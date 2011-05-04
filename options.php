<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */
function optionsframework_options() {
	
	// TEST DATA
	$test_array = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
	
	// MULTICHECK ARRAY
	$multicheck_array = array("one" => "French Toast", "two" => "Pancake", "three" => "Omelette", "four" => "Crepe", "five" => "Waffle");
	
	// MULTICHECK DEFAULTS
	$multicheck_defaults = array("one" => true,"five" => true);
	
	// BACKGROUND DEFAULTS
	$background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll');
	
	// PULL ALL THE CATEGORIES INTO AN ARRAY
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// PULL ALL THE PAGES INTO AN ARRAY
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages['false'] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// IF USING IMAGE RADIO BUTTONS, DEFINE A DIRECTORY PATH
	$imagepath =  get_bloginfo('stylesheet_directory') . '/css/layouts/icons/';
	$stylespath = get_bloginfo('stylesheet_directory') . '/css/styles/';
	

	/*
	*	BUILD OUR OPTIONS PANEL TABS
	*/			
	$options = array();
		
		
	/*
	*	INTRODUCTION TAB
	*/
	$options[] = array( 
							"name" => "Introduction",
							"type" => "heading"
						);			
	$options[] = array( 
						"name" => "Welcome",
						"desc" => "You are using a child theme that is built on <b><a href='http://framwork.thefoundationthemes.com'>theFOUNDATION</a></b> theme framework to power your WordPress Site.
									There are many aspects of your website that can be customized from the options panel. It's perfect for most users who need make quick adjustments
									to their website. 
									
									<br/><br />If you are an advance or inclined user and would like to build child theme on <b>theFOUNDATION</b> framework, then please take the time to watch/read up 
									on how the framework is organized. The overview is informative and brief and will help you navigate the code base.  It will also help you get familiar with the naming conventions and nomenclature.
									
									<br/><br />One benefit with your decision to use this framework is that you have an architect dedicated to growing quality support documentation. For more specific information please check out the areas below.
									
						",
						"type" => "info");
	$options[] = array( 
							"name" => "Get Support",
							"desc" => "You can find support in a variety of ways.  The theFOUNDATION has an official community forum to support 
										 organic self help. Don't worry, the Architect behind theFOUNDATION spends time nurturing this forum. So your
										 questions will be heard and answered.
						",
						"type" => "info");			
	$options[] = array( 
							"name" => "Explore",
							"type" => "info",
							"desc" => "You can find  free and premium child themes specifically crafted for your niche interest.  Just visit the gallery.
							
							If you have a created a child theme and would like to feature it, please shoot me a message. We also have a showcase
							gallery for websites that are built on theFOUNDATION framework.
							",
						);						
						
	$options[] = array( 
							"name" => "Request a feature",
							"type" => "info",
							"desc" => "The Architect behind theFOUNDATION is eagar to implement key features and if you find yourself wishing that
							the framework was able to do just a little more, then submit a suggestion.  We can work together to make this a great
							opensource theme framework that rivals premium theme framework providers.
							",
						);			
	$options[] = array( 
							"name" => "Report a Bug",
							"type" => "info",
							"desc" => "theFOUNDATION theme framework is currently being developed by a passionate architect.  Sometimes 
							things don't work perfectly.  If you find a bug, reporting it will go a long way towards produce a dependable and
							secure framework.  If you have the chops to improve upon the code base, you can also submit changes.									
							",
						);										
	

	
	/*
	*	TYPOGRAPHY OPTIONS
	*/
	$options = array_merge( $options, typography_options() );
	
	/*
	*	HYPERLINK OPTIONS
	*/
	$options = array_merge( $options, hyperlinks_options() );
	
	/*
	*	HEADER OPTIONS
	*/
	$options = array_merge( $options, header_options() );
	
	/*
	*	BRANDING ( LOGO + FAVICON) OPTIONS
	*/
	$options = array_merge( $options, branding_options() );
						
	/*
	*	TEMPLATE LAYOUT OPTIONS
	*/
	$options = array_merge( $options, template_layout_options() );
		
	/*
	*	ALTERNATIVE STYLES LAYOUT TAB
	*/	
	$options = array_merge($options, alternative_styles_options() );
	
	/*
	*	INDEX TEMPLATE LOOP
	*/	
	$options = array_merge($options, template_index_settings() );
	
	/*
	*	SINGLE LOOP SETTINGS
	*/	
	$options = array_merge($options, template_single_settings() );
		
	/*
	*	PAGE LOOP SETTINGS
	*/	
	$options = array_merge($options, template_page_settings() );
		
	/*
	*	ARCHIVE LOOP SETTINGS
	*/	
	$options = array_merge($options, template_archive_settings() );
	
	
	
	
	/*
	*	CREDITS
	*/	
	$options[] = array( 
							"name" => "Credits & Liscense",
							"type" => "heading"
						);			

	$options[] = array( 
							"name" => "Credits",
							"type" => "info",
							"std" => "It's important to give credit to the variety of projects and individuals that have 
							contributed in direct and indirect ways.
						",
					);		

	
	/*
	*	CUSTOM CSS
	*/	
	$my_options[] = array( 
							"name" => "Custom Css",
							"type" => "heading"
						);			

	$my_options[] = array( 
							"name" => "Custom Css",
							"type" => "info",
							"desc" => "
								theFOUNDATION has an organized way of including css. Familiarize yourself with the setup to quickly identify elements
								for styling. You can read up on the CSS guide for more information. There is also a community css code snippet respository,
								if you are looking for ideas to  quickly add css styling for specifc design elements to your website.
								
								<br /><br />
								If you are inclined you can also easily add your own css rules below.  You can also load a custom css
								file if you like as well. If you like your changes to be permanent, then I recommend that you add a 
								css file to your										
								<span class='highlight'>wp-content/themes/<strong>childthemefoldername</strong>/css/load/</span> folder.  
								Any css file located there will not be erased if you decide to reset the options.
							",
						);		
	$my_options[] = array( 
							"name" => "Custom CSS",
							"desc" => "Quickly add some CSS to your theme by adding it to this block.",
							"id" => "custom_css",
							"std" => "",
							"type" => "textarea"
						);
								
								
								
								
								
								
								
								
	
	$options[] = array( "name" => "Basic Settings",
						"type" => "heading");
							
	$options[] = array( "name" => "Input Text Mini",
						"desc" => "A mini text input field.",
						"id" => "example_text_mini",
						"std" => "Default",
						"class" => "mini",
						"type" => "text");
								
	$options[] = array( "name" => "Input Text",
						"desc" => "A text input field.",
						"id" => "example_text",
						"std" => "Default Value",
						"type" => "text");
							
	$options[] = array( "name" => "Textarea",
						"desc" => "Textarea description.",
						"id" => "example_textarea",
						"std" => "Default Text",
						"type" => "textarea"); 
						
	$options[] = array( "name" => "Input Select Small",
						"desc" => "Small Select Box.",
						"id" => "example_select",
						"std" => "three",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $test_array);			 
						
	$options[] = array( "name" => "Input Select Wide",
						"desc" => "A wider select box.",
						"id" => "example_select_wide",
						"std" => "two",
						"type" => "select",
						"options" => $test_array);
						
	$options[] = array( "name" => "Select a Category",
						"desc" => "Passed an array of categories with cat_ID and cat_name",
						"id" => "example_select_categories",
						"type" => "select",
						"options" => $options_categories);
						
	$options[] = array( "name" => "Select a Page",
						"desc" => "Passed an pages with ID and post_title",
						"id" => "example_select_pages",
						"type" => "select",
						"options" => $options_pages);
						
	$options[] = array( "name" => "Input Radio (one)",
						"desc" => "Radio select with default options 'one'.",
						"id" => "example_radio",
						"std" => "one",
						"type" => "radio",
						"options" => $test_array);
							
	$options[] = array( "name" => "Example Info",
						"desc" => "This is just some example information you can put in the panel.",
						"type" => "info");
											
	$options[] = array( "name" => "Input Checkbox",
						"desc" => "Example checkbox, defaults to true.",
						"id" => "example_checkbox",
						"std" => true,
						"type" => "checkbox");
						
						
						
						
						
						
						
	$options[] = array( "name" => "Advanced Settings",
						"type" => "heading");
						
	$options[] = array( "name" => "Check to Show a Hidden Text Input",
						"desc" => "Click here and see what happens.",
						"id" => "example_showhidden",
						"type" => "checkbox");
	
	$options[] = array( "name" => "Hidden Text Input",
						"desc" => "This option is hidden unless activated by a checkbox click.",
						"id" => "example_text_hidden",
						"std" => "Hello",
						"class" => "hidden",
						"type" => "text");
						
	$options[] = array( "name" => "Uploader Test",
						"desc" => "This creates a full size uploader that previews the image.",
						"id" => "example_uploader",
						"type" => "upload");
						
				
	$options[] = array( "name" =>  "Example Background",
						"desc" => "Change the background CSS.",
						"id" => "example_background",
						"std" => $background_defaults, 
						"type" => "background");
								
	$options[] = array( "name" => "Multicheck",
						"desc" => "Multicheck description.",
						"id" => "example_multicheck",
						"std" => $multicheck_defaults, // These items get checked by default
						"type" => "multicheck",
						"options" => $multicheck_array);
	$options[] = array( "name" => "Colorpicker",
						"desc" => "No color selected by default.",
						"id" => "example_colorpicker",
						"std" => "",
						"type" => "color");
						
	$options[] = array( "name" => "Typography",
						"desc" => "Example typography.",
						"id" => "example_typography",
						"std" => array('size' => '12px','face' => 'verdana','style' => 'bold italic','color' => '#123456'),
						"type" => "typography");			
	return $options;
}















/*
*	BRANDING OPTIONS
*/
function branding_options(){

	// IF USING IMAGE RADIO BUTTONS, DEFINE A DIRECTORY PATH
	$imagepath =  get_bloginfo('stylesheet_directory') . '/css/layouts/icons/';
	$stylespath = get_bloginfo('stylesheet_directory') . '/css/styles/';
		
	$options[] = array( 
							"name" => "Logo & Favicon",
							"type" => "heading"
						);			

	$options[] = array( 
							"name" => "Logo & Favicon",
							"type" => "info",
							"desc" => "Establish your visual identity by using a logo and favicon. These are elements of a website that help you discern your prescence.
							",
						);	

	$options[] = array( 
							"name" => "Custom Logo",
							"desc" => "Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)",
							"id" => "custom_logo",
							"std" => "",
							"type" => "upload"
						);
	
	$options[] = array( 
							"name" => "Custom Favicon",
							"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
							"id" => "custom_favicon",
							"std" => "",
							"type" => "upload"
						); 

	return $options;

}












/*
*	BACKGROUND OPTIONS
*/
function background_options(){
		
	$options[] = array( 
						"name" => "Background",
						"type" => "heading"
						);			

	$options[] = array( 
						"name" => "Background",
						"type" => "info",
						"std" => "One of the best ways to style your website is using a great background. A background can easily
						take a bland website, and turn into an inviting website. The framework currently uses Wordpress built into
						background changer, located in the Appearance menu.
							",
						);	

	$options[] = array( "name" =>  "Body Background Color",
						"desc" => "Pick a background color for the theme (default: #fff).",
						"id" => "body_background",
						"std" => "",
						"type" => "color");
								

	return $options;

}




/*
*	HEADER OPTIONS
*/
function header_options() {

	#	HEADER
	$options[] = array( 
				"name" => "Header",
				"type" => "heading"
			);			

	$options[] = array( 
				"name" => "Header",
				"type" => "info",
				"desc" => " The Header can be one of the most attention grabbing elements of a website. It helps establishes your website's brand, 
					and is often used to convey the personality behind a website. theFOUNDATION uses the built in theme header appreance options.
					
					Headers can also be simple or complicated. Take time to enable or disable header features.
				",
			);	

	$options[] = array( 
			"name" =>  "Header Background Color",
			"desc" => "Pick a background color for the header (default: #fff).",
			"id" => "header_background",
			"std" => "",
			"type" => "color"
			);   
						
						
	return $options;

}




























/*
*	TYPOGRAPHY OPTIONS
*/
function typography_options() {

	$options[] = array( 
						"name" => __('Typography', TEXTDOMAIN),
						"type" => "heading"
					);	
	$options[] = array( 
					"name" => "Typography",
					"desc" => "Default Site Type Settings",
					"id" => "default_font_settings",
					"std" => array('size' => '12px','face' => 'verdana','style' => 'bold italic','color' => '#123456'),
					"type" => "typography"
					);		
						
	return $options;

}









/*
*	HYPERLINK OPTIONS
*/
function hyperlinks_options() {

	$options[] = array( 
						"name" => __('Hyperlinks', TEXTDOMAIN),
						"type" => "heading"
					);	
	$options[] = array( 
						"name" => "Hyperlink Styles",
						"type" => "info",
						"desc" => __("
							Making your website links visible and visually discernable to help your visitor navigate your website. 
							Take the time to adjust your default hyperlink color and styles.<br /> <br />
							If you like to be more specific, please check out theFOUNDATION guide to styling links using the power
							of CSS.
						")
						);	

						
	$options[] = array( 
						"name" => "A:link (default #2098a8)",
						"desc" => "Select a Default Color for you Links",
						"id" => "href_link_value",
						"std" => "#2098a8",
						"type" => "color"
						);       

	$options[] = array( 
						"name" => "A:visited",
						"desc" => "Selected a Default Color for Visited Links",
						"id" => "href_visited_value",
						"std" => "",
						"type" => "color"
						); 

	$options[] = array( 
						"name" => "A:hover (default #2098a8)",
						"desc" => "Select a default hover value for Links upon mouse hover.",
						"id" => "href_value_value",
						"std" => "#2098a8",
						"type" => "color"
						);       
	$options[] = array( 
						"name" => "A:active",
						"desc" => "Select a default value for Links when focus is active",
						"id" => "href_active_value",
						"std" => "",
						"type" => "color"
						); 

					
					
					
	return $options;

}
















/*
*	TEMPLATE LAYOUT TAB
*/
function template_layout_options() {

	// IF USING IMAGE RADIO BUTTONS, DEFINE A DIRECTORY PATH
	$imagepath =  get_bloginfo('stylesheet_directory') . '/css/layouts/icons/';
	$stylespath = get_bloginfo('stylesheet_directory') . '/css/styles/';
	

	$options[] = array( 
				"name" => __('Template Layout', TEXTDOMAIN),
						"type" => "heading"
					);			
	$options[] = array( 
						"name" => "Set the Layout for Supported Templates",
						"type" => "info",
						"desc" => "WordPress has a native <a href='http://codex.wordpress.org/Template_Hierarchy'>template logic</a>
						which this framework uses to provide you with options to configure your layouts. 
						
						<br/><br/>
						The default 'index.php' template is what Wordpress defaults to depending on the theme, you can have 
						specific templates to display your website content.  
					
						<br/><br />
						Configure the layouts for this child theme's suported templates below. You can refer to the Template hierarchy chart as a guide to which
						template takes precedence. The Options are listed from lowest to hightest. 
						If you like would like to create a template for one that does not exist you can read or watch our guide on how to add or edit
						Wordpress Template files.
						",
					);
					
	//	CONTENT WIDTH VALUE								
	$options[] = array( 
						"name" => "Content > Primary Width",
						"desc" => "Set the Primary Width Size for the Primary Content Area, This value is also used by by WordPress' $content_width to contrain the maximum image size",
						"id" => "set_content_primary_width",
						"std" => "540",
						"class" => "mini",							
						"type" => "text"
						); 
	$options[] = array( 
						"name" => "Content > Secondary Width",
						"desc" => "Set the Width of the Secondary Content Area",
						"id" => "set_content_secondary_width",
						"std" => "340",
						"class" => "mini",							
						"type" => "text"
						); 
	//	BUILD LAYOUT OPTIONS ARRAY
	$layout_array = array (
						'layout-p.css' => $imagepath . 'layout-p.png',
						'layout-ls-p.css' => $imagepath . 'layout-ls-p.png',
						'layout-p-rs.css' => $imagepath . 'layout-p-rs.png',
						'layout-ts-p.css' => $imagepath . 'layout-ts-p.png',
						'layout-p-bs.css' => $imagepath . 'layout-p-bs.png'										
						);
	// INDEX TEMPLATE LAYOUT					
						$layout_default = 'layout-ls-p.css';	
	$options[] = array( 
						"name" => "Index",
						"desc" => "Select the Layout for Your Index.php Template",
						"id" => "template_index",
						"std" => $layout_default,
						"type" => "images",
						"options" => $layout_array
						);
	// SINGLE TEMPLATE 
	$options[] = array( 
						"name" => "Single",
						"desc" => "Select the Layout for Your Single.php Template",
						"id" => "template_single",
						"std" => $layout_default,
						"type" => "images",
						"options" => $layout_array
						);							
	// PAGE TEMPLATE 
	$options[] = array( 
						"name" => "Page",
						"desc" => "Select the Layout for Your Page.php Template",
						"id" => "template_page",
						"std" => $layout_default,
						"type" => "images",
						"options" => $layout_array
						);	
	// ARCHIVE TEMPLATE 
	$options[] = array( 
						"name" => "Archive",
						"desc" => "Select the Layout for Your Archive.php Template",
						"id" => "template_archive",
						"std" => $layout_default,
						"type" => "images",
						"options" => $layout_array
						);			
						

	return $options;

}

















/*
*	ALTERNATIVE STYLES
*/
function alternative_styles_options() {

	// IF USING IMAGE RADIO BUTTONS, DEFINE A DIRECTORY PATH
	$imagepath =  get_bloginfo('stylesheet_directory') . '/css/layouts/icons/';
	$stylespath = get_bloginfo('stylesheet_directory') . '/css/styles/';
	

	$options[] = array( 
					"name" => "Styles",
					"type" => "heading"
					);
	$options[] = array( 
					"name" => "Styles",
					"type" => "info",
					"desc" => "Configuring your website can be a time consuming task.  You can quickly switch embeded styles here.
					",
					);							
	$options[] = array( 
					"name" => "Theme Stylesheet",
					"desc" => "Select your themes alternative color scheme.",
					"id" => "alt_stylesheet",
					"std" => "default.css",
					"type" => "radio",
					"options" => find_alternative_styles()
					);
					
	return $options;
}















function template_index_settings(){

	// IF USING IMAGE RADIO BUTTONS, DEFINE A DIRECTORY PATH
	$imagepath =  get_bloginfo('stylesheet_directory') . '/css/layouts/icons/';
	$stylespath = get_bloginfo('stylesheet_directory') . '/css/styles/';
	
	$options[] = array( 
				"name" => __('Loop for Index', TEXTDOMAIN),
				"type" => "heading"
				);			
	$options[] = array( 
				"name" => __('Change Loop Settings for the Index Template', TEXTDOMAIN),
				"type" => "info",
				"desc" => "Customize what displays when the Index Template is being used by Wordpress.  This is the default template that is applied when other templates are not present in the theme."
				);
	$options[] = array( 
				"name" => "Loop Header",
				"desc" => "Enter in descriptive text to describe the listing of each POST entry. This is placed before the Loop begins. For example: <strong>Latest Blog Post</strong> would precede a listing of the latest blog post.",
				"id" => "index_loop_header",
				"std" => "Latest Blog Post",
				"type" => "text"
				); 						
	$item_meta = array ( 
				'author' => 'Author',
				'date' => 'Date',
				'time' => 'Time',
				'comments' => 'Comments',
				'category' => 'Category',
				'tag' => 'Tag'
				);
	$options[] = array( 
				"name" => "Enable Itemhead Meta Display",
				"desc" => "Each listed Post entry will have meta Information that can be displayed below it's title. Enable/Disable their display here",
				"id" => "index_itemhead_meta",
				"std" => array ( 
						'author' => true,
						'date' => true,
						'time' => true,
						'comments' => true,
						'category' => false,
						'tag' => false						
					),
				"type" => "multicheck",
				"options" => array ( 
						'author' => 'Author',
						'date' => 'Date',
						'time' => 'Time',
						'comments' => 'Comments',
						'category' => 'Category',
						'tag' => 'Tag'
					)
				);								
	$options[] = array( 
				"name" => "Enable Itemfoot Meta Display",
				"desc" => "Each listed Post entry has Meta Information that can be displayed after the entry's content. Enable/Disable their display here",
				"id" => "index_itemfoot_meta",
				"std" => array ( 
						'author' => false,
						'date' => false,
						'time' => false,
						'comments' => false,
						'category' => false,
						'tag' => false						
					),
				"type" => "multicheck",
				"options" => array ( 
						'author' => 'Author',
						'date' => 'Date',
						'time' => 'Time',
						'comments' => 'Comments',
						'category' => 'Category',
						'tag' => 'Tag'
					)
				);								
	$options[] = array( 
				"name" => "Loop Footer",
				"desc" => "Althought it is uncommon, you can have a can place text that will display after the listing of post entries.  You could create a back to top link, or a thank you note.",
				"id" => "index_loop_footer",
				"std" => "",
				"type" => "text"
				); 
				
		

	return $options;
}



/*
*	TEMPLATE PAGE SETTINGS
*/
function template_page_settings(){

	// IF USING IMAGE RADIO BUTTONS, DEFINE A DIRECTORY PATH
	$imagepath =  get_bloginfo('stylesheet_directory') . '/css/layouts/icons/';
	$stylespath = get_bloginfo('stylesheet_directory') . '/css/styles/';

	$options[] = array( 
				"name" => __('Loop for Page', TEXTDOMAIN),
				"type" => "heading"
				);			
	$options[] = array( 
				"name" => __('Change Loop Settings for the Page Template', TEXTDOMAIN),
				"type" => "info",
				"desc" => "You can customize what displays when WordPress uses the Page Template. The Page Template is applied to entries made into the Page post type."
				);
	$options[] = array( 
				"name" => "Loop Header",
				"desc" => "Enter in descriptive text to describe the display of a Page. This is placed before the Loop begins. This is not commonly used for Pages, the Title of the Page is sufficient in most cases.",
				"id" => "page_loop_header",
				"std" => "",
				"type" => "text"
				); 						
	$item_meta = array ( 
				'author' => 'Author',
				'date' => 'Date',
				'time' => 'Time',
				'comments' => 'Comments',
				'category' => 'Category',
				'tag' => 'Tag'
				);
	$options[] = array( 
				"name" => "Enable Itemhead Meta Display",
				"desc" => "Each listed Page entry will have meta Information that can be displayed below it's title. Enable/Disable their display here",
				"id" => "page_itemhead_meta",
				"std" => array ( 
						'author' => true,
						'date' => true,
						'time' => true				
					),
				"type" => "multicheck",
				"options" => array ( 
						'author' => 'Author',
						'date' => 'Date',
						'time' => 'Time'
					)
				);								
	$options[] = array( 
				"name" => "Enable Itemfoot Meta Display",
				"desc" => "Each listed Post entry has Meta Information that can be displayed after the entry's content. Enable/Disable their display here",
				"id" => "page_itemfoot_meta",
				"std" => array ( 
						'author' => false,
						'date' => false,
						'time' => false				
					),
				"type" => "multicheck",
				"options" => array ( 
						'author' => 'Author',
						'date' => 'Date',
						'time' => 'Time'
					)
				);								
	$options[] = array( 
				"name" => "Loop Footer",
				"desc" => "Althought it is uncommon, you can have a can place text that will display after the listing of post entries.  You could create a back to top link, or a thank you note.",
				"id" => "page_loop_footer",
				"std" => "",
				"type" => "text"
				); 	
				
	return $options;


}



/*
*	TEMPLATE SINGLE SETTINGS
*/
function template_single_settings(){

	// IF USING IMAGE RADIO BUTTONS, DEFINE A DIRECTORY PATH
	$imagepath =  get_bloginfo('stylesheet_directory') . '/css/layouts/icons/';
	$stylespath = get_bloginfo('stylesheet_directory') . '/css/styles/';

	$options[] = array( 
				"name" => __('Loop for Single', TEXTDOMAIN),
				"type" => "heading"
				);			
	$options[] = array( 
				"name" => __('Change Loop Settings for Archive the Single Template', TEXTDOMAIN),
				"type" => "info",
				"desc" => "You can customize what display when WordPress uses the Single Template to display an entry made into the Post"
				);
	$options[] = array( 
				"name" => "Loop Header",
				"desc" => "Enter in descriptive text to describe the the display of a Single Post. This is placed before the Loop begins. For example: <strong>You are Readiing</strong> precede a listing of the latest blog post.",
				"id" => "single_loop_header",
				"std" => "",
				"type" => "text"
				); 						
	$item_meta = array ( 
				'author' => 'Author',
				'date' => 'Date',
				'time' => 'Time',
				'comments' => 'Comments',
				'category' => 'Category',
				'tag' => 'Tag'
				);
	$options[] = array( 
				"name" => "Enable Itemhead Meta Display",
				"desc" => "Each listed Post entry will have meta Information that can be displayed below it's title. Enable/Disable their display here",
				"id" => "single_itemhead_meta",
				"std" => array ( 
						'author' => true,
						'date' => true,
						'time' => true,
						'comments' => true,
						'category' => false,
						'tag' => false						
					),
				"type" => "multicheck",
				"options" => array ( 
						'author' => 'Author',
						'date' => 'Date',
						'time' => 'Time',
						'comments' => 'Comments',
						'category' => 'Category',
						'tag' => 'Tag'
					)
				);								
	$options[] = array( 
				"name" => "Enable Itemfoot Meta Display",
				"desc" => "Each listed Post entry has Meta Information that can be displayed after the entry's content. Enable/Disable their display here",
				"id" => "single_itemfoot_meta",
				"std" => array ( 
						'author' => false,
						'date' => false,
						'time' => false,
						'comments' => false,
						'category' => false,
						'tag' => false						
					),
				"type" => "multicheck",
				"options" => array ( 
						'author' => 'Author',
						'date' => 'Date',
						'time' => 'Time',
						'comments' => 'Comments',
						'category' => 'Category',
						'tag' => 'Tag'
					)
				);								
	$options[] = array( 
				"name" => "Loop Footer",
				"desc" => "Althought it is uncommon, you can have a can place text that will display after the listing of post entries.  You could create a back to top link, or a thank you note.",
				"id" => "single_loop_footer",
				"std" => "",
				"type" => "text"
				); 		
				
	return $options;
}




/*
*	TEMPLATE ARCHIVE SETTINGS
*/
function template_archive_settings(){

	// IF USING IMAGE RADIO BUTTONS, DEFINE A DIRECTORY PATH
	$imagepath =  get_bloginfo('stylesheet_directory') . '/css/layouts/icons/';
	$stylespath = get_bloginfo('stylesheet_directory') . '/css/styles/';
	
	$options[] = array( 
				"name" => __('Loop for Achive', TEXTDOMAIN),
				"type" => "heading"
				);			
	$options[] = array( 
				"name" => __('Change Loop Settings for the Archive Template', TEXTDOMAIN),
				"type" => "info",
				"desc" => "You can customize what displays when WordPress uses the Page Template. The Page Template is applied to entries made into the Page post type."
				);
	$options[] = array( 
				"name" => "Loop Header",
				"desc" => "Enter in descriptive text to describe the display of an Archive Page. This is placed before the Loop begins. This is not commonly used for Pages, the Title of the Page is sufficient in most cases.",
				"id" => "page_loop_header",
				"std" => "Archives",
				"type" => "text"
				); 						
	$item_meta = array ( 
				'author' => 'Author',
				'date' => 'Date',
				'time' => 'Time',
				'comments' => 'Comments',
				'category' => 'Category',
				'tag' => 'Tag'
				);
	$options[] = array( 
				"name" => "Enable Itemhead Meta Display",
				"desc" => "Each listed Page entry will have meta Information that can be displayed below it's title. Enable/Disable their display here",
				"id" => "page_itemhead_meta",
				"std" => array ( 
						'author' => true,
						'date' => true,
						'time' => true				
					),
				"type" => "multicheck",
				"options" => array ( 
						'author' => 'Author',
						'date' => 'Date',
						'time' => 'Time'
					)
				);								
	$options[] = array( 
				"name" => "Enable Itemfoot Meta Display",
				"desc" => "Each listed Post entry has Meta Information that can be displayed after the entry's content. Enable/Disable their display here",
				"id" => "page_itemfoot_meta",
				"std" => array ( 
						'author' => false,
						'date' => false,
						'time' => false				
					),
				"type" => "multicheck",
				"options" => array ( 
						'author' => 'Author',
						'date' => 'Date',
						'time' => 'Time'
					)
				);								
	$options[] = array( 
				"name" => "Loop Footer",
				"desc" => "Althought it is uncommon, you can have a can place text that will display after the listing of post entries.  You could create a back to top link, or a thank you note.",
				"id" => "page_loop_footer",
				"std" => "",
				"type" => "text"
				); 		
		
	return $options;
}


?>