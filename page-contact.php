<?php
/* Template Name: صفحه تماس با ما */
get_header('light');?>

<style>
body{
	background-color:#ffffff;
}
  .contact-section {
    width: 100%;
    padding: 80px 0;
  
	margin-top: 80px;
  }

  .contact-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    text-align: center;
  }

  .contact-title {
    font-size: 44px;
    font-weight: 500;
    color: #161618;
    margin: 0 0 20px 0;
    line-height: 1.2;
  }

  .contact-subtitle {
    font-size: 20px;
    font-weight: 400;
    color: #65656D;
    margin: 0;
    line-height: 1.5;
	font-family:'iranyekanen';
  }

  /* موبایل */
  @media (max-width: 768px) {
    .contact-section {
      padding: 40px 0;
    }

    .contact-title {
      font-size: 32px;
    }

    .contact-subtitle {
      font-size: 18px;
    }
  }
</style>

<section class="contact-section">
  <div class="contact-container">
    <h1 class="contact-title">تماس با ما</h1>
    <p class="contact-subtitle">تیم سیکس‌توفیت اینجاست تا به شما کمک کنه و هرگونه پرسش یا نیازی که دارید رو با دقت پاسخ بده. اگر سوال یا مشکلی دارید، فقط کافیه با ما در تماس باشید. ما همیشه آماده‌ی پشتیبانی و راهنمایی به شما هستیم!</p>
  
  </div>
</section>

<style>
  .contact-info-section {
    width: 100%;
    padding: 80px 0;
    background-color: #FFFFFF;
  }

  .contact-info-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1.2fr;
    gap: 0;
    align-items: start;
  }

  .info-column {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    text-align: center;
    position: relative;
  }

 .info-column:first-child::before,
.info-column:nth-child(2)::before
 

 {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 1px;
    background-color: #D1D1D1;
  }

  .info-icon {
    margin-bottom: 20px;
  }

  .info-icon img {
    width: 40px;
    height: 40px;
  }

  .info-title {
    font-size: 18px;
    font-weight: 500;
    color: #161618;
    margin: 0 0 10px 0;
    text-align: center;
  }

  .info-text {
    font-size: 18px;
    font-weight: 400;
    color: #65656D;
    margin: 0 0 10px 0;
    text-align: center;
    line-height: 1.5;
  }

  .info-column:nth-child(3) .info-text:last-child {
    margin-bottom: 0;
  }

  /* هم‌تراز کردن ردیف‌ها با grid */
  .info-column > * {
    width: 100%;
  }

  /* موبایل */
  @media (max-width: 768px) {
    .info-grid {
      grid-template-columns: 1fr;
      gap: 40px;
    }
	 .info-column:first-child::before,
.info-column:nth-child(2)::before
 

 {
  display:none;
  }
  .info-column {
   
    padding-bottom: 16px;
    margin-bottom: 16px;
    border-bottom: 1px solid #ddd; /* خط طوسی کم‌رنگ */
  }

  .info-column:last-child {
    border-bottom: none; /* خط از روی آخرین حذف میشه */
    margin-bottom: 0;
    padding-bottom: 0;
  }

    .info-column:not(:first-child)::before {
      display: none;
    }

    .contact-info-section {
      padding: 40px 0;
    }

    .info-title,
    .info-text {
      font-size: 16px;
    }
  }


  
</style>

<section class="contact-info-section">
  <div class="contact-info-container">
    <div class="info-grid">
      <div class="info-column">
        <div class="info-icon">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/whatsappc.png" alt="آیکون تماس">
        </div>
        <h3 class="info-title">شماره واتساپ</h3>
        <p class="info-text">۰۱۶۴۷۵۰۷۴۰۴۳</p>
      </div>

      <div class="info-column">
        <div class="info-icon">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/Envelope.png" alt="آیکون ایمیل">
        </div>
        <h3 class="info-title">ایمیل</h3>
        <p class="info-text" style="font-family:'iranyekanen';" >info@6tofit.com</p>
      </div>

      <div class="info-column">
        <div class="info-icon">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/Round-Pushpin.png" alt="آیکون آدرس">
        </div>
        <h3 class="info-title">آدرس</h3>
        <p class="info-text">خیابان ولیعصر بالاتر از  باغ فردوس نرسیده به تجریش نبش کیارستمی برج فردوس طبقه ششم واحد  34</p>
        <p class="info-text" style="font-family:'iranyekanen';">88 Blue Jays Way #3904, Toronto, ON M5V 0L7, Canada</p>
      </div>
    </div>
  </div>
</section>


<style>
  .contact-form-section {
    width: 100%;
    padding: 80px 0;
    background-color: #FFFFFF;
  }

  .contact-form-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
    text-align: center;
  }

  /* موبایل */
  @media (max-width: 768px) {
    .contact-form-section {
      padding: 40px 0;
    }
  }
</style>

<section class="contact-form-section">
  <div class="contact-form-container">
    <?php echo do_shortcode('[sixtofit_inline_form]'); ?>
  </div>
</section>

<?php get_footer(); ?>