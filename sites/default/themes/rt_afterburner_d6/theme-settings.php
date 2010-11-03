<?php

/**
* Implementation of THEMEHOOK_settings() function.
*
* @param $saved_settings
*   array An array of saved settings for this theme.
* @return
*   array A form array.
*/
function afterburner_settings($saved_settings){
	
	$defaults = afterburner_settings_defaults();

  // Merge the saved variables and their default values
  $settings = array_merge($defaults, $saved_settings);

  // Create the form widgets using Forms API

	 $form['theme'] = array(
	  '#type' => 'fieldset',
	  '#title' => t('Theme'),
	  '#collapsible' => TRUE,
	  '#collapsed' => FALSE,
	);
	
	$form['theme']['color_style'] = array(
    '#type' => 'select',
    '#title' => t('Default Color Style'),
		'#options' => array(
	  		'light' => 'Light',  
	  		'light2' => 'Light 2', 
	  		'light3' => 'Light 3',  
	  		'light4' => 'Light 4',  
	  		'dark' => 'Dark',
	  		'dark2' => 'Dark 2',
	  		'dark3' => 'Dark 3',
	  		'dark4' => 'Dark 4'

	),
	'#default_value' => $settings['color_style'],
  );

// Page Widths -----------------------------
	$form['widths'] = array(
	  '#type' => 'fieldset',
	  '#title' => t('Page Widths'),
	  '#collapsible' => TRUE,
	  '#collapsed' => FALSE,
	);
	
	$form['widths']['template_width'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Template Width'),
	    '#default_value' => $settings['template_width'],
			'#size' => 10,
			'#required' => TRUE
	  );
	  
	  $form['widths']['leftcolumn_width'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Left Column Width'),
	    '#default_value' => $settings['leftcolumn_width'],
			'#size' => 10,
			'#required' => TRUE
	  );
	  
	  $form['widths']['rightcolumn_width'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Right Column Width'),
	    '#default_value' => $settings['rightcolumn_width'],
			'#size' => 10,
			'#required' => TRUE
	  );
	  

// ELEMENTS ------------------------------
	 $form['elements'] = array(
	  '#type' => 'fieldset',
	  '#title' => t('Elements'),
	  '#collapsible' => TRUE,
	  '#collapsed' => FALSE,
	);
	
	$form['elements']['leftcolumn_color'] = array(
    '#type' => 'select',
    '#title' => t('Left Column Color'),
		'#options' => array(
	  		'color1' => 'Color 1',  
	  		'color2' => 'Color 2'

	),
	'#default_value' => $settings['leftcolumn_color'],
  );
  
  $form['elements']['rightcolumn_color'] = array(
    '#type' => 'select',
    '#title' => t('Right Column Color'),
		'#options' => array(
	  		'color1' => 'Color 1',  
	  		'color2' => 'Color 2'

	),
	'#default_value' => $settings['rightcolumn_color'],
  );
	
	$form['elements']['show_breadcrumb'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show breadcrumbs'),
    '#default_value' => $settings['show_breadcrumb']
	);


  // Return the additional form widgets
  return $form;
	
}




function afterburner_settings_defaults(){
	
	$defaults = array(

		'color_style'					=> "light4",			// style1 - style5
		'enable_ie6warn'         		=> "false",           // true | false
		'template_width'				=> "962",			 	// width in px
		'leftcolumn_width'				=> "210",			 	// width in px
		'rightcolumn_width'				=> "220",			 	// width in px
		'leftcolumn_color'				=> "color2",
		'rightcolumn_color'				=> "color1",
		'show_breadcrumb' 				=> "true",			 	// true | false
		'show_logo'		 				=> "true"			 	// true | false
		
  );
  
	return $defaults;
	
}


