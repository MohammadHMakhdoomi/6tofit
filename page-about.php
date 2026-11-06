<?php
/* Template Name: صفحه درباره ما */
get_header('light'); ?>

<style>
  .about-section {
    width: 100%;
    padding: 80px 0;
  
	margin-top: 90px;
  }

  .about-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    text-align: center;
  }

  .about-title {
    font-size: 36px;
    font-weight: 500;
    color: #161618;
    margin: 0 0 40px 0;
    line-height: 1.2;
  }

  .about-logo {
    display: block;
    margin: 80px auto 80px;
    max-width: 200px; /* اندازه لوگو رو تنظیم کن */
    height: auto;
  }

  .about-description {
    font-size: 20px;
    font-weight: 400;
    color: #65656D;
    margin: 0;
    line-height: 1.5;
    max-width: 1100px;
    margin-left: auto;
    margin-right: auto;
	font-family:'iranyekanen';
  }

  /* موبایل */
  @media (max-width: 768px) {
    .about-section {
      padding: 40px 0;
    }

    .about-title {
      font-size: 28px;
    }

    .about-description {
      font-size: 18px;
	  
    }

    .about-logo {
      max-width: 150px;
    }
  }
</style>

<section class="about-section">
  <div class="about-container">
    <h1 class="about-title">درباره ما</h1>
    <img src="http://6tofit.com/wp-content/uploads/2025/10/Logo_Type.svg" alt="لوگوی 6tofit" class="about-logo">
    <p class="about-description">ما در 6-2fit معتقدیم که هر فردی می‌تواند با برنامه‌ریزی هوشمندانه، تغذیه‌ی مناسب و تمرکز بر ذهنیت مثبت، به نتایج واقعی و پایدار برسد. فلسفه‌ی ما اینه که ورزش، تغذیه و ریکاوری فقط ابزار نیستند، بلکه بخشی از یک سبک زندگی سالم و متعادل‌اند. توی 6-2fit، همه چیز با نیازها و هدف‌های شما شروع میشه. تیم ما با طراحی برنامه‌های VIP اختصاصی، بهت کمک می‌کنه تا با تمرین‌ها و رژیم غذایی مناسب، قدم‌به‌قدم به تناسب اندام ایده‌آل برسی. ما کنارتم تا مسیر رو با انگیزه و انرژی طی کنی. ما باور داریم که تندرستی فقط به تحرک یا تغذیه محدود نمیشه. به همین خاطر، در بلاگ 6-2fit محتواهایی رو پیدا می‌کنی که بهت کمک می‌کنه روی ذهنیت، ریکاوری، و انگیزه‌ت هم کار کنی. با ما همراه باش و هر روز یک قدم به بهتر شدن خودت نزدیک‌تر شو. این فقط یک سایت یا یک برنامه‌ی تمرینی نیست؛ ما یک خانواده‌ایم. جایی که تجربه‌های موفق شما رو جشن می‌گیریم و الهام‌بخش همدیگه هستیم. همین الان شروع کن و بذار ما توی این مسیر کنارت باشیم!</p>
  
  </div>
</section>


<style>
  .certificates-section {
    width: 100%;

    padding: 90px 0;
  }

  .certificates-container {
    width: 80%;
    margin: 0 auto;
  }

  .certificates-headers {
    text-align: center;
    margin-bottom: 20px;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
  }

  .certificates-headers h2:first-of-type {
    font-size: 30px;
    font-weight: 500;
    background: linear-gradient(90.11deg, #E64910 23.2%, #F51E55 36.59%, #DE39B3 49.98%, #C64CDB 63.37%, #0083EB 76.76%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0 0 10px 0;
    font-family: 'iranyekanen', sans-serif;
  }

  .certificates-headers h2:last-of-type {
    font-size: 30px;
    font-weight: 500;
    color: #161618;
    margin: 0;
    font-family: 'iranyekanen', sans-serif;
  }

  .certificates-slider-container {
    position: relative;
    width: 100%;
    overflow: hidden;
    padding: 50px 0 0;
  }

  .certificates-slider {
    display: flex;
    flex-direction: row; /* ترتیب اسلایدها برای محاسبه موقعیت */
    transition: transform 0.5s ease-in-out;
  }

  .certificate-slide {
    flex: 0 0 100%; /* هر اسلاید 100% عرض ظرف */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .certificate-slide .image-wrapper {
    background: #FFFFFF;
    border-radius: 45px;
    padding: 10px;
    margin-bottom: 30px; /* فاصله از محتوا */
  }

  .certificate-slide img:not(.certificate-shadow) {
    width: 430px;
    height: auto;
    z-index: 2;
	    background: #F7F7F8;
    padding: 10px;
    border: 3px solid;
    border-radius: 40px;
  }

  .certificate-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 40%;
    padding-top: 30px;
  }

  .certificate-title {
    font-size: 30px;
    font-weight: 500;
    color: #000000;
    text-align: center;
    margin: 0 0 10px 0;
    font-family: 'iranyekanen', sans-serif;
  }

  .certificate-text {
    font-size: 24px;
    font-weight: 400;
    color: #65656D;
    text-align: center;
    margin: 0 0 10px 0;
    line-height: 1.5;
    font-family: 'iranyekanen', sans-serif;
  }

  .certificate-subtitle {
    font-size: 18px;
    font-weight: 400;
    color: #65656D;
    text-align: center;
    margin: 0;
    line-height: 1.5;
    font-family: 'iranyekanen', sans-serif;
  }

  .certificates-prev,
  .certificates-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 10;
  }

  .certificates-prev {
    right: 10px; /* دکمه "قبلی" در سمت راست */
  }

  .certificates-next {
    left: 10px; /* دکمه "بعدی" در سمت چپ */
  }

  .certificates-prev img,
  .certificates-next img {
    width: 40px;
    height: 40px;
  }

  #certificates {
    scroll-margin-top: 100px;
  }

  .certificate-shadow {
    position: fixed;      /* ثابت روی صفحه */
    top: -60px;
    transform: rotate(341deg); /* چرخش 80 درجه به سمت بالا */
    transform-origin: left bottom; /* نقطه مرجع چرخش */
    width: 150px;         /* سایز تصویر */
    height: auto;         /* ارتفاع خودکار */
    opacity: 0.4;
  }

  /* تغییرات برای موبایل */
  @media only screen and (max-width: 768px) {
    .certificates-headers h2:first-of-type,
    .certificates-headers h2:last-of-type {
      font-size: 28px;
    }
    .certificates-section {
      margin-bottom: 0px;
    }
    .certificates-headers {
      margin: 50px 0 10px;
    }
	.certificates-container {
		width:90%;
}
    .certificate-text,
    .certificate-subtitle {
      font-size: 16px;
    }
    .certificates-prev img,
    .certificates-next img {
      width: 36px;
      height: 36px;
    }
    .certificate-slide .image-wrapper {
      width: 60%;
	  display: inline-flex;
    }
    .certificate-slide img:not(.certificate-shadow) {
      width: 85%;
      height: auto;
    }
    .certificate-content {
      width: 90%;
    }
    .certificates-section {
      padding: 20px 0;
    }
  }
</style>

<section class="certificates-section" id="certificates">
  <div class="certificates-container">
    <div class="certificates-headers">
      <h2>مدارک ‌آکادمیک و دوره‌های تخصصی</h2>
      <h2>سامان خوارزمی</h2>
    </div>
    
    <div class="certificates-slider-container">
      <div class="certificates-slider" id="certificates-slider">
        <div class="certificate-slide">
         
          <div class="image-wrapper">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Am.jpg" alt="Certificate 1">
          </div>
          <div class="certificate-content">
            <h3 class="certificate-title">American Sports & Fitness Association</h3>
            <p class="certificate-text">The American Sports & Fitness Association hereby confers this award with all honors and privileges</p>
            <p class="certificate-subtitle">Oct 26/16</p>
          </div>
        </div>

        <div class="certificate-slide">
          
          <div class="image-wrapper">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/DTS.jpg" alt="Certificate 2">
          </div>
          <div class="certificate-content">
            <h3 class="certificate-title">DTS Fitness Education</h3>
            <p class="certificate-text">DTS Fitness Education is a reputable fitness and health education institute based in Toronto.</p>
            <p class="certificate-subtitle">September 30, 2018</p>
          </div>
        </div>

        <div class="certificate-slide">
          
          <div class="image-wrapper">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Gy.jpg" alt="Certificate 3">
          </div>
          <div class="certificate-content">
            <h3 class="certificate-title">GYROTONIC® Attestation</h3>
            <p class="certificate-text">GYROTONIC® Specialized Course – Principles Applied to Dynamic Trunk Stabilization</p>
            <p class="certificate-subtitle">9-21-2018</p>
          </div>
        </div>

        <div class="certificate-slide">
          
          <div class="image-wrapper">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/nasm.jpg" alt="Certificate 3">
          </div>
          <div class="certificate-content">
            <h3 class="certificate-title">University of Pennsylvania</h3>
            <p class="certificate-text">Diploma of Education, Principles Applied to Dynamic Trunk Stablization</p>
            <p class="certificate-subtitle">Mar 2018 - Sep 2018</p>
          </div>
        </div>
      </div>
      <div class="certificates-prev" onclick="moveCertificate(1)">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/IconButtonR.svg" alt="Previous">
      </div>
      <div class="certificates-next" onclick="moveCertificate(-1)">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/IconButtonL.svg" alt="Next">
      </div>
    </div>
  </div>
</section>

<script>
  (function () {
    let currentIndex = 0;
    const slides = document.querySelectorAll('.certificate-slide');
    const totalSlides = slides.length;
    const slider = document.getElementById('certificates-slider');
    
    // عرض دینامیک برای اسلایدها (100% عرض ظرف)
    const getSlideWidth = () => {
      return document.querySelector('.certificates-slider-container').offsetWidth;
    };
    let slideWidth = getSlideWidth();

    // تنظیم موقعیت اولیه اسلایدر
    if (slider) {
      slider.style.transform = `translateX(0px)`;
    }

    window.moveCertificate = function (direction) {
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
    let autoSlide = setInterval(() => window.moveCertificate(1), 5000);

    // توقف اسلاید خودکار هنگام کلیک کاربر
    document.querySelector('.certificates-prev').addEventListener('click', () => clearInterval(autoSlide));
    document.querySelector('.certificates-next').addEventListener('click', () => clearInterval(autoSlide));
  })();
</script>


<?php get_footer(); ?>