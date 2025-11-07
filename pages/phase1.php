<?php /* Template Name: Phase 1 */ ?>

<?php get_header(); ?>

<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        $pageid = get_the_ID();

        //HEADER
        $header_image = get_field('header_image', $pageid);
        $header_video = get_field('header_video', $pageid);
        $header_video_mobile = get_field('header_video_mobile', $pageid);
        $header_vw_logo = get_field('header_vw_logo', $pageid);
        $header_links = get_field('header_links', $pageid);
        $header_text_left = get_field('header_text_left', $pageid);
        $header_text_right = get_field('header_text_right', $pageid);
        $header_button_label = get_field('header_button_label', $pageid);
        $hader_event_date = get_field('hader_event_date', $pageid);

        //PUB1
        $pub1_background_image = get_field('pub1_background_image', $pageid);
        $pub1_background_image_mobile = get_field('pub1_background_image_mobile', $pageid);
        $pub1_text_left = get_field('pub1_text_left', $pageid);
        $pub1_text_right = get_field('pub1_text_right', $pageid);

        //INFO
        $info_title = get_field('info_title', $pageid);
        $info_text = get_field('info_text', $pageid);
        $info_button = get_field('info_button', $pageid);

        //PRIZES
        $prizes_title = get_field('prizes_title', $pageid);
        $prizes_items = get_field('prizes_items', $pageid);

        //HOW
        $how_image = get_field('how_image', $pageid);
        $how_image_mobile = get_field('how_image_mobile', $pageid);
        $how_title = get_field('how_title', $pageid);
        $how_button = get_field('how_button', $pageid);
        $how_info = get_field('how_info', $pageid);

        //PUB2
        $pub2_image = get_field('pub2_image', $pageid);
        $pub2_title = get_field('pub2_title', $pageid);
        $pub2_text = get_field('pub2_text', $pageid);
        $pub2_link = get_field('pub2_link', $pageid);

    endwhile;
endif;
?>

<section id="phase1" data-control="PHASE1">

    <section class="header">

        <div class="container">
            <div class="menu">
                <img class="logo mobile" src="<?php echo $header_vw_logo['url']; ?>" />
                <?php if ($header_links) { ?>
                    <ul>
                        <?php foreach ($header_links as $item) { ?>

                            <?php if ($item['link']['title'] == 'home') { ?>
                                <li class="logoli"><img class="logo" src="<?php echo $header_vw_logo['url']; ?>" /></li>
                            <?php } else { ?>
                                <li><a target="<?php echo $item['link']['target']; ?>" class="<?php if ($item['link']['url'] == '#open-insc') { ?>js-insc-open<?php } ?>" href="<?php echo $item['link']['url']; ?>"><?php echo $item['link']['title']; ?></a></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>

            <!--<div class="bg">
                <img class="image" src="<?php echo $header_image['url']; ?>" />
                <img class="spacer" src="<?php echo get_bloginfo('template_url'); ?>/images/hero_spacer.png" />
            </div>-->

            <div class="bg">
                <video class="desktop" preload="metadata" muted playsinline loop autoplay>
                    <source src="<?php echo $header_video['url'] ?>" type="video/mp4">
                </video>
                <video class="mobile" preload="metadata" muted playsinline loop autoplay>
                    <source src="<?php echo $header_video_mobile['url'] ?>" type="video/mp4">
                </video>
            </div>

            <div class="infoh">
                <div class="l">
                    <p><?php echo $header_text_left; ?></p>
                </div>
                <div class="r">
                    <p><?php echo $header_text_right; ?></p>
                    <div class="countdown" data-date="<?php echo $hader_event_date; ?>"></div>
                    <a class="button js-insc-open" href="#"><?php echo $header_button_label; ?></a>
                </div>
            </div>
        </div>
    </section>

    <div data-speed="0.9">
        <section id="nouveau-t-roc" class="pub1">
            <div class="container">
                <img class="bg" src="<?php echo $pub1_background_image['url']; ?>" alt="" />
                <img class="bg mobile" src="<?php echo $pub1_background_image_mobile['url']; ?>" alt="" />
                <div class="text">
                    <div class="l"><?php echo $pub1_text_left; ?></div>
                    <div class="r"><?php echo $pub1_text_right; ?></div>
                </div>
            </div>
        </section>

        <section class="info">
            <div class="container">
                <div class="l"><?php echo $info_title; ?></div>
                <div class="r">
                    <div class="text">
                        <?php echo $info_text; ?>
                    </div>
                    <a class="button invert js-insc-open" href="#"><?php echo $info_button; ?></a>
                </div>
            </div>

            <div class="line"></div>
        </section>

        <section class="prizes">
            <div class="container">
                <h2><?php echo $prizes_title; ?></h2>
                <div class="items">
                    <?php foreach ($prizes_items as $item) { ?>
                        <div class="item">
                            <img src="<?php echo $item['image']['url']; ?>" alt="" />
                            <p><?php echo $item['text']; ?></p>
                            <h3><?php echo $item['title']; ?></h3>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </section>
    </div>

    <div data-speed="1.2">
        <section id="how" class="how">
            <div class="bg">
                <img src="<?php echo $how_image['url']; ?>" alt="" />
                <img class="mobile" src="<?php echo $how_image_mobile['url']; ?>" alt="" />
            </div>

            <div class="container">
                <div class="top">
                    <h2><?php echo $how_title; ?></h2>
                </div>
                <div class="bot">
                    <div class="infos">
                        <?php foreach ($how_info as $info) { ?>
                            <div class="infohow">
                                <h3><?php echo $info['title']; ?></h3>
                                <p><?php echo $info['text']; ?></p>
                            </div>
                        <?php } ?>
                    </div>
                    <a class="button js-insc-open"><?php echo $how_button; ?></a>
                </div>
            </div>
        </section>

        <section class="pub2">
            <div class="container">
                <img src="<?php echo $pub2_image['url']; ?>" alt="" />
                <div class="content">
                    <h2><?php echo $pub2_title; ?></h2>
                    <div class="text">
                        <?php echo $pub2_text; ?>
                        <?php if ($pub2_link) { ?>
                            <div class="buttoncontainer">
                                <a class="button invert white" href="<?php echo $pub2_link['url']; ?>" target="<?php echo $pub2_link['target']; ?>">
                                    <?php echo $pub2_link['title']; ?>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>-
    </div>

</section>

<?php get_footer(); ?>