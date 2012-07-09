jQuery(document).ready(function($) {

ThreeWP_Ajax_Search = {
	settings_overview : function(){
		$(".ajax_search_settings .enabled input.checkbox").change(function(){
			var enabled = $(this).attr('checked');
			enabled = (enabled ? '1' : '0');
			var id = $(this).attr('id').replace("__", '');
			
			// Fade out to show activity.
			$(".ajax_search_settings tbody").fadeTo(200, 0.5, function(){
				var url = document.location + '&admin_overview_ajax';
				$.post(url, {
					'set_enabled' : enabled,
					'id' : id,
				}, function(data){
					// We're done? Fade in again.					
					$(".ajax_search_settings tbody").fadeTo(200, 1.0);
				}, 'json');
			});
			
		});
	},
}

});
