<?php
/**
 * Checkout Billing & Custom Order Summary Box (CURCY & Stripe/ZarinPal Compatible)
 * فایل: woocommerce/checkout/form-billing.php
 */
defined( 'ABSPATH' ) || exit;

$is_usd       = function_exists( 'af_is_usd_currency' ) ? af_is_usd_currency() : ( get_woocommerce_currency() === 'USD' );
$current_user = wp_get_current_user();
$has_user     = ( $current_user && $current_user->ID > 0 );

$user_first_name = $has_user ? $current_user->first_name : '';
$user_last_name  = $has_user ? $current_user->last_name : '';
$full_name       = trim( $user_first_name . ' ' . $user_last_name );

if ( empty( $full_name ) && $has_user ) {
    $full_name = get_user_meta( $current_user->ID, 'billing_full_name', true ) ?: $current_user->display_name;
}

if ( ! empty( $full_name ) && empty( $user_last_name ) ) {
    $parts           = preg_split( '/\s+/u', trim( $full_name ), 2 );
    $user_first_name = $parts[0] ?? $full_name;
    $user_last_name  = ! empty( $parts[1] ) ? $parts[1] : $user_first_name;
}

$user_phone = $has_user ? ( get_user_meta( $current_user->ID, 'phone', true ) ?: get_user_meta( $current_user->ID, 'billing_phone', true ) ) : '';
$raw_email  = $has_user ? $current_user->user_email : '';
$is_temp_em = ( strpos( $raw_email, '@temp.6tofit.com' ) !== false );
$user_email = $is_temp_em ? '' : $raw_email;

$cart_items     = WC()->cart ? WC()->cart->get_cart() : array();
$main_product   = null;
$main_cart_item = null;

foreach ( $cart_items as $cart_item_key => $cart_item ) {
    if ( empty( $cart_item['data'] ) || ! is_a( $cart_item['data'], 'WC_Product' ) ) {
        continue;
    }
    $main_product                    = $cart_item['data'];
    $main_cart_item                  = $cart_item;
    $main_cart_item['_cart_item_key'] = $cart_item_key;
    break;
}

$product_name          = '';
$product_image         = '';
$subscription_months   = 0;
$subscription_discount = 0;
$addons                = array();

if ( $main_product ) {
    $parent_id     = $main_product->get_parent_id() ? $main_product->get_parent_id() : $main_product->get_id();
    $parent_prod   = wc_get_product( $parent_id ) ?: $main_product;
    $product_name  = $parent_prod->get_name();
    $product_image = wp_get_attachment_image_url( $parent_prod->get_image_id(), 'thumbnail' );

    if ( ! empty( $main_cart_item['af_subscription'] ) && is_array( $main_cart_item['af_subscription'] ) ) {
        $subscription          = $main_cart_item['af_subscription'];
        $subscription_months   = isset( $subscription['months'] ) ? absint( $subscription['months'] ) : 0;
        $subscription_discount = isset( $subscription['discount'] ) ? floatval( $subscription['discount'] ) : 0;
    } elseif ( function_exists( 'af_get_cart_item_months' ) ) {
        $subscription_months = af_get_cart_item_months( $main_cart_item );
    }

    if ( ! empty( $main_cart_item['selected_addons'] ) && is_array( $main_cart_item['selected_addons'] ) ) {
        $addons = $main_cart_item['selected_addons'];
    }
}
?>

<div class="af-checkout-box">
    <?php if ( $main_product ) : ?>
        <div class="af-checkout-product">
            <?php if ( $product_image ) : ?>
                <div class="af-checkout-product-image">
                    <img src="<?php echo esc_url( $product_image ); ?>" alt="<?php echo esc_attr( $product_name ); ?>">
                </div>
            <?php endif; ?>
            <div class="af-checkout-product-info">
                <div class="af-checkout-product-name">
                    <?php echo esc_html( $product_name ); ?>
                    <?php if ( $subscription_months > 0 ) : ?>
                        <span class="af-checkout-subscription">
                            (<?php echo esc_html( $subscription_months ); ?> ماهه)
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( ! empty( $addons ) ) : ?>
        <div class="af-checkout-addons">
            <?php foreach ( $addons as $addon_index => $addon ) :
                $addon_name  = is_array( $addon ) && isset( $addon['title'] ) ? $addon['title'] : '';
                $addon_price = function_exists( 'af_get_addon_converted_price' )
                    ? af_get_addon_converted_price( $addon )
                    : floatval( $addon['price'] ?? 0 );

                if ( ! $addon_name ) {
                    continue;
                }

                if ( $is_usd ) {
                    $dec              = ( floor( $addon_price ) == $addon_price ) ? 0 : 2;
                    $formatted_addon  = '$' . number_format( $addon_price, $dec, '.', ',' ) . ' دلار';
                } else {
                    $formatted_addon  = number_format( $addon_price, 0, '', '.' ) . ' تومان';
                }
            ?>
                <div class="af-checkout-addon" data-addon-index="<?php echo esc_attr( $addon_index ); ?>">
                    <div class="af-checkout-addon-name">
                        <span><?php echo esc_html( $addon_name ); ?></span>
                        <?php if ( $addon_price > 0 ) : ?>
                            <span class="af-checkout-addon-price">
                                (+ <?php echo esc_html( $formatted_addon ); ?>)
                            </span>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="af-checkout-addon-remove" data-addon-index="<?php echo esc_attr( $addon_index ); ?>" aria-label="حذف اددان">
                        <img src="https://6tofit.com/wp-content/uploads/2026/09/Delete-1.svg" alt="حذف">
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="af-checkout-user-info">
        <!-- نمایش خلاصه اطلاعات کاربر + دکمه ویرایش در صورت نیاز -->
        <div id="af-checkout-static-info" <?php echo ( empty( $full_name ) || ( empty( $user_phone ) && empty( $user_email ) ) ) ? 'style="display:none;"' : ''; ?>>
            <div class="af-checkout-display-row">
                <span class="af-checkout-label">نام و نام خانوادگی</span>
                <span class="af-checkout-value" id="af-disp-name"><?php echo esc_html( $full_name ?: '—' ); ?></span>
            </div>

            <?php if ( ! empty( $user_phone ) ) : ?>
                <div class="af-checkout-display-row" style="margin-top:14px;">
                    <span class="af-checkout-label">شماره موبایل</span>
                    <span class="af-checkout-value" id="af-disp-phone" style="direction:ltr;"><?php echo esc_html( $user_phone ); ?></span>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $user_email ) ) : ?>
                <div class="af-checkout-display-row" style="margin-top:14px;">
                    <span class="af-checkout-label">ایمیل</span>
                    <span class="af-checkout-value" id="af-disp-email" style="direction:ltr;"><?php echo esc_html( $user_email ); ?></span>
                </div>
            <?php endif; ?>

            <div style="margin-top:14px;text-align:left;">
                <a href="javascript:void(0);" onclick="document.getElementById('af-checkout-editable-fields').style.display='flex';this.parentElement.style.display='none';" style="font-size:13px;color:#5247FF;text-decoration:none;">ویرایش اطلاعات</a>
            </div>
        </div>

        <!-- فیلدهای قابل ویرایش (اگر اطلاعات ناقص بود خودکار باز می‌شود) -->
        <div id="af-checkout-editable-fields" style="display: <?php echo ( empty( $full_name ) || ( empty( $user_phone ) && empty( $user_email ) ) ) ? 'flex' : 'none'; ?>; flex-direction: column; gap: 14px;">
            <div class="af-checkout-field">
                <label>نام و نام خانوادگی</label>
                <input type="text" name="billing_full_name" id="af_billing_full_name" value="<?php echo esc_attr( $full_name ); ?>" placeholder="نام و نام خانوادگی" required>
            </div>
            <div class="af-checkout-field">
                <label>شماره موبایل</label>
                <input type="tel" name="billing_phone" id="af_billing_phone" value="<?php echo esc_attr( $user_phone ?: '09120000000' ); ?>" placeholder="09123456789" style="direction:ltr;text-align:right;">
            </div>
            <div class="af-checkout-field">
                <label>ایمیل</label>
                <input type="email" name="billing_email" id="af_billing_email" value="<?php echo esc_attr( $user_email ?: $raw_email ); ?>" placeholder="email@example.com" style="direction:ltr;text-align:right;">
            </div>
        </div>
    </div>

    <!-- اینپوت‌های مخفی اجباری ووکامرس برای جلوگیری ۱۰۰٪ از خطای کشور، استان، شهر، خیابان و کدپستی -->
    <input type="hidden" name="billing_first_name" id="af_billing_first_name" value="<?php echo esc_attr( $user_first_name ?: 'کاربر' ); ?>">
    <input type="hidden" name="billing_last_name" id="af_billing_last_name" value="<?php echo esc_attr( $user_last_name ?: ( $user_first_name ?: 'سیکس‌توفیت' ) ); ?>">
    <input type="hidden" name="billing_country" value="<?php echo $is_usd ? 'US' : 'IR'; ?>">
    <input type="hidden" name="billing_state" value="<?php echo $is_usd ? 'CA' : 'THR'; ?>">
    <input type="hidden" name="billing_city" value="<?php echo $is_usd ? 'Los Angeles' : 'Tehran'; ?>">
    <input type="hidden" name="billing_address_1" value="Online Digital Program">
    <input type="hidden" name="billing_postcode" value="<?php echo $is_usd ? '90001' : '1111111111'; ?>">
</div>

<style>
.af-checkout-user-info { display: flex; flex-direction: column; gap: 16px; }
.woocommerce-checkout-review-order { width: 100%; background: #FFFFFF; border-radius: 32px; padding: 44px; box-sizing: border-box; direction: rtl; }
.af-checkout-display-row { display: flex; justify-content: space-between; align-items: center; width: 100%; }
.af-checkout-label { color: #65656D; font-size: 14px; font-weight: 400; }
.af-checkout-value { color: #161618; font-size: 18px; font-weight: 500; }
.af-checkout-box { width: 100%; background: #FFFFFF; border-radius: 32px; padding: 34px; box-sizing: border-box; direction: rtl; }
.af-checkout-product { display: flex; align-items: center; gap: 16px; width: 100%; margin-bottom: 24px; }
.af-checkout-product-image { width: 48px; height: 48px; flex-shrink: 0; border-radius: 20px; overflow: hidden; }
.af-checkout-product-image img { width: 100%; height: 100%; object-fit: cover; display: block; }
.af-checkout-product-info { flex: 1; }
.af-checkout-product-name { font-size: 24px; font-weight: 500; color: #161618; line-height: 1.8; }
.af-checkout-subscription { color: #65656D; font-size: 16px; font-weight: 400; }
.af-checkout-addons { display: flex; flex-direction: column; gap: 12px; margin-bottom: 32px; }
.af-checkout-addon { width: 100%; min-height: 56px; padding: 16px; box-sizing: border-box; background: #F9F9FB; border-radius: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
.af-checkout-addon-name { display: flex; align-items: center; gap: 6px; font-size: 15px; font-weight: 400; color: #161618; flex: 1; }
.af-checkout-addon-price { color: #65656D; font-size: 14px; white-space: nowrap; }
.af-checkout-addon-remove { width: 32px; height: 32px; padding: 0; margin: 0; border: none; background: transparent; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; }
.af-checkout-addon-remove img { width: 20px; height: 20px; object-fit: contain; display: block; }
.af-checkout-field { width: 100%; }
.af-checkout-field label { display: block; margin-bottom: 8px; color: #161618; font-size: 14px; font-weight: 400; }
.af-checkout-field input { width: 100%; height: 50px; box-sizing: border-box; padding: 0 16px; border: 1px solid #E5E5E7; border-radius: 16px; background: #F9F9FB; color: #161618; font-size: 15px; font-family: inherit; outline: none; }
.af-checkout-field input:focus { border-color: #5247FF; background: #fff; }
@media only screen and (max-width: 768px) {
    .af-checkout-box { padding: 16px; border-radius: 24px; }
    .woocommerce-checkout-review-order { padding: 20px; border-radius: 24px; }
    .af-checkout-product-image { width: 32px; height: 32px; border-radius: 16px; }
    .af-checkout-product-name { font-size: 20px; }
    .af-checkout-label { font-size: 12px; }
    .af-checkout-value { font-size: 16px; font-weight: 400; }
    .af-checkout-subscription { font-size: 16px; }
    .af-checkout-addon { padding: 14px; border-radius: 20px; }
    .af-checkout-addon-name { font-size: 14px; }
    .af-checkout-addon-price { font-size: 13px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // همگام‌سازی نام کامل با first_name و last_name هنگام تایپ
    const fullNameInput = document.getElementById('af_billing_full_name');
    if (fullNameInput) {
        fullNameInput.addEventListener('input', function() {
            const val = this.value.trim();
            const parts = val.split(/\s+/);
            const fName = parts[0] || 'کاربر';
            const lName = parts.slice(1).join(' ') || fName;
            const fnEl = document.getElementById('af_billing_first_name');
            const lnEl = document.getElementById('af_billing_last_name');
            if (fnEl) fnEl.value = fName;
            if (lnEl) lnEl.value = lName;
        });
    }

    // حذف ایجکسی Addon در صفحه Checkout
    const removeButtons = document.querySelectorAll('.af-checkout-addon-remove');
    removeButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const addonIndex = this.dataset.addonIndex;
            if (addonIndex === undefined || this.dataset.loading === '1') return;

            this.dataset.loading = '1';
            this.disabled = true;
            const addonBox = this.closest('.af-checkout-addon');
            if (addonBox) {
                addonBox.style.opacity = '0.5';
                addonBox.style.pointerEvents = 'none';
            }

            const formData = new FormData();
            formData.append('action', 'af_remove_checkout_addon');
            formData.append('addon_index', addonIndex);

            fetch('<?php echo esc_url( admin_url( "admin-ajax.php" ) ); ?>', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
            .then(r => r.json())
            .then(data => {
                if (!data.success) {
                    alert(data.data?.message || 'خطا در حذف خدمت پرو');
                    if (addonBox) {
                        addonBox.style.opacity = '';
                        addonBox.style.pointerEvents = '';
                    }
                    return;
                }
                if (addonBox) addonBox.remove();
                const addonsContainer = document.querySelector('.af-checkout-addons');
                if (addonsContainer && !addonsContainer.querySelector('.af-checkout-addon')) {
                    addonsContainer.remove();
                }
                if (typeof jQuery !== 'undefined') {
                    jQuery(document.body).trigger('update_checkout');
                } else {
                    window.location.reload();
                }
            })
            .catch(() => {
                if (addonBox) {
                    addonBox.style.opacity = '';
                    addonBox.style.pointerEvents = '';
                }
            })
            .finally(() => {
                this.dataset.loading = '0';
                this.disabled = false;
            });
        });
    });
});
</script>