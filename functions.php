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
*	DEFINE CONSTANTS AND UNIVERSAL VARS
*/	
define( 'TEXTDOMAIN', 'thefdt' );
define( 'THEMECUSTOMMETAKEY', '_fsl_media_options' );
$content_width = $data['set_content_primary_width'];


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
			update_option( 'thumbnail_size_w',  '340' );
			update_option( 'thumbnail_size_h', '225' );
			update_option( 'thumbnail_crop', 1 );
			
			update_option( 'medium_size_w', '580' );       // ~ 16 to 9 :: 580 > 325 :: FOR LANDSCAPE
			update_option( 'medium_size_h', '380' );        // ~  4 to 3  :: 280 > 380 :: FOR PORTRAITE
			
			update_option( 'large_size_w', '940' );            // ~ 16 to 9 :: 940 > 530
			update_option( 'large_size_h', '520' );             // ~ 4 to 3 :: 520 > 390		
						
			#header( 'Location: '.admin_url().'admin.php?page=my_theme' ) ;			// RELOCATE PAGE AFTER ACTIVATION
		}			

	#	SETUP DEFAULT CROP OPTIONS ON DEFAULT WORDPRESS MEDIA SIZES
		if(	false === get_option("medium_crop")	)
			add_option("medium_crop", "0");
		else
			update_option("medium_crop", "0");
			
		if(false === get_option("large_crop"))
			add_option("large_crop", "1");
		else
			update_option("large_crop", "1");			
	
	#	ESTABLISH CUSTOM THUMBSIZE SIZES	
		add_image_size( "minithumbnail", 85, 50, true );		// DIMENSION SIZE FOR 'MINITHUMBNAIL'
		add_image_size( "minimedium", 130, 75, true );			// DIMENSION SIZE FOR 'MINIMEDIUM'
		add_image_size( "minilarge", 170, 95, true );				// DIMENSION SIZE FOR 'MINILARGE'
		add_image_size( "headerlogo", 180, 180, true );			// DIMENSION SIZE FOR 'HEADERLOGO'
		#add_image_size( "squarethumbnail", 50, 50, true );		// DIMENSION SIZE FOR 'SQAURETHUMBNAIL'
		#add_image_size( "squaremedium", 80, 80, true );		// DIMENSION SIZE FOR 'SQUAREMEDIUM'
		#add_image_size( "squarelarge", 160, 160, true );			// DIMENSION SIZE FOR 'SQUARELARGE'
		
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



/**************************************************************
 [08] INCLUDE IMAGE IN RSS
**************************************************************/
function rss_post_thumbnail($content) {
	global $post;
		$featured_image = get_the_post_thumbnail( $post->ID, 'medium', array('class' => 'alignleft'));
		
		if( $featured_image ) :
			return "<p>" . $featured_image . "</p>";
		else :
			echo "<p>" . get_first_image($post->ID, 'thumbnail') . "</p>";
		endif;
		
	return $content;
}
add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');

?>