jQuery(document).ready(function($) {

ThreeWP_Ajax_Search = {
	options : {},
	results : {},
	searched_text : '',				// Text the user last searched for
	queue : 0,						// How many times we've called the fetch_results function.
	selected_item_index : -1,		// -1 = no item selected
	default_options : {
	},
	ajax_search_object : undefined,
	
	// Retrieves the search term.
	get_search_term : function(){
		return $(ThreeWP_Ajax_Search.options.selector_search_input).val();
	},
	
	clear_results : function(callback){
		$(ThreeWP_Ajax_Search.options.selector_search_results_content, ThreeWP_Ajax_Search.ajax_search_object).empty();
		ThreeWP_Ajax_Search.disable_keyboard_navigation();
		ThreeWP_Ajax_Search.do_callback(callback);
	},
	
	hide_results : function(callback){
		ThreeWP_Ajax_Search.do_user_callback('before_hide', function(){
			$(ThreeWP_Ajax_Search.ajax_search_object).fadeTo(0, 0, function(){
				$(ThreeWP_Ajax_Search.ajax_search_object).hide();
				ThreeWP_Ajax_Search.do_callback(callback);
			});
		});
	},
	
	show_results : function(callback){
		ThreeWP_Ajax_Search.do_user_callback('before_show', function(){
			$(ThreeWP_Ajax_Search.ajax_search_object).fadeTo(0, 1.0, function(){
				ThreeWP_Ajax_Search.do_callback(callback);
			});
		});
	},
	
	// Fetches the search results using the search url.
	fetch_results : function(callback){
		ThreeWP_Ajax_Search.queue--;

		if (ThreeWP_Ajax_Search.queue > 0)
			return;
			
		var url = ThreeWP_Ajax_Search.options.search_url + ThreeWP_Ajax_Search.get_search_term();
		
		$.get(url, function(data){
			ThreeWP_Ajax_Search.results = $('.hentry', data);
			
			// Remove extra elements if necessary
			if ( ThreeWP_Ajax_Search.results.length > ThreeWP_Ajax_Search.options.results_to_display )
			{
				ThreeWP_Ajax_Search.results = ThreeWP_Ajax_Search.results.slice( 0, ThreeWP_Ajax_Search.options.results_to_display );
			}

			if ( ThreeWP_Ajax_Search.results.length < 1 )
				ThreeWP_Ajax_Search.hide_results();
			
			ThreeWP_Ajax_Search.do_callback(callback);
		});
	},
	
	// Puts the results into the display container.	
	display_results : function(callback){
		if ( ThreeWP_Ajax_Search.results.length < 1 )
			return;
		
		// Clear previous results.
		$(ThreeWP_Ajax_Search.options.selector_search_results_content, ThreeWP_Ajax_Search.ajax_search_object).empty();
		
		var results = '';
		$.each( ThreeWP_Ajax_Search.results, function(index, item){
			var item_format = ThreeWP_Ajax_Search.options.display_format_item;
			var item_class = "item_" + index;
			if (index == 0)
				item_class += " item_first";
				
			if (index == ThreeWP_Ajax_Search.results.length -1 )
				item_class += " item_last";
				
			item_format = item_format.replace("%item%", $(item).html());
			item_format = item_format.replace("%item_class%", item_class);
			
			$(ThreeWP_Ajax_Search.options.selector_search_results_content, ThreeWP_Ajax_Search.ajax_search_object).append( item_format );
		});
		
		ThreeWP_Ajax_Search.show_results();

		ThreeWP_Ajax_Search.enable_keyboard_navigation(); 
		
		ThreeWP_Ajax_Search.do_callback(callback);
	},
	
	enable_keyboard_navigation : function(callback){
		if ( !ThreeWP_Ajax_Search.options.cursor_key_navigation )
			return;
		
		ThreeWP_Ajax_Search.disable_keyboard_navigation();
		
		ThreeWP_Ajax_Search.selected_item_index = -1;
		
		$(ThreeWP_Ajax_Search.options.selector_search_input).bind('keypress.navigation', (function(e) {
			var code = e.keyCode || e.which;
			var redraw = false;
			
			if ( code == '27' )
			{
				ThreeWP_Ajax_Search.clear_results();
			}
			
			if (code == '13' && ThreeWP_Ajax_Search.selected_item_index > -1 )
			{
				e.preventDefault();
				var url = $(".threewp_ajax_search_"+ThreeWP_Ajax_Search.options.name_md5 + " li.item_selected a").attr('href');
				document.location = url;
			}
			
			if (code == '40')
			{
				if ( ThreeWP_Ajax_Search.selected_item_index == ThreeWP_Ajax_Search.results.length - 1 )
				{
					if ( ThreeWP_Ajax_Search.options.cursor_key_navigation_loops )
						ThreeWP_Ajax_Search.selected_item_index = 0;
					else
						return;
				}
				else
					ThreeWP_Ajax_Search.selected_item_index++;
				
				redraw = true;
			}

			if (code == '38')
			{
				if ( ThreeWP_Ajax_Search.selected_item_index < 0 )
					ThreeWP_Ajax_Search.selected_item_index = 1;

				if ( ThreeWP_Ajax_Search.selected_item_index < 1 )
				{
					if ( ThreeWP_Ajax_Search.options.cursor_key_navigation_loops )
						ThreeWP_Ajax_Search.selected_item_index = ThreeWP_Ajax_Search.results.length - 1;
					else
						return;
				}
				else
					ThreeWP_Ajax_Search.selected_item_index--;
				
				redraw = true;
			}

			if ( redraw )
			{
				$(".threewp_ajax_search_"+ThreeWP_Ajax_Search.options.name_md5 + " li").removeClass('item_selected');
				$(".threewp_ajax_search_"+ThreeWP_Ajax_Search.options.name_md5 + " li.item_" + ThreeWP_Ajax_Search.selected_item_index).addClass('item_selected');				
			}
		}));

		ThreeWP_Ajax_Search.do_callback(callback);
	},
	
	disable_keyboard_navigation : function(callback){
		$(ThreeWP_Ajax_Search.options.selector_search_input).unbind('keypress.navigation');
		ThreeWP_Ajax_Search.do_callback(callback);
	},
	
	// Convenience function that calls fetch_results and then display_results when ready.	
	fetch_and_display : function(callback){
		// Append the "search in progress" class to the whole form.
		$(ThreeWP_Ajax_Search.options.selector_search_form).addClass( 'threewp_ajax_search_in_progress' );
		
		ThreeWP_Ajax_Search.fetch_results(function(){
			ThreeWP_Ajax_Search.display_results();

			// Append the "search in progress" class to the whole form.
			$(ThreeWP_Ajax_Search.options.selector_search_form).removeClass( 'threewp_ajax_search_in_progress' );
			
			ThreeWP_Ajax_Search.do_callback(callback);
		});
	},
	
	do_callback : function(callback){
		if (callback === undefined)
			return;
		callback();
	},
	
	do_user_callback : function(callback_type, our_callback)
	{
		if ( ThreeWP_Ajax_Search.options.callbacks[callback_type] == '')
			return;
		if (our_callback === undefined)
			our_callback = function(){};
		var form_object = $(ThreeWP_Ajax_Search.options.selector_search_form);
		ThreeWP_Ajax_Search.options.callbacks[callback_type](form_object, our_callback);
	},
	
	init : function(options){
		$.extend( ThreeWP_Ajax_Search.default_options, options );
		ThreeWP_Ajax_Search.options = ThreeWP_Ajax_Search.default_options;

		ThreeWP_Ajax_Search.searched_text = $(ThreeWP_Ajax_Search.options.selector_search_input).val();
		
		// Prepare the container
		$(ThreeWP_Ajax_Search.options.selector_search_form).addClass('threewp_ajax_search').append('<div class="threewp_ajax_search_container threewp_ajax_search_'+ThreeWP_Ajax_Search.options.name_md5+'"></div>');
		
		// Convenience for later. And we'll be using it a lot...
		ThreeWP_Ajax_Search.ajax_search_object = $(".threewp_ajax_search_"+ThreeWP_Ajax_Search.options.name_md5);
		
		$(ThreeWP_Ajax_Search.ajax_search_object)
			.append( ThreeWP_Ajax_Search.options.display_format_header + ThreeWP_Ajax_Search.options.display_format_footer ).hide();
			
		$(ThreeWP_Ajax_Search.options.selector_search_input).bind('keyup.ajax_search', function(e){
			var text = $(this).val();
			if (text == ThreeWP_Ajax_Search.searched_text)
				return;
			
			// Remember the new text length
			ThreeWP_Ajax_Search.searched_text = text;
			
			ThreeWP_Ajax_Search.clear_results();
			
			// Don't bother doing anything if there isn't any text.
			if (text.length < 1)
				return;
			
			// Do we have enough characters for a search?
			if (text.length < ThreeWP_Ajax_Search.options.chars_before_search)
				return;
			
			ThreeWP_Ajax_Search.queue++;
				
			// Queue a search
			setTimeout(function(){
				ThreeWP_Ajax_Search.fetch_and_display();
			}, ThreeWP_Ajax_Search.options.time_before_search);
		}).blur(function(){
			// We need a small delay to give the browsers a chance to click on the results link.
			setTimeout(function(){
				ThreeWP_Ajax_Search.hide_results();
			}, 200);
		}).focus(function(){
			ThreeWP_Ajax_Search.show_results();
		});
		
		ThreeWP_Ajax_Search.do_user_callback('after_init');
	}
};
 
});
