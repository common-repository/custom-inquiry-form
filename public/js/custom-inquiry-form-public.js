(function( $ ) {
	'use strict';
	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 $(".custom_inquiry_az").submit(function(e) {
	 	$("status_msg").hide();
	    var formdata = $(this).serialize();
	    var this_id = $(this).attr("id");
	    var ajaxurl = frontend_ajax_object.ajaxurl;
	    jQuery.ajax({
		url: ajaxurl, 
		type: "POST",
		dataType:"json",
		data: {action:"cb_submit_inquiry",data:formdata},
		beforeSend: function() {
               $("#"+this_id).find(".image_loader").show();
        },
		success: function(result)   
		{
			if(result.status == 'true'){
				$("#"+this_id).find(".image_loader").hide();
				$("#"+this_id)[0].reset();
				$("#"+this_id).find("#status_msg").removeClass("alert-danger").addClass("alert-success").html(result.message).show().fadeOut(8000);
			}
			else
			{
				$("#"+this_id).find(".image_loader").hide();
				$("#"+this_id).find("#status_msg").removeClass("alert-success").addClass("alert-danger").html(result.message).show().fadeOut(8000);
				
			}
		}
		});
	 	e.preventDefault();
	});

})( jQuery );
