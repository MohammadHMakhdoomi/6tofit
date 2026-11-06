<?php
/**
 * ==========================================================
 * پاپ‌آپ "تست‌های من" - پروفایل کاربر
 * ==========================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'AF_MYTESTS_NONCE_ACTION' ) ) {
	define( 'AF_MYTESTS_NONCE_ACTION', 'af_mytests_nonce' );
}

/* ==========================================================
 * تبدیل تاریخ میلادی به شمسی 
 * ========================================================== */

if ( ! function_exists( 'af_mytests_div' ) ) {
	function af_mytests_div( $a, $b ) {
		return (int) ( $a / $b );
	}
}

if ( ! function_exists( 'af_mytests_gregorian_to_jalali' ) ) {
	function af_mytests_gregorian_to_jalali( $gy, $gm, $gd ) {
		$g_d_m = array( 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334 );
		$gy2   = ( $gm > 2 ) ? ( $gy + 1 ) : $gy;
		$days  = 355666 + ( 365 * $gy ) + af_mytests_div( ( $gy2 + 3 ), 4 ) - af_mytests_div( ( $gy2 + 99 ), 100 )
			+ af_mytests_div( ( $gy2 + 399 ), 400 ) + $gd + $g_d_m[ $gm - 1 ];

		$jy = -1595 + ( 33 * af_mytests_div( $days, 12053 ) );
		$days %= 12053;
		$jy += 4 * af_mytests_div( $days, 1461 );
		$days %= 1461;

		if ( $days > 365 ) {
			$jy  += af_mytests_div( ( $days - 1 ), 365 );
			$days = ( $days - 1 ) % 365;
		}

		if ( $days < 186 ) {
			$jm = 1 + af_mytests_div( $days, 31 );
			$jd = 1 + ( $days % 31 );
		} else {
			$jm = 7 + af_mytests_div( ( $days - 186 ), 30 );
			$jd = 1 + ( ( $days - 186 ) % 30 );
		}

		return array( $jy, $jm, $jd );
	}
}

if ( ! function_exists( 'af_mytests_to_persian_digits' ) ) {
	function af_mytests_to_persian_digits( $string ) {
		$en = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
		$fa = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
		return str_replace( $en, $fa, (string) $string );
	}
}

if ( ! function_exists( 'af_mytests_format_shamsi_date' ) ) {
	/**
	 * ورودی: تاریخ میلادی به فرم mysql datetime مثل 2024-07-23 10:00:00
	 * خروجی: رشته‌ی شمسی مثل «۲ مرداد ۱۴۰۳»
	 */
	function af_mytests_format_shamsi_date( $mysql_datetime ) {
		if ( empty( $mysql_datetime ) ) {
			return '';
		}
		$ts = strtotime( $mysql_datetime );
		if ( ! $ts ) {
			return '';
		}

		$gy = (int) date( 'Y', $ts );
		$gm = (int) date( 'n', $ts );
		$gd = (int) date( 'j', $ts );

		list( $jy, $jm, $jd ) = af_mytests_gregorian_to_jalali( $gy, $gm, $gd );

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

		return af_mytests_to_persian_digits( $jd ) . ' ' . $month_name . ' ' . af_mytests_to_persian_digits( $jy );
	}
}


/* ==========================================================
 * گرفتن لیست تست‌های تکمیل‌شده‌ی کاربر جاری
 * ========================================================== */

if ( ! function_exists( 'af_mytests_get_completed_attempts' ) ) {
	function af_mytests_get_completed_attempts() {
		if ( ! function_exists( 'af_questionnaire_get_current_identity' ) ) {
			return array();
		}

		$identity = af_questionnaire_get_current_identity();
		global $wpdb;

		if ( 'user' === $identity['type'] ) {
			if ( ! function_exists( 'af_questionnaire_table_attempts' ) ) {
				return array();
			}
			$table = af_questionnaire_table_attempts();
			$rows  = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT id, completed_at FROM {$table} WHERE user_id = %d AND status = %s ORDER BY completed_at DESC, id DESC",
					$identity['user_id'],
					'completed'
				)
			);
		} else {
			if ( ! function_exists( 'af_questionnaire_table_temp_attempts' ) ) {
				return array();
			}
			$table = af_questionnaire_table_temp_attempts();
			$rows  = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT id, completed_at FROM {$table} WHERE guest_token = %s AND status = %s ORDER BY completed_at DESC, id DESC",
					$identity['token'],
					'completed'
				)
			);
		}

		return $rows ? $rows : array();
	}
}


/* ==========================================================
 * AJAX مستقل: گرفتن پاسخ‌های یک Attempt خاص (برای صفحه‌ی نتیجه)
 * ========================================================== */

if ( ! function_exists( 'af_mytests_ajax_get_answers' ) ) {
	function af_mytests_ajax_get_answers() {
		check_ajax_referer( AF_MYTESTS_NONCE_ACTION, 'nonce' );

		if ( ! function_exists( 'af_questionnaire_get_current_identity' ) || ! function_exists( 'af_questionnaire_get_answers' ) ) {
			wp_send_json_error( array( 'message' => 'سیستم پرسشنامه در دسترس نیست.' ) );
		}

		$questionnaire_id = isset( $_POST['questionnaire_id'] ) ? (int) $_POST['questionnaire_id'] : 0;
		if ( ! $questionnaire_id ) {
			wp_send_json_error( array( 'message' => 'شناسه‌ی تست ارسال نشده.' ) );
		}

		$identity = af_questionnaire_get_current_identity();

		// af_questionnaire_get_answers خودش مالکیت Attempt را نسبت به identity چک می‌کند
		$answers = af_questionnaire_get_answers( $identity, $questionnaire_id );

		wp_send_json_success( array( 'answers' => $answers ) );
	}
}
add_action( 'wp_ajax_af_mytests_get_answers', 'af_mytests_ajax_get_answers' );
add_action( 'wp_ajax_nopriv_af_mytests_get_answers', 'af_mytests_ajax_get_answers' );


/* ==========================================================
 * رندر پاپ‌آپ
 * ========================================================== */

if ( ! function_exists( 'af_mytests_render_popup' ) ) {
	function af_mytests_render_popup() {
		static $already = false;
		if ( $already ) {
			return;
		}
		$already = true;

		$attempts = af_mytests_get_completed_attempts();

		// آدرس آیکن‌ها
		$icon_test     = 'http://6tofit.com/wp-content/uploads/2026/09/phonetest.png';
		$icon_link     = 'http://6tofit.com/wp-content/uploads/2025/10/brudic.svg';
		$icon_back     = 'http://6tofit.com/wp-content/uploads/2025/10/Stateback.svg';
		$icon_fire     = 'http://6tofit.com/wp-content/uploads/2026/09/fireemo.png';
		$icon_clip     = 'http://6tofit.com/wp-content/uploads/2026/09/📋-Clipboard.png';
		$icon_target   = 'http://6tofit.com/wp-content/uploads/2026/09/🎯-Direct-Hit.png';
		$icon_bulb     = 'http://6tofit.com/wp-content/uploads/2026/09/💡-Light-Bulb.png';
		?>
		<div class="af-mt-overlay" id="af-mt-overlay">
			<div class="af-mt-content" dir="rtl">

				<!-- ========== صفحه‌ی لیست تست‌ها ========== -->
				<div class="af-mt-screen af-mt-screen-list" id="af-mt-screen-list">

					<div class="af-mt-header">
						<h2 class="af-mt-title">تست های من</h2>
						<button type="button" class="af-mt-close" id="af-mt-close" aria-label="بستن">&times;</button>
					</div>

					<div class="af-mt-list-wrap">
						<div class="af-mt-list">
							<?php if ( ! empty( $attempts ) ) : ?>
								<?php foreach ( $attempts as $attempt ) : ?>
									<div class="af-mt-item">
										<div class="af-mt-col af-mt-col-icon">
											<img src="<?php echo esc_url( $icon_test ); ?>" alt="" class="af-mt-icon-img">
										</div>
										<div class="af-mt-col af-mt-col-info">
											<div class="af-mt-info-title">تست هوشمند</div>
											<div class="af-mt-info-date"><?php echo esc_html( af_mytests_format_shamsi_date( $attempt->completed_at ) ); ?></div>
										</div>
										<div class="af-mt-col af-mt-col-link">
											<a href="javascript:void(0)" class="af-mt-view-link" data-questionnaire-id="<?php echo esc_attr( $attempt->id ); ?>">
												<span>مشاهده نتیجه</span>
												<img src="<?php echo esc_url( $icon_link ); ?>" alt="" class="af-mt-link-icon">
											</a>
										</div>
									</div>
								<?php endforeach; ?>
							<?php else : ?>
								<div class="af-mt-empty">هنوز هیچ تستی انجام نداده‌ای.</div>
							<?php endif; ?>
						</div>
					</div>

					<div class="af-mt-footer">
						<button type="button" class="af-mt-cta-btn" id="af-mt-start-btn">انجام تست جدید</button>
					</div>

				</div>
				<!-- /af-mt-screen-list -->

				<!-- ========== صفحه‌ی نتیجه‌ی تست (مستقل) ========== -->
				<div class="af-mt-screen af-mt-screen-result" id="af-mt-screen-result" style="display:none;">

					<div class="af-mt-header af-mt-result-header">
						<button type="button" class="af-mt-back" id="af-mt-back" aria-label="بازگشت">
							<img src="<?php echo esc_url( $icon_back ); ?>" alt="" class="af-mt-back-icon">
						</button>
						<h2 class="af-mt-title">نتیجه تست</h2>
						<button type="button" class="af-mt-close" id="af-mt-close-2" aria-label="بستن">&times;</button>
					</div>

					<div class="af-mt-list-wrap af-mt-result-body" id="af-mt-result-body">

						<div class="af-mt-result-loading" id="af-mt-result-loading">در حال بارگذاری نتیجه...</div>

						<div class="af-mt-result-content" id="af-mt-result-content" style="display:none;">

							<!-- تب‌ها -->
							<div class="afmt-tabs-container">
								<div class="afmt-tab active" data-tab="afmt-tdee-now" id="afmt-tab-now">TDEE الآن</div>
								<div class="afmt-tab" data-tab="afmt-tdee-ideal" id="afmt-tab-ideal">TDEE ایده‌آل</div>
							</div>

							<!-- تب TDEE الآن -->
							<div class="afmt-tab-content" id="afmt-tdee-now" style="display:block;">

								<div class="afmt-tdee-calorie">
									<img src="<?php echo esc_url( $icon_fire ); ?>" alt="" class="afmt-tdee-calorie-icon">
									<span class="afmt-tdee-number" id="afmt-now-cal">۱۸۰۰</span>
									<span class="afmt-tdee-unit">کالری</span>
								</div>

								<div class="afmt-energy-chart">
									<div class="afmt-energy-bar">
										<div class="afmt-energy-segment afmt-bmr"></div>
										<div class="afmt-energy-segment afmt-neat"></div>
										<div class="afmt-energy-segment afmt-exercise"></div>
										<div class="afmt-energy-segment afmt-tef"></div>
									</div>

									<div class="afmt-energy-label afmt-label-bmr">
										<span class="afmt-label-text">BMR</span>
										<span class="afmt-label-line"></span>
										<span class="afmt-label-dot"></span>
									</div>
									<div class="afmt-energy-label afmt-label-neat">
										<span class="afmt-label-dot"></span>
										<span class="afmt-label-line"></span>
										<span class="afmt-label-text">NEAT</span>
									</div>
									<div class="afmt-energy-label afmt-label-exercise">
										<span class="afmt-label-text">EXERCISE</span>
										<span class="afmt-label-line"></span>
										<span class="afmt-label-dot"></span>
									</div>
									<div class="afmt-energy-label afmt-label-tef">
										<span class="afmt-label-dot"></span>
										<span class="afmt-label-line"></span>
										<span class="afmt-label-text">TEF</span>
									</div>
								</div>

								<p class="afmt-intro-text">این تخمینی از انرژی‌ای هست که در یک روز عادی بر پایه پاسخ‌هایی که دادی مصرف میکنی.</p>

								<div class="afmt-tdee-cards">
									<div class="afmt-tdee-card">
										<div class="afmt-tdee-card-right"><div class="afmt-tdee-dot" style="background:#4590E6;"></div></div>
										<div class="afmt-tdee-card-left">
											<div class="afmt-tdee-card-title">متابولیسم پایه (BMR)</div>
											<div class="afmt-tdee-card-desc">مقدار انرژی‌ای که بدن برای زنده موندن در حالت استراحت کامل نیاز داره، مثل نفس کشیدن</div>
											<div class="afmt-tdee-card-value">
												<span class="afmt-tdee-num" id="afmt-card-bmr">۱۶۰۰</span>
												<span class="afmt-tdee-unit-sm">کالری</span>
											</div>
										</div>
									</div>

									<div class="afmt-tdee-card">
										<div class="afmt-tdee-card-right"><div class="afmt-tdee-dot" style="background:#FF7A00;"></div></div>
										<div class="afmt-tdee-card-left">
											<div class="afmt-tdee-card-title">فعالیت‌های روزمره (NEAT)</div>
											<div class="afmt-tdee-card-desc">کالری‌ای که برای حرکت‌های غیر تمرینی می‌سوزونی، مثل راه رفتن، ایستادن، یا حتی تکون خوردن موقع حرف زدن</div>
											<div class="afmt-tdee-card-value">
												<span class="afmt-tdee-num" id="afmt-card-neat">۲۵۰</span>
												<span class="afmt-tdee-unit-sm">کالری</span>
											</div>
										</div>
									</div>

									<div class="afmt-tdee-card">
										<div class="afmt-tdee-card-right"><div class="afmt-tdee-dot" style="background:#ED5C5C;"></div></div>
										<div class="afmt-tdee-card-left">
											<div class="afmt-tdee-card-title"> ورزش (EXERCISE)</div>
											<div class="afmt-tdee-card-desc">کالری‌ای که حین ورزش یا تمرین منظم می‌سوزونی، از پیاده‌روی گرفته تا تمرینات برنامه‌ریزی‌شده باشگاهی</div>
											<div class="afmt-tdee-card-value">
												<span class="afmt-tdee-num" id="afmt-card-exercise">۴۵۰</span>
												<span class="afmt-tdee-unit-sm">کالری</span>
											</div>
										</div>
									</div>

									<div class="afmt-tdee-card">
										<div class="afmt-tdee-card-right"><div class="afmt-tdee-dot" style="background:#00A89E;"></div></div>
										<div class="afmt-tdee-card-left">
											<div class="afmt-tdee-card-title">اثر حرارتی غذا (TEF)</div>
											<div class="afmt-tdee-card-desc">میزان انرژی‌ای که بدن برای هضم، جذب و پردازش مواد غذایی مصرف می‌کنه، حدود ۱۰٪ از کل کالری دریافتی</div>
											<div class="afmt-tdee-card-value">
												<span class="afmt-tdee-num" id="afmt-card-tef">۳۵۰</span>
												<span class="afmt-tdee-unit-sm">کالری</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /afmt-tdee-now -->

							<!-- تب TDEE ایده‌آل -->
							<div class="afmt-tab-content" id="afmt-tdee-ideal" style="display:none;">

								<div class="afmt-ideal-goal" id="afmt-ideal-goal-text">هدف: کاهش وزن</div>

								<div class="afmt-tdee-calorie">
									<img src="<?php echo esc_url( $icon_fire ); ?>" alt="" class="afmt-tdee-calorie-icon">
									<span class="afmt-tdee-number" id="afmt-ideal-cal">۱۸۰۰</span>
									<span class="afmt-tdee-unit">کالری</span>
								</div>

								<p class="afmt-ideal-desc" id="afmt-ideal-desc">
									برای کاهش نیم کیلو وزن در هفته، باید حدود ۵۰۰ کالری کمتر از TDEE الانتون مصرف کنید.
								</p>

								<div class="afmt-ideal-cards">
									<div class="afmt-ideal-card">
										<div class="afmt-ideal-card-header">
											<div class="afmt-ideal-card-icon"><img src="<?php echo esc_url( $icon_clip ); ?>" alt=""></div>
											<h2 class="afmt-ideal-card-title">ما برنامه‌ای تهیه میکنیم که</h2>
										</div>
										<div class="afmt-ideal-card-divider"></div>
										<ul class="afmt-ideal-card-list">
											<li id="afmt-ideal-cal-li">۱۸۰۰ کالری دارد.</li>
											<li>پر از غذاهای سالم و سیرکننده است تا بدون احساس گرسنگی وزن کم کنید.</li>
											<li>با افزودن تحرک روزانه (مثل ۲۰ دقیقه پیاده‌روی اضافه) می‌توانید کالری‌سوزی خود را بالا برده و سرعت کاهش وزن را بیشتر کنید.</li>
										</ul>
									</div>

									<div class="afmt-ideal-card">
										<div class="afmt-ideal-card-header">
											<div class="afmt-ideal-card-icon"><img src="<?php echo esc_url( $icon_target ); ?>" alt=""></div>
											<h2 class="afmt-ideal-card-title">نکات کلیدی</h2>
										</div>
										<div class="afmt-ideal-card-divider"></div>
										<ul class="afmt-ideal-card-list">
											<li id="afmt-ideal-monthly-li">با این روال، انتظار داریم در ماه اول ۲ تا ۳ کیلوگرم کاهش وزن داشته باشید.</li>
										</ul>
									</div>
								</div>

								<div class="afmt-ideal-tip-box">
									<div class="afmt-ideal-tip-icon"><img src="<?php echo esc_url( $icon_bulb ); ?>" alt="" width="24" height="24"></div>
									<div class="afmt-ideal-tip-text">
										ترکیب رژیم مناسب و ورزش، متابولیسم شما را همیشه فعال نگه می‌دارد و کمک می‌کند وزن کم‌شده برنگردد.
									</div>
								</div>
							</div>
							<!-- /afmt-tdee-ideal -->

						</div>
						<!-- /af-mt-result-content -->

						<div class="af-mt-result-error" id="af-mt-result-error" style="display:none;">
							مشکلی در بارگذاری نتیجه پیش آمد. لطفاً دوباره تلاش کنید.
						</div>

					</div>
					<!-- /af-mt-result-body -->

				</div>
				<!-- /af-mt-screen-result -->

			</div>
		</div>

		<style>
		/* ================= Overlay / Content (مشترک بین هر دو صفحه) ================= */
		.af-mt-overlay {
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
		.af-mt-overlay.active {
			display: flex !important;
		}
		.af-mt-content {
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
		.af-mt-screen {
			display: flex;
			flex-direction: column;
			flex: 1;
			min-height: 0;
		}

		/* Header */
		.af-mt-header {
			padding: 82px 82px 16px;
			position: relative;
			text-align: right;
			flex-shrink: 0;
		}
		.af-mt-result-header {
			text-align: center;
		}
		.af-mt-title {
			font-size: 24px;
			font-weight: 600;
			color: #000;
			margin: 0;
		}
		.af-mt-close {
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
		.af-mt-back {
			position: absolute;
			top: 14px;
			right: 28px;
			background: none;
			border: none;
			cursor: pointer;
			padding: 0;
			z-index: 10;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.af-mt-back-icon {
			width: 32px;
			height: 32px;
			display: block;
		}

		/* List wrap - این بخش اسکرول می‌خورد نه کل پاپ‌آپ */
		.af-mt-list-wrap {
			flex: 1;
			min-height: 0;
			overflow-y: auto;
			padding: 4px 102px 20px;
			scrollbar-width: none;
			-ms-overflow-style: none;
		}
		.af-mt-list-wrap::-webkit-scrollbar {
			display: none;
		}
		.af-mt-list {
			display: flex;
			flex-direction: column;
			gap: 12px;
		}

		/* هر ردیف تست */
		.af-mt-item {
			display: flex;
			flex-direction: row;
			align-items: center;
			padding: 14px 18px;
			gap: 14px;
		}
		.af-mt-col-icon {
			flex: 0 0 auto;
			width: 40px;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.af-mt-icon-img {
			width: 32px;
			height: 32px;
			object-fit: contain;
			display: block;
		}
		.af-mt-col-info {
			flex: 1 1 auto;
			min-width: 0;
			display: flex;
			flex-direction: column;
			gap: 4px;
			text-align: right;
		}
		.af-mt-info-title {
			font-size: 16px;
			color: #161618;
			font-weight: 500;
		}
		.af-mt-info-date {
			font-size: 12px;
			color: #65656D;
		}
		.af-mt-col-link {
			flex: 0 0 auto;
		}
		.af-mt-view-link {
			display: flex;
			align-items: center;
			gap: 4px;
			text-decoration: none;
			color: #65656D;
			font-size: 12px;
			white-space: nowrap;
			cursor: pointer;
		}
		.af-mt-link-icon {
			width: 14px;
			height: 14px;
			object-fit: contain;
			display: block;
		}
		.af-mt-empty {
			text-align: center;
			padding: 40px 10px;
			color: #9B9BA1;
			font-size: 15px;
		}

		/* Footer */
		.af-mt-footer {
			flex-shrink: 0;
			padding: 16px 32px 32px;
			text-align: center;
		}
		.af-mt-cta-btn {
			display: inline-block;
			background: #000000;
			color: #FFFFFF;
			font-size: 18px;
			border: none;
			border-radius: 100px;
			padding: 12px 10px;
			    min-width: 30%;
			cursor: pointer;
			font-family: 'iranyekan', sans-serif;
			transition: opacity 0.2s ease;
		}
		.af-mt-cta-btn:hover {
			opacity: 0.85;
		}

		/* Result loading / error */
		.af-mt-result-loading,
		.af-mt-result-error {
			text-align: center;
			padding: 60px 10px;
			color: #9B9BA1;
			font-size: 15px;
		}
		.af-mt-result-error {
			color: #c0392b;
		}

		/* ================= صفحه‌ی نتیجه (کپی هم‌ارز صفحه‌ی TDEE اصلی، با کلاس‌های afmt- مستقل) ================= */
		.afmt-tabs-container {
			width: 80%;
			background: #F0F0F1;
			border-radius: 1000px;
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin: 10px auto 24px;
			padding: 5px;
		}
		.afmt-tab {
			flex: 1;
			text-align: center;
			padding: 14px 0;
			font-size: 16px;
			font-weight: 700;
			color: #65656D;
			background: transparent;
			cursor: pointer;
			transition: all 0.25s ease;
			border-radius: 1000px;
			font-family: 'iranyekan', sans-serif;
		}
		.afmt-tab.active {
			background: #FFFFFF;
			color: #161618;
			box-shadow: 0 2px 8px rgba(0,0,0,0.06);
		}

		.afmt-tdee-calorie {
			display: flex;
			align-items: baseline;
			justify-content: center;
			gap: 8px;
			margin-bottom: 18px;
		}
		.afmt-tdee-calorie-icon {
			width: 36px;
			height: 36px;
			object-fit: contain;
			margin-left: 6px;
		}
		.afmt-tdee-number {
			font-size: 44px;
			font-weight: 700;
			color: #161618;
			line-height: 1;
		}
		.afmt-tdee-unit {
			font-size: 30px;
			color: #65656D;
			font-weight: 500;
		}

		/* نمودار انرژی */
		.afmt-energy-chart {
			position: relative;
			width: min(440px, 100%);
			height: 125px;
			margin: 0 auto;
			direction: ltr;
		}
		.afmt-energy-bar {
			position: absolute;
			top: 47px;
			left: 0;
			width: 100%;
			height: 40px;
			display: flex;
			overflow: hidden;
			border-radius: 20px;
		}
		.afmt-energy-segment {
			height: 100%;
			flex-shrink: 0;
		}
		.afmt-energy-segment.afmt-bmr { width: 56%; background: #4892df; }
		.afmt-energy-segment.afmt-neat { width: 23%; background: #ff7900; }
		.afmt-energy-segment.afmt-exercise { width: 13%; background: #ed5b60; }
		.afmt-energy-segment.afmt-tef { width: 8%; background: #00a99d; }

		.afmt-energy-label {
			position: absolute;
			width: 70px;
			text-align: center;
			font-size: 14px;
			font-weight: 700;
			line-height: 1;
			color: #151515;
		}
		.afmt-energy-label .afmt-label-text { display: block; }
		.afmt-energy-label .afmt-label-line {
			display: block;
			width: 2px;
			height: 12px;
			margin-left: auto;
			margin-right: auto;
			position: relative;
		}
		.afmt-energy-label .afmt-label-dot {
			position: absolute;
			width: 6px;
			height: 6px;
			border-radius: 50%;
			left: 50%;
			transform: translateX(-50%);
		}
		.afmt-label-bmr { top: 3px; left: 25%; }
		.afmt-label-bmr .afmt-label-line { background: #4892df; }
		.afmt-label-bmr .afmt-label-dot { background: #4892df; bottom: -3px; }

		.afmt-label-exercise { top: 3px; left: 78%; }
		.afmt-label-exercise .afmt-label-line { background: #ed5b60; }
		.afmt-label-exercise .afmt-label-dot { background: #ed5b60; bottom: -3px; }

		.afmt-label-neat { top: 91px; left: 60%; }
		.afmt-label-neat .afmt-label-line { background: #ff7900; margin-top: 0; margin-bottom: 5px; }
		.afmt-label-neat .afmt-label-dot { background: #ff7900; top: -3px; }

		.afmt-label-tef { top: 91px; left: 86%; }
		.afmt-label-tef .afmt-label-line { background: #00a99d; margin-top: 0; margin-bottom: 5px; }
		.afmt-label-tef .afmt-label-dot { background: #00a99d; top: -3px; }

		.afmt-intro-text {
			text-align: center;
			font-size: 15px;
			color: #65656D;
			line-height: 1.8;
			margin: 24px 0 28px;
			padding: 0 10px;
		}

		/* کارت‌های تفکیک انرژی */
		.afmt-tdee-cards {
			display: flex;
			flex-direction: column;
			gap: 23px;
			margin-bottom: 12px;
		}
		.afmt-tdee-card {
			background: #FFFFFF;
			padding: 12px;
			border-radius: 16px;
			display: flex;
			gap: 12px;
		}
		.afmt-tdee-card-right {
			width: 10%;
			display: flex;
			justify-content: center;
			align-items: flex-start;
			padding-top: 8px;
		}
		.afmt-tdee-dot {
			width: 12px;
			height: 12px;
			border-radius: 50%;
			flex-shrink: 0;
		}
		.afmt-tdee-card-left {
			width: 85%;
			text-align: right;
		}
		.afmt-tdee-card-title {
			font-size: 16px;
			color: #161618;
			font-weight: 500;
			margin-bottom: 4px;
		}
		.afmt-tdee-card-desc {
			font-size: 12px;
			color: #65656D;
			margin-bottom: 10px;
		}
		.afmt-tdee-card-value {
			display: flex;
			align-items: baseline;
			gap: 6px;
		}
		.afmt-tdee-num {
			font-size: 24px;
			font-weight: 600;
			color: #161618;
		}
		.afmt-tdee-unit-sm {
			font-size: 12px;
			color: #65656D;
		}

		/* تب ایده‌آل */
		.afmt-ideal-goal {
			text-align: center;
			font-size: 18px;
			font-weight: 600;
			color: #161618;
			margin: 10px 0 20px;
		}
		.afmt-ideal-desc {
			text-align: center;
			font-size: 18px;
			color: #65656D;
			line-height: 1.8;
			margin-bottom: 28px;
			padding: 0 8px;
		}
		.afmt-ideal-cards {
			display: flex;
			flex-direction: column;
			gap: 20px;
			margin-bottom: 24px;
		}
		.afmt-ideal-card {
			padding: 28px 24px;
			background-color: #FFFFFF;
			border-radius: 24px;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		}
		.afmt-ideal-card-header {
			display: flex;
			align-items: center;
			gap: 10px;
		}
		.afmt-ideal-card-icon img {
			width: 28px;
			height: 28px;
			object-fit: contain;
		}
		.afmt-ideal-card-title {
			font-size: 22px;
			font-weight: bold;
			color: #161618;
			text-align: right;
			margin: 0;
		}
		.afmt-ideal-card-divider {
			width: 100%;
			height: 1px;
			background-color: #F0F0F1;
			margin: 14px 0;
		}
		.afmt-ideal-card-list {
			list-style: none;
			padding-right: 22px;
			padding-top: 8px;
			margin: 0;
			color: #161618;
			font-size: 17px;
			line-height: 1.7;
			text-align: right;
		}
		.afmt-ideal-card-list li {
			position: relative;
			padding-right: 14px;
			margin-bottom: 6px;
		}
		.afmt-ideal-card-list li::before {
			content: '•';
			position: absolute;
			right: 0;
			color: #000000;
			font-size: 18px;
		}
		.afmt-ideal-tip-box {
			background: #F2F2F8;
			border-radius: 24px;
			padding: 16px;
			display: flex;
			align-items: center;
			gap: 14px;
			direction: rtl;
		}
		.afmt-ideal-tip-icon {
			width: 10%;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.afmt-ideal-tip-icon img {
			width: 24px;
			height: 24px;
			object-fit: contain;
		}
		.afmt-ideal-tip-text {
			width: 90%;
			font-size: 16px;
			color: #161618;
			line-height: 1.7;
			text-align: justify;
		}

		/* Mobile */
		@media only screen and (max-width: 768px) {
			.af-mt-content {
				min-width: unset;
				width: 100%;
				height: 100%;
				max-height: 100%;
				border-radius: 0;
				max-width: unset;
			}
			.af-mt-header {
				padding: 20px 20px 12px;
			}
			.af-mt-title {
				font-size: 20px;
				        text-align: center;
			}
			.af-mt-cta-btn {
				    min-width: 100%;
			}
			.af-mt-list-wrap {
				padding: 4px 16px 16px;
			}
			.af-mt-footer {
				padding: 12px 16px 20px;
			}
			.afmt-tabs-container {
				width: 100%;
			}
			.afmt-tab {
				font-size: 14px;
				padding: 12px 0;
			}
			.afmt-tdee-number {
				font-size: 36px;
			}
			.afmt-tdee-unit {
				font-size: 24px;
			}
			.afmt-ideal-card-title {
				font-size: 18px;
			}
			.afmt-ideal-card-list {
				font-size: 15px;
				padding-right: 12px;
			}
		}
		</style>

		<script>
		var afMyTestsData = <?php echo wp_json_encode( array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( AF_MYTESTS_NONCE_ACTION ),
		) ); ?>;
		</script>

		<script>
		(function () {
			if ( window._afMyTestsInit ) return;
			window._afMyTestsInit = true;

			var overlay      = document.getElementById('af-mt-overlay');
			var closeBtn     = document.getElementById('af-mt-close');
			var closeBtn2    = document.getElementById('af-mt-close-2');
			var startBtn     = document.getElementById('af-mt-start-btn');
			var backBtn      = document.getElementById('af-mt-back');
			var screenList   = document.getElementById('af-mt-screen-list');
			var screenResult = document.getElementById('af-mt-screen-result');
			var resultLoading = document.getElementById('af-mt-result-loading');
			var resultContent = document.getElementById('af-mt-result-content');
			var resultError    = document.getElementById('af-mt-result-error');

			/* ---------------- باز/بسته کردن پاپ‌آپ ---------------- */
			function open() {
				if (!overlay) return;
				overlay.classList.add('active');
				document.body.style.overflow = 'hidden';
				showListScreen();
			}
			function close() {
				if (!overlay) return;
				overlay.classList.remove('active');
				document.body.style.overflow = '';
			}
			function showListScreen() {
				if (screenList) screenList.style.display = 'flex';
				if (screenResult) screenResult.style.display = 'none';
			}
			function showResultScreen() {
				if (screenList) screenList.style.display = 'none';
				if (screenResult) screenResult.style.display = 'flex';
			}

			/* ---------------- موتور محاسبه‌ی مستقل TDEE/BMR (هم‌ارز AFQResults) ---------------- */
			var persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
			function toPersian(str) {
				return String(str).replace(/[0-9]/g, function (d) { return persianDigits[d]; });
			}
			function fmt(n) {
				n = Math.round(n);
				return toPersian(n.toLocaleString('en-US'));
			}
			function num(v, def) {
				var n = parseFloat(v);
				return isNaN(n) ? def : n;
			}
			function roundTo(n, step) {
				return Math.round(n / step) * step;
			}

			var ACTIVITY_FACTORS = {
				sedentary:   1.2,
				light:       1.375,
				moderate:    1.55,
				very_active: 1.725
			};
			var ACTIVITY_SPLIT = {
				sedentary:   { neat: 0.90, exercise: 0.10 },
				light:       { neat: 0.70, exercise: 0.30 },
				moderate:    { neat: 0.55, exercise: 0.45 },
				very_active: { neat: 0.35, exercise: 0.65 }
			};
			var GOAL_LABELS = {
				weight_loss:       'کاهش وزن',
				healthy_lifestyle: 'سبک زندگی سالم‌تر',
				fitness:           'تناسب اندام'
			};

			function afMtCompute(answers) {
				answers = answers || {};

				var gender   = answers.s1_gender || 'male';
				var age      = num(answers.s1_q3, 25);
				var heightCm = num(answers.s1_q4, 170);
				var weightKg = num(answers.s1_q5, 70);
				var targetKg = num(answers.s1_q6, weightKg);
				var activity = answers.s1_q7 && ACTIVITY_FACTORS[answers.s1_q7] ? answers.s1_q7 : 'moderate';
				var goal     = answers.s1_q1 && GOAL_LABELS[answers.s1_q1] ? answers.s1_q1 : 'weight_loss';

				var bmr;
				if (gender === 'female') {
					bmr = 10 * weightKg + 6.25 * heightCm - 5 * age - 161;
				} else if (gender === 'male') {
					bmr = 10 * weightKg + 6.25 * heightCm - 5 * age + 5;
				} else {
					var bmrMale   = 10 * weightKg + 6.25 * heightCm - 5 * age + 5;
					var bmrFemale = 10 * weightKg + 6.25 * heightCm - 5 * age - 161;
					bmr = (bmrMale + bmrFemale) / 2;
				}
				bmr = Math.max(800, Math.round(bmr));

				var factor = ACTIVITY_FACTORS[activity];
				var tdee = Math.round(bmr * factor);

				var tef = Math.round(tdee * 0.10);
				var remaining = Math.max(0, tdee - bmr - tef);
				var split = ACTIVITY_SPLIT[activity];
				var neat = Math.round(remaining * split.neat);
				var exercise = Math.max(0, remaining - neat);

				function pct(v) { return tdee > 0 ? (v / tdee) * 100 : 0; }
				var bmrPct = pct(bmr), neatPct = pct(neat), exercisePct = pct(exercise), tefPct = pct(tef);
				var drift = 100 - (bmrPct + neatPct + exercisePct + tefPct);
				bmrPct = Math.round((bmrPct + drift) * 10) / 10;
				neatPct = Math.round(neatPct * 10) / 10;
				exercisePct = Math.round(exercisePct * 10) / 10;
				tefPct = Math.round(tefPct * 10) / 10;

				var idealCalorie;
				if (goal === 'weight_loss') {
					idealCalorie = Math.max(bmr, roundTo(tdee - 500, 50));
				} else if (goal === 'fitness') {
					idealCalorie = roundTo(tdee + 300, 50);
				} else {
					idealCalorie = roundTo(tdee, 50);
				}

				var deficitPerDay = tdee - idealCalorie;
				var monthlyChangeKg = Math.round(Math.abs(deficitPerDay) * 30 / 7700 * 10) / 10;
				if (monthlyChangeKg <= 0) monthlyChangeKg = 0.5;

				return {
					gender: gender, goal: goal,
					bmr: bmr, tdee: tdee, neat: neat, exercise: exercise, tef: tef,
					bmrPct: bmrPct, neatPct: neatPct, exercisePct: exercisePct, tefPct: tefPct,
					idealCalorie: idealCalorie, monthlyChangeKg: monthlyChangeKg
				};
			}

			/* ---------------- رندر نتیجه در DOM ---------------- */
			function setText(id, text) {
				var el = document.getElementById(id);
				if (el) el.textContent = text;
			}

			function afMtRenderResult(r) {
				setText('afmt-now-cal', fmt(r.tdee));
				setText('afmt-card-bmr', fmt(r.bmr));
				setText('afmt-card-neat', fmt(r.neat));
				setText('afmt-card-exercise', fmt(r.exercise));
				setText('afmt-card-tef', fmt(r.tef));

				var segBmr = screenResult.querySelector('.afmt-energy-segment.afmt-bmr');
				var segNeat = screenResult.querySelector('.afmt-energy-segment.afmt-neat');
				var segExercise = screenResult.querySelector('.afmt-energy-segment.afmt-exercise');
				var segTef = screenResult.querySelector('.afmt-energy-segment.afmt-tef');
				if (segBmr) segBmr.style.width = r.bmrPct + '%';
				if (segNeat) segNeat.style.width = r.neatPct + '%';
				if (segExercise) segExercise.style.width = r.exercisePct + '%';
				if (segTef) segTef.style.width = r.tefPct + '%';

				var cursor = 0;
				function positionLabel(selector, widthPct) {
					var center = cursor + widthPct / 2;
					var label = screenResult.querySelector(selector);
					if (label) {
						label.style.left = center + '%';
						label.style.transform = 'translateX(-50%)';
					}
					cursor += widthPct;
				}
				positionLabel('.afmt-label-bmr', r.bmrPct);
				positionLabel('.afmt-label-neat', r.neatPct);
				positionLabel('.afmt-label-exercise', r.exercisePct);
				positionLabel('.afmt-label-tef', r.tefPct);

				setText('afmt-ideal-cal', fmt(r.idealCalorie));

				var goalMap = {
					weight_loss: 'کاهش وزن',
					healthy_lifestyle: 'سبک زندگی سالم‌تر',
					fitness: 'تناسب اندام'
				};
				setText('afmt-ideal-goal-text', 'هدف: ' + (goalMap[r.goal] || goalMap.weight_loss));

				var goalDescMap = {
					weight_loss: 'برای کاهش وزن، باید حدود ' + fmt(Math.max(0, r.tdee - r.idealCalorie)) +
						' کالری کمتر از TDEE الان‌تان مصرف کنید. یعنی شما حدود ' + fmt(r.idealCalorie) +
						' کالری در روز باید غذا بخورید تا به‌مرور وزنتان کاهش یابد.',
					healthy_lifestyle: 'برای حفظ سبک زندگی سالم و پایدار، باید حدود ' + fmt(r.idealCalorie) +
						' کالری در روز مصرف کنید؛ یعنی همان میزان TDEE فعلی‌تان، بدون کسری یا مازاد قابل توجه.',
					fitness: 'برای تناسب اندام و عضله‌سازی، باید حدود ' + fmt(Math.max(0, r.idealCalorie - r.tdee)) +
						' کالری بیشتر از TDEE الان‌تان مصرف کنید. یعنی شما حدود ' + fmt(r.idealCalorie) +
						' کالری در روز باید غذا بخورید تا به‌مرور عضله‌سازی کنید.'
				};
				setText('afmt-ideal-desc', goalDescMap[r.goal] || goalDescMap.weight_loss);
				setText('afmt-ideal-cal-li', fmt(r.idealCalorie) + ' کالری دارد.');

				var monthlyTextMap = {
					weight_loss: 'با این روال، انتظار داریم در ماه اول حدود ' + fmt(r.monthlyChangeKg) + ' کیلوگرم کاهش وزن داشته باشید.',
					healthy_lifestyle: 'با این روال، وزن شما در بلندمدت پایدار می‌ماند و انرژی و کیفیت زندگی‌تان بهبود پیدا می‌کند.',
					fitness: 'با این روال، انتظار داریم در ماه اول حدود ' + fmt(r.monthlyChangeKg) + ' کیلوگرم افزایش وزن (عمدتاً عضله) داشته باشید.'
				};
				setText('afmt-ideal-monthly-li', monthlyTextMap[r.goal] || monthlyTextMap.weight_loss);
			}

			/* ---------------- تب‌ها (اسکوپ‌شده فقط داخل صفحه‌ی نتیجه) ---------------- */
			function afMtSwitchTab(tabId, el) {
				screenResult.querySelectorAll('.afmt-tab').forEach(function (t) {
					t.classList.remove('active');
				});
				el.classList.add('active');
				screenResult.querySelectorAll('.afmt-tab-content').forEach(function (c) {
					c.style.display = 'none';
				});
				var content = document.getElementById(tabId);
				if (content) content.style.display = 'block';
			}
			var tabNowEl = document.getElementById('afmt-tab-now');
			var tabIdealEl = document.getElementById('afmt-tab-ideal');
			if (tabNowEl) tabNowEl.addEventListener('click', function () { afMtSwitchTab('afmt-tdee-now', tabNowEl); });
			if (tabIdealEl) tabIdealEl.addEventListener('click', function () { afMtSwitchTab('afmt-tdee-ideal', tabIdealEl); });

			/* ---------------- گرفتن پاسخ‌های یک Attempt خاص از سرور ---------------- */
			function afMtFetchAnswers(questionnaireId, onSuccess, onError) {
				var params = new URLSearchParams();
				params.append('action', 'af_mytests_get_answers');
				params.append('nonce', afMyTestsData.nonce);
				params.append('questionnaire_id', questionnaireId);

				fetch(afMyTestsData.ajax_url, {
					method: 'POST',
					credentials: 'same-origin',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
					body: params
				})
					.then(function (res) { return res.json(); })
					.then(function (json) {
						if (json && json.success) {
							onSuccess(json.data.answers || {});
						} else {
							onError();
						}
					})
					.catch(onError);
			}

			function openResultFor(questionnaireId) {
				showResultScreen();
				if (resultLoading) resultLoading.style.display = 'block';
				if (resultContent) resultContent.style.display = 'none';
				if (resultError) resultError.style.display = 'none';

				afMtFetchAnswers(
					questionnaireId,
					function (answers) {
						var r = afMtCompute(answers);
						afMtRenderResult(r);
						if (resultLoading) resultLoading.style.display = 'none';
						if (resultContent) resultContent.style.display = 'block';
					},
					function () {
						if (resultLoading) resultLoading.style.display = 'none';
						if (resultError) resultError.style.display = 'block';
					}
				);
			}

			/* ---------------- Event Bindings ---------------- */
			if (closeBtn) closeBtn.addEventListener('click', close);
			if (closeBtn2) closeBtn2.addEventListener('click', close);
			if (backBtn) backBtn.addEventListener('click', showListScreen);
			if (overlay) {
				overlay.addEventListener('click', function (e) {
					if (e.target === overlay) close();
				});
			}
			if (startBtn) {
				startBtn.addEventListener('click', function () {
					close();
					if (typeof AFQuestionnaire !== 'undefined') {
						AFQuestionnaire.open();
					}
				});
			}
			document.addEventListener('click', function (e) {
				var link = e.target.closest('.af-mt-view-link');
				if (link) {
					var id = link.getAttribute('data-questionnaire-id');
					openResultFor(id);
				}
			});

			window.AFMyTests = {
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
 * به‌جای وابسته‌بودن به هوک wp_footer، پاپ‌آپ همین‌جا و همین لحظه
 * که فایل require میشه چاپ می‌شود. برای همین توصیه می‌شود این فایل
 * از داخل footer.php قالب (نزدیک انتهای body>) require شود، نه از
 * وسط functions.php.
 * ========================================================== */


if ( ! function_exists( 'render_mytests_popup' ) ) {
	function render_mytests_popup() {
		af_mytests_render_popup();
	}
}

if ( ! function_exists( 'af_mytests_shortcode' ) ) {
	function af_mytests_shortcode( $atts ) {
		ob_start();
		?>
		<button type="button" class="af-pro-open-my-tests" onclick="AFMyTests.open()">
			تست های من
		</button>
		<?php
		return ob_get_clean();
	}
}
add_shortcode( 'af_my_tests', 'af_mytests_shortcode' );