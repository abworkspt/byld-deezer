<?php /* Template Name: XXX */ ?>

<?php get_header(); ?>

<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        $pageid = get_the_ID();
    endwhile;
endif;
?>

<section id="page-XXX">
    
</section>

<?php get_footer(); ?>