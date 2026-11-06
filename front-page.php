<?php
/**
 * Template Name: 6tofit Front Page
 * Description: صفحه اصلی 6tofit
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // جلوگیری از دسترسی مستقیم
}
get_header(); // فراخوانی هدر
?>
<?php
  include __DIR__ . '/template-parts/consultation-popup.php';
  ?>
<main id="main" class="site-main">

    <section class="home-hero">
     
    <style>
        /* ریست کلی */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* استایل کلی اسلایدر */
        .slider-container {
            width: 100%;
            height: 100vh; /* تمام‌صفحه */
            position: relative;
            overflow: hidden;
        }

        /* تنظیمات هر اسلاید */
        .slide {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        /* اسلاید فعال */
        .slide.active {
            opacity: 1;
        }

      /* تصاویر پس‌زمینه با گرادینت نیمه‌تیره */
.slide:nth-child(1) {
  background: 
    linear-gradient(0deg, rgba(13, 13, 13, 0.40) 0%, rgba(13, 13, 13, 0.40) 100%),
    url('http://6tofit.com/wp-content/uploads/2025/10/hero.png') center center / cover no-repeat;
}

.slide:nth-child(2) {
  background:
    linear-gradient(0deg, rgba(13, 13, 13, 0.40) 0%, rgba(13, 13, 13, 0.40) 100%),
    url('https://picsum.photos/1536/1024') center center / cover no-repeat;
}

.slide:nth-child(3) {
  background:
    linear-gradient(0deg, rgba(13, 13, 13, 0.40) 0%, rgba(13, 13, 13, 0.40) 100%),
    url('https://picsum.photos/1536/1024') center center / cover no-repeat;
}

.slide:nth-child(4) {
  background:
    linear-gradient(0deg, rgba(13, 13, 13, 0.40) 0%, rgba(13, 13, 13, 0.40) 100%),
    url('https://picsum.photos/1536/1024') center center / cover no-repeat;
}


        /* کانتینر محتوا */
        .content-container {
            max-width: 1400px;
            width: 100%;
            display: flex;
            justify-content: start;
            align-items: center;
            height: 100%;
            padding: 0 20px;
        }

        /* ستون سمت راست */
        .right-column {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
        }

        /* عنوان */
        .title {
            font-size: 36px;
            font-weight: 500;
            margin-bottom: 16px;
        }

        /* متن زیر عنوان */
        .subtitle {
            font-size: 20px;
            font-weight: 400;
            margin-bottom: 24px;
            max-width: 600px;
        }

        /* دکمه مشاوره رایگان */
        .consult-button {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            background: #5247FF;
            padding: 15px 19px;
            border-radius: 1000000px; /* دکمه کاملاً گرد */
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }

        .consult-button:hover {
            background: #4038cc;
        }

        /* اسلایدر ناوبری (Navigation) */
        .slider-nav {
            position: absolute;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            width: 195px;
            padding: 24px;
            align-items: center;
            gap: 12px;
            border-radius: 1000000px;
            background: rgba(255, 255, 255, 0.50);
            backdrop-filter: blur(6px);
        }

        /* نقطه‌های ناوبری */
        .nav-dot {
            width: 12px;
            height: 12px;
            flex-shrink: 0;
            border-radius: 50%;
            background: rgba(13, 13, 13, 0.40);
            cursor: pointer;
            transition: all 0.3s;
        }

        /* نقطه فعال */
        .nav-dot.active {
            flex: 1 0 0;
            border-radius: 12px;
            background: rgba(13, 13, 13, 0.40);
        }
		
/* در موبایل مرکزچین شود */
@media (max-width: 768px) {
    .content-container {
        justify-content: center;
		align-items: end;
		margin-bottom: 250px;
    }

	 .slide:nth-child(1) {
		   background:
    linear-gradient(0deg, rgba(13, 13, 13, 0.40) 0%, rgba(13, 13, 13, 0.40) 100%),
            background: url('http://6tofit.com/wp-content/uploads/2025/10/hero.png') no-repeat center center/cover;
        }
        .slide:nth-child(2) {
			  background:
    linear-gradient(0deg, rgba(13, 13, 13, 0.40) 0%, rgba(13, 13, 13, 0.40) 100%),
            background: url('https://picsum.photos/1536/1024') no-repeat center center/cover;
        }
        .slide:nth-child(3) {
			  background:
    linear-gradient(0deg, rgba(13, 13, 13, 0.40) 0%, rgba(13, 13, 13, 0.40) 100%),
            background: url('https://picsum.photos/1536/1024') no-repeat center center/cover;
        }
        .slide:nth-child(4) {
			  background:
    linear-gradient(0deg, rgba(13, 13, 13, 0.40) 0%, rgba(13, 13, 13, 0.40) 100%),
            background: url('https://picsum.photos/1536/1024') no-repeat center center/cover;
        }
		.title{
			font-size:28px;
		}
		.subtitle{
font-size:16px;
		}
		.slider-nav{
			padding:12px;
		}
		.slider-nav {
width: 135px;
}
.nav-dot{
	width:10px;
	height:10px;
}
    </style>

    <div class="slider-container">
        <!-- اسلاید 1 -->
        <div class="slide active">
            <div class="content-container">
                <div class="right-column">
                    <h1 class="title">6tofit</h1>
                    <p class="subtitle">دریافت مشاوره علمی و برای انتخاب بهترین برنامه ورزشی و تغذیه</p>
                    <a href="#" class="consult-button">مشاوره رایگان</a>
                </div>
            </div>
        </div>
      
        <div class="slide">
            <div class="content-container">
                <div class="right-column">
                    <h1 class="title">6tofit</h1>
                    <p class="subtitle">دریافت مشاوره علمی و برای انتخاب بهترین برنامه ورزشی و تغذیه</p>
                    <a href="#" class="consult-button">مشاوره رایگان</a>
                </div>
            </div>
        </div>
       
        <div class="slide">
            <div class="content-container">
                <div class="right-column">
                    <h1 class="title">6tofit</h1>
                    <p class="subtitle">دریافت مشاوره علمی و برای انتخاب بهترین برنامه ورزشی و تغذیه</p>
                    <a href="#" class="consult-button">مشاوره رایگان</a>
                </div>
            </div>
        </div>
   
        <div class="slide">
            <div class="content-container">
                <div class="right-column">
                    <h1 class="title">6tofit</h1>
                    <p class="subtitle">دریافت مشاوره علمی و برای انتخاب بهترین برنامه ورزشی و تغذیه</p>
                   <a href="javascript:void(0)" class="consult-button" onclick="showFreeConsultationPopup()">مشاوره رایگان</a>
                </div>
            </div>
        </div> 
 <?php
        // Render the popup at the end of the body
        render_free_consultation_popup("مشاوره رایگان", "ارسال درخواست");
?>
        <!-- ناوبری اسلایدر -->
        <div class="slider-nav">
            <span class="nav-dot active"></span>
            <span class="nav-dot"></span>
            <span class="nav-dot"></span>
            <span class="nav-dot"></span>
        </div>
    </div>

    
    <script>
        // برای تغییر اسلایدها به صورت دستی (بدون کتابخانه)
        const slides = document.querySelectorAll('.slide');
        const navDots = document.querySelectorAll('.nav-dot');
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove('active');
                navDots[i].classList.remove('active');
                if (i === index) {
                    slide.classList.add('active');
                    navDots[i].classList.add('active');
                }
            });
        }

        // کلیک روی نقطه‌های ناوبری
        navDots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });

        // تغییر خودکار اسلایدها (هر 5 ثانیه)
        setInterval(() => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }, 5000);
    </script>

      
    </section>

   <section class="about-section">
    <div class="content-row">
        <h2 class="title-1">با محصولات 6tofit</h2>
        <p class="title-2">معجزه سلامتی در دستان شماست</p>
        <p class="description">
            در 6tofit ما معتقدیم مسیر رسیدن به اندام ایده‌آل، فقط یک مسیر نیست. برای همین سه راه متفاوت ولی علمی و حرفه‌ای پیش پات گذاشتیم. چه بخوای در خونه تمرین کنی، چه عاشق باشگاه باشی، چه فقط دنبال راهنمایی رایگان باشی، یا حتی بخوای کسی همیشه همراهت باشه، اینجا برایت مسیری طراحی کردیم که دقیقاً با تو و زندگی‌ات جور باشه.
        </p>
    </div>

    <style>
        /* استایل سکشن */
        .about-section {
            width: 100%;
            padding: 60px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            direction: rtl;
			margin-top: 110px;
        }

        /* ردیف محتوا */
        .content-row {
            width: 80%;
            max-width: 1400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        /* عنوان اول */
        .title-1 {
            font-size: 36px;
			font-family: 'iranyekanen', sans-serif;
            font-weight: 500;
            line-height: 48px;
            background: linear-gradient(90.11deg, #E64910 23.2%, #F51E55 36.59%, #DE39B3 49.98%, #C64CDB 63.37%, #0083EB 76.76%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 16px;
        }

        /* عنوان دوم */
        .title-2 {
            font-size: 36px;
			font-family: 'iranyekanen', sans-serif;
            font-weight: 500;
            line-height: 48px;
            color: #161618;
            margin-bottom: 24px;
        }

        /* متن توضیحات */
        .description {
            font-size: 24px;
			font-family: 'iranyekanen', sans-serif;
            font-weight: 400;
            line-height: 32px;
            color: #65656D;
          
        }
		@media (max-width: 768px) {
        .title-1{
			font-size: 28px;
			line-height: 38px;
		}
		.title-2{
			font-size: 28px;
			line-height: 38px;
		}
		.description{
			font-size: 16px;
			line-height: 22px;
			text-align: justify;
		}
		.content-row {
			width:90%;
}
.about-section{
	    margin-top: 40px;
}


		}
    </style>
</section>


<section class="tabs-section">
    <div class="content-rowpr">
        <div class="tabs-container">
            <div class="tab active" data-tab="products"><p>محصولات</p></div>
            <div class="tab" data-tab="vip"><p>VIP</p></div>
            <div class="tab" data-tab="offline"><p>دوره آفلاین</p> </div>
        </div>
<div class="tab-content" id="products">
    <div class="products-container">
        <div class="products-grid">
            <!-- ردیف اول: دو کارت -->
            <div class="product-card">
                <div class="card-content">
                    <img src="http://6tofit.com/wp-content/uploads/2025/10/Weight.png" alt="تصویر محصول 1" class="product-image">
                    <p class="product-description"> برنامه ورزشی</p>
                    <h3 class="product-title">
                        <span class="highlight1">تمرین کن،</span> هرجا و با هر وسیله ای که داری
                    </h3>
                </div>
                <div class="card-overlay" id="overlay1">
                    <p class="overlay-text">تمرین کن، هرجا و با هر وسیله‌ای که داری
برنامه ورزشی‌ای که فقط برای تو طراحی شده؛ براساس هدفت، شرایط بدنی‌ات و امکاناتی که در دسترس داری، چه خونه باشه چه باشگاه. و با پیگیری‌ هفتگی کوچ‌، می‌تونی مسیرت رو دقیق‌تر و مطمئن‌تر ادامه بدی.</p>
                    <a href="https://6tofit.com/product/training-plan/" class="overlay-link">
                        <img src="http://6tofit.com/wp-content/uploads/2025/10/Icon-Button.png" alt="آیکن لینک" class="link-icon">
                    </a>
                </div>
                <img src="http://6tofit.com/wp-content/uploads/2025/10/plusicon.svg" alt="آیکن تعاملی" class="interactive-icon" data-overlay="overlay1">
            </div>
            <div class="product-card">
                <div class="card-content">
                    <img src="http://6tofit.com/wp-content/uploads/2025/10/RedApple.png" alt="تصویر محصول 2" class="product-image">
                    <p class="product-description">رژیم غذایی</p>
                    <h3 class="product-title">
                        <span class="highlight">هم غذا، هم تناسب؛</span> بدون جنگ با خوراکی‌ها
                    </h3>
                </div>
                <div class="card-overlay" id="overlay2">
                    <p class="overlay-text">متن overlay برای کارت دوم: جزئیات بیشتر یا پیام دلخواه.</p>
                    <a href="https://6tofit.com/product/diet/" class="overlay-link">
                        <img src="http://6tofit.com/wp-content/uploads/2025/10/Icon-Button.png" alt="آیکن لینک" class="link-icon">
                    </a>
                </div>
                <img src="http://6tofit.com/wp-content/uploads/2025/10/plusicon.svg" alt="آیکن تعاملی" class="interactive-icon" data-overlay="overlay2">
            </div>
            <!-- ردیف دوم: یک کارت تمام عرض -->
            <div class="product-card full-width">
                <div class="card-content">
                    <img src="http://6tofit.com/wp-content/uploads/2025/10/mixplan.png" alt="تصویر محصول 3" class="product-image3">
                    <p class="product-description">برنامه کمبو</p>
                    <h3 class="product-title">
                        <span class="highlight2">هم تمرین، هم تغذیه،</span><br> همون تعادلی که همیشه دنبالش بودی
                    </h3>
                </div>
                <div class="card-overlay" id="overlay3">
                    <p class="overlay-text">متن overlay برای کارت سوم: جزئیات بیشتر یا پیام دلخواه.</p>
                    <a href="https://6tofit.com/product/combined-diet-training-plan/" class="overlay-link">
                        <img src="http://6tofit.com/wp-content/uploads/2025/10/Icon-Button.png" alt="آیکن لینک" class="link-icon">
                    </a>
                </div>
                <img src="http://6tofit.com/wp-content/uploads/2025/10/plusicon.svg" alt="آیکن تعاملی" class="interactive-icon" data-overlay="overlay3">
            </div>
        </div>
    </div>

    <style>
        .products-container {
            padding: 80px 0;
            direction: rtl;
        }

        .products-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            max-width: 100%;
        }

        .product-card {
            position: relative;
            background: #FFFFFF;
            padding: 40px;
            border-radius: 24px;
            direction: rtl;
        }

        .product-card.full-width {
            grid-column: 1 / -1;
        }

        .card-content {
            direction: rtl;
			margin-bottom: 60px
        }

        .product-image {
            width: auto;
            height: auto;
            border-radius: 12px;
            margin-bottom: 20px;
        }
		 .product-image3 {
            width: auto;
            height: auto;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .product-description {
            font-size: 18px;
            font-weight: 400;
            line-height: 24px;
            margin-bottom: 20px;
            color: #65656D;
        }

        .product-title {
            font-weight: 500;
            font-size: 30px;
            line-height: 38px;
            margin: 0;
            color: #161618;
        }
                 .highlight1 {
            color: #4590E6;
        }
        .highlight2 {
            color: #6959D9;
        }

        .highlight {
            color: #ED5C5C;
        }

        .interactive-icon {
            position: absolute;
            bottom: 20px;
            left: 40px;
            width: 40px;
            height: 40px;
            cursor: pointer;
            border-radius: 50%;
            z-index: 2;
        }

        .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #4590E6;
            border-radius: 24px;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 40px;
            box-sizing: border-box;
            z-index: 3;
        }

        .card-overlay.active {
            display: flex;
        }

        .overlay-text {
            color: #FFFFFF;
            font-size: 20px;
            font-weight: 500;
            line-height: 26px;
            text-align: center;
            margin-bottom: 20px;
        }

        .overlay-link {
            position: absolute;
            bottom: 20px;
            left: 40px;
        }

        .link-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
			.product-image
 {
    width: 56px;
    height: 56px;
}

.product-image3 {
    width: 152px;
    height: 56px;
}
.interactive-icon{
	left:20px
}
  .overlay-link {
           
            left: 20px;
        }


            .products-container {
                padding: 40px 0;
            }

            .product-card {
                padding: 20px;
            }

            .product-title {
                font-size: 24px;
                line-height: 32px;
            }

            .product-description {
                font-size: 16px;
                line-height: 22px;
            }
        }
    </style>

    <script>
        function toggleOverlay(overlayId) {
            const overlay = document.getElementById(overlayId);
            overlay.classList.toggle('active');
        }

        // Event listener برای آیکن‌های تعاملی
        document.addEventListener('DOMContentLoaded', function() {
            const icons = document.querySelectorAll('.interactive-icon');
            icons.forEach(icon => {
                icon.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const overlayId = this.getAttribute('data-overlay');
                    toggleOverlay(overlayId);
                });
            });

            // بستن overlay با کلیک خارج از کارت‌ها (خارج از overlay)
            document.addEventListener('click', function(event) {
                const overlays = document.querySelectorAll('.card-overlay');
                let clickedInsideOverlay = false;
                overlays.forEach(overlay => {
                    if (overlay.classList.contains('active') && overlay.contains(event.target)) {
                        clickedInsideOverlay = true;
                    }
                });
                if (!clickedInsideOverlay) {
                    overlays.forEach(overlay => {
                        overlay.classList.remove('active');
                    });
                }
            });
        });
    </script>
</div>       
<div class="tab-content" id="vip" style="display: none;">
    <div class="vip-container">
        <div class="vip-grid">
            <!-- یک کارت تمام عرض -->
            <div class="vip-card full-width">
                <div class="vip-content">
                    <img src="http://6tofit.com/wp-content/uploads/2025/10/gem.png" alt="تصویر VIP" class="vip-image">
                    <p class="vip-description">VIP</p>
                    <h3 class="vip-title">
                        <span class="vip-highlight">VIP یعنی یک سبک زندگی‌ای که فقط برای تو طراحی شده،</span> یعنی داشتن مربی، پشتیبان، و برنامه‌ای که با زندگی تو هماهنگه
                    </h3>
                </div>
                <div class="vip-overlay" id="vip-overlay1">
                    <p class="vip-overlay-text">متن overlay برای کارت VIP: جزئیات بیشتر یا پیام دلخواه.</p>
                    <a href="https://6tofit.com/vip/" class="vip-overlay-link">
                        <img src="http://6tofit.com/wp-content/uploads/2025/10/Icon-Button.png" alt="آیکن لینک" class="vip-link-icon">
                    </a>
                </div>
                <img src="http://6tofit.com/wp-content/uploads/2025/10/plusicon.svg" alt="آیکن تعاملی" class="vip-interactive-icon" data-overlay="vip-overlay1">
            </div>
        </div>
    </div>

    <style>
        .vip-container {
            padding: 80px 0;
            direction: rtl;
        }

        .vip-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
            max-width: 100%;
        }

        .vip-card {
            position: relative;
            background: #FFFFFF;
            padding: 40px;
            border-radius: 24px;
            direction: rtl;
        }

        .vip-card.full-width {
            grid-column: 1 / -1;
        }

        .vip-content {
            direction: rtl;
            margin-bottom: 60px;
        }

        .vip-image {
            width: auto;
            height: auto;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .vip-description {
            font-size: 18px;
            font-weight: 400;
            line-height: 24px;
            margin-bottom: 20px;
            color: #65656D;
        }

        .vip-title {
            font-weight: 500;
            font-size: 30px;
            line-height: 38px;
            margin: 0;
            color: #161618;
        }

        .vip-highlight {
            color: #5247FF;
        }

        .vip-interactive-icon {
            position: absolute;
            bottom: 20px;
            left: 40px;
            width: 40px;
            height: 40px;
            cursor: pointer;
            border-radius: 50%;
            z-index: 2;
        }

        .vip-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #4590E6;
            border-radius: 24px;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 40px;
            box-sizing: border-box;
            z-index: 3;
        }

        .vip-overlay.active {
            display: flex;
        }

        .vip-overlay-text {
            color: #FFFFFF;
            font-size: 20px;
            font-weight: 500;
            line-height: 26px;
            text-align: center;
            margin-bottom: 20px;
        }

        .vip-overlay-link {
            position: absolute;
            bottom: 20px;
            left: 40px;
        }

        .vip-link-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .vip-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .vip-image {
                width: 56px;
                height: 56px;
            }

            .vip-interactive-icon {
                left: 20px;
            }

            .vip-overlay-link {
                left: 20px;
            }

            .vip-container {
                padding: 40px 0;
            }

            .vip-card {
                padding: 20px;
            }

            .vip-title {
                font-size: 24px;
                line-height: 32px;
            }

            .vip-description {
                font-size: 16px;
                line-height: 22px;
            }
        }
    </style>

    <script>
        function toggleVipOverlay(overlayId) {
            const overlay = document.getElementById(overlayId);
            overlay.classList.toggle('active');
        }

        // Event listener برای آیکن‌های تعاملی
        document.addEventListener('DOMContentLoaded', function() {
            const icons = document.querySelectorAll('.vip-interactive-icon');
            icons.forEach(icon => {
                icon.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const overlayId = this.getAttribute('data-overlay');
                    toggleVipOverlay(overlayId);
                });
            });

            // بستن overlay با کلیک خارج از کارت‌ها (خارج از overlay)
            document.addEventListener('click', function(event) {
                const overlays = document.querySelectorAll('.vip-overlay');
                let clickedInsideOverlay = false;
                overlays.forEach(overlay => {
                    if (overlay.classList.contains('active') && overlay.contains(event.target)) {
                        clickedInsideOverlay = true;
                    }
                });
                if (!clickedInsideOverlay) {
                    overlays.forEach(overlay => {
                        overlay.classList.remove('active');
                    });
                }
            });
        });
    </script>
</div>
        <div class="tab-content" id="offline" style="display: none;">
    <div class="offline-container">
        <div class="offline-grid">
            <!-- ردیف اول: دو کارت -->
            <div class="offline-card">
                <div class="offline-content">
                    <img src="http://6tofit.com/wp-content/uploads/2025/10/peach.png" alt="تصویر آفلاین 1" class="offline-image">
                    <p class="offline-description">گلوت لب</p>
                    <h3 class="offline-title">
                        <span class="offline-highlight1">تمرکز روی باسن،</span> تغییر در فرم کل بدن
                    </h3>
                </div>
                <div class="offline-overlay" id="offline-overlay1">
                    <p class="offline-overlay-text">تمرین کن، هرجا و با هر وسیله‌ای که داری
برنامه ورزشی‌ای که فقط برای تو طراحی شده؛ براساس هدفت، شرایط بدنی‌ات و امکاناتی که در دسترس داری، چه خونه باشه چه باشگاه. و با پیگیری‌ هفتگی کوچ‌، می‌تونی مسیرت رو دقیق‌تر و مطمئن‌تر ادامه بدی.</p>
                    <a href="#" class="offline-overlay-link">
                        <img src="http://6tofit.com/wp-content/uploads/2025/10/Icon-Button.png" alt="آیکن لینک" class="offline-link-icon">
                    </a>
                </div>
                <img src="http://6tofit.com/wp-content/uploads/2025/10/plusicon.svg" alt="آیکن تعاملی" class="offline-interactive-icon" data-overlay="offline-overlay1">
            </div>
            <div class="offline-card">
                <div class="offline-content">
                    <img src="http://6tofit.com/wp-content/uploads/2025/10/mat.png" alt="تصویر آفلاین 2" class="offline-image">
                    <p class="offline-description">اسنک اکسرسایز</p>
                    <h3 class="offline-title">
                        <span class="offline-highlight">۱۰ دقیقه برای خودت؛</span> هرجا، هر وقت، با هرچی که دم دسته
                    </h3>
                </div>
                <div class="offline-overlay" id="offline-overlay2">
                    <p class="offline-overlay-text">متن overlay برای کارت دوم: جزئیات بیشتر یا پیام دلخواه.</p>
                    <a href="#" class="offline-overlay-link">
                        <img src="http://6tofit.com/wp-content/uploads/2025/10/Icon-Button.png" alt="آیکن لینک" class="offline-link-icon">
                    </a>
                </div>
                <img src="http://6tofit.com/wp-content/uploads/2025/10/plusicon.svg" alt="آیکن تعاملی" class="offline-interactive-icon" data-overlay="offline-overlay2">
            </div>
        </div>
    </div>

    <style>
        .offline-container {
            padding: 80px 0;
            direction: rtl;
        }

        .offline-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            max-width: 100%;
        }

        .offline-card {
            position: relative;
            background: #FFFFFF;
            padding: 40px;
            border-radius: 24px;
            direction: rtl;
        }

        .offline-content {
            direction: rtl;
            margin-bottom: 60px;
        }

        .offline-image {
            width: auto;
            height: auto;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .offline-description {
            font-size: 18px;
            font-weight: 400;
            line-height: 24px;
            margin-bottom: 20px;
            color: #65656D;
        }

        .offline-title {
            font-weight: 500;
            font-size: 30px;
            line-height: 38px;
            margin: 0;
            color: #161618;
        }

        .offline-highlight1 {
            color: #FF7A00;
        }

        .offline-highlight {
            color: #4590E6;
        }

        .offline-interactive-icon {
            position: absolute;
            bottom: 20px;
            left: 40px;
            width: 40px;
            height: 40px;
            cursor: pointer;
            border-radius: 50%;
            z-index: 2;
        }

        .offline-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #4590E6;
            border-radius: 24px;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 40px;
            box-sizing: border-box;
            z-index: 3;
        }

        .offline-overlay.active {
            display: flex;
        }

        .offline-overlay-text {
            color: #FFFFFF;
            font-size: 20px;
            font-weight: 500;
            line-height: 26px;
            text-align: center;
            margin-bottom: 20px;
        }

        .offline-overlay-link {
            position: absolute;
            bottom: 20px;
            left: 40px;
        }

        .offline-link-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .offline-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .offline-image {
                width: 56px;
                height: 56px;
            }

            .offline-interactive-icon {
                left: 20px;
            }

            .offline-overlay-link {
                left: 20px;
            }

            .offline-container {
                padding: 40px 0;
            }

            .offline-card {
                padding: 20px;
            }

            .offline-title {
                font-size: 24px;
                line-height: 32px;
            }

            .offline-description {
                font-size: 16px;
                line-height: 22px;
            }
        }
    </style>

    <script>
        function toggleOfflineOverlay(overlayId) {
            const overlay = document.getElementById(overlayId);
            overlay.classList.toggle('active');
        }

        // Event listener برای آیکن‌های تعاملی
        document.addEventListener('DOMContentLoaded', function() {
            const icons = document.querySelectorAll('.offline-interactive-icon');
            icons.forEach(icon => {
                icon.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const overlayId = this.getAttribute('data-overlay');
                    toggleOfflineOverlay(overlayId);
                });
            });

            // بستن overlay با کلیک خارج از کارت‌ها (خارج از overlay)
            document.addEventListener('click', function(event) {
                const overlays = document.querySelectorAll('.offline-overlay');
                let clickedInsideOverlay = false;
                overlays.forEach(overlay => {
                    if (overlay.classList.contains('active') && overlay.contains(event.target)) {
                        clickedInsideOverlay = true;
                    }
                });
                if (!clickedInsideOverlay) {
                    overlays.forEach(overlay => {
                        overlay.classList.remove('active');
                    });
                }
            });
        });
    </script>
</div>
    </div>

    <style>
        /* استایل سکشن */
        .tabs-section {
            width: 100%;
            padding: 60px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            direction: rtl;
        }

        /* ردیف محتوا */
        .content-rowpr {
            width: 80%;
            max-width: 1400px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* کانتینر تب‌ها */
        .tabs-container {
            width: 80%;
            background: #F0F0F1;
            border-radius: 1000px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
			padding: 5px;
        }

        /* استایل تب‌ها */
        .tab {
            flex: 1;
            text-align: center;
            padding: 16px 0;
            font-size: 20px;
            font-weight: 700;
            color:#65656D;
            background: transparent;
            cursor: pointer;
            transition: background 0.3s;
        }

        /* تب فعال */
        .tab.active {
            background: #FFFFFF;
            border-radius: 1000px;
			color:#161618;
        }

        /* محتوای تب‌ها */
        .tab-content {
            width: 90%;
            min-height: 200px;
        }
		@media (max-width: 768px) {
         .content-rowpr{
width:95%;
		 }
		 .tabs-container {
			 width:100%;
}
.tab {
	    font-size: 14px;
}
.tabs-section{
	    padding: 10px 0;
}


		}
    </style>

    <script>
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // حذف کلاس active از همه تب‌ها
                tabs.forEach(t => t.classList.remove('active'));
                // مخفی کردن همه محتواها
                tabContents.forEach(content => content.style.display = 'none');

                // اضافه کردن کلاس active به تب کلیک‌شده
                tab.classList.add('active');
                // نمایش محتوای تب مربوطه
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).style.display = 'block';
            });
        });
    </script>
</section>



<section class="steps-section">
    <div class="content-row">
        <h2 class="steps-title">مراحل دریافت محصولات</h2>
        <div class="steps-grid">
            <div class="step-column">
                <div class="step-image">
                    <img src="http://6tofit.com/wp-content/uploads/2025/10/one.png" alt="مرحله 1" class="step-img">
                </div>
                <h3 class="step-title">مشاوره و شناخت تو</h3>
                <p class="step-description">با یه فرم کامل، سبک زندگی، هدف‌هات و شرایطت رو بررسی می‌کنیم تا نقطه شروع دقیقی داشته باشیم.</p>
            </div>
            <div class="step-column">
                <div class="step-image">
                    <img src="http://6tofit.com/wp-content/uploads/2025/10/two.png" alt="مرحله 2" class="step-img">
                </div>
                <h3 class="step-title">طراحی اختصاصی برنامه</h3>
                <p class="step-description">کارشناسان ما برنامه‌ای علمی و اجرایی فقط برای تو طراحی می‌کنن. بدون نسخه آماده، کاملاً شخصی‌سازی‌شده.</p>
            </div>
            <div class="step-column">
                <div class="step-image">
                    <img src="http://6tofit.com/wp-content/uploads/2025/10/three.png" alt="مرحله 3" class="step-img">
                </div>
                <h3 class="step-title">پرداخت و دریافت برنامه</h3>
                <p class="step-description">بعد از پرداخت، برنامه‌ت رو دریافت می‌کنی. کوچ‌ها کنار تو هستن تا مطمئن شی درست و موثر پیش می‌ری.</p>
            </div>
        </div>
    </div>

    <style>
        .steps-section {
            width: 100%;
            padding: 60px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            direction: rtl;
        }

        .content-row {
            width: 80%;
            max-width: 1400px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .steps-title {
            font-size: 30px;
            font-weight: 500;
            color: #161618;
            text-align: center;
            margin-bottom: 40px;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 80px;
            width: 100%;
            align-items: stretch;
        }

        .step-column {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100%;
        }

        .step-image {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            flex-shrink: 0;
        }

        .step-img {
            width: auto;
            height: auto;
            
            
        }

        .step-title {
            font-size: 20px;
            font-weight: 500;
            color: #5247FF;
            text-align: center;
            margin: 0 0 15px 0;
            flex-shrink: 0;
        }

        .step-description {
            font-size: 18px;
            font-weight: 400;
            color: #65656D;
            text-align: center;
            margin: 0;
            flex-grow: 1;
            line-height: 24px;
        }

        @media (max-width: 768px) {
            .content-row {
                width: 95%;
            }

            .steps-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .steps-title {
                font-size: 24px;
            }

            .step-title {
                font-size: 18px;
            }

            .step-description {
                font-size: 16px;
            }

            .steps-section {
                padding: 40px 0;
            }
        }
    </style>
</section>




<style>
  .faq-section {
    width: 100%;
    margin-top: 180px;
   
  }

  .faq-container {
      width: 80%;
      margin: 0 auto;
  }

  .faq-title {
      padding: 30px 0;
      text-align: center;
  }

  .faq-title h2 {
      font-size: 30px;
      font-weight: 500;
      color: #000000;
      margin: 0;
  }

  .faq-cards {
      display: flex;
      flex-direction: column;
      gap: 12px;
  }

  .faq-card {
      background-color: #FFFFFF;
      border-radius: 24px;
      padding: 18px 19px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .faq-question {
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
  }

  .faq-question-text {
      font-size: 18px;
      font-weight: 500;
      color: #000000;
      text-align: right;
  }

  .faq-icon img {
      width: 24px;
      height: 24px;
  }

  .faq-answer {
      display: none;
      font-size: 14px;
      color: #65656D;
      text-align: right;
      margin-top: 10px;
  }

  .faq-card.active .faq-answer {
      display: block;
  }

  .faq-card.active .faq-icon img.closed {
      display: none;
  }

  .faq-card.active .faq-icon img.open {
      display: inline;
  }

  .faq-icon img.open {
      display: none;
  }

  #faq {
      scroll-margin-top: 100px;
  }

  /* تغییرات برای موبایل */
  @media only screen and (max-width: 768px) {
      .faq-container {
          width: 90%;
      }

      .faq-title h2 {
          font-size: 24px;
      }

      .faq-question-text {
          font-size: 15px;
      }
      .faq-section{
          margin-top: 80px;
         
      }
  }
</style>
<section class="faq-section" id="faq">
  <div class="faq-container">
    <div class="faq-title">
      <h2>سوالات متداول محصولات</h2>
    </div>
    <div class="faq-cards">
      <div class="faq-card">
        <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
          <div class="faq-question-text">این برنامه چه ویژگی‌هایی دارد؟</div>
          <div class="faq-icon">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqop.svg" alt="Closed Icon" class="closed">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqcl.svg" alt="Open Icon" class="open">
          </div>
        </div>
        <div class="faq-answer">
          این برنامه شامل ویژگی‌های متنوعی مانند تمرینات شخصی‌سازی‌شده، رژیم غذایی، و پشتیبانی آنلاین است.
        </div>
      </div>
      <div class="faq-card">
        <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
          <div class="faq-question-text">چگونه می‌توانم اشتراک بخرم؟</div>
          <div class="faq-icon">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqop.svg" alt="Closed Icon" class="closed">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqcl.svg" alt="Open Icon" class="open">
          </div>
        </div>
        <div class="faq-answer">
          برای خرید اشتراک، به بخش خدمات پرو مراجعه کنید و یکی از گزینه‌ها را انتخاب کنید.
        </div>
      </div>
      <div class="faq-card">
        <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
          <div class="faq-question-text">آیا پشتیبانی ۲۴ ساعته دارید؟</div>
          <div class="faq-icon">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqop.svg" alt="Closed Icon" class="closed">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrowfaqcl.svg" alt="Open Icon" class="open">
          </div>
        </div>
        <div class="faq-answer">
          بله، تیم پشتیبانی ما به‌صورت ۲۴ ساعته آماده پاسخگویی به سوالات شماست.
        </div>
      </div>
    </div>
  </div>
</section>




<section class="button-section">
    <div class="content-row">
        <button class="view-programs-btn" onclick="window.location.href='/products/'">مشاهده برنامه‌ها</button>

    </div>

    <style>
        .button-section {
            width: 100%;
            padding: 60px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            direction: rtl;
        }

        .content-row {
            width: 80%;
            max-width: 1400px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .view-programs-btn {
            background-color: #5247FF;
            color: #FFFFFF;
            border: none;
            border-radius: 10000px;
            padding: 12px 10px;
            min-width: 70px;
            font-weight: 700;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .view-programs-btn:hover {
            background-color: #4239D0;
        }

        @media (max-width: 768px) {
            .content-row {
                width: 95%;
            }

            .button-section {
                padding: 40px 0;
            }
        }
    </style>
</section>





 
  <style>
    .user-stories-section {
      width: 100%;
      background-color: #FFFFFF;
      padding: 90px 0;
	
    }

    .user-stories-container {
      width: 80%;
      margin: 0 auto;
     
	   
    }

    .user-stories-title {

      text-align: right;
    }

    .user-stories-title h2 {
      font-size: 30px;
      font-weight: 500;
      color: #000000;
      margin: 0;
    }

    .stories-slider-container {
      position: relative;
      width: 100%;
      overflow: hidden;
    }

    .stories-slider {
      display: flex;
      flex-direction: row; /* ترتیب اسلایدها برای محاسبه موقعیت */
      transition: transform 0.5s ease-in-out;
    }

    .story-slide {
      flex: 0 0 100%; /* هر اسلاید 100% عرض ظرف */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .story-slide img {
      width: auto;
      height: auto;
     
    }

    .story-content {
      display: flex;
      flex-direction: column;
      align-items: center;
     
	  width:40%;
    }

    .story-icon {
      width: 60px;
      height: 60px;
      margin-bottom: 10px;
    }

    .story-title {
      font-size: 24px;
      font-weight: 500;
      color: #000000;
      text-align: center;
      margin: 0 0 10px 0;
    }

    .story-text {
      font-size: 18px;
      font-weight: 400;
      color: #65656D;
      text-align: center;
      margin: 0;
      line-height: 1.5;
    }

    .stories-prev,
    .stories-next {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      z-index: 10;
    }

    .stories-prev {
      right: 10px; /* دکمه "قبلی" در سمت راست */
    }

    .stories-next {
      left: 10px; /* دکمه "بعدی" در سمت چپ */
    }

    .stories-prev img,
    .stories-next img {
      width: 40px;
      height: 40px;
    }

    #user-stories {
      scroll-margin-top: 100px;
    }

    /* تغییرات برای موبایل */
    @media only screen and (max-width: 768px) {
      .user-stories-title h2 {
        font-size: 24px;
      }
      .user-stories-section {
        margin-bottom: 60px;
      }
      .user-stories-title {
        margin: 50px 0 10px;
      }
      .story-text {
        font-size: 16px;
      }
      .stories-prev img,
      .stories-next img {
        width: 36px;
        height: 36px;
      }
      .story-slide img {
        height: auto;
		width: 90%;
      }
	  .story-content{
		  width:90%;
	  }
	  .story-icon{
		   height: 64px!important;
		width: 64px!important;
	  }
	  .user-stories-section{
		  padding: 20px 0;
	  }
    }
  </style>

  <section class="user-stories-section" id="user-stories">
    <div class="user-stories-container">
      <div class="user-stories-title">
        <h2>داستان‌های موفقیت شما</h2>
      </div>
      <div class="stories-slider-container">
        <div class="stories-slider" id="stories-slider">
          <div class="story-slide">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/slide1.png" alt="Story 1">
            <div class="story-content">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/storyic.png" alt="User Icon" class="story-icon">
              <h3 class="story-title">نیلوفر شریفی</h3>
              <p class="story-text">توی خوابگاه بودم و دسترسی زیادی نداشتم. برنامه‌ای که برام فرستادن هم تمرین خونه‌ای داشت، هم یه رژیم منطقی که با امکاناتم جور بود. الان نه تنها وزنم کم شده، بلکه عادت‌هام هم بهتر شدن.</p>
            </div>
          </div>

          <div class="story-slide">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/slide1.png" alt="Story 2">
            <div class="story-content">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/storyic.png" alt="User Icon" class="story-icon">
              <h3 class="story-title">ملیکا داوودی</h3>
              <p class="story-text">این برنامه زندگی من رو تغییر داد! با تمرینات ساده و رژیم مناسب، تونستم به اهدافم برسم و احساس بهتری داشته باشم.</p>
            </div>
          </div>

          <div class="story-slide">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/slide1.png" alt="Story 3">
            <div class="story-content">
              <img src="http://6tofit.com/wp-content/uploads/2025/10/storyic.png" alt="User Icon" class="story-icon">
              <h3 class="story-title">ساناز شریفی</h3>
              <p class="story-text">کاربری آسان و نتایج شگفت‌انگیز! هرگز فکر نمی‌کردم بتونم اینقدر سریع پیشرفت کنم.</p>
            </div>
          </div>
        </div>
<div class="stories-prev" onclick="moveStory(1)">
  <img src="http://6tofit.com/wp-content/uploads/2025/10/IconButtonR.svg" alt="Previous">
</div>
<div class="stories-next" onclick="moveStory(-1)">
  <img src="http://6tofit.com/wp-content/uploads/2025/10/IconButtonL.svg" alt="Next">
</div>

      </div>
    </div>
  </section>

  <script>
    (function () {
      let currentIndex = 0;
      const slides = document.querySelectorAll('.story-slide');
      const totalSlides = slides.length;
      const slider = document.getElementById('stories-slider');
      
      // عرض دینامیک برای اسلایدها (100% عرض ظرف)
      const getSlideWidth = () => {
        return document.querySelector('.stories-slider-container').offsetWidth;
      };
      let slideWidth = getSlideWidth();

      // تنظیم موقعیت اولیه اسلایدر
      if (slider) {
        slider.style.transform = `translateX(0px)`;
      }

      window.moveStory = function (direction) {
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
      let autoSlide = setInterval(() => window.moveStory(1), 5000);

      // توقف اسلاید خودکار هنگام کلیک کاربر
      document.querySelector('.stories-prev').addEventListener('click', () => clearInterval(autoSlide));
      document.querySelector('.stories-next').addEventListener('click', () => clearInterval(autoSlide));
    })();
  </script>



<style>
  .blog-carousel-section {
    width: 100%;
 
    padding: 100px 0;
    direction: rtl;
  }

  .blog-container {
   
  
    margin: 0 auto;
  }

  .blog-title {
   width: 80%;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 50px;
  }

  .blog-title h2 {
    font-size: 30px;
    font-weight: 500;
    color: #161618;
    margin: 0;
  }

  .carousel-container {
    position: relative;
    overflow: hidden;
  }

  .carousel {
    display: flex;
    transition: transform 0.5s ease-in-out;
    width: calc(100% + 20px); /* برای spacing */
	padding-right: 50px;
  }
.blog-post-title a {
    text-align: right;
    font-size: 24px;
    font-weight: 500;
    color: #191919;
    margin: 0;
    line-height: 1.3;
    text-decoration: none; /* این خط خط زیر لینک را حذف می‌کند */
}


  .blog-card {
    background-color: #FFFFFF;
    border-radius: 24px;
    overflow: hidden;
    margin-left: 20px;
    flex: 0 0 400px;
   
  }

  .blog-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
  }

  .blog-content {
    padding: 24px;
  }

  .category-tag {
    display: flex;
    align-items: center;
    width: fit-content;
    background-color: var(--cat-color, #default-color); /* fallback */
    border-radius: 100px;
    padding: 8px 16px;
    margin-bottom: 16px;
    color: #FFFFFF;
    font-size: 16px;
    font-weight: 400;
  }

  .category-icon {
    width: 20px;
    height: 20px;
    margin-left: 8px;
  }

  .category-name {
    margin: 0;
  }

  .blog-post-title {
    text-align: right;
    font-size: 24px;
    font-weight: 500;
    color: #191919;
    margin: 0;
    line-height: 1.3;
  }

  .carousel-prev,
  .carousel-next {
   
    
    left: 0;
    background: none;
    border: none;
    cursor: pointer;
    width: 40px;
    height: 40px;
   
  }

  .carousel-next {
    left: auto;
    right: 0;
    margin-right: 0;
  }

  .carousel-prev img,
  .carousel-next img {
    width: 100%;
    height: 100%;
  }
  .carousel-prev-next{
	  display: flex;
	  margin-top:50px;
    flex-direction: row-reverse;
    padding-left: 100px;
    justify-content: flex-start;
    gap: 24px;
  }

  /* Mobile */
  @media only screen and (max-width: 768px) {
    .blog-carousel-section {
      padding: 50px 0;
    }
 .carousel {
  
	padding-right: 30px;
  }
    .blog-container {
      width: 90%;
    }

    .blog-title h2 {
      font-size: 24px;
    }

    .blog-card {
      flex: 0 0 280px;
      margin-left: 15px;
    }

    .carousel-prev,
    .carousel-next {
      display: none;
    }

    .carousel {
      touch-action: pan-y;
    }
  }
</style>

<section class="blog-carousel-section">
  <div class="blog-container">
    <div class="blog-title">
      <h2>آخرین بلاگ‌ها</h2>
    </div>
    <div class="carousel-container">
      <div class="carousel" id="blogCarousel">
        <?php
        $args = array(
          'post_type' => 'post',
          'posts_per_page' => 6,
          'post_status' => 'publish'
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
          while ($query->have_posts()) {
            $query->the_post();
            $categories = get_the_category();
            $category = !empty($categories) ? $categories[0] : null;
            $term_id = $category ? $category->term_id : 0;
            $icon = $term_id ? get_term_meta($term_id, 'category_icon', true) : '';
            $color = $term_id ? get_term_meta($term_id, 'category_color', true) : '#000000';
            $cat_name = $category ? $category->name : 'دسته‌بندی';
        ?>
        <article class="blog-card">
          <?php if (has_post_thumbnail()) : ?>
            <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>" class="blog-image">
          <?php endif; ?>
          <div class="blog-content">
            <?php if ($category) : ?>
              <div class="category-tag" style="background-color: <?php echo esc_attr($color); ?>;">
                <?php if ($icon) : ?>
                  <img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($cat_name); ?>" class="category-icon">
                <?php endif; ?>
                <span class="category-name"><?php echo esc_html($cat_name); ?></span>
              </div>
            <?php endif; ?>
            <h3 class="blog-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          </div>
        </article>
        <?php
          }
          wp_reset_postdata();
        }
        ?>
      </div>
	  <div class="carousel-prev-next">
      <button class="carousel-prev" onclick="moveBlogSlide(-1)">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/IconButtonL.svg" alt="Previous">
      </button>
      <button class="carousel-next" onclick="moveBlogSlide(1)">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/IconButtonR.svg" alt="Next">
      </button>
	  </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('blogCarousel');
    const prevButton = document.querySelector('.carousel-prev');
    const nextButton = document.querySelector('.carousel-next');
    let currentBlog = 0;
    const cards = carousel.querySelectorAll('.blog-card');
    const cardWidth = cards[0] ? cards[0].offsetWidth + 20 : 320; // width + margin

    function moveBlogSlide(direction) {
        currentBlog += direction;
        const maxSlide = Math.max(0, cards.length - Math.floor(carousel.parentElement.offsetWidth / cardWidth));
        currentBlog = Math.max(0, Math.min(currentBlog, maxSlide));
       carousel.style.transform = `translateX(${currentBlog * cardWidth}px)`;

    }

    // Attach event listeners to buttons
    if (prevButton) {
       prevButton.addEventListener('click', () => moveBlogSlide(1));
    }
    if (nextButton) {
       nextButton.addEventListener('click', () => moveBlogSlide(-1));
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
    moveBlogSlide(diff > 0 ? -1 : 1);
    isDragging = false;
}

    });

    carousel.addEventListener('touchend', () => {
        isDragging = false;
    });
});
</script>




<style>
  .certificates-section {
    width: 100%;
    background-color: #FFFFFF;
    padding: 90px 0;
  }

  .certificates-container {
    width: 80%;
    margin: 0 auto;
  }

  .certificates-title {
    text-align: center;
    margin-bottom: 20px;
	max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
  }

  .certificates-title h3 {
    font-size: 30px;
    font-weight: 500;
    color: #000000;
    margin: 0;
  }

  .certificates-subtitle {
    font-size: 24px;
    font-weight: 400;
    color: #65656D;
    text-align: center;
    margin: 10px 0 30px 0;
    line-height: 1.5;
	font-family: 'iranyekanen', sans-serif;
  }

  .certificates-slider-container {
    position: relative;
    width: 100%;
    overflow: hidden;
	    padding: 200px 0 0;
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

  .certificate-slide img {
    width: 430px;
    height: auto;
	background: #F7F7F8;
    padding: 10px;
    border: 3px solid;
    border-radius: 40px;
	z-index: 2;
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

  /* استایل دکمه */
  .button-section {
    width: 100%;
    padding: 60px 0;
    display: flex;
    justify-content: center;
    align-items: center;
    direction: rtl;
  }

  .content-row {
    width: 80%;
    max-width: 1400px;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .view-certificates-btn {
    background-color: #5247FF;
    color: #FFFFFF;
    border: none;
    border-radius: 10000px;
    padding: 12px 10px;
    min-width: 70px;
    font-weight: 700;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .view-certificates-btn:hover {
    background-color: #4239D0;
  }
.certificate-shadow{
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
    .certificates-title h2 {
      font-size: 28px;
    }
	.certificates-subtitle {
		font-size:16px;
	}
    .certificates-section {
      margin-bottom: 0px;
    }
    .certificates-title {
      margin: 50px 0 10px;
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
    .certificate-slide img {
      height: auto;
      width: 90%;
    }
    .certificate-content {
      width: 90%;
    }
    .certificates-section {
      padding: 20px 0;
    }
    .content-rowbt {
      width: 95%;
    }
    .button-section {
      padding: 40px 0;
    }
  }
</style>

<section class="certificates-section" id="certificates">
  <div class="certificates-container">
    <div class="certificates-title">
      <h3>برنامه‌ت فقط تمرین نیست؛ نتیجه‌ی علم و تجربه‌ست</h3>
      <p class="certificates-subtitle">تمام برنامه‌ها زیر نظر سامان خوارزمی و تیم حرفه‌ای 6tofit طراحی می‌شن؛ مربی‌ای با مدارک بین‌المللی، دانش تخصصی و سال‌ها تجربه توی مسیر سلامت و تناسب اندام. این یعنی هر قدمی که برمی‌داری، پایه علمی داره.</p>
	  <div class="content-rowbt">
        <button class="view-certificates-btn" onclick="window.location.href='/about/'">مشاهده همه مدرک‌ها</button>
      </div>
    </div>
	
    <div class="certificates-slider-container">
      <div class="certificates-slider" id="certificates-slider">
        <div class="certificate-slide">
		<img src="http://6tofit.com/wp-content/uploads/2025/10/Am.jpg" alt="Certificate 1" class="certificate-shadow">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/Am.jpg" alt="Certificate 1">
          <div class="certificate-content">
            <h3 class="certificate-title">American Sports & Fitness Association</h3>
            <p class="certificate-text">The American Sports & Fitness Association hereby confers this award with all honors and privileges</p>
            <p class="certificate-subtitle">Oct 26/16</p>
          </div>
        </div>

        <div class="certificate-slide">
			<img src="http://6tofit.com/wp-content/uploads/2025/10/DTS.jpg" alt="Certificate 1" class="certificate-shadow">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/DTS.jpg" alt="Certificate 2">
          <div class="certificate-content">
            <h3 class="certificate-title">DTS Fitness Education</h3>
            <p class="certificate-text">DTS Fitness Education is a reputable fitness and health education institute based in Toronto.</p>
            <p class="certificate-subtitle">September 30, 2018</p>
          </div>
        </div>

        <div class="certificate-slide">
			<img src="http://6tofit.com/wp-content/uploads/2025/10/Gy.jpg" alt="Certificate 1" class="certificate-shadow">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/Gy.jpg" alt="Certificate 3">
          <div class="certificate-content">
            <h3 class="certificate-title">GYROTONIC® Attestation</h3>
            <p class="certificate-text">GYROTONIC® Specialized Course – Principles Applied to Dynamic Trunk Stabilization</p>
            <p class="certificate-subtitle">9-21-2018</p>
          </div>
        </div>

		<div class="certificate-slide">
			<img src="http://6tofit.com/wp-content/uploads/2025/10/nasm.jpg" alt="Certificate 1" class="certificate-shadow">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/nasm.jpg" alt="Certificate 3">
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
    <div class="button-section">
      
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
</main>

<?php
get_footer(); // فراخوانی فوتر
