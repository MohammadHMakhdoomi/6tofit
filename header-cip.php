<?php
/** Dedicated CIP header. Logo: theme mod six2fit_cip_logo_black (image URL). */
defined('ABSPATH') || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php if (!current_theme_supports('title-tag')) : ?><title><?php echo esc_html(wp_get_document_title()); ?></title><?php endif; ?>
<?php wp_head(); ?>
<style>
body.cip-site{margin:0;background:#fff;color:#101014;font-family:'iranyekanen',Tahoma,sans-serif}
.cip-site .cip-header,.cip-site .cip-footer{direction:rtl;text-align:right;font-family:'iranyekanen',Tahoma,sans-serif;line-height:1.8}
.cip-header *,.cip-footer *{box-sizing:border-box}
.cip-header a,.cip-footer a{color:inherit;text-decoration:none}
.cip-header a:focus-visible,.cip-header summary:focus-visible,.cip-footer a:focus-visible{outline:3px solid #5247ff;outline-offset:4px;border-radius:8px}
.cip-shell{width:100%;max-width:1200px;margin-inline:auto;padding-inline:32px}
.cip-header{position:sticky;top:0;z-index:999;border-bottom:1px solid #e7e7eb;background:rgba(255,255,255,.94);backdrop-filter:blur(16px);color:#101014}
.admin-bar .cip-header{top:32px}
.cip-header-row{height:72px;display:flex;align-items:center;gap:16px}
.cip-site .cip-logo{display:inline-flex;align-items:center;flex-shrink:0;line-height:1}
.cip-logo img{display:block;width:auto;height:28px;max-width:180px;object-fit:contain}
.cip-logo-text{font:800 36px/1 Arial,sans-serif;direction:ltr;letter-spacing:-1.5px}

/* ---- Navigation (WP Menu) ---- */
.cip-desktop-nav{display:flex;flex:1;align-items:center;justify-content:center}
.cip-desktop-menu{display:flex;align-items:center;justify-content:center;gap:2px;list-style:none;margin:0;padding:0}
.cip-desktop-menu > li{position:relative}
.cip-desktop-menu > li > a{display:block;padding:8px 14px;border-radius:999px;font-size:14px;white-space:nowrap;transition:background .15s,color .15s}
.cip-desktop-menu > li > a:hover{background:#f5f5f7}
.cip-desktop-menu > li.current-menu-item > a,
.cip-desktop-menu > li > a[aria-current="page"]{color:#5247ff;font-weight:700}
.cip-desktop-menu ul.sub-menu{position:absolute;top:100%;inset-inline-end:0;min-width:224px;padding:8px;margin:0;list-style:none;background:#fff;border:1px solid #e7e7eb;border-radius:18px;box-shadow:0 12px 36px #10101414;opacity:0;visibility:hidden;transform:translateY(-6px);transition:.18s ease;z-index:20}
.cip-desktop-menu li:hover > ul.sub-menu,
.cip-desktop-menu li:focus-within > ul.sub-menu{opacity:1;visibility:visible;transform:translateY(0)}
.cip-desktop-menu ul.sub-menu a{display:block;padding:10px 12px;font-size:14px;border-radius:10px}
.cip-desktop-menu ul.sub-menu a:hover{background:#f5f5f7}

/* ---- Header buttons ---- */
.cip-header-actions{display:flex;align-items:center;gap:8px}
.cip-header .cip-header-button{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:36px;padding:7px 16px;border:1px solid #dcdce2;border-radius:999px;background:#fff;font-size:13px;font-weight:500;white-space:nowrap;line-height:1.5;cursor:pointer;font-family:inherit}
.cip-header .cip-header-button:hover{background:#f5f5f7}
.cip-header .cip-header-primary{color:#fff;background:#5247ff;border-color:#5247ff}
.cip-header .cip-header-primary:hover{background:#453bdc}
.cip-header-icon{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round}

/* ---- Account dropdown ---- */
.cip-account-wrapper{position:relative}
.cip-account-menu{position:absolute;top:calc(100% + 8px);inset-inline-end:0;width:236px;padding:8px;background:#fff;border:1px solid #e7e7eb;border-radius:14px;box-shadow:0 10px 30px rgba(16,16,20,.10);opacity:0;visibility:hidden;pointer-events:none;transform:translateY(-6px);transition:.18s ease;z-index:100001;direction:rtl}
.cip-account-wrapper.open .cip-account-menu,
.cip-account-wrapper:hover .cip-account-menu{opacity:1;visibility:visible;pointer-events:auto;transform:translateY(0)}
.cip-account-menu a{display:flex;align-items:center;justify-content:space-between;padding:10px 12px;font-size:14px;color:#161618;border-radius:8px;transition:background .15s}
.cip-account-menu a:hover{background:#f5f5f7}
.cip-account-menu a.cip-account-logout{color:#e53935;margin-top:4px;border-top:1px solid #eee;border-radius:0 0 8px 8px}
.cip-account-menu a.cip-account-logout:hover{background:#fff5f5}

/* ---- Mobile menu ---- */
.cip-mobile-menu{display:none}
.cip-mobile-toggle{width:40px;height:40px;border:1px solid #e2e2e7;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;list-style:none}
.cip-mobile-toggle::-webkit-details-marker{display:none}
.cip-mobile-toggle svg{width:20px;height:20px}
.cip-menu-close{display:none}
.cip-mobile-menu[open] .cip-menu-close{display:block}
.cip-mobile-menu[open] .cip-menu-open{display:none}
.cip-mobile-panel{position:absolute;top:100%;left:0;right:0;padding:16px 20px 24px;background:#fff;border-bottom:1px solid #e7e7eb;box-shadow:0 14px 24px #1010140d;max-height:calc(100dvh - 118px);overflow:auto}
.cip-mobile-nav{display:flex;flex-direction:column;gap:4px;max-width:1136px;margin:auto}
.cip-mobile-menu-list{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:2px}
.cip-mobile-menu-list li a{display:block;padding:10px 12px;border-radius:10px;font-size:14px}
.cip-mobile-menu-list li a:hover{background:#f5f5f7}
.cip-mobile-menu-list ul.sub-menu{list-style:none;margin:0;padding:0 16px 4px 0;display:flex;flex-direction:column;gap:2px}
.cip-mobile-menu-list ul.sub-menu li a{font-size:13px;padding:8px 12px;color:#52525a}
.cip-mobile-cta{display:flex;flex-direction:column;gap:8px;padding:16px 12px 0;border-top:1px solid #eee;margin-top:12px}
.cip-mobile-cta .cip-header-button{width:100%;justify-content:center}

/* ---- Skip link ---- */
.cip-skip-link{position:fixed;top:-100px;right:20px;z-index:100001;background:#fff;color:#101014;padding:10px 18px;border:2px solid #5247ff;border-radius:10px}
.cip-skip-link:focus{top:12px}

/* ---- Footer (unchanged) ---- */
.cip-footer{background:#0d0d0d;color:#fff;border-top:1px solid #242424;padding-block:48px}
.cip-footer-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:40px}
.cip-footer h2{font-family:inherit;font-size:14px;font-weight:600;line-height:1.8;color:#fff;margin:0 0 16px}
.cip-footer p{font-size:14px;color:#ffffff99;line-height:2;margin:16px 0 0;max-width:280px}
.cip-footer ul{list-style:none;padding:0;margin:0}
.cip-footer li+li{margin-top:12px}
.cip-footer li a{font-size:14px;color:#ffffff99}
.cip-footer li a:hover{color:#fff}
.cip-footer .cip-footer-note{margin-top:40px;font-size:12px;color:#ffffff66}

/* ---- Responsive ---- */
@media(max-width:1100px){
  .cip-desktop-menu > li > a{padding-inline:9px;font-size:13px}
  .cip-header-row{gap:12px}
  .cip-header .cip-header-button{padding-inline:12px}
}
@media(max-width:1023px){
  .cip-desktop-nav{display:none}
  .cip-header-actions{margin-inline-start:auto}
  .cip-mobile-menu{display:block}
}
@media(max-width:782px){.admin-bar .cip-header{top:46px}}
@media(max-width:767px){
  .cip-shell{padding-inline:20px}
  .cip-header-row{height:64px}
  .cip-logo img{height:24px}
  .cip-logo-text{font-size:31px}
  .cip-header-actions > .cip-header-button,
  .cip-header-actions > .cip-account-wrapper{display:none}
  .cip-footer-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:32px}
  .cip-footer-brand{grid-column:1/-1}
}
@media(max-width:600px){.admin-bar .cip-header{top:0}}
@media(max-width:380px){
  .cip-footer-grid{grid-template-columns:1fr}
  .cip-mobile-cta .cip-header-button{width:100%}
}
@media(prefers-reduced-motion:reduce){
  .cip-desktop-menu ul.sub-menu,.cip-account-menu,.cip-chevron{transition:none}
}
</style>
</head>
<body <?php body_class('cip-site'); ?>>
<?php wp_body_open(); ?>

<?php
// ---- Popups (same as main header.php) ----
include __DIR__ . '/template-parts/header-consultation-popup.php';
render_free_header_consultation_popup("مشاوره رایگان", "ارسال درخواست");

include __DIR__ . '/template-parts/login-signup.php';
render_auth_popup("ورود / ثبت‌نام", "ادامه");

include __DIR__ . '/template-parts/user-information.php';
render_user_info_popup("اطلاعات کاربری", "ادامه");

include __DIR__ . '/template-parts/my-changes.php';
?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    <?php render_my_changes_popup(); ?>
});
</script>

<a class="cip-skip-link" href="#cip-page">رفتن به محتوای اصلی</a>
<header class="cip-header" id="cip-site-header">
  <div class="cip-shell cip-header-row">

    <a class="cip-logo" aria-label="6toFit — خانه" href="<?php echo esc_url(home_url('/')); ?>">
      <?php $cip_black_logo = get_theme_mod('six2fit_cip_logo_black', ''); ?>
      <?php if ($cip_black_logo) : ?>
        <img src="<?php echo esc_url($cip_black_logo); ?>" alt="6toFit">
      <?php else : ?>
        <span class="cip-logo-text">6toFit</span>
      <?php endif; ?>
    </a>

    <nav class="cip-desktop-nav" aria-label="ناوبری اصلی">
      <?php
      wp_nav_menu( array(
          'menu'           => 'cip',
          'menu_class'     => 'cip-desktop-menu',
          'menu_id'        => 'cip-desktop-navigation',
          'container'      => false,
          'fallback_cb'    => false,
          'depth'          => 2,
      ) );
      ?>
    </nav>

    <div class="cip-header-actions">

      <?php if ( is_user_logged_in() ) : ?>
        <div class="cip-account-wrapper" id="cip-account-wrapper">
          <a
            class="cip-header-button cip-account-button"
            id="cip-account-button"
            href="javascript:void(0)"
            aria-label="حساب کاربری"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <svg class="cip-header-icon" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
            حساب کاربری
          </a>

          <div class="cip-account-menu" id="cip-account-menu" role="menu">
            <a href="#" role="menuitem" onclick="showUserInfoPopup(); return false;">
              <span>اطلاعات کاربری</span>
              <svg class="cip-header-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <a href="javascript:void(0)" role="menuitem" onclick="AFMyPrograms.open()">
              <span>برنامه های من</span>
              <svg class="cip-header-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <a href="javascript:void(0)" role="menuitem" onclick="showMyChangesPopup()">
              <span>تغییرات من</span>
              <svg class="cip-header-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <a href="javascript:void(0)" role="menuitem" onclick="AFMyTests.open()">
              <span>تست های من</span>
              <svg class="cip-header-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <a href="<?php echo esc_url( wc_logout_url() ); ?>" class="cip-account-logout" role="menuitem">
              <span>خروج از حساب کاربری</span>
            </a>
          </div>
        </div>
      <?php else : ?>
        <a
          class="cip-header-button"
          href="javascript:void(0)"
          onclick="showAuthPopup(); return false;"
        >
          <svg class="cip-header-icon" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
          ورود / ثبت‌نام
        </a>
      <?php endif; ?>

      <a class="cip-header-button cip-header-primary" href="<?php echo esc_url(home_url('/program-finder/')); ?>" data-cip-questionnaire>
        پیدا کردن برنامه مناسب
      </a>

      <details class="cip-mobile-menu">
        <summary class="cip-mobile-toggle" aria-label="منوی اصلی">
          <svg class="cip-header-icon cip-menu-open" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M4 5h16M4 12h16M4 19h16"/>
          </svg>
          <svg class="cip-header-icon cip-menu-close" viewBox="0 0 24 24" aria-hidden="true">
            <path d="m6 6 12 12M6 18 18 6"/>
          </svg>
        </summary>
        <div class="cip-mobile-panel">
          <nav class="cip-mobile-nav" aria-label="ناوبری موبایل">
            <?php
            wp_nav_menu( array(
                'menu'           => 'cip',
                'menu_class'     => 'cip-mobile-menu-list',
                'menu_id'        => 'cip-mobile-navigation',
                'container'      => false,
                'fallback_cb'    => false,
                'depth'          => 2,
            ) );
            ?>
            <div class="cip-mobile-cta">
              <?php if ( is_user_logged_in() ) : ?>
                <a class="cip-header-button" href="#" onclick="showUserInfoPopup(); return false;">اطلاعات کاربری</a>
                <a class="cip-header-button" href="javascript:void(0)" onclick="AFMyPrograms.open()">برنامه های من</a>
                <a class="cip-header-button" href="javascript:void(0)" onclick="showMyChangesPopup()">تغییرات من</a>
                <a class="cip-header-button" href="javascript:void(0)" onclick="AFMyTests.open()">تست های من</a>
                <a class="cip-header-button cip-header-primary" href="<?php echo esc_url( wc_logout_url() ); ?>">خروج از حساب کاربری</a>
              <?php else : ?>
                <a class="cip-header-button" href="javascript:void(0)" onclick="showAuthPopup(); return false;">ورود / ثبت‌نام</a>
              <?php endif; ?>
              <a class="cip-header-button cip-header-primary" href="<?php echo esc_url(home_url('/program-finder/')); ?>" data-cip-questionnaire>
                پیدا کردن برنامه مناسب
              </a>
            </div>
          </nav>
        </div>
      </details>

    </div>
  </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ---- Account dropdown toggle ----
    const accountButton  = document.getElementById('cip-account-button');
    const accountWrapper = document.getElementById('cip-account-wrapper');

    if (accountButton && accountWrapper) {
        accountButton.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const opened = accountWrapper.classList.toggle('open');
            accountButton.setAttribute('aria-expanded', opened ? 'true' : 'false');
        });

        document.addEventListener('click', function (e) {
            if (!accountWrapper.contains(e.target)) {
                accountWrapper.classList.remove('open');
                accountButton.setAttribute('aria-expanded', 'false');
            }
        });

        // Close dropdown when a menu item is clicked
        accountWrapper.querySelectorAll('.cip-account-menu a').forEach(function (link) {
            link.addEventListener('click', function () {
                accountWrapper.classList.remove('open');
                accountButton.setAttribute('aria-expanded', 'false');
            });
        });
    }

    // ---- Close mobile menu when a popup trigger is clicked ----
    const mobileMenu = document.querySelector('.cip-mobile-menu');
    if (mobileMenu) {
        mobileMenu.querySelectorAll('[onclick]').forEach(function (el) {
            el.addEventListener('click', function () {
                mobileMenu.removeAttribute('open');
            });
        });
    }
});
</script>