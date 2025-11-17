<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, interactive-widget=resizes-content">
	<?php include_once('modules/common/seo.php'); 
	?>
	<!-- Matomo -->
	<script>
		var _paq = window._paq = window._paq || [];
		/* tracker methods like "setCustomDimension" should be called before "trackPageView" */
		_paq.push(['trackPageView']);
		_paq.push(['enableLinkTracking']);
		(function() {
			var u = "https://rocon.matomo.cloud/";
			_paq.push(['setTrackerUrl', u + 'matomo.php']);
			_paq.push(['setSiteId', '1']);
			var d = document,
				g = d.createElement('script'),
				s = d.getElementsByTagName('script')[0];
			g.async = true;
			g.src = 'https://cdn.matomo.cloud/rocon.matomo.cloud/matomo.js';
			s.parentNode.insertBefore(g, s);
		})();
	</script>
	<!-- End Matomo Code -->
	<?php wp_head(); ?>
</head>

<body data-control="GLOBAL" class="" data-control="GLOBAL">
	
	
	<?php include_once('modules/common/header.php'); ?>


	<?php
	if (is_page_template('pages/phase1.php')) {
		include(TEMPLATEPATH . '/modules/phase1/popup-signin.php');
	}
	?>

	<div id="smooth-content">