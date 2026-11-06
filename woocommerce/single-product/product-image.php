<?php
/**
 * Single Product Image
 *
 * @package WooCommerce\Templates
 * @version 10.5.0
 */

use Automattic\WooCommerce\Enums\ProductType;

defined( 'ABSPATH' ) || exit;

// اگر تابع ووکامرس وجود نداشت (برای compatibility قدیمی)
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

// گرفتن اسم محصول (حتی اگر theme override داشته باشه)
$product_name = $product->get_name(); // این خط خیلی قوی‌تر و مطمئن‌تره

$post_thumbnail_id = $product->get_image_id();
$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );

$wrapper_classes = apply_filters(
    'woocommerce_single_product_image_gallery_classes',
    array(
        'woocommerce-product-gallery',
        'woocommerce-product-gallery--' . ($post_thumbnail_id ? 'with-images' : 'without-images'),
        'woocommerce-product-gallery--columns-' . absint( $columns ),
        'images',
    )
);
?>
<main>





<section class="hero-section">
<!-- جایگزین کامل کد breadcrumb قبلی (بعد از get_header) -->
<div class="breadcrumb" style="width: 80%; margin: 0 auto; margin-top: 40px; margin-bottom: 40px; text-align: right; display: flex; align-items: center; gap: 12px; font-family: 'IranYekan', sans-serif;">

    <!-- خانه -->
    <div style="display: flex; align-items: center; gap: 12px;">

        <a href="<?php echo esc_url(home_url('/')); ?>" 
           style="color: #65656D; text-decoration: none; font-size: 16px; font-weight: 400; transition: color 0.3s;">
            خانه
        </a>

        <img 
            src="http://6tofit.com/wp-content/uploads/2025/10/brudic.svg"
            alt="/"
            width="16"
            height="16"
            style="vertical-align: middle;"
        >

    </div>

    <!-- محصولات -->
    <div style="display: flex; align-items: center; gap: 12px;">

        <a href="<?php echo esc_url(home_url('/products/')); ?>" 
           style="color: #65656D; text-decoration: none; font-size: 16px; font-weight: 400; transition: color 0.3s;">
            محصولات
        </a>

        <img 
            src="http://6tofit.com/wp-content/uploads/2025/10/brudic.svg"
            alt="/"
            width="16"
            height="16"
            style="vertical-align: middle;"
        >

    </div>

   <!-- نام محصول -->
<div style="display: flex; align-items: center; gap: 12px;">

    <span id="product-breadcrumb-title"
          style="color: #161618; font-size: 16px; font-weight: 400;">
        <?php echo esc_html( $product_name ); ?>
    </span>

</div>

</div>

<style>
.breadcrumb img {
    width: 16px;
    height: 16px;
    object-fit: contain;
    flex-shrink: 0;
}
</style>

</div>
  <div class="hero-container">
    <h1 class="hero-title"> <?php echo esc_html( $product_name ); ?></h1>
    <p class="hero-text">۱۰۰۰+ نفر در حال استفاده از <?php echo esc_html( $product_name ); ?> سیکس‌توفیت!</p>
  </div>
</section>

<style>
.header-spacer {
    height: 99px;
    width: 100%;
}

.hero-section {
    width: 100%;
    margin-top: 100px;
    margin-bottom: 40px;
}

.hero-container {
    width: 80%;
    margin: 0 auto;
    text-align: right;
}

.hero-title {
    color: #000000;
    font-size: 44px;
    margin: 0;
    font-weight: 500;
}

.hero-text {
    font-size: 20px;
    margin-top: 10px;
    background: linear-gradient(to right, #E64910, #F51E55, #DE39B3, #C64CDB, #0083EB);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

@media only screen and (max-width: 768px) {
    .hero-section {
        margin-top: 50px;
    }
    .hero-title {
        font-size: 28px;
        margin-bottom: 50px;
    }
    .hero-text {
        font-size: 16px;
    }
}
</style>


<style>
 .video-section {
    width: 100%;
    height: 100vh;
}

.video-container {
    position: relative;
    width: 100%;
    height: 100%;
}

.video-player {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    cursor: pointer;
}

.play-icon {
    position: absolute;
    top: 70px;
    right: 50px;
    cursor: pointer;
    z-index: 10;
}

.play-icon img {
    width: 64px;
    height: 64px;
}

/* تغییرات برای موبایل */
@media only screen and (max-width: 768px) {
    .video-section {
        height: 480px;
    }

    .play-icon {
        top: 30px;
        right: 30px;
    }

    .play-icon img {
        width: 48px;
        height: 48px;
    }
}
</style>

<?php
$video_cover = get_field('video_cover');
$product_video = get_field('product_video');

// چون گفتی هر دو آرایه هستن و لینک برمی‌گردونن
$cover_url = is_array($video_cover) ? ($video_cover['url'] ?? '') : $video_cover;
$video_url = is_array($product_video) ? ($product_video['url'] ?? '') : $product_video;
?>

<?php if ($video_url) : ?>
<section class="video-section">
  <div class="video-container">
    <video class="video-player" 
           poster="<?php echo esc_url($cover_url); ?>" 
           onclick="this.paused ? this.play() : this.pause();">
      <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
      Your browser does not support the video tag.
    </video>
    
    <a href="#" class="play-icon" onclick="document.querySelector('.video-player').play(); this.style.display='none'; return false;">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/products/IconButton.svg" alt="Play Icon">
    </a>
  </div>
</section>
<?php endif; ?>

