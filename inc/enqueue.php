<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function sixtofit_enqueue_scripts() {
    // استایل اصلی
    wp_enqueue_style( 'sixtofit-style', get_stylesheet_uri() );

    // استایل دلخواه
    wp_enqueue_style( 'sixtofit-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.9' );

    // اسکریپت اصلی
    wp_enqueue_script( 'sixtofit-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'sixtofit_enqueue_scripts' );
