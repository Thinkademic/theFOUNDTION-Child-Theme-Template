<?php

/* =============================================
	OPTIONS FRAMEWORK FUNCTIONS
	
	CHANGEABLE OPTIONS - 
	
	DEFAULT LINK COLORS
	LAYOUTS
	FOOTER TEXT
	LOGO SIZE
	LATEST BLOG TEXT :: PRIMARY H2
	PRIMARY WIDTH
	SECONDARY WIDTH
	
	ITEMHEAD
	METADATA INCLUSION
	LAYOUT BY TEMPLATE
	
	LOOP OPTIONS
	
	LAYOUT OPTIONS...
	
	[Index]
	home
	front-page
	404
	search
	
	
	[Archive]
	date
	author
	category
	tag
	taxonomy
		
    ============================================= */

	
	
define( 'THEMEOPTIONS', 'thefdt_options' );
/**************************************************************
 INSERT theFOUNDATION DEFAULT OPTIONS
 03.07.2011
**************************************************************/
function thefdt_install_options() {
	add_option( THEMEOPTIONS, thefdt_default_options() );
}

/**************************************************************
 RETURNS VALUE OF thefdt FRAMEWORK OPTION FROM THE DB IF IT EXISTS.
 03.07.2011
**************************************************************/
function thefdt_get_option( $name ) {
	$options = get_option( THEMEOPTIONS );
	if ( isset($options[$name]) ) {
		return $options[$name];
	} else {
		return false;
	}
}

/**************************************************************
 ADD VALUE TO thefdt FRAMEWORK OPTIONS
 03.07.2011
**************************************************************/
function thefdt_add_option( $name, $value ) {
	$options = get_option( THEMEOPTIONS );
	if ( $options and !isset($options[$name]) ) {
		$options[$name] = $value;
		return update_option( THEMEOPTIONS, $options );
	} else {
		return false;
	}
}

/**************************************************************
 DELETE VALUE TO thefdt FRAMEWORK OPTIONS
 03.07.2011
**************************************************************/
function thefdt_delete_option( $name ) {
	$options = get_option( THEMEOPTIONS );
	if ( $options[$name] ) {
		unset( $options[$name] );
		return update_option( THEMEOPTIONS, $options );
	} else {
		return false;
	}
}

/**************************************************************
 UPDATE VALUE TO thefdt FRAMEWORK OPTIONS
 03.07.2011
**************************************************************/
function thefdt_update_option( $name, $value ) {
	$options = get_option( THEMEOPTIONS );
	if ( $value != $options[$name] ) {
		$options[$name] = $value;
		return update_option( THEMEOPTIONS, $options );
	} else {
		return false;
	}
}


/**************************************************************
	DEFINE SOME CONSTANT FILE PATHS
**************************************************************/
define('ADMIN_PATH', STYLESHEETPATH . '/functions/themeoptions/');
#define('FUNCTIONS_PATH', STYLESHEETPATH . '/functions/');
#define('FUNCTIONS', CHILDTHEME_URI . 'functions/');


/**************************************************************
	DEFINE SOME CONSTANTS, RELATIVE TO CHILD THEME
**************************************************************/
define('CHILDTHEME_URI', get_stylesheet_directory_uri() );
define('ADMINURI', CHILDTHEME_URI . '/functions/themeoptions/');
define('LAYOUTS_URI', CHILDTHEME_URI . '/css/layouts/');
define('STYLES_URI', CHILDTHEME_URI . '/css/styles/');
define('STYLES', STYLESHEETPATH . '/css/styles/');

/**************************************************************
	 YOU CAN MESS WITH THESE 2 IF YOU WISH.
**************************************************************/
$themedata = get_theme_data(STYLESHEETPATH . '/style.css');
define('THEMENAME', $themedata['Name']);
define('OPTIONS', THEMEOPTIONS); 								//	NAME OF ENTRY INTO DATABASE - WILL BREAK DB IF THIS HAS SPACES!



/**************************************************************
	THESE FILES BUILD OUT THE OPTIONS INTERFACE.  
	LIKELY WON'T NEED TO EDIT THESE.
**************************************************************/
require_once (ADMIN_PATH . 'admin-setup.php');			// CUSTOM FUNCTIONS AND PLUGINS
require_once (ADMIN_PATH . 'admin-interface.php');		// ADMIN INTERFACES 



/**************************************************************
	THESE FILES BUILD OUT THE ADMIN SPECIFIC OPTIONS AND 
	ASSOCIATED FUNCTIONS.
**************************************************************/
require_once (ADMIN_PATH . 'theme-options.php'); 		// OPTIONS PANEL SETTINGS AND CUSTOM SETTINGS
require_once (ADMIN_PATH . 'admin-functions.php'); 	// THEME ACTIONS BASED ON OPTIONS SETTINGS
?>