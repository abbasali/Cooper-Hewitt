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
if (is_null(theme_get_setting('theme_variation'))) {  

  global $theme_key;

	if (!(function_exists('afterburner_settings_defaults'))){
		include('theme-settings.php');
	}
	
	
  $defaults = afterburner_settings_defaults();

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
function afterburner_preprocess_search_block_form(&$variables) {
  $variables['form']['search_block_form']['#title'] = '';
  $variables['form']['search_block_form']['#size'] = 20;
  $variables['form']['search_block_form']['#value'] = 'search...';
  $variables['form']['search_block_form']['#attributes'] = array('onblur' => "if (this.value == '') {this.value = '".$variables['form']['search_block_form']['#value']."';}", 'onfocus' => "if (this.value == '".$variables['form']['search_block_form']['#value']."') {this.value = '';}" );
  unset($variables['form']['search_block_form']['#printed']);

  $variables['search']['search_block_form'] = drupal_render($variables['form']['search_block_form']);

  $variables['search_form'] = implode($variables['search']);
}



function afterburner_preprocess_block(&$variables){
	
	static $user123_count;
	if($variables['block']->region == 'user123'){
		$user123_count++;
	}
	$variables['user123_count'] = $user123_count;
	
	static $user456_count;
	if($variables['block']->region == 'user456'){
		$user456_count++;
	}
	$variables['user456_count'] = $user456_count;
	
	static $user789_count;
	if($variables['block']->region == 'user789'){
		$user789_count++;
	}
	$variables['user789_count'] = $user789_count;
	


}



// Primary Links expanded for bottom menu system on <front>
function afterburner_expandlink($links) {
  if (module_exists('path')) {

    foreach ($links as $key => $link) {
      
      $href = $link['href'] == "<front>" ? base_path() : "?q=" . $link['href'];
      print "<div style='width:90px;height:135px;float:left;margin-right:15px;border-right:1px dotted #ccc;padding-right:5px'>";
      print "<a href='" . $href . "'" . " class='mainlevel-bottom'>" . $links[$key]['title'] . "</a>";
      echo "<br /><br />";
	  // submenu goes here
      print "</div>";
      
    }
  }
}


function afterburner_preprocess_maintenance_page(&$vars) {
		afterburner_preprocess_page($vars);
	}


function afterburner_preprocess_page(&$variables) {
	
	//$theme_settings = variable_get('theme_afterburner_settings', array());
	
	$variables['path'] = base_path() . path_to_theme();
	$css_path = path_to_theme().'/css/';
	$js_path = path_to_theme() . '/js/';
	$variables['file_path'] = base_path().file_directory_path();
	$variables['default_color'] = theme_get_setting('default_color');
	$variables['url'] = "http://" . $_SERVER['HTTP_HOST'] . url();
    $variables['uri'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	
	$variables['tabs2'] = menu_secondary_local_tasks();
	
	// Set the default logo
	if (theme_get_setting('default_logo')){
		$variables['logo'] = $variables['path'].'/images/logo.png';
	}
	
	// set global for style from cookie if exists
	if( isset( $_COOKIE['afterburner_style'] ) )
		$variables['afterburner_style'] = $_COOKIE['afterburner_style']; 
	else
		$variables['afterburner_style'] = theme_get_setting(color_style);
	
	
	// populate the header variable


	$enable_ie6_warning = theme_get_setting('enable_ie6_warning');
	
	if ($enable_ie6_warning){
		drupal_add_js($js_path.'rokie6warn.js', 'theme');
	}




	drupal_set_html_head(
		'<!--[if IE]>		
	  <script type="text/javascript" src="'.$js_path.'ie_suckerfish.js"></script>
	  <![endif]-->'
	);
	
	$variables['scripts'] = drupal_get_js();
	//$variables['scripts'] = "";
	//$variables['head'] = drupal_get_html_head();
	$variables['styles'] = drupal_get_css();
	

	
	// get widths for block regions
	
	$block_regions = array('user123', 'user456', 'user789', 'user101112');
	
	$block_region_widths = array(
		1 => 'w99',
		2 => 'w49',
		3 => 'w33',
		4 => 'w24'
	);
	
 	foreach($block_regions as $block_region){
		$blocks = block_list($block_region);	
		$variables[$block_region.'_width'] = ($block_region_widths[count($blocks)] ? $block_region_widths[count($blocks)] : $block_region_widths[4]);
	} 
	
	
	if (strpos(request_uri(), 'wrapper') != false){
		$variables['template_file'] = 'page-wrapper';
	}

}




function afterburner_change_theme($change, $changeVal, $page=''){
	
	$theme_settings = variable_get('theme_afterburner_settings', array());
	
	$cookie_prefix = "afterburner_";
	$cookie_time = time()+31536000;
	
	//print_r($theme_settings);
	
	
	if($change && $changeVal){
		//print $change . " " . $changeVal;
		
		switch ($change){
			
			
			case 'tstyle':
			
				$cookie_name = $cookie_prefix . "style";
				setcookie($cookie_name, $changeVal, $cookie_time);
				//$color_style = $theme_settings['color_style'];
				//$theme_settings['color_style'] = $changeVal;
			
			break;

		}

		// echo $theme_settings[$setting];
	
		//variable_set('theme_afterburner_settings', $theme_settings);
		
		
	}
	
	 //print_r($theme_settings);
	if ($page){
		drupal_goto("node/$page");
	}
	else {
		drupal_goto('<front>');
	}
	
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
    //$extra_class = get_link_color($items[$i]['title']);
    
    if (stristr($i, 'active')) {
        $extra_class .= " active";
      }
    
    
    if ($i == 0) {
      //$extra_class = 'first';
    }
    if ($i == $num_items - 1) {
      //$extra_class = 'last';
    }
    $link = main_menu_item_link($data['link']);
   
    if ($data['below']) {
      $extra_class = "parent ";
      if(theme_get_setting(menu_type) == "splitmenu") {
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
    //$extra_class = get_link_color($items[$i]['title']);
    
    if (stristr($i, 'active')) {
        $extra_class .= " active";
      }
    
    
    if ($i == 0) {
      //$extra_class = 'first';
    }
    if ($i == $num_items - 1) {
      //$extra_class = 'last';
    }
    $link = sub_menu_item_link($data['link']);
    if ($data['below']) {
      $extra_class = " parent ";
      $output .= sub_menu_item($link, $data['link']['has_children'], sub_menu_tree_output($data['below']), $data['link']['in_active_trail'], $extra_class);
    }
    else {
      $output .= sub_menu_item($link, $data['link']['has_children'], '', $data['link']['in_active_trail'], $extra_class);
    }
  }
  return $output ? sub_menu_tree($output) : '';
}

/**
 * FULL MENU TREE
 */
function main_menu_tree($tree) {
  	return '<ul class="menutop" id="horiznav">'. $tree .'</ul>';
}

/**
 * SUB MENU TREE
 */
function sub_menu_tree($tree) {
  	return '<ul>'. $tree .'</ul>';
}

/**
  * MENU ITEM 
 */
function main_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
  //$class = ($menu ? 'expanded' : ($has_children ? 'collapsed' : 'leaf'));
  $class = "";
  if (!empty($extra_class)) {
    $class .= $extra_class;
  }
  if ($in_active_trail) {
    $class .= 'active';
  }
  return '<li class="'. $class .'">'. $link . $menu . "</li>\n";
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
    $class .= 'active';
  }
  return '<li class="'. $class .'">'. $link . $menu . "</li>\n";
}


/**
 * Generate the HTML output for a single menu link.
 *
 * @ingroup themeable
 */
function main_menu_item_link($link) {
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
  $this_link = "<a class='topdaddy' href='" . $href . "'><span>" . $link['title'] . "</span></a>"; 	

  return $this_link;
}

 function sub_menu_item_link($link) {
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
  $this_link = "<a href='" . $href . "'><span>" . $link['title'] . "</span></a>"; 	

  return $this_link;
}


//******************************************************************************



function change_font($change, $page){
	$theme_settings = variable_get('theme_afterburner_settings', array());
	
	$theme_settings['font_size'] = $change;
	
	variable_set('theme_afterburner_settings', $theme_settings);
	//$newPage = str_replace('?', '', $page);
	$newPage = str_replace('&', '', $page);
	$newPage = str_replace('fontstyle=large', '', $newPage); 
	$newPage = str_replace('fontstyle=default', '', $newPage);
	$newPage = str_replace('fontstyle=small', '', $newPage); 
	drupal_goto("$newPage");
}


/**
 * Sets the body-tag class attribute.
 */
//function afterburner_body_class($body_style_variation, $header_footer_variation) {
function afterburner_body_class($theme_color) {
	
	$id = 'ff-' . theme_get_setting('default_font');
	$class = 'f-' . theme_get_setting('font_family');		
	$class .= ' iehandle';
	
  print ' id="' . $id . '"' .  ' class="' . $class . '"';

}


/**
* Implementation of hook_theme.
*
* Register custom theme functions.
*/
function afterburner_theme() {
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


function afterburner_user_login_block(&$form){

	$form['links'] = array('#value' => '<div id="sl_lostpass"><a href="/user/password">Request new password</a></div>');

	return drupal_render($form);
	
}


function afterburner_user_login_top_section(){
	
	global $user;
	
	if(!$user->uid){
	$output = drupal_get_form('user_login_block');	
	}else{
	
	$output = '<div id="greeting">Hi '.$user->name.'</div>';
	$output .=	'<div id="sl_submitbutton">';
	$output .= l('Logout', 'logout', array('attributes' => array('class' => 'button')));	
	$output .= '</div>';	
		
	}
	
	return $output;
	
	
	
}


function afterburner_get_theme_headers($theme){
	
	$themes = array (
		2 => 10,
		3 => 2,
		6 => 3
	);

	return $themes[$theme];
	
}





/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function afterburner_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
		$breadcrumb[$_GET['q']] = drupal_get_title(); 
    return '<div class="breadcrumbs">'. implode('<span style="padding: 0 10px 0 10px;">\</span>', $breadcrumb) .'</div>';
  }
}

/**
 * Allow themable wrapping of all comments.
 */
function afterburner_comment_wrapper($content, $node) {
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
function afterburner_menu_local_tasks() {
  return menu_primary_local_tasks();
}

function afterburner_comment_submitted($comment) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

function afterburner_node_submitted($node) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}







