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
	*	TEMPLATE LAYOUT TAB
	*/
	$options[] = array( 
						"name" => "Template Layout",
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
						$layout_default = 'layout-p.css';	
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

		
		
		
		
		
		
		
	/*
	*	ALTERNATIVE STYLES LAYOUT TAB
	*/	
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
	

	
		
		
		
		
		
		
	/*
	*	LOOP SETTINGS
	*/	
	$options[] = array( 
				"name" => "Index Loop Settings",
				"type" => "heading"
				);			
	$options[] = array( 
				"name" => "Index Loop",
				"type" => "info",
				"std" => "You can enable and disable the way elements display for Post content.
				",
				);
	$options[] = array( 
				"name" => "Loop Header",
				"desc" => "Enter in descriptive text to describe the listing of post items/entries. Occurs Before the Loop. For example: <strong>Latest Blog Post</strong>",
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
				"desc" => "Each Queried Post has Meta Information that can be displayed before the content. Enable/Disable their display here",
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
				"desc" => "Each Queried Post has Meta Information that can be displayed after the content. Enable/Disable their display here",
				"id" => "index_itemfoot_meta",
				"std" => array ( 
						'author' => false,
						'date' => false,
						'time' => false,
						'comments' => false,
						'category' => true,
						'tag' => true						
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
				"desc" => "Enter in descriptive text to describe the listing of post items/entries. Occurs <strong>After the Loop</strong>. For example: <strong>Don't Forget to...</strong>",
				"id" => "index_loop_footer",
				"std" => "",
				"type" => "text"
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
						
	$options[] = array( "name" => "Example Image Selector",
						"desc" => "Images for layout.",
						"id" => "example_images",
						"std" => "2c-l-fixed",
						"type" => "images",
						"options" => array(
							'1col-fixed' => $imagepath . '1col.png',
							'2c-r-fixed' => $imagepath . '2cr.png',
							'2c-l-fixed' => $imagepath . '2cl.png',
							'3c-fixed' => $imagepath . '3cm.png',
							'3c-r-fixed' => $imagepath . '3cr.png')
						);
						
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














?>