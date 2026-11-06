<?php
/**
 * Questionnaire - Popup Template
 * بدون بخش لاگین. همه محتوا از questionnaire-content.php لود می‌شود.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="af-pro-questionnaire-overlay" id="af-pro-questionnaire-overlay">
	<div class="af-pro-questionnaire-content">

		<!-- Header -->
		<div class="af-pro-questionnaire-header">
			<h2 class="af-pro-questionnaire-title" id="af-pro-questionnaire-title">پرسشنامه هوشمند</h2>
			<p class="af-pro-questionnaire-desc" id="af-pro-questionnaire-desc"></p>
			<button type="button" class="af-pro-questionnaire-back" id="af-pro-questionnaire-back" aria-label="بازگشت" style="display:none;">
				<img src="http://6tofit.com/wp-content/uploads/2025/10/Stateback.svg" alt="بازگشت" class="af-pro-questionnaire-back-icon">
			</button>
			<button type="button" class="af-pro-questionnaire-close" id="af-pro-questionnaire-close" aria-label="بستن">
				&times;
			</button>
		</div>

		<!-- Body -->
		<div class="af-pro-questionnaire-body">

			<div class="af-pro-questionnaire-loading" id="af-pro-questionnaire-loading" style="display:none;">
				<div class="af-loader af-loader-global">
					<svg class="af-loader-svg" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
						<circle
							id="af-loader-arc-global"
							cx="75"
							cy="75"
							r="30"
							fill="none"
							stroke="#5247FF"
							stroke-width="10"
							stroke-linecap="round"
						/>
					</svg>
				</div>
			</div>

			<script>
			(function () {
				if (window._afQLoaderGlobal) return;
				window._afQLoaderGlobal = true;

				var arc = document.getElementById('af-loader-arc-global');
				if (!arc) return;

				/*
				 * GIF اصلی:
				 * 32 فریم
				 * مدت هر فریم: 30 / 40ms
				 */
				var frames = [
					{ angle:   0, length:   0, duration: 30 },
					{ angle:  -1, length:   1, duration: 40 },
					{ angle:  -4, length:   5, duration: 30 },
					{ angle:  -7, length:   8, duration: 30 },
					{ angle: -12, length:  13, duration: 40 },
					{ angle: -18, length:  19, duration: 30 },
					{ angle: -25, length:  26, duration: 30 },
					{ angle: -33, length:  34, duration: 40 },
					{ angle: -42, length:  43, duration: 30 },
					{ angle: -52, length:  54, duration: 30 },
					{ angle: -63, length:  65, duration: 40 },
					{ angle: -75, length:  78, duration: 30 },
					{ angle: -87, length:  91, duration: 30 },
					{ angle: -99, length: 105, duration: 40 },
					{ angle: -111, length: 120, duration: 30 },
					{ angle: -123, length: 135, duration: 30 },
					{ angle: -135, length: 145, duration: 40 },
					{ angle: -147, length: 133, duration: 30 },
					{ angle: -159, length: 120, duration: 30 },
					{ angle: -171, length: 105, duration: 40 },
					{ angle: 177, length:  91, duration: 30 },
					{ angle: 165, length:  78, duration: 30 },
					{ angle: 153, length:  65, duration: 40 },
					{ angle: 141, length:  54, duration: 30 },
					{ angle: 129, length:  43, duration: 30 },
					{ angle: 117, length:  34, duration: 40 },
					{ angle: 105, length:  26, duration: 30 },
					{ angle:  93, length:  19, duration: 30 },
					{ angle:  81, length:  13, duration: 40 },
					{ angle:  69, length:   8, duration: 30 },
					{ angle:  57, length:   4, duration: 30 },
					{ angle:  45, length:   0, duration: 30 }
				];

				var circumference = 2 * Math.PI * 30;

				function renderFrame(frame) {
					if (frame.length <= 0) {
						arc.style.strokeDasharray = '0 9999';
						arc.style.strokeDashoffset = '0';
					} else {
						var arcLength = Math.min(frame.length, circumference);
						arc.style.strokeDasharray = arcLength + ' ' + circumference;
						arc.style.strokeDashoffset = '0';
					}
					arc.style.transform = 'rotate(' + frame.angle + 'deg)';
				}

				var currentFrame = 0;

				function animate() {
					var frame = frames[currentFrame];
					renderFrame(frame);
					currentFrame++;
					if (currentFrame >= frames.length) {
						currentFrame = 0;
					}
					setTimeout(animate, frame.duration);
				}

				animate();
			})();
			</script>

			<div class="af-pro-questionnaire-error" id="af-pro-questionnaire-error" style="display:none;"></div>

			<!-- دیالوگ ادامه / شروع مجدد -->
			<div class="af-pro-questionnaire-resume-dialog" id="af-pro-questionnaire-resume-dialog" style="display:none;">
				<p class="af-pro-questionnaire-resume-text">
					شما یک پرسشنامه نیمه‌تمام دارید. مایلید ادامه دهید یا از ابتدا شروع کنید؟
				</p>
				<div class="af-pro-questionnaire-resume-actions">
					<button type="button" class="af-pro-questionnaire-btn af-pro-questionnaire-btn-primary" id="af-pro-questionnaire-btn-continue">
						ادامه پرسشنامه
					</button>
					<button type="button" class="af-pro-questionnaire-btn af-pro-questionnaire-btn-secondary" id="af-pro-questionnaire-btn-restart">
						شروع از ابتدا
					</button>
				</div>
			</div>

			<!-- Container همه Sectionها -->
			<div class="af-pro-questionnaire-section-container" id="af-pro-questionnaire-section-container">
				<?php af_questionnaire_render_content(); ?>
			</div>

		</div>
	</div>
</div>