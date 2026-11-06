
<style>
.free-consultation-popup-overlay.active {
    display: flex !important;
}

.free-consultation-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(13, 13, 13, 0.56);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    backdrop-filter: blur(50px);
    -webkit-backdrop-filter: blur(50px);
}

.free-consultation-popup-content {
    background: #101012;
    border-radius: 40px;
    padding: 30px;
    width: 840px;
    text-align: center;
}

.free-consultation-popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
}

.free-consultation-close {
    background: none;
    border: none;
    cursor: pointer;
}

.free-consultation-close img {
    width: 48px;
    height: 48px;
	    background: #38383D;
    border-radius: 10000px;
}

.free-consultation-back {
    background: none;
    border: none;
    cursor: pointer;
}

.free-consultation-back img {
    width: 48px;
    height: 48px;
	background: #38383D;
    border-radius: 10000px;
}

.free-consultation-popup-content h2 {
    font-size: 20px;
    font-weight: 500;
    color: #E9E9EB;
    margin: 0 auto;
    flex-grow: 1;
    text-align: center;
    padding-left: 48px;
}

.free-consultation-popup-content p {
    font-size: 18px;
    font-weight: 400;
    color: #E9E9EB;
    margin: 60px 0;
}

.consultation-cards {
    display: flex;
    gap: 16px;
    justify-content: center;
}

.consultation-card {
    background: #212124;
    border-radius: 24px;
    padding: 32px;
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.consultation-card img {
    width: 48px;
    height: 48px;
    object-fit: contain;
    margin-bottom: 12px;
}

.consultation-card p {
    font-size: 16px;
    color: #B8B8BC;
    margin: 12px 0;
}

.consultation-card button {
    background: #38383D;
    border: none;
    padding: 8px 10px;
    font-size: 16px;
    color: #A9A9AF;
    border-radius: 1000000px;
    cursor: pointer;
    min-width: 125px;
  
}

.free-consultation-popup-content .stage-content {
    display: none;
}

.free-consultation-popup-content .stage-content.active {
    display: block;
}

.form-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.form-field {
    position: relative;
    width: 420px;
    margin-bottom: 16px;
}

.form-field input {
    width: 100%;
    height: 56px;
    border: 1px solid rgba(0, 0, 0, 0.12);
    border-radius: 1000000px;
    padding-top: 8px;
    padding-bottom: 8px;
    padding-right:20px;
    padding-left:20px;
    font-size: 16px;
 
    box-sizing: border-box;
}

.form-field label {
    position: absolute;
    top: 50%;
    right: 29px;
    transform: translateY(-50%);
    font-size: 16px;
    color: #161618;
 
    pointer-events: none;
}

.submit-button {
    background: #38383D;
    border: none;
    padding: 12px 10px;
    font-size: 18px;
    color: #A9A9AF;
    border-radius: 1000000px;
    cursor: pointer;
    
    min-width: 240px;
    margin-top: 50px;
}

.form-field input {
    transition: all 0.3s ease;
}

.form-field input:focus + label,
.form-field input:valid + label {
    opacity: 0;
    transform: translateY(-1.5rem);
}

.submit-button {
    transition: background-color 0.3s ease;
}

/* تغییرات برای موبایل */
@media only screen and (max-width: 768px) {
    .free-consultation-popup-overlay {
        z-index: 9999;
    }
    .free-consultation-popup-content p{
            margin: 10px 0;
    }

    .free-consultation-popup-content {
        width: 100%;
        height: 100%;
        border-radius: 0;
        padding: 20px;
        box-sizing: border-box;
    }

    .free-consultation-popup-content h2 {
        font-size: 20px;
    }

    .free-consultation-popup-content p {
        font-size: 15px;
    }

    .consultation-cards {
        flex-direction: column;
        gap: 16px;
    }

    .consultation-card {
        width: 100%;
    }

    .consultation-card p {
        font-size: 15px;
    }

    .form-container {
        position: relative;
        height: 100%;
        justify-content: space-between;
    }

    .form-field {
        width: 100%;
    }
    .consultation-card{
        padding: 16px;
		width:auto;
    }
	.free-consultation-close img{
		    background: #38383d00;
    border-radius: 10000px;
	}
	.free-consultation-back img{
		background: #38383d00;
    border-radius: 10000px;
	}
    

    .submit-button {
      margin-top: 300px;
        bottom: 20px;
        width: 100%;
        max-width: 90%;
    }
}
</style>
<?php
function render_free_vip_consultation_popup($title = "مشاوره رایگان", $submit_text = "ارسال درخواست") {
    // Start output buffering to capture HTML
    ob_start();
?>
<div class="free-consultation-popup-overlay" id="free-consultation-popup">
  <div class="free-consultation-popup-content">
    <div class="stage-content active" id="stage-main">
      <div class="free-consultation-popup-header">
        <button class="free-consultation-close">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/closvipcons.svg" alt="Close Icon">
        </button>
        <h2><?php echo htmlspecialchars($title); ?></h2>
        
      </div>
      <p>با انتخاب هر یک از روش‌های زیر، مشاوران ما در طول ۴۸ ساعت آینده با شما ارتباط برقرار خواهند کرد.</p>
      <div class="consultation-cards">
        <div class="consultation-card">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/whatsapp.svg" alt="Card Image 1">
          <p>ارسال پیام مستقیم در واتساپ و دریافت مشاوره</p>
          <button onclick="window.open('https://wa.me/14376065506', '_blank')">پیام در واتساپ</button>
        </div>
        <div class="consultation-card">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/Speech.svg" alt="Card Image 2">
          <p>ثبت شماره موبایل جهت دریافت مشاوره در واتساپ</p>
          <button onclick="showStage('stage-2')">ثبت شماره</button>
        </div>
        <div class="consultation-card">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/google.svg" alt="Card Image 3">
          <p>رزرو زمان جلسه مشاوره آنلاین در گوگل میت</p>
          <button onclick="showStage('stage-3')">رزرو جلسه مشاوره</button>
        </div>
      </div>
    </div>
    <div class="stage-content" id="stage-2">
      <div class="free-consultation-popup-header">
        <button class="free-consultation-back" onclick="showStage('stage-main')">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/rightvip.svg" alt="Back Icon">
        </button>
        <h2 style="padding-left:0px;">ثبت شماره</h2>
        <button class="free-consultation-close">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/closvipcons.svg" alt="Close Icon">
        </button>
      </div>
      <p>پس از ثبت شماره، کارشناسان ما ظرف مدت ۴۸ ساعت در واتساپ با شما ارتباط خواهند گرفت.</p>
      <div class="form-container">
        <?php echo do_shortcode('[sixtofit_form title="برنامه ورزشی"]'); ?>
      </div>
    </div>
    <div class="stage-content" id="stage-3">
      <div class="free-consultation-popup-header">
        <button class="free-consultation-back" onclick="showStage('stage-main')">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/rightvip.svg" alt="Back Icon">
        </button>
        <h2 style="padding-left:0px;">رزرو جلسه مشاوره</h2>
        <button class="free-consultation-close">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/closvipcons.svg" alt="Close Icon">
        </button>
      </div>
      <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
      <div 
        class="calendly-inline-widget"
        data-url="https://calendly.com/fatemeh-ghorbani1075/30min"
        style="min-width:320px; height:630px;">
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('free-consultation-popup');
    if (!popup) {
      console.error('Popup element not found!');
      return;
    }

    window.showFreeVipConsultationPopup = function() {
      console.log('Attempting to show popup');
      popup.classList.add('active');
    };

    window.hideFreeConsultationPopup = function() {
      popup.classList.remove('active');
      showStage('stage-main');
    };

    window.showStage = function(stageId) {
      document.querySelectorAll('.stage-content').forEach(stage => {
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
      if (e.target === this) hideFreeConsultationPopup();
    });

    document.querySelectorAll('.free-consultation-close').forEach(button => {
      button.addEventListener('click', hideFreeConsultationPopup);
    });
  });
</script>
<?php
    // Capture and echo the HTML
    $popup_html = ob_get_clean();
    echo $popup_html;
}
?>