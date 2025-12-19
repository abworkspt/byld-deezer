<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, interactive-widget=resizes-content">
	<?php include_once('modules/common/seo.php'); 
	?>
	
	<script>
		window._paq = window._paq || [];
	</script>

	<?php wp_head(); ?>
</head>

<body data-control="GLOBAL" class="" data-control="GLOBAL">
	
	<?php include(TEMPLATEPATH . '/modules/common/cookiebanner.php'); ?>

	<?php
	if (is_page_template('pages/phase1.php')) {
		include(TEMPLATEPATH . '/modules/phase1/popup-signin.php');
	}
	?>

	<?php
	if ( is_singular('participant') ) {
		include(TEMPLATEPATH . '/modules/phase2/popup-vote.php');
	}
	?>

	<div id="smooth-content">