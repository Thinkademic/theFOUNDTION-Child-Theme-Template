<?php
/**************************************************************
 INTIATE JQUERY SETUP
 FUNCTION IS CALLED IN PARENT THEME
**************************************************************/
function init_jquery() {
	#add_action('init', 'init_jquery_google');
	add_action('init', 'init_jquery_local');	
	add_action('init', 'register_jquery_plugins');
	add_action('template_redirect', 'enqueue_jquery_plugins'); 	
}
		
		

/**************************************************************
 USE GOOGLE'S JQUERY SCRIPT
**************************************************************/
function init_jquery_google() {
	if(!is_admin()):
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js', false, 1.4);
	endif;
}



/**************************************************************
 USE LOCAL JQUERY SCRIPT
**************************************************************/
function init_jquery_local() {
	if(!is_admin()):
		$src = get_stylesheet_directory_uri();
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', $src.'/js/jquery142.min.js', false, 1.4);
	endif;
}




/**************************************************************
 COMMENT REPLY ENQUEUE
**************************************************************/
function comment_reply_queue_js(){
  if (!is_admin()){
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
      wp_enqueue_script( 'comment-reply' );
  }
}
add_action('get_header', 'comment_reply_queue_js');




/**************************************************************
 [PG] REGISTER SCRIPTS
**************************************************************/
function register_jquery_plugins() {
	$src = get_stylesheet_directory_uri();
	
	wp_register_script('hoverintent', 	$src."/js/jquery.hoverIntent.js", false, '5', false);
	wp_register_script('mousewheel', 	$src."/js/jquery.mousewheel.js", false, '3.0.4', false);
	wp_register_script('easing', 		$src."/js/jquery.easing.1.2.js", false, '1.1.2', false);	

	wp_register_script('cufon', 		$src."/js/cufon-yui.js", false, '1.09', false);
	
	wp_register_script('superfish', 	$src."/js/superfish.js", false, '1.4.8', false);	
	wp_register_script('supersubs', 	$src."/js/supersubs.js", false, '0.2b', false);
	
	wp_register_script('crossslide', 	$src."/js/jquery.cross-slide.js", false, '0.3.3', false);
	wp_register_script('jcycle',		$src."/js/jquery.cycle.all.js", array('smoothdiv'), '2.99', false);

	wp_register_script('filterable', 	$src."/js/filterable.js", false, '', false);
	wp_register_script('scrollto', 		$src."/js/jquery.scrollTo.js", false, '1.4.2', false);
	wp_register_script('localscroll', 	$src."/js/jquery.localscroll.js", false, '1', false);
	wp_register_script('serialscroll', 	$src."/js/jquery.serialScroll.js", array('scrollto', 'localscroll'), '1.4.2', false);
	wp_register_script('smoothdiv', 	$src."/js/jquery.smoothdivscroll.js", false, '0.8', false);

	wp_register_script('anythingslider',$src."/js/jquery.anythingslider.js", array('anythingsliderfx'), '1.4', false);	
	wp_register_script('anythingsliderfx',$src."/js/jquery.anythingslider.fx.js", false, '1.4', false);		
	wp_register_script('jscrollpane',$src."/js/jquery.jscrollpane.min.js", false, '2.0', false);	
	
	wp_register_script('fancytransitions', 	$src."/js/jquery.fancytransitions.1.8.js", false, '1.8', false);
	wp_register_script('coinslider', 	$src."/js/jquery.coinslider.min.js", false, '1.0', false);

	wp_register_script('orbit', 	$src."/js/jquery.orbit.js", false, '1.1', false);	
	
	wp_register_script('fancybox', 		$src."/js/jquery.fancybox-1.3.1.js", false, '1.31', false);	
	wp_register_script('qtip',		 	$src."/js/jquery.qtip.js", false, '1.0.0r3', false);	
	wp_register_script('lazyload',	 	$src."/js/lazyload.js", false, '1.5.0', false);

	wp_register_script('nivoslider',	 	$src."/js/jquery.nivo.slider.js",  array('jcycle'), '2.5.1', false);		
	
	wp_register_script('portfoliomaker',	 $src."/js/jquery.portfoliomaker.js",  array('jcycle', 'filterable', 'scrollto', 'localscroll', 'serialscroll', 'fancybox'), '1', false);		
	wp_register_script('customthemejquery',	 $src."/js/jquery.".get_stylesheet().".js", false, '1', false);		
}



/**************************************************************
 ENQUEUE SCRIPTS BY DEFAULT
 PARENT THEME WILL CALL THIS FUNCTION VIA ADD_ACTION		
**************************************************************/
function enqueue_jquery_plugins() {
		global $wp_scripts, $post;
		
			$meta = get_post_meta($post->ID, THEMECUSTOMMETAKEY, true);		
		
		#	LOAD JQUERY 
			wp_enqueue_script('jquery');
			
		#	INTERFACE BEHAVIORS - DEPENDANCIES
			use_wp_enqueue( 'hoverintent', true );				
			use_wp_enqueue( 'mousewheel', false );				
			use_wp_enqueue( 'easing', false );					
			
		#	FONT LOAD
			$load = of_get_option('enable_cufon_support', false);
				use_wp_enqueue( 'cufon', $load );
			
		#	MENU
			$load = of_get_option('enable_suckerfish_dropdown', false );	
				use_wp_enqueue( 'superfish', $load );
				use_wp_enqueue( 'supersubs', $load );	

		#	IMAGE GALLERY PLUGINS
			$load = false;	
				use_wp_enqueue( 'crossslide', $load );				// - 	http://tobia.github.com/crossslide/

			$load = false;	
				use_wp_enqueue( 'jcycle', $load );							// - 	http://jquery.malsup.com/cycle/

			if( is_page_template( 'page_portfoliomaker.php') || is_page_template( 'page_portfoliomakermodal.php') || (is_single() && ('portfolio' == get_post_type()))	)
				use_wp_enqueue( 'portfoliomaker', true  );					
							
			$load = false;	
				use_wp_enqueue( 'serialscroll', $load );
				
			$load = false;		
				use_wp_enqueue( 'smoothdiv', $load );	

			$load = false;		
				use_wp_enqueue( 'anythingslider', $load  );	

		#	UI ENHANCEMENT
			$load = false;
				use_wp_enqueue( 'fancybox', $load );

			$load = false;
				use_wp_enqueue( 'nivoslider', $load );	
			
			$load = false;
				use_wp_enqueue( 'lazyload', $load );		
		
		#	JSCROLLPANE
			$load = false;
				use_wp_enqueue( 'jscrollpane', $load );
				
		#	CUSTOM
			$load = false;
				use_wp_enqueue( 'customthemejquery', $load  );
}	



/**************************************************************
 OUTPUT JQUERY FOR DROP DOWNS
**************************************************************/
function enable_suckerfish_dropdown() {
	$enable_dropdown = of_get_option('enable_suckerfish_dropdown', false );
	if( $enable_dropdown ){

print <<<END
	$(function(){
		
		/**********************************************************
		3)	ADMIN EDIT LINKS
				WP FILE LOCATION : functions/functions-jquery.php
				
		{$enable_dropdown}		
		**********************************************************/
		$(".editlink").hide();
		$(".itemhead").hoverIntent(
				function() { 
					$(".editlink",this).fadeIn();
				},
				function() { 
					$(".editlink",this).hide(); 
				}
		);  

		

		$(".masthead-menu").superfish(); 
	});
	
END;

	}
}
add_action('fdt_print_dynamic_themeoptions_js', 'enable_suckerfish_dropdown');	


/**************************************************************
 OUTPUT CUFON SCRIPT
 
 MAYBE APPLY FILTER ON RULES,
**************************************************************/
function enable_cufon_rules() {
	$enable_cufon_support = of_get_option('enable_cufon_support', false );
	
	$cufon_rules = of_get_option('cufon_rules', FALSE);
	
	if( $enable_cufon_support && $cufon_rules ){
	
		echo htmlspecialchars_decode($cufon_rules, ENT_QUOTES);
	}
}
add_action('fdt_print_dynamic_themeoptions_js', 'enable_cufon_rules');	
		
?>