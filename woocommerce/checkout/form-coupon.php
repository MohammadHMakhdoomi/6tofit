<?php

/**
 * Custom Checkout Coupon Form
 *
 * @package WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) {
    return;
}

/**
 * کوپن فعال فعلی
 */
$applied_coupons = WC()->cart ? WC()->cart->get_applied_coupons() : array();

$active_coupon = '';

if ( ! empty( $applied_coupons ) ) {
    $active_coupon = end( $applied_coupons );
}

$has_coupon = ! empty( $active_coupon );

/**
 * مبلغ تخفیف همین کوپن
 */
$discount_amount = 0;

if ( $has_coupon && WC()->cart ) {

    $discount_amount =
        (float) WC()->cart->get_coupon_discount_amount( $active_coupon ) +
        (float) WC()->cart->get_coupon_discount_tax_amount( $active_coupon );

    /**
     * اگر واحد فروشگاه ریال است،
     * برای نمایش تومان تقسیم بر 10 می‌کنیم.
     */
    if ( 'IRR' === get_woocommerce_currency() ) {
        $discount_amount = $discount_amount / 10;
    }
}

$formatted_discount = number_format_i18n(
    $discount_amount,
    0
);

$state_nonce = wp_create_nonce( 'custom_checkout_coupon_state' );

?>

<div
    class="custom-checkout-coupon <?php echo $has_coupon ? 'has-active-coupon' : ''; ?>"
    data-state-nonce="<?php echo esc_attr( $state_nonce ); ?>"
>

    <div class="custom-coupon-header">

        <div class="custom-coupon-title">
            کد تخفیف
        </div>

        <label class="custom-toggle">

            <input
                type="checkbox"
                id="custom-coupon-toggle"
                aria-controls="custom-coupon-content"
                <?php checked( $has_coupon ); ?>
            >

            <span class="toggle-slider"></span>

        </label>

    </div>


    <div
        id="custom-coupon-content"
        class="custom-coupon-content"
        <?php echo ! $has_coupon ? 'style="display:none;"' : ''; ?>
    >

        <!--
            مهم:
            اینجا دیگر FORM نداریم.
            چون این بخش داخل فرم اصلی Checkout قرار گرفته.
        -->
        <div class="checkout_coupon woocommerce-form-coupon custom-coupon-form">

            <div class="custom-coupon-input-wrapper">

                <input
                    type="text"
                    name="coupon_code"
                    class="custom-coupon-input"
                    placeholder="کد تخفیف"
                    id="coupon_code"
                    autocomplete="off"
                    value="<?php echo esc_attr( $active_coupon ); ?>"
                >

                <button
                    type="button"
                    class="custom-coupon-button"
                    value="اعمال کد"
                    data-mode="<?php echo $has_coupon ? 'remove' : 'apply'; ?>"
                >
                    <?php echo $has_coupon ? 'حذف کد' : 'اعمال کد'; ?>
                </button>

            </div>


            <div
                class="custom-coupon-discount-message"
                <?php echo ! $has_coupon ? 'style="display:none;"' : ''; ?>
            >

                <span class="custom-coupon-discount-amount">
                    <?php echo esc_html( $formatted_discount ); ?>
                </span>

                تومان از مبلغ پرداختی شما کسر شد

            </div>

        </div>

    </div>

</div>


<style>

/* =========================================
   Coupon Card
========================================= */

.custom-checkout-coupon {
    width: 100%;
    background: #FFFFFF;
    border-radius: 24px;
    padding: 40px;
    box-sizing: border-box;
    box-shadow:
        0 0 3px 0 rgba(0, 0, 0, 0.06);
    direction: rtl;
}


/* =========================================
   Header
========================================= */

.custom-coupon-header {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}


.custom-coupon-title {
    font-size: 16px;
    font-weight: 500;
    color: #19191B;
    line-height: 1.7;
}


/* =========================================
   Toggle
========================================= */

.custom-toggle {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 28px;
    cursor: pointer;
    flex: 0 0 auto;
}


.custom-toggle input {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
}


.toggle-slider {
    position: absolute;
    inset: 0;
    background: #B8B8BC;
    border-radius: 100px;
    transition: 0.25s ease;
}


.toggle-slider::before {
    content: "";
    position: absolute;
    width: 24px;
    height: 24px;
    left: 2px;
    top: 2px;
    background: #FFFFFF;
    border-radius: 50%;
    transition: 0.25s ease;
    box-shadow:
        0 1px 3px rgba(0, 0, 0, 0.12);
}


.custom-toggle input:checked + .toggle-slider {
    background: #19191B;
}


.custom-toggle input:checked + .toggle-slider::before {
    transform: translateX(22px);
}


/* =========================================
   Content
========================================= */

.custom-coupon-content {
    width: 100%;
    margin-top: 24px;
}


/*
 * دیگر فرم داخلی وجود ندارد.
 * بنابراین WooCommerce نمی‌تواند
 * این بخش را به عنوان فرم خودش hide کند.
 */

.custom-coupon-form {
    display: block !important;
    width: 100%;
    margin: 0 !important;
    padding: 0 !important;
    border: 0 !important;
    background: transparent !important;
}


/* =========================================
   Input wrapper
========================================= */

.custom-coupon-input-wrapper {
    width: 100%;
    height: 56px;
    background: #FFFFFF;
    border: 1px solid #E5E5E7;
    border-radius: 1000px;
    box-sizing: border-box;

    display: flex;
    align-items: center;

    gap: 18px;

    padding:
        5px
        18px
        5px
        5px;

    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}


.custom-coupon-input-wrapper:focus-within {
    border-color: #C8C8CC;

    box-shadow:
        0 0 0 3px rgba(25, 25, 27, 0.04);
}


/* =========================================
   Input
========================================= */

.custom-coupon-input {
    flex: 1;
    min-width: 0;

    height: 100%;

    padding: 0 !important;
    margin: 0 !important;

    background: transparent !important;
    border: 0 !important;
    outline: 0 !important;
    box-shadow: none !important;

    font-size: 14px;
    font-family: inherit;

    color: #19191B;

    text-align: right;
}


.custom-coupon-input::placeholder {
    color: #A5A5AA;
    opacity: 1;
}


/* =========================================
   Button
========================================= */

.custom-coupon-button,
.woocommerce .custom-coupon-button {

    flex: 0 0 auto;

    height: 44px;
    min-width: 100px;

    padding: 0 22px !important;
    margin: 0 !important;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border: 0 !important;
    border-radius: 10000000px !important;

    background: #F0F0F1 !important;
    color: #19191B !important;

    font-family: inherit;
    font-size: 13px;
    font-weight: 500;
    line-height: 1;

    cursor: pointer;

    box-shadow: none !important;

    transition:
        background 0.2s ease,
        opacity 0.2s ease;
}


.custom-coupon-button:hover,
.woocommerce .custom-coupon-button:hover {
    background: #E5E5E7 !important;
}


.custom-coupon-button:disabled {
    opacity: 0.5;
    cursor: wait;
}


/* =========================================
   Discount message
========================================= */

.custom-coupon-discount-message {
    margin-top: 10px;

    font-size: 12px;
    font-weight: 400;
    line-height: 1.8;

    color: #5A5A61;

    text-align: right;
}


/* =========================================
   Woo Notices
========================================= */

.custom-checkout-coupon .woocommerce-error,
.custom-checkout-coupon .woocommerce-message,
.custom-checkout-coupon .woocommerce-info {

    margin: 12px 0 0 !important;
    font-size: 12px;
}


/* =========================================
   Mobile
========================================= */

@media (max-width: 767px) {

    .custom-checkout-coupon {
        padding: 24px 20px;
        border-radius: 20px;
    }

    .custom-coupon-content {
        margin-top: 20px;
    }

    .custom-coupon-input-wrapper {
        height: 54px;

        padding:
            5px
            15px
            5px
            5px;
    }

    .custom-coupon-button,
    .woocommerce .custom-coupon-button {

        height: 42px;
        min-width: 86px;

        padding: 0 16px !important;

        font-size: 12px;
    }

}

</style>


<script>

jQuery(function($) {

    const $box       = $('.custom-checkout-coupon');
    const $toggle    = $('#custom-coupon-toggle');
    const $content   = $('#custom-coupon-content');
    const $form      = $box.find('.custom-coupon-form');
    const $input     = $box.find('input[name="coupon_code"]');
    const $button    = $box.find('.custom-coupon-button');
    const $message   = $box.find('.custom-coupon-discount-message');
    const $amount    = $box.find('.custom-coupon-discount-amount');

    let activeCoupon = <?php echo wp_json_encode( $active_coupon ); ?>;


    /* =========================================
       Toggle
    ========================================= */

    $toggle.on('change', function() {

        if ($(this).is(':checked')) {

            $content.stop(true, true).slideDown(220);

            setTimeout(function() {

                if (!activeCoupon) {
                    $input.trigger('focus');
                }

            }, 230);

        } else {

            $content.stop(true, true).slideUp(220);

        }

    });


    /* =========================================
       UI state - Apply
    ========================================= */

    function setApplyState() {

        activeCoupon = '';

        $box.removeClass('has-active-coupon');

        $button
            .prop('disabled', false)
            .attr('type', 'button')
            .removeAttr('name')
            .attr('data-mode', 'apply')
            .text('اعمال کد');

        $input
            .prop('readonly', false);

        $message.hide();
        $amount.text('');

    }


    /* =========================================
       UI state - Remove
    ========================================= */

    function setRemoveState(coupon, discount) {

        activeCoupon = coupon || '';

        $box.addClass('has-active-coupon');

        $toggle.prop('checked', true);

        $content.show();

        $input
            .val(activeCoupon)
            .prop('readonly', true);

        $button
            .prop('disabled', false)
            .attr('type', 'button')
            .removeAttr('name')
            .attr('data-mode', 'remove')
            .text('حذف کد');

        if (
            discount !== undefined &&
            discount !== null &&
            discount !== ''
        ) {

            $amount.text(discount);
            $message.show();

        }

    }


    /* =========================================
       دریافت وضعیت کوپن از سرور
    ========================================= */

    function syncCouponState() {

        return $.ajax({

            url: wc_checkout_params.ajax_url,

            type: 'POST',

            dataType: 'json',

            data: {

                action: 'custom_checkout_coupon_state',

                security: $box.data('state-nonce')

            },

            success: function(response) {

    if (
        response &&
        response.success &&
        response.data
    ) {

        if (response.data.has_coupon) {

            setRemoveState(
                response.data.coupon_code,
                response.data.discount
            );

        } else {

            setApplyState();

        }

    }

}

        });

    }
/* =========================================
   APPLY COUPON
========================================= */

$button.on('click', function(e) {

    e.preventDefault();

    const $this = $(this);

    if ($this.attr('data-mode') !== 'apply') {
        return;
    }

    const coupon = $.trim($input.val());

    if (!coupon) {
        $input.trigger('focus');
        return;
    }

    if ($this.prop('disabled')) {
        return;
    }

    $this
        .prop('disabled', true)
        .text('در حال اعمال...');

    $.ajax({
        type: 'POST',

        url: wc_checkout_params.wc_ajax_url
            .toString()
            .replace('%%endpoint%%', 'apply_coupon'),

        data: {
            security: wc_checkout_params.apply_coupon_nonce,
            coupon_code: coupon
        },

        dataType: 'html',

        success: function(response) {

            /*
             * نمایش پیام ووکامرس
             */
            let $noticeWrapper =
                $box.find('.custom-coupon-notices');

            if (!$noticeWrapper.length) {

                $noticeWrapper = $(
                    '<div class="custom-coupon-notices"></div>'
                );

                $message.after($noticeWrapper);
            }

            $noticeWrapper.html(response);


            /*
             * بررسی می‌کنیم کوپن واقعاً اعمال شده یا نه
             */
            const couponApplied =
                response &&
                !$(response).find('.woocommerce-error').length;


            /*
             * اگر کوپن موفق بود:
             * همان لحظه UI را به حالت حذف تغییر بده
             */
            if (couponApplied) {

                setRemoveState(coupon, '');

                /*
                 * حالا Checkout را آپدیت کن
                 */
                $(document.body).trigger('update_checkout');

                /*
                 * بعد از آپدیت قیمت‌ها،
                 * وضعیت واقعی تخفیف را از سرور بگیر
                 */
                setTimeout(function() {
                    syncCouponState();
                }, 300);

            } else {

                /*
                 * اگر کوپن نامعتبر بود
                 */
                setApplyState();
            }

        },

        error: function() {

            setApplyState();

        },

        complete: function() {

            /*
             * اگر کوپن موفق شده باشد،
             * setRemoveState قبلاً دکمه را فعال کرده.
             */
            if (activeCoupon) {

                $button
                    .prop('disabled', false)
                    .text('حذف کد');

            } else {

                $button
                    .prop('disabled', false)
                    .text('اعمال کد');

            }

        }

    });

});




    /* =========================================
       Checkout Error
    ========================================= */

    $(document.body).on(
        'checkout_error',
        function() {

            $button.prop('disabled', false);

            if (!activeCoupon) {
                $button.text('اعمال کد');
            }

        }
    );


    /* =========================================
       REMOVE COUPON
    ========================================= */

    $button.on('click', function(e) {

        if ($(this).attr('data-mode') !== 'remove') {
            return;
        }

        e.preventDefault();

        if (!activeCoupon) {
            return;
        }

        const $this = $(this);

        const couponToRemove = activeCoupon;

        $this
            .prop('disabled', true)
            .text('در حال حذف...');


        $.ajax({

            type: 'POST',

            url: wc_checkout_params.wc_ajax_url
                .toString()
                .replace(
                    '%%endpoint%%',
                    'remove_coupon'
                ),

            data: {

                security:
                    wc_checkout_params.remove_coupon_nonce,

                coupon:
                    couponToRemove

            },

            dataType: 'html',

            success: function(response) {

                /*
                 * پاک کردن state
                 */
                activeCoupon = '';

                $input
                    .val('')
                    .prop('readonly', false);

                setApplyState();


                /*
                 * Event استاندارد WooCommerce
                 */
                $(document.body).trigger(
                    'removed_coupon_in_checkout',
                    [couponToRemove]
                );


                /*
                 * بروزرسانی Checkout
                 */
                $(document.body).trigger(
                    'update_checkout',
                    {
                        update_shipping_method: false
                    }
                );

            },

            error: function() {

                $this
                    .prop('disabled', false)
                    .text('حذف کد');

            },

            complete: function() {

                $this.prop('disabled', false);

            }

        });

    });


    /* =========================================
       اگر جایی دیگر Coupon تغییر کرد
    ========================================= */

    $(document.body).on(
        'removed_coupon_in_checkout',
        function() {

            setTimeout(function() {

                syncCouponState();

            }, 200);

        }
    );


    /* =========================================
       بعد از Update Checkout
    ========================================= */

    $(document.body).on(
        'updated_checkout',
        function() {

            if ($toggle.is(':checked')) {

                $content.show();

            }

        }
    );


    /* =========================================
       Sync اولیه
    ========================================= */

    syncCouponState();

});

</script>