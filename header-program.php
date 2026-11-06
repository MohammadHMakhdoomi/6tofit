<!DOCTYPE html>
<html <?php language_attributes(); ?> lang="fa">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo esc_html( get_the_title() ); ?> | سیکس‌توفیت</title>

  <!-- نمایش فاوآیکون (Favicon) در صفحه تکی محصولات -->
  <?php
  if ( function_exists( ' has_site_icon' ) && has_site_icon() ) {
      wp_site_icon();
  } else {
      echo '<link rel="icon" href="' . esc_url( get_template_directory_uri() . '/assets/img/products/logo.svg' ) . '" type="image/svg+xml">';
      echo '<link rel="shortcut icon" href="' . esc_url( get_template_directory_uri() . '/assets/img/products/logo.svg' ) . '">';
  }
  ?>

  <!-- فراخوانی استایل اصلی -->
  <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/css/products.css">
  <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/css/main.css">
  <!-- فراخوانی اسکریپت -->
  <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/products.js" defer></script>

  <style>
    html, body {
        overflow-x: hidden !important;
        width: 100%;
    }
    body {
        background-color: #f3f4f6;
        margin: 0;
        direction: rtl;
    }
    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color: rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(56px);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      z-index: 50;
      transition: height 0.2s ease;
    }
    .container {
      width: 80%;
      height: 64px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .logo-column {
      width: 64px;
      display: flex;
      align-items: center;
    }
    .logo-column img {
      width: 24px;
      height: 36px;
    }
    nav {
      flex-grow: 1;
      display: flex;
      padding-right: 100px;
      align-items: center;
      font-family: 'IranYekan', sans-serif;
    }
    nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      gap: 24px;
    }
    nav ul li a {
      color: #5A5A61;
      text-decoration: none;
      font-size: 16px;
      font-family: 'IranYekan', sans-serif;
    }
    nav ul li a:hover {
      color: #000000;
      text-decoration: none;
    }
    .empty-column {
      width: 64px;
      display: flex;
      align-items: center;
    }
    .mobile-header, .mobile-nav, .hamburger-menu {
      display: none;
    }
    @media screen and (max-width: 768px) {
      header { height: 108px; }
      header.hidden-nav { height: 64px; }
      .container { display: none; }
      .mobile-header {
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 0 10px;
        box-sizing: border-box;
        background-color: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(56px);
      }
      .mobile-left { width: 15%; display: flex; align-items: center; justify-content: center; }
      .mobile-left img { width: 24px; height: 24px; cursor: pointer; }
      .mobile-center { width: 70%; display: flex; align-items: center; font-size: 20px; font-weight: 500; color: #161618; }
      .mobile-right { width: 15%; display: flex; align-items: center; justify-content: center; }
      .mobile-right img { width: 24px; height: 24px; }
      .mobile-nav {
        display: block;
        height: 44px;
        overflow-x: auto;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        background-color: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(56px);
        transition: opacity 0.3s ease, visibility 0.3s ease;
        opacity: 1;
        visibility: visible;
      }
      .mobile-nav.hidden { opacity: 0; visibility: hidden; display: none; }
      .mobile-nav::-webkit-scrollbar { display: none; }
      .mobile-nav ul { display: inline-flex; gap: 8px; padding: 0 10px; margin: 0; align-items: center; height: 100%; list-style: none; }
      .mobile-nav ul li { padding: 12px; }
      .mobile-nav ul li a { font-size: 14px; color: #5A5A61; text-decoration: none; }
      .mobile-nav ul li.active a { color: #161618; }
    }
    @media screen and (min-width: 769px) {
      .hamburger-menu { display: none !important; }
    }
  </style>
</head>
<body <?php body_class(); ?>>

<?php
// فراخوانی پاپ‌آپ‌ها در جای استاندارد (داخل body به جای بالای head)
include_once __DIR__ . '/template-parts/header-consultation-popup.php';
if ( function_exists( 'render_free_header_consultation_popup' ) ) {
    render_free_header_consultation_popup( "مشاوره رایگان", "ارسال درخواست" );
}
if ( function_exists( 'render_questionnaire_popup' ) ) {
    render_questionnaire_popup();
}
?>

<!-- نوار ناوبری -->
<header>
  <div class="container">
    <div class="logo-column">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/products/logo.svg" alt="لوگو">
      </a>
    </div>
    <nav>
      <ul>
        <li><a href="#description">توضیحات <?php echo esc_html( get_the_title() ); ?></a></li>
        <li id="pro-services-menu"><a href="#services">خدمات پرو</a></li>
        <li><a href="#testimonials">تجربه کاربران قبلی</a></li>
        <li><a href="#programe">نمونه برنامه</a></li>
        <li><a href="#cta">انتخاب بهتر با...</a></li>
        <li><a href="#faq">سوالات متداول</a></li>
      </ul>
    </nav>
    <div class="empty-column"></div>
  </div>

  <div class="mobile-header">
    <div class="mobile-right">
      <a href="/"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/products/arrowrightB.svg" alt="بازگشت"></a>
    </div>
    <div class="mobile-center">
      <?php echo esc_html( get_the_title() ); ?>
    </div>
    <div class="mobile-left">
      <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/products/Hamburger.svg" alt="منوی همبرگری" class="hamburger-icon">
    </div>
  </div>
  <div class="mobile-nav">
    <ul>
      <li class="active"><a href="#description">توضیحات <?php echo esc_html( get_the_title() ); ?></a></li>
      <li id="pro-services-menu-mob"><a href="#services">خدمات پرو</a></li>
      <li><a href="#testimonials">تجربه کاربران قبلی</a></li>
      <li><a href="#programe">نمونه برنامه</a></li>
      <li><a href="#cta">انتخاب بهتر با...</a></li>
      <li><a href="#faq">سوالات متداول</a></li>
    </ul>
  </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const mobileNav = document.querySelector('.mobile-nav');
  const header = document.querySelector('header');
  const main = document.querySelector('main');

  if (!mobileNav || !header) return;

  let lastScrollTop = 0;
  window.addEventListener('scroll', () => {
    let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
    if (currentScroll > lastScrollTop && currentScroll > 0) {
      mobileNav.classList.add('hidden');
      header.classList.add('hidden-nav');
      if (main) main.classList.add('hidden-nav');
    } else if (currentScroll < lastScrollTop) {
      mobileNav.classList.remove('hidden');
      header.classList.remove('hidden-nav');
      if (main) main.classList.remove('hidden-nav');
    }
    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
  }, { passive: true });
});
</script>

<style>
  .hamburger-menu { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: white; z-index: 100; display: none; flex-direction: column; padding: 20px; box-sizing: border-box; transition: opacity 0.3s ease; opacity: 0; }
  .hamburger-menu.active { display: flex; opacity: 1; z-index: 2000; }
  .hamburger-header { display: flex; justify-content: space-between; align-items: center; height: 64px; margin-bottom: 20px; }
  .hamburger-close { width: 15%; display: flex; }
  .hamburger-close img { width: 34px; height: 34px; cursor: pointer; }
  .hamburger-logo { width: 55%; display: flex; justify-content: flex-start; }
  .hamburger-logo img { width: 78px; height: 22px; }
  .hamburger-links { width: 30%; display: flex; justify-content: flex-start; gap: 10px; }
  .hamburger-links a img { width: 48px; height: 48px; }
  .hamburger-menu ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0; }
  .hamburger-menu ul li { display: flex; align-items: center; justify-content: space-between; height: 56px; padding: 0 10px; }
  .hamburger-menu ul li a { font-size: 16px; color: #161618; text-decoration: none; text-align: right; }
  .hamburger-menu ul li img { width: 24px; height: 24px; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const hamburgerIcon = document.querySelector('.hamburger-icon');
  const hamburgerClose = document.querySelector('.hamburger-close');
  const hamburgerMenu = document.querySelector('.hamburger-menu');

  if (!hamburgerIcon || !hamburgerClose || !hamburgerMenu) return;

  hamburgerIcon.addEventListener('click', () => hamburgerMenu.classList.add('active'));
  hamburgerClose.addEventListener('click', () => hamburgerMenu.classList.remove('active'));
});
</script>

<div class="hamburger-menu">
    <div class="hamburger-header">
        <div class="hamburger-close">
            <img src="https://6tofit.com/wp-content/uploads/2025/10/arrowrightB.svg" alt="بستن منو">
        </div>
        <div class="hamburger-logo">
            <img src="https://6tofit.com/wp-content/uploads/2025/10/6toFit_logotype_Black_2.svg" alt="لوگو">
        </div>
        <div class="hamburger-links">
            <a href="javascript:void(0)" onclick="showFreeHeaderConsultationPopup()">
                <img src="https://6tofit.com/wp-content/uploads/2025/10/suport.svg" alt="پشتیبانی">
            </a>
            <?php if ( is_user_logged_in() ) : ?>
                <a id="account-button" class="header-account" href="javascript:void(0);">
                    <img src="https://6tofit.com/wp-content/uploads/2025/10/acount.svg" alt="حساب کاربری">
                </a>
            <?php else : ?>
                <a id="account-button" class="header-account" href="javascript:void(0);" onclick="showAuthPopup(); return false;">
                    <img src="https://6tofit.com/wp-content/uploads/2025/10/acount.svg" alt="حساب کاربری">
                </a>
            <?php endif; ?>
        </div>
    </div>
    <?php
    wp_nav_menu( array(
        'theme_location' => 'primary',
        'menu_class'     => 'mobile-menu',
        'container'      => false,
        'walker'         => new Custom_Mobile_Menu_Walker(),
    ) );
    ?>
</div>

<?php if ( is_user_logged_in() ) : ?>
    <div id="account-menu" class="account-menu">
        <div class="account-menu-header">
            <div class="account-menu-title">پروفایل</div>
            <button type="button" id="account-menu-close" class="account-menu-close">
                <img src="https://6tofit.com/wp-content/uploads/2025/10/mobham.svg" alt="بستن منو">
            </button>
        </div>
        <div class="account-menu-list">
            <a href="#" onclick="showUserInfoPopup(); return false;" class="account-menu-item">
                <span class="account-menu-item-title">اطلاعات کاربری</span>
                <img src="https://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg" alt="">
            </a>
            <a href="javascript:void(0)" class="account-menu-item" onclick="AFMyPrograms.open()">
                <span class="account-menu-item-title">برنامه های من</span>
                <img src="https://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg" alt="">
            </a>
            <a href="javascript:void(0);" class="account-menu-item" onclick="showMyChangesPopup()">
                <span class="account-menu-item-title">تغییرات من</span>
                <img src="https://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg" alt="">
            </a>
            <a href="javascript:void(0)" class="account-menu-item" onclick="AFMyTests.open()">
                <span class="account-menu-item-title">تست های من</span>
                <img src="https://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg" alt="">
            </a>
            <a href="<?php echo esc_url( wc_logout_url() ); ?>" class="account-menu-item account-logout">
                <span class="account-menu-item-title">خروج از حساب کاربری</span>
            </a>
        </div>
    </div>
<?php endif; ?>

<style>
.desktop-account-wrapper { position: relative; }
.desktop-account-button { display: flex; align-items: center; justify-content: center; cursor: pointer; position: relative; z-index: 2; }
.desktop-account-button img { display: block; }
.desktop-account-menu { position: absolute; top: calc(100% + 8px); right: 50%; transform: translateX(50%) translateY(-5px); width: 230px; background: #fff; border-radius: 8px; padding: 8px; box-sizing: border-box; box-shadow: 0 8px 30px rgba(0,0,0,0.10); border: 1px solid #eee; opacity: 0; visibility: hidden; pointer-events: none; transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease; z-index: 99999; }
.desktop-account-menu::after { content: ""; position: absolute; top: -10px; left: 0; width: 100%; height: 10px; background: transparent; }
.desktop-account-wrapper:hover .desktop-account-menu, .desktop-account-wrapper.account-open .desktop-account-menu { opacity: 1; visibility: visible; pointer-events: auto; transform: translateX(50%) translateY(0); }
.desktop-account-item { width: 100%; min-height: 48px; box-sizing: border-box; display: flex; align-items: center; justify-content: space-between; direction: rtl; text-decoration: none; color: #161618; font-size: 14px; font-weight: 500; transition: background-color 0.2s ease; }
.desktop-account-item:hover { background-color: #f7f7f7; }
.desktop-account-item span { white-space: nowrap; text-align: right; }
.desktop-account-item img { width: 18px!important; height: 18px!important; object-fit: contain; flex-shrink: 0; }
.desktop-account-item.desktop-account-logout { justify-content: flex-start; margin-top: 4px; padding-top: 8px; padding-bottom: 8px; }
.desktop-account-item.desktop-account-logout span { color: #e53935; }
.account-menu { position: fixed; top: 0; right: 0; width: 100%; height: 100vh; background: #fff; z-index: 99999; display: flex; flex-direction: column; box-sizing: border-box; padding: 20px; opacity: 0; visibility: hidden; transform: translateX(100%); transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s ease; }
.account-menu.active { opacity: 1; visibility: visible; transform: translateX(0); }
.account-menu-header { width: 100%; height: 64px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; margin-bottom: 20px; }
.account-menu-title { font-size: 18px; font-weight: 700; color: #161618; text-align: right; }
.account-menu-close { width: 40px; height: 40px; padding: 0; margin: 0; border: none; background: transparent; display: flex; align-items: center; justify-content: center; cursor: pointer; }
.account-menu-close img { width: 32px; height: 32px; display: block; }
.account-menu-list { width: 100%; display: flex; flex-direction: column; gap: 0; }
.account-menu-item { width: 100%; min-height: 64px; display: flex; align-items: center; justify-content: space-between; box-sizing: border-box; text-decoration: none; direction: rtl; transition: background 0.2s ease; }
.account-menu-item-title { font-size: 16px; font-weight: 700; color: #161618; text-align: right; }
.account-menu-item > img { width: 20px; height: 20px; object-fit: contain; flex-shrink: 0; }
.account-menu-item:hover { background: #fafafa; }
.account-menu-item.account-logout { border-bottom: none; justify-content: flex-start; margin-top: 10px; }
.account-menu-item.account-logout .account-menu-item-title { color: #E53935; }
@media (min-width: 768px) { .account-menu { display: none !important; } }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const accountBtn = document.getElementById('account-button');
    const accountMenu = document.getElementById('account-menu');
    const accountClose = document.getElementById('account-menu-close');
    if (!accountBtn || !accountMenu) return;

    function openAccountMenu() { accountMenu.classList.add('active'); document.body.style.overflow = 'hidden'; }
    function closeAccountMenu() { accountMenu.classList.remove('active'); document.body.style.overflow = ''; }

    accountBtn.addEventListener('click', function (e) { e.preventDefault(); openAccountMenu(); });
    if (accountClose) accountClose.addEventListener('click', closeAccountMenu);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeAccountMenu(); });
    accountMenu.querySelectorAll('.account-menu-item').forEach(function (link) {
        link.addEventListener('click', closeAccountMenu);
    });
});
</script>