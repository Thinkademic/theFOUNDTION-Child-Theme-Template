<?php
/*
*	THESE ARE FUNCTIONS SPECIFIC TO THESE OPTIONS SETTINGS 
*	AND THIS THEME
*/



/*
*	GRAB ALL THE OPTIONS DATA, MAKE IT GLOBAL SO WE DON"T TO  RETRIEVE IT AGAIN
*	IS THIS BEST PRACTICE?
*/
global $data;
$data = get_option(OPTIONS);
	

	


	
	

/**************************************************************
 THEME HEADER OUTPUT - wp_head() 
 THIS SETUPS THE SELECTED LAYOUTS IN THE OPTIONS PANELS
**************************************************************/
if (!function_exists('optionsframework_wp_head')) {
	function optionsframework_wp_head() {

	global $data, $content_width;	

	// GRABS THE CURRENT TEMPLATE NAME
	$current_template = thefdt_get_current_template();

	// BASED ON CURRENT TEMPLATE FIND PROPER LAYOUT
	$layout = $data['template_'.$current_template];
	$data['current_template'] = $layout;
	
	// SET UP A DEFAULT LAYOUT
	if ($layout == '') 
		$layout = 'default.css';
	
	// CHANGE THE OEMBED SIZES, CURRENTLY WE DISABLE
	// SETTINGS -> MEDIA -> EMBED -> MAX WIDTH
	// AND ALTER THE CONTENT WIDTH
	if($layout == 'p.css' || $layout == 'ts-p.css' || $layout == 'p-bs.css' ) {
		$content_width = $data['set_content_primary_width'] + $data['set_content_secondary_width'];
	}
	
	/*	GOT TO FIND A BETTER WAY THEN USING THE GLOBAL $CONTENT_WID
	if(	$oembed_width = $data['set_'.$current_template.'_max_embed_width'] );
		$content_width = $oembed_width;
	*/
	
	
	// REGISTER & ENQUEUE STYLE
	wp_register_style('layout', LAYOUTS_URI . $layout );
    wp_enqueue_style('layout');
		
	// ALTERNATIVE STYLES
	$alt_style = $data['alt_stylesheet'];
	if ($alt_style == '')
		$alt_style = 'default.css';
		
		
	wp_register_style('alt_style',STYLES_URI . $alt_style);
    wp_enqueue_style('alt_style');
	}
}
add_action('fdt_enqueue_dynamic_css', 'optionsframework_wp_head');





/**************************************************************
 OUTPUT CSS FROM STANDARIZED OPTIONS 
 NEED TO WORK ON THIS
**************************************************************/
function of_head_css() {
		global $data, $content_width;

		if ($body_color = $data['body_background'] )
			$output .= "body {background:" . $body_color .";}\n";
		
		if ($header_color = $data['header_background'] )
			$output .= "#header {background:" . $header_color .";}\n";
		
		if ($footer_color = $data['footer_background'] )
			$output .= "#footer {background:" . $footer_color .";}\n";
		
		// SAMPLE TYPOGRAPHY
		if ($typography = $data['body_font'] ) {
			$output .= "body {\n     font-family:" . of_font_stack($typography['face']) . "; \n";
			$output .= "     font-size:" . $typography['size'] . "; \n";
			$output .= "     font-style:".$typography['style'] . "; \n";
			$output .= "     color: ".$typography['color'] . "; \n";
			$output .= "}\n";
		}
		
		$custom_css = $data['custom_css'];
		
		if ($custom_css <> '') {
			$output .= $custom_css . "\n";
		}
		
		// OUTPUT STYLES
		if ($output <> '') {
			echo $output;
		}
	
		$p_width = $content_width;
		$s_width = $data['set_content_secondary_width'];
				
		$comment = $current_template. "[CURRENTTEMPLATE]";
		
		
print <<<END
/*
{$comment}
*/

#primary {
	width: {$p_width};
}

#secondary {
	width: {$s_width};
}	

END;
	
	
	
	

print <<<END

END;
	
}
add_action('fdt_print_dyanmic_css', 'of_head_css');	// do_action fdt_print_dynamic_css is used by a function that uses the wp_head hook, int he parent theme 





/**************************************************************
 OUTPUT JQUERY FROM STANDARIZED OPTIONS
 NEED TO WORK ON THIS 
**************************************************************/
function fdt_dynamic_themeoptions_js() {
		global $data;
		
// USED FOR DROPDOWN MENU
print <<<END

$(function(){
	/**********************************************************
	2)	 SUCKERFISH MENU
			WP THEME FILE : ???
	**********************************************************/
	$("ul.masthead-menu").superfish({
            delay: 400,                            					// one second delay on mouseout 
            animation: {opacity:'show',height:'show'},  	// fade-in and slide-down animation 
            speed:       'fast',                          					// faster animation speed 
            autoArrows:  false,                           			// disable generation of arrow mark-up 
            dropShadows: false                            			// disable drop shadows 	
	});  
	

	/**********************************************************
	3)	ADMIN EDIT LINKS
			WP THEME FILE : ???
	**********************************************************/
	$(".itemhead .editlink").hide();
	$(".itemhead").hover(
			function() { 
				$(".editlink",this).fadeIn();
			},
			function() { 
				$(".editlink",this).hide();
			}
	); 

});
END;

}
add_action('fdt_print_dynamic_themeoptions_js', 'fdt_dynamic_themeoptions_js');






/**************************************************************
 [ALT] FONT STACK
**************************************************************/
function of_font_stack($font){
	$stack = '';
	
	switch ( $font ) {
	
		case 'arial':
			$stack .= 'Arial, sans-serif';
		break;
		case 'verdana':
			$stack .= 'Verdana, "Verdana Ref", sans-serif';
		break;
		case 'trebuchet':
			$stack .= '"Trebuchet MS", Verdana, "Verdana Ref", sans-serif';
		break;
		case 'georgia':
			$stack .= 'Georgia, serif';
		break;
		case 'times':
			$stack .= 'Times, "Times New Roman", serif';
		break;
		case 'tahoma':
			$stack .= 'Tahoma,Geneva,Verdana,sans-serif';
		break;
		case 'palatino':
			$stack .= '"Palatino Linotype", Palatino, Palladio, "URW Palladio L", "Book Antiqua", Baskerville, "Bookman Old Style", "Bitstream Charter", "Nimbus Roman No9 L", Garamond, "Apple Garamond", "ITC Garamond Narrow", "New Century Schoolbook", "Century Schoolbook", "Century Schoolbook L", Georgia, serif';
		break;
		case 'helvetica':
			$stack .= '"Helvetica Neue", Helvetica, Arial, sans-serif';
		break;
	}
	return $stack;
}






/**************************************************************
 [ALT] OUTPUT FAVICON
**************************************************************/
function childtheme_favicon() {
		global $data;
		if ($data['custom_favicon'] != '') {
	        echo '<link rel="shortcut icon" href="'.  $data['custom_favicon']  .'"/>'."\n";
	    }
		else { ?>
			<link rel="shortcut icon" href="<?php echo ADMINURI ?>images/favicon.ico" />
<?php }
}
#add_action('wp_head', 'childtheme_favicon');




/**************************************************************
 [DEL] IF A LOGO IS UPLOADED, UNHOOK THE PAGE TITLE AND DESCRIPTION
**************************************************************/
function add_childtheme_logo() {
	global $data;
	$logo = $data['logo'];
	if (!empty($logo)) {
		remove_action('thematic_header','thematic_blogtitle', 3);
		remove_action('thematic_header','thematic_blogdescription',5);
		add_action('thematic_header','childtheme_logo', 3);
	}
}
#add_action('init','add_childtheme_logo');



/**************************************************************
 [DEL] DISPLAYS THE LOGO
**************************************************************/
function childtheme_logo() {
	global $data;
	$logo = $data['logo'];
    $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div';?>
    <<?php echo $heading_tag; ?> id="site-title">
	<a href="<?php echo home_url(); ?>" title="<?php bloginfo('description'); ?>">
    <img src="<?php echo $logo; ?>" alt="<?php bloginfo('name'); ?>"/>
	</a>
    </<?php echo $heading_tag; ?>>
<?php }

 

/**************************************************************
 [DEL] FILTER FOOTER TEXT
**************************************************************/
function childtheme_footer($thm_footertext) {
	global $data;
	if ($footertext = $data['footer_text'])
    	return $footertext;
}

#add_filter('thematic_footertext', 'childtheme_footer');




/**************************************************************
 [DEL] ANALYTICS CODE
**************************************************************/
function childtheme_analytics() {
	global $data;
	$output = $data['google_analytics'];
	if ( $output <> "" ) 
		echo stripslashes($output) . "\n";
}
#add_action('wp_footer','childtheme_analytics');




?>