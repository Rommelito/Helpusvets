<?php
/*                                                                                                                                                                                                                                                             
Plugin Name: ThreeWP Ajax Search
Plugin URI: http://mindreantre.se/program/threewp/threewp-ajax-search/
Description: Enables ajax searches for content.
Version: 1.2
Author: Edward Hevlund
Author URI: http://www.mindreantre.se
Author Email: edward@mindreantre.se
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

require_once('ThreeWP_Ajax_Search_3Base.php');
class ThreeWP_Ajax_Search extends ThreeWP_Ajax_Search_3Base
{
	protected $local_options = array(
		'settings' => array(),
	);
	
	private $load_own_css = false;
	private $wp_enqueue_script = '';
	
	protected $default_settings = array(
		'enabled' => true,
		'name' => 'Default Ajax Search that works with Twentyten',
		'description' => 'The default ajax search theme made for Twentyten and derivatives.',
		'search_url' => '',
		'chars_before_search' => '0',
		'time_before_search' => '500',
		'cursor_key_navigation' => true,
		'cursor_key_navigation_loops' => true,
		'results_to_display' => '10',
		'load_css' => true,
		'display_format_header' => "<div class=\"threewp_ajax_search_results_content\">\n<ul>",
		'display_format_item' => '<li class="%item_class%">%item%</li>',
		'display_format_footer' => "</ul>\n</div>",
		'selector_search_form' => '#searchform',
		'selector_search_input' => '#s',
		'selector_search_results' => '.hentry',
		'selector_search_results_content' => '.threewp_ajax_search_results_content ul',
		'callback_after_init' => 'function(form_object, callback){
	$("input", form_object).attr("autocomplete", "off");
	callback();
}',
		'callback_after_fetch' => 'function(form_object, callback){
	callback();
}',
		'callback_before_hide' => 'function(form_object, callback){
	$(".threewp_ajax_search_container", form_object).fadeTo(250, 0.0, callback);
}
',
		'callback_before_show' => 'function(form_object, callback){
	$(".threewp_ajax_search_container", form_object).fadeTo(250, 1.0, callback);
}
',
	);
	
	private $callbacks = array(
		'after_init', 'after_fetch', 'before_hide', 'before_show'
	);
	
	public function __construct()
	{
		parent::__construct(__FILE__);
		register_activation_hook(__FILE__, array(&$this, 'activate') );
		register_deactivation_hook(__FILE__, array(&$this, 'deactivate') );
		add_action( 'admin_init', array(&$this, 'admin_init') );
		add_action( 'admin_menu', array(&$this, 'admin_menu') );
		add_action( 'wp_head', array(&$this, 'wp_head') );
		add_action( 'wp_print_styles', array(&$this, 'wp_print_styles') );
	}
	
	// --------------------------------------------------------------------------------------------
	// ----------------------------------------- Callbacks
	// --------------------------------------------------------------------------------------------
	public function activate()
	{
		parent::activate();
		
		// Add default set.
		if ( $this->get_local_option( 'settings' ) === false )
		{
			$this->options['settings'][] = $this->generate_new_settings();
			$this->update_local_option( 'settings', $this->options['settings'] );
		}
	}
	
	public function deactivate()
	{
		parent::deactivate();
	}

	protected function uninstall()
	{
		$this->deregister_options();
	}
	
	public function admin_init()
	{
		if (isset($_GET['admin_overview_ajax']))
			$this->admin_overview_ajax();
		
		if ( isset($_POST['threewp_ajax_search_settings_delete']) )
		{
			$id = $_GET['delete_id'];
			$settings = $this->get_local_option( 'settings' );
			if ( array_key_exists($id, $settings))
			{
				unset($settings[$id]);
				
				update_option( 'settings', $settings);
				
				$url = remove_query_arg( array('tab', 'delete_id') );
				wp_redirect( $url );
			}
		}

		if ( isset($_POST['threewp_ajax_search_settings_create']) )
		{
			$this->create_settings();
			$url = remove_query_arg( array('tab') );
			wp_redirect( $url );
		}

	}
	
	public function admin_menu()
	{
		wp_enqueue_script( 'threewp_ajax_search_admin', '/' . $this->paths['path_from_base_directory'] . '/js/admin.js' );
		add_submenu_page( 'options-general.php', __('Ajax Search', 'ThreeWP_Activity_Monitor'), __('Ajax Search', 'ThreeWP_Activity_Monitor'), 'administrator', 'ThreeWP_Ajax_Search', array (&$this, 'admin') );
	}
	
	public function wp_print_styles()
	{
		$this->prepare_js();

		if ($this->wp_enqueue_script == '')
			return;
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'threewp_ajax_search_user', '/' . $this->paths['path_from_base_directory'] . '/js/user.js' );

		if ($this->load_own_css)
			wp_enqueue_style( 'threewp_ajax_search', '/' . $this->paths['path_from_base_directory'] . '/css/ThreeWP_Ajax_Search.css', false, '1.0', 'screen' );
	}
	
	public function wp_head()
	{
		echo $this->wp_enqueue_script;
	}
	
	public function admin()
	{
		$tabData = array(
			'tabs'		=>	array(),
			'functions' =>	array(),
		);
		
		$tabData['tabs'][] = __('Overview', 'ThreeWP_Ajax_Search');
		$tabData['functions'][] = 'admin_overview';
		
		if ( @$_GET['tab'] == 'edit' && isset($_GET['edit_id']))
		{
			$tabData['tabs'][] = __('Edit', 'ThreeWP_Ajax_Search');
			$tabData['functions'][] = 'admin_settings_edit';
		}

		if ( @$_GET['tab'] == 'delete' && isset($_GET['delete_id']))
		{
			$tabData['tabs'][] = __('Delete', 'ThreeWP_Ajax_Search');
			$tabData['functions'][] = 'admin_settings_delete';
		}

		$tabData['tabs'][] = __('Help', 'ThreeWP_Ajax_Search');
		$tabData['functions'][] = 'admin_help';
		
		$tabData['tabs'][] = __('Uninstall', 'ThreeWP_Ajax_Search');
		$tabData['functions'][] = 'admin_uninstall';
		
		$this->tabs($tabData);
	}
	
	public function admin_overview_ajax()
	{
		$settings = get_option('settings');
		$returnValue = array('ok' => false);
		
		if ( isset($_POST['set_enabled']) )
		{
			$enabled = $_POST['set_enabled'];
			$id = $_POST['id'];
			
			$settings[ $id ]['enabled'] = $enabled;

			$returnValue['ok'] = true;
		}
		
		update_option( 'settings', $settings );
		
		echo json_encode( $returnValue );
		exit;
	}

	public function admin_overview()
	{
		$form = $this->form();
		$returnValue = '';
		
		$input_settings_create = array(
			'name' => 'threewp_ajax_search_settings_create',
			'type' => 'submit',
			'value' => __('Create new settings', 'ThreeWP_Ajax_Search'),
			'css_class' => 'button-primary',
		);
		
		$settings = get_option('settings');
		$settings = ( is_array($settings) ? $settings : array() );
		$tBody = '';
		foreach($settings as $index=>$setting)
		{
			$inputEnabled = array(
				'name' => $index,
				'type' => 'checkbox',
				'label' => $index,
				'checked' => $setting['enabled'],
			);
			$url = add_query_arg(array('tab' => 'edit', 'edit_id' => $index));
			$url_delete = add_query_arg(array('tab' => 'delete', 'delete_id' => $index));
			$tBody .= '<tr>
				<td class="enabled">
					'.$form->make_input($inputEnabled).'<div class="screen-reader-text">'.$form->make_label($inputEnabled).'</div>
				</td>
				<td class="name">
					<a href="'.$url.'">'.$setting['name'].'</a>
				</td>
				<td class="actions row-actions">
					<span class="trash"><a href="'.$url_delete.'">'.__('Delete', 'ThreeWP_Ajax_Search').'</a></div>
				</td>
			</tr>';
		}
		
		$returnValue .= '
			<table class="widefat ajax_search_settings">
				<thead>
					<tr>
						<th class="enabled">'.__('Enabled', 'ThreeWP_Ajax_Search').'</th>
						<th class="name">'.__('Name', 'ThreeWP_Ajax_Search').'</th>
						<th class="name">'.__('Actions', 'ThreeWP_Ajax_Search').'</th>
					</tr>
				</thead>
				<tbody>
					'.$tBody.'
				</tbody>
			</table>
			<br />
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					ThreeWP_Ajax_Search.settings_overview();
				});
			</script>
			
			'.$form->start().'
			<p>
				'.$form->make_input( $input_settings_create ).'
			</p>
			'.$form->stop().'
			
		';
		
		if ( isset($_GET['settings_saved']) )
			$this->message( __('The settings have been saved!', 'ThreeWP_Ajax_Search') );
		
		echo $returnValue;
	}
	
	public function admin_settings_delete()
	{
		$id = $_GET['delete_id'];
		$settings = get_option('settings');
		$settings = $settings[$id];

		$returnURL = remove_query_arg(array('tab', 'delete_id'));
		
		$form = $this->form();
		$input_delete = array(
			'name' => 'threewp_ajax_search_settings_delete',
			'type' => 'submit',
			'value' => 'Delete the settings for '.$settings['name'],
			'css_class' => 'button-primary',
		);
		
		echo '
			<p>
				Are you sure?
			</p>

			<p>
				'.$form->start().'
				'.$form->make_input($input_delete).'
				'.$form->stop().'
			</p>

			<p>
				<a href="'.$returnURL.'">'.__('Return to overview', 'ThreeWP_Ajax_Search').'</a>
			</p>
		';
	}
	
	public function admin_settings_edit()
	{
		$id = $_GET['edit_id'];
		$settings = get_option('settings');

		if ( isset($_POST['import_settings']) )
		{
			$string = $_POST['serialized_settings'];
			$string = stripslashes($string);
			$imported_settings = unserialize($string);
			if ($imported_settings !== false)
			{
				$imported_settings = array_merge($this->default_settings, $imported_settings);
				$settings[$id] = $imported_settings;
				update_option( 'settings', $settings);
				$this->message( __('The settings have been successfully imported!', 'ThreeWP_Ajax_Search') ); 
			}
			else
				$this->error( __('The string could not be unserialized.', 'ThreeWP_Ajax_Search') ); 
		}

		$settings = $settings[$id];
		$settings = array_merge($this->default_settings, $settings);
		$form = $this->form();

		$inputs = array(
			'name' => array(
				'name' => 'name',
				'type' => 'text',
				'label' => __('Name', 'ThreeWP_Ajax_Search'),
				'css_class' => 'regular-text',
			),
			'description' => array(
				'name' => 'description',
				'type' => 'textarea',
				'label' => __('Description', 'ThreeWP_Ajax_Search'),
				'rows' => 2,
				'cols' => 50,
			),
			'search_url' => array(
				'name' => 'search_url',
				'type' => 'text',
				'css_class' => 'regular-text',
				'label' => __('Search URL', 'ThreeWP_Ajax_Search'),
				'description' => sprintf(
					__('If specified will use this URL instead of the standard <code>%s/?s=</code>. The search term itself is appended at the end of the url.', 'ThreeWP_Ajax_Search'),
					get_bloginfo('url')
				),
				'validation' => array( 'empty' => true ),
			),
			'chars_before_search' => array(
				'name' => 'chars_before_search',
				'type' => 'text',
				'label' => __('Characters before ajax search activates', 'ThreeWP_Ajax_Search'),
				'css_class' => 'regular-text',
				'description' => __('How many characters the user must type before the ajax search activates.', 'ThreeWP_Ajax_Search'),
				'validation' => array(
					'valuemin' => 0,
					'valuemax' => 10,
				),
			),
			'time_before_search' => array(
				'name' => 'time_before_search',
				'type' => 'text',
				'label' => __('Time before ajax search activates', 'ThreeWP_Ajax_Search'),
				'css_class' => 'regular-text',
				'description' => __('How many milliseconds before the ajax search activates.', 'ThreeWP_Ajax_Search'),
				'validation' => array(
					'valuemin' => 0,
					'valuemax' => 10000,
				),
			),
			'load_css' => array(
				'name' => 'load_css',
				'type' => 'checkbox',
				'label' => __("Load plugin's CSS", 'ThreeWP_Ajax_Search'),
				'description' => __("Load the standard CSS for this plugin or let the theme handle the CSS display of the search box?", 'ThreeWP_Ajax_Search'),
			),
			'cursor_key_navigation' => array(
				'name' => 'cursor_key_navigation',
				'type' => 'checkbox',
				'label' => __("Enable cursor key navigation of search results", 'ThreeWP_Ajax_Search'),
			),
			'cursor_key_navigation_loops' => array(
				'name' => 'cursor_key_navigation_loops',
				'type' => 'checkbox',
				'label' => __("Loop the cursor navigation?", 'ThreeWP_Ajax_Search'),
				'description' => __("If at the top/bottom of the list, should the cursor loop to the bottom/top of the list?", 'ThreeWP_Ajax_Search'), 
			),
			'results_to_display' => array(
				'name' => 'results_to_display',
				'type' => 'text',
				'label' => __('Maximum amount of results to display', 'ThreeWP_Ajax_Search'),
				'css_class' => 'regular-text',
				'validation' => array(
					'valuemin' => 0,
					'valuemax' => 100,
				),
			),
			'selector_search_form' => array(
				'name' => 'selector_search_form',
				'type' => 'text',
				'label' => __('Search form', 'ThreeWP_Ajax_Search'),
				'description' => sprintf(
					__('CSS selector for the search form. The default is: %s', 'ThreeWP_Ajax_Search'),
					'<code>#searchform</code>'
				),
				'css_class' => 'regular-text',
			),
			'selector_search_input' => array(
				'name' => 'selector_search_input',
				'type' => 'text',
				'label' => __('Search input', 'ThreeWP_Ajax_Search'),
				'description' => sprintf(
					__('The text input for the search form. The default is: %s', 'ThreeWP_Ajax_Search'),
					'<code>#s</code>'
				),
				'css_class' => 'regular-text',
			),
			'selector_search_results' => array(
				'name' => 'selector_search_results',
				'type' => 'text',
				'label' => __('Search results', 'ThreeWP_Ajax_Search'),
				'description' => sprintf(
					__('How to select each item from the search results page. The default is: %s', 'ThreeWP_Ajax_Search'),
					'<code>.hentry</code>'
				),
				'css_class' => 'regular-text',
			),
			'selector_search_results_content' => array(
				'name' => 'selector_search_results_content',
				'type' => 'text',
				'label' => __('Result box content', 'ThreeWP_Ajax_Search'),
				'description' => sprintf(
					__('How to select the search results box content that pops up: %s', 'ThreeWP_Ajax_Search'),
					'<code>.threewp_ajax_search_results_content ul</code>'
				),
				'css_class' => 'regular-text',
			),
			'display_format_header' => array(
				'name' => 'display_format_header',
				'type' => 'textarea',
				'label' => __('Header text', 'ThreeWP_Ajax_Search'),
				'description' => __('Display this text before the results.', 'ThreeWP_Ajax_Search'),
				'rows' => 2,
				'cols' => 50,
				'validation' => array( 'empty' => true ),
			),
			'display_format_item' => array(
				'name' => 'display_format_item',
				'type' => 'textarea',
				'label' => __('Item display format', 'ThreeWP_Ajax_Search'),
				'description' => sprintf(
					__('Display each item using this template. Use %s for the item\'s li class and %s for the item text itself.', 'ThreeWP_Ajax_Search'),
					'<code>%item_class%</code>',
					'<code>%item%</code>'
				),
				'rows' => 2,
				'cols' => 50,
			),
			'display_format_footer' => array(
				'name' => 'display_format_footer',
				'type' => 'textarea',
				'label' => __('Footer text', 'ThreeWP_Ajax_Search'),
				'description' => __('Display this text after the results.', 'ThreeWP_Ajax_Search'),
				'rows' => 2,
				'cols' => 50,
				'validation' => array( 'empty' => true ),
			),
			'callback_after_init' => array(
				'name' => 'callback_after_init',
				'type' => 'textarea',
				'label' => __('After initialisation', 'ThreeWP_Ajax_Search'),
				'description' => __('', 'ThreeWP_Ajax_Search'),
				'rows' => 5,
				'cols' => 80,
				'validation' => array( 'empty' => true ),
			),
			'callback_after_fetch' => array(
				'name' => 'callback_after_fetch',
				'type' => 'textarea',
				'label' => __('After fetching new results', 'ThreeWP_Ajax_Search'),
				'description' => __('', 'ThreeWP_Ajax_Search'),
				'rows' => 5,
				'cols' => 80,
				'validation' => array( 'empty' => true ),
			),
			'callback_before_hide' => array(
				'name' => 'callback_before_hide',
				'type' => 'textarea',
				'label' => __('Before hiding the result box', 'ThreeWP_Ajax_Search'),
				'description' => __('', 'ThreeWP_Ajax_Search'),
				'rows' => 5,
				'cols' => 80,
				'validation' => array( 'empty' => true ),
			),
			'callback_before_show' => array(
				'name' => 'callback_before_show',
				'type' => 'textarea',
				'label' => __('Before showing the result box', 'ThreeWP_Ajax_Search'),
				'description' => __('', 'ThreeWP_Ajax_Search'),
				'rows' => 5,
				'cols' => 80,
				'validation' => array( 'empty' => true ),
			),
		);
		
		$inputs_import_export = array(
			'serialized_settings' => array(
				'name' => 'serialized_settings',
				'type' => 'text',
				'label' => __('Serialized settings', 'ThreeWP_Ajax_Search'),
				'description' => __('The settings have been <code>PHP serialized</code> into a normal text string.', 'ThreeWP_Ajax_Search'),
				'maxlength' => 1000000,
				'css_class' => 'regular-text',
				'value' => serialize( $settings ),
				'validation' => array( 'empty' => true ),
			),
			'import_settings' => array(
				'name' => 'import_settings',
				'type' => 'submit',
				'value' => __('Import settings', 'ThreeWP_Ajax_Search'),
				'css_class' => 'button-secondary',
			),
		);
		
		$input_update_settings = array(
			'name' => 'update_settings',
			'type' => 'submit',
			'value' => __('Update settings', 'ThreeWP_Ajax_Search'),
			'css_class' => 'button-primary',
		);
		
		if ( isset($_POST['update_settings']) )
		{
			$result = $form->validate_post($inputs, array_keys($inputs), $_POST);
			if ($result === true)
			{
				$all_settings = get_option('settings');
				foreach($inputs as $key => $input)
					$all_settings[$id][$key] = stripslashes( $_POST[$key] );
				update_option( 'settings', $all_settings);
				$settings = get_option('settings');
				$settings = $settings[$id];
				$this->message('Settings have been saved!');
			}
			else
			{
				$this->error( implode('<br />', $result) );
			}
		}

		foreach($inputs as $name => $input)
		{
			if ( isset($_POST['update_settings']) )
				$form->usePostValue($inputs[$name], null, $_POST, $name);
			else
				$inputs[$name]['value'] = $settings[$name];
		}
				
		$returnURL = remove_query_arg(array('tab', 'edit_id'));


		$returnValue = '
			<h3>'.__("General settings", 'ThreeWP_Ajax_Search').'</h3>
			
			'.$form->start().'
			
			<table class="form-table">
				<tbody>
		';

		foreach(array(
			'name',
			'description',
			'search_url',
			'cursor_key_navigation',
			'cursor_key_navigation_loops'
		) as $input)
			$returnValue .= $this->make_table_row($inputs[$input], $form);

		$returnValue .= '
				</tbody>
			</table>
		';



		$returnValue .= '
			<h3>'.__("Search box display", 'ThreeWP_Ajax_Search').'</h3>
			<table class="form-table">
				<tbody>
		';

		foreach(array(
			'load_css',
			'chars_before_search',
			'time_before_search',
			'results_to_display'
		) as $input)
			$returnValue .= $this->make_table_row($inputs[$input], $form);

		$returnValue .= '
				</tbody>
			</table>
		';


		
		$returnValue .= '
			<h3>'.__("CSS selectors", 'ThreeWP_Ajax_Search').'</h3>
			<table class="form-table">
				<tbody>
		';

		foreach(array(
			'selector_search_form',
			'selector_search_input',
			'selector_search_results',
			'selector_search_results_content',
		) as $input)
			$returnValue .= $this->make_table_row($inputs[$input], $form);

		$returnValue .= '
				</tbody>
			</table>
		';


		
		$returnValue .= '
			<h3>'.__("Display template", 'ThreeWP_Ajax_Search').'</h3>
			<table class="form-table">
				<tbody>
		';

		foreach(array(
			'display_format_header',
			'display_format_item',
			'display_format_footer',
		) as $input)
			$returnValue .= $this->make_table_row($inputs[$input], $form);

		$returnValue .= '
				</tbody>
			</table>
		';

		$url_help = add_query_arg('tab', 'help');
		$returnValue .= '
			<h3>'.__("Javascript callbacks", 'ThreeWP_Ajax_Search').'</h3>
			
			<p>
				Please see the <a href="'.$url_help.'">help page</a> for information about javascript callbacks. Per default they do very little, just a simple fade in/out. Those of you with more jQuery-talent can make something spiffier and then <a href="mailto:edward@mindreantre.se">send me the code</a> and I\'ll include it in the next release.
			</p>
			<table class="form-table">
				<tbody>
		';

		foreach(array(
			'callback_after_init',
			'callback_after_fetch',
			'callback_before_hide',
			'callback_before_show',
		) as $input)
			$returnValue .= $this->make_table_row($inputs[$input], $form);

		$returnValue .= '
				</tbody>
			</table>
		';


		$returnValue .= '
			<div>
				'.$form->make_input( $input_update_settings ).'
			</div>
			
			<p>
				<a href="'.$returnURL.'">' . __('Return to overview', 'ThreeWP_Ajax_Search') . '</a>
			</p>

			'.$form->stop().'
		';


		$returnValue .= '
			<h3>'.__("Import settings", 'ThreeWP_Ajax_Search').'</h3>
			'.$form->start().'
			
			<p>'.__("If you want to save these settings, save the contents of the text input into a text file. If you wish to quickly import previously-saved settings, put the text in the box and press the <em>import settings</em> button.", 'ThreeWP_Ajax_Search').'</p>

			<table class="form-table">
				<tbody>
		';

		foreach(array(
			'serialized_settings',
		) as $input)
			$returnValue .= $this->make_table_row($inputs_import_export[$input], $form);

		$returnValue .= '
				</tbody>
			</table>
			
			<div>
				'.$form->make_input( $inputs_import_export[ 'import_settings'] ).'
			</div>
			
			<p>
				<a href="'.$returnURL.'">' . __('Return to overview', 'ThreeWP_Ajax_Search') . '</a>
			</p>

			'.$form->stop().'
		';

	
		echo $returnValue;
	}
	
	public function admin_help()
	{
		echo "
		<p>
			ThreeWP Ajax Search enabled ajax searching for your Wordpress install. It uses Wordpress' own search function to find results and jquery to parse and display them. 
		</p>

		<p>
			The default settings work for Twentyten although they should work for any theme that follows the normal Wordpress HTML ID and CSS naming conventions. 
		</p>
		
		<h3>Extending ajax search using Javascript callbacks</h3>
		
		<p>
			If you would like fancy / fancier effects you can write your own javascript functions and link them to ThreeWP Ajax Search. The available callback hooks are:
		</p>

		<ul>
			<li><code>After initalization</code> is called after ajax search has set itself up.</li>
			<li><code>After fetching new results</code> comes right after the new results have been received and the header + items + footer have been appended to the supercontainer class.</li>
			<li><code>Before hiding</code> comes just before the results box is about to be hidding because of the search input's blur().</li>
			<li><code>Before showing</code> is before the results are about to be (re)shown to the user.</li>
		</ul>
		
		<p>
			All callbacks are sent two parameters: the jQuery object of the form ajax search has attached itself to, and the callback to be called after you're done with your function.
		</p>
		
		<p>
			I haven't been able to make any fancy effects myself other than a simple fade in/out. If you're handier with jQuery than I feel free to send <a href='mailto:edward@mindreantre.se'>me some examples of your work</a>.
		</p>
		";
	}
	
	// --------------------------------------------------------------------------------------------
	// ----------------------------------------- Misc functions
	// --------------------------------------------------------------------------------------------

	public function prepare_js()
	{
		$all_settings = get_option('settings');
		$all_settings = ( is_array($all_settings) ? $all_settings : array() );
		
		foreach($all_settings as $index => $settings)
		{
			if ( !$settings['enabled'] )
				continue;
				
			$this->load_own_css |= $settings['load_css'];
			
			$search_url = ( $settings['search_url'] == '' ? get_bloginfo('url') . '/?s=' : $settings['search_url'] );
			
			foreach(array(
				'display_format_header',
				'display_format_item',
				'display_format_footer',
			) as $key)
			{
				$settings[$key] = str_replace("\r", "", $settings[$key]);
				$settings[$key] = addslashes( $settings[$key] );
				$settings[$key] = str_replace("\n", "\\\n", $settings[$key]);
			}
			
			foreach($this->callbacks as $callback)
				if ($settings['callback_' . $callback] == '')
					$settings['callback_' . $callback] = "''";

			$this->wp_enqueue_script .= '
				<script type="text/javascript">
					/* <![CDATA[ */
					jQuery(document).ready(function($) {
						ThreeWP_Ajax_Search.init({
							name : "'.$settings['name'].'",
							name_md5 : "'.md5('ajax_search_settings_index_' . $index).'",
							chars_before_search : '.$settings['chars_before_search'].',
							time_before_search : '.$settings['time_before_search'].',
							cursor_key_navigation : '.intval($settings['cursor_key_navigation']).',
							cursor_key_navigation_loops : '.intval($settings['cursor_key_navigation_loops']).',
							results_to_display : '.$settings['results_to_display'].',
							selector_search_form : "'.$settings['selector_search_form'].'",
							selector_search_input : "'.$settings['selector_search_input'].'",
							selector_search_results : "'.$settings['selector_search_results'].'",
							selector_search_results_content : "'.$settings['selector_search_results_content'].'",
							display_format_header : "'.$settings['display_format_header'].'",
							display_format_item : "'.$settings['display_format_item'].'",
							display_format_footer : "'.$settings['display_format_footer'].'",
							callbacks : {
								"after_init" : '.$settings['callback_after_init'].',
								"after_fetch" : '.$settings['callback_after_fetch'].',
								"before_hide" : '.$settings['callback_before_hide'].',
								"before_show" : '.$settings['callback_before_show'].'
							},
							search_url : "'.$search_url.'"
						});
					});
					/* ]]> */
				</script>
			';
		}
	}
	
	private function make_table_row($input, $form = null)
	{
		if ($form === null)
			$form = $this->form();
		return '
			<tr>
				<th>'.$form->make_label($input).'</th>
				<td>
					<div class="input_itself">
						'.$form->make_input($input).'
					</div>
					<div class="input_description">
						'.$form->make_description($input).'
					</div>
				</td>
			</tr>';
	}
	
	private function generate_new_settings()
	{
		$new_settings = $this->default_settings;
		$new_settings['name'] .= ' ' . $this->now();
		return $new_settings;
	}
	
	private function create_settings()
	{
		$settings = get_option('settings');
		$settings[] = $this->generate_new_settings();
		update_option( 'settings', $settings);
	}		
		
}
$threewp_ajax_search = new ThreeWP_Ajax_Search();
?>