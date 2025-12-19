<?php

function include_scripts_styles() {
    if(!is_admin() && !in_array( $_SERVER['PHP_SELF'], array( '/wp-login.php', '/wp-register.php' ) )) {
        
		// REMOVE DEFAULT SCRIPTS
        wp_deregister_script('wp-embed');
				
		// LIBS				
		wp_enqueue_script('abquery', get_template_directory_uri().'/scripts/libs/jquery-3.7.1.min.js', '', '1', true);
		wp_enqueue_script('gsap', get_template_directory_uri().'/scripts/libs/gsap.min.js', '', '1', true);
		wp_enqueue_script('scrolltrigger', get_template_directory_uri().'/scripts/libs/ScrollTrigger.min.js', '', '1', true);
		wp_enqueue_script('scrollsmoother', get_template_directory_uri().'/scripts/libs/ScrollSmoother.min.js', '', '1', true);
		wp_enqueue_script('main', get_template_directory_uri().'/scripts/main-min.js', '', '1.4', true);
		wp_localize_script('main', 'appapi', array('template_path' => get_template_directory_uri(), 'url' => home_url(), 'ajaxurl' => admin_url( 'admin-ajax.php' ),'ajaxnonce' => wp_create_nonce( 'appnonce' )));
		
		// REMOVE DEFAULT STYLES
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-admin' );
				
		// TEMPLATE
		wp_enqueue_style( 'main',  get_template_directory_uri(). '/css/main.min.css',false,'2.1','all');
    }
}

add_action('wp_enqueue_scripts', 'include_scripts_styles');

?>