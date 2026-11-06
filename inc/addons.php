<?php
/**
 * اضافه کردن تب "افزونه‌ها (Addons)" به صفحه ویرایش محصول (با پشتیبانی از قیمت ثابت دلاری)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'woocommerce_product_data_tabs', 'add_product_addons_tab' );
function add_product_addons_tab( $tabs ) {$tabs['product_addons'] = array(
		'label'    => 'افزونه‌ها (Addons)',
		'target'   => 'product_addons_data',
		'class'    => array( 'show_if_simple', 'show_if_variable' ),
		'priority' => 25,
	);
	return $tabs;
}

add_action( 'woocommerce_product_data_panels', 'product_addons_tab_content' );
function product_addons_tab_content() {
	global $post;
	$addons = get_post_meta($post->ID, '_product_addons', true );
	if ( ! is_array( $addons ) ) {$addons = array();
	}
	?>
	<div id="product_addons_data" class="panel woocommerce_options_panel">
		<div class="options_group">
			<p class="form-field">
				<strong>افزونه‌های محصول</strong><br>
				<span class="description">می‌تونی چندین Addon با عنوان، توضیح، قیمت تومانی و قیمت ثابت دلاری اضافه کنی.</span>
			</p>

			<table class="widefat" id="product-addons-table" style="margin-top: 15px;">
				<thead>
					<tr>
						<th style="width: 22%;">عنوان</th>
						<th style="width: 38%;">توضیح</th>
						<th style="width: 15%;">قیمت (تومان)</th>
						<th style="width: 15%;">قیمت ثابت (دلار)</th>
						<th style="width: 10%;">عملیات</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( ! empty( $addons ) ) : ?>
						<?php foreach ( $addons as $index =>$addon ) : ?>
							<tr class="addon-row">
								<td>
									<input type="text" name="product_addons[<?php echo $index; ?>][title]" value="<?php echo esc_attr( $addon['title'] ?? '' ); ?>" style="width:100%;" />
								</td>
								<td>
									<textarea name="product_addons[<?php echo $index; ?>][description]" rows="2" style="width:100%;"><?php echo esc_textarea( $addon['description'] ?? '' ); ?></textarea>
								</td>
								<td>
									<input type="number" name="product_addons[<?php echo $index; ?>][price]" value="<?php echo esc_attr( $addon['price'] ?? '' ); ?>" step="1000" min="0" style="width:100%;" placeholder="تومان" />
								</td>
								<td>
									<input type="number" name="product_addons[<?php echo $index; ?>][price_usd]" value="<?php echo esc_attr( $addon['price_usd'] ?? '' ); ?>" step="0.01" min="0" style="width:100%;" placeholder="دلار ($)" />
								</td>
								<td>
									<button type="button" class="button remove-addon">حذف</button>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>

			<p style="margin-top: 15px;">
				<button type="button" class="button button-primary" id="add-new-addon">+ افزودن Addon جدید</button>
			</p>
		</div>
	</div>

	<script>
	jQuery(document).ready(function($) {
		let addonIndex = <?php echo ! empty( $addons ) ? count( $addons ) : 0; ?>;

		$('#add-new-addon').on('click', function() {
			const row = `
				<tr class="addon-row">
					<td><input type="text" name="product_addons[${addonIndex}][title]" value="" style="width:100%;" placeholder="عنوان Addon" /></td>
					<td><textarea name="product_addons[${addonIndex}][description]" rows="2" style="width:100%;" placeholder="توضیحات..."></textarea></td>
					<td><input type="number" name="product_addons[${addonIndex}][price]" value="" step="1000" min="0" style="width:100%;" placeholder="تومان" /></td>
					<td><input type="number" name="product_addons[${addonIndex}][price_usd]" value="" step="0.01" min="0" style="width:100%;" placeholder="دلار ($)" /></td>
					<td><button type="button" class="button remove-addon">حذف</button></td>
				</tr>
			`;
			$('#product-addons-table tbody').append(row);
			addonIndex++;
		});

		$(document).on('click', '.remove-addon', function() {$(this).closest('tr').remove();
		});
	});
	</script>
	<?php
}

add_action( 'woocommerce_process_product_meta', 'save_product_addons' );
function save_product_addons( $post_id ) {
	if ( ! isset( $_POST['product_addons'] ) || ! is_array( $_POST['product_addons'] ) ) {
		delete_post_meta( $post_id, '_product_addons' );
		return;
	}

	$addons = array();

	foreach ( $_POST['product_addons'] as$addon ) {
		$title       = sanitize_text_field($addon['title'] ?? '' );
		$description = sanitize_textarea_field($addon['description'] ?? '' );
		$price       = floatval($addon['price'] ?? 0 );
		$price_usd   = ( isset($addon['price_usd'] ) && $addon['price_usd'] !== '' ) ? floatval( $addon['price_usd'] ) : '';

		if ( ! empty( $title ) ) {$addons[] = array(
				'title'       => $title,
				'description' => $description,
				'price'       => $price,
				'price_usd'   => $price_usd,
			);
		}
	}

	update_post_meta( $post_id, '_product_addons',$addons );
}