<?php
/**
	Form handling class
	-------------------
	
<p>ThreeWP_Forms is a XHTML form class that handles: creation, display and validation of form elements and complete form layouts.</p>

Using the class

First, create the class:

$form = new ThreeWP_Forms();

During your display of the HTML:

echo $form->start();

Now you can build your forms using arrays as inputs.

$input_text = array(
  'name' => 'my_text_example',
  'type' => 'text',
  'size' => 60,  // recommended that you have any size specified
  'css_class' => 'text_area_orange',  // optional
  'css_style' => 'font-size: 500%;',  // optional
  'value' => 'This is the default text displayed', // optional
  'description' => 'This is a short, optional description. Note that you'll need to put divs around the description in order to do interesting stuff with it.',
);

echo $form->make_label( $input_text ); // The accessible label
echo $form->make_input( $input_text ); // The input itself
echo $form->make_description( $input_text ); // displays only the description, including validation info.


And to finish up the form after displaying:

echo $form->stop();



		Input types

Most of the input types have the css_class, css_style, escription, value fields in common.


		checkbox

$input_checkbox = array(
  'name' => 'checkbox_example',
  'type' => 'checkbox',
  'label' => 'Label of checkbox',
  'checked' => true,
);

value, description is optional.


		file

$input_file = array(
  'name' => 'file_example',
  'type' => 'file',
  'value' => 'Text on button',
);



		image

An image is used instead of a submit button.

$input_image = array(
  'name' => 'image_example',
  'type' => 'image',
  'label' => 'ALT value of image'
  'src' => 'images/submit.png',
);



		password

Similar to text, except that the value isn't displayed.

$input_password = array(
  'name' => 'password_example',
  'type' => 'password',
  'label' => 'Displayed label',
);



		radio

$input_radio = array(
  'name' => 'radio_example',
  'type' => 'radio
  'label' => 'Label of radio box',
  'options' => array(
    array('value' => 'option001', 'text' => 'First radio option'),
    array('value' => 'option002', 'text' => 'Second radio option'),
  ),
);



		select

$input_select = array(
  'name' => 'select_example',
  'type' => 'select',
  'label' => 'Label of checkbox',
  'multiple' => false,  // Allow selection of multiple values
  'size' => 5,  // How many option rows to display.
  'options' => array(
    array('value' => 'option001', 'text' => 'First select option'),
    array('value' => 'option002', 'text' => 'Second select option'),
  ),
);



		submit

$input_submit = array(
  'name' => 'submit_example',
  'type' => 'submit',
  'value' => 'Displayed on the button',
);



		text

$input_text = array(
  'name' => 'text_example',
  'type' => 'text
  'label' => 'Label of text box',
);



		textarea

$input_textarea = array(
  'name' => 'textarea_example',
  'type' => 'textarea',
  'label' => 'Label of text area',
  'rows' => 80,
  'cols' => 10,
);
	
	Validation
	----------
	empty			Field is allowed to be empty
	valuemin		Value: minimum
	valuemax		Value: maximum
	datetime		Date must be in this format. (Use format keywords from date(). "Y-m-d").
	datemaximum		Latest date/time allowed. Any date() format.
	lengthmin		Length: minimum
		
 */
class ThreeWP_Form
{
	private $options;
	
	private $default_options = array(
		'class' => '',
		'global_nameprefix' => '',
		'nameprefix' => '',
		'namesuffix' => '',
		'title' => '',
		'alt' => '',
		'value' => '',
		'multiple' => false,
		'size' => 1,
		'maxlength' => 100,
		'disabled' => false,
		'readonly' => false,
		'display_two_rows' => false,
		'style' => 'STYLE1',
		'css_class' => '',
		'css_style' => '',
		'form_method' => 'post',
		'form_action' => '',
		'description' => '',
	);
	
    protected $language_data = array();
	
	private $sections = array();
	
	function __construct($options = array())
	{
		$this->options = array_merge($this->default_options, $options);
		$this->language_data = ThreeWP_FormLanguage::$language_data;
	}
	
	/**
	 * Returns the _POST data of the calling class.
	 */
	public static function get_post_data($callingClass, $POST = null)
	{
		if ($POST === null)
			$POST = $_POST;
		if (isset( $POST[ get_class($callingClass) ] ))
			return $POST[ get_class($callingClass) ];
	}
	
	/**
	 * Cleans up the name of an input, remove illegal characters.
	 */
	public static function fix_name($name)
	{
		return preg_replace('/\[|\]| |\'|\\\|\?/', '_', $name);
	}
	
	/**
	 * Returns a text ID of this input. 
	 */
	public function make_id($options)
	{
		$options = array_merge($this->options, $options);
		$options['name'] = self::fix_name($options['name']);

		// Add the global prefix
		$options['nameprefix'] = $this->options['global_nameprefix'] . $options['nameprefix'];  
			
		return $options['class'] . '_' . preg_replace('/\[|\]/', '_', $options['nameprefix']) .  '_' . $options['name'] .  $options['namesuffix'];
	}
	
	/**
	 * Returns the name of this input. 
	 */
	public static function make_name($options)
	{
		$options['name'] = self::fix_name($options['name']);
		if ($options['class']!='')
			return $options['class'] . $options['global_nameprefix'] . $options['nameprefix'] . '[' . $options['name'] . ']';
		else
		{
			$returnValue = $options['global_nameprefix'];

			// Remove the first [ and first ]. Yeah, that's how lovely forms work: the first prefix doesn't have brackets. The rest do.
			$returnValue .= ($returnValue == '' ?
				preg_replace('/\[/', '',
					preg_replace('/\]/', '', $options['nameprefix'], 1)
				, 1) : $options['nameprefix']);
			$returnValue .= ($returnValue == '' ? $options['name'] : '[' . $options['name'] . ']');
		}
		return $returnValue;
	}
	
	/**
	 * Returns a simple <form> tag (with action and method set).
	 */
	public function start()
	{
		return '<form enctype="multipart/form-data" action="'.$this->options['form_action'].'" method="'.$this->options['form_method'].'">' . "\n";
	}
	
	/**
	 * Returns </form>. That's it.
	 */
	public function stop()
	{
		return '</form>' . "\n";
	}
	
	/**
	 * Makes a small asterisk thingy that is supposed to symbolise that the field is required.
	 */
	private function make_required_field($options)
	{
		$returnValue = '';
		switch($options['type'])
		{
			case 'text':
			case 'textarea':
				$needed = false;
				if (!isset($options['validation']))
					$needed = true;
				else
				{
					if (!isset($options['validation']['empty']))
						$needed = true;
					if (isset($options['validation']['valuemin']) || isset($options['validation']['valuemax']))
						$needed = false;
				}
				if ($needed)
					$returnValue .= '<sup><span class="screen-reader-text aural-info"> ('.$this->l('Required field').')</span><span title="'.$this->l('Required field').'">*</span></sup>';
			break;
			default:
			break;
		}
		return $returnValue;
	}
	
	/**
	 * Returns the label of this input.
	 */
	public function make_label($options)
	{
		// Merge the given options with the options we were constructed with.
		$options = array_merge($this->options, $options);
		
		if (!isset($options['label']))
			return null;
			
		$extra = '';
		
		if ($options['title'] != '')
			$extra .= ' title="'.$options['title'].'"';
			
		$requiredField = $this->make_required_field($options);
			
		return '<label for="'.$this->make_id($options).'"'.$extra.'>'.$options['label'].$requiredField.'</label>';
	}
	
	/**
	 * Returns the description of this input.
	 */
	public function make_description($options)
	{
		// Merge the given options with the options we were constructed with.
		$options = array_merge($this->options, $options);
		
		if ($options['description'] == '')
			return '';
		
		$returnValue = '
			<div>
				<div class="screen-reader-text aural-info">
					'.$this->l('Description').':
				</div>
				'.$options['description'].'
			</div>';

		$returnValue .= $this->make_validation($options);			
			
		return $returnValue;
	}
	
	private function make_validation($options)
	{
		$validation = array();
		if (isset($options['validation']))
		{
			$validationArray = $options['validation'];
			if ( isset($validationArray['valuemin']) && !isset($validationArray['valuemax']) )
				$validation[] = $this->l('The value must be larger than or equal to') . ' ' . $validationArray['valuemin']; 
			if ( !isset($validationArray['valuemin']) && isset($validationArray['valuemax']) )
				$validation[] = $this->l('The value must be smaller or equal to') . ' ' . $validationArray['valuemax']; 
			if ( isset($validationArray['valuemin']) && isset($validationArray['valuemax']) )
				$validation[] = $this->l('Valid values') . ': ' . $validationArray['valuemin'] . ' ' . $this->l('to') . ' ' . $validationArray['valuemax']; 
			if ( isset($validationArray['lengthmin']) )
				$validation[] = $this->l('Minimum length') . ': ' . $validationArray['lengthmin'] . ' ' . $this->l('characters'); 
			if ( isset($validationArray['passwordstrength']) )
			{
				$type = $validationArray['passwordstrength'];
				$checkFunction = "passwordStrengthGet$type";
				$rules = $this->$checkFunction();
				$rules = $this->l('The password must') . ': ' . implode(', ', $rules);
				$validation[] = $rules;
			}
			if ( isset($validationArray['datetime']) )
			{
				$formatString = $validationArray['datetime'];
				$formatString = str_replace('m', $this->l('MM'), $formatString);
				$formatString = str_replace('d', $this->l('DD'), $formatString);
				$formatString = str_replace('H', $this->l('HH'), $formatString);
				$formatString = str_replace('i', $this->l('MM'), $formatString);
				$formatString = str_replace('s', $this->l('SS'), $formatString);
				$formatString = str_replace('Y', $this->l('YYYY'), $formatString);
				$validation[] = $this->l('Date format') . ': ' . $formatString;
			} 
			if ( isset($validationArray['datemaximum']) )
			{
				$validation[] = $this->l('Latest valid date') . ': ' .  $validationArray['datemaximum'];
			}
		}
			
		if (count($validation)>0)
			return '<div>' . implode(', ', $validation) . '</div>';
		else
			return '';
	}
	
	/**
	 * Makes an input string.
	 */
	public function make_input($options)
	{
		// Merge the given options with the options we were constructed with.
		$options = array_merge($this->options, $options);
		
		$extraOptions = '';
		if ($options['disabled'])
			$extraOptions .= ' disabled="disabled" ';
		if ($options['readonly'])
			$extraOptions .= ' readonly="readonly" ';
			
		$classes = $options['type'];
		if ($options['css_class'] != '')
			$classes .= ' ' . $options['css_class'];
		
		// Add title to all
		$extraOptions .= ' title="'.$options['title'].'"';
		// Add alt to all except textarea
		if (!in_array($options['type'], array('select', 'textarea')))
			$extraOptions .= ' alt="'.$options['alt'].'"';
		
		if ($options['css_style'] != '')
			$extraOptions .= ' style="'.$options['css_style'].'"';
			
		// Add the global prefix
		$options['nameprefix'] = $options['global_nameprefix'] . $options['nameprefix'];  
			
		switch ($options['type'])
		{
			case 'select':
				if ($options['multiple'])
				{
					$extraOptions .= ' multiple="multiple" ';
					$nameSuffix = '[]';		// Names for multiple selects need []
				}
				else
					$nameSuffix = '';
				
				// Convert the value text to an array
				if (!is_array($options['value']))
					$options['value'] = array($options['value']);
					
				// Make the options
				$optionsText = '';
				foreach($options['options'] as $option)
				{
					$selected = in_array($option['value'], $options['value'], true) ? 'selected="selected"' : '';
					$optionsText .= '
						<option value="'.$option['value'].'" '.$selected.'>'.$option['text'].'</option>
					';
				}
				
				$returnValue = '<select class="'.$classes.'" name="'.self::make_name($options).$nameSuffix.'" id="'.$this->make_id($options).'" size="'.$options['size'].'" '.$extraOptions.'>
					'.$optionsText.'
					</select>
				';
			break;
			case 'radio':
				// Make the options
				$returnValue = '';
				$baseOptions = array_merge($this->options, $options);
				foreach($options['options'] as $option)
				{
					$checked = ($option['value'] == $options['value']) ? 'checked="checked"' : '';
					$option = array_merge($baseOptions, $option);
					$option['namesuffix'] = $option['value'];
					$option['label'] = $option['text'];
					$returnValue .= '
						<div>
							<input class="'.$classes.'" type="'.$options['type'].'" name="'.self::make_name($options).'" value="'.$option['value'].'" id="'.$this->make_id($option).'" '.$checked.' '.$extraOptions.' />
							'.$this->make_label($option).'
						</div>
					';
				}
			break;
			case 'hidden':
				$returnValue = '<input class="'.$classes.'" type="'.$options['type'].'" name="'.self::make_name($options).'" value="'.$options['value'].'"'.$extraOptions.' />';
			break;
			case 'checkbox':
				if (!isset($options['checked']))
				{
					$options['checked'] = (intval($options['value']) == 1);
					if ($options['value'] == '' || $options['value'] == '0')
						$options['value'] = 1;
				}
				$checked = ($options['checked'] == true ? ' checked="checked" ' : '');
				$returnValue = '<input class="'.$classes.'" type="'.$options['type'].'" name="'.self::make_name($options).'" id="'.$this->make_id($options).'" value="'.$options['value'].'" '.$checked.' '.$extraOptions.' />';
			break;
			case 'submit':
				$returnValue = '<input class="'.$classes.'" type="'.$options['type'].'" name="'.self::make_name($options).'" id="'.$this->make_id($options).'" value="'.$options['value'].'" '.$extraOptions.' />';
			break;
			case 'file':
				$returnValue = '<input class="'.$classes.'" type="'.$options['type'].'" name="'.self::make_name($options).'" id="'.$this->make_id($options).'" value="'.$options['value'].'" '.$extraOptions.' />';
			break;
			case 'password':
				if (isset($options['size']))
				{
					$options['size'] = min($options['size'], $options['maxlength']); // Size can't be bigger than maxlength
					$text['size'] = 'size="'.$options['size'].'"';
				}
				$returnValue = '<input class="'.$classes.'" type="'.$options['type'].'" '.$text['size'].' maxlength="'.$options['maxlength'].'" name="'.self::make_name($options).'"  value="'.htmlspecialchars($options['value']).'" id="'.$this->make_id($options).'"'.$extraOptions.' />';
			break;
			case 'textarea':
				$returnValue = '<textarea class="'.$classes.'" cols="'.$options['cols'].'" rows="'.$options['rows'].'" name="'.self::make_name($options).'" id="'.$this->make_id($options).'"'.$extraOptions.'>'.$options['value'].'</textarea>';
			break;
			case 'image':
				$returnValue = '<input class="'.$classes.'" type="'.$options['type'].'" name="'.self::make_name($options).'[]" id="'.$this->make_id($options).'" value="'.$options['value'].'" title="'.$options['title'].'" src="'.$options['src'].'" '.$extraOptions.' />';
			break;
			default:	// Default = 'text'
				if (isset($options['size']))
				{
					$options['size'] = min($options['size'], $options['maxlength']); // Size can't be bigger than maxlength
					$text['size'] = 'size="'.$options['size'].'"';
				}
				
				$returnValue = '<input class="text '.$classes.'" type="text" '.$text['size'].' maxlength="'.$options['maxlength'].'" name="'.self::make_name($options).'" id="'.$this->make_id($options).'" value="'.htmlspecialchars($options['value']).'"'.$extraOptions.' />';
		}
		return $returnValue;
	}

	/**
	 * Adds a section.
	 * 
	 * $section = array(
	 * 	'name' => 'Name of the section',
	 * 	'description' => 'Section description that tells the user what this section is about.',
	 * 	'inputs' => RESERVED
	 * )
	 */		
	public function add_section($section)
	{
		$section['inputs'] = array();
		$this->sections[ $section['name'] ] = $section;
	}
	
	private function implode_array($data, &$strings, $glueBefore, $glueAfter, $stringPrefix = null, $currentString = null)
	{
		foreach($data as $key=>$value)
		{
			if (!is_array($value))
			{
				$stringToAdd = $stringPrefix . $currentString . $glueBefore . $key . $glueAfter;
				$strings[$stringToAdd] = $value;
			}
			else
				$this->implode_array($value, $strings, $glueBefore, $glueAfter,  $stringPrefix, $currentString . $glueBefore.$key.$glueAfter);
		}
	}
	
	public function usePostValue(&$input, $settings, $postData, $key)
	{
		if ($input['type']=='submit')		// Submits don't get their values posted, so return the value.
			return $input['value'];
			
		$input['name'] = self::fix_name($input['name']);
			
		// Merge the default options.
		// In case this class was created with a nameprefix and the individual inputs weren't, for example.
		$input = array_merge($this->options, $input);
			
		if ($postData === null)
		{
			if ($settings !== null)
				if (in_array($input['type'], array('text', 'textarea', 'checkbox', 'select')))
					if (@$input['value'] == '')
						$input['value'] = stripslashes( $settings->get($key) );
			return;
		}
		
		// Nameprefix? Find the right array section in the post.			
		if ($input['nameprefix'] != '')
		{
			$strings = '';
			$this->implode_array($postData, $strings, '__', '', $this->options['class'] . '');
		}
		else
		{
			if (isset($postData[$input['name']]))
				if (!is_array($postData[$input['name']]))
					$input['value'] = @stripslashes($postData[$input['name']]);		// @ is for unchecked checkboxes. *sigh*
				else
				{
					$input['value'] = array();	// Kill the value, otherwise postvalues are just appended and therefore do nothing.
					foreach($postData[$input['name']] as $index=>$value)
						$input['value'][$index] = stripslashes($value);
				}
		}
		
		$inputID = $this->make_id($input);
		if (isset($strings[$inputID]))
		{
			switch($input['type'])
			{
				default:
					@$input['value'] = stripslashes( $strings[$inputID] );
			}
		}
	}
	
	/**
	 * Adds an input to a section.
	 * Kinda like makeInput, but with a section name.
	 */
	public function add_section_input($section, $input, $settings, $postData = null)
	{
		if (!is_string($input))
		{
			$input = array_merge($this->options, $input);
			if ($input['type'] == 'rawtext')
				$input['name'] = rand(0, time());
			$this->usePostValue($input, $settings, $postData, $input['name']);
		}
		else
			$input = array(
				'type' => 'rawtext',
				'value' => $input,
			);
		if ($input['type'] == 'rawtext')
			$input['name'] = rand(0, time());
			
		$this->sections[ $section['name'] ]['inputs'][] = $input;
	}
	
	public function add_text_section($sectionName, $text)
	{
		$this->sections[ $sectionName ]['inputs'][] = array(
			'type' => 'rawtext',
			'value' => $text,
		);
	}
	
	/**
		Adds sections + inputs "automatically".
		
		Using $layout, the modules $settings module and the postdata, it creates a form with
		section and inputs.
		
		Example layout
		
		private $inputLayout = array(
			0 => array(
				'name' => 'ExampleSection',
				'description' => 'This section deals with examples. Examples are good.',
				'autoinputs' => array(
			    	'IFACMS_STAGE_PAGE_TITLE_SEPARATOR' => array('text'),
				),  // Inputs
				'inputs' => array(
						array(
							'type' => 'submit',
							'name'=>'CHANGE_SETTINGS_BASE',
							'value' => 'Change settings',
						)
				), // Manualinputs
			),	// 0
		); // inputLayout
		
		Tip: If your module requires several pages/tabs of settings, put the layouts in one big
		layoutarray and make the tab name the key.
		
	*/
	public function add_layout($layouts, $inputData, $settings, $postData = null)
	{
		$layoutDefaults = array(
			'autoinputs' => array(),
			'inputs' => array(),
		);

		foreach($layouts as $sectionNumber => $layout)
		{
			$this->add_section($layout);
			$layout = array_merge($layoutDefaults, $layout);
			
			foreach($layout['autoinputs'] as $inputName)
			{
				$input = $inputData[$inputName];
				
				$input['name'] = $inputName;

				$this->add_section_input($layout, $input, $settings, $postData);
			}
			foreach($layout['inputs'] as $manualInput)
				$this->add_section_input($layout, $manualInput, $settings, $postData);
		}
	}
	
	/**
	 * Displays a whole form with sections and all the section inputs.
	 */
	public function display()
	{
		$style = array(
			'formStart'							=> '<div class="form-%%STYLE%%-start">',
			'formStop'							=> '</div>',
			'sectionStart'						=> '	<fieldset class="form-%%STYLE%%-section-start %%CSSCLASS%%">',
			'sectionStop'						=> '	</fieldset>',
			'sectionNameStart'					=> '		<legend class="form-%%STYLE%%-section-name">',
			'sectionNameStop'					=> '		</legend>',
			'sectionDescriptionStart'			=> '		<div class="form-%%STYLE%%-section-description">',
			'sectionDescriptionStop'			=> '		</div>',
			'rowStart'							=> '			<div class="form-%%STYLE%%-row-start">',
			'rowStop'							=> '			</div>',
			'labelContainerStart'				=> '				<div class="form-%%STYLE%%-labelcontainer-start">',
			'labelContainerStop'				=> '				</div>',
			'labelContainerSingleStart'			=> '				<div class="form-%%STYLE%%-labelcontainer-single-start">',
			'labelContainerSingleStop'			=> '				</div>',
			'labelStart'						=> '					<div class="form-%%STYLE%%-label-start">',
			'labelStop'							=> '					</div>',
			'inputContainerStart'				=> '				<div class="form-%%STYLE%%-inputcontainer-start">',
			'inputContainerStop'				=> '				</div>',
			'inputContainerSingleStart'			=> '				<div class="form-%%STYLE%%-inputcontainer-single-start">',
			'inputContainerSingleStop'			=> '				</div>',
			'inputStart'						=> '					<div class="form-%%STYLE%%-input-start">',
			'inputStop'							=> '					</div>',
			'descriptionContainerStart'			=> '				<div class="form-%%STYLE%%-descriptioncontainer-start">',
			'descriptionContainerStop'			=> '				</div>',
			'descriptionStart'					=> '					<div class="form-%%STYLE%%-description-start">',
			'descriptionStop'					=> '					</div>',
		);
		
		$returnValue = $style['formStart'] . "\n";
		
		foreach($this->sections as $sectionName => $sectionData)
		{
			$sectionData = array_merge(array(
				'description' => null,
				'css_class' => null,
			), $sectionData);
			$sectionDescription = ($sectionData['description']!=null ? $style['sectionDescriptionStart'] . $sectionData['description'] . $style['sectionDescriptionStop'] . "\n" : '');
			$returnValue .= $style['sectionStart'] . "\n" .
				$style['sectionNameStart'] . "\n" .
					'			' . $sectionName . "\n" .
				$style['sectionNameStop'] . "\n" .
				$sectionDescription;
				
			$returnValue = str_replace('%%CSSCLASS%%', $sectionData['cssClass'], $returnValue);
				
			foreach($sectionData['inputs'] as $index=>$input)
			{
				if ($input['type'] == 'hidden')
				{
					$returnValue .= $this->make_input($input);
					continue;
				}	

				// Force validation stuff to make a description if there isn't one already.
				$validation = $this->make_validation($input);
				if ($validation != '' && !isset($input['description']))
					$input['description'] = '';
					
				$description = (isset($input['description']) ?
					$style['descriptionContainerStart'] . "\n".
						$style['descriptionStart'] . "\n".
							$this->make_description($input) . "\n".
						$style['descriptionStop'] . "\n".
					$style['descriptionContainerStop'] . "\n"
				: '');
				
				if ($input['type'] == 'rawtext')
				{
					if (isset($input['css_class']))
						$inputData = '<div class="'.$input['css_class'].'">'.$input['value'].'</div>';
					else
						$inputData = $input['value'];
				}
				else
				{
					if (!isset($input['display_two_rows']))
						$input['display_two_rows'] = false;		// Standard is one row
					
					
					if ($input['type'] == 'submit')
						$input['display_two_rows'] = true;
						
					if ($input['display_two_rows'] == true)
					{
						$inputData =
							$style['labelContainerSingleStart'] . "\n".
								$style['labelStart'] . "\n".
									'					' . $this->make_label($input) . "\n".
								$style['labelStop'] . "\n".
							$style['labelContainerSingleStop'] . "\n".
							
							$style['inputContainerSingleStart'] . "\n".
								$style['inputStart'] . "\n".
									'					' . $this->make_input($input) . "\n".
								$style['inputStop'] . "\n".
							$style['inputContainerSingleStop'] . "\n".
							
							$description;
					}
					else
					{
						$inputData =
							'<div class="container_for_'.$input['type'].'">' .
							$style['labelContainerStart'] . "\n".
								$style['labelStart'] . "\n".
									'					' . $this->make_label($input) . "\n".
								$style['labelStop'] . "\n".
							$style['labelContainerStop'] . "\n".
								
							$style['inputContainerStart'] . "\n".
								$style['inputStart'] . "\n".
									'					' . $this->make_input($input) . "\n".
								$style['inputStop'] . "\n".
							$style['inputContainerStop'] . "\n".
							"</div>" .
							$description;
					}
				}

				$returnValue .= 
					'		<div class="row'.($index+1).'">' . "\n" .
						$style['rowStart'] . "\n".
							$inputData .  "\n" .
						$style['rowStop']  . "\n" .
					'		</div>' . "\n";
			}
			$returnValue .= $style['sectionStop'] . "\n";
		}
		
		$returnValue .= $style['formStop'] . "\n";
		
		return str_replace('%%STYLE%%', $this->options['style'], $returnValue);
	}

	/**
	 * Generates an SQL-statement that either updates or inserts the values into a table.
	 * 
	 * On an update, it only changes the values that have changed (compares newvalues to oldvalues).
	 * 
	 * @param	inputs An array of inputs in standard input format (see top).
	 * @param	inputsToChange An array of names of which inputs to change.
	 * @param	tableName The table's name
	 */
	public static function generate_changed_sql($inputs, $inputsToChange, $tableName, $uniqueKey, $oldValues, $newValues)
	{
		if ($oldValues === null)
		{
			// Insert.
			
			// Make the keys and values paranthesis.
			$keys = '';
			$values = '';
			foreach($inputsToChange as $key)
			{
				if ($key == $uniqueKey)		// otherwise a null-value is assigned the the query has no effect.
					continue;
					
				$keys .= $key . ', ';
				
				switch($inputs[$key]['type'])
				{
					case 'rawtext':
						continue;
					break;
					case 'checkbox':
						if (isset($newValues[$key]))
							$value = "'1'";
						else
							$value = "'0'";
					break;
					default:
						if ($newValues[$key] == '')
							$value = 'NULL';
						else
							$value = "'$newValues[$key]'";
					break;
				}
				$values .= $value . ', ';
			}
			$keys = '(' . trim($keys, ', ') . ')';
			$values = '(' . trim($values, ', ') . ')';
			
			$returnValue = 'INSERT INTO ' . $tableName . " $keys VALUES $values";
		}
		else
		{
			// Update.
			
			// Sometimes, there might be no new values at all for specific keys. Make sure each newvalue key exists.
			foreach($inputsToChange as $newKey)
				if (!isset($newValues[$newKey]))
					$newValues[$newKey] = null;
			
			// Make the sets
			$sets = '';
			foreach($inputsToChange as $key)
			{
				switch($inputs[$key]['type'])
				{
					case 'rawtext':
						continue;
					break;
					case 'checkbox':
					{
						if ($oldValues[$key] == '1' && !isset($newValues[$key]))
							$sets .= "$key = '0', ";
						if ($oldValues[$key] == '0' && isset($newValues[$key]))
							if ($newValues[$key] !== null)
								$sets .= "$key = '1', ";
					}
					break;
					default:
						if ($oldValues[$key] !== $newValues[$key])
						{
							if ($newValues[$key] === '' | $newValues[$key] === null)
								$sets .= "$key = NULL, " ;
							else
							{
								// If value is an array (multiple choice select input), serialize it.
								if (is_array($newValues[$key]))
									$newValues[$key] = serialize($newValues[$key]);
								$sets .= "$key = '".addslashes($newValues[$key])."', ";
							}
						}
					break;
				}
			}
			$sets = trim($sets, ', ');
			
			if ($sets != '')
				$returnValue = 'UPDATE ' . $tableName . ' SET ' . $sets . " WHERE $uniqueKey = '$oldValues[$uniqueKey]'";
			else
				$returnValue = '';
		}
		return $returnValue;
	}

	/**
	Validate an email address.
	Provide email address (raw input)
	Returns true if the email address has the email 
	address format and the domain exists.
	*/
	public static function valid_email($email)
	{
	   $isValid = true;
	   $atIndex = strrpos($email, "@");
	   if (is_bool($atIndex) && !$atIndex)
	   {
	      $isValid = false;
	   }
	   else
	   {
	      $domain = substr($email, $atIndex+1);
	      $local = substr($email, 0, $atIndex);
	      $localLen = strlen($local);
	      $domainLen = strlen($domain);
	      if ($localLen < 1 || $localLen > 64)
	      {
	         // local part length exceeded
	         $isValid = false;
	      }
	      else if ($domainLen < 1 || $domainLen > 255)
	      {
	         // domain part length exceeded
	         $isValid = false;
	      }
	      else if ($local[0] == '.' || $local[$localLen-1] == '.')
	      {
	         // local part starts or ends with '.'
	         $isValid = false;
	      }
	      else if (preg_match('/\\.\\./', $local))
	      {
	         // local part has two consecutive dots
	         $isValid = false;
	      }
	      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
	      {
	         // character not valid in domain part
	         $isValid = false;
	      }
	      else if (preg_match('/\\.\\./', $domain))
	      {
	         // domain part has two consecutive dots
	         $isValid = false;
	      }
	      else if
	(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
	                 str_replace("\\\\","",$local)))
	      {
	         // character not valid in local part unless 
	         // local part is quoted
	         if (!preg_match('/^"(\\\\"|[^"])+"$/',
	             str_replace("\\\\","",$local)))
	         {
	            $isValid = false;
	         }
	      }
	      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
	      {
	         // domain not found in DNS
	         $isValid = false;
	      }
	   }
	   return $isValid;
	}

	/**
	 * Validates the values based on $inputs and which of the $inputs to check.
	 * 
	 * Returns an array of $key / 'error message' if validation fails, else returns true.
	 */		
	public function validate_post($inputs, $inputs_to_check, $values)
	{
		$returnValue = array();
		
		foreach($inputs_to_check as $key)
		{
			$input = $inputs[$key];
			
			// Because form fixes the name to remove illegal characters, we need to do the same to the key here so that we find the correct values in the POST.
			$key = self::fix_name($key);
			
			$input['type'] = (isset($input['type']) ? $input['type'] : 'text');		// Assume type text.
		
			switch($input['type'])
			{
				case 'text':
					if (isset( $input['validation']['email']) )
					{
						$email = trim($values[$key]);
						if (!self::valid_email($email))
							$returnValue[$key] = $this->l('Invalid email address') . ': ' . $email;
					}
					if (isset( $input['validation']['datetime']) )
					{
						$text = trim($values[$key]);
						$date = strtotime($text);
						$dateFormat = $input['validation']['datetime'];
						
						if (date($dateFormat, $date) != $text && !isset($input['validation']['empty']))
							$returnValue[$key] = $this->l('Could not parse date') . ': ' . $text . ' (' . $input['label'] . ')';
					}
					if (isset( $input['validation']['datemaximum']) )
					{
						$date = strtotime($values[$key]);
						if ($date > strtotime($input['validation']['datemaximum']))
							$returnValue[$key] = $this->l('Invalid date') . ': ' . $text . ' (' . $input['label'] . ')';
					}
					if (isset( $input['validation']['lengthmin']) )
					{
						$text = trim($values[$key]);
						if (strlen($text) < $input['validation']['lengthmin'])
							$returnValue[$key] = '<span class="validation-field-name">' . $input['label'] . '</span> ' . $this->l('must be at least') . ' <em>' . $input['validation']['lengthmin'] . '</em> ' . $this->l('characters long') . '.';
					}

					if (isset( $input['validation']['valuemin']) )
					{
						// First convert to correct type of number...
						if (is_float($input['validation']['valuemin']))
							$value = floatval($values[$key]);
						if (is_int($input['validation']['valuemin']))
							$value = intval($values[$key]);

						if ($value < $input['validation']['valuemin'])
							$returnValue[$key] = '<span class="validation-field-name">' . $input['label'] . '</span> ' . $this->l('may not be smaller than') . ' ' . $input['validation']['valuemin'];
					}
					if (isset( $input['validation']['valuemax']) )
					{
						// First convert to correct type of number...
						if (is_float($input['validation']['valuemin']))
							$value = floatval($values[$key]);
						if (is_int($input['validation']['valuemin']))
							$value = intval($values[$key]);

						if ($value > $input['validation']['valuemax'])
							$returnValue[$key] = '<span class="validation-field-name">' . $input['label'] . '</span> ' . $this->l('may not be larger than') . ' ' . $input['validation']['valuemax'];
					}
				case 'textarea':
					// Is the value allowed to be empty?
					if (!isset( $input['validation']['empty']) )
						if (trim($values[$key]) == '')
							$returnValue[$key] = '<span class="validation-field-name">' . $input['label'] . '</span> ' . $this->l('may not be empty');
				break;
			}
		}
		
		if (count($returnValue)> 0)
			return $returnValue;
		else
			return true;
	}
	
	/**
	 * Returns the translated string, if any.
	 */
	public function l($string, $replacementString = array())
	{
		$language = $this->options['language'];
		
		if (!isset($this->language_data[$string]))
			$returnValue = $string;
		else
			if (isset($this->language_data[$string][$language]))
				$returnValue = $this->language_data[$string][$language];
			else
				$returnValue = $string;
				
		while (count($replacementString) > 0)
		{
			$returnValue = preg_replace('/%s/', reset($replacementString), $returnValue, 1);
			array_shift($replacementString);
		}
			
		return $returnValue; 
	}
}

class ThreeWP_FormLanguage
{
    public static $language_data = array(
		'Could not parse date' => array(
			'sv' => 'Kunde inte tolka datumet',
		),
		'DD' => array(
			'sv' => 'DD',
		),
		'Date format' => array(
			'sv' => 'Datumformat',
		),
		'Description' => array(
			'sv' => 'Beskrivning',
		),
		'HH' => array(
			'sv' => 'TT',
		),
		'Invalid date' => array(
			'sv' => 'Ogiltigt datum',
		),
		'Invalid email address' => array(
			'sv' => 'Ogiltig epostadress',
		),
		'Latest valid date' => array(
			'sv' => 'Senaste till&aring;tna datum',
		),
		'MM' => array(
			'sv' => 'MM',
		),
		'Minimum length' => array(
			'sv' => 'Minimuml&auml;ngd',
		),
		'Required field' => array(
			'sv' => 'M&aring;ste fyllas i',
		),
		'SS' => array(
			'sv' => 'SS',
		),
		'The value must be larger than or equal to' => array(
			'sv' => 'V&auml;rdet m&aring;ste vara st&ouml;rre eller lika med',
		),
		'The value must be smaller or equal to' => array(
			'sv' => 'V&auml;rdet m&aring;ste vara mindre eller lika med',
		),
		'Valid values' => array(
			'sv' => 'Giltiga v&auml;rden',
		),
		'YYYY' => array(
			'sv' => '&Aring;&Aring;&Aring;&Aring;',
		),
		'characters' => array(
			'sv' => 'tecken',
		),
		'characters long' => array(
			'sv' => 'tecken',
		),
		'may not be empty' => array(
			'sv' => 'f&aring;r ej l&auml;mnas tomt',
		),
		'may not be larger than' => array(
			'sv' => 'f&aring;r inte vara st&ouml;rre &auml;n',
		),
		'may not be smaller than' => array(
			'sv' => 'f&aring;r inte vara mindre &auml;n',
		),
		'must be at least' => array(
			'sv' => 'm&aring;ste best&aring; av minst',
		),
		'The password must' => array(
			'sv' => 'L&ouml;senordet m&aring;ste',
		),
		'to' => array(
			'sv' => 'till',
		),
	);
}
?>