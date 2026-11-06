<?php
/**
 * Footer template for VIP page
 */
?>
<?php render_mytests_popup(); ?>
<?php render_questionnaire_popup(); ?>
<?php render_myprograms_popup(); ?>
<style>
  .vip-footer {
    width: 100%;
    background-color: #161618;
    direction: rtl;
    font-family: 'Arial', sans-serif;
    color: #161618;
  }

  .vip-footer-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .vip-footer-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 0;
    flex-wrap: wrap;
  }

  .vip-footer-row .vip-footer-col {
    flex: 1;
  }

  .vip-footer-row .vip-footer-col.vip-menu-col {
    flex: 2;
    text-align: center;
  }

  .vip-footer-row .vip-footer-col.vip-logo-col {
    order: 1; /* در RTL، لوگو سمت راست */
  }

  .vip-footer-row .vip-footer-col.vip-menu-col {
    order: 2;
  }

  .vip-footer-row .vip-footer-col.vip-images-col {
    order: 3; /* سمت چپ */
    display: flex;
    justify-content: flex-end;
    gap: 10px;
  }

  .vip-logo-col img {
    max-width: 78px; /* اندازه لوگو رو تنظیم کن */
    height: auto;
  }

  .vip-footer-menu {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 40px;
    flex-wrap: wrap;
  }

  .vip-footer-menu li a {
    font-weight: 700;
    font-size: 16px;
    color: #E9E9EB;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .vip-footer-menu li a:hover {
    color: #5247FF;
  }

  .vip-images-col img {
    width: 37px;
    height: 37px;
  }

  .vip-divider {
    border-top: 1px solid #000000;
    margin: 0;
  }

  .vip-copyright-row .vip-copyright-col {
    text-align: left; /* چپ‌چین (در RTL، راست‌چین می‌شه) */
    flex: 1;
  }

  .vip-copyright-col p {
    font-weight: 400;
    font-size: 16px;
    color: #B8B8BC;
    margin: 0;
  }

  .vip-icons-col {
    display: flex;
    justify-content: flex-start;
    gap: 10px;
    flex: 1;
  }

  .vip-icons-col img {
    width: 24px;
    height: 24px;
  }

  /* موبایل */
  @media (max-width: 768px) {
    .vip-footer-row {
      flex-direction: column;
      gap: 20px;
      text-align: center;
    }

    .vip-footer-row .vip-footer-col {
      flex: none;
      width: 100%;
      padding-bottom: 8px;
    }
    
    .vip-footer-row .vip-footer-col.vip-images-col {
      justify-content: center;
    }
    
    .vip-copyright-col p {
      font-size: 14px;
    }
    
    .vip-copyright-row .vip-copyright-col {
      text-align: center;
    }

    .vip-footer-menu {
      gap: 20px;
      flex-direction: column;
    }

    .vip-images-col,
    .vip-icons-col {
      justify-content: center;
    }

    .vip-copyright-col {
      text-align: center;
    }
  }
</style>

<footer class="vip-footer">
  <div class="vip-footer-container">
    <!-- ردیف اول -->
    <div class="vip-footer-row">
      <div class="vip-footer-col vip-logo-col">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/6toFit_logotype_white_2.svg" alt="لوگوی 6tofit">
      </div>
      <div class="vip-footer-col vip-menu-col">
        <?php wp_nav_menu( array(
          'theme_location' => 'footer',
          'container' => false,
          'menu_class' => 'vip-footer-menu',
          'items_wrap' => '<ul class="%2$s">%3$s</ul>',
          'fallback_cb' => false,
        ) ); ?>
      </div>
      <div class="vip-footer-col vip-images-col">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/prico.png" alt="تصویر 1">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/enemad.png" alt="تصویر 2">
      </div>
    </div>

    <!-- خط جداکننده -->
    <hr class="vip-divider">

    <!-- ردیف دوم -->
    <div class="vip-footer-row vip-copyright-row">
      <div class="vip-footer-col vip-icons-col">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/Whatsappvipfoot.svg" alt="آیکن 1">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/Instagramvipfoot.svg" alt="آیکن 2">
      </div>
      <div class="vip-footer-col vip-copyright-col">
        <p>۱۴۰۵ تمامی حقوق این سایت برای سیکس تو فیت محفوظ است.</p>
      </div>
    </div>
  </div>
</footer>