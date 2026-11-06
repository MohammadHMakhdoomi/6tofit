<?php
/* Template Name: صفحه تک سوال متداول */
get_header('light'); ?>

<style>
body {
    background-color: #FFFFFF;
	min-height:100vh;
}
.faq-main{
	min-height: 100dvh;
}
.breadcrumb-section {
    width: 100%;
    padding: 20px 0;
    background-color: #FFFFFF;
    margin-top: 110px;
}
.breadcrumb-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    direction: rtl;
    display: flex;
    align-items: center;
    gap: 10px;
}
.breadcrumb-text {
    color: #65656D;
    font-weight: 400;
    font-size: 16px;
    margin: 0;
}
.breadcrumb-icon {
    width: 16px;
    height: 16px;
}
.breadcrumb-icon img {
    width: 100%;
    height: 100%;
}
.post-title-breadcrumb {
    color: #161618;
    font-weight: 400;
    font-size: 16px;
    margin: 0;
}
.post-header-section {
    width: 100%;
    padding: 80px 0;
    background-color: #FFFFFF;
    text-align: center;
}
.post-header-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
.post-title {
    font-size: 36px;
    font-weight: 500;
    color: #161618;
    margin: 0 0 20px 0;
    line-height: 1.2;
}
.post-excerpt {
    font-size: 20px;
    font-weight: 400;
    color: #161618;
    margin: 0;
    line-height: 1.5;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}
.faq-accordion-section {
    width: 100%;
   padding: 40px 0 80px 0;
    background-color: #FFFFFF;
}
.faq-accordion-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    border: 1px solid #0000001F;
    border-radius: 12px;
    padding: 16px;
}
.faq-question {
    margin-bottom: 0;
    padding-bottom: 15px;
}
.faq-question:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.faq-question-header {
    display: flex;
	
    padding: 10px 0;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    direction: rtl;
}
.faq-question-title {
    font-size: 16px;
    font-weight: 400;
    color: #161618;
    margin: 0;
    flex: 1;
    text-align: right;
}
.faq-question h3 {
    border: none;
}
.faq-question-icon {
    width: 20px;
    height: 20px;
    transition: transform 0.3s ease;
}
.faq-question-icon img {
    width: 100%;
    height: 100%;
}
.faq-question-icon.open {
    transform: rotate(180deg);
}
.faq-answer {
    margin-top: 15px;
    font-size: 16px;
    font-weight: 400;
    color: #65656D;
    line-height: 1.5;
    display: none;
    padding: 0px;
    background: #ffffff;
}
.faq-answer.active {
    display: block;
}
@media (max-width: 768px) {
    .breadcrumb-section,
    .post-header-section,
    .faq-accordion-section {
        padding: 40px 0;
    }
	.breadcrumb-section{
		display:none;
	}
	.post-header-container {
margin-top: 50px;
}

	.faq-accordion-section{
		margin-bottom:30px;
		padding-top:0px;
	}
    .post-title {
        font-size: 28px;
    }
    .post-excerpt {
        font-size: 18px;
    }
    .breadcrumb-container {
        flex-wrap: wrap;
        gap: 5px;
    }
    .faq-question-title {
        font-size: 14px;
    }
    .faq-answer {
        font-size: 14px;
    }
}
.breadcrumb-container a {
    text-decoration: none;
}
</style>
<main class="faq-main">
<!-- سکشن اول: Bread Crumb -->
<section class="breadcrumb-section">
    <div class="breadcrumb-container">
        <a href="https://6tofit.com/faq/">
            <p class="breadcrumb-text">سوالات متداول</p>
        </a>
        <div class="breadcrumb-icon">
            <img src="http://6tofit.com/wp-content/uploads/2025/10/brudic.svg" alt="آیکون">
        </div>
        <h2 class="post-title-breadcrumb"><?php the_title(); ?></h2>
    </div>
</section>

<!-- سکشن دوم: عنوان و خلاصه پست -->
<section class="post-header-section">
    <div class="post-header-container">
        <h1 class="post-title"><?php the_title(); ?></h1>
        <?php if ( $excerpt = get_the_excerpt() ) : ?>
            <p class="post-excerpt"><?php echo esc_html( $excerpt ); ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- سکشن سوم: آکاردئون سوالات -->
<section class="faq-accordion-section">
    <div class="faq-accordion-container">
        <?php
        $faq_questions = get_post_meta( get_the_ID(), '_faq_questions', true );
        $faq_questions = is_array( $faq_questions ) ? $faq_questions : array();

        if ( ! empty( $faq_questions ) ) :
            $first = true;
            foreach ( $faq_questions as $question ) :
        ?>
            <div class="faq-question">
                <div class="faq-question-header">
                    <h3 class="faq-question-title"><?php echo esc_html( $question['question'] ); ?></h3>
                    <div class="faq-question-icon<?php echo $first ? ' open' : ''; ?>">
                        <img src="http://6tofit.com/wp-content/uploads/2025/10/Faqop.svg" alt="آیکون باز/بسته">
                    </div>
                </div>
                <div class="faq-answer<?php echo $first ? ' active' : ''; ?>">
                    <?php echo wp_kses_post( $question['answer'] ); ?>
                </div>
            </div>
        <?php
            $first = false;
            endforeach;
        else :
            echo '<p>هیچ سوالی برای این بخش تعریف نشده است.</p>';
        endif;
        ?>
    </div>
</section>
</main>
<script>
jQuery(document).ready(function($) {
    $('.faq-question-header').on('click', function() {
        var $question = $(this).closest('.faq-question');
        var $answer = $question.find('.faq-answer');
        var $icon = $question.find('.faq-question-icon');

        // Close all other open FAQs
        $('.faq-answer').not($answer).removeClass('active');
        $('.faq-question-icon').not($icon).removeClass('open');

        // Toggle the clicked FAQ
        $answer.toggleClass('active');
        $icon.toggleClass('open');
    });
});
</script>

<?php get_footer(); ?>