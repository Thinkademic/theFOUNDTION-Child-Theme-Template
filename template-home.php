<?php
/*
Template Name: Template for Home Page
*/
?>
<?php get_header(); ?>
<body <?php body_id(); ?> <?php body_class(); ?>>
<div id="wrapper">
<?php get_template_part( 'slide', 'top'); ?>	

<div id="layout"><div id="template-home">

<!-- Masthead -->
<?php get_template_part( 'masthead'); ?>	

	<!-- Content is King -->
	<div id="content">

		<?php dynamicsidebar( 'Content Featured', '<div id="content-featured">', '</div>'); ?>
		
		<div id="primary">
			<?php dynamicsidebar( "Primary Featured", '<div id="primary-featured">', '</div>' ); ?>

			<div id="postbox">
				<?php get_template_part( 'loop', 'page'); ?>			
			</div>
			
			<?php get_template_part( 'navigate'); ?>
		</div>
   
		<?php get_template_part( 'secondary'); ?>	

	</div>



</div></div>

<!-- Footer -->
<?php get_footer(); ?>


<div id="bottomslide"></div>
</div>
<?php wp_footer(); ?>
</body>
</html>