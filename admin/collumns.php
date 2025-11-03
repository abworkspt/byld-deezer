<?php

$postscols = array('code');

foreach ($postscols as $ps) {
	add_filter('manage_' . $ps . '_posts_columns', 'add_' . $ps . '_collumns');
	add_action('manage_' . $ps . '_posts_custom_column', 'manage_' . $ps . '_collumns', 10, 3);
}

function add_code_collumns($columns)
{
	unset($columns['date']);

	return array_merge($columns, array(
		'used' => 'Used'
	));
}

function manage_code_collumns($column_name, $post_id)
{

	switch ($column_name) {
		case 'used':
			$used = get_field('used', $post_id);
			if (!$used) {
				$html = '----';
			} else {
				$html = 'YES';
			}
			echo $html;
			break;
	}
}
