<?php

// *******************************************************************************	
// ADD MENU SEPARATORS ***********************************************************
// *******************************************************************************
function add_admin_menu_separator( $position ) {

	global $menu;
	
	$menu[ $position ] = array(
		0	=>	'',
		1	=>	'read',
		2	=>	'separator' . $position,
		3	=>	'',
		4	=>	'wp-menu-separator'
	);

}
add_action( 'admin_init', 'add_admin_menu_separator' );

// *******************************************************************************	
// CHANGE MENU ORDER *************************************************************
// *******************************************************************************

function change_menu_order( $menu_order ) {

	$order = array();
		
	global $submenu;

	
	array_push( $order, 'index.php' );
	array_push($order, 'activity-log-page');
	array_push($order, 'settings');
	array_push($order, 'edit.php?post_type=participant');	
	array_push($order, 'edit.php?post_type=advogado');	
	array_push($order, 'footer');	
		
	array_push( $order, 'edit.php?post_type=page' );	
	array_push( $order, 'separator1' );
	array_push( $order, 'separator2' );	
	array_push( $order, 'separator-last' );
	
	array_push( $order, 'users.php' );
	array_push( $order, 'edit-comments.php' );	
	array_push( $order, 'edit.php' );	
	array_push( $order, 'upload.php' );	
	array_push( $order, 'themes.php' );
	array_push( $order, 'plugins.php' );
	array_push( $order, 'tools.php' );
	array_push( $order, 'options-general.php' );
		
	return $order;
}

add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'change_menu_order' );

// *******************************************************************************	
// CHANGE MENU NAMES *************************************************************
// *******************************************************************************

function change_menu_names() {

	global $menu;
	//global $submenu;
	
	//print_r($menu);
		
	foreach($menu as $key => $item) {
		switch($item[0]) {
			case 'Activity Log': 
				$menu[$key][0] = 'Activity';
				break;
			case 'Campos personalizados': 
			case 'Custom Fields': 
				$menu[$key][0] = 'Campos';
				break;
			case 'Registo de actividade': 
				$menu[$key][0] = 'Activity';
				break;
			case 'WP Mail SMTP': 
				$menu[$key][0] = 'SMTP';
				break;
			case 'All-in-One WP Migration': 
				$menu[$key][0] = 'Migration';
				break;
		}
	}
	
	/*foreach($submenu as $subkey => $subitem) {
		if(!isset($subitem[0])) continue;
		switch($subitem[0]) {
			case 'Todas as páginas': 
				$submenu[$subkey][0] = 'All Pages';
				break;
		}
	}*/
}

add_action( 'admin_init', 'change_menu_names');


// *******************************************************************************	
// REMOVE SELECTED MENUS *********************************************************
// *******************************************************************************

function remove_selected_menus() {
	
	if ( $GLOBALS[ 'hide_dashboard' ] )remove_menu_page( 'index.php' );
	if ( $GLOBALS[ 'hide_default_posts' ] )remove_menu_page( 'edit.php' );
	if ( $GLOBALS[ 'hide_media' ] )remove_menu_page( 'upload.php' );
	if ( $GLOBALS[ 'hide_pages' ] )remove_menu_page( 'edit.php?post_type=page' );
	if ( $GLOBALS[ 'hide_comments' ] )remove_menu_page( 'edit-comments.php' );
	if ( $GLOBALS[ 'hide_users' ] )remove_menu_page( 'users.php' );
	if ( $GLOBALS[ 'hide_acf_fields' ] )remove_menu_page( 'edit.php?post_type=acf-field-group' );
	if ( $GLOBALS[ 'hide_themes' ] )remove_menu_page( 'themes.php' );
	if ( $GLOBALS[ 'hide_plugins' ] )remove_menu_page( 'plugins.php' );
	if ( $GLOBALS[ 'hide_tools' ] )remove_menu_page( 'tools.php' );
	if ( $GLOBALS[ 'hide_options' ] )remove_menu_page( 'options-general.php' );
	
	if(get_current_user_id() != 1) {
		remove_menu_page( 'options-general.php' );
		remove_menu_page( 'tools.php' );
		remove_menu_page( 'plugins.php' );
		remove_menu_page( 'themes.php' );
		remove_menu_page( 'edit.php?post_type=acf-field-group' );
		remove_menu_page( 'itsec' );
		remove_menu_page( 'sitepress-multilingual-cms/menu/languages.php' );
	}	
	
	remove_menu_page( 'edit.php?post_type=projecto' );
	
	add_submenu_page('atlanticvillas_homepage', 'Atlantic Villas - Projectos', 'Projectos', 'manage_options', 'edit.php?post_type=projecto', '', 200);
}

add_action( 'admin_menu', 'remove_selected_menus');

// *******************************************************************************	
// REMOVE LINKS FROM ADMIN BAR MENU **********************************************
// *******************************************************************************

function remove_links_menubar( $wp_admin_bar ) {
	//if ( $GLOBALS[ 'hide_default_posts' ] )$wp_admin_bar->remove_node( 'new-post' );
	if ( $GLOBALS[ 'hide_media' ] )$wp_admin_bar->remove_node( 'new-media' );
	if ( $GLOBALS[ 'hide_pages' ] )$wp_admin_bar->remove_node( 'new-page' );
	if ( $GLOBALS[ 'hide_users' ] )$wp_admin_bar->remove_node( 'new-user' );
}

add_action( 'admin_bar_menu', 'remove_links_menubar', 999 );

// *******************************************************************************	
// REDIRECT HIDDEN PAGES *********************************************************
// *******************************************************************************

 function redirect_hidden_pages() {
	 	
	if ( $GLOBALS[ 'hide_acf_fields' ] && get_current_screen()->post_type == 'acf-field-group' || 
	   	 //$GLOBALS[ 'hide_default_posts' ] && get_current_screen()->post_type == 'post' ||
	     $GLOBALS[ 'hide_media' ] && get_current_screen()->base == 'upload' ||
	     $GLOBALS[ 'hide_pages' ] && get_current_screen()->post_type == 'page' ||
	     $GLOBALS[ 'hide_comments' ] && get_current_screen()->base == 'edit-comments' ||
	     $GLOBALS[ 'hide_users' ] && get_current_screen()->base == 'users' ||
	     $GLOBALS[ 'hide_themes' ] && get_current_screen()->base == 'themes' ||
	     $GLOBALS[ 'hide_plugins' ] && get_current_screen()->base == 'plugins' ||
	     $GLOBALS[ 'hide_tools' ] && get_current_screen()->base == 'tools' ||
	     $GLOBALS[ 'hide_options' ] && get_current_screen()->base == 'options' ||
	     $GLOBALS[ 'hide_options' ] && get_current_screen()->base == 'options-general') {			
		
		wp_redirect( admin_url(), 301 );
        exit;
	}
	 
}

add_action( 'admin_head', 'redirect_hidden_pages' );

 function redirect_hidden_pages2() {
	 
	 global $pagenow;
	 	 
	 if ( $GLOBALS[ 'hide_themes' ] && $pagenow == 'customize.php' ||
		  $GLOBALS[ 'hide_themes' ] && $pagenow == 'theme-editor.php' ||
		  $GLOBALS[ 'hide_tools' ] && $pagenow == 'import.php' ||
		  $GLOBALS[ 'hide_tools' ] && $pagenow == 'export.php' ||
		  $GLOBALS[ 'hide_tools' ] && $pagenow == 'site-health.php' ||
		  $GLOBALS[ 'hide_tools' ] && $pagenow == 'tools.php' ||
		  $GLOBALS[ 'hide_acf_fields' ] && $pagenow == 'post-new.php' && $_GET['post_type'] == 'acf-field-group' ||
		  $GLOBALS[ 'hide_acf_fields' ] && $pagenow == 'edit.php' && $_GET['post_type'] == 'acf-field-group' ||
		  $GLOBALS[ 'hide_options' ] && $pagenow == 'options-writing.php' ||
		  $GLOBALS[ 'hide_options' ] && $pagenow == 'options-reading.php' ||
		  $GLOBALS[ 'hide_options' ] && $pagenow == 'options-discussion.php' ||
		  $GLOBALS[ 'hide_options' ] && $pagenow == 'options-media.php' ||
		  $GLOBALS[ 'hide_options' ] && $pagenow == 'options-permalink.php' ||
		  $GLOBALS[ 'hide_options' ] && $pagenow == 'privacy.php' ||
		  $GLOBALS[ 'hide_plugins' ] && $pagenow == 'plugin-install.php' ||
		  $GLOBALS[ 'hide_plugins' ] && $pagenow == 'plugin-editor.php' ||
		  $GLOBALS[ 'hide_users' ] && $pagenow == 'user-new.php' ||
		  $GLOBALS[ 'hide_users' ] && $pagenow == 'profile.php' ||
		  $GLOBALS[ 'hide_pages' ] && $pagenow == 'post-new.php' && $_GET['post_type'] == 'page' ||
		  $GLOBALS[ 'hide_media' ] && $pagenow == 'upload.php' ||
		  $GLOBALS[ 'hide_media' ] && $pagenow == 'media-new.php') {
		 
		 wp_redirect( admin_url(), 301 );
         exit;
	 }
	 
 }

add_action( 'admin_init', 'redirect_hidden_pages2' );


// *******************************************************************************	
// REMOVE SUBMENUS **************************************************************
// *******************************************************************************

function delete_submenu_items() {
		remove_submenu_page( 'index.php', 'index.php' );
		remove_submenu_page( 'index.php', 'update-core.php' );
		remove_submenu_page( 'index.php', 'mpsum-update-options' );
		remove_submenu_page( 'activity-log-page', 'activity-log-page' );
		remove_submenu_page( 'activity-log-page', 'activity-log-settings' );
}
add_action( 'admin_init', 'delete_submenu_items' );

?>