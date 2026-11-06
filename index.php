<?php get_header(); ?>

<main id="main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
    else :
        echo '<p>مطلبی یافت نشد.</p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>
