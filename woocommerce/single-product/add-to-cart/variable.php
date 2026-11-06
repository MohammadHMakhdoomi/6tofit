<?php
/**
 * Variable product add to cart - Custom Sticky Footer & Popups (CURCY Compatible)
 *
 * @package WooCommerce\Templates
 * @version 10.9.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// تشخیص ارز فعال در CURCY
$current_currency = get_woocommerce_currency();
if ( class_exists( 'WOOMULTI_CURRENCY_Data' ) ) {
	$current_currency = WOOMULTI_CURRENCY_Data::get_ins()->get_current_currency();
}
$is_usd = ( $current_currency === 'USD' );

// محاسبه کمترین قیمت متغیرها (دلار ثابت یا تومان)
$min_price = 0;
$children  = $product->get_children();

if ( $is_usd ) {
	$usd_prices = array();
	foreach ( $children as $child_id ) {
		$wmcp = get_post_meta( $child_id, '_regular_price_wmcp', true );
		$data = is_string( $wmcp ) ? json_decode( $wmcp, true ) : $wmcp;
		if ( is_array( $data ) && ! empty( $data['USD'] ) && is_numeric( $data['USD'] ) ) {
			$usd_prices[] = (float) $data['USD'];
		}
	}
	$min_price = ! empty( $usd_prices ) ? min( $usd_prices ) : (float) $product->get_variation_price( 'min', true );
} else {
	$toman_prices = array();
	foreach ( $children as $child_id ) {
		$reg = get_post_meta( $child_id, '_regular_price', true );
		if ( is_numeric( $reg ) && (float) $reg > 0 ) {
			$toman_prices[] = (float) $reg;
		}
	}
	$min_price = ! empty( $toman_prices ) ? min( $toman_prices ) : (float) $product->get_variation_price( 'min', true );
}

// لود کردن پاپ‌آپ اشتراک و احراز هویت
include_once get_template_directory() . '/template-parts/product-subscription.php';
if ( function_exists( 'render_auth_popup' ) ) {
	render_auth_popup( get_the_ID() );
}

// لود کردن پاپ‌آپ خدمات پرو (Addons)
include_once get_template_directory() . '/template-parts/addon-popup.php';
if ( function_exists( 'render_addons_popup' ) ) {
	render_addons_popup( get_the_ID() );
}

do_action( 'woocommerce_before_add_to_cart_form' );
?>

<style>
	.sticky-footer {
		position: fixed;
		bottom: 0;
		left: 0;
		width: 100%;
		background-color: #fff;
		box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
		z-index: 1000;
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 12px 0;
	}
	.footer-rowpr {
		width: 80%;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}
	.right-column {
		display: flex;
		justify-content: flex-end;
		align-items: center;
		gap: 12px;
	}
	.right-column img {
		width: 48px;
		height: 48px;
		object-fit: contain;
		border-radius: 8px;
	}
	.right-column span {
		font-size: 30px;
		font-weight: 500;
		color: #161618;
	}
	.left-column {
		display: flex;
		gap: 16px;
		align-items: center;
	}
	.price-column {
		display: flex;
		gap: 20px;
		align-items: flex-end;
	}
	.price-details {
		display: flex;
		flex-direction: column;
		align-items: flex-start;
	}
	.starting-price {
		font-size: 12px;
		font-weight: 400;
		color: #65656D;
	}
	.total-price {
		font-size: 24px;
		font-weight: 500;
		color: #161618;
		direction: ltr;
		display: inline-block;
	}
	.buttons-column {
		display: flex;
		gap: 16px;
	}
	.sticky-footer .button {
		padding: 12px 10px;
		font-size: 18px;
		font-weight: 400;
		border-radius: 999px;
		text-align: center;
		min-width: 120px;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 4px;
		cursor: pointer;
		text-decoration: none;
	}
	.primary-button {
		background-color: #5247FF;
		color: #fff !important;
		border: 0px;
	}
	.secondary-button {
		background-color: #fff;
		color: #5247FF !important;
		border: 1.5px solid #5247FF;
	}
	.secondary-button .plus-sign {
		font-size: 18px;
		color: #5247FF;
	}
	@media only screen and (max-width: 768px) {
		.sticky-footer {
			height: auto;
			align-items: flex-start;
			padding: 16px 0;
		}
		.buttons-column {
			justify-content: space-between;
			width: 100%;
		}
		.sticky-footer .button {
			min-width: 150px;
			font-size: 18px;
		}
		.footer-rowpr {
			flex-direction: column;
			align-items: flex-start;
			gap: 16px;
			width: 90%;
		}
		.right-column {
			justify-content: flex-start;
		}
		.right-column img {
			width: 32px;
			height: 32px;
		}
		.right-column span {
			font-size: 24px;
		}
		.left-column {
			flex-direction: column;
			align-items: flex-start;
			gap: 16px;
			width: 100%;
		}
		.price-column {
			justify-content: space-between;
			width: 100%;
		}
		.total-price {
			font-size: 20px;
		}
	}
</style>

<div class="sticky-footer" data-base-price="<?php echo esc_attr( $min_price ); ?>" data-currency="<?php echo esc_attr( $current_currency ); ?>">
	<div class="footer-rowpr">
		<div class="right-column">
			<?php
			$image_id = $product->get_image_id();
			if ( $image_id ) {
				echo wp_get_attachment_image( $image_id, 'thumbnail', false, array( 'alt' => esc_attr( $product->get_name() ) ) );
			} else {
				echo wc_placeholder_img( 'thumbnail' );
			}
			?>
			<span><?php echo esc_html( $product->get_name() ); ?></span>
		</div>

		<div class="left-column">
			<div class="price-column">
				<div class="price-details">
					<span class="starting-price">شروع قیمت از</span>
				</div>
				<div>
					<span class="total-price">
						<?php
						if ( $is_usd ) {
							echo '$' . esc_html( number_format( $min_price, ( floor( $min_price ) == $min_price ? 0 : 2 ), '.', ',' ) ) . ' دلار';
						} else {
							echo esc_html( number_format( $min_price, 0, '.', '.' ) ) . ' تومان';
						}
						?>
					</span>
				</div>
			</div>

			<div class="buttons-column">
				<button type="button" class="button primary-button" id="af-buy-program-btn" onclick="handleAfBuyProgramClick()">
					خرید برنامه
				</button>
				<a href="javascript:void(0)" class="button secondary-button" onclick="showAfAddonsPopup()">
					<span class="plus-sign">+</span>
					<span>خدمات پرو</span>
				</a>
			</div>
		</div>
	</div>
</div>

<script>
window.handleAfBuyProgramClick = function() {
	if (typeof window.afAuthState === 'undefined') {
		window.afAuthState = {
			productId: <?php echo (int) $product->get_id(); ?>,
			isLoggedIn: <?php echo is_user_logged_in() ? 'true' : 'false'; ?>,
			selectedSubscription: null,
			selectedAddons: [],
			selectedGender: null
		};
	}

	const selectedAddons = [];
	document.querySelectorAll('.addon-checkbox:checked').forEach(function(cb) {
		selectedAddons.push({
			index: cb.value,
			price: parseFloat(cb.dataset.price || 0),
			title: cb.closest('.service-card')?.querySelector('.checkbox-text')?.textContent?.trim() || ''
		});
	});

	window.afAuthState.selectedAddons = selectedAddons;
	window.afAuthState.productId = <?php echo (int) $product->get_id(); ?>;

	if (typeof showAfAuthPopup === 'function') {
		showAfAuthPopup();
	} else {
		alert('پاپ‌آپ هنوز لود نشده است. لطفا صفحه را رفرش کنید.');
	}
};
</script>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>