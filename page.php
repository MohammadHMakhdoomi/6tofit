<?php
/**
 * Template Name: صفحه داخلی
 */

if (!defined('ABSPATH')) {
    exit;

}

get_header('product');
?>
<?php
$page_title = get_the_title();
?>
<style>
.site-page {
    width: 100%;
    direction: rtl;
}

.site-page-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.site-page-hero {
    width: 100%;
    padding: 80px 0 60px;
    text-align: center;
}

.site-page-title {
    margin: 0;
    color: #161618;
    font-size: 44px;
    font-weight: 500;
    line-height: 1.3;
    font-family: 'iranyekanen', sans-serif;
}

.site-page-content-section {
    width: 100%;
    padding: 40px 0 100px;
}

.site-page-content {
    width: 100%;

    margin: 0 auto;
    color: #161618;
    font-size: 17px;
    line-height: 2;
}

.site-page-content img {
    max-width: 100%;
    height: auto;
    border-radius: 24px;
}

.site-page-content a {
    color: inherit;
}

@media only screen and (max-width: 768px) {

    .site-page-container {
        padding: 0 15px;
    }

    .site-page-hero {
        padding: 45px 0 35px;
    }

    .site-page-title {
        font-size: 26px;
    }

    .site-page-content-section {
        padding: 25px 0 60px;
    }

    .site-page-content {
        font-size: 15px;
        line-height: 1.9;
    }

}
</style>

<main class="site-page">

    <section class="site-page-hero">
        <div class="site-page-container">
<div class="page-breadcrumb"> <!-- خانه --> <div class="page-breadcrumb-item"> <a href="<?php echo esc_url(home_url('/')); ?>"> خانه </a> <img src="http://6tofit.com/wp-content/uploads/2025/10/brudic.svg" alt="/" width="16" height="16" > </div> <!-- محصولات --> <div class="page-breadcrumb-item"> <a href="<?php echo esc_url(home_url('/products/')); ?>"> محصولات </a> <img src="http://6tofit.com/wp-content/uploads/2025/10/brudic.svg" alt="/" width="16" height="16" > </div> <!-- نام صفحه --> <div class="page-breadcrumb-item page-breadcrumb-current"> <span> <?php echo esc_html($page_title); ?> </span> </div> </div> <style> .page-breadcrumb { width: 80%; margin: 40px auto; display: flex; align-items: center; justify-content: flex-start; gap: 12px; direction: rtl; font-family: 'IranYekan', sans-serif; } .page-breadcrumb-item { display: flex; align-items: center; gap: 12px; } .page-breadcrumb-item a { color: #65656D; text-decoration: none; font-size: 16px; font-weight: 400; transition: color 0.3s ease; } .page-breadcrumb-item a:hover { color: #161618; } .page-breadcrumb-item img { width: 16px; height: 16px; object-fit: contain; flex-shrink: 0; } .page-breadcrumb-current span { color: #161618; font-size: 16px; font-weight: 400; } @media only screen and (max-width: 768px) { .page-breadcrumb { width: calc(100% - 30px); margin: 25px auto; gap: 8px; overflow: hidden; } .page-breadcrumb-item { gap: 8px; min-width: 0; } .page-breadcrumb-item a, .page-breadcrumb-current span { font-size: 14px; } .page-breadcrumb-item img { width: 14px; height: 14px; } } </style>
        </div>
    </section>

    <section class="site-page-content-section">
        <div class="site-page-container">

            <article class="site-page-content">

                <?php
                while (have_posts()) :
                    the_post();

                    the_content();

                endwhile;
                ?>

            </article>

        </div>
    </section>

</main>


<?php get_footer(); ?>