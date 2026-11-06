<?php
/**
 * Template Name: راهنمای انتخاب برنامه — CIP
 * Template Post Type: page
 * Uses the existing AFQuestionnaire.open() API, loaded by the theme's wp_footer hook.
 */
defined('ABSPATH') || exit;
get_header('cip');
?>
<style>
.cip-finder{direction:rtl;text-align:center;background:#fff;color:#171719;font-family:'iranyekanen',Tahoma,sans-serif;padding:76px 24px 90px;min-height:calc(100vh - 72px);box-sizing:border-box}
.cip-finder *{box-sizing:border-box}.cip-finder h1,.cip-finder h2,.cip-finder p{font-family:inherit;margin:0;color:inherit}
.cip-finder-inner{max-width:760px;margin:0 auto}.cip-finder-badge{display:inline-flex;align-items:center;gap:7px;background:#f5f5f7;border:1px solid #ececef;border-radius:999px;padding:5px 12px;color:#88888e;font-size:11px;line-height:1.6}
.cip-finder-badge svg{width:16px;height:16px;color:#6358e9;fill:none;stroke:currentColor;stroke-width:1.6;stroke-linejoin:round}
.cip-finder h1{font-size:36px;font-weight:800;line-height:1.6;margin:20px 0 22px;letter-spacing:-.6px}
.cip-finder .cip-finder-intro{font-size:13px;line-height:2.5;color:#82828a;max-width:630px;margin:0 auto}
.cip-finder-cards{display:grid;grid-template-columns:1fr 1fr;gap:14px;max-width:670px;margin:38px auto 32px}
.cip-finder-card{border:1px solid #e9e9ee;border-radius:24px;padding:23px;text-align:right;box-shadow:0 2px 5px #17171903}
.cip-finder-step{font-size:11px;color:#7972c7}.cip-finder-card h2{font-size:15px;line-height:1.9;font-weight:600;margin:5px 0 9px}.cip-finder-card p{font-size:12px;line-height:2.5;color:#85858d}
.cip-finder-start{display:inline-flex;align-items:center;justify-content:center;gap:14px;border:0;border-radius:999px;background:#5144f5;color:#fff;padding:13px 27px;min-height:50px;font:600 14px/1.7 'iranyekanen',Tahoma,sans-serif;cursor:pointer;transition:background .15s}
.cip-finder-start:hover{background:#4236d9}.cip-finder-start:focus-visible,.cip-finder-contact:focus-visible{outline:3px solid #8176ff;outline-offset:5px}
.cip-finder-contact{display:inline-block;margin-top:20px;color:#85858d;font-size:12px;text-decoration:none}.cip-finder-contact:hover{text-decoration:underline}
.cip-finder-status{font-size:13px;color:#7b3250;margin:14px auto 0;max-width:470px}.cip-finder-status:empty{display:none}
@media(max-width:767px){.cip-finder{padding:54px 20px 65px}.cip-finder h1{font-size:28px}.cip-finder .cip-finder-intro{font-size:12px}.cip-finder-cards{margin-top:28px}.cip-finder-card{padding:20px}}
@media(max-width:520px){.cip-finder h1{font-size:25px;letter-spacing:0}.cip-finder-cards{grid-template-columns:1fr;gap:12px}.cip-finder-start{min-width:185px}.cip-finder-card{border-radius:20px}}
</style>
<main class="cip-finder" id="cip-page" tabindex="-1" dir="rtl" lang="fa">
 <div class="cip-finder-inner">
  <span class="cip-finder-badge"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 3 2.4 6.6L21 12l-6.6 2.4L12 21l-2.4-6.6L3 12l6.6-2.4zM20 2v5M17.5 4.5h5"/></svg>بدون نیاز به ورود</span>
  <h1>پرسشنامه هوشمند پیشنهاد برنامه</h1>
  <p class="cip-finder-intro">مرحله اول با ۴ سؤال کوتاه برنامه مناسب را مشخص می‌کند. اگر بخواهی، در مرحله دوم پیشنهاد پکیج کامل شامل سطح همراهی، مدت دوره و امکانات تکمیلی را هم می‌بینی. این پرسشنامه تشخیص پزشکی نیست.</p>
  <div class="cip-finder-cards">
   <article class="cip-finder-card"><span class="cip-finder-step">مرحله اول</span><h2>پیشنهاد برنامه</h2><p>نوع نیاز، هدف، سطح همراهی و بررسی شرایط؛ خروجی: برنامه غذایی، ورزشی، ترکیبی یا ارزیابی CIP.</p></article>
   <article class="cip-finder-card"><span class="cip-finder-step">مرحله دوم (اختیاری)</span><h2>پیشنهاد پکیج کامل</h2><p>سابقه پزشکی، اهداف، شرایط، اولویت شروع و نیازهایی که اجرای برنامه را آسان‌تر می‌کند؛ خروجی: سطح سرویس، مدت پیشنهادی و امکانات سازگار.</p></article>
  </div>
  <button class="cip-finder-start" id="cip-start-questionnaire" type="button" aria-haspopup="dialog">شروع پرسشنامه <span aria-hidden="true">←</span></button>
  <div id="cip-finder-status" class="cip-finder-status" role="status" aria-live="polite"></div>
  <div><a class="cip-finder-contact" href="<?php echo esc_url('https://consult.6tofit.com/'); ?>" data-cip-consultation>ترجیح می‌دهم با کارشناس صحبت کنم</a></div>
  <noscript><p>برای باز کردن پرسشنامه، جاوااسکریپت مرورگر را فعال کنید.</p></noscript>
 </div>
</main>
<script>
(function () {
 'use strict';
 document.getElementById('cip-start-questionnaire').addEventListener('click', function () {
  const status = document.getElementById('cip-finder-status');
  if (typeof AFQuestionnaire !== 'undefined' && typeof AFQuestionnaire.open === 'function') {
   status.textContent = '';
   AFQuestionnaire.open();
  } else {
   status.textContent = 'پرسشنامه هنوز بارگذاری نشده است. صفحه را دوباره باز کنید یا از مشاوره رایگان کمک بگیرید.';
  }
 });
}());
</script>
<?php get_footer('cip'); ?>
