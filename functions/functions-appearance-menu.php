<?php
/****
 * functions/functions-appearance-menu.php
 *
 * SETUP MENUS FOR THEME
 */

$themefoldername = get_stylesheet();		# USE THE THEMES' FOLDER NAME AS THE PREFIX FOR THE MENU LOCATION NAME
$location = $themefoldername."-nav";	# THE LOCATION NAME, USE THIS NAME WITH THE wp_nav_menu() function
$location_displayname = __( ucwords( $themefoldername." Masthead Menu") );
register_nav_menu( $location, $location_displayname );

register_nav_menu( 'mastlinetop-nav', __( 'Top Mastline Menu' ) );
register_nav_menu( 'mastlinebottom-nav', __( 'Bottom Mastline Menu' ) );
register_nav_menu( 'footertop-nav', __( 'Top Footer Menu' ) );
register_nav_menu( 'footerbottom-nav', __( 'Bottom Footer Menu' ) );
	

?>