<?php get_header(); ?>

<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        $id = get_the_ID();
        $title = get_the_title($id);
        $front_page_id = get_option('page_on_front');
        $header_vw_logo = get_field('header_vw_logo', $front_page_id);
        $header_links = get_field('header_links', $front_page_id);
        $winners = get_field('winners', $front_page_id);
        $winners_title = get_field('winners_title', $front_page_id);
        $winners_text = get_field('winners_text', $front_page_id);

        $hero_image = get_field('hero_image', $id);
        $hero_image_mobile = get_field('hero_image_mobile', $id);
        $hero_title = get_field('hero_title', $id);
        $hero_description = get_field('hero_description', $id);
        $deezer_embed_code = get_field('deezer_embed_code', $id);
        $artist_name = get_field('artist_name', $id);
        $location = get_field('location', $id);
        $musical_genre = get_field('musical_genre', $id);

        $share_url     = urlencode(get_permalink($id));
        $share_title   = urlencode(get_the_title($id));
        $template_url  = get_bloginfo('template_url');
    endwhile;
endif;
?>

<section id="single-participant" data-control="PHASE2">
    <div class="header">
        <div class="container">
            <img class="heroimage desktop" src="<?php echo $hero_image['url']; ?>">
            <img class="heroimage mobile" src="<?php echo $hero_image_mobile['url']; ?>">

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
            <div class="info">
                <h1><?php echo $hero_title; ?></h1>
                <div class="text">
                    <p><?php echo $hero_description; ?></p>
                    <!--<a href="#" class="button js-open-vote">JE VOTE !</a>-->
                </div>
            </div>
        </div>
    </div>

    <div class="embed">
        <div class="container">
            <iframe title="deezer-widget" src="https://widget.deezer.com/widget/dark/artist/<?php echo $deezer_embed_code; ?>/top_tracks" width="100%" height="300" frameborder="0" allowtransparency="true" allow="encrypted-media; clipboard-write"></iframe>
        </div>
    </div>

    <div class="infos">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>À PROPOS DE <br><?php echo $artist_name; ?></p>
                </div>
                <div class="col">
                    <p>
                        <span>Ville</span>
                        <?php echo $location; ?>
                    </p>
                </div>
                <div class="sep"></div>
                <div class="col last">
                    <span>GENRE MUSICAL</span>
                    <?php echo $musical_genre; ?>
                </div>
                <!--<a href="#" class="button invert js-open-vote">JE VOTE !</a>-->
            </div>
            <div class="row share-list">
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

    <div class="winners_title">
        <div class="container">
            <h2><?php echo $winners_title; ?></h2>
            <p><?php echo $winners_text; ?></p>
        </div>
    </div>

    <section class="winners">
        <div class="container">
            <?php $speed = 1.1;
            $count = 1;
            foreach ($winners as $band) {
                $image = get_field('photos', $band['band']);
                $name = get_field('group_name', $band['band']);
   
                if($band['band'] == $id || !$band['band']) continue;

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
                <div class="band" data-speed="<?php echo $speed; ?>">
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
</section>

<?php get_footer(); ?>