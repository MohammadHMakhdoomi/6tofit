<?php
/**
 * Checkout Payment Section (Fixed for Stripe Credit Card Box & ZarinPal)
 *
 * @package WooCommerce\Templates
 * @version 10.9.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>
<div id="payment" class="woocommerce-checkout-payment">
	<?php if ( WC()->cart && WC()->cart->needs_payment() ) : ?>
		<ul class="wc_payment_methods payment_methods methods" aria-label="<?php esc_attr_e( 'Payment methods', 'woocommerce' ); ?>">
			<?php
			if ( ! empty( $available_gateways ) ) {
				foreach ( $available_gateways as $gateway ) {
					wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
				}
			} else {
				echo '<li>';
				wc_print_notice( apply_filters( 'woocommerce_no_available_payment_methods_message', esc_html__( 'هیچ درگاه پرداختی برای این ارز فعال نیست.', 'woocommerce' ) ), 'notice' );
				echo '</li>';
			}
			?>
		</ul>
	<?php endif; ?>
	<div class="form-row place-order">
		<noscript>
			<button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
		</noscript>

		<?php wc_get_template( 'checkout/terms.php' ); ?>

		<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

		<?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); ?>

		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
	</div>
</div>

<style>
.woocommerce-checkout-payment {
    width: 100%;
    direction: rtl;
}
.woocommerce-checkout-payment .wc_payment_methods {
    display: flex !important;
    flex-direction: column;
    gap: 16px;
    margin: 0;
    padding: 0;
    list-style: none !important;
}
.woocommerce-checkout-payment .wc_payment_method {
    position: relative;
    display: block !important;
    margin: 0 !important;
    padding: 16px 20px !important;
    background: #F9F9FB !important;
    border: 1.5px solid transparent !important;
    border-radius: 24px !important;
    list-style: none !important;
}
.woocommerce-checkout-payment .wc_payment_method::before,
.woocommerce-checkout-payment .wc_payment_method::after {
    display: none !important;
    content: none !important;
}
.woocommerce-checkout-payment .wc_payment_method input.input-radio {
    appearance: none;
    -webkit-appearance: none;
    width: 18px !important;
    height: 18px !important;
    min-width: 18px;
    min-height: 18px;
    margin: 0 0 0 10px !important;
    padding: 0 !important;
    border: 1.5px solid #5A5A61 !important;
    border-radius: 50% !important;
    background: transparent !important;
    box-shadow: none !important;
    cursor: pointer;
    vertical-align: middle;
    position: relative;
}
.woocommerce-checkout-payment .wc_payment_method input.input-radio:checked {
    border-color: #5247FF !important;
    background: #ffffff !important;
}
.woocommerce-checkout-payment .wc_payment_method input.input-radio:checked::after {
    content: "";
    position: absolute;
    width: 70%;
    height: 70%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #5247FF;
    border-radius: 50%;
}
.woocommerce-checkout-payment .wc_payment_method label {
    display: inline-flex;
    align-items: center;
    margin: 0 !important;
    padding: 0 !important;
    color: #161618 !important;
    font-size: 16px !important;
    font-weight: 500;
    line-height: 1.6;
    cursor: pointer;
    vertical-align: middle;
}
/* مخفی کردن توضیحات متنی درگاه‌های ایرانی، اما نمایش کامل باکس کارت بانکی Stripe */
.woocommerce-checkout-payment .wc_payment_method .payment_box {
    display: none;
}
.woocommerce-checkout-payment .wc_payment_method.payment_method_stripe .payment_box,
.woocommerce-checkout-payment .wc_payment_method.payment_method_af_stripe_test .payment_box,
.woocommerce-checkout-payment .wc_payment_method.payment_method_stripe_cc .payment_box {
    display: block !important;
    margin-top: 14px !important;
}
.woocommerce-checkout-payment .place-order {
    margin-top: 24px;
}
#place_order {
    width: 100%;
    height: 56px;
    background: #5247FF !important;
    color: #FFFFFF !important;
    border: none !important;
    border-radius: 999px !important;
    font-size: 18px !important;
    font-weight: 700 !important;
    cursor: pointer;
    font-family: inherit;
    transition: background 0.25s ease;
}
#place_order:hover {
    background: #4239D0 !important;
}
</style>
<?php
if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}