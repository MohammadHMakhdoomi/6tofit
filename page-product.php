<?php
/* Template Name: صفحه پروداکت */

// CIP is an independent product line; create parent SKU S2F-CIP.
// Override product ID or URLs here when your WordPress slugs differ.
$cip_catalog = apply_filters('six2fit_cip_catalog_settings', array(
    'product_id' => 0,
    'sku' => 'S2F-CIP',
    'details_url' => home_url('/cip/'),
    'assessment_url' => home_url('/consultation/'),
));
$cip_product_id = absint($cip_catalog['product_id']);
if (!$cip_product_id && function_exists('wc_get_product_id_by_sku')) {
    $cip_product_id = wc_get_product_id_by_sku($cip_catalog['sku']);
}
$cip_catalog_product = $cip_product_id ? wc_get_product($cip_product_id) : false;
// Do not expose prices from an unpublished product.
if ($cip_catalog_product && $cip_catalog_product->get_status() !== 'publish') {
    $cip_catalog_product = false;
}
$cip_catalog_price = '';
if ($cip_catalog_product) {
    if ($cip_catalog_product->is_type('variable')) {
        // WooCommerce display prices retain tax rules and currency-plugin filters.
        $cip_prices = $cip_catalog_product->get_variation_prices(true);
        if (!empty($cip_prices['price'])) {
            $cip_catalog_price = wc_price(min($cip_prices['price']));
        }
    } elseif ($cip_catalog_product->get_price() !== '') {
        $cip_catalog_price = wc_price(wc_get_price_to_display($cip_catalog_product));
    }
}

get_header('product');
include __DIR__ . '/template-parts/consultation-popup.php';
?>
<style>
  .product-section {
    width: 100%;
    padding: 80px 0;
    margin-top: 80px;
  }

  .product-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .product-title {
    font-size: 44px;
    font-weight: 500;
    color: #161618;
    text-align: right;
    margin: 0 0 60px 0;
    line-height: 1.2;
  }

  .products-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
  }

  .product-card {
    background-color: #FFFFFF;
    border-radius: 24px;
    box-shadow: 0px 0px 3px 0px #0000000F;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 30px;
    text-align: center;
    position: relative;
  }

  .product-card.special {
    box-shadow: 0px 0px 15px 0px #0000000F;
  }

  .special-badge {
    position: absolute;
    top: 15px;
    right: 8px;
    display: flex;
    align-items: center;
    gap: 4px;
    background-color: #FFFFFF;
    border-radius: 12px;
    padding: 4px 8px;
    font-size: 12px;
    font-weight: 700;
    color: #5247FF;
    z-index: 1;
  }

  .special-badge img {
    width: 16px;
    height: 16px;
  }

  .product-icon {
    margin-bottom: 20px;
  }

  .product-card-title {
    font-size: 30px;
    font-weight: 500;
    color: #161618;
    margin: 0 0 20px 0;
    line-height: 1.3;
  }

  .product-tags {
    display: flex;
    justify-content: center;
    gap: 4px;
    margin-bottom: 20px;
    flex-wrap: wrap;
  }

  .product-tag {
    background-color: #F0F0F1;
    border-radius: 10000px;
    padding: 6px 8px;
    font-size: 12px;
    font-weight: 400;
    color: #161618;
  }

  .product-price {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 30px;
    font-size: 20px;
    font-weight: 500;
  }

  .price-from {
    color: #65656D;
  }

  .price-amount {
    color: #161618;
    direction: ltr;
    display: inline-block;
  }

  .price-currency {
    color: #65656D;
  }

  .product-buttons {
    display: flex;
    gap: 16px;
    width: 100%;
    justify-content: center;
  }

  .product-btn {
    border-radius: 100px;
    padding: 12px 10px;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.3s ease;
    border: none;
    text-align: center;
    min-width: 120px;
  }

  .product-btn-details {
    background-color: #5247FF;
    color: #FFFFFF;
  }

  .product-btn-details:hover {
    background-color: #4239D0;
  }

  .product-btn-buy {
    background-color: #FFFFFF;
    color: #5247FF;
    border: 1px solid #5247FF;
  }

  .product-btn-buy:hover {
    background-color: #F0F0F1;
  }

  /* موبایل */
  @media only screen and (max-width: 768px) {
    .product-section {
      padding: 40px 0;
    }

    .product-title {
      font-size: 32px;
      text-align: center;
      display: none;
    }

    .products-grid {
      grid-template-columns: 1fr;
      gap: 20px;
    }

    .product-card {
      height: auto;
      padding: 30px 20px;
    }

    .product-card-title {
      font-size: 24px;
    }

    .product-tags {
      justify-content: center;
    }

    .product-price {
      font-size: 18px;
    }

    .product-buttons {
      gap: 12px;
    }

    .product-btn {
      width: 100%;
      max-width: 104px;
    }
  }

/* Dedicated full-width CIP card; styles do not affect existing product cards. */
.product-cip-banner{box-sizing:border-box;margin-top:24px;padding:32px;border:1px solid #ffffff40;border-radius:28px;background:linear-gradient(90deg,#e64910 0%,#f51e55 24%,#de39b3 49%,#c64cdb 70%,#0083eb 100%);color:#fff;direction:rtl;text-align:right;font-family:inherit}
.product-cip-banner *{box-sizing:border-box}.product-cip-layout{display:flex;align-items:center;justify-content:space-between;gap:32px}.product-cip-copy{max-width:700px;min-width:0}.product-cip-heading{display:flex;align-items:center;gap:10px}.product-cip-banner h2{font:700 24px/1.4 Arial,sans-serif;color:#fff;margin:0}.product-cip-badge,.product-cip-tags span{display:inline-flex;padding:4px 10px;border:1px solid #ffffff40;border-radius:999px;background:#ffffff26;font-size:11px;line-height:1.8;color:#fff}.product-cip-banner p{font-size:14px;line-height:2;margin:12px 0 0;color:#ffffffdb}.product-cip-tags{display:flex;flex-wrap:wrap;gap:8px;margin-top:12px}.product-cip-actions{display:flex;flex-direction:column;align-items:flex-end;gap:12px;flex-shrink:0}.product-cip-price{display:flex;align-items:baseline;gap:8px;color:#fff}.product-cip-price-label{font-size:11px;color:#ffffffdb}.product-cip-amount{font:700 22px/1.5 Arial,Tahoma,sans-serif;unicode-bidi:isolate;font-variant-numeric:tabular-nums}.product-cip-amount bdi{unicode-bidi:isolate}.product-cip-price .amount,.product-cip-price .woocommerce-Price-currencySymbol{color:#fff}.product-cip-banner a.product-cip-details{display:inline-flex;align-items:center;justify-content:center;min-height:48px;padding:10px 28px;border-radius:999px;background:#fff;color:#101014;font-size:14px;font-weight:600;text-decoration:none;line-height:1.7}.product-cip-banner a.product-cip-details:hover{background:#ffffffe6}.product-cip-banner a.product-cip-assessment{font-size:12px;color:#ffffffdb;text-decoration:none;text-underline-offset:4px}.product-cip-banner a.product-cip-assessment:hover{color:#fff;text-decoration:underline}.product-cip-banner a:focus-visible{outline:3px solid #fff;outline-offset:5px}.product-cip-footnote{margin:32px 0 0;text-align:center;font-size:12px;line-height:2;color:#74747e;direction:rtl}
@media(max-width:768px){.product-cip-banner{padding:24px;border-radius:24px}.product-cip-layout{flex-direction:column;align-items:stretch;gap:24px}.product-cip-actions{align-items:flex-start}.product-cip-copy{max-width:none}}
@media(max-width:420px){.product-cip-banner a.product-cip-details{width:100%}.product-cip-actions{align-items:stretch}.product-cip-assessment{text-align:center}}

</style>

<section class="product-section">
    <div class="product-container">

        <h1 class="product-title">محصولات</h1>

        <div class="products-grid">

            <?php
            // تشخیص ارز فعلی از طریق افزونه CURCY یا ووکامرس
            $current_currency = get_woocommerce_currency();
            if ( class_exists( 'WOOMULTI_CURRENCY_Data' ) ) {
                $current_currency = WOOMULTI_CURRENCY_Data::get_ins()->get_current_currency();
            }
            $is_usd = ( $current_currency === 'USD' );

            // کوئری محصولات کاتالوگ (حذف محصولات مخفی مثل Add-onها)
            $products = new WP_Query( array(
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'post__not_in'   => $cip_product_id ? array($cip_product_id) : array(),
                'orderby'        => 'ID',
                'order'          => 'ASC',
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => array( 'exclude-from-catalog' ),
                        'operator' => 'NOT IN',
                    ),
                ),
            ) );

            if ( $products->have_posts() ) :

                while ( $products->have_posts() ) :
                    $products->the_post();

                    global $product;
                    $product = wc_get_product( get_the_ID() );

                    if ( ! $product ) {
                        continue;
                    }

                    // Prevent CIP parents/legacy products from appearing as regular cards.
                    $cip_item_sku = (string) $product->get_sku();
                    if (has_term('cip', 'product_cat', $product->get_id()) ||
                        preg_match('/^(?:S2F-CIP(?:-|$)|CIP-)/i', $cip_item_sku)) {
                        continue;
                    }

                    $product_id  = $product->get_id();
                    $is_featured = $product->is_featured();

                    // تصویر محصول
                    $image_url = get_the_post_thumbnail_url( $product_id, 'medium' );
                    if ( ! $image_url ) {
                        $image_url = wc_placeholder_img_src();
                    }

                    // محاسبه دقیق کمترین قیمت (سازگار با قیمت ثابت دلاری CURCY در متغیرها و محصول ساده)
                    $display_price = 0;

                    if ( $is_usd ) {
                        // ۱. اگر محصول متغیر است، کمترین قیمت دلاری ثابت (_regular_price_wmcp) را از متغیرهای فرزند بخوان
                        if ( $product->is_type( 'variable' ) ) {
                            $children   = $product->get_children();
                            $usd_prices = array();
                            foreach ( $children as $child_id ) {
                                $wmcp = get_post_meta( $child_id, '_regular_price_wmcp', true );
                                $data = is_string( $wmcp ) ? json_decode( $wmcp, true ) : $wmcp;
                                if ( is_array( $data ) && ! empty( $data['USD'] ) && is_numeric( $data['USD'] ) ) {
                                    $usd_prices[] = (float) $data['USD'];
                                }
                            }
                            if ( ! empty( $usd_prices ) ) {
                                $display_price = min( $usd_prices );
                            }
                        } else {
                            // ۲. اگر محصول ساده است، قیمت دلاری ثابت خودش را بخوان
                            $wmcp = get_post_meta( $product_id, '_regular_price_wmcp', true );
                            $data = is_string( $wmcp ) ? json_decode( $wmcp, true ) : $wmcp;
                            if ( is_array( $data ) && ! empty( $data['USD'] ) && is_numeric( $data['USD'] ) ) {
                                $display_price = (float) $data['USD'];
                            }
                        }

                        // ۳. اگر فیلد قیمت ثابت دلاری خالی بود، از تابع تبدیل خودکار CURCY استفاده کن
                        if ( $display_price <= 0 ) {
                            $raw_toman = $product->is_type( 'variable' )
                                ? (float) $product->get_variation_price( 'min', false )
                                : (float) $product->get_price();
                            $display_price = function_exists( 'wmc_get_price' ) ? (float) wmc_get_price( $raw_toman ) : (float) $product->get_price();
                        }
                    } else {
                        // حالت تومان (ایران): کمترین قیمت پایه تومانی
                        if ( $product->is_type( 'variable' ) ) {
                            $children     = $product->get_children();
                            $toman_prices = array();
                            foreach ( $children as $child_id ) {
                                $reg = get_post_meta( $child_id, '_regular_price', true );
                                if ( is_numeric( $reg ) && (float) $reg > 0 ) {
                                    $toman_prices[] = (float) $reg;
                                }
                            }
                            $display_price = ! empty( $toman_prices ) ? min( $toman_prices ) : (float) $product->get_price();
                        } else {
                            $reg_price     = get_post_meta( $product_id, '_regular_price', true );
                            $display_price = ( is_numeric( $reg_price ) && (float) $reg_price > 0 ) ? (float) $reg_price : (float) $product->get_price();
                        }
                    }
                    ?>

                    <div class="product-card <?php echo $is_featured ? 'special' : ''; ?>">

                        <?php if ( $is_featured ) : ?>
                            <div class="special-badge">
                                <img
                                    src="https://6tofit.com/wp-content/uploads/2025/10/producpish.svg"
                                    alt="پیشنهادی"
                                >
                                <span>پیشنهادی</span>
                            </div>
                        <?php endif; ?>

                        <!-- تصویر محصول -->
                        <div class="product-icon">
                            <img
                                src="<?php echo esc_url( $image_url ); ?>"
                                alt="<?php echo esc_attr( get_the_title() ); ?>"
                            >
                        </div>

                        <!-- عنوان -->
                        <h3 class="product-card-title">
                            <?php
                            if ( in_array( (int) $product_id, array( 315, 477 ), true ) ) {
                                echo 'برنامه ترکیبی';
                            } else {
                                echo esc_html( get_the_title() );
                            }
                            ?>
                        </h3>

                        <!-- تگ‌ها -->
                        <?php
                        $product_tags = get_the_terms( $product_id, 'product_tag' );
                        if ( ! empty( $product_tags ) && ! is_wp_error( $product_tags ) ) :
                        ?>
                            <div class="product-tags">
                                <?php
                                $tag_count = 0;
                                foreach ( $product_tags as $tag ) :
                                    if ( $tag_count >= 3 ) {
                                        break;
                                    }
                                    ?>
                                    <span class="product-tag">
                                        <?php echo esc_html( $tag->name ); ?>
                                    </span>
                                    <?php
                                    $tag_count++;
                                endforeach;
                                ?>
                            </div>
                        <?php endif; ?>

                        <!-- قیمت (داینامیک بر اساس تومان / دلار) -->
                        <div class="product-price">
                            <span class="price-from">شروع قیمت از</span>

                            <?php if ( $is_usd ) : ?>
                                <span class="price-amount">
                                    $<?php echo number_format( $display_price, ( floor( $display_price ) == $display_price ? 0 : 2 ), '.', ',' ); ?>
                                </span>
                                <span class="price-currency">دلار</span>
                            <?php else : ?>
                                <span class="price-amount">
                                    <?php echo number_format( $display_price, 0, '.', '.' ); ?>
                                </span>
                                <span class="price-currency">تومان</span>
                            <?php endif; ?>
                        </div>

                        <!-- دکمه‌ها -->
                        <div class="product-buttons">
                            <a
                                href="<?php echo esc_url( get_permalink( $product_id ) ); ?>"
                                class="product-btn product-btn-details"
                            >
                                جزئیات
                            </a>

                            <a
                                href="<?php echo esc_url( get_permalink( $product_id ) ); ?>"
                                class="product-btn product-btn-buy"
                            >
                                خرید
                            </a>
                        </div>

                    </div>

                    <?php
                endwhile;

                wp_reset_postdata();

            else :
                ?>
                <p class="no-products">
                    محصولی برای نمایش وجود ندارد.
                </p>
                <?php
            endif;
            ?>

        </div>

        <article class="product-cip-banner" aria-labelledby="product-cip-title">
            <div class="product-cip-layout">
                <div class="product-cip-copy">
                    <div class="product-cip-heading"><h2 id="product-cip-title" dir="ltr">CIP</h2><span class="product-cip-badge"><?php echo ($cip_catalog_product && !$cip_catalog_product->is_in_stock()) ? 'ظرفیت تکمیل' : 'ظرفیت محدود'; ?></span></div>
                    <p>برنامه ظرفیت‌محدود ۳ یا ۶ ماهه برای مدیریت یکپارچه سلامت، با هماهنگی و پایش مستمر.</p>
                    <div class="product-cip-tags"><span>دوره ۳ یا ۶ ماهه</span><span>بدون افزودنی</span><span>پذیرش پس از ارزیابی</span></div>
                </div>
                <div class="product-cip-actions">
                    <div class="product-cip-price">
                        <?php if ($cip_catalog_price !== '') : ?>
                            <span class="product-cip-price-label">شروع از</span><span class="product-cip-amount"><?php echo wp_kses_post($cip_catalog_price); ?></span>
                        <?php else : ?>
                            <span class="product-cip-price-label">قیمت دوره در صفحه جزئیات</span>
                        <?php endif; ?>
                    </div>
                    <a class="product-cip-details" href="<?php echo esc_url($cip_catalog['details_url']); ?>">مشاهده جزئیات CIP</a>
                    <a class="product-cip-assessment" href="<?php echo esc_url($cip_catalog['assessment_url']); ?>">بررسی صلاحیت پذیرش</a>
                </div>
            </div>
        </article>
        <p class="product-cip-footnote">فستینگ، گیاه‌خواری، تمرین در خانه یا باشگاه و حرکات اصلاحی محصول جداگانه نیستند؛ داخل تنظیمات همین برنامه‌ها انتخاب می‌شوند.</p>
    </div>
</section>

<style>
.product-btn,
.product-btn:hover,
.product-btn:focus,
.product-btn:active {
    text-decoration: none !important;
}
  .product-cta-section {
    width: 100%;
    margin: 100px 0;
  }

  .product-cta-container {
    width: 80%;
    margin: 0 auto;
  }

  .product-cta-title {
    text-align: right;
  }

  .product-cta-title h2 {
    font-size: 30px;
    font-weight: 500;
    color: #000000;
    margin: 0 0 24px;
  }

  .product-cta-cards {
    display: flex;
    gap: 24px;
  }

  .product-cta-card {
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

  .product-cta-card img {
    width: 120px;
    height: 120px;
    object-fit: contain;
    margin-bottom: 16px;
  }

  .product-cta-card h2 {
    font-size: 30px;
    font-weight: 500;
    color: #000000;
    margin: 0 0 15px;
  }

  .product-cta-card p {
    font-size: 16px;
    color: #000000;
    margin: 15px 0;
    margin-bottom: 25px;
  }

  .product-cta-button {
    background: none;
    border: none;
    font-size: 16px;
    color: #5247FF;
    cursor: pointer;
    display: inline-flex;
    gap: 8px;
  }

  .product-cta-button img {
    width: 20px;
    height: 20px;
    vertical-align: middle;
  }

  #product-cta {
    scroll-margin-top: 100px;
  }

  /* تغییرات برای موبایل */
  @media only screen and (max-width: 768px) {
    .product-cta-container {
      width: 90%;
    }

    .product-cta-title h2 {
      font-size: 24px;
    }

    .product-cta-cards {
      flex-direction: column;
      gap: 24px;
    }

    .product-cta-card h2 {
      font-size: 24px;
    }

    .product-cta-card p {
      font-size: 14px;
    }

    .product-cta-button {
      font-size: 16px;
    }
  }
</style>

<section class="product-cta-section" id="product-cta">
  <div class="product-cta-container">
    <div class="product-cta-title">
      <h2>انتخاب بهتر با</h2>
    </div>
    <div class="product-cta-cards">
      <div class="product-cta-card">
        <img src="https://6tofit.com/wp-content/uploads/2025/10/Mobile-Phone.png" alt="Card Image 1">
        <h2>پرسشنامه هوشمند</h2>
        <p>با پاسخ به چند سوال در پرسشنامه هوشمند، مناسب‌ترین برنامه براساس نیازهایتان را به شما پیشنهاد می‌کنیم</p>
        <button class="product-cta-button">
          از اینجا شروع کنید
          <img src="https://6tofit.com/wp-content/uploads/2025/10/Arrow-Left-2-Iconly-Pro.svg" alt="Button Icon">
        </button>
      </div>
      <div class="product-cta-card">
        <img src="https://6tofit.com/wp-content/uploads/2025/10/Headphonepr.png" alt="Card Image 2">
        <h2>مشاوره رایگان</h2>
        <p>برای دریافت مشاوره رایگان، کافیست درخواست خود را ثبت کنید. پس از ثبت درخواست متخصصان ما با شما ارتباط خواهند گرفت.</p>
        <button class="product-cta-button" onclick="showFreeConsultationPopup()">
          ثبت درخواست
          <img src="https://6tofit.com/wp-content/uploads/2025/10/Arrow-Left-2-Iconly-Pro.svg" alt="Button Icon">
        </button>
      </div>
    </div>
  </div>
</section>
<?php
render_free_consultation_popup("مشاوره رایگان", "ارسال درخواست");
get_footer();