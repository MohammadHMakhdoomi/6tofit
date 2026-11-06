<?php
/**
 * Template Name: نوشته تکی
 * Template Post Type: post
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header('blog');
?>
<?php
$post_title = get_the_title();
?>
<style>
.single-post-page {
    width: 100%;
    direction: rtl;
}

.single-post-container {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}

.single-post-hero {
    width: 100%;
    padding: 80px 0 60px;
    text-align: center;
}

.single-post-title {
    margin: 0;
    color: #161618;
    font-size: 44px;
    font-weight: 500;
    line-height: 1.3;
    font-family: 'iranyekanen', sans-serif;
}

.single-post-content-section {
    width: 100%;
    padding: 40px 0 100px;
}

.single-post-content {
    width: 100%;
    margin: 0 auto;
    color: #161618;
    font-size: 17px;
    line-height: 2;
	    margin-top: 18px;
}

.single-post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 24px;
}

.single-post-content a {
    color: inherit;
}
.single-post-containerbr {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

@media only screen and (max-width: 768px) {

    .single-post-container {
        padding: 0 15px;
    }

    .single-post-hero {
        padding: 45px 0 35px;
    }

    .single-post-title {
        font-size: 26px;
    }

    .single-post-content-section {
        padding: 25px 0 60px;
    }

    .single-post-content {
        font-size: 15px;
        line-height: 1.9;
    }

}
</style>

<main class="single-post-page">

    <section class="single-post-hero">
        <div class="single-post-containerbr">
            <div class="single-post-breadcrumb">
                <!-- بلاگ -->
                <div class="single-post-breadcrumb-item">
                    <a href="<?php echo esc_url(home_url('/blog/')); ?>">بلاگ</a>
                    <img src="http://6tofit.com/wp-content/uploads/2025/10/brudic.svg" alt="/" width="16" height="16">
                </div>
                <!-- نام مقاله -->
                <div class="single-post-breadcrumb-item single-post-breadcrumb-current">
                    <span><?php echo esc_html($post_title); ?></span>
                </div>
            </div>

            <style>
            .single-post-breadcrumb {
                width: 80%;
                margin: 40px 0;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                gap: 12px;
                direction: rtl;
                font-family: 'IranYekan', sans-serif;
            }

            .single-post-breadcrumb-item {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .single-post-breadcrumb-item a {
                color: #65656D;
                text-decoration: none;
                font-size: 16px;
                font-weight: 400;
                transition: color 0.3s ease;
            }

            .single-post-breadcrumb-item a:hover {
                color: #161618;
            }

            .single-post-breadcrumb-item img {
                width: 16px;
                height: 16px;
                object-fit: contain;
                flex-shrink: 0;
            }

            .single-post-breadcrumb-current span {
                color: #161618;
                font-size: 16px;
                font-weight: 400;
            }

            @media only screen and (max-width: 768px) {
                .single-post-breadcrumb {
                    width: calc(100% - 30px);
                    margin: 25px auto;
                    gap: 8px;
                    overflow: hidden;
					display: none;
                }

                .single-post-breadcrumb-item {
                    gap: 8px;
                    min-width: 0;
                }

                .single-post-breadcrumb-item a,
                .single-post-breadcrumb-current span {
                    font-size: 14px;
                }

                .single-post-breadcrumb-item img {
                    width: 14px;
                    height: 14px;
                }
            }
            </style>
        </div>
    </section>

    <section class="single-post-content-section">
        <div class="single-post-container">
<!-- سکشن دسته‌بندی‌های مقاله -->
<style>
.single-post-categories-section {
    width: 100%;
    padding: 0 0 40px;
    direction: rtl;
}

.single-post-categories-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;

}

.single-post-categories-list {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: flex-start;
    gap: 10px;
    width: fit-content;
}

.blog-post-category {
    display: flex;
    align-items: center;
    width: fit-content;
    background-color: var(--cat-color, #000000);
    border-radius: 100px;
    padding: 8px 16px;
    color: #FFFFFF;
    font-size: 16px;
    font-weight: 400;
}

.blog-post-category-icon {
    width: 20px;
    height: 20px;
    margin-left: 8px;
    object-fit: contain;
}

.blog-post-category-name {
    margin: 0;
    line-height: 1;
}

@media only screen and (max-width: 768px) {
	.single-post-categories-section{
		margin-top: 30px;
	}
    .single-post-categories-container {
        padding: 0 15px;
    }

    .single-post-categories-list {
        gap: 8px;
    }

    .blog-post-category {
        padding: 6px 14px;
        font-size: 14px;
    }

    .blog-post-category-icon {
        width: 18px;
        height: 18px;
        margin-left: 6px;
    }
}
</style>

<section class="single-post-categories-section">
    <div class="single-post-categories-container">
        <div class="single-post-categories-list">
            <?php
            $categories = get_the_category();
            if (!empty($categories)) :
                foreach ($categories as $category) :
                    $term_id  = $category->term_id;
                    $icon     = get_term_meta($term_id, 'category_icon', true);
                    $color    = get_term_meta($term_id, 'category_color', true);
                    $cat_name = $category->name;

                    if (empty($color)) {
                        $color = '#000000';
                    }
            ?>
                <div class="blog-post-category" style="background-color: <?php echo esc_attr($color); ?>;">
                    <?php if ($icon) : ?>
                        <img src="<?php echo esc_url($icon); ?>" 
                             alt="<?php echo esc_attr($cat_name); ?>" 
                             class="blog-post-category-icon">
                    <?php endif; ?>
                    <span class="blog-post-category-name"><?php echo esc_html($cat_name); ?></span>
                </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
<!-- سکشن عنوان مقاله -->
<style>
.single-post-title-section {
    width: 100%;
    padding: 0 0 40px;
    direction: rtl;
}

.single-post-title-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;

}

.single-post-main-title {
    margin: 0;
    color: #191919;
    font-size: 36px;
    font-weight: 500;
    line-height: 1.4;
    font-family: 'iranyekanen', sans-serif;
}

@media only screen and (max-width: 768px) {
    .single-post-title-container {
        padding: 0 15px;
    }

    .single-post-main-title {
        font-size: 20px;
    }
}
.wp-block-list{
	    padding-right: 50px;
}
</style>

<section class="single-post-title-section">
    <div class="single-post-title-container">
        <h1 class="single-post-main-title"><?php the_title(); ?></h1>
    </div>
</section>

<!-- سکشن مقدمه مقاله -->
<style>
.single-post-intro-section {
    width: 100%;
    padding: 0 0 40px;
    direction: rtl;
}

.single-post-intro-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.single-post-intro-text {
    margin: 0;

}

@media only screen and (max-width: 768px) {
    .single-post-intro-container {
        padding: 0 15px;
    }


}
</style>

<section id="description"  class="single-post-intro-section">
    <div class="single-post-intro-container">
        <?php
        $article_intro = get_post_meta(get_the_ID(), '_mytheme_article_navigation_intro', true);
        if (!empty($article_intro)) :
        ?>
            <p class="single-post-intro-text">
                مقدمه: <?php echo esc_html($article_intro); ?>
            </p>
        <?php endif; ?>
    </div>
</section>
<!-- سکشن تصویر شاخص -->
<style>
.single-post-thumbnail-section {
    width: 100%;

    direction: rtl;
}

.single-post-thumbnail-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
 
}

.single-post-thumbnail {
    width: 100%;

    border-radius: 24px;
    display: block;
    object-fit: cover;
}
.wp-block-paragraph{
    padding: 0 20px;

}
.wp-block-heading{
  padding: 0 20px;	
}

@media only screen and (max-width: 768px) {
    .single-post-thumbnail-container {
        padding: 0 15px;
    }

    .single-post-thumbnail {
        border-radius: 16px;
    }
}
</style>

<section class="single-post-thumbnail-section">
    <div class="single-post-thumbnail-container">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('full', [
                'class' => 'single-post-thumbnail',
                'alt'   => get_the_title()
            ]); ?>
        <?php endif; ?>
    </div>
</section>
            <article class="single-post-content">

                <?php
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
                ?>

            </article>
			<!-- سکشن برچسب‌های مقاله -->
<style>
.single-post-tags-section {
    width: 100%;
    padding: 40px 0 40px;
    direction: rtl;
}

.single-post-tags-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.single-post-tags-title {
    margin: 0 0 16px;
    color: #191919;
    font-size: 24px;
    font-weight: 500;
    text-align: right;
    font-family: 'iranyekanen', sans-serif;
}

.single-post-tags-list {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: flex-start;
    gap: 8px;
}

.single-post-tag {
    display: inline-flex;
    align-items: center;
    background-color: #F0F0F1;
    border-radius: 1000000px;
    padding: 6px 12px;
    color: #161618;
    font-size: 14px;
    font-weight: 400;
    text-decoration: none;
    transition: background-color 0.2s ease;
}

.single-post-tag:hover {
    background-color: #E4E4E5;
}

@media only screen and (max-width: 768px) {
    .single-post-tags-container {
        padding: 0 15px;
    }

    .single-post-tags-title {
        font-size: 20px;
        margin-bottom: 12px;
    }

    .single-post-tag {
        font-size: 13px;
        padding: 5px 10px;
    }
}
</style>

<?php
$post_tags = get_the_tags();
if ($post_tags) :
?>
<section class="single-post-tags-section">
    <div class="single-post-tags-container">
        <h3 class="single-post-tags-title">برچسب ها</h3>
        <div class="single-post-tags-list">
            <?php foreach ($post_tags as $tag) : ?>
                <p  class="single-post-tag">
                    <?php echo esc_html($tag->name); ?>
                </p>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- سکشن اشتراک‌گذاری -->
<style>
.single-post-share-section {
    width: 100%;
    padding: 0 0 40px;
    direction: rtl;
}

.single-post-share-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.single-post-share-title {
    margin: 0 0 16px;
    color: #191919;
    font-size: 24px;
    font-weight: 500;
    text-align: right;
    font-family: 'iranyekanen', sans-serif;
}

.single-post-share-list {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 12px;
}

.single-post-share-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background-color: #ffffff;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s ease, transform 0.2s ease;
    padding: 0;
    text-decoration: none;
}

.single-post-share-btn:hover {

    transform: scale(1.05);
}

.single-post-share-btn img {
    width: 22px;
    height: 22px;
    object-fit: contain;
}

/* پیام کپی شدن */
.single-post-copy-toast {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%) translateY(20px);
    background-color: #191919;
    color: #fff;
    padding: 12px 24px;
    border-radius: 100px;
    font-size: 14px;
    font-weight: 400;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 9999;
    direction: rtl;
}

.single-post-copy-toast.show {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0);
}

@media only screen and (max-width: 768px) {
    .single-post-share-container {
        padding: 0 15px;
    }

    .single-post-share-title {
        font-size: 20px;
        margin-bottom: 12px;
    }

    .single-post-share-btn {
        width: 44px;
        height: 44px;
    }

    .single-post-share-btn img {
        width: 20px;
        height: 20px;
    }
}
</style>

<section class="single-post-share-section">
    <div class="single-post-share-container">
        <h3 class="single-post-share-title">اشتراک گذاری مقاله</h3>

        <div class="single-post-share-list">

            <!-- کپی لینک -->
            <button type="button" class="single-post-share-btn" id="copy-post-link" title="کپی لینک">
                <img src="http://6tofit.com/wp-content/uploads/2026/09/Link-Iconly-Pro.png" alt="کپی لینک"> 
            </button>

            <!-- تلگرام -->
            <a href="https://t.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
               class="single-post-share-btn" 
               target="_blank" 
               rel="noopener noreferrer"
               title="اشتراک در تلگرام">
                <img src="http://6tofit.com/wp-content/uploads/2026/09/Telegram-Iconly-Pro.png" alt="تلگرام"> <!-- آدرس آیکون خودت رو بذار -->
            </a>

            <!-- واتساپ -->
            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" 
               class="single-post-share-btn" 
               target="_blank" 
               rel="noopener noreferrer"
               title="اشتراک در واتساپ">
                <img src="http://6tofit.com/wp-content/uploads/2026/09/Whatsapp-Iconly-Pro.png" alt="واتساپ"> <!-- آدرس آیکون خودت رو بذار -->
            </a>

        </div>
    </div>
</section>

<!-- پیام کپی شدن -->
<div class="single-post-copy-toast" id="copy-toast">لینک کپی شد</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const copyBtn = document.getElementById('copy-post-link');
    const toast = document.getElementById('copy-toast');

    // لینک کوتاه وردپرس (مثلاً https://site.com/?p=123)
    const shortLink = '<?php echo esc_js(wp_get_shortlink()); ?>';

    if (copyBtn) {
        copyBtn.addEventListener('click', function () {
            navigator.clipboard.writeText(shortLink).then(function () {
                // نمایش پیام
                toast.classList.add('show');

                setTimeout(function () {
                    toast.classList.remove('show');
                }, 2000);
            }).catch(function () {
                // روش جایگزین در صورت عدم پشتیبانی
                const tempInput = document.createElement('input');
                tempInput.value = shortLink;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);

                toast.classList.add('show');
                setTimeout(function () {
                    toast.classList.remove('show');
                }, 2000);
            });
        });
    }
});
</script>



        </div>
    </section>
<!-- سکشن بلاگ‌های مشابه -->
<style>
.blog-related-section {
    width: 100%;
    padding: 100px 0;
    direction: rtl;
	    background-color: #F7F7F8;
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
    width: calc(100% + 20px);
    padding-right: 50px;
}

.blog-post-title a {
    text-align: right;
    font-size: 24px;
    font-weight: 500;
    color: #191919;
    margin: 0;
    line-height: 1.3;
    text-decoration: none;
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
    background-color: var(--cat-color, #000000);
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

.carousel-prev-next {
    display: flex;
    margin-top: 50px;
    flex-direction: row-reverse;
    padding-left: 100px;
    justify-content: flex-start;
    gap: 24px;
}

/* Mobile */
@media only screen and (max-width: 768px) {
    .blog-related-section {
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

<section id="similararticles" class="blog-related-section">
    <div class="blog-container">
        <div class="blog-title">
            <h2>بلاگ‌های مشابه</h2>
        </div>
        <div class="carousel-container">
            <div class="carousel" id="blogRelatedCarousel">
                <?php
                $current_post_id = get_the_ID();
                $current_categories = get_the_category($current_post_id);
                $category_ids = array();

                if (!empty($current_categories)) {
                    foreach ($current_categories as $cat) {
                        $category_ids[] = $cat->term_id;
                    }
                }

                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                    'post__not_in'   => array($current_post_id), // جلوگیری از نمایش پست فعلی
                );

                if (!empty($category_ids)) {
                    $args['category__in'] = $category_ids;
                }

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
                <button class="carousel-prev" onclick="moveRelatedBlogSlide(-1)">
                    <img src="http://6tofit.com/wp-content/uploads/2025/10/IconButtonL.svg" alt="Previous">
                </button>
                <button class="carousel-next" onclick="moveRelatedBlogSlide(1)">
                    <img src="http://6tofit.com/wp-content/uploads/2025/10/IconButtonR.svg" alt="Next">
                </button>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('blogRelatedCarousel');
    const prevButton = document.querySelector('.carousel-prev');
    const nextButton = document.querySelector('.carousel-next');
    let currentBlog = 0;
    const cards = carousel.querySelectorAll('.blog-card');
    const cardWidth = cards[0] ? cards[0].offsetWidth + 20 : 320;

    function moveRelatedBlogSlide(direction) {
        currentBlog += direction;
        const maxSlide = Math.max(0, cards.length - Math.floor(carousel.parentElement.offsetWidth / cardWidth));
        currentBlog = Math.max(0, Math.min(currentBlog, maxSlide));
        carousel.style.transform = `translateX(${currentBlog * cardWidth}px)`;
    }

    if (prevButton) {
        prevButton.addEventListener('click', () => moveRelatedBlogSlide(1));
    }
    if (nextButton) {
        nextButton.addEventListener('click', () => moveRelatedBlogSlide(-1));
    }

    // Touch/Swipe
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
            moveRelatedBlogSlide(diff > 0 ? -1 : 1);
            isDragging = false;
        }
    });

    carousel.addEventListener('touchend', () => {
        isDragging = false;
    });
});
</script>


<!-- سکشن خبرنامه -->
<style>
.single-post-newsletter-section {
    width: 100%;
    background-color: #FFFFFF;
    padding: 80px 0;
    direction: rtl;
}

.single-post-newsletter-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.single-post-newsletter-icon {
    width: 64px;
    height: 64px;
    margin-bottom: 24px;
    object-fit: contain;
}

.single-post-newsletter-title {
    margin: 0 0 16px;
    color: #161618;
    font-size: 30px;
    font-weight: 500;
    line-height: 1.4;
    font-family: 'iranyekanen', sans-serif;
}

.single-post-newsletter-desc {
    margin: 0 0 32px;
    color: #65656D;
    font-size: 24px;
    font-weight: 400;
    line-height: 1.6;
    max-width: 700px;
}

.single-post-newsletter-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    max-width: 328px;
}

.single-post-newsletter-input {
    width: 100%;
    max-width: 328px;
    height: 48px;
    background-color: #FFFFFF;
    border: 1px solid rgba(0, 0, 0, 0.12); /* #0000001F */
    border-radius: 100000px;
    padding: 0 20px;
    font-size: 16px;
    color: #161618;
    outline: none;
    direction: rtl;
    text-align: right;
    margin-bottom: 16px;
    transition: border-color 0.2s ease;
}

.single-post-newsletter-input::placeholder {
    color: #161618;
    opacity: 1;
}

.single-post-newsletter-input:focus {
    border-color: #161618;
}

.single-post-newsletter-btn {
    width: 100%;
    max-width: 328px;
    background-color: #E9E9EB;
    border: none;
    border-radius: 100000px;
    padding: 12px 10px;
    color: #9B9BA1;
    font-size: 18px;
    font-weight: 400;
    cursor: pointer;
    transition: background-color 0.2s ease, color 0.2s ease;
}

.single-post-newsletter-btn:hover {
    background-color: #DCDCE0;
    color: #161618;
}

.single-post-newsletter-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.single-post-newsletter-message {
    margin-top: 16px;
    font-size: 14px;
    font-weight: 400;
    display: none;
}

.single-post-newsletter-message.success {
    color: #16a34a;
    display: block;
}

.single-post-newsletter-message.error {
    color: #dc2626;
    display: block;
}

@media only screen and (max-width: 768px) {
    .single-post-newsletter-section {
        padding: 50px 0;
    }

    .single-post-newsletter-container {
        padding: 0 15px;
    }

    .single-post-newsletter-title {
        font-size: 24px;
    }

    .single-post-newsletter-desc {
        font-size: 18px;
        margin-bottom: 24px;
    }

    .single-post-newsletter-icon {
        width: 52px;
        height: 52px;
        margin-bottom: 20px;
    }
}
</style>

<section class="single-post-newsletter-section">
    <div class="single-post-newsletter-container">

        <!-- آیکون (آدرس تصویر خودت رو بذار) -->
        <img src="http://6tofit.com/wp-content/uploads/2026/09/📬-Open-Mailbox-With-Raised-Flag.png" alt="خبرنامه" class="single-post-newsletter-icon">

        <h2 class="single-post-newsletter-title">به باشگاه محتوای 6tofit بپیوندید</h2>

        <p class="single-post-newsletter-desc">
            اولین نفری باش که مقاله‌های تخصصی، تمرین‌های کاربردی و نکات رژیمی 6tofit رو می‌خونه.
        </p>

        <form class="single-post-newsletter-form" id="newsletterForm">
            <input 
                type="email" 
                name="email" 
                id="newsletterEmail" 
                class="single-post-newsletter-input" 
                placeholder="ایمیل" 
                required
                autocomplete="email"
            >

            <button type="submit" class="single-post-newsletter-btn" id="newsletterBtn">
                عضویت در خبر نامه
            </button>

            <div class="single-post-newsletter-message" id="newsletterMessage"></div>
        </form>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('newsletterForm');
    const emailInput = document.getElementById('newsletterEmail');
    const btn = document.getElementById('newsletterBtn');
    const message = document.getElementById('newsletterMessage');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const email = emailInput.value.trim();

        if (!email) {
            showMessage('لطفاً ایمیل را وارد کنید', 'error');
            return;
        }

        btn.disabled = true;
        btn.textContent = 'در حال ارسال...';

        const formData = new FormData();
        formData.append('action', 'newsletter_subscribe');
        formData.append('email', email);
        formData.append('nonce', '<?php echo wp_create_nonce("newsletter_subscribe_nonce"); ?>');

        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.data.message || 'با موفقیت عضو شدید!', 'success');
                emailInput.value = '';
            } else {
                showMessage(data.data.message || 'خطایی رخ داد', 'error');
            }
        })
        .catch(() => {
            showMessage('خطا در ارتباط با سرور', 'error');
        })
        .finally(() => {
            btn.disabled = false;
            btn.textContent = 'عضویت در خبر نامه';
        });
    });

    function showMessage(text, type) {
        message.textContent = text;
        message.className = 'single-post-newsletter-message ' + type;
    }
});
</script>
</main>

<?php get_footer(); ?>