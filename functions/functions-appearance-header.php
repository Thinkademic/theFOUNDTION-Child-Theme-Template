<?php
/****
 * functions/functions-appearance-header.php
 *
 * Place functions related to setting up your wordpress custom header
 *
 * @link http://hitchhackerguide.com/2011/02/12/register_default_headers/
 */
define('HEADER_TEXTCOLOR', 'ffffff');
define('HEADER_IMAGE', get_stylesheet_directory_uri() . '/images/logo/logo_default.png'); // %S IS THE TEMPLATE DIR URI
define('HEADER_IMAGE_WIDTH', apply_filters('thefdt_header_image_width', 180));
define('HEADER_IMAGE_HEIGHT', apply_filters('thefdt_header_image_height', 180));
define('NO_HEADER_TEXT', true); // DONT SUPPORT TEXT COLOR CHANGE
add_custom_image_header('enable_header_style', 'enable_admin_header_style');              // SETUP HEADER STYLE SHEET FUNCTION

/*


/**
 * OUTPUT CSS FOR HEADER
 */
function enable_header_style()
{
    echo '
		<style type="text/css">
			#mastline h1 {
				background: url( "' . get_header_image() . '");
				height: ' . HEADER_IMAGE_HEIGHT . 'px;
				width: ' . HEADER_IMAGE_WIDTH . 'px;
			}
			#mastline h1 a {
				background: transparent !important;
				height: ' . HEADER_IMAGE_HEIGHT . 'px;
				width: ' . HEADER_IMAGE_WIDTH . 'px;
			}			
		</style>
	';
}


/**
 * OUTPUT ADMIN CSS
 */
function enable_admin_header_style()
{
    echo '
	<style type="text/css">
		#headimg {
			height: ' . HEADER_IMAGE_HEIGHT . 'px;
			width: ' . HEADER_IMAGE_WIDTH . 'px;
		}
		.default-header {
			width: 100%;
		}
	</style>
	';
}

?>