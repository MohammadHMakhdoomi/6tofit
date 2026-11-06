<?php
/* Template Name: آرشیو سوالات متداول */
get_header('light'); ?>

<style>
body{
	 background-color: #FFFFFF;
}
  .faq-archive-section {
    width: 100%;
    padding: 80px 0;
   
	margin-top: 80px;
  }

  .faq-archive-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
    text-align: center;
  }

  .faq-archive-title {
    font-size: 36px;
    font-weight: 500;
    color: #161618;
    margin: 0 0 15px 0;
    line-height: 1.2;
  }

  .faq-archive-subtitle {
    font-size: 20px;
    font-weight: 400;
    color: #65656D;
    margin: 0;
    line-height: 1.5;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
	font-family:'iranyekanen';
  }

  .faq-cards-section {
    width: 100%;
   padding: 40px 0 80px 0;
    background-color: #FFFFFF;
  }

  .faq-cards-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .faq-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #0000001F;
    margin-bottom: 20px;
    text-decoration: none;
    transition: background-color 0.3s ease;
    direction: rtl;
  }

  .faq-card:hover {
    background-color: #f9f9f9;
  }

  .faq-card-image {
   display: flex;
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
	justify-content: center;
	align-items: center;
  }

  .faq-card-image img {
    width: 40px;
    height: 40px;
    object-fit: cover;
  }

  .faq-card-content {
    flex: 1;
    padding: 0 20px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .faq-card-title {
    font-size: 16px;
    font-weight: 400;
    color: #161618;
    margin: 0 0 5px 0;
    line-height: 1.3;
  }

  .faq-card-excerpt {
    font-size: 12px;
    font-weight: 400;
    color: #65656D;
    margin: 0;
    line-height: 1.4;
  }

  .faq-card-icon {
    flex: 0 0 auto;
    width: 24px;
    height: 24px;
  }

  .faq-card-icon img {
    width: 100%;
    height: 100%;
  }

  /* موبایل */
  @media (max-width: 768px) {
    .faq-archive-section,
    .faq-cards-section {
      padding: 40px 0;
    }
.faq-card-image {
    width: 40px;
    height: 40px;
}
    .faq-archive-title {
      font-size: 28px;
    }

    .faq-archive-subtitle {
      font-size: 18px;
    }

    .faq-card {
     display: flex;
   width: fit-content;
      gap: 10px;
	  align-content: center
    }

    .faq-card-content {
      padding: 0;
      width: 100%;
    }

    .faq-card-title {
      font-size: 14px;
    }

    .faq-card-excerpt {
      font-size: 12px;
    }
  }
</style>

<!-- سکشن اول: عنوان -->
<section class="faq-archive-section">
  <div class="faq-archive-container">
    <h1 class="faq-archive-title">سوالات متداول</h1>
    <p class="faq-archive-subtitle">سوالات پرتکراری که کاربران از ما می‌پرسن، به همراه پاسخ‌ها و راهنمایی‌های تیم تخصصی 6tofit اینجا جمع‌آوری شده است</p>
  </div>
</section>

<!-- سکشن دوم: کارت‌های FAQ -->
<section class="faq-cards-section">
  <div class="faq-cards-container">
    <?php
    $faq_query = new WP_Query( array(
      'post_type' => 'faq',
      'posts_per_page' => -1,
      'post_status' => 'publish',
      'orderby' => 'date',
      'order' => 'ASC'  // از قدیمی‌ترین به جدیدترین
    ) );

    if ( $faq_query->have_posts() ) :
      while ( $faq_query->have_posts() ) : $faq_query->the_post();
        $permalink = get_permalink();
        $title = get_the_title();
        $excerpt = get_the_excerpt();
        $thumbnail = get_the_post_thumbnail( null, 'full', array( 'class' => 'faq-card-image-img' ) );
    ?>
        <a href="<?php echo esc_url( $permalink ); ?>" class="faq-card">
          <?php if ( $thumbnail ) : ?>
            <div class="faq-card-image">
              <?php echo $thumbnail; ?>
            </div>
          <?php endif; ?>
          <div class="faq-card-content">
            <h3 class="faq-card-title"><?php echo esc_html( $title ); ?></h3>
            <p class="faq-card-excerpt"><?php echo esc_html( $excerpt ); ?></p>
          </div>
          <div class="faq-card-icon">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/ArrowLeftmenu.svg" alt="آیکون">
          </div>
        </a>
    <?php
      endwhile;
      wp_reset_postdata();
    else :
      echo '<p>هیچ سوالی یافت نشد.</p>';
    endif;
    ?>
  </div>
</section>

<?php get_footer(); ?>