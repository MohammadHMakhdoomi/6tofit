<?php
/**
 * ==========================================================
 * Questionnaire Content - همه Sectionها، صفحات و سوالات
 * هر بخش استایل و اسکریپت خودش را کنار کد دارد.
 * استایل‌ها و اسکریپت اصلی به صورت inline هستند.
 * دیگر نیازی به questionnaire.css و questionnaire.js نیست.
 * ==========================================================
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<!-- ========================================================
     BASE STYLES (از questionnaire.css - استایل پایه پاپ‌آپ)
======================================================== -->
<style>
/* Overlay */
.af-pro-questionnaire-overlay {
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
.af-pro-questionnaire-overlay.active {
	display: flex !important;
}

/* Content */
.af-pro-questionnaire-content {
	background: #F7F7F8;
	border-radius: 40px;
	max-width: 46%;
	min-width: 700px;
	min-height: 80%;
	width: 100%;
	max-height: 90vh;
	overflow: hidden;
	position: relative;
	display: flex;
	flex-direction: column;
}

/* Header */
.af-pro-questionnaire-header {
	padding: 28px 32px 10px;
	position: relative;
	text-align: center;
}
.af-pro-questionnaire-close {
	position: absolute;
	top: 18px;
	left: 28px;
	background: none;
	border: none;
	cursor: pointer;
	padding: 0;
	z-index: 10;
	font-size: 26px;
	line-height: 1;
	color: #6e6e6e;
}
.af-pro-questionnaire-back {
	position: absolute;
	top: 12px;
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
.af-pro-questionnaire-back-icon {
	width: 34px;
	height: 34px;
	display: block;
}
.af-pro-questionnaire-title {
	font-size: 24px;
	font-weight: 600;
	color: #000;
	margin: 0 0 8px 0;
}
.af-pro-questionnaire-desc {
	font-size: 15px;
	color: #6e6e6e;
	margin: 0;
}

/* Body */
.af-pro-questionnaire-body {
	padding: 30px 150px 50px;
	overflow-y: auto;
	flex: 1;
	position: relative;
}

/* Loading */
.af-pro-questionnaire-loading {
	display: none;
	position: absolute;
	inset: 0;
	align-items: center;
	justify-content: center;
	background: #F7F7F8;
	z-index: 5;
}
.af-loader-global {
	width: 60px;
	height: 60px;
	margin: 0 auto;
	display: flex;
	align-items: center;
	justify-content: center;
	background: #5247FF;
	border-radius: 50%;
}
.af-loader-global .af-loader-svg {
	width: 36px;
	height: 36px;
	overflow: visible;
}
#af-loader-arc-global {
	transform-origin: 75px 75px;
}

/* Error */
.af-pro-questionnaire-error {
	background: #fdecec;
	color: #c0392b;
	border: 1px solid rgba(192, 57, 43, 0.25);
	border-radius: 14px;
	padding: 14px 18px;
	font-size: 14px;
	margin-bottom: 20px;
	text-align: center;
}

/* Resume Dialog */
.af-pro-questionnaire-resume-dialog {
	text-align: center;
	padding: 20px 0;
}
.af-pro-questionnaire-resume-text {
	font-size: 15px;
	color: #161618;
	margin: 0 0 20px 0;
	line-height: 1.8;
}
.af-pro-questionnaire-resume-actions {
	display: flex;
	gap: 12px;
	justify-content: center;
}

/* Buttons (resume etc) */
.af-pro-questionnaire-btn {
	border: none;
	border-radius: 999px;
	padding: 14px 32px;
	font-size: 15px;
	font-weight: 500;
	cursor: pointer;
	font-family: 'iranyekan', sans-serif;
	transition: background 0.25s ease, opacity 0.2s ease;
}
.af-pro-questionnaire-btn-primary {
	background: #5247FF;
	color: #fff;
}
.af-pro-questionnaire-btn-primary:hover {
	background: #4338e0;
}
.af-pro-questionnaire-btn-secondary {
	background: #fff;
	color: #161618;
	border: 1.5px solid rgba(0,0,0,0.12);
}
.af-pro-questionnaire-btn-secondary:hover {
	border-color: rgba(82, 71, 255, 0.35);
}
.af-pro-questionnaire-btn:disabled {
	opacity: 0.6;
	cursor: not-allowed;
}

/* Section Container */
.af-pro-questionnaire-section-container {
	min-height: 400px;
}
.af-pro-questionnaire-section {
	font-size: 15px;
	color: #161618;
	height: 100%;
	display: flex;
	align-content: flex-end;
	align-items: flex-end;
	height: 400px;
}

/* Mobile */
@media only screen and (max-width: 768px) {
	.af-pro-questionnaire-content {
		min-width: unset;
		width: 100%;
		height: 100%;
		max-height: 100%;
		border-radius: 0;
		max-width: unset;
	}
	.af-pro-questionnaire-header {
		padding: 20px 20px 8px;
	}
	.af-pro-questionnaire-title {
		font-size: 20px;
	}
	.af-pro-questionnaire-body {
		padding: 10px 16px 20px;
	}
	.af-pro-questionnaire-resume-actions {
		flex-direction: column;
	}
}
</style>

<!-- ========================================================
     SECTION 1  (بخش اول)
     ترتیب دقیق:
     صفحه ۱ → صفحه ۲ → سوال ۱ → سوال ۲ → سوال ۳ → سوال ۴ → سوال ۵
     → صفحه ۴ → سوال ۶ → صفحه ۵ → سوال ۷ → صفحه ۶ → سوال ۸
     سوال ۲ = جنسیت (مرد/زن)
======================================================== -->
<div class="af-pro-questionnaire-section" data-section="1" style="display:none;">

	<!-- ========== صفحه ۱ : متن مقدمه ========== -->
	<div class="af-pro-q-page" data-page="1">
		<div class="af-pro-q-text-page">
			<div class="af-pro-q-intro-image-wrap">
				<img src="http://6tofit.com/wp-content/uploads/2026/09/mansec11.png" alt="" class="af-pro-q-intro-image">
			</div>
			<p>قراره فقط چند دقیقه وقت بذاری و توی چند بخش به چند تا سؤال کوتاه جواب بدی.</p>
			<p>ما بر اساس جواب‌هات، از بین محصولاتمون پیشنهادهایی بهت می‌دیم که دقیقاً با هدف و شرایط تو هماهنگ باشن.</p>
		</div>
		<div class="af-pro-q-page-actions">
			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-text-next"
				data-next-section="1" data-next-page="2" data-next-q="0">ادامه <img src="http://6tofit.com/wp-content/uploads/2026/09/Left-Arrow.png" alt="" class="af-pro-q-btn-icon"></button>
		</div>

		<style>
			.af-pro-q-intro-image-wrap {
				display: flex;
				justify-content: center;
				margin-bottom: 24px;
			}
			.af-pro-q-intro-image {
				width: 280px;
				max-width: 100%;
				object-fit: contain;
				border-radius: 24px;
			}
		</style>
	</div>

	<!-- ========== صفحه ۲ : متن توضیحی ========== -->
	<div class="af-pro-q-page" data-page="2" style="display:none;">
		<div class="af-pro-q-text-page">
			<div class="af-pro-q-intro-image-wrap">
				<img src="http://6tofit.com/wp-content/uploads/2026/09/mansec1-scaled.png" alt="" class="af-pro-q-intro-image">
			</div>
			<p>قدم اول، بیا بیشتر درباره هدف‌ت بگو.</p>
		</div>
		<div class="af-pro-q-page-actions">
			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-text-next"
				data-next-section="1" data-next-page="3" data-next-q="1">ادامه <img src="http://6tofit.com/wp-content/uploads/2026/09/Left-Arrow.png" alt="" class="af-pro-q-btn-icon"></button>
		</div>

		<style>
			.af-pro-q-intro-image-wrap {
				display: flex;
				justify-content: center;
				margin-bottom: 24px;
			}
			.af-pro-q-intro-image {
				width: 280px;
				max-width: 100%;
				object-fit: contain;
				border-radius: 24px;
			}
		</style>
	</div>

	<!-- ========== سوال ۱ ========== -->
	<div class="af-pro-q-page" data-page="3" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:12.5%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۱ از ۸</span>
		</div>
		<div class="af-pro-q-question" data-question="1" data-key="s1_q1">
			<div class="af-pro-q-question-text">هدف اصلی شما چیست؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/371508a9b5c068f358f6b7a6bc8df68047967fa6.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s1_q1" value="weight_loss"> کاهش وزن
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/baremo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s1_q1" value="healthy_lifestyle"> سبک زندگی سالم‌تر
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/bazemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s1_q1" value="fitness"> تناسب اندام
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="1" data-page="3" data-q="1"
				data-next-section="1" data-next-page="4" data-next-q="2" data-total="8">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

		<!-- ========== سوال ۲ (جنسیت) ========== -->
	<div class="af-pro-q-page" data-page="4" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:25%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۲ از ۸</span>
		</div>
		<div class="af-pro-q-question" data-question="2" data-key="s1_gender">
			<div class="af-pro-q-question-text">جنسیت شما چیست؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/male-memoji.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s1_gender" value="male"> مرد
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/Female-memoji.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s1_gender" value="female"> زن
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/soal.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s1_gender" value="other"> سایر
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="1" data-page="4" data-q="2"
				data-next-section="1" data-next-page="5" data-next-q="3" data-total="8">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<!-- ========== سوال ۳ ========== -->
	<div class="af-pro-q-page" data-page="5" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:37.5%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۳ از ۸</span>
		</div>
		<div class="af-pro-q-question" data-question="3" data-key="s1_q3">
			<div class="af-pro-q-question-text">شما چند سال دارید؟</div>

			<!-- Picker سن -->
			<div class="af-pro-q-age-picker" data-min="1" data-max="100" data-default="20">
				<div class="af-pro-q-age-list">
					<!-- اعداد با JS پر می‌شن -->
				</div>
				<!-- مقدار انتخاب‌شده برای سیستم ذخیره -->
				<input type="radio" name="s1_q3" value="20" checked style="display:none;">
			</div>

			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-next-btn"
				data-section="1" data-page="5" data-q="3"
				data-next-section="1" data-next-page="6" data-next-q="4" data-total="8">ادامه</button>
		</div>

		<style>
			.af-pro-q-age-picker {
				display: flex;
				justify-content: center;
				margin: 10px 0 32px;
				user-select: none;
			}
			.af-pro-q-age-list {
				display: flex;
				flex-direction: column;
				align-items: center;
				gap: 9px;
				height: 320px;
				justify-content: center;
			}
			.af-pro-q-age-item {
				display: flex;
				align-items: center;
				justify-content: center;
				width: 72px;
				height: 36px;
				font-family: 'iranyekan', sans-serif;
				font-weight: 500;
				color: #C6C6C9;
				font-size: 20px;
				transition: all 0.2s ease;
				cursor: pointer;
				border-radius: 24px;
			}
			.af-pro-q-age-item[data-pos="-2"],
			.af-pro-q-age-item[data-pos="2"] {
				color: #C6C6C9;
				font-size: 20px;
			}
			.af-pro-q-age-item[data-pos="-1"],
			.af-pro-q-age-item[data-pos="1"] {
				color: #65656D;
				font-size: 24px;
			}
			.af-pro-q-age-item[data-pos="0"] {
			
				height: 80px;
				background: #FFFFFF;
				border: 1px solid #5247FF;
				border-radius: 24px;
				color: #161618;
				font-size: 44px;
				font-weight: 600;
			}
		</style>

		<script>
		(function () {
			if (window._afQAgePicker) return;
			window._afQAgePicker = true;

			function initAgePicker(picker) {
				var min = parseInt(picker.getAttribute('data-min'), 10) || 1;
				var max = parseInt(picker.getAttribute('data-max'), 10) || 100;
				var current = parseInt(picker.getAttribute('data-default'), 10) || 20;
				var list = picker.querySelector('.af-pro-q-age-list');
				var hiddenRadio = picker.querySelector('input[type="radio"]');

				function render() {
					list.innerHTML = '';
					for (var i = -2; i <= 2; i++) {
						var num = current + i;
						var item = document.createElement('div');
						item.className = 'af-pro-q-age-item';
						item.setAttribute('data-pos', i);

						if (num >= min && num <= max) {
							item.textContent = num;
							item.addEventListener('click', (function (n) {
								return function () {
									current = n;
									hiddenRadio.value = n;
									hiddenRadio.checked = true;
									render();
									// فعال کردن دکمه ادامه
									var btn = picker.closest('.af-pro-q-question').querySelector('.af-pro-q-next-btn');
									if (btn) {
										btn.classList.remove('af-pro-q-btn-inactive');
										btn.classList.add('af-pro-q-btn-active');
									}
								};
							})(num));
						} else {
							item.textContent = '';
							item.style.visibility = 'hidden';
						}
						list.appendChild(item);
					}
				}

				// پشتیبانی از اسکرول با چرخ موس / تاچ
				list.addEventListener('wheel', function (e) {
					e.preventDefault();
					if (e.deltaY < 0 && current > min) {
						current--;
					} else if (e.deltaY > 0 && current < max) {
						current++;
					}
					hiddenRadio.value = current;
					hiddenRadio.checked = true;
					render();
				}, { passive: false });

				render();
			}

			// وقتی صفحه سوال ۳ نمایش داده شد، پیکر را راه‌اندازی کن
			document.addEventListener('click', function (e) {
				// بعد از رفتن به صفحه، پیکر را چک کن
			});

			// راه‌اندازی اولیه وقتی DOM آماده است
			function tryInit() {
				var picker = document.querySelector('.af-pro-q-age-picker');
				if (picker && !picker.dataset.inited) {
					picker.dataset.inited = '1';
					initAgePicker(picker);
				}
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', tryInit);
			} else {
				tryInit();
			}

			// برای اطمینان بعد از هر بار نمایش صفحه هم چک شود
			var observer = new MutationObserver(tryInit);
			observer.observe(document.body, { childList: true, subtree: true });
		})();
		</script>
	</div>

	<!-- ========== سوال ۴ ========== -->
	<div class="af-pro-q-page" data-page="6" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:50%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۴ از ۸</span>
		</div>
		<div class="af-pro-q-question" data-question="4" data-key="s1_q4">
			<div class="af-pro-q-question-text">قد شما چند است؟</div>

			<div class="af-pro-q-height-picker">
				<!-- دکمه‌های Ft / Cm -->
				<div class="af-pro-q-height-toggle">
					<button type="button" class="af-pro-q-toggle-btn ft-btn">Ft</button>
					<button type="button" class="af-pro-q-toggle-btn cm-btn active">Cm</button>
				</div>

				<!-- Stage اصلی (تصویر + خط صاف + خط‌کش) -->
				<div class="af-pro-q-height-stage">
					<div class="af-pro-q-height-display">
					<span class="af-pro-q-height-unit">cm</span>
						<span class="af-pro-q-height-number">156.6</span>
						
					</div>

					<div class="af-pro-q-height-line"></div>

					<div class="af-pro-q-ruler">
						<div class="af-pro-q-ruler-track"></div>
					</div>

					<div class="af-pro-q-silhouette-container">
						<!-- مرد -->
						<div class="af-pro-q-silhouette-male">
							<svg width="178" height="401" viewBox="0 0 178 401" fill="none" xmlns="http://www.w3.org/2000/svg">
								<g clip-path="url(#clip0_2500_29235)">
									<path d="M177.945 222.403C178.445 213.012 173.302 204.788 172.913 195.508C172.607 179.865 173.691 164.056 168.215 149.108C160.903 128.909 172.273 101.486 143.612 94.9006C126.237 90.4829 102.634 90.1495 108.5 70.5892C109.418 67.5329 113.115 68.7554 114.449 66.4215C114.755 65.8936 114.727 64.7545 114.922 64.171C115.645 62.0594 115.756 59.6144 116.201 57.336C116.673 54.9743 120.148 53.0572 120.26 50.6678C120.371 47.806 118.508 45.4443 118.425 42.5547C118.397 41.3878 118.258 40.5264 118.814 39.5262C119.398 38.4704 120.343 37.5813 120.982 36.5533C122.206 34.5806 122.623 32.1355 122.094 29.8572C121.761 28.3846 121.038 27.0232 120.037 25.884C119.398 25.1617 117.063 24.1892 117.98 23.0778C118.897 21.9664 120.093 21.2996 120.232 19.6603C120.343 18.4378 119.731 17.2153 118.842 16.354C117.952 15.4927 116.84 14.937 115.7 14.4369C116.479 14.7703 116.507 11.4917 116.451 11.2139C116.145 9.908 115.311 8.6577 114.31 7.76859C111.892 5.65698 109.112 5.01793 105.998 4.76788C103.079 4.5456 100.994 3.21195 98.3532 2.10057C96.4072 1.29482 94.2667 0.878054 92.1539 0.85027C89.9855 0.85027 88.0673 1.48931 85.9267 0.905839C81.8679 -0.872365 77.8369 -0.0388329 75.5017 3.46201C74.9457 4.29554 71.4707 3.37865 70.4143 4.23997C69.3857 5.10129 69.8861 6.685 69.1077 7.62967C68.2181 8.68548 66.2443 8.21315 65.0211 8.54656C63.7145 8.90776 62.7415 9.99135 62.0187 11.1305C61.2959 12.2697 60.7677 13.5478 59.9893 14.6591C59.2387 15.7427 57.9321 16.2428 57.1259 17.2709C56.0139 18.6879 56.7089 19.9382 57.5707 21.2718C57.9321 21.8275 58.2101 22.5499 57.9321 23.1334C57.6819 23.7169 57.0425 23.9669 56.5143 24.3003C55.4579 24.9394 54.6517 25.9952 54.3181 27.1621C53.4841 30.0517 55.3745 32.4412 57.5151 34.1082C56.6533 35.6364 55.5969 36.7755 56.1807 38.7482C56.8201 40.9432 58.5993 41.3322 60.4341 42.1102C59.9893 43.9995 58.5715 45.5276 58.7105 47.6115C58.8495 49.6953 59.9059 51.6958 61.5739 52.9739C62.4357 53.6407 63.5477 54.1964 63.8535 55.2522C64.2149 56.5025 63.5477 57.8917 63.7423 59.1976C63.9369 60.5868 64.6319 61.9205 65.6883 62.8373C66.1053 63.1985 66.5501 63.5042 66.8559 63.9487C67.6065 65.0601 66.4667 66.5049 67.1617 67.783C67.6899 68.7276 68.4961 69.1166 69.4413 69.5056C70.1085 69.7835 70.0529 69.5056 70.4143 70.0613C70.6645 70.4503 70.5533 71.0338 70.8869 71.4227C73.2499 90.5384 53.5119 89.7882 39.8899 93.6781C4.7786 97.429 16.677 127.492 8.83739 151.247C2.5546 169.557 6.8914 189.84 1.52601 208.344C0.497408 211.54 -0.0307896 214.902 0.0248103 218.263C0.16381 229.405 -0.47559 240.547 0.970007 251.716C2.16541 273.499 -2.94979 298.422 20.0964 310.98C33.1068 313.925 12.2012 290.031 17.6778 285.446C20.6246 288.753 22.9876 292.448 25.4062 296.143C26.0178 296.588 27.7692 296.31 27.5746 295.087C25.156 269.053 15.0924 272.721 17.0106 262.357C21.2084 244.047 27.3522 226.015 27.1298 206.983C27.0742 204.066 27.8248 201.065 28.492 198.175C29.2426 195.008 30.5214 191.924 31.272 188.729C32.0782 185.395 32.7176 182.06 33.3848 178.698C34.052 175.42 34.4968 172.086 35.2196 168.807C35.6088 167.057 36.4984 159.527 38.9169 159.499C41.3077 159.472 42.2807 165.306 42.7533 167.001C45.1997 176.17 46.5341 185.506 46.8121 194.98C47.0067 201.676 46.6731 208.4 45.7557 215.013C44.8105 221.709 42.5587 228.127 40.9185 234.656C36.8876 250.799 35.0806 267.386 33.218 283.89C31.2442 301.117 30.2434 318.482 30.7994 335.819C30.8272 336.847 30.7994 337.931 30.9106 338.959C33.496 367.827 40.0289 376.329 30.16 405.892C22.098 437.649 41.0575 470.796 27.8526 501.831C27.4634 502.582 27.102 503.471 27.1576 504.276C27.519 509.917 24.7946 514.64 22.8764 519.614C21.0972 524.17 21.6254 526.143 26.1846 527.504C30.438 528.143 53.4007 536.701 52.2609 528.393C43.0591 487.55 60.2117 456.821 64.8265 417.422C66.5501 407.392 63.2975 397.473 65.1879 387.471C69.4413 365.049 73.6113 342.627 79.1713 320.455C80.4223 315.481 81.7289 310.508 83.1189 305.562C83.8139 303.089 84.5089 300.617 85.2317 298.144C85.7043 296.56 85.9545 293.226 87.4557 292.281C91.5145 289.697 92.0705 296.421 92.6821 298.644C93.6829 302.367 94.6559 306.062 95.6011 309.785C97.5193 317.343 99.3819 324.928 101.244 332.513C102.801 339.098 103.552 345.794 104.775 352.435C106.832 363.493 110.307 374.162 111.308 385.387C112.337 396.751 112.031 408.17 113.004 419.534C113.282 422.562 113.476 425.73 114.144 428.703C117.619 444.373 121.733 459.877 125.264 475.547C127.237 484.216 130.268 492.885 127.682 502.026C127.293 510.306 126.403 518.641 125.569 526.921C124.013 534.784 133.909 531.172 138.274 530.616C142.889 529.671 147.504 528.699 152.007 527.338C155.593 526.254 156.261 524.615 155.371 521.642C153.175 514.279 151.368 506.777 148.755 499.553C139.747 472.713 151.09 444.54 149.199 417.339C147.309 405.781 143.445 394.445 141.888 382.886C146.086 343.127 148.921 303.256 141.888 263.524C140.081 253.383 138.246 243.269 136.189 233.156C134.104 222.876 132.13 212.54 131.407 202.065C130.573 190.229 131.407 178.059 135.411 166.807C135.883 165.473 138.747 156.721 140.164 161.694C143.445 173.003 145.002 184.728 148.727 195.953C152.563 207.483 149.422 219.792 153.175 231.433C155.343 240.158 157.428 248.882 159.346 257.662C160.57 263.274 162.182 269.081 156.261 273.416C155.482 273.971 155.037 275.194 154.759 276.194C153.203 281.973 151.701 287.78 150.284 293.587C149.978 295.727 151.952 296.31 153.314 295.171C155.204 292.92 156.205 289.947 157.706 287.447C157.984 287.03 158.79 286.919 159.374 286.78C159.458 286.78 159.847 287.502 159.819 287.891C159.68 289.92 159.847 291.726 159.291 293.754C158.735 295.754 157.845 297.644 156.928 299.505C155.566 302.228 153.203 304.951 152.813 308.091C152.202 313.092 158.54 310.647 160.959 309.202C163.461 307.729 165.518 305.562 167.242 303.256C171.328 297.838 174.025 291.281 175.609 284.696C176.833 279.639 177.861 273.499 175.915 268.47C175.443 266.414 175.276 264.163 175.554 262.08C177.333 248.91 178.167 235.684 177.972 222.403H177.945Z" fill="#5247FF" fill-opacity="0.12"/>
								</g>
								<defs>
									<clipPath id="clip0_2500_29235">
										<rect width="178" height="466" fill="white"/>
									</clipPath>
								</defs>
							</svg>
						</div>
						<!-- زن -->
						<div class="af-pro-q-silhouette-female" style="display:none;">
							<svg width="178" height="401" viewBox="0 0 178 401" fill="none" xmlns="http://www.w3.org/2000/svg">
								<g clip-path="url(#clip0_2500_29163)">
									<path d="M175.141 247.382C173.616 237.427 170.308 227.886 170.122 217.555C169.601 196.481 166.441 175.482 167.036 154.332C165.4 139.87 164.805 116.804 148.076 111.733C144.358 110.606 140.454 110.268 136.588 109.93C133.391 109.667 129.562 110.155 127.331 107.338C125.472 104.971 126.29 102.267 126.253 99.5243C126.253 95.7302 126.179 91.9736 126.253 88.1795C126.327 80.7791 126.513 73.3787 126.736 65.9783C126.996 56.5494 127.926 46.5194 126.811 37.1656C126.513 34.6111 126.141 32.0942 125.658 29.5773C122.163 11.5083 104.876 -1.18884 86.6966 0.0883907C86.5479 0.0883907 86.3992 0.0883907 86.2877 0.0883907C70.1157 0.0132597 58.4421 9.32951 53.7578 22.778C49.6312 33.1085 49.8914 44.3406 50.9696 55.2346C52.6054 71.4253 54.6873 88.0293 51.1183 104.107C50.7837 105.572 50.4119 107.113 49.5197 108.315C47.7724 110.719 44.2406 110.456 41.6382 110.832C37.2513 111.433 32.9016 112.221 28.6634 113.536C23.0497 115.264 18.7 118.833 16.804 124.581C6.5803 148.885 11.2646 175.332 8.81092 200.951C7.43537 225.481 0.85507 249.448 0 273.941C0 292.461 1.18967 310.981 1.44991 329.5C0.669194 338.967 11.5992 367.103 23.0125 368.493C23.6445 368.569 24.2766 368.343 24.6855 367.892C25.6893 366.728 24.8714 364.887 24.165 363.272C21.0421 355.721 16.0233 348.621 17.9936 340.056C20.1871 342.686 21.5626 347.607 24.3881 349.485C24.8714 349.786 25.5034 349.485 25.5778 348.959C26.6187 340.207 22.7151 327.284 17.4732 320.109C15.8374 317.893 15.3541 314.099 15.7259 311.168C16.4322 305.496 18.0308 299.786 19.109 294.151C20.2243 288.366 21.3024 282.581 22.3805 276.758C24.4996 265.151 26.47 253.543 28.2916 241.898C31.4889 221.387 34.24 200.763 36.2104 180.102C36.3591 178.374 37.1769 172.326 39.5934 172.326C41.4895 172.326 43.0509 177.51 43.6086 178.938C45.8764 184.836 46.2481 191.56 46.9173 197.758C47.7352 205.76 48.1813 213.799 48.1813 221.838C48.1813 226.158 48.5159 231.004 47.7352 235.286C46.2853 243.438 43.3483 251.402 40.0395 258.952C33.6079 273.641 30.7082 289.493 29.5185 305.233C23.4215 354.369 41.1549 403.054 34.5746 451.964C32.3811 467.103 29.7415 482.204 28.6634 497.493C25.5034 529.574 32.2324 561.543 30.9312 593.699C32.1209 610.791 27.102 626.832 23.9791 643.36C23.4958 646.967 24.9829 649.934 28.5147 650.761C34.0541 652.076 39.6678 653.09 45.3187 653.766C49.3338 654.254 50.8581 651.174 51.3042 647.793C39.705 597.681 61.4163 549.296 65.8404 499.672C66.6211 489.793 67.3646 480.213 65.8404 470.334C64.9853 464.736 65.5058 458.726 66.4724 453.091C71.1939 433.369 71.7515 413.159 75.209 393.174C78.2203 378.561 79.1869 363.535 83.202 349.11C83.7597 347.044 84.0942 344.226 85.7672 342.799C86.9197 341.822 89.2246 341.409 90.563 342.198C92.459 343.362 92.7193 346.217 93.1654 348.17C94.8012 355.308 95.9537 362.596 97.3664 369.771C98.7791 377.058 99.8201 384.571 101.567 391.784C105.954 409.853 104.579 428.673 110.007 446.479C112.646 456.509 113.129 466.878 111.345 476.682C109.337 487.952 111.345 498.771 112.72 509.402C118.743 554.18 137.443 599.108 126.253 644.638C123.502 657.598 142.499 654.555 149.414 650.535C153.281 648.62 154.879 645.614 153.578 641.257C137.034 588.289 156.143 532.73 147.109 479.086C139.376 446.893 140.008 414.286 145.064 381.717C147.369 358.201 151.57 334.647 148.299 311.018C147.518 292.649 144.209 274.805 136.885 257.938C132.647 248.134 129.673 237.465 129.153 226.684C128.707 217.781 128.298 208.502 128.781 199.561C129.153 192.837 130.454 185.587 134.209 179.802C135.138 178.374 136.216 177.06 137.443 175.857C138.484 174.881 139.711 173.716 140.938 175.444C143.206 178.6 141.867 183.859 142.313 187.54C145.102 210.831 148.299 234.084 151.905 257.262C152.314 259.816 152.909 262.408 153.132 265C154.098 277.059 165.251 311.018 160.456 319.207C155.325 326.044 154.47 334.159 152.091 341.784C151.756 343.099 150.864 350.274 153.392 349.11C153.764 348.959 154.061 348.659 154.284 348.283C155.66 346.104 156.961 343.85 158.337 341.672C158.634 341.183 159.415 341.371 159.452 341.935C159.638 344.865 160.233 347.87 158.857 350.5C156.961 355.646 153.281 360.417 153.243 365.901C153.243 367.517 154.879 368.644 156.403 368.043C162.538 365.601 168.151 355.909 171.163 350.575C177.334 338.366 176.293 325.143 177.334 312.371C178.486 290.77 178.338 268.757 175.326 247.27L175.141 247.382Z" fill="#5247FF" fill-opacity="0.12"/>
								</g>
								<defs>
									<clipPath id="clip0_2500_29163">
										<rect width="178" height="466" fill="white"/>
									</clipPath>
								</defs>
							</svg>
						</div>
					</div>
				</div>
			</div>
             <!-- مقدار انتخاب‌شده برای سیستم ذخیره -->
<input type="radio" name="s1_q4" value="165" checked style="display:none;">
			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-next-btn"
				data-section="1" data-page="6" data-q="4"
				data-next-section="1" data-next-page="7" data-next-q="5" data-total="8">ادامه</button>
		</div>

		<!-- استایل‌ها و اسکریپت کامل (دقیقاً همان کد کاربر + تنظیمات جدید) -->
		<style>
			/* ====================== WRAPPER ====================== */
			.af-pro-q-height-picker {
				width: 100%;
			
				user-select: none;
			}

			/* ====================== TOGGLE ====================== */
			.af-pro-q-height-toggle {
				display: flex;
				width: fit-content;
				margin: 0 auto 18px;
				background: #F0F0F1;
				border-radius: 999px;
				padding: 4px;
				    border: 1px solid #5247FF;
			}
			.af-pro-q-toggle-btn {
				padding: 8px 22px;
				border: none;
				background: transparent;
				border-radius: 999px;
				font-size: 14px;
				font-weight: 500;
				color: #9B9BA1;
				cursor: pointer;
				transition: all .2s ease;
				font-family: inherit;
			}
			.af-pro-q-toggle-btn.active {
				background: #5247FF;
				color: #FFFFFF;
			}

			/* ====================== STAGE ====================== */
			.af-pro-q-height-stage {
				    position: relative;
    width: 70%;
    height: 290px;
    overflow: hidden;
    cursor: grab;
    touch-action: none;
    margin-left: auto;
    margin-right: auto;
			}
			.af-pro-q-height-stage.dragging { cursor: grabbing; }

			/* big number */
			.af-pro-q-height-display {
				position: absolute;
				top: 60px;
				left: 0;
				right: 0;
				display: flex;
				align-items: baseline;
				justify-content: center;
				gap: 6px;
				pointer-events: none;
				z-index: 4;
				justify-content: center;
			}
			.af-pro-q-height-number {
				font-size: 40px;
				font-weight: 600;
				color: #161618;
				line-height: 1;
				font-variant-numeric: tabular-nums;
			}
			.af-pro-q-height-unit {
				font-size: 18px;
				color: #9B9BA1;
				font-weight: 500;
			}

			/* purple indicator line */
			.af-pro-q-height-line {
				position: absolute;
    width: 70%;
    top: 108px;
    left: 0px;
    height: 3px;
    background: #5247FF;
    z-index: 3;
			}

			/* ruler */
			.af-pro-q-ruler {
				position: absolute;
				top: 0;
				left: 0;
				width: 92px;
				height: 100%;
				overflow: hidden;
				z-index: 2;
			}
			.af-pro-q-ruler-track {
				position: absolute;
				left: 0;
				width: 100%;
				will-change: transform;
			}
			.af-pro-q-tick-row {
				position: absolute;
				left: 0;
				width: 100%;
				display: flex;
				align-items: center;
				gap: 5px;
				    flex-direction: row-reverse;
				height: 1px;
			}
			.af-pro-q-tick-line {
				height: 1px;
				background: #B8B8BC;
			}
			.af-pro-q-tick-row.minor .af-pro-q-tick-line { width: 26px; }
			.af-pro-q-tick-row.major .af-pro-q-tick-line { width: 36px; background: #000000; }
			.af-pro-q-tick-label {
				margin-right: 8px;
				font-size: 16px;
				font-weight: 400;
				color: #000000;
				white-space: nowrap;
				font-variant-numeric: tabular-nums;
			}

			/* silhouette */
			.af-pro-q-silhouette-container {
				position: absolute;
				left: 50%;
				top: 108px;
				transform-origin: top center;
				z-index: 1;
		
				    height: 200px;
				margin-left: -89px;
				transition: none;
			}
			.af-pro-q-silhouette-container svg { width: 100%; height: 100%; display: block; }
			.af-pro-q-silhouette-male, .af-pro-q-silhouette-female { width: 100%; height: 100%; }
			@media (max-width: 767px) {
    .af-pro-q-height-stage {
           width: 100%;
		       height: 60dvh;
    }
	.af-pro-q-silhouette-container{
		    height: unset;
	}
}
		</style>

		<script>
		(function () {
			var MIN_H = 130, MAX_H = 220;
			var LINE_TOP = 108;
			var PX_PER_CM = 42;
			var MINOR_PER_CM = 8;
			var MINOR_PER_INCH = 4;
			var CM_PER_INCH = 2.54;

			var current = 165;
			var isCm = true;
			var gender = 'male';

			var stage   = document.querySelector('.af-pro-q-height-stage');
			var track   = document.querySelector('.af-pro-q-ruler-track');
			var numEl   = document.querySelector('.af-pro-q-height-number');
			var unitEl  = document.querySelector('.af-pro-q-height-unit');
		
			var maleSil = document.querySelector('.af-pro-q-silhouette-male');
			var femaleSil = document.querySelector('.af-pro-q-silhouette-female');
		    var hiddenRadio = document.querySelector('input[name="s1_q4"]');

			var persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
			function toPersian(str) {
				return String(str).replace(/[0-9]/g, function (d) { return persianDigits[d]; });
			}

			function cmToFt(cm) {
				var totalIn = cm / 2.54;
				var feet = Math.floor(totalIn / 12);
				var inches = Math.round(totalIn % 12);
				if (inches === 12) { feet++; inches = 0; }
				return feet + "'" + inches + '"';
			}

			function addTickRow(hcm, isMajor, labelText) {
				var row = document.createElement('div');
				row.className = 'af-pro-q-tick-row ' + (isMajor ? 'major' : 'minor');
				row.style.top = ((MAX_H - hcm) * PX_PER_CM) + 'px';

				var line = document.createElement('div');
				line.className = 'af-pro-q-tick-line';
				row.appendChild(line);

				if (labelText !== null) {
					var label = document.createElement('span');
					label.className = 'af-pro-q-tick-label';
					label.textContent = labelText;
					row.appendChild(label);
				}
				track.appendChild(row);
			}

			// ------------- RULER BUILD -------------
			function buildRuler() {
				track.innerHTML = '';

				if (isCm) {
					var stepCm = 1 / MINOR_PER_CM;
					for (var h = MAX_H; h >= MIN_H - 1e-6; h -= stepCm) {
						var isMajor = Math.abs(h - Math.round(h)) < 1e-6;
						addTickRow(h, isMajor, isMajor ? toPersian(Math.round(h)) : null);
					}
				} else {
					var minIn = MIN_H / CM_PER_INCH;
					var maxIn = MAX_H / CM_PER_INCH;
					var stepIn = 1 / MINOR_PER_INCH;
					// هم‌تراز کردن نقطه‌ی شروع با گرید ۰٫۲۵ اینچی، وگرنه چون
					// MAX_H/CM_PER_INCH عدد صحیح نیست هیچ تیکی دقیقاً روی
					// عدد صحیح اینچ نمی‌افتد و هیچ لیبلی ساخته نمی‌شود.
					var startHi = Math.floor(maxIn / stepIn) * stepIn;
					for (var hi = startHi; hi >= minIn - 1e-6; hi -= stepIn) {
						var isMajorIn = Math.abs(hi - Math.round(hi)) < 1e-6;
						var hcm = hi * CM_PER_INCH;
						addTickRow(hcm, isMajorIn, isMajorIn ? toPersian(Math.round(hi)) : null);
					}
				}
			}

			// ------------- DISPLAY UPDATE -------------
			function updateDisplay() {
    if (isCm) {
        numEl.textContent = toPersian(current.toFixed(1));
        unitEl.textContent = 'cm';
    } else {
        numEl.textContent = cmToFt(current);
        unitEl.textContent = 'ft';
    }

    var offset = (MAX_H - current) * PX_PER_CM;
    track.style.transform = 'translateY(' + (LINE_TOP - offset) + 'px)';
	// ===== این خط جدید =====
    if (hiddenRadio) {
        hiddenRadio.value = current.toFixed(1);
        hiddenRadio.checked = true;
    }
}

			function setGender(g) {
				gender = g;
				maleSil.style.display = g === 'female' ? 'none' : 'block';
				femaleSil.style.display = g === 'female' ? 'block' : 'none';
			}

			// ------------- TOGGLE -------------
			var toggle = document.querySelector('.af-pro-q-height-toggle');
			toggle.addEventListener('click', function (e) {
				var btn = e.target.closest('.af-pro-q-toggle-btn');
				if (!btn) return;
				isCm = btn.classList.contains('cm-btn');
				toggle.querySelectorAll('.af-pro-q-toggle-btn').forEach(function (b) {
					b.classList.toggle('active', b === btn);
				});
				buildRuler();
				updateDisplay();
			});

			// ------------- DRAG TO SCROLL -------------
			var dragging = false, startY = 0, startVal = 0;

			function handleStart(e) {
				dragging = true;
				startY = (e.touches ? e.touches[0].clientY : e.clientY);
				startVal = current;
				stage.classList.add('dragging');
			}
			function handleMove(e) {
				if (!dragging) return;
				var y = (e.touches ? e.touches[0].clientY : e.clientY);
				var deltaCm = (y - startY) / PX_PER_CM;
				var next = startVal + deltaCm;
				next = Math.max(MIN_H, Math.min(MAX_H, next));
				current = Math.round(next * 10) / 10;
				updateDisplay();
			}
			function handleEnd() {
				dragging = false;
				stage.classList.remove('dragging');
			}

			stage.addEventListener('mousedown', handleStart);
			window.addEventListener('mousemove', handleMove);
			window.addEventListener('mouseup', handleEnd);
			stage.addEventListener('touchstart', handleStart, { passive: true });
			stage.addEventListener('touchmove', handleMove, { passive: true });
			stage.addEventListener('touchend', handleEnd);

			buildRuler();
			setGender(gender);
			updateDisplay();
		})();
		</script>
	</div>

	<!-- ========== سوال وزن ========== -->
	<div class="af-pro-q-page" data-page="7" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:62%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۵ از ۸</span>
		</div>
		<div class="af-pro-q-question" data-question="5" data-key="s1_q5">
			<div class="af-pro-q-question-text">وزن فعلی شما چقدر است؟</div>

			<div class="af-pro-q-weight-picker">
				<div class="af-pro-q-weight-toggle">
					<button type="button" class="af-pro-q-weight-toggle-btn lbs-btn">Lbs</button>
					<button type="button" class="af-pro-q-weight-toggle-btn kg-btn active">Kg</button>
				</div>

				<div class="af-pro-q-weight-display">
					<span class="af-pro-q-weight-unit">kg</span>
					<span class="af-pro-q-weight-number">56.3</span>
				</div>

				<div class="af-pro-q-weight-stage">
					<div class="af-pro-q-weight-line"></div>
					<div class="af-pro-q-weight-ruler">
						<div class="af-pro-q-weight-ruler-track"></div>
					</div>
				</div>
			</div>

			<!-- باکس BMI -->
			<div class="af-pro-q-bmi-box">
				<div class="af-pro-q-bmi-row1">BMI فعلی شما :</div>
				<div class="af-pro-q-bmi-row2">
					<span class="af-pro-q-bmi-value">—</span>
					<span class="af-pro-q-bmi-badge">—</span>
				</div>
				<div class="af-pro-q-bmi-row3">در حال دریافت اطلاعات قد...</div>
			</div>

			<input type="radio" name="s1_q5" value="56.3" checked style="display:none;">

			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-next-btn"
				data-section="1" data-page="7" data-q="5"
				data-next-section="1" data-next-page="8" data-next-q="6" data-total="8">ادامه</button>
		</div>

		<style>
			.af-pro-q-weight-picker { width: 100%; user-select: none; }

			.af-pro-q-weight-toggle {
				display: flex; width: fit-content; margin: 0 auto 18px;
				background: #F0F0F1; border-radius: 999px; padding: 4px;
			}
			.af-pro-q-weight-toggle-btn {
				padding: 8px 22px; border: none; background: transparent;
				border-radius: 999px; font-size: 14px; font-weight: 500;
				color: #9B9BA1; cursor: pointer; transition: all .2s ease; font-family: inherit;
			}
			.af-pro-q-weight-toggle-btn.active { background: #5247FF; color: #FFFFFF; }

			.af-pro-q-weight-display {
				display: flex; align-items: baseline; justify-content: center;
				gap: 6px; margin-bottom: 18px;
			}
			.af-pro-q-weight-number {
				font-size: 40px; font-weight: 600; color: #161618;
				line-height: 1; font-variant-numeric: tabular-nums;
			}
			.af-pro-q-weight-unit { font-size: 18px; color: #9B9BA1; font-weight: 500; }

			.af-pro-q-weight-stage {
				position: relative; width: 100%; height: 90px;
				overflow: hidden; cursor: grab; touch-action: none;
			}
			.af-pro-q-weight-stage.dragging { cursor: grabbing; }

			.af-pro-q-weight-line {
				position: absolute; top: 0; left: 50%; width: 3px; height: 40px;
				background: #5247FF; z-index: 3; transform: translateX(-50%);
			}

			.af-pro-q-weight-ruler {
				position: absolute; top: 0; left: 0; width: 100%; height: 100%;
				overflow: hidden; z-index: 2; direction: ltr;
			}
			.af-pro-q-weight-ruler-track {
				position: absolute; top: 0; left: 0; height: 100%;
				will-change: transform; direction: ltr;
			}
			.af-pro-q-w-tick {
				position: absolute; top: 0; width: 1px; height: 100%;
				display: flex; flex-direction: column; align-items: center;
			}
			.af-pro-q-w-tick-line { width: 1px; background: #B8B8BC; }
			.af-pro-q-w-tick.minor .af-pro-q-w-tick-line { height: 16px; }
			.af-pro-q-w-tick.major .af-pro-q-w-tick-line { height: 26px; background: #000000; }
			.af-pro-q-w-tick-label {
				margin-top: 6px; font-size: 14px; font-weight: 400; color: #000000;
				white-space: nowrap; font-variant-numeric: tabular-nums;
			}

			/* BMI Box */
			.af-pro-q-bmi-box {
				margin: 24px 0 28px; padding: 18px 16px;
				background: #FFFFFF; border: 1px solid #F0F0F1;
				border-radius: 24px; text-align: right;
				font-family: 'iranyekan', sans-serif;
			}
			.af-pro-q-bmi-row1 {
				font-size: 16px; font-weight: 400; color: #161618; margin-bottom: 10px;
			}
			.af-pro-q-bmi-row2 {
				display: flex; align-items: center;
				gap: 10px; margin-bottom: 12px;
			}
			.af-pro-q-bmi-value {
				font-size: 16px; font-weight: 500; color: #161618;
				font-variant-numeric: tabular-nums;
			}
			.af-pro-q-bmi-badge {
				display: inline-block; padding: 6px 10px; border-radius: 10000px;
				font-size: 14px; font-weight: 500; line-height: 1;
			}
			.af-pro-q-bmi-badge.underweight { color: #9A5500; background: #F8F3B8; }
			.af-pro-q-bmi-badge.normal      { color: #388E3C; background: #CDF6CF; }
			.af-pro-q-bmi-badge.overweight  { color: #D32F2F; background: #FFCDD2; }
			.af-pro-q-bmi-row3 {
				font-size: 14px; font-weight: 400; color: #65656D; line-height: 1.7;
			}
		</style>

		<script>
		(function () {
			var MIN_W = 30, MAX_W = 200;
			var PX_PER_KG = 44;
			var MINOR_PER_KG = 10;
			var MINOR_PER_LB = 10;
			var KG_PER_LB = 1 / 2.2046226218;

			var current = 56.3;
			var isKg = true;
			var heightCm = null;

			var stage  = document.querySelector('.af-pro-q-weight-stage');
			var track  = document.querySelector('.af-pro-q-weight-ruler-track');
			var numEl  = document.querySelector('.af-pro-q-weight-number');
			var unitEl = document.querySelector('.af-pro-q-weight-unit');
			var hiddenRadio = document.querySelector('input[name="s1_q5"]');

			var bmiValueEl = document.querySelector('.af-pro-q-bmi-value');
			var bmiBadgeEl = document.querySelector('.af-pro-q-bmi-badge');
			var bmiDescEl  = document.querySelector('.af-pro-q-bmi-row3');

			var persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
			function toPersian(str) {
				return String(str).replace(/[0-9]/g, function (d) { return persianDigits[d]; });
			}

			function kgToLb(kg) { return kg / KG_PER_LB; }
			function lbToKg(lb) { return lb * KG_PER_LB; }

			function getLineLeft() {
				return stage ? stage.clientWidth / 2 : 0;
			}

			function addTick(wkg, isMajor, labelText) {
				var col = document.createElement('div');
				col.className = 'af-pro-q-w-tick ' + (isMajor ? 'major' : 'minor');
				col.style.left = (wkg * PX_PER_KG) + 'px';
				var line = document.createElement('div');
				line.className = 'af-pro-q-w-tick-line';
				col.appendChild(line);
				if (labelText !== null) {
					var label = document.createElement('span');
					label.className = 'af-pro-q-w-tick-label';
					label.textContent = labelText;
					col.appendChild(label);
				}
				track.appendChild(col);
			}

			function buildRuler() {
				if (!track) return;
				track.innerHTML = '';
				if (isKg) {
					var stepKg = 1 / MINOR_PER_KG;
					for (var w = MIN_W; w <= MAX_W + 1e-6; w += stepKg) {
						var isMajor = Math.abs(w - Math.round(w)) < 1e-6;
						addTick(w, isMajor, isMajor ? toPersian(Math.round(w)) : null);
					}
				} else {
					var minLb = kgToLb(MIN_W);
					var maxLb = kgToLb(MAX_W);
					var stepLb = 1 / MINOR_PER_LB;
					var startLb = Math.ceil(minLb / stepLb) * stepLb;
					for (var lb = startLb; lb <= maxLb + 1e-6; lb += stepLb) {
						var isMajorLb = Math.abs(lb - Math.round(lb)) < 1e-6;
						addTick(lbToKg(lb), isMajorLb, isMajorLb ? toPersian(Math.round(lb)) : null);
					}
				}
			}

			function updateBMI() {
				if (!heightCm || heightCm <= 0) {
					bmiValueEl.textContent = '—';
					bmiBadgeEl.textContent = '—';
					bmiBadgeEl.className = 'af-pro-q-bmi-badge';
					bmiDescEl.textContent = 'در حال دریافت اطلاعات قد از سرور...';
					return;
				}

				var heightM = heightCm / 100;
				var bmi = current / (heightM * heightM);
				bmi = Math.round(bmi * 10) / 10;

				bmiValueEl.textContent = toPersian(bmi.toFixed(1));

				var category, badgeClass, desc;
				if (bmi < 18.5) {
					category = 'کمبود وزن';
					badgeClass = 'underweight';
					desc = 'شاخص BMI کمبود وزن دارید. ما از شاخص شما برای طراحی برنامه‌های شخصی‌سازی‌شده متناسب با نیازهای شما استفاده خواهیم کرد.';
				} else if (bmi < 25) {
					category = 'نرمال';
					badgeClass = 'normal';
					desc = 'شاخص BMI نرمالی دارید. ما از شاخص شما برای طراحی برنامه‌های شخصی‌سازی‌شده متناسب با نیازهای شما استفاده خواهیم کرد.';
				} else {
					category = 'اضافه وزن';
					badgeClass = 'overweight';
					desc = 'شاخص BMI اضافه وزن دارید. ما از شاخص شما برای طراحی برنامه‌های شخصی‌سازی‌شده متناسب با نیازهای شما استفاده خواهیم کرد.';
				}

				bmiBadgeEl.textContent = category;
				bmiBadgeEl.className = 'af-pro-q-bmi-badge ' + badgeClass;
				bmiDescEl.textContent = desc;
			}

			function updateDisplay() {
				if (!numEl || !unitEl) return;

				if (isKg) {
					numEl.textContent = toPersian(current.toFixed(1));
					unitEl.textContent = 'kg';
				} else {
					numEl.textContent = toPersian(kgToLb(current).toFixed(1));
					unitEl.textContent = 'lb';
				}

				if (stage && track) {
					var lineLeft = getLineLeft();
					var offset = current * PX_PER_KG;
					track.style.transform = 'translateX(' + (lineLeft - offset) + 'px)';
				}

				if (hiddenRadio) {
					hiddenRadio.value = current.toFixed(1);
					hiddenRadio.checked = true;
				}

				updateBMI();
			}

			// Toggle
			var toggle = document.querySelector('.af-pro-q-weight-toggle');
			if (toggle) {
				toggle.addEventListener('click', function (e) {
					var btn = e.target.closest('.af-pro-q-weight-toggle-btn');
					if (!btn) return;
					isKg = btn.classList.contains('kg-btn');
					toggle.querySelectorAll('.af-pro-q-weight-toggle-btn').forEach(function (b) {
						b.classList.toggle('active', b === btn);
					});
					buildRuler();
					updateDisplay();
				});
			}

			// Drag
			var dragging = false, startX = 0, startVal = 0;

			function handleStart(e) {
				dragging = true;
				startX = e.touches ? e.touches[0].clientX : e.clientX;
				startVal = current;
				if (stage) stage.classList.add('dragging');
			}
			function handleMove(e) {
				if (!dragging) return;
				var x = e.touches ? e.touches[0].clientX : e.clientX;
				var deltaPx = x - startX;

				if (isKg) {
					var nextKg = startVal - (deltaPx / PX_PER_KG);
					current = Math.round(Math.max(MIN_W, Math.min(MAX_W, nextKg)) * 10) / 10;
				} else {
					var startLb = kgToLb(startVal);
					var nextLb = startLb - (deltaPx / PX_PER_KG);
					var minLb = kgToLb(MIN_W), maxLb = kgToLb(MAX_W);
					nextLb = Math.max(minLb, Math.min(maxLb, nextLb));
					current = lbToKg(Math.round(nextLb * 10) / 10);
				}
				updateDisplay();
			}
			function handleEnd() {
				dragging = false;
				if (stage) stage.classList.remove('dragging');
			}

			if (stage) {
				stage.addEventListener('mousedown', handleStart);
				stage.addEventListener('touchstart', handleStart, { passive: true });
				stage.addEventListener('touchmove', handleMove, { passive: true });
				stage.addEventListener('touchend', handleEnd);
			}
			window.addEventListener('mousemove', handleMove);
			window.addEventListener('mouseup', handleEnd);
			window.addEventListener('resize', updateDisplay);

			if (window.ResizeObserver && stage) {
				new ResizeObserver(function () { updateDisplay(); }).observe(stage);
			}

			// ========== گرفتن قد از دیتابیس ==========
			function fetchHeightFromDB(callback) {
				if (typeof AFQuestionnaire === 'undefined' || typeof AFQuestionnaire.getAnswers !== 'function') {
					if (callback) callback();
					return;
				}

				AFQuestionnaire.getAnswers(function (answers) {
					if (answers && answers.s1_q4 !== undefined && answers.s1_q4 !== null && answers.s1_q4 !== '') {
						var h = parseFloat(String(answers.s1_q4).replace(/[^\d.]/g, ''));
						if (!isNaN(h) && h > 0) {
							heightCm = h;
						}
					}
					if (callback) callback();
				});
			}

			// وقتی صفحه واقعاً نمایش داده شد، دوباره از دیتابیس بخوان
			function onPageVisible() {
				fetchHeightFromDB(function () {
					buildRuler();
					updateDisplay();
				});
			}

			// تشخیص نمایش شدن صفحه (چون با display:none شروع می‌شود)
			var pageEl = document.querySelector('.af-pro-q-page[data-page="7"]');
			if (pageEl) {
				var observer = new MutationObserver(function (mutations) {
					mutations.forEach(function (m) {
						if (m.attributeName === 'style' || m.type === 'attributes') {
							if (pageEl.style.display !== 'none' && pageEl.offsetParent !== null) {
								onPageVisible();
							}
						}
					});
				});
				observer.observe(pageEl, { attributes: true, attributeFilter: ['style', 'class'] });
			}

			// بار اول هم تلاش کن
			buildRuler();
			fetchHeightFromDB(function () {
				updateDisplay();
			});

			// اگر بعد از ۱ ثانیه هنوز قد نیامد، دوباره تلاش کن (برای اطمینان)
			setTimeout(function () {
				if (!heightCm) {
					fetchHeightFromDB(function () {
						updateDisplay();
					});
				}
			}, 1200);
		})();
		</script>
	</div>

		<!-- ========== صفحه ۴ : متن ========== -->
	<div class="af-pro-q-page" data-page="8" style="display:none;">
		<div class="af-pro-q-text-page">
			<!-- تصویر وسط‌چین بر اساس جنسیت -->
			<div class="af-pro-q-gender-image-wrap">
				<img src="" alt="" class="af-pro-q-gender-image" id="af-pro-q-page8-gender-img">
			</div>

			<p>بر اساس اطلاعات شما، نرخ متابولیسم پایه‌تان (BMR)‌ رو محاسبه می‌کنیم، یعنی کالری‌ای که بدن‌تون در حالت استراحت می‌سوزونه. عضله و وزن بیشتر، یعنی BMR بالاتر.</p>
		</div>
		<div class="af-pro-q-page-actions">
			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-text-next"
				data-next-section="1" data-next-page="9" data-next-q="6">ادامه <img src="http://6tofit.com/wp-content/uploads/2026/09/Left-Arrow.png" alt="" class="af-pro-q-btn-icon"></button>
		</div>

		<style>
			.af-pro-q-gender-image-wrap {
				display: flex;
				justify-content: center;
				margin-bottom: 24px;
			}
			.af-pro-q-gender-image {
				width: 240px;
		
				object-fit: contain;
				border-radius: 24px;
			}
		</style>

		<script>
		(function () {
			var imgEl = document.getElementById('af-pro-q-page8-gender-img');
			if (!imgEl) return;

			var MALE_IMG   = 'http://6tofit.com/wp-content/uploads/2026/09/dreamstime-271020657-1m.png';
			var FEMALE_IMG = 'http://6tofit.com/wp-content/uploads/2026/09/dreamstime-271020657-1.png';
			var OTHER_IMG  = 'http://6tofit.com/wp-content/uploads/2026/09/dreamstime-271020657-1m.png'; // در صورت نیاز تغییر بده

			function setGenderImage(gender) {
				if (gender === 'female') {
					imgEl.src = FEMALE_IMG;
				} else if (gender === 'other') {
					imgEl.src = OTHER_IMG;
				} else {
					imgEl.src = MALE_IMG; // پیش‌فرض مرد
				}
			}

			function loadGenderFromDB() {
				if (typeof AFQuestionnaire === 'undefined' || typeof AFQuestionnaire.getAnswers !== 'function') {
					setGenderImage('male');
					return;
				}

				AFQuestionnaire.getAnswers(function (answers) {
					var gender = (answers && answers.s1_gender) ? answers.s1_gender : 'male';
					setGenderImage(gender);
				});
			}

			// وقتی صفحه نمایش داده شد، جنسیت را از دیتابیس بخوان
			var pageEl = document.querySelector('.af-pro-q-page[data-page="8"]');
			if (pageEl) {
				var observer = new MutationObserver(function (mutations) {
					mutations.forEach(function (m) {
						if (pageEl.style.display !== 'none') {
							loadGenderFromDB();
						}
					});
				});
				observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });
			}

			// بار اول هم تلاش کن
			loadGenderFromDB();
		})();
		</script>
	</div>

		<!-- ========== سوال ۶ : وزن هدف ========== -->
	<div class="af-pro-q-page" data-page="9" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:75%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۶ از ۸</span>
		</div>
		<div class="af-pro-q-question" data-question="6" data-key="s1_q6">
			<div class="af-pro-q-question-text">وزن هدف شما چقدر است؟</div>

			<div class="af-pro-q-weight-picker">
				<div class="af-pro-q-weight-toggle">
					<button type="button" class="af-pro-q-weight-toggle-btn lbs-btn">Lbs</button>
					<button type="button" class="af-pro-q-weight-toggle-btn kg-btn active">Kg</button>
				</div>

				<div class="af-pro-q-weight-display">
					<span class="af-pro-q-weight-unit">kg</span>
					<span class="af-pro-q-weight-number">50.0</span>
				</div>

				<div class="af-pro-q-weight-stage">
					<div class="af-pro-q-weight-line"></div>
					<div class="af-pro-q-weight-ruler">
						<div class="af-pro-q-weight-ruler-track"></div>
					</div>
				</div>
			</div>

			<!-- باکس درصد تغییر وزن -->
			<div class="af-pro-q-bmi-box af-pro-q-goal-box">
				<div class="af-pro-q-bmi-row1">
	شما <span class="af-pro-q-goal-percent">۰</span>٪ از وزن خود را از دست خواهید داد.
</div>
				<div class="af-pro-q-bmi-row2">
					<span class="af-pro-q-bmi-badge">هدف معقول</span>
				</div>
				<div class="af-pro-q-bmi-row3">
					برای بیشتر افراد، کاهش وزن در محدوده 0.5 تا 1 کیلوگرم در هفته یک هدف ایمن و منطقی به حساب میاد.
				</div>
			</div>

			<input type="radio" name="s1_q6" value="50.0" checked style="display:none;">

			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-next-btn"
				data-section="1" data-page="9" data-q="6"
				data-next-section="1" data-next-page="10" data-next-q="0" data-total="8">ادامه</button>
		</div>

		<style>
			.af-pro-q-weight-picker { width: 100%; user-select: none; }

			.af-pro-q-weight-toggle {
				display: flex; width: fit-content; margin: 0 auto 18px;
				background: #F0F0F1; border-radius: 999px; padding: 4px;
			}
			.af-pro-q-weight-toggle-btn {
				padding: 8px 22px; border: none; background: transparent;
				border-radius: 999px; font-size: 14px; font-weight: 500;
				color: #9B9BA1; cursor: pointer; transition: all .2s ease; font-family: inherit;
			}
			.af-pro-q-weight-toggle-btn.active { background: #5247FF; color: #FFFFFF; }

			.af-pro-q-weight-display {
				display: flex; align-items: baseline; justify-content: center;
				gap: 6px; margin-bottom: 18px;
			}
			.af-pro-q-weight-number {
				font-size: 40px; font-weight: 600; color: #161618;
				line-height: 1; font-variant-numeric: tabular-nums;
			}
			.af-pro-q-weight-unit { font-size: 18px; color: #9B9BA1; font-weight: 500; }

			.af-pro-q-weight-stage {
				position: relative; width: 100%; height: 90px;
				overflow: hidden; cursor: grab; touch-action: none;
			}
			.af-pro-q-weight-stage.dragging { cursor: grabbing; }

			.af-pro-q-weight-line {
				position: absolute; top: 0; left: 50%; width: 3px; height: 40px;
				background: #5247FF; z-index: 3; transform: translateX(-50%);
			}
			.af-pro-q-goal-percent {
	font-weight: 600;
	transition: color 0.2s ease;
}
.af-pro-q-goal-percent.reasonable {
	color: #388E3C;
}
.af-pro-q-goal-percent.achievable {
	color: #9A5500;
}
.af-pro-q-goal-percent.challenging {
	color: #D32F2F;
}

			.af-pro-q-weight-ruler {
				position: absolute; top: 0; left: 0; width: 100%; height: 100%;
				overflow: hidden; z-index: 2; direction: ltr;
			}
			.af-pro-q-weight-ruler-track {
				position: absolute; top: 0; left: 0; height: 100%;
				will-change: transform; direction: ltr;
			}
			.af-pro-q-w-tick {
				position: absolute; top: 0; width: 1px; height: 100%;
				display: flex; flex-direction: column; align-items: center;
			}
			.af-pro-q-w-tick-line { width: 1px; background: #B8B8BC; }
			.af-pro-q-w-tick.minor .af-pro-q-w-tick-line { height: 16px; }
			.af-pro-q-w-tick.major .af-pro-q-w-tick-line { height: 26px; background: #000000; }
			.af-pro-q-w-tick-label {
				margin-top: 6px; font-size: 14px; font-weight: 400; color: #000000;
				white-space: nowrap; font-variant-numeric: tabular-nums;
			}

			/* Goal Box (همان ظاهر BMI) */
			.af-pro-q-bmi-box {
				margin: 24px 0 28px; padding: 18px 16px;
				background: #FFFFFF; border: 1px solid #F0F0F1;
				border-radius: 24px; text-align: right;
				font-family: 'iranyekan', sans-serif;
			}
			.af-pro-q-bmi-row1 {
				font-size: 16px; font-weight: 400; color: #161618; margin-bottom: 10px;
			}
			.af-pro-q-goal-percent {
				font-weight: 600;
			}
			.af-pro-q-bmi-row2 {
				display: flex; align-items: center;
				gap: 10px; margin-bottom: 12px;
			}
			.af-pro-q-bmi-badge {
				display: inline-block; padding: 6px 10px; border-radius: 10000px;
				font-size: 14px; font-weight: 500; line-height: 1;
			}
			/* سه حالت هدف */
			.af-pro-q-bmi-badge.reasonable {
				color: #388E3C; background: #CDF6CF;
			}
			.af-pro-q-bmi-badge.achievable {
				color: #9A5500; background: #F8F3B8;
			}
			.af-pro-q-bmi-badge.challenging {
				color: #D32F2F; background: #FFCDD2;
			}
			.af-pro-q-bmi-row3 {
				font-size: 14px; font-weight: 400; color: #65656D; line-height: 1.7;
			}

			/* رنگ درصد در متن ردیف اول */
			.af-pro-q-goal-percent.reasonable { color: #388E3C; }
			.af-pro-q-goal-percent.achievable { color: #9A5500; }
			.af-pro-q-goal-percent.challenging { color: #D32F2F; }
		</style>

		<script>
		(function () {
			var MIN_W = 30, MAX_W = 200;
			var PX_PER_KG = 44;
			var MINOR_PER_KG = 10;
			var MINOR_PER_LB = 10;
			var KG_PER_LB = 1 / 2.2046226218;

			var current = 50.0;          // وزن هدف (همیشه به کیلوگرم)
			var isKg = true;
			var currentWeight = null;   // وزن فعلی از سوال قبلی (s1_q5)

			var stage  = document.querySelector('.af-pro-q-page[data-page="9"] .af-pro-q-weight-stage');
			var track  = document.querySelector('.af-pro-q-page[data-page="9"] .af-pro-q-weight-ruler-track');
			var numEl  = document.querySelector('.af-pro-q-page[data-page="9"] .af-pro-q-weight-number');
			var unitEl = document.querySelector('.af-pro-q-page[data-page="9"] .af-pro-q-weight-unit');
			var hiddenRadio = document.querySelector('.af-pro-q-page[data-page="9"] input[name="s1_q6"]');

			var percentEl = document.querySelector('.af-pro-q-page[data-page="9"] .af-pro-q-goal-percent');
			var badgeEl   = document.querySelector('.af-pro-q-page[data-page="9"] .af-pro-q-bmi-badge');
			var descEl    = document.querySelector('.af-pro-q-page[data-page="9"] .af-pro-q-bmi-row3');

			var persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
			function toPersian(str) {
				return String(str).replace(/[0-9]/g, function (d) { return persianDigits[d]; });
			}

			function kgToLb(kg) { return kg / KG_PER_LB; }
			function lbToKg(lb) { return lb * KG_PER_LB; }

			function getLineLeft() {
				return stage ? stage.clientWidth / 2 : 0;
			}

			function addTick(wkg, isMajor, labelText) {
				var col = document.createElement('div');
				col.className = 'af-pro-q-w-tick ' + (isMajor ? 'major' : 'minor');
				col.style.left = (wkg * PX_PER_KG) + 'px';
				var line = document.createElement('div');
				line.className = 'af-pro-q-w-tick-line';
				col.appendChild(line);
				if (labelText !== null) {
					var label = document.createElement('span');
					label.className = 'af-pro-q-w-tick-label';
					label.textContent = labelText;
					col.appendChild(label);
				}
				track.appendChild(col);
			}

			function buildRuler() {
				if (!track) return;
				track.innerHTML = '';
				if (isKg) {
					var stepKg = 1 / MINOR_PER_KG;
					for (var w = MIN_W; w <= MAX_W + 1e-6; w += stepKg) {
						var isMajor = Math.abs(w - Math.round(w)) < 1e-6;
						addTick(w, isMajor, isMajor ? toPersian(Math.round(w)) : null);
					}
				} else {
					var minLb = kgToLb(MIN_W);
					var maxLb = kgToLb(MAX_W);
					var stepLb = 1 / MINOR_PER_LB;
					var startLb = Math.ceil(minLb / stepLb) * stepLb;
					for (var lb = startLb; lb <= maxLb + 1e-6; lb += stepLb) {
						var isMajorLb = Math.abs(lb - Math.round(lb)) < 1e-6;
						addTick(lbToKg(lb), isMajorLb, isMajorLb ? toPersian(Math.round(lb)) : null);
					}
				}
			}

			function updateGoalBox() {
				if (!currentWeight || currentWeight <= 0) {
					percentEl.textContent = '۰';
					percentEl.className = 'af-pro-q-goal-percent';
					badgeEl.textContent = '—';
					badgeEl.className = 'af-pro-q-bmi-badge';
					descEl.textContent = 'در حال دریافت وزن فعلی...';
					return;
				}

				// درصد کاهش وزن (اگر هدف کمتر از وزن فعلی باشد)
				var diff = currentWeight - current;
				var percent = (diff / currentWeight) * 100;
				percent = Math.max(0, Math.round(percent * 10) / 10); // فقط کاهش را نشان می‌دهیم

				percentEl.textContent = toPersian(percent.toFixed(1));

				var badgeClass, title, desc;

				if (percent < 9.9) {
					badgeClass = 'reasonable';
					title = 'هدف معقول';
					desc = 'برای بیشتر افراد، کاهش وزن در محدوده 0.5 تا 1 کیلوگرم در هفته یک هدف ایمن و منطقی به حساب میاد.';
				} else if (percent < 19.9) {
					badgeClass = 'achievable';
					title = 'هدف دست‌یافتنی';
					desc = 'شواهد علمی نشون می‌دن که کاهش وزن به‌اندازهٔ ۱۰٪ یا بیشتر، می‌تونه تأثیر چشم‌گیری در بهبود برخی از شرایط مرتبط با وزن داشته باشه.';
				} else {
					badgeClass = 'challenging';
					title = 'هدف چالشی';
					desc = 'شواهد علمی نشون می‌دن که کاهش وزن به‌اندازهٔ ۱۰٪ یا بیشتر، می‌تونه تأثیر چشم‌گیری در بهبود برخی از شرایط مرتبط با وزن داشته باشه.';
				}

				percentEl.className = 'af-pro-q-goal-percent ' + badgeClass;
				badgeEl.textContent = title;
				badgeEl.className = 'af-pro-q-bmi-badge ' + badgeClass;
				descEl.textContent = desc;
			}

			function updateDisplay() {
				if (!numEl || !unitEl) return;

				if (isKg) {
					numEl.textContent = toPersian(current.toFixed(1));
					unitEl.textContent = 'kg';
				} else {
					numEl.textContent = toPersian(kgToLb(current).toFixed(1));
					unitEl.textContent = 'lb';
				}

				if (stage && track) {
					var lineLeft = getLineLeft();
					var offset = current * PX_PER_KG;
					track.style.transform = 'translateX(' + (lineLeft - offset) + 'px)';
				}

				if (hiddenRadio) {
					hiddenRadio.value = current.toFixed(1);
					hiddenRadio.checked = true;
				}

				updateGoalBox();
			}

			// Toggle
			var toggle = document.querySelector('.af-pro-q-page[data-page="9"] .af-pro-q-weight-toggle');
			if (toggle) {
				toggle.addEventListener('click', function (e) {
					var btn = e.target.closest('.af-pro-q-weight-toggle-btn');
					if (!btn) return;
					isKg = btn.classList.contains('kg-btn');
					toggle.querySelectorAll('.af-pro-q-weight-toggle-btn').forEach(function (b) {
						b.classList.toggle('active', b === btn);
					});
					buildRuler();
					updateDisplay();
				});
			}

			// Drag
			var dragging = false, startX = 0, startVal = 0;

			function handleStart(e) {
				dragging = true;
				startX = e.touches ? e.touches[0].clientX : e.clientX;
				startVal = current;
				if (stage) stage.classList.add('dragging');
			}
			function handleMove(e) {
				if (!dragging) return;
				var x = e.touches ? e.touches[0].clientX : e.clientX;
				var deltaPx = x - startX;

				if (isKg) {
					var nextKg = startVal - (deltaPx / PX_PER_KG);
					current = Math.round(Math.max(MIN_W, Math.min(MAX_W, nextKg)) * 10) / 10;
				} else {
					var startLb = kgToLb(startVal);
					var nextLb = startLb - (deltaPx / PX_PER_KG);
					var minLb = kgToLb(MIN_W), maxLb = kgToLb(MAX_W);
					nextLb = Math.max(minLb, Math.min(maxLb, nextLb));
					current = lbToKg(Math.round(nextLb * 10) / 10);
				}
				updateDisplay();
			}
			function handleEnd() {
				dragging = false;
				if (stage) stage.classList.remove('dragging');
			}

			if (stage) {
				stage.addEventListener('mousedown', handleStart);
				stage.addEventListener('touchstart', handleStart, { passive: true });
				stage.addEventListener('touchmove', handleMove, { passive: true });
				stage.addEventListener('touchend', handleEnd);
			}
			window.addEventListener('mousemove', handleMove);
			window.addEventListener('mouseup', handleEnd);
			window.addEventListener('resize', updateDisplay);

			if (window.ResizeObserver && stage) {
				new ResizeObserver(function () { updateDisplay(); }).observe(stage);
			}

			// ========== گرفتن وزن فعلی از دیتابیس (s1_q5) ==========
			function fetchCurrentWeightFromDB(callback) {
				if (typeof AFQuestionnaire === 'undefined' || typeof AFQuestionnaire.getAnswers !== 'function') {
					if (callback) callback();
					return;
				}

				AFQuestionnaire.getAnswers(function (answers) {
					if (answers && answers.s1_q5 !== undefined && answers.s1_q5 !== null && answers.s1_q5 !== '') {
						var w = parseFloat(String(answers.s1_q5).replace(/[^\d.]/g, ''));
						if (!isNaN(w) && w > 0) {
							currentWeight = w;
							// مقدار پیش‌فرض وزن هدف را کمی کمتر از وزن فعلی بگذار
							if (current >= currentWeight) {
								current = Math.max(MIN_W, Math.round((currentWeight * 0.95) * 10) / 10);
							}
						}
					}
					if (callback) callback();
				});
			}

			function onPageVisible() {
				fetchCurrentWeightFromDB(function () {
					buildRuler();
					updateDisplay();
				});
			}

			var pageEl = document.querySelector('.af-pro-q-page[data-page="9"]');
			if (pageEl) {
				var observer = new MutationObserver(function (mutations) {
					mutations.forEach(function (m) {
						if (pageEl.style.display !== 'none') {
							onPageVisible();
						}
					});
				});
				observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });
			}

			buildRuler();
			fetchCurrentWeightFromDB(function () {
				updateDisplay();
			});

			setTimeout(function () {
				if (!currentWeight) {
					fetchCurrentWeightFromDB(function () {
						updateDisplay();
					});
				}
			}, 1200);
		})();
		</script>
	</div>

	<!-- ========== صفحه ۵ : متن ========== -->
	<div class="af-pro-q-page" data-page="10" style="display:none;">
		<div class="af-pro-q-text-page">
			<!-- تصویر بر اساس جنسیت -->
			<div class="af-pro-q-gender-image-wrap">
				<img src="" alt="" class="af-pro-q-gender-image" id="af-pro-q-page10-gender-img">
			</div>

			<p>
				کم کردن <span class="af-pro-q-kg-diff" id="af-pro-q-page10-kg-diff">۱</span> کیلو کاملاً دست‌یافتنیه.<br>
				تو از پسش برمیای!
			</p>
		</div>
		<div class="af-pro-q-page-actions">
			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-text-next"
				data-next-section="1" data-next-page="11" data-next-q="7">ادامه <img src="http://6tofit.com/wp-content/uploads/2026/09/Left-Arrow.png" alt="" class="af-pro-q-btn-icon"></button>
		</div>

		<style>
			.af-pro-q-gender-image-wrap {
				display: flex;
				justify-content: center;
				margin-bottom: 24px;
			}
			.af-pro-q-gender-image {
				width: 240px;
		
				object-fit: contain;
				border-radius: 24px;
			}
			.af-pro-q-kg-diff {
				color: #5247FF;
				font-weight: 600;
			}
		</style>

		<script>
		(function () {
			var imgEl = document.getElementById('af-pro-q-page10-gender-img');
			var kgEl  = document.getElementById('af-pro-q-page10-kg-diff');

			var MALE_IMG   = 'http://6tofit.com/wp-content/uploads/2026/09/man.png';
			var FEMALE_IMG = 'http://6tofit.com/wp-content/uploads/2026/09/fem.png';
			var OTHER_IMG  = 'http://6tofit.com/wp-content/uploads/2026/09/man.png';

			var persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
			function toPersian(str) {
				return String(str).replace(/[0-9]/g, function (d) { return persianDigits[d]; });
			}

			function setGenderImage(gender) {
				if (!imgEl) return;
				if (gender === 'female') {
					imgEl.src = FEMALE_IMG;
				} else if (gender === 'other') {
					imgEl.src = OTHER_IMG;
				} else {
					imgEl.src = MALE_IMG;
				}
			}

			function updateKgDiff(answers) {
				if (!kgEl) return;

				var currentW = answers && answers.s1_q5 ? parseFloat(String(answers.s1_q5).replace(/[^\d.]/g, '')) : null;
				var targetW  = answers && answers.s1_q6 ? parseFloat(String(answers.s1_q6).replace(/[^\d.]/g, '')) : null;

				if (!currentW || !targetW || currentW <= 0) {
					kgEl.textContent = toPersian('1');
					return;
				}

				var diff = Math.max(0, currentW - targetW);
				diff = Math.round(diff * 10) / 10; // یک رقم اعشار

				// اگر عدد صحیح بود بدون اعشار نشان بده
				var display = (diff % 1 === 0) ? diff.toFixed(0) : diff.toFixed(1);
				kgEl.textContent = toPersian(display);
			}

			function loadDataFromDB() {
				if (typeof AFQuestionnaire === 'undefined' || typeof AFQuestionnaire.getAnswers !== 'function') {
					setGenderImage('male');
					if (kgEl) kgEl.textContent = toPersian('1');
					return;
				}

				AFQuestionnaire.getAnswers(function (answers) {
					var gender = (answers && answers.s1_gender) ? answers.s1_gender : 'male';
					setGenderImage(gender);
					updateKgDiff(answers);
				});
			}

			// وقتی صفحه نمایش داده شد
			var pageEl = document.querySelector('.af-pro-q-page[data-page="10"]');
			if (pageEl) {
				var observer = new MutationObserver(function () {
					if (pageEl.style.display !== 'none') {
						loadDataFromDB();
					}
				});
				observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });
			}

			// بار اول
			loadDataFromDB();
		})();
		</script>
	</div>

	<!-- ========== سوال ۷ ========== -->
	<div class="af-pro-q-page" data-page="11" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:87.5%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۷ از ۸</span>
		</div>
		<div class="af-pro-q-question" data-question="7" data-key="s1_q7">
			<div class="af-pro-q-question-text">سطح فعالیت شما چقدره؟</div>
			<div class="af-pro-q-options af-pro-q-options-activity">
				<label class="af-pro-q-option af-pro-q-option-activity">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/one-bar.png" alt="" class="af-pro-q-option-icon">
					<div class="af-pro-q-option-content">
						<span class="af-pro-q-option-title">کم‌تحرک</span>
						<span class="af-pro-q-option-desc">من بیشتر روز نشسته‌ام.</span>
					</div>
					<input type="radio" name="s1_q7" value="sedentary">
				</label>

				<label class="af-pro-q-option af-pro-q-option-activity">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/two-bars2.png" alt="" class="af-pro-q-option-icon">
					<div class="af-pro-q-option-content">
						<span class="af-pro-q-option-title">فعالیت سبک</span>
						<span class="af-pro-q-option-desc">ورزش کردن را به یک عادت همیشگی تبدیل کرده‌ام.</span>
					</div>
					<input type="radio" name="s1_q7" value="light">
				</label>

				<label class="af-pro-q-option af-pro-q-option-activity">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/three-bar3.png" alt="" class="af-pro-q-option-icon">
					<div class="af-pro-q-option-content">
						<span class="af-pro-q-option-title">فعالیت متوسط</span>
						<span class="af-pro-q-option-desc">من بیشتر روز را ایستاده‌ام و در طول روز حرکت می‌کنم.</span>
					</div>
					<input type="radio" name="s1_q7" value="moderate">
				</label>

				<label class="af-pro-q-option af-pro-q-option-activity">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/four-bar4.png" alt="" class="af-pro-q-option-icon">
					<div class="af-pro-q-option-content">
						<span class="af-pro-q-option-title">بسیار فعال</span>
						<span class="af-pro-q-option-desc">اکثر روزهایم را به انجام فعالیت‌های بدنی اختصاص می‌دهم.</span>
					</div>
					<input type="radio" name="s1_q7" value="very_active">
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="1" data-page="11" data-q="7"
				data-next-section="1" data-next-page="12" data-next-q="0" data-total="8">ادامه</button>
		</div>

		<style>
			.af-pro-q-options-activity {
				display: flex;
				flex-direction: column;
				gap: 12px;
				margin-bottom: 28px;
			}
			.af-pro-q-option-activity {
				display: flex;
				align-items: flex-start;
				gap: 14px;
				padding: 16px;
				background: #ffffff;
				border-radius: 16px;
				cursor: pointer;
				border: 1px solid transparent;
				transition: border-color 0.2s, background 0.2s;
			}
			.af-pro-q-option-activity:hover,
			.af-pro-q-option-activity.selected {
				border-color: #5247FF;
			}
			.af-pro-q-option-activity input {
				display: none;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
				border-radius: 12px;
			}
			.af-pro-q-option-content {
				display: flex;
				flex-direction: column;
				gap: 4px;
				flex: 1;
			}
			.af-pro-q-option-title {
				font-size: 16px;
				font-weight: 500;
				color: #161618;
				line-height: 1.4;
			}
			.af-pro-q-option-desc {
				font-size: 12px;
				font-weight: 400;
				color: #65656D;
				line-height: 1.5;
			}
		</style>
	</div>

	<!-- ========== صفحه ۶ : متن ========== -->
	<div class="af-pro-q-page" data-page="12" style="display:none;">
		<div class="af-pro-q-text-page">
			<!-- تصویر بر اساس جنسیت -->
			<div class="af-pro-q-gender-image-wrap">
				<img src="" alt="" class="af-pro-q-gender-image" id="af-pro-q-page12-gender-img">
			</div>

			<p>فعالیت‌های روزمره (Neat) مثل راه رفتن، کارهای خانه یا بازی با بچه‌ها، نقش زیادی در کالری‌سوزی شما دارند. هرچه تحرک‌تان بیشتر، مصرف کالری‌تان هم بالاتر.</p>
		</div>
		<div class="af-pro-q-page-actions">
			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-text-next"
				data-next-section="1" data-next-page="13" data-next-q="8">ادامه <img src="http://6tofit.com/wp-content/uploads/2026/09/Left-Arrow.png" alt="" class="af-pro-q-btn-icon"></button>
		</div>

		<style>
			.af-pro-q-gender-image-wrap {
				display: flex;
				justify-content: center;
				margin-bottom: 24px;
			}
			.af-pro-q-gender-image {
				width: 240px;
	
				object-fit: contain;
				border-radius: 24px;
			}
		</style>

		<script>
		(function () {
			var imgEl = document.getElementById('af-pro-q-page12-gender-img');
			if (!imgEl) return;

			var MALE_IMG   = 'http://6tofit.com/wp-content/uploads/2026/09/neatman.png';
			var FEMALE_IMG = 'http://6tofit.com/wp-content/uploads/2026/09/neatfem.png';
			var OTHER_IMG  = 'http://6tofit.com/wp-content/uploads/2026/09/neatman.png';

			function setGenderImage(gender) {
				if (gender === 'female') {
					imgEl.src = FEMALE_IMG;
				} else if (gender === 'other') {
					imgEl.src = OTHER_IMG;
				} else {
					imgEl.src = MALE_IMG;
				}
			}

			function loadGenderFromDB() {
				if (typeof AFQuestionnaire === 'undefined' || typeof AFQuestionnaire.getAnswers !== 'function') {
					setGenderImage('male');
					return;
				}

				AFQuestionnaire.getAnswers(function (answers) {
					var gender = (answers && answers.s1_gender) ? answers.s1_gender : 'male';
					setGenderImage(gender);
				});
			}

			var pageEl = document.querySelector('.af-pro-q-page[data-page="12"]');
			if (pageEl) {
				var observer = new MutationObserver(function () {
					if (pageEl.style.display !== 'none') {
						loadGenderFromDB();
					}
				});
				observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });
			}

			loadGenderFromDB();
		})();
		</script>
	</div>

	<!-- ========== سوال ۸ ========== -->
	<div class="af-pro-q-page" data-page="13" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:100%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۸ از ۸</span>
		</div>
		<div class="af-pro-q-question" data-question="8" data-key="s1_q8">
			<div class="af-pro-q-question-text">آیا دچار بیماری خاصی هستید؟</div>

			<div class="af-pro-q-options af-pro-q-options-multi">
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/🚫-No-Entry.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">من هیچ بیماری خاصی ندارم.</span>
					<input type="checkbox" name="s1_q8" value="none">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/🩸-Drop-Of-Blood.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">فشار خون بالا</span>
					<input type="checkbox" name="s1_q8" value="high_blood_pressure">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/cholesterol.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">کلسترول بالا</span>
					<input type="checkbox" name="s1_q8" value="high_cholesterol">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/Mechanical-scale-balance-1-Iconly-Pro.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">اضافه وزن بالا</span>
					<input type="checkbox" name="s1_q8" value="obesity">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/💉-Syringe.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">دیابت</span>
					<input type="checkbox" name="s1_q8" value="diabetes">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/galb.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">مشکل قلب</span>
					<input type="checkbox" name="s1_q8" value="heart">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/🧬-Dna.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">سرطان</span>
					<input type="checkbox" name="s1_q8" value="cancer">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/riye.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">مشکل ریه</span>
					<input type="checkbox" name="s1_q8" value="lung">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/💊-Pill-1.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">مشکل تیروئید</span>
					<input type="checkbox" name="s1_q8" value="thyroid">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/mede.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">مشکل معده</span>
					<input type="checkbox" name="s1_q8" value="stomach">
				</label>
			</div>

			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn af-pro-q-multi-next"
				data-section="1" data-page="13" data-q="8"
				data-next-section="2" data-next-page="1" data-next-q="0" data-total="8"> تایید  </button>
		</div>

		<style>
			.af-pro-q-options-multi {
				display: flex;
				flex-direction: column;
				gap: 10px;
				margin-bottom: 28px;
				max-height: 340px;          /* حدود ۵ گزینه */
				overflow-y: auto;
				padding-left: 4px;
				padding-right: 4px;
			}
			.af-pro-q-option-multi {
				display: flex;
				align-items: center;
				gap: 14px;
				padding: 14px 16px;
				background: #ffffff;
				border-radius: 14px;
				cursor: pointer;
				border: 1px solid transparent;
				transition: border-color 0.2s, background 0.2s;
				flex-shrink: 0;
			}
			.af-pro-q-option-multi:hover {
				border-color: rgba(82, 71, 255, 0.35);
			}
			.af-pro-q-option-multi.selected {
				border-color: #5247FF;
		
			}
			.af-pro-q-option-multi input {
				display: none;
			}
			.af-pro-q-option-icon {
				width: 40px;
				height: 40px;
				object-fit: contain;
				flex-shrink: 0;
				border-radius: 10px;
			}
			.af-pro-q-option-title {
				font-size: 15px;
				font-weight: 500;
				color: #161618;
				line-height: 1.4;
			}
			@media (max-width: 767px) {
    .af-pro-q-options-multi {
            max-height: 540px;
    }
}
		</style>

		<script>
		(function () {
			var page = document.querySelector('.af-pro-q-page[data-page="13"]');
			if (!page) return;

			var options = page.querySelectorAll('.af-pro-q-option-multi');
			var nextBtn = page.querySelector('.af-pro-q-multi-next');

			function getSelectedValues() {
				var values = [];
				options.forEach(function (opt) {
					var input = opt.querySelector('input[type="checkbox"]');
					if (input && input.checked) {
						values.push(input.value);
					}
				});
				return values;
			}

			function updateButtonState() {
				var selected = getSelectedValues();
				if (selected.length > 0) {
					nextBtn.classList.remove('af-pro-q-btn-inactive');
					nextBtn.classList.add('af-pro-q-btn-active');
				} else {
					nextBtn.classList.add('af-pro-q-btn-inactive');
					nextBtn.classList.remove('af-pro-q-btn-active');
				}
			}

			// انتخاب / لغو انتخاب
			options.forEach(function (opt) {
				opt.addEventListener('click', function (e) {
					e.preventDefault();
					var input = opt.querySelector('input[type="checkbox"]');
					if (!input) return;

					// اگر «هیچ بیماری ندارم» انتخاب شد، بقیه را پاک کن
					if (input.value === 'none') {
						options.forEach(function (o) {
							var i = o.querySelector('input');
							if (i && i.value !== 'none') {
								i.checked = false;
								o.classList.remove('selected');
							}
						});
						input.checked = !input.checked;
						opt.classList.toggle('selected', input.checked);
					} else {
						// اگر بیماری انتخاب شد، گزینه «هیچ» را بردار
						var noneOpt = page.querySelector('input[value="none"]');
						if (noneOpt) {
							noneOpt.checked = false;
							noneOpt.closest('.af-pro-q-option-multi').classList.remove('selected');
						}
						input.checked = !input.checked;
						opt.classList.toggle('selected', input.checked);
					}
					updateButtonState();
				});
			});

			// ذخیره چندگزینه‌ای
			nextBtn.addEventListener('click', function (e) {
				if (nextBtn.classList.contains('af-pro-q-btn-inactive')) return;
				e.stopImmediatePropagation(); // جلوگیری از listener عمومی رادیو

				var selected = getSelectedValues();
				if (selected.length === 0) return;

				var answer = selected.join(','); // ذخیره به صورت رشته جدا شده با کاما

				if (typeof AFQuestionnaire !== 'undefined' && AFQuestionnaire.saveAndGo) {
					AFQuestionnaire.saveAndGo({
						section: 1,
						page: 13,
						question_key: 's1_q8',
						question_number: 8,
						answer: answer,
						next_section: 2,
						next_page: 1,
						next_question: 0
					});
				}
			}, true);
		})();
		</script>
	</div>

	<style>
	/* دکمه‌ها و صفحات متنی مشترک بخش اول */
	.af-pro-q-text-page {
		color: #161618;
		font-size: 20px;
		line-height: 1.9;
		text-align: center;
		padding: 20px 10px 40px;
		font-family: 'iranyekan', sans-serif;
	}
	.af-pro-q-page-actions {
		display: flex;
		justify-content: center;
		padding-bottom: 10px;
	}
	.af-pro-q-btn {
		border: none;
		border-radius: 1000000px;
		padding: 12px 10px;
		font-size: 18px;
		font-family: 'iranyekan', sans-serif;
		font-weight: 500;
		cursor: pointer;
		transition: background 0.25s ease, color 0.25s ease, opacity 0.2s ease;
		min-width: 160px;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		/* دکمه به‌صورت بلوک با عرض متناسب با محتوا رندر می‌شود تا margin:auto واقعاً آن را وسط‌چین کند */
    width: 100%;

		margin: 0 auto;
	}
	.af-pro-q-btn-inactive {
		background: #E9E9EB;
		color: #9B9BA1;
		cursor: not-allowed;
	}
	.af-pro-q-btn-active {
		background: #5247FF;
		color: #FFFFFF;
	}
	.af-pro-q-btn-active:hover { background: #4338e0; }
	.af-pro-q-arrow { font-size: 18px; line-height: 1; }
	.af-pro-q-btn-icon { width: 20px; height: 20px; object-fit: contain; display: inline-block; }

	/* Progress bar */
	.af-pro-q-progress-wrap {
		display: flex;
		align-items: center;
		gap: 12px;
		margin-bottom: 24px;
		padding: 0 4px;
	}
	.af-pro-q-progress-bar {
		flex: 1;
		height: 10px;
		background: #FFFFFF;
		border: 1px solid #F0F0F1;
		border-radius: 10000px;
		overflow: hidden;
		display: flex;
		align-items: center;
	}
	.af-pro-q-progress-fill {
		height: 8px;
		background: #009E52;
		border-radius: 100000px;
		transition: width 0.3s ease;
	}
	.af-pro-q-progress-text {
		font-size: 14px;
		color: #161618;
		font-family: 'iranyekan', sans-serif;
		white-space: nowrap;
	}
	.af-pro-q-question { padding: 0 4px 20px; }
	.af-pro-q-question-text {
		font-size: 18px;
		font-weight: 500;
		color: #161618;
		margin-bottom: 20px;
		line-height: 1.6;
		font-family: 'iranyekan', sans-serif;
	}
	.af-pro-q-options {
		display: flex;
		flex-direction: column;
		gap: 12px;
		margin-bottom: 28px;
	}
	.af-pro-q-option {
		display: flex;
		align-items: center;
		gap: 10px;
		padding: 14px 16px;
		background: #ffffff;
		border-radius: 12px;
		cursor: pointer;
		font-size: 16px;
		font-family: 'iranyekan', sans-serif;
		transition: background 0.2s;
	}
	.af-pro-q-option:hover { border: 1px solid #5247FF; }
	.af-pro-q-option input { accent-color: #5247FF; width: 18px; height: 18px;    display: none;}
	.af-pro-q-option.selected {  border: 1px solid #5247FF; }

	@media (max-width: 768px) {
		.af-pro-q-text-page { font-size: 17px; padding: 10px 4px 30px;min-height: 80dvh; }
		.af-pro-q-btn { width: 100%; max-width: 100%;position: absolute; bottom: 10px; }
	}
	</style>

	<script>
	(function () {
		if (window._afQS1) return;
		window._afQS1 = true;

		// متن پویای دکمه سوالات بر اساس فعال/غیرفعال بودن و نوع (تک‌انتخابی/چندانتخابی)
		(function () {
			var SINGLE_INACTIVE_TEXT = 'یک گزینه را انتخاب کنید';
			var MULTI_INACTIVE_TEXT  = 'موارد مرتبط را انتخاب کنید';
			var ACTIVE_TEXT          = 'تایید';

			function applyButtonText(btn) {
				if (!btn || !btn.classList.contains('af-pro-q-next-btn')) return;
				var isMulti = btn.classList.contains('af-pro-q-multi-next');
				var isActive = btn.classList.contains('af-pro-q-btn-active');
				var text = isActive ? ACTIVE_TEXT : (isMulti ? MULTI_INACTIVE_TEXT : SINGLE_INACTIVE_TEXT);
				if (btn.textContent.trim() !== text) {
					btn.textContent = text;
				}
			}

			function applyAll() {
				document.querySelectorAll('.af-pro-q-next-btn').forEach(applyButtonText);
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', applyAll);
			} else {
				applyAll();
			}

			var observer = new MutationObserver(function (mutations) {
				mutations.forEach(function (m) {
					if (m.target.classList && m.target.classList.contains('af-pro-q-next-btn')) {
						applyButtonText(m.target);
					}
				});
			});
			observer.observe(document.body, {
				attributes: true,
				attributeFilter: ['class'],
				subtree: true
			});
		})();

		// دکمه صفحات متنی (بدون ذخیره پاسخ)
		document.addEventListener('click', function (e) {
			var btn = e.target.closest('.af-pro-q-text-next');
			if (!btn) return;
			var ns = parseInt(btn.getAttribute('data-next-section'), 10);
			var np = parseInt(btn.getAttribute('data-next-page'), 10);
			var nq = parseInt(btn.getAttribute('data-next-q') || '0', 10);
			if (typeof AFQuestionnaire !== 'undefined' && AFQuestionnaire.goTo) {
				AFQuestionnaire.goTo(ns, np, nq);
			}
		});

		// فعال شدن دکمه سوال وقتی گزینه انتخاب شد
		document.addEventListener('change', function (e) {
			var input = e.target;
			if (!input.matches('.af-pro-q-question input[type="radio"]')) return;
			var q = input.closest('.af-pro-q-question');
			if (!q) return;
			var btn = q.querySelector('.af-pro-q-next-btn');
			if (btn) {
				btn.classList.remove('af-pro-q-btn-inactive');
				btn.classList.add('af-pro-q-btn-active');
			}
			q.querySelectorAll('.af-pro-q-option').forEach(function (o) { o.classList.remove('selected'); });
			input.closest('.af-pro-q-option').classList.add('selected');
		});

		// ذخیره لایو + رفتن به مرحله بعد
		document.addEventListener('click', function (e) {
			var btn = e.target.closest('.af-pro-q-next-btn');
			if (!btn || btn.classList.contains('af-pro-q-btn-inactive')) return;
			if (btn.classList.contains('af-pro-q-s5-branch')) return; // هندلر مخصوص بخش ۵

			var section = parseInt(btn.getAttribute('data-section'), 10);
			var page = parseInt(btn.getAttribute('data-page'), 10);
			var qNum = parseInt(btn.getAttribute('data-q'), 10);
			var qEl = btn.closest('.af-pro-q-question');
			var key = qEl ? qEl.getAttribute('data-key') : '';
			var checked = qEl ? qEl.querySelector('input[type="radio"]:checked') : null;
			if (!checked || !key) return;

			var nextSection = btn.hasAttribute('data-next-section') ? parseInt(btn.getAttribute('data-next-section'), 10) : section;
			var nextPage = parseInt(btn.getAttribute('data-next-page'), 10);
			var nextQ = parseInt(btn.getAttribute('data-next-q') || '1', 10);

			if (typeof AFQuestionnaire !== 'undefined' && AFQuestionnaire.saveAndGo) {
				AFQuestionnaire.saveAndGo({
					section: section,
					page: page,
					question_key: key,
					question_number: qNum,
					answer: checked.value,
					next_section: nextSection,
					next_page: nextPage,
					next_question: nextQ || 1
				});
			}
		});
	})();
	</script>

</div><!-- /section 1 -->



<!-- ========================================================
     SECTION 2  (بخش دوم)
     ترتیب: صفحه ۱ → سوال ۱ → سوال ۲ → سوال ۳ → سوال ۴ → سوال ۵
======================================================== -->
<div class="af-pro-questionnaire-section" data-section="2" style="display:none;">

		<!-- صفحه ۱ : متن -->
	<div class="af-pro-q-page" data-page="1">
		<div class="af-pro-q-text-page">
			<!-- تصویر بر اساس جنسیت -->
			<div class="af-pro-q-gender-image-wrap">
				<img src="" alt="" class="af-pro-q-gender-image" id="af-pro-q-s2-page1-gender-img">
			</div>

			<p>قدم دوم، بیا بیشتر درباره سبک زندگیت بگو.</p>
		</div>
		<div class="af-pro-q-page-actions">
			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-text-next"
				data-next-section="2" data-next-page="2" data-next-q="1">ادامه <img src="http://6tofit.com/wp-content/uploads/2026/09/Left-Arrow.png" alt="" class="af-pro-q-btn-icon"></button>
		</div>

		<style>
			.af-pro-q-gender-image-wrap {
				display: flex;
				justify-content: center;
				margin-bottom: 24px;
			}
			.af-pro-q-gender-image {
				width: 340px;
		
				object-fit: contain;
				border-radius: 24px;
			}
		</style>

		<script>
		(function () {
			var imgEl = document.getElementById('af-pro-q-s2-page1-gender-img');
			if (!imgEl) return;

			var MALE_IMG   = 'http://6tofit.com/wp-content/uploads/2026/09/7c4e0ce9af0ef7a3c2587aedcc0f0d69cb986574-scaled.png';
			var FEMALE_IMG = 'http://6tofit.com/wp-content/uploads/2026/09/39ce69ccd6133548346ebe11b2be5ba47ef25706-scaled.png';
			var OTHER_IMG  = 'http://6tofit.com/wp-content/uploads/2026/09/7c4e0ce9af0ef7a3c2587aedcc0f0d69cb986574-scaled.png';

			function setGenderImage(gender) {
				if (gender === 'female') {
					imgEl.src = FEMALE_IMG;
				} else if (gender === 'other') {
					imgEl.src = OTHER_IMG;
				} else {
					imgEl.src = MALE_IMG;
				}
			}

			function loadGenderFromDB() {
				if (typeof AFQuestionnaire === 'undefined' || typeof AFQuestionnaire.getAnswers !== 'function') {
					setGenderImage('male');
					return;
				}
				AFQuestionnaire.getAnswers(function (answers) {
					var gender = (answers && answers.s1_gender) ? answers.s1_gender : 'male';
					setGenderImage(gender);
				});
			}

			var pageEl = document.querySelector('.af-pro-questionnaire-section[data-section="2"] .af-pro-q-page[data-page="1"]');
			if (pageEl) {
				var observer = new MutationObserver(function () {
					if (pageEl.style.display !== 'none') {
						loadGenderFromDB();
					}
				});
				observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });
			}

			loadGenderFromDB();
		})();
		</script>
	</div>

		<!-- سوال ۱ -->
	<div class="af-pro-q-page" data-page="2" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:20%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۱ از ۵</span>
		</div>
		<div class="af-pro-q-question" data-question="1" data-key="s2_q1">
			<div class="af-pro-q-question-text">چند وعده در هفته بیرون از خانه غذا می‌خوری؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/spag.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q1" value="1-2"> ۱-۲ بار در هفته
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/berger.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q1" value="3-5"> ۳-۵ بار در هفته
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/taco.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q1" value="6+"> ۶ بار و بیشتر در هفته
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/nosh.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q1" value="rarely"> به ندرت بیرون غذا می‌خورم
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="2" data-page="2" data-q="1"
				data-next-section="2" data-next-page="3" data-next-q="2" data-total="5">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

		<!-- سوال ۲ -->
	<div class="af-pro-q-page" data-page="3" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:40%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۲ از ۵</span>
		</div>
		<div class="af-pro-q-question" data-question="2" data-key="s2_q2">
			<div class="af-pro-q-question-text">تا حالا پیش اومده بعد از خوردن خوراکی‌هایی که نمی‌تونستی در برابرشون مقاومت کنی، احساس عذاب وجدان داشته باشی؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/check.png" alt="" class="af-pro-q-option-icon" style="width:44px;height:44px;">
					<input type="radio" name="s2_q2" value="yes"> بله
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/kheyr.png" alt="" class="af-pro-q-option-icon" style="width:44px;height:44px;">
					<input type="radio" name="s2_q2" value="no"> خیر
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="2" data-page="3" data-q="2"
				data-next-section="2" data-next-page="4" data-next-q="3" data-total="5">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

		<!-- سوال ۳ -->
	<div class="af-pro-q-page" data-page="4" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:60%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۳ از ۵</span>
		</div>
		<div class="af-pro-q-question" data-question="3" data-key="s2_q3">
			<div class="af-pro-q-question-text">کدوم برنامه بیشتر با سلیقه و ترجیحاتت جور درمیاد؟</div>
			<div class="af-pro-q-options af-pro-q-options-scroll">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/hichkodam.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q3" value="none"> هیچکدوم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/sand.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q3" value="balanced"> رژیم متعادل
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/egg.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q3" value="keto"> رژیم کتوژنیک
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/salad.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q3" value="vegetarian"> گیاه‌خواری
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/borokli.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q3" value="vegan"> وگان
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/gosht.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q3" value="paleo"> رژیم پالئو
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/migo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q3" value="mediterranean"> رژیم مدیترانه‌ای
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/nan.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q3" value="low_carb"> کم‌کربوهیدرات
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/Goje.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q3" value="clean"> تغذیه پاک و طبیعی
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="2" data-page="4" data-q="3"
				data-next-section="2" data-next-page="5" data-next-q="4" data-total="5">ادامه</button>
		</div>

		<style>
			.af-pro-q-options-scroll {
				display: flex;
				flex-direction: column;
				gap: 12px;
				margin-bottom: 28px;
				max-height: 340px;
				overflow-y: auto;
				padding-left: 4px;
				padding-right: 4px;
			}
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
				flex-shrink: 0;
			}
			.af-pro-q-option-icon {
				width: 36px;
				height: 36px;
				object-fit: contain;
				flex-shrink: 0;
			}
@media (max-width: 767px) {
			.af-pro-q-options-scroll{
    max-height: 540px;
			}
			}
		</style>
	</div>

		<!-- سوال ۴ -->
	<div class="af-pro-q-page" data-page="5" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:80%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۴ از ۵</span>
		</div>
		<div class="af-pro-q-question" data-question="4" data-key="s2_q4">
			<div class="af-pro-q-question-text">موقع غذا خوردن، حواست زیاد پرت می‌شه؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/sadem.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q4" value="often"> آره، خیلی وقتا حواسم پرت می‌شه
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/chem.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q4" value="sometimes"> گاهی پیش میاد، ولی نه همیشه
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/hapem.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q4" value="rarely"> به‌ندرت، معمولاً تمرکزم رو حفظ می‌کنم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/starem.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q4" value="never"> اصلاً نه، موقع غذا خوردن کاملاً تمرکز دارم
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="2" data-page="5" data-q="4"
				data-next-section="2" data-next-page="6" data-next-q="5" data-total="5">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 36px;
				height: 36px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

		<!-- سوال ۵ -->
	<div class="af-pro-q-page" data-page="6" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:100%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۵ از ۵</span>
		</div>
		<div class="af-pro-q-question" data-question="5" data-key="s2_q5">
			<div class="af-pro-q-question-text">معمولاً تو چه شرایطی سراغ خوراکی و اسنک می‌ری؟</div>
			<div class="af-pro-q-options af-pro-q-options-scroll">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/chan.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q5" value="hungry"> وقتی گرسنه‌م
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/mus.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q5" value="fun"> موقع تفریح یا سرگرمی
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/laptop.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q5" value="work"> موقع کار یا مطالعه کردن
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/abr.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q5" value="stress"> برای کم کردن استرس
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/speech.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q5" value="boredom"> از سر بی‌حوصلگی
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/party.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q5" value="social"> وقتی با بقیه‌ام یا دورهمیم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/soal.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s2_q5" value="other"> سایر موارد
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="2" data-page="6" data-q="5"
				data-next-section="3" data-next-page="1" data-next-q="0" data-total="5"> تایید  </button>
		</div>

		<style>
			.af-pro-q-options-scroll {
				display: flex;
				flex-direction: column;
				gap: 12px;
				margin-bottom: 28px;
				max-height: 340px;
				overflow-y: auto;
				padding-left: 4px;
				padding-right: 4px;
			}
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
				flex-shrink: 0;
			}
			.af-pro-q-option-icon {
				width: 40px;
				height: 40px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

</div>


<!-- ========================================================
     SECTION 3  (بخش سوم)
     ترتیب: صفحه ۱ → سوال ۱..۶ → صفحه ۲ → سوال ۷
======================================================== -->
<div class="af-pro-questionnaire-section" data-section="3" style="display:none;">

		<!-- صفحه ۱ : متن -->
	<div class="af-pro-q-page" data-page="1">
		<div class="af-pro-q-text-page">
			<!-- تصویر بر اساس جنسیت -->
			<div class="af-pro-q-gender-image-wrap">
				<img src="" alt="" class="af-pro-q-gender-image" id="af-pro-q-s3-page1-gender-img">
			</div>

			<p>قدم سوم، بیا بیشتر درباره تغذیه‌ات بگو.</p>
		</div>
		<div class="af-pro-q-page-actions">
			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-text-next"
				data-next-section="3" data-next-page="2" data-next-q="1">ادامه <img src="http://6tofit.com/wp-content/uploads/2026/09/Left-Arrow.png" alt="" class="af-pro-q-btn-icon"></button>
		</div>

		<style>
			.af-pro-q-gender-image-wrap {
				display: flex;
				justify-content: center;
				margin-bottom: 24px;
			}
			.af-pro-q-gender-image {
				width: 340px;
			
				object-fit: contain;
				border-radius: 24px;
			}
		</style>

		<script>
		(function () {
			var imgEl = document.getElementById('af-pro-q-s3-page1-gender-img');
			if (!imgEl) return;

			var MALE_IMG   = 'http://6tofit.com/wp-content/uploads/2026/09/manse3-scaled.png';
			var FEMALE_IMG = 'http://6tofit.com/wp-content/uploads/2026/09/femsec3-scaled.png';
			var OTHER_IMG  = 'http://6tofit.com/wp-content/uploads/2026/09/manse3-scaled.png';

			function setGenderImage(gender) {
				if (gender === 'female') {
					imgEl.src = FEMALE_IMG;
				} else if (gender === 'other') {
					imgEl.src = OTHER_IMG;
				} else {
					imgEl.src = MALE_IMG;
				}
			}

			function loadGenderFromDB() {
				if (typeof AFQuestionnaire === 'undefined' || typeof AFQuestionnaire.getAnswers !== 'function') {
					setGenderImage('male');
					return;
				}
				AFQuestionnaire.getAnswers(function (answers) {
					var gender = (answers && answers.s1_gender) ? answers.s1_gender : 'male';
					setGenderImage(gender);
				});
			}

			var pageEl = document.querySelector('.af-pro-questionnaire-section[data-section="3"] .af-pro-q-page[data-page="1"]');
			if (pageEl) {
				var observer = new MutationObserver(function () {
					if (pageEl.style.display !== 'none') {
						loadGenderFromDB();
					}
				});
				observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });
			}

			loadGenderFromDB();
		})();
		</script>
	</div>

		<!-- سوال 1 -->
	<div class="af-pro-q-page" data-page="2" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:14.3%;"></div></div>
			<span class="af-pro-q-progress-text">سوال 1 از ۷</span>
		</div>
		<div class="af-pro-q-question" data-question="1" data-key="s3_q1">
			<div class="af-pro-q-question-text">آیا درک اولیه‌ای از تغذیه داری؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/happyemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q1" value="expert"> درک کامل و عمیق دارم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/happ2emo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q1" value="basic"> یکم می‌دونم، ولی اطلاعات زیادی ندارم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/thinkemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q1" value="interested"> علاقه دارم ولی اطلاعات ندارم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/pookeremo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q1" value="none"> هیچ علاقه‌ای ندارم
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="3" data-page="2" data-q="1"
				data-next-section="3" data-next-page="3" data-next-q="2" data-total="7">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 36px;
				height: 36px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

		<!-- سوال 2 -->
	<div class="af-pro-q-page" data-page="3" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:28.6%;"></div></div>
			<span class="af-pro-q-progress-text">سوال 2 از ۷</span>
		</div>
		<div class="af-pro-q-question" data-question="2" data-key="s3_q2">
			<div class="af-pro-q-question-text">تا حالا رژیم‌های غذایی محدودکننده برای کاهش وزن امتحان کردی؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/check.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q2" value="yes"> بله
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/kheyr.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q2" value="no"> خیر
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="3" data-page="3" data-q="2"
				data-next-section="3" data-next-page="4" data-next-q="3" data-total="7">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 36px;
				height: 36px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

		<!-- سوال 3 -->
	<div class="af-pro-q-page" data-page="4" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:42.9%;"></div></div>
			<span class="af-pro-q-progress-text">سوال 3 از ۷</span>
		</div>
		<div class="af-pro-q-question" data-question="3" data-key="s3_q3">
			<div class="af-pro-q-question-text">با خوندن اطلاعات تغذیه‌ای روی بسته‌بندی آشنایی داری؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/happyemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q3" value="expert"> خیلی خوب بلدم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/happ2emo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q3" value="some"> تا حدی بلدم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/sadem.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q3" value="none"> اصلاً بلد نیستم
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="3" data-page="4" data-q="3"
				data-next-section="3" data-next-page="5" data-next-q="4" data-total="7">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 36px;
				height: 36px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

		<!-- سوال 4 -->
	<div class="af-pro-q-page" data-page="5" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:57.1%;"></div></div>
			<span class="af-pro-q-progress-text">سوال 4 از ۷</span>
		</div>
		<div class="af-pro-q-question" data-question="4" data-key="s3_q4">
			<div class="af-pro-q-question-text">تا حالا رژیم غذایی یا مقدار کالری مصرفی‌تو دنبال کردی؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/happyemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q4" value="always"> همیشه پیگیری می‌کنم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/happ2emo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q4" value="sometimes"> گاهی وقتا پیگیری می‌کنم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/Tahobemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q4" value="never"> هیچ‌وقت پیگیری نکردم
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="3" data-page="5" data-q="4"
				data-next-section="3" data-next-page="6" data-next-q="5" data-total="7">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 36px;
				height: 36px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

		<!-- سوال 5 -->
	<div class="af-pro-q-page" data-page="6" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:71.4%;"></div></div>
			<span class="af-pro-q-progress-text">سوال 5 از ۷</span>
		</div>
		<div class="af-pro-q-question" data-question="5" data-key="s3_q5">
			<div class="af-pro-q-question-text">آیا ریزمغذی‌هایی مثل ویتامین‌ها و مواد معدنی رو به‌طور روزانه پیگیری می‌کنی؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/happyemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q5" value="always"> همیشه پیگیری می‌کنم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/happ2emo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q5" value="sometimes"> گاهی وقتا پیگیری می‌کنم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/chem.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q5" value="rarely"> به‌ندرت پیگیری می‌کنم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/Tahobemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q5" value="never"> هیچ‌وقت پیگیری نکردم
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="3" data-page="6" data-q="5"
				data-next-section="3" data-next-page="7" data-next-q="6" data-total="7">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 36px;
				height: 36px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

		<!-- سوال 6 -->
	<div class="af-pro-q-page" data-page="7" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:85.7%;"></div></div>
			<span class="af-pro-q-progress-text">سوال 6 از ۷</span>
		</div>
		<div class="af-pro-q-question" data-question="6" data-key="s3_q6">
			<div class="af-pro-q-question-text">منابع اصلی دریافت پروتئین روزانه‌ت چیه؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/nimremo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q6" value="animal"> پروتئین حیوانی (مثل تخم‌مرغ، گوشت و...)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/lobem.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q6" value="plant"> پروتئین گیاهی (مثل محصولات سویا و...)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/milkemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q6" value="dairy"> محصولات لبنی
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/sand.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q6" value="mixed"> ترکیبی از منابع مختلف
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/soal.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q6" value="other"> سایر موارد
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="3" data-page="7" data-q="6"
				data-next-section="3" data-next-page="8" data-next-q="0" data-total="7">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 36px;
				height: 36px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

		<!-- صفحه ۲ : متن -->
	<div class="af-pro-q-page" data-page="8" style="display:none;">
		<div class="af-pro-q-text-page">
			<!-- تصویر بر اساس جنسیت -->
			<div class="af-pro-q-gender-image-wrap">
				<img src="" alt="" class="af-pro-q-gender-image" id="af-pro-q-s3-page8-gender-img">
			</div>

			<p>جالبه بدونی حتی هضم غذا (TEF) هم کالری می‌سوزونه! پروتئین‌ها بیشترین تأثیر رو دارن، چون بدن انرژی بیشتری برای هضمشون مصرف می‌کنه. برای همین خوراکی‌های پروتئینی، هم متابولیسم رو بالا می‌برن، هم بیشتر سیر نگه‌ت می‌دارن.</p>
		</div>
		<div class="af-pro-q-page-actions">
			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-text-next"
				data-next-section="3" data-next-page="9" data-next-q="7">ادامه <img src="http://6tofit.com/wp-content/uploads/2026/09/Left-Arrow.png" alt="" class="af-pro-q-btn-icon"></button>
		</div>

		<style>
			.af-pro-q-gender-image-wrap {
				display: flex;
				justify-content: center;
				margin-bottom: 24px;
			}
			.af-pro-q-gender-image {
				width: 340px;
				height: auto;
				object-fit: contain;
				border-radius: 24px;
			}
		</style>

		<script>
		(function () {
			var imgEl = document.getElementById('af-pro-q-s3-page8-gender-img');
			if (!imgEl) return;

			var MALE_IMG   = 'http://6tofit.com/wp-content/uploads/2026/09/tefman-scaled.png';
			var FEMALE_IMG = 'http://6tofit.com/wp-content/uploads/2026/09/teffem-scaled.png';
			var OTHER_IMG  = 'http://6tofit.com/wp-content/uploads/2026/09/tefman-scaled.png';

			function setGenderImage(gender) {
				if (gender === 'female') {
					imgEl.src = FEMALE_IMG;
				} else if (gender === 'other') {
					imgEl.src = OTHER_IMG;
				} else {
					imgEl.src = MALE_IMG;
				}
			}

			function loadGenderFromDB() {
				if (typeof AFQuestionnaire === 'undefined' || typeof AFQuestionnaire.getAnswers !== 'function') {
					setGenderImage('male');
					return;
				}
				AFQuestionnaire.getAnswers(function (answers) {
					var gender = (answers && answers.s1_gender) ? answers.s1_gender : 'male';
					setGenderImage(gender);
				});
			}

			var pageEl = document.querySelector('.af-pro-questionnaire-section[data-section="3"] .af-pro-q-page[data-page="8"]');
			if (pageEl) {
				var observer = new MutationObserver(function () {
					if (pageEl.style.display !== 'none') {
						loadGenderFromDB();
					}
				});
				observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });
			}

			loadGenderFromDB();
		})();
		</script>
	</div>

		<!-- سوال ۷ -->
	<div class="af-pro-q-page" data-page="9" style="display:none;">
		<div class="af-pro-q-progress-wrap">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill" style="width:100%;"></div></div>
			<span class="af-pro-q-progress-text">سوال ۷ از ۷</span>
		</div>
		<div class="af-pro-q-question" data-question="7" data-key="s3_q7">
			<div class="af-pro-q-question-text">منابع اصلی دریافت کربوهیدرات‌هات توی رژیم غذاییت چیه؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/ricemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q7" value="staple"> غذاهای پایه مثل برنج و نودل
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/breademoj.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q7" value="bread"> نان و شیرینی‌ها
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2025/10/RedApplepro.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q7" value="fruits_veg"> میوه و سبزیجات
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/sand.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q7" value="mixed"> ترکیبی از منابع مختلف
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/soal.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s3_q7" value="other"> سایر موارد
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="3" data-page="9" data-q="7"
				data-next-section="5" data-next-page="1" data-next-q="0" data-total="7">ادامه <img src="http://6tofit.com/wp-content/uploads/2026/09/Left-Arrow.png" alt="" class="af-pro-q-btn-icon"></button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 36px;
				height: 36px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

</div>


<!-- ========================================================
     SECTION 4  (جایگاه خالی – در صورت نیاز بعداً پر شود)
======================================================== -->
<div class="af-pro-questionnaire-section" data-section="4" style="display:none;">
	<div class="af-pro-q-page" data-page="1">
		<p style="text-align:center;padding:40px 0;color:#9B9BA1;">بخش چهارم در حال حاضر استفاده نمی‌شود.</p>
		<button type="button" class="af-pro-q-btn af-pro-q-btn-active" onclick="AFQuestionnaire.goTo(5,1,1)">رفتن به بخش پنجم</button>
	</div>
</div>


<!-- ========================================================
     SECTION 5  (بخش پنجم)
     ترتیب: صفحه ۱ → سوال ۱..۶ → صفحه ۲ → سوال ۷ → سوال ۸ → سوال ۹
     سپس شرطی: مرد → سوال ۱۰،۱۱ | زن → سوال ۱۰،۱۱،۱۲،۱۳
======================================================== -->

<div class="af-pro-questionnaire-section" data-section="5" style="display:none;">

	<!-- صفحه ۱ : متن -->
	<div class="af-pro-q-page" data-page="1">
		<div class="af-pro-q-text-page">
			<!-- تصویر بر اساس جنسیت -->
			<div class="af-pro-q-gender-image-wrap">
				<img src="" alt="" class="af-pro-q-gender-image" id="af-pro-q-s5-page1-gender-img">
			</div>

			<p>قدم چهارم، ببینیم چجور ورزشی بهت می‌سازه.</p>
		</div>
		<div class="af-pro-q-page-actions">
			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-text-next"
				data-next-section="5" data-next-page="2" data-next-q="1">ادامه <img src="http://6tofit.com/wp-content/uploads/2026/09/Left-Arrow.png" alt="" class="af-pro-q-btn-icon"></button>
		</div>

		<style>
			.af-pro-q-gender-image-wrap {
				display: flex;
				justify-content: center;
				margin-bottom: 24px;
			}
			.af-pro-q-gender-image {
				width: 340px;
				object-fit: contain;
				border-radius: 24px;
			}
		</style>

		<script>
		(function () {
			var imgEl = document.getElementById('af-pro-q-s5-page1-gender-img');
			if (!imgEl) return;

			var MALE_IMG   = 'http://6tofit.com/wp-content/uploads/2026/09/mansec4-scaled.png';
			var FEMALE_IMG = 'http://6tofit.com/wp-content/uploads/2026/09/femsec4-scaled.png';
			var OTHER_IMG  = 'http://6tofit.com/wp-content/uploads/2026/09/mansec4-scaled.png';

			function setGenderImage(gender) {
				if (gender === 'female') {
					imgEl.src = FEMALE_IMG;
				} else if (gender === 'other') {
					imgEl.src = OTHER_IMG;
				} else {
					imgEl.src = MALE_IMG;
				}
			}

			function loadGenderFromDB() {
				if (typeof AFQuestionnaire === 'undefined' || typeof AFQuestionnaire.getAnswers !== 'function') {
					setGenderImage('male');
					return;
				}
				AFQuestionnaire.getAnswers(function (answers) {
					var gender = (answers && answers.s1_gender) ? answers.s1_gender : 'male';
					setGenderImage(gender);
				});
			}

			var pageEl = document.querySelector('.af-pro-questionnaire-section[data-section="5"] .af-pro-q-page[data-page="1"]');
			if (pageEl) {
				var observer = new MutationObserver(function () {
					if (pageEl.style.display !== 'none') {
						loadGenderFromDB();
					}
				});
				observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });
			}

			loadGenderFromDB();
		})();
		</script>
	</div>

	<!-- سوال 1 -->
	<div class="af-pro-q-page" data-page="2" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="1">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question" data-question="1" data-key="s5_q1">
			<div class="af-pro-q-question-text">چند روز در هفته می‌تونی برای ورزش وقت بذاری؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/col1.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q1" value="1_day"> ۱ روز در هفته
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/col3.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q1" value="2_3_days"> ۲ تا ۳ روز در هفته
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/col5.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q1" value="4_5_days"> ۴ تا ۵ روز در هفته
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/col7.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q1" value="6_7_days"> ۶ تا ۷ روز در هفته
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="5" data-page="2" data-q="1"
				data-next-section="5" data-next-page="3" data-next-q="2" data-total="10">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<!-- سوال 2 -->
	<div class="af-pro-q-page" data-page="3" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="2">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question" data-question="2" data-key="s5_q2">
			<div class="af-pro-q-question-text">برای هر جلسه تمرین، معمولاً چقدر وقت داری؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/c1-scaled.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q2" value="under_30"> کمتر از ۳۰ دقیقه
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/c2-scaled.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q2" value="30_45"> ۳۰ تا ۴۵ دقیقه
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/c3-scaled.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q2" value="45_60"> ۴۵ تا ۶۰ دقیقه
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/c4-scaled.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q2" value="over_60"> بیشتر از ۶۰ دقیقه
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="5" data-page="3" data-q="2"
				data-next-section="5" data-next-page="4" data-next-q="3" data-total="10">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<!-- سوال 3 -->
	<div class="af-pro-q-page" data-page="4" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="3">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question" data-question="3" data-key="s5_q3">
			<div class="af-pro-q-question-text">چه تجهیزاتی برای تمرین در دسترست هست؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/Start.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q3" value="bodyweight"> فقط وزن بدن یا فضای خونه
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/Weight-1.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q3" value="dumbbells_bands"> دمبل یا کش تمرینی
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/Halter.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q3" value="full_gym"> باشگاه کامل (وزنه و دستگاه)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/Tredmil-1.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q3" value="cardio_equipment"> وسایل هوازی (مثل تردمیل یا دوچرخه ثابت)
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="5" data-page="4" data-q="3"
				data-next-section="5" data-next-page="5" data-next-q="4" data-total="10">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<!-- سوال 4 -->
	<div class="af-pro-q-page" data-page="5" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="4">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question" data-question="4" data-key="s5_q4">
			<div class="af-pro-q-question-text">سطح تجربه ورزشی‌ات چطوره؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/one-bar-1.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q4" value="beginner"> مبتدی (کمتر از ۶ ماه)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/three-bar.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q4" value="intermediate"> نیمه‌حرفه‌ای (۶ تا ۲۴ ماه)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/four-bar.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q4" value="advanced"> پیشرفته (بیش از ۲ سال)
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="5" data-page="5" data-q="4"
				data-next-section="5" data-next-page="6" data-next-q="5" data-total="10">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<!-- سوال 5 -->
	<div class="af-pro-q-page" data-page="6" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="5">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question" data-question="5" data-key="s5_q5">
			<div class="af-pro-q-question-text">هدف اصلی تو از ورزش در حال حاضر چیه؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/371508a9b5c068f358f6b7a6bc8df68047967fa6.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q5" value="fat_loss"> چربی‌سوزی و کاهش وزن
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/bazemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q5" value="muscle_gain"> عضله‌سازی و افزایش حجم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/baremo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q5" value="fitness_health"> تناسب‌اندام و حفظ سلامتی
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/galb.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q5" value="cardio_endurance"> افزایش استقامت قلبی–عروقی
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/shoemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q5" value="strength_performance"> بهبود قدرت و عملکرد ورزشی
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="5" data-page="6" data-q="5"
				data-next-section="5" data-next-page="7" data-next-q="6" data-total="10">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<!-- سوال 6 -->
	<div class="af-pro-q-page" data-page="7" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="6">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question" data-question="6" data-key="s5_q6">
			<div class="af-pro-q-question-text">کدوم سبک تمرین برات جذاب‌تره؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/Weight-1.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q6" value="resistance"> تمرین مقاومتی (وزنه یا وزن بدن)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/shoemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q6" value="steady_cardio"> هوازی مداوم (دویدن، دوچرخه و…)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/fireemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q6" value="hiit"> تمرین دَوِرِی پرشدت (HIIT)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/bazemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q6" value="mixed"> ترکیبی از مقاومتی و هوازی
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/Start.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q6" value="mobility_yoga"> حرکات کششی، یوگا یا موبیلیتی
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="5" data-page="7" data-q="6"
				data-next-section="5" data-next-page="8" data-next-q="0" data-total="10">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<!-- صفحه ۲ : متن -->
	<div class="af-pro-q-page" data-page="8" style="display:none;">
		<div class="af-pro-q-text-page">
			<!-- تصویر بر اساس جنسیت -->
			<div class="af-pro-q-gender-image-wrap">
				<img src="" alt="" class="af-pro-q-gender-image" id="af-pro-q-s5-page8-gender-img">
			</div>

			<p>ورزش (Exercise) نه‌تنها کالری می‌سوزونه، بلکه با ساختن عضله، متابولیسمت رو هم بالا می‌بره. تمرین‌های قدرتی باعث می‌شن حتی در حالت استراحت هم کالری بیشتری بسوزونی.</p>
		</div>
		<div class="af-pro-q-page-actions">
			<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-text-next"
				data-next-section="5" data-next-page="9" data-next-q="7">ادامه <img src="http://6tofit.com/wp-content/uploads/2026/09/Left-Arrow.png" alt="" class="af-pro-q-btn-icon"></button>
		</div>

		<style>
			.af-pro-q-gender-image-wrap {
				display: flex;
				justify-content: center;
				margin-bottom: 24px;
			}
			.af-pro-q-gender-image {
				width: 340px;
				object-fit: contain;
				border-radius: 24px;
			}
		</style>

		<script>
		(function () {
			var imgEl = document.getElementById('af-pro-q-s5-page8-gender-img');
			if (!imgEl) return;

			var MALE_IMG   = 'http://6tofit.com/wp-content/uploads/2026/09/mansec52-scaled.png';
			var FEMALE_IMG = 'http://6tofit.com/wp-content/uploads/2026/09/femsec52-scaled.png';
			var OTHER_IMG  = 'http://6tofit.com/wp-content/uploads/2026/09/mansec52-scaled.png';

			function setGenderImage(gender) {
				if (gender === 'female') {
					imgEl.src = FEMALE_IMG;
				} else if (gender === 'other') {
					imgEl.src = OTHER_IMG;
				} else {
					imgEl.src = MALE_IMG;
				}
			}

			function loadGenderFromDB() {
				if (typeof AFQuestionnaire === 'undefined' || typeof AFQuestionnaire.getAnswers !== 'function') {
					setGenderImage('male');
					return;
				}
				AFQuestionnaire.getAnswers(function (answers) {
					var gender = (answers && answers.s1_gender) ? answers.s1_gender : 'male';
					setGenderImage(gender);
				});
			}

			var pageEl = document.querySelector('.af-pro-questionnaire-section[data-section="5"] .af-pro-q-page[data-page="8"]');
			if (pageEl) {
				var observer = new MutationObserver(function () {
					if (pageEl.style.display !== 'none') {
						loadGenderFromDB();
					}
				});
				observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });
			}

			loadGenderFromDB();
		})();
		</script>
	</div>

	<!-- سوال ۷ -->
	<div class="af-pro-q-page" data-page="9" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="7">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question" data-question="7" data-key="s5_q7">
			<div class="af-pro-q-question-text">اگر محدودیت یا آسیب داری، کدوم ناحیه رو درگیر کرده؟</div>

			<div class="af-pro-q-options af-pro-q-options-multi">
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/ostemo.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">زانو / لگن</span>
					<input type="checkbox" name="s5_q7" value="knee_hip">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/spine.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">کمر / ستون فقرات</span>
					<input type="checkbox" name="s5_q7" value="back_spine">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/sotonemo.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">شانه / گردن</span>
					<input type="checkbox" name="s5_q7" value="shoulder_neck">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/cholesterol.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">بیماری قلبی یا فشار خون</span>
					<input type="checkbox" name="s5_q7" value="heart_bp">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/💉-Syringe.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">دیابت یا مشکلات متابولیک</span>
					<input type="checkbox" name="s5_q7" value="diabetes_metabolic">
				</label>
				<label class="af-pro-q-option af-pro-q-option-multi">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/hichkodam.png" alt="" class="af-pro-q-option-icon">
					<span class="af-pro-q-option-title">ندارم</span>
					<input type="checkbox" name="s5_q7" value="none">
				</label>
			</div>

			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn af-pro-q-multi-next"
				data-section="5" data-page="9" data-q="7"
				data-next-section="5" data-next-page="10" data-next-q="8" data-total="10">ادامه</button>
		</div>

		<style>
			.af-pro-q-options-multi {
				display: flex;
				flex-direction: column;
				gap: 10px;
				margin-bottom: 28px;
				max-height: 340px;
				overflow-y: auto;
				padding-left: 4px;
				padding-right: 4px;
			}
			.af-pro-q-option-multi {
				display: flex;
				align-items: center;
				gap: 14px;
				padding: 14px 16px;
				background: #ffffff;
				border-radius: 14px;
				cursor: pointer;
				border: 1px solid transparent;
				transition: border-color 0.2s, background 0.2s;
				flex-shrink: 0;
			}
			.af-pro-q-option-multi:hover {
				border-color: rgba(82, 71, 255, 0.35);
			}
			.af-pro-q-option-multi.selected {
				border-color: #5247FF;
			}
			.af-pro-q-option-multi input {
				display: none;
			}
			.af-pro-q-option-icon {
				width: 40px;
				height: 40px;
				object-fit: contain;
				flex-shrink: 0;
				border-radius: 10px;
			}
			.af-pro-q-option-title {
				font-size: 15px;
				font-weight: 500;
				color: #161618;
				line-height: 1.4;
			}
		</style>

		<script>
		(function () {
			var page = document.querySelector('.af-pro-questionnaire-section[data-section="5"] .af-pro-q-page[data-page="9"]');
			if (!page) return;

			var options = page.querySelectorAll('.af-pro-q-option-multi');
			var nextBtn = page.querySelector('.af-pro-q-multi-next');

			if (!nextBtn || options.length === 0) return;

			function getSelectedValues() {
				var values = [];
				options.forEach(function (opt) {
					var input = opt.querySelector('input[type="checkbox"]');
					if (input && input.checked) {
						values.push(input.value);
					}
				});
				return values;
			}

			function updateButtonState() {
				var selected = getSelectedValues();
				if (selected.length > 0) {
					nextBtn.classList.remove('af-pro-q-btn-inactive');
					nextBtn.classList.add('af-pro-q-btn-active');
				} else {
					nextBtn.classList.add('af-pro-q-btn-inactive');
					nextBtn.classList.remove('af-pro-q-btn-active');
				}
			}

			options.forEach(function (opt) {
				opt.addEventListener('click', function (e) {
					e.preventDefault();
					var input = opt.querySelector('input[type="checkbox"]');
					if (!input) return;

					if (input.value === 'none') {
						options.forEach(function (o) {
							var i = o.querySelector('input');
							if (i && i.value !== 'none') {
								i.checked = false;
								o.classList.remove('selected');
							}
						});
						input.checked = !input.checked;
						opt.classList.toggle('selected', input.checked);
					} else {
						var noneOpt = page.querySelector('input[value="none"]');
						if (noneOpt) {
							noneOpt.checked = false;
							var noneLabel = noneOpt.closest('.af-pro-q-option-multi');
							if (noneLabel) noneLabel.classList.remove('selected');
						}
						input.checked = !input.checked;
						opt.classList.toggle('selected', input.checked);
					}
					updateButtonState();
				});
			});

			nextBtn.addEventListener('click', function (e) {
				if (nextBtn.classList.contains('af-pro-q-btn-inactive')) return;
				e.stopImmediatePropagation();

				var selected = getSelectedValues();
				if (selected.length === 0) return;

				var answer = selected.join(',');

				if (typeof AFQuestionnaire !== 'undefined' && AFQuestionnaire.saveAndGo) {
					AFQuestionnaire.saveAndGo({
						section: 5,
						page: 9,
						question_key: 's5_q7',
						question_number: 7,
						answer: answer,
						next_section: 5,
						next_page: 10,
						next_question: 8
					});
				}
			}, true);
		})();
		</script>
	</div>

	<!-- سوال ۸ -->
	<div class="af-pro-q-page" data-page="10" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="8">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question" data-question="8" data-key="s5_q8">
			<div class="af-pro-q-question-text">شدت تمرینی که الان برات مناسبه چقدره؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/happ2emo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q8" value="very_light"> بسیار سبک (مثل پیاده‌روی آرام)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/danemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q8" value="light_moderate"> سبک تا متوسط (یه کم عرق، راحت صحبت می‌کنی)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/cryemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q8" value="moderate_hard"> متوسط تا سخت (نفس‌نفس، سخت صحبت می‌کنی)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/angeremo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q8" value="very_hard"> خیلی سنگین (نمی‌تونی حرف بزنی)
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="5" data-page="10" data-q="8"
				data-next-section="5" data-next-page="11" data-next-q="9" data-total="10">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<!-- سوال ۹ (حالا یک سوال عمومی عادی است، نقطه انشعاب دیگه اینجا نیست) -->
	<div class="af-pro-q-page" data-page="11" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="9">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question" data-question="9" data-key="s5_q9">
			<div class="af-pro-q-question-text">چه ساعتی برات برای ورزش مناسب‌تره؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/sunemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q9" value="morning"> صبح زود
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/afteremo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q9" value="midday"> اواسط روز
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/moon.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q9" value="evening"> عصر
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/fingemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q9" value="anytime"> هر ساعتی باشه اوکی‌ام
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="5" data-page="11" data-q="9"
				data-next-section="5" data-next-page="12" data-next-q="10" data-total="10">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<!-- سوال ۱۰ (سوال عمومی جدید - آخرین سوال عمومی، نقطه انشعاب جنسیتی اینجاست) -->
	<div class="af-pro-q-page" data-page="12" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="10">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question" data-question="10" data-key="s5_q10">
			<div class="af-pro-q-question-text">چی بیشتر از همه بهت انگیزه می‌ده که به برنامه پایبند بمونی؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="" alt="" class="af-pro-q-option-icon" id="af-pro-q-s5-q10-gender-img">
					<input type="radio" name="s5_q10" value="appearance"> ظاهر بهتر
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/Flash-1-Iconly-Pro-1.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q10" value="health_energy"> سلامتی و انرژی بیشتر
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/✨-Sparkles.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q10" value="confidence"> افزایش اعتمادبه‌نفس
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/shoemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q10" value="performance"> عملکرد ورزشی
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/cholesterol.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q10" value="doctor"> توصیه پزشک
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn af-pro-q-s5-branch"
				data-section="5" data-page="12" data-q="10" data-total="10">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>

		<script>
		(function () {
			var imgEl = document.getElementById('af-pro-q-s5-q10-gender-img');
			if (!imgEl) return;

			var MALE_IMG   = 'http://6tofit.com/wp-content/uploads/2026/09/👕-T-Shirt.png';
			var FEMALE_IMG = 'http://6tofit.com/wp-content/uploads/2026/09/👗-Dress.png';
			var OTHER_IMG  = 'http://6tofit.com/wp-content/uploads/2026/09/👕-T-Shirt.png';

			function setGenderImage(gender) {
				if (gender === 'female') {
					imgEl.src = FEMALE_IMG;
				} else if (gender === 'other') {
					imgEl.src = OTHER_IMG;
				} else {
					imgEl.src = MALE_IMG;
				}
			}

			function loadGenderFromDB() {
				if (typeof AFQuestionnaire === 'undefined' || typeof AFQuestionnaire.getAnswers !== 'function') {
					setGenderImage('male');
					return;
				}
				AFQuestionnaire.getAnswers(function (answers) {
					var gender = (answers && answers.s1_gender) ? answers.s1_gender : 'male';
					setGenderImage(gender);
				});
			}

			var pageEl = document.querySelector('.af-pro-questionnaire-section[data-section="5"] .af-pro-q-page[data-page="12"]');
			if (pageEl) {
				var observer = new MutationObserver(function () {
					if (pageEl.style.display !== 'none') {
						loadGenderFromDB();
					}
				});
				observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });
			}

			loadGenderFromDB();
		})();
		</script>
	</div>

	<!-- ===== سوالات شرطی مرد (۱۱ و ۱۲) ===== -->
	<div class="af-pro-q-page" data-page="13" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="11">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question af-pro-q-gender-male" data-question="11" data-key="s5_q11_male">
			<div class="af-pro-q-question-text">چقدر جدی به افزایش توده عضلانی فکر می‌کنی؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/one-bar.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q11_male" value="small"> جزئی (۲–۴ کیلو)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/two-bars2.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q11_male" value="medium"> متوسط (۴–۸ کیلو)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/three-bar3.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q11_male" value="large"> قابل‌توجه (بیش از ۸ کیلو)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/hichkodam.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q11_male" value="not_priority"> اولویت اصلی عضله‌سازی نیست
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="5" data-page="13" data-q="11"
				data-next-section="5" data-next-page="14" data-next-q="12" data-total="12">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<div class="af-pro-q-page" data-page="14" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="12">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question af-pro-q-gender-male" data-question="12" data-key="s5_q12_male">
			<div class="af-pro-q-question-text">چقدر به تمرین با وزنه‌های سنگین علاقه‌مندی؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/pookeremo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q12_male" value="none"> اصلا علاقه‌ای ندارم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/happ2emo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q12_male" value="low"> کم
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/happyemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q12_male" value="medium"> متوسط
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/starem.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q12_male" value="high"> زیاد
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="5" data-page="14" data-q="12"
				data-next-section="6" data-next-page="1" data-next-q="1" data-total="12">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<!-- ===== سوالات شرطی زن (۱۱ تا ۱۳) ===== -->
	<div class="af-pro-q-page" data-page="15" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="11">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question af-pro-q-gender-female" data-question="11" data-key="s5_q11_female">
			<div class="af-pro-q-question-text">الان در کدوم فاز از چرخه قاعدگیت هستی؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/bargg.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q11_female" value="follicular"> فولیکولار (روز ۶–۱۳)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/flower.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q11_female" value="ovulation"> تخمک‌گذاری (روز ۱۴–۱۶)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/abr.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q11_female" value="luteal"> لوتئال (روز ۱۷–۲۸)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/💊-Pill.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q11_female" value="no_period"> قاعدگی ندارم / یائسه / IUD یا قرص هورمونی
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="5" data-page="15" data-q="11"
				data-next-section="5" data-next-page="16" data-next-q="12" data-total="13">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<div class="af-pro-q-page" data-page="16" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="12">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question af-pro-q-gender-female" data-question="12" data-key="s5_q12_female">
			<div class="af-pro-q-question-text">آیا در حال حاضر بارداری یا در دوره بعد از زایمان هستی؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/74e0552a593ab5b82a0c865ccd57d204f82805e0.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q12_female" value="pregnant"> باردارم (سه‌ماهه ۱ / ۲ / ۳)
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/shishe.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q12_female" value="postpartum_under_6"> کمتر از ۶ ماه از زایمان گذشته
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/baby.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q12_female" value="postpartum_over_6"> بیش از ۶ ماه از زایمان گذشته
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/hichkodam.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q12_female" value="no"> خیر
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="5" data-page="16" data-q="12"
				data-next-section="5" data-next-page="17" data-next-q="13" data-total="13">ادامه</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<div class="af-pro-q-page" data-page="17" style="display:none;">
		<div class="af-pro-q-progress-wrap" data-qnum="13">
			<div class="af-pro-q-progress-bar"><div class="af-pro-q-progress-fill"></div></div>
			<span class="af-pro-q-progress-text"></span>
		</div>
		<div class="af-pro-q-question af-pro-q-gender-female" data-question="13" data-key="s5_q13_female">
			<div class="af-pro-q-question-text">موقع پریود معمولاً چه علائمی داری که ممکنه روی تمرین‌هات اثر بذاره؟</div>
			<div class="af-pro-q-options">
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/vsaddem.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q13_female" value="cramps"> درد شکم / کمر
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/zzzzemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q13_female" value="severe_fatigue"> خستگی شدید
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/saddemoo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q13_female" value="mild_energy"> نوسان انرژی خفیف
				</label>
				<label class="af-pro-q-option">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/lovlyemo.png" alt="" class="af-pro-q-option-icon">
					<input type="radio" name="s5_q13_female" value="no_effect"> تأثیر خاصی نداره
				</label>
			</div>
			<button type="button" class="af-pro-q-btn af-pro-q-btn-inactive af-pro-q-next-btn"
				data-section="5" data-page="17" data-q="13"
				data-next-section="6" data-next-page="1" data-next-q="1" data-total="13">پایان و مشاهده نتایج</button>
		</div>

		<style>
			.af-pro-q-option {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.af-pro-q-option-icon {
				width: 44px;
				height: 44px;
				object-fit: contain;
				flex-shrink: 0;
			}
		</style>
	</div>

	<!-- اسکریپت انشعاب جنسیتی (بعد از سوال ۱۰) -->
	<script>
	(function () {
		if (window._afQS5) return;
		window._afQS5 = true;

		document.addEventListener('click', function (e) {
			var btn = e.target.closest('.af-pro-q-s5-branch');
			if (!btn || btn.classList.contains('af-pro-q-btn-inactive')) return;
			e.stopImmediatePropagation();

			var qEl = btn.closest('.af-pro-q-question');
			var checked = qEl.querySelector('input[type="radio"]:checked');
			if (!checked || typeof AFQuestionnaire === 'undefined') return;

			AFQuestionnaire.saveAnswerOnly({
				section: 5,
				page: 12,
				question_key: 's5_q10',
				question_number: 10,
				answer: checked.value
			}, function () {
				AFQuestionnaire.getAnswers(function (answers) {
					var gender = (answers && answers.s1_gender) ? answers.s1_gender : 'male';
					if (gender === 'female') {
						AFQuestionnaire.goTo(5, 15, 11); // صفحه ۱۵ = سوال ۱۱ زن
					} else {
						AFQuestionnaire.goTo(5, 13, 11); // صفحه ۱۳ = سوال ۱۱ مرد
					}
				});
			});
		}, true);
	})();
	</script>

	<!-- اسکریپت پویاساز نوار پیشرفت بخش پنجم (بر اساس جنسیت: مرد/سایر = از ۱۲، زن = از ۱۳) -->
	<script>
	(function () {
		if (window._afQS5Progress) return;
		window._afQS5Progress = true;

		var persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
		function toPersian(str) {
			return String(str).replace(/[0-9]/g, function (d) { return persianDigits[d]; });
		}

		function applyProgress(wrap, qnum, gender) {
			var total = (gender === 'female') ? 13 : 12;
			var fill = wrap.querySelector('.af-pro-q-progress-fill');
			var text = wrap.querySelector('.af-pro-q-progress-text');
			var percent = Math.min(100, (qnum / total) * 100);
			if (fill) fill.style.width = percent + '%';
			if (text) text.textContent = 'سوال ' + toPersian(qnum) + ' از ' + toPersian(total);
		}

		function updateProgress(pageEl) {
			var wrap = pageEl.querySelector('.af-pro-q-progress-wrap[data-qnum]');
			if (!wrap) return;
			var qnum = parseInt(wrap.getAttribute('data-qnum'), 10);
			if (!qnum) return;

			if (typeof AFQuestionnaire !== 'undefined' && AFQuestionnaire.getAnswers) {
				AFQuestionnaire.getAnswers(function (answers) {
					var gender = (answers && answers.s1_gender) ? answers.s1_gender : 'male';
					applyProgress(wrap, qnum, gender);
				});
			} else {
				applyProgress(wrap, qnum, 'male');
			}
		}

		var sectionEl = document.querySelector('.af-pro-questionnaire-section[data-section="5"]');
		if (!sectionEl) return;

		var observer = new MutationObserver(function (mutations) {
			mutations.forEach(function (m) {
				var pageEl = m.target;
				if (pageEl.classList && pageEl.classList.contains('af-pro-q-page') && pageEl.style.display !== 'none') {
					updateProgress(pageEl);
				}
			});
		});

		sectionEl.querySelectorAll('.af-pro-q-page').forEach(function (p) {
			observer.observe(p, { attributes: true, attributeFilter: ['style'] });
			if (p.style.display !== 'none') {
				updateProgress(p);
			}
		});
	})();
	</script>

</div><!-- /section 5 -->

<!-- ========================================================
     AFQResults — موتور محاسبه پویای نتایج (BMR / TDEE / انرژی)
     همه محاسبات بخش نتایج (بخش ۶) بر اساس پاسخ‌های واقعی کاربر
     در این‌جا انجام می‌شود و سپس در صفحات نتایج استفاده می‌شود.
======================================================== -->
<script>
window.AFQResults = (function () {
	'use strict';

	var persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
	function toPersian(str) {
		return String(str).replace(/[0-9]/g, function (d) { return persianDigits[d]; });
	}
	function formatNumber(n) {
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

	// سهم NEAT/EXERCISE از باقی‌ماندهٔ TDEE (بعد از کسر BMR و TEF) به تفکیک سطح فعالیت
	var ACTIVITY_SPLIT = {
		sedentary:   { neat: 0.90, exercise: 0.10 },
		light:       { neat: 0.70, exercise: 0.30 },
		moderate:    { neat: 0.55, exercise: 0.45 },
		very_active: { neat: 0.35, exercise: 0.65 }
	};

	// رنگ‌بندی نمودار انرژی که بر اساس سطح فعالیت تغییر می‌کند
	var ACTIVITY_COLORS = {
		sedentary:   { bmr: '#4892df', neat: '#c7c7cd', exercise: '#c7c7cd', tef: '#00a99d' },
		light:       { bmr: '#4892df', neat: '#ffb238', exercise: '#f2b100', tef: '#00a99d' },
		moderate:    { bmr: '#4892df', neat: '#ff7900', exercise: '#ed5b60', tef: '#00a99d' },
		very_active: { bmr: '#4892df', neat: '#ff7900', exercise: '#c81d3f', tef: '#00a99d' }
	};

	var GOAL_LABELS = {
		weight_loss:       'کاهش وزن',
		healthy_lifestyle: 'سبک زندگی سالم‌تر',
		fitness:           'تناسب اندام'
	};

	function compute(answers) {
		answers = answers || {};

		var gender   = answers.s1_gender || 'male';
		var age      = num(answers.s1_q3, 25);
		var heightCm = num(answers.s1_q4, 170);
		var weightKg = num(answers.s1_q5, 70);
		var targetKg = num(answers.s1_q6, weightKg);
		var activity = answers.s1_q7 && ACTIVITY_FACTORS[answers.s1_q7] ? answers.s1_q7 : 'moderate';
		var goal     = answers.s1_q1 && GOAL_LABELS[answers.s1_q1] ? answers.s1_q1 : 'weight_loss';

		// ---- BMR (فرمول Mifflin-St Jeor) ----
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

		// ---- TDEE ----
		var factor = ACTIVITY_FACTORS[activity];
		var tdee = Math.round(bmr * factor);

		// ---- تفکیک اجزای انرژی (BMR / NEAT / EXERCISE / TEF) ----
		var tef = Math.round(tdee * 0.10);
		var remaining = Math.max(0, tdee - bmr - tef);
		var split = ACTIVITY_SPLIT[activity];
		var neat = Math.round(remaining * split.neat);
		var exercise = Math.max(0, remaining - neat);

		function pct(v) {
			return tdee > 0 ? (v / tdee) * 100 : 0;
		}
		var bmrPct = pct(bmr), neatPct = pct(neat), exercisePct = pct(exercise), tefPct = pct(tef);
		// اصلاح خطای گرد شدن تا مجموع دقیقاً ۱۰۰٪ شود (روی سهم BMR که بزرگ‌ترین است اعمال می‌شود)
		var drift = 100 - (bmrPct + neatPct + exercisePct + tefPct);
		bmrPct = Math.round((bmrPct + drift) * 10) / 10;
		neatPct = Math.round(neatPct * 10) / 10;
		exercisePct = Math.round(exercisePct * 10) / 10;
		tefPct = Math.round(tefPct * 10) / 10;

		// ---- کالری هدف بر اساس هدف کاربر ----
		var idealCalorie;
		if (goal === 'weight_loss') {
			idealCalorie = Math.max(bmr, roundTo(tdee - 500, 50));
		} else if (goal === 'fitness') {
			idealCalorie = roundTo(tdee + 300, 50);
		} else {
			idealCalorie = roundTo(tdee, 50);
		}

		var weightDiffKg = weightKg - targetKg; // مثبت یعنی هدف کاهش وزن
		var deficitPerDay = tdee - idealCalorie; // می‌تواند منفی باشد (مازاد کالری برای هدف تناسب اندام)
		var monthlyChangeKg = Math.round(Math.abs(deficitPerDay) * 30 / 7700 * 10) / 10;
		if (monthlyChangeKg <= 0) monthlyChangeKg = 0.5;

		return {
			gender: gender,
			age: age,
			heightCm: heightCm,
			weightKg: weightKg,
			targetKg: targetKg,
			activity: activity,
			goal: goal,
			goalLabel: GOAL_LABELS[goal],
			bmr: bmr,
			tdee: tdee,
			neat: neat,
			exercise: exercise,
			tef: tef,
			bmrPct: bmrPct,
			neatPct: neatPct,
			exercisePct: exercisePct,
			tefPct: tefPct,
			colors: ACTIVITY_COLORS[activity],
			idealCalorie: idealCalorie,
			weightDiffKg: Math.round(Math.abs(weightDiffKg) * 10) / 10,
			isWeightLossDirection: weightDiffKg > 0,
			monthlyChangeKg: monthlyChangeKg,
			formatNumber: formatNumber
		};
	}

	function getCached(callback) {
		if (typeof AFQuestionnaire !== 'undefined' && AFQuestionnaire.getAnswers) {
			AFQuestionnaire.getAnswers(function (answers) {
				callback(compute(answers), answers);
			});
		} else {
			callback(compute({}), {});
		}
	}

	return {
		compute: compute,
		getCached: getCached,
		formatNumber: formatNumber
	};
})();
</script>

<!-- ========================================================
     SECTION 6  (نتایج – ۴ صفحه)
======================================================== -->
<div class="af-pro-questionnaire-section" data-section="6" style="display:none;">

	<div class="af-pro-q-page" data-page="1" style="display:none;">
		<div class="af-pro-q-result-box">
			<!-- تصویر بر اساس جنسیت -->
			<div class="af-pro-q-gender-image-wrap">
				<img src="" alt="" class="af-pro-q-gender-image" id="af-pro-q-s6-page1-gender-img">
			</div>

			<p>داریم جواب‌هات رو بررسی می‌کنیم تا TDEE مخصوص بدنت رو دربیاریم.</p>
		</div>

		<button type="button" class="af-pro-q-btn af-pro-q-btn-active af-pro-q-result-auto-next" id="af-pro-q-s6-auto-next" style="min-width: 180px; padding: 8px;">
			<div class="af-loader">
				<svg class="af-loader-svg" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
					<circle
						id="af-loader-arc"
						cx="75"
						cy="75"
						r="30"
						fill="none"
						stroke="#ffffff"
						stroke-width="10"
						stroke-linecap="round"
					/>
				</svg>
			</div>
		</button>

		<style>
			.af-pro-q-gender-image-wrap {
				display: flex;
				justify-content: center;
				margin-bottom: 24px;
			}
			.af-pro-q-gender-image {
				width: 380px;
				object-fit: contain;
				border-radius: 24px;
			}

			.af-loader {
				width: 18px;
				height: 418px;
				display: flex;
				align-items: center;
				justify-content: center;
				background: transparent;
			}

			.af-loader-svg {
				width: 18px;
				height: 18px;
				overflow: visible;
			}

			#af-loader-arc {
				transform-origin: 75px 75px;
			}
			@media (max-width: 767px) {
					.af-loader-svg {
				width: 8px;
				height: 8px;
				overflow: visible;
			}
			.af-loader {
				width: 18px;
				height: 18px;
				display: flex;
				align-items: center;
				justify-content: center;
				background: transparent;
			}
			}
		</style>

		<script>
		(function () {
			// ========== تصویر جنسیت ==========
			var imgEl = document.getElementById('af-pro-q-s6-page1-gender-img');
			if (imgEl) {
				var MALE_IMG   = 'http://6tofit.com/wp-content/uploads/2026/09/resman-scaled.png';
				var FEMALE_IMG = 'http://6tofit.com/wp-content/uploads/2026/09/resfem-scaled.png';
				var OTHER_IMG  = 'http://6tofit.com/wp-content/uploads/2026/09/resman-scaled.png';

				function setGenderImage(gender) {
					if (gender === 'female') {
						imgEl.src = FEMALE_IMG;
					} else if (gender === 'other') {
						imgEl.src = OTHER_IMG;
					} else {
						imgEl.src = MALE_IMG;
					}
				}

				function loadGenderFromDB() {
					if (typeof AFQuestionnaire === 'undefined' || typeof AFQuestionnaire.getAnswers !== 'function') {
						setGenderImage('male');
						return;
					}
					AFQuestionnaire.getAnswers(function (answers) {
						var gender = (answers && answers.s1_gender) ? answers.s1_gender : 'male';
						setGenderImage(gender);
					});
				}

				var pageEl = document.querySelector('.af-pro-questionnaire-section[data-section="6"] .af-pro-q-page[data-page="1"]');
				if (pageEl) {
					var observer = new MutationObserver(function () {
						if (pageEl.style.display !== 'none') {
							loadGenderFromDB();
						}
					});
					observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });
				}
				loadGenderFromDB();
			}

			// ========== لودر ==========
			var arc = document.getElementById('af-loader-arc');
			if (arc) {
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
				var currentFrame = 0;

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
			}

			// ========== رفتن خودکار به صفحه بعد بعد از ۳.۵ ثانیه ==========
			var pageEl = document.querySelector('.af-pro-questionnaire-section[data-section="6"] .af-pro-q-page[data-page="1"]');
			var hasAutoGone = false;

			function startAutoNext() {
				if (hasAutoGone) return;
				hasAutoGone = true;

				setTimeout(function () {
					if (typeof AFQuestionnaire !== 'undefined' && AFQuestionnaire.goTo) {
						AFQuestionnaire.goTo(6, 2, 1);
					}
				}, 3500);
			}

			if (pageEl) {
				var observer = new MutationObserver(function () {
					if (pageEl.style.display !== 'none') {
						startAutoNext();
					}
				});
				observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });

				// اگر از اول نمایش بود
				if (pageEl.style.display !== 'none') {
					startAutoNext();
				}
			}
		})();
		</script>
	</div>

	<div class="af-pro-q-page" data-page="2" style="display:none;">
		<div class="af-pro-q-result-box">
			<!-- تصویر بر اساس جنسیت -->
			<div class="af-pro-q-gender-image-wrap">
				<img src="" alt="" class="af-pro-q-gender-image" id="af-pro-q-s6-page2-gender-img">
			</div>

			<p>جواب‌هات بررسی شدن و نتیجه اماده است.</p>
		</div>
		<button type="button" class="af-pro-q-btn af-pro-q-btn-active" onclick="AFQuestionnaire.goTo(6,3,1)">مشاهده نتیجه تست TDEE</button>

		<style>
			.af-pro-q-gender-image-wrap {
				display: flex;
				justify-content: center;
				margin-bottom: 24px;
			}
			.af-pro-q-gender-image {
				width: 340px;
				object-fit: contain;
				border-radius: 24px;
			}
		</style>

		<script>
		(function () {
			var imgEl = document.getElementById('af-pro-q-s6-page2-gender-img');
			if (!imgEl) return;

			var MALE_IMG   = 'http://6tofit.com/wp-content/uploads/2026/09/resman-scaled.png';
			var FEMALE_IMG = 'http://6tofit.com/wp-content/uploads/2026/09/resfem-scaled.png';
			var OTHER_IMG  = 'http://6tofit.com/wp-content/uploads/2026/09/resman-scaled.png';

			function setGenderImage(gender) {
				if (gender === 'female') {
					imgEl.src = FEMALE_IMG;
				} else if (gender === 'other') {
					imgEl.src = OTHER_IMG;
				} else {
					imgEl.src = MALE_IMG;
				}
			}

			function loadGenderFromDB() {
				if (typeof AFQuestionnaire === 'undefined' || typeof AFQuestionnaire.getAnswers !== 'function') {
					setGenderImage('male');
					return;
				}
				AFQuestionnaire.getAnswers(function (answers) {
					var gender = (answers && answers.s1_gender) ? answers.s1_gender : 'male';
					setGenderImage(gender);
				});
			}

			var pageEl = document.querySelector('.af-pro-questionnaire-section[data-section="6"] .af-pro-q-page[data-page="2"]');
			if (pageEl) {
				var observer = new MutationObserver(function () {
					if (pageEl.style.display !== 'none') {
						loadGenderFromDB();
					}
				});
				observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });
			}

			loadGenderFromDB();
		})();
		</script>
	</div>

	<div class="af-pro-q-page" data-page="3" style="display:none;">
		<div class="af-pro-q-result-box">

			<!-- تب‌ها -->
			<div class="mychanges-tabs-container">
				<div class="mychanges-tab active" data-tab="tdee-now" onclick="switchTdeeTab('tdee-now', this)">
					TDEE الآن
				</div>
				<div class="mychanges-tab" data-tab="tdee-ideal" onclick="switchTdeeTab('tdee-ideal', this)">
					TDEE ایده‌آل
				</div>
			</div>

			<!-- محتوای تب TDEE الآن -->
			<div class="tdee-tab-content" id="tdee-now" style="display:block;">
			<!-- عدد کالری -->
				<div class="tdee-ideal-calorie">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/fireemo.png" alt="" class="tdee-ideal-calorie-icon">
					<span class="tdee-ideal-number" id="af-s6-tdee-now-cal">۱۸۰۰</span>
					<span class="tdee-ideal-unit">کالری</span>
				</div>
			<div class="energy-chart">

    <div class="energy-bar">
        <div class="energy-segment bmr"></div>
        <div class="energy-segment neat"></div>
        <div class="energy-segment exercise"></div>
        <div class="energy-segment tef"></div>
    </div>

    <!-- BMR -->
    <div class="energy-label label-bmr">
        <span class="label-text">BMR</span>
        <span class="label-line"></span>
        <span class="label-dot"></span>
    </div>

    <!-- NEAT -->
    <div class="energy-label label-neat">
        <span class="label-dot"></span>
        <span class="label-line"></span>
        <span class="label-text">NEAT</span>
    </div>

    <!-- EXERCISE -->
    <div class="energy-label label-exercise">
        <span class="label-text">EXERCISE</span>
        <span class="label-line"></span>
        <span class="label-dot"></span>
    </div>

    <!-- TEF -->
    <div class="energy-label label-tef">
        <span class="label-dot"></span>
        <span class="label-line"></span>
        <span class="label-text">TEF</span>
    </div>

</div>


<style>
/* =========================
   Energy Chart
========================= */

.energy-chart {
    position: relative;
    width: min(440px, 100%);
    height: 125px;
    margin: 0 auto;

	    direction: ltr;
}


/* =========================
   Main Bar
========================= */

.energy-bar {
    position: absolute;
    top: 47px;
    left: 0;

    width: 100%;
    height: 40px;

    display: flex;

    overflow: hidden;
    border-radius: 20px;
}

.energy-segment {
    height: 100%;
    flex-shrink: 0;
}


/* BMR */
.energy-segment.bmr {
    width: 56%;
    background: #4892df;
}


/* NEAT */
.energy-segment.neat {
    width: 23%;
    background: #ff7900;
}


/* EXERCISE */
.energy-segment.exercise {
    width: 13%;
    background: #ed5b60;
}


/* TEF */
.energy-segment.tef {
    width: 8%;
    background: #00a99d;
}


/* =========================
   Labels
========================= */

.energy-label {
    position: absolute;

    width: 70px;

    text-align: center;

    font-size: 14px;
    font-weight: 700;
    line-height: 1;

    color: #151515;
}

.energy-label .label-text {
    display: block;
}

.energy-label .label-line {
    display: block;

    width: 2px;
    height: 12px;

    margin-left: auto;
    margin-right: auto;

    position: relative;
}

.energy-label .label-dot {
    position: absolute;

    width: 6px;
    height: 6px;

    border-radius: 50%;

    left: 50%;

    transform: translateX(-50%);
}


/* =========================
   BMR
========================= */

.label-bmr {
    top: 3px;

    /*
     * مرکز BMR روی حدود 32.5%
     * عرض نمودار قرار می‌گیرد
     */
    left: 25%;
}

.label-bmr .label-line {
    background: #4892df;
}

.label-bmr .label-dot {
    background: #4892df;

    bottom: -3px;
}


/* =========================
   EXERCISE
========================= */

.label-exercise {
    top: 3px;

    /*
     * مرکز Exercise روی حدود 85%
     */
    left: 78%;
}

.label-exercise .label-line {
    background: #ed5b60;
}

.label-exercise .label-dot {
    background: #ed5b60;

    bottom: -3px;
}


/* =========================
   NEAT
========================= */

.label-neat {
    top: 91px;

    /*
     * مرکز NEAT روی حدود 67.5%
     */
    left: 60%;
}

.label-neat .label-line {
    background: #ff7900;

    margin-top: 0;
    margin-bottom: 5px;
}

.label-neat .label-dot {
    background: #ff7900;

    top: -3px;
}


/* =========================
   TEF
========================= */

.label-tef {
    top: 91px;

    /*
     * مرکز TEF نزدیک انتهای نمودار
     */
    left: 86%;
}

.label-tef .label-line {
    background: #00a99d;

    margin-top: 0;
    margin-bottom: 5px;
}

.label-tef .label-dot {
    background: #00a99d;

    top: -3px;
}


/* =========================
   Mobile
========================= */

@media (max-width: 480px) {

    .energy-chart {
        height: 115px;
    }

    .energy-bar {
        top: 44px;
        height: 36px;
        border-radius: 18px;
    }

    .energy-label {
        font-size: 12px;
        width: 60px;
    }

    .label-bmr {
        top: 3px;
    }

    .label-exercise {
        top: 3px;
    }

    .label-neat,
    .label-tef {
        top: 83px;
    }

    .energy-label .label-line {
        height: 10px;
    }

    .energy-label .label-dot {
        width: 5px;
        height: 5px;
    }
}
</style>
				<p class="tdee-intro-text">این تخمینی از انرژی‌ای هست که در یک روز عادی بر پایه پاسخ‌هایی که دادی مصرف میکنی.</p>

				<div class="tdee-cards">
					<!-- کارت ۱ -->
					<div class="tdee-card">
						<div class="tdee-card-right">
							<div class="tdee-dot" style="background:#4590E6;"></div>
						</div>
						<div class="tdee-card-left">
							<div class="tdee-card-title">متابولیسم پایه (BMR)</div>
							<div class="tdee-card-desc">مقدار انرژی‌ای که بدن برای زنده موندن در حالت استراحت کامل نیاز داره، مثل نفس کشیدن</div>
							<div class="tdee-card-value">
								<span class="tdee-number" id="af-card-bmr-num">۱۶۰۰</span>
								<span class="tdee-unit">کالری</span>
							</div>
						</div>
					</div>

					<!-- کارت ۲ -->
					<div class="tdee-card">
						<div class="tdee-card-right">
							<div class="tdee-dot" style="background:#FF7A00;"></div>
						</div>
						<div class="tdee-card-left">
							<div class="tdee-card-title">فعالیت‌های روزمره (NEAT)</div>
							<div class="tdee-card-desc">کالری‌ای که برای حرکت‌های غیر تمرینی می‌سوزونی، مثل راه رفتن، ایستادن، یا حتی تکون خوردن موقع حرف زدن</div>
							<div class="tdee-card-value">
								<span class="tdee-number" id="af-card-neat-num">۲۵۰</span>
								<span class="tdee-unit">کالری</span>
							</div>
						</div>
					</div>

					<!-- کارت ۳ -->
					<div class="tdee-card">
						<div class="tdee-card-right">
							<div class="tdee-dot" style="background:#ED5C5C;"></div>
						</div>
						<div class="tdee-card-left">
							<div class="tdee-card-title"> ورزش  (EXERCISE)</div>
							<div class="tdee-card-desc">کالری‌ای که حین ورزش یا تمرین منظم می‌سوزونی، از پیاده‌روی گرفته تا تمرینات برنامه ریزی شده باشگاهی</div>
							<div class="tdee-card-value">
								<span class="tdee-number" id="af-card-exercise-num">۴۵۰</span>
								<span class="tdee-unit">کالری</span>
							</div>
						</div>
					</div>

					<!-- کارت ۴ -->
					<div class="tdee-card">
						<div class="tdee-card-right">
							<div class="tdee-dot" style="background:#00A89E;"></div>
						</div>
						<div class="tdee-card-left">
							<div class="tdee-card-title">اثر حرارتی غذا (TEF)</div>
							<div class="tdee-card-desc">میزان انرژی‌ای که بدن برای هضم، جذب و پردازش مواد غذایی مصرف می‌کنه، حدود ۱۰٪ از کل کالری دریافتی</div>
							<div class="tdee-card-value">
								<span class="tdee-number" id="af-card-tef-num">۳۵۰</span>
								<span class="tdee-unit">کالری</span>
							</div>
						</div>
					</div>
				</div>
			</div>

		
			<!-- محتوای تب TDEE ایده‌آل -->
			<div class="tdee-tab-content" id="tdee-ideal" style="display:none;">

				<!-- هدف -->
				<div class="tdee-ideal-goal" id="tdee-ideal-goal-text">هدف: کاهش وزن</div>

				<!-- عدد کالری -->
				<div class="tdee-ideal-calorie">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/fireemo.png" alt="" class="tdee-ideal-calorie-icon">
					<span class="tdee-ideal-number" id="af-s6-tdee-ideal-cal">۱۸۰۰</span>
					<span class="tdee-ideal-unit">کالری</span>
				</div>

				<!-- توضیح -->
				<p class="tdee-ideal-desc" id="af-s6-tdee-ideal-desc">
					برای کاهش نیم کیلو وزن در هفته، باید حدود ۵۰۰ کالری کمتر از TDEE الانتون مصرف کنید. یعنی شما حدود ۱۸۰۰ کالری در روز باید غذا بخورید تا به‌مرور وزنتان کاهش یابد.
				</p>

				<!-- دو کارت -->
				<div class="tdee-ideal-cards">
					<div class="tdee-ideal-card">
						<div class="tdee-ideal-card-header">
							<div class="tdee-ideal-card-icon">
								<img src="http://6tofit.com/wp-content/uploads/2026/09/📋-Clipboard.png" alt="">
							</div>
							<h2 class="tdee-ideal-card-title">ما برنامه‌ای تهیه میکنیم که</h2>
						</div>
						<div class="tdee-ideal-card-divider"></div>
						<ul class="tdee-ideal-card-list">
							<li id="af-ideal-cal-li">1800 کالری دارد.</li>
							<li> پر از غذاهای سالم و سیرکننده است تا بدون احساس گرسنگی وزن کم کنید. </li>
							<li> با افزودن تحرک روزانه (مثل ۲۰ دقیقه پیاده‌روی اضافه) می‌توانید کالری‌سوزی خود را بالا برده و سرعت کاهش وزن را بیشتر کنید .</li>
							
						</ul>
					</div>

					<div class="tdee-ideal-card">
						<div class="tdee-ideal-card-header">
							<div class="tdee-ideal-card-icon">
								<img src="http://6tofit.com/wp-content/uploads/2026/09/🎯-Direct-Hit.png" alt="">
							</div>
							<h2 class="tdee-ideal-card-title">نکات کلیدی</h2>
						</div>
						<div class="tdee-ideal-card-divider"></div>
						<ul class="tdee-ideal-card-list">
							<li id="af-ideal-monthly-li">با این روال، انتظار داریم در ماه اول ۲ تا ۳ کیلوگرم کاهش وزن داشته باشید.</li>
						
						</ul>
					</div>
				</div>

				<!-- باکس پایینی -->
				<div class="tdee-ideal-tip-box">
					<div class="tdee-ideal-tip-icon">
						<img src="http://6tofit.com/wp-content/uploads/2026/09/💡-Light-Bulb.png" alt="" width="24" height="24">
					</div>
					<div class="tdee-ideal-tip-text">
						ترکیب رژیم مناسب و ورزش، متابولیسم شما را همیشه فعال نگه می‌دارد و کمک می‌کند وزن کم‌شده برنگردد.
					</div>
				</div>
			</div>

			<style>
				/* ===== تب ایده‌آل ===== */
				.tdee-ideal-goal {
					text-align: center;
					font-size: 18px;
					font-weight: 600;
					color: #161618;
					margin-bottom: 20px;
				}

				.tdee-ideal-calorie {
					display: flex;
					align-items: baseline;
					justify-content: center;
					gap: 8px;
					margin-bottom: 18px;
				}
				.tdee-ideal-calorie-icon {
					width: 36px;
					height: 36px;
					object-fit: contain;
					margin-left: 6px;
				}
				.tdee-ideal-number {
					font-size: 44px;
					font-weight: 700;
					color: #161618;
					line-height: 1;
				}
				.tdee-ideal-unit {
					font-size: 30px;
					color: #65656D;
					font-weight: 500;
				}

				.tdee-ideal-desc {
					text-align: center;
					font-size: 18px;
					color: #65656D;
					line-height: 1.8;
					margin-bottom: 28px;
					padding: 0 8px;
				}

				/* کارت‌ها */
				.tdee-ideal-cards {
					display: flex;
					flex-direction: column;
					gap: 20px;
					margin-bottom: 24px;
				}
				.tdee-ideal-card {
					padding: 28px 24px;
					background-color: #FFFFFF;
					border-radius: 24px;
					box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
				}
				.tdee-ideal-card-header {
					display: flex;
					align-items: center;
					gap: 10px;

				}
				.tdee-ideal-card-icon img {
					width: 28px;
					height: 28px;
					object-fit: contain;
				}
				.tdee-ideal-card-title {
					font-size: 22px;
					font-weight: bold;
					color: #161618;
					text-align: right;
					margin: 0;
				}
				.tdee-ideal-card-divider {
					width: 100%;
					height: 1px;
					background-color: #F0F0F1;
					margin: 14px 0;
				}
				.tdee-ideal-card-list {
					list-style: none;
					padding-right: 22px;
					padding-top: 8px;
					margin: 0;
					color: #161618;
					font-size: 17px;
					line-height: 1.7;
					text-align: right;
				}
				.tdee-ideal-card-list li {
					position: relative;
					padding-right: 14px;
					margin-bottom: 6px;
				}
				.tdee-ideal-card-list li::before {
					content: '•';
					position: absolute;
					right: 0;
					color: #000000;
					font-size: 18px;
				}

				/* باکس نکته */
				.tdee-ideal-tip-box {
					background: #F2F2F8;
					border-radius: 24px;
					padding: 16px;
					display: flex;
					align-items: center;
					gap: 14px;
					direction: rtl;
				}
				.tdee-ideal-tip-icon {
					width: 10%;
					display: flex;
					align-items: center;
					justify-content: center;
				}
				.tdee-ideal-tip-icon img {
					width: 24px;
					height: 24px;
					object-fit: contain;
				}
				.tdee-ideal-tip-text {
					width: 90%;
					font-size: 16px;
					color: #161618;
					line-height: 1.7;
					text-align: justify;
				}

				@media only screen and (max-width: 768px) {
					.tdee-ideal-number {
						font-size: 36px;
					}
					.tdee-ideal-unit {
						font-size: 24px;
					}
					.tdee-ideal-card-title {
						font-size: 18px;
					}
					.tdee-ideal-card-list {
						font-size: 15px;
						padding-right: 12px;
					}
				}
			</style>

			<script>
			(function () {
				// نمایش هدف از s1_q1
				function updateIdealGoal() {
					var goalEl = document.getElementById('tdee-ideal-goal-text');
					if (!goalEl) return;

					var goalMap = {
						'weight_loss': 'کاهش وزن',
						'healthy_lifestyle': 'سبک زندگی سالم‌تر',
						'fitness': 'تناسب اندام'
					};

					if (typeof AFQuestionnaire !== 'undefined' && AFQuestionnaire.getAnswers) {
						AFQuestionnaire.getAnswers(function (answers) {
							var key = (answers && answers.s1_q1) ? answers.s1_q1 : 'weight_loss';
							var label = goalMap[key] || 'کاهش وزن';
							goalEl.textContent = 'هدف: ' + label;
						});
					} else {
						goalEl.textContent = 'هدف: کاهش وزن';
					}
				}

				// وقتی تب ایده‌آل باز شد آپدیت کن
				var originalSwitch = window.switchTdeeTab;
				window.switchTdeeTab = function (tabId, el) {
					if (typeof originalSwitch === 'function') {
						originalSwitch(tabId, el);
					}
					if (tabId === 'tdee-ideal') {
						updateIdealGoal();
					}
				};

				// بار اول هم تلاش کن
				setTimeout(updateIdealGoal, 500);
			})();
			</script>

			<!-- دکمه‌ها -->
			<div class="tdee-buttons">
				<button type="button" class="af-pro-q-btn af-pro-q-btn-active resdef" onclick="AFQuestionnaire.goTo(6,4,1)">
					دیدن برنامه پیشنهادی من
				</button>
				<button type="button" class="tdee-download-btn" id="af-tdee-download-btn">
					دانلود نتیجه تست
				</button>
			</div>
		</div>

		<style>
			/* تب‌ها */
			.mychanges-tabs-container {
				width: 80%;
				background: #F0F0F1;
				border-radius: 1000px;
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin: 0 auto 24px;
				padding: 5px;
			}
			.mychanges-tab {
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
			.mychanges-tab.active {
				background: #FFFFFF;
				color: #161618;
				box-shadow: 0 2px 8px rgba(0,0,0,0.06);
			}

			/* متن معرفی */
			.tdee-intro-text {
				text-align: center;
				font-size: 15px;
				color: #65656D;
				line-height: 1.8;
				margin-bottom: 28px;
				padding: 0 10px;
			}

			/* کارت‌ها */
			.tdee-cards {
				display: flex;
				flex-direction: column;
				gap: 23px;
				margin-bottom: 32px;
			}
			.tdee-card {
				background: #FFFFFF;
				padding: 12px;
				border-radius: 16px;
				display: flex;
			
				gap: 12px;
			}
			.tdee-card-right {
				width: 10%;
				display: flex;
				justify-content: center;
				align-items: flex-start;
				padding-top: 8px;
			}
			.tdee-dot {
				width: 12px;
				height: 12px;
				border-radius: 50%;
				flex-shrink: 0;
			}
			.tdee-card-left {
				width: 85%;
				text-align: right;
			}
			.tdee-card-title {
				font-size: 16px;
				color: #161618;
				font-weight: 500;
				margin-bottom: 4px;
			}
			.tdee-card-desc {
				font-size: 12px;
				color: #65656D;
				margin-bottom: 10px;
			}
			.tdee-card-value {
				display: flex;
				align-items: baseline;
			
				gap: 6px;
			}
			.tdee-number {
				font-size: 24px;
				font-weight: 600;
				color: #161618;
			}
			.tdee-unit {
				font-size: 12px;
				color: #65656D;
			}

			/* دکمه‌ها */
			.tdee-buttons {
				display: flex;
	
				gap: 12px;
				align-items: center;
			}
			.tdee-download-btn {
				background: transparent;
				border: 1px solid #5247FF;
				border-radius: 100000px;
				padding: 12px 10px;
				color: #5247FF;
				font-size: 18px;
				font-family: 'iranyekan', sans-serif;
				font-weight: 500;
				cursor: pointer;
				width: 100%;
				max-width: 320px;
				transition: background 0.2s, color 0.2s;
			}
			.tdee-download-btn:hover {
				background: rgba(82, 71, 255, 0.06);
			}

			@media only screen and (max-width: 768px) {
				.mychanges-tabs-container {
					width: 100%;
				}
				.mychanges-tab {
					font-size: 14px;
					padding: 12px 0;
				}
				.resdef{
                        position: static!imprtant;
						        width: 100%!imprtant;
				}
				.tdee-buttons{
					flex-direction: column;
				}
			}
		</style>

		<script>
		function switchTdeeTab(tabId, el) {
			// تب‌ها
			document.querySelectorAll('.mychanges-tab').forEach(function (t) {
				t.classList.remove('active');
			});
			el.classList.add('active');

			// محتوا
			document.querySelectorAll('.tdee-tab-content').forEach(function (c) {
				c.style.display = 'none';
			});
			var content = document.getElementById(tabId);
			if (content) content.style.display = 'block';
		}
		</script>

		<!-- ========== به‌روزرسانی پویای TDEE / انرژی‌بار بر اساس پاسخ‌های کاربر ========== -->
		<script>
		(function () {
			if (window._afQS6Page3Dynamic) return;
			window._afQS6Page3Dynamic = true;

			function fmt(n) {
				return (window.AFQResults ? window.AFQResults.formatNumber(n) : n);
			}

			function setText(id, text) {
				var el = document.getElementById(id);
				if (el) el.textContent = text;
			}

			function applyResults(r) {
	if (!r) return;

	// ---- عدد کالری TDEE الآن ----
	setText('af-s6-tdee-now-cal', fmt(r.tdee));

	// ---- کارت‌های تفکیک انرژی ----
	setText('af-card-bmr-num', fmt(r.bmr));
	setText('af-card-neat-num', fmt(r.neat));
	setText('af-card-exercise-num', fmt(r.exercise));
	setText('af-card-tef-num', fmt(r.tef));

	// ---- نمودار انرژی: فقط عرض هر بخش تغییر کند ----
	var segBmr = document.querySelector('.energy-chart .energy-segment.bmr');
	var segNeat = document.querySelector('.energy-chart .energy-segment.neat');
	var segExercise = document.querySelector('.energy-chart .energy-segment.exercise');
	var segTef = document.querySelector('.energy-chart .energy-segment.tef');

	if (segBmr) segBmr.style.width = r.bmrPct + '%';
	if (segNeat) segNeat.style.width = r.neatPct + '%';
	if (segExercise) segExercise.style.width = r.exercisePct + '%';
	if (segTef) segTef.style.width = r.tefPct + '%';

	// ---- موقعیت افقی برچسب‌ها متناسب با مرکز هر بخش ----
	var cursor = 0;

	function positionLabel(selector, widthPct) {
		var center = cursor + widthPct / 2;
		var label = document.querySelector(selector);

		if (label) {
			label.style.left = center + '%';
			label.style.transform = 'translateX(-50%)';
		}

		cursor += widthPct;
	}

	positionLabel('.energy-label.label-bmr', r.bmrPct);
	positionLabel('.energy-label.label-neat', r.neatPct);
	positionLabel('.energy-label.label-exercise', r.exercisePct);
	positionLabel('.energy-label.label-tef', r.tefPct);

	// ---- رنگ خط و نقطه‌ها تغییر نکند ----
	// رنگ‌ها از CSS خوانده می‌شوند و اینجا دستکاری نمی‌شوند.

	// ---- تب TDEE ایده‌آل ----
	setText('af-s6-tdee-ideal-cal', fmt(r.idealCalorie));

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

	setText(
		'af-s6-tdee-ideal-desc',
		goalDescMap[r.goal] || goalDescMap.weight_loss
	);

	setText(
		'af-ideal-cal-li',
		fmt(r.idealCalorie) + ' کالری دارد.'
	);

	var monthlyTextMap = {
		weight_loss: 'با این روال، انتظار داریم در ماه اول حدود ' +
			fmt(r.monthlyChangeKg) + ' کیلوگرم کاهش وزن داشته باشید.',

		healthy_lifestyle: 'با این روال، وزن شما در بلندمدت پایدار می‌ماند و انرژی و کیفیت زندگی‌تان بهبود پیدا می‌کند.',

		fitness: 'با این روال، انتظار داریم در ماه اول حدود ' +
			fmt(r.monthlyChangeKg) +
			' کیلوگرم افزایش وزن (عمدتاً عضله) داشته باشید.'
	};

	setText(
		'af-ideal-monthly-li',
		monthlyTextMap[r.goal] || monthlyTextMap.weight_loss
	);

	// ---- صفحه «چرا این برنامه» ----
	setText('af-s6-why-now-cal', fmt(r.tdee));
	setText('af-s6-why-goal-cal', fmt(r.idealCalorie));
}

			function refresh() {
				if (window.AFQResults) {
					window.AFQResults.getCached(applyResults);
				}
			}

			window._afQRefreshResults = refresh; // برای استفادهٔ دکمهٔ دانلود PDF

			// هر بار که صفحهٔ ۳ یا صفحهٔ ۵ بخش ۶ نمایش داده شد، دوباره محاسبه کن
			var pagesToWatch = document.querySelectorAll(
				'.af-pro-questionnaire-section[data-section="6"] .af-pro-q-page[data-page="3"], ' +
				'.af-pro-questionnaire-section[data-section="6"] .af-pro-q-page[data-page="5"]'
			);
			pagesToWatch.forEach(function (p) {
				var observer = new MutationObserver(function () {
					if (p.style.display !== 'none') refresh();
				});
				observer.observe(p, { attributes: true, attributeFilter: ['style'] });
				if (p.style.display !== 'none') refresh();
			});

			// همچنین وقتی بین تب TDEE الآن/ایده‌آل جابه‌جا می‌شویم، مقادیر تازه بماند
			var originalSwitchForResults = window.switchTdeeTab;
			window.switchTdeeTab = function (tabId, el) {
				if (typeof originalSwitchForResults === 'function') {
					originalSwitchForResults(tabId, el);
				}
				refresh();
			};

			setTimeout(refresh, 300);
		})();
		</script>

		<!-- ========== دانلود نتیجه تست به‌صورت PDF (با همان ظاهر TDEE الآن / TDEE ایده‌آل) ========== -->
		<script>
		(function () {
			if (window._afQPdfDownload) return;
			window._afQPdfDownload = true;

			var LIBS_LOADED = null;

			function loadScript(src) {
				return new Promise(function (resolve, reject) {
					var s = document.createElement('script');
					s.src = src;
					s.onload = resolve;
					s.onerror = reject;
					document.head.appendChild(s);
				});
			}

			function ensureLibs() {
				if (LIBS_LOADED) return LIBS_LOADED;
				LIBS_LOADED = Promise.resolve()
					.then(function () {
						if (typeof window.html2canvas === 'undefined') {
							return loadScript('https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js');
						}
					})
					.then(function () {
						if (!window.jspdf) {
							return loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
						}
					});
				return LIBS_LOADED;
			}

function captureElement(el) {
	if (!el) return Promise.reject(new Error('Target element not found'));

	function measure() {
		void el.offsetHeight; // اجبار به reflow
		var rect = el.getBoundingClientRect();
		return { w: Math.ceil(rect.width), h: Math.ceil(rect.height) };
	}

	function attempt(retriesLeft) {
		var size = measure();

		if (!size.w || !size.h) {
			if (retriesLeft > 0) {
				return new Promise(function (resolve) { setTimeout(resolve, 250); })
					.then(function () { return attempt(retriesLeft - 1); });
			}
			return Promise.reject(new Error(
				'Element has zero size before capture (w=' + size.w + ', h=' + size.h + ')'
			));
		}

		return window.html2canvas(el, {
			scale: 2,
			backgroundColor: '#F7F7F8',
			useCORS: true,
			allowTaint: true,
			logging: false
		}).then(function (canvas) {
			if ((!canvas.width || !canvas.height) && retriesLeft > 0) {
				return new Promise(function (resolve) { setTimeout(resolve, 250); })
					.then(function () { return attempt(retriesLeft - 1); });
			}
			return canvas;
		});
	}

	return attempt(4);
}

			function addImageAsPage(doc, canvas, isFirstPage) {
	if (!canvas || !canvas.width || !canvas.height) {
		throw new Error('Canvas capture failed (zero size)');
	}

	var pageWidth = doc.internal.pageSize.getWidth();
	var pageHeight = doc.internal.pageSize.getHeight();
	var margin = 24;
	var maxW = pageWidth - margin * 2;
	var imgW = maxW;
	var imgH = (canvas.height * imgW) / canvas.width;

	if (imgH > pageHeight - margin * 2) {
		imgH = pageHeight - margin * 2;
		imgW = (canvas.width * imgH) / canvas.height;
	}

	if (!isFirstPage) doc.addPage();
	var x = (pageWidth - imgW) / 2;
	var y = margin;

	// از JPEG به‌جای PNG استفاده می‌کنیم چون دیکودر PNG داخلی jsPDF
	// گاهی با خروجی toDataURL مرورگرها به‌درستی کار نمی‌کند و خطای
	// "Incomplete or corrupt PNG file" می‌دهد. JPEG پایدارتر است.
	var imgData = canvas.toDataURL('image/jpeg', 0.95);
	doc.addImage(imgData, 'JPEG', x, y, imgW, imgH);
}

			function generatePdf(btn) {
				var originalText = btn.textContent;
				btn.disabled = true;
				btn.textContent = 'در حال آماده‌سازی فایل...';

				var nowTab = document.getElementById('tdee-now');
				var idealTab = document.getElementById('tdee-ideal');
				var nowWasHidden = nowTab && nowTab.style.display === 'none';
				var idealWasHidden = idealTab && idealTab.style.display === 'none';

							ensureLibs()
				.then(function () {
					if (typeof window._afQRefreshResults === 'function') {
						window._afQRefreshResults();
					}
					// هر دو تب را موقتاً نمایان می‌کنیم تا هر دو به‌درستی عکس‌برداری شوند
					if (nowTab) nowTab.style.display = 'block';
					if (idealTab) idealTab.style.display = 'block';
					// اجبار به reflow فوری
					if (nowTab) void nowTab.offsetHeight;
					if (idealTab) void idealTab.offsetHeight;
					// تاخیر بیشتر تا مرورگر layout جدید را کامل اعمال کند
					return new Promise(function (resolve) { setTimeout(resolve, 250); });
				})
					.then(function () {
						return captureElement(nowTab);
					})
					.then(function (nowCanvas) {
						return captureElement(idealTab).then(function (idealCanvas) {
							return { nowCanvas: nowCanvas, idealCanvas: idealCanvas };
						});
					})
					.then(function (canvases) {
						var jsPDF = window.jspdf.jsPDF;
						var doc = new jsPDF({ unit: 'pt', format: 'a4' });
						addImageAsPage(doc, canvases.nowCanvas, true);
						addImageAsPage(doc, canvases.idealCanvas, false);
						doc.save('6tofit-tdee-result.pdf');
					})
					.catch(function (err) {
						console.error('AFQ PDF export error:', err);
						alert('متأسفانه در ساخت فایل PDF مشکلی پیش آمد. لطفاً دوباره تلاش کنید.');
					})
					.then(function () {
						// بازگرداندن وضعیت نمایش تب‌ها به حالت قبل
						if (nowWasHidden && nowTab) nowTab.style.display = 'none';
						if (idealWasHidden && idealTab) idealTab.style.display = 'none';
						btn.disabled = false;
						btn.textContent = originalText;
					});
			}

			document.addEventListener('click', function (e) {
				var btn = e.target.closest('#af-tdee-download-btn');
				if (!btn || btn.disabled) return;
				generatePdf(btn);
			});
		})();
		</script>
	</div>

<div class="af-pro-q-page" data-page="4" style="display:none;">
		<div class="af-pro-q-result-box">

			<!-- عنوان گرادیان -->
			<div class="final-gradient-title">این برنامه دقیقاً برای تو طراحی شده</div>

			<!-- دکمه چرا این برنامه -->
		<button type="button" class="why-program-btn" onclick="AFQuestionnaire.goTo(6, 5, 1)">
	چرا این برنامه برات مناسبه؟
</button>

		<?php
$af_product_id = 315;
$af_product    = function_exists( 'wc_get_product' ) ? wc_get_product( $af_product_id ) : null;

$af_fa_digits = array( '0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹' );

if ( $af_product ) {
	$af_product_title = $af_product->get_name();

	$af_image_id  = $af_product->get_image_id();
	$af_product_image = $af_image_id ? wp_get_attachment_image_url( $af_image_id, 'medium' ) : '';
	if ( ! $af_product_image ) {
		$af_product_image = function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src() : 'http://6tofit.com/wp-content/uploads/2026/09/product-default.png';
	}

	$af_price_raw       = (float) $af_product->get_price();
	$af_price_formatted = number_format( $af_price_raw, 0, '.', ',' );
	$af_product_price   = strtr( $af_price_formatted, $af_fa_digits );

	$af_product_url          = get_permalink( $af_product_id );
	$af_product_buy_url      = method_exists( $af_product, 'add_to_cart_url' ) ? $af_product->add_to_cart_url() : $af_product_url;

	$af_product_tags = array();
	$af_terms = wc_get_product_terms( $af_product_id, 'product_cat', array( 'fields' => 'names' ) );
	if ( ! empty( $af_terms ) && ! is_wp_error( $af_terms ) ) {
		$af_product_tags = array_slice( $af_terms, 0, 3 );
	}
} else {
	// در صورت نبود ووکامرس یا نبود محصول با این شناسه، مقادیر پیش‌فرض
	$af_product_title    = 'برنامه ترکیبی';
	$af_product_image    = 'http://6tofit.com/wp-content/uploads/2026/09/product-default.png';
	$af_product_price    = '۱,۲۹۰,۰۰۰';
	$af_product_url      = '#';
	$af_product_buy_url  = '#';
	$af_product_tags     = array( 'کاهش وزن', 'عضله‌سازی', 'شخصی‌سازی' );
}
?>
<!-- کارت محصول (پویا - از محصول شناسه ۳۱۵) -->
		<div class="product-card special">
		

			<div class="product-icon">
				<img src="<?php echo esc_url( $af_product_image ); ?>" alt="<?php echo esc_attr( $af_product_title ); ?>">
			</div>

			<h3 class="product-card-title"><?php echo esc_html( $af_product_title ); ?></h3>

			<?php if ( ! empty( $af_product_tags ) ) : ?>
			<div class="product-tags">
				<?php foreach ( $af_product_tags as $af_tag ) : ?>
					<span class="product-tag"><?php echo esc_html( $af_tag ); ?></span>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

			<div class="product-price">
				<span class="price-from">شروع قیمت از</span>
				<span class="price-amount"><?php echo esc_html( $af_product_price ); ?></span>
				<span class="price-currency">تومان</span>
			</div>

			<div class="product-buttons">
				<a href="<?php echo esc_url( $af_product_url ); ?>" class="product-btn product-btn-details">جزئیات</a>
				<a href="<?php echo esc_url( $af_product_url ); ?>" class="product-btn product-btn-buy">خرید</a>
			</div>
		</div>
<div class="af-reviews-title">نظرات کاربران قبلی</div>
			<!-- اسلایدر نظرات -->
			<div class="af-reviews-section">
				<div class="af-reviews-slider">
					<div class="af-reviews-track">

						<div class="af-review-slide">
							<div class="af-review-card">
								<div class="af-review-avatar">
									<img src="http://6tofit.com/wp-content/uploads/2025/10/storyic.png" alt="نیلوفر شریفی">
								</div>
								<div class="af-review-name">نیلوفر شریفی</div>
								<div class="af-review-stars">
									<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
								</div>
								<div class="af-review-text">
									"واقعاً احساس کردم کسی هست که به‌طور کامل من رو درک کنه. برنامه غذایی و تمرینی که برام طراحی شد، کاملاً متناسب با سبک زندگی و اهدافم بود."
								</div>
							</div>
						</div>

						<div class="af-review-slide">
							<div class="af-review-card">
								<div class="af-review-avatar">
									<img src="http://6tofit.com/wp-content/uploads/2025/10/storyic.png" alt="سارا محمدی">
								</div>
								<div class="af-review-name">سارا محمدی</div>
								<div class="af-review-stars">
									<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
								</div>
								<div class="af-review-text">
									"تجربه خیلی خوبی بود. برنامه‌ای که گرفتم کاملاً با شرایط من هماهنگ بود و بالاخره تونستم با یک برنامه منظم به هدفم نزدیک بشم."
								</div>
							</div>
						</div>

						<div class="af-review-slide">
							<div class="af-review-card">
								<div class="af-review-avatar">
									<img src="http://6tofit.com/wp-content/uploads/2025/10/storyic.png" alt="مریم احمدی">
								</div>
								<div class="af-review-name">مریم احمدی</div>
								<div class="af-review-stars">
									<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
								</div>
								<div class="af-review-text">
									"چیزی که بیشتر از همه دوست داشتم این بود که برنامه واقعاً برای خودم طراحی شده بود و مجبور نبودم از برنامه‌های عمومی استفاده کنم."
								</div>
							</div>
						</div>

						<div class="af-review-slide">
							<div class="af-review-card">
								<div class="af-review-avatar">
									<img src="http://6tofit.com/wp-content/uploads/2025/10/storyic.png" alt="الهام رضایی">
								</div>
								<div class="af-review-name">الهام رضایی</div>
								<div class="af-review-stars">
									<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
								</div>
								<div class="af-review-text">
									"هم برنامه تمرینی و هم تغذیه خیلی دقیق و کاربردی بود. چیزی که باعث شد ادامه بدم، همین شخصی‌سازی برنامه برای شرایط خودم بود."
								</div>
							</div>
						</div>

					</div>
				</div>

				<div class="af-review-dots">
					<button class="af-review-dot active" data-slide="0" aria-label="نظر اول"></button>
					<button class="af-review-dot" data-slide="1" aria-label="نظر دوم"></button>
					<button class="af-review-dot" data-slide="2" aria-label="نظر سوم"></button>
					<button class="af-review-dot" data-slide="3" aria-label="نظر چهارم"></button>
				</div>
			</div>


		</div>

		<style>
			/* عنوان گرادیان */
			.final-gradient-title {
				text-align: center;
				font-size: 30px;
				font-weight: 500;
				margin-bottom: 20px;
				background: linear-gradient(to right, #E64910, #F51E55, #DE39B3, #C64CDB, #0083EB);
				-webkit-background-clip: text;
				background-clip: text;
				color: transparent;
			}
			.af-reviews-title {
	text-align: center;
	font-size: 24px;
	font-weight: 500;
	color: #161618;
	margin-bottom: 20px;
}

			/* دکمه چرا این برنامه */
			.why-program-btn {
				display: block;
				margin: 0 auto 28px;
				background: #F0F0F1;
				border: none;
				border-radius: 100000px;
				padding: 12px 10px;
				font-size: 18px;
				font-weight: 500;
				color: #161618;
				font-family: 'iranyekan', sans-serif;
				cursor: pointer;
				transition: background 0.2s;
			}
			.why-program-btn:hover {
				background: #e5e5e7;
			}

			/* ========== PRODUCT CARD ========== */
			.product-card {
				background-color: #FFFFFF;
				border-radius: 24px;
				box-shadow: 0px 0px 3px 0px #0000000F;
				display: flex;
				flex-direction: column;
				align-items: center;
				justify-content: center;
				padding: 40px 30px;
				text-align: center;
				position: relative;
				margin-bottom: 32px;
			}
			.product-card.special {
				box-shadow: 0px 0px 15px 0px #0000000F;
			}
			.special-badge {
				position: absolute;
				top: 15px;
				right: 8px;
				display: flex;
				align-items: center;
				gap: 4px;
				background-color: #FFFFFF;
				border-radius: 12px;
				padding: 4px 8px;
				font-size: 12px;
				font-weight: 700;
				color: #5247FF;
				z-index: 1;
			}
			.special-badge img {
				width: 16px;
				height: 16px;
			}
			.product-icon {
				margin-bottom: 20px;
			}
			.product-icon img {
				max-width: 120px;
				height: auto;
			}
			.product-card-title {
				font-size: 30px;
				font-weight: 500;
				color: #161618;
				margin: 0 0 20px 0;
				line-height: 1.3;
			}
			.product-tags {
				display: flex;
				justify-content: center;
				gap: 4px;
				margin-bottom: 20px;
				flex-wrap: wrap;
			}
			.product-tag {
				background-color: #F0F0F1;
				border-radius: 10000px;
				padding: 6px 8px;
				font-size: 12px;
				font-weight: 400;
				color: #161618;
			}
			.product-price {
				display: flex;
				align-items: center;
				justify-content: center;
				gap: 8px;
				margin-bottom: 30px;
				font-size: 20px;
				font-weight: 500;
			}
			.price-from { color: #65656D; }
			.price-amount { color: #161618; }
			.price-currency { color: #65656D; }
			.product-buttons {
				display: flex;
				gap: 16px;
				width: 100%;
				justify-content: center;
			}
			.product-btn {
				border-radius: 100px;
				padding: 12px 10px;
				font-size: 18px;
				font-weight: 700;
				cursor: pointer;
				transition: background-color 0.3s ease;
				border: none;
				text-align: center;
				min-width: 120px;
				text-decoration: none;
				display: inline-block;
			}
			.product-btn-details {
				background-color: #5247FF;
				color: #FFFFFF;
			}
			.product-btn-details:hover {
				background-color: #4239D0;
			}
			.product-btn-buy {
				background-color: #FFFFFF;
				color: #5247FF;
				border: 1px solid #5247FF;
			}
			.product-btn-buy:hover {
				background-color: #F0F0F1;
			}

			@media only screen and (max-width: 768px) {
				.product-card {
					height: auto;
					padding: 30px 20px;
				}
				.product-card-title {
					font-size: 24px;
				}
				.product-price {
					font-size: 18px;
				}
				.product-buttons {
					gap: 12px;
				}
				.product-btn {
					width: 100%;
					max-width: 104px;
				}
			}

			/* ========== REVIEWS SLIDER ========== */
			.af-reviews-section {
				width: 100%;
				position: relative;
				direction: rtl;
				overflow: hidden;
				box-sizing: border-box;
				margin-top: 10px;
			}
			.af-reviews-slider {
				width: 100%;
				overflow: hidden;
				cursor: grab;
				user-select: none;
				-webkit-user-select: none;
				touch-action: pan-y;
				box-sizing: border-box;
			}
			.af-reviews-slider.dragging {
				cursor: grabbing;
			}
			.af-reviews-track {
				display: flex;
				direction: ltr;
				width: max-content;
				transition: transform 0.55s cubic-bezier(.22, .61, .36, 1);
				will-change: transform;
			}
			.af-review-slide {
				flex: 0 0 420px;
				width: 420px;
				padding: 0 20px;
				box-sizing: border-box;
			}
			.af-review-card {
				width: 100%;
				min-height: 235px;
				box-sizing: border-box;
				background: #ffffff;
				border-radius: 28px;
				padding: 17px 28px 22px;
				text-align: center;
				box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.02);
			}
			.af-review-avatar {
				width: 43px;
				height: 43px;
				margin: 0 auto 8px;
				overflow: hidden;
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				flex-shrink: 0;
			}
			.af-review-avatar img {
				display: block;
				width: 100%;
				height: 100%;
				object-fit: cover;
				border-radius: 50%;
				-webkit-user-drag: none;
				pointer-events: none;
			}
			.af-review-name {
				font-size: 18px;
				font-weight: 500;
				line-height: 1.5;
				color: #202020;
				margin-bottom: 8px;
			}
			.af-review-stars {
				display: flex;
				justify-content: center;
				align-items: center;
				direction: ltr;
				gap: 2px;
				margin-bottom: 14px;
			}
			.af-review-stars span {
				display: block;
				font-size: 20px;
				line-height: 1;
				color: #FFD52F;
			}
			.af-review-text {
				font-size: 16px;
				font-weight: 400;
				line-height: 1.9;
				color: #666873;
				max-width: 340px;
				margin: 0 auto;
			}
			.af-review-dots {
				display: flex;
				justify-content: center;
				align-items: center;
				direction: ltr;
				gap: 8px;
				margin-top: 24px;
			}
			.af-review-dot {
				display: block;
				width: 7px;
				height: 7px;
				padding: 0;
				margin: 0;
				border: 0;
				outline: none;
				border-radius: 50%;
				background: #5046F5;
				opacity: 0.9;
				cursor: pointer;
				transition: width 0.3s ease, opacity 0.3s ease, border-radius 0.3s ease;
			}
			.af-review-dot.active {
				width: 32px;
				border-radius: 10px;
				opacity: 1;
			}

			@media (min-width: 769px) {
				.af-reviews-slider {
					padding-left: calc((100% - 420px) / 2);
					padding-right: calc((100% - 420px) / 2);
				}
			}
			@media (max-width: 768px) {
				.af-review-slide {
					flex: 0 0 88vw;
					width: 88vw;
					padding: 0 7px;
				}
				.af-review-card {
					min-height: 235px;
					border-radius: 27px;
					padding: 17px 22px 20px;
				}
				.af-review-name { font-size: 17px; }
				.af-review-stars span { font-size: 19px; }
				.af-review-text {
					font-size: 15px;
					line-height: 1.85;
					max-width: 100%;
				}
				.af-review-dots { margin-top: 20px; }
			}
			@media (max-width: 400px) {
				.af-review-slide {
					flex-basis: 92vw;
					width: 92vw;
				}
				.af-review-card {
					min-height: 225px;
					padding-left: 18px;
					padding-right: 18px;
				}
				.af-review-text { font-size: 14px; }
			}
		</style>

		<script>
		(function () {
			// اسلایدر نظرات
			var slider = document.querySelector('.af-reviews-slider');
			var track = document.querySelector('.af-reviews-track');
			var slides = document.querySelectorAll('.af-review-slide');
			var dots = document.querySelectorAll('.af-review-dot');

			if (!slider || !track || !slides.length) return;

			var currentIndex = 0;
			var startX = 0;
			var currentX = 0;
			var isDragging = false;
			var startTranslate = 0;
			var autoPlay = null;

			function getSlideWidth() {
				return slides[0].getBoundingClientRect().width;
			}

			function getTranslate() {
				var slideWidth = getSlideWidth();
				var sliderWidth = slider.getBoundingClientRect().width;
				return currentIndex * slideWidth - (sliderWidth - slideWidth) / 2;
			}

			function updateSlider(animate) {
				if (animate === undefined) animate = true;
				var translate = getTranslate();
				track.style.transition = animate ? 'transform 0.55s cubic-bezier(.22,.61,.36,1)' : 'none';
				track.style.transform = 'translateX(' + translate + 'px)';
				dots.forEach(function (dot, index) {
					dot.classList.toggle('active', index === currentIndex);
				});
			}

			function goToSlide(index) {
				if (index < 0) index = slides.length - 1;
				if (index >= slides.length) index = 0;
				currentIndex = index;
				updateSlider(true);
				restartAutoPlay();
			}

			dots.forEach(function (dot) {
				dot.addEventListener('click', function () {
					var index = parseInt(dot.getAttribute('data-slide'), 10);
					if (!isNaN(index)) goToSlide(index);
				});
			});

			function dragStart(e) {
				isDragging = true;
				slider.classList.add('dragging');
				startX = e.type === 'mousedown' ? e.clientX : e.touches[0].clientX;
				currentX = startX;
				startTranslate = getTranslate();
				track.style.transition = 'none';
				clearInterval(autoPlay);
			}

			function dragMove(e) {
				if (!isDragging) return;
				currentX = e.type === 'mousemove' ? e.clientX : e.touches[0].clientX;
				var diff = startX - currentX;
				track.style.transform = 'translateX(' + (startTranslate + diff) + 'px)';
			}

			function dragEnd() {
				if (!isDragging) return;
				isDragging = false;
				slider.classList.remove('dragging');
				var diff = startX - currentX;
				if (Math.abs(diff) > 50) {
					if (diff > 0) goToSlide(currentIndex + 1);
					else goToSlide(currentIndex - 1);
				} else {
					updateSlider(true);
					restartAutoPlay();
				}
			}

			slider.addEventListener('mousedown', dragStart);
			window.addEventListener('mousemove', dragMove);
			window.addEventListener('mouseup', dragEnd);
			slider.addEventListener('touchstart', dragStart, { passive: true });
			slider.addEventListener('touchmove', dragMove, { passive: true });
			slider.addEventListener('touchend', dragEnd);

			function startAutoPlay() {
				autoPlay = setInterval(function () {
					goToSlide(currentIndex + 1);
				}, 4500);
			}
			function restartAutoPlay() {
				clearInterval(autoPlay);
				startAutoPlay();
			}

			slider.addEventListener('mouseenter', function () { clearInterval(autoPlay); });
			slider.addEventListener('mouseleave', function () {
				if (!isDragging) restartAutoPlay();
			});

			window.addEventListener('resize', function () { updateSlider(false); });

			setTimeout(function () {
				updateSlider(false);
				startAutoPlay();
			}, 100);

			// دکمه «چرا این برنامه برات مناسبه؟» (فعلاً فقط لاگ می‌کند، بعداً پاپ‌آپ اضافه می‌شود)
			var whyBtn = document.getElementById('af-why-program-btn');
			if (whyBtn) {
				whyBtn.addEventListener('click', function () {
					// اینجا بعداً پاپ‌آپ جدید باز می‌شود
					console.log('باز کردن پاپ‌آپ توضیح برنامه');
				});
			}
		})();
		</script>
	</div>
<!-- صفحه توضیح «چرا این برنامه مناسبه» -->
		<div class="af-pro-q-page" data-page="5" style="display:none;">
		<div class="af-pro-q-result-box">

			<!-- باکس مقایسه TDEE -->
			<div class="why-tdee-box">
				<div class="why-tdee-label">TDEE الان:</div>

				<div class="tdee-ideal-calorie">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/fireemo.png" alt="" class="tdee-ideal-calorie-icon">
					<span class="tdee-ideal-number" id="af-s6-why-now-cal">۱۸۰۰</span>
					<span class="tdee-ideal-unit">کالری</span>
				</div>

				<!-- خط با آیکن وسط -->
				<div class="why-tdee-divider">
					<div class="why-tdee-line"></div>
					<div class="why-tdee-divider-icon">
						<img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqop.svg" alt="">
					</div>
					<div class="why-tdee-line"></div>
				</div>

				<div class="why-tdee-label">TDEE هدف:</div>

				<div class="tdee-ideal-calorie">
					<img src="http://6tofit.com/wp-content/uploads/2026/09/🎯-Direct-Hit.png" alt="" class="tdee-ideal-calorie-icon">
					<span class="tdee-ideal-number" id="af-s6-why-goal-cal">۱۸۰۰</span>
					<span class="tdee-ideal-unit">کالری</span>
				</div>

				<p class="why-tdee-desc">
					این برنامه بر اساس نیازهای واقعی تو طراحی شده. اینجا بهت نشون می‌دیم چرا این برنامه بهترین انتخاب تو برای رسیدن به هدفته.
				</p>
			</div>

			<!-- چهار کارت -->
			<div class="tdee-ideal-cards">
				<div class="tdee-ideal-card">
					<div class="tdee-ideal-card-header">
						<div class="tdee-ideal-card-icon">
							<img src="http://6tofit.com/wp-content/uploads/2026/09/sand.png" alt="">
						</div>
						<h2 class="tdee-ideal-card-title">TEF - تأثیر غذا بر متابولیسم</h2>
					</div>
					<div class="tdee-ideal-card-divider"></div>
					<p class="why-card-text">
رژیم غذایی درست، فقط کالری کم نمی‌کنه؛ باعث می‌شه بدنت انرژی بیشتری برای هضم و جذب صرف کنه. ما با تغذیه هوشمند، پروتیین مصرفیت و بالا و میبریم و کاری می‌کنیم TEF بالا بره و به TDEE هدفت نزدیک‌تر بشی.
					</p>
				</div>

				<div class="tdee-ideal-card">
					<div class="tdee-ideal-card-header">
						<div class="tdee-ideal-card-icon">
							<img src="http://6tofit.com/wp-content/uploads/2026/09/shoemo.png" alt="">
						</div>
						<h2 class="tdee-ideal-card-title">NEAT - تحرک روزمره</h2>
					</div>
					<div class="tdee-ideal-card-divider"></div>
					<p class="why-card-text">
راه رفتن، ایستادن، بالا رفتن از پله… همه اینا مهمن. برنامه‌ای که داری، کمک می‌کنه NEAT رو در سبک زندگی روزمره‌ات بالا ببری، بدون نیاز به ورزش سنگین.
					</p>
				</div>

				<div class="tdee-ideal-card">
					<div class="tdee-ideal-card-header">
						<div class="tdee-ideal-card-icon">
							<img src="http://6tofit.com/wp-content/uploads/2026/09/Weight.png" alt="">
						</div>
						<h2 class="tdee-ideal-card-title">Exercise - تمرینات هدفمند</h2>
					</div>
					<div class="tdee-ideal-card-divider"></div>
					<p class="why-card-text">
ورزش فقط برای چربی‌سوزی نیست. تمرینات برنامه ما باعث عضله‌سازی هم می‌شن، و این یعنی متابولیسم فعال‌تر، مصرف انرژی بیشتر، و TDEE پایین‌تر به‌مرور زمان.
					</p>
				</div>

				<div class="tdee-ideal-card">
					<div class="tdee-ideal-card-header">
						<div class="tdee-ideal-card-icon">
							<img src="http://6tofit.com/wp-content/uploads/2026/09/fireemo.png" alt="">
						</div>
						<h2 class="tdee-ideal-card-title">BMR - سوخت‌وساز پایه بدن</h2>
					</div>
					<div class="tdee-ideal-card-divider"></div>
					<p class="why-card-text">
وقتی عضله‌سازی کنی، حتی در حال استراحت هم کالری بیشتری می‌سوزونی. این یعنی BMR بالاتر و قدمی دیگه برای رسیدن به هدف.
					</p>
				</div>

					<div class="tdee-ideal-card">
					<div class="tdee-ideal-card-header">
						<div class="tdee-ideal-card-icon">
							<img src="http://6tofit.com/wp-content/uploads/2026/09/🎯-Direct-Hit.png" alt="">
						</div>
						<h2 class="tdee-ideal-card-title">برنامه ترکیبی بهترین انتخاب برای هدف شما</h2>
					</div>
					<div class="tdee-ideal-card-divider"></div>
					<p class="why-card-text">
برنامه ترکیبی، دقیقا برای نیاز تو طراحی شده. با تغذیه اصولی و تمرینات هوشمند، بهت کمک می‌کنیم قدم‌به‌قدم به هدفت برسی.
					</p>
				</div>

			</div>

			<button type="button" class="af-pro-q-btn af-pro-q-btn-active" 
				onclick="AFQuestionnaire.goTo(6, 4, 1)">
				متوجه شدم
			</button>
		</div>

		<style>
			/* باکس مقایسه TDEE */
			.why-tdee-box {
				background: #FFFFFF;
				border-radius: 24px;
				padding: 24px 20px;
				margin-bottom: 24px;
				box-shadow: 0 2px 4px rgba(0,0,0,0.06);
			}
			.why-tdee-label {
				text-align: right;
				font-size: 18px;
				color: #65656D;
				margin-bottom: 10px;
			}
			.why-tdee-divider {
				display: flex;
				align-items: center;
				gap: 12px;
				margin: 20px 0;
			}
			.why-tdee-line {
				flex: 1;
				height: 1px;
				background: #F0F0F1;
			}
			.why-tdee-divider-icon {
				width: 28px;
				height: 28px;
				display: flex;
				align-items: center;
				justify-content: center;
				flex-shrink: 0;
			}
			.why-tdee-divider-icon img {
				width: 24px;
				height: 24px;
				object-fit: contain;
			}
			.why-tdee-desc {
				text-align: center;
				font-size: 16px;
				color: #65656D;
				line-height: 1.8;
				margin: 20px 0 0;
			}

			/* متن داخل کارت‌ها */
			.why-card-text {
				font-size: 16px;
				color: #161618;
				line-height: 1.8;
				text-align: right;
				margin: 0;
			}

			/* استفاده مجدد از استایل‌های قبلی calorie و card */
			.tdee-ideal-calorie {
				display: flex;
				align-items: baseline;
				justify-content: center;
				gap: 8px;
				margin-bottom: 8px;
			}
			.tdee-ideal-calorie-icon {
				width: 36px;
				height: 36px;
				object-fit: contain;
			}
			.tdee-ideal-number {
				font-size: 44px;
				font-weight: 700;
				color: #161618;
				line-height: 1;
			}
			.tdee-ideal-unit {
				font-size: 30px;
				color: #65656D;
				font-weight: 500;
			}

			.tdee-ideal-cards {
				display: flex;
				flex-direction: column;
				gap: 20px;
				margin-bottom: 28px;
			}
			.tdee-ideal-card {
				padding: 28px 24px;
				background-color: #FFFFFF;
				border-radius: 24px;
				box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
			}
			.tdee-ideal-card-header {
				display: flex;
				align-items: center;
				gap: 10px;
			
			}
			.tdee-ideal-card-icon img {
				width: 28px;
				height: 28px;
				object-fit: contain;
			}
			.tdee-ideal-card-title {
				font-size: 20px;
				font-weight: bold;
				color: #161618;
				text-align: right;
				margin: 0;
			}
			.tdee-ideal-card-divider {
				width: 100%;
				height: 1px;
				background-color: #F0F0F1;
				margin: 14px 0;
			}
		</style>

		<script>
		(function () {
			// تغییر عنوان پاپ‌آپ وقتی این صفحه نمایش داده می‌شود
			var pageEl = document.querySelector('.af-pro-questionnaire-section[data-section="6"] .af-pro-q-page[data-page="5"]');
			if (!pageEl) return;

			var originalTitle = 'پرسشنامه هوشمند';

			function setTitle(title) {
				var titleEl = document.getElementById('af-pro-questionnaire-title');
				if (titleEl) titleEl.textContent = title;
			}

			var observer = new MutationObserver(function () {
				if (pageEl.style.display !== 'none') {
					setTitle('چرا این برنامه برات مناسبه؟');
				} else {
					// وقتی از صفحه خارج شد، عنوان را برگردان (اختیاری)
					 setTitle(originalTitle);
				}
			});
			observer.observe(pageEl, { attributes: true, attributeFilter: ['style'] });
		})();
		</script>
	</div>


	<style>
	.af-pro-q-result-box {
		text-align: center;
		padding: 30px 15px;
		font-family: 'iranyekan', sans-serif;
	}
	.af-pro-q-result-box h3 {
		font-size: 22px;
		margin-bottom: 16px;
		color: #161618;
	}
	.af-pro-q-result-box p {
		font-size: 16px;
		line-height: 1.8;
		color: #444;
	}
	.af-pro-q-result-note {
		font-size: 14px !important;
		color: #9B9BA1 !important;
		margin-top: 20px;
	}
	</style>

	<script>
	(function () {
		if (window._afQS6) return;
		window._afQS6 = true;
		document.addEventListener('click', function (e) {
			if (e.target.closest('#af-pro-q-finish-btn')) {
				if (typeof AFQuestionnaire !== 'undefined') {
					AFQuestionnaire.completeAndClose();
				}
			}
		});
	})();
	</script>
</div>

<!-- ========================================================
     CORE SCRIPT (از questionnaire.js) + داده‌های AJAX
     این اسکریپت کلی زیر همه صفحات است.
======================================================== -->
<?php
$identity = function_exists( 'af_questionnaire_get_current_identity' ) ? af_questionnaire_get_current_identity() : array( 'type' => 'guest', 'token' => '' );
?>
<script>
var afQuestionnaireData = <?php echo wp_json_encode( array(
	'ajax_url'       => admin_url( 'admin-ajax.php' ),
	'nonce'          => wp_create_nonce( defined( 'AF_QUESTIONNAIRE_NONCE_ACTION' ) ? AF_QUESTIONNAIRE_NONCE_ACTION : 'af_questionnaire_nonce' ),
	'is_logged_in'   => is_user_logged_in(),
	'guest_token'    => ( isset( $identity['type'] ) && 'guest' === $identity['type'] ) ? ( $identity['token'] ?? '' ) : '',
	'total_sections' => defined( 'AF_QUESTIONNAIRE_TOTAL_SECTIONS' ) ? AF_QUESTIONNAIRE_TOTAL_SECTIONS : 6,
) ); ?>;
</script>
<script>
/**
 * Questionnaire System - Frontend Core (Vanilla JS)
 * بدون لاگین. پشتیبانی کامل از مهمان + لاگین‌شده.
 * ذخیره لایو پاسخ‌ها و دسترسی به جواب‌های قبلی.
 */
var AFQuestionnaire = (function () {
	'use strict';

	var state = {
		questionnaireId: null,
		currentSection: 1,
		currentPage: 1,
		currentQuestion: 1,
		answersCache: {},
		history: []
	};

	var els = {};

	function cacheElements() {
		els.overlay          = document.getElementById('af-pro-questionnaire-overlay');
		els.loading          = document.getElementById('af-pro-questionnaire-loading');
		els.error            = document.getElementById('af-pro-questionnaire-error');
		els.resumeDialog     = document.getElementById('af-pro-questionnaire-resume-dialog');
		els.btnContinue      = document.getElementById('af-pro-questionnaire-btn-continue');
		els.btnRestart       = document.getElementById('af-pro-questionnaire-btn-restart');
		els.sectionContainer = document.getElementById('af-pro-questionnaire-section-container');
		els.closeBtn         = document.getElementById('af-pro-questionnaire-close');
		els.backBtn          = document.getElementById('af-pro-questionnaire-back');
		els.title            = document.getElementById('af-pro-questionnaire-title');
		els.desc             = document.getElementById('af-pro-questionnaire-desc');
	}

	function showLoading(show) {
		if (els.loading) els.loading.style.display = show ? 'flex' : 'none';
		if (els.sectionContainer) els.sectionContainer.style.display = show ? 'none' : 'block';
		if (els.resumeDialog && show) els.resumeDialog.style.display = 'none';
	}

	function showError(message) {
		if (!els.error) return;
		if (!message) {
			els.error.style.display = 'none';
			els.error.textContent = '';
			return;
		}
		els.error.textContent = message;
		els.error.style.display = 'block';
	}

	function showResumeDialog(show) {
		if (els.resumeDialog) els.resumeDialog.style.display = show ? 'block' : 'none';
		if (els.sectionContainer) els.sectionContainer.style.display = show ? 'none' : 'block';
	}

	function setHeader(title, desc) {
		if (els.title) els.title.textContent = title || 'پرسشنامه هوشمند';
		if (els.desc) els.desc.textContent = desc || '';
	}

	/* ------------------------------------------------------
	 * AJAX
	 * ------------------------------------------------------ */
	function toFormBody(data) {
		var params = new URLSearchParams();
		Object.keys(data).forEach(function (key) {
			params.append(key, data[key]);
		});
		return params;
	}

	function ajaxRequest(action, extraData, onSuccess, onError) {
		var data = Object.assign({
			action: action,
			nonce: afQuestionnaireData.nonce
		}, extraData || {});

		showError(null);
		showLoading(true);

		fetch(afQuestionnaireData.ajax_url, {
			method: 'POST',
			credentials: 'same-origin',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
			body: toFormBody(data)
		})
		.then(function (r) { return r.json(); })
		.then(function (response) {
			showLoading(false);
			if (response && response.success) {
				if (typeof onSuccess === 'function') onSuccess(response.data);
			} else {
				var msg = (response && response.data && response.data.message) ? response.data.message : 'خطایی رخ داد.';
				showError(msg);
				if (typeof onError === 'function') onError(response);
			}
		})
		.catch(function () {
			showLoading(false);
			showError('ارتباط با سرور برقرار نشد.');
			if (typeof onError === 'function') onError();
		});
	}

	/* ------------------------------------------------------
	 * Navigation & Render
	 * ------------------------------------------------------ */
	function applyPosition(data) {
		state.questionnaireId = data.questionnaire_id;
		state.currentSection  = data.current_section;
		state.currentPage     = data.current_page;
		state.currentQuestion = data.current_question;
		renderCurrent();
	}

	function renderCurrent() {
		if (!els.sectionContainer) return;

		// مخفی کردن همه sectionها
		els.sectionContainer.querySelectorAll('.af-pro-questionnaire-section').forEach(function (s) {
			s.style.display = 'none';
		});

		var sectionEl = els.sectionContainer.querySelector('.af-pro-questionnaire-section[data-section="' + state.currentSection + '"]');
		if (!sectionEl) {
			showError('بخش مورد نظر یافت نشد.');
			return;
		}
		sectionEl.style.display = 'block';

		// صفحات
		sectionEl.querySelectorAll('.af-pro-q-page').forEach(function (p) {
			p.style.display = 'none';
		});
		var pageEl = sectionEl.querySelector('.af-pro-q-page[data-page="' + state.currentPage + '"]');
		if (pageEl) {
			pageEl.style.display = 'block';
		}

		// سوالات داخل صفحه (صفحه متنی بدون سوال هم فقط صفحه را نشان می‌دهد)
		if (pageEl) {
			pageEl.querySelectorAll('.af-pro-q-question').forEach(function (q) {
				q.style.display = 'none';
			});

			if (state.currentQuestion && state.currentQuestion > 0) {
				var gender = state.answersCache.s1_gender || 'male';
				var qEl = null;

				// برای سوالات شرطی جنسیت، فقط گروه درست را انتخاب کن
				if (state.currentSection === 5 && state.currentQuestion >= 10) {
					var genderClass = (gender === 'female') ? 'af-pro-q-gender-female' : 'af-pro-q-gender-male';
					qEl = pageEl.querySelector('.af-pro-q-question.' + genderClass + '[data-question="' + state.currentQuestion + '"]');
				}
				if (!qEl) {
					qEl = pageEl.querySelector('.af-pro-q-question[data-question="' + state.currentQuestion + '"]');
				}
				if (qEl) {
					qEl.style.display = 'block';
				}
			}
		}

		// آپدیت progress text در بخش ۱
		updateProgressUI();

		// اگر جواب قبلی وجود دارد، گزینه را انتخاب کن (برای برگشت)
		restorePreviousAnswer();

		updateBackButtonUI();
	}

	function updateBackButtonUI() {
		if (!els.backBtn) return;
		// از بخش نتایج (۶) امکان بازگشت به بخش‌های قبلی وجود ندارد
		var canGoBack = state.history.length > 0 && state.currentSection !== 6;
		els.backBtn.style.display = canGoBack ? 'flex' : 'none';
	}

	function updateProgressUI() {
		if (state.currentSection !== 1) return;
		var total = 8;
		var current = state.currentQuestion;
		var percent = Math.min(100, (current / total) * 100);
		var fill = document.getElementById('af-pro-q-s1-progress-fill');
		var text = document.getElementById('af-pro-q-s1-progress-text');
		if (fill) fill.style.width = percent + '%';
		if (text) text.textContent = 'سوال ' + current + ' از ' + total;
	}

	function restorePreviousAnswer() {
		var key = null;
		var sectionEl = els.sectionContainer.querySelector('.af-pro-questionnaire-section[data-section="' + state.currentSection + '"]');
		if (!sectionEl) return;
		var qEl = sectionEl.querySelector('.af-pro-q-question[data-question="' + state.currentQuestion + '"]');
		if (!qEl) return;
		key = qEl.getAttribute('data-key');
		if (!key || !state.answersCache[key]) return;

		var val = state.answersCache[key];
		var input = qEl.querySelector('input[type="radio"][value="' + val + '"]');
		if (input) {
			input.checked = true;
			input.dispatchEvent(new Event('change', { bubbles: true }));
		}
	}

	/* ------------------------------------------------------
	 * Public API
	 * ------------------------------------------------------ */
	function open() {
		cacheElements();
		if (!els.overlay) return;
		els.overlay.classList.add('active');
		document.body.style.overflow = 'hidden';
		setHeader('پرسشنامه هوشمند', '');
		showError(null);
		state.history = [];
		updateBackButtonUI();
		checkStatus();
	}

	function close() {
		if (els.overlay) els.overlay.classList.remove('active');
		document.body.style.overflow = '';
	}

	function checkStatus() {
		ajaxRequest('af_questionnaire_check_status', {}, function (data) {
			if (data.has_attempt) {
				state.questionnaireId = data.questionnaire_id;
				state.currentSection  = data.current_section;
				state.currentPage     = data.current_page;
				state.currentQuestion = data.current_question;
				showResumeDialog(true);
			} else {
				showResumeDialog(false);
				start();
			}
		});
	}

	function start() {
		ajaxRequest('af_questionnaire_start', {}, function (data) {
			showResumeDialog(false);
			applyPosition(data);
			loadAnswersCache();
		});
	}

	function resume() {
		ajaxRequest('af_questionnaire_resume', {}, function (data) {
			showResumeDialog(false);
			applyPosition(data);
			loadAnswersCache();
		});
	}

	function restart() {
		ajaxRequest('af_questionnaire_restart', {}, function (data) {
			showResumeDialog(false);
			state.answersCache = {};
			applyPosition(data);
		});
	}

	function goTo(section, page, question, opts) {
		opts = opts || {};
		if (!opts.skipHistory) {
			state.history.push({
				section:  state.currentSection,
				page:     state.currentPage,
				question: state.currentQuestion
			});
		}
		state.currentSection  = section;
		state.currentPage     = page;
		state.currentQuestion = question;
		renderCurrent();
	}

	function goBack() {
		// از بخش نتایج امکان بازگشت به بخش‌های قبلی وجود ندارد
		if (state.currentSection === 6) return;
		if (!state.history.length) return;
		var prev = state.history.pop();
		goTo(prev.section, prev.page, prev.question, { skipHistory: true });
	}

	function saveAndGo(opts) {
		if (!state.questionnaireId) return;

		var payload = {
			questionnaire_id: state.questionnaireId,
			section: opts.section,
			page: opts.page,
			question_key: opts.question_key,
			question_number: opts.question_number,
			answer: opts.answer,
			next_section: opts.next_section || opts.section,
			next_page: opts.next_page,
			next_question: opts.next_question
		};

		ajaxRequest('af_questionnaire_save_answer', payload, function () {
			// کش محلی
			state.answersCache[opts.question_key] = opts.answer;

			// اگر به بخش نتایج می‌رویم، complete کن
			if (payload.next_section === 6) {
				ajaxRequest('af_questionnaire_complete', {
					questionnaire_id: state.questionnaireId
				}, function () {
					goTo(6, 1, 1);
				});
			} else {
				goTo(payload.next_section, payload.next_page, payload.next_question);
			}
		});
	}

	function saveAnswerOnly(opts, callback) {
		if (!state.questionnaireId) return;
		var payload = {
			questionnaire_id: state.questionnaireId,
			section: opts.section,
			page: opts.page,
			question_key: opts.question_key,
			question_number: opts.question_number,
			answer: opts.answer
		};
		ajaxRequest('af_questionnaire_save_answer', payload, function () {
			state.answersCache[opts.question_key] = opts.answer;
			if (typeof callback === 'function') callback();
		});
	}

	function getAnswers(callback) {
		if (!state.questionnaireId) {
			if (typeof callback === 'function') callback(state.answersCache);
			return;
		}
		ajaxRequest('af_questionnaire_get_answers', {
			questionnaire_id: state.questionnaireId
		}, function (data) {
			if (data && data.answers) {
				state.answersCache = data.answers;
			}
			if (typeof callback === 'function') callback(state.answersCache);
		});
	}

	function loadAnswersCache() {
		getAnswers(function () {});
	}

	function completeAndClose() {
		if (!state.questionnaireId) {
			close();
			return;
		}
		ajaxRequest('af_questionnaire_complete', {
			questionnaire_id: state.questionnaireId
		}, function () {
			close();
		}, function () {
			close();
		});
	}

	/* ------------------------------------------------------
	 * Event Bindings
	 * ------------------------------------------------------ */
	function bindEvents() {
		cacheElements();
		if (els.closeBtn) {
			els.closeBtn.addEventListener('click', close);
		}
		if (els.backBtn) {
			els.backBtn.addEventListener('click', goBack);
		}
		if (els.overlay) {
			els.overlay.addEventListener('click', function (e) {
				if (e.target === els.overlay) close();
			});
		}
		if (els.btnContinue) {
			els.btnContinue.addEventListener('click', resume);
		}
		if (els.btnRestart) {
			els.btnRestart.addEventListener('click', restart);
		}
	}

	// Init
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', bindEvents);
	} else {
		bindEvents();
	}

	return {
		open: open,
		close: close,
		goTo: goTo,
		goBack: goBack,
		saveAndGo: saveAndGo,
		saveAnswerOnly: saveAnswerOnly,
		getAnswers: getAnswers,
		completeAndClose: completeAndClose
	};
})();
</script>