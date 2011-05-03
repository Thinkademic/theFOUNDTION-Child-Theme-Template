<?php
/**************************************************************
 [01] INITIATTE OPTIONS FRAME WORK
**************************************************************/
add_action('init','of_options');





/**************************************************************
 [01] DEFINE THE THEME OPTIONS THAT WILL BE
		DISPLAYED AT APPEARANCE->THEMEOPTIONS
**************************************************************/
if (!function_exists('of_options')) {
	function of_options(){
		
			//	ACCESS THE WORDPRESS CATEGORIES VIA AN ARRAY
			$of_categories = array();  
			$of_categories_obj = get_categories('hide_empty=0');
			foreach ($of_categories_obj as $of_cat) {
				$of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
				}
			$categories_tmp = array_unshift($of_categories, "Select a category:");    
			

			
			//	ACCESS THE WORDPRESS PAGES VIA AN ARRAY
			$of_pages = array();
			$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
			foreach ($of_pages_obj as $of_page) {
				$of_pages[$of_page->ID] = $of_page->post_name; 
				}
			$of_pages_tmp = array_unshift($of_pages, "Select a page:"); 

			
						
			//	ALTERNATIVE LAYOUT STYLESHEETS READER
			$alt_stylesheet_path = STYLES;
			$alt_stylesheets = array();
			if ( is_dir($alt_stylesheet_path) ) {
				if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
					while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
						if(stristr($alt_stylesheet_file, ".css") !== false) {
							$alt_stylesheets[] = $alt_stylesheet_file;
						}
					}    
				}
			}

			
			
			//	DUMMY TESTING
			$my_options_select = array("one","two","three","four","five"); 
			$my_options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 

			
				
			/**************************************************************
				TO DO: ADD OPTIONS/FUNCTIONS THAT USE THESE
			**************************************************************/
			$uploads_arr = wp_upload_dir();
			$all_uploads_path = $uploads_arr['path'];
			$all_uploads = get_option('of_uploads');
			$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
			$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
			$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

			// IMAGE ALIGNMENT RADIO BOX
			$my_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

			// IMAGE LINKS TO OPTIONS
			$my_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


			/**************************************************************
				THE OPTIONS ARRAY
			**************************************************************/			
			// SET THE OPTIONS ARRAY
			global $my_options;
			$my_options = array();

	









	
		#	INTRODUCTION
			$my_options[] = array( 
									"name" => "Introduction",
									"type" => "heading"
								);			
			$my_options[] = array( 
									"name" => "Introduction",
									"type" => "info",
									"std" => "You are using a child theme that is built on <b><a href='http://framwork.thefoundationthemes.com'>theFOUNDATION</a></b> theme framework to power your WordPress Site.
												There are many aspects of your website that can be customized from the options panel. It's perfect for most users who need make quick adjustments
												to their website. 
												
												<br/><br />If you are an advance or inclined user and would like to build child theme on <b>theFOUNDATION</b> framework, then please take the time to watch/read up 
												on how the framework is organized. The overview is informative and brief and will help you navigate the code base.  It will also help you get familiar with the naming conventions and nomenclature.
												
												<br/><br />One benefit with your decision to use this framework is that you have an architect dedicated to growing quality support documentation. For more specific information please check out the areas below.
												
									",
								);			
			$my_options[] = array( 
									"name" => "Get Support",
									"type" => "infopanel_half",
									"std" => "You can find support in a variety of ways.  The theFOUNDATION has an official community forum to support 
												 organic self help. Don't worry, the Architect behind theFOUNDATION spends time nurturing this forum. So your
												 questions will be heard and answered.
									",
								);			
			$my_options[] = array( 
									"name" => "Explore",
									"type" => "infopanel_half",
									"std" => "You can find  free and premium child themes specifically crafted for your niche interest.  Just visit the gallery.
									
									If you have a created a child theme and would like to feature it, please shoot me a message. We also have a showcase
									gallery for websites that are built on theFOUNDATION framework.
									",
								);						
								
			$my_options[] = array( 
									"name" => "Request a feature",
									"type" => "infopanel_half",
									"std" => "The Architect behind theFOUNDATION is eagar to implement key features and if you find yourself wishing that
									the framework was able to do just a little more, then submit a suggestion.  We can work together to make this a great
									opensource theme framework that rivals premium theme framework providers.
									",
								);			
			$my_options[] = array( 
									"name" => "Report a Bug",
									"type" => "infopanel_half",
									"std" => "theFOUNDATION theme framework is currently being developed by a passionate architect.  Sometimes 
									things don't work perfectly.  If you find a bug, reporting it will go a long way towards produce a dependable and
									secure framework.  If you have the chops to improve upon the code base, you can also submit changes.									
									",
								);										
	
	
	




	
	
	
	
	
			/*
			*	LOAD LAYOUTS 
			*	TODO AUTO DETECT AVAILABLE CSS FILES FROM DIRECTORY
			*	
			*/
			$url =  LAYOUTS_URI . 'icons/';			
			$layout_array = array (
											'layout-p.css' => $url . 'layout-p.png',
											'layout-ls-p.css' => $url . 'layout-ls-p.png',
											'layout-p-rs.css' => $url . 'layout-p-rs.png',
											'layout-ts-p.css' => $url . 'layout-ts-p.png',
											'layout-p-bs.css' => $url . 'layout-p-bs.png'										
										);
			$layout_default = 'layout-p.css';							
										
			
			/*
			* 	TEMPLATE AND LAYOUT OPTIONS
			*/
			$my_options[] = array( 
									"name" => "Template Options",
									"type" => "heading"
								);			
			$my_options[] = array( 
									"name" => "Template Options",
									"type" => "info",
									"std" => "WordPress has a native <a href='http://codex.wordpress.org/Template_Hierarchy'>template logic</a>
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
			$my_options[] = array( "name" => "Content > Primary Width",
								"desc" => "Set the Primary Width Size for the Primary Content Area, This value is also used by by WordPress' $content_width to contrain the maximum image size",
								"id" => "set_content_primary_width",
								"std" => "540",
								"type" => "text"); 
			$my_options[] = array( "name" => "Content >Secondary Width",
								"desc" => "Set the Width of the Secondary Content Area",
								"id" => "set_content_secondary_width",
								"std" => "340",
								"type" => "text"); 

			
			//	TEMPLATE - INDEX
			$url =  ADMINURI . 'images/';
			$my_options[] = array( 
								"name" => "Index",
								"desc" => "Select the Layout for Your Index Template",
								"id" => "template_index",
								"std" => $layout_default,
								"type" => "images",
								"options" => $layout_array
								);
								
																
			//	TEMPLATE  - PAGE					
			$my_options[] = array( 
								"name" => "Page",
								"desc" => "Overide Index.php Templates for <a href='http://codex.wordpress.org/Pages' target='_blank' title='Wordpress Codex Page Definition'>Pages</a>",
								"id" => "override_template_page",
								"std" => true,
								"type" => "checkbox"); 								
			$my_options[] = array( 
								//	"name" => "Page.php Template Layout",
								"desc" => "Select the relative positioning between primary content and secondary content areas. The Primary Content area, contains blog post, and page content. The Secondary Content area contains widgets which have additional layout options.",
								"id" => "template_page",
								"std" => $layout_default,
								"type" => "images",
								"options" => $layout_array
								);	
								

			//	TEMPLATE  - SINGLE			
			$my_options[] = array( 
								"name" => "Single",
								"desc" => "Select the relative positioning between primary content and secondary content areas. The Primary Content area, contains blog post, and page content. The Secondary Content area contains widgets which have additional layout options.",
								"id" => "template_single",
								"std" => $layout_default,
								"type" => "images",
								"options" => $layout_array
								);	

								
								
			//	TEMPLATE  - ARCHIVE			
			$my_options[] = array( 
								"name" => "Archive",
								"desc" => "Select the relative positioning between primary content and secondary content areas. The Primary Content area, contains blog post, and page content. The Secondary Content area contains widgets which have additional layout options.",
								"id" => "template_archive",
								"std" => $layout_default,
								"type" => "images",
								"options" => $layout_array
								);								
								
			









			
		#	STYLES
			$my_options[] = array( "name" => "Styles",
									"type" => "heading"
								);
					
			$my_options[] = array( 
									"name" => "Styles",
									"type" => "info",
									"std" => "Configuring your website can be a time consuming task.  You can quickly switch embeded styles here.
									",
								);						
								
			$my_options[] = array( "name" => "Theme Stylesheet",
									"desc" => "Select your themes alternative color scheme.",
									"id" => "alt_stylesheet",
									"std" => "default.css",
									"type" => "select",
									"options" => $alt_stylesheets
								); 	// $alt_stylesheets is populated by a function that searches a folder for css files
	



						
	
	
		#	TYPOGRAPHY
			$my_options[] = array( 
									"name" => "Typography",
									"type" => "heading"
								);			
	
			$my_options[] = array( 
									"name" => "Typography",
									"type" => "info",
									"std" => "Typography is an important aspect of any well designed website.  Take the time to set your website typography. 
										Make sure you factor in legibility on the devices and screens commonly used by your viewing audience.
									",
								);	
	
			$my_options[] = array( "name" => "Body Font",
								"desc" => "Specify the body font properties",
								"id" => "body_font",
								"std" => array('size' => '12px','face' => 'arial','style' => 'normal','color' => '#000000'),
								"type" => "typography");  

			$my_options[] = array( "name" => "Typography",
								"desc" => "This is a typographic specific option.",
								"id" => "typography",
								"std" => array('size' => '12px','face' => 'verdana','style' => 'bold italic','color' => '#123456'),
								"type" => "typography");  







								
								
								
		#	HYPERLINK STYLES
			$my_options[] = array( 
									"name" => "Hyperlink Styles",
									"type" => "heading"
								);			
	
			$my_options[] = array( 
									"name" => "Hyperlink Styles",
									"type" => "info",
									"std" => "Making your website links visible and visually discernable help your users explore your content. 
												Take the time to adjust your default hyperlink color and styles.<br /> <br />
												If you like to be more specific, please check out theFOUNDATION guide to styling links using the power
												of CSS.
									",
								);	
	
								
			$my_options[] = array( "name" => "A:link (default #2098a8)",
								"desc" => "Color selected.",
								"id" => "example_colorpicker_2",
								"std" => "#2098a8",
								"type" => "color");       

			$my_options[] = array( "name" => "A:visted",
								"desc" => "No color selected.",
								"id" => "example_colorpicker",
								"std" => "",
								"type" => "color"); 

			$my_options[] = array( "name" => "A:hover (default #2098a8)",
								"desc" => "Color selected.",
								"id" => "example_colorpicker_2",
								"std" => "#2098a8",
								"type" => "color");       

			$my_options[] = array( "name" => "A:active",
								"desc" => "No color selected.",
								"id" => "example_colorpicker",
								"std" => "",
								"type" => "color"); 







		#	FAVICON & LOGO
			$my_options[] = array( 
									"name" => "Logo & Favicon",
									"type" => "heading"
								);			
	
			$my_options[] = array( 
									"name" => "Logo & Favicon",
									"type" => "info",
									"std" => "Establish your visual identity by using a logo and favicon. These are elements of a website that help you discern your prescence.
									",
								);	
		
			$my_options[] = array( "name" => "Custom Logo",
								"desc" => "Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)",
								"id" => "logo",
								"std" => "",
								"type" => "upload");
			
			
			$my_options[] = array( "name" => "Custom Favicon",
								"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
								"id" => "custom_favicon",
								"std" => "",
								"type" => "upload"); 		
	
	
	
	
	
	
		#	BACKGROUND
			$my_options[] = array( 
									"name" => "Background",
									"type" => "heading"
								);			
	
			$my_options[] = array( 
									"name" => "Background",
									"type" => "info",
									"std" => "One of the best ways to style your website is using a great background. A background can easily
									take a bland website, and turn into an inviting website. The framework currently uses Wordpress built into
									background changer, located in the Appearance menu.
									",
								);	

			$my_options[] = array( "name" =>  "Body Background Color",
								"desc" => "Pick a background color for the theme (default: #fff).",
								"id" => "body_background",
								"std" => "",
								"type" => "color");
								

	
	
	
	
	
	
	
	
	
	
	
		#	HEADER
			$my_options[] = array( 
									"name" => "Header",
									"type" => "heading"
								);			
	
			$my_options[] = array( 
									"name" => "Header",
									"type" => "info",
									"std" => " The Header can be one of the most attention grabbing elements of a website. It helps establishes your website's brand, 
										and is often used to convey the personality behind a website. theFOUNDATION uses the built in theme header appreance options.
										
										Headers can also be simple or complicated. Take time to enable or disable header features.
									",
								);	

			$my_options[] = array( "name" =>  "Header Background Color",
								"desc" => "Pick a background color for the header (default: #fff).",
								"id" => "header_background",
								"std" => "",
								"type" => "color");   


								
								
								
								
		#	INDEX POST CONTENT -> PERHAPS WE CAN CREATE A LOOP
			$my_options[] = array( 
									"name" => "Index Loop Settings",
									"type" => "heading"
								);			
			$my_options[] = array( 
									"name" => "Index Loop",
									"type" => "info",
									"std" => "You can enable and disable the way elements display for Post content.
									",
								);
			$my_options[] = array( "name" => "Loop Header",
								"desc" => "Enter in descriptive text to describe the listing of post items/entries. Occurs Before the Loop. For example: <strong>Latest Blog Post</strong>",
								"id" => "index_loop_header",
								"std" => "",
								"type" => "text"); 						
			$item_meta = array ( 
									'author' => 'Author',
									'date' => 'Date',
									'time' => 'Time',
									'comments' => 'Comments',
									'category' => 'Category',
									'tag' => 'Tag'
								);
			$my_options[] = array( 
									"name" => "Enable Itemhead Meta Display",
									"desc" => "Each Queried Post has Meta Information that can be displayed before the content. Enable/Disable their display here",
									"id" => "index_itemhead_meta",
									"std" => array("author","date"),
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

			$my_options[] = array( 
									"name" => "Enable Itemfoot Meta Display",
									"desc" => "Each Queried Post has Meta Information that can be displayed after the content. Enable/Disable their display here",
									"id" => "index_itemfoot_meta",
									"std" => array("category","tag"),
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
			$my_options[] = array( "name" => "Loop Footer",
								"desc" => "Enter in descriptive text to describe the listing of post items/entries. Occurs <strong>After the Loop</strong>. For example: <strong>Don't Forget to...</strong>",
								"id" => "index_loop_footer",
								"std" => "",
								"type" => "text"); 						

								
			/*					
								
								
		#	SINGLE POST CONTENT 
			$my_options[] = array( 
									"name" => "Single Loop",
									"type" => "heading"
								);			
			$my_options[] = array( 
									"name" => "Loop Content",
									"type" => "info",
									"std" => "Edit the display of elements for the Single Template Loop
									",
								);
			$my_options[] = array( "name" => "Loop Header",
								"desc" => "Enter in descriptive text to describe the listing of post items/entries. Occurs Before the Loop. For example: <strong>Latest Blog Post</strong>",
								"id" => "single_loop_header",
								"std" => "",
								"type" => "text"); 						
			$item_meta = array ( 
									'author' => 'Author',
									'date' => 'Date',
									'time' => 'Time',
									'category' => 'Category',
									'tag' => 'Tag'
								);
			$my_options[] = array( 
									"name" => "Enable Itemhead Meta Display",
									"desc" => "Each Queried Post has Meta Information that can be displayed before the content. Enable/Disable their display here",
									"id" => "single_itemhead_meta",
									"std" => array("author","date"),
									"type" => "multicheck",
									"options" => $item_meta
								);								

			$my_options[] = array( 
									"name" => "Enable Itemfoot Meta Display",
									"desc" => "Each Queried Post has Meta Information that can be displayed after the content. Enable/Disable their display here",
									"id" => "single_itemfoot_meta",
									"std" => array("category","tag"),
									"type" => "multicheck",
									"options" => $item_meta
								);								
			$my_options[] = array( "name" => "Loop Footer",
								"desc" => "Enter in descriptive text to describe the listing of post items/entries. Occurs <strong>After the Loop</strong>. For example: <strong>Don't Forget to...</strong>",
								"id" => "single_loop_footer",
								"std" => "",
								"type" => "text"); 									
								
								
								
								
								
								
															
		#	PAGE CONTENT
			$my_options[] = array( 
									"name" => "Pages",
									"type" => "heading"
								);			
			$my_options[] = array( 
									"name" => "Pages Content",
									"type" => "info",
									"std" => "You can enable and disable the various elements for your Pages.  If you are looking to change the default layout for Pages, you can go to <strong>Template Options</strong>
									",
								);
			$my_options[] = array( "name" => "Pages Header",
								"desc" => "Enter in descriptive text to describe the listing of Pages items/entries. Occurs Before the Loop. For example: <strong>Learn About</strong>",
								"id" => "pages_header",
								"std" => "",
								"type" => "text"); 						
			$item_meta = array (
									'author' => 'Author',
									'date' => 'Date',
									'time' => 'Time'
								);
			$my_options[] = array( 
									"name" => "Enable Pages Itemhead Meta Display",
									"desc" => "Each Queried Post has Meta Information that can be displayed before the content. Enable/Disable their display here",
									"id" => "itemhead_meta",
									"std" => array(""),
									"type" => "multicheck",
									"options" => $item_meta
								);								
			$my_options[] = array( 
									"name" => "Enable Pages Itemfoot Meta Display",
									"desc" => "Each Queried Post has Meta Information that can be displayed after the content. Enable/Disable their display here",
									"id" => "itemfoot_meta",
									"std" => array(""),
									"type" => "multicheck",
									"options" => $item_meta
								);								
			$my_options[] = array( "name" => "Pages Content Footer",
								"desc" => "Enter in descriptive text to describe the listing of post items/entries. Occurs <strong>After the Loop</strong>. For example: <strong>Don't Forget to...</strong>",
								"id" => "pages_footer",
								"std" => "",
								"type" => "text"); 						


								

*/










			
								
			// FOOTER					
			$my_options[] = array( 
									"name" => "Footer",
									"type" => "heading"
								);			
			$my_options[] = array( 
									"name" => "Footer",
									"type" => "info",
									"std" => "The Footer...						
									",
								);			
			$my_options[] = array( 
									"name" => "Footer Text",
									"desc" => "You can use the following shortcodes in your footer text: [wp-link] [theme-link] [loginout-link] [blog-title] [blog-link] [the-year]",
									"id" => "footer_text",
									"std" => "Powered by [wp-link]. Built on the [theme-link].",
									"type" => "textarea"
								);                                                          
			$my_options[] = array( 
									"name" =>  "Footer Background Color",
									"desc" => "Pick a background color for the footer (default: #fff).",
									"id" => "footer_background",
									"std" => "",
									"type" => "color"
								);
																
				
	
	
	
	
	
	
	
	
			// SOCIAL MEDIA
			$my_options[] = array( 
									"name" => "Social Media",
									"type" => "heading"
								);			
	
			$my_options[] = array( 
									"name" => "Social Media",
									"type" => "info",
									"std" => "Social Media...						
									",
								);	







			// SEARCH ENGINE OPTIMIZATION					
			$my_options[] = array( 
									"name" => "SEO",
									"type" => "heading"
								);			
	
			$my_options[] = array( 
									"name" => "SEO",
									"type" => "info",
									"std" => "SEO...						
									",
								);		
														   
			$my_options[] = array( "name" => "Tracking Code",
								"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
								"id" => "google_analytics",
								"std" => "",
								"type" => "textarea");	









	
	
			// CREDITS
			$my_options[] = array( 
									"name" => "Credits & Liscense",
									"type" => "heading"
								);			
	
			$my_options[] = array( 
									"name" => "Credits",
									"type" => "info",
									"std" => "It's important to give credit to the variety of projects and individuals that have 
									contributed in direct and indirect ways.
									",
								);		
	
	
	
	
	
	
	
	
	
			// CREDITS
			$my_options[] = array( 
									"name" => "Custom Css",
									"type" => "heading"
								);			
	
			$my_options[] = array( 
									"name" => "Custom Css",
									"type" => "info",
									"std" => "
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
			$my_options[] = array( "name" => "Custom CSS",
								"desc" => "Quickly add some CSS to your theme by adding it to this block.",
								"id" => "custom_css",
								"std" => "",
								"type" => "textarea");

								
								
								
								
								
								
								
								
								
								
			$my_options[] = array( "name" => "Example Options",
								"type" => "heading"); 	   

								
			$my_options[] = array( "name" => "Border",
								"desc" => "This is a border specific option.",
								"id" => "border",
								"std" => array('width' => '2','style' => 'dotted','color' => '#444444'),
								"type" => "border");      
								
   
							  
			$my_options[] = array( "name" => "Upload Basic",
								"desc" => "An image uploader without text input.",
								"id" => "uploader",
								"std" => "",
								"type" => "upload_min");  
								
			$my_options[] = array( "name" => "Upload",
								"desc" => "An image uploader with text input.",
								"id" => "uploader2",
								"std" => "",
								"type" => "upload");     
											
			$my_options[] = array( "name" => "Input Text",
								"desc" => "A text input field.",
								"id" => "test_text",
								"std" => "Default Value",
								"type" => "text"); 
											   
			$my_options[] = array( "name" => "Input Checkbox (false)",
								"desc" => "Example checkbox with false selected.",
								"id" => "example_checkbox_false",
								"std" => false,
								"type" => "checkbox");    
													
			$my_options[] = array( "name" => "Input Checkbox (true)",
								"desc" => "Example checkbox with true selected.",
								"id" => "example_checkbox_true",
								"std" => true,
								"type" => "checkbox"); 
																						 
			$my_options[] = array( "name" => "Input Select Small",
								"desc" => "Small Select Box.",
								"id" => "example_select",
								"std" => "three",
								"type" => "select",
								"class" => "mini", //mini, tiny, small
								"options" => $my_options_select);                                                          

			$my_options[] = array( "name" => "Input Select Wide",
								"desc" => "A wider select box.",
								"id" => "example_select_wide",
								"std" => "two",
								"type" => "select2",
								"options" => $my_options_radio);    

			$my_options[] = array( "name" => "Input Radio (one)",
								"desc" => "Radio select with default of 'one'.",
								"id" => "example_radio",
								"std" => "one",
								"type" => "radio",
								"options" => $my_options_radio);
								
			$url =  ADMINURI . 'images/';
			$my_options[] = array( "name" => "Image Select",
								"desc" => "Use radio buttons as images.",
								"id" => "images",
								"std" => "",
								"type" => "images",
								"options" => array(
									'warning.css' => $url . 'warning.png',
									'accept.css' => $url . 'accept.png',
									'wrench.css' => $url . 'wrench.png'));
													
			$my_options[] = array( "name" => "Textarea",
								"desc" => "Textarea description.",
								"id" => "example_textarea",
								"std" => "Default Text",
								"type" => "textarea"); 
												   
			$my_options[] = array( "name" => "Multicheck",
								"desc" => "Multicheck description.",
								"id" => "example_multicheck",
								"std" => array("three","two"),
								"type" => "multicheck",
								"options" => $my_options_radio);
													
			$my_options[] = array( "name" => "Select a Category",
								"desc" => "A list of all the categories being used on the site.",
								"id" => "example_category",
								"std" => "Select a category:",
								"type" => "select",
								"options" => $of_categories);
		
		}
}
?>
