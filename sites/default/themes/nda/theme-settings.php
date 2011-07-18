<?php

/**
* Implementation of THEMEHOOK_settings() function.
*
* @param $saved_settings
*   array An array of saved settings for this theme.
* @return
*   array A form array.
*/
function nda_settings($saved_settings){
	
	$defaults = nda_settings_defaults();

    // Merge the saved variables and their default values
    $settings = array_merge($defaults, $saved_settings);

    // Create the form widgets using Forms API

	$form['theme'] = array(
		  '#type' => 'fieldset',
		  '#title' => t('Theme'),
		  '#collapsible' => TRUE,
		  '#collapsed' => FALSE,
	);
	
  	$form['theme']['preset_style'] = array(
	    '#type' => 'select',
	    '#title' => t('Default Theme Style'),
			'#options' => array(
		  		'style1' 	=> 'Style 1',  
		  		'style2' 	=> 'Style 2', 
		  		'style3' 	=> 'Style 3',  
		  		'style4' 	=> 'Style 4',  
				'style5' 	=> 'Style 5',  
		  		'style6' 	=> 'Style 6'
	
		),
		'#default_value' => $settings['preset_style']
  	);

  	
  	$form['theme']['bg_style'] = array(
	    '#type' => 'select',
	    '#title' => t('BG Style'),
			'#options' => array(
		  		'full' 		=> 'Full',   
		  		'medium' 	=> 'Medium',
		  		'simple' 	=> 'Simple'
	
		),
		'#default_value' => $settings['bg_style']
  	);  	
  	
  	$form['theme']['link_color'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Link Color'),
	    '#default_value' => $settings['link_color'],
			'#size' => 10,
			'#required' => TRUE
  ); 


  	
  $form['menu'] = array(
  '#type' => 'fieldset',
  '#title' => t('Menu settings'),
  '#collapsible' => TRUE,
  '#collapsed' => FALSE,
  );

  $form['menu']['menu_type'] = array(
    '#type' => 'select',
    '#title' => t('Menu type'),
		'#options' => array(
			'fusion' => 'Fusion',
			'splitmenu' => 'SplitMenu',
			'none' => 'None'
		),
		'#description' => t('Type of menu for main navigation'),
    '#default_value' => $settings['menu_type'],
  );
  
  $form['menu']['f_enablejs'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable Javascript Menu Effects'),
    '#default_value' => $settings['f_enablejs']
  );   
  
  $form['menu']['menu_columns'] = array(
    '#type' => 'select',
    '#title' => t('Drop Down Columns'),
		'#options' => array(
			'1' => '1',
			'2' => '2'
		
			),
    '#default_value' => $settings['menu_columns']
  );   
  
  $form['menu']['submenu_columns'] = array(
    '#type' => 'select',
    '#title' => t('Sub Menu Drop Down Columns'),
		'#options' => array(
			'1' => '1',
			'2' => '2'
		
			),
    '#default_value' => $settings['submenu_columns']
  ); 
  
   $form['menu']['splitmenu_col'] = array(
    '#type' => 'select',
    '#title' => t('Splitmenu side'),
		'#options' => array(
			'leftcol' => t('Left Column'),
			'rightcol' => t('Right Column')
		),
    '#default_value' => $settings['splitmenu_col'],
  );
  
   $form['menu']['f_opacity'] = array(
	    '#type' => 'select',
	    '#title' => t('Menu Opacity'),
	    '#options' => array(
			'1' => t('100%'),
			'0.9' => t('90%'),
			'0.8' => t('80%'),
			'0.7' => t('70%'),
			'0.6' => t('60%'),
			'0.5' => t('50%'),
			'0.4' => t('40%'),
			'0.3' => t('30%'),
			'0.2' => t('20%'),
			'0.1' => t('10%')
		),
	    '#default_value' => $settings['f_opacity'],
			
  );
  
  $form['menu']['f_effect'] = array(
	    '#type' => 'select',
	    '#title' => t('Menu Effect'),
		'#options' => array(
			'slide and fade' => t('Slide and Fade'),
			'slide' => t('Slide'),
			'fade' => t('Fade')
		),
		'#default_value' => $settings['f_effect'],
  );
  
  $form['menu']['f_hidedelay'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Menu Hide Delay'),
	    '#default_value' => $settings['f_hidedelay'],
			'#size' => 10,
			'#required' => TRUE
  );  
	  
  $form['menu']['f_menu_animation'] = array(
    '#type' => 'select',
    '#title' => t('Menu Animation'),
		'#options' => array(
			'linear' => 'linear',
			'Quad.easeOut' => 'Quad.easeOut',
			'Quad.easeIn' => 'Quad.easeIn',
			'Quad.easeInOut' => 'Quad.easeInOut',
			'Cubic.easeOut' => 'Cubic.easeOut',
			'Cubic.easeIn' => 'Cubic.easeIn',
			'Cubic.easeInOut' => 'Cubic.easeInOut',
			'Quart.easeOut' => 'Quart.easeOut',
			'Quart.easeIn' => 'Quart.easeIn',
			'Quart.easeInOut' => 'Quart.easeInOut',
			'Quint.easeOut' => 'Quint.easeOut',
			'Quint.easeIn' => 'Quint.easeIn',
			'Quint.easeInOut' => 'Quint.easeInOut',
			'Expo.easeOut' => 'Expo.easeOut',
			'Expo.easeIn' => 'Expo.easeIn',
			'Expo.easeInOut' => 'Expo.easeInOut',
			'Circ.easeOut' => 'Circ.easeOut',
			'Circ.easeIn' => 'Circ.easeIn',
			'Circ.easeInOut' => 'Circ.easeInOut',
			'Sine.easeOut' => 'Sine.easeOut',
			'Sine.easeIn' => 'Sine.easeIn',
			'Sine.easeInOut' => 'Sine.easeInOut',
			'Back.easeOut' => 'Back.easeOut',
			'Back.easeIn' => 'Back.easeIn',
			'Back.easeInOut' => 'Back.easeInOut',
			'Bounce.easeOut' => 'Bounce.easeOut',
			'Bounce.easeIn' => 'Bounce.easeIn',
			'Bounce.easeInOut' => 'Bounce.easeInOut',
			'Elastic.easeOut' => 'Elastic.easeOut',
			'Elastic.easeIn' => 'Elastic.easeIn',
			'Elastic.easeInOut' => 'Elastic.easeInOut',
			),
    '#default_value' => $settings['f_menu_animation'],
		'#description' => t('Any of the available MooTools transitions.')
  );	 
  
    $form['menu']['f_menu_duration'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Menu Duration'),
	    '#default_value' => $settings['f_menu_duration'],
			'#size' => 10,
			'#required' => TRUE
  );  
  
  $form['menu']['f_pill'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable Pill'),
    '#default_value' => $settings['f_pill']
  );   
  
	  
	  $form['menu']['f_pill_duration'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Pill Duration'),
	    '#default_value' => $settings['f_pill_duration'],
			'#size' => 10,
			'#required' => TRUE
  );    
	  
  $form['menu']['f_pill_animation'] = array(
    '#type' => 'select',
    '#title' => t('Pill Animation'),
		'#options' => array(
			'linear' => 'linear',
			'Quad.easeOut' => 'Quad.easeOut',
			'Quad.easeIn' => 'Quad.easeIn',
			'Quad.easeInOut' => 'Quad.easeInOut',
			'Cubic.easeOut' => 'Cubic.easeOut',
			'Cubic.easeIn' => 'Cubic.easeIn',
			'Cubic.easeInOut' => 'Cubic.easeInOut',
			'Quart.easeOut' => 'Quart.easeOut',
			'Quart.easeIn' => 'Quart.easeIn',
			'Quart.easeInOut' => 'Quart.easeInOut',
			'Quint.easeOut' => 'Quint.easeOut',
			'Quint.easeIn' => 'Quint.easeIn',
			'Quint.easeInOut' => 'Quint.easeInOut',
			'Expo.easeOut' => 'Expo.easeOut',
			'Expo.easeIn' => 'Expo.easeIn',
			'Expo.easeInOut' => 'Expo.easeInOut',
			'Circ.easeOut' => 'Circ.easeOut',
			'Circ.easeIn' => 'Circ.easeIn',
			'Circ.easeInOut' => 'Circ.easeInOut',
			'Sine.easeOut' => 'Sine.easeOut',
			'Sine.easeIn' => 'Sine.easeIn',
			'Sine.easeInOut' => 'Sine.easeInOut',
			'Back.easeOut' => 'Back.easeOut',
			'Back.easeIn' => 'Back.easeIn',
			'Back.easeInOut' => 'Back.easeInOut',
			'Bounce.easeOut' => 'Bounce.easeOut',
			'Bounce.easeIn' => 'Bounce.easeIn',
			'Bounce.easeInOut' => 'Bounce.easeInOut',
			'Elastic.easeOut' => 'Elastic.easeOut',
			'Elastic.easeIn' => 'Elastic.easeIn',
			'Elastic.easeInOut' => 'Elastic.easeInOut',
			),
    '#default_value' => $settings['f_pill_animation'],
		'#description' => t('Any of the available MooTools transitions.')
  );

  $form['menu']['f_tweakInitial_x'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Level 2 X Offset'),
	    '#default_value' => $settings['f_tweakInitial_x'],
			'#size' => 10,
			'#required' => TRUE
  ); 
  
  $form['menu']['f_tweakInitial_y'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Level 2 Y Offset'),
	    '#default_value' => $settings['f_tweakInitial_y'],
			'#size' => 10,
			'#required' => TRUE
  ); 

  $form['menu']['f_tweakSubsequent_x'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Submenus X Offset'),
	    '#default_value' => $settings['f_tweakSubsequent_x'],
			'#size' => 10,
			'#required' => TRUE
  ); 
  
  $form['menu']['f_tweakSubsequent_y'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Submenus Y Offset'),
	    '#default_value' => $settings['f_tweakSubsequent_y'],
			'#size' => 10,
			'#required' => TRUE
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
	  
	  $form['widths']['leftinset_width'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Left Inset Width'),
	    '#default_value' => $settings['leftinset_width'],
			'#size' => 10,
			'#required' => TRUE
	  );
	  
	  $form['widths']['rightinset_width'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Right Inset Width'),
	    '#default_value' => $settings['rightinset_width'],
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
	

	$form['elements']['show_topbutton'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show Top Button'),
    '#default_value' => $settings['show_topbutton']
	);
	
	$form['elements']['show_textsizer'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show Text Sizer'),
    '#default_value' => $settings['show_textsizer']
	);

	
	$form['elements']['show_date'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show Date'),
    '#default_value' => $settings['show_date']
	);
	
	$form['elements']['show_breadcrumb'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show breadcrumb'),
    '#default_value' => $settings['show_breadcrumb']
	);
	
	$form['elements']['show_logo'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show Logo'),
    '#default_value' => $settings['show_logo']
	);
	
	$form['elements']['promoted_content'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show Promoted Content'),
    '#default_value' => $settings['promoted_content']
	);
	
	$form['elements']['show_copyright'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show Copyright'),
    '#default_value' => $settings['show_copyright']
	);
	
	$form['elements']['copyright_text'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Copyright Text'),
	    '#default_value' => $settings['copyright_text'],
			'#size' => 70,
			'#required' => TRUE
	  );
	
	$form['elements']['enable_fontspans'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable Fontspans'),
    '#default_value' => $settings['enable_fontspans']
	);
	
	$form['elements']['js_compatibility'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable JS Compatibility'),
    '#default_value' => $settings['js_compatibility'],
    '#description' => t('Disable MooTools Library')
	);
	

	 $form['fonts'] = array(
	  '#type' => 'fieldset',
	  '#title' => t('Fonts'),
	  '#collapsible' => TRUE,
	  '#collapsed' => FALSE,
	);

	$form['fonts']['font_family'] = array(
	'#type' => 'select',
	'#title' => t('Font family'),
		'#options' => array(
			'nda' => 'nda',
			'bebas'		=> 'Bebas',
			'continuum' => 'Coninuum',
			'optima' => 'Optima',
			'geneva' => 'Geneva',  
			'helvetica' => 'Helvetica',
			'trebuchet' => 'Trebuchet', 
			'lucida' => 'Lucida', 
			'georgia' => 'Georgia', 
			'palatino' => 'Palatino'
		),
	'#default_value' => $settings['font_family'],
	);
	
	$form['fonts']['default_font'] = array(
    '#type' => 'select',
    '#title' => t('Font size'),
		'#options' => array(
			'small' => 'Small', 
			'default' => 'Default', 
			'large' => 'Large'
		),
    '#default_value' => $settings['default_font'],
  );


	$form['ie6'] = array(
	  '#type' => 'fieldset',
	  '#title' => t('Internet Explorer 6 Compatibility'),
	  '#collapsible' => TRUE,
	  '#collapsed' => FALSE,
	);
	
	
	$form['ie6']['enable_ie6warn'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable IE6 Warning'),
    '#default_value' => $settings['enable_ie6warn'],
		'#description' => t('Warn IE6 users their browser is old and they won\'t be getting the full site experience.')
  );	  



  // Return the additional form widgets
  return $form;
	
}




function nda_settings_defaults(){
	
	$defaults = array(
	
		'preset_style' 			=> "style1",
		'primary_style'			=> "style1",
		'bg_style' 				=> "full",
		'link_color'			=> "#A0C34B",
		'font_family'           => "nda",
		
		'enable_ie6warn'        => "false",
		'enable_fontspans'      => "true",
		'enable_inputstyle'		=> "false",
		
		'template_width'		=> "982",
		'leftcolumn_width'		=> "260",
		'rightcolumn_width'		=> "180",
		'leftinset_width' 		=> "180",
		'rightinset_width'		=> "180",
		'splitmenu_col'			=> "leftcol",
		
		'promoted_content'		=> 0,
		'menu_type' 			=> "fusion",
		'default_font' 			=> "default",
		'show_textsizer'		=> "true",
		'show_date'		 		=> "true",
		'show_breadcrumb'		=> "true",
		'clientside_date'		=> "true",
		'show_logo'				=> "true",
		'show_topbutton' 		=> "true",
		'show_copyright' 		=> "true",
		'copyright_text'		=> "Copyright 2010, All Rights Reserved",
		'js_compatibility'	 	=> 0,
		'menu_columns'			=> 2,
		'submenu_columns'		=> 1,
		
		// fusion menu
		'f_enablejs'            => "true",
		'f_opacity'				=> 1,
		'f_effect'				=> 'slidefade',
		'f_hidedelay'			=> 500,
		'f_menu_animation' 		=> 'Quint.easeOut',
		'f_menu_duration'	    => 400,
		'f_pill'		        => 1,
		'f_pill_animation' 		=> 'Quint.easeOut',
		'f_pill_duration' 		=> 400 ,
		
		'f_tweakInitial_x' 		=> '-12',
		'f_tweakInitial_y' 		=> '0',
		'f_tweakSubsequent_x' 	=> '-12',
		'f_tweakSubsequent_y' 	=> '-6',
		'f_enable_current'      => "true"


  	);
  
	return $defaults;
	
}

