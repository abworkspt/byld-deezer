<?php get_header(); ?>

<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        $inid = get_the_ID();
        $intitle = get_the_title();
        $inimage = get_field('imagem_destaque', $inid);
        $incontent = get_field('content', $inid);
        $indate = get_the_time('d M, Y', $inid);
        $inlink = get_permalink($inid);
    endwhile;
endif;
?>

<section id="insight" data-control="INSIGHT">

    <div class="container">
        <h1><?php echo $intitle; ?></h1>
        <p class="date"><?php echo $indate; ?></p>
        <img src="<?php echo $inimage['url']; ?>" />
        <div class="content">
            <?php echo $incontent; ?>
        </div>
        <div class="social">
            <p><?php echo get_field('traducao_insight_partilha', 'option'); ?></p>
            <ul>
                <li>
                    <a href="https://www.linkedin.com/shareArticle?url=<?php echo $inlink; ?>&title=<?php echo $intitle; ?>" target="_blank">LinkedIn</a>
                </li>
                <li class="sep"></li>
                <li>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $inlink; ?>" target="_blank">Facebook</a>
                </li>
                <li class="sep"></li>
                <li>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo $inlink; ?>&text=<?php echo $intitle; ?>&via=<?php echo home_url(); ?>" target="_blank">X</a>
                </li>
                <li class="sep"></li>
                <li>
                    <a href="https://mail.google.com/mail/?view=cm&to=&su=&body=<?php echo $inlink; ?>" target="_blank">Email</a>
                </li>
                <li class="sep"></li>
                <li>
                    <a href="<?php echo $inlink; ?>" class="copy">Copiar link</a>
                </li>
            </ul>
        </div>
    </div>

</section>

<?php get_footer(); ?>