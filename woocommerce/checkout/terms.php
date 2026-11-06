<?php
/**
 * Checkout terms and conditions area.
 *
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) {
	do_action( 'woocommerce_checkout_before_terms_and_conditions' );

	?>
	<div class="woocommerce-terms-and-conditions-wrapper">
		<?php
		/**
		 * Terms and conditions hook used to inject content.
		 *
		 * @since 3.4.0.
		 * @hooked wc_checkout_privacy_policy_text() Shows custom privacy policy text. Priority 20.
		 * @hooked wc_terms_and_conditions_page_content() Shows t&c page content. Priority 30.
		 */
		do_action( 'woocommerce_checkout_terms_and_conditions' );
		?>

		<?php if ( wc_terms_and_conditions_checkbox_enabled() ) : ?>
		<p class="form-row validate-required">

    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">

        <input
            type="checkbox"
            class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
            name="terms"
            <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); ?>
            id="terms"
        />

        <span class="woocommerce-terms-and-conditions-checkbox-text">
            <a
                href="https://6tofit.com/privacy-and-policy/"
                target="_blank"
                rel="noopener"
            >
                شرایط و قوانین
            </a>
            رو خوانده و می‌پذیرم
        </span>

    </label>

    <input type="hidden" name="terms-field" value="1" />

</p>

<?php
/**
 * هشدار پرداخت برای کاربران ایران
 *
 * تایم‌زون واقعی مرورگر کاربر با JavaScript بررسی می‌شود.
 */
?>

<div
    class="af-iran-payment-notice"
    id="af-iran-payment-notice"
    style="display: none;"
>

    <div class="af-iran-payment-notice-icon">
        <img
            src="http://6tofit.com/wp-content/uploads/2026/09/⚠️-Warning.png"
            alt=""
            width="24"
            height="24"
        >
    </div>

    <div class="af-iran-payment-notice-text">
        برای پرداخت صورت حساب، لطفا از کارتی که به نام شخص شما باشد استفاده کنید.
    </div>

</div>

<script>
(function () {

    function checkIranTimezone() {

        var notice = document.getElementById('af-iran-payment-notice');

        if (!notice) {
            return;
        }

        try {

            var userTimezone =
                Intl.DateTimeFormat().resolvedOptions().timeZone;

            /*
             * فقط کاربران با تایم‌زون ایران
             */
            if (userTimezone === 'Asia/Tehran') {

                notice.style.display = 'flex';

            } else {

                notice.style.display = 'none';

            }

        } catch (error) {

            notice.style.display = 'none';

        }

    }

    /*
     * اجرای اولیه
     */
    checkIranTimezone();

    /*
     * چون Checkout ووکامرس با AJAX آپدیت می‌شود،
     * بعد از هر آپدیت Checkout دوباره بررسی شود.
     */
    if (typeof jQuery !== 'undefined') {

        jQuery(document.body).on(
            'updated_checkout',
            function () {
                checkIranTimezone();
            }
        );

    }

})();
</script>

<style>
/* =========================
   Checkout Terms Checkbox
========================= */

.woocommerce-terms-and-conditions-wrapper {
    direction: rtl;
}

.woocommerce-terms-and-conditions-wrapper
.form-row {
    margin: 0 !important;
    padding: 0 !important;
}

.woocommerce-terms-and-conditions-wrapper
.woocommerce-form__label-for-checkbox {
    display: flex !important;
    align-items: center !important;

    margin: 0 !important;
    padding: 0 !important;

    cursor: pointer;
}

/* Checkbox */
.woocommerce-terms-and-conditions-wrapper
.input-checkbox {
    appearance: none;
    -webkit-appearance: none;

    width: 18px !important;
    height: 18px !important;

    min-width: 18px;
    min-height: 18px;

    margin: 0 0 0 10px !important;
    padding: 0 !important;

    border: 1.5px solid #65656D !important;
    border-radius: 5px !important;

    background: transparent !important;

    box-shadow: none !important;

    position: relative;

    cursor: pointer;

    flex-shrink: 0;

    transition:
        background-color 0.15s ease,
        border-color 0.15s ease;
}

/* Checkbox Active */
.woocommerce-terms-and-conditions-wrapper
.input-checkbox:checked {
    background: #161618 !important;
    border-color: #161618 !important;
}

/* White Check */
.woocommerce-terms-and-conditions-wrapper
.input-checkbox:checked::after {
    content: "";

    position: absolute;

    width: 5px;
    height: 9px;

    top: 2px;
    left: 5px;

    border: solid #FFFFFF;
    border-width: 0 1.5px 1.5px 0;

    transform: rotate(45deg);

    box-sizing: border-box;
}

/* Text */
.woocommerce-terms-and-conditions-wrapper
.woocommerce-terms-and-conditions-checkbox-text {
    margin: 0 !important;
    padding: 0 !important;

    color: #161618 !important;

    font-size: 14px !important;
    font-weight: 400;

    line-height: 1.8;

    text-align: right;
}

/* Link */
.woocommerce-terms-and-conditions-wrapper
.woocommerce-terms-and-conditions-checkbox-text a {
    color: #5247FF !important;

    font-size: 14px !important;
    font-weight: 400;

    text-decoration: none !important;
}

/* Hover */
.woocommerce-terms-and-conditions-wrapper
.woocommerce-terms-and-conditions-checkbox-text a:hover {
    color: #5247FF !important;
    text-decoration: none !important;
}

/* حذف ستاره required */
.woocommerce-terms-and-conditions-wrapper
.required {
    display: none !important;
}


/* =========================================================
   هشدار پرداخت کاربران ایران
========================================================= */

.af-iran-payment-notice {

    width: 100%;
    box-sizing: border-box;

    display: flex;
    align-items: center;

    gap: 4px;

    padding: 12px;

    background: #FFEBEE;

    border-radius: 8px;

    direction: rtl;
margin-top: 24px;
    margin-bottom: 24px;
}
/* ========================================================= دکمه پرداخت نهایی ========================================================= */ #place_order { width: 100% !important; box-sizing: border-box !important; display: flex !important; align-items: center !important; justify-content: center !important; gap: 10px !important; padding: 12px 10px !important; min-height: auto !important; height: auto !important; border: none !important; border-radius: 1000000px !important; background: #000000 !important; color: #FFFFFF !important; font-size: 18px !important; font-weight: 700 !important; line-height: 1.5 !important; text-align: center !important; cursor: pointer; box-shadow: none !important; transition: background-color 0.2s ease, color 0.2s ease, opacity 0.2s ease; } /* ========================================================= متن دکمه ========================================================= */ #place_order:hover, #place_order:focus, #place_order:active { background: #000000 !important; color: #FFFFFF !important; } /* ========================================================= حالت غیرفعال ========================================================= */ #place_order:disabled, #place_order.disabled, #place_order[disabled] { background: #E9E9EB !important; color: #9B9BA1 !important; cursor: not-allowed !important; opacity: 1 !important; } /* ========================================================= موبایل ========================================================= */ @media only screen and (max-width: 768px) { #place_order { width: 100% !important; padding: 12px 10px !important; font-size: 18px !important; border-radius: 1000000px !important; } }

/* =========================================================
   آیکون
========================================================= */

.af-iran-payment-notice-icon {

    width: 24px;
    height: 24px;

    min-width: 24px;
    min-height: 24px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;
}


.af-iran-payment-notice-icon img {

    width: 24px;
    height: 24px;

    display: block;

    object-fit: contain;
}


/* =========================================================
   متن
========================================================= */

.af-iran-payment-notice-text {

    flex: 1;

    display: flex;
    align-items: center;

    color: #161618;

    font-size: 14px;
    font-weight: 400;

    line-height: 1.8;

    text-align: right;
}


</style>

		<?php endif; ?>
	</div>

<script>
(function ($) {

    function updatePlaceOrderButton() {

        var $terms = $('#terms');
        var $button = $('#place_order');

        if (!$terms.length || !$button.length) {
            return;
        }

        /*
         * اگر قوانین تیک نخورده باشد
         */
        if (!$terms.is(':checked')) {

            $button.prop('disabled', true);
            $button.addClass('disabled');

        }

        /*
         * اگر قوانین تیک خورده باشد
         */
        else {

            $button.prop('disabled', false);
            $button.removeClass('disabled');

        }
    }


    /*
     * اجرای اولیه
     */
    $(document).ready(function () {
        updatePlaceOrderButton();
    });


    /*
     * هنگام تغییر وضعیت چک‌باکس
     */
    $(document.body).on('change', '#terms', function () {
        updatePlaceOrderButton();
    });


    /*
     * بعد از آپدیت AJAX ووکامرس
     */
    $(document.body).on('updated_checkout', function () {
        updatePlaceOrderButton();
    });


})(jQuery);
</script>


	<?php

	do_action( 'woocommerce_checkout_after_terms_and_conditions' );
}






