<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<style>
  .text-section {
    width: 100%;
    margin: 60px 0;
  }
  .text-container {
    width: 80%;
    margin: 0 auto;
    text-align: right;
  }
  .text-content {
    color: #161618;
    font-size: 16px;
    line-height: 1.6;
  }
  #description {
    scroll-margin-top: 100px;
  }

  @media only screen and (max-width: 768px) {
     .text-container {
         width: 90%;
     }
  }
</style>

<section class="text-section" id="description">
  <div class="text-container">
    <div class="text-content">
      <?php
        // نمایش توضیحات کامل محصول
        the_content();
      ?>
    </div>
  </div>
</section>



<style>
  .cards-section {
    width: 100%;
}

.cards-container {
    width: 80%;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
}

.card-column {
    width: calc(50% - 24px);
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.card {
    padding: 40px;
    background-color: #FFFFFF;
    border-radius: 24px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 10px;
}



.card-title {
    font-size: 24px;
    font-weight: bold;
    color: #161618;
    text-align: right;
}

.card-divider {
    width: 100%;
    height: 1px;
    background-color: #F0F0F1;
    margin: 10px auto;
}

.card-list {
    list-style: none;
    padding-right: 25px;
    padding-top: 25px;
    margin: 0;
    color: #161618;
    font-size: 18px;
    line-height: 1.6;
    text-align: right;
}

.card-list li {
    position: relative;
    padding-right: 12px;
}

.card-list li::before {
    content: '•';
    position: absolute;
    right: 0;
    color: #000000;
    font-size: 18px;
}

/* تغییرات برای موبایل */
@media only screen and (max-width: 768px) {
    .cards-container {
        flex-direction: column;
    }

    .card-column {
        width: 100%;
    }

    .card-title {
        font-size: 20px;
    }

    .card-list {
        font-size: 16px;
       padding-right: 0px;
    }
    .cards-container{
        width:90%;
    }

    /* ترتیب کارت‌ها */
    .card-column:nth-child(1) .card:nth-child(1) {
        order: 1; /* ویژگی‌ها */
    }

    .card-column:nth-child(2) .card:nth-child(1) {
        order: 2; /* چی دریافت می‌کنی */
    }

    .card-column:nth-child(1) .card:nth-child(2) {
        order: 3; /* نتایج قابل انتظار */
    }

    .card-column:nth-child(2) .card:nth-child(2) {
        order: 4; /* انواع برنامه‌ها */
    }
}

</style>
<section class="cards-section">
  <div class="cards-container">

    <!-- ستون اول -->
    <div class="card-column">

      <!-- کارت ۱: ویژگی‌ها -->
      <div class="card">
        <div class="card-header">
          <div class="card-icon">
            <img src="http://6tofit.com/wp-content/uploads/2026/09/✨-Sparkles.png" alt="Icon 1">
          </div>
          <h2 class="card-title">ویژگی‌ها</h2>
        </div>
        <div class="card-divider"></div>
        <ul class="card-list">
          <?php if ( have_rows('product_feature') ) : ?>
            <?php while ( have_rows('product_feature') ) : the_row(); ?>
              <li><?php echo esc_html( get_sub_field('attribute_value') ); ?></li>
            <?php endwhile; ?>
          <?php endif; ?>
        </ul>
      </div>

      <!-- کارت ۲: نتایج قابل انتظار -->
      <div class="card">
        <div class="card-header">
          <div class="card-icon">
            <img src="http://6tofit.com/wp-content/uploads/2026/09/🎯-Direct-Hit.png" alt="Icon 3">
          </div>
          <h2 class="card-title">نتایج قابل انتظار</h2>
        </div>
        <div class="card-divider"></div>
        <ul class="card-list">
          <?php if ( have_rows('expected_results') ) : ?>
            <?php while ( have_rows('expected_results') ) : the_row(); ?>
              <li><?php echo esc_html( get_sub_field('expected_results_value') ); ?></li>
            <?php endwhile; ?>
          <?php endif; ?>
        </ul>
      </div>

    </div>

    <!-- ستون دوم -->
    <div class="card-column">

      <!-- کارت ۳: چی دریافت می‌کنی؟ -->
      <div class="card">
        <div class="card-header">
          <div class="card-icon">
            <img src="http://6tofit.com/wp-content/uploads/2026/09/🚩-Triangular-Flag.png" alt="Icon 2">
          </div>
          <h2 class="card-title">چی دریافت می‌کنی؟</h2>
        </div>
        <div class="card-divider"></div>
        <ul class="card-list">
          <?php if ( have_rows('what_do_you_get') ) : ?>
            <?php while ( have_rows('what_do_you_get') ) : the_row(); ?>
              <li><?php echo esc_html( get_sub_field('get_value') ); ?></li>
            <?php endwhile; ?>
          <?php endif; ?>
        </ul>
      </div>

      <!-- کارت ۴: انواع برنامه‌ها -->
      <div class="card">
        <div class="card-header">
          <div class="card-icon">
            <img src="http://6tofit.com/wp-content/uploads/2026/09/📋-Clipboard.png" alt="Icon 4">
          </div>
          <h2 class="card-title">انواع برنامه‌ها</h2>
        </div>
        <div class="card-divider"></div>
        <ul class="card-list">
          <?php if ( have_rows('types_of_programs') ) : ?>
            <?php while ( have_rows('types_of_programs') ) : the_row(); ?>
              <li><?php echo esc_html( get_sub_field('types_of_programs_value') ); ?></li>
            <?php endwhile; ?>
          <?php endif; ?>
        </ul>
      </div>

    </div>

  </div>
</section>


<style>
.services-section {
    width: 100%;
    margin-top: 200px;
    margin-bottom: 100px;
}

.services-container {
    width: 80%;
    margin: 0 auto;
}

.services-title {
    padding: 30px 0;
    text-align: right;
}

.services-title h2 {
    font-size: 30px;
    font-weight: 500;
    color: #000000;
    margin: 0;
}

.cards-row {
    display: flex;
    gap: 24px;
}

.service-card {
    flex: 1;
    padding: 24px;
    background-color: #FFFFFF;
    border-radius: 24px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    cursor: pointer;
}

.service-card:has(input[type="checkbox"]:checked) {
    border: 1px solid #5247FF;
    border-radius: 24px;
}

.checkbox-row {
    display: flex;
    align-items: center;
    gap: 8px;
}

.checkbox-row input[type="checkbox"] {
    width: 18px;
    height: 18px;
    border: 1.5px solid #5247FF;
    border-radius: 4px;
    appearance: none;
    cursor: pointer;
    position: relative;
}

.checkbox-row input[type="checkbox"]:checked {
    background-color: #5247FF;
}

.checkbox-row input[type="checkbox"]:checked::before {
    content: '✔';
    color: #FFFFFF;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 12px;
}

.checkbox-text {
    font-size: 18px;
    color: #000000;
}

.description-text {
    font-size: 12px;
    color: #65656D;
    margin-top: 8px;
    padding-right: 20px;
}

.price-row {
    margin-top: 20px;
    text-align: right;
    padding-right: 20px;
}

.price-plus {
    color: #5247FF;
    font-size: 18px;
}

.price-text {
    font-size: 12px;
    color: #000000;
}

#services {
    scroll-margin-top: 100px;
}

/* تغییرات برای موبایل */
@media only screen and (max-width: 768px) {
    .services-container {
        width: 90%;
    }

    .services-title h2 {
        font-size: 24px;
    }
    .services-section {
        margin-top: 100px;
}

    .cards-row {
        flex-direction: column;
        gap: 24px;
    }

    .service-card {
        width: 100%;
    }

    .checkbox-text {
        font-size: 18px;
    }

    .description-text {
        font-size: 12px;
    }

    .price-text {
        font-size: 18px;
    }

    .price-text span {
        font-size: 12px;
    }
}
</style>
<?php
global $product;

$addons = get_post_meta( $product->get_id(), '_product_addons', true );
if ( ! is_array( $addons ) || empty( $addons ) ) {
	return;
}
?>

<section class="services-section" id="services">
  <div class="services-container">
    <div class="services-title">
      <h2>خدمات پرو</h2>
    </div>
    <div class="cards-row">
      <?php foreach ( $addons as $index => $addon ) : 
        $title       = esc_html( $addon['title'] ?? '' );
        $description = esc_html( $addon['description'] ?? '' );
        $price       = floatval( $addon['price'] ?? 0 );
        $price_html  = number_format( $price, 0, '', '.' );
      ?>
        <div class="service-card" data-addon-index="<?php echo esc_attr( $index ); ?>" data-addon-price="<?php echo esc_attr( $price ); ?>">
          <div class="service-card-content">
            <div class="checkbox-row">
              <!-- چک‌باکس فقط برای ایرانی‌ها نمایش داده می‌شه -->
              <input type="checkbox" 
                     id="addon_<?php echo esc_attr( $index ); ?>" 
                     name="selected_addons[]" 
                     value="<?php echo esc_attr( $index ); ?>"
                     class="addon-checkbox"
                     data-price="<?php echo esc_attr( $price ); ?>">
              <label for="addon_<?php echo esc_attr( $index ); ?>" class="checkbox-text"><?php echo $title; ?></label>
            </div>
            <div class="description-text"><?php echo $description; ?></div>
            <div class="price-row">
              <span class="price-text"><?php echo $price_html; ?> <span style="color: #65656D;">تومان</span></span>
              <span class="price-plus">+</span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {

  const userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
  const isIranian = userTimeZone === 'Asia/Tehran';

  const checkboxes = document.querySelectorAll('.addon-checkbox');
  const serviceCards = document.querySelectorAll('.service-card');

  if (isIranian) {
    // ===== کاربران ایرانی =====
    // چک‌باکس‌ها نمایش داده می‌شن و قابل انتخاب هستن

    // کلیک روی کل کارت = تoggle چک‌باکس
    serviceCards.forEach(card => {
      card.addEventListener('click', function (e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'LABEL') return;

        const checkbox = this.querySelector('.addon-checkbox');
        if (checkbox) {
          checkbox.checked = !checkbox.checked;
          checkbox.dispatchEvent(new Event('change'));
        }
      });
    });

  } else {
    // ===== کاربران خارجی =====
    // چک‌باکس‌ها مخفی می‌شن ولی همه انتخاب‌شده باقی می‌مونن
    checkboxes.forEach(cb => {
      cb.checked = true;
      cb.style.display = 'none';           // مخفی کردن چک‌باکس
    });

    // لیبل رو هم کمی تنظیم می‌کنیم که فاصله درست باشه
    document.querySelectorAll('.checkbox-row label').forEach(label => {
      label.style.marginRight = '0';
    });
  }

  // محاسبه قیمت لحظه‌ای (برای هر دو گروه کار می‌کنه)
  function updateTotalPrice() {
    const basePriceEl = document.querySelector('.sticky-footer .total-price');
    if (!basePriceEl) return;

    const sticky = document.querySelector('.sticky-footer');
    const basePrice = parseFloat(sticky?.dataset.basePrice || 0);

    let addonsTotal = 0;
    document.querySelectorAll('.addon-checkbox:checked').forEach(cb => {
      addonsTotal += parseFloat(cb.dataset.price || 0);
    });

    const finalPrice = basePrice + addonsTotal;
    const formatted = finalPrice.toLocaleString('fa-IR').replace(/٬/g, '.');
    basePriceEl.innerHTML = formatted;
  }
function syncSelectedAddons() {

    const selected = [];

    document.querySelectorAll('.addon-checkbox:checked').forEach(cb => {

        const index = parseInt(cb.value, 10);

        if (!isNaN(index)) {
            selected.push(index);
        }

    });

    window.afAuthState = window.afAuthState || {};

    window.afAuthState.selectedAddons = selected;

    console.log('Selected Addons:', selected);
}
  // لیسنر تغییر (فقط برای ایرانی‌ها معنی داره)
checkboxes.forEach(cb => {

    cb.addEventListener('change', function () {

        updateTotalPrice();

        syncSelectedAddons();

    });

});

  // محاسبه اولیه
  updateTotalPrice();

syncSelectedAddons();
});
</script>

<style>
  .testimonials-section {
    width: 100%;
    background-color: #FFFFFF;
    margin-bottom: 150px;
}

.testimonials-container {
    width: 80%;
    margin: 0 auto;
    margin-bottom: 100px;
	    padding-top: 50px;
    padding-bottom: 50px;
}

.testimonials-title {
    margin: 0px 0 20px;
    text-align: right;
}

.testimonials-title h2 {
    font-size: 30px;
    font-weight: 500;
    color: #000000;
    margin: 0;
}

.slider-container {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.slider {
    display: flex;
    width: 100%;
    height: 100%;
    transition: transform 0.5s ease-in-out;
}

.slide {
    padding-top: 50px;
    flex: 0 0 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.slide img {
    width: 100%;
    height: 500px;
    object-fit: contain;
}

.slide-text {
    font-size: 16px;
    font-weight: 400;
    color: #000000;
    text-align: center;
    margin-top: 10px;
}

.slider-prev,
.slider-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
}

.slider-prev {
    left: 10px;
}

.slider-next {
    right: 10px;
}

.slider-prev img,
.slider-next img {
    width: 40px;
    height: 40px;
}

#testimonials {
    scroll-margin-top: 100px;
}

/* تغییرات برای موبایل */
@media only screen and (max-width: 768px) {
    .testimonials-title h2 {
        font-size: 24px;
        
    }
      .testimonials-section {
    width: 100%;
    background-color: #FFFFFF;
    margin-bottom:60px;
}
.testimonials-title{
    margin: 50px 0 10px;
}
    .slide-text {
        font-size: 20px;
    }

    .slider-prev img,
    .slider-next img {
        width: 36px;
        height: 36px;
    }

    .slide img {
        height: auto;
    }
}
</style>
<section class="testimonials-section" id="testimonials">
  <div class="testimonials-container">
    <div class="testimonials-title">
      <h2>تجربه کاربران قبلی</h2>
    </div>

    <?php if ( have_rows('previous_user_experience') ) : ?>
      <div class="slider-container">
        <div class="slider">

          <?php while ( have_rows('previous_user_experience') ) : the_row(); 
            $image = get_sub_field('user_experience_image');
            $text  = get_sub_field('explaining_the_user_experience');

            // اگر فیلد تصویر از نوع Image باشه و آرایه برگردونه
            $image_url = is_array($image) ? $image['url'] : $image;
          ?>
            <div class="slide">
              <?php if ( $image_url ) : ?>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($text); ?>">
              <?php endif; ?>
              
              <?php if ( $text ) : ?>
                <div class="slide-text"><?php echo esc_html($text); ?></div>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>

        </div>

        <div class="slider-prev" onclick="moveSlide(-1)">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/products/IconButtonL.svg" alt="Previous">
        </div> 
        <div class="slider-next" onclick="moveSlide(1)">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/products/IconButtonR.svg" alt="Next">
        </div>
      </div>
    <?php endif; ?>

  </div>
</section>

<script>
  let currentSlide = 0;
  const slides = document.querySelectorAll('.slide');
  const slider = document.querySelector('.slider');

  function moveSlide(direction) {
    if (!slides.length) return;
    currentSlide = (currentSlide + direction + slides.length) % slides.length;
    slider.style.transform = `translateX(-${currentSlide * 100}%)`;
  }
</script>



<style>
  .content-section {
    width: 100%;
}

.content-container {
    width: 80%;
    margin: 0 auto;
    display: flex;
    gap: 24px;
}

.column-left,
.column-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.column-left {
    gap: 24px;
}

.card {
    width: 100%;
    background-color: #FFFFFF;
    border-radius: 24px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.column-right .card {
    padding: 24px;
    padding-bottom: 5px;
}

.column-right .card img {
    width: 211px;
    height: 435px;
    object-fit: contain;
}

.column-right .card .main-gallery-img {
    display: none;
}

.column-right .card .main-gallery-img.active {
    display: inline-block;
}

.card-audio {
    padding: 24px;
}

.audio-player {
    background-color: #000000;
    padding: 16px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}


.audio-player img {
    width: 32px;
    height: 32px;
    cursor: pointer;
}

.audio-timer {
    color: #FFFFFF;
    font-size: 14px;
    min-width: 60px;
}

.audio-waveform {
    flex: 1;
    height: 32px;
    display: flex;
    align-items: center;
}

.audio-waveform canvas {
    width: 100%;
    height: 100%;
}

.card-audio-text {
    font-size: 16px;
    color: #000000;
    margin-top: 16px;
}

.cards-row {
    display: flex;
    gap: 24px;
    width: 100%;
}

.cards-row .card {
    flex: 1;
    padding: 24px;
}

.cards-row .card img {
    width: 80px;
    height: 80px;
    object-fit: contain;
}

.cards-row .card-text {
    font-size: 16px;
    color: #000000;
    margin-top: 16px;
}
.programe-title h2{
    text-align: right;
    font-size: 30px;
    font-weight: 500;
    margin: 0;
}
#programe {
    scroll-margin-top: 100px;
}
.column-right .card {
    position: relative;
}

/* تغییرات برای موبایل */
@media only screen and (max-width: 768px) {
    .content-container {
        flex-direction: column;
        width: 90%;
    }

    .column-left,
    .column-right {
        width: 100%;
    }

.column-right .card img {
    height: 364px;
}

.column-right .card .main-gallery-img {
    height: 364px;
}

.column-right .card .main-gallery-img.active {
    display: inline-block;
}

    .cards-row {
        flex-direction: column;
        gap: 24px;
    }

    .cards-row .card {
        display: flex;
        align-items: center;
        gap: 16px;
        text-align: right;
        padding: 16px;
    }

    .cards-row .card img {
        width: 80px;
        height: 80px;
    }

    .cards-row .card-text {
        font-size: 16px;
    }

    .card-audio-text {
        font-size: 16px;
    }

    .programe-title h2 {
        font-size: 24px;
    }
}
/* تصاویر گالری */
.column-right .card {
    position: relative;
}

.column-right .card .main-gallery-img {
    width: 211px;
    height: 435px;
    object-fit: contain;
    display: none;
	    margin-bottom: 10px;
}

.column-right .card .main-gallery-img.active {
    display: inline-block;
}
   /* اسلایدر ناوبری (Navigation) */
        .slider-nav {
            position: absolute;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            width: 105px;
            padding: 1px;
            align-items: center;
            gap: 12px;
            border-radius: 1000000px;
            background: rgba(255, 255, 255, 0.50);
            backdrop-filter: blur(6px);
        }

        /* نقطه‌های ناوبری */
        .nav-dot {
            width: 12px;
            height: 12px;
            flex-shrink: 0;
            border-radius: 50%;
            background: rgba(13, 13, 13, 0.40);
            cursor: pointer;
            transition: all 0.3s;
        }

        /* نقطه فعال */
        .nav-dot.active {
            flex: 1 0 0;
            border-radius: 12px;
            background: rgba(13, 13, 13, 0.40);
        }
</style>
<section style="width: 100%;">
  <div style="width: 80%; margin: 0 auto; margin-bottom: 50px;">
    <div class="programe-title" id="programe">
      <h2>
        نمونه برنامه
      </h2>
    </div>
  </div>
</section>

<section class="content-section">
  <div class="content-container">

<!-- ستون راست: کارت اصلی -->

<div class="column-right">

  <div class="card">


<?php

$images = get_field('sample_app_gallery');

// اگر هیچ تصویری وجود نداشت
if (empty($images)) {
    return;
}

// اگر مقدار آرایه نبود، تبدیلش می‌کنیم به آرایه
if (!is_array($images)) {
    $images = [$images];
}

// حذف تصاویر خالی
$images = array_values(array_filter($images));

// تعداد تصاویر
$count = count($images);

// --------------------------------------------------
// فقط یک تصویر
// --------------------------------------------------
if ($count === 1) {

    $first = $images[0];

    $img_url = is_array($first)
        ? ($first['url'] ?? '')
        : $first;

    if ($img_url) :
?>

        <img
            src="<?php echo esc_url($img_url); ?>"
            alt="Sample App Gallery"
            class="main-gallery-img active"
        >

<?php
    endif;

// --------------------------------------------------
// بیشتر از یک تصویر = اسلایدر
// --------------------------------------------------
} else {
?>

    <?php foreach ($images as $index => $img) :

        $img_url = is_array($img)
            ? ($img['url'] ?? '')
            : $img;

        if (!$img_url) {
            continue;
        }
    ?>

        <img
            src="<?php echo esc_url($img_url); ?>"
            alt="Sample App Gallery"
            class="main-gallery-img <?php echo ($index === 0) ? 'active' : ''; ?>"
        >

    <?php endforeach; ?>


    <!-- ناو اسلایدر -->
    <div class="slider-nav">

        <?php foreach ($images as $index => $img) :

            $img_url = is_array($img)
                ? ($img['url'] ?? '')
                : $img;

            if (!$img_url) {
                continue;
            }
        ?>

            <span
                class="nav-dot <?php echo ($index === 0) ? 'active' : ''; ?>"
                data-index="<?php echo $index; ?>"
            ></span>

        <?php endforeach; ?>

    </div>


    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const slides = document.querySelectorAll('.main-gallery-img');
        const navDots = document.querySelectorAll('.nav-dot');

        // اگر اسلایدی وجود نداشت
        if (!slides.length) {
            return;
        }

        let currentSlide = 0;

        // نمایش یک اسلاید
        function showSlide(index) {

            // همه تصاویر مخفی شوند
            slides.forEach(function (slide) {
                slide.classList.remove('active');
            });

            // همه ناوها غیرفعال شوند
            navDots.forEach(function (dot) {
                dot.classList.remove('active');
            });

            // تصویر فعلی نمایش داده شود
            if (slides[index]) {
                slides[index].classList.add('active');
            }

            // ناو مربوط به تصویر فعلی فعال شود
            if (navDots[index]) {
                navDots[index].classList.add('active');
            }
        }


        // کلیک روی ناوهای اسلایدر
        navDots.forEach(function (dot, index) {

            dot.addEventListener('click', function () {

                currentSlide = index;

                showSlide(currentSlide);

            });

        });


        // تغییر خودکار هر ۵ ثانیه
        setInterval(function () {

            currentSlide++;

            if (currentSlide >= slides.length) {
                currentSlide = 0;
            }

            showSlide(currentSlide);

        }, 5000);


        // نمایش اسلاید اول
        showSlide(0);

    });
    </script>

<?php
}

?>

  </div>

</div>


    <!-- ستون چپ -->
    <div class="column-left">
     <!-- کارت دوم: ویس یا تصویر -->
<!-- کارت دوم: ویس یا تصویر -->
<div class="card card-audio">
  <?php
  $media_type = get_field('audio_or_video');   // <--- تغییر اینجا
  $media_file = get_field('card_audio_file');
  $image      = get_field('second_card_image');
  $description = get_field('second_card_description');

  // ==================== ویس (صوت) ====================
  if ($media_type === 'audio' && $media_file) {
    $audio_url = is_array($media_file) ? ($media_file['url'] ?? '') : $media_file;

    if ($audio_url) :
  ?>
    <div class="audio-player">
      <div class="audio-waveform">
        <canvas id="waveform"></canvas>
      </div>
      <div class="audio-timer" id="audio-timer">0:00 / 0:30</div>
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/products/Iconvoic.svg" alt="Play Icon" id="play-btn">
    </div>
    <audio id="audio1" src="<?php echo esc_url($audio_url); ?>"></audio>
  <?php 
    endif;
  }
  // ==================== تصویر ====================
  elseif ($media_type === 'image' && $image) {
    $img_url = is_array($image) ? ($image['url'] ?? '') : $image;

    if ($img_url) :
  ?>
      <img src="<?php echo esc_url($img_url); ?>" alt="Second Card Image">
  <?php 
    endif;
  }
  ?>
  
  <?php if ($description) : ?>
    <p class="card-audio-text"><?php echo esc_html($description); ?></p>
  <?php endif; ?>
</div>

      <!-- کارت سوم -->
      <div class="cards-row">
        <div class="card">
          <?php
          $third_img = get_field('third_card_image');
          $third_url = is_array($third_img) ? ($third_img['url'] ?? '') : $third_img;
          if ($third_url) :
          ?>
            <img src="<?php echo esc_url($third_url); ?>" alt="Card Image 1">
          <?php endif; ?>
          <p class="card-text"><?php echo esc_html(get_field('text_of_the_third_card')); ?></p>
        </div>

        <!-- کارت چهارم -->
        <div class="card">
          <?php
          $fourth_img = get_field('image_of_the_fourth_card');
          $fourth_url = is_array($fourth_img) ? ($fourth_img['url'] ?? '') : $fourth_img;
          if ($fourth_url) :
          ?>
            <img src="<?php echo esc_url($fourth_url); ?>" alt="Card Image 2">
          <?php endif; ?>
          <p class="card-text"><?php echo esc_html(get_field('text_of_the_fourth_card')); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function () {

  const audio = document.getElementById('audio1');
  const playBtn = document.getElementById('play-btn');
  const timer = document.getElementById('audio-timer');
  const canvas = document.getElementById('waveform');

  // اگر پلیر صوتی در این صفحه وجود ندارد، هیچ کاری نکن
  if (!audio || !playBtn || !timer || !canvas) {
    return;
  }

  // حالا مطمئن هستیم Canvas وجود دارد
  const ctx = canvas.getContext('2d');

  let audioContext;
  let analyser;
  let dataArray;
  let bufferLength;
  let animationFrame;

  function initAudio() {

    audioContext = new (window.AudioContext || window.webkitAudioContext)();

    analyser = audioContext.createAnalyser();

    const source = audioContext.createMediaElementSource(audio);

    source.connect(analyser);
    analyser.connect(audioContext.destination);

    analyser.fftSize = 256;

    bufferLength = analyser.frequencyBinCount;

    dataArray = new Uint8Array(bufferLength);

    canvas.width = canvas.parentElement.clientWidth;
    canvas.height = 32;
  }


  function drawWaveform() {

    animationFrame = requestAnimationFrame(drawWaveform);

    analyser.getByteTimeDomainData(dataArray);

    ctx.clearRect(
      0,
      0,
      canvas.width,
      canvas.height
    );

    const sliceWidth = canvas.width / bufferLength;

    let x = 0;

    const currentTime = audio.currentTime;
    const duration = audio.duration || 30;

    const highlightPoint =
      (currentTime / duration) * bufferLength;


    for (let i = 0; i < bufferLength; i++) {

      const v = dataArray[i] / 128.0;

      const y = (v * canvas.height) / 2;

      ctx.fillStyle =
        i < highlightPoint
          ? '#CCCCCC'
          : '#666666';

      ctx.fillRect(
        x,
        canvas.height / 2 - y / 2,
        sliceWidth - 1,
        y
      );

      x += sliceWidth;
    }
  }


  playBtn.addEventListener('click', function () {

    if (audio.paused) {

      if (!audioContext) {
        initAudio();
      }

      // برای بعضی مرورگرها لازم است AudioContext فعال شود
      if (audioContext.state === 'suspended') {
        audioContext.resume();
      }

      audio.play();

      playBtn.src =
        '<?php echo get_template_directory_uri(); ?>/assets/img/products/Iconvoic.svg';

      drawWaveform();

    } else {

      audio.pause();

      playBtn.src =
        '<?php echo get_template_directory_uri(); ?>/assets/img/products/Iconvoic.svg';

      if (animationFrame) {
        cancelAnimationFrame(animationFrame);
      }
    }
  });


  audio.addEventListener('timeupdate', function () {

    const current = Math.floor(audio.currentTime);

    const duration =
      Math.floor(audio.duration || 30);

    const currentMin =
      Math.floor(current / 60);

    const currentSec =
      current % 60;

    const durationMin =
      Math.floor(duration / 60);

    const durationSec =
      duration % 60;

    timer.textContent =
      `${currentMin}:${currentSec.toString().padStart(2, '0')} / ${durationMin}:${durationSec.toString().padStart(2, '0')}`;
  });


  audio.addEventListener('ended', function () {

    playBtn.src =
      '<?php echo get_template_directory_uri(); ?>/assets/img/products/Iconvoic.svg';

    if (animationFrame) {
      cancelAnimationFrame(animationFrame);
    }
  });

});
</script>




<style>
  .cta-section {
    width: 100%;
    margin: 100px 0;
}

.cta-container {
    width: 80%;
    margin: 0 auto;
}

.cta-title {
    text-align: right;
}

.cta-title h2 {
    font-size: 30px;
    font-weight: 500;
    color: #000000;
    margin: 0 0 24px;
}

.cta-cards {
    display: flex;
    gap: 24px;
}

.cta-card {
    flex: 1;
    background-color: #e6e6f3a1;
    border-radius: 24px;
    padding: 32px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.cta-card img {
    width: 120px;
    height: 120px;
    object-fit: contain;
    margin-bottom: 16px;
}

.cta-card h2 {
    font-size: 30px;
    font-weight: 500;
    color: #000000;
    margin: 0 0 15px;
}

.cta-card p {
    font-size: 16px;
    color: #000000;
    margin: 15px 0;
    margin-bottom: 25px;
}

.cta-button {
    background: none;
    border: none;
    font-size: 16px;
    color: #5247FF;
    cursor: pointer;
    display: inline-flex;
    gap: 8px;

}

.cta-button img {
    width: 20px;
    height: 20px;
    vertical-align: middle;
}

#cta {
    scroll-margin-top: 100px;
}

/* تغییرات برای موبایل */
@media only screen and (max-width: 768px) {
    .cta-container {
        width: 90%;
    }

    .cta-title h2 {
        font-size: 24px;
    }

    .cta-cards {
        flex-direction: column;
        gap: 24px;
    }

    .cta-card {
        width: 100%;
    }

    .cta-card h2 {
        font-size: 24px;
    }

    .cta-card p {
        font-size: 14px;
    }

    .cta-button {
        font-size: 16px;
    }
}
</style>
<section class="cta-section" id="cta">
  <div class="cta-container">
    <div class="cta-title">
      <h2>انتخاب بهتر با</h2>
    </div>
    <div class="cta-cards">
      <div class="cta-card">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/products/Mobilepng.png" alt="Card Image 1">
        <h2>پرسشنامه هوشمند</h2>
        <p>با پاسخ به چند سوال در پرسشنامه هوشمند، مناسب‌ترین برنامه براساس نیازهایتان را به شما پیشنهاد می‌کنیم</p>
<button class="cta-button" onclick="AFQuestionnaire.open()">
  از اینجا شروع کنید
  <img src="<?php echo get_template_directory_uri(); ?>/assets/img/products/ArrowLeft2.svg" alt="Button Icon">
</button>
      </div>
      <div class="cta-card">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/products/Headphonepng.png" alt="Card Image 2">
        <h2>مشاوره رایگان</h2>
        <p>برای دریافت مشاوره رایگان، کافیست درخواست خود را ثبت کنید. پس از ثبت درخواست متخصصان ما با شما ارتباط خواهند گرفت.</p>
        <button class="cta-button" onclick="showFreeHeaderConsultationPopup()">
          ثبت درخواست
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/products/ArrowLeft2.svg" alt="Button Icon">
        </button>
        
      </div>
    </div>
  </div>
</section>




<style>
  .faq-section {
    width: 100%;
    margin-top: 180px;
    margin-bottom: 200px;
}

.faq-container {
    width: 80%;
    margin: 0 auto;
}

.faq-title {
    padding: 30px 0;
    text-align: right;
}

.faq-title h2 {
    font-size: 30px;
    font-weight: 500;
    color: #000000;
    margin: 0;
}

.faq-cards {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.faq-card {
    background-color: #FFFFFF;
    border-radius: 24px;
    padding: 18px 19px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.faq-question {
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
}

.faq-question-text {
    font-size: 18px;
    font-weight: 500;
    color: #000000;
    text-align: right;
}

.faq-icon img {
    width: 24px;
    height: 24px;
}

.faq-answer {
    display: none;
    font-size: 14px;
    color: #65656D;
    text-align: right;
    margin-top: 10px;
}

.faq-card.active .faq-answer {
    display: block;
}

.faq-card.active .faq-icon img.closed {
    display: none;
}

.faq-card.active .faq-icon img.open {
    display: inline;
}

.faq-icon img.open {
    display: none;
}

#faq {
    scroll-margin-top: 100px;
}

/* تغییرات برای موبایل */
@media only screen and (max-width: 768px) {
    .faq-container {
        width: 90%;
    }

    .faq-title h2 {
        font-size: 24px;
    }

    .faq-question-text {
        font-size: 15px;
    }
    .faq-section{
        margin-top: 80px;
    margin-bottom: 300px;
    }
}
</style>
<section class="faq-section" id="faq">
  <div class="faq-container">
    <div class="faq-title">
      <h2>سوالات متداول</h2>
    </div>

    <div class="faq-cards">
      <?php if (have_rows('faq_about_products')) : ?>
        <?php while (have_rows('faq_about_products')) : the_row(); ?>

          <div class="faq-card">
            <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
              <div class="faq-question-text">
                <?php echo esc_html(get_sub_field('question')); ?>
              </div>
              <div class="faq-icon">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/products/Arrowfaqop.svg" 
                     alt="Closed Icon" class="closed">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/products/Arrowfaqcl.svg" 
                     alt="Open Icon" class="open">
              </div>
            </div>

            <div class="faq-answer">
              <?php echo wp_kses_post(get_sub_field('answer')); ?>
            </div>
          </div>

        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>
</section>