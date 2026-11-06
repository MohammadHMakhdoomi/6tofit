<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>


<div class="af-thankyou-page">

    <?php if ( $order ) : ?>

        <?php
        do_action(
            'woocommerce_before_thankyou',
            $order->get_id()
        );
        ?>

        <div class="af-thankyou-content">

            <!-- تصویر موفقیت -->
            <div class="af-thankyou-icon">
                <img
                    src="http://6tofit.com/wp-content/uploads/2026/09/freepik-163211516-1-1.png"
                    alt="پرداخت موفق"
                    width="65"
                    height="65"
                >
            </div>

            <!-- عنوان اول -->
            <div class="af-thankyou-success-title">
                پرداخت با موفقیت انجام شد
            </div>

            <!-- عنوان اصلی -->
            <div class="af-thankyou-main-title">
                فرم اطلاعات شخصی را پرکنید
            </div>

            <!-- توضیحات -->
            <div class="af-thankyou-description">
                فرم از طریق ایمیل برای شما ارسال شد، داده‌های فرم به ما کمک می‌کند تا برنامه‌ای دقیقا متناسب با نیازهای شما تدوین کنیم.
            </div>

            <!-- دکمه پشتیبانی -->
            <a
              href="javascript:void(0)" onclick="showFreeHeaderConsultationPopup()"
                class="af-thankyou-support-button"
            >
                تماس با پشتیبانی
            </a>

        </div>

   

    <?php endif; ?>

</div>


<style>

/* =========================================
   Thank You Page
========================================= */
.site-page-hero{
	display:none;
}
.af-thankyou-page {
    width: 100%;
    min-height: 600px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-sizing: border-box;
    direction: rtl;
}


/* =========================================
   Content
========================================= */

.af-thankyou-content {
    width: 100%;
    max-width: 760px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}


/* =========================================
   Success Icon
========================================= */

.af-thankyou-icon {
    width: 65px;
    height: 65px;
    flex: 0 0 65px;
    margin-bottom: 24px;
}

.af-thankyou-icon img {
    width: 65px;
    height: 65px;
    display: block;
    object-fit: contain;
}


/* =========================================
   Success Title
========================================= */

.af-thankyou-success-title {
    color: #161618;
    font-size: 20px;
    font-weight: 500;
    line-height: 1.7;
    margin: 0;
}


/* =========================================
   Main Title
========================================= */

.af-thankyou-main-title {
    color: #161618;
    font-size: 30px;
    font-weight: 500;
    line-height: 1.7;
    margin-top: 44px;
}


/* =========================================
   Description
========================================= */

.af-thankyou-description {
    max-width: 700px;
    margin-top: 18px;
    color: #161618;
    font-size: 16px;
    font-weight: 400;
    line-height: 2;
}


/* =========================================
   Support Button
========================================= */

.af-thankyou-support-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    margin-top: 32px;

    padding: 12px 10px;

    min-height: 48px;

    box-sizing: border-box;

    border: 1px solid rgba(0, 0, 0, 0.12);
    border-radius: 1000000px;

    background: transparent;

    color: #161618;

    font-size: 18px;
    font-weight: 400;
    line-height: 1.5;

    text-decoration: none;

    transition:
        background 0.2s ease,
        border-color 0.2s ease;
}

.af-thankyou-support-button:hover {
    background: #F7F7F8;
    border-color: rgba(0, 0, 0, 0.18);
    color: #161618;
}


/* =========================================
   Mobile
========================================= */

@media only screen and (max-width: 767px) {

    .af-thankyou-page {
        min-height: 500px;
        padding: 40px 20px;
    }

    .af-thankyou-content {
        max-width: 100%;
    }

    .af-thankyou-icon {
        margin-bottom: 20px;
    }

    .af-thankyou-success-title {
        font-size: 18px;
    }

    .af-thankyou-main-title {
        font-size: 24px;
        margin-top: 32px;
    }

    .af-thankyou-description {
        margin-top: 14px;
        font-size: 14px;
        line-height: 2;
    }

    .af-thankyou-support-button {
        margin-top: 28px;
        font-size: 16px;
    }

}

</style>