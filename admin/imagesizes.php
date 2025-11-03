<?php


function image_sizes() {
	add_image_size( 'size-383-190', 383, 190, true );
	add_image_size( 'size-790-400', 790, 400, true );
	add_image_size( 'size-769-420', 769, 420 , true );
	add_image_size( 'size-354-237', 354, 237, true );
	add_image_size( 'size-354-420', 354, 420, true );
	add_image_size( 'size-1195-710', 1195, 710, true );
	add_image_size( 'size-180-120', 180, 120, true );
	add_image_size( 'size-95-95', 95, 95, true );
}

add_action( 'after_setup_theme', 'image_sizes' );

function remove_stock_image_sizes( $sizes ) {
	
	return array( 
		'size-383-190',
		'size-790-400',
		'size-769-420',
		'size-354-237',
		'size-354-420',
		'size-1195-710',
		'size-180-120',
		'size-95-95',
	);
}
add_filter( 'intermediate_image_sizes', 'remove_stock_image_sizes' );

?>