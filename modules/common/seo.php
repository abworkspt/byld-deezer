<?php
$seo_site_title        = get_field('seo_site_title', 'option');
$seo_site_description  = get_field('seo_site_description', 'option');
$seo_share_description = get_field('seo_share_description', 'option');
$seo_share_image       = get_field('seo_share_image', 'option');
$global_favicon        = get_field('general_favicon', 'option');
$seo_site_url          = home_url();

$seo_share_image_url = $seo_share_image['url'] ?? '';
$global_favicon_url  = $global_favicon['url'] ?? '';
?>
<title><?php echo esc_html($seo_site_title); ?></title>

<meta name="description" content="<?php echo esc_attr($seo_site_description); ?>" />

<meta property="og:site_name" content="<?php echo esc_attr($seo_site_title); ?>" />
<meta property="og:title" content="<?php echo esc_attr($seo_site_title); ?>" />
<meta property="og:description" content="<?php echo esc_attr($seo_share_description ?: $seo_site_description); ?>" />
<meta property="og:url" content="<?php echo esc_url($seo_site_url); ?>" />
<meta property="og:type" content="website" />

<?php if ($seo_share_image_url): ?>
<meta property="og:image" content="<?php echo esc_url($seo_share_image_url); ?>" />
<meta property="og:image:secure_url" content="<?php echo esc_url($seo_share_image_url); ?>" />
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:image" content="<?php echo esc_url($seo_share_image_url); ?>" />
<?php endif; ?>

<meta property="twitter:site" content="@<?php echo esc_attr($seo_site_title); ?>" />

<?php if ($global_favicon_url): ?>
<link rel="shortcut icon" href="<?php echo esc_url($global_favicon_url); ?>" type="image/x-icon">
<link rel="icon" type="image/x-icon" href="<?php echo esc_url($global_favicon_url); ?>">
<?php endif; ?>
