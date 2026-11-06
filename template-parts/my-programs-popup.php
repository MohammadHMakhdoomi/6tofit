<?php
/**
 * ==========================================================
 * پاپ‌آپ "برنامه‌های من" - پروفایل کاربر
 * ----------------------------------------------------------
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
 * تبدیل تاریخ میلادی به شمسی 
 * ========================================================== */

if ( ! function_exists( 'af_myprograms_div' ) ) {
	function af_myprograms_div( $a, $b ) {
		return (int) ( $a / $b );
	}
}

if ( ! function_exists( 'af_myprograms_gregorian_to_jalali' ) ) {
	function af_myprograms_gregorian_to_jalali( $gy, $gm, $gd ) {
		$g_d_m = array( 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334 );
		$gy2   = ( $gm > 2 ) ? ( $gy + 1 ) : $gy;
		$days  = 355666 + ( 365 * $gy ) + af_myprograms_div( ( $gy2 + 3 ), 4 ) - af_myprograms_div( ( $gy2 + 99 ), 100 )
			+ af_myprograms_div( ( $gy2 + 399 ), 400 ) + $gd + $g_d_m[ $gm - 1 ];

		$jy = -1595 + ( 33 * af_myprograms_div( $days, 12053 ) );
		$days %= 12053;
		$jy += 4 * af_myprograms_div( $days, 1461 );
		$days %= 1461;

		if ( $days > 365 ) {
			$jy  += af_myprograms_div( ( $days - 1 ), 365 );
			$days = ( $days - 1 ) % 365;
		}

		if ( $days < 186 ) {
			$jm = 1 + af_myprograms_div( $days, 31 );
			$jd = 1 + ( $days % 31 );
		} else {
			$jm = 7 + af_myprograms_div( ( $days - 186 ), 30 );
			$jd = 1 + ( ( $days - 186 ) % 30 );
		}

		return array( $jy, $jm, $jd );
	}
}

if ( ! function_exists( 'af_myprograms_to_persian_digits' ) ) {
	function af_myprograms_to_persian_digits( $string ) {
		$en = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
		$fa = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
		return str_replace( $en, $fa, (string) $string );
	}
}

if ( ! function_exists( 'af_myprograms_format_shamsi_date' ) ) {
	function af_myprograms_format_shamsi_date( $mysql_datetime ) {
		if ( empty( $mysql_datetime ) ) {
			return '';
		}
		$ts = is_numeric( $mysql_datetime ) ? (int) $mysql_datetime : strtotime( $mysql_datetime );
		if ( ! $ts ) {
			return '';
		}

		$gy = (int) date( 'Y', $ts );
		$gm = (int) date( 'n', $ts );
		$gd = (int) date( 'j', $ts );

		list( $jy, $jm, $jd ) = af_myprograms_gregorian_to_jalali( $gy, $gm, $gd );

		$months = array(
			1  => 'فروردین',
			2  => 'اردیبهشت',
			3  => 'خرداد',
			4  => 'تیر',
			5  => 'مرداد',
			6  => 'شهریور',
			7  => 'مهر',
			8  => 'آبان',
			9  => 'آذر',
			10 => 'دی',
			11 => 'بهمن',
			12 => 'اسفند',
		);

		$month_name = isset( $months[ $jm ] ) ? $months[ $jm ] : '';

		return af_myprograms_to_persian_digits( $jd ) . ' ' . $month_name . ' ' . af_myprograms_to_persian_digits( $jy );
	}
}


/* ==========================================================
 * گرفتن لیست محصولات خریداری‌شده‌ی کاربر جاری (از سفارش‌های ووکامرس)
 * ========================================================== */

if ( ! function_exists( 'af_myprograms_get_purchased_items' ) ) {
	function af_myprograms_get_purchased_items() {
		if ( ! is_user_logged_in() || ! function_exists( 'wc_get_orders' ) ) {
			return array();
		}

		$orders = wc_get_orders( array(
			'customer_id' => get_current_user_id(),
			'status'      => array( 'wc-completed', 'wc-processing' ),
			'limit'       => -1,
			'orderby'     => 'date',
			'order'       => 'DESC',
		) );

		$items = array();

		foreach ( $orders as $order ) {
			$order_date = $order->get_date_created() ? $order->get_date_created()->getTimestamp() : time();

			foreach ( $order->get_items() as $item ) {
				$product = $item->get_product();
				if ( ! $product ) {
					continue;
				}

				$image_id  = $product->get_image_id();
				$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : '';
				if ( ! $image_url ) {
					$image_url = function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src() : '';
				}

				$items[] = array(
					'name'      => $item->get_name(),
					'image'     => $image_url,
					'date'      => $order_date,
					'product_id' => $product->get_id(),
					'order_id'   => $order->get_id(),
				);
			}
		}

		return $items;
	}
}


/* ==========================================================
 * رندر پاپ‌آپ
 * ========================================================== */

if ( ! function_exists( 'af_myprograms_render_popup' ) ) {
	function af_myprograms_render_popup() {
		static $already = false;
		if ( $already ) {
			return;
		}
		$already = true;

		$items = af_myprograms_get_purchased_items();

		$icon_link = 'http://6tofit.com/wp-content/uploads/2025/10/brudic.svg';
		?>
		<div class="af-mp-overlay" id="af-mp-overlay">
			<div class="af-mp-content" dir="rtl">

				<div class="af-mp-header">
					<h2 class="af-mp-title">برنامه های من</h2>
					<button type="button" class="af-mp-close" id="af-mp-close" aria-label="بستن">&times;</button>
				</div>

				<div class="af-mp-list-wrap">
					<div class="af-mp-list">
						<?php if ( ! empty( $items ) ) : ?>
							<?php foreach ( $items as $item ) : ?>
								<div class="af-mp-item">
									<div class="af-mp-col af-mp-col-icon">
										<img src="<?php echo esc_url( $item['image'] ); ?>" alt="" class="af-mp-icon-img">
									</div>
									<div class="af-mp-col af-mp-col-info">
										<div class="af-mp-info-title"><?php echo esc_html( $item['name'] ); ?></div>
										<div class="af-mp-info-date"><?php echo esc_html( af_myprograms_format_shamsi_date( $item['date'] ) ); ?></div>
									</div>
									<div class="af-mp-col af-mp-col-link">
										<a href="#" class="af-mp-view-link" data-product-id="<?php echo esc_attr( $item['product_id'] ); ?>" data-order-id="<?php echo esc_attr( $item['order_id'] ); ?>">
									
											<img src="<?php echo esc_url( $icon_link ); ?>" alt="" class="af-mp-link-icon">
										</a>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else : ?>
							<div class="af-mp-empty">هنوز هیچ برنامه‌ای خریداری نکرده‌ای.</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="af-mp-footer">
					<a href="https://6tofit.com/products/" class="af-mp-cta-btn">دریافت برنامه جدید</a>
				</div>

			</div>
		</div>

		<style>
		.af-mp-overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(13, 13, 13, 0.56);
			display: none;
			align-items: center;
			justify-content: center;
			z-index: 99999;
			backdrop-filter: blur(50px);
			-webkit-backdrop-filter: blur(50px);
		}
		.af-mp-overlay.active {
			display: flex !important;
		}

		.af-mp-content {
			background: #F7F7F8;
			border-radius: 40px;
			max-width: 46%;
			min-width: 700px;
			min-height: 50%;
			max-height: 90vh;
			width: 100%;
			overflow: hidden;
			position: relative;
			display: flex;
			flex-direction: column;
			font-family: 'iranyekan', sans-serif;
		}

		.af-mp-header {
			padding: 82px 82px 16px;
			position: relative;
			text-align: right;
			flex-shrink: 0;
		}
		.af-mp-title {
			font-size: 24px;
			font-weight: 600;
			color: #000;
			margin: 0;
		}
		.af-mp-close {
			position: absolute;
			top: 18px;
			right: 28px;
			background: none;
			border: none;
			cursor: pointer;
			padding: 0;
			z-index: 10;
			font-size: 26px;
			line-height: 1;
			color: #6e6e6e;
		}

		.af-mp-list-wrap {
			flex: 1;
			min-height: 0;
			overflow-y: auto;
			padding: 4px 102px 20px;
			scrollbar-width: none;
			-ms-overflow-style: none;
		}
		.af-mp-list-wrap::-webkit-scrollbar {
			display: none;
		}
		.af-mp-list {
			display: flex;
			flex-direction: column;
			gap: 12px;
		}

		.af-mp-item {
			display: flex;
			flex-direction: row;
			align-items: center;
	
			border-radius: 20px;
			padding: 14px 18px;
			gap: 14px;
		}

		.af-mp-col-icon {
			flex: 0 0 auto;
			width: 40px;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.af-mp-icon-img {
			width: 40px;
			height: 40px;
			object-fit: cover;
			display: block;
			border-radius: 10px;
		}

		.af-mp-col-info {
			flex: 1 1 auto;
			min-width: 0;
			display: flex;
			flex-direction: column;
			gap: 4px;
			text-align: right;
		}
		.af-mp-info-title {
			font-size: 16px;
			color: #161618;
			font-weight: 500;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}
		.af-mp-info-date {
			font-size: 12px;
			color: #65656D;
		}

		.af-mp-col-link {
			flex: 0 0 auto;
		}
		.af-mp-view-link {
			display: flex;
			align-items: center;
			gap: 4px;
			text-decoration: none;
			color: #65656D;
			font-size: 12px;
			white-space: nowrap;
			cursor: pointer;
		}
		.af-mp-link-icon {
			width: 14px;
			height: 14px;
			object-fit: contain;
			display: block;
		}

		.af-mp-empty {
			text-align: center;
			padding: 40px 10px;
			color: #9B9BA1;
			font-size: 15px;
		}

		.af-mp-footer {
			flex-shrink: 0;
			padding: 16px 32px 32px;
			text-align: center;
		}
		.af-mp-cta-btn {
			display: inline-block;
			background: #000000;
			color: #FFFFFF;
			font-size: 18px;
			border: none;
			border-radius: 100px;
			padding: 12px 10px;
			cursor: pointer;
			font-family: 'iranyekan', sans-serif;
			transition: opacity 0.2s ease;
			text-decoration: none;
			    min-width: 30%;
		}
		.af-mp-cta-btn:hover {
			opacity: 0.85;
			color: #FFFFFF;
		}

		@media only screen and (max-width: 768px) {
			.af-mp-content {
				min-width: unset;
				width: 100%;
				height: 100%;
				max-height: 100%;
				border-radius: 0;
				max-width: unset;
			}
			.af-mp-header {
				padding: 20px 20px 12px;
			}
			.af-mp-title {
				font-size: 20px;
				        text-align: center;
			}
			.af-mp-list-wrap {
				padding: 14px 16px 16px;
			}
			.af-mp-footer {
				padding: 12px 16px 20px;
			}
			.af-mp-cta-btn {
				    min-width: 100%;
			}
		}
		</style>

		<script>
		(function () {
			if ( window._afMyProgramsInit ) return;
			window._afMyProgramsInit = true;

			var overlay  = document.getElementById('af-mp-overlay');
			var closeBtn = document.getElementById('af-mp-close');

			function open() {
				if (!overlay) return;
				overlay.classList.add('active');
				document.body.style.overflow = 'hidden';
			}
			function close() {
				if (!overlay) return;
				overlay.classList.remove('active');
				document.body.style.overflow = '';
			}

			if (closeBtn) closeBtn.addEventListener('click', close);
			if (overlay) {
				overlay.addEventListener('click', function (e) {
					if (e.target === overlay) close();
				});
			}

			window.AFMyPrograms = {
				open: open,
				close: close
			};
		})();
		</script>
		<?php
	}
}


/* ==========================================================
 * چاپ مستقیم پاپ‌آپ + Shortcode
 * ----------------------------------------------------------
 * همین الگوی «چاپ مستقیم موقع require» که برای تست‌های من استفاده
 * شد؛ این فایل را هم از داخل footer.php قالب (نزدیک انتهای body>)
 * require کن، نه از وسط functions.php.
 * ========================================================== */



if ( ! function_exists( 'render_myprograms_popup' ) ) {
	function render_myprograms_popup() {
		af_myprograms_render_popup();
	}
}

if ( ! function_exists( 'af_myprograms_shortcode' ) ) {
	function af_myprograms_shortcode( $atts ) {
		ob_start();
		?>
		<button type="button" class="af-pro-open-my-programs" onclick="AFMyPrograms.open()">
			برنامه های من
		</button>
		<?php
		return ob_get_clean();
	}
}
add_shortcode( 'af_my_programs', 'af_myprograms_shortcode' );