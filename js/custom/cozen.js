// COZEN ARCHITECTURE JQUERY
(function( $ ){

  $.fn.cozen = function() {
  
	// GRAB WINDOW VIEWPORT DIMMENSIONS
	var vpheight = $(window).height();	
	var vpwidth = $(window).width();	

	// COZEN CONTENT CONTAINER DIMENSIONS
	$("#content", this).css( "height", vpheight+"px");
	$("#content", this).css( "width", vpwidth-180+"px");
	
	// COZEN HOME PAGE
	$(".page-id-1583 #primary").css( "width", vpwidth-180+"px");	
	
	// COZEN PORTFOLIO
	$('#page_portfolio #slidetoggle a', this).click(function() {			// Actions that occure when user exits Porfolio item Detail back to Preview Mode
		$('#portfolio_titles').show();
	
	});	
	
	
	$("#page_portfolio ul#portfolio_preview_list li", this).each(function() {			// Set's Portfolio item Preview span to match image widths

		var setthumbwidth = $(this).width();	
		var thumbnailHeight = setthumbwidth	* 240 / 360;													// Height will scale according to width, based on image ratio

		$("IMG", this).css("width", setthumbwidth+"px");				
		$("IMG", this).css("height", thumbnailHeight+"px");

		var adjustedSPANpos = thumbnailHeight + 5;
		$("SPAN", this).css("top", "-"+adjustedSPANpos+"px");				
	});

		
	if ( $("#primary .portfolio_content", this).length ) {
		$('#page_portfolio ul#portfolio_preview_list li a', this).click(function() {
			$('#portfolio_titles').hide();	

			//	GRAB THE TARGETED, WHICH IS FOUND IN THE REL ATTRIBUTE
			var targetclass = $(this).parent().attr('rel');

			
			// INTIALIZE FANCYBOX
			$('.'+targetclass+' .slide_item a').attr('rel', 'gallery'+targetclass).fancybox({
				'autoScale'			: true,
				'autoDimensions'	: true,
				'overlayOpacity'	: .85,
				'titleShow'			: false,
				'padding'			: 5,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',
				'showCloseButton'	: true,		
				'overlayColor'  	:'#222',
				'scrolling'			: 'no'
			});	
			
			return false;
		});
	} 
	
	$('.portfolio_content .post_content', this).jScrollPane({showArrows: true});	
	$('.portfolio_media', this).jScrollPane({showArrows: true});	
	
	$('.person .details', this).jScrollPane({showArrows: true});	

	$(".person").hoverIntent(
			function() { 
				$(".details", this).fadeIn("normal");;
			},
			function() { 
				$(".details", this).fadeOut("fast");; 
			}
	); 	

  };
})( jQuery );










// HORIZONTAL SCROLLER (LIVING ART)
$(function(){
    
	scrollWrapper = $('#phs #content');
    
	if ( scrollWrapper.length ) {

		scrollWrapper.mousewheel(function (event, delta) {
            this.scrollLeft -= (delta * 100);
        })
        .css({
            'overflow-x' : 'scroll'
        });
    
		// When the Window Resizes We need to recalculate the Thumbns and Clipping window
		var vWidth = $(window).width();			
		var vHeight = $(window).height();
		
		var offset = $("#phs #content").offset();
		var adjustHeight = vHeight - offset.top;

		$("#phs #content").css( "height", adjustHeight+"px");										// Adjust height to fit everythin in view, otherwise css auto
 			
			
		$(window).resize(function() {
			vWidth = $(window).width();			
			vHeight = $(window).height();
					
			offset = $("#phs #content").offset();
			adjustHeight = vHeight - offset.top;						
					
			$("#phs #content").css( "height", adjustHeight+"px");										// Adjust height to fit everythin in view, otherwise css auto
 	  			
		});
		
		var thumbmargin = parseInt($("#phs .portfolio_item").css("marginRight"));					// Grab the desired thumb margin from css
	
		var totalwidth = 0; 
		$(".portfolio_item").each(function(i){
			totalwidth = totalwidth + $(this).width() + thumbmargin;

		});	

		$("#phs #primary").css( "width", totalwidth+"px");										// Adjust height to fit everythin in view, otherwise css auto
 		
		
		
		// ScrollTo Applied to Targets
		var $scrolltarget = $('#phs #content');
		$('.about_content').click(function(){
			$scrolltarget.stop().scrollTo( '.service_content', 1000, { offset:-50 } );
		});
		$('.service_content').click(function(){
			$scrolltarget.stop().scrollTo( '.about_content', 1000, { offset:-50 } );
		});
		
		
		$($scrolltarget ).serialScroll({
			items:'.portfolio_item',
			prev:'#slidenav .prev',
			next:'#slidenav .next',
			offset:0, //when scrolling to photo, stop 230 before reaching it (from the left)
			start:0, //as we are centering it, start at the 2nd
			duration:1200,
			force:true,
			stop:true,
			lock:false,
			cycle:false, //don't pull back once you reach the end
			easing:'easeOutQuart', //use this easing equation for a funny effect
			jump: false //click on the images to scroll to them
		});		
				
		
		
		var scrollAmount = 15;
		var hoverInterval;
		
		$("#hovernav .next").hover(
			function() {
				// call doStuff every 100 milliseconds
				hoverInterval = setInterval( nexthoverScroller, 5 );
			},
			function() {
				clearInterval(hoverInterval);
			}
		);
			
		$("#hovernav .prev").hover(
			function() {
				// call doStuff every 100 milliseconds
				hoverInterval = setInterval( prevhoverScroller, 5 );
			},
			function() {
				clearInterval(hoverInterval);
			}
		);
		
		
		function nexthoverScroller() {
			var $scrolltarget = $('#phs #content');			
			var currentScrollposition = $scrolltarget.scrollLeft();
			$scrolltarget.scrollLeft(currentScrollposition + scrollAmount);
				
		}
		
		function prevhoverScroller() {
			var $scrolltarget = $('#phs #content');			
			var currentScrollposition = $scrolltarget.scrollLeft();
			$scrolltarget.scrollLeft(currentScrollposition - scrollAmount);			
		}	
	
	}
	
});





