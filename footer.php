<?php render_mytests_popup(); ?>
<?php render_questionnaire_popup(); ?>
<?php render_myprograms_popup(); ?>
<style>
  .footer {
    width: 100%;
    background-color: #F9F9FB;
    direction: rtl;
    font-family: 'Arial', sans-serif;
    color: #161618;
  }

  .footer-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .footer-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 0;
    flex-wrap: wrap;
  }

  .footer-row .footer-col {
    flex: 1;
  }

  .footer-row .footer-col.menu-col {
    flex: 2;
    text-align: center;
  }

  .footer-row .footer-col.logo-col {
    order: 1; /* در RTL، لوگو سمت راست */
  }

  .footer-row .footer-col.menu-col {
    order: 2;
  }

  .footer-row .footer-col.images-col {
    order: 3; /* سمت چپ */
    display: flex;
    justify-content: flex-end;
    gap: 10px;
  }

  .logo-col img {
    max-width: 78px; /* اندازه لوگو رو تنظیم کن */
    height: auto;
  }

  .footer-menu {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 40px;
    flex-wrap: wrap;
  }

  .footer-menu li a {
    font-weight: 700;
    font-size: 16px;
    color: #161618;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .footer-menu li a:hover {
    color: #5247FF;
  }

  .images-col img {
    width: 37px;
    height: 37px;
  }

  .divider {
    border-top: 1px solid #D1D1D1;
    margin: 0;
  }

  .copyright-row .copyright-col {
    text-align: left; /* چپ‌چین (در RTL، راست‌چین می‌شه) */
    flex: 1;
  }

  .copyright-col p {
    font-weight: 400;
    font-size: 16px;
    color: #65656D;
    margin: 0;
  }

  .icons-col {
    display: flex;
    justify-content: flex-start;
    gap: 10px;
    flex: 1;
  }

  .icons-col img {
    width: 24px;
    height: 24px;
  }

  /* موبایل */
  @media (max-width: 768px) {
    .footer-row {
      flex-direction: column;
      gap: 20px;
      text-align: center;
    }

    .footer-row .footer-col {
      flex: none;
      width: 100%;
	  padding-bottom: 8px;
    }
	.footer-row .footer-col.images-col{
justify-content: center;

	}
	.copyright-col p{
		font-size:14px;
	}
	.copyright-row .copyright-col {
		text-align:center;
}

    .footer-menu {
      gap: 20px;
	  flex-direction: column;
    }

    .images-col,
    .icons-col {
      justify-content: center;
    }

    .copyright-col {
      text-align: center;
    }
  }
</style>

<footer class="footer">
  <div class="footer-container">
    <!-- ردیف اول -->
    <div class="footer-row">
      <div class="footer-col logo-col">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/6toFit_logotype_Black_2.svg" alt="لوگوی 6tofit">
      </div>
      <div class="footer-col menu-col">
        <?php wp_nav_menu( array(
          'theme_location' => 'footer',
          'container' => false,
          'menu_class' => 'footer-menu',
          'items_wrap' => '<ul class="%2$s">%3$s</ul>',
          'fallback_cb' => false,
        ) ); ?>
      </div>
      <div class="footer-col images-col">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/prico.png" alt="تصویر 1">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/enemad.png" alt="تصویر 2">
      </div>
    </div>

    <!-- خط جداکننده -->
    <hr class="divider">

    <!-- ردیف دوم -->
    <div class="footer-row copyright-row">
	<div class="footer-col icons-col">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/whatfoot.svg" alt="آیکن 1">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/Instagramfoot.svg" alt="آیکن 2">
      </div>
      <div class="footer-col copyright-col">
        <p>۱۴۰۵ تمامی حقوق این سایت برای سیکس تو فیت محفوظ است.</p>
      </div>
      
    </div>
  </div>
</footer>
