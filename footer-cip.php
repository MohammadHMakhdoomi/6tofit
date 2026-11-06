<?php
/** Dedicated CIP footer. Logo: theme mod six2fit_cip_logo_white (image URL). */
defined('ABSPATH') || exit;
?>
<footer class="cip-footer">
 <div class="cip-shell cip-footer-grid">
  <div class="cip-footer-brand"><a class="cip-logo" aria-label="6toFit — خانه" href="<?php echo esc_url(home_url('/')); ?>"><?php $cip_white_logo = get_theme_mod('six2fit_cip_logo_white', ''); if ($cip_white_logo) : ?><img src="<?php echo esc_url($cip_white_logo); ?>" alt="6toFit"><?php else : ?><span class="cip-logo-text">6toFit</span><?php endif; ?></a><p>برنامه‌های شخصی‌سازی‌شده تغذیه و تمرین برای زندگی واقعی.</p></div>
  <nav aria-labelledby="cip-footer-programs"><h2 id="cip-footer-programs">برنامه‌ها</h2><ul><li><a href="<?php echo esc_url(get_permalink(311)); ?>">برنامه غذایی</a></li><li><a href="<?php echo esc_url(get_permalink(238)); ?>">برنامه ورزشی</a></li><li><a href="<?php echo esc_url(get_permalink(315)); ?>">برنامه ترکیبی</a></li><li><a href="<?php echo esc_url(home_url('/cip/')); ?>">CIP</a></li></ul></nav>
  <nav aria-labelledby="cip-footer-account"><h2 id="cip-footer-account">حساب کاربری</h2><ul><li><a href="<?php echo esc_url('https://consult.6tofit.com/'); ?>" data-cip-consultation>مشاوره رایگان</a></li><li><a href="<?php echo esc_url(function_exists('wc_get_account_endpoint_url') ? wc_get_account_endpoint_url('orders') : home_url('/my-account/')); ?>">وضعیت سفارش</a></li><li><a href="<?php echo esc_url(function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/')); ?>">تسویه حساب</a></li></ul></nav>
  <nav aria-labelledby="cip-footer-more"><h2 id="cip-footer-more">بیشتر</h2><ul><li><a href="<?php echo esc_url(home_url('/results/')); ?>">نتایج</a></li><li><a href="<?php echo esc_url(home_url('/blog/')); ?>">بلاگ</a></li><li><a href="<?php echo esc_url(home_url('/review/')); ?>">بازبینی طراحی</a></li></ul></nav>
 </div>
 <div class="cip-shell cip-footer-note">6toFit — همراه تو در مسیر سلامتی</div>
</footer>
<script>
(function () {
 'use strict';
 const header = document.getElementById('cip-site-header');
 if (!header) return;
 const menus = header.querySelectorAll('details');
 document.addEventListener('click', function (event) {
  menus.forEach(function (menu) { if (!menu.contains(event.target)) menu.open = false; });
 });
 header.addEventListener('keydown', function (event) {
  if (event.key !== 'Escape') return;
  const active = document.activeElement;
  const menu = active && active.closest('details[open]');
  if (menu && header.contains(menu)) {
   menu.open = false;
   menu.querySelector('summary').focus();
   event.preventDefault();
  }
 });
 header.addEventListener('click', function (event) {
  if (event.target.closest('a')) menus.forEach(function (menu) { menu.open = false; });
 });
 const desktop = window.matchMedia('(min-width: 1024px)');
 function closeMenus() { menus.forEach(function (menu) { menu.open = false; }); }
 if (desktop.addEventListener) desktop.addEventListener('change', closeMenus);
}());
</script>
<?php wp_footer(); ?>
<script>
 document.addEventListener('click', function(e) {
 const a=e.target.closest && e.target.closest('a'); if(!a)return;
 const u=new URL(a.href,location.href);
 if(a.hasAttribute('data-cip-consultation') || u.hash==='#cip-consultation' || (u.origin===location.origin && u.pathname.replace(/\/+$/,'')==='/auth')) {
 e.preventDefault(); e.stopImmediatePropagation(); location.assign('https://consult.6tofit.com/');
 }
 },true);
 </script>
 <script>
 document.addEventListener('click',function(e){
 const a=e.target.closest && e.target.closest('[data-cip-questionnaire]');
 if(a && typeof AFQuestionnaire!=='undefined' && typeof AFQuestionnaire.open==='function'){
 e.preventDefault(); document.querySelectorAll('#cip-site-header details[open]').forEach(function(m){m.open=false}); AFQuestionnaire.open();
 }
 });
 </script></body></html>