<?php

$services = array('GetRandomStory', 'CheckAnswer', 'GetCode');

foreach ($services as $service) {
	add_action("wp_ajax_nopriv_{$service}", "{$service}");
	add_action("wp_ajax_{$service}", "{$service}");
}

function CheckAnswer()
{
	check_ajax_referer('appnonce', 'security');
	$gameid = $_POST['gameid'];
	$answerid = $_POST['answerid'];
	$game = get_post($gameid);
	$answers = get_field('answer', $game->ID);
	die(json_encode(array('result' => $answers[$answerid]['correct'])));
}

function GetRandomStory()
{
	check_ajax_referer('appnonce', 'security');

	$the_query = new WP_Query(array(
		'post_type' => 'story',
		'orderby'   => 'rand',
		'posts_per_page' => 1,
	));

	$result = array();

	if ($the_query->have_posts()) {
		while ($the_query->have_posts()) {
			$the_query->the_post();
			$result = array(
				'background_image_desktop' => get_field('background_image_desktop', get_the_ID()),
				'background_image_mobile' => get_field('background_image_mobile', get_the_ID()),
				'texts' => get_field('texts', get_the_ID()),
				'final_screen' => get_field('final_screen', get_the_ID()),
				'answers' => get_field('answer', get_the_ID()),
			);
		}
	}

	die(json_encode(array('result' => $result)));
}

function GetCode()
{
	check_ajax_referer('appnonce', 'security');

	$the_query = new WP_Query(array(
		'post_type' => 'code',
		'orderby'   => 'rand',
		'meta_key'  => 'used',
		'meta_value' => '0',
		'posts_per_page' => 1,
	));

	$result = array();

	if ($the_query->have_posts()) {
		while ($the_query->have_posts()) {
			$the_query->the_post();
			$result = get_the_title();
			update_field('used', true, get_the_ID());
		}
	}

	die(json_encode(array('code' => $result)));
}

/*$the_query = new WP_Query(array(
	'post_type' => 'code',
	'posts_per_page' => -1,
));

$result = array();

if ($the_query->have_posts()) {
	while ($the_query->have_posts()) {
		$the_query->the_post();
		update_field('used', '0', get_the_ID());
	}
}*/
