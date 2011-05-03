<?php
 	$data = get_option(OPTIONS); 
?>

	<script type="text/javascript" language="javascript">
		jQuery.noConflict();
		jQuery(document).ready(function($) {
		
			// hides warning if js is enabled			
			$('#js-warning').hide();
			
			// Tabify Options			
			$('.group').hide();
			$('.group:first').fadeIn();

			
			$('.group .collapsed').each(function() {
				$(this).find('input:checked').parent().parent().parent().nextAll().each( 
					function() {
						if ($(this).hasClass('last')) {
							$(this).removeClass('hidden');
							return false;
						}
						$(this).filter('.hidden').removeClass('hidden');
				});
			});
									
			$('.group .collapsed input:checkbox').click(unhideHidden);
			
			function unhideHidden() {
				if ($(this).attr('checked')) {
					$(this).parent().parent().parent().nextAll().removeClass('hidden');
				} else {
					$(this).parent().parent().parent().nextAll().each( 
						function() {
							if ($(this).filter('.last').length) {
								$(this).addClass('hidden');
								return false;
							}
							$(this).addClass('hidden');
					});
									
				}
			}
			
			// Current Menu Class
			$('#of-nav li:first').addClass('current');
			$('#of-nav li a').click(function(evt) {	
			$('#of-nav li').removeClass('current');
			$(this).parent().addClass('current');				
			var clicked_group = $(this).attr('href');
			$('.group').hide();				
			$(clicked_group).fadeIn();
			evt.preventDefault();
								
		});
		
			// Reset Message Popup
			var reset = "<?php echo $_REQUEST['reset'] ?>";
						
			if ( reset.length ) {
				if ( reset == 'true') {
					var message_popup = $('#of-popup-reset');
				} else {
					var message_popup = $('#of-popup-fail');
			}
				message_popup.fadeIn();
				window.setTimeout(function() {
				message_popup.fadeOut();                        
				}, 2000);	
			}
			
			//Update Message popup
			$.fn.center = function () {
				this.animate({"top":( $(window).height() - this.height() - 200 ) / 2+$(window).scrollTop() + "px"},100);
				this.css("left", 250 );
				return this;
			}
				
					
			$('#of-popup-save').center();
			$('#of-popup-reset').center();
			$('#of-popup-fail').center();
					
			$(window).scroll(function() { 
				$('#of-popup-save').center();
				$('#of-popup-reset').center();
				$('#of-popup-fail').center();
			});
					
		
			// MASKED INPUTS (IMAGES AS RADIO BUTTONS)
			$('.of-radio-img-img').click(function() {
				$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
				$(this).addClass('of-radio-img-selected');
			});
			$('.of-radio-img-label').hide();
			$('.of-radio-img-img').show();
			$('.of-radio-img-radio').hide();
			
			// COLOR Picker			
			$('.colorSelector').each(function() {
				var Othis = this; //cache a copy of the this variable for use inside nested function
					
				$(this).ColorPicker({
						color: '<?php echo $color; ?>',
						onShow: function (colpkr) {
							$(colpkr).fadeIn(500);
							return false;
						},
						onHide: function (colpkr) {
							$(colpkr).fadeOut(500);
							return false;
						},
						onChange: function (hsb, hex, rgb) {
							$(Othis).children('div').css('backgroundColor', '#' + hex);
							$(Othis).next('input').attr('value','#' + hex);
							
						}
				});
					  
			}); //end color picker
			
			// AJAX UPLOAD
			$('.image_upload_button').each(function() {	
			var clickedObject = $(this);
			var clickedID = $(this).attr('id');		
			var nonce = $('#security').val();
					
			new AjaxUpload(clickedID, {
				action: ajaxurl,
				name: clickedID, // File upload name
				data: { // Additional data to send
					action: 'of_ajax_post_action',
					type: 'upload',
					security: nonce,
					data: clickedID },
				autoSubmit: true, // Submit file after selection
				responseType: false,
				onChange: function(file, extension) {},
				onSubmit: function(file, extension) {
					clickedObject.text('Uploading'); // change button text, when user selects file	
					this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
					interval = window.setInterval(function() {
						var text = clickedObject.text();
						if (text.length < 13) {	clickedObject.text(text + '.'); }
						else { clickedObject.text('Uploading'); } 
						}, 200);
				},
				onComplete: function(file, response) {
					window.clearInterval(interval);
					clickedObject.text('Upload Image');	
					this.enable(); // enable upload button
						
			
					// IF NONCE FAILS
					if(response==-1) {
						var fail_popup = $('#of-popup-fail');
						fail_popup.fadeIn();
						window.setTimeout(function() {
						fail_popup.fadeOut();                        
						}, 2000);
					}
						
					// IF THERE WAS AN ERROR
					else if(response.search('Upload Error') > -1) {
						var buildReturn = '<span class="upload-error">' + response + '</span>';
						$(".upload-error").remove();
						clickedObject.parent().after(buildReturn);
						
						}
						
					else {
						var buildReturn = '<img class="hide of-option-image" id="image_'+clickedID+'" src="'+response+'" alt="" />';
		
						$(".upload-error").remove();
						$("#image_" + clickedID).remove();	
						clickedObject.parent().after(buildReturn);
						$('img#image_'+clickedID).fadeIn();
						clickedObject.next('span').fadeIn();
						clickedObject.parent().prev('input').val(response);
					}
				}
			});
					
			});
					
			// AJAX REMOVE (CLEAR OPTION VALUE)
			$('.image_reset_button').click(function() {
			
				var clickedObject = $(this);
				var clickedID = $(this).attr('id');
				var theID = $(this).attr('title');	
						
				var nonce = $('#security').val();
			
				var data = {
					action: 'of_ajax_post_action',
					type: 'image_reset',
					security: nonce,
					data: theID
				};
							
				$.post(ajaxurl, data, function(response) {
								
					//check nonce
					if(response==-1) { //failed			
						var fail_popup = $('#of-popup-fail');
						fail_popup.fadeIn();
						window.setTimeout(function() {
							fail_popup.fadeOut();                        
						}, 2000);
					}
								
					else {	
						var image_to_remove = $('#image_' + theID);
						var button_to_hide = $('#reset_' + theID);
						image_to_remove.fadeOut(500,function() { $(this).remove(); });
						button_to_hide.fadeOut();
						clickedObject.parent().prev('input').val('');
					}		
								
				});			
			});   	 	
					
			// SAVE EVERYTHING ELSE
			$('#of_save').live("click",function() {
				var nonce = $('#security').val();		
				$('.ajax-loading-img').fadeIn();						
				var serializedReturn = $('#ofform').serialize();
												
				//alert(serializedReturn);
								
				var data = {
					<?php if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'optionsframework') { ?>
					type: 'save',
					<?php } ?>
					action: 'of_ajax_post_action',
					security: nonce,
					data: serializedReturn
				};
							
				$.post(ajaxurl, data, function(response) {
					var success = $('#of-popup-save');
					var fail = $('#of-popup-fail');
					var loading = $('.ajax-loading-img');
					loading.fadeOut();  
								
					if (response==1) {
						success.fadeIn();
					} else { 
						fail.fadeIn();
					}
								
					window.setTimeout(function() {
						success.fadeOut(); 
						fail.fadeOut();				
					}, 2000);
				});
					
			return false; 			
			});   
					
			// CONFIRM RESET		
			$('#of_reset').click(function() {
				var answer = confirm("<?php _e('Click OK to reset. All settings will be lost!');?>")
				if (answer) { 	return true; } else { return false; }
		});					
			
		}); // END DOC READY
</script>