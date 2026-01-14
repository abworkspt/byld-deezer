<?php /* Template Name: Phase 2 */ ?>

<?php get_header(); ?>

<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        $pageid = get_the_ID();

        //HEADER
        $header_image = get_field('header_image', $pageid);
        $header_image_mobile = get_field('header_image_mobile', $pageid);
        $header_logo = get_field('header_logo', $pageid);
        $header_logo_mobile = get_field('header_logo_mobile', $pageid);
        $header_text = get_field('header_text', $pageid);
        $header_vw_logo = get_field('header_vw_logo', $pageid);
        $header_links = get_field('header_links', $pageid);
        $header_image_text = get_field('header_image_text', $pageid);
        $finish_date = get_field('finish_date', $pageid);

        //BANDS
        $bands_title = get_field('bands_title', $pageid);
        $bands_text = get_field('bands_text', $pageid);
        $bands_infos = get_field('bands_infos', $pageid);

        //WINNERS
        $winners = get_field('winners', $pageid);

        //PUB2
        $pub2_image = get_field('pub2_image', $pageid);
        $pub2_title = get_field('pub2_title', $pageid);
        $pub2_text = get_field('pub2_text', $pageid);
        $pub2_link = get_field('pub2_link', $pageid);
    endwhile;
endif;
?>

<section id="phase2" data-control="PHASE2_COUNTDOWN">

    <section class="header">

        <img class="bg" src="<?php echo $header_image['url']; ?>" alt="">
        <img class="bg mobile" src="<?php echo $header_image_mobile['url']; ?>" alt="">

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

        <div class="container">
            <img class="biglogo" src="<?php echo $header_logo['url']; ?>" alt="">
            <img class="biglogo mobile" src="<?php echo $header_logo_mobile['url']; ?>" alt="">
            <div class="text">
                <?php if ($header_image_text) { ?>
                    <img src="<?php echo $header_image_text['url']; ?>" alt="<?php echo $header_text; ?>" />
                <?php } else {
                    echo $header_text;
                } ?>
            </div>
            <div class="r">
                <p>Fin dans votes dans</p>
                <div class="countdown" data-date="<?php echo $finish_date; ?>"></div>
            </div>
        </div>
    </section>

    <section class="bands">
        <div class="container">
            <div class="row top">
                <h2><?php echo $bands_title; ?></h2>
                <div class="text"><?php echo $bands_text; ?></div>
            </div>
            <div class="row bot">
                <?php foreach ($bands_infos as $info) { ?>
                    <div class="info">
                        <div class="center">
                            <img src="<?php echo $info['icon']['url']; ?>" alt="<?php echo $info['text']; ?>" />
                            <p><?php echo $info['text']; ?></p>
                            <img class="mobile" src="<?php echo $info['icon']['url']; ?>" alt="<?php echo $info['text']; ?>" />
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <section class="winners">
        <div class="container">
            <?php $speed = 1.1;
            $count = 1;
            foreach ($winners as $band) {
                $image = get_field('photos', $band['band']);
                $name = get_field('group_name', $band['band']);
                $clss = '';

                if (!$band['band']) $clss = 'hide';

                switch ($count) {
                    case 2:
                        $speed = 1.2;
                        break;
                    case 3:
                        $speed = 1.2;
                        break;
                    case 4:
                        $speed = 1.2;
                        break;
                    case 7:
                        $speed = 1.3;
                        break;
                    case 9:
                        $speed = 1.3;
                        break;
                    case 10:
                        $speed = 1.2;
                        break;
                    default:
                        $speed = 1.1;
                        break;
                }
            ?>
                <div class="band <?php echo $clss; ?>" data-speed="<?php echo $speed; ?>">
                    <div class="image" style="background-image: url(<?php echo $image[0]['url']; ?>);">
                        <img src="<?php echo get_bloginfo('template_url'); ?>/images/winners_spacer.png" alt="" />
                    </div>
                    <div class="info">
                        <h2><?php echo $name; ?></h2>
                        <a href="<?php echo get_permalink($band['band']); ?>">
                            <svg width="74" height="69" viewBox="0 0 74 69" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="0.5" y="0.5" width="72.3714" height="68" rx="9.5" stroke="#11192E" style="stroke:#11192E;stroke:color(display-p3 0.0667 0.0980 0.1804);stroke-opacity:1;" />
                                <g clip-path="url(#clip0_3285_622)">
                                    <path d="M21.6857 36.1409L45.4262 36.1409L36.8384 44.7668L39.1284 47.0569L51.6857 34.4996L39.1284 21.9424L36.8384 24.2325L45.4262 32.8584L21.6857 32.8584L21.6857 36.1409Z" fill="#11192E" style="fill:#11192E;fill:color(display-p3 0.0667 0.0980 0.1804);fill-opacity:1;" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_3285_622">
                                        <rect width="30" height="25.1145" fill="white" style="fill:white;fill-opacity:1;" transform="translate(51.6857 47.0574) rotate(-180)" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </a>

                    </div>
                </div>
            <?php $count++;
            } ?>
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

</section>

<?php get_footer(); ?>