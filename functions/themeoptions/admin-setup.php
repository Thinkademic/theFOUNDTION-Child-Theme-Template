<?php
/**************************************************************
 HEAD HOOK
**************************************************************/
function of_head() { do_action( 'of_head' ); }




/**************************************************************
 ADD DEFAULT OPTIONS AFTER ACTIVATION
**************************************************************/
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	//Call action that sets
	add_action('admin_head','of_option_setup');
}




/**************************************************************
 Set options=defaults if DB entry does not exist, else update defaults only 
**************************************************************/
function of_option_setup(){
global $options_machine;
		
	if (!get_option(OPTIONS)){
		//doesnt exist in db
		update_option(OPTIONS, $options_machine->Defaults);	
		
	} else {
	    //exists in db- so preserve existing options
	}
		
	
	
}




/**************************************************************
 ADMIN BACKEND
**************************************************************/
function optionsframework_admin_head() { 
	//Tweaked the message on theme activate
	?>
    <script type="text/javascript">
    jQuery(function(){
    	
        var message = '<p>This theme comes with an <a href="<?php echo admin_url('admin.php?page=optionsframework'); ?>">options panel</a> to configure settings. This theme also supports widgets, please visit the <a href="<?php echo admin_url('widgets.php'); ?>">widgets settings page</a> to configure them.</p>';
    	jQuery('.themes-php #message2').html(message);
    
    });
    </script>
    <?php
	
}
add_action('admin_head', 'optionsframework_admin_head'); 
?>