<?php
/**************************************************************
 WELCOME TO THE FOUNDATION CHILD THEME TEMPLATE
 ---------------------------------------------------------------------------------------------
 
 THIS TEMPLATE WAS CREATED TO HELP FACILITATE THE
 CREATION OF CHILD THEMES FOR 
 theFOUNDATION THEME FRAMEWORK
 
 FOR INFORMATION ON HOW FILES ARE ORAGINIZED
 AND NAMING CONVENTIONS OF FUNCTIONS PLEASE
 VISIT...
 
 http://thefoundationthemes.com/
**************************************************************/





/*
*	DEFINE DOES NOT OCCUR EARLY ENOUGH FOR CHILD THEMES
*/	
define( 'TEXTDOMAIN', 'thefdt' );
define( 'THEMECUSTOMMETAKEY', '_fsl_media_options' );





/*
*	LOAD OPTIONS, USES OPTIONS FRAMEWORK
*/
require_once(STYLESHEETPATH . '/functions/functions-appearance-options.php');






/**************************************************************
 [00] CUSTOM POST TYPES CUSTOM POST TYPES LOADED FROM PARENT THEME
 
 ENABLED IN ADMIN > APPEARANCE > THEME OPTIONS > CUSTOM POST TYPE
**************************************************************/
if( of_get_option( 'enable_custom_posttype_event', false ) == true )
	require_once(TEMPLATEPATH . '/functions/functions-posttype-event.php');
if( of_get_option( 'enable_custom_posttype_portfolio', false ) == true )
	require_once(TEMPLATEPATH . '/functions/functions-posttype-portfolio.php');
if( of_get_option( 'enable_custom_posttype_designer', false ) == true )
	require_once(TEMPLATEPATH . '/functions/functions-posttype-designer.php');
if( of_get_option( 'enable_custom_posttype_swatch', false ) == true )
	require_once(TEMPLATEPATH . '/functions/functions-posttype-swatch.php');
if( of_get_option( 'enable_custom_posttype_product', false ) == true)
	require_once(TEMPLATEPATH . '/functions/functions-posttype-product.php');
if( of_get_option( 'enable_custom_posttype_post', false ) == true)
	require_once(TEMPLATEPATH . '/functions/functions-posttype-post.php');
if( of_get_option( 'enable_custom_posttype_dictionary', false ) == true )
	require_once(TEMPLATEPATH . '/functions/functions-posttype-dictionary.php');

	
	
	
	
/**************************************************************
 [01] CHILD THEME APPEARANCE OPTION OVERRIDES
**************************************************************/
require_once(STYLESHEETPATH . '/functions/functions-appearance-sidebars.php');
require_once(STYLESHEETPATH . '/functions/functions-appearance-header.php');
require_once(STYLESHEETPATH . '/functions/functions-appearance-widgets.php');
require_once(STYLESHEETPATH . '/functions/functions-appearance-menu.php');





/**************************************************************
 [02] CHILD THEME FONT FUNCTIONS OVERRIDE
**************************************************************/
require_once(STYLESHEETPATH . '/functions/functions-fonts.php');





/**************************************************************
 [03] CHILDTHEME JQUERY + JQUERY LIBRARIES OVERRIDES
**************************************************************/
require_once(STYLESHEETPATH . '/functions/functions-jquery.php');





/**************************************************************
 [04] OVERRIDES FOR 3rd PARTY PLUGINS
**************************************************************/
require_once(STYLESHEETPATH . '/functions/functions-override-plugin.php');




/**************************************************************
 [05] SET CONTENT WIDTH
**************************************************************/
$content_width = $data['set_content_primary_width'];


/**************************************************************
 [05] REMOVE ADMIN BAR
**************************************************************/
#add_filter( 'show_admin_bar', '__return_false' );
#wp_deregister_script('admin-bar');
#wp_deregister_style('admin-bar');
#remove_action('wp_footer','wp_admin_bar_render',1000);	
#add_action( 'admin_print_scripts-profile.php', 'hide_admin_bar_prefs' );
function hide_admin_bar_prefs() { 
	echo '
	<style type="text/css">
		.show-admin-bar { display: none; }
	</style>
	';
}


/**************************************************************
 [06] DEFAULT SETUP POST FORMATS
**************************************************************/
add_theme_support( 'post-formats', array( 
	'aside', 
	'chat', 
	'gallery', 
	'image', 
	'link', 
	'quote', 
	'status', 
	'video', 
	'audio' ) 
);



/*
* [07] SETUP THE CONTENT WIDTH
* 
* NOTE
* thefdt_is_active_secondary() function is
* defined in [childthemefolder]/functions/functions-appearance-sidebars.php
*
*/


/**************************************************************
 [07] IMAGE FORMATS
**************************************************************/
function setup_theme_image_formats() {
		
		if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
			update_option( 'thumbnail_size_w',  '165' );
			update_option( 'thumbnail_size_h', '110' );
			update_option( 'thumbnail_crop', 1 );
			
			update_option( 'medium_size_w', '540' );
			update_option( 'medium_size_h', '360' );
			
			update_option( 'large_size_w', '880' );
			update_option( 'large_size_h', '540' );	
						
			#header( 'Location: '.admin_url().'admin.php?page=my_theme' ) ;
		}			

	#	SETUP DEFAULT CROP OPTIONS ON DEFAULT WORDPRESS MEDIA SIZES
		if(	false === get_option("medium_crop")	)
			add_option("medium_crop", "0");
		else
			update_option("medium_crop", "1");
			
		if(false === get_option("large_crop"))
			add_option("medium_crop", "0");
		else
			update_option("large_crop", "1");			
	
	#	ESTABLISH CUSTOM THUMBSIZE SIZES	
		add_image_size( "minithumbnail", 85, 50, true );			// DIMENSION SIZE FOR THUMBNAIL SIZE 	:: 360 X 240
		add_image_size( "minimedium", 130, 75, true );			// DIMENSION SIZE FOR MEDIUM 			:: 540 X 360
		add_image_size( "minilarge", 170, 95, true );				// DIMENSION SIZE FOR LARGE IMAGES 		:: 880 X 540
		add_image_size( "headerlogo", 180, 180, true );			// DIMENSION SIZE FOR HEADER IMAGES
		add_image_size( "squarethumbnail", 50, 50, true );		// DIMENSION SIZE FOR LARGE IMAGES 		:: 880 X 540
		add_image_size( "squaremedium", 80, 80, true );		// DIMENSION SIZE FOR LARGE IMAGES 		:: 880 X 540
		add_image_size( "squarelarge", 160, 160, true );			// DIMENSION SIZE FOR LARGE IMAGES 		:: 880 X 540		
}


/**************************************************************
 [08] E SHORT CODE AND AUTOEMBED FOR WIDGETS
**************************************************************/
add_filter( 'widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
add_filter( 'widget_text', array( $wp_embed, 'autoembed'), 8 );


/************************************************************************
 [09] NICER EXCERPTS FOR THEME
************************************************************************/
function improved_trim_excerpt($text) {
	global $post;
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		$text = strip_tags($text, '<a><p><img>');
		$excerpt_length = 50;
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words)> $excerpt_length) {
			array_pop($words);
			array_push($words, '[...]');
			$text = implode(' ', $words);
		}
	}
	return $text;
}
#remove_filter('get_the_excerpt', 'wp_trim_excerpt', 10);
#add_filter('get_the_excerpt', 'improved_trim_excerpt', 10);


/************************************************************************
 [10] REPLACE EXCERPT ELLIPSE
************************************************************************/
function replace_excerpt($content) {
	return str_replace('[...]', '...<a class="read_more" href="'. get_permalink() .'">Continue Reading &raquo;</a>', $content);
}
add_filter('get_the_excerpt', 'replace_excerpt', 19);


/**************************************************************
 [07] ENABBLE SHORT CODE AND AUTOEMBED FOR WIDGETS
**************************************************************/
add_filter( 'widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
add_filter( 'widget_text', array( $wp_embed, 'autoembed'), 8 );

?>