<?php


// set left column width
if($left) {
	$current_leftcolumn_width = theme_get_setting('leftcolumn_width');
}
else {
	$current_leftcolumn_width = 0;
}
// set right column width
if($right) {
	$current_rightcolumn_width = theme_get_setting('rightcolumn_width');
}
else {
	$current_rightcolumn_width = 0;
}

$col_mode = "s-c-s";
if ($current_leftcolumn_width==0 and $current_rightcolumn_width>0) $col_mode = "x-c-s";
if ($current_leftcolumn_width>0 and $current_rightcolumn_width==0) $col_mode = "s-c-x";
if ($current_leftcolumn_width==0 and $current_rightcolumn_width==0) $col_mode = "x-c-x";

// set template width
$current_template_width = 'margin: 0 auto; width: ' . theme_get_setting(template_width) . 'px;';




$inlinestyle = "
	#wrapper { ".$current_template_width."padding:0;}
	.s-c-s #colmid { left:".$current_leftcolumn_width."px;}
	.s-c-s #colright { margin-left:-".($current_leftcolumn_width + $current_rightcolumn_width)."px;}
	.s-c-s #col1pad { margin-left:".($current_leftcolumn_width + $current_rightcolumn_width)."px;}
	.s-c-s #col2 { left:".$current_rightcolumn_width."px;width:".$current_leftcolumn_width."px;}
	.s-c-s #col3 { width:".$current_rightcolumn_width."px;}
	
	.s-c-x #colright { left:".$current_leftcolumn_width."px;}
	.s-c-x #col1wrap { right:".$current_leftcolumn_width."px;}
	.s-c-x #col1 { margin-left:".$current_leftcolumn_width."px;}
	.s-c-x #col2 { right:".$current_leftcolumn_width."px;width:".$current_leftcolumn_width."px;}
	
	.x-c-s #colright { margin-left:-".$current_rightcolumn_width."px;}
	.x-c-s #col1 { margin-left:".$current_rightcolumn_width."px;}
	.x-c-s #col3 { left:".$current_rightcolumn_width."px;width:".$current_rightcolumn_width."px;}";

echo "<style>" . $inlinestyle . "</style>";	

?>