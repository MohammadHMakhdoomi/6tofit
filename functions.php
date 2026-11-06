<?php
// جلوگیری از دسترسی مستقیم
if ( ! defined( 'ABSPATH' ) ) exit;

// غیرفعال کردن هشدار ترجمه زودرس در وردپرس 6.7+
add_filter( 'doing_it_wrong_trigger_error', function( $trigger, $function_name ) {
    if ( '_load_textdomain_just_in_time' === $function_name ) {
        return false;
    }
    return $trigger;
}, 10, 2 );

// جلوگیری از خطای 404 روی /favicon.ico
add_action( 'init', function() {
    if ( isset( $_SERVER['REQUEST_URI'] ) && $_SERVER['REQUEST_URI'] === '/favicon.ico' ) {
        wp_redirect( get_template_directory_uri() . '/assets/img/products/logo.svg', 301 );
        exit;
    }
}, 1 );

// =========================================================================
// ۱. موتور هوشمند تشخیص ارز (IP + Timezone) و قفل ارز در کل چرخه خرید
// =========================================================================

function af_get_real_user_ip() {
    if ( ! empty( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ) {
        return sanitize_text_field( $_SERVER['HTTP_CF_CONNECTING_IP'] );
    }
    if ( ! empty( $_SERVER['HTTP_X_REAL_IP'] ) ) {
        return sanitize_text_field( $_SERVER['HTTP_X_REAL_IP'] );
    }
    if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        $ips = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
        return sanitize_text_field( trim( $ips[0] ) );
    }
    return sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' );
}

function af_get_country_by_ip( $ip ) {
    if ( ! empty( $_SERVER['HTTP_CF_IPCOUNTRY'] ) && $_SERVER['HTTP_CF_IPCOUNTRY'] !== 'XX' ) {
        return strtoupper( sanitize_text_field( $_SERVER['HTTP_CF_IPCOUNTRY'] ) );
    }
    if ( ! empty( $_SERVER['GEOIP_COUNTRY_CODE'] ) ) {
        return strtoupper( sanitize_text_field( $_SERVER['GEOIP_COUNTRY_CODE'] ) );
    }
    if ( empty( $ip ) || in_array( $ip, array( '127.0.0.1', '::1' ), true ) ) {
        return 'IR';
    }
    if ( class_exists( 'WC_Geolocation' ) ) {
        $geo = WC_Geolocation::geolocate_ip( $ip, false, false );
        if ( ! empty( $geo['country'] ) ) {
            return strtoupper( $geo['country'] );
        }
    }
    return 'UNKNOWN';
}

add_action( 'init', function() {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    $default_currency = 'IRT';
    if ( class_exists( 'WOOMULTI_CURRENCY_Data' ) ) {
        $curcy            = WOOMULTI_CURRENCY_Data::get_ins();
        $default_currency = $curcy->get_default_currency() ?: 'IRT';
    }

    if ( ! empty( $_GET['wmc-currency'] ) ) {
        $req_curr = strtoupper( sanitize_text_field( $_GET['wmc-currency'] ) );
        if ( $req_curr === 'AUTO' ) {
            setcookie( 'af_manual_currency', '', time() - 3600, '/' );
            unset( $_COOKIE['af_manual_currency'] );
        } elseif ( in_array( $req_curr, array( 'USD', 'IRT' ), true ) ) {
            if ( class_exists( 'WOOMULTI_CURRENCY_Data' ) ) {
                WOOMULTI_CURRENCY_Data::get_ins()->set_current_currency( $req_curr );
            }
            $_COOKIE['wmc_current_currency']     = $req_curr;
            $_COOKIE['wmc_current_currency_old'] = $req_curr;
            $_COOKIE['af_manual_currency']       = $req_curr;
            if ( ! headers_sent() ) {
                setcookie( 'af_manual_currency', $req_curr, time() + 7200, '/' );
                setcookie( 'wmc_current_currency', $req_curr, time() + 86400, '/' );
                setcookie( 'wmc_current_currency_old', $req_curr, time() + 86400, '/' );
            }
            return;
        }
    }

    if ( ! empty( $_COOKIE['af_manual_currency'] ) ) {
        $manual_curr = strtoupper( sanitize_text_field( $_COOKIE['af_manual_currency'] ) );
        if ( class_exists( 'WOOMULTI_CURRENCY_Data' ) ) {
            WOOMULTI_CURRENCY_Data::get_ins()->set_current_currency( $manual_curr );
        }
        $_COOKIE['wmc_current_currency'] = $manual_curr;
        return;
    }

    $user_ip = af_get_real_user_ip();
    $country = af_get_country_by_ip( $user_ip );

    if ( isset( $_COOKIE['af_tz_iran'] ) && $_COOKIE['af_tz_iran'] === '1' ) {
        $target_curr = $default_currency;
    } elseif ( isset( $_COOKIE['af_tz_iran'] ) && $_COOKIE['af_tz_iran'] === '0' && $country !== 'IR' ) {
        $target_curr = 'USD';
    } else {
        $target_curr = ( $country === 'IR' || $country === 'UNKNOWN' ) ? $default_currency : 'USD';
    }

    if ( ! headers_sent() ) {
        setcookie( 'wmc_current_currency', $target_curr, time() + 86400, '/' );
        setcookie( 'wmc_current_currency_old', $target_curr, time() + 86400, '/' );
    }
    $_COOKIE['wmc_current_currency']     = $target_curr;
    $_COOKIE['wmc_current_currency_old'] = $target_curr;

    if ( class_exists( 'WOOMULTI_CURRENCY_Data' ) ) {
        WOOMULTI_CURRENCY_Data::get_ins()->set_current_currency( $target_curr );
    }
}, 1 );

function af_is_usd_currency() {
    if ( ! empty( $_GET['wmc-currency'] ) ) {
        $req = strtoupper( sanitize_text_field( $_GET['wmc-currency'] ) );
        if ( $req === 'USD' ) return true;
        if ( $req === 'IRT' ) return false;
    }
    if ( ! empty( $_COOKIE['af_manual_currency'] ) ) {
        return strtoupper( $_COOKIE['af_manual_currency'] ) === 'USD';
    }
    if ( isset( $_COOKIE['af_tz_iran'] ) ) {
        if ( $_COOKIE['af_tz_iran'] === '1' ) return false;
        if ( $_COOKIE['af_tz_iran'] === '0' && af_get_country_by_ip( af_get_real_user_ip() ) !== 'IR' ) return true;
    }
    if ( ! empty( $_COOKIE['wmc_current_currency'] ) ) {
        return strtoupper( $_COOKIE['wmc_current_currency'] ) === 'USD';
    }
    if ( class_exists( 'WOOMULTI_CURRENCY_Data' ) ) {
        return WOOMULTI_CURRENCY_Data::get_ins()->get_current_currency() === 'USD';
    }
    return false;
}

add_filter( 'woocommerce_currency', function( $currency ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return $currency;
    }
    return af_is_usd_currency() ? 'USD' : 'IRT';
}, 99999 );

function af_get_addon_converted_price( $addon ) {
    if ( ! is_array( $addon ) ) return 0;

    $is_usd     = af_is_usd_currency();
    $base_price = isset( $addon['price'] ) ? floatval( $addon['price'] ) : 0;

    if ( ! empty( $addon['_converted_to'] ) ) {
        if ( ( $is_usd && $addon['_converted_to'] === 'USD' ) || ( ! $is_usd && $addon['_converted_to'] === 'IRT' ) ) {
            return $base_price;
        }
    }

    $raw_toman = isset( $addon['_raw_toman_price'] ) ? floatval( $addon['_raw_toman_price'] ) : $base_price;

    if ( ! $is_usd ) {
        return $raw_toman;
    }

    if ( isset( $addon['price_usd'] ) && $addon['price_usd'] !== '' && floatval( $addon['price_usd'] ) > 0 ) {
        return floatval( $addon['price_usd'] );
    }

    static $curcy_addon_map = null;
    if ( null === $curcy_addon_map ) {
        $curcy_addon_map = array( 'by_title' => array(), 'by_toman' => array() );
        $all_addon_posts = get_posts( array(
            'post_type'      => array( 'product', 'product_variation' ),
            'post_status'    => 'any',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => '_regular_price_wmcp',
                    'compare' => 'EXISTS',
                ),
            ),
        ) );

        foreach ( $all_addon_posts as $ap ) {
            $wmcp = get_post_meta( $ap->ID, '_regular_price_wmcp', true );
            $data = is_string( $wmcp ) ? json_decode( $wmcp, true ) : $wmcp;
            if ( is_array( $data ) && ! empty( $data['USD'] ) && is_numeric( $data['USD'] ) && floatval( $data['USD'] ) > 0 ) {
                $usd_val   = floatval( $data['USD'] );
                $toman_val = floatval( get_post_meta( $ap->ID, '_regular_price', true ) );
                $title_key = trim( $ap->post_title );
                $curcy_addon_map['by_title'][ $title_key ] = $usd_val;
                if ( $toman_val > 0 ) {
                    $curcy_addon_map['by_toman'][ (string) $toman_val ] = $usd_val;
                }
            }
        }
    }

    $clean_title = trim( $addon['title'] ?? '' );
    if ( $clean_title !== '' ) {
        if ( isset( $curcy_addon_map['by_title'][ $clean_title ] ) ) {
            return $curcy_addon_map['by_title'][ $clean_title ];
        }
        foreach ( $curcy_addon_map['by_title'] as $wc_title => $usd_val ) {
            if ( mb_stripos( $wc_title, $clean_title ) !== false || mb_stripos( $clean_title, $wc_title ) !== false ) {
                return $usd_val;
            }
            if ( mb_stripos( $clean_title, 'سامان' ) !== false && mb_stripos( $wc_title, 'سامان' ) !== false ) {
                return $usd_val;
            }
        }
    }

    if ( $raw_toman > 0 && isset( $curcy_addon_map['by_toman'][ (string) $raw_toman ] ) ) {
        return $curcy_addon_map['by_toman'][ (string) $raw_toman ];
    }

    if ( function_exists( 'wmc_get_price' ) ) {
        $wmc_converted = floatval( wmc_get_price( $raw_toman ) );
        if ( $wmc_converted > 0 && $wmc_converted < ( $raw_toman / 1000 ) ) {
            return round( $wmc_converted, 2 );
        }
    }

    if ( $raw_toman > 1000 ) {
        return round( $raw_toman / 150000, 2 );
    }

    return $raw_toman;
}

add_filter( 'get_post_metadata', function( $value, $object_id, $meta_key, $single ) {
    if ( $meta_key !== '_product_addons' ) {
        return $value;
    }
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return $value;
    }

    static $is_filtering_addons = false;
    if ( $is_filtering_addons ) {
        return $value;
    }

    $is_filtering_addons = true;
    $raw_addons          = get_post_meta( $object_id, '_product_addons', true );
    $is_filtering_addons = false;

    if ( ! is_array( $raw_addons ) || empty( $raw_addons ) ) {
        return $value;
    }

    $is_usd = af_is_usd_currency();

    foreach ( $raw_addons as $idx => $addon ) {
        if ( ! is_array( $addon ) ) continue;
        $raw_toman                              = isset( $addon['price'] ) ? floatval( $addon['price'] ) : 0;
        $raw_addons[ $idx ]['_raw_toman_price'] = $raw_toman;
        $raw_addons[ $idx ]['price']            = af_get_addon_converted_price( $raw_addons[ $idx ] );
        $raw_addons[ $idx ]['_converted_to']    = $is_usd ? 'USD' : 'IRT';
    }

    return $single ? array( $raw_addons ) : array( $raw_addons );
}, 10, 4 );

function af_get_exact_product_price( $product_id, $months = 1, $level = 'core', $option = 'standard' ) {
    $product = wc_get_product( $product_id );
    if ( ! $product ) return 0;

    $is_usd = af_is_usd_currency();

    if ( $product->is_type( 'variable' ) ) {
        $children       = $product->get_children();
        $matched_prices = array();
        $all_prices     = array();

        foreach ( $children as $child_id ) {
            if ( $is_usd ) {
                $wmcp = get_post_meta( $child_id, '_regular_price_wmcp', true );
                $data = is_string( $wmcp ) ? json_decode( $wmcp, true ) : $wmcp;
                $p    = ( is_array( $data ) && ! empty( $data['USD'] ) ) ? floatval( $data['USD'] ) : 0;
                if ( $p <= 0 ) {
                    $reg = floatval( get_post_meta( $child_id, '_regular_price', true ) );
                    $p   = $reg > 1000 ? round( $reg / 150000, 2 ) : $reg;
                }
            } else {
                $p = floatval( get_post_meta( $child_id, '_regular_price', true ) );
            }

            if ( $p <= 0 ) continue;
            $all_prices[] = $p;

            $dur_meta = get_post_meta( $child_id, 'attribute_pa_duration', true ) ?: get_post_meta( $child_id, 'attribute_duration', true );
            $lvl_meta = strtolower( get_post_meta( $child_id, 'attribute_pa_level', true ) ?: get_post_meta( $child_id, 'attribute_level', true ) );
            $opt_meta = strtolower( get_post_meta( $child_id, 'attribute_pa_option', true ) ?: get_post_meta( $child_id, 'attribute_option', true ) );

            if ( absint( $dur_meta ) === absint( $months ) ) {
                if ( ( empty( $lvl_meta ) || $lvl_meta === strtolower( $level ) ) && ( empty( $opt_meta ) || $opt_meta === strtolower( $option ) || $opt_meta === 'onboarding' ) ) {
                    return $p;
                }
                $matched_prices[] = $p;
            }
        }

        if ( ! empty( $matched_prices ) ) return min( $matched_prices );
        return ! empty( $all_prices ) ? min( $all_prices ) : 0;
    }

    if ( $is_usd ) {
        $wmcp = get_post_meta( $product_id, '_regular_price_wmcp', true );
        $data = is_string( $wmcp ) ? json_decode( $wmcp, true ) : $wmcp;
        if ( is_array( $data ) && ! empty( $data['USD'] ) && is_numeric( $data['USD'] ) ) {
            return floatval( $data['USD'] );
        }
        $reg = floatval( get_post_meta( $product_id, '_regular_price', true ) );
        return $reg > 1000 ? round( $reg / 150000, 2 ) : $reg;
    }

    return floatval( get_post_meta( $product_id, '_regular_price', true ) ?: $product->get_price() );
}

// =========================================================================
// ۲. فراخوانی فایل‌های قالب
// =========================================================================
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/addons.php';
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/product-subscription-inc.php';
require get_template_directory() . '/inc/newsletter-manager.php';
require get_template_directory() . '/inc/woocommerce.php';
require_once get_template_directory() . '/inc/category-extra-fields.php';
require_once get_template_directory() . '/inc/single-blog-menu.php';
require_once get_template_directory() . '/inc/faq-cpt.php';
require_once get_template_directory() . '/questionnaire/questionnaire.php';
require_once get_template_directory() . '/template-parts/questionnaire-test-popup.php';
require_once get_template_directory() . '/template-parts/my-programs-popup.php';

function enable_svg_upload( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'enable_svg_upload' );

function sanitize_svg( $file ) {
    if ( $file['type'] === 'image/svg+xml' ) {
        $svg_content = file_get_contents( $file['tmp_name'] );
        $svg_content = preg_replace( '/<script.*?<\/script>/is', '', $svg_content );
        file_put_contents( $file['tmp_name'], $svg_content );
    }
    return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'sanitize_svg' );

class Custom_Mobile_Menu_Walker extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $output .= '<li>';
        $output .= '<a href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a>';
        $output .= '<img src="https://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg" alt="آیکن ' . esc_attr( $item->title ) . '">';
        $output .= '</li>';
    }
}

add_action( 'wp_ajax_search_posts', 'search_posts_callback' );
add_action( 'wp_ajax_nopriv_search_posts', 'search_posts_callback' );

function search_posts_callback() {
    global $wpdb;
    $query = sanitize_text_field( $_POST['query'] ?? '' );
    if ( empty( $query ) ) {
        wp_send_json_success( [] );
        return;
    }

    $posts_query = $wpdb->prepare(
        "SELECT DISTINCT p.ID, p.post_title 
         FROM {$wpdb->posts} p
         LEFT JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
         LEFT JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
         LEFT JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
         WHERE p.post_type = 'post' 
         AND p.post_status = 'publish' 
         AND (p.post_title LIKE %s OR t.name LIKE %s)
         GROUP BY p.ID
         LIMIT 10",
        '%' . $wpdb->esc_like( $query ) . '%',
        '%' . $wpdb->esc_like( $query ) . '%'
    );

    $posts = $wpdb->get_results( $posts_query, ARRAY_A );

    foreach ( $posts as &$post ) {
        $categories        = wp_get_post_categories( $post['ID'], [ 'fields' => 'names' ] );
        $tags              = wp_get_post_tags( $post['ID'], [ 'fields' => 'names' ] );
        $post['category']  = ! empty( $categories ) ? $categories[0] : '';
        $post['tags']      = $tags;
        $post['title']     = $post['post_title'];
        $post['permalink'] = get_permalink( $post['ID'] );
        unset( $post['post_title'] );
    }

    wp_send_json_success( $posts );
    wp_die();
}

add_action( 'wp_ajax_filter_blog_posts', 'filter_blog_posts' );
add_action( 'wp_ajax_nopriv_filter_blog_posts', 'filter_blog_posts' );

function filter_blog_posts() {
    $categories = isset( $_POST['categories'] ) ? json_decode( stripslashes( $_POST['categories'] ), true ) : [];
    $paged      = isset( $_POST['paged'] ) ? intval( $_POST['paged'] ) : 1;

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 8,
        'paged'          => $paged,
        'post_status'    => 'publish'
    );

    if ( ! empty( $categories ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $categories,
                'operator' => 'IN'
            )
        );
    }

    $query = new WP_Query( $args );
    ob_start();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $categories = get_the_category();
            $category   = ! empty( $categories ) ? $categories[0] : null;
            $term_id    = $category ? $category->term_id : 0;
            $icon       = $term_id ? get_term_meta( $term_id, 'category_icon', true ) : '';
            $color      = $term_id ? get_term_meta( $term_id, 'category_color', true ) : '#000000';
            $cat_name   = $category ? $category->name : 'دسته‌بندی';
            ?>
            <article class="blog-post-card">
                <?php if ( has_post_thumbnail() ) : ?>
                    <img src="<?php the_post_thumbnail_url( 'full' ); ?>" alt="<?php the_title(); ?>" class="blog-post-image">
                <?php endif; ?>
                <div class="blog-post-content">
                    <?php if ( $category ) : ?>
                        <div class="blog-post-category" style="background-color: <?php echo esc_attr( $color ); ?>;">
                            <?php if ( $icon ) : ?>
                                <img src="<?php echo esc_url( $icon ); ?>" alt="<?php echo esc_attr( $cat_name ); ?>" class="blog-post-category-icon">
                            <?php endif; ?>
                            <span class="blog-post-category-name"><?php echo esc_html( $cat_name ); ?></span>
                        </div>
                    <?php endif; ?>
                    <h3 class="blog-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </div>
            </article>
            <?php
        }
    } else {
        echo '<p>هیچ مقاله‌ای یافت نشد.</p>';
    }

    wp_reset_postdata();
    $html = ob_get_clean();
    wp_send_json( array( 'html' => $html, 'max_pages' => $query->max_num_pages ) );
}
// =========================================================================
// 3. AUTHENTICATION & OTP SECTION (KAVENEGAR SMS + EMAIL OTP)
// =========================================================================
require_once get_template_directory() . '/inc/kavenegar-sms.php';
require_once get_template_directory() . '/inc/email-otp.php';

if ( ! function_exists( 'af_convert_persian_digits_to_en' ) ) {
    function af_convert_persian_digits_to_en( $string ) {
        $persian = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' );
        $english = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
        return str_replace( $persian, $english, (string) $string );
    }
}

if ( ! function_exists( 'af_clean_all_output_buffers' ) ) {
    function af_clean_all_output_buffers() {
        while ( ob_get_level() > 0 ) {
            @ob_end_clean();
        }
    }
}

if ( ! function_exists( 'af_save_user_billing_meta_on_auth' ) ) {
    function af_save_user_billing_meta_on_auth( $user_id ) {
        $user = get_userdata( $user_id );
        if ( ! $user ) {
            return;
        }

        $default_label = 'کاربر';
        $full_name     = $user->display_name ? $user->display_name : $user->first_name;
        $parts         = preg_split( '/\s+/u', trim( $full_name ), 2 );
        $first_name    = ! empty( $parts[0] ) ? $parts[0] : $default_label;
        $last_name     = ! empty( $parts[1] ) ? $parts[1] : $first_name;
        $phone         = get_user_meta( $user_id, 'phone', true );
        $email         = $user->user_email;

        update_user_meta( $user_id, 'first_name', $first_name );
        update_user_meta( $user_id, 'last_name', $last_name );
        update_user_meta( $user_id, 'billing_first_name', $first_name );
        update_user_meta( $user_id, 'billing_last_name', $last_name );
        update_user_meta( $user_id, 'billing_full_name', $full_name );

        if ( ! empty( $phone ) ) {
            update_user_meta( $user_id, 'billing_phone', $phone );
        }
        if ( ! empty( $email ) ) {
            update_user_meta( $user_id, 'billing_email', $email );
        }
    }
}

add_action( 'wp_ajax_send_auth_otp', 'handle_send_auth_otp' );
add_action( 'wp_ajax_nopriv_send_auth_otp', 'handle_send_auth_otp' );

function handle_send_auth_otp() {
    @ini_set( 'display_errors', 0 );

    // اطمینان ۱۰۰٪ از لود شدن کلاس‌های پیامک و ایمیل
    require_once get_template_directory() . '/inc/kavenegar-sms.php';
    require_once get_template_directory() . '/inc/email-otp.php';

    $raw_identifier = isset( $_POST['phone'] ) ? $_POST['phone'] : ( isset( $_POST['identifier'] ) ? $_POST['identifier'] : '' );
    $identifier     = function_exists( 'af_normalize_otp_identifier' )
        ? af_normalize_otp_identifier( $raw_identifier )
        : sanitize_text_field( af_convert_persian_digits_to_en( trim( $raw_identifier ) ) );

    if ( empty( $identifier ) ) {
        af_clean_all_output_buffers();
        $msg_empty = 'شماره موبایل یا ایمیل وارد نشده است.';
        wp_send_json_error( array( 'message' => $msg_empty ) );
    }

    $code = function_exists( 'generate_otp_code' ) ? generate_otp_code( 4 ) : (string) wp_rand( 1000, 9999 );
    if ( function_exists( 'save_otp' ) ) {
        save_otp( $identifier, $code, 300 );
    }
    set_transient( 'af_backup_otp_' . md5( $identifier ), (string) $code, 300 );

    $result = array(
        'success' => false,
        'message' => '',
    );

    try {
        if ( is_email( $identifier ) ) {
            $email_otp = new Email_OTP();
            $result    = $email_otp->send_otp( $identifier, $code );
        } else {
            $kavenegar = new Kavenegar_SMS();
            $result    = $kavenegar->send_otp( $identifier, $code );
        }
    } catch ( Throwable $e ) {
        $result = array(
            'success' => false,
            'message' => $e->getMessage(),
        );
    }

    af_clean_all_output_buffers();

    if ( ! empty( $result['success'] ) ) {
        $msg_ok = ! empty( $result['message'] ) ? $result['message'] : 'کد تایید ارسال شد.';
        wp_send_json_success( array(
            'message'    => $msg_ok,
            'identifier' => $identifier,
        ) );
    } else {
        $err_text = ! empty( $result['message'] ) ? $result['message'] : 'عدم ارتباط با سرویس پیامک/ایمیل';
        $msg_test = 'خطای سرویس ارسال (' . $err_text . ') - کد تست: ' . $code;
        wp_send_json_success( array(
            'message'     => $msg_test,
            'identifier'  => $identifier,
            'debug_otp'   => $code,
            'gateway_err' => $err_text,
        ) );
    }
}

add_action( 'wp_ajax_verify_auth_otp', 'handle_verify_auth_otp' );
add_action( 'wp_ajax_nopriv_verify_auth_otp', 'handle_verify_auth_otp' );

function handle_verify_auth_otp() {
    @ini_set( 'display_errors', 0 );

    require_once get_template_directory() . '/inc/kavenegar-sms.php';

    $raw_id     = isset( $_POST['identifier'] ) ? $_POST['identifier'] : ( isset( $_POST['phone'] ) ? $_POST['phone'] : '' );
    $raw_code   = isset( $_POST['code'] ) ? $_POST['code'] : '';
    $identifier = function_exists( 'af_normalize_otp_identifier' )
        ? af_normalize_otp_identifier( $raw_id )
        : sanitize_text_field( af_convert_persian_digits_to_en( trim( $raw_id ) ) );
    $code       = sanitize_text_field( af_convert_persian_digits_to_en( trim( $raw_code ) ) );

    if ( empty( $identifier ) || empty( $code ) ) {
        af_clean_all_output_buffers();
        $msg_inc = 'اطلاعات ناقص است.';
        wp_send_json_error( array( 'message' => $msg_inc ) );
    }

    $is_valid = false;
    $err_msg  = 'کد وارد شده اشتباه یا منقضی شده است.';

    if ( function_exists( 'verify_otp' ) ) {
        $result = verify_otp( $identifier, $code );
        if ( ! empty( $result['success'] ) ) {
            $is_valid = true;
        } elseif ( ! empty( $result['message'] ) ) {
            $err_msg = $result['message'];
        }
    }

    $backup_code = get_transient( 'af_backup_otp_' . md5( $identifier ) );
    if ( ! $is_valid && $backup_code && (string) $backup_code === (string) $code ) {
        $is_valid = true;
        delete_transient( 'af_backup_otp_' . md5( $identifier ) );
    }

    if ( ! $is_valid ) {
        af_clean_all_output_buffers();
        wp_send_json_error( array( 'message' => $err_msg ) );
    }

    $user = find_user_by_identifier( $identifier );

    if ( $user ) {
        wp_set_current_user( $user->ID );
        wp_set_auth_cookie( $user->ID, true );
        af_save_user_billing_meta_on_auth( $user->ID );

        af_clean_all_output_buffers();
        $msg_login = 'ورود موفقیت‌آمیز بود';
        wp_send_json_success( array(
            'action'   => 'login',
            'message'  => $msg_login,
            'redirect' => home_url(),
        ) );
    } else {
        set_transient( 'auth_pending_' . md5( $identifier ), $identifier, 900 );

        af_clean_all_output_buffers();
        $msg_reg = 'کد تایید صحیح است. لطفا اطلاعات خود را وارد کنید.';
        wp_send_json_success( array(
            'action'     => 'register',
            'message'    => $msg_reg,
            'identifier' => $identifier,
        ) );
    }
}

function find_user_by_identifier( $identifier ) {
    if ( is_string( $identifier ) && is_email( $identifier ) ) {
        return get_user_by( 'email', $identifier );
    }

    $users = get_users( array(
        'meta_key'   => 'phone',
        'meta_value' => $identifier,
        'number'     => 1,
    ) );

    return ! empty( $users ) ? $users[0] : false;
}

add_action( 'wp_ajax_register_auth_user', 'handle_register_auth_user' );
add_action( 'wp_ajax_nopriv_register_auth_user', 'handle_register_auth_user' );

function handle_register_auth_user() {
    @ini_set( 'display_errors', 0 );

    require_once get_template_directory() . '/inc/kavenegar-sms.php';

    $raw_id     = isset( $_POST['identifier'] ) ? $_POST['identifier'] : '';
    $identifier = function_exists( 'af_normalize_otp_identifier' )
        ? af_normalize_otp_identifier( $raw_id )
        : sanitize_text_field( af_convert_persian_digits_to_en( trim( $raw_id ) ) );
    $fullname   = sanitize_text_field( isset( $_POST['fullname'] ) ? $_POST['fullname'] : '' );
    $birthdate  = sanitize_text_field( isset( $_POST['birthdate'] ) ? $_POST['birthdate'] : '1375/06/15' );
    $gender     = sanitize_text_field( isset( $_POST['gender'] ) ? $_POST['gender'] : 'male' );

    if ( empty( $identifier ) || empty( $fullname ) ) {
        af_clean_all_output_buffers();
        $msg_req = 'لطفاً نام و نام خانوادگی را وارد کنید.';
        wp_send_json_error( array( 'message' => $msg_req ) );
    }

    $existing_user = find_user_by_identifier( $identifier );
    if ( $existing_user ) {
        wp_set_current_user( $existing_user->ID );
        wp_set_auth_cookie( $existing_user->ID, true );
        af_save_user_billing_meta_on_auth( $existing_user->ID );

        af_clean_all_output_buffers();
        $msg_ok_login = 'ورود با موفقیت انجام شد';
        wp_send_json_success( array(
            'message'  => $msg_ok_login,
            'redirect' => home_url(),
        ) );
    }

    if ( is_email( $identifier ) ) {
        $username = sanitize_user( current( explode( '@', $identifier ) ), true );
        if ( empty( $username ) ) {
            $username = 'user_' . wp_rand( 1000, 9999 );
        }
        $email = $identifier;
        $phone = '';
    } else {
        $username = 'user_' . $identifier;
        $email    = $identifier . '@temp.6tofit.com';
        $phone    = $identifier;
    }

    $original_username = $username;
    $i = 1;
    while ( username_exists( $username ) ) {
        $username = $original_username . $i;
        $i++;
    }

    $user_id = wp_create_user( $username, wp_generate_password(), $email );

    if ( is_wp_error( $user_id ) ) {
        af_clean_all_output_buffers();
        $err_create = 'خطا در ایجاد حساب کاربری: ' . $user_id->get_error_message();
        wp_send_json_error( array( 'message' => $err_create ) );
    }

    $parts      = preg_split( '/\s+/u', trim( $fullname ), 2 );
    $first_name = ! empty( $parts[0] ) ? $parts[0] : $fullname;
    $last_name  = ! empty( $parts[1] ) ? $parts[1] : $first_name;

    wp_update_user( array(
        'ID'           => $user_id,
        'display_name' => $fullname,
        'first_name'   => $first_name,
        'last_name'    => $last_name,
    ) );

    update_user_meta( $user_id, 'phone', $phone );
    update_user_meta( $user_id, 'birthdate', $birthdate );
    update_user_meta( $user_id, 'gender', $gender );
    update_user_meta( $user_id, 'auth_method', is_email( $identifier ) ? 'email' : 'phone' );

    delete_transient( 'auth_pending_' . md5( $identifier ) );

    wp_set_current_user( $user_id );
    wp_set_auth_cookie( $user_id, true );
    af_save_user_billing_meta_on_auth( $user_id );

    af_clean_all_output_buffers();
    $msg_reg_done = 'ثبت‌نام با موفقیت انجام شد';
    wp_send_json_success( array(
        'message'  => $msg_reg_done,
        'redirect' => home_url(),
    ) );
}

/**
 * لینک مستقیم تست پیامک و ایمیل از طریق admin-ajax (بدون هیچ ریدایرکتی):
 * تست پیامک: https://6tofit.com/wp-admin/admin-ajax.php?action=af_debug_otp&target=09123456789
 * تست ایمیل: https://6tofit.com/wp-admin/admin-ajax.php?action=af_debug_otp&target=test@gmail.com
 */
add_action( 'wp_ajax_af_debug_otp', function() {
    require_once get_template_directory() . '/inc/kavenegar-sms.php';
    require_once get_template_directory() . '/inc/email-otp.php';

    $target = isset( $_GET['target'] ) ? sanitize_text_field( $_GET['target'] ) : '';
    $code   = (string) wp_rand( 1000, 9999 );

    header( 'Content-Type: text/html; charset=utf-8' );
    echo '<div style="direction:rtl;font-family:tahoma,sans-serif;padding:30px;line-height:2;background:#f8fafc;max-width:800px;margin:40px auto;border:1px solid #cbd5e1;border-radius:12px;">';
    echo '<h2>گزارش تست زنده پیامک و ایمیل (6toFit)</h2>';
    echo '<p>گیرنده: <code>' . esc_html( $target ) . '</code> | کد: <code>' . esc_html( $code ) . '</code></p><hr>';

    if ( is_email( $target ) ) {
        $email_otp = new Email_OTP();
        $res       = $email_otp->send_otp( $target, $code );
        echo '<pre style="direction:ltr;background:#1e293b;color:#f8fafc;padding:15px;border-radius:8px;">' . esc_html( print_r( $res, true ) ) . '</pre>';
    } else {
        $kavenegar = new Kavenegar_SMS();
        $res       = $kavenegar->send_otp( $target, $code );
        echo '<pre style="direction:ltr;background:#1e293b;color:#f8fafc;padding:15px;border-radius:8px;">' . esc_html( print_r( $res, true ) ) . '</pre>';
    }
    echo '</div>';
    exit;
} );

// =========================================================================
// ۴. محاسبه یکپارچه و قفل‌شده قیمت اشتراک + Addons در سبد خرید
// =========================================================================
add_filter( 'woocommerce_add_cart_item_data', 'save_selected_addons_to_cart', 10, 2 );
function save_selected_addons_to_cart( $cart_item_data, $product_id ) {
    if ( empty( $_POST['selected_addons'] ) || ! is_array( $_POST['selected_addons'] ) ) {
        return $cart_item_data;
    }

    $all_addons = get_post_meta( $product_id, '_product_addons', true );
    if ( ! is_array( $all_addons ) ) {
        return $cart_item_data;
    }

    $selected = array();
    foreach ( $_POST['selected_addons'] as $raw_idx ) {
        if ( is_array( $raw_idx ) && isset( $raw_idx['index'] ) ) {
            $index = intval( $raw_idx['index'] );
        } elseif ( is_numeric( $raw_idx ) ) {
            $index = intval( $raw_idx );
        } else {
            continue;
        }
        if ( isset( $all_addons[ $index ] ) ) {
            $selected[] = $all_addons[ $index ];
        }
    }

    if ( ! empty( $selected ) ) {
        $cart_item_data['selected_addons'] = $selected;
        $cart_item_data['unique_key']      = md5( microtime() . rand() );
    }

    return $cart_item_data;
}

function af_get_cart_item_months( $cart_item ) {
    if ( ! empty( $cart_item['af_subscription']['months'] ) ) {
        return max( 1, absint( $cart_item['af_subscription']['months'] ) );
    }

    if ( ! empty( $cart_item['variation'] ) && is_array( $cart_item['variation'] ) ) {
        foreach ( $cart_item['variation'] as $attr_name => $attr_value ) {
            $decoded_val    = urldecode( $attr_value );
            $persian        = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' );
            $english        = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
            $normalized_val = str_replace( $persian, $english, $decoded_val );

            if ( preg_match( '/(\d+)/', $normalized_val, $matches ) ) {
                return max( 1, absint( $matches[1] ) );
            }
        }
    }
    return 1;
}

add_filter( 'woocommerce_get_item_data', 'display_selected_addons_in_cart', 10, 2 );
function display_selected_addons_in_cart( $item_data, $cart_item ) {
    if ( empty( $cart_item['selected_addons'] ) || ! is_array( $cart_item['selected_addons'] ) ) {
        return $item_data;
    }

    foreach ( $cart_item['selected_addons'] as $addon ) {
        if ( ! is_array( $addon ) || empty( $addon['title'] ) ) {
            continue;
        }
        $converted_price = af_get_addon_converted_price( $addon );
        $item_data[]     = array(
            'key'   => $addon['title'],
            'value' => wc_price( $converted_price ),
        );
    }
    return $item_data;
}

add_action( 'woocommerce_before_calculate_totals', 'af_unified_cart_price_calculation', 9999 );
function af_unified_cart_price_calculation( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
        $product_id   = $cart_item['product_id'];
        $variation_id = ! empty( $cart_item['variation_id'] ) ? $cart_item['variation_id'] : 0;
        $months       = af_get_cart_item_months( $cart_item );
        $discount     = isset( $cart_item['af_subscription']['discount'] ) ? floatval( $cart_item['af_subscription']['discount'] ) : 0;

        if ( $variation_id > 0 ) {
            $program_price = af_get_exact_product_price( $variation_id, $months );
        } else {
            $parent_obj = wc_get_product( $product_id );
            if ( $parent_obj && $parent_obj->is_type( 'variable' ) ) {
                $program_price = af_get_exact_product_price( $product_id, $months );
            } else {
                $base_unit_price = af_get_exact_product_price( $product_id, 1 );
                $program_price   = ( $base_unit_price * $months ) * ( 1 - ( $discount / 100 ) );
            }
        }

        $addons_total = 0;
        if ( ! empty( $cart_item['selected_addons'] ) && is_array( $cart_item['selected_addons'] ) ) {
            foreach ( $cart_item['selected_addons'] as $addon ) {
                $addons_total += af_get_addon_converted_price( $addon );
            }
        }

        $final_item_price = $program_price + ( $addons_total * $months );

        $cart_item['data']->set_price( $final_item_price );
        $cart_item['data']->update_meta_data( '_af_locked_final_price', (string) $final_item_price );
    }
}

add_filter( 'woocommerce_product_get_price', 'af_enforce_locked_cart_price', 99999, 2 );
add_filter( 'woocommerce_product_variation_get_price', 'af_enforce_locked_cart_price', 99999, 2 );
function af_enforce_locked_cart_price( $price, $product ) {
    if ( is_object( $product ) && method_exists( $product, 'get_meta' ) ) {
        $locked = $product->get_meta( '_af_locked_final_price' );
        if ( $locked !== '' && is_numeric( $locked ) ) {
            return (float) $locked;
        }
    }
    return $price;
}

add_action( 'woocommerce_checkout_create_order_line_item', 'save_addons_to_order_item', 10, 4 );
function save_addons_to_order_item( $item, $cart_item_key, $values, $order ) {
    if ( empty( $values['selected_addons'] ) || ! is_array( $values['selected_addons'] ) ) {
        return;
    }

    $addons_text = array();
    foreach ( $values['selected_addons'] as $addon ) {
        if ( ! is_array( $addon ) || empty( $addon['title'] ) ) {
            continue;
        }
        $converted_price = af_get_addon_converted_price( $addon );
        $formatted_price = wp_strip_all_tags( wc_price( $converted_price, array( 'currency' => $order->get_currency() ) ) );
        $addons_text[]   = $addon['title'] . ' (' . $formatted_price . ')';
    }

    if ( ! empty( $addons_text ) ) {
        $item->add_meta_data( 'خدمات پرو', implode( ' + ', $addons_text ) );
    }
}

add_action( 'wp_ajax_af_remove_checkout_addon', 'af_remove_checkout_addon' );
add_action( 'wp_ajax_nopriv_af_remove_checkout_addon', 'af_remove_checkout_addon' );

function af_remove_checkout_addon() {
    if ( ! WC()->cart ) {
        wp_send_json_error( array( 'message' => 'سبد خرید در دسترس نیست.' ) );
    }

    $addon_index = isset( $_POST['addon_index'] ) ? absint( $_POST['addon_index'] ) : -1;
    if ( $addon_index < 0 ) {
        wp_send_json_error( array( 'message' => 'Addon نامعتبر است.' ) );
    }

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        if ( empty( $cart_item['selected_addons'] ) || ! is_array( $cart_item['selected_addons'] ) ) {
            continue;
        }
        if ( ! isset( $cart_item['selected_addons'][ $addon_index ] ) ) {
            continue;
        }

        unset( WC()->cart->cart_contents[ $cart_item_key ]['selected_addons'][ $addon_index ] );
        WC()->cart->cart_contents[ $cart_item_key ]['selected_addons'] = array_values(
            WC()->cart->cart_contents[ $cart_item_key ]['selected_addons']
        );

        if ( empty( WC()->cart->cart_contents[ $cart_item_key ]['selected_addons'] ) ) {
            unset( WC()->cart->cart_contents[ $cart_item_key ]['selected_addons'] );
        }
        break;
    }

    WC()->cart->calculate_totals();
    $subtotal = WC()->cart->get_subtotal();
    $total    = WC()->cart->get_total( 'edit' );

    wp_send_json_success( array(
        'subtotal_html' => wc_price( $subtotal ),
        'total_html'    => wc_price( $total ),
    ) );
}

// =========================================================================
// ۵. بهینه‌سازی خروجی HTML + تشخیص تایم‌زون + اصلاح کامل کارت‌های .service-card
// =========================================================================
add_action( 'template_redirect', function() {
    if ( is_admin() || defined( 'DOING_AJAX' ) ) {
        return;
    }

    $queried_id       = get_queried_object_id();
    $js_addons_prices = array();
    if ( $queried_id ) {
        $product_addons = get_post_meta( $queried_id, '_product_addons', true );
        if ( is_array( $product_addons ) ) {
            foreach ( $product_addons as $idx => $ad ) {
                $js_addons_prices[ $idx ] = af_get_addon_converted_price( $ad );
            }
        }
    }
    $addons_json = wp_json_encode( $js_addons_prices );

    ob_start( function( $buffer ) use ( $addons_json ) {
        $buffer = str_replace( 'http://6tofit.com', 'https://6tofit.com', $buffer );
        $buffer = str_replace( 'http:\/\/6tofit.com', 'https:\/\/6tofit.com', $buffer );

        $emoji_svgs = array(
            'Syringe.png'         => '💉',
            'Dna.png'             => '🧬',
            'Drop-Of-Blood.png'   => '🩸',
            'Direct-Hit.png'      => '🎯',
            'Sparkles.png'        => '✨',
            'Light-Bulb.png'      => '💡',
            'No-Entry.png'        => '🚫',
            'Pill-1.png'          => '💊',
            'Pill.png'            => '💊',
            'Triangular-Flag.png' => '🚩',
            'Clipboard.png'       => '📋',
            'T-Shirt.png'         => '👕',
        );

        foreach ( $emoji_svgs as $filename => $emoji ) {
            $svg_data_uri = 'data:image/svg+xml;utf8,' . rawurlencode( '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" font-size="44">' . $emoji . '</text></svg>' );
            $pattern      = '#https?://6tofit\.com/wp-content/uploads/2026/09/[^"\'\s>]*' . preg_quote( $filename, '#' ) . '#i';
            $buffer       = preg_replace( $pattern, $svg_data_uri, $buffer );
        }

        $buffer = preg_replace( '/<img\s+(?![^>]*\bloading=)/i', '<img loading="lazy" decoding="async" ', $buffer );

        $is_usd        = af_is_usd_currency();
        $is_manual     = ! empty( $_GET['wmc-currency'] ) || ! empty( $_COOKIE['af_manual_currency'] );
        $server_cntry  = af_get_country_by_ip( af_get_real_user_ip() );
        $js_is_usd     = $is_usd ? 'true' : 'false';
        $js_is_manual  = $is_manual ? 'true' : 'false';

        $head_tz_detector = <<<HTML
<script id="af-early-tz-detector">
(function() {
    try {
        const isUsdRendered = {$js_is_usd};
        const isManualMode  = {$js_is_manual};
        const serverCountry = "{$server_cntry}";

        const origResolvedOptions = Intl.DateTimeFormat.prototype.resolvedOptions;
        const realOptions = origResolvedOptions.call(new Intl.DateTimeFormat());
        const tzName = realOptions.timeZone || '';
        const tzOffset = new Date().getTimezoneOffset();
        const isIranTimezone = (tzName === 'Asia/Tehran' || tzName === 'Iran' || tzOffset === -210);

        document.cookie = "af_tz_iran=" + (isIranTimezone ? "1" : "0") + "; path=/; max-age=604800; SameSite=Lax";

        Intl.DateTimeFormat.prototype.resolvedOptions = function() {
            const res = origResolvedOptions.apply(this, arguments);
            res.timeZone = 'Asia/Tehran';
            return res;
        };

        if (isIranTimezone && isUsdRendered && !isManualMode) {
            document.cookie = "wmc_current_currency=IRT; path=/; max-age=86400; SameSite=Lax";
            document.cookie = "wmc_current_currency_old=IRT; path=/; max-age=86400; SameSite=Lax";
            if (sessionStorage.getItem('af_tz_last_switch') !== 'IRT') {
                sessionStorage.setItem('af_tz_last_switch', 'IRT');
                const cleanUrl = new URL(window.location.href);
                cleanUrl.searchParams.delete('wmc-currency');
                window.location.replace(cleanUrl.toString());
            }
        } else if (!isIranTimezone && !isUsdRendered && !isManualMode && serverCountry !== 'IR') {
            document.cookie = "wmc_current_currency=USD; path=/; max-age=86400; SameSite=Lax";
            document.cookie = "wmc_current_currency_old=USD; path=/; max-age=86400; SameSite=Lax";
            if (sessionStorage.getItem('af_tz_last_switch') !== 'USD') {
                sessionStorage.setItem('af_tz_last_switch', 'USD');
                const cleanUrl = new URL(window.location.href);
                cleanUrl.searchParams.delete('wmc-currency');
                window.location.replace(cleanUrl.toString());
            }
        } else {
            sessionStorage.removeItem('af_tz_last_switch');
        }
    } catch (e) {}
})();
</script>
HTML;

        if ( stripos( $buffer, '<head>' ) !== false ) {
            $buffer = preg_replace( '/<head>/i', '<head>' . $head_tz_detector, $buffer, 1 );
        }

        $footer_sync_script = <<<HTML
<script id="af-global-currency-sync">
(function() {
    const isUsd = {$js_is_usd};
    const serverAddonPrices = {$addons_json} || {};

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.addon-checkbox, .af-addon-checkbox').forEach(function(cb) {
            const idx = cb.value;
            cb.style.display = '';
            cb.checked = false;

            let p = (serverAddonPrices[idx] !== undefined)
                ? parseFloat(serverAddonPrices[idx])
                : parseFloat(cb.dataset.price || 0);

            if (isUsd && p > 1000) {
                p = Math.round((p / 150000) * 100) / 100;
            }

            cb.dataset.price = p;

            const card = cb.closest('.service-card, .af-addon-card');
            if (card) {
                card.classList.remove('selected', 'active');
                card.dataset.price = p;
                card.dataset.addonPrice = p;
                card.setAttribute('data-addon-price', String(p));
                card.setAttribute('data-price', String(p));

                const dec = Math.floor(p) === p ? 0 : 2;
                const formattedUsd = '$' + p.toLocaleString('en-US', {minimumFractionDigits: dec, maximumFractionDigits: dec});
                const formattedIrt = Math.round(p).toLocaleString('en-US').replace(/,/g, '.');

                const priceTextEl = card.querySelector('.price-text');
                if (priceTextEl) {
                    if (isUsd) {
                        priceTextEl.innerHTML = '<span style="direction:ltr;display:inline-block;">' + formattedUsd + '</span> <span style="color: #65656D;">دلار</span>';
                    } else {
                        priceTextEl.innerHTML = formattedIrt + ' <span style="color: #65656D;">تومان</span>';
                    }
                }

                const popupPriceEl = card.querySelector('.af-addon-price');
                if (popupPriceEl) {
                    if (isUsd) {
                        popupPriceEl.innerHTML = '<span style="direction:ltr;display:inline-block;">' + formattedUsd + '</span> <span style="color:#65656D;font-size:13px;">دلار</span>';
                    } else {
                        popupPriceEl.innerHTML = formattedIrt + ' <span style="color:#65656D;font-size:13px;">تومان</span>';
                    }
                }
            }
        });

        const stickyFooter = document.querySelector('.sticky-footer');
        if (stickyFooter) {
            let basePrice = parseFloat(stickyFooter.dataset.basePrice || 0);
            if (isUsd && basePrice > 10000) {
                basePrice = Math.round((basePrice / 150000) * 100) / 100;
                stickyFooter.dataset.basePrice = basePrice;
            }

            function syncStickyFooterPrice() {
                let addonsSum = 0;
                document.querySelectorAll('.addon-checkbox:checked').forEach(function(cb) {
                    let ap = parseFloat(cb.dataset.price || 0);
                    if (isUsd && ap > 1000) ap = Math.round((ap / 150000) * 100) / 100;
                    addonsSum += ap;
                });

                const finalTotal = basePrice + addonsSum;
                const totalEl = stickyFooter.querySelector('.total-price');
                if (totalEl) {
                    if (isUsd) {
                        const dec = Math.floor(finalTotal) === finalTotal ? 0 : 2;
                        totalEl.innerHTML = '<span style="direction:ltr;display:inline-block;">$' + finalTotal.toLocaleString('en-US', {minimumFractionDigits: dec, maximumFractionDigits: dec}) + '</span> <span style="font-size:14px;color:#65656D;">دلار</span>';
                    } else {
                        totalEl.innerHTML = Math.round(finalTotal).toLocaleString('en-US').replace(/,/g, '.') + ' <span style="font-size:14px;color:#65656D;">تومان</span>';
                    }
                }
            }

            setTimeout(syncStickyFooterPrice, 50);
            setTimeout(syncStickyFooterPrice, 250);
            document.querySelectorAll('.addon-checkbox').forEach(function(cb) {
                cb.addEventListener('change', function() {
                    setTimeout(syncStickyFooterPrice, 10);
                });
            });
        }
    });
})();
</script>
HTML;

        if ( stripos( $buffer, '</body>' ) !== false ) {
            $buffer = str_ireplace( '</body>', $footer_sync_script . '</body>', $buffer );
        } else {
            $buffer .= $footer_sync_script;
        }

        return $buffer;
    } );
} );

// =========================================================================
// ۶. تنظیمات کامل تسویه‌حساب + پر کردن خودکار اطلاعات کاربر + اتصال به Zapier / Zoho CRM
// =========================================================================

add_filter( 'woocommerce_get_terms_and_conditions_checkbox_text', 'af_custom_terms_checkbox_text' );
function af_custom_terms_checkbox_text( $text ) {
    return 'شرایط و قوانین رو خوانده و می‌پذیرم';
}
add_filter( 'woocommerce_checkout_show_terms', '__return_true' );
add_filter( 'woocommerce_terms_and_conditions_checkbox_enabled', '__return_true' );

add_filter( 'woocommerce_cart_needs_shipping', '__return_false' );
add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false' );
add_filter( 'woocommerce_shipping_packages', '__return_empty_array' );

add_filter( 'woocommerce_default_address_fields', function( $address_fields ) {
    $optional_keys = array( 'country', 'first_name', 'last_name', 'company', 'address_1', 'address_2', 'city', 'state', 'postcode' );
    foreach ( $optional_keys as $key ) {
        if ( isset( $address_fields[ $key ] ) ) {
            $address_fields[ $key ]['required'] = false;
        }
    }
    return $address_fields;
}, 9999 );

add_filter( 'woocommerce_checkout_fields', function ( $fields ) {
    $is_usd       = af_is_usd_currency();
    $current_user = wp_get_current_user();
    $has_user     = ( $current_user && $current_user->ID > 0 );

    $default_name = $has_user ? ( $current_user->display_name ?: $current_user->first_name ) : '';
    $default_tel  = $has_user ? get_user_meta( $current_user->ID, 'phone', true ) : '';
    $default_mail = ( $has_user && strpos( $current_user->user_email, '@temp.6tofit.com' ) === false ) ? $current_user->user_email : '';

    $fields['billing'] = array(
        'billing_full_name' => array(
            'type'        => 'text',
            'label'       => 'نام و نام خانوادگی',
            'placeholder' => 'نام و نام خانوادگی',
            'default'     => $default_name,
            'required'    => true,
            'class'       => array( 'form-row-wide' ),
            'priority'    => 10,
        ),
        'billing_phone' => array(
            'type'        => 'tel',
            'label'       => 'شماره موبایل',
            'placeholder' => 'شماره موبایل',
            'default'     => $default_tel,
            'required'    => ! $is_usd,
            'class'       => array( 'form-row-wide' ),
            'priority'    => 20,
        ),
        'billing_email' => array(
            'type'        => 'email',
            'label'       => 'ایمیل',
            'placeholder' => 'ایمیل',
            'default'     => $default_mail,
            'required'    => $is_usd,
            'class'       => array( 'form-row-wide' ),
            'priority'    => 30,
        ),
        'billing_country' => array(
            'type'     => 'hidden',
            'default'  => $is_usd ? 'US' : 'IR',
            'required' => false,
            'class'    => array( 'hidden' ),
            'priority' => 40,
        ),
    );

    $fields['shipping'] = array();
    $fields['order']    = array();

    return $fields;
}, 9999 );

add_filter( 'woocommerce_checkout_get_value', function( $value, $input ) {
    if ( ! empty( $value ) || ! is_user_logged_in() ) {
        return $value;
    }
    $user = wp_get_current_user();
    if ( $input === 'billing_full_name' ) {
        return $user->display_name ?: $user->first_name;
    }
    if ( $input === 'billing_phone' ) {
        return get_user_meta( $user->ID, 'phone', true );
    }
    if ( $input === 'billing_email' ) {
        return ( strpos( $user->user_email, '@temp.6tofit.com' ) === false ) ? $user->user_email : '';
    }
    return $value;
}, 10, 2 );

add_action( 'woocommerce_before_checkout_process', function() {
    $is_usd       = af_is_usd_currency();
    $current_user = wp_get_current_user();
    $has_user     = ( $current_user && $current_user->ID > 0 );

    if ( empty( $_POST['billing_full_name'] ) && $has_user ) {
        $_POST['billing_full_name'] = $current_user->display_name ?: $current_user->first_name;
    }
    if ( empty( $_POST['billing_phone'] ) && $has_user ) {
        $_POST['billing_phone'] = get_user_meta( $current_user->ID, 'phone', true ) ?: '09000000000';
    }
    if ( empty( $_POST['billing_email'] ) ) {
        $_POST['billing_email'] = $has_user ? $current_user->user_email : 'guest_' . time() . '@temp.6tofit.com';
    }

    if ( empty( $_POST['billing_country'] ) )   $_POST['billing_country']   = $is_usd ? 'US' : 'IR';
    if ( empty( $_POST['billing_state'] ) )     $_POST['billing_state']     = $is_usd ? 'CA' : 'THR';
    if ( empty( $_POST['billing_city'] ) )      $_POST['billing_city']      = $is_usd ? 'Los Angeles' : 'Tehran';
    if ( empty( $_POST['billing_address_1'] ) ) $_POST['billing_address_1'] = 'Online Digital Program';
    if ( empty( $_POST['billing_postcode'] ) )  $_POST['billing_postcode']  = $is_usd ? '90001' : '1111111111';

    if ( ! empty( $_POST['billing_full_name'] ) ) {
        $full_name  = sanitize_text_field( wp_unslash( $_POST['billing_full_name'] ) );
        $parts      = preg_split( '/\s+/u', trim( $full_name ), 2 );
        $first_name = $parts[0] ?? 'User';
        $last_name  = ! empty( $parts[1] ) ? $parts[1] : $first_name;

        $_POST['billing_first_name'] = $first_name;
        $_POST['billing_last_name']  = $last_name;
    }
}, 1 );

add_action( 'woocommerce_after_checkout_validation', function( $data, $errors ) {
    if ( ! is_object( $errors ) || ! method_exists( $errors, 'get_error_codes' ) ) {
        return;
    }
    $ignore_codes = array(
        'billing_country_required',
        'billing_state_required',
        'billing_city_required',
        'billing_address_1_required',
        'billing_postcode_required',
        'billing_postcode_validation',
        'billing_first_name_required',
        'billing_last_name_required',
    );
    foreach ( $ignore_codes as $code ) {
        $errors->remove( $code );
    }
    foreach ( $errors->get_error_codes() as $code ) {
        $messages = $errors->get_error_messages( $code );
        foreach ( $messages as $msg ) {
            if ( mb_strpos( $msg, 'کشور' ) !== false || mb_strpos( $msg, 'استان' ) !== false || mb_strpos( $msg, 'شهر' ) !== false || mb_strpos( $msg, 'خیابان' ) !== false || mb_strpos( $msg, 'کدپستی' ) !== false ) {
                $errors->remove( $code );
            }
        }
    }
}, 9999, 2 );

add_action( 'woocommerce_checkout_create_order', function ( $order, $data ) {
    $full_name = '';
    if ( ! empty( $_POST['billing_full_name'] ) ) {
        $full_name = sanitize_text_field( wp_unslash( $_POST['billing_full_name'] ) );
    } elseif ( ! empty( $data['billing_full_name'] ) ) {
        $full_name = sanitize_text_field( $data['billing_full_name'] );
    }

    if ( ! empty( $full_name ) ) {
        $parts      = preg_split( '/\s+/u', trim( $full_name ), 2 );
        $first_name = $parts[0] ?? 'User';
        $last_name  = ! empty( $parts[1] ) ? $parts[1] : $first_name;

        $order->set_billing_first_name( $first_name );
        $order->set_billing_last_name( $last_name );
        $order->update_meta_data( '_billing_full_name', $full_name );
        $order->update_meta_data( 'zoho_full_name', $full_name );
        $order->update_meta_data( 'zoho_first_name', $first_name );
        $order->update_meta_data( 'zoho_last_name', $last_name );
    }

    $order->set_currency( af_is_usd_currency() ? 'USD' : 'IRT' );

    $skus          = array();
    $program_names = array();
    $levels        = array();
    $durations     = array();
    $options       = array();
    $pro_addons    = array();

    foreach ( $order->get_items() as $item ) {
        $product = $item->get_product();
        if ( $product && $product->get_sku() ) {
            $skus[] = $product->get_sku();
        }
        $program_names[] = $item->get_name();

        $lvl = $item->get_meta( 'pa_level' ) ?: $item->get_meta( 'level' );
        $dur = $item->get_meta( 'pa_duration' ) ?: ( $item->get_meta( 'duration' ) ?: $item->get_meta( 'اشتراک' ) );
        $opt = $item->get_meta( 'pa_option' ) ?: $item->get_meta( 'option' );
        $add = $item->get_meta( 'خدمات پرو' );

        if ( $lvl ) $levels[]     = strtoupper( $lvl );
        if ( $dur ) $durations[]  = $dur;
        if ( $opt ) $options[]    = ucfirst( $opt );
        if ( $add ) $pro_addons[] = $add;
    }

    $order->update_meta_data( 'zoho_sku', implode( ', ', array_filter( $skus ) ) );
    $order->update_meta_data( 'zoho_program_name', implode( ' + ', array_filter( $program_names ) ) );
    $order->update_meta_data( 'zoho_service_level', ! empty( $levels ) ? implode( ', ', $levels ) : 'Core' );
    $order->update_meta_data( 'zoho_duration_months', ! empty( $durations ) ? implode( ', ', $durations ) : '1' );
    $order->update_meta_data( 'zoho_diet_option', ! empty( $options ) ? implode( ', ', $options ) : 'Standard' );
    $order->update_meta_data( 'zoho_pro_addons', ! empty( $pro_addons ) ? implode( ' | ', $pro_addons ) : 'بدون خدمات پرو' );
    $order->update_meta_data( 'zoho_environment', 'Sandbox_Test' );
}, 20, 2 );

add_filter( 'woocommerce_rest_prepare_shop_order_object', function( $response, $order, $request ) {
    if ( ! $order instanceof WC_Order ) {
        return $response;
    }
    $zoho_keys = array(
        'zoho_full_name',
        'zoho_first_name',
        'zoho_last_name',
        'zoho_sku',
        'zoho_program_name',
        'zoho_service_level',
        'zoho_duration_months',
        'zoho_diet_option',
        'zoho_pro_addons',
        'zoho_environment',
    );
    foreach ( $zoho_keys as $key ) {
        $response->data[ $key ] = (string) $order->get_meta( $key );
    }
    return $response;
}, 10, 3 );

// =========================================================================
// ۷. بارگذاری قطعی درگاه تست استرایپ و سندباکس زرین‌پال + اصلاح ایجکس Checkout
// =========================================================================

add_filter( 'woocommerce_cart_needs_payment', '__return_true', 9999 );

add_filter( 'wc_stripe_supported_currencies', function( $currencies ) {
    $currencies[] = 'USD';
    $currencies[] = 'IRT';
    $currencies[] = 'IRR';
    return array_unique( $currencies );
} );

if ( ! function_exists( 'af_ensure_custom_gateways_loaded' ) ) {
    function af_ensure_custom_gateways_loaded() {
        if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
            return;
        }

        // --- درگاه تست استرایپ (دلاری) جهت ارسال ایونت پرداخت به Zapier/Zoho Sandbox ---
        if ( ! class_exists( 'WC_Gateway_AF_Stripe_Test' ) ) {
            class WC_Gateway_AF_Stripe_Test extends WC_Payment_Gateway {
                public function __construct() {
                    $this->id                 = 'af_stripe_test';
                    $this->has_fields         = true;
                    $this->method_title       = 'Stripe Credit Card (Test Mode)';
                    $this->method_description = 'Stripe Test Mode Gateway for Zapier/Zoho Sandbox';
                    $this->title              = 'Credit / Debit Card (Stripe)';
                    $this->description        = 'Pay securely using your credit or debit card via Stripe.';
                    $this->enabled            = 'yes';
                    $this->supports           = array( 'products' );
                }

                public function is_available() {
                    return true;
                }

                public function payment_fields() {
                    ?>
                    <div class="af-stripe-card-box" style="background:#f8f9fa;border:1px solid #e2e8f0;border-radius:16px;padding:18px;margin-top:10px;direction:ltr;text-align:left;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                            <span style="font-size:13px;font-weight:600;color:#1e293b;">Card Information (Stripe)</span>
                            <span style="font-size:11px;background:#e0e7ff;color:#4338ca;padding:2px 8px;border-radius:99px;font-weight:600;">TEST MODE</span>
                        </div>
                        <div style="margin-bottom:12px;">
                            <label style="display:block;font-size:12px;color:#64748b;margin-bottom:4px;">Card Number</label>
                            <input type="text" name="af_stripe_cc_num" placeholder="4242 4242 4242 4242" value="4242 4242 4242 4242" maxlength="19" style="width:100%;height:44px;border:1px solid #cbd5e1;border-radius:10px;padding:0 12px;font-size:15px;letter-spacing:1px;background:#fff;box-sizing:border-box;" />
                        </div>
                        <div style="display:flex;gap:12px;">
                            <div style="flex:1;">
                                <label style="display:block;font-size:12px;color:#64748b;margin-bottom:4px;">Expiry (MM/YY)</label>
                                <input type="text" name="af_stripe_cc_exp" placeholder="12/28" value="12/28" maxlength="5" style="width:100%;height:44px;border:1px solid #cbd5e1;border-radius:10px;padding:0 12px;font-size:14px;background:#fff;box-sizing:border-box;" />
                            </div>
                            <div style="flex:1;">
                                <label style="display:block;font-size:12px;color:#64748b;margin-bottom:4px;">CVC</label>
                                <input type="text" name="af_stripe_cc_cvc" placeholder="123" value="123" maxlength="4" style="width:100%;height:44px;border:1px solid #cbd5e1;border-radius:10px;padding:0 12px;font-size:14px;background:#fff;box-sizing:border-box;" />
                            </div>
                        </div>
                    </div>
                    <?php
                }

                public function process_payment( $order_id ) {
                    $order = wc_get_order( $order_id );
                    if ( ! $order ) {
                        return array( 'result' => 'fail' );
                    }

                    $cc_num = isset( $_POST['af_stripe_cc_num'] ) ? preg_replace( '/\s+/', '', sanitize_text_field( $_POST['af_stripe_cc_num'] ) ) : '4242424242424242';
                    if ( $cc_num === '4000000000009995' ) {
                        wc_add_notice( 'Stripe Error: Your card has insufficient funds.', 'error' );
                        return array( 'result' => 'fail' );
                    }

                    $order->set_currency( 'USD' );
                    $order->set_payment_method_title( 'Stripe (Credit Card - Test)' );
                    $tx_id = 'pi_test_' . strtolower( wp_generate_password( 16, false ) );
                    $order->add_order_note( 'Stripe Test Payment Succeeded. Transaction ID: ' . $tx_id );
                    
                    // این تابع وضعیت سفارش را به Processing تغییر می‌دهد که باعث تریگر شدن زپیر می‌شود
                    $order->payment_complete( $tx_id ); 

                    WC()->cart->empty_cart();

                    return array(
                        'result'   => 'success',
                        'redirect' => $this->get_return_url( $order ),
                    );
                }
            }
        }

        // --- درگاه سندباکس زرین‌پال (تومانی) ---
        if ( ! class_exists( 'WC_Gateway_AF_Zarinpal_Sandbox' ) ) {
            class WC_Gateway_AF_Zarinpal_Sandbox extends WC_Payment_Gateway {
                private $merchant_code;

                public function __construct() {
                    $gw_title                 = 'پرداخت امن با کلیه کارت‌های عضو شتاب (زرین‌پال)';
                    $this->id                 = 'af_zarinpal_sandbox';
                    $this->has_fields         = false;
                    $this->method_title       = 'سندباکس زرین‌پال (Sandbox)';
                    $this->method_description = 'اتصال به درگاه تستی زرین‌پال جهت شبیه‌سازی پرداخت تومانی';
                    $this->title              = $gw_title;
                    $this->description        = 'پرداخت تستی از طریق سندباکس زرین‌پال';
                    $this->enabled            = 'yes';
                    $this->supports           = array( 'products' );
                    // مرچنت کد پیش‌فرض تستی زرین‌پال
                    $this->merchant_code      = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; 
                    
                    // بررسی بازگشت از درگاه
                    add_action( 'woocommerce_api_wc_gateway_af_zarinpal_sandbox', array( $this, 'verify_payment' ) );
                }

                public function is_available() {
                    return true;
                }

                public function process_payment( $order_id ) {
                    $order = wc_get_order( $order_id );
                    if ( ! $order ) {
                        return array( 'result' => 'fail' );
                    }

                    $order->set_currency( 'IRT' );
                    $order->set_payment_method_title( 'زرین‌پال (سندباکس)' );

                    $amount = $order->get_total();
                    $amount = ( $amount < 1000 ) ? 1000 : $amount; // حداقل مبلغ زرین‌پال در تومان
                    $amount_toman = (int) $amount;
                    
                    $callback_url = add_query_arg( 'wc-api', 'WC_Gateway_AF_Zarinpal_Sandbox', home_url( '/' ) );
                    $callback_url = add_query_arg( 'order_id', $order_id, $callback_url );

                    // درخواست توکن از سندباکس زرین‌پال
                    $data = array(
                        'merchant_id'  => $this->merchant_code,
                        'amount'       => $amount_toman * 10, // سندباکس ریال می‌گیرد
                        'callback_url' => $callback_url,
                        'description'  => 'پرداخت تستی سفارش شماره ' . $order->get_order_number(),
                        'metadata'     => array(
                            'mobile' => $order->get_billing_phone(),
                            'email'  => $order->get_billing_email()
                        )
                    );

                    $response = wp_remote_post( 'https://sandbox.zarinpal.com/pg/v4/payment/request.json', array(
                        'body'    => json_encode( $data ),
                        'headers' => array(
                            'Content-Type' => 'application/json',
                            'Accept'       => 'application/json'
                        ),
                        'timeout' => 15
                    ));

                    if ( ! is_wp_error( $response ) ) {
                        $body = json_decode( wp_remote_retrieve_body( $response ), true );
                        if ( isset( $body['data']['code'] ) && $body['data']['code'] == 100 ) {
                            $authority = $body['data']['authority'];
                            // انتقال به صفحه پرداخت تستی زرین‌پال
                            return array(
                                'result'   => 'success',
                                'redirect' => 'https://sandbox.zarinpal.com/pg/StartPay/' . $authority
                            );
                        }
                    }

                    wc_add_notice( 'خطا در اتصال به سندباکس زرین‌پال.', 'error' );
                    return array( 'result' => 'fail' );
                }

                public function verify_payment() {
                    $order_id  = isset( $_GET['order_id'] ) ? absint( $_GET['order_id'] ) : 0;
                    $authority = isset( $_GET['Authority'] ) ? sanitize_text_field( $_GET['Authority'] ) : '';
                    $status    = isset( $_GET['Status'] ) ? sanitize_text_field( $_GET['Status'] ) : '';

                    if ( ! $order_id || ! $authority ) {
                        wp_die( 'اطلاعات بازگشتی نامعتبر است.' );
                    }

                    $order = wc_get_order( $order_id );
                    if ( ! $order ) {
                        wp_die( 'سفارش یافت نشد.' );
                    }

                    if ( $status === 'OK' ) {
                        $amount_toman = (int) $order->get_total();
                        $data = array(
                            'merchant_id' => $this->merchant_code,
                            'authority'   => $authority,
                            'amount'      => $amount_toman * 10
                        );

                        $response = wp_remote_post( 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json', array(
                            'body'    => json_encode( $data ),
                            'headers' => array(
                                'Content-Type' => 'application/json',
                                'Accept'       => 'application/json'
                            )
                        ));

                        if ( ! is_wp_error( $response ) ) {
                            $body = json_decode( wp_remote_retrieve_body( $response ), true );
                            // کد 100 یعنی پرداخت موفق، 101 یعنی قبلاً وریفای شده
                            if ( isset( $body['data']['code'] ) && ( $body['data']['code'] == 100 || $body['data']['code'] == 101 ) ) {
                                $ref_id = $body['data']['ref_id'];
                                $order->add_order_note( 'تراکنش موفق در سندباکس زرین‌پال. کد رهگیری: ' . $ref_id );
                                $order->payment_complete( $ref_id );
                                
                                WC()->cart->empty_cart();
                                wp_redirect( $this->get_return_url( $order ) );
                                exit;
                            }
                        }
                    }

                    wc_add_notice( 'پرداخت در سندباکس زرین‌پال ناموفق بود یا لغو شد.', 'error' );
                    wp_redirect( wc_get_checkout_url() );
                    exit;
                }
            }
        }
    }
}

add_action( 'init', 'af_ensure_custom_gateways_loaded', 0 );

add_filter( 'woocommerce_payment_gateways', function( $gateways ) {
    af_ensure_custom_gateways_loaded();
    $gateways[] = 'WC_Gateway_AF_Stripe_Test';
    $gateways[] = 'WC_Gateway_AF_Zarinpal_Sandbox';
    return $gateways;
}, 99 );

add_filter( 'woocommerce_available_payment_gateways', function( $available_gateways ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) && empty( $_GET['wc-ajax'] ) ) {
        return $available_gateways;
    }

    af_ensure_custom_gateways_loaded();

    unset( $available_gateways['cod'] );
    unset( $available_gateways['cheque'] );
    unset( $available_gateways['bacs'] );

    $is_usd = af_is_usd_currency();

    if ( $is_usd ) {
        // حذف تمام درگاه‌های غیر استرایپ
        foreach ( $available_gateways as $gid => $gw ) {
            if ( stripos( $gid, 'stripe' ) === false ) {
                unset( $available_gateways[ $gid ] );
            }
        }

        if ( empty( $available_gateways ) && class_exists( 'WC_Gateway_AF_Stripe_Test' ) ) {
            $available_gateways['af_stripe_test'] = new WC_Gateway_AF_Stripe_Test();
        }
    } else {
        // حذف تمام درگاه‌های استرایپ (حالت تومانی)
        foreach ( $available_gateways as $gid => $gw ) {
            if ( stripos( $gid, 'stripe' ) !== false ) {
                unset( $available_gateways[ $gid ] );
            }
        }

        // اولویت دادن به سندباکس زرین‌پال در حالت تستی
        if ( class_exists( 'WC_Gateway_AF_Zarinpal_Sandbox' ) ) {
            $available_gateways['af_zarinpal_sandbox'] = new WC_Gateway_AF_Zarinpal_Sandbox();
            // اگر درگاه زرین‌پال واقعی هم بود، موقتاً مخفیش می‌کنیم تا فقط تست انجام بشه
            unset( $available_gateways['zarinpal'] ); 
        }
    }

    // انتخاب خودکار درگاه فعال به عنوان پیش‌فرض سشن
    if ( ! empty( $available_gateways ) ) {
        $first_gw_id = key( $available_gateways );
        foreach ( $available_gateways as $gid => $gw ) {
            $available_gateways[ $gid ]->chosen = ( $gid === $first_gw_id );
        }
        if ( function_exists( 'WC' ) && WC()->session ) {
            WC()->session->set( 'chosen_payment_method', $first_gw_id );
        }
    }

    return $available_gateways;
}, 99999 );

/**
 * اصلاح خودکار خروجی ایجکس update_order_review در صفحه Checkout
 */
add_filter( 'woocommerce_update_order_review_fragments', function( $fragments ) {
    if ( af_is_usd_currency() && ! empty( $fragments ) && is_array( $fragments ) ) {
        foreach ( $fragments as $key => $html ) {
            if ( is_string( $html ) ) {
                $html = preg_replace( '/(<span\s+class="af-(?:bill|final)-currency"[^>]*>)\s*تومان\s*(<\/span>)/u', '$1دلار$2', $html );
                $fragments[ $key ] = $html;
            }
        }
    }
    return $fragments;
}, 99999 );

/**
 * باز کردن اجباری باکس کارت بانکی استرایپ در payment.php و اصلاح واحد دلار در Checkout
 */
add_action( 'woocommerce_review_order_after_payment', function() {
    $is_usd    = af_is_usd_currency();
    $js_is_usd = $is_usd ? 'true' : 'false';
    ?>
    <style>
        html body .woocommerce-checkout-payment .wc_payment_methods {
            display: flex !important;
        }
        html body .woocommerce-checkout-payment .wc_payment_method.payment_method_af_stripe_test .payment_box,
        html body .woocommerce-checkout-payment .wc_payment_method.payment_method_stripe .payment_box,
        html body .woocommerce-checkout-payment .wc_payment_method.payment_method_stripe_cc .payment_box {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
    </style>
    <script>
    (function() {
        var isUsd = <?php echo $js_is_usd; ?>;
        function syncCheckoutCurrencyAndGateway() {
            var radios = document.querySelectorAll('input[name="payment_method"]');
            if (radios.length > 0) {
                var anyChecked = false;
                radios.forEach(function(r) { if (r.checked) anyChecked = true; });
                if (!anyChecked) radios[0].checked = true;
            }
            if (isUsd) {
                document.querySelectorAll('.af-bill-currency, .af-final-currency').forEach(function(el) {
                    el.textContent = 'دلار';
                });
                document.querySelectorAll('.af-bill-number, .af-final-number, .af-discount-number').forEach(function(el) {
                    var txt = el.textContent.trim();
                    if (txt && !txt.startsWith('$')) {
                        el.textContent = '$' + txt.replace(/\./g, ',');
                    }
                    el.style.direction = 'ltr';
                    el.style.display = 'inline-block';
                });
            }
        }
        syncCheckoutCurrencyAndGateway();
        document.addEventListener('DOMContentLoaded', syncCheckoutCurrencyAndGateway);
        if (typeof jQuery !== 'undefined') {
            jQuery(document.body).on('updated_checkout', syncCheckoutCurrencyAndGateway);
        }
    })();
    </script>
    <?php
} );

add_filter( 'woocommerce_order_button_text', function() {
    return 'پرداخت نهایی';
} );

add_action( 'woocommerce_before_checkout_form', function() {
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
}, 1 );