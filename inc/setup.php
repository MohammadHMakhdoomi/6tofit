<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function sixtofit_setup() {
    // پشتیبانی از تایتل داینامیک
    add_theme_support( 'title-tag' );

    // پشتیبانی از تصویر شاخص
    add_theme_support( 'post-thumbnails' );

    // پشتیبانی از ووکامرس
    add_theme_support( 'woocommerce' );

    // منوهای قالب
    register_nav_menus( array(
        'primary' => __( 'منوی اصلی', 'sixtofit' ),
        'footer'  => __( 'منوی فوتر', 'sixtofit' ),
    ) );

    // پشتیبانی از HTML5
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption' ) );
}
add_action( 'after_setup_theme', 'sixtofit_setup' );
