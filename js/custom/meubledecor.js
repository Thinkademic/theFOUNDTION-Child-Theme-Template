// COLLECTION MEUBLE DECOR JQUERY
(function( $ ){

  $.fn.collectionMeuble = function() {
  
	// GRAB WINDOW VIEWPORT DIMMENSIONS
	var vpheight = $(window).height();	
	var wpwidth = $(window).width();	

	// RESIZE ELEMENTS
	$("#primary #background IMG", this).css( "height", vpheight+"px");
	$("#content #logogutter", this).css( "height", vpheight+"px");
	$("#topimage IMG", this).css( "width", wpwidth+"px");
	$("#bottomimage IMG", this).css( "width", wpwidth+"px");	 

	
	// INITIATE SERIALSCROLL ON HOME PAGE
	$('#phsfs #content').serialScroll({
		items:'.info',
		prev:'.navigator .nav_prev',
		next:'.navigator .nav_next',
		offset: 0, //when scrolling to photo, stop 230 before reaching it (from the left)
		start: 0, //as we are centering it, start at the 2nd
		duration: 700,
		force:true,
		stop:true,
		lock:false,
		cycle:true, //don't pull back once you reach the end
		easing:'easeOutQuart', //use this easing equation for a funny effect
		jump: false //click on the images to scroll to them
	});
	
	// INIT CUSTOM BIO HOVERS
	$("#paul").hoverIntent(
			function() { 
				$(".paulbio").fadeIn("normal");;
			},
			function() { 
				$(".paulbio").fadeOut("fast");; 
			}
	);  
	// INIT CUSTOM BIO HOVERS	
	$("#jaime").hoverIntent(
			function() { 
				$(".jaimebio").fadeIn("normal");;
			},
			function() { 
				$(".jaimebio").fadeOut("fast");; 
			}
	); 		

  };
})( jQuery );





$(function(){


	$( "#phsfs" ).collectionMeuble();	
	$(window).resize(function() {
		$( "#phsfs" ).collectionMeuble();		
	});		
	
	
	
	$( "#cozen" ).cozen();
	$( "#cozen" ).portfoliotoggle();
	$(window).resize(function() {
		$( "#cozen" ).cozen();		
	});			

	

});
