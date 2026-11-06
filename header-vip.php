<?php
/**
 * Header template for VIP page
 */
 		  include __DIR__ . '/template-parts/login-signup.php';
		    // Render the auth popup
  render_auth_popup("ورود / ثبت‌نام", "ادامه");

    include __DIR__ . '/template-parts/user-information.php';
	  // Render the user info popup
  render_user_info_popup("اطلاعات کاربری", "ادامه");

include __DIR__ . '/template-parts/my-changes.php';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="vip-site-header">
    <div class="vip-container">
        <div class="vip-header-grid">
            <!-- Left Column: Logo -->
            <div class="vip-header-left">
                <a href="<?php echo esc_url( home_url('/') ); ?>">
                    <img src="http://6tofit.com/wp-content/uploads/2025/10/6toFit_logotype_white_2.svg" alt="<?php bloginfo('name'); ?>">
                </a>
            </div>
            <!-- Center Column: Menu -->
            <div class="vip-header-center">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'vip-primary-menu',
                    'container'      => false,
                ) );
                ?>
            </div>
            <!-- Hamburger Icon for Mobile -->
            <div class="vip-hamburger-icon">
                <img src="http://6tofit.com/wp-content/uploads/2025/10/mobham.svg" alt="منوی همبرگر">
            </div>
            <!-- Right Column: Account & Support -->
            <div class="vip-header-right">
                <div class="vip-header-right-item">
                                     <?php if ( is_user_logged_in() ) : ?>

        <a
            href="javascript:void(0)"
            class="desktop-account-button"
            id="desktop-account-button"
            aria-label="حساب کاربری"
        >
            <img
                src="http://6tofit.com/wp-content/uploads/2025/10/headeracount.svg"
                alt="حساب کاربری"
            >
        </a>

        <!-- منوی حساب کاربری -->
        <div class="desktop-account-menu" id="desktop-account-menu">

            <a
               href="#" onclick="showUserInfoPopup(); return false;"
                class="desktop-account-item"
            >
                <span>اطلاعات کاربری</span>

                <img
                    src="http://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg"
                    alt=""
                >
            </a>


            <a
                    href="javascript:void(0)"
                class="desktop-account-item"
				    onclick="AFMyPrograms.open()"
            >
                <span>برنامه های من</span>

                <img
                    src="http://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg"
                    alt=""
                >
            </a>


          <a
    href="javascript:void(0);"
    class="desktop-account-item"
    onclick="showMyChangesPopup()"
>
    <span>تغییرات من</span>

    <img
        src="http://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg"
        alt=""
    >
</a>


            <a
                   href="javascript:void(0)"
                class="desktop-account-item"
				    onclick="AFMyTests.open()"
            >
                <span>تست های من</span>

                <img
                    src="http://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg"
                    alt=""
                >
            </a>


            <a
                href="<?php echo esc_url( wc_logout_url() ); ?>"
                class="desktop-account-item desktop-account-logout"
            >
                <span>خروج از حساب کاربری</span>
            </a>

        </div>

    <?php else : ?>

        <a
            href="javascript:void(0)"
            onclick="showAuthPopup(); return false;"
            class="desktop-account-button"
        >
            <img
                src="http://6tofit.com/wp-content/uploads/2025/10/headeracount.svg"
                alt="حساب کاربری"
            >
        </a>

    <?php endif; ?>
	<script>
document.addEventListener('DOMContentLoaded', function () {

    const accountButton = document.getElementById('desktop-account-button');
    const accountWrapper = document.querySelector('.vip-header-right-item');

    if (!accountButton || !accountWrapper) {
        return;
    }

   accountButton.addEventListener('click', function (e) {

    e.preventDefault();

    e.stopPropagation();

    accountWrapper.classList.toggle('account-open');

});


    // کلیک بیرون از منو
document.addEventListener('click', function (e) {

    if (!accountWrapper.contains(e.target)) {

        accountWrapper.classList.remove('account-open');

    }

});

});
</script>
                </div>
                <div class="vip-header-right-item">
                    <a href="javascript:void(0)" onclick="showFreeVipConsultationPopup()"><img src="http://6tofit.com/wp-content/uploads/2025/10/headersupp.svg" alt="پشتیبانی"></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Hamburger Menu -->
    <div class="vip-hamburger-menu">
        <div class="vip-hamburger-header">
            <div class="vip-hamburger-close">
                <img src="http://6tofit.com/wp-content/uploads/2025/10/arrowrightB.svg" alt="بستن منو">
            </div>
            <div class="vip-hamburger-logo">
                <img src="http://6tofit.com/wp-content/uploads/2025/10/6toFit_logotype_Black_2.svg" alt="لوگو">
            </div>
            <div class="vip-hamburger-links">
                <a href="javascript:void(0)" onclick="showFreeVipConsultationPopup()"><img src="http://6tofit.com/wp-content/uploads/2025/10/suport.svg" alt="پشتیبانی"></a>
                  <?php if ( is_user_logged_in() ) : ?>

    <!-- کاربر لاگین است -->
    <a id="account-button"
       class="header-account"
       href="javascript:void(0);">

        <img
            src="http://6tofit.com/wp-content/uploads/2025/10/acount.svg"
            alt="حساب کاربری"
        >

    </a>

<?php else : ?>

    <!-- کاربر لاگین نیست -->
    <a id="account-button"
       class="header-account"
       href="javascript:void(0);"
       onclick="showAuthPopup(); return false;">

        <img
            src="http://6tofit.com/wp-content/uploads/2025/10/acount.svg"
            alt="حساب کاربری"
        >

    </a>

<?php endif; ?>
            </div>
        </div>
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_class'     => 'product-mobile-menu',
            'container'      => false,
            'walker'         => new Custom_Mobile_Menu_Walker(),
        ) );
        ?>
    </div>
	<?php if ( is_user_logged_in() ) : ?>

    <!-- منوی حساب کاربری -->
    <div id="account-menu" class="account-menu">

        <!-- هدر منوی حساب -->
        <div class="account-menu-header">

            <!-- عنوان -->
            <div class="account-menu-title">
                پروفایل
            </div>

            <!-- دکمه بستن -->
            <button type="button" id="account-menu-close" class="account-menu-close">
                <img 
                    src="http://6tofit.com/wp-content/uploads/2025/10/mobham.svg"
                    alt="بستن منو"
                >
            </button>

        </div>


        <!-- لیست -->
        <div class="account-menu-list">

            <!-- اطلاعات کاربری -->
            <a href="#" onclick="showUserInfoPopup(); return false;" class="account-menu-item">

                <span class="account-menu-item-title">
                    اطلاعات کاربری
                </span>

                <img 
                    src="http://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg"
                    alt=""
                >

            </a>


            <!-- برنامه های من -->
            <a         href="javascript:void(0)" class="account-menu-item"     onclick="AFMyPrograms.open()">

                <span class="account-menu-item-title">
                    برنامه های من
                </span>

                <img 
                    src="http://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg"
                    alt=""
                >

            </a>


            <!-- تغییرات من -->
            <a  href="javascript:void(0);"
    class="desktop-account-item"
    onclick="showMyChangesPopup()" class="account-menu-item">

                <span class="account-menu-item-title">
                    تغییرات من
                </span>

                <img 
                    src="http://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg"
                    alt=""
                >

            </a>


            <!-- تست های من -->
            <a     href="javascript:void(0)" class="account-menu-item"     onclick="AFMyTests.open()">

                <span class="account-menu-item-title">
                    تست های من
                </span>

                <img 
                    src="http://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg"
                    alt=""
                >

            </a>


            <!-- خروج -->
            <a href="<?php echo esc_url( wc_logout_url() ); ?>" class="account-menu-item account-logout">

                <span class="account-menu-item-title">
                    خروج از حساب کاربری
                </span>

            </a>

        </div>

    </div>

<?php endif; ?>
<style>
/* =========================================
   DESKTOP ACCOUNT
========================================= */

.vip-header-right-item {
    position: relative;
}


/* دکمه */

.desktop-account-button {
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
    z-index: 2;
}

.desktop-account-button img {
    display: block;
}


/* =========================================
   ACCOUNT MENU
========================================= */

.desktop-account-menu {

    position: absolute;

    top: calc(100% + 8px);

    right: 50%;

    transform: translateX(50%) translateY(-5px);

    width: 230px;

    background: #fff;

    border-radius: 8px;

    padding: 8px 8px;

    box-sizing: border-box;

    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.10);

    border: 1px solid #eeeeee;

    opacity: 0;

    visibility: hidden;

    pointer-events: none;

    transition:
        opacity 0.2s ease,
        transform 0.2s ease,
        visibility 0.2s ease;

    z-index: 99999;
}


/*
 * پل ارتباطی بین آیکن و منو
 * باعث میشه وقتی موس از آیکن به منو میره
 * Hover قطع نشه
 */

.desktop-account-menu::after {

    content: "";

    position: absolute;

    top: -10px;

    left: 0;

    width: 100%;

    height: 10px;

    background: transparent;
}

/* =========================================
   HOVER
========================================= */

.vip-header-right-item:hover .desktop-account-menu {

    opacity: 1;

    visibility: visible;

    pointer-events: auto;

    transform: translateX(50%) translateY(0);
}


/* =========================================
   CLICK
========================================= */

.vip-header-right-item.account-open .desktop-account-menu {

    opacity: 1;

    visibility: visible;

    pointer-events: auto;

    transform: translateX(50%) translateY(0);
}
.userinfo-popup-content{
	max-height: 90%;
}
.auth-popup-content {
    background: #F7F7F8;
    border-radius: 40px;
    text-align: center;
    max-height: 85%;
}
.auth-stage-1-right {
    padding: 10px 24px;
}
.auth-stage-1-wrapper{
	     height: unset; 
     min-height: unset;
}
/* =========================================
   ITEMS
========================================= */

.desktop-account-item {

    width: 100%;

    min-height: 48px;

 

    box-sizing: border-box;

    display: flex;

    align-items: center;

    justify-content: space-between;

    direction: rtl;

    text-decoration: none;

    color: #161618;

    font-size: 14px;

    font-weight: 500;

    transition: background-color 0.2s ease;
}


.desktop-account-item:hover {

    background-color: #f7f7f7;
}


.desktop-account-item span {

    white-space: nowrap;

    text-align: right;
}


/* آیکن فلش */

.desktop-account-item img {

    width: 18px!important;

    height: 18px!important;

    object-fit: contain;

    flex-shrink: 0;
}


/* =========================================
   LOGOUT
========================================= */

.desktop-account-item.desktop-account-logout {

    justify-content: flex-start;

    margin-top: 4px;


    padding-top: 8px;

    padding-bottom: 8px;
}


.desktop-account-item.desktop-account-logout span {

    color: #e53935;
}
/* =========================================
   ACCOUNT MENU - MOBILE
========================================= */

.account-menu {

    position: fixed;

    top: 0;
    right: 0;

    width: 100%;
    height: 100vh;

    background: #fff;

    z-index: 99999;

    display: flex;
    flex-direction: column;

    box-sizing: border-box;

    padding: 20px;

    /* حالت بسته */
    opacity: 0;
    visibility: hidden;
    transform: translateX(100%);

    transition:
        opacity 0.3s ease,
        transform 0.3s ease,
        visibility 0.3s ease;
}


/* حالت باز */

.account-menu.active {

    opacity: 1;

    visibility: visible;

    transform: translateX(0);

}


/* =========================================
   HEADER
========================================= */

.account-menu-header {

    width: 100%;

    height: 64px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    flex-shrink: 0;

    margin-bottom: 20px;
}


/* عنوان پروفایل */

.account-menu-title {

    font-size: 18px;

    font-weight: 700;

    color: #161618;

    text-align: right;
}


/* دکمه بستن */

.account-menu-close {

    width: 40px;

    height: 40px;

    padding: 0;

    margin: 0;

    border: none;

    background: transparent;

    display: flex;

    align-items: center;

    justify-content: center;

    cursor: pointer;
}


.account-menu-close img {

    width: 32px;

    height: 32px;

    display: block;
}


/* =========================================
   LIST
========================================= */

.account-menu-list {

    width: 100%;

    display: flex;

    flex-direction: column;

    gap: 0;
}


/* هر آیتم */

.account-menu-item {

    width: 100%;

    min-height: 64px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    box-sizing: border-box;

 

    text-decoration: none;
    direction: rtl;

    transition: background 0.2s ease;
}


/* عنوان */

.account-menu-item-title {

    font-size: 16px;

    font-weight: 700;

    color: #161618;

    text-align: right;
}


/* آیکن سمت چپ */

.account-menu-item > img {

    width: 20px;

    height: 20px;

    object-fit: contain;

    flex-shrink: 0;
}


/* Hover */

.account-menu-item:hover {

    background: #fafafa;

}


/* =========================================
   LOGOUT
========================================= */

.account-menu-item.account-logout {

    border-bottom: none;

    justify-content: flex-start;

    margin-top: 10px;
}


.account-menu-item.account-logout .account-menu-item-title {

    color: #E53935;

}


/* =========================================
   MOBILE
========================================= */

@media (min-width: 768px) {

    .account-menu {

        display: none !important;

    }

}

</style>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const accountBtn = document.getElementById('account-button');

    const accountMenu = document.getElementById('account-menu');

    const accountClose = document.getElementById('account-menu-close');


    if (!accountBtn || !accountMenu) {
        return;
    }


    // جلوگیری از رفتن به لینک My Account
    accountBtn.addEventListener('click', function (e) {

        e.preventDefault();

        openAccountMenu();

    });


    // باز کردن منو
    function openAccountMenu() {

        accountMenu.classList.add('active');

        document.body.style.overflow = 'hidden';

    }


    // بستن منو
    function closeAccountMenu() {

        accountMenu.classList.remove('active');

        document.body.style.overflow = '';

    }


    // دکمه بستن
    if (accountClose) {

        accountClose.addEventListener('click', function () {

            closeAccountMenu();

        });

    }


    // بستن با ESC
    document.addEventListener('keydown', function (e) {

        if (e.key === 'Escape') {

            closeAccountMenu();

        }

    });


    // وقتی روی لینک‌های منو کلیک شد
    // منو بسته شود
    const menuLinks = accountMenu.querySelectorAll(
        '.account-menu-item'
    );

    menuLinks.forEach(function (link) {

        link.addEventListener('click', function () {

            closeAccountMenu();

        });

    });

});

</script>
</header>
<style>
/* General Header Styles */
.vip-site-header {
    background:#101012;
   
   
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
}

.vip-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 15px;
}

/* Desktop Header Grid */
.vip-header-grid {
    display: grid;
    grid-template-columns: 1fr 3fr 1fr;
    align-items: center;
    padding: 15px 0;
}

.vip-header-center {
    order: 2;
}

/* Left Column: Logo */
.vip-header-left {
    display: flex;
    justify-content: flex-end;
    order: 3;
}

.vip-header-left img {
    max-width: 100px; /* Adjust as needed */
    height: auto;
}

.vip-primary-menu ul {
    display: inline-flex;
    gap: 9px;
    font-family: ir;
}

/* Center Column: Menu */
.vip-header-center .vip-primary-menu {
    list-style: none !important; /* حذف بولت‌ها با اولویت بالا */
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: row; /* نمایش افقی */
    justify-content: center;
    gap: 40px;
}

.vip-header-center .vip-primary-menu li {
    list-style: none !important; /* حذف بولت‌ها برای آیتم‌های منو */
}

.vip-header-center .vip-primary-menu li a {
    color: #fff;
    font-size: 16px;
    font-weight: 400;
    text-decoration: none;
    transition: color 0.3s;
}

.vip-header-center .vip-primary-menu li a:hover {
    color: #ddd;
}

/* Right Column: Account & Support */
.vip-header-right {
    display: grid;
    grid-template-columns: 1fr 4fr;
    gap: 10px;
    justify-items: flex-start;
    order: 1;
}

.vip-header-right-item img {
    width: 40px; /* Adjust as needed */
    height: auto;
}

/* Hamburger Icon (Visible on Mobile) */
.vip-hamburger-icon {
    display: none;
}

.vip-hamburger-icon img {
    width: 30px;
    height: auto;
    cursor: pointer;
}

/* Mobile Hamburger Menu */
.vip-hamburger-menu {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background-color: white;
    z-index: 100;
    display: none;
    flex-direction: column;
    padding: 20px;
    box-sizing: border-box;
    transition: opacity 0.3s ease;
    opacity: 0;
}

.vip-hamburger-menu.active {
    display: flex;
    opacity: 1;
    z-index: 2000;
}

.vip-hamburger-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 64px;
    margin-bottom: 20px;
}

.vip-hamburger-close {
    width: 15%;
}

.vip-hamburger-close img {
    width: 34px;
    height: 34px;
    cursor: pointer;
}

.vip-hamburger-logo {
    width: 55%;
    display: flex;
    justify-content: flex-start;
}

.vip-hamburger-logo img {
    width: 78px;
    height: 22px;
}

.vip-hamburger-links {
    width: 30%;
    display: flex;
    justify-content: flex-start;
    gap: 10px;
}

.vip-hamburger-links a img {
    width: 48px;
    height: 48px;
}

.vip-hamburger-menu ul.vip-mobile-menu {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0;
}

.vip-hamburger-menu ul.vip-mobile-menu li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 56px;
    padding: 0 10px;
}

.vip-hamburger-menu ul.vip-mobile-menu li a {
    font-size: 16px;
    color: #161618;
    text-decoration: none;
    text-align: right;
    font-weight: 700;
}

.vip-hamburger-menu ul.vip-mobile-menu li img {
    width: 24px;
    height: 24px;
}

/* Mobile Layout */
@media (max-width: 768px) {
    .vip-header-grid {
        display: grid;
        grid-template-columns: auto auto;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
    }

    .vip-header-left {
        margin-right: 10px;
        order: 2;
    }

    .vip-header-left img {
        max-width: 80px; /* Adjust for mobile */
    }

    .vip-header-center,
    .vip-header-right {
        display: none;
    }

    .vip-hamburger-icon {
        display: block;
        margin-left: 10px;
        order: 2;
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const hamburgerIcon = document.querySelector('.vip-hamburger-icon');
    const hamburgerClose = document.querySelector('.vip-hamburger-close');
    const hamburgerMenu = document.querySelector('.vip-hamburger-menu');

    if (!hamburgerIcon || !hamburgerClose || !hamburgerMenu) {
        console.error('یکی از المنت‌های vip-hamburger-icon، vip-hamburger-close یا vip-hamburger-menu پیدا نشد!');
        return;
    }

    hamburgerIcon.addEventListener('click', () => {
        hamburgerMenu.classList.add('active');
    });

    hamburgerClose.addEventListener('click', () => {
        hamburgerMenu.classList.remove('active');
    });
});
</script>