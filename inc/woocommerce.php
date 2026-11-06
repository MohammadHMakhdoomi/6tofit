<?php
/**
 * WooCommerce Compatibility for MyTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * اعلام پشتیبانی از ووکامرس
 */
function sixtofit_woocommerce_support() {
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 400,
        'single_image_width'    => 800,
        'product_grid' => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ) );
}
add_action( 'after_setup_theme', 'sixtofit_woocommerce_support' );

/**
 * حذف استایل‌های پیش‌فرض ووکامرس (در صورت نیاز)
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * بارگذاری استایل اختصاصی برای صفحات ووکامرس
 */
function sixtofit_woocommerce_styles() {
    wp_enqueue_style(
        'sixtofit-woocommerce',
        get_template_directory_uri() . '/assets/css/woocommerce.css',
        array(),
        '1.0'
    );
}
add_action( 'wp_enqueue_scripts', 'sixtofit_woocommerce_styles' );

/**
 * تغییر تعداد محصولات در هر صفحه فروشگاه
 */
add_filter( 'loop_shop_per_page', function( $cols ) {
    return 12;
}, 20 );

/**
 * تغییر تعداد ستون‌های نمایش محصولات در فروشگاه
 */
add_filter( 'loop_shop_columns', function() {
    return 4;
}, 999 );

/**
 * حذف سایدبار ووکامرس در صفحات خاص
 */



/**
 * تغییر Breadcrumb پیش‌فرض ووکامرس
 */
add_filter( 'woocommerce_breadcrumb_defaults', function( $defaults ) {
    $defaults['delimiter']   = ' » ';
    $defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb">';
    $defaults['wrap_after']  = '</nav>';
    return $defaults;
});

/**
 * سفارشی‌سازی متن "افزودن به سبد خرید"
 */
add_filter( 'woocommerce_product_add_to_cart_text', function( $text ) {
    return __( 'افزودن به سبد', 'sixtofit' );
});

/**
 * افزودن پشتیبانی از گالری محصول (زوم، لایت‌باکس و اسلایدر)
 */
function sixtofit_wc_gallery_support() {
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'sixtofit_wc_gallery_support' );

/**
 * تغییر کلاس بدنه در صفحات ووکامرس برای استایل‌دهی راحت‌تر
 */
add_filter( 'body_class', function( $classes ) {
    if ( is_woocommerce() ) {
        $classes[] = 'sixtofit-woocommerce';
    }
    return $classes;
});

/**
 * تنظیم قالب‌های ووکامرس از پوشه theme/woocommerce/
 */
function sixtofit_woocommerce_template_path() {
    return 'woocommerce/';
}