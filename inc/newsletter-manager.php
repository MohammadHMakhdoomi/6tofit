<?php
if (!defined('ABSPATH')) {
    exit;
}

function newsletter_manager_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    $charset_collate = $wpdb->get_charset_collate();

    // چک می‌کنیم جدول وجود داره یا نه
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            email varchar(255) NOT NULL,
            subscribed_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            UNIQUE KEY email (email)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

// جدول رو موقع لود شدن ادمین یا فرانت‌اند چک و در صورت نیاز بساز
add_action('admin_init', 'newsletter_manager_create_table');
add_action('init', 'newsletter_manager_create_table');

function newsletter_manager_admin_menu() {
    add_menu_page(
        'مدیریت خبرنامه',
        'خبرنامه',
        'manage_options',
        'newsletter-subscribers',
        'newsletter_manager_list_page',
        'dashicons-email'
    );

    add_submenu_page(
        'newsletter-subscribers',
        'ارسال ایمیل گروهی',
        'ارسال گروهی',
        'manage_options',
        'newsletter-bulk-email',
        'newsletter_manager_bulk_email_page'
    );

    add_submenu_page(
        'newsletter-subscribers',
        'ارسال ایمیل تکی',
        'ارسال تکی',
        'manage_options',
        'newsletter-single-email',
        'newsletter_manager_single_email_page'
    );
}
add_action('admin_menu', 'newsletter_manager_admin_menu');

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Newsletter_Subscribers_Table extends WP_List_Table {
    function __construct() {
        parent::__construct(array(
            'singular' => 'subscriber',
            'plural'   => 'subscribers',
            'ajax'     => false
        ));
    }

    function get_columns() {
        return array(
            'cb'            => '<input type="checkbox" />',
            'id'            => 'شناسه',
            'email'         => 'ایمیل',
            'subscribed_at' => 'تاریخ عضویت',
            'actions'       => 'عملیات'
        );
    }

    function prepare_items() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'newsletter_subscribers';

        $per_page = 20;
        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $data = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC", ARRAY_A);

        $total_items = count($data);
        $this->items = $data;

        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil($total_items / $per_page)
        ));
    }

    function column_default($item, $column_name) {
        return $item[$column_name];
    }

    function column_cb($item) {
        return sprintf('<input type="checkbox" name="subscriber[]" value="%s" />', $item['id']);
    }

    function column_actions($item) {
        $delete_url = wp_nonce_url(
            admin_url('admin-post.php?action=delete_subscriber&id=' . $item['id']),
            'delete_subscriber_' . $item['id']
        );
        $send_url = admin_url('admin.php?page=newsletter-single-email&email=' . urlencode($item['email']));
        return sprintf(
            '<a href="%s" style="color:#dc2626;">حذف</a> | <a href="%s">ارسال ایمیل</a>',
            $delete_url,
            $send_url
        );
    }

    function get_bulk_actions() {
        return array(
            'delete' => 'حذف انتخاب‌شده‌ها',
            'export' => 'خروجی CSV'
        );
    }
}

function newsletter_manager_list_page() {
    $subscribers_table = new Newsletter_Subscribers_Table();
    $subscribers_table->prepare_items();

    if (isset($_POST['action']) && $_POST['action'] == 'export') {
        newsletter_manager_export_csv();
    }

    echo '<div class="wrap"><h1>مشترکین خبرنامه</h1>';
    echo '<form method="post">';
    $subscribers_table->display();
    echo '</form></div>';
}

function newsletter_manager_delete_subscriber() {
    if (!current_user_can('manage_options')) return;

    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        check_admin_referer('delete_subscriber_' . $id);
        $wpdb->delete($table_name, array('id' => $id));
    } elseif (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['subscriber'])) {
        foreach ($_POST['subscriber'] as $id) {
            $wpdb->delete($table_name, array('id' => intval($id)));
        }
    }

    wp_redirect(admin_url('admin.php?page=newsletter-subscribers'));
    exit;
}
add_action('admin_post_delete_subscriber', 'newsletter_manager_delete_subscriber');

function newsletter_manager_export_csv() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    $results = $wpdb->get_results("SELECT email, subscribed_at FROM $table_name", ARRAY_A);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=subscribers.csv');

    $output = fopen('php://output', 'w');
    // BOM برای نمایش صحیح فارسی در اکسل
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    fputcsv($output, array('ایمیل', 'تاریخ عضویت'));

    foreach ($results as $row) {
        fputcsv($output, $row);
    }

    exit;
}

/**
 * قالب حرفه‌ای ایمیل 6toFit
 */
function six2fit_get_email_template($content, $title = '') {
    $logo_url = 'http://6tofit.com/wp-content/uploads/2025/10/6toFit_logotype_Black_2-scaled.png';
    $site_url = home_url();
    $year     = date('Y');

    $html = '
    <!DOCTYPE html>
    <html lang="fa" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . esc_html($title) . '</title>
    </head>
    <body style="margin:0; padding:0; background-color:#f4f4f7; font-family:Tahoma, Arial, sans-serif; direction:rtl;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f7; padding:40px 0;">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.08);">
                        
                        <!-- Header با لوگو -->
                        <tr>
                            <td style="background: linear-gradient(135deg, #6B2DFF 0%, #8B5CF6 100%); padding:32px 40px; text-align:center;">
                                <img src="' . esc_url($logo_url) . '" alt="6toFit" width="180" style="display:block; margin:0 auto; max-width:180px; height:auto;">
                            </td>
                        </tr>

                        <!-- محتوای اصلی -->
                        <tr>
                            <td style="padding:40px 40px 30px; color:#1f2937; font-size:15px; line-height:1.8;">
                                ' . $content . '
                            </td>
                        </tr>

                        <!-- فوتر -->
                        <tr>
                            <td style="background-color:#f9fafb; padding:28px 40px; text-align:center; border-top:1px solid #e5e7eb;">
                                <p style="margin:0 0 12px; font-size:13px; color:#6b7280;">
                                    با احترام<br>
                                    <strong style="color:#6B2DFF;">6tofit</strong>
                                </p>
                                <p style="margin:0 0 16px; font-size:12px; color:#9ca3af;">
                                    <a href="' . esc_url($site_url) . '" style="color:#6B2DFF; text-decoration:none;">www.6tofit.com</a>
                                </p>
                                <p style="margin:0; font-size:11px; color:#9ca3af;">
                                    © ' . $year . ' 6toFit. تمامی حقوق محفوظ است.
                                </p>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>';

    return $html;
}

function newsletter_manager_bulk_email_page() {
    if (isset($_POST['send_bulk_email'])) {
        newsletter_manager_send_bulk_email();
    }

    echo '<div class="wrap"><h1>ارسال ایمیل گروهی</h1>';
    echo '<form method="post">';
    wp_nonce_field('bulk_email_nonce');
    echo '<p><label for="subject"><strong>موضوع ایمیل:</strong></label><br>';
    echo '<input type="text" name="subject" id="subject" class="regular-text" required style="width:100%; max-width:600px;"></p>';
    echo '<p><label for="message"><strong>متن پیام:</strong></label></p>';
    wp_editor('', 'message', array(
        'textarea_name' => 'message',
        'media_buttons' => true,
        'teeny'         => false,
        'textarea_rows' => 12
    ));
    echo '<p><input type="submit" name="send_bulk_email" class="button button-primary" value="ارسال ایمیل گروهی"></p>';
    echo '</form></div>';
}

function newsletter_manager_send_bulk_email() {
    check_admin_referer('bulk_email_nonce');

    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    $subject = sanitize_text_field($_POST['subject']);
    $message = wp_kses_post($_POST['message']);

    $email_content = six2fit_get_email_template($message, $subject);

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: 6toFit <noreply@6tofit.com>'
    );

    $subscribers = $wpdb->get_col("SELECT email FROM $table_name");

    $sent = 0;
    foreach ($subscribers as $email) {
        if (wp_mail($email, $subject, $email_content, $headers)) {
            $sent++;
        }
    }

    echo '<div class="notice notice-success is-dismissible"><p>تعداد ' . $sent . ' ایمیل با موفقیت ارسال شد.</p></div>';
}

function newsletter_manager_single_email_page() {
    $email  = isset($_GET['email']) ? sanitize_email($_GET['email']) : '';
    $search = isset($_POST['search_email']) ? sanitize_email($_POST['search_email']) : '';

    if (isset($_POST['send_single_email'])) {
        newsletter_manager_send_single_email();
    }

    echo '<div class="wrap"><h1>ارسال ایمیل تکی</h1>';

    echo '<form method="post" style="margin-bottom:25px;">';
    echo '<label for="search_email"><strong>جستجوی ایمیل:</strong></label> ';
    echo '<input type="email" name="search_email" id="search_email" class="regular-text"> ';
    echo '<input type="submit" class="button" value="جستجو">';
    echo '</form>';

    if ($search) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'newsletter_subscribers';
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT email FROM $table_name WHERE email LIKE %s",
            '%' . $wpdb->esc_like($search) . '%'
        ));

        if ($results) {
            echo '<ul style="list-style:disc; margin-right:20px;">';
            foreach ($results as $result) {
                $send_url = admin_url('admin.php?page=newsletter-single-email&email=' . urlencode($result->email));
                echo '<li>' . esc_html($result->email) . ' — <a href="' . esc_url($send_url) . '">ارسال ایمیل</a></li>';
            }
            echo '</ul>';
        } else {
            echo '<p>نتیجه‌ای یافت نشد.</p>';
        }
    }

    if ($email) {
        echo '<form method="post">';
        wp_nonce_field('single_email_nonce');
        echo '<input type="hidden" name="to_email" value="' . esc_attr($email) . '">';
        echo '<p><strong>گیرنده:</strong> ' . esc_html($email) . '</p>';
        echo '<p><label for="subject"><strong>موضوع:</strong></label><br>';
        echo '<input type="text" name="subject" id="subject" class="regular-text" required style="width:100%; max-width:600px;"></p>';
        echo '<p><label for="message"><strong>متن پیام:</strong></label></p>';
        wp_editor('', 'message', array(
            'textarea_name' => 'message',
            'media_buttons' => true,
            'teeny'         => false,
            'textarea_rows' => 12
        ));
        echo '<p><input type="submit" name="send_single_email" class="button button-primary" value="ارسال ایمیل"></p>';
        echo '</form>';
    }

    echo '</div>';
}

function newsletter_manager_send_single_email() {
    check_admin_referer('single_email_nonce');

    $to      = sanitize_email($_POST['to_email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = wp_kses_post($_POST['message']);

    $email_content = six2fit_get_email_template($message, $subject);

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: 6toFit <noreply@6tofit.com>'
    );

    if (wp_mail($to, $subject, $email_content, $headers)) {
        echo '<div class="notice notice-success is-dismissible"><p>ایمیل با موفقیت ارسال شد.</p></div>';
    } else {
        echo '<div class="notice notice-error is-dismissible"><p>خطا در ارسال ایمیل.</p></div>';
    }
}

function newsletter_manager_send_on_post_publish($post_id, $post) {
    if ($post->post_status != 'publish' || $post->post_type != 'post') {
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    $subject = 'مقاله جدید: ' . get_the_title($post_id);
    $excerpt = wp_trim_words(strip_tags($post->post_content), 55);
    $link    = get_permalink($post_id);
    $thumb   = get_the_post_thumbnail_url($post_id, 'medium');

    $content = '';
    if ($thumb) {
        $content .= '<p style="text-align:center; margin-bottom:24px;"><img src="' . esc_url($thumb) . '" alt="" style="max-width:100%; border-radius:12px;"></p>';
    }
    $content .= '<h2 style="color:#1f2937; font-size:22px; margin:0 0 16px;">' . esc_html(get_the_title($post_id)) . '</h2>';
    $content .= '<p style="color:#4b5563; margin:0 0 24px;">' . esc_html($excerpt) . '</p>';
    $content .= '<p style="text-align:center; margin:30px 0 10px;">
                    <a href="' . esc_url($link) . '" style="display:inline-block; background-color:#F97316; color:#ffffff; text-decoration:none; padding:14px 32px; border-radius:50px; font-weight:bold; font-size:15px;">
                        مطالعه کامل مقاله
                    </a>
                 </p>';

    $email_content = six2fit_get_email_template($content, $subject);

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: 6toFit <noreply@6tofit.com>'
    );

    $subscribers = $wpdb->get_col("SELECT email FROM $table_name");

    foreach ($subscribers as $email) {
        wp_mail($email, $subject, $email_content, $headers);
    }
}
add_action('publish_post', 'newsletter_manager_send_on_post_publish', 10, 2);


/**
 * AJAX: عضویت در خبرنامه
 */
function newsletter_subscribe_ajax() {
    check_ajax_referer('newsletter_subscribe_nonce', 'nonce');

    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

    if (empty($email) || !is_email($email)) {
        wp_send_json_error(array('message' => 'ایمیل معتبر نیست'));
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    // چک وجود ایمیل
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM $table_name WHERE email = %s",
        $email
    ));

    if ($exists) {
        wp_send_json_error(array('message' => 'این ایمیل قبلاً ثبت شده است'));
    }

    $inserted = $wpdb->insert(
        $table_name,
        array(
            'email'         => $email,
            'subscribed_at' => current_time('mysql')
        ),
        array('%s', '%s')
    );

    if ($inserted) {
        wp_send_json_success(array('message' => 'با موفقیت عضو شدید!'));
    } else {
        wp_send_json_error(array('message' => 'خطا در ثبت ایمیل'));
    }
}
add_action('wp_ajax_newsletter_subscribe', 'newsletter_subscribe_ajax');
add_action('wp_ajax_nopriv_newsletter_subscribe', 'newsletter_subscribe_ajax');