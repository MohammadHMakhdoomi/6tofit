<?php
/* Template Name: صفحه دوره آفلاین */
get_header('product'); ?>
<?php
  include __DIR__ . '/template-parts/consultation-popup.php';
  ?>
<style>
  .offline-product-section {
    width: 100%;
    padding: 80px 0;
	margin-top: 80px;
   
  }

  .offline-product-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .offline-product-title {
    font-size: 44px;
    font-weight: 500;
    color: #161618;
    text-align: right;
    margin: 0 0 60px 0;
    line-height: 1.2;
  }

  .offline-products-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
  }

  .offline-product-card {
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
  }

  .offline-product-card.special {
    box-shadow: 0px 0px 15px 0px #0000000F;
  }

  .offline-special-badge {
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

  .offline-special-badge img {
    width: 16px;
    height: 16px;
  }

  .offline-product-icon {
    margin-bottom: 20px;
  }

 

  .offline-product-card-title {
    font-size: 30px;
    font-weight: 500;
    color: #161618;
    margin: 0 0 0px 0;
    line-height: 1.3;
  }
 .offline-product-card-title2 {
    font-size: 20px;
    font-weight: 500;
    color: #161618;
    margin: 0 0 20px 0;
    line-height: 1.3;
  }
  .offline-product-tags {
    display: flex;
    justify-content: center;
    gap: 4px;
    margin-bottom: 20px;
    flex-wrap: wrap;
  }

  .offline-product-tag {
    background-color: #F0F0F1;
    border-radius: 10000px;
    padding: 6px 8px;
    font-size: 12px;
    font-weight: 400;
    color: #161618;
  }

  .offline-product-price {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 30px;
    font-size: 20px;
    font-weight: 500;
  }

  .offline-price-from {
    color: #65656D;
  }

  .offline-price-amount {
    color: #161618;
  }

  .offline-price-currency {
    color: #65656D;
  }

  .offline-product-buttons {
    display: flex;
    gap: 16px;
    width: 100%;
    justify-content: center;
  }

  .offline-product-btn {
    border-radius: 100px;
    padding: 12px 10px;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.3s ease;
    border: none;
    text-align: center;
    min-width: 120px;
  }

  .offline-product-btn-details {
    background-color: #5247FF;
    color: #FFFFFF;
  }

  .offline-product-btn-details:hover {
    background-color: #4239D0;
  }

  .offline-product-btn-buy {
    background-color: #FFFFFF;
    color: #5247FF;
    border: 1px solid #5247FF;
  }

  .offline-product-btn-buy:hover {
    background-color: #F0F0F1;
  }

  /* موبایل */
  @media only screen and (max-width: 768px) {
    .offline-product-section {
      padding: 40px 0;
    }

    .offline-product-title {
      font-size: 32px;
      text-align: center;
	  display: none;
    }

    .offline-products-grid {
      grid-template-columns: 1fr;
      gap: 20px;
    }

    .offline-product-card {
      height: auto;
      padding: 30px 20px;
    }

    .offline-product-card-title {
      font-size: 24px;
    }

    .offline-product-tags {
      justify-content: center;
    }

    .offline-product-price {
      font-size: 18px;
    }

    .offline-product-buttons {
      
      gap: 12px;
    }

    .offline-product-btn {
      width: 100%;
     max-width: 104px;
    }
  }
</style>

<section class="offline-product-section">
  <div class="offline-product-container">
    <h1 class="offline-product-title">محصولات</h1>
    <div class="offline-products-grid">
      <!-- کارت 1 -->
      <div class="offline-product-card">
        <div class="offline-product-icon">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/Peach.png" alt="آیکون محصول 1">
        </div>
        <h3 class="offline-product-card-title">گلوت لب</h3>
		<h3 class="offline-product-card-title2">GluteLab</h3>
        <div class="offline-product-tags">
          <span class="offline-product-tag">ویدئو آماده</span>
          <span class="offline-product-tag">انجام حرکات توسط مربی</span>
		 
        </div>
        <div class="offline-product-price">
          <span class="offline-price-from">شروع قیمت از</span>
          <span class="offline-price-amount">4.500.000</span>
          <span class="offline-price-currency">تومان</span>
        </div>
        <div class="offline-product-buttons">
          <button class="offline-product-btn offline-product-btn-details">جزئیات</button>
          <button class="offline-product-btn offline-product-btn-buy">خرید</button>
        </div>
      </div>

      <!-- کارت 2 -->
      <div class="offline-product-card">
        <div class="offline-product-icon">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/Group3-1.png" alt="آیکون محصول 2">
        </div>
        <h3 class="offline-product-card-title">اسنک اکسرسایز</h3>
		<h3 class="offline-product-card-title2">Snack exercise</h3>
        <div class="offline-product-tags">
          <span class="offline-product-tag">ورزش با وسایل درخانه</span>
          <span class="offline-product-tag">بازه زمانی کوتاه</span>
          
        </div>
        <div class="offline-product-price">
          <span class="offline-price-from">شروع قیمت از</span>
          <span class="offline-price-amount">1.500.000</span>
          <span class="offline-price-currency">تومان</span>
        </div>
        <div class="offline-product-buttons">
          <button class="offline-product-btn offline-product-btn-details">جزئیات</button>
          <button class="offline-product-btn offline-product-btn-buy">خرید</button>
        </div>
      </div>

    </div>
  </div>
</section>



<style>
  .offline-product-cta-section {
    width: 100%;
    margin: 100px 0;
  }

  .offline-product-cta-container {
    width: 80%;
    margin: 0 auto;
  }

  .offline-product-cta-title {
    text-align: right;
  }

  .offline-product-cta-title h2 {
    font-size: 30px;
    font-weight: 500;
    color: #000000;
    margin: 0 0 24px;
  }

  .offline-product-cta-cards {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  .offline-product-cta-card {
    flex: 1;
    background-color: #e6e6f3a1;
    border-radius: 24px;
    padding: 32px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
	width: 100%;
  }

  .offline-product-cta-card img {
    width: 120px;
    height: 120px;
    object-fit: contain;
    margin-bottom: 16px;
  }

  .offline-product-cta-card h2 {
    font-size: 30px;
    font-weight: 500;
    color: #000000;
    margin: 0 0 15px;
  }

  .offline-product-cta-card p {
    font-size: 16px;
    color: #000000;
    margin: 15px 0;
    margin-bottom: 25px;
  }

  .offline-product-cta-button {
    background: none;
    border: none;
    font-size: 16px;
    color: #5247FF;
    cursor: pointer;
    display: inline-flex;
    gap: 8px;
    
  }

  .offline-product-cta-button img {
    width: 20px;
    height: 20px;
    vertical-align: middle;
  }

  #offline-product-cta {
    scroll-margin-top: 100px;
  }

  /* تغییرات برای موبایل */
  @media only screen and (max-width: 768px) {
    .offline-product-cta-container {
      width: 90%;
    }

    .offline-product-cta-title h2 {
      font-size: 24px;
    }

    .offline-product-cta-cards {
      flex-direction: column;
      gap: 24px;
    }
.offline-product-cta-card{
	width: auto;
}
   

    .offline-product-cta-card h2 {
      font-size: 24px;
    }

    .offline-product-cta-card p {
      font-size: 14px;
    }

    .offline-product-cta-button {
      font-size: 16px;
    }
  }
</style>

<section class="offline-product-cta-section" id="offline-product-cta">
  <div class="offline-product-cta-container">
    <div class="offline-product-cta-title">
      <h2>انتخاب بهتر با</h2>
    </div>
    <div class="offline-product-cta-cards">
      <div class="offline-product-cta-card">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/Headphonepr.png" alt="Card Image 2">
        <h2>مشاوره رایگان</h2>
        <p>برای دریافت مشاوره رایگان، کافیست درخواست خود را ثبت کنید. پس از ثبت درخواست متخصصان ما با شما ارتباط خواهند گرفت.</p>
        <button class="offline-product-cta-button" onclick="showFreeConsultationPopup()">
          ثبت درخواست
          <img src="http://6tofit.com/wp-content/uploads/2025/10/Arrow-Left-2-Iconly-Pro.svg" alt="Button Icon">
        </button>
      </div>
    </div>
  </div>
</section>
  <?php
        // Render the popup at the end of the body
        render_free_consultation_popup("مشاوره رایگان", "ارسال درخواست");
?>
<?php get_footer(); ?>