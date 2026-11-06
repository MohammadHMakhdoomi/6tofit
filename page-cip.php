<?php
/**
 * Template Name: صفحه CIP
 * Template Post Type: page
 *
 * Installation: place in the active (preferably child) theme and select «صفحه CIP».
 * Uses the dedicated header-cip.php and footer-cip.php. No Tailwind or external assets required.
 * Configure destination URLs below or via the six2fit_cip_settings filter.
 * These links do not create orders or reserve capacity; connect your existing backend.
 */
defined('ABSPATH') || exit;
// Set these to the exact published WooCommerce product/variation IDs.
// Zero means no product is connected. Never substitutes an unrelated product.
$cip_product_ids = apply_filters('six2fit_cip_product_ids', array(
    'three' => 0,
    'six' => 0,
    'assessment' => 0,
));
$cip_products = array();
$cip_prices = array();
$cip_urls = array();
foreach (array('three', 'six', 'assessment') as $cip_key) {
    $cip_product = function_exists('wc_get_product') && !empty($cip_product_ids[$cip_key])
        ? wc_get_product(absint($cip_product_ids[$cip_key])) : false;
    if ($cip_product && ($cip_product->get_status() !== 'publish' ||
        ($cip_product->is_type('variation') && get_post_status($cip_product->get_parent_id()) !== 'publish'))) {
        $cip_product = false;
    }
    $cip_products[$cip_key] = $cip_product;
    $cip_urls[$cip_key] = $cip_product ? $cip_product->get_permalink() : 'https://consult.6tofit.com/';
    $cip_prices[$cip_key] = 'پس از بررسی شرایط';
    if ($cip_product) {
        $cip_prices[$cip_key] = 'مشاهده قیمت در صفحه محصول';
        // Reuse the theme's currency decision and exact-price function; no new geo logic or exchange rate.
        if (!$cip_product->is_type('variable') && function_exists('af_get_exact_product_price') && function_exists('af_is_usd_currency')) {
            $cip_amount = af_get_exact_product_price($cip_product->get_id(), $cip_key === 'six' ? 6 : ($cip_key === 'three' ? 3 : 1), 'cip');
            if (is_numeric($cip_amount) && $cip_amount > 0) {
                $cip_prices[$cip_key] = wc_price($cip_amount, array('currency' => af_is_usd_currency() ? 'USD' : 'IRT'));
            }
        }
    }
}
$cip = apply_filters('six2fit_cip_settings', array(
    'apply_url'    => 'https://consult.6tofit.com/',
    'booking_url'  => $cip_urls['assessment'],
    'waitlist_url' => 'https://consult.6tofit.com/',
    'plans_url'    => home_url('/products/'),
    'logo_url'     => '',
    'three_url'    => $cip_urls['three'],
    'six_url'      => $cip_urls['six'],
));
get_header('cip');
?>
<style>
.cip-page{--cip-ink:#101014;--cip-muted:#74747e;--cip-line:#e2e2e7;--cip-purple:#5247ff;background:#fff;color:var(--cip-ink);font-family:'iranyekanen',Tahoma,sans-serif;direction:rtl;text-align:right;line-height:1.9;width:100%;isolation:isolate}
.cip-page *,.cip-page *::before,.cip-page *::after{box-sizing:border-box}
.cip-page h1,.cip-page h2,.cip-page h3,.cip-page p,.cip-page ul{margin:0;padding:0;font-family:inherit;color:inherit}
.cip-page a{text-decoration:none}.cip-page button,.cip-page input{font:inherit}.cip-page a:focus-visible,.cip-page button:focus-visible,.cip-page input:focus-visible{outline:3px solid var(--cip-purple);outline-offset:5px}
.cip-page .cip-wrap{width:100%;max-width:1200px;margin-inline:auto;padding-inline:32px}
.cip-page .cip-section{padding-block:80px}.cip-page .cip-muted{color:var(--cip-muted)}
.cip-page .cip-heading{text-align:center;margin-bottom:52px}.cip-page .cip-eyebrow{display:block;color:var(--cip-purple);font-size:13px;margin-bottom:8px}.cip-page h2{font-size:30px;font-weight:800;line-height:1.6}.cip-page .cip-heading p{font-size:14px;color:var(--cip-muted);margin-top:14px}
.cip-page .cip-btn{display:inline-flex;min-height:52px;align-items:center;justify-content:center;gap:10px;border:1px solid var(--cip-line);border-radius:999px;padding:10px 26px;font-size:14px;font-weight:600;line-height:1.6;background:#fff;color:var(--cip-ink);cursor:pointer;transition:background .2s,border-color .2s}
.cip-page .cip-btn:hover{background:#f0f0f5}.cip-page .cip-btn-dark{background:#111;color:#fff;border-color:#111}.cip-page .cip-btn-dark:hover{background:#333}.cip-page .cip-actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:30px}
.cip-page .cip-money{direction:ltr;unicode-bidi:isolate;font-family:Arial,sans-serif;font-weight:700;font-variant-numeric:tabular-nums;display:inline-block;white-space:nowrap}
.cip-page .cip-hero{background:linear-gradient(90deg,#e64910 0%,#f51e55 24%,#de39b3 49%,#c64cdb 70%,#0083eb 100%);color:#fff}
.cip-page .cip-hero-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:64px;padding-block:96px;align-items:start}
.cip-page .cip-brand{display:flex;align-items:center;gap:12px;line-height:1}.cip-page .cip-wordmark{font:800 34px/1 Arial,sans-serif;letter-spacing:-1.4px;direction:ltr}.cip-page .cip-brand img{height:28px;width:auto;max-width:180px;object-fit:contain}.cip-page .cip-badge{font:12px/1.5 Arial,sans-serif;padding:4px 13px;border:1px solid #ffffff4d;background:#ffffff1a;border-radius:999px}
.cip-page h1{font-size:44px;line-height:1.4;font-weight:800;margin-top:28px}.cip-page .cip-intro{font-size:15px;line-height:2.2;color:#ffffffdb;margin-top:24px}.cip-page .cip-btn-glass{background:transparent;color:#fff;border-color:#ffffff66}.cip-page .cip-btn-glass:hover{background:#ffffff1a}.cip-page .cip-hero a:focus-visible{outline-color:#fff}
.cip-page .cip-facts{display:flex;flex-wrap:wrap;gap:16px 24px;font-size:12px;color:#ffffffdb;margin-top:30px}.cip-page .cip-facts span{display:inline-flex;align-items:center;gap:7px}.cip-page .cip-icon{width:17px;height:17px;fill:none;stroke:currentColor;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}
.cip-page .cip-glass{border:1px solid #ffffff40;border-radius:32px;background:#ffffff1f;padding:32px;backdrop-filter:blur(8px)}.cip-page .cip-glass h2{font-size:15px}.cip-page .cip-glass ul{list-style:none;font-size:13px;line-height:2.2;color:#ffffffdb;margin-top:20px}.cip-page .cip-glass li+li{margin-top:10px}.cip-page .cip-investment{border-top:1px solid #ffffff40;padding-top:22px;margin-top:28px}.cip-page .cip-investment>p{font-size:12px;color:#ffffffcc;margin-bottom:15px}.cip-page .cip-price-row{display:flex;justify-content:space-between;align-items:center;font-size:14px;gap:16px;margin-top:8px}.cip-page .cip-price-row .cip-money{font-size:18px}
.cip-page .cip-services{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}.cip-page .cip-card{border:1px solid var(--cip-line);border-radius:24px;background:#fff;padding:26px}.cip-page .cip-card h3{font-size:14px;font-weight:700;margin-bottom:12px}.cip-page .cip-card p{font-size:13px;color:var(--cip-muted);line-height:2.1}.cip-page .cip-service-title{display:flex;align-items:center;gap:9px}.cip-page .cip-check{display:inline-flex;align-items:center;justify-content:center;width:25px;height:25px;flex-shrink:0;border-radius:50%;background:#f1f0ff;color:var(--cip-purple);font:14px Arial,sans-serif}.cip-page .cip-note{text-align:center;font-size:12px;color:var(--cip-muted);line-height:2;margin-top:26px}
.cip-page .cip-gray{background:#f5f5f5}.cip-page #pricing{scroll-margin-top:100px}.cip-page .cip-pricing-inner{max-width:770px;margin-inline:auto}.cip-page .cip-plans{display:grid;grid-template-columns:1fr 1fr;gap:16px;border:0;padding:0;margin:0;min-width:0}.cip-page .cip-sr{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
.cip-page .cip-plan{display:block;position:relative;cursor:pointer;border:1px solid var(--cip-line);border-radius:30px;background:#fff;padding:26px;transition:border-color .2s,box-shadow .2s}.cip-page .cip-plan:has(input:checked){border-color:var(--cip-purple);box-shadow:0 0 0 1px var(--cip-purple)}.cip-page .cip-plan:has(input:focus-visible){outline:3px solid var(--cip-purple);outline-offset:4px}.cip-page .cip-plan input{position:absolute;left:24px;top:26px;width:20px;height:20px;accent-color:var(--cip-purple);margin:0}.cip-page .cip-plan-title{display:block;font-size:16px;font-weight:700;padding-left:30px}.cip-page .cip-plan-description{display:block;color:var(--cip-muted);font-size:12px;line-height:2;margin-top:10px;min-height:48px}.cip-page .cip-plan-price{display:block;border-top:1px solid var(--cip-line);padding-top:16px;margin-top:22px;font-size:22px}.cip-page .cip-plan-small{display:block;font-size:11px;color:var(--cip-muted);margin-top:3px}
.cip-page .cip-pricing-actions{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:22px}.cip-page .cip-pricing-actions button:disabled{background:#929292;border-color:#929292;color:#fff;cursor:not-allowed}.cip-page .cip-assessment{display:flex;gap:22px;align-items:center;margin-top:30px}.cip-page .cip-assessment-copy{flex:1}.cip-page .cip-assessment .cip-money{font-size:22px}.cip-page .cip-assessment .cip-btn{min-height:44px;padding:8px 22px;white-space:nowrap}
.cip-page .cip-process-heading{text-align:right}.cip-page .cip-steps{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px}.cip-page .cip-step-number{font:700 28px/1 Arial,sans-serif;color:#d9d6ff;display:block;margin-bottom:14px}
.cip-page .cip-fit{display:grid;grid-template-columns:1fr 1fr;gap:16px}.cip-page .cip-list{list-style:none;font-size:13px;line-height:2.2}.cip-page .cip-list li+li{margin-top:12px}.cip-page .cip-list-good li{position:relative;padding-right:23px}.cip-page .cip-list-good li::before{content:'✓';position:absolute;right:0;color:var(--cip-purple)}.cip-page .cip-fit .cip-btn{width:100%;margin-top:22px;min-height:44px}
.cip-page .cip-admission{background:#f1f0ff}.cip-page .cip-admission-card{display:flex;justify-content:space-between;align-items:center;gap:50px;padding:40px}.cip-page .cip-admission-copy{max-width:730px}.cip-page .cip-admission h2{font-size:24px}.cip-page .cip-admission p{margin-top:12px}.cip-page .cip-admission-prices{display:flex;flex-wrap:wrap;gap:20px;font-size:12px;margin-top:20px;color:var(--cip-muted)}.cip-page .cip-admission-prices b{color:var(--cip-ink);font-size:16px;margin-inline-start:5px}.cip-page .cip-admission-actions{display:flex;flex-direction:column;gap:12px;flex-shrink:0}
@media(min-width:769px) and (max-width:1000px){.cip-page .cip-hero-grid{gap:32px}.cip-page h1{font-size:36px}.cip-page .cip-steps{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:768px){.cip-page .cip-wrap{padding-inline:20px}.cip-page .cip-section{padding-block:56px}.cip-page .cip-hero-grid{grid-template-columns:1fr;gap:36px;padding-block:64px}.cip-page h1{font-size:30px;line-height:1.5}.cip-page .cip-intro{font-size:14px}.cip-page .cip-glass{padding:26px}.cip-page .cip-heading{margin-bottom:32px}.cip-page h2{font-size:25px}.cip-page .cip-services,.cip-page .cip-steps{grid-template-columns:repeat(2,minmax(0,1fr))}.cip-page .cip-fit{grid-template-columns:1fr}.cip-page .cip-admission-card{flex-direction:column;align-items:stretch;gap:26px;padding:26px}.cip-page .cip-admission-actions{flex-direction:row;flex-wrap:wrap}.cip-page .cip-assessment{flex-wrap:wrap}.cip-page .cip-assessment-copy{flex-basis:100%}.cip-page .cip-card{padding:22px}}
@media(max-width:480px){.cip-page .cip-services,.cip-page .cip-steps,.cip-page .cip-plans,.cip-page .cip-pricing-actions{grid-template-columns:1fr}.cip-page .cip-actions .cip-btn,.cip-page .cip-admission-actions .cip-btn{width:100%}.cip-page .cip-plan-description{min-height:0}.cip-page .cip-facts{gap:12px 18px}.cip-page .cip-brand .cip-wordmark{font-size:30px}}
</style>
<main class="cip-page" id="cip-page" tabindex="-1" dir="rtl" lang="fa">
<section class="cip-hero" aria-labelledby="cip-title">
 <div class="cip-wrap cip-hero-grid">
  <div>
   <div class="cip-brand">
    <?php if (!empty($cip['logo_url'])) : ?><img src="<?php echo esc_url($cip['logo_url']); ?>" alt="6toFit"><?php else : ?><span class="cip-wordmark" aria-label="6toFit">6toFit</span><?php endif; ?>
    <span class="cip-badge">CIP</span>
   </div>
   <h1 id="cip-title">مسئولیت‌پذیری مشترک برای سلامت تو، در ۳ یا ۶ ماه</h1>
   <p class="cip-intro">CIP یک بسته گران‌تر نیست؛ یک مدل متفاوت است. به‌جای تحویل یک برنامه، یک مسیر ۳ یا ۶ ماهه با پایش مستمر، بازطراحی به‌موقع و هماهنگی بین متخصص‌ها اجرا می‌شود.</p>
   <div class="cip-actions"><a class="cip-btn" href="<?php echo esc_url($cip['apply_url']); ?>">درخواست بررسی صلاحیت <span aria-hidden="true">←</span></a><a class="cip-btn cip-btn-glass" href="#pricing">وضعیت ظرفیت</a></div>
   <div class="cip-facts">
    <span><svg class="cip-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 6v6l4 2"/></svg>دوره ۳ یا ۶ ماهه</span>
    <span><svg class="cip-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="7" r="4"/><path d="M2 21v-2a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v2M17 3a4 4 0 0 1 0 8M22 21v-2a4 4 0 0 0-3-4"/></svg>ظرفیت محدود</span>
    <span><svg class="cip-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 3 6v6c0 5 9 9 9 9s9-4 9-9V6zM8 12l3 3 5-6"/></svg>بدون افزودنی سبد خرید</span>
   </div>
  </div>
  <aside class="cip-glass" aria-labelledby="cip-not-title">
   <h2 id="cip-not-title">CIP چه چیزی نیست</h2>
   <ul><li>نسخه گران‌تر برنامه غذایی یا ورزشی نیست.</li><li>سطح سرویس داخل برنامه‌های دیگر نیست؛ خط مستقل است.</li><li>دوره کوتاه‌تر از سه ماه ندارد.</li><li>در سبد خرید افزودنی قابل انتخاب ندارد.</li></ul>
   <div class="cip-investment"><p>سرمایه‌گذاری دوره</p><div class="cip-price-row"><span>۳ ماهه</span><b class="cip-money"><?php echo wp_kses_post($cip_prices['three']); ?></b></div><div class="cip-price-row"><span>۶ ماهه</span><b class="cip-money"><?php echo wp_kses_post($cip_prices['six']); ?></b></div></div>
  </aside>
 </div>
</section>
<section class="cip-section" aria-labelledby="cip-services-title"><div class="cip-wrap">
 <div class="cip-heading"><span class="cip-eyebrow">چه چیزی شامل می‌شود</span><h2 id="cip-services-title">سرویس‌های داخل CIP</h2><p>همه موارد زیر بخشی از دوره CIP هستند و جداگانه انتخاب نمی‌شوند.</p></div>
 <div class="cip-services">
 <?php
 $cip_services = array(
  array('ارزیابی جامع اولیه', 'بررسی سابقه سلامت، سبک زندگی، آزمایش‌های موجود و اهداف دوره.'),
  array('برنامه تغذیه و تمرین یکپارچه', 'طراحی و بازطراحی مستمر هر دو بخش به‌صورت هماهنگ در طول دوره.'),
  array('پایش دوره‌ای', 'بررسی منظم شاخص‌ها و به‌روزرسانی مسیر بر اساس داده‌های واقعی.'),
  array('هماهنگی بین متخصص‌ها', 'یک نفر مسئول هماهنگی بین تیم تغذیه، تمرین و مشاوره‌های تخصصی است.'),
  array('سهمیه مشاوره تخصصی', 'تعداد مشخصی جلسه تخصصی داخل برنامه؛ جلسات بیشتر جداگانه محاسبه می‌شود.'),
  array('کانال ارتباطی اختصاصی', 'دسترسی مستقیم برای هماهنگی، تغییر برنامه و سؤال‌های بین‌دوره‌ای.'),
 );
 foreach ($cip_services as $cip_service) : ?>
 <article class="cip-card"><h3 class="cip-service-title"><span class="cip-check" aria-hidden="true">✓</span><?php echo esc_html($cip_service[0]); ?></h3><p><?php echo esc_html($cip_service[1]); ?></p></article>
 <?php endforeach; ?>
 </div><p class="cip-note">مشاوره‌های تخصصی بیشتر از سهمیه تعریف‌شده، خارج از دوره محاسبه می‌شود.</p>
</div></section>
<section class="cip-section cip-gray" id="pricing" aria-labelledby="cip-pricing-title"><div class="cip-wrap">
 <div class="cip-heading"><span class="cip-eyebrow">انتخاب دوره</span><h2 id="cip-pricing-title">دوره CIP را انتخاب کن</h2><p>CIP افزودنی قابل انتخاب ندارد؛ همه سرویس‌های دوره داخل همین مبلغ است.</p></div>
 <div class="cip-pricing-inner">
  <fieldset class="cip-plans"><legend class="cip-sr">مدت دوره CIP</legend>
   <label class="cip-plan"><input type="radio" name="cip_duration" value="3" data-url="<?php echo esc_url($cip['three_url']); ?>"><span class="cip-plan-title">۳ ماهه</span><span class="cip-plan-description">دوره فشرده برای شروع مسیر و تثبیت پایه‌ها</span><span class="cip-plan-price"><b class="cip-money"><?php echo wp_kses_post($cip_prices['three']); ?></b></span><span class="cip-plan-small">جزئیات دوره و مبلغ نهایی در صفحه محصول نمایش داده می‌شود.</span></label>
   <label class="cip-plan"><input type="radio" name="cip_duration" value="6" data-url="<?php echo esc_url($cip['six_url']); ?>"><span class="cip-plan-title">۶ ماهه</span><span class="cip-plan-description">دوره کامل برای پایش بلندمدت و تغییر پایدار</span><span class="cip-plan-price"><b class="cip-money"><?php echo wp_kses_post($cip_prices['six']); ?></b></span><span class="cip-plan-small">جزئیات دوره و مبلغ نهایی در صفحه محصول نمایش داده می‌شود.</span></label>
  </fieldset>
  <div class="cip-pricing-actions"><button class="cip-btn cip-btn-dark" id="cip-continue" type="button" disabled>ادامه انتخاب دوره</button><a class="cip-btn" href="<?php echo esc_url($cip['apply_url']); ?>">درخواست بررسی صلاحیت</a></div>
  <p id="cip-selection" class="cip-sr" role="status" aria-live="polite"></p>
  <noscript><p class="cip-note">برای ادامه، دوره را انتخاب کنید: <a href="<?php echo esc_url($cip['three_url']); ?>">دوره ۳ ماهه</a> یا <a href="<?php echo esc_url($cip['six_url']); ?>">دوره ۶ ماهه</a>.</p></noscript>
  <p class="cip-note">CIP در صفحه مقایسه افزودنی قابل انتخاب ندارد. جلسات تخصصی داخل سهمیه دوره است و در جلسه ارزیابی، جزئیات همکاری مشخص می‌شود.</p>
  <div class="cip-card cip-assessment"><div class="cip-assessment-copy"><h3>جلسه ارزیابی و تعیین صلاحیت CIP</h3><p>یک جلسه اختصاصی برای بررسی شرایط و تشخیص تناسب تو با CIP. این جلسه جدا از مبلغ دوره است و به‌صورت خودکار به سفارش اضافه نمی‌شود.</p></div><b class="cip-money"><?php echo wp_kses_post($cip_prices['assessment']); ?></b><a class="cip-btn" href="<?php echo esc_url($cip['booking_url']); ?>">رزرو جلسه</a></div>
 </div>
</div></section>
<section class="cip-section cip-gray" aria-labelledby="cip-process-title"><div class="cip-wrap">
 <div class="cip-heading cip-process-heading"><span class="cip-eyebrow">روند اجرا</span><h2 id="cip-process-title">پایش و هماهنگی چطور کار می‌کند</h2></div>
 <div class="cip-steps">
 <?php $cip_steps = array(array('ارزیابی و پذیرش','بررسی شرایط، اهداف و تناسب با ظرفیت دوره.'),array('طراحی مسیر دوره','تعریف مراحل، شاخص‌ها و نقاط بازبینی.'),array('پایش دوره‌ای','بررسی منظم داده‌ها و اصلاح برنامه در طول مسیر.'),array('هماهنگی و جمع‌بندی','هماهنگی بین متخصص‌ها و گزارش پایان دوره.')); foreach ($cip_steps as $cip_index => $cip_step) : ?>
  <article class="cip-card"><span class="cip-step-number" aria-hidden="true"><?php echo esc_html($cip_index + 1); ?></span><h3><?php echo esc_html($cip_step[0]); ?></h3><p><?php echo esc_html($cip_step[1]); ?></p></article>
 <?php endforeach; ?>
 </div>
</div></section>
<section class="cip-section" aria-label="تناسب دوره"><div class="cip-wrap cip-fit">
 <article class="cip-card"><h3>برای چه کسی مناسب است</h3><ul class="cip-list cip-list-good"><li>شرایط سلامتی یا سبک زندگی پیچیده‌ای داری که برنامه ساده جواب نداده.</li><li>می‌خواهی در چند ماه آینده مسیر مشخص و پیگیری منظم داشته باشی.</li><li>زمان محدودی داری و می‌خواهی هماهنگی بین متخصص‌ها از سمت سرویس باشد.</li></ul></article>
 <article class="cip-card"><h3>برای چه کسی مناسب نیست</h3><ul class="cip-list cip-muted"><li>دنبال یک برنامه کوتاه‌مدت یک یا سه ماهه هستی.</li><li>فقط به برنامه غذایی یا فقط برنامه تمرین نیاز داری.</li><li>امکان همراهی منظم در طول مسیر دوره را نداری.</li></ul><a class="cip-btn" href="<?php echo esc_url($cip['plans_url']); ?>">مشاهده برنامه‌های دیگر</a></article>
</div></section>
<section class="cip-section cip-admission" aria-labelledby="cip-admission-title"><div class="cip-wrap">
 <div class="cip-card cip-admission-card"><div class="cip-admission-copy"><h2 id="cip-admission-title">پذیرش دوره فعلی محدود است</h2><p>تعداد پذیرش هر دوره بر اساس ظرفیت تیم تعیین می‌شود. پس از ثبت درخواست، ارزیابی اولیه انجام می‌شود و در صورت تناسب، پذیرش نهایی اعلام می‌گردد.</p><div class="cip-admission-prices"><span>۳ ماهه <b class="cip-money"><?php echo wp_kses_post($cip_prices['three']); ?></b></span><span>۶ ماهه <b class="cip-money"><?php echo wp_kses_post($cip_prices['six']); ?></b></span></div></div><div class="cip-admission-actions"><a class="cip-btn cip-btn-dark" href="<?php echo esc_url($cip['apply_url']); ?>">ثبت درخواست پذیرش</a><a class="cip-btn" href="<?php echo esc_url($cip['waitlist_url']); ?>">اطلاع از بازشدن ظرفیت</a></div></div>
</div></section>
</main>
<script>
(function () {
 'use strict';
 const root = document.getElementById('cip-page');
 if (!root) return;
 const next = root.querySelector('#cip-continue');
 const status = root.querySelector('#cip-selection');
 const options = root.querySelectorAll('input[name="cip_duration"]');
 function updateSelection() {
  const selected = root.querySelector('input[name="cip_duration"]:checked');
  next.disabled = !selected;
  status.textContent = selected ? 'دوره ' + (selected.value === '3' ? '۳' : '۶') + ' ماهه انتخاب شد.' : '';
 }
 options.forEach(function (option) { option.addEventListener('change', updateSelection); });
 next.addEventListener('click', function () {
  const selected = root.querySelector('input[name="cip_duration"]:checked');
  if (!selected || !selected.dataset.url) return;
  if (selected.dataset.url === 'https://consult.6tofit.com/') {
   if (typeof window.showFreeHeaderConsultationPopup === 'function') window.showFreeHeaderConsultationPopup();
   else status.textContent = 'فرم مشاوره بارگذاری نشد. صفحه را دوباره باز کنید.';
   return;
  }
  window.location.assign(selected.dataset.url);
 });
 updateSelection();
 window.addEventListener('pageshow', updateSelection);
}());
</script>
<?php get_footer('cip'); ?>
