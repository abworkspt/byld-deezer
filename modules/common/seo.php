<?php
$seo_site_title;
$seo_site_description;
$seo_site_keywords;
$seo_imagem_de_partilha = get_field('xxxxxx', 'option')['url'];
$global_favicon = get_field('xxxxxx', 'option')['url'];
$seo_site_url = home_url();

if (have_posts()) :
    while (have_posts()) : the_post();
        $pageid = get_the_ID();
        $seo_site_title = get_field('seo_titulo', $pageid);
        $seo_site_description = get_field('seo_descricao', $pageid);
        $seo_site_keywords = get_field('seo_keywords', $pageid);
    endwhile;
endif;
?>

<title><?php echo $seo_site_title; ?></title>

<meta property="og:site_name" content="<?php echo $seo_site_title; ?>" />
<meta property="og:title" content="<?php echo $seo_site_title; ?>" />
<meta property="og:description" content="<?php echo $seo_site_description; ?>" />
<meta property="og:url" content="<?php echo $seo_site_url; ?>" />
<meta property="og:type" content="article" />

<meta property="og:image" content="<?php echo $seo_imagem_de_partilha; ?>" />
<meta property="og:image:secure_url" content="<?php echo $seo_imagem_de_partilha; ?>" />
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:image" content="<?php echo $seo_imagem_de_partilha; ?>" />
<meta property="twitter:site" content="@<?php echo $seo_site_title; ?>" />

<link rel="shortcut icon" href="<?php echo $global_favicon; ?>" type="image/x-icon">
<link rel="icon" type="image/x-icon" href="<?php echo $global_favicon; ?>">