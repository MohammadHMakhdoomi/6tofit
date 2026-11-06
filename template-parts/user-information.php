<?php
function render_user_info_popup($title = "اطلاعات کاربری", $submit_text = "ادامه") {
    ob_start();
?>
<style>
/* ==================== User Info Popup Base ==================== */
.userinfo-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(13, 13, 13, 0.56);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    backdrop-filter: blur(50px);
    -webkit-backdrop-filter: blur(50px);
}

.userinfo-popup-overlay.active {
    display: flex !important;
}

.userinfo-popup-content {
    background: #F7F7F8;
    border-radius: 40px;
    text-align: center;
    overflow: hidden;
	    min-width: 700px;
}


.userinfo-popup-content .userinfo-stage {
    display: none;
}

.userinfo-popup-content .userinfo-stage.active {
    display: block;
}

/* ==================== Stage Wrapper (مشترک بین استیج‌ها) ==================== */
.userinfo-stage-wrapper {
    display: flex;
    height: 100%;
    min-height: 520px;
    border-radius: 40px;
    overflow: hidden;
}

.userinfo-stage-left {
    flex: 1.4;
    display: flex;
    align-items: center;
    justify-content: center;
}

.userinfo-stage-image {
    width: 60%;
    display: block;
}

.userinfo-stage-right {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;

    background: #ffffff;
}

.userinfo-stage-box {
    background: #FFFFFF;
    border-radius: 28px;
    padding: 96px 72px;
    width: 100%;

    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

/* دکمه بستن */
.userinfo-close {
    position: absolute;
    top: 16px;
    right: 16px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    z-index: 10;
}

.userinfo-close img {
    width: 40px;
    height: 40px;
}

/* لوگو */
.userinfo-logo {
    margin-bottom: 28px;
    margin-top: 12px;
}

.userinfo-logo img {
    height: 42px;
    width: auto;
}

/* عنوان و توضیحات */
.userinfo-title {
    font-size: 24px;
    font-weight: 700;
    color: #000000;
    margin: 0 0 12px 0;
    text-align: center;
}

.userinfo-desc {
    font-size: 14px;
    font-weight: 400;
    color: #6B6B6F;
    line-height: 1.7;
    text-align: center;
    margin: 0 0 28px 0;
}

/* فیلدهای فرم */
.userinfo-form-field {
    position: relative;
    width: 100%;
    max-width: 420px;
    margin-bottom: 16px;
}

.userinfo-form-field input {
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

.userinfo-form-field label {
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

.userinfo-form-field input:focus + label,
.userinfo-form-field input:not(:placeholder-shown) + label {
    opacity: 0;
    transform: translateY(-1.5rem);
}

/* دکمه اصلی */
.userinfo-submit-button {
    background: #000000;
    border: none;
    padding: 12px 10px;
    font-size: 15px;
    color: #FFFFFF;
    border-radius: 1000000px;
    cursor: pointer;
    font-family: 'iranyekan', sans-serif;
    min-width: 240px;

    max-width: 420px;
    height: 56px;
    margin-top: 8px;
    margin-bottom: 20px;
    transition: background-color 0.3s ease;
}

.userinfo-submit-button:hover {
    background: #000000;
}

.userinfo-submit-button.active {
    background: #000000;
    color: #FFFFFF;
}



/* ==================== موبایل ==================== */
@media only screen and (max-width: 768px) {
    .userinfo-popup-overlay {
        z-index: 9999;
    }
	.userinfo-stage-box{
		width:unset;
	}
.userinfo-popup-content{
	    min-width: unset;
}
.userinfo-popup-content:has(#userinfo-stage-3.active) {
   background: unset;
       display: flex;
    flex-direction: column;
    justify-content: flex-end;
}
    .userinfo-popup-content {
        width: 100%;
        height: 100%;
        border-radius: 0;
    }

    .userinfo-stage-wrapper {
        flex-direction: column;
        min-height: auto;
		    min-height: 100vh;
        border-radius: 0;
    }

    .userinfo-stage-left {
        display: none;
    }

    .userinfo-stage-right {
        padding: unset;
    }

    .userinfo-stage-box {
        padding: 28px 20px;
        border-radius: 24px;
        max-width: 100%;
    }

    .userinfo-close {
        top: 12px;
        right: 12px;
    }

    .userinfo-close img {
        width: 36px;
        height: 36px;
    }

    .userinfo-title {
        font-size: 22px;
    }

    .userinfo-desc {
        font-size: 13px;
        margin-bottom: 24px;
    }

    .userinfo-form-field,
    .userinfo-submit-button {
        max-width: 100%;
    }
}
</style>

<div class="userinfo-popup-overlay" id="userinfo-popup">
  <div class="userinfo-popup-content">

    <!-- ==================== استیج ۱ - مشاهده اطلاعات کاربری ==================== -->
<div class="userinfo-stage active" id="userinfo-stage-1">
  <div class="userinfo-stage-wrapper">
    <div class="userinfo-stage-right">
      <div class="userinfo-stage-box userinfo-view-box">

        <!-- دکمه بستن (آیکنش رو خودت بذار) -->
        <button class="userinfo-close">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/State.svg" alt="Close">
        </button>

        <!-- عنوان -->
        <h2 class="userinfo-view-title">اطلاعات کاربری</h2>

        <?php
        // گرفتن اطلاعات کاربر فعلی
        $current_user = wp_get_current_user();
        $user_id      = $current_user->ID;

        $fullname  = $current_user->display_name ?: '—';
        $phone     = get_user_meta($user_id, 'phone', true) ?: '—';
        $email     = $current_user->user_email ?: '—';
        $gender    = get_user_meta($user_id, 'gender', true);
        $birthdate = get_user_meta($user_id, 'birthdate', true) ?: '—';

        // تبدیل جنسیت به فارسی
        $gender_fa = match($gender) {
            'male'   => 'مرد',
            'female' => 'زن',
            'other'  => 'سایر',
            default  => '—'
        };

        // تصویر پروفایل
        $avatar_url = get_avatar_url($user_id, ['size' => 160]);
        ?>

        <!-- تصویر پروفایل گرد -->
        <div class="userinfo-avatar-wrapper">
          <img src="<?php echo esc_url($avatar_url); ?>" alt="Profile" class="userinfo-avatar">
        </div>

        <!-- لیست اطلاعات -->
        <div class="userinfo-info-list">

          <!-- نام و نام خانوادگی -->
          <div class="userinfo-info-row">
            <span class="userinfo-info-label">نام و نام خانوادگی</span>
            <span class="userinfo-info-value"><?php echo esc_html($fullname); ?></span>
          </div>

          <!-- شماره موبایل -->
          <div class="userinfo-info-row">
            <span class="userinfo-info-label">شماره موبایل</span>
            <span class="userinfo-info-value" dir="ltr"><?php echo esc_html($phone); ?></span>
          </div>

          <!-- ایمیل -->
          <div class="userinfo-info-row">
            <span class="userinfo-info-label">ایمیل</span>
            <span class="userinfo-info-value" dir="ltr"><?php echo esc_html($email); ?></span>
          </div>

          <!-- جنسیت -->
          <div class="userinfo-info-row">
            <span class="userinfo-info-label">جنسیت</span>
            <span class="userinfo-info-value"><?php echo esc_html($gender_fa); ?></span>
          </div>

          <!-- تاریخ تولد -->
          <div class="userinfo-info-row">
            <span class="userinfo-info-label">تاریخ تولد</span>
            <span class="userinfo-info-value"><?php echo esc_html($birthdate); ?></span>
          </div>

        </div>

        <!-- دکمه ویرایش -->
        <button class="userinfo-edit-btn" onclick="showUserInfoStage('userinfo-stage-2')">
          ویرایش
        </button>

      </div>
    </div>
  </div>
</div>
<style>
/* ==================== استیج ۱ - مشاهده اطلاعات ==================== */



/* عنوان */
.userinfo-view-title {
  font-size: 22px;
  font-weight: 600;
  color: #000000;
  margin: 42px 0 32px 0;
  text-align: right;
  width: 100%;
  padding-right: 68px;
}

/* تصویر پروفایل گرد */
.userinfo-avatar-wrapper {
  margin-bottom: 36px;
}

.userinfo-avatar {
  width: 110px;
  height: 110px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #F2F2F8;
  display: block;
}

/* لیست اطلاعات */
.userinfo-info-list {
  width: 100%;
  max-width: 420px;
  margin-bottom: 32px;
}

.userinfo-info-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 14px 0;
  border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.userinfo-info-row:last-child {
  border-bottom: none;
}

.userinfo-info-label {
  font-size: 14px;
  color: #9B9BA1;
  font-family: 'iranyekan', sans-serif;
  text-align: right;
}

.userinfo-info-value {
  font-size: 15px;
  color: #161618;
  font-weight: 600;
  font-family: 'iranyekan', sans-serif;
  text-align: left;
}

/* دکمه ویرایش */
.userinfo-edit-btn {
  background: #e9e9eb00;
  border: 1px solid #dddddd;
  padding: 12px 10px;
  font-size: 15px;
  color: #000000;
  border-radius: 1000000px;
  cursor: pointer;
  font-family: 'iranyekan', sans-serif;
  min-width: 220px;

  max-width: 420px;
  height: 56px;
  margin-top: 8px;
  margin-bottom: 10px;
  transition: background-color 0.3s ease;
}

.userinfo-edit-btn:hover {
  background: #D0D0D3;
}

/* موبایل */
@media only screen and (max-width: 768px) {
  .userinfo-view-box {
            padding: 32px 23px 28px !important;
        width: 100%;
		min-height: 100vh;
		        display: flex;
		        justify-content: space-between;
  }

  .userinfo-view-title {
    font-size: 20px !important;
    margin-bottom: 28px!important;
        margin-top: 0px!important;
        padding-right: 0px!important;
        margin-left: auto;
        margin-right: auto;
        text-align: center!important;
  }
  .userinfo-edit-btn{
	     width: 100%; 
  }

  .userinfo-avatar {
    width: 96px;
    height: 96px;
  }

  .userinfo-info-list {
    max-width: 100%;
  }
}
</style>

<!-- ==================== استیج ۲ - ویرایش اطلاعات کاربری ==================== -->
<div class="userinfo-stage" id="userinfo-stage-2">
  <div class="userinfo-stage-wrapper">
    <div class="userinfo-stage-right">
      <div class="userinfo-stage-box userinfo-edit-box">

        <!-- دکمه بازگشت (به جای ضربدر) -->
        <button class="userinfo-back-btn" onclick="showUserInfoStage('userinfo-stage-1')">
          <!-- آیکون بازگشت خودت رو اینجا بگذار -->
          <img src="http://6tofit.com/wp-content/uploads/2026/08/State-Layer.svg" alt="Back">
        </button>

        <!-- عنوان (راست‌چین مثل استیج ۱) -->
        <h2 class="userinfo-view-title">ویرایش اطلاعات</h2>

        <?php
        $current_user = wp_get_current_user();
        $user_id      = $current_user->ID;

        $fullname  = $current_user->display_name ?: '';
        $phone     = get_user_meta($user_id, 'phone', true) ?: '';
        $email     = $current_user->user_email ?: '';
        $gender    = get_user_meta($user_id, 'gender', true) ?: '';
        $birthdate = get_user_meta($user_id, 'birthdate', true) ?: '';
        $avatar_url = get_avatar_url($user_id, ['size' => 160]);
        ?>

        <!-- تصویر پروفایل + دکمه منو -->
        <div class="userinfo-avatar-edit-wrapper">
          <img src="<?php echo esc_url($avatar_url); ?>" alt="Profile" class="userinfo-avatar" id="userinfo-edit-avatar">
          
          <!-- دکمه باز کردن منو (گوشه پایین چپ) -->
          <button type="button" class="userinfo-avatar-menu-btn" id="userinfo-avatar-menu-btn">
            <!-- آیکون ویرایش/دوربین خودت رو اینجا بگذار -->
            <img src="http://6tofit.com/wp-content/uploads/2026/08/Editw.svg" alt="Edit Avatar">
          </button>

          <!-- منوی انتخاب عکس -->
          <div class="userinfo-avatar-menu" id="userinfo-avatar-menu">
            <button type="button" class="userinfo-avatar-menu-item" onclick="handleChooseFromFile()">
              <img src="http://6tofit.com/wp-content/uploads/2026/08/Image-Iconly-Pro.svg" alt="File">
              <span>انتخاب از فایل</span>
            </button>
            <button type="button" class="userinfo-avatar-menu-item" onclick="showUserInfoStage('userinfo-stage-4')">
              <img src="http://6tofit.com/wp-content/uploads/2026/08/Female-memoji.svg" alt="Emoji">
              <span>استفاده از مموجی</span>
            </button>
          </div>
        </div>

        <!-- نام و نام خانوادگی -->
        <div class="userinfo-form-field">
          <input type="text" id="userinfo-fullname" required placeholder=" " value="<?php echo esc_attr($fullname); ?>">
          <label for="userinfo-fullname">نام و نام خانوادگی</label>
        </div>

        <!-- شماره موبایل -->
        <div class="userinfo-form-field">
          <input type="text" id="userinfo-phone" required placeholder=" " value="<?php echo esc_attr($phone); ?>" dir="ltr">
          <label for="userinfo-phone">شماره موبایل</label>
        </div>

        <!-- ایمیل -->
        <div class="userinfo-form-field">
          <input type="email" id="userinfo-email" required placeholder=" " value="<?php echo esc_attr($email); ?>" dir="ltr">
          <label for="userinfo-email">ایمیل</label>
        </div>

        <!-- تاریخ تولد + آیکن -->
        <div class="userinfo-form-field userinfo-birthdate-field">
          <input type="text" id="userinfo-birthdate" required placeholder=" " readonly value="<?php echo esc_attr($birthdate); ?>">
          <label for="userinfo-birthdate">تاریخ تولد</label>
          <button type="button" class="userinfo-birthdate-icon" onclick="openUserInfoBirthdatePicker()">
            <img src="http://6tofit.com/wp-content/uploads/2026/08/Calendar-Iconly-Pro.svg" alt="Calendar">
          </button>
        </div>

        <!-- گزینه‌های جنسیت -->
        <div class="userinfo-gender-options">
          <button type="button" class="userinfo-gender-btn <?php echo $gender === 'female' ? 'selected' : ''; ?>" data-gender="female" onclick="selectUserInfoGender(this)">زن</button>
          <button type="button" class="userinfo-gender-btn <?php echo $gender === 'male' ? 'selected' : ''; ?>" data-gender="male" onclick="selectUserInfoGender(this)">مرد</button>
          <button type="button" class="userinfo-gender-btn <?php echo $gender === 'other' ? 'selected' : ''; ?>" data-gender="other" onclick="selectUserInfoGender(this)">سایر</button>
        </div>

        <!-- دکمه ذخیره تغییرات -->
        <button class="userinfo-submit-button" id="userinfo-submit-btn" onclick="handleUpdateUserInfo()">
          ذخیره تغییرات
        </button>

      </div>
    </div>
  </div>
</div>
<style>
/* ==================== استیج ۲ - فرم ویرایش ==================== */

.userinfo-birthdate-field {
  position: relative;
}
/* ==================== استیج ۲ - ویرایش (نسخه جدید) ==================== */

.userinfo-edit-box {

      padding: 76px 72px!important;
}

/* دکمه بازگشت (بالا سمت راست) */
.userinfo-back-btn {
  position: absolute;
  top: 16px;
  right: 16px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
  z-index: 10;
}

.userinfo-back-btn img {
  width: 40px;
  height: 40px;
}

/* عنوان راست‌چین */
.userinfo-edit-box .userinfo-view-title {
  font-size: 22px;
  font-weight: 600;
  color: #000000;
  margin: 12px 0 28px 0;
  text-align: right;
  width: 100%;
  padding-right: 8px;
}

/* ========== تصویر پروفایل + منو ========== */
.userinfo-avatar-edit-wrapper {
  position: relative;
  display: inline-block;
  margin-bottom: 32px;
}

.userinfo-avatar-edit-wrapper .userinfo-avatar {
  width: 110px;
  height: 110px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #F2F2F8;
  display: block;
}

/* دکمه باز کردن منو (گوشه پایین چپ تصویر) */
.userinfo-avatar-menu-btn {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 34px;
  height: 34px;
  border-radius: 50%;
  background: #C5C5C5;
  border: 2px solid #FFFFFF;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  padding: 0;
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  z-index: 5;
}

.userinfo-avatar-menu-btn img {
  width: 18px;
  height: 18px;
}

/* منوی انتخاب عکس */
.userinfo-avatar-menu {
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%);
  margin-top: 12px;
  background: #FFFFFF;
  border-radius: 16px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.12);
  padding: 8px;
  min-width: 210px;
  display: none;
  z-index: 20;
  flex-direction: column;
  gap: 4px;
}

.userinfo-avatar-menu.active {
  display: flex;
}

.userinfo-avatar-menu-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 14px;
  border: none;
  background: transparent;
  border-radius: 12px;
  cursor: pointer;
  font-family: 'iranyekan', sans-serif;
  font-size: 14px;
  color: #161618;
  transition: background 0.2s ease;
  text-align: right;
  width: 100%;
}

.userinfo-avatar-menu-item:hover {
  background: #F5F5F7;
}

.userinfo-avatar-menu-item img {
  width: 20px;
  height: 20px;
  flex-shrink: 0;
}

/* موبایل */
@media only screen and (max-width: 768px) {
  .userinfo-edit-box {
    padding: 28px 20px 24px !important;
	        width: 100%;
  }

  .userinfo-back-btn {
    top: 12px;
    right: 12px;
  }

  .userinfo-back-btn img {
    width: 36px;
    height: 36px;
  }

  .userinfo-avatar-edit-wrapper .userinfo-avatar {
    width: 96px;
    height: 96px;
  }

  .userinfo-avatar-menu-btn {
    width: 30px;
    height: 30px;
  }

  .userinfo-avatar-menu-btn img {
    width: 16px;
    height: 16px;
  }
}

.userinfo-birthdate-field input {
  padding-left: 48px !important;
}

.userinfo-birthdate-icon {
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

.userinfo-birthdate-icon img {
  width: 22px;
  height: 22px;
}

/* گزینه‌های جنسیت */
.userinfo-gender-options {
  display: flex;
  gap: 12px;
  width: 100%;
  max-width: 420px;
  margin-bottom: 24px;
}

.userinfo-gender-btn {
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

.userinfo-gender-btn:hover {
  border-color: rgba(0, 0, 0, 0.25);
}

.userinfo-gender-btn.selected {
  background: #FFFFFF;
  border-color:#5247FF;
  color:#161618;
}

/* دکمه ذخیره */
#userinfo-submit-btn {
  background: #000000;
  color: #ffffff;
}

#userinfo-submit-btn.active {
  background: #000000;
  color: #ffffff;
}


@media only screen and (max-width: 768px) {
  .userinfo-gender-options {
    max-width: 100%;
    gap: 8px;
  }
  #userinfo-submit-btn{
	  width:100%;
  }
  .userinfo-gender-btn {
           font-size: 12px;
        height: 46px;
  }
}
</style>
<script>
// منوی تغییر عکس پروفایل
document.addEventListener('DOMContentLoaded', function() {
  const menuBtn = document.getElementById('userinfo-avatar-menu-btn');
  const menu = document.getElementById('userinfo-avatar-menu');

  if (menuBtn && menu) {
    menuBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      menu.classList.toggle('active');
    });

    // بستن منو با کلیک بیرون
    document.addEventListener('click', function(e) {
      if (!menu.contains(e.target) && !menuBtn.contains(e.target)) {
        menu.classList.remove('active');
      }
    });
  }
});

// انتخاب از فایل (فعلاً ساده - بعداً می‌تونی آپلود واقعی وصل کنی)
// ==================== کراپ تصویر ====================
let cropImage = null;
let isDragging = false;
let startX, startY;
let currentX = 0;
let currentY = 0;
let imageScale = 1;

window.handleChooseFromFile = function() {
  const input = document.createElement('input');
  input.type = 'file';
  input.accept = 'image/*';
  
  input.onchange = function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(event) {
      openCropModal(event.target.result);
    };
    reader.readAsDataURL(file);
  };
  
  input.click();

  // بستن منوی آواتار
  document.getElementById('userinfo-avatar-menu')?.classList.remove('active');
};

function openCropModal(imageSrc) {
  const overlay = document.getElementById('userinfo-crop-overlay');
  const img = document.getElementById('userinfo-crop-image');
  
  img.src = imageSrc;
  cropImage = img;

  // ریست موقعیت
  currentX = 0;
  currentY = 0;
  imageScale = 1;
  updateCropImagePosition();

  // بعد از لود شدن تصویر، اندازه مناسب تنظیم شود
  img.onload = function() {
    const containerSize = 280;
    const imgRatio = img.naturalWidth / img.naturalHeight;

    if (imgRatio > 1) {
      // تصویر عریض
      img.style.height = containerSize + 'px';
      img.style.width = 'auto';
    } else {
      // تصویر بلند
      img.style.width = containerSize + 'px';
      img.style.height = 'auto';
    }
    updateCropImagePosition();
  };

  overlay.classList.add('active');
  initCropDrag();
}

function updateCropImagePosition() {
  if (!cropImage) return;
  cropImage.style.transform = `translate(calc(-50% + ${currentX}px), calc(-50% + ${currentY}px)) scale(${imageScale})`;
}

function initCropDrag() {
  const wrapper = document.getElementById('userinfo-crop-image-wrapper');
  
  // Mouse
  wrapper.onmousedown = function(e) {
    isDragging = true;
    startX = e.clientX - currentX;
    startY = e.clientY - currentY;
  };

  window.onmousemove = function(e) {
    if (!isDragging) return;
    currentX = e.clientX - startX;
    currentY = e.clientY - startY;
    updateCropImagePosition();
  };

  window.onmouseup = function() {
    isDragging = false;
  };

  // Touch
  wrapper.ontouchstart = function(e) {
    isDragging = true;
    startX = e.touches[0].clientX - currentX;
    startY = e.touches[0].clientY - currentY;
  };

  window.ontouchmove = function(e) {
    if (!isDragging) return;
    currentX = e.touches[0].clientX - startX;
    currentY = e.touches[0].clientY - startY;
    updateCropImagePosition();
  };

  window.ontouchend = function() {
    isDragging = false;
  };
}

function closeCropModal() {
  document.getElementById('userinfo-crop-overlay').classList.remove('active');
  document.getElementById('userinfo-crop-image').src = '';
}

function confirmCrop() {
  const img = document.getElementById('userinfo-crop-image');
  const containerSize = 280;

  // ساخت کانواس دایره‌ای
  const canvas = document.createElement('canvas');
  canvas.width = containerSize;
  canvas.height = containerSize;
  const ctx = canvas.getContext('2d');

  // رسم دایره
  ctx.beginPath();
  ctx.arc(containerSize / 2, containerSize / 2, containerSize / 2, 0, Math.PI * 2);
  ctx.closePath();
  ctx.clip();

  // محاسبه موقعیت تصویر
  const imgWidth = img.offsetWidth;
  const imgHeight = img.offsetHeight;

  const drawX = (containerSize / 2) - (imgWidth / 2) + currentX;
  const drawY = (containerSize / 2) - (imgHeight / 2) + currentY;

  ctx.drawImage(img, drawX, drawY, imgWidth, imgHeight);

  // تبدیل به base64 و قرار دادن در آواتار استیج ۲
  const croppedDataUrl = canvas.toDataURL('image/png');
  
  const stage2Avatar = document.getElementById('userinfo-edit-avatar');
  if (stage2Avatar) {
    stage2Avatar.src = croppedDataUrl;
    stage2Avatar.style.backgroundColor = 'transparent';
  }

  // اگر استیج ۴ هم باز بود، آپدیت کن
  const stage4Preview = document.getElementById('userinfo-avatar-editor-preview');
  if (stage4Preview) {
    stage4Preview.src = croppedDataUrl;
  }

  closeCropModal();
}
</script>

   <!-- ==================== استیج ۳ - انتخاب تاریخ تولد ==================== -->
<div class="userinfo-stage" id="userinfo-stage-3">
  <div class="userinfo-stage-4-wrapper">
    <div class="userinfo-stage-4-box">

      <!-- دکمه بستن -->
      <button class="userinfo-back-btn" onclick="showUserInfoStage('userinfo-stage-2')">
            <img src="http://6tofit.com/wp-content/uploads/2026/08/State-Layer.svg" alt="Back">
      </button>

      <!-- عنوان -->
      <h2 class="userinfo-stage-4-title">تاریخ تولد</h2>

      <!-- عنوان ستون‌ها -->
      <div class="userinfo-date-labels">
        <span>روز</span>
        <span>ماه</span>
        <span>سال</span>
      </div>

      <!-- انتخابگر تاریخ -->
      <div class="userinfo-date-picker">
        <div class="userinfo-date-highlight"></div>

        <div class="userinfo-date-column" data-type="day">
          <div class="userinfo-date-scroller" id="userinfo-day-scroller"></div>
        </div>

        <div class="userinfo-date-column" data-type="month">
          <div class="userinfo-date-scroller" id="userinfo-month-scroller"></div>
        </div>

        <div class="userinfo-date-column" data-type="year">
          <div class="userinfo-date-scroller" id="userinfo-year-scroller"></div>
        </div>
      </div>

      <!-- دکمه ادامه -->
      <button class="userinfo-submit-button active" id="userinfo-date-continue-btn" onclick="handleUserInfoDateContinue()">
        ادامه
      </button>

    </div>
  </div>
</div>
<style>
/* ==================== استیج ۳ - انتخابگر تاریخ ==================== */

.userinfo-stage-4-wrapper {
  display: flex;
  height: 100%;
  min-height: 520px;
  border-radius: 40px;
  overflow: hidden;
}

.userinfo-stage-4-box {
  background: #FFFFFF;
  border-radius: 28px;
  padding: 48px 72px 40px;
  width: 100%;
  min-width: 620px;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
}

.userinfo-stage-4-title {
  font-size: 20px;
  font-weight: 600;
  color: #000000;
  margin: 12px 0 28px 0;
  text-align: center;
}

.userinfo-date-labels {
  display: flex;
  width: 100%;
  margin-bottom: 12px;
  font-size: 16px;
  color: #000000;
  font-family: 'iranyekan', sans-serif;
}

.userinfo-date-labels span {
  flex: 1;
  text-align: center;
}

.userinfo-date-picker {
  position: relative;
  display: flex;
  width: 100%;
  height: 192px;
  margin-bottom: 36px;
  overflow: hidden;
  user-select: none;
  -webkit-user-select: none;
}

.userinfo-date-highlight {
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

.userinfo-date-column {
  flex: 1;
  height: 100%;
  overflow: hidden;
  position: relative;
  z-index: 2;
  cursor: grab;
}

.userinfo-date-column:active {
  cursor: grabbing;
}

.userinfo-date-scroller {
  display: flex;
  flex-direction: column;
  align-items: center;
  will-change: transform;
}

.userinfo-date-item {
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

.userinfo-date-item.selected {
  color: #161618;
  font-weight: 700;
  font-size: 18px;
}

#userinfo-date-continue-btn {
  width: 100%;
  max-width: 320px;
  margin-top: 0;
  margin-bottom: 0;
  background: #000000  !important;
  color: #FFFFFF !important;
}

@media only screen and (max-width: 768px) {
  .userinfo-stage-4-wrapper {
    min-height: auto;
           padding: 20px 0px 0px;
		           border-radius: 40px 40px 0 0;
		  
  }
  .userinfo-stage-4-title{
	      margin: 1px 0 10px 0;
  }
  
  .userinfo-stage-4-box {
    padding: 36px 20px 32px;
    max-width: 100%;
    min-width: auto;
	 border-radius: 40px 40px 0 0;
  }
}
</style>

<script>
// ==================== استیج ۲ و ۳ - ویرایش اطلاعات + تاریخ ====================

let userinfoSelectedGender = null;
let userinfoSelectedDay = 15;
let userinfoSelectedMonth = 6;
let userinfoSelectedYear = 1375;
const USERINFO_ITEM_HEIGHT = 48;

const userinfoPersianMonths = [
  { num: 1, name: 'فروردین' }, { num: 2, name: 'اردیبهشت' }, { num: 3, name: 'خرداد' },
  { num: 4, name: 'تیر' }, { num: 5, name: 'مرداد' }, { num: 6, name: 'شهریور' },
  { num: 7, name: 'مهر' }, { num: 8, name: 'آبان' }, { num: 9, name: 'آذر' },
  { num: 10, name: 'دی' }, { num: 11, name: 'بهمن' }, { num: 12, name: 'اسفند' }
];

// انتخاب جنسیت
window.selectUserInfoGender = function(btn) {
  document.querySelectorAll('.userinfo-gender-btn').forEach(b => b.classList.remove('selected'));
  btn.classList.add('selected');
  userinfoSelectedGender = btn.getAttribute('data-gender');
  checkUserInfoFormComplete();
};

// چک کامل بودن فرم
function checkUserInfoFormComplete() {
  const fullname  = document.getElementById('userinfo-fullname')?.value.trim();
  const phone     = document.getElementById('userinfo-phone')?.value.trim();
  const email     = document.getElementById('userinfo-email')?.value.trim();
  const birthdate = document.getElementById('userinfo-birthdate')?.value.trim();
  const btn       = document.getElementById('userinfo-submit-btn');

  if (fullname && phone && email && birthdate && userinfoSelectedGender) {
    btn.classList.add('active');
  } else {
    btn.classList.remove('active');
  }
}

// لیسنر فیلدها
document.addEventListener('DOMContentLoaded', function() {
  ['userinfo-fullname', 'userinfo-phone', 'userinfo-email', 'userinfo-birthdate'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', checkUserInfoFormComplete);
  });

  // اگر جنسیت از قبل انتخاب شده بود
  const selectedBtn = document.querySelector('.userinfo-gender-btn.selected');
  if (selectedBtn) {
    userinfoSelectedGender = selectedBtn.getAttribute('data-gender');
  }
  checkUserInfoFormComplete();
});

// باز کردن انتخابگر تاریخ
window.openUserInfoBirthdatePicker = function() {
  showUserInfoStage('userinfo-stage-3');
  setTimeout(initUserInfoDatePicker, 50);
  setTimeout(initUserInfoDatePicker, 150);
  setTimeout(initUserInfoDatePicker, 300);
};

// ==================== Date Picker ====================

function createUserInfoDateScroller(scrollerId, items, selectedValue, type) {
  const scroller = document.getElementById(scrollerId);
  if (!scroller) return;

  scroller.innerHTML = '';
  const paddingCount = 2;

  for (let i = 0; i < paddingCount; i++) {
    const empty = document.createElement('div');
    empty.className = 'userinfo-date-item';
    empty.innerHTML = '&nbsp;';
    scroller.appendChild(empty);
  }

  items.forEach(item => {
    const el = document.createElement('div');
    el.className = 'userinfo-date-item';
    el.dataset.value = item.value;
    el.textContent = item.label;
    scroller.appendChild(el);
  });

  for (let i = 0; i < paddingCount; i++) {
    const empty = document.createElement('div');
    empty.className = 'userinfo-date-item';
    empty.innerHTML = '&nbsp;';
    scroller.appendChild(empty);
  }

  const selectedIndex = items.findIndex(i => i.value === selectedValue);
  const safeIndex = selectedIndex >= 0 ? selectedIndex : 0;
  const offset = (safeIndex + paddingCount - 1) * USERINFO_ITEM_HEIGHT;
  scroller.style.transform = `translateY(-${offset}px)`;
  updateUserInfoSelectedClass(scroller, safeIndex + paddingCount);
  setupUserInfoDrag(scroller, items, type, paddingCount);
}

function updateUserInfoSelectedClass(scroller, index) {
  scroller.querySelectorAll('.userinfo-date-item').forEach((el, i) => {
    el.classList.toggle('selected', i === index);
  });
}

function setupUserInfoDrag(scroller, items, type, paddingCount) {
  let startY = 0, startOffset = 0, isDragging = false;

  const getOffset = () => {
    const m = scroller.style.transform.match(/translateY\((-?\d+(?:\.\d+)?)px\)/);
    return m ? parseFloat(m[1]) : 0;
  };
  const setOffset = (v) => scroller.style.transform = `translateY(${v}px)`;
  const clamp = (v, min, max) => Math.max(min, Math.min(max, v));

  const onStart = (clientY) => {
    isDragging = true;
    startY = clientY;
    startOffset = getOffset();
    scroller.style.transition = 'none';
  };

  const onMove = (clientY) => {
    if (!isDragging) return;
    let newOffset = startOffset + (clientY - startY);
    const minOffset = -((items.length + paddingCount * 2 - 3) * USERINFO_ITEM_HEIGHT);
    newOffset = clamp(newOffset, minOffset, 0);
    setOffset(newOffset);

    const rawIndex = Math.round((-newOffset) / USERINFO_ITEM_HEIGHT);
    const realIndex = clamp(rawIndex - paddingCount + 1, 0, items.length - 1);
    updateUserInfoSelectedClass(scroller, realIndex + paddingCount);

    if (type === 'day') userinfoSelectedDay = items[realIndex].value;
    if (type === 'month') userinfoSelectedMonth = items[realIndex].value;
    if (type === 'year') userinfoSelectedYear = items[realIndex].value;
  };

  const onEnd = () => {
    if (!isDragging) return;
    isDragging = false;
    scroller.style.transition = 'transform 0.2s ease-out';
    const current = getOffset();
    const rawIndex = Math.round((-current) / USERINFO_ITEM_HEIGHT);
    const realIndex = clamp(rawIndex - paddingCount + 1, 0, items.length - 1);
    const finalOffset = -((realIndex + paddingCount - 1) * USERINFO_ITEM_HEIGHT);
    setOffset(finalOffset);
    updateUserInfoSelectedClass(scroller, realIndex + paddingCount);

    if (type === 'day') userinfoSelectedDay = items[realIndex].value;
    if (type === 'month') userinfoSelectedMonth = items[realIndex].value;
    if (type === 'year') userinfoSelectedYear = items[realIndex].value;
  };

  scroller.addEventListener('mousedown', e => { e.preventDefault(); onStart(e.clientY); });
  window.addEventListener('mousemove', e => onMove(e.clientY));
  window.addEventListener('mouseup', onEnd);

  scroller.addEventListener('touchstart', e => onStart(e.touches[0].clientY), { passive: true });
  scroller.addEventListener('touchmove', e => onMove(e.touches[0].clientY), { passive: true });
  scroller.addEventListener('touchend', onEnd);
}

function initUserInfoDatePicker() {
  const days = Array.from({ length: 31 }, (_, i) => ({ value: i + 1, label: String(i + 1) }));
  const months = userinfoPersianMonths.map(m => ({ value: m.num, label: m.name }));
  const years = [];
  for (let y = 1404; y >= 1330; y--) years.push({ value: y, label: String(y) });

  createUserInfoDateScroller('userinfo-day-scroller', days, userinfoSelectedDay, 'day');
  createUserInfoDateScroller('userinfo-month-scroller', months, userinfoSelectedMonth, 'month');
  createUserInfoDateScroller('userinfo-year-scroller', years, userinfoSelectedYear, 'year');
}

// دکمه ادامه تاریخ
window.handleUserInfoDateContinue = function() {
  const formatted = `${userinfoSelectedYear}/${String(userinfoSelectedMonth).padStart(2, '0')}/${String(userinfoSelectedDay).padStart(2, '0')}`;
  const input = document.getElementById('userinfo-birthdate');
  if (input) {
    input.value = formatted;
    input.dispatchEvent(new Event('input'));
  }
  showUserInfoStage('userinfo-stage-2');
  checkUserInfoFormComplete();
};

// ثبت تغییرات
window.handleUpdateUserInfo = function() {
  const fullname  = document.getElementById('userinfo-fullname').value.trim();
  const phone     = document.getElementById('userinfo-phone').value.trim();
  const email     = document.getElementById('userinfo-email').value.trim();
  const birthdate = document.getElementById('userinfo-birthdate').value.trim();

  if (!fullname || !phone || !email || !birthdate || !userinfoSelectedGender) {
    alert('لطفاً همه فیلدها را پر کنید');
    return;
  }

  const btn = document.getElementById('userinfo-submit-btn');
  btn.disabled = true;
  btn.textContent = 'در حال ذخیره...';

  const formData = new FormData();
  formData.append('action', 'update_user_info'); // اکشن جدید برای آپدیت
  formData.append('fullname', fullname);
  formData.append('phone', phone);
  formData.append('email', email);
  formData.append('birthdate', birthdate);
  formData.append('gender', userinfoSelectedGender);

  fetch('/wp-admin/admin-ajax.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    btn.disabled = false;
    btn.textContent = 'ذخیره تغییرات';

    if (data.success) {
      alert(data.data?.message || 'اطلاعات با موفقیت ذخیره شد');
      // برگشت به استیج مشاهده و رفرش اطلاعات
      location.reload(); // یا می‌تونی استیج ۱ رو دستی آپدیت کنی
    } else {
      alert(data.data?.message || 'خطا در ذخیره اطلاعات');
    }
  })
  .catch(err => {
    console.error(err);
    btn.disabled = false;
    btn.textContent = 'ذخیره تغییرات';
    alert('خطا در ارتباط با سرور');
  });
};
</script>


<!-- ==================== استیج ۴ - ویرایش پروفایل (داینامیک) ==================== -->
<div class="userinfo-stage" id="userinfo-stage-4">
  <div class="userinfo-stage-wrapper">
    <div class="userinfo-stage-right">
      <div class="userinfo-stage-box userinfo-avatar-editor">

        <!-- دکمه بازگشت -->
        <button class="userinfo-back-btn" onclick="showUserInfoStage('userinfo-stage-2')">
          <img src="http://6tofit.com/wp-content/uploads/2026/08/State-Layer.svg" alt="Back">
        </button>

        <h2 class="userinfo-view-title">ویرایش پروفایل</h2>

        <?php
        $current_user = wp_get_current_user();
        $user_id      = $current_user->ID;
        $avatar_url   = get_avatar_url($user_id, ['size' => 160]);

        // مسیر فایل‌سیستم و URL
$memo_dir = get_template_directory() . '/assets/img/memo/';
$memo_uri = get_template_directory_uri() . '/assets/img/memo/';

        $categories = [];

        if (is_dir($memo_dir)) {
            $folders = array_filter(glob($memo_dir . '*'), 'is_dir');

            foreach ($folders as $folder) {
                $cat_name = basename($folder);
                $images = [];

                // پیدا کردن همه تصاویر داخل فولدر
                $files = glob($folder . '/*.{png,jpg,jpeg,webp,svg,gif}', GLOB_BRACE);

                foreach ($files as $file) {
                    $filename = basename($file);
                    $images[] = [
                        'url'  => $memo_uri . $cat_name . '/' . $filename,
                        'name' => pathinfo($filename, PATHINFO_FILENAME)
                    ];
                }

                if (!empty($images)) {
                    $categories[$cat_name] = $images;
                }
            }
        }
        ?>

        <!-- تصویر پروفایل زنده -->
        <div class="userinfo-avatar-editor-wrapper">
          <img src="<?php echo esc_url($avatar_url); ?>" 
               alt="Profile" 
               class="userinfo-avatar-editor-preview" 
               id="userinfo-avatar-editor-preview">
        </div>

        <!-- انتخاب پس‌زمینه -->
        <p class="userinfo-editor-subtitle">انتخاب پس‌زمینه</p>
        <div class="userinfo-bg-colors">
          <?php
          $bg_colors = [
            '#F2F2F8', '#E9E9EB', '#D0D0D3', '#B0B0B5',
            '#9B9BA1', '#6B6B6F', '#5247FF', '#4338e0'
          ];
          foreach ($bg_colors as $index => $color) :
          ?>
            <button type="button" 
                    class="userinfo-bg-color-btn <?php echo $index === 0 ? 'selected' : ''; ?>" 
                    data-bg="<?php echo esc_attr($color); ?>" 
                    style="background-color: <?php echo esc_attr($color); ?>;"
                    onclick="setEditorBackground(this)">
            </button>
          <?php endforeach; ?>
        </div>

        <!-- انتخاب مموجی -->
        <p class="userinfo-editor-subtitle">انتخاب مموجی</p>
        <div class="userinfo-emoji-box">

          <!-- هدر دسته‌بندی‌ها (داینامیک) -->
          <div class="userinfo-emoji-header">
            <div class="userinfo-emoji-categories" id="userinfo-emoji-categories">
              <?php if (!empty($categories)) : ?>
                <?php $first = true; foreach ($categories as $cat_name => $images) : ?>
                  <button type="button" 
                          class="userinfo-emoji-cat-btn <?php echo $first ? 'active' : ''; ?>" 
                          data-category="<?php echo esc_attr($cat_name); ?>"
                          onclick="switchEmojiCategory('<?php echo esc_js($cat_name); ?>', this)">
                    <!-- نمایش اولین تصویر دسته به‌عنوان نمونه -->
                    <img src="<?php echo esc_url($images[0]['url']); ?>" alt="<?php echo esc_attr($cat_name); ?>">

                  </button>
                <?php $first = false; endforeach; ?>
              <?php else : ?>
                <p style="color:#999; font-size:13px;">هیچ دسته‌بندی‌ای پیدا نشد</p>
              <?php endif; ?>
            </div>
          </div>

          <!-- لیست مموجی‌ها (داینامیک) -->
          <div class="userinfo-emoji-list" id="userinfo-emoji-list">
            <?php if (!empty($categories)) : ?>
              <?php foreach ($categories as $cat_name => $images) : ?>
                <div class="userinfo-emoji-category-group" 
                     data-category="<?php echo esc_attr($cat_name); ?>" 
                     style="<?php echo $cat_name === array_key_first($categories) ? '' : 'display:none;'; ?>">
                  
                  <?php
                  // گروه‌بندی ۳ تایی
                  $chunks = array_chunk($images, 3);
                  foreach ($chunks as $chunk) :
                  ?>
                    <div class="userinfo-emoji-row">
                      <?php foreach ($chunk as $img) : ?>
                        <button type="button" 
                                class="userinfo-emoji-item" 
                                data-category="<?php echo esc_attr($cat_name); ?>"
                                data-src="<?php echo esc_url($img['url']); ?>"
                                onclick="selectEmoji(this)">
                          <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['name']); ?>">
                        </button>
                      <?php endforeach; ?>
                    </div>
                  <?php endforeach; ?>
                  
                </div>
              <?php endforeach; ?>
            <?php else : ?>
              <p style="text-align:center; color:#999; padding:40px 0;">
                پوشه <code>img/memo/</code> خالی است یا تصویری پیدا نشد.
              </p>
            <?php endif; ?>
          </div>
        </div>

        <button class="userinfo-submit-button active" id="userinfo-avatar-set-btn" onclick="saveUserAvatar()">
          تنظیم پروفایل
        </button>

      </div>
    </div>
  </div>
</div>
<style>
/* ==================== استیج ۴ - ویرایش پروفایل ==================== */
/* ==================== استیج ۴ - ویرایش پروفایل ==================== */

.userinfo-avatar-editor {
  padding: 40px 48px 36px !important;
}

.userinfo-avatar-editor .userinfo-view-title {
  font-size: 22px;
  font-weight: 600;
  color: #000000;
  margin: 12px 0 28px 0;
  text-align: center;
  width: 100%;
  padding-right: 8px;
}

.userinfo-avatar-editor-wrapper {

  text-align: center;
}

.userinfo-avatar-editor-preview {
  width: 110px;
  height: 110px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #F2F2F8;
}

.userinfo-editor-subtitle {
  font-size: 14px;
  color: #9B9BA1;
  margin: 20px 0 12px;
  text-align: right;
  font-family: 'iranyekan', sans-serif;
}

.userinfo-bg-colors {
  display: flex;
  gap: 12px;
  justify-content: center;
  margin-bottom: 12px;
  flex-wrap: wrap;
}

.userinfo-bg-color-btn {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  border: 2px solid transparent;
  background: #F2F2F8;
  cursor: pointer;
  transition: all 0.2s ease;
}

.userinfo-bg-color-btn.selected {
  border-color: #5247FF;
  box-shadow: 0 0 0 3px rgba(82, 71, 255, 0.2);
}

.userinfo-bg-color-btn:hover {
  transform: scale(1.08);
}

/* ایموجی‌ها */
.userinfo-emoji-box {
  margin-bottom: 32px;
      min-width: 400px;
}



.userinfo-emoji-categories {
    display: flex;
    gap: 8px;
    justify-content: center;
    overflow-x: auto;
    scrollbar-width: none;
    background: #F5F5F7;
    padding: 10px;
   border-bottom: 1px solid #D9D9D9;
    border-radius: 20px 20px 0 0;
}

.userinfo-emoji-categories::-webkit-scrollbar { display: none; }

.userinfo-emoji-cat-btn {
 
  border: none;
  padding: 4px 6px;
  border-radius: 8px;
  font-size: 14px;
  color: #161618;
  cursor: pointer;
  transition: all 0.2s ease;
      background-color: #f0f8ff00;
}
.userinfo-emoji-cat-btn img{
width:34px;
height:34px;
}

.userinfo-emoji-cat-btn.active,
.userinfo-emoji-cat-btn:hover {
    background: #0d0d0d1f;
  color: #FFFFFF;
}

.userinfo-emoji-list {
    height: 200px;
    background: #F5F5F7;
    border-radius: 0 0 20px 20px;
    overflow-y: auto;
    padding: 22px;
}

.userinfo-emoji-row {
  display: flex;
  gap: 65px;
  justify-content: center;
  margin-bottom: 12px;
}

.userinfo-emoji-item {
  width: 52px;
  height: 52px;
  background: #ffffff00;
  border-radius: 50%;
  font-size: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  border:unset;
  transition: transform 0.2s ease;
  padding: 6px;
}

.userinfo-emoji-item:hover {
  transform: scale(1.15);
}

.userinfo-emoji-item img {
  width: 70px;
  height: 70px;
  object-fit: contain;
}

/* موبایل */
@media only screen and (max-width: 768px) {
  .userinfo-avatar-editor { padding: 28px 20px 24px !important; }
  .userinfo-avatar-editor-preview { width: 96px; height: 96px; }
  .userinfo-emoji-list { height: 180px; }
  .userinfo-emoji-row { gap: 10px; }
  .userinfo-emoji-item { width: 48px; height: 48px; font-size: 26px; }
}
</style>
<script>
// تغییر رنگ پس‌زمینه
function setEditorBackground(btn) {
  document.querySelectorAll('.userinfo-bg-color-btn').forEach(b => b.classList.remove('selected'));
  btn.classList.add('selected');
  
  const color = btn.getAttribute('data-bg');
  const preview = document.getElementById('userinfo-avatar-editor-preview');
  if (preview) {
    preview.style.backgroundColor = color;
  }
}

// انتخاب مموجی
function selectEmoji(btn) {
  const src = btn.getAttribute('data-src');
  const preview = document.getElementById('userinfo-avatar-editor-preview');
  if (preview && src) {
    preview.src = src;
  }
}

// تغییر دسته‌بندی
function switchEmojiCategory(category, btn) {
  // فعال کردن دکمه دسته
  document.querySelectorAll('.userinfo-emoji-cat-btn').forEach(b => b.classList.remove('active'));
  if (btn) btn.classList.add('active');

  // نمایش فقط گروه مربوطه
  document.querySelectorAll('.userinfo-emoji-category-group').forEach(group => {
    if (group.getAttribute('data-category') === category) {
      group.style.display = 'block';
    } else {
      group.style.display = 'none';
    }
  });
}

// ذخیره پروفایل (فعلاً ساده)
// ذخیره پروفایل و انتقال به استیج ۲
async function saveUserAvatar() {
  const preview = document.getElementById('userinfo-avatar-editor-preview');
  const stage2Avatar = document.getElementById('userinfo-edit-avatar');
  const selectedColorBtn = document.querySelector('.userinfo-bg-color-btn.selected');

  if (!preview || !stage2Avatar) {
    showUserInfoStage('userinfo-stage-2');
    return;
  }

  const bgColor = selectedColorBtn 
    ? selectedColorBtn.getAttribute('data-bg') 
    : '#F2F2F8';

  try {
    // ساخت تصویر نهایی با رنگ پس‌زمینه
    const finalImage = await createFinalAvatar(preview.src, bgColor, 280);

    // قرار دادن در استیج ۲
    stage2Avatar.src = finalImage;
    stage2Avatar.style.backgroundColor = 'transparent'; // دیگه نیازی به background نیست

    // آپدیت پیش‌نمایش استیج ۴ هم (اختیاری)
    preview.src = finalImage;
    preview.style.backgroundColor = 'transparent';

  } catch (err) {
    console.error('خطا در ساخت تصویر نهایی:', err);
    // در صورت خطا، حداقل src رو منتقل کن
    stage2Avatar.src = preview.src;
  }

  showUserInfoStage('userinfo-stage-2');
}
async function setEditorBackground(btn) {
  document.querySelectorAll('.userinfo-bg-color-btn').forEach(b => b.classList.remove('selected'));
  btn.classList.add('selected');

  const color = btn.getAttribute('data-bg');
  const preview = document.getElementById('userinfo-avatar-editor-preview');

  if (preview && preview.src) {
    // اگر می‌خوای زنده ترکیب بشه (ممکنه کمی کند باشه):
    // const finalImage = await createFinalAvatar(preview.src, color, 220);
    // preview.src = finalImage;
    // preview.style.backgroundColor = 'transparent';

    // روش سبک‌تر (فقط background):
    preview.style.backgroundColor = color;
  }
}
</script>

<!-- ==================== پاپ‌آپ کراپ تصویر ==================== -->
<div class="userinfo-crop-overlay" id="userinfo-crop-overlay">
  <div class="userinfo-crop-modal">
    
    <h3 class="userinfo-crop-title">بارگذاری عکس</h3>

    <div class="userinfo-crop-container">
      <div class="userinfo-crop-image-wrapper" id="userinfo-crop-image-wrapper">
        <img id="userinfo-crop-image" src="" alt="Crop">
      </div>
      <!-- ماسک دایره‌ای -->
      <div class="userinfo-crop-mask"></div>
    </div>

    <div class="userinfo-crop-actions">
	 <button type="button" class="userinfo-crop-btn userinfo-crop-confirm" onclick="confirmCrop()">
        تایید
      </button>
      <button type="button" class="userinfo-crop-btn userinfo-crop-cancel" onclick="closeCropModal()">
        انصراف
      </button>
     
    </div>

  </div>
  
<style>
/* ==================== پاپ‌آپ پیام ==================== */
.userinfo-toast-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.45);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 10001;
  backdrop-filter: blur(6px);
}

.userinfo-toast-overlay.active {
  display: flex;
}

.userinfo-toast {
  background: #FFFFFF;
  border-radius: 24px;
  padding: 32px 28px 24px;
  width: 90%;
  max-width: 340px;
  text-align: center;
  box-shadow: 0 20px 50px rgba(0,0,0,0.15);
  animation: toastIn 0.25s ease;
}

@keyframes toastIn {
  from { transform: scale(0.9); opacity: 0; }
  to   { transform: scale(1); opacity: 1; }
}

.userinfo-toast-icon {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  margin: 0 auto 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
}

.userinfo-toast.success .userinfo-toast-icon {
  background: #E8F5E9;
  color: #2E7D32;
}

.userinfo-toast.error .userinfo-toast-icon {
  background: #FFEBEE;
  color: #C62828;
}

.userinfo-toast-message {
  font-size: 15px;
  color: #161618;
  line-height: 1.6;
  margin: 0 0 24px 0;
  font-family: 'iranyekan', sans-serif;
}

.userinfo-toast-close {
  background: #000;
  color: #fff;
  border: none;
  border-radius: 100px;
  padding: 12px 32px;
  font-size: 14px;
  font-family: 'iranyekan', sans-serif;
  cursor: pointer;
  min-width: 120px;
}
/* ==================== پاپ‌آپ کراپ تصویر ==================== */
.userinfo-crop-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.55);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 10000;
  backdrop-filter: blur(8px);
}

.userinfo-crop-overlay.active {
  display: flex;
}

.userinfo-crop-modal {
  background: #FFFFFF;
  border-radius: 28px;
  width: 90%;
  max-width: 420px;
  padding: 28px 24px 24px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.2);
  display: flex;
  flex-direction: column;
  align-items: center;
}

.userinfo-crop-title {
  font-size: 20px;
  font-weight: 600;
  color: #000;
  margin: 0 0 24px 0;
  font-family: 'iranyekan', sans-serif;
}

/* کانتینر کراپ */
.userinfo-crop-container {
  position: relative;
  width: 280px;
  height: 280px;
  border-radius: 50%;
  overflow: hidden;
  background: #f0f0f0;
  margin-bottom: 28px;
  touch-action: none;
}

/* تصویر قابل جابه‌جایی */
.userinfo-crop-image-wrapper {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  cursor: grab;
}

.userinfo-crop-image-wrapper:active {
  cursor: grabbing;
}

#userinfo-crop-image {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  max-width: none;
  user-select: none;
  pointer-events: none;
}

/* ماسک دایره‌ای (لایه سیاه اطراف) */
.userinfo-crop-mask {
  position: absolute;
  inset: 0;
  border-radius: 50%;
  box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.55);
  pointer-events: none;
  z-index: 2;
}

/* دکمه‌ها */
.userinfo-crop-actions {
  display: flex;
  gap: 12px;
  width: 100%;
}

.userinfo-crop-btn {
  flex: 1;
  height: 52px;
  border-radius: 100px;
  font-size: 15px;
  font-family: 'iranyekan', sans-serif;
  cursor: pointer;
  border: none;
  transition: all 0.2s ease;
}

.userinfo-crop-cancel {
  background: #ffffff;
  color: #ff0000;
      border: 1px solid #ff0000;
}

.userinfo-crop-cancel:hover {
  background: #E5E5E9;
}

.userinfo-crop-confirm {
  background: #000000;
  color: #FFFFFF;
}

.userinfo-crop-confirm:hover {
  background: #222;
}

/* موبایل */
@media (max-width: 480px) {
  .userinfo-crop-container {
    width: 260px;
    height: 260px;
  }
}
</style>


  </div>
</div>
<!-- پاپ‌آپ پیام موفقیت / خطا -->
<div class="userinfo-toast-overlay" id="userinfo-toast-overlay">
  <div class="userinfo-toast" id="userinfo-toast">
    <div class="userinfo-toast-icon" id="userinfo-toast-icon"></div>
    <p class="userinfo-toast-message" id="userinfo-toast-message"></p>
    <button class="userinfo-toast-close" onclick="hideUserInfoToast()">باشه</button>
  </div>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('userinfo-popup');
    if (!popup) {
        console.error('UserInfo popup element not found!');
        return;
    }

    window.showUserInfoPopup = function() {
        popup.classList.add('active');
        showUserInfoStage('userinfo-stage-1');
    };

    window.hideUserInfoPopup = function() {
        popup.classList.remove('active');
        showUserInfoStage('userinfo-stage-1');
    };

    window.showUserInfoStage = function(stageId) {
        document.querySelectorAll('.userinfo-stage').forEach(stage => {
            stage.classList.remove('active');
        });
        const stage = document.getElementById(stageId);
        if (stage) {
            stage.classList.add('active');
        } else {
            console.error('Stage not found: ' + stageId);
        }
    };

    // بستن با کلیک روی overlay
    popup.addEventListener('click', function(e) {
        if (e.target === this) hideUserInfoPopup();
    });

    // دکمه‌های بستن
    document.querySelectorAll('.userinfo-close').forEach(button => {
        button.addEventListener('click', hideUserInfoPopup);
    });
});
// ==================== نمایش / مخفی کردن پیام ====================
function showUserInfoToast(message, type = 'success') {
  const overlay = document.getElementById('userinfo-toast-overlay');
  const toast   = document.getElementById('userinfo-toast');
  const icon    = document.getElementById('userinfo-toast-icon');
  const msg     = document.getElementById('userinfo-toast-message');

  if (!overlay || !toast || !icon || !msg) {
    console.error('عناصر پاپ‌آپ پیام پیدا نشد');
    return;
  }

  toast.className = 'userinfo-toast ' + type;
  icon.textContent = type === 'success' ? '✓' : '✕';
  msg.textContent = message;
  overlay.classList.add('active');
}

function hideUserInfoToast() {
  const overlay = document.getElementById('userinfo-toast-overlay');
  if (overlay) overlay.classList.remove('active');
}

// ==================== آپدیت لایو استیج ۱ ====================
function updateStage1Info(data) {
  // نام
  const nameEl = document.querySelector('#userinfo-stage-1 .userinfo-info-row:nth-child(1) .userinfo-info-value');
  if (nameEl) nameEl.textContent = data.fullname || '—';

  // موبایل
  const phoneEl = document.querySelector('#userinfo-stage-1 .userinfo-info-row:nth-child(2) .userinfo-info-value');
  if (phoneEl) phoneEl.textContent = data.phone || '—';

  // ایمیل
  const emailEl = document.querySelector('#userinfo-stage-1 .userinfo-info-row:nth-child(3) .userinfo-info-value');
  if (emailEl) emailEl.textContent = data.email || '—';

  // جنسیت
  const genderMap = { male: 'مرد', female: 'زن', other: 'سایر' };
  const genderEl = document.querySelector('#userinfo-stage-1 .userinfo-info-row:nth-child(4) .userinfo-info-value');
  if (genderEl) genderEl.textContent = genderMap[data.gender] || '—';

  // تاریخ تولد
  const birthEl = document.querySelector('#userinfo-stage-1 .userinfo-info-row:nth-child(5) .userinfo-info-value');
  if (birthEl) birthEl.textContent = data.birthdate || '—';

  // تصویر پروفایل
  const avatarEl = document.querySelector('#userinfo-stage-1 .userinfo-avatar');
  if (avatarEl && data.avatar) {
    avatarEl.src = data.avatar;
  }
}

// ==================== ذخیره تغییرات ====================
window.handleUpdateUserInfo = async function () {
  const fullname  = document.getElementById('userinfo-fullname')?.value.trim();
  const phone     = document.getElementById('userinfo-phone')?.value.trim();
  const email     = document.getElementById('userinfo-email')?.value.trim();
  const birthdate = document.getElementById('userinfo-birthdate')?.value.trim();
  const gender    = userinfoSelectedGender;

  // اعتبارسنجی
  if (!fullname || !phone || !email || !birthdate || !gender) {
    showUserInfoToast('لطفاً همه فیلدها را کامل پر کنید', 'error');
    return;
  }

  if (!/^09\d{9}$/.test(phone.replace(/\s/g, ''))) {
    showUserInfoToast('شماره موبایل معتبر نیست (مثال: 09123456789)', 'error');
    return;
  }

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    showUserInfoToast('ایمیل وارد شده معتبر نیست', 'error');
    return;
  }

  const btn = document.getElementById('userinfo-submit-btn');
  if (btn) {
    btn.disabled = true;
    btn.textContent = 'در حال ذخیره...';
  }

  // گرفتن تصویر فعلی
  const avatarImg = document.getElementById('userinfo-edit-avatar');
  let avatarData = '';
  let avatarBg   = '';

  if (avatarImg) {
    avatarData = avatarImg.src || '';
    avatarBg   = avatarImg.style.backgroundColor || '';
  }

  const formData = new FormData();
  formData.append('action', 'update_user_info');
  formData.append('fullname', fullname);
  formData.append('phone', phone);
  formData.append('email', email);
  formData.append('birthdate', birthdate);
  formData.append('gender', gender);
  formData.append('avatar', avatarData);
  formData.append('avatar_bg', avatarBg);

  try {
    const res  = await fetch('/wp-admin/admin-ajax.php', {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (btn) {
      btn.disabled = false;
      btn.textContent = 'ذخیره تغییرات';
    }

    if (data.success) {
      // آپدیت لایو استیج ۱
      updateStage1Info({
        fullname: fullname,
        phone: phone,
        email: email,
        gender: gender,
        birthdate: birthdate,
        avatar: avatarData
      });

      showUserInfoToast(data.data?.message || 'اطلاعات با موفقیت ذخیره شد', 'success');

      // بعد از ۱.۸ ثانیه به استیج ۱ برو
      setTimeout(() => {
        hideUserInfoToast();
        showUserInfoStage('userinfo-stage-1');
      }, 1800);

    } else {
      showUserInfoToast(data.data?.message || 'خطا در ذخیره اطلاعات', 'error');
    }

  } catch (err) {
    console.error(err);
    if (btn) {
      btn.disabled = false;
      btn.textContent = 'ذخیره تغییرات';
    }
    showUserInfoToast('خطا در ارتباط با سرور. لطفاً دوباره تلاش کنید', 'error');
  }
};
// ساخت تصویر نهایی مموجی + رنگ پس‌زمینه
function createFinalAvatar(imageSrc, bgColor, size = 280) {
  return new Promise((resolve) => {
    const canvas = document.createElement('canvas');
    canvas.width = size;
    canvas.height = size;
    const ctx = canvas.getContext('2d');

    // ۱. رسم دایره رنگی پس‌زمینه
    ctx.beginPath();
    ctx.arc(size / 2, size / 2, size / 2, 0, Math.PI * 2);
    ctx.closePath();
    ctx.fillStyle = bgColor || '#F2F2F8';
    ctx.fill();

    // ۲. رسم تصویر مموجی روی آن
    const img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = function () {
      // محاسبه سایز مناسب (کمی کوچکتر از دایره)
      const padding = size * 0.08;
      const drawSize = size - padding * 2;

      ctx.drawImage(
        img,
        padding,
        padding,
        drawSize,
        drawSize
      );

      resolve(canvas.toDataURL('image/png'));
    };
    img.onerror = function () {
      // اگر تصویر لود نشد، فقط رنگ رو برگردون
      resolve(canvas.toDataURL('image/png'));
    };
    img.src = imageSrc;
  });
}
</script>
<?php
    $popup_html = ob_get_clean();
    echo $popup_html;
}
?>