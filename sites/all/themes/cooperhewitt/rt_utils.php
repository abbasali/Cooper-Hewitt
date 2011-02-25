<?php

	$thisTitle = "";
	$menus = menu_tree_page_data('primary-links'); 
	foreach($menus as $menu) {
	    if(!empty($menu['link']['in_active_trail']) && $menu['link']['has_children'])
	        $thisTitle = $menu['link']['title'];
	       
	}


	
	// set left column width
	if(((theme_get_setting(splitmenu_col) == "leftcol") and $cooperhewitt_menu_type == "splitmenu" AND $thisTitle != "" and !$is_front) or $left) {
		$current_leftcolumn_width = theme_get_setting('leftcolumn_width');
	}
	else {
		$current_leftcolumn_width = 0;
	}
	// set right column width
	if(((theme_get_setting(splitmenu_col) == "rightcol") and $cooperhewitt_menu_type == "splitmenu" AND $thisTitle != "" and !$is_front) or $right) {
		$current_rightcolumn_width = theme_get_setting('rightcolumn_width');
	}
	else {
		$current_rightcolumn_width = 0;
	}
	// set insetwidth
	if($inset AND arg(0) != "admin") {
		$current_left_inset_width = theme_get_setting('leftinset_width');
		//$current_left_inset_width = 0;
	}
	else {
		$current_left_inset_width = 0;
	}
	
	if($inset2 AND arg(0) != "admin") {
		$current_right_inset_width = theme_get_setting('rightinset_width');
		//$current_right_inset_width = 0;
	}
	else {
		$current_right_inset_width = 0;
	}
	
	// set template width
	$current_template_width = theme_get_setting('template_width');
	
	$col_mode = "s-c-s";
	if ($current_leftcolumn_width==0 and $current_rightcolumn_width>0) $col_mode = "x-c-s";
	if ($current_leftcolumn_width>0 and $current_rightcolumn_width==0) $col_mode = "s-c-x";
	if ($current_leftcolumn_width==0 and $current_rightcolumn_width==0) $col_mode = "x-c-x";




	function rok_isIe($version = false) {   
	
		$agent=$_SERVER['HTTP_USER_AGENT'];  
	
		$found = strpos($agent,'MSIE ');  
		if ($found) { 
		        if ($version) {
		            $ieversion = substr(substr($agent,$found+5),0,1);   
		            if ($ieversion == $version) return true;
		            else return false;
		        } else {
		            return true;
		        }
		        
	        } else {
	                return false;
	        }
		if (stristr($agent, 'msie'.$ieversion)) return true;
		return false;        
	}



?>

