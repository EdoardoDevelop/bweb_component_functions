<?php
/**
* ID: theme    
* Name: Tema
* Description: Crea tema principale del sito, template di categorie,archivi ecc. ecc.
* Icon: dashicons-admin-appearance
 * Version: 1.6
* 
*/

// ABS PATH
if ( !defined( 'ABSPATH' ) ) { exit; }
define( 'PLUGIN_THEME_DIR', plugin_dir_path( __FILE__ ) );
if ( !is_admin() ):
    require plugin_dir_path( __FILE__ ) ."inc/bootstrap_navwalker.php";
endif;
require plugin_dir_path( __FILE__ ) ."inc/functions.php";
if ( is_admin() ){
    require plugin_dir_path( __FILE__ ) ."inc/settings.php";
    
    require plugin_dir_path( __FILE__ ) ."inc/page_admin_settings/create.php";
    
    require plugin_dir_path( __FILE__ ) ."inc/page_admin_settings/dev.php";
    
}
