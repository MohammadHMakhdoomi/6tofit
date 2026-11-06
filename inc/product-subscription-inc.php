<?php
/**
 * اضافه کردن تب «اشتراک‌ها» به صفحه ویرایش محصول + افزودن هوشمند به سبد خرید
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'woocommerce_product_data_tabs', 'add_product_subscriptions_tab' );
function add_product_subscriptions_tab( $tabs ) {
	$tabs['product_subscriptions'] = array(
		'label'    => 'اشتراک‌ها',
		'target'   => 'product_subscriptions_data',
		'class'    => array( 'show_if_simple', 'show_if_variable' ),
		'priority' => 26,
	);
	return $tabs;
}

add_action( 'woocommerce_product_data_panels', 'product_subscriptions_tab_content' );
function product_subscriptions_tab_content() {
	global $post;
	$subscriptions = get_post_meta( $post->ID, '_product_subscriptions', true );
	if ( ! is_array( $subscriptions ) ) {
		$subscriptions = array();
	}
	?>
	<div id="product_subscriptions_data" class="panel woocommerce_options_panel">
		<div class="options_group">
			<p class="form-field">
				<strong>گزینه‌های اشتراک محصول</strong><br>
				<span class="description">
					تعداد ماه و درصد تخفیف رو مشخص کن.
					قیمت نهایی = (قیمت محصول × تعداد ماه) منهای درصد تخفیف.
				</span>
			</p>

			<table class="widefat" id="product-subscriptions-table" style="margin-top: 15px;">
				<thead>
					<tr>
						<th style="width: 30%;">تعداد ماه</th>
						<th style="width: 30%;">درصد تخفیف (%)</th>
						<th style="width: 25%;">پیش‌نمایش قیمت</th>
						<th style="width: 15%;">عملیات</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( ! empty( $subscriptions ) ) : ?>
						<?php foreach ( $subscriptions as $index => $sub ) :
							$months   = intval( $sub['months'] ?? 1 );
							$discount = floatval( $sub['discount'] ?? 0 );
						?>
							<tr class="subscription-row">
								<td>
									<input type="number"
										name="product_subscriptions[<?php echo $index; ?>][months]"
										value="<?php echo esc_attr( $months ); ?>"
										min="1"
										step="1"
										style="width:100%;"
										class="sub-months" />
								</td>
								<td>
									<input type="number"
										name="product_subscriptions[<?php echo $index; ?>][discount]"
										value="<?php echo esc_attr( $discount ); ?>"
										min="0"
										max="100"
										step="0.1"
										style="width:100%;"
										class="sub-discount" />
								</td>
								<td class="preview-price">—</td>
								<td>
									<button type="button" class="button remove-subscription">حذف</button>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>

			<p style="margin-top: 15px;">
				<button type="button" class="button button-primary" id="add-new-subscription">+ افزودن اشتراک جدید</button>
			</p>
		</div>
	</div>

	<script>
	jQuery(document).ready(function($) {
		let subIndex = <?php echo ! empty( $subscriptions ) ? count( $subscriptions ) : 0; ?>;

		function getProductPrice() {
			return parseFloat($('#_regular_price').val()) || parseFloat($('#_price').val()) || 0;
		}

		function updatePreview($row) {
			const months    = parseFloat($row.find('.sub-months').val()) || 1;
			const discount  = parseFloat($row.find('.sub-discount').val()) || 0;
			const basePrice = getProductPrice();
			const total     = basePrice * months;
			const finalPrice = total * (1 - (discount / 100));
			$row.find('.preview-price').text(finalPrice.toLocaleString('fa-IR') + ' تومان');
		}

		function updateAllPreviews() {
			$('#product-subscriptions-table tbody tr').each(function() {
				updatePreview($(this));
			});
		}

		$('#add-new-subscription').on('click', function() {
			const row = `
				<tr class="subscription-row">
					<td><input type="number" name="product_subscriptions[${subIndex}][months]" value="1" min="1" step="1" style="width:100%;" class="sub-months" /></td>
					<td><input type="number" name="product_subscriptions[${subIndex}][discount]" value="0" min="0" max="100" step="0.1" style="width:100%;" class="sub-discount" /></td>
					<td class="preview-price">—</td>
					<td><button type="button" class="button remove-subscription">حذف</button></td>
				</tr>
			`;
			$('#product-subscriptions-table tbody').append(row);
			subIndex++;
			updateAllPreviews();
		});

		$(document).on('click', '.remove-subscription', function() {
			$(this).closest('tr').remove();
		});

		$(document).on('input', '.sub-months, .sub-discount', function() {
			updatePreview($(this).closest('tr'));
		});

		$('#_regular_price, #_price').on('input', updateAllPreviews);
		updateAllPreviews();
	});
	</script>
	<?php
}

add_action( 'woocommerce_process_product_meta', 'save_product_subscriptions' );
function save_product_subscriptions( $post_id ) {
	if ( ! isset( $_POST['product_subscriptions'] ) || ! is_array( $_POST['product_subscriptions'] ) ) {
		delete_post_meta( $post_id, '_product_subscriptions' );
		return;
	}

	$subscriptions = array();
	foreach ( $_POST['product_subscriptions'] as $sub ) {
		$months   = intval( $sub['months'] ?? 0 );
		$discount = floatval( $sub['discount'] ?? 0 );
		if ( $months >= 1 ) {
			$subscriptions[] = array(
				'months'   => $months,
				'discount' => max( 0, min( 100, $discount ) ),
			);
		}
	}
	update_post_meta( $post_id, '_product_subscriptions', $subscriptions );
}

/**
 * AJAX: افزودن اشتراک (ساده یا متغیر) به همراه Addonها به سبد خرید
 */
add_action( 'wp_ajax_af_add_subscription_to_cart', 'af_add_subscription_to_cart' );
add_action( 'wp_ajax_nopriv_af_add_subscription_to_cart', 'af_add_subscription_to_cart' );

function af_add_subscription_to_cart() {
	$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
	$months     = isset( $_POST['months'] ) ? max( 1, absint( $_POST['months'] ) ) : 1;
	$discount   = isset( $_POST['discount'] ) ? floatval( $_POST['discount'] ) : 0;

	if ( ! $product_id ) {
		wp_send_json_error( array( 'message' => 'محصول نامعتبر است' ) );
	}

	$product = wc_get_product( $product_id );
	if ( ! $product ) {
		wp_send_json_error( array( 'message' => 'محصول یافت نشد' ) );
	}

	WC()->cart->empty_cart();

	// محاسبه قیمت دقیق اشتراک در ارز فعلی (دلار یا تومان)
	$exact_price = function_exists( 'af_get_exact_product_price' )
		? af_get_exact_product_price( $product_id, $months )
		: floatval( $_POST['price'] ?? 0 );

	$cart_item_data = array(
		'af_subscription' => array(
			'months'   => $months,
			'discount' => $discount,
			'price'    => $exact_price,
		),
		'unique_key' => md5( microtime() . rand() ),
	);

	$variation_id         = 0;
	$variation_attributes = array();

	// اگر محصول از نوع متغیر (Variable) است، متغیر متناظر با تعداد ماه را پیدا کن
	if ( $product->is_type( 'variable' ) ) {
		$children = $product->get_children();
		foreach ( $children as $child_id ) {
			$dur = get_post_meta( $child_id, 'attribute_pa_duration', true ) ?: get_post_meta( $child_id, 'attribute_duration', true );
			$lvl = strtolower( get_post_meta( $child_id, 'attribute_pa_level', true ) ?: get_post_meta( $child_id, 'attribute_level', true ) );
			$opt = strtolower( get_post_meta( $child_id, 'attribute_pa_option', true ) ?: get_post_meta( $child_id, 'attribute_option', true ) );

			if ( absint( $dur ) === $months && ( empty( $lvl ) || $lvl === 'core' || $lvl === 'cip' ) && ( empty( $opt ) || $opt === 'standard' || $opt === 'onboarding' ) ) {
				$variation_id = $child_id;
				break;
			}
		}
		// اگر متغیر دقیق پیدا نشد، اولین متغیر فرزند را بگیر
		if ( ! $variation_id && ! empty( $children ) ) {
			$variation_id = $children[0];
		}
		if ( $variation_id ) {
			$var_obj = wc_get_product( $variation_id );
			if ( $var_obj ) {
				$variation_attributes = $var_obj->get_variation_attributes();
			}
		}
	}

	$added = WC()->cart->add_to_cart( $product_id, 1, $variation_id, $variation_attributes, $cart_item_data );

	if ( ! $added ) {
		wp_send_json_error( array( 'message' => 'خطا در افزودن به سبد خرید' ) );
	}

	wp_send_json_success( array(
		'checkout_url' => wc_get_checkout_url(),
	) );
}

add_filter( 'woocommerce_get_item_data', 'af_display_subscription_in_cart', 10, 2 );
function af_display_subscription_in_cart( $item_data, $cart_item ) {
	if ( empty( $cart_item['af_subscription'] ) ) {
		return $item_data;
	}

	$sub         = $cart_item['af_subscription'];
	$item_data[] = array(
		'key'   => 'اشتراک',
		'value' => $sub['months'] . ' ماهه' . ( $sub['discount'] > 0 ? ' (' . $sub['discount'] . '٪ تخفیف)' : '' ),
	);

	return $item_data;
}

add_action( 'woocommerce_checkout_create_order_line_item', 'af_save_subscription_to_order_item', 10, 4 );
function af_save_subscription_to_order_item( $item, $cart_item_key, $values, $order ) {
	if ( empty( $values['af_subscription'] ) ) {
		return;
	}

	$sub = $values['af_subscription'];
	$item->add_meta_data( 'اشتراک', $sub['months'] . ' ماهه' );
	if ( $sub['discount'] > 0 ) {
		$item->add_meta_data( 'تخفیف اشتراک', $sub['discount'] . '%' );
	}
}