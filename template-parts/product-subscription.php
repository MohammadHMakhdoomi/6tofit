<?php
/**
 * Auth + Subscription Popup (Complete 5-Stage Flow + Atomic Cart & Checkout Redirect)
 * فایل: template-parts/product-subscription.php
 */
if ( ! function_exists( 'render_auth_popup' ) ) {
	function render_auth_popup( $product_id = 0 ) {
		if ( ! $product_id ) {
			global $product;
			$product_id = ( $product && is_a( $product, 'WC_Product' ) ) ? $product->get_id() : 0;
		}

		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			return;
		}

		$is_logged_in = is_user_logged_in();
		$is_usd       = function_exists( 'af_is_usd_currency' ) ? af_is_usd_currency() : ( get_woocommerce_currency() === 'USD' );

		$base_price = function_exists( 'af_get_exact_product_price' )
			? af_get_exact_product_price( $product_id, 1 )
			: floatval( $product->get_price() );

		$subscriptions = get_post_meta( $product_id, '_product_subscriptions', true );
		if ( ! is_array( $subscriptions ) || empty( $subscriptions ) ) {
			if ( $product->get_sku() === 'S2F-CIP' || (int) $product_id === 499 ) {
				$subscriptions = array(
					array( 'months' => 3, 'discount' => 0 ),
					array( 'months' => 6, 'discount' => 10 ),
				);
			} else {
				$subscriptions = array(
					array( 'months' => 1, 'discount' => 0 ),
					array( 'months' => 3, 'discount' => 16 ),
					array( 'months' => 6, 'discount' => 21 ),
				);
			}
		}

		ob_start();
		?>
<style>
/* =====================================================
   GLOBAL STYLES (Overlay + Common)
===================================================== */
.af-auth-popup-overlay {
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
.af-auth-popup-overlay.active {
	display: flex !important;
}
.af-auth-popup-content {
	background: #F7F7F8;
	border-radius: 40px;
	text-align: center;
	max-width: 96%;
	min-width: 900px;
}
.af-auth-popup-content .af-auth-stage {
	display: none;
}
.af-auth-popup-content .af-auth-stage.active {
	display: block;
}
.af-auth-stage-wrapper {
	display: flex;
	height: 100%;
	min-height: 520px;
	border-radius: 40px;
	overflow: hidden;
}
.af-auth-stage-left {
	flex: 1.4;
	display: flex;
	align-items: center;
	justify-content: center;
}
.af-auth-stage-image {
	width: 60%;
	display: block;
}
.af-auth-stage-right {
	flex: 1;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 30px 24px;
	background: #F7F7F8;
}
.af-auth-stage-box {
	background: #FFFFFF;
	border-radius: 28px;
	padding: 48px 56px;
	width: 100%;
	box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
	display: flex;
	flex-direction: column;
	align-items: center;
	position: relative;
}
.af-auth-close {
	position: absolute;
	top: 16px;
	right: 16px;
	background: none;
	border: none;
	cursor: pointer;
	padding: 0;
	z-index: 10;
}
.af-auth-close img {
	width: 40px;
	height: 40px;
}
.af-auth-logo {
	margin-bottom: 24px;
	margin-top: 8px;
}
.af-auth-logo img {
	height: 42px;
	width: auto;
}
.af-auth-title {
	font-size: 24px;
	font-weight: 600;
	color: #000000;
	margin: 0 0 12px 0;
}
.af-auth-descc {
	font-size: 20px;
	margin-top: 10px;
	background: linear-gradient(to right, #E64910, #F51E55, #DE39B3, #C64CDB, #0083EB);
	-webkit-background-clip: text;
	background-clip: text;
	line-height: 1.7;
	text-align: center;
	margin: 0 0 28px 0;
	color: transparent;
}
.af-auth-desc {
	font-size: 14px;
	font-weight: 400;
	color: #6e6e6e;
	line-height: 1.7;
	text-align: center;
	margin: 0 0 28px 0;
}
.af-auth-form-field {
	position: relative;
	width: 100%;
	max-width: 420px;
	margin-bottom: 16px;
}
.af-auth-form-field input {
	width: 100%;
	height: 56px;
	border: 1px solid rgba(0, 0, 0, 0.12);
	border-radius: 1000000px;
	padding: 8px 20px;
	font-size: 16px;
	font-family: 'iranyekan', sans-serif;
	box-sizing: border-box;
	transition: all 0.3s ease;
	text-align: right;
	background: #fff;
}
.af-auth-form-field label {
	position: absolute;
	top: 50%;
	right: 29px;
	transform: translateY(-50%);
	font-size: 16px;
	color: #161618;
	font-family: 'iranyekan', sans-serif;
	pointer-events: none;
	transition: all 0.3s ease;
}
.af-auth-form-field input:focus + label,
.af-auth-form-field input:not(:placeholder-shown) + label {
	opacity: 0;
	transform: translateY(-1.5rem);
}
.af-auth-submit-button {
	background: #E9E9EB;
	border: none;
	padding: 12px 10px;
	font-size: 15px;
	color: #9B9BA1;
	border-radius: 1000000px;
	cursor: pointer;
	font-family: 'iranyekan', sans-serif;
	min-width: 240px;
	width: 100%;
	max-width: 420px;
	height: 56px;
	margin-top: 8px;
	margin-bottom: 20px;
	transition: background-color 0.3s ease;
}
.af-auth-submit-button.active {
	background: #000000 !important;
	color: #FFFFFF !important;
}
.af-auth-submit-button.active:hover {
	background: #4338e0 !important;
}

/* Stage 0 Styles */
#af-auth-stage-0.active .af-auth-stage-box {
	background: transparent;
	box-shadow: none;
	align-items: flex-start;
	padding: 70px;
}
.af-price-currency {
	font-size: 12px !important;
	font-weight: 400 !important;
	color: #65656D !important;
}
.af-sub-list {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 20px;
	width: 100%;
	max-width: 100%;
	padding: 20px 0;
}
.af-sub-item {
	border: 1.5px solid rgba(0, 0, 0, 0);
	border-radius: 20px;
	padding: 20px 16px;
	cursor: pointer;
	transition: all 0.3s ease;
	text-align: right;
	position: relative;
	overflow: hidden;
	background: #fff;
	height: 100%;
	display: flex;
	flex-direction: column;
}
.af-sub-item:hover {
	border-color: rgba(82, 71, 255, 0.4);
}
.af-sub-item.selected {
	border-color: #5247FF;
}
.af-sub-item-header {
	display: flex;
	justify-content: center;
	align-items: center;
	margin-bottom: 32px;
	padding-top: 30px;
}
.af-sub-months {
	font-size: 24px;
	font-weight: 500;
	color: #161618;
}
.af-sub-discount {
	position: absolute;
	top: 12px;
	right: 16px;
	color: #D32F2F;
	font-size: 13px;
	font-weight: 500;
	display: flex;
	align-items: center;
	gap: 4px;
}
.af-sub-discount img {
	width: 18px;
	height: 18px;
}
.af-sub-price-box span {
	font-size: 18px;
	font-weight: 500;
	color: #000000;
	margin: 8px 0 12px;
	padding-right: 5px;
}
.af-program-box {
	background: #F0F0F1;
	color: #000000;
	font-size: 12px;
	font-weight: 500;
	padding: 3px 14px;
	border-radius: 999px;
	text-align: center;
	align-self: center;
	margin-top: auto;
	width: fit-content;
	min-width: 130px;
}
.af-sub-footer {
	font-size: 13px;
	color: #65656D;
	margin-top: 20px;
	text-align: center;
	display: flex;
	justify-content: center;
	align-items: center;
	gap: 4px;
}
.afpb-sticky-footer {
	border-radius: 0px 0px 40px 40px;
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
.afpb-footer-row {
	width: 80%;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.afpb-right-column {
	display: flex;
	justify-content: flex-end;
	align-items: center;
	gap: 12px;
}
.afpb-right-column img {
	width: 38px;
	height: 38px;
	object-fit: contain;
	border-radius: 8px;
}
.afpb-right-column span {
	font-size: 24px;
	font-weight: 500;
	color: #161618;
}
.afpb-left-column {
	display: flex;
	gap: 16px;
	align-items: center;
}
.afpb-price-column {
	display: flex;
	gap: 20px;
	align-items: flex-end;
}
.afpb-total-price {
	font-size: 20px;
	font-weight: 500;
	color: #161618;
}
.afpb-buttons-column {
	display: flex;
	gap: 16px;
}
.afpb-sticky-footer .afpb-button {
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
	border: none;
}
.afpb-primary-button {
	background-color: #5247FF;
	color: #fff !important;
}

/* Stage 1, 2, 3, 4 Specific Styles */
#af-auth-stage-1.active .af-auth-stage-box,
#af-auth-stage-2.active .af-auth-stage-box,
#af-auth-stage-3.active .af-auth-stage-box,
#af-auth-stage-4.active .af-auth-stage-box {
	background: #FFFFFF;
	box-shadow: none;
}
#af-auth-stage-1.active .af-auth-stage-right,
#af-auth-stage-2.active .af-auth-stage-right,
#af-auth-stage-3.active .af-auth-stage-right,
#af-auth-stage-4.active .af-auth-stage-right {
	background: #FFFFFF;
}
.af-auth-identifier-display {
	display: flex;
	align-items: center;
	justify-content: space-between;
	max-width: 420px;
	width: 100%;
	height: 48px;
	border: 1px solid rgba(0, 0, 0, 0.12);
	border-radius: 1000000px;
	padding: 0 16px 0 12px;
	margin-bottom: 28px;
	background: #FFFFFF;
	box-sizing: border-box;
}
.af-auth-identifier-display span {
	font-size: 15px;
	color: #161618;
	font-family: 'iranyekan', sans-serif;
	direction: ltr;
	text-align: left;
}
.af-auth-edit-identifier {
	background: none;
	border: none;
	cursor: pointer;
	padding: 4px;
	display: flex;
	align-items: center;
	justify-content: center;
}
.af-auth-edit-identifier img {
	width: 20px;
	height: 20px;
}
.af-auth-otp-boxes {
	display: flex;
	gap: 12px;
	justify-content: center;
	width: 100%;
	max-width: 420px;
	margin-bottom: 24px;
	direction: ltr;
}
.af-auth-otp-input {
	width: 56px;
	height: 56px;
	border: 1px solid rgba(0, 0, 0, 0.12);
	border-radius: 16px;
	text-align: center;
	font-size: 22px;
	font-weight: 600;
	font-family: 'iranyekan', sans-serif;
	color: #161618;
	background: #FFFFFF;
	outline: none;
	transition: border-color 0.2s ease;
	box-sizing: border-box;
}
.af-auth-otp-input:focus {
	border-color: #5247FF;
}
.af-auth-resend-wrapper {
	margin-bottom: 24px;
	text-align: center;
	min-height: 24px;
}
#af-auth-timer-text {
	font-size: 14px;
	color: #9B9BA1;
	font-family: 'iranyekan', sans-serif;
}
#af-auth-resend-link {
	font-size: 14px;
	color: #5247FF;
	text-decoration: none;
	font-family: 'iranyekan', sans-serif;
	font-weight: 500;
}
.af-auth-birthdate-field {
	position: relative;
}
.af-auth-birthdate-field input {
	padding-left: 48px !important;
	cursor: pointer;
}
.af-auth-birthdate-icon {
	position: absolute;
	left: 16px;
	top: 50%;
	transform: translateY(-50%);
	background: none;
	border: none;
	cursor: pointer;
	padding: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	z-index: 5;
}
.af-auth-birthdate-icon img {
	width: 22px;
	height: 22px;
}
.af-auth-gender-options {
	display: flex;
	gap: 12px;
	width: 100%;
	max-width: 420px;
	margin-bottom: 24px;
}
.af-auth-gender-btn {
	flex: 1;
	height: 56px;
	border: 1px solid rgba(0, 0, 0, 0.12);
	border-radius: 1000000px;
	background: #FFFFFF;
	font-size: 15px;
	font-family: 'iranyekan', sans-serif;
	color: #161618;
	cursor: pointer;
	transition: all 0.25s ease;
}
.af-auth-gender-btn.selected {
	background: #ffffff;
	border-color: #5247FF;
	color: #000000;
	font-weight: 600;
}
.af-auth-date-labels {
	display: flex;
	width: 100%;
	margin-bottom: 12px;
	font-size: 16px;
	color: #000000;
	font-family: 'iranyekan', sans-serif;
}
.af-auth-date-labels span {
	flex: 1;
	text-align: center;
}
.af-auth-date-picker {
	position: relative;
	display: flex;
	width: 100%;
	height: 192px;
	margin-bottom: 36px;
	overflow: hidden;
	user-select: none;
	-webkit-user-select: none;
}
.af-auth-date-highlight {
	position: absolute;
	top: 40%;
	left: 8px;
	right: 8px;
	height: 48px;
	transform: translateY(-50%);
	background: #F2F2F8;
	border-radius: 14px;
	z-index: 1;
	pointer-events: none;
}
.af-auth-date-column {
	flex: 1;
	height: 100%;
	overflow: hidden;
	position: relative;
	z-index: 2;
	cursor: grab;
}
.af-auth-date-column:active {
	cursor: grabbing;
}
.af-auth-date-scroller {
	display: flex;
	flex-direction: column;
	align-items: center;
	will-change: transform;
}
.af-auth-date-item {
	height: 48px;
	width: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 17px;
	font-family: 'iranyekan', sans-serif;
	color: #B0B0B5;
	flex-shrink: 0;
	transition: color 0.15s ease, font-weight 0.15s ease;
}
.af-auth-date-item.selected {
	color: #161618;
	font-weight: 700;
	font-size: 18px;
}
#af-auth-date-continue-btn {
	width: 100%;
	max-width: 320px;
	margin-top: 0;
	margin-bottom: 0;
	background: #000000 !important;
	color: #FFFFFF !important;
}

@media only screen and (max-width: 768px) {
	.af-auth-popup-content { max-width: unset; min-width: unset; width: 100%; }
	.af-sub-list { display: flex; flex-direction: column; gap: 20px; width: 100%; padding: 20px 0; height: 55vh; max-height: 55vh; overflow-y: auto; overflow-x: hidden; scrollbar-width: none; }
	.af-sub-list::-webkit-scrollbar { display: none; }
	.af-sub-item { flex: 0 0 auto; width: 100%; min-height: 180px; box-sizing: border-box; }
	.afpb-sticky-footer { height: auto; align-items: flex-start; padding: 16px 0; position: absolute; border-radius: 0; }
	.afpb-footer-row { flex-direction: column; align-items: flex-start; gap: 16px; width: 90%; }
	.afpb-left-column, .afpb-price-column, .afpb-buttons-column, .afpb-sticky-footer .afpb-button { width: 100%; }
	.af-auth-stage-wrapper { height: 100dvh; min-height: 0; max-height: 100dvh; border-radius: 0; overflow: hidden; }
	#af-auth-stage-0.active .af-auth-stage-box { padding: 1px 16px; }
	.af-auth-stage-right { padding: 10px 14px; align-items: flex-start; }
	.af-auth-title { margin-left: auto; margin-right: auto; font-size: 20px; margin-top: 8px; }
	.af-auth-stage-box[style] { min-width: unset !important; max-width: 100% !important; border-radius: 40px 40px 0 0; }
}
</style>

<div class="af-auth-popup-overlay" id="af-auth-popup">
	<div class="af-auth-popup-content">

		<!-- =====================================================
		     STAGE 0 : Subscription Selection
		===================================================== -->
		<div class="af-auth-stage active" id="af-auth-stage-0">
			<div class="af-auth-stage-wrapper">
				<div class="af-auth-stage-right">
					<div class="af-auth-stage-box">
						<button class="af-auth-close" type="button" onclick="hideAfAuthPopup()">
							<img src="https://6tofit.com/wp-content/uploads/2025/10/State.svg" alt="Close">
						</button>

						<h2 class="af-auth-title">مدت زمان برنامه</h2>
						<p class="af-auth-descc">دریافت برنامه اختصاصی در هر ماه!</p>

						<div class="af-sub-list" id="af-sub-list">
							<?php foreach ( $subscriptions as $index => $sub ) :
								$months   = max( 1, intval( $sub['months'] ?? 1 ) );
								$discount = floatval( $sub['discount'] ?? 0 );

								if ( $product->is_type( 'variable' ) && function_exists( 'af_get_exact_product_price' ) ) {
									$final = af_get_exact_product_price( $product_id, $months );
									$raw   = $base_price * $months;
									if ( $raw > $final && $raw > 0 ) {
										$discount = round( ( ( $raw - $final ) / $raw ) * 100 );
									}
								} else {
									$raw   = $base_price * $months;
									$final = $raw * ( 1 - ( $discount / 100 ) );
								}

								$monthly       = $final / $months;
								$discount_text = $discount > 0 ? $discount . '%' : '';

								if ( $is_usd ) {
									$monthly_formatted = '$' . number_format( $monthly, ( floor( $monthly ) == $monthly ? 0 : 2 ), '.', ',' );
									$currency_label    = 'دلار';
								} else {
									$monthly_formatted = number_format( $monthly, 0, '', '.' );
									$currency_label    = 'تومان';
								}
							?>
								<div class="af-sub-item"
									 data-index="<?php echo esc_attr( $index ); ?>"
									 data-months="<?php echo esc_attr( $months ); ?>"
									 data-discount="<?php echo esc_attr( $discount ); ?>"
									 data-price="<?php echo esc_attr( $final ); ?>"
									 onclick="selectAfSubscription(this)">
									<div class="af-sub-item-header">
										<span class="af-sub-months"><?php echo $months; ?> ماهه</span>
										<?php if ( $discount > 0 ) : ?>
											<div class="af-sub-discount">
												<img src="https://6tofit.com/wp-content/uploads/2026/09/Tag-Iconly-Pro.svg" alt="تخفیف" style="width:18px;height:18px;">
												<?php echo esc_html( $discount_text ); ?> تخفیف
											</div>
										<?php endif; ?>
									</div>

									<div class="af-program-box">
										<?php echo ( $months === 1 ) ? '1 برنامه دریافتی' : 'دریافت ' . $months . ' برنامه جداگانه'; ?>
									</div>

									<div class="af-sub-footer">
										ماهانه
										<div class="af-sub-price-box">
											<span class="woocommerce-Price-amount amount" style="direction: ltr; display: inline-block;">
												<?php echo esc_html( $monthly_formatted ); ?>
											</span>
											<span class="woocommerce-Price-currencySymbol af-price-currency"><?php echo esc_html( $currency_label ); ?></span>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="afpb-sticky-footer" id="af-popup-sticky-footer" data-base-price="<?php echo esc_attr( $base_price ); ?>" data-is-usd="<?php echo $is_usd ? '1' : '0'; ?>">
				<div class="afpb-footer-row">
					<div class="afpb-right-column">
						<?php
						$popup_image_id = $product->get_image_id();
						if ( $popup_image_id ) {
							echo wp_get_attachment_image( $popup_image_id, 'thumbnail', false, array( 'alt' => esc_attr( $product->get_name() ) ) );
						} else {
							echo wc_placeholder_img( 'thumbnail' );
						}
						?>
						<span><?php echo esc_html( $product->get_name() ); ?></span>
					</div>

					<div class="afpb-left-column">
						<div class="afpb-price-column">
							<div class="price-details">
								<span class="starting-price">قیمت نهایی</span>
							</div>
							<div>
								<span class="afpb-total-price" id="af-popup-total-price">
									<span class="woocommerce-Price-amount amount af-price-wrapper">
										<span class="af-price-number" style="direction: ltr; display: inline-block;">...</span>
										<span class="woocommerce-Price-currencySymbol af-price-currency"><?php echo $is_usd ? 'دلار' : 'تومان'; ?></span>
									</span>
								</span>
							</div>
						</div>

						<div class="afpb-buttons-column">
							<button type="button"
								class="afpb-button afpb-primary-button"
								id="af-popup-buy-program-btn"
								onclick="handleAfSubscriptionContinue()">
								خرید برنامه
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- =====================================================
		     STAGE 1 : Phone / Email
		===================================================== -->
		<div class="af-auth-stage" id="af-auth-stage-1">
			<div class="af-auth-stage-wrapper">
				<div class="af-auth-stage-right">
					<div class="af-auth-stage-box">
						<button class="af-auth-close" type="button" onclick="hideAfAuthPopup()">
							<img src="https://6tofit.com/wp-content/uploads/2025/10/State.svg" alt="Close">
						</button>

						<div class="af-auth-logo">
							<img src="https://6tofit.com/wp-content/uploads/2025/10/6toFit_logo_Black_2.svg" alt="6tofit">
						</div>

						<h2 class="af-auth-title">خوش آمدید!</h2>
						<p class="af-auth-desc">برای ورود یا ثبت نام شماره موبایل یا ایمیلت رو وارد کن تا کد تایید برات ارسال بشه</p>

						<div class="af-auth-form-field">
							<input type="text" id="af-auth-identifier" required placeholder=" ">
							<label for="af-auth-identifier">شماره موبایل یا ایمیل</label>
						</div>

						<button type="button" class="af-auth-submit-button active" id="af-auth-send-code-btn" onclick="handleAfSendCode()">
							ارسال کد تایید
						</button>

						<p style="font-size:12px;color:#9B9BA1;margin:0 0 20px;line-height:1.6;">
							ورود شما به معنای پذیرش
							<a href="/terms" target="_blank" style="color:#5247FF;">شرایط 6tofit</a>
							و
							<a href="/privacy" target="_blank" style="color:#5247FF;">قوانین حریم خصوصی</a>
							است
						</p>
					</div>
				</div>
			</div>
		</div>

		<!-- =====================================================
		     STAGE 2 : OTP
		===================================================== -->
		<div class="af-auth-stage" id="af-auth-stage-2">
			<div class="af-auth-stage-wrapper">
				<div class="af-auth-stage-right">
					<div class="af-auth-stage-box">
						<button class="af-auth-close" type="button" onclick="hideAfAuthPopup()">
							<img src="https://6tofit.com/wp-content/uploads/2025/10/State.svg" alt="Close">
						</button>

						<div class="af-auth-logo">
							<img src="https://6tofit.com/wp-content/uploads/2025/10/6toFit_logo_Black_2.svg" alt="6tofit">
						</div>

						<h2 class="af-auth-title">کد تایید</h2>
						<p class="af-auth-desc" id="af-otp-desc-text">کد تایید برای شما ارسال شده است، لطفا آن را وارد نمایید</p>

						<div class="af-auth-identifier-display">
							<button type="button" class="af-auth-edit-identifier" onclick="showAfAuthStage('af-auth-stage-1')">
								<img src="https://6tofit.com/wp-content/uploads/2026/08/Edit.svg" alt="Edit">
							</button>
							<span id="af-auth-identifier-value">0912*******89</span>
						</div>

						<div class="af-auth-otp-boxes">
							<input type="text" class="af-auth-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code">
							<input type="text" class="af-auth-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*">
							<input type="text" class="af-auth-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*">
							<input type="text" class="af-auth-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*">
						</div>

						<div class="af-auth-resend-wrapper">
							<span id="af-auth-timer-text">۰۲:۰۰ تا ارسال مجدد کد</span>
							<a href="#" id="af-auth-resend-link" style="display:none;" onclick="handleAfResendCode(event)">ارسال مجدد کد</a>
						</div>

						<button type="button" class="af-auth-submit-button" id="af-auth-verify-code-btn" onclick="handleAfVerifyCode()">
							تایید
						</button>
					</div>
				</div>
			</div>
		</div>

		<!-- =====================================================
		     STAGE 3 : User Info
		===================================================== -->
		<div class="af-auth-stage" id="af-auth-stage-3">
			<div class="af-auth-stage-wrapper">
				<div class="af-auth-stage-right">
					<div class="af-auth-stage-box">
						<button class="af-auth-close" type="button" onclick="hideAfAuthPopup()">
							<img src="https://6tofit.com/wp-content/uploads/2025/10/State.svg" alt="Close">
						</button>

						<div class="af-auth-logo">
							<img src="https://6tofit.com/wp-content/uploads/2025/10/6toFit_logo_Black_2.svg" alt="6tofit">
						</div>

						<h2 class="af-auth-title">اطلاعات کاربری</h2>
						<p class="af-auth-desc">لطفا اطلاعات خود را وارد کنید</p>

						<div class="af-auth-form-field">
							<input type="text" id="af-auth-fullname" required placeholder=" ">
							<label for="af-auth-fullname">نام و نام خانوادگی</label>
						</div>

						<div class="af-auth-form-field af-auth-birthdate-field" onclick="openAfBirthdatePicker()">
							<input type="text" id="af-auth-birthdate" required placeholder=" " readonly value="1375/06/15">
							<label for="af-auth-birthdate">تاریخ تولد</label>
							<button type="button" class="af-auth-birthdate-icon" onclick="openAfBirthdatePicker()">
								<img src="https://6tofit.com/wp-content/uploads/2026/08/Calendar-Iconly-Pro.svg" alt="Calendar">
							</button>
						</div>

						<div class="af-auth-gender-options">
							<button type="button" class="af-auth-gender-btn" data-gender="female" onclick="selectAfGender(this)">زن</button>
							<button type="button" class="af-auth-gender-btn" data-gender="male" onclick="selectAfGender(this)">مرد</button>
							<button type="button" class="af-auth-gender-btn" data-gender="other" onclick="selectAfGender(this)">سایر</button>
						</div>

						<button type="button" class="af-auth-submit-button" id="af-auth-submit-info-btn" onclick="handleAfSubmitInfo()">
							ثبت اطلاعات و ادامه خرید
						</button>
					</div>
				</div>
			</div>
		</div>

		<!-- =====================================================
		     STAGE 4 : Birthdate Picker
		===================================================== -->
		<div class="af-auth-stage" id="af-auth-stage-4">
			<div class="af-auth-stage-wrapper" style="justify-content:center;">
				<div class="af-auth-stage-box" style="max-width:620px;min-width:620px;">
					<button class="af-auth-close" type="button" onclick="hideAfAuthPopup()">
						<img src="https://6tofit.com/wp-content/uploads/2025/10/State.svg" alt="Close">
					</button>

					<h2 class="af-auth-title">تاریخ تولد</h2>

					<div class="af-auth-date-labels">
						<span>روز</span>
						<span>ماه</span>
						<span>سال</span>
					</div>

					<div class="af-auth-date-picker">
						<div class="af-auth-date-highlight"></div>
						<div class="af-auth-date-column" data-type="day">
							<div class="af-auth-date-scroller" id="af-auth-day-scroller"></div>
						</div>
						<div class="af-auth-date-column" data-type="month">
							<div class="af-auth-date-scroller" id="af-auth-month-scroller"></div>
						</div>
						<div class="af-auth-date-column" data-type="year">
							<div class="af-auth-date-scroller" id="af-auth-year-scroller"></div>
						</div>
					</div>

					<button type="button" class="af-auth-submit-button active" id="af-auth-date-continue-btn" onclick="handleAfDateContinue()">
						تایید تاریخ تولد
					</button>
				</div>
			</div>
		</div>

	</div>
</div>

<script>
function afParseAjaxJson(response) {
	return response.text().then(function(text) {
		try {
			return JSON.parse(text);
		} catch (e) {
			// استخراج هوشمند JSON در صورتی که هشدار PHP قبل یا بعد از آن چاپ شده باشد
			const start = text.indexOf('{');
			const end = text.lastIndexOf('}');
			if (start !== -1 && end !== -1 && end > start) {
				return JSON.parse(text.substring(start, end + 1));
			}
			throw new Error('Invalid JSON: ' + text.substring(0, 100));
		}
	});
}
window.afAuthState = {
	productId: <?php echo (int) $product_id; ?>,
	isLoggedIn: <?php echo $is_logged_in ? 'true' : 'false'; ?>,
	selectedSubscription: null,
	selectedAddons: [],
	selectedGender: null
};

function afToEnglishDigits(str) {
	if (!str) return '';
	const persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
	const english = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
	let res = String(str);
	for (let i = 0; i < persian.length; i++) {
		res = res.split(persian[i]).join(english[i]);
	}
	return res;
}

function syncSelectedAddonsFromDOM() {
	const addons = [];
	document.querySelectorAll('.addon-checkbox:checked').forEach(function(cb) {
		addons.push({
			index: cb.value,
			price: parseFloat(cb.dataset.price || 0),
			title: cb.closest('.service-card')?.querySelector('.checkbox-text')?.textContent?.trim() || ''
		});
	});
	window.afAuthState.selectedAddons = addons;
}

function appendCartDataToForm(formData) {
	syncSelectedAddonsFromDOM();
	const sub = window.afAuthState.selectedSubscription;
	formData.append('product_id', window.afAuthState.productId);
	formData.append('months', sub ? sub.months : 1);
	formData.append('discount', sub ? sub.discount : 0);
	formData.append('price', sub ? sub.price : 0);

	(window.afAuthState.selectedAddons || []).forEach(item => {
		const idx = (typeof item === 'object' && item !== null) ? item.index : item;
		if (idx !== undefined && idx !== null && idx !== '') {
			formData.append('selected_addons[]', idx);
		}
	});
}

function calculateFinalPrice(subscriptionPrice = null, months = 1) {
	syncSelectedAddonsFromDOM();
	const footerEl = document.getElementById('af-popup-sticky-footer');
	const isUsd = footerEl?.dataset.isUsd === '1';

	const addonsTotal = (window.afAuthState.selectedAddons || []).reduce((sum, addon) => {
		let ap = parseFloat(addon.price) || 0;
		if (isUsd && ap > 1000) ap = Math.round((ap / 150000) * 100) / 100;
		return sum + ap;
	}, 0);

	if (subscriptionPrice === null) {
		let basePrice = parseFloat(footerEl?.dataset.basePrice || 0);
		if (isUsd && basePrice > 10000) basePrice = Math.round((basePrice / 150000) * 100) / 100;
		return basePrice + addonsTotal;
	}
	return subscriptionPrice + (addonsTotal * months);
}

function updatePopupTotalPrice(subscriptionPrice = null, months = 1) {
	const totalPriceEl = document.getElementById('af-popup-total-price');
	const footerEl = document.getElementById('af-popup-sticky-footer');
	if (!totalPriceEl || !footerEl) return;

	const isUsd = footerEl.dataset.isUsd === '1';
	const finalPrice = calculateFinalPrice(subscriptionPrice, months);

	let formattedPrice = '';
	if (isUsd) {
		const decimals = Math.floor(finalPrice) === finalPrice ? 0 : 2;
		formattedPrice = '$' + finalPrice.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
	} else {
		formattedPrice = Math.round(finalPrice).toLocaleString('en-US').replace(/,/g, '.');
	}

	totalPriceEl.innerHTML = `
		<span class="woocommerce-Price-amount amount af-price-wrapper">
			<span class="af-price-number" style="direction: ltr; display: inline-block;">${formattedPrice}</span>
			<span class="woocommerce-Price-currencySymbol af-price-currency">${isUsd ? 'دلار' : 'تومان'}</span>
		</span>
	`;
}

window.selectAfSubscription = function(el) {
	document.querySelectorAll('.af-sub-item').forEach(i => i.classList.remove('selected'));
	el.classList.add('selected');
	const price = parseFloat(el.dataset.price);
	const months = parseInt(el.dataset.months);
	window.afAuthState.selectedSubscription = {
		index: el.dataset.index,
		months: months,
		discount: parseFloat(el.dataset.discount),
		price: price
	};
	updatePopupTotalPrice(price, months);
};

window.handleAfSubscriptionContinue = function() {
	if (!window.afAuthState.selectedSubscription) {
		const firstSub = document.querySelector('.af-sub-item.selected') || document.querySelector('.af-sub-item');
		if (firstSub) {
			window.selectAfSubscription(firstSub);
		} else {
			alert('لطفا یک اشتراک انتخاب کنید');
			return;
		}
	}

	if (window.afAuthState.isLoggedIn) {
		addAfSubscriptionToCartAndCheckout();
	} else {
		showAfAuthStage('af-auth-stage-1');
		setTimeout(() => document.getElementById('af-auth-identifier')?.focus(), 100);
	}
};

function addAfSubscriptionToCartAndCheckout() {
	const btn = document.getElementById('af-popup-buy-program-btn');
	if (btn) {
		btn.disabled = true;
		btn.textContent = 'در حال انتقال به پرداخت...';
	}

	const formData = new FormData();
	formData.append('action', 'af_add_subscription_to_cart');
	appendCartDataToForm(formData);

	fetch('<?php echo esc_url( admin_url( "admin-ajax.php" ) ); ?>', {
		method: 'POST',
		credentials: 'same-origin',
		body: formData
	})
	.then(afParseAjaxJson)
	.then(data => {
		if (data.success) {
			window.location.href = data.data.checkout_url || '<?php echo esc_url( wc_get_checkout_url() ); ?>';
		} else {
			if (btn) {
				btn.disabled = false;
				btn.textContent = 'خرید برنامه';
			}
			alert(data.data?.message || 'خطا در افزودن به سبد خرید');
		}
	})
	.catch(() => {
		if (btn) {
			btn.disabled = false;
			btn.textContent = 'خرید برنامه';
		}
		alert('خطا در ارتباط با سرور');
	});
}

// ==================== Stage 1 & 2 (OTP) ====================
let afAuthTimerInterval = null;
let afAuthTimerSeconds = 120;

function startAfAuthTimer() {
	clearInterval(afAuthTimerInterval);
	afAuthTimerSeconds = 120;
	const timerText = document.getElementById('af-auth-timer-text');
	const resendLink = document.getElementById('af-auth-resend-link');
	if (timerText) timerText.style.display = 'inline';
	if (resendLink) resendLink.style.display = 'none';
	updateAfTimerDisplay();

	afAuthTimerInterval = setInterval(() => {
		afAuthTimerSeconds--;
		updateAfTimerDisplay();
		if (afAuthTimerSeconds <= 0) {
			clearInterval(afAuthTimerInterval);
			if (timerText) timerText.style.display = 'none';
			if (resendLink) resendLink.style.display = 'inline';
		}
	}, 1000);
}

function updateAfTimerDisplay() {
	const m = Math.floor(afAuthTimerSeconds / 60).toString().padStart(2, '0');
	const s = (afAuthTimerSeconds % 60).toString().padStart(2, '0');
	const el = document.getElementById('af-auth-timer-text');
	if (el) el.textContent = m + ':' + s + ' تا ارسال مجدد کد';
}

window.handleAfSendCode = function() {
	const input = document.getElementById('af-auth-identifier');
	const rawValue = input ? input.value.trim() : '';
	let value = afToEnglishDigits(rawValue).replace(/\s+/g, '');
	const btn = document.getElementById('af-auth-send-code-btn');

	if (!value) {
		alert('لطفا شماره موبایل یا ایمیل را وارد کنید');
		return;
	}

	// نرمال‌سازی شماره موبایل در فرانت‌اند (مثلاً 912... به 0912...)
	if (/^9[0-9]{9}$/.test(value)) value = '0' + value;
	if (/^989[0-9]{9}$/.test(value)) value = '0' + value.slice(2);
	if (/^\+989[0-9]{9}$/.test(value)) value = '0' + value.slice(3);

	const isPhone = /^09[0-9]{9}$/.test(value);
	const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);

	if (!isPhone && !isEmail) {
		alert('لطفا یک شماره موبایل معتبر (مثال: 09123456789) یا ایمیل وارد کنید');
		return;
	}

	btn.disabled = true;
	btn.textContent = 'در حال ارسال...';

	const formData = new FormData();
	formData.append('action', 'send_auth_otp');
	formData.append('identifier', value);
	formData.append('phone', value);

	fetch('<?php echo esc_url( admin_url( "admin-ajax.php" ) ); ?>', {
		method: 'POST',
		credentials: 'same-origin',
		body: formData
	})
	.then(afParseAjaxJson)
	.then(data => {
		btn.disabled = false;
		btn.textContent = 'ارسال کد تایید';
		if (data.success) {
			document.getElementById('af-auth-identifier-value').textContent = value;
			const descEl = document.getElementById('af-otp-desc-text');
			if (data.data?.debug_otp && descEl) {
				descEl.innerHTML = 'کد تایید شما: <strong style="color:#5247FF;font-size:18px;">' + data.data.debug_otp + '</strong>';
			} else if (descEl) {
				descEl.textContent = 'کد تایید برای شما ارسال شده است، لطفا آن را وارد نمایید';
			}
			showAfAuthStage('af-auth-stage-2');
			startAfAuthTimer();
			document.querySelectorAll('.af-auth-otp-input').forEach(inp => inp.value = '');
			setTimeout(() => document.querySelector('.af-auth-otp-input')?.focus(), 100);
		} else {
			alert(data.data?.message || 'خطا در ارسال کد');
		}
	})
	.catch(() => {
		btn.disabled = false;
		btn.textContent = 'ارسال کد تایید';
		alert('خطا در ارتباط با سرور');
	});
};

window.handleAfResendCode = function(e) {
	if (e) e.preventDefault();
	window.handleAfSendCode();
};

window.handleAfVerifyCode = function() {
	const rawCode = Array.from(document.querySelectorAll('.af-auth-otp-input')).map(i => i.value).join('');
	const code = afToEnglishDigits(rawCode);
	const identifier = afToEnglishDigits(document.getElementById('af-auth-identifier-value')?.textContent || '');

	if (code.length !== 4) {
		alert('لطفا کد ۴ رقمی را کامل وارد کنید');
		return;
	}

	const btn = document.getElementById('af-auth-verify-code-btn');
	btn.disabled = true;
	btn.textContent = 'در حال بررسی...';

	const formData = new FormData();
	formData.append('action', 'verify_auth_otp');
	formData.append('identifier', identifier);
	formData.append('phone', identifier);
	formData.append('code', code);
	// ارسال همزمان اطلاعات سبد خرید تا اگر کاربر از قبل ثبت‌نام کرده بود، در همین درخواست به سبد اضافه و مستقیم به Checkout برود
	appendCartDataToForm(formData);

	fetch('<?php echo esc_url( admin_url( "admin-ajax.php" ) ); ?>', {
		method: 'POST',
		credentials: 'same-origin',
		body: formData
	})
	.then(afParseAjaxJson)
	.then(data => {
		btn.disabled = false;
		btn.textContent = 'تایید';

		if (data.success) {
			if (data.data.action === 'login') {
				window.afAuthState.isLoggedIn = true;
				if (data.data.checkout_url) {
					window.location.href = data.data.checkout_url;
				} else {
					addAfSubscriptionToCartAndCheckout();
				}
			} else {
				showAfAuthStage('af-auth-stage-3');
				setTimeout(() => document.getElementById('af-auth-fullname')?.focus(), 100);
			}
		} else {
			alert(data.data?.message || 'کد وارد شده اشتباه است');
		}
	})
	.catch(() => {
		btn.disabled = false;
		btn.textContent = 'تایید';
		alert('خطا در ارتباط با سرور');
	});
};

// ==================== Stage 3 & 4 (User Info & Birthdate Picker) ====================
window.selectAfGender = function(btn) {
	document.querySelectorAll('.af-auth-gender-btn').forEach(b => b.classList.remove('selected'));
	btn.classList.add('selected');
	window.afAuthState.selectedGender = btn.getAttribute('data-gender');
	checkAfInfoFormComplete();
};

function checkAfInfoFormComplete() {
	const fullname = document.getElementById('af-auth-fullname')?.value.trim();
	const birthdate = document.getElementById('af-auth-birthdate')?.value.trim();
	const btn = document.getElementById('af-auth-submit-info-btn');
	if (fullname && birthdate && window.afAuthState.selectedGender) {
		btn?.classList.add('active');
	} else {
		btn?.classList.remove('active');
	}
}

window.handleAfSubmitInfo = function() {
	const fullname = document.getElementById('af-auth-fullname')?.value.trim() || '';
	const birthdate = document.getElementById('af-auth-birthdate')?.value.trim() || '1375/06/15';
	const identifier = afToEnglishDigits(document.getElementById('af-auth-identifier-value')?.textContent || '');

	if (!fullname || !window.afAuthState.selectedGender) {
		alert('لطفا نام و نام خانوادگی و جنسیت را انتخاب کنید');
		return;
	}

	const btn = document.getElementById('af-auth-submit-info-btn');
	btn.disabled = true;
	btn.textContent = 'در حال ثبت اطلاعات و انتقال به پرداخت...';

	const formData = new FormData();
	formData.append('action', 'register_auth_user');
	formData.append('identifier', identifier);
	formData.append('fullname', fullname);
	formData.append('birthdate', birthdate);
	formData.append('gender', window.afAuthState.selectedGender);
	// ارسال همزمان اطلاعات سبد خرید تا بلافاصله پس از ثبت‌نام، سبد خرید ساخته شده و به Checkout برود
	appendCartDataToForm(formData);

	fetch('<?php echo esc_url( admin_url( "admin-ajax.php" ) ); ?>', {
		method: 'POST',
		credentials: 'same-origin',
		body: formData
	})
	.then(afParseAjaxJson)
	.then(data => {
		if (data.success) {
			window.afAuthState.isLoggedIn = true;
			if (data.data?.checkout_url) {
				window.location.href = data.data.checkout_url;
			} else {
				addAfSubscriptionToCartAndCheckout();
			}
		} else {
			btn.disabled = false;
			btn.textContent = 'ثبت اطلاعات و ادامه خرید';
			alert(data.data?.message || 'خطا در ثبت‌نام');
		}
	})
	.catch(() => {
		btn.disabled = false;
		btn.textContent = 'ثبت اطلاعات و ادامه خرید';
		alert('خطا در ارتباط با سرور');
	});
};

const afPersianMonths = [
	{ num: 1, name: 'فروردین' }, { num: 2, name: 'اردیبهشت' }, { num: 3, name: 'خرداد' },
	{ num: 4, name: 'تیر' }, { num: 5, name: 'مرداد' }, { num: 6, name: 'شهریور' },
	{ num: 7, name: 'مهر' }, { num: 8, name: 'آبان' }, { num: 9, name: 'آذر' },
	{ num: 10, name: 'دی' }, { num: 11, name: 'بهمن' }, { num: 12, name: 'اسفند' }
];
let afSelectedDay = 15;
let afSelectedMonth = 6;
let afSelectedYear = 1375;
const AF_ITEM_HEIGHT = 48;

function afUpdateSelectedClass(scroller, index) {
	const items = scroller.querySelectorAll('.af-auth-date-item');
	items.forEach((el, i) => {
		el.classList.toggle('selected', i === index);
	});
}

function afSetupDrag(scroller, items, type, paddingCount) {
	let startY = 0;
	let startOffset = 0;
	let isDragging = false;

	const getOffset = () => {
		const m = scroller.style.transform.match(/translateY\((-?\d+(?:\.\d+)?)px\)/);
		return m ? parseFloat(m[1]) : 0;
	};
	const setOffset = (value) => {
		scroller.style.transform = `translateY(${value}px)`;
	};
	const clamp = (v, min, max) => Math.max(min, Math.min(max, v));

	const onStart = (clientY) => {
		isDragging = true;
		startY = clientY;
		startOffset = getOffset();
		scroller.style.transition = 'none';
	};
	const onMove = (clientY) => {
		if (!isDragging) return;
		const delta = clientY - startY;
		let newOffset = startOffset + delta;
		const maxOffset = 0;
		const minOffset = -((items.length + paddingCount * 2 - 3) * AF_ITEM_HEIGHT);
		newOffset = clamp(newOffset, minOffset, maxOffset);
		setOffset(newOffset);

		const rawIndex = Math.round((-newOffset) / AF_ITEM_HEIGHT);
		const realIndex = clamp(rawIndex - paddingCount + 1, 0, items.length - 1);
		afUpdateSelectedClass(scroller, realIndex + paddingCount);

		if (type === 'day') afSelectedDay = items[realIndex].value;
		if (type === 'month') afSelectedMonth = items[realIndex].value;
		if (type === 'year') afSelectedYear = items[realIndex].value;
	};
	const onEnd = () => {
		if (!isDragging) return;
		isDragging = false;
		scroller.style.transition = 'transform 0.2s ease-out';
		const current = getOffset();
		const rawIndex = Math.round((-current) / AF_ITEM_HEIGHT);
		const realIndex = clamp(rawIndex - paddingCount + 1, 0, items.length - 1);
		const finalOffset = -((realIndex + paddingCount - 1) * AF_ITEM_HEIGHT);
		setOffset(finalOffset);
		afUpdateSelectedClass(scroller, realIndex + paddingCount);

		if (type === 'day') afSelectedDay = items[realIndex].value;
		if (type === 'month') afSelectedMonth = items[realIndex].value;
		if (type === 'year') afSelectedYear = items[realIndex].value;
	};

	scroller.addEventListener('mousedown', (e) => { e.preventDefault(); onStart(e.clientY); });
	window.addEventListener('mousemove', (e) => onMove(e.clientY));
	window.addEventListener('mouseup', onEnd);
	scroller.addEventListener('touchstart', (e) => onStart(e.touches[0].clientY), { passive: true });
	scroller.addEventListener('touchmove', (e) => onMove(e.touches[0].clientY), { passive: true });
	window.addEventListener('touchend', onEnd);
}

function afCreateDateScroller(scrollerId, items, selectedValue, type) {
	const scroller = document.getElementById(scrollerId);
	if (!scroller) return;
	scroller.innerHTML = '';
	const paddingCount = 2;

	for (let i = 0; i < paddingCount; i++) {
		const empty = document.createElement('div');
		empty.className = 'af-auth-date-item';
		empty.innerHTML = '&nbsp;';
		scroller.appendChild(empty);
	}

	items.forEach((item) => {
		const el = document.createElement('div');
		el.className = 'af-auth-date-item';
		el.dataset.value = item.value;
		el.textContent = item.label;
		el.addEventListener('click', function() {
			const idx = items.findIndex(x => x.value === item.value);
			if (idx >= 0) {
				const offset = (idx + paddingCount - 1) * AF_ITEM_HEIGHT;
				scroller.style.transition = 'transform 0.2s ease-out';
				scroller.style.transform = `translateY(-${offset}px)`;
				afUpdateSelectedClass(scroller, idx + paddingCount);
				if (type === 'day') afSelectedDay = item.value;
				if (type === 'month') afSelectedMonth = item.value;
				if (type === 'year') afSelectedYear = item.value;
			}
		});
		scroller.appendChild(el);
	});

	for (let i = 0; i < paddingCount; i++) {
		const empty = document.createElement('div');
		empty.className = 'af-auth-date-item';
		empty.innerHTML = '&nbsp;';
		scroller.appendChild(empty);
	}

	const selectedIndex = Math.max(0, items.findIndex(i => i.value === selectedValue));
	const offset = (selectedIndex + paddingCount - 1) * AF_ITEM_HEIGHT;
	scroller.style.transform = `translateY(-${offset}px)`;
	afUpdateSelectedClass(scroller, selectedIndex + paddingCount);
	afSetupDrag(scroller, items, type, paddingCount);
}

function afInitDatePicker() {
	const days = Array.from({ length: 31 }, (_, i) => ({ value: i + 1, label: String(i + 1) }));
	const months = afPersianMonths.map(m => ({ value: m.num, label: m.name }));
	const years = [];
	for (let y = 1404; y >= 1330; y--) {
		years.push({ value: y, label: String(y) });
	}
	afCreateDateScroller('af-auth-day-scroller', days, afSelectedDay, 'day');
	afCreateDateScroller('af-auth-month-scroller', months, afSelectedMonth, 'month');
	afCreateDateScroller('af-auth-year-scroller', years, afSelectedYear, 'year');
}

window.openAfBirthdatePicker = function() {
	showAfAuthStage('af-auth-stage-4');
	setTimeout(afInitDatePicker, 50);
};

window.handleAfDateContinue = function() {
	const formatted = afSelectedYear + '/' + String(afSelectedMonth).padStart(2, '0') + '/' + String(afSelectedDay).padStart(2, '0');
	const birthdateInput = document.getElementById('af-auth-birthdate');
	if (birthdateInput) {
		birthdateInput.value = formatted;
		birthdateInput.dispatchEvent(new Event('input'));
		birthdateInput.dispatchEvent(new Event('change'));
	}
	showAfAuthStage('af-auth-stage-3');
	checkAfInfoFormComplete();
};

// ==================== Global Popup Controls ====================
document.addEventListener('DOMContentLoaded', function() {
	const popup = document.getElementById('af-auth-popup');
	if (!popup) return;

	window.showAfAuthPopup = function() {
		popup.classList.add('active');
		showAfAuthStage('af-auth-stage-0');
		const selectedSubEl = document.querySelector('.af-sub-item.selected') || document.querySelector('.af-sub-item');
		if (selectedSubEl) {
			window.selectAfSubscription(selectedSubEl);
		} else {
			updatePopupTotalPrice();
		}
	};

	window.hideAfAuthPopup = function() {
		popup.classList.remove('active');
		showAfAuthStage('af-auth-stage-0');
	};

	window.showAfAuthStage = function(stageId) {
		document.querySelectorAll('.af-auth-stage').forEach(stage => stage.classList.remove('active'));
		document.getElementById(stageId)?.classList.add('active');
	};

	popup.addEventListener('click', function(e) {
		if (e.target === this) hideAfAuthPopup();
	});

	document.getElementById('af-auth-fullname')?.addEventListener('input', checkAfInfoFormComplete);
	document.getElementById('af-auth-birthdate')?.addEventListener('input', checkAfInfoFormComplete);

	const otpInputs = document.querySelectorAll('.af-auth-otp-input');
	otpInputs.forEach((input, index) => {
		input.addEventListener('input', function() {
			this.value = afToEnglishDigits(this.value).replace(/[^0-9]/g, '');
			if (this.value.length === 1 && index < otpInputs.length - 1) {
				otpInputs[index + 1].focus();
			}
			const allFilled = Array.from(otpInputs).every(i => i.value.length === 1);
			document.getElementById('af-auth-verify-code-btn')?.classList.toggle('active', allFilled);
		});
		input.addEventListener('keydown', function(e) {
			if (e.key === 'Backspace' && this.value === '' && index > 0) {
				otpInputs[index - 1].focus();
			}
		});
		input.addEventListener('paste', function(e) {
			e.preventDefault();
			const pasteData = afToEnglishDigits((e.clipboardData || window.clipboardData).getData('text')).replace(/[^0-9]/g, '').slice(0, 4);
			pasteData.split('').forEach((char, i) => {
				if (otpInputs[i]) otpInputs[i].value = char;
			});
			if (pasteData.length > 0) {
				otpInputs[Math.min(pasteData.length, 3)].focus();
			}
			const allFilled = Array.from(otpInputs).every(i => i.value.length === 1);
			document.getElementById('af-auth-verify-code-btn')?.classList.toggle('active', allFilled);
		});
	});
});
</script>
<?php
		echo ob_get_clean();
	}
}