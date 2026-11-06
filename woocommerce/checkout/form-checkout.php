<?php
/**
 * Checkout Form
 *
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">

	<div class="col2-set rowsix" id="customer_details">

		<?php if ( $checkout->get_checkout_fields() ) : ?>
			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>
		<?php endif; ?>

		<div class="col-2">
			<?php if ( $checkout->get_checkout_fields() ) : ?>
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
			<?php endif; ?>

			<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

			<div id="order_review" class="woocommerce-checkout-review-order">
				<div class="af-checkout-review-title">
					صورت حساب
				</div>
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>

			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
		</div>

	</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<style>
.woocommerce-checkout-review-order-table {
    width: 100%;
    background: #FFFFFF;
    border-radius: 32px;
    padding: 20px;
    box-sizing: border-box;
    direction: rtl;
}
.woocommerce-checkout-review-order-table .product-name {
    display: none;
}
.woocommerce-checkout-review-order-table .product-total {
    display: none;
}
.rowsix {
    display: flex;
    gap: 20px;
    justify-content: space-between;
}
.rowsix .col-1 {
    flex: 0 0 50%;
    gap: 20px;
    display: flex;
    flex-direction: column;
}
.rowsix .col-2 {
    flex: 0 0 calc(50% - 24px);
}
@media only screen and (max-width: 768px) {
    .rowsix {
        display: flex;
        gap: 20px;
        justify-content: space-between;
        flex-direction: column;
        width: 90%;
        margin-left: auto;
        margin-right: auto;
    }
    .site-page-container {
        padding: 0;
        width: 100%;
    }
    .page-breadcrumb {
        display: none;
    }
}
</style>