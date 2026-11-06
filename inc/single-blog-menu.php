<?php

/**
 * ============================================
 * Article Navigation / Table of Contents
 * Backend
 * ============================================
 */


/**
 * --------------------------------------------
 * 1. Add Meta Box
 * --------------------------------------------
 */
function mytheme_article_navigation_meta_box() {

    add_meta_box(
        'mytheme_article_navigation',
        'منوی راهبری مقاله',
        'mytheme_article_navigation_meta_box_callback',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'mytheme_article_navigation_meta_box');


/**
 * --------------------------------------------
 * 2. Meta Box HTML
 * --------------------------------------------
 */
function mytheme_article_navigation_meta_box_callback($post) {

    wp_nonce_field(
        'mytheme_article_navigation_save',
        'mytheme_article_navigation_nonce'
    );

    $navigation_items = get_post_meta(
        $post->ID,
        '_mytheme_article_navigation',
        true
    );

    if (!is_array($navigation_items)) {
        $navigation_items = array();
    }

    ?>

    <div class="mytheme-article-navigation-box">

        <div class="mytheme-navigation-header">

            <div>
                <strong>منوی راهبری مقاله</strong>

                <p class="description">
                    Headingهای مقاله به‌صورت خودکار شناسایی می‌شوند.
                    مشخص کنید کدام عنوان در منوی راهبری نمایش داده شود.
                </p>
            </div>

            <button
                type="button"
                class="button"
                id="mytheme-scan-headings"
            >
                بروزرسانی عناوین
            </button>

        </div>
<?php

$article_intro = get_post_meta(
    $post->ID,
    '_mytheme_article_navigation_intro',
    true
);

?>

<div class="mytheme-navigation-introduction">

    <label for="mytheme-article-navigation-intro">
        <strong>توضیحات</strong>
    </label>

    <p class="description">
        متن مقدمه مقاله را وارد کنید. این بخش همیشه اولین آیتم منوی راهبری خواهد بود.
    </p>

    <textarea
        id="mytheme-article-navigation-intro"
        name="mytheme_article_navigation_intro"
        rows="5"
        class="widefat"
        placeholder="مقدمه یا توضیحات ابتدای مقاله را وارد کنید..."
    ><?php echo esc_textarea($article_intro); ?></textarea>

</div>
        <div
            id="mytheme-navigation-items"
            class="mytheme-navigation-items"
            data-post-id="<?php echo esc_attr($post->ID); ?>"
        >

            <?php

            if (!empty($navigation_items)) {

                foreach ($navigation_items as $index => $item) {

                    mytheme_render_navigation_item(
                        $index,
                        $item
                    );

                }

            } else {

                ?>

                <div class="mytheme-navigation-empty">
                    <p>
                        هنوز عنوانی شناسایی نشده است.
                    </p>

                    <p>
                        ابتدا مقاله را ذخیره کنید و سپس روی
                        «بروزرسانی عناوین» کلیک کنید.
                    </p>
                </div>

                <?php

            }

            ?>

        </div>

        <div class="mytheme-navigation-help">

            <strong>نحوه عملکرد:</strong>

            <ul>
                <li>
                    سیستم Headingهای H2 و H3 مقاله را پیدا می‌کند.
                </li>

                <li>
                    با فعال کردن هر عنوان، آن بخش وارد منوی راهبری می‌شود.
                </li>

                <li>
                    عنوان منو می‌تواند با عنوان اصلی Heading متفاوت باشد.
                </li>

                <li>
                    ترتیب آیتم‌ها را می‌توان با Drag & Drop تغییر داد.
                </li>
            </ul>

        </div>

    </div>

    <?php
}


/**
 * --------------------------------------------
 * 3. Render Navigation Item
 * --------------------------------------------
 */
function mytheme_render_navigation_item($index, $item) {

    $heading_id    = isset($item['heading_id'])
        ? $item['heading_id']
        : '';

    $heading_text  = isset($item['heading_text'])
        ? $item['heading_text']
        : '';

    $menu_title    = isset($item['menu_title'])
        ? $item['menu_title']
        : $heading_text;

    $level         = isset($item['level'])
        ? absint($item['level'])
        : 2;

    $enabled       = !empty($item['enabled']);

    ?>

    <div
        class="mytheme-navigation-item"
        data-heading-id="<?php echo esc_attr($heading_id); ?>"
    >

        <div class="mytheme-navigation-item-drag">
            ☰
        </div>

        <div class="mytheme-navigation-item-content">

            <div class="mytheme-navigation-item-title">

                <label>

                    <input
                        type="checkbox"
                        name="mytheme_navigation[<?php echo esc_attr($index); ?>][enabled]"
                        value="1"
                        <?php checked($enabled, true); ?>
                    >

                    <span class="mytheme-heading-level level-<?php echo esc_attr($level); ?>">
                        H<?php echo esc_html($level); ?>
                    </span>

                    <strong>
                        <?php echo esc_html($heading_text); ?>
                    </strong>

                </label>

            </div>

            <div class="mytheme-navigation-menu-title">

                <label>
                    عنوان نمایش در منو:
                </label>

                <input
                    type="text"
                    class="widefat"
                    name="mytheme_navigation[<?php echo esc_attr($index); ?>][menu_title]"
                    value="<?php echo esc_attr($menu_title); ?>"
                    placeholder="<?php echo esc_attr($heading_text); ?>"
                >

            </div>

            <input
                type="hidden"
                name="mytheme_navigation[<?php echo esc_attr($index); ?>][heading_id]"
                value="<?php echo esc_attr($heading_id); ?>"
            >

            <input
                type="hidden"
                name="mytheme_navigation[<?php echo esc_attr($index); ?>][heading_text]"
                value="<?php echo esc_attr($heading_text); ?>"
            >

            <input
                type="hidden"
                name="mytheme_navigation[<?php echo esc_attr($index); ?>][level]"
                value="<?php echo esc_attr($level); ?>"
            >

        </div>

    </div>

    <?php
}


/**
 * --------------------------------------------
 * 4. Save Meta Box
 * --------------------------------------------
 */
function mytheme_save_article_navigation($post_id) {

    /*
     * Nonce
     */
    if (
        !isset($_POST['mytheme_article_navigation_nonce']) ||
        !wp_verify_nonce(
            $_POST['mytheme_article_navigation_nonce'],
            'mytheme_article_navigation_save'
        )
    ) {
        return;
    }


    /*
     * Autosave
     */
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }


    /*
     * Revision
     */
    if (wp_is_post_revision($post_id)) {
        return;
    }


    /*
     * Permission
     */
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
/**
 * Save article introduction
 */
$article_intro = isset($_POST['mytheme_article_navigation_intro'])
    ? sanitize_textarea_field($_POST['mytheme_article_navigation_intro'])
    : '';

if (!empty($article_intro)) {

    update_post_meta(
        $post_id,
        '_mytheme_article_navigation_intro',
        $article_intro
    );

} else {

    delete_post_meta(
        $post_id,
        '_mytheme_article_navigation_intro'
    );

}

    /*
     * Data
     */
    if (
        !isset($_POST['mytheme_navigation']) ||
        !is_array($_POST['mytheme_navigation'])
    ) {

        delete_post_meta(
            $post_id,
            '_mytheme_article_navigation'
        );

        return;
    }


    $navigation = array();

    foreach ($_POST['mytheme_navigation'] as $item) {

        if (!is_array($item)) {
            continue;
        }

        $heading_id = isset($item['heading_id'])
            ? sanitize_key($item['heading_id'])
            : '';

        $heading_text = isset($item['heading_text'])
            ? sanitize_text_field($item['heading_text'])
            : '';

        $menu_title = isset($item['menu_title'])
            ? sanitize_text_field($item['menu_title'])
            : '';

        $level = isset($item['level'])
            ? absint($item['level'])
            : 2;

        $enabled = !empty($item['enabled']) ? 1 : 0;


        if (empty($heading_id)) {
            continue;
        }


        /*
         * اگر عنوان منو خالی باشد،
         * از عنوان اصلی Heading استفاده می‌کنیم.
         */
        if (empty($menu_title)) {
            $menu_title = $heading_text;
        }


        $navigation[] = array(

            'heading_id'   => $heading_id,

            'heading_text' => $heading_text,

            'menu_title'   => $menu_title,

            'level'        => $level,

            'enabled'      => $enabled,

        );

    }


    update_post_meta(
        $post_id,
        '_mytheme_article_navigation',
        $navigation
    );

}
add_action(
    'save_post_post',
    'mytheme_save_article_navigation'
);


/**
 * --------------------------------------------
 * 5. AJAX: Scan Article Headings
 * --------------------------------------------
 */
function mytheme_scan_article_headings() {

    /*
     * Check nonce
     */
    check_ajax_referer(
        'mytheme_scan_headings',
        'nonce'
    );


    $post_id = isset($_POST['post_id'])
        ? absint($_POST['post_id'])
        : 0;


    if (!$post_id) {

        wp_send_json_error(
            array(
                'message' => 'شناسه مقاله معتبر نیست.'
            )
        );

    }


    if (!current_user_can('edit_post', $post_id)) {

        wp_send_json_error(
            array(
                'message' => 'شما اجازه ویرایش این مقاله را ندارید.'
            )
        );

    }


    $post = get_post($post_id);


    if (!$post) {

        wp_send_json_error(
            array(
                'message' => 'مقاله پیدا نشد.'
            )
        );

    }


    /*
     * Parse content
     */
    $content = $post->post_content;


    if (empty($content)) {

        wp_send_json_success(
            array(
                'items' => array()
            )
        );

    }


    /*
     * Find H2 / H3
     */
    preg_match_all(
        '/<h([23])([^>]*)>(.*?)<\/h\1>/is',
        $content,
        $matches,
        PREG_SET_ORDER
    );


    $items = array();




    if (!empty($matches)) {

        foreach ($matches as $match) {

            $level = absint($match[1]);

            $attributes = $match[2];

            $inner_html = $match[3];


            /*
             * Remove HTML tags
             */
            $heading_text = wp_strip_all_tags(
                $inner_html
            );


            $heading_text = trim(
                preg_replace(
                    '/\s+/u',
                    ' ',
                    $heading_text
                )
            );


            if (empty($heading_text)) {
                continue;
            }


            /*
             * Check existing ID
             */
            $existing_id = '';


            if (
                preg_match(
                    '/\bid\s*=\s*["\']([^"\']+)["\']/i',
                    $attributes,
                    $id_match
                )
            ) {

                $existing_id = sanitize_key(
                    $id_match[1]
                );

            }


            /*
             * Generate ID
             */
            $heading_id = 'section-' . (count($items) + 1);





            /*
             * Default menu title
             */
            $menu_title = $heading_text;


            $items[] = array(

                'heading_id'   => $heading_id,

                'heading_text' => $heading_text,

                'menu_title'   => $menu_title,

                'level'        => $level,

                'enabled'      => 0,

            );

        }

    }


    wp_send_json_success(
        array(
            'items' => $items
        )
    );

}
add_action(
    'wp_ajax_mytheme_scan_article_headings',
    'mytheme_scan_article_headings'
);


/**
 * --------------------------------------------
 * 6. Admin Scripts
 * --------------------------------------------
 */
function mytheme_article_navigation_admin_assets($hook) {

    if (
        $hook !== 'post.php' &&
        $hook !== 'post-new.php'
    ) {
        return;
    }


    global $post;


    if (
        !$post ||
        $post->post_type !== 'post'
    ) {
        return;
    }


    wp_enqueue_script(
        'jquery-ui-sortable'
    );


    wp_enqueue_style(
        'mytheme-article-navigation-admin',
        get_template_directory_uri() .
        '/assets/css/article-navigation-admin.css',
        array(),
        '1.0.0'
    );


    wp_enqueue_script(
        'mytheme-article-navigation-admin',
        get_template_directory_uri() .
        '/assets/js/article-navigation-admin.js',
        array(
            'jquery',
            'jquery-ui-sortable'
        ),
        '1.0.0',
        true
    );


    wp_localize_script(
        'mytheme-article-navigation-admin',
        'myThemeArticleNavigation',
        array(

            'ajaxUrl' => admin_url(
                'admin-ajax.php'
            ),

            'nonce' => wp_create_nonce(
                'mytheme_scan_headings'
            ),

            'postId' => $post->ID,

        )
    );

}
add_action(
    'admin_enqueue_scripts',
    'mytheme_article_navigation_admin_assets'
);


/**
 * ============================================
 * Add Article Navigation IDs to Selected Headings
 * ============================================
 */
function mytheme_add_navigation_ids_to_content($content) {

    if (!is_singular('post') || !is_main_query()) {
        return $content;
    }

    $post_id = get_the_ID();

    if (!$post_id) {
        return $content;
    }

    /*
     * Get navigation settings
     */
    $navigation_items = get_post_meta(
        $post_id,
        '_mytheme_article_navigation',
        true
    );

    if (
        !is_array($navigation_items) ||
        empty($navigation_items)
    ) {
        return $content;
    }

    /*
     * Create map of selected headings
     *
     * heading_text => heading_id
     */
    $selected_headings = array();

    foreach ($navigation_items as $item) {

        if (empty($item['enabled'])) {
            continue;
        }

        if (
            empty($item['heading_id']) ||
            empty($item['heading_text'])
        ) {
            continue;
        }

        $selected_headings[] = array(
            'id'   => sanitize_key($item['heading_id']),
            'text' => trim($item['heading_text']),
            'level' => !empty($item['level'])
                ? absint($item['level'])
                : 2,
        );
    }

    if (empty($selected_headings)) {
        return $content;
    }

    /*
     * Find H2 / H3
     */
    preg_match_all(
        '/<h([23])([^>]*)>(.*?)<\/h\1>/is',
        $content,
        $matches,
        PREG_SET_ORDER
    );

    if (empty($matches)) {
        return $content;
    }

    /*
     * Track used navigation items
     */
    $used = array();

    foreach ($matches as $match) {

        $level = absint($match[1]);

        $attributes = $match[2];

        $inner_html = $match[3];

        /*
         * Get plain heading text
         */
        $heading_text = wp_strip_all_tags(
            $inner_html
        );

        $heading_text = trim(
            preg_replace(
                '/\s+/u',
                ' ',
                $heading_text
            )
        );

        if (empty($heading_text)) {
            continue;
        }

        /*
         * Find matching selected heading
         */
        $matched_index = false;

        foreach ($selected_headings as $index => $selected) {

            if (isset($used[$index])) {
                continue;
            }

            /*
             * Level must match
             */
            if ($selected['level'] !== $level) {
                continue;
            }

            /*
             * Heading text must match
             */
            if ($selected['text'] === $heading_text) {

                $matched_index = $index;

                break;
            }
        }

        /*
         * No match
         */
        if ($matched_index === false) {
            continue;
        }

        $heading_id = $selected_headings[$matched_index]['id'];

        $used[$matched_index] = true;

        /*
         * If heading already has an ID,
         * replace it.
         */
        if (
            preg_match(
                '/\bid\s*=\s*([\'"])[^\'"]*\1/i',
                $attributes
            )
        ) {

            $attributes = preg_replace(
                '/\bid\s*=\s*([\'"])[^\'"]*\1/i',
                'id="' . esc_attr($heading_id) . '"',
                $attributes,
                1
            );

        } else {

            $attributes .= ' id="' .
                esc_attr($heading_id) .
                '"';
        }

        /*
         * Replace original heading
         */
        $new_heading =
            '<h' . $level .
            $attributes .
            '>' .
            $inner_html .
            '</h' . $level . '>';

        $content = str_replace(
            $match[0],
            $new_heading,
            $content
        );
    }

    return $content;
}

add_filter(
    'the_content',
    'mytheme_add_navigation_ids_to_content',
    20
);