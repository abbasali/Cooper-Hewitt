<?php

/**
 * Comment out for production!
 * For development only. Defeats theme register caching.
 * Changes to theme show immediately, but performance is effected.
 * Comment out for production.
 */
drupal_rebuild_theme_registry();

/*
* Initialize theme settings
*/
if (is_null(theme_get_setting('preset_style'))) {  

  global $theme_key;

	if (!(function_exists('colormoves_settings_defaults'))){
		include('theme-settings.php');
	}
	
	
  $defaults = colormoves_settings_defaults();

  // Get default theme settings.
  $settings = theme_get_settings($theme_key);
  // Don't save the toggle_node_info_ variables.
  if (module_exists('node')) {
    foreach (node_get_types() as $type => $name) {
      unset($settings['toggle_node_info_' . $type]);
    }
  }
  // Save default theme settings.
  variable_set(
    str_replace('/', '_', 'theme_'. $theme_key .'_settings'),
    array_merge($defaults, $settings)
  );

  // Force refresh of Drupal internals.
  theme_get_setting('', TRUE);

}



/**
* Override or insert PHPTemplate variables into the search_block_form template.
*
* @param $vars
*   A sequential array of variables to pass to the theme template.
* @param $hook
*   The name of the theme function being called (not used in this case.)
*/
function colormoves_preprocess_search_block_form(&$variables) {
  $variables['form']['search_block_form']['#title'] = '';
  $variables['form']['search_block_form']['#size'] = 20;
  $variables['form']['search_block_form']['#value'] = 'Search...';
  $variables['form']['search_block_form']['#attributes'] = array('onblur' => "if (this.value == '') {this.value = '".$variables['form']['search_block_form']['#value']."';}", 'onfocus' => "if (this.value == '".$variables['form']['search_block_form']['#value']."') {this.value = '';}" );
  unset($variables['form']['search_block_form']['#printed']);

  $variables['search']['search_block_form'] = drupal_render($variables['form']['search_block_form']);

  $variables['search_form'] = implode($variables['search']);
}

function colormoves_blocks($region) {
  $output = '';

  if ($list = block_list($region)) {
    $blockcounter = 1; // there is at least one block in this region
    foreach ($list as $key => $block) {
      // $key == <i>module</i>_<i>delta</i>
      $block->extraclass = ''; // add the 'extracclass' key to the $block object
      $block->num_count = 0;
      if ($blockcounter == 1){ // is this the first block in this region?
        $block->extraclass .= 'first'; 
      }
      elseif ($blockcounter == count($list)){ // is this the last block in this region?
        $block->extraclass .= 'last';
      }
      else {
      	$block->extraclass .= 'middle';
      }
      
      
      $output .= theme('block', $block);
      $blockcounter++;
    }
   
  }

  // Add any content assigned to this region through drupal_set_content() calls.
  $output .= drupal_get_content($region);

  return $output;
}




function colormoves_preprocess_block(&$variables){
	
	static $feature_count;
	if($variables['block']->region == 'feature'){
		$feature_count++;
	}
	$variables['feature_count'] = $feature_count;
	
	static $showcase_count;
	if($variables['block']->region == 'showcase'){
		$showcase_count++;
	}
	$variables['showcase_count'] = $showcase_count;
	
	static $main_feature_count;
	if($variables['block']->region == 'main_feature'){
		$main_feature_count++;
	}
	$variables['main_feature_count'] = $main_feature_count;
	
	static $user123_count;
	if($variables['block']->region == 'user123'){
		$user123_count++;
	}
	$variables['user123_count'] = $user123_count;
	
	static $main123_count;
	if($variables['block']->region == 'main123'){
		$main123_count++;
	}
	$variables['main123_count'] = $main123_count;
	
	static $main456_count;
	if($variables['block']->region == 'main456'){
		$main456_count++;
	}
	$variables['main456_count'] = $main456_count;
	
	static $user456_count;
	if($variables['block']->region == 'user456'){
		$user456_count++;
	}
	$variables['user456_count'] = $user456_count;
	
	static $main789_count;
	if($variables['block']->region == 'main789'){
		$main789_count++;
	}
	$variables['main789_count'] = $main789_count;
	
	static $user789_count;
	if($variables['block']->region == 'user789'){
		$user789_count++;
	}
	$variables['user789_count'] = $user789_count;
	
	
	static $footer123_count;
	if($variables['block']->region == 'footer123'){
		$footer123_count++;
	}
	$variables['footer123_count'] = $footer123_count;	
}


function colormoves_preprocess_maintenance_page(&$vars) {
	colormoves_preprocess_page($vars);
}


function colormoves_preprocess_page(&$variables) {
	
	
	$variables['path'] = base_path() . path_to_theme();
	$css_path = path_to_theme().'/css/';
	$js_path = path_to_theme() . '/js/';
	$variables['file_path'] = base_path().file_directory_path();
	$variables['url'] = "http://" . $_SERVER['HTTP_HOST'] . url();
    $variables['uri'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
    $variables['tabs2'] = menu_secondary_local_tasks();
	
	
	if( isset( $_COOKIE['colormoves_preset_style'] ) )
		$variables['colormoves_preset_style'] = $_COOKIE['colormoves_preset_style']; 
	else
		$variables['colormoves_preset_style'] = theme_get_setting(preset_style);

	
	if( isset( $_COOKIE['colormoves_bg_style'] ) )
		$variables['colormoves_bg_style'] = $_COOKIE['colormoves_bg_style']; 
	else
		$variables['colormoves_bg_style'] =  theme_get_setting(bg_style);
	
	if( isset( $_COOKIE['colormoves_link_color'] ) )
		$variables['colormoves_link_color'] = $_COOKIE['colormoves_link_color']; 
	else
		$variables['colormoves_link_color'] =  theme_get_setting(link_color);

	if( isset( $_COOKIE['colormoves_font_family'] ) )
		$variables['colormoves_font_family'] = $_COOKIE['colormoves_font_family']; 
	else
		$variables['colormoves_font_family'] = theme_get_setting(font_family);
	
	if( isset( $_COOKIE['colormoves_defaultfont'] ) )
		$variables['colormoves_defaultfont'] = $_COOKIE['colormoves_defaultfont']; 
	else
		$variables['colormoves_defaultfont'] = theme_get_setting(default_font);
	

		
	
	// set global for menu style if exists
	if( isset( $_COOKIE['colormoves_menu_type'] ) )
		$variables['colormoves_menu_type'] = $_COOKIE['colormoves_menu_type']; 
	else
		$variables['colormoves_menu_type'] = theme_get_setting('menu_type');
	
		
	
	
	
	$variables['scripts'] = drupal_get_js();
	$variables['head'] = drupal_get_html_head();
	$variables['styles'] = drupal_get_css();
	

	
	// get widths for block regions
	
	$block_regions = array('showcase', 'feature', 'main_feature', 'user123', 'main123', 'main456', 'user456', 'main789', 'user789', 'footer123');
	
	$block_region_widths = array(
		1 => 'w99',
		2 => 'w49',
		3 => 'w33',
		4 => 'w24'
	);
	
 	foreach($block_regions as $block_region){
		$blocks = block_list($block_region);	
		$variables[$block_region.'_width'] = ($block_region_widths[count($blocks)] ? $block_region_widths[count($blocks)] : $block_region_widths[4]);
		$variables[$block_region.'_number'] = count($blocks);
	} 

	if (strpos(request_uri(), 'wrapper') != false){
		$variables['template_file'] = 'page-wrapper';
	}

}




function colormoves_change_theme($change, $changeVal, $bgVal='', $page=''){
	
	$theme_settings = variable_get('theme_colormoves_settings', array());
	
	$cookie_prefix = "colormoves_";
	$cookie_time = time()+31536000;
	$cookie_path = base_path();
	//print_r($theme_settings);
	
	
	if($change && $changeVal){
		
		switch ($change){
			
			case 'fontfamily':
			
				$cookie_name = $cookie_prefix . "fontfamily";
				setcookie($cookie_name, $changeVal, $cookie_time, $cookie_path);
			
			break;
			
			case 'tstyle':
				
				$rt_style_includes = path_to_theme() . "/styles.php";
				include $rt_style_includes;
				
				$style = $stylesList[$changeVal];
				
				$cookie_name = $cookie_prefix . "preset_style";
				setcookie($cookie_name, $changeVal, $cookie_time, $cookie_path);
				
				$cookie_name = $cookie_prefix . "bg_style";
				if($bgVal) {
					setcookie($cookie_name, $bgVal, $cookie_time, $cookie_path);
				}
				else {
					setcookie($cookie_name, $style[1], $cookie_time, $cookie_path);
				}
				
				$cookie_name = $cookie_prefix . "font_family";
				setcookie($cookie_name, $style[2], $cookie_time, $cookie_path);
				
				$cookie_name = $cookie_prefix . "link_color";
				setcookie($cookie_name, $style[3], $cookie_time, $cookie_path);
				
				//$cookie_name = $cookie_prefix . "header_style";
				//setcookie($cookie_name, $style[0], $cookie_time, $cookie_path);

				
			break;		

			case 'menu_type':
				
				$cookie_name = $cookie_prefix . "menu_type";
				setcookie($cookie_name, $changeVal, $cookie_time, $cookie_path);
				//$theme_settings['menu_type'] = $changeVal;
			
			break;

		}


		
	}
	
	 //print_r($theme_settings);
	if ($page){
		drupal_goto("node/$page");
	}
	else {
		drupal_goto('<front>');
	}
	
}


function change_font($change, $page=''){

	$cookie_prefix = "colormoves_";
	$cookie_time = time()+31536000;
	
	$cookie_name = $cookie_prefix . "defaultfont";
	setcookie($cookie_name, $change, $cookie_time);
	
	if ($page){
		drupal_goto("node/$page");
	}
	else {
		drupal_goto('<front>');
	}
	
}


// SplitMenu Menu Override //

function split_menu_tree_output($tree) {
  $output = '';
  $items = array();

  // Pull out just the menu items we are going to render so that we
  // get an accurate count for the first/last classes.
  foreach ($tree as $data) {
    if (!$data['link']['hidden']) {
      $items[] = $data;
    }
  }

  $num_items = count($items);
  foreach ($items as $i => $data) {
    
    $extra_class = NULL;
    
    if (stristr($i, 'active')) {
        $extra_class .= " active";
      }
    
    
    if ($i == 0) {
      //$extra_class = 'first';
    }
    if ($i == $num_items - 1) {
      //$extra_class = 'last';
    }
    $link = sub_menu_item_link($data['link'], $data['link']['has_children'], $data['link']['description']);
    if ($data['below']) {
      $extra_class = " parent ";
      $output .= sub_menu_item($link, $data['link']['has_children'], '', $data['link']['in_active_trail'], $extra_class);
    }
    else {
      $output .= sub_menu_item($link, $data['link']['has_children'], '', $data['link']['in_active_trail'], $extra_class);
    }
  }
  return $output ? split_menu_tree($output) : '';
}
/*
 * SPLIT MENU TREE
 */
function split_menu_tree($tree) {
  	return '<ul class="menu level1">'. $tree .'</ul>';
}




//********************************************
// PRIMARY LINK MENU ITEM INFO
//********************************************

/**
 * Returns a rendered menu tree.
 *
 * @param $tree
 *   A data structure representing the tree as returned from menu_tree_data.
 * @return
 *   The rendered HTML of that data structure.
 */
function main_menu_tree_output($tree) {
  $output = '';
  $items = array();

  if( isset( $_COOKIE['colormoves_menu_type'] ) )
	$this_mtype = $_COOKIE['colormoves_menu_type']; 
  else
	$this_mtype = theme_get_setting('menu_type');
  // Pull out just the menu items we are going to render so that we
  // get an accurate count for the first/last classes.
  foreach ($tree as $data) {
    if (!$data['link']['hidden']) {
      $items[] = $data;
    }
  }

  $num_items = count($items);
  foreach ($items as $i => $data) {
    
    $extra_class = NULL;
    
    if (stristr($i, 'active')) {
        $extra_class .= " active";
      }
    
    
    if ($i == 0) {
      //$extra_class = 'first';
    }
    if ($i == $num_items - 1) {
      //$extra_class = 'last';
    }
    $link = main_menu_item_link($data['link'], $data['link']['has_children'], $data['link']['description']);
   
    if ($data['below']) {
      $extra_class = "parent ";
      if($this_mtype == "splitmenu") {
      	$output .= main_menu_item($link, $data['link']['has_children'], '', $data['link']['in_active_trail'], $extra_class);
      }	
      else {	
      	$output .= main_menu_item($link, $data['link']['has_children'], sub_menu_tree_output($data['below']), $data['link']['in_active_trail'], $extra_class);
      }
    }
    
    else {
      $output .= main_menu_item($link, $data['link']['has_children'], '', $data['link']['in_active_trail'], $extra_class);
    }
  }
  return $output ? main_menu_tree($output) : '';
}



function sub_menu_tree_output($tree) {
  $output = '';
  $items = array();

  // Pull out just the menu items we are going to render so that we
  // get an accurate count for the first/last classes.
  foreach ($tree as $data) {
    if (!$data['link']['hidden']) {
      $items[] = $data;
    }
  }

  $num_items = count($items);
  foreach ($items as $i => $data) {
    
    $extra_class = NULL;
    
    if (stristr($i, 'active')) {
        $extra_class .= " active";
      }
    
    
    if ($i == 0) {
      //$extra_class = 'first';
    }
    if ($i == $num_items - 1) {
      //$extra_class = 'last';
    }
    $link = sub_menu_item_link($data['link'], $data['link']['has_children'], $data['link']['description']);
    if ($data['below']) {
      $extra_class = " parent ";
      $output .= sub_menu_item($link, $data['link']['has_children'], tri_menu_tree_output($data['below']), $data['link']['in_active_trail'], $extra_class);
    }
    else {
      $output .= sub_menu_item($link, $data['link']['has_children'], '', $data['link']['in_active_trail'], $extra_class);
    }
  }
  return $output ? sub_menu_tree($output) : '';
}

function tri_menu_tree_output($tree) {
  $output = '';
  $items = array();

  // Pull out just the menu items we are going to render so that we
  // get an accurate count for the first/last classes.
  foreach ($tree as $data) {
    if (!$data['link']['hidden']) {
      $items[] = $data;
    }
  }

  $num_items = count($items);
  foreach ($items as $i => $data) {
    
    $extra_class = NULL;
 
    
    if (stristr($i, 'active')) {
        $extra_class .= " active";
      }
    
    
    if ($i == 0) {
      //$extra_class = 'first';
    }
    if ($i == $num_items - 1) {
      //$extra_class = 'last';
    }
    $link = tri_menu_item_link($data['link'], $data['link']['has_children'], $data['link']['description']);
    if ($data['below']) {
      $extra_class = " parent ";
      $output .= tri_menu_item($link, $data['link']['has_children'], tri_menu_tree_output($data['below']), $data['link']['in_active_trail'], $extra_class);
    }
    else {
      $output .= tri_menu_item($link, $data['link']['has_children'], '', $data['link']['in_active_trail'], $extra_class);
    }
  }
  return $output ? tri_menu_tree($output) : '';
}

/**
 * FULL MENU TREE
 */
function main_menu_tree($tree) {
  	return '<ul class="menutop level1">'. $tree .'</ul>';
}

/**
 * SUB MENU TREE
 */
function sub_menu_tree($tree) {
  	return '<div class="fusion-submenu-wrapper level2 columns' . theme_get_setting(menu_columns) . '"><div class="drop-top"></div><ul class="level2 columns' . theme_get_setting(menu_columns) . '">'. $tree .'</ul></div>';
}

/**
 * TRI MENU TREE
 */
function tri_menu_tree($tree) {
  	return '<div class="fusion-submenu-wrapper level3 columns' . theme_get_setting(submenu_columns) . '"><div class="drop-top"></div><ul class="level3 columns' . theme_get_setting(submenu_columns) . '">'. $tree .'</ul></div>';
}



/**
  * MENU ITEM 
 */
function main_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
  //$class = ($menu ? 'expanded' : ($has_children ? 'collapsed' : 'leaf'));
  $class = "item1";
  $id = "";
  if (!empty($extra_class)) {
    $class .= " " . $extra_class;
  }
  if ($in_active_trail) {
    $class .= ' active';
    $id .= 'current';
  }
  
  $class .= ' root';
  return '<li class="'. $class .'" id="' . $id . '">'. $link . $menu . "</li>\n";
}

/**
  * SUB MENU ITEM 
 */
function sub_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
  //$class = ($menu ? 'expanded' : ($has_children ? 'collapsed' : 'leaf'));
  $class = "";
  if (!empty($extra_class)) {
    $class .= $extra_class;
  }
  if ($in_active_trail) {
    $class .= ' active';
  }
  return '<li class="'. $class .'">'. $link . $menu . "</li>\n";
}

/**
  * TRI MENU ITEM 
 */
function tri_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
  //$class = ($menu ? 'expanded' : ($has_children ? 'collapsed' : 'leaf'));
  $class = "";
  if (!empty($extra_class)) {
    $class .= $extra_class;
  }
  if ($in_active_trail) {
    $class .= ' active';
  }
  return '<li class="'. $class .'">'. $link . $menu . "</li>\n";
}


/**
 * Generate the HTML output for a single menu link.
 *
 * @ingroup themeable
 */
function main_menu_item_link($link, $has_children = FALSE) {
  if( isset( $_COOKIE['colormoves_menu_type'] ) )
	$this_mtype = $_COOKIE['colormoves_menu_type']; 
  else
	$this_mtype = theme_get_setting('menu_type');
  
  
  if (empty($link['localized_options'])) {
    $link['localized_options'] = array();
  }
  if(strlen(strstr($link['href'],"http"))>0) {
  	$href = $link['href'];	
  }
  else {
  	if(variable_get('clean_url', 0)) {
  		$href = $link['href'] == "<front>" ? base_path() : base_path() . drupal_get_path_alias($link['href']);
  	}
  	else {
  		$href = $link['href'] == "<front>" ? base_path() : base_path() . "?q=" . drupal_get_path_alias($link['href']);
  	}
  }
  
  $subtext = $link['localized_options']['attributes']['title'];
  
  $class = "";
  
  if($has_children AND $this_mtype != "splitmenu") { 
  	$class .= "daddy "; 
  }
  else {
  	$class .= "orphan ";
  }
  
  $class .= "item ";
  
  if($this_mtype != "splitmenu"){
  	$class .= "bullet ";
  }
  
  if($subtext != "") {
  	$class .= " subtext";
  }
  
  $this_link = "<a class='" . $class . "' href='" . $href . "'><span>" . $link['title'] . "<em>" . $subtext . "</em>" . "</span></a>"; 	

  return $this_link;
}

function sub_menu_item_link($link, $has_children = FALSE) {
  if (empty($link['localized_options'])) {
    $link['localized_options'] = array();
  }
  if(strlen(strstr($link['href'],"http"))>0) {
  	$href = $link['href'];	
  }
  else {
  	if(variable_get('clean_url', 0)) {
  		$href = $link['href'] == "<front>" ? base_path() : base_path() . drupal_get_path_alias($link['href']);
  	}
  	else {
  		$href = $link['href'] == "<front>" ? base_path() : base_path() . "?q=" . drupal_get_path_alias($link['href']);
  	}
  }	
  
  $subtext = $link['localized_options']['attributes']['title'];
  
  $class = "";
  
  if($has_children) {
  	$class .= "daddy ";
  }
  else {
  	$class .= "orphan";
  }
  
  $class .= " item bullet"; 
  
  if($subtext != "") {
  	$class .= " subtext";
  } 
  
  $this_link = "<a class='" . $class . "' href='" . $href . "'><span>" . $link['title'] . "<em>" . $subtext . "</em>" . "</span></a>"; 	
  return $this_link;
}

function tri_menu_item_link($link, $has_children = FALSE) {
  if (empty($link['localized_options'])) {
    $link['localized_options'] = array();
  }
  if(strlen(strstr($link['href'],"http"))>0) {
  	$href = $link['href'];	
  }
  else {
  	if(variable_get('clean_url', 0)) {
  		$href = $link['href'] == "<front>" ? base_path() : base_path() . drupal_get_path_alias($link['href']);
  	}
  	else {
  		$href = $link['href'] == "<front>" ? base_path() : base_path() . "?q=" . drupal_get_path_alias($link['href']);
  	}
  }	
  
  $subtext = $link['localized_options']['attributes']['title'];
  
  $class = "";
  
  if($has_children) {
  	$class .= "daddy ";
  }
  else {
  	$class .= "orphan";
  }
  
  $class .= " item bullet";  
  
  if($subtext != "") {
  	$class .= " subtext";
  } 
  
  $this_link = "<a class='" . $class . "' href='" . $href . "'><span>" . $link['title'] . "<em>" . $subtext . "</em>" . "</span></a>"; 	
  //return l($link['title'], $link['href'], $link['localized_options']);
  return $this_link;
}


//******************************************************************************


function colormoves_more_link($url, $title) {

  return '<div class="clr"></div><div class="readon-wrap1"><div class="readon1-l"></div><a class="readon-main" href="' . check_url($url) . '"><span class="readon1-m"><span class="readon1-r">Read More</span></span></a></div><div class="clr"></div>';
}




/**
* Implementation of hook_theme.
*
* Register custom theme functions.
*/
function colormoves_theme() {
  return array(
    // The form ID.
    'user_login_block' => array(
      // Forms always take the form argument.
      'arguments' => array('form' => NULL),
    ),
	'user_login_top_section' => array(
    // Forms always take the form argument.
    'arguments' => array(),
  ),
  );
}


function colormoves_user_login_block($form) {
  $form['name']['#title'] = t(''); //wrap any text in a t function
  $form['name']['#value'] = t('Username');
  $form['pass']['#title'] = t('');
  $form['submit']['#title'] = t('submit');  
  //unset($form['links']['#value']); //remove links under fields
  return (drupal_render($form));
}

/*
function colormoves_user_login_block(&$form){

	$form['links'] = array('#value' => '<div id="sl_lostpass"><a href="/user/password">Request new password</a></div>');

	return drupal_render($form);
	
}
*/

function colormoves_button($element) {
  // Make sure not to overwrite classes.
  if (isset($element['#attributes']['class'])) {
    $element['#attributes']['class'] = 'Button form-' . $element['#button_type'] . ' ' . $element['#attributes']['class'];
  }
  else {
    $element['#attributes']['class'] = 'Button form-' . $element['#button_type'];
  }

  // Skip admin pages due to some issues with ajax not being able to find buttons.
  if (arg(0) == 'admin') {
    //return '<input type="submit" '. (empty($element['#name']) ? '' : 'name="'. $element['#name'] .'" ') .'id="'. $element['#id'] .'" value="'. check_plain($element['#value']) .'" '. drupal_attributes($element['#attributes']) ." />\n";
  }
  
  if ($element['#value'] == 'Search') {
    return '<input type="submit" '. (empty($element['#name']) ? '' : 'name="'. $element['#name'] .'" ') .'id="'. $element['#id'] .'" value="'. check_plain($element['#value']) .'" '. drupal_attributes($element['#attributes']) ." />\n";
  }

  return '<button type="submit" ' . (empty($element['#name']) ? '' : 'name="' . $element['#name']
         . '" ')  . 'id="' . $element['#id'] . '" value="' . check_plain($element['#value']) . '" ' . drupal_attributes($element['#attributes']) . '>'
         
      
        . '<div class="readon-wrap1"><div class="readon1-l"></div><a class="readon-main"><span class="readon1-m"><span class="readon1-r">'  . check_plain($element['#value']) .  '</span></span></a></div>'
		. '</button>';

}




function colormoves_get_theme_headers($theme){
	
	$themes = array (
		2 => 10,
		3 => 2,
		6 => 3
	);

	return $themes[$theme];
	
}



function colormoves_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
	$breadcrumb_new = array();
	// Create new breadcrumb array without the top level image gallery link
	foreach ($breadcrumb as $crumb) {
		if (strstr($crumb, '<a href="/image">') != TRUE) {
			$breadcrumb_new[] = $crumb;
		}
	}
	$breadcrumb_new[] = '<span class="no-link">'. drupal_get_title() .'</span>';

	return '<span class="breadcrumbs pathway">' . implode('<img src="' . base_path() . path_to_theme() .  '/images/arrow.png" alt="" />', $breadcrumb_new) . '</span>';

  }
}

/**
 * Allow themable wrapping of all comments.
 */
function colormoves_comment_wrapper($content, $node) {
  if (!$content || $node->type == 'forum') {
    return '<div id="comments">'. $content .'</div>';
  }
  else {
    return '<div id="comments"><h2 class="comments">'. t('Comments') .'</h2>'. $content .'</div>';
  }
}



/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs. Overridden to split the secondary tasks.
 *
 * @ingroup themeable
 */
function colormoves_menu_local_tasks() {
  return menu_primary_local_tasks();
}

function colormoves_comment_submitted($comment) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

function colormoves_node_submitted($node) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}