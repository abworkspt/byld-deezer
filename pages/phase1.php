<?php /* Template Name: Phase 1 */ ?>

<?php get_header(); ?>

<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        $pageid = get_the_ID();
        $header_image = get_field('header_image', $pageid);
        $header_vw_logo = get_field('header_vw_logo', $pageid);
        $header_links = get_field('header_links', $pageid);
        $header_text_left = get_field('header_text_left', $pageid);
        $header_text_right = get_field('header_text_right', $pageid);
        $header_button_label = get_field('header_button_label', $pageid);
        $hader_event_date = get_field('hader_event_date', $pageid);
    endwhile;
endif;
?>

<section id="phase1">
    <section class="header">
        <div class="container">
            <div class="menu">
                <img class="logo" src="<?php echo $header_vw_logo['url']; ?>" />
                <?php if ($header_links) { ?>
                    <ul>
                        <?php foreach ($header_links as $item) { ?>
                            <li><a href="<?php echo $item['link']['url']; ?>"><?php echo $item['link']['title']; ?></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
            <img class="bg" src="<?php echo $header_image['url']; ?>" />
            <div class="info">
                <div class="l">
                    <p><?php echo $header_text_left; ?></p>
                </div>
                <div class="r">
                    <p><?php echo $header_text_right; ?></p>
                    <div class="countdown"><?php echo $hader_event_date; ?></div>
                    <a class="button" href="#"><?php echo $header_button_label; ?></a>
                </div>
            </div>
        </div>
    </section>
</section>

<?php get_footer(); ?>