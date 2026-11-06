<?php
/**
 * Review order table (Synced with af_is_usd_currency - USD & IRT)
 * فایل: woocommerce/checkout/review-order.php
 */

defined( 'ABSPATH' ) || exit;

$is_usd         = function_exists( 'af_is_usd_currency' ) ? af_is_usd_currency() : ( get_woocommerce_currency() === 'USD' );
$currency_label = $is_usd ? 'دلار' : 'تومان';

$format_checkout_price = function( $amount ) use ( $is_usd ) {
    $amount = (float) $amount;
    if ( $is_usd ) {
        $decimals = ( floor( $amount ) == $amount ) ? 0 : 2;
        return '$' . number_format( $amount, $decimals, '.', ',' );
    }
    return number_format( $amount, 0, '', '.' );
};
?>

<table class="shop_table woocommerce-checkout-review-order-table">

    <thead>
        <tr>
            <th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
            <th class="product-total"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php do_action( 'woocommerce_review_order_before_cart_contents' ); ?>
        <?php do_action( 'woocommerce_review_order_after_cart_contents' ); ?>
    </tbody>

    <tfoot>

        <tr class="cart-subtotal af-bill-row">
            <th>مبلغ نهایی</th>
            <td>
                <?php $subtotal = WC()->cart->get_subtotal(); ?>
                <span class="af-bill-price af-subtotal-price">
                    <span class="af-bill-number" style="direction: ltr; display: inline-block;">
                        <?php echo esc_html( $format_checkout_price( $subtotal ) ); ?>
                    </span>
                    <span class="af-bill-currency">
                        <?php echo esc_html( $currency_label ); ?>
                    </span>
                </span>
            </td>
        </tr>

        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <?php
            $discount_amount = WC()->cart->get_coupon_discount_amount(
                $coupon->get_code(),
                WC()->cart->display_prices_including_tax()
            );
            if ( $discount_amount <= 0 ) {
                continue;
            }
            ?>
            <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?> af-bill-row af-discount-row">
                <th>کد تخفیف</th>
                <td>
                    <span class="af-discount-price">
                        <span class="af-discount-number" style="direction: ltr; display: inline-block;">
                            <?php echo esc_html( $format_checkout_price( $discount_amount ) ); ?>
                        </span>
                        <span class="af-bill-currency">
                            <?php echo esc_html( $currency_label ); ?>
                        </span>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
            <tr class="fee">
                <th><?php echo esc_html( $fee->name ); ?></th>
                <td><?php wc_cart_totals_fee_html( $fee ); ?></td>
            </tr>
        <?php endforeach; ?>

        <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

        <tr class="af-bill-separator-row">
            <td colspan="2">
                <div class="af-bill-separator"></div>
            </td>
        </tr>

        <tr class="order-total af-final-total-row">
            <th>مبلغ پرداختی</th>
            <td>
                <?php $final_total = WC()->cart->get_total( 'edit' ); ?>
                <span class="af-final-price">
                    <span class="af-final-number" style="direction: ltr; display: inline-block;">
                        <?php echo esc_html( $format_checkout_price( $final_total ) ); ?>
                    </span>
                    <span class="af-final-currency">
                        <?php echo esc_html( $currency_label ); ?>
                    </span>
                </span>
            </td>
        </tr>

        <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

    </tfoot>

</table>

<style>
.af-checkout-review-order { width: 100%; background: #FFFFFF; border-radius: 32px; padding: 20px; box-sizing: border-box; direction: rtl; }
.af-checkout-review-title { width: 100%; padding-right: 30px; margin-bottom: 28px; margin-top: 20px; color: #161618; font-size: 24px; font-weight: 500; line-height: 1.8; text-align: right; }
.af-checkout-review-order .woocommerce-checkout-review-order-table { width: 100%; margin: 0; padding: 32px; border: none !important; border-collapse: collapse; background: transparent !important; }
.af-checkout-review-order .woocommerce-checkout-review-order-table thead { display: none; }
.af-checkout-review-order .woocommerce-checkout-review-order-table th, .af-checkout-review-order .woocommerce-checkout-review-order-table td { border: none !important; background: transparent !important; }
.af-bill-row { border: none !important; }
.af-bill-row th { padding: 0 0 16px; color: #65656D; font-size: 12px; font-weight: 400; text-align: right; }
.af-bill-row td { padding: 0 0 16px; text-align: left; }
.af-bill-price { display: inline-flex; align-items: baseline; gap: 4px; white-space: nowrap; color: #161618; font-size: 14px; font-weight: 500; }
.af-bill-number { color: #161618; }
.af-bill-currency { color: #65656D; font-size: 12px; font-weight: 400; }
.af-discount-row th { color: #65656D !important; }
.af-discount-price { display: inline-flex; align-items: baseline; gap: 4px; white-space: nowrap; }
.af-discount-number { color: #D32F2F; font-size: 14px; font-weight: 500; }
.af-discount-price .af-bill-currency { color: #65656D; }
.af-bill-separator-row { border: none !important; }
.af-bill-separator-row td { padding: 4px 0 20px !important; border: none !important; }
.af-bill-separator { width: 100%; height: 1px; background: #F0F0F1; }
.af-final-total-row { border: none !important; background: transparent !important; }
.af-final-total-row th { padding: 0 !important; color: #65656D; font-size: 14px; font-weight: 400; text-align: right; vertical-align: middle; }
.af-final-total-row td { padding: 0 !important; text-align: left; vertical-align: middle; }
.af-final-price { display: inline-flex; align-items: baseline; justify-content: flex-end; gap: 4px; white-space: nowrap; }
.af-final-number { color: #161618; font-size: 24px; font-weight: 500; line-height: 1; }
.af-final-currency { color: #65656D; font-size: 12px; font-weight: 400; line-height: 1; }
@media only screen and (max-width: 768px) {
    .af-checkout-review-order { padding: 16px; border-radius: 24px; }
    .af-checkout-review-title { margin-bottom: 24px; font-size: 17px; }
    .af-bill-row th { font-size: 12px; }
    .af-bill-price { font-size: 16px; }
    .af-discount-number { font-size: 13px; }
    .af-final-total-row th { font-size: 13px; }
    .af-final-number { font-size: 22px; }
    .af-final-currency { font-size: 11px; }
}
</style>