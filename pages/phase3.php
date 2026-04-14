<?php /* Template Name: Phase 3 */ ?>

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
        $header_vw_logo = get_field('header_vw_logo', $pageid);
        $header_links = get_field('header_links', $pageid);

        //BANDS
        $bands_title = get_field('bands_title', $pageid);
        $bands_text = get_field('bands_text', $pageid);
        $bands_city = get_field('bands_city', $pageid);
        $bands_musical_style = get_field('bands_musical_style', $pageid);
        $bands_deezer_album_id = get_field('bands_deezer_album_id', $pageid);

        //PUB2
        $pub2_image = get_field('pub2_image', $pageid);
        $pub2_title = get_field('pub2_title', $pageid);
        $pub2_text = get_field('pub2_text', $pageid);
        $pub2_link = get_field('pub2_link', $pageid);

        //EXTRAS
        $videos = get_field('videos', $pageid);
        $embed_title = get_field('embed_title', $pageid);

        $share_url     = urlencode(get_permalink($pageid));
        $share_title   = urlencode(get_the_title($pageid));
        $template_url  = get_bloginfo('template_url');
    endwhile;
endif;
?>

<section id="phase3" data-control="">

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
        </div>
    </section>

    <section class="bands">
        <div class="container">
            <div class="row top">
                <h2><?php echo $bands_title; ?></h2>
                <div class="text"><?php echo $bands_text; ?></div>
            </div>

            <div class="ytvideos">
                <?php if ($videos) { ?>
                    <?php foreach ($videos as $video) { ?>
                        <div class="video" <?php if($video['anchor']) { ?>id="<?php echo $video['anchor']; ?>"<?php } ?>>
                            <h3><?php echo $video['title']; ?></h3>
                            <div class="video-frame">
                                <iframe
                                    src="https://www.youtube.com/embed/<?php echo $video['youtube_id']; ?>?modestbranding=1&rel=0&controls=1"
                                    title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <div class="embed">
                <h3><?php echo $embed_title; ?></h3>
                <iframe title="deezer-widget" src="https://widget.deezer.com/widget/dark/artist/<?php echo $bands_deezer_album_id; ?>/top_tracks" width="100%" height="475" frameborder="0" allowtransparency="true" allow="encrypted-media; clipboard-write"></iframe>
            </div>

            <div class="infos">
                <div class="row">

                    <div class="col">
                        <p>
                            <span>Ville</span>
                            <?php echo $bands_city; ?>
                        </p>
                    </div>
                    <div class="sep"></div>
                    <div class="col">
                        <span>GENRE MUSICAL</span>
                        <?php echo $bands_musical_style; ?>
                    </div>
                    <div class="sep"></div>
                    <div class="share-list">
                        <p>PARTAGE SUR</p>
                        <ul>
                            <li>
                                <a
                                    href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>"
                                    target="_blank"
                                    rel="noopener">
                                    <img src="<?php echo $template_url; ?>/images/Facebook.svg" alt="Facebook">
                                </a>
                            </li>

                            <li>
                                <a
                                    href="https://api.whatsapp.com/send?text=<?php echo $share_title; ?>%20<?php echo $share_url; ?>"
                                    target="_blank"
                                    rel="noopener">
                                    <img src="<?php echo $template_url; ?>/images/Whatsapp.svg" alt="WhatsApp">
                                </a>
                            </li>

                            <li>
                                <a href="#" class="copy-link" onclick="copyShareLink(event)">
                                    <img src="<?php echo $template_url; ?>/images/CopyLink.svg" alt="Copiar link">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
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

</section>

<?php get_footer(); ?>