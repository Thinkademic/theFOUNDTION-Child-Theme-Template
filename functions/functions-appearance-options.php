<?php
/*
*	OPTIONS FRAME WORK PLUGIN CHECK
*
* 	Helper function to return the theme option value. If no value has been saved, it returns $default.
* 	Needed because options are saved as serialized strings.
*
* 	This code allows the theme to work without errors if the Options Framework plugin has been disabled.
*/

if ( !function_exists( 'of_get_option' ) ) {
	function of_get_option($name, $default = false) {
		
		$optionsframework_settings = get_option('optionsframework');
		
		// Gets the unique option id
		$option_name = $optionsframework_settings['id'];
		
		if ( get_option($option_name) ) {
			$options = get_option($option_name);
		}
			
		if ( !empty($options[$name]) ) {
			return $options[$name];
		} else {
			return $default;
		}
	}
}



/* 
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});
	
	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}
	
});
</script>
 
<?php
}
















/*	****** ****** ****** ****** ****** ****** ****** ****** ****** ****** ****** ******
*
*	READ OPTIONS AND PREP FOR THEME USAGE
*
****** ****** ****** ****** ****** ****** ****** ****** ****** ****** ****** ****** */

/*	
*	ALTERNATIVE LAYOUT STYLESHEETS READER
*/
function find_alternative_styles() {

	$alt_stylesheet_path = STYLESHEETPATH. '/css/styles';
	$alt_stylesheets = array();
	if ( is_dir($alt_stylesheet_path) ) {
		if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
			while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
				if(stristr($alt_stylesheet_file, ".css") !== false) {
					$alt_stylesheets[$alt_stylesheet_file] = $alt_stylesheet_file;
				}
			}    
		}
	}


	return $alt_stylesheets;
}





/*	
*	FIND LAYOUTS 
*	NEEDS TO WORK
*/
function find_layouts() {

	$alt_stylesheet_path = STYLESHEETPATH. '/css/styles';
	$alt_stylesheets = array();
	if ( is_dir($alt_stylesheet_path) ) {
		if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
			while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
				if(stristr($alt_stylesheet_file, ".css") !== false) {
					$alt_stylesheets[$alt_stylesheet_file] = $alt_stylesheet_file;
				}
			}    
		}
	}

	return $alt_stylesheets;
}




/*
*	CURRENT TEMPLATE
*/
function layout_for_current_template(){

		// GRABS THE CURRENT TEMPLATE NAME
		$current_template = thefdt_get_current_template();

		// BASED ON CURRENT TEMPLATE FIND PROPER LAYOUT
		$layout = of_get_option('template_'.$current_template, 'layout-p.css' ); 
		
		return $layout;
}




/*	
*	ENQUEUE OUR SELECTED LAYOUTS FOR OUR TEMPLATES
* 	ENQUEUE SELECTED ALTERNATIVE STYLE
*/
function enqueue_template_layout() {
	global $data, $content_width;	

	// LAYOUTS PATH
	$layout_path = get_stylesheet_directory_uri() . '/css/layouts/';
	
		$layout_file_name = layout_for_current_template();
		
		// SET UP A DEFAULT LAYOUT
		if ($layout == '') 
			$layout = 'default.css';

		// CHANGE THE OEMBED SIZES, CURRENTLY WE DISABLE
		// SETTINGS -> MEDIA -> EMBED -> MAX WIDTH
		// AND ALTER THE CONTENT WIDTH
		if($layout_file_name == 'layout-p.css' || $layout_file_name == 'layout-ts-p.css' || $layout_file_name == 'layout-p-bs.css' ) {
			$content_width = of_get_option(  '$set_content_primary_width', '200' ) + of_get_option(  'set_content_secondary_width', '200' );		
		}

		// REGISTER & ENQUEUE STYLE
		wp_register_style('layout', $layout_path . $layout_file_name );
		wp_enqueue_style('layout');


	// ALTERNATIVE STYLES  PATH
	$alt_styles_path = get_stylesheet_directory_uri() . '/css/styles/';
		$alt_style = of_get_option( 'alt_stylesheet', 'default.css' ); 
		
		wp_register_style('alt_style',  $alt_styles_path . $alt_style);
		wp_enqueue_style('alt_style');	
}
add_action('fdt_enqueue_dynamic_css', 'enqueue_template_layout');





/*
*	GET THE CURRENT TEMPLATE BEING USED
*	AND LOAD IT INTO A GLOBAL VARIALBLE
*	
*	CODEX: http://wordpress.stackexchange.com/questions/10537/get-name-of-the-current-template-file
*/
function var_template_include( $current ){
	// Take a peek at the Current Template location
	// Parse it and load it into a global variable
	// For later usage.
	
	$basename = basename($current);
	$templatename = substr($basename, 0,strrpos($basename,'.')); 
    $GLOBALS['current_theme_template'] = $templatename;
	
    return $current;
}
add_filter( 'template_include', 'var_template_include', 1000 );

/*
*	FUNCTION TO GET THE THE CURRENT THEME TEMPLATE
*	ONLY AVAILIABE AFTER THE TEMPLATE IS SET.
*	WILL NOT BE ACCESSIBLE TO ANY FILTERS OR HOOKS THAT
*	OCCUR BEFORE THE TEMPLATE IS SET.
*/
function thefdt_get_current_template( $echo = false ) {
    if( !isset( $GLOBALS['current_theme_template'] ) ) {
		return false;
    } if( $echo ) {
		echo $GLOBALS['current_theme_template'];
    } else {
        return  $GLOBALS['current_theme_template'];
	}	
}
	
	

	
/*
*	TT - POST HEADER ACTION HOOK
*/
function thefdt_loop_header() {
	do_action("thefdt_loop_header");
}
/*
*	RETRIEVE THE POST HEADER
*	LABEL/TEXT THAT GOES BEFORE THE LOOP
*	WHILE DISPLAYING THE INDEX/HOME/FRONT-PAGE TEMPLATES
*/
function thefdt_get_loop_header() {
	
	// FIND THE CURRENT TEMPLATE
	$current_template = thefdt_get_current_template();	
	$headertext = of_get_option(  $current_template."_loop_header" , '' );
	
	$headertext = xtag( 'h2', $headertext, 'id=headline' );
	
	echo $headertext;
}
add_action('thefdt_loop_header', 'thefdt_get_loop_header');





/*
*	POST FOOTER ACTION HOOK
*/
function thefdt_loop_footer() {
	do_action("thefdt_loop_footer");
}
/*
*	RETRIEVE THE POSTS FOOTER
*	LABEL/TEXT THAT GOES BEFORE THE LOOP
*	WHILE DISPLAYING THE INDEX/HOME/FRONT-PAGE TEMPLATES
*/
function thefdt_get_loop_footer() {
	
	// FIND THE CURRENT TEMPLATE
	$current_template = thefdt_get_current_template();	
	$foottext = of_get_option(  $current_template."_loop_footer" , '' );
	
	$foottext = xtag( 'span', $foottext, 'id=footline' );
	
	echo $foottext;
}
add_action('thefdt_loop_footer', 'thefdt_get_loop_footer');














/*
*	RETRIEVE THE ITEM META
*	THIS FUNCTION IS USED BY itemhead.php & itemfoot.php
*/
function thefdt_get_item_meta( $location = "head"){

	$current_template = thefdt_get_current_template();
	$meta_display_key = $current_template.'_item'.$location.'_meta';
	$meta_display = of_get_option( $meta_display_key , array ( 
						'author' => false,
						'date' => false,
						'time' => false,
						'comments' => false,
						'category' => false,
						'tag' => false						
					)
			);

			
	// LOOP THROUGH ARRAY AND CALL CORRESPONDING FUNCTION
	// IF WE EDIT THE ARRAY ORDER, THEN WE CAN EDIT THE OUTPUT ORDER
	// FIGURE OUT HOW TO DO THIS LATER
	$meta = "";		
	foreach ($meta_display as $key => $value) {
		if($value){
			$function_name = "get_".$key."_meta";
			$meta = $meta.$function_name();
		}
	}

	$post_meta = xtag( 'div', $meta, "class=metadata");
	$post_meta = apply_filters( 'thefdt_get_posts_meta_'.$location , $post_meta );
	echo $post_meta;
}


/*
*	RETURNS THE DATE META INFORMATION
*/
function get_date_meta(){
		$date_meta = get_the_date();
		$date_meta = xtag('span', $date_meta, 'class=date-meta');
		
		$date_meta = apply_filters('date_meta', $date_meta);
		return $date_meta;
}


/*
*	RETURNS THE DATE META INFORMATION
*/
function get_time_meta(){
		$time_meta = get_the_time();
		$time_meta = xtag('span', $time_meta, 'class=time-meta');
		
		$time_meta = apply_filters('date_meta', $time_meta);
		return $time_meta;
}


/*
*	RETURNS AUTHOR META
*/
function get_author_meta() {
		$author_meta_format = 	__('by %s', TEXTDOMAIN );
		$author_meta = sprintf( $author_meta_format , '<a href="' . get_author_posts_url(get_the_author_meta( 'ID' )) . '">' . get_the_author() . '</a>' ); 	
		$author_meta = xtag('span', $author_meta, 'class=author-meta' );
		
		$author_meta = apply_filters('thefdt_author_meta', $author_meta);
		return $author_meta;
}



/*
*	RETURNS COMMENTS META
*/
function get_comments_meta() {
	// CAPTURE ECHO OUTPUT
	ob_start();

			comments_popup_link( 
				'<span class="no-comments-meta">'.__('0 Comments',TEXTDOMAIN).'</span>', 
				'<span class="one-comments-meta">'.__('1 Comment',TEXTDOMAIN).'</span>', 
				'<span class="many-comments-meta">% '.__('Comments',TEXTDOMAIN).'</span>', 
				'comments-meta', 
				'<span class="closed-comments-meta">'.__(' Comments Closed',TEXTDOMAIN).'</span>'
			); 
		
		$comment_meta = ob_get_contents();
	ob_end_clean();
	
	$comment_meta = apply_filters('thefdt_comment_link', $comment_meta);
	return $comment_meta;
}


/*
*	RETURNS TAGS META
*/
function get_tag_meta(){
		$tags_meta_format = __('Tags: %s', TEXTDOMAIN );
		if( $tag_list =  get_the_tag_list( '', ', ' ) )
			$tags_meta = sprintf( $tags_meta_format, $tag_list );
		$tags_meta = xtag('span', $tags_meta, 'class=tags-meta');
		
		$tags_meta = apply_filters('thefdt_tags_meta', $tags_meta);
		return $tags_meta;
}


/*
*	RETURNS CATEGORY META
*/
function get_category_meta(){
		$category_meta_format = __('Category %s', TEXTDOMAIN );
		$category_meta = sprintf( $category_meta_format, get_the_nice_category(', ', ' &amp; ' ) );
		$category_meta = xtag('span', $category_meta, 'class=category-meta');
		
		$category_meta = apply_filters('thefdt_category_meta', $category_meta);
		return $category_meta;
}










?>