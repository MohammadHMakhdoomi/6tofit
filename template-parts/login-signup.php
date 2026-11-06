<?php
function render_auth_popup($title = "ورود / ثبت‌نام", $submit_text = "ادامه") {
    ob_start();
?>
<style>
.auth-popup-overlay.active {
    display: flex !important;
}

.auth-popup-overlay {
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

.auth-popup-content {
    background: #F7F7F8;
    border-radius: 40px;


    text-align: center;
}

.auth-popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
}

.auth-close {
    background: none;
    border: none;
    cursor: pointer;
}

.auth-close img {
    width: 48px;
    height: 48px;
}

.auth-back {
    background: none;
    border: none;
    cursor: pointer;
}

.auth-back img {
    width: 48px;
    height: 48px;
}

.auth-popup-content h2 {
    font-size: 28px;
    font-weight: 500;
    color: #000000;
    margin: 0 auto;
    flex-grow: 1;
    text-align: center;

}

.auth-popup-content p {
    font-size: 14px;
    font-weight: 400;
    color: #6e6e6e;

}

.auth-cards {
    display: flex;
    gap: 16px;
    justify-content: center;
}

.auth-card {
    background: #FFFFFF;
    border-radius: 24px;
    padding: 32px;
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.auth-card img {
    width: 48px;
    height: 48px;
    object-fit: contain;
    margin-bottom: 12px;
}

.auth-card p {
    font-size: 16px;
    color: #000000;
    margin: 12px 0;
}

.auth-card button {
    background: #F2F2F8;
    border: none;
    padding: 8px 10px;
    font-size: 16px;
    color: #5247FF;
    border-radius: 1000000px;
    cursor: pointer;
    min-width: 125px;
    font-family: 'iranyekan', sans-serif;
}

.auth-popup-content .auth-stage {
    display: none;
}

.auth-popup-content .auth-stage.active {
    display: block;
}

.auth-form-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.auth-form-field {
    position: relative;
    width: 420px;
    margin-bottom: 16px;
}

.auth-form-field input {
    width: 100%;
    height: 56px;
    border: 1px solid rgba(0, 0, 0, 0.12);
    border-radius: 1000000px;
    padding-top: 8px;
    padding-bottom: 8px;
    padding-right: 20px;
    padding-left: 20px;
    font-size: 16px;
    font-family: 'iranyekan', sans-serif;
    box-sizing: border-box;
}

.auth-form-field label {
    position: absolute;
    top: 50%;
    right: 29px;
    transform: translateY(-50%);
    font-size: 16px;
    color: #161618;
    font-family: 'iranyekan', sans-serif;
    pointer-events: none;
}

.auth-submit-button {
    background: #E9E9EB;
    border: none;
    padding: 12px 10px;
    font-size: 18px;
    color: #9B9BA1;
    border-radius: 1000000px;
    cursor: pointer;
    font-family: 'iranyekan', sans-serif;
    min-width: 240px;
    margin-top: 50px;
}

.auth-form-field input {
    transition: all 0.3s ease;
}

.auth-form-field input:focus + label,
.auth-form-field input:valid + label {
    opacity: 0;
    transform: translateY(-1.5rem);
}

.auth-submit-button {
    transition: background-color 0.3s ease;
}

/* تغییرات برای موبایل */
@media only screen and (max-width: 768px) {
    .auth-popup-overlay {
        z-index: 9999;
    }

    .auth-popup-content p {
        margin: 10px 0;
    }

    .auth-popup-content {
        width: 100%;
        height: 100%;
        border-radius: 0;
        padding: 0px;
        box-sizing: border-box;
    }

    .auth-popup-content h2 {
        font-size: 20px;
		        margin: 10px 0;
    }

    .auth-popup-content p {
        font-size: 15px;
    }

    .auth-cards {
        flex-direction: column;
        gap: 16px;
    }

    .auth-card p {
        font-size: 15px;
    }

    .auth-form-container {
        position: relative;
        height: 100%;
        justify-content: space-between;
    }

    .auth-form-field {
        width: 100%;
    }

    .auth-card {
        padding: 16px;
    }

    .auth-submit-button {
        margin-top: 300px;
        bottom: 20px;
        width: 100%;
        max-width: 90%;
    }
}
</style>
<div class="auth-popup-overlay" id="auth-popup">
  <div class="auth-popup-content">

<!-- استیج ۱ -->
<div class="auth-stage active" id="auth-stage-1">
  <div class="auth-stage-1-wrapper">

    <!-- ستون راست - فرم -->
    <div class="auth-stage-1-right">
      <div class="auth-stage-1-box">

        <!-- دکمه بستن -->
        <button class="auth-close auth-stage-1-close">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/State.svg" alt="Close Icon">
        </button>

        <!-- لوگو -->
        <div class="auth-stage-1-logo">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/6toFit_logo_Black_2.svg" alt="6tofit Logo">
        </div>

        <!-- عنوان -->
        <h2 class="auth-stage-1-title">خوش آمدید!</h2>

        <!-- توضیحات -->
        <p class="auth-stage-1-desc">
          برای ورود یا ثبت نام شماره موبایل یا ایمیلت رو وارد کن تا کد تایید برات ارسال بشه
        </p>

        <!-- فیلد ورودی -->
        <div class="auth-form-field">
          <input type="text" id="auth-identifier" required placeholder=" ">
          <label for="auth-identifier">شماره موبایل یا ایمیل</label>
        </div>

        <!-- دکمه ارسال کد -->
        <button class="auth-submit-button" id="auth-send-code-btn" onclick="handleSendCode()">
          ارسال کد تایید
        </button>

        <!-- متن شرایط -->
        <p class="auth-stage-1-terms">
          ورود شما به معنای پذیرش 
          <a href="/terms" target="_blank">شرایط 6tofit</a> 
          و 
          <a href="/privacy" target="_blank">قوانین حریم خصوصی</a> 
          است
        </p>

        <!-- خط جداکننده با متن "یا" -->
        <div class="auth-divider">
          <span>یا</span>
        </div>

        <!-- دکمه گوگل -->
        <button class="auth-google-btn" onclick="handleGoogleLogin()">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/google.svg" alt="Google">
          <span>ادامه با حساب گوگل</span>
        </button>

      </div>
    </div>
    
    <!-- ستون چپ - تصویر -->
    <div class="auth-stage-1-left">
      <img src="http://6tofit.com/wp-content/uploads/2026/08/YogaMat.png" alt="Login Image" class="auth-stage-1-image">
    </div>

  </div>
</div>
   


<style>
/* ==================== استیج ۱ ==================== */

.auth-stage-1-wrapper {
  display: flex;
  height: 100%;
  min-height: 520px;
  border-radius: 40px;
  overflow: hidden;
}

/* ستون چپ - تصویر */
.auth-stage-1-left {
  flex: 1.4;
  display: flex;
  align-items: center;
  justify-content: center;
}

.auth-stage-1-image {
  width: 60%;
  display: block;
}

/* ستون راست - فرم */
.auth-stage-1-right {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 30px 24px;
  background: #F7F7F8;
}

.auth-stage-1-box {
  background: #FFFFFF;
  border-radius: 28px;
  padding: 96px 72px;
  width: 100%;
  max-width: 580px;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative; /* برای دکمه بستن */
}

/* دکمه بستن - گوشه راست بالا */
.auth-stage-1-close {
  position: absolute;
  top: 16px;
  right: 16px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
  z-index: 10;
}

.auth-stage-1-close img {
  width: 40px;
  height: 40px;
}

/* لوگو */
.auth-stage-1-logo {
  margin-bottom: 28px;
  margin-top: 12px;
}

.auth-stage-1-logo img {
  height: 42px;
  width: auto;
}

/* عنوان */
.auth-stage-1-title {
  font-size: 24px;
  font-weight: 700;
  color: #000000;
  margin: 0 0 12px 0;
  text-align: center;
}

/* توضیحات */
.auth-stage-1-desc {
  font-size: 14px;
  font-weight: 400;
  color: #6B6B6F;
  line-height: 1.7;
  text-align: center;
  margin: 0 0 28px 0;
}

/* ===== فیلد ورودی (ظاهر مثل کد شما) ===== */
.auth-stage-1-box .auth-form-field {
  position: relative;
  width: 100%;
  max-width: 420px;
  margin-bottom: 16px;
}

.auth-stage-1-box .auth-form-field input {
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

.auth-stage-1-box .auth-form-field label {
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

.auth-stage-1-box .auth-form-field input:focus + label,
.auth-stage-1-box .auth-form-field input:not(:placeholder-shown) + label {
  opacity: 0;
  transform: translateY(-1.5rem);
}

/* ===== دکمه ارسال کد (ظاهر مثل کد شما) ===== */
.auth-stage-1-box .auth-submit-button {
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

.auth-stage-1-box .auth-submit-button:hover {
  background: #D0D0D3;
}

/* وقتی دکمه فعال باشه (مثلا بعد از پر شدن فیلد) */
.auth-stage-1-box .auth-submit-button.active {
  background: #000000;
  color: #FFFFFF;
}

.auth-stage-1-box .auth-submit-button.active:hover {
  background: #4338e0;
}

/* متن شرایط */
.auth-stage-1-terms {
  font-size: 12px;
  color: #9B9BA1;
  text-align: center;
  line-height: 1.6;
  margin: 0 0 24px 0;
}

.auth-stage-1-terms a {
  color: #5247FF;
  text-decoration: none;
}

.auth-stage-1-terms a:hover {
  text-decoration: underline;
}

/* خط جداکننده با متن "یا" */
.auth-divider {
  width: 100%;
  max-width: 420px;
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.auth-divider::before,
.auth-divider::after {
  content: "";
  flex: 1;
  height: 1px;
  background: rgba(0, 0, 0, 0.1);
}

.auth-divider span {
  padding: 0 14px;
  font-size: 13px;
  color: #9B9BA1;
}

/* دکمه گوگل */
.auth-google-btn {
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

.auth-google-btn:hover {
  background: #F9F9F9;
  border-color: rgba(0, 0, 0, 0.18);
}

.auth-google-btn img {
  width: 20px;
  height: 20px;
}

.auth-google-btn span {
  font-size: 15px;
  color: #161618;
  font-weight: 500;
}

/* ========== موبایل استیج ۱ ========== */
@media only screen and (max-width: 768px) {
  .auth-stage-1-wrapper {
    flex-direction: column;
    min-height: auto;
    border-radius: 0;
  }

  .auth-stage-1-left {
    display: none;
  }

  .auth-stage-1-right {
    padding: 0px 0px;
    background: #F7F7F8;
  }

  .auth-stage-1-box {
    padding: 28px 20px;
    border-radius: 0px;
    max-width: 100%;
	        height: 100vh;
  }

  .auth-stage-1-close {
    top: 12px;
    right: 12px;
  }

  .auth-stage-1-close img {
    width: 36px;
    height: 36px;
  }

  .auth-stage-1-title {
    font-size: 22px;
  }

  .auth-stage-1-desc {
    font-size: 13px;
    margin-bottom: 24px;
  }

  .auth-stage-1-box .auth-form-field,
  .auth-stage-1-box .auth-submit-button,
  .auth-divider,
  .auth-google-btn {
    max-width: 100%;
  }
}
</style>


    <!-- استیج ۲ -->
<div class="auth-stage" id="auth-stage-2">
  <div class="auth-stage-1-wrapper">

    <!-- ستون راست - فرم -->
    <div class="auth-stage-1-right">
      <div class="auth-stage-1-box">

        <!-- دکمه بستن -->
        <button class="auth-close auth-stage-1-close">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/State.svg" alt="Close Icon">
        </button>

        <!-- لوگو -->
        <div class="auth-stage-1-logo">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/6toFit_logo_Black_2.svg" alt="6tofit Logo">
        </div>

        <!-- عنوان -->
        <h2 class="auth-stage-1-title">خوش آمدید!</h2>

        <!-- توضیحات -->
        <p class="auth-stage-1-desc">
          کد تایید برای شما ارسال شده است، لطفا آن را وارد نمایید
        </p>

        <!-- باکس نمایش شماره/ایمیل + آیکن ادیت -->
        <div class="auth-identifier-display">
		 <button class="auth-edit-identifier" onclick="showAuthStage('auth-stage-1')" title="ویرایش">
            <!-- آیکن خودت رو اینجا بذار -->
            <img src="http://6tofit.com/wp-content/uploads/2026/08/Edit.svg" alt="Edit">
          </button>
          <span id="auth-identifier-value">0912*******89</span>
         
        </div>

        <!-- ۴ باکس کد تایید -->
        <div class="auth-otp-boxes">
          <input type="text" class="auth-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code">
          <input type="text" class="auth-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*">
          <input type="text" class="auth-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*">
          <input type="text" class="auth-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*">
        </div>

        <!-- تایمر / ارسال مجدد -->
        <div class="auth-resend-wrapper">
          <span id="auth-timer-text">۰۲:۰۰ تا ارسال مجدد کد</span>
          <a href="#" id="auth-resend-link" style="display: none;" onclick="handleResendCode(event)">ارسال مجدد کد</a>
        </div>

        <!-- دکمه تایید -->
        <button class="auth-submit-button" id="auth-verify-code-btn" onclick="handleVerifyCode()">
          تایید
        </button>

      </div>
    </div>
    
    <!-- ستون چپ - تصویر -->
    <div class="auth-stage-1-left">
      <img src="http://6tofit.com/wp-content/uploads/2026/08/YogaMat.png" alt="Login Image" class="auth-stage-1-image">
    </div>

  </div>
</div>
<style>
/* ==================== استیج ۲ ==================== */

/* باکس نمایش شماره/ایمیل */
.auth-identifier-display {
  display: flex;
  align-items: center;
  justify-content: space-between;

  max-width: 420px;
  height: 48px;
  border: 1px solid rgba(0, 0, 0, 0.12);
  border-radius: 1000000px;
  padding: 0 16px 0 12px;
  margin-bottom: 28px;
  background: #FFFFFF;
  box-sizing: border-box;
}

.auth-identifier-display span {
  font-size: 15px;
  color: #161618;
  font-family: 'iranyekan', sans-serif;
  direction: ltr;
  text-align: left;
}

.auth-edit-identifier {
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.auth-edit-identifier img {
  width: 20px;
  height: 20px;
}

/* ۴ باکس OTP */
.auth-otp-boxes {
  display: flex;
  gap: 12px;
  justify-content: center;
  width: 100%;
  max-width: 420px;
  margin-bottom: 24px;
  direction: ltr; /* اعداد از چپ به راست وارد بشن */
}

.auth-otp-input {
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

.auth-otp-input:focus {
  border-color: #5247FF;
}

/* تایمر و ارسال مجدد */
.auth-resend-wrapper {
  margin-bottom: 24px;
  text-align: center;
  min-height: 24px;
}

#auth-timer-text {
  font-size: 14px;
  color: #9B9BA1;
  font-family: 'iranyekan', sans-serif;
}

#auth-resend-link {
  font-size: 14px;
  color: #5247FF;
  text-decoration: none;
  font-family: 'iranyekan', sans-serif;
  font-weight: 500;
}

#auth-resend-link:hover {
  text-decoration: underline;
}

/* دکمه تایید استیج ۲ */
#auth-verify-code-btn {
  background: #E9E9EB;
  color: #9B9BA1;
}

#auth-verify-code-btn.active {
  background: #000000;
  color: #FFFFFF;
}



/* موبایل استیج ۲ */
@media only screen and (max-width: 768px) {
  .auth-identifier-display {
    max-width: 100%;
  }

  .auth-otp-boxes {
    max-width: 100%;
    gap: 8px;
  }

  .auth-otp-input {
    width: 52px;
    height: 52px;
    font-size: 20px;
  }
}
</style>
<script>
// ==================== استیج ۲ - OTP ====================

let authTimerInterval = null;
let authTimerSeconds = 120; // ۲ دقیقه

// وقتی از استیج ۱ به ۲ میریم، شماره/ایمیل رو نمایش بده و تایمر رو شروع کن
window.goToStage2 = function(identifier) {
  document.getElementById('auth-identifier-value').textContent = identifier;
  showAuthStage('auth-stage-2');
  startAuthTimer();
  // فوکوس روی اولین باکس OTP
  setTimeout(() => {
    document.querySelector('.auth-otp-input').focus();
  }, 100);
};

// شروع تایمر
function startAuthTimer() {
  clearInterval(authTimerInterval);
  authTimerSeconds = 120;

  const timerText = document.getElementById('auth-timer-text');
  const resendLink = document.getElementById('auth-resend-link');

  timerText.style.display = 'inline';
  resendLink.style.display = 'none';

  updateTimerDisplay();

  authTimerInterval = setInterval(() => {
    authTimerSeconds--;
    updateTimerDisplay();

    if (authTimerSeconds <= 0) {
      clearInterval(authTimerInterval);
      timerText.style.display = 'none';
      resendLink.style.display = 'inline';
    }
  }, 1000);
}

function updateTimerDisplay() {
  const minutes = Math.floor(authTimerSeconds / 60).toString().padStart(2, '0');
  const seconds = (authTimerSeconds % 60).toString().padStart(2, '0');
  document.getElementById('auth-timer-text').textContent = `${minutes}:${seconds} تا ارسال مجدد کد`;
}

// ارسال مجدد کد
window.handleResendCode = function(e) {
  e.preventDefault();

  const identifier = document.getElementById('auth-identifier-value')?.textContent || '';
  if (!identifier) return;

  const formData = new FormData();
  formData.append('action', 'send_auth_otp');
  formData.append('identifier', identifier);
  formData.append('phone', identifier);

  fetch('/wp-admin/admin-ajax.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      startAuthTimer();
      alert('کد جدید ارسال شد');
    } else {
      alert(data.data?.message || 'خطا در ارسال مجدد کد');
    }
  })
  .catch(err => {
    console.error(err);
    alert('خطا در ارتباط با سرور');
  });
};

// مدیریت ورود اعداد در باکس‌های OTP
document.addEventListener('DOMContentLoaded', function() {
  const otpInputs = document.querySelectorAll('.auth-otp-input');

  otpInputs.forEach((input, index) => {
    // فقط عدد قبول کنه
    input.addEventListener('input', function(e) {
      this.value = this.value.replace(/[^0-9]/g, '');

      if (this.value.length === 1 && index < otpInputs.length - 1) {
        otpInputs[index + 1].focus();
      }

      checkOtpComplete();
    });

    // با Backspace برگرد به قبلی
    input.addEventListener('keydown', function(e) {
      if (e.key === 'Backspace' && this.value === '' && index > 0) {
        otpInputs[index - 1].focus();
      }
    });

    // پیست کردن کد کامل
    input.addEventListener('paste', function(e) {
      e.preventDefault();
      const pasteData = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 4);
      
      pasteData.split('').forEach((char, i) => {
        if (otpInputs[i]) {
          otpInputs[i].value = char;
        }
      });

      if (pasteData.length > 0) {
        otpInputs[Math.min(pasteData.length, 3)].focus();
      }
      checkOtpComplete();
    });
  });
});

// چک کن همه ۴ رقم پر شدن یا نه
function checkOtpComplete() {
  const otpInputs = document.querySelectorAll('.auth-otp-input');
  const allFilled = Array.from(otpInputs).every(input => input.value.length === 1);
  const btn = document.getElementById('auth-verify-code-btn');

  if (allFilled) {
    btn.classList.add('active');
  } else {
    btn.classList.remove('active');
  }
}


// آپدیت تابع handleSendCode استیج ۱ (تا بره به استیج ۲)
window.handleSendCode = function() {
  const input = document.getElementById('auth-identifier');
  const value = input.value.trim();
  const btn = document.getElementById('auth-send-code-btn');

  if (!value) {
    alert('لطفا شماره موبایل یا ایمیل را وارد کنید');
    return;
  }

  // تشخیص نوع ورودی
  const isPhone = /^09[0-9]{9}$/.test(value.replace(/\s/g, ''));
  const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);

  if (!isPhone && !isEmail) {
    alert('لطفا یک شماره موبایل معتبر (مثل 09121234567) یا ایمیل معتبر وارد کنید');
    return;
  }

  btn.disabled = true;
  btn.textContent = 'در حال ارسال...';

  const formData = new FormData();
  formData.append('action', 'send_auth_otp');
  formData.append('identifier', value);   // ← مهم
  formData.append('phone', value);        // برای سازگاری با کد قبلی

  fetch('/wp-admin/admin-ajax.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    btn.disabled = false;
    btn.textContent = 'ارسال کد تایید';

    if (data.success) {
      goToStage2(value);
    } else {
      alert(data.data?.message || 'خطا در ارسال کد');
    }
  })
  .catch(err => {
    console.error(err);
    btn.disabled = false;
    btn.textContent = 'ارسال کد تایید';
    alert('خطا در ارتباط با سرور');
  });
};
</script>

   <!-- استیج ۳ -->
<div class="auth-stage" id="auth-stage-3">
  <div class="auth-stage-1-wrapper">

    <!-- ستون راست - فرم -->
    <div class="auth-stage-1-right">
      <div class="auth-stage-1-box">

        <!-- دکمه بستن -->
        <button class="auth-close auth-stage-1-close">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/State.svg" alt="Close Icon">
        </button>

        <!-- لوگو -->
        <div class="auth-stage-1-logo">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/6toFit_logo_Black_2.svg" alt="6tofit Logo">
        </div>

        <!-- عنوان -->
        <h2 class="auth-stage-1-title">اطلاعات کاربری</h2>

        <!-- توضیحات -->
        <p class="auth-stage-1-desc">
          لطفا اطلاعات خود را وارد کنید
        </p>

        <!-- فیلد نام و نام خانوادگی -->
        <div class="auth-form-field">
          <input type="text" id="auth-fullname" required placeholder=" ">
          <label for="auth-fullname">نام و نام خانوادگی</label>
        </div>

        <!-- فیلد تاریخ تولد + آیکن -->
        <div class="auth-form-field auth-birthdate-field">
          <input type="text" id="auth-birthdate" required placeholder=" " readonly>
          <label for="auth-birthdate">تاریخ تولد</label>
          <button type="button" class="auth-birthdate-icon" onclick="openBirthdatePicker()">
            <!-- آیکن خودت رو اینجا بذار -->
            <img src="http://6tofit.com/wp-content/uploads/2026/08/Calendar-Iconly-Pro.svg" alt="Calendar">
          </button>
        </div>

        <!-- سه گزینه جنسیت -->
        <div class="auth-gender-options">
          <button type="button" class="auth-gender-btn" data-gender="female" onclick="selectGender(this)">زن</button>
          <button type="button" class="auth-gender-btn" data-gender="male" onclick="selectGender(this)">مرد</button>
          <button type="button" class="auth-gender-btn" data-gender="other" onclick="selectGender(this)">سایر</button>
        </div>

        <!-- دکمه ثبت اطلاعات -->
        <button class="auth-submit-button" id="auth-submit-info-btn" onclick="handleSubmitInfo()">
          ثبت اطلاعات
        </button>

      </div>
    </div>
    
    <!-- ستون چپ - تصویر -->
    <div class="auth-stage-1-left">
      <img src="http://6tofit.com/wp-content/uploads/2026/08/YogaMat.png" alt="Login Image" class="auth-stage-1-image">
    </div>

  </div>
</div>
<style>
/* ==================== استیج ۳ ==================== */

/* فیلد تاریخ تولد با آیکن سمت چپ */
.auth-birthdate-field {
  position: relative;
}

.auth-birthdate-field input {
  padding-left: 48px !important; /* جا برای آیکن */
}

.auth-birthdate-icon {
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

.auth-birthdate-icon img {
  width: 22px;
  height: 22px;
}

/* سه گزینه جنسیت */
.auth-gender-options {
  display: flex;
  gap: 12px;
  width: 100%;
  max-width: 420px;
  margin-bottom: 24px;
}

.auth-gender-btn {
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

.auth-gender-btn:hover {
  border-color: rgba(0, 0, 0, 0.25);
}

.auth-gender-btn.selected {
  background: #ffffff;
  border-color: #5247FF;
  color: #000000;
}

/* دکمه ثبت اطلاعات */
#auth-submit-info-btn {
  background: #E9E9EB;
  color: #9B9BA1;
}

#auth-submit-info-btn.active {
  background: #000000;
  color: #FFFFFF;
}

#auth-submit-info-btn.active:hover {
  background: #4338e0;
}

/* موبایل استیج ۳ */
@media only screen and (max-width: 768px) {
  .auth-gender-options {
    max-width: 100%;
    gap: 8px;
  }

  .auth-gender-btn {
    font-size: 14px;
  }
}
</style>
<script>
// ==================== استیج ۳ - اطلاعات کاربری ====================

let selectedGender = null;

// انتخاب جنسیت
window.selectGender = function(btn) {
  // همه دکمه‌ها رو از حالت selected خارج کن
  document.querySelectorAll('.auth-gender-btn').forEach(b => {
    b.classList.remove('selected');
  });

  // دکمه کلیک‌شده رو selected کن
  btn.classList.add('selected');
  selectedGender = btn.getAttribute('data-gender');

  checkInfoFormComplete();
};

// چک کردن کامل بودن فرم
function checkInfoFormComplete() {
  const fullname = document.getElementById('auth-fullname').value.trim();
  const birthdate = document.getElementById('auth-birthdate').value.trim();
  const btn = document.getElementById('auth-submit-info-btn');

  if (fullname && birthdate && selectedGender) {
    btn.classList.add('active');
  } else {
    btn.classList.remove('active');
  }
}

// لیسنر برای فیلدها
document.addEventListener('DOMContentLoaded', function() {
  const fullnameInput = document.getElementById('auth-fullname');
  const birthdateInput = document.getElementById('auth-birthdate');

  if (fullnameInput) {
    fullnameInput.addEventListener('input', checkInfoFormComplete);
  }
  if (birthdateInput) {
    birthdateInput.addEventListener('input', checkInfoFormComplete);
  }
});

// باز کردن انتخابگر تاریخ (فعلاً ساده)
window.openBirthdatePicker = function() {
  // بعداً می‌تونی datepicker واقعی وصل کنی
  // فعلاً یک پرامپت ساده:
  const date = prompt('تاریخ تولد را وارد کنید (مثال: ۱۳۷۵/۰۵/۱۲)');
  if (date) {
    document.getElementById('auth-birthdate').value = date;
    // لیبل رو مخفی کن
    document.getElementById('auth-birthdate').dispatchEvent(new Event('input'));
    checkInfoFormComplete();
  }
};

// ثبت اطلاعات
window.handleSubmitInfo = function() {
  const fullname = document.getElementById('auth-fullname').value.trim();
  const birthdate = document.getElementById('auth-birthdate').value.trim();
  const identifier = document.getElementById('auth-identifier-value')?.textContent || '';

  if (!fullname || !birthdate || !selectedGender) {
    alert('لطفا همه اطلاعات را کامل وارد کنید');
    return;
  }

  const btn = document.getElementById('auth-submit-info-btn');
  btn.disabled = true;
  btn.textContent = 'در حال ثبت‌نام...';

  const formData = new FormData();
  formData.append('action', 'register_auth_user');
  formData.append('identifier', identifier);
  formData.append('fullname', fullname);
  formData.append('birthdate', birthdate);
  formData.append('gender', selectedGender);

  fetch('/wp-admin/admin-ajax.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    btn.disabled = false;
    btn.textContent = 'ثبت اطلاعات';

    if (data.success) {
      alert(data.data.message || 'ثبت‌نام با موفقیت انجام شد');
      window.location.href = data.data.redirect || '/';
    } else {
      alert(data.data?.message || 'خطا در ثبت‌نام');
    }
  })
  .catch(err => {
    console.error(err);
    btn.disabled = false;
    btn.textContent = 'ثبت اطلاعات';
    alert('خطا در ارتباط با سرور');
  });
};

// آپدیت تابع تایید کد استیج ۲ (تا بره به استیج ۳)
window.handleVerifyCode = function() {
  const otpInputs = document.querySelectorAll('.auth-otp-input');
  const code = Array.from(otpInputs).map(input => input.value).join('');
  const identifier = document.getElementById('auth-identifier-value')?.textContent || '';

  if (code.length !== 4) {
    alert('لطفا کد ۴ رقمی را کامل وارد کنید');
    return;
  }

  const btn = document.getElementById('auth-verify-code-btn');
  btn.disabled = true;
  btn.textContent = 'در حال بررسی...';

  const formData = new FormData();
  formData.append('action', 'verify_auth_otp');
  formData.append('identifier', identifier);
  formData.append('phone', identifier);
  formData.append('code', code);

  fetch('/wp-admin/admin-ajax.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    btn.disabled = false;
    btn.textContent = 'تایید';

    if (data.success) {
      if (data.data.action === 'login') {
        // کاربر وجود داشت → لاگین شد
        alert(data.data.message || 'ورود موفقیت‌آمیز بود');
        window.location.href = data.data.redirect || '/';
      } else {
        // کاربر جدید → برو به استیج اطلاعات
        showAuthStage('auth-stage-3');
      }
    } else {
      alert(data.data?.message || 'کد اشتباه است');
    }
  })
  .catch(err => {
    console.error(err);
    btn.disabled = false;
    btn.textContent = 'تایید';
    alert('خطا در ارتباط با سرور');
  });
};
</script>
  <!-- استیج ۴ -->
<div class="auth-stage" id="auth-stage-4">
  <div class="auth-stage-4-wrapper">
    <div class="auth-stage-4-box">

      <!-- دکمه بستن -->
      <button class="auth-close auth-stage-1-close">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/State.svg" alt="Close Icon">
      </button>

      <!-- عنوان -->
      <h2 class="auth-stage-4-title">تاریخ تولد</h2>

      <!-- عنوان ستون‌ها -->
      <div class="auth-date-labels">
        <span>روز</span>
        <span>ماه</span>
        <span>سال</span>
      </div>

      <!-- انتخابگر تاریخ -->
      <div class="auth-date-picker">
        <!-- هایلایت خاکستری وسط -->
        <div class="auth-date-highlight"></div>

        <!-- ستون روز -->
        <div class="auth-date-column" data-type="day">
          <div class="auth-date-scroller" id="auth-day-scroller"></div>
        </div>

        <!-- ستون ماه -->
        <div class="auth-date-column" data-type="month">
          <div class="auth-date-scroller" id="auth-month-scroller"></div>
        </div>

        <!-- ستون سال -->
        <div class="auth-date-column" data-type="year">
          <div class="auth-date-scroller" id="auth-year-scroller"></div>
        </div>
      </div>

      <!-- دکمه ادامه -->
      <button class="auth-submit-button active" id="auth-date-continue-btn" onclick="handleDateContinue()">
        ادامه
      </button>

    </div>
  </div>
</div>

  </div>
</div>


<style>
/* ==================== استیج ۴ - تاریخ تولد ==================== */

.auth-stage-4-wrapper {
    display: flex;
    height: 100%;
    min-height: 520px;
    border-radius: 40px;
    overflow: hidden;
}

.auth-stage-4-box {
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

.auth-stage-4-title {
  font-size: 22px;
  font-weight: 700;
  color: #000000;
  margin: 12px 0 28px 0;
  text-align: center;
}

/* عنوان ستون‌ها */
.auth-date-labels {
  display: flex;
  width: 100%;
  margin-bottom: 12px;
  font-size: 16px;
  color: #000000;
  font-family: 'iranyekan', sans-serif;
}

.auth-date-labels span {
  flex: 1;
  text-align: center;
}

/* کانتینر اصلی پیکر */
.auth-date-picker {
  position: relative;
  display: flex;
  width: 100%;
  height: 192px; /* 4 * 48 */
  margin-bottom: 36px;
  overflow: hidden;
  user-select: none;
  -webkit-user-select: none;
}

/* هایلایت خاکستری وسط */
.auth-date-highlight {
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

/* هر ستون */
.auth-date-column {
  flex: 1;
  height: 100%;
  overflow: hidden;
  position: relative;
  z-index: 2;
  cursor: grab;
}

.auth-date-column:active {
  cursor: grabbing;
}

.auth-date-scroller {
  display: flex;
  flex-direction: column;
  align-items: center;
  will-change: transform;
}

.auth-date-item {
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

.auth-date-item.selected {
  color: #161618;
  font-weight: 700;
  font-size: 18px;
}

/* دکمه ادامه */
#auth-date-continue-btn {
  width: 100%;
  max-width: 320px;
  margin-top: 0;
  margin-bottom: 0;
  background: #000000 !important;
  color: #FFFFFF !important;
}

/* موبایل */
@media only screen and (max-width: 768px) {
  .auth-stage-4-wrapper {
    min-height: auto;
    padding: 20px 0px 0px;
		border-radius: 40px 40px 0 0;
  }

  .auth-stage-4-box {
    padding: 36px 20px 32px;
    max-width: 100%;
	min-width:unset;
	border-radius: 40px 40px 0 0;
  }
  .auth-popup-content:has(#auth-stage-4.active) {
    background: unset;
	display: flex;
        flex-direction: column;
        justify-content: flex-end;
}

  .auth-date-picker {
    height: 192px;
  }
}
</style>
<script>
// ==================== استیج ۴ - انتخاب تاریخ تولد (نسخه اصلاح شده) ====================

const persianMonths = [
  { num: 1, name: 'فروردین' },
  { num: 2, name: 'اردیبهشت' },
  { num: 3, name: 'خرداد' },
  { num: 4, name: 'تیر' },
  { num: 5, name: 'مرداد' },
  { num: 6, name: 'شهریور' },
  { num: 7, name: 'مهر' },
  { num: 8, name: 'آبان' },
  { num: 9, name: 'آذر' },
  { num: 10, name: 'دی' },
  { num: 11, name: 'بهمن' },
  { num: 12, name: 'اسفند' }
];

let selectedDay = 15;
let selectedMonth = 6;
let selectedYear = 1375;

const ITEM_HEIGHT = 48;

function createDateScroller(scrollerId, items, selectedValue, type) {
  const scroller = document.getElementById(scrollerId);
  if (!scroller) {
    console.error('Scroller not found:', scrollerId);
    return;
  }

  scroller.innerHTML = '';

  const paddingCount = 2;

  // پدینگ بالا
  for (let i = 0; i < paddingCount; i++) {
    const empty = document.createElement('div');
    empty.className = 'auth-date-item';
    empty.innerHTML = '&nbsp;';
    scroller.appendChild(empty);
  }

  // آیتم‌ها
  items.forEach((item) => {
    const el = document.createElement('div');
    el.className = 'auth-date-item';
    el.dataset.value = item.value;
    el.textContent = item.label;
    scroller.appendChild(el);
  });

  // پدینگ پایین
  for (let i = 0; i < paddingCount; i++) {
    const empty = document.createElement('div');
    empty.className = 'auth-date-item';
    empty.innerHTML = '&nbsp;';
    scroller.appendChild(empty);
  }

  // موقعیت اولیه
  const selectedIndex = items.findIndex(i => i.value === selectedValue);
  const safeIndex = selectedIndex >= 0 ? selectedIndex : 0;
  const offset = (safeIndex + paddingCount - 1) * ITEM_HEIGHT;
  scroller.style.transform = `translateY(-${offset}px)`;

  // کلاس selected
  updateSelectedClass(scroller, safeIndex + paddingCount);

  // درگ
  setupDrag(scroller, items, type, paddingCount);
}

function updateSelectedClass(scroller, index) {
  const items = scroller.querySelectorAll('.auth-date-item');
  items.forEach((el, i) => {
    el.classList.toggle('selected', i === index);
  });
}

function setupDrag(scroller, items, type, paddingCount) {
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
    const minOffset = -((items.length + paddingCount * 2 - 3) * ITEM_HEIGHT);
    newOffset = clamp(newOffset, minOffset, maxOffset);

    setOffset(newOffset);

    const rawIndex = Math.round((-newOffset) / ITEM_HEIGHT);
    const realIndex = clamp(rawIndex - paddingCount + 1, 0, items.length - 1);
    updateSelectedClass(scroller, realIndex + paddingCount);

    if (type === 'day') selectedDay = items[realIndex].value;
    if (type === 'month') selectedMonth = items[realIndex].value;
    if (type === 'year') selectedYear = items[realIndex].value;
  };

  const onEnd = () => {
    if (!isDragging) return;
    isDragging = false;
    scroller.style.transition = 'transform 0.2s ease-out';

    const current = getOffset();
    const rawIndex = Math.round((-current) / ITEM_HEIGHT);
    const realIndex = clamp(rawIndex - paddingCount + 1, 0, items.length - 1);
    const finalOffset = -((realIndex + paddingCount - 1) * ITEM_HEIGHT);

    setOffset(finalOffset);
    updateSelectedClass(scroller, realIndex + paddingCount);

    if (type === 'day') selectedDay = items[realIndex].value;
    if (type === 'month') selectedMonth = items[realIndex].value;
    if (type === 'year') selectedYear = items[realIndex].value;
  };

  scroller.addEventListener('mousedown', (e) => {
    e.preventDefault();
    onStart(e.clientY);
  });

  window.addEventListener('mousemove', (e) => onMove(e.clientY));
  window.addEventListener('mouseup', onEnd);

  scroller.addEventListener('touchstart', (e) => {
    onStart(e.touches[0].clientY);
  }, { passive: true });

  scroller.addEventListener('touchmove', (e) => {
    onMove(e.touches[0].clientY);
  }, { passive: true });

  scroller.addEventListener('touchend', onEnd);
}

function initDatePicker() {
  console.log('Initializing date picker...');

  const dayScroller = document.getElementById('auth-day-scroller');
  const monthScroller = document.getElementById('auth-month-scroller');
  const yearScroller = document.getElementById('auth-year-scroller');

  if (!dayScroller || !monthScroller || !yearScroller) {
    console.error('Date picker elements not found in DOM');
    return;
  }

  // روز
  const days = Array.from({ length: 31 }, (_, i) => ({
    value: i + 1,
    label: String(i + 1)
  }));

  // ماه
  const months = persianMonths.map(m => ({
    value: m.num,
    label: m.name
  }));

  // سال
  const years = [];
  for (let y = 1404; y >= 1330; y--) {
    years.push({ value: y, label: String(y) });
  }

  createDateScroller('auth-day-scroller', days, selectedDay, 'day');
  createDateScroller('auth-month-scroller', months, selectedMonth, 'month');
  createDateScroller('auth-year-scroller', years, selectedYear, 'year');

  console.log('Date picker initialized successfully');
}

// باز کردن پیکر تاریخ
window.openBirthdatePicker = function() {
  console.log('Opening birthdate picker...');
  showAuthStage('auth-stage-4');

  // چند بار تلاش می‌کنیم تا مطمئن بشیم DOM آماده است
  setTimeout(initDatePicker, 50);
  setTimeout(initDatePicker, 150);
  setTimeout(initDatePicker, 300);
};

// دکمه ادامه
window.handleDateContinue = function() {
  const formatted = `${selectedYear}/${String(selectedMonth).padStart(2, '0')}/${String(selectedDay).padStart(2, '0')}`;

  const birthdateInput = document.getElementById('auth-birthdate');
  if (birthdateInput) {
    birthdateInput.value = formatted;
    birthdateInput.dispatchEvent(new Event('input'));
    birthdateInput.dispatchEvent(new Event('change'));
  }

  showAuthStage('auth-stage-3');
};
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('auth-popup');
    if (!popup) {
      console.error('Auth popup element not found!');
      return;
    }

    window.showAuthPopup = function() {
      popup.classList.add('active');
      showAuthStage('auth-stage-1');
    };

    window.hideAuthPopup = function() {
      popup.classList.remove('active');
      showAuthStage('auth-stage-1');
    };

    window.showAuthStage = function(stageId) {
      document.querySelectorAll('.auth-stage').forEach(stage => {
        stage.classList.remove('active');
      });
      const stage = document.getElementById(stageId);
      if (stage) {
        stage.classList.add('active');
      } else {
        console.error('Stage not found: ' + stageId);
      }
    };

    popup.addEventListener('click', function(e) {
      if (e.target === this) hideAuthPopup();
    });

    document.querySelectorAll('.auth-close').forEach(button => {
      button.addEventListener('click', hideAuthPopup);
    });
  });
</script>
<?php
    $popup_html = ob_get_clean();
    echo $popup_html;
}
?>