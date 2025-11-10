<?php
// *******************************************************************************	
// ALLOW PLUGIN AUTO UPDATES *****************************************************
// *******************************************************************************
add_filter( 'auto_update_plugin', '__return_true' );

// *******************************************************************************	
// REMOVE UNECESSARY HEAD TAGS ***************************************************
// *******************************************************************************

remove_action('wp_head', 'feed_links_extra', 3); 
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10,0);

// *******************************************************************************	
// REMOVE WORDPRESS EMOJIS *******************************************************
// *******************************************************************************

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
add_filter( 'emoji_svg_url', '__return_false' );

// *******************************************************************************	
// REMOVE WORDPRESS VERSION ******************************************************
// *******************************************************************************

add_filter('the_generator', 'remove_wordpress_version');

function remove_wordpress_version() {return '';}

// *******************************************************************************	
// REMOVE ADMIN BAR FROM FRONTEND ************************************************
// *******************************************************************************

add_filter( 'show_admin_bar' , 'remove_admin_bar');

function remove_admin_bar(){return false;}

// *******************************************************************************	
// ADD CUSTOM CSS FILE TO ADMIN **************************************************
// *******************************************************************************

add_action('admin_head', 'add_admin_styles');
add_action( 'login_enqueue_scripts', 'add_admin_styles' );

function add_admin_styles() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . $GLOBALS['admin_css'] . '?v=1.1" />';
}

// *******************************************************************************	
// REMOVE DASHBOARD DEFAULT WIDGETS **********************************************
// *******************************************************************************

add_action( 'admin_init', 'remove_dashboard_widget' );
remove_action( 'welcome_panel', 'wp_welcome_panel' );

function remove_dashboard_widget() {
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_custom_feed', 'dashboard', 'normal' );
}


// *******************************************************************************	
// REMOVE DASHBOARD NAME TITLE ***************************************************
// *******************************************************************************

/*add_action( 'admin_head', 'remove_dashboard_title' );

function remove_dashboard_title(){
	if ( $GLOBALS['title'] != 'Dashboard' ){return;}
	$GLOBALS['title'] =  ''; 
}*/

add_action('admin_init', 'text_domain_logout_link');

function text_domain_logout_link() {
    global $menu;
    $menu[9999] = array(__('Logout'), 'manage_options', wp_logout_url());
}
// *******************************************************************************	
// CHANGE FOOTER ADMIN TEXT ******************************************************
// *******************************************************************************

add_filter('admin_footer_text', 'change_footer');

function change_footer () 
{
    echo '<span id="footer-thankyou">' . $GLOBALS['footer_text'] . '</span>';
}

// *******************************************************************************	
// DISABLE REST API **************************************************************
// *******************************************************************************


/*remove_action( 'wp_head', 'rest_output_link_wp_head');

$dra_current_WP_version = get_bloginfo('version');

if ( version_compare( $dra_current_WP_version, '4.7', '>=' ) ) {
    DRA_Force_Auth_Error();
} else {
    DRA_Disable_Via_Filters();
}

function DRA_Force_Auth_Error() {
    add_filter( 'rest_authentication_errors', 'DRA_only_allow_logged_in_rest_access' );
}


function DRA_Disable_Via_Filters() {    
    add_filter( 'json_enabled', '__return_false' );
    add_filter( 'json_jsonp_enabled', '__return_false' );
    add_filter( 'rest_enabled', '__return_false' );
    add_filter( 'rest_jsonp_enabled', '__return_false' );
    remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'template_redirect', 'rest_output_link_header', 11 );
}

function DRA_only_allow_logged_in_rest_access( $access ) {
	return new WP_Error( 'rest_cannot_access', __( 'Only authenticated users can access the REST API.', 'disable-json-api' ), array( 'status' => rest_authorization_required_code() ) );
    return $access;	
}*/

// *******************************************************************************	
// REMOVE WP LOGO ****************************************************************
// *******************************************************************************

add_action( 'wp_before_admin_bar_render', 'remove_admin_logo', 999 );

function remove_admin_logo() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('new-content');
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('view-site'); 
	$wp_admin_bar->remove_menu('my-account');
	$wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
	$wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('site-name');
	$wp_admin_bar->remove_menu('easy-updates-manager-admin-bar');
	$wp_admin_bar->remove_menu('itsec_admin_bar_menu');
	$wp_admin_bar->remove_menu('updraft_admin_node');
	$wp_admin_bar->remove_menu('view');
}

// *******************************************************************************	
// ADMIN REDIRECT  ***************************************************************
// *******************************************************************************

add_action( 'admin_init', 'admin_redirect' );

function admin_redirect() {	
    global $pagenow;
    if( $pagenow == 'index.php' && $GLOBALS['admin_redirect'] && $GLOBALS['admin_redirect'] != ''){		
		wp_redirect( admin_url( $GLOBALS['admin_redirect'] ), 301 );
        exit;        
    }
}

// *******************************************************************************	
// LOGOUT REDIRECT  ***************************************************************
// *******************************************************************************

add_filter('wp_logout','redirect_me');

function redirect_me(){
 $logout_redirect_url = $_SERVER['HTTP_REFERER'];
 if(!empty($_REQUEST['redirect_to'])) wp_safe_redirect($_REQUEST['redirect_to']);
 else wp_redirect($logout_redirect_url);
 exit();
}

// *******************************************************************************	
// REMOVE HELP AND OPTIONS TABS **************************************************
// *******************************************************************************

add_filter( 'admin_head', 'remove_help_tab' );
add_filter('screen_options_show_screen', 'remove_screen_options');

function remove_help_tab(){
   $screen = get_current_screen();
	$screen->remove_help_tabs();
}

function remove_screen_options(){
    return false;
}

function append_query_string( $url, $post ) {
    if ( 'analysis' == get_post_type( $post ) ) {
        return add_query_arg( $_GET, $url );
    }
    return $url;
}
add_filter( 'post_type_link', 'append_query_string', 10, 2 );

// *******************************************************************************	
// REMOVE CONTENT EDITOR FOR POSTS ***********************************************
// *******************************************************************************

add_action( 'init', function() {
	//remove_post_type_support( 'post', 'editor' );
	remove_post_type_support( 'page', 'editor' );
}, 99);

// *******************************************************************************	
// CHANGE ADMIN FAVICON **********************************************************
// *******************************************************************************

function favicon4admin() {
echo '<link rel="Shortcut Icon" type="image/x-icon" href="' . get_bloginfo('template_url') . '/favicon.ico" />';
}
add_action( 'admin_head', 'favicon4admin' );

// *******************************************************************************	
// REMOVE SITE HEALTH WIDGET *****************************************************
// *******************************************************************************
add_action('wp_dashboard_setup', 'remove_site_health_dashboard_widget');
function remove_site_health_dashboard_widget()
{
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
}

// *******************************************************************************	
// HELPERS ***********************************************************************
// *******************************************************************************
 add_action( 'load-index.php', 'show_welcome_panel' );

function show_welcome_panel() {
    $user_id = get_current_user_id();

    if ( 1 != get_user_meta( $user_id, 'show_welcome_panel', true ) )
        update_user_meta( $user_id, 'show_welcome_panel', 1 );
}

// *******************************************************************************
// ADD MIME TYPES ****************************************************************
// *******************************************************************************

function allow_svg_json_uploads($upload_mimes)
{
    // Permitir apenas para administradores
    if (current_user_can('administrator')) {
        $upload_mimes['svg']  = 'image/svg+xml';
        $upload_mimes['json'] = 'application/json';
    }
    return $upload_mimes;
}
add_filter('upload_mimes', 'allow_svg_json_uploads');

// Verificação de tipo MIME segura para o WordPress 5.1+
// Garante que SVG e JSON passem na checagem.
function fix_svg_json_mime_type($data, $file, $filename, $mimes)
{
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if ($ext === 'svg') {
        $data['ext']  = 'svg';
        $data['type'] = 'image/svg+xml';
    }

    if ($ext === 'json') {
        $data['ext']  = 'json';
        $data['type'] = 'application/json';
    }

    return $data;
}
add_filter('wp_check_filetype_and_ext', 'fix_svg_json_mime_type', 10, 4);

// *******************************************************************************	
// ADD LOGOUT LINK ***************************************************************
// *******************************************************************************

function wpse_141446_admin_bar_logout( $wp_admin_bar ) {
    if ( is_user_logged_in() ) {
        $wp_admin_bar->add_menu(
            array(
                'id'     => 'my-log-out',
                'parent' => 'top-secondary',
                'title'  => __( 'Log out' ),
                'href'   => wp_logout_url(),
            )
        );
    }
}

add_action( 'admin_bar_menu', 'wpse_141446_admin_bar_logout', 100 );

add_filter('admin_title', 'my_admin_title', 10, 2);

function my_admin_title($admin_title, $title)
{
    return get_bloginfo('name').' :: '.$title;
}

// *******************************************************************************	
// ADD NEW ACF TOOLBAR ***********************************************************
// *******************************************************************************

add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
function my_toolbars( $toolbars )
{
	/*echo '< pre >';
		print_r($toolbars);
	echo '< /pre >';
	die;*/
	
	$toolbars['Basic 01' ] = array();
	$toolbars['Basic 01' ][1] = array('bold', 'formatselect');


	if( ($key = array_search('code' , $toolbars['Full' ][2])) !== false )
	{
	    unset( $toolbars['Full' ][2][$key] );
	}

	unset( $toolbars['Basic' ] );
	return $toolbars;
}

add_filter( 'tiny_mce_before_init', function( $settings ){
	$settings['block_formats'] = 'Paragraph=p;Título=h2;';
	return $settings;
} );

?>