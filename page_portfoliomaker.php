<?php
/*
Template Name: Portfoliomaker
*/
?>
<?php get_header(); ?>
<body <?php body_class() ?>>
<div id="wrapper">
<?php get_template_part('slide', 'top'); ?>

<div id="layout"><div id="page_portfolio">

<!-- Masthead -->
<?php get_template_part( 'masthead'); ?>
	
	<!-- Content is King -->
	<div id="content">
		<div id="navigation">
			
			<!-- <div id="parentmenu"></div> -->
			<div id="slidetoggle"><a href="#"><span>View All Projects</span></a></div>				
			<div id="portfolio_previewer_box">
				<?php echo get_portfolio_thumbs(); ?>
			</div>						
		</div>	
		
		<div id="primary">
				<?php get_portfolio_content(); ?>
		</div>
		

	</div>

</div></div>

<!-- Footer -->
<?php get_footer(); ?>


<?php get_template_part('slide', 'bottom'); ?>
</div>
<?php wp_footer(); ?>
</body>
</html>