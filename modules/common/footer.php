<?php
$footer_text_left = get_field('footer_text_left', 'option');
$footer_logos = get_field('footer_logos', 'option');
$footer_links = get_field('footer_links', 'option');
$footer_image_left = get_field('footer_image_left', 'option');
$clss = '';

if (is_page_template('pages/blank.php')) {
    $clss = 'yellow';
}
?>

<section id="site-footer" class="<?php echo $clss; ?>">
    <div class="container">
        <?php if ($footer_image_left) { ?><img class="chart desktoop" src="<?php echo $footer_image_left['url']; ?>" alt="" /><?php } ?>
        <div class="l"><?php echo $footer_text_left; ?></div>
        <div class="c">
            <?php foreach ($footer_logos as $logo) { ?>
                <?php if ($logo['link']) { ?><a target="_blank" href="<?php echo $logo['link']['url']; ?>"><?php } ?>
                    <img src="<?php echo $logo['logo']['url']; ?>" alt="" />
                    <?php if ($logo['link']) { ?></a><?php } ?>
            <?php } ?>
        </div>
        <div class="l mobile"><?php echo $footer_text_left; ?></div>
        <div class="r">
            <?php if ($footer_image_left) { ?><img class="chart mobile" src="<?php echo $footer_image_left['url']; ?>" alt="" /><?php } ?>
            <?php foreach ($footer_links as $link) { ?>
                <a href="<?php echo $link['link']['url']; ?>"><?php echo $link['link']['title']; ?></a>
            <?php } ?>
        </div>
    </div>
</section>