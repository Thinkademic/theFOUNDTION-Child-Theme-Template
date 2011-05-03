$(function(){
	
	/**********************************************************
		PORTFOLIO MAKER + PORTFOLIO MAKER WITH MODAL
	**********************************************************/	
	$( ".page-template-pageportfoliomaker-php" ).portfoliomaker( 'auto' , 6, 3);
	$( ".page-template-pageportfoliomakermodal-php" ).portfoliomaker( 'auto' , 6, 3);

	/*****************************
		PORTFOLIO FILTER TAG
	*****************************/		
	$('ul#portfolio_preview_list').filterable({
		tagSelector: '#portfolio-filter a',
		selectedTagClass: 'currentfilter',
		useTags: true
	});
	
	

	$(".page-template-pageportfoliomakermodal-php #portfolio_previewer a").fancybox({
		'autoScale'			: false,
		'autoDimensions'	: false,
		'width'				: 880,
		'height'			: 525,
		'overlayOpacity'	: .7,
		'titleShow'			: false,
		'padding'			: 5,
		'transitionIn'		: 'elastic',
		'transitionOut'		: 'elastic',
		'showCloseButton'	: false,		
		'overlayColor'  	:'#000',
		'scrolling'			: 'no',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
		
	});	
	


	

					
	/**********************************************************
	4)	PORTFOLIO TEMPLATE JQUERY
	**********************************************************/		
	$( ".page-template-pageportfoliomaker-php" ).portfoliotoggle();	
	$( ".page-template-pageportfoliomakermodal-php" ).portfoliotoggle();		
	
	
	
	/**********************************************************
	4)	SINGLE PORTFOLIO
	**********************************************************/	
		$('.single-portfolio .media_assets').cycle({
			fx:     'fade',
			speed:   400,
			next:   '.next, .media_assets img',
			prev:   '.prev',
			timeout: 700,
			pagerEvent:  'click.cycle',					// name of event which drives the pager navigation 	
			nowrap: 0,
			before: adjustHeight		
	});	
	
	// START JYCLE ON PAUSE
		$('.single-portfolio .media_assets').cycle('pause');
	
});




/*****************************
	PORTFOLIO PREVIEWER
*****************************/
(function( $ ){

  $.fn.portfoliomaker = function( thumbsize, nthumbs, nthumbsc ) {
  

	//	SOME VARIABLES WE WILL NEED
	var $paneTarget = $( '#portfolio_previewer', this );								// THIS IS THE LAYOUT PLANE, ALL THUMBS MUST FIT ON HERE
	
	if ( thumbsize == "auto" ) {
	
		$paneTarget.autoHeightcalcThumbSize( "#content", nthumbs, nthumbsc );		

		//	CALUCLATE THUMBS DIMESION AND CLIPPING WINDOW WHEN WINDOW IS RESIZED
		$(window).resize(function() {
			if ( $paneTarget .is(":visible") ) {	
					$paneTarget.autoHeightcalcThumbSize( "#content", nthumbs, nthumbsc );				
					$paneTarget.scrollTo( 0 );
			}
		});
		
		//	CALUCLATE THUMBS DIMESION AND CLIPPING WINDOW WHEN PORTFOLIO FILTER IS CLICKED
		$("#portfolio-filter a").click(function(){
					$paneTarget.autoHeightcalcThumbSize( "#content", nthumbs,  nthumbsc);	
					$paneTarget.scrollTo( 0 );
		});	
	}
	

	//	OUR MOST POSTION ALONG X AXIS DETERMINES THE POSITION OF THE CLIPPING WINDOW
	//	WE USE SCROLLTO HANDLE THE MOVEMENT INTERMS OF PERCENTAGE
	$(" #content ",  this).mousemove(function(e){

		var numbervisible = $("ul li:visible", $paneTarget).length;
	
		if ( $paneTarget.is(":visible") && numbervisible > 6) {

			var scrollBuffer = 100;
		
			var offset = $paneTarget .offset();		// CHILDREN THUMB POSITION
			var x = e.pageX - offset.left - scrollBuffer;		// REDUCE LENGTH AND WIDTH
			var y = e.pageY - offset.top - scrollBuffer;	
			
			
			// WE SHAVE OFF A LITTLE, SO THAT OUR MOUSE DOESN'T HAVE TO 
			// RIGHT UP THE EDGE TO GET THE CLIPPING WINDOW FULL LEFT OR FULL RIGHT		
			
			// ADJUST scrollTO BASED ON MOUSE X + Y POSITION 
			var viewport			= $paneTarget.width() - (scrollBuffer * 2);		
			var percentage		= x /  viewport  * 100;
			var viewporty		= $paneTarget.height() - (scrollBuffer * 2) ;
			var percentagey	= y /  viewporty  * 100;	  

			
			// SCROLL TO OUR SECTION	
			$paneTarget.stop().scrollTo( {
					top: percentagey + '%',
					left: percentage + '%'
				} 

			);
		
		} else {
			// SCROLL TO OUR SECTION	
			$paneTarget.stop().animate( {scrollLeft: 0 }, 400 );	

		}
			
	}); 


  };
})( jQuery );




/*****************************
	PORTFOLIO MAKER
*****************************/
(function( $ ){

  $.fn.portfoliotoggle = function() {

	////		SOME VARIABLES WE WILL NEED
	var $template = $(this);								

	//// 	INTIAL ELEMENT DISPLAY SETTINGS
	$('#portfolio_previewer_box', this).show();				//	SHOW THE ENTIRE PORTFOLIO PREVIEWER
	$('#portfolio_page_post_content', this).show();		//	POST CONTENT FROM PAGE THAT IS USING THE PAGE_PORTFOLIO.PHP THEME FILE
	$('#slidetoggle a', this).hide();										//	"VIEW ALL PORTFOLIO ITEMS"
	$('.portfolio_item', this).hide();										// 	GET_PORTFOLIO_CONTENT(), SEE PAGE_PORTFOLIO.PHP

	
	////		SET PORTFOLIO ITEM PREVIEW SPAN ELEMENT TO MATCH IMAGE WIDTHS
	$("ul#portfolio_preview_list li", this).each(function() {			
				var imgwidth = $("img", this).width();
				$("SPAN",this).css("width", imgwidth+"px"); 	
	});
	$('ul#portfolio_preview_list li SPAN', this).hide();									// INTIAL DISPLAY SETTINGS ON SPAN ELEMENT	
	$("#page_portfolio ul#portfolio_preview_list li").hoverIntent(
			function() { 
				$("img",this).removeAttr('title');
				$("SPAN",this).fadeIn("fast");
				$("img",this).animate({ opacity: 0.25 }, 800);	
			},
			function() { 
				$("SPAN",this).fadeOut("fast"); 
				$("img",this).animate({ opacity: 1.00 }, 800);	
			}
	);	

	////		EVENTS THAT OCCUR WHEN USER EXITS DETAIL MODE
	$('#slidetoggle a', this).click(function() {							
		$('#primary .portfolio_item').hide();
		$('ul#portfolio_preview_list').toggle();
		$('#slidetoggle a').hide();
		
		$('#portfolio_page_post_content').show();				//	SHOW POST CONTENT FROM POSTTYPE:PAGE WITH TEMPLATE SET TO 'PORTFOLIO'
		$("#portfolio_preview_filter").show();							//	SHOW THE FILTERABLE CONTROLS
		$("#portfolio_previewer").show();									//	SHOW PORTFOLIO ITEM PREVIEW;
		
		var copyhash = $(this).attr('href');
		$('ul#portfolio_preview_list').trigger('filter', [ copyhash ] );		
		
		$("ul#portfolio_preview_list li SPAN").fadeOut("slow"); 			//	MAKE SURE WE FADE OUT WHEN WE GO BACK TO VIEW ALL STATE

	});		
	
	
	////		EVENTS THAT OCCUR WHEN PORTFOLIO IS FILTERED
	$('#portfolio-filter a', this).click(function() {						
		$('#primary .portfolio_item').hide();
		$('ul#portfolio_preview_list').show();
		$('#slidetoggle a').hide();
		
		$('#portfolio_page_post_content').show();					// Show post content from posttype:page with template set to 'portfolio'
		$("#portfolio_preview_filter").show();								// Show the filterable controls
		$("#portfolio_previewer").show();										// Show Portfolio Item Preview;
		
	});	
	
	
	
	if ( $("#primary .portfolio_content", this).length ) {
	
		$('ul#portfolio_preview_list li a', this).click(function() {
			
			// REMEMBER WHICH FILTER WE USED - FOR THE PORTFOLIO FILTER
			var copyhash = window.location.hash;
			$('#slidetoggle a').attr( 'href', ''+copyhash );


			// ACTIONS THAT OCCUR AFTER CLICKING ON THE PREVIEW THUMB
			$("SPAN",this).fadeOut("fast"); 																	//	FADE OUT ON THE SPAN (PROJECT TITLE)		
			$("#portfolio_preview_filter").hide();															//	HIDE THE FILTERABLE CONTROLS
			$("#portfolio_previewer").hide();																	// HIDE ALL PREVIEW IMAGES		

			// EXECUTE STATE CHANGES WHEN PREVIEW THUMBNAIL WAS CLICKED
			$('#portfolio_page_post_content').hide();														// CONTENT ASSOCIATED WITH WORDPRESS PAGE
			$('#portfolio_page_post_content .portfolio_item .media_controls').hide();		// PREV/NEXT CONTROLS FOR EACH OF THE PROJECTS
			$('#portfolio_page_post_content .portfolio_item').show();						

			// GRAB THE TARGETED, WHICH IS FOUND IN THE REL ATTRIBUTE
			var targetclass = $(this).parent().attr('rel');

			// AND THEN BRING UP OUR TARGETED CONTENT ITEM...THE SELECTED PROJECT
			$('#primary .'+targetclass).fadeIn().jcycleportfolio(targetclass);

			// FINISH EXECUTING STATE CHANGES WHEN THUMBNAIL WAS CLICKED
			$(this).parent().parent().slideToggle();
			$('#slidetoggle a').show();


			return false;
		});

	}	
	
	
	
  };
})( jQuery );






/* *************************************
	CALCULATE THUMBNAIL SIZE WITH AUTOHEIGHT ADJUSTMENT
	IMAGE IS  PORPORTIONALY SCALED
   ************************************* */
jQuery.fn.autoHeightcalcThumbSize = function ( containerwidth, nthumbs, nthumbsc ) {
	var element = $(this)[0];
	if( element ) {

		// SETUP CSS
		$(this).css("overflow", "hidden");	
		$(this).css("clear", "both");	 


		// GRAB VIEWPORT + OFFSETS
		var viewportWidth = $(containerwidth).width();
		var viewportHeight = $(window).height();	
		var offset = $(this).offset();
		var ctheight = viewportHeight - offset.top;
		
		$(this).css( "height", ctheight+"px");										// ADJUST HEIGHT TO FIT EVERYTHIN IN VIEW, OTHERWISE CSS AUTO 	  
		$(this).css("width", viewportWidth+"px");								// MATCH THE DIV TO THE VIEWPORT SIZE, ACTS LIKE A CLIPPING MASK FOR OUR TECHNIQUE
		  
		var numofthumbs = nthumbs;																		// NUMBERS OF THUMBS IN VISIBLE IN THE ROW, INSIDE THE VIEWPORT
		var numofthumbsclipped = nthumbsc;														// ADDITIONAL NUMBER OF THUMBS OUTSIDE THE VIEPORT PER ROW
		var thumbmargin = parseInt($("LI", this).css("marginRight"));	// GRAB THE DESIRED THUMB MARGIN FROM CSS
		$("UL", this).css("paddingLeft", thumbmargin+"px");		

		// CALCULCATE AMOUNT OF ROWS WE'LL HAVE
		var totalthumbs = $( "LI", this ).size();																						// DETERMINE TOTAL NUMBER OF THUMBS IN THE LIST
		var rowCalc = Math.ceil(totalthumbs / ( numofthumbs + numofthumbsclipped ) );   		// NUMBER OF ROWS NEEDED

		var setthumbwidth = ( viewportWidth - (thumbmargin * numofthumbs) - thumbmargin ) / numofthumbs;	// WIDTH BASED ON NUMBER OF VISIBLE ITEMS IN VIEWPORT
		
		// var thumbnailHeight = ( (viewportHeight - 260 ) - ( rowCalc * thumbmargin) ) / rowCalc;			// Calculate to fit evenly in viewport
		var thumbnailHeight = setthumbwidth	* 240 / 360;																			// Height will scale according to width, based on image ratio
		
		$( "LI", this ).css("width", setthumbwidth+"px");				
		$( "LI", this ).css("height", thumbnailHeight+"px");
		$( "LI IMG", this ).css("width", setthumbwidth+"px");				
		$( "LI IMG", this ).css("height", thumbnailHeight+"px");

		var adjustedSPANpos = thumbnailHeight + 5;
		$( "ul#portfolio_preview_list li SPAN", this ).css("top", "-"+adjustedSPANpos+"px");


		// Determine size of the div that is being masked by #portfolio_previewer
		var panewidth = ( setthumbwidth * numofthumbs + ( setthumbwidth * numofthumbsclipped) ) + ( (thumbmargin * numofthumbs ) + ( thumbmargin * numofthumbsclipped) );				
		$( "UL", this).css("width", panewidth+"px");
		
		
		

	}
}






/* *************************************
	PORTFOLIO MAKER  JYCLE
   ************************************* */
jQuery.fn.jcycleportfolio = function (targetclass) {



	//	JCYCLE CONTROLLER ELEMENTS SETUP
		$('.'+targetclass+' .media_controls').hide();
		$('.pause').click(function() { $('.'+targetclass+' .media_assets').cycle('pause'); return false; });
		$('.play').click(function() { $('.'+targetclass+' .media_assets').cycle('resume'); return false; });

	//	CHECK FOR HOVER OVER MEDIA ELEMETNS
		$('.media_grouping').hoverIntent(
			function() { $('.media_controls').fadeIn(); },
			function() { $('.media_controls').fadeOut(); }
		);


	// INITIATE JCYCLE
		$('.'+targetclass+' .media_assets').cycle({
			fx:     'fade',
			speed:   400,
			next:   '.next',
			prev:   '.prev',
			timeout: 700,
			nowrap: 0,
			before: adjustHeight,
			pager:  '.'+targetclass+' .thumbnav',
			pagerEvent:     'click.cycle',					// name of event which drives the pager navigation 

			// callback fn that creates a thumbnail to use as pager anchor 
			pagerAnchorBuilder: function(idx, slide) { 
				// return selector string for existing anchor 
				return '.'+targetclass+' .thumbnav li:eq(' + idx + ') a IMG'; 						
			}			
	});

	
	// START JYCLE ON PAUSE
		$('.'+targetclass+' .media_assets').cycle('pause');



	// HIDE PAUSE/PLAY DEPENDING ON STATE
		$('.'+targetclass+' .pause').hide();
		
		$('.'+targetclass+' .play').click(function(){
			$('.'+targetclass+' .media_assets').cycle('resume'); 
			$('.'+targetclass+' .media_controls').fadeOut(); 
			$(this).hide();
			$('.'+targetclass+' .pause').show(); 			
		});		
		
		$('.'+targetclass+' .pause').click(function(){  
			$('.'+targetclass+' .media_assets').cycle('pause'); 
			$('.'+targetclass+' .media_controls').fadeOut(); 
			$(this).hide();
			$('.'+targetclass+' .play').show();			
		});


}








// 	WORKS WITH JCYCLE, DETECTS CONTAINER ITEM HEIGHT AND ADJUST ENTIRE CONTAINER ACCORDINGLY
function adjustHeight(curr, next, opts, fwd) {
	
	// GET THE HEIGHT OF THE CURRENT SLIDE
	var $ht = $(this).height();
	var $wt = $(this).width();
	
	//	SET THE CONTAINER'S HEIGHT TO THAT OF THE CURRENT SLIDE		
	$(this).parent().animate({ height: $ht}, 250);	
}


