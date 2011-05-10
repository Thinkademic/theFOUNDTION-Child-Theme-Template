<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
	<!-- META -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>

	<!-- FAVICON -->
	<link href='<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico' rel='shortcut icon' />
	
	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/reset.css" type="text/css" media="screen" />	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/menu.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/widgets.css" type="text/css" media="screen" />	
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/mediagalleries.css" type="text/css" media="screen" />
	
	<!-- RSS + PING BACK URL -->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	
<?php
wp_head(); 
?>
 
</head>