<?php
require_once TEMPLATEPATH . '/admin/config.php';
require_once TEMPLATEPATH . '/admin/global.php';
require_once TEMPLATEPATH . '/admin/menus.php';
require_once TEMPLATEPATH . '/admin/includes.php';
require_once TEMPLATEPATH . '/admin/imagesizes.php';
require_once TEMPLATEPATH . '/admin/funcs.php';
require_once TEMPLATEPATH . '/admin/exportparts.php';
require_once TEMPLATEPATH . '/admin/ajax.php';
require_once TEMPLATEPATH . '/admin/collumns.php';


add_filter( 'ai1wm_exclude_themes_from_export',
function ( $exclude_filters ) {
  $exclude_filters[] = 'abtheme/sources/node_modules'; 
  $exclude_filters[] = 'abtheme/sources/scss'; 
  $exclude_filters[] = 'abtheme/sources/scripts';
  return $exclude_filters;
} );
?>