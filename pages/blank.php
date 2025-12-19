<?php /* Template Name: Blank */ ?>

<?php get_header(); ?>

<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        $pageid = get_the_ID();
        $title = get_the_title($pageid);
        $header_links = get_field('header_links', $pageid);
        $page_title = get_field('page_title', $pageid);
        $general_dark_logo = get_field('general_dark_logo', 'option');

        $thetitle = $page_title ? $page_title : $title;
    endwhile;
endif;
?>

<section id="blank">
    <div class="container">
        <div class="menu">
            <img class="logo mobile" src="<?php echo $general_dark_logo['url']; ?>" />
            <?php if ($header_links) { ?>
                <ul>
                    <?php foreach ($header_links as $item) { ?>

                        <?php if ($item['link']['url'] == '#logo') { ?>
                            <li class="logoli">
                                <a href="<?php echo home_url(); ?>">
                                    <img class="logo" src="<?php echo $general_dark_logo['url']; ?>" />
                                </a>
                            </li>
                        <?php } else { ?>
                            <li><a target="<?php echo $item['link']['target']; ?>" class="<?php if ($item['link']['url'] == '#open-insc') { ?>js-insc-open<?php } ?>" href="<?php echo $item['link']['url']; ?>"><?php echo $item['link']['title']; ?></a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <h1><?php echo $thetitle; ?></h1>
        <?php echo the_field('content', $pageid); ?>
    </div>
</section>

<?php get_footer(); ?>