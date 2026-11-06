<?php
/* Template Name: صفحه VIP */
get_header('vip'); ?>

<style>
body{
	background-color: #101012;
}
  .vip-hero-section {
    width: 100%;
	height: 68dvh;
margin-top:50px;
    background-image: url('http://6tofit.com/wp-content/uploads/2025/10/vipheader.png'); /* تصویر دسکتاپ */
 
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    direction: rtl;
  }

  .vip-hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
 
  }

  .vip-hero-container {
    max-width: 1400px;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    position: relative;
    z-index: 1;
  }

  .vip-hero-left {
    flex: 1; /* ستون چپ خالی */
    height: 100%;
  }

  .vip-hero-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    max-width: 600px;
    padding: 40px;
  }

  .vip-hero-title {
    font-size: 44px;
    font-weight: 500;
    color: #E9E9EB;
    margin: 0 0 20px 0;
    line-height: 1.2;
    font-family: 'iranyekanen', sans-serif; /* فرض بر فونت */
  }

  .vip-hero-subtitle {
    font-size: 20px;
    font-weight: 500;
    color: #B8B8BC;
    margin: 0 0 40px 0;
    line-height: 1.5;
    font-family: 'iranyekanen', sans-serif;
  }

  .vip-images-row {
    display: flex;
    justify-content: center;

    margin-bottom: 30px;
  }

  .vip-images-row img {
margin-right: -10px;
    height: auto;
    border-radius: 12px; /* اختیاری */
  }

  .vip-hero-h2 {
    font-size: 20px;
    font-weight: 700;
    background: linear-gradient(90.11deg, #E64910 23.2%, #F51E55 36.59%, #DE39B3 49.98%, #C64CDB 63.37%, #0083EB 76.76%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0 0 20px 0;
    line-height: 1.3;
    font-family: 'iranyekanen', sans-serif;
  }

  .vip-hero-button {
    background-color: #5247FF;
    color: #FFFFFF;
    border: none;
    border-radius: 10000px;
    padding: 12px 10px;
    min-width: 72px;
    font-weight: 700;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-family: 'iranyekanen', sans-serif;
  }

  .vip-hero-button:hover {
    background-color: #4239D0;
  }

  /* موبایل: تصویر متفاوت و تغییرات */
  @media (max-width: 768px) {
    .vip-hero-section {
      background-image: url('http://6tofit.com/wp-content/uploads/2025/10/vipheadermob-1.png'); /* تصویر موبایل */
      height: 90vh; /* ارتفاع کمتر برای موبایل */
	  background-size: contain;
    }

    .vip-hero-container {
      flex-direction: column;
      justify-content: center;
      padding: 0 10px;
	  margin-bottom: 220px;
    }

    .vip-hero-left {
      display: none; /* ستون چپ در موبایل مخفی */
    }

    .vip-hero-right {
      flex: none;
      padding: 20px;
      max-width: 100%;
    }

    .vip-hero-title {
      font-size: 32px;
    }

    .vip-hero-subtitle {
      font-size: 18px;
      margin-bottom: 30px;
    }

    .vip-images-row {
      gap: -5px;
    }

    .vip-images-row img {
      width: 48px;
    }

    .vip-hero-h2 {
      font-size: 18px;
    }

    .vip-hero-button {
      min-width: 200px; /* بزرگتر در موبایل */
    }
  }
</style>

<!-- سکشن اول: Hero با پس‌زمینه -->
<section class="vip-hero-section">
  <div class="vip-hero-overlay"></div>
  <div class="vip-hero-container">
    
    <div class="vip-hero-right">
      <h1 class="vip-hero-title">آغاز مسیر اختصاصی تو</h1>
      <p class="vip-hero-subtitle">تجربه‌ای شخصی‌سازی‌شده با سامان خوارزمی<br>برای رسیدن به بهترین نسخه‌ی خودت</p>
      <div class="vip-images-row">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/vipic1.png" alt="تصویر 1">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/vipic2.png" alt="تصویر 2">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/vipic3.png" alt="تصویر 3">
      </div>
      <h2 class="vip-hero-h2">۴۵۰+ ورزشکار VIP در حال پیشرفت</h2>
      <button class="vip-hero-button" onclick="showFreeVipConsultationPopup()">ثبت درخواست مشاوره</button>
    </div>
	<div class="vip-hero-left">
      <!-- خالی -->
    </div>
  </div>
  <?php
  include __DIR__ . '/template-parts/vip-consultation-popup.php';
        // Render the popup at the end of the body
        render_free_vip_consultation_popup("مشاوره رایگان", "ارسال درخواست");
?>
</section>

<style>
  .vip-features-section {
    width: 100%;
    background-color: #212124;
    padding: 50px 0;
    direction: rtl;
  }

  .vip-features-container {
    margin: 0 auto;
  }

  .vip-features-title {
    width: 80%;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 50px;
  }

  .vip-features-title h2 {
    font-size: 30px;
    font-weight: 500;
    color: #E9E9EB;
    margin: 0;
  }

  .features-carousel-container {
    position: relative;
    overflow: hidden;
  }

  .features-carousel {
    display: flex;
    transition: transform 0.5s ease-in-out;
    width: calc(100% + 12px); /* برای spacing */
    padding-right: 90px;
  }

  .features-card {
    background-color: transparent;
    border-radius: 24px;
    overflow: hidden;
    margin-left: 40px;
    flex: 0 0 400px;
  }

  .features-image {
    width: 100%;
    height: 390px;
    object-fit: cover;
    border-radius: 24px;
  }

  .features-content {
    padding: 24px;
  }

  .features-card-title {
    font-size: 20px;
    font-weight: 500;
    color: #E9E9EB;
    margin: 0 0 10px 0;
    line-height: 1.3;
    text-decoration: none;
  }

  .features-card-text {
    font-size: 20px;
    font-weight: 400;
    color: #B8B8BC;
    margin: 0;
    line-height: 1.4;
  }

  .features-prev,
  .features-next {
    left: 0;
    background: none;
    border: none;
    cursor: pointer;
    width: 40px;
    height: 40px;
  }

  .features-next {
    left: auto;
    right: 0;
    margin-right: 0;
  }

  .features-prev img,
  .features-next img {
background-color: #38383D;
    border-radius: 10000000px;
    height: 100%;
  }

  .features-prev-next {
    display: flex;
    margin-top: 10px;
    flex-direction: row-reverse;
    padding-left: 100px;
    justify-content: flex-start;
    gap: 24px;
  }

  /* Mobile */
  @media only screen and (max-width: 768px) {
    .vip-features-section {
      padding: 50px 0;
    }

    .features-carousel {
      padding-right: 30px;
    }

    .vip-features-container {
      width: 90%;
    }

    .vip-features-title h2 {
      font-size: 24px;
    }

    .features-card {
      flex: 0 0 280px;
      margin-left: 8px;
    }

    .features-prev,
    .features-next {
      display: none;
    }

    .features-carousel {
      touch-action: pan-y;
    }

    .features-card-title {
      font-size: 20px;
    }

    .features-card-text {
      font-size: 18px;
    }
  }
  .rotated img {
  transform: rotate(180deg); /* برعکس کردن جهت */
}
</style>

<section class="vip-features-section">
  <div class="vip-features-container">
    <div class="vip-features-title">
      <h2>ویژگی‌های پلن VIP</h2>
    </div>
    <div class="features-carousel-container">
      <div class="features-carousel" id="featuresCarousel">
        <!-- کارت استاتیک 1 -->
        <article class="features-card">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/vizh1.png" alt="ویژگی 1" class="features-image">
          <div class="features-content">
            <h3 class="features-card-title">رودمپ ۶ ماهه، مخصوص مسیر تو</h3>
            <p class="features-card-text">در این برنامه‌ی ۶ ماهه، هر مرحله با دقت بر اساس نیازها و توانایی‌های تو طراحی شده تا مسیر پیشرفت، واضح و دست‌یافتنی باشد.</p>
          </div>
        </article>

        <!-- کارت استاتیک 2 -->
        <article class="features-card">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/vizh2.png" alt="ویژگی 2" class="features-image">
          <div class="features-content">
            <h3 class="features-card-title"> رفع سلولیت، بهبود و فرم‌دهی بدن</h3>
            <p class="features-card-text">اگه سلولیت داری، اگه محدودیت حرکتی داری، مثل زانودرد، دیسک کمر یا هر درد مزمن دیگه، برنامه‌ت طوری طراحی می‌شه که به بهبودش کمک کند.</p>
          </div>
        </article>

        <!-- کارت استاتیک 3 -->
        <article class="features-card">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/vizh3.png" alt="ویژگی 3" class="features-image">
          <div class="features-content">
            <h3 class="features-card-title">همراهی هر روز، دقیق و اختصاصی</h3>
            <p class="features-card-text">اگر چیزی برات سخت یا ناکارآمد باشه، سریع بر اساس شرایطت تنظیمش می‌کنیم. چون مهمه که برنامه، با تو پیش بره، نه برعکس.</p>
          </div>
        </article>

        <!-- کارت استاتیک 4 -->
        <article class="features-card">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/vizh4.png" alt="ویژگی 4" class="features-image">
          <div class="features-content">
            <h3 class="features-card-title">رژیم غذایی شخصی، قابل تغییر در هر لحظه</h3>
            <p class="features-card-text">رژیمی شخصی‌سازی‌شده و انعطاف‌پذیر که با سبک زندگی تو هماهنگ شده و همیشه همراهت خواهد بود.</p>
          </div>
        </article>

      
      </div>
      <div class="features-prev-next">
	  <button class="features-next" onclick="moveFeaturesSlide(1)">
         <img src="http://6tofit.com/wp-content/uploads/2025/10/Statevipl.svg" alt="Previous">
        </button>
        <button class="features-prev rotated" onclick="moveFeaturesSlide(-1)">
		 <img src="http://6tofit.com/wp-content/uploads/2025/10/Statevipl.svg" alt="Next">
          
        </button>
        
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('featuresCarousel');
    const prevButton = document.querySelector('.features-prev');
    const nextButton = document.querySelector('.features-next');
    let currentFeatures = 0;
    const cards = carousel.querySelectorAll('.features-card');
    const cardWidth = cards[0] ? cards[0].offsetWidth + 12 : 320; // width + margin

    function moveFeaturesSlide(direction) {
        currentFeatures += direction;
        const maxSlide = Math.max(0, cards.length - Math.floor(carousel.parentElement.offsetWidth / cardWidth));
        currentFeatures = Math.max(0, Math.min(currentFeatures, maxSlide));
        carousel.style.transform = `translateX(${currentFeatures * cardWidth}px)`;
    }

    // Attach event listeners to buttons
    if (prevButton) {
       prevButton.addEventListener('click', () => moveFeaturesSlide(-1));
    }
    if (nextButton) {
       nextButton.addEventListener('click', () => moveFeaturesSlide(1));
    }

    // Touch/Swipe for mobile
    let startX = 0;
    let currentX = 0;
    let isDragging = false;

    carousel.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        isDragging = true;
    });

    carousel.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        currentX = e.touches[0].clientX;
        const diff = startX - currentX;
        if (Math.abs(diff) > 50) {
            // در RTL جهت لمس معکوس می‌شود
            moveFeaturesSlide(diff > 0 ? -1 : 1);
            isDragging = false;
        }
    });

    carousel.addEventListener('touchend', () => {
        isDragging = false;
    });
});
</script>




<style>
  .vip-video-section {
    width: 100%;
    height: 100vh;
  }

  .vip-video-container {
    position: relative;
    width: 100%;
    height: 100%;
  }

  .vip-video-player {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    cursor: pointer;
  }

  .vip-play-icon {
    position: absolute;
    top: 70px;
    right: 50px;
    cursor: pointer;
    z-index: 10;
  }

  .vip-play-icon img {
    width: 64px;
    height: 64px;
  }

  /* تغییرات برای موبایل */
  @media only screen and (max-width: 768px) {
    .vip-video-section {
      height: 480px;
    }

    .vip-play-icon {
      top: 30px;
      right: 30px;
    }

    .vip-play-icon img {
      width: 48px;
      height: 48px;
    }
  }
</style>

<section class="vip-video-section">
  <div class="vip-video-container">
    <video class="vip-video-player" poster="http://6tofit.com/wp-content/uploads/2025/10/pstervid-scaled.jpg" onclick="this.paused ? this.play() : this.pause();">
      <source src="https://six2fit.com/wp-content/uploads/2025/10/vip-video.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
    <a href="#" class="vip-play-icon" onclick="document.querySelector('.vip-video-player').play(); this.style.display='none';">
      <img src="http://6tofit.com/wp-content/uploads/2025/10/Iconplayvip.svg" alt="Play Icon">
    </a>
  </div>
</section>



<style>
  .vip-unique-section {
    width: 100%;
 
    padding: 50px 0;
    direction: rtl;
  }

  .vip-unique-container {
    margin: 0 auto;
  }

  .vip-unique-title {
    width: 80%;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 50px;
  }

  .vip-unique-title h2 {
    font-size: 30px;
    font-weight: 500;
    color: #E9E9EB;
    margin: 0;
  }

  .unique-carousel-container {
    position: relative;
    overflow: hidden;
  }

  .unique-carousel {
    display: flex;
    transition: transform 0.5s ease-in-out;
    width: calc(100% + 40px); /* برای spacing */
    padding-right: 90px;
  }

  .unique-card {
    background-color: #212124;
    border-radius: 24px;
    overflow: hidden;
    margin-left: 40px;
    flex: 0 0 400px;
    box-shadow: 0px 0px 3px 0px #0000000F;
    display: flex;
    flex-direction: column;
  }

  .unique-content {
    padding: 40px;
    display: grid;
    grid-template-rows: auto auto auto auto; /* هم‌ترازی ردیف‌ها */
    gap: 20px;
    height: 100%; /* برای هم‌ترازی ارتفاع */
    align-items: start;
  }

  .unique-icon-row {
    display: flex;
    
    grid-row: 1;
  }

  .unique-icon-row img {
    width: 60px;
    height: 60px;
  }

  .unique-title-row {
    grid-row: 2;
  }

  .unique-card-title {
    font-size: 20px;
    font-weight: 500;
    color: #E9E9EB;
    margin: 0;
    line-height: 1.3;
    text-decoration: none;
  }

  .unique-text-row {
    grid-row: 3;
  }

  .unique-card-text {
    font-size: 20px;
    font-weight: 400;
    color: #B8B8BC;
    margin: 0;
    line-height: 1.4;
  }

  .unique-bottom-row {
    display: flex;
justify-content: flex-end;
    align-items: flex-end;
    grid-row: 4;
  }

  .unique-bottom-icon {
    width: 48px;
    height: 48px;
    cursor: pointer;
    margin-left: 10px; /* چسبیده به چپ */
  }

  .unique-prev,
  .unique-next {
    left: 0;
    background: none;
    border: none;
    cursor: pointer;
    width: 40px;
    height: 40px;
  }

  .unique-next {
    left: auto;
    right: 0;
    margin-right: 0;
  }

  .unique-prev img,
  .unique-next img {
    background-color: #38383D;
    border-radius: 10000000px;
    height: 100%;
  }

  .unique-prev-next {
    display: flex;
    margin-top: 40px;
    flex-direction: row-reverse;
    padding-left: 100px;
    justify-content: flex-start;
    gap: 24px;
  }

  /* پاپ‌آپ */
  .popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #0D0D0D8F;
    backdrop-filter: blur(50px);
    z-index: 1000;
    display: none;
    justify-content: center;
    align-items: center;
  }

  .popup-card {
    background-color: #2D2D30;
    border-radius: 24px;
    padding: 80px 40px;
    max-width: 800px;
    width: 90%;
    text-align: center;
    position: relative;
    direction: rtl;
  }

  .popup-icon {
    margin-bottom: 30px;
  }

  .popup-icon img {
    width: 80px;
    height: 80px;
  }

  .popup-title {
    font-size: 24px;
    font-weight: 500;
    color: #E9E9EB;
    margin: 0 0 20px 0;
    line-height: 1.3;
  }

  .popup-text {
    font-size: 18px;
    font-weight: 400;
    color: #B8B8BC;
    margin: 0 0 30px 0;
    line-height: 1.5;
	font-family: 'iranyekanen';
  }

  .popup-close-btn {
    background-color: #38383D;
    color: #E9E9EB;
    border: none;
    border-radius: 10000px;
    padding: 12px 10px;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
    max-width: 200px;
  }

  .popup-close-btn:hover {
    background-color: #4A4A4F;
  }

  /* Mobile */
  @media only screen and (max-width: 768px) {
    .vip-unique-section {
      padding: 50px 0;
    }

    .unique-carousel {
      padding-right: 30px;
    }

    .vip-unique-container {
      width: 90%;
    }

    .vip-unique-title h2 {
      font-size: 24px;
    }

    .unique-card {
      flex: 0 0 280px;
      margin-left: 8px;
    }

    .unique-content {
      padding: 20px;
      gap: 15px;
    }

    .unique-prev,
    .unique-next {
      display: none;
    }

    .unique-carousel {
      touch-action: pan-y;
    }

    .unique-card-title {
      font-size: 18px;
    }

    .unique-card-text {
      font-size: 16px;
    }

    .popup-card {
		position: absolute;
      padding: 40px 20px;
	          border-top-left-radius: 24px;
        border-top-right-radius: 24px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
		bottom:0;
    }

    .popup-title {
      font-size: 20px;
    }

    .popup-text {
      font-size: 16px;
    }
  }

  .rotated img {
    transform: rotate(180deg); /* برعکس کردن جهت */
  }
</style>

<section class="vip-unique-section">
  <div class="vip-unique-container">
    <div class="vip-unique-title">
      <h2>چرا پلن VIP ما متفاوته؟</h2>
    </div>
    <div class="unique-carousel-container">
      <div class="unique-carousel" id="uniqueCarousel">
        <!-- کارت 1 -->
        <article class="unique-card">
          <div class="unique-content">
            <div class="unique-icon-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/Group.png" alt="آیکون 1">
            </div>
            <div class="unique-title-row">
              <h3 class="unique-card-title">گارانتی برگشت هزینه بی‌قید و شرط</h3>
            </div>
            <div class="unique-text-row">
              <p class="unique-card-text">هرگز نگران نتیجه نباشید؛ اگر به هدف نرسیدید، هزینه شما به‌طور کامل بازگردانده می‌شود.</p>
            </div>
            <div class="unique-bottom-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/Iconplusevip.svg" alt="آیکون پاپ‌آپ 1" class="unique-bottom-icon" data-popup-title="گارانتی برگشت هزینه بی‌قید و شرط" data-popup-text="ما در 62Fit باور داریم که سبک زندگی سالم و پرانرژی، حق طبیعی هر فرده. توی این مسیر، همراه و حامی تو هستیم تا بتونی به نسخه‌ای سالم‌تر، آرام‌تر و پرقدرت‌تر از خودت برسی. اما می‌دونیم که هر کسی شرایط و نیازهای متفاوتی داره، و گاهی ممکنه نتیجه‌ای که انتظارش رو داری، به دست نیاد. به همین خاطر، با احترام به انتخاب و تجربه‌ی تو، اگر دیدی خدمات VIP ما نتونسته خواسته‌ها و هدف‌هات رو برآورده کنه، بدون هیچ قید و شرطی، همه‌ی مبلغی که پرداخت کردی رو بهت برمی‌گردونیم.
این تضمین ماست که از اعتماد تو به عنوان یه سرمایه‌ی ارزشمند مراقبت کنیم و کاری کنیم که تو همیشه با حس آرامش، اعتماد و امنیت، قدم‌هات رو برداری. هیچ قضاوت یا تردیدی در کار نیست – ما اینجا هستیم تا بهت کمک کنیم بهترین تجربه رو بسازی و هر وقت نیاز داشتی، در کنارت باشیم." data-popup-icon="http://6tofit.com/wp-content/uploads/2025/10/Group.png">
            </div>
          </div>
        </article>

        <!-- کارت 2 -->
        <article class="unique-card">
          <div class="unique-content">
            <div class="unique-icon-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/Magnifying-coin.png" alt="آیکون 2">
            </div>
            <div class="unique-title-row">
              <h3 class="unique-card-title">آنالیز بدن توسط سامان خوارزمی</h3>
            </div>
            <div class="unique-text-row">
              <p class="unique-card-text">بدن شما توسط سامان خوارزمی به‌صورت تخصصی آنالیز می‌شود تا بهترین برنامه شخصی‌سازی‌شده برایتان طراحی گردد.</p>
            </div>
            <div class="unique-bottom-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/Iconplusevip.svg" alt="آیکون پاپ‌آپ 2" class="unique-bottom-icon" data-popup-title="جزئیات رفع سلولیت" data-popup-text="ما در 62Fit باور داریم که سبک زندگی سالم و پرانرژی، حق طبیعی هر فرده. توی این مسیر، همراه و حامی تو هستیم تا بتونی به نسخه‌ای سالم‌تر، آرام‌تر و پرقدرت‌تر از خودت برسی. اما می‌دونیم که هر کسی شرایط و نیازهای متفاوتی داره، و گاهی ممکنه نتیجه‌ای که انتظارش رو داری، به دست نیاد. به همین خاطر، با احترام به انتخاب و تجربه‌ی تو، اگر دیدی خدمات VIP ما نتونسته خواسته‌ها و هدف‌هات رو برآورده کنه، بدون هیچ قید و شرطی، همه‌ی مبلغی که پرداخت کردی رو بهت برمی‌گردونیم.
این تضمین ماست که از اعتماد تو به عنوان یه سرمایه‌ی ارزشمند مراقبت کنیم و کاری کنیم که تو همیشه با حس آرامش، اعتماد و امنیت، قدم‌هات رو برداری. هیچ قضاوت یا تردیدی در کار نیست – ما اینجا هستیم تا بهت کمک کنیم بهترین تجربه رو بسازی و هر وقت نیاز داشتی، در کنارت باشیم." data-popup-icon="http://6tofit.com/wp-content/uploads/2025/10/Magnifying-coin.png">
            </div>
          </div>
        </article>

        <!-- کارت 3 -->
        <article class="unique-card">
          <div class="unique-content">
            <div class="unique-icon-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/infinite-1.png" alt="آیکون 3">
            </div>
            <div class="unique-title-row">
              <h3 class="unique-card-title">تغییرات نامحدود و انعطاف‌ کامل</h3>
            </div>
            <div class="unique-text-row">
              <p class="unique-card-text">برنامه شما همیشه و در هر وعده قابل تغییر و مناسب شرایط است، حتی خارج از خانه یا در موقعیت‌های خاص.</p>
            </div>
            <div class="unique-bottom-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/Iconplusevip.svg" alt="آیکون پاپ‌آپ 3" class="unique-bottom-icon" data-popup-title="جزئیات همراهی روزانه" data-popup-text="ما در 62Fit باور داریم که سبک زندگی سالم و پرانرژی، حق طبیعی هر فرده. توی این مسیر، همراه و حامی تو هستیم تا بتونی به نسخه‌ای سالم‌تر، آرام‌تر و پرقدرت‌تر از خودت برسی. اما می‌دونیم که هر کسی شرایط و نیازهای متفاوتی داره، و گاهی ممکنه نتیجه‌ای که انتظارش رو داری، به دست نیاد. به همین خاطر، با احترام به انتخاب و تجربه‌ی تو، اگر دیدی خدمات VIP ما نتونسته خواسته‌ها و هدف‌هات رو برآورده کنه، بدون هیچ قید و شرطی، همه‌ی مبلغی که پرداخت کردی رو بهت برمی‌گردونیم.
این تضمین ماست که از اعتماد تو به عنوان یه سرمایه‌ی ارزشمند مراقبت کنیم و کاری کنیم که تو همیشه با حس آرامش، اعتماد و امنیت، قدم‌هات رو برداری. هیچ قضاوت یا تردیدی در کار نیست – ما اینجا هستیم تا بهت کمک کنیم بهترین تجربه رو بسازی و هر وقت نیاز داشتی، در کنارت باشیم." data-popup-icon="http://6tofit.com/wp-content/uploads/2025/10/infinite-1.png">
            </div>
          </div>
        </article>

        <!-- کارت 4 -->
        <article class="unique-card">
          <div class="unique-content">
            <div class="unique-icon-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/Headphone.png" alt="آیکون 4">
            </div>
            <div class="unique-title-row">
              <h3 class="unique-card-title">پشتیبان اختصاصی شخصی</h3>
            </div>
            <div class="unique-text-row">
              <p class="unique-card-text">در این مسیر، یک پشتیبان اختصاصی همیشه همراه شماست تا روند تمرین و تغذیه‌تان را پیگیری و به‌روز نگه دارد.</p>
            </div>
            <div class="unique-bottom-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/Iconplusevip.svg" alt="آیکون پاپ‌آپ 4" class="unique-bottom-icon" data-popup-title="پشتیبان اختصاصی شخصی" data-popup-text="ما در 62Fit باور داریم که سبک زندگی سالم و پرانرژی، حق طبیعی هر فرده. توی این مسیر، همراه و حامی تو هستیم تا بتونی به نسخه‌ای سالم‌تر، آرام‌تر و پرقدرت‌تر از خودت برسی. اما می‌دونیم که هر کسی شرایط و نیازهای متفاوتی داره، و گاهی ممکنه نتیجه‌ای که انتظارش رو داری، به دست نیاد. به همین خاطر، با احترام به انتخاب و تجربه‌ی تو، اگر دیدی خدمات VIP ما نتونسته خواسته‌ها و هدف‌هات رو برآورده کنه، بدون هیچ قید و شرطی، همه‌ی مبلغی که پرداخت کردی رو بهت برمی‌گردونیم.
این تضمین ماست که از اعتماد تو به عنوان یه سرمایه‌ی ارزشمند مراقبت کنیم و کاری کنیم که تو همیشه با حس آرامش، اعتماد و امنیت، قدم‌هات رو برداری. هیچ قضاوت یا تردیدی در کار نیست – ما اینجا هستیم تا بهت کمک کنیم بهترین تجربه رو بسازی و هر وقت نیاز داشتی، در کنارت باشیم." data-popup-icon="http://6tofit.com/wp-content/uploads/2025/10/Headphone.png">
            </div>
          </div>

        </article>
		     <article class="unique-card">
          <div class="unique-content">
            <div class="unique-icon-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/Group2.png" alt="آیکون 4">
            </div>
            <div class="unique-title-row">
              <h3 class="unique-card-title">ارتباط مستقیم با سامان خوارزمی آخر هرماه</h3>
            </div>
            <div class="unique-text-row">
              <p class="unique-card-text">پیش از آغاز هر دوره، در یک جلسه‌ مشاوره تصویری، اهداف، نیازها و مسیر ۶ماه‌تان با سامان خوارزمی بررسی می‌شود.</p>
            </div>
            <div class="unique-bottom-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/Iconplusevip.svg" alt="آیکون پاپ‌آپ 4" class="unique-bottom-icon" data-popup-title="ارتباط مستقیم با سامان خوارزمی آخر هرماه" data-popup-text="ما در 62Fit باور داریم که سبک زندگی سالم و پرانرژی، حق طبیعی هر فرده. توی این مسیر، همراه و حامی تو هستیم تا بتونی به نسخه‌ای سالم‌تر، آرام‌تر و پرقدرت‌تر از خودت برسی. اما می‌دونیم که هر کسی شرایط و نیازهای متفاوتی داره، و گاهی ممکنه نتیجه‌ای که انتظارش رو داری، به دست نیاد. به همین خاطر، با احترام به انتخاب و تجربه‌ی تو، اگر دیدی خدمات VIP ما نتونسته خواسته‌ها و هدف‌هات رو برآورده کنه، بدون هیچ قید و شرطی، همه‌ی مبلغی که پرداخت کردی رو بهت برمی‌گردونیم.
این تضمین ماست که از اعتماد تو به عنوان یه سرمایه‌ی ارزشمند مراقبت کنیم و کاری کنیم که تو همیشه با حس آرامش، اعتماد و امنیت، قدم‌هات رو برداری. هیچ قضاوت یا تردیدی در کار نیست – ما اینجا هستیم تا بهت کمک کنیم بهترین تجربه رو بسازی و هر وقت نیاز داشتی، در کنارت باشیم." data-popup-icon="http://6tofit.com/wp-content/uploads/2025/10/Group2.png">
            </div>
          </div>
        </article>

		     <article class="unique-card">
          <div class="unique-content">
            <div class="unique-icon-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/Studio-Microphone.png" alt="آیکون 4">
            </div>
            <div class="unique-title-row">
              <h3 class="unique-card-title">وبینارهای ماهانه با نکات طلایی و آپدیت‌های روز</h3>
            </div>
            <div class="unique-text-row">
              <p class="unique-card-text">هر ماه وبینار اختصاصی داریم تا جدیدترین آپدیت‌ها، مسیرهای میان‌بر و چیت‌کدهای واقعی رو یاد بگیری.</p>
            </div>
            <div class="unique-bottom-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/Iconplusevip.svg" alt="آیکون پاپ‌آپ 4" class="unique-bottom-icon" data-popup-title="وبینارهای ماهانه با نکات طلایی و آپدیت‌های روز" data-popup-text="ما در 62Fit باور داریم که سبک زندگی سالم و پرانرژی، حق طبیعی هر فرده. توی این مسیر، همراه و حامی تو هستیم تا بتونی به نسخه‌ای سالم‌تر، آرام‌تر و پرقدرت‌تر از خودت برسی. اما می‌دونیم که هر کسی شرایط و نیازهای متفاوتی داره، و گاهی ممکنه نتیجه‌ای که انتظارش رو داری، به دست نیاد. به همین خاطر، با احترام به انتخاب و تجربه‌ی تو، اگر دیدی خدمات VIP ما نتونسته خواسته‌ها و هدف‌هات رو برآورده کنه، بدون هیچ قید و شرطی، همه‌ی مبلغی که پرداخت کردی رو بهت برمی‌گردونیم.
این تضمین ماست که از اعتماد تو به عنوان یه سرمایه‌ی ارزشمند مراقبت کنیم و کاری کنیم که تو همیشه با حس آرامش، اعتماد و امنیت، قدم‌هات رو برداری. هیچ قضاوت یا تردیدی در کار نیست – ما اینجا هستیم تا بهت کمک کنیم بهترین تجربه رو بسازی و هر وقت نیاز داشتی، در کنارت باشیم." data-popup-icon="http://6tofit.com/wp-content/uploads/2025/10/Studio-Microphone.png">
            </div>
          </div>
        </article>

    <article class="unique-card">
          <div class="unique-content">
            <div class="unique-icon-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/Studio-Microphone.png" alt="آیکون 4">
            </div>
            <div class="unique-title-row">
              <h3 class="unique-card-title"> رفع سلولیت، بهبود و فرم‌دهی بدن</h3>
            </div>
            <div class="unique-text-row">
              <p class="unique-card-text">اگه سلولیت یا محدودیت حرکتی داری، مثل زانودرد، دیسک کمر یا هر درد مزمن دیگه، برنامه‌ت به بهبودش کمک کند.</p>
            </div>
            <div class="unique-bottom-row">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/Iconplusevip.svg" alt="آیکون پاپ‌آپ 4" class="unique-bottom-icon" data-popup-title="رفع سلولیت، بهبود و فرم‌دهی بدن" data-popup-text="ما در 62Fit باور داریم که سبک زندگی سالم و پرانرژی، حق طبیعی هر فرده. توی این مسیر، همراه و حامی تو هستیم تا بتونی به نسخه‌ای سالم‌تر، آرام‌تر و پرقدرت‌تر از خودت برسی. اما می‌دونیم که هر کسی شرایط و نیازهای متفاوتی داره، و گاهی ممکنه نتیجه‌ای که انتظارش رو داری، به دست نیاد. به همین خاطر، با احترام به انتخاب و تجربه‌ی تو، اگر دیدی خدمات VIP ما نتونسته خواسته‌ها و هدف‌هات رو برآورده کنه، بدون هیچ قید و شرطی، همه‌ی مبلغی که پرداخت کردی رو بهت برمی‌گردونیم.
این تضمین ماست که از اعتماد تو به عنوان یه سرمایه‌ی ارزشمند مراقبت کنیم و کاری کنیم که تو همیشه با حس آرامش، اعتماد و امنیت، قدم‌هات رو برداری. هیچ قضاوت یا تردیدی در کار نیست – ما اینجا هستیم تا بهت کمک کنیم بهترین تجربه رو بسازی و هر وقت نیاز داشتی، در کنارت باشیم." data-popup-icon="http://6tofit.com/wp-content/uploads/2025/10/Studio-Microphone.png">
            </div>
          </div>
        </article>

      </div>
      <div class="unique-prev-next">
        <button class="unique-next" onclick="moveUniqueSlide(1)">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/Statevipl.svg" alt="Previous">
        </button>
        <button class="unique-prev rotated" onclick="moveUniqueSlide(-1)">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/Statevipl.svg" alt="Next">
        </button>
      </div>
    </div>
  </div>
</section>

<!-- پاپ‌آپ -->
<div class="popup-overlay" id="popupOverlay">
  <div class="popup-card">
    <div class="popup-icon">
      <img id="popupIcon" src="" alt="آیکون پاپ‌آپ">
    </div>
    <h3 id="popupTitle" class="popup-title"></h3>
    <p id="popupText" class="popup-text"></p>
    <button class="popup-close-btn" onclick="closePopup()">بستن</button>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const carousel = document.getElementById('uniqueCarousel');
  const prevButton = document.querySelector('.unique-prev');
  const nextButton = document.querySelector('.unique-next');
  let currentUnique = 0;
  const cards = carousel.querySelectorAll('.unique-card');
  const cardWidth = cards[0] ? cards[0].offsetWidth + 40 : 320; // width + gap

  window.moveUniqueSlide = function(direction) {
    currentUnique += direction;
    const maxSlide = Math.max(0, cards.length - Math.floor(carousel.parentElement.offsetWidth / cardWidth));
    currentUnique = Math.max(0, Math.min(currentUnique, maxSlide));
    carousel.style.transform = `translateX(${currentUnique * cardWidth}px)`;
  };

  // Attach event listeners to buttons
  if (prevButton) {
    prevButton.addEventListener('click', () => moveUniqueSlide(-1));
  }
  if (nextButton) {
    nextButton.addEventListener('click', () => moveUniqueSlide(1));
  }

  // Touch/Swipe for mobile
  let startX = 0;
  let currentX = 0;
  let isDragging = false;

  carousel.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
    isDragging = true;
  });

  carousel.addEventListener('touchmove', (e) => {
    if (!isDragging) return;
    currentX = e.touches[0].clientX;
    const diff = startX - currentX;
    if (Math.abs(diff) > 50) {
      moveUniqueSlide(diff > 0 ? -1 : 1);
      isDragging = false;
    }
  });

  carousel.addEventListener('touchend', () => {
    isDragging = false;
  });

  // پاپ‌آپ
  const overlay = document.getElementById('popupOverlay');
  const popupIcon = document.getElementById('popupIcon');
  const popupTitle = document.getElementById('popupTitle');
  const popupText = document.getElementById('popupText');

  document.querySelectorAll('.unique-bottom-icon').forEach(icon => {
    icon.addEventListener('click', function() {
      popupIcon.src = this.dataset.popupIcon;
      popupTitle.textContent = this.dataset.popupTitle;
      popupText.textContent = this.dataset.popupText;
      overlay.style.display = 'flex';
    });
  });

  window.closePopup = function() {
    overlay.style.display = 'none';
  };

  overlay.addEventListener('click', function(e) {
    if (e.target === overlay) {
      closePopup();
    }
  });
});
</script>



<style>
  .vip-stories-section {
    width: 100%;
    background-color: #212124;
    padding: 90px 0;
  }

  .vip-stories-container {
    width: 80%;
    margin: 0 auto;
  }

  .vip-stories-title {
    text-align: right;
  }

  .vip-stories-title h2 {
    font-size: 30px;
    font-weight: 500;
    color: #E9E9EB;
    margin: 0;
  }

  .vip-stories-slider-container {
    position: relative;
    width: 100%;
    overflow: hidden;
  }

  .vip-stories-slider {
    display: flex;
    flex-direction: row; /* ترتیب اسلایدها برای محاسبه موقعیت */
    transition: transform 0.5s ease-in-out;
  }

  .vip-story-slide {
    flex: 0 0 100%; /* هر اسلاید 100% عرض ظرف */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .vip-story-slide img {
    width: auto;
    height: auto;
  }

  .vip-story-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 40%;
  }

  .vip-story-icon {
    width: 60px;
    height: 60px;
    margin-bottom: 10px;
  }

  .vip-story-title {
    font-size: 24px;
    font-weight: 500;
    color: #E9E9EB;
    text-align: center;
    margin: 0 0 10px 0;
  }

  .vip-story-text {
    font-size: 18px;
    font-weight: 400;
    color: #B8B8BC;
    text-align: center;
    margin: 0;
    line-height: 1.5;
  }

  .vip-stories-prev,
  .vip-stories-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 10;
  }

  .vip-stories-prev {
    right: 10px; /* دکمه "قبلی" در سمت راست */
  }

  .vip-stories-next {
    left: 10px; /* دکمه "بعدی" در سمت چپ */
  }

  .vip-stories-prev img,
  .vip-stories-next img {
    width: 40px;
    height: 40px;
	background-color:#38383D;
	    border-radius: 1000000px;
  }

  #vip-stories {
    scroll-margin-top: 100px;
  }

  /* تغییرات برای موبایل */
  @media only screen and (max-width: 768px) {
    .vip-stories-title h2 {
      font-size: 24px;
    }
    .vip-stories-section {
    
    }
    .vip-stories-title {
      margin: 50px 0 10px;
    }
    .vip-story-text {
      font-size: 16px;
    }
    .vip-stories-prev img,
    .vip-stories-next img {
      width: 36px;
      height: 36px;
    }
    .vip-story-slide img {
      height: auto;
      width: 90%;
    }
    .vip-story-content {
      width: 90%;
    }
    .vip-story-icon {
      height: 64px !important;
      width: 64px !important;
    }
    .vip-stories-section {
      padding: 20px 0;
    }
  }
</style>

<section class="vip-stories-section" id="vip-stories">
  <div class="vip-stories-container">
    <div class="vip-stories-title">
      <h2>تغییرات خیره‌کننده شما</h2>
    </div>
    <div class="vip-stories-slider-container">
      <div class="vip-stories-slider" id="vip-stories-slider">
        <div class="vip-story-slide">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/slide1.png" alt="Story 1">
          <div class="vip-story-content">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/storyic.png" alt="User Icon" class="vip-story-icon">
            <h3 class="vip-story-title">نیلوفر شریفی</h3>
            <p class="vip-story-text">توی خوابگاه بودم و دسترسی زیادی نداشتم. برنامه‌ای که برام فرستادن هم تمرین خونه‌ای داشت، هم یه رژیم منطقی که با امکاناتم جور بود. الان نه تنها وزنم کم شده، بلکه عادت‌هام هم بهتر شدن.</p>
          </div>
        </div>

        <div class="vip-story-slide">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/slide1.png" alt="Story 2">
          <div class="vip-story-content">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/storyic.png" alt="User Icon" class="vip-story-icon">
            <h3 class="vip-story-title">ملیکا داوودی</h3>
            <p class="vip-story-text">این برنامه زندگی من رو تغییر داد! با تمرینات ساده و رژیم مناسب، تونستم به اهدافم برسم و احساس بهتری داشته باشم.</p>
          </div>
        </div>

        <div class="vip-story-slide">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/slide1.png" alt="Story 3">
          <div class="vip-story-content">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/storyic.png" alt="User Icon" class="vip-story-icon">
            <h3 class="vip-story-title">ساناز شریفی</h3>
            <p class="vip-story-text">کاربری آسان و نتایج شگفت‌انگیز! هرگز فکر نمی‌کردم بتونم اینقدر سریع پیشرفت کنم.</p>
          </div>
        </div>
      </div>
      <div class="vip-stories-prev" onclick="moveVipStory(1)">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/rightvip.svg" alt="Previous">
      </div>
      <div class="vip-stories-next" onclick="moveVipStory(-1)">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/leftvip.svg" alt="Next">
      </div>
    </div>
  </div>
</section>

<script>
  (function () {
    let currentIndex = 0;
    const slides = document.querySelectorAll('.vip-story-slide');
    const totalSlides = slides.length;
    const slider = document.getElementById('vip-stories-slider');
    
    // عرض دینامیک برای اسلایدها (100% عرض ظرف)
    const getSlideWidth = () => {
      return document.querySelector('.vip-stories-slider-container').offsetWidth;
    };
    let slideWidth = getSlideWidth();

    // تنظیم موقعیت اولیه اسلایدر
    if (slider) {
      slider.style.transform = `translateX(0px)`;
    }

    window.moveVipStory = function (direction) {
      currentIndex += direction;

      // حلقه بی‌نهایت
      if (currentIndex >= totalSlides) {
        currentIndex = 0;
      } else if (currentIndex < 0) {
        currentIndex = totalSlides - 1;
      }

      // حرکت اسلایدر به سمت چپ (برای RTL)
      slider.style.transform = `translateX(${currentIndex * slideWidth}px)`;
    };

    // به‌روزرسانی عرض اسلایدر هنگام تغییر اندازه پنجره
    window.addEventListener('resize', () => {
      slideWidth = getSlideWidth();
      slider.style.transform = `translateX(${currentIndex * -slideWidth}px)`;
    });

    // اسلاید خودکار به سمت چپ (اسلاید بعدی در RTL)
    let autoSlide = setInterval(() => window.moveVipStory(1), 5000);

    // توقف اسلاید خودکار هنگام کلیک کاربر
    document.querySelector('.vip-stories-prev').addEventListener('click', () => clearInterval(autoSlide));
    document.querySelector('.vip-stories-next').addEventListener('click', () => clearInterval(autoSlide));
  })();
</script>



<style>
  .vip-join-section {
    width: 100%;
    background-color: #212124; /* فرض بر پس‌زمینه تیره، مثل سکشن‌های قبلی */
  
    position: relative;
    overflow: hidden;
  }

  .vip-join-bg1 {
    position: absolute;
    angle: 0deg;
    opacity: 1;
    top: 0px;
    right: 0px;
    z-index: 1;
  }

  .vip-join-bg2 {
    position: absolute;
    angle: 0deg;
    opacity: 1;
    top: 0px;
    left: 0px;
    z-index: 1;
  }

  .vip-join-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;

    position: relative;
    z-index: 2;
  }

  .vip-join-left {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .vip-join-left img {
    max-width: 100%;
    height: 640px;
  }

  .vip-join-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 0 40px;
  }

  .vip-join-title {
    font-size: 30px;
    font-weight: 500;
    color: #E9E9EB;
    margin: 0 0 20px 0;
    line-height: 1.2;
    font-family: 'iranyekanen', sans-serif;
  }

  .vip-join-text {
    font-size: 24px;
    font-weight: 400;
    color: #B8B8BC;
    margin: 0 0 30px 0;
    line-height: 1.4;
    font-family: 'iranyekanen', sans-serif;
  }

  .vip-join-btn {
    background-color: #5247FF;
    color: #FFFFFF;
    border: none;
    border-radius: 10000px;
    padding: 12px 10px;
    min-width: 200px; /* تنظیم عرض */
    font-weight: 700;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-family: 'iranyekanen', sans-serif;
  }

  .vip-join-btn:hover {
    background-color: #4239D0;
  }

  /* موبایل */
  @media only screen and (max-width: 768px) {
    .vip-join-section {
      padding-top: 50px;
    }
.vip-join-left img{
	max-width: 272px;
    height: 278px;
}
    .vip-join-container {
      flex-direction: column;
      gap: 30px;
      padding: 0 10px;
    }

    .vip-join-right {
      padding: 0;
      order: -1; /* عنوان اول در موبایل */
    }

    .vip-join-title {
      font-size: 24px;
    }

    .vip-join-text {
      font-size: 18px;
    }

    .vip-join-btn {
      min-width: 180px;
      font-size: 16px;
    }
  }
</style>

<section class="vip-join-section">
  <!-- تصاویر پس‌زمینه -->
  <img src="http://6tofit.com/wp-content/uploads/2025/10/Ellipsetop.svg" alt="" class="vip-join-bg1">
  <img src="http://6tofit.com/wp-content/uploads/2025/10/Ellipsbt.svg" alt="" class="vip-join-bg2">

  <div class="vip-join-container">
   <div class="vip-join-right">
      <h3 class="vip-join-title">به جمع خاص‌ترین‌ها بپیوند</h3>
      <p class="vip-join-text">شروع کن؛ ما آماده‌ایم تا مسیرت رو بسازیم</p>
      <button class="vip-join-btn" onclick="showFreeVipConsultationPopup()">ثبت درخواست مشاوره</button>
    </div>
    <div class="vip-join-left">
      <img src="http://6tofit.com/wp-content/uploads/2025/10/vip-ctaimg-scaled.png" alt="تصویر VIP">
    </div>
   
  </div>
</section>


<style>
  .vip-faq-section {
    width: 100%;
    margin-top: 80px;
	margin-bottom: 80px;
  }

  .vip-faq-container {
    width: 80%;
    margin: 0 auto;
  }

  .vip-faq-title {
    padding: 30px 0;
   
  }

  .vip-faq-title h2 {
    font-size: 30px;
    font-weight: 500;
    color: #E9E9EB;
    margin: 0;
  }

  .vip-faq-cards {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .vip-faq-card {
    background-color: #212124;
    border-radius: 24px;
    padding: 18px 19px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .vip-faq-question {
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
  }

  .vip-faq-question-text {
    font-size: 18px;
    font-weight: 500;
    color: #F9F9FB;
    text-align: right;
  }

  .vip-faq-icon img {
    width: 24px;
    height: 24px;
  }

  .vip-faq-answer {
    display: none;
    font-size: 14px;
    color: #B8B8BC;
    text-align: right;
    margin-top: 10px;
  }

  .vip-faq-card.active .vip-faq-answer {
    display: block;
  }

  .vip-faq-card.active .vip-faq-icon img.closed {
    display: none;
  }

  .vip-faq-card.active .vip-faq-icon img.open {
    display: inline;
  }

  .vip-faq-icon img.open {
    display: none;
  }

  #vip-faq {
    scroll-margin-top: 100px;
  }

  /* تغییرات برای موبایل */
  @media only screen and (max-width: 768px) {
    .vip-faq-container {
      width: 90%;
    }

    .vip-faq-title h2 {
      font-size: 24px;
    }

    .vip-faq-question-text {
      font-size: 15px;
    }
    .vip-faq-section {
      margin-top: 40px;
	  margin-bottom: 60px;
    }
  }
</style>

<section class="vip-faq-section" id="vip-faq">
  <div class="vip-faq-container">
    <div class="vip-faq-title">
      <h2>سوالات متدوال</h2>
    </div>
    <div class="vip-faq-cards">
      <div class="vip-faq-card">
        <div class="vip-faq-question" onclick="this.parentElement.classList.toggle('active')">
          <div class="vip-faq-question-text">آیا می‌تونم برنامه ورزشی و رژیم غذایی رو هر زمان بخوام تغییر بدم؟</div>
          <div class="vip-faq-icon">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqop.svg" alt="Closed Icon" class="closed">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqcl.svg" alt="Open Icon" class="open">
          </div>
        </div>
        <div class="vip-faq-answer">
          این برنامه شامل ویژگی‌های متنوعی مانند تمرینات شخصی‌سازی‌شده، رژیم غذایی، و پشتیبانی آنلاین است.
        </div>
      </div>
      <div class="vip-faq-card">
        <div class="vip-faq-question" onclick="this.parentElement.classList.toggle('active')">
          <div class="vip-faq-question-text"> پشتیبانی شما دقیقاً چطوریه و چه زمانی در دسترسه؟</div>
          <div class="vip-faq-icon">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqop.svg" alt="Closed Icon" class="closed">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqcl.svg" alt="Open Icon" class="open">
          </div>
        </div>
        <div class="vip-faq-answer">
          برای خرید اشتراک، به بخش خدمات پرو مراجعه کنید و یکی از گزینه‌ها را انتخاب کنید.
        </div>
      </div>
      <div class="vip-faq-card">
        <div class="vip-faq-question" onclick="this.parentElement.classList.toggle('active')">
          <div class="vip-faq-question-text"> آیا رژیم غذایی برای شرایط پزشکی یا محدودیت خاص هم طراحی می‌کنید؟</div>
          <div class="vip-faq-icon">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqop.svg" alt="Closed Icon" class="closed">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqcl.svg" alt="Open Icon" class="open">
          </div>
        </div>
        <div class="vip-faq-answer">
          بله، تیم پشتیبانی ما به‌صورت ۲۴ ساعته آماده پاسخگویی به سوالات شماست.
        </div>
      </div>
	   <div class="vip-faq-card">
        <div class="vip-faq-question" onclick="this.parentElement.classList.toggle('active')">
          <div class="vip-faq-question-text">  برنامه ورزشی رو کجا و چطور می‌تونم ببینم یا استفاده کنم؟</div>
          <div class="vip-faq-icon">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqop.svg" alt="Closed Icon" class="closed">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqcl.svg" alt="Open Icon" class="open">
          </div>
        </div>
        <div class="vip-faq-answer">
          بله، تیم پشتیبانی ما به‌صورت ۲۴ ساعته آماده پاسخگویی به سوالات شماست.
        </div>
      </div>
	   <div class="vip-faq-card">
        <div class="vip-faq-question" onclick="this.parentElement.classList.toggle('active')">
          <div class="vip-faq-question-text"> این خدمات VIP فقط برای ورزشکار حرفه‌ایه یا برای همه مناسب هست؟</div>
          <div class="vip-faq-icon">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqop.svg" alt="Closed Icon" class="closed">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqcl.svg" alt="Open Icon" class="open">
          </div>
        </div>
        <div class="vip-faq-answer">
        برای همه مناسبه! چه تازه‌کار باشین یا ورزشکار حرفه‌ای، ما برنامه رو طبق شرایط شما طراحی می‌کنیم.
        </div>
      </div>
    </div>
  </div>
</section>
<?php get_footer('vip'); ?>