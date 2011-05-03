
$(function(){

	/**********************************************************
	1)	 SWAP INPUT VALUE ON FOCUS
			WP THEME FILE : SEARCHFORM.PHP
	**********************************************************/
	swapValues = [];
	$(".swap_value").each(function(i){
		swapValues[i] = $(this).val();
		$(this).focus(function(){
			if ($(this).val() == swapValues[i]) {
				$(this).val("");
			}
		}).blur(function(){
			if ($.trim($(this).val()) == "") {
				$(this).val(swapValues[i]);
			}
		});
	});
   

	/**********************************************************
	2)	 SUCKERFISH MENU
			WP THEME FILE : ???
	**********************************************************/
	$("ul.sf-menu").supersubs({ 
		minWidth:    15,   // minimum width of sub-menus in em units 
		maxWidth:    19,   // maximum width of sub-menus in em units 		
		extraWidth:  1     // extra width can ensure lines don't sometimes turn over 
						   // due to slight rounding differences and font-family 
	}).superfish({
            delay:       1000,                            			// one second delay on mouseout 
            animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
            speed:       'fast',                          				// faster animation speed 
            autoArrows:  false,                           			// disable generation of arrow mark-up 
            dropShadows: false                            		// disable drop shadows 	
	});  



	/**********************************************************
	3)	ADMIN EDIT LINKS
			WP THEME FILE : ???
	**********************************************************/
	$(".itemhead").hoverIntent(
			function() { 
				$(".editlink",this).show();
			},
			function() { 
				$(".editlink",this).hide(); 
			}
	);  

	
});