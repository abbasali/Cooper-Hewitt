<?php
// This information has been pulled out to make the template more readible.
//
// This data goes between the <head></head> tags of the template
$theme_path = path_to_theme();
?>

<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />


<link href="<?php echo base_path() . path_to_theme(); ?>/css/template.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_path() . path_to_theme(); ?>/css/<?php echo $nda_preset_style; ?>.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_path() . path_to_theme(); ?>/css/typography.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_path() . path_to_theme(); ?>/css/menu-<?php echo $nda_menu_type; ?>.css" rel="stylesheet" type="text/css" />


<?php 
	$current_mainbody_width = ($current_template_width - $current_rightcolumn_width) - 20;
	$current_maincol_width = ($current_mainbody_width - $current_leftcolumn_width) - 45;
	$col_diff = $current_leftcolumn_width + $current_rightcolumn_width; 
	$current_template_widthIE7 = $current_template_width - 30;
?>
<style type="text/css">
	
	div.wrapper { margin: 0 auto; width: <?php echo $current_template_width; ?>px; padding:0;}
	
	body { min-width:<?php echo $current_template_width; ?>px;}
	/*body { min-width:".$template_real_width."px;}*/
	#inset-block-left { width:<?php echo $current_left_inset_width; ?>px;padding:0;}
	#inset-block-right { width:<?php echo $current_right_inset_width; ?>px;padding:0;}
	#maincontent-block { margin-right:<?php echo $current_right_inset_width; ?>px;margin-left:<?php echo $current_left_inset_width; ?>px;}
	
	.s-c-s .colmid { left:<?php echo $current_leftcolumn_width; ?>px;}
	.s-c-s .colright { margin-left:-<?php echo $col_diff; ?>px;}
	.s-c-s .col1pad { margin-left:<?php echo $col_diff; ?>px;}
	.s-c-s .col2 { left:<?php echo $current_rightcolumn_width; ?>px;width:<?php echo $current_leftcolumn_width; ?>px;}
	.s-c-s .col3 { width:<?php echo $current_rightcolumn_width; ?>px;}
	
	.s-c-x .colright { left:<?php echo $current_leftcolumn_width; ?>px;}
	.s-c-x .col1wrap { right:<?php echo $current_leftcolumn_width; ?>px;}
	.s-c-x .col1 { margin-left:<?php echo $current_leftcolumn_width; ?>px;}
	.s-c-x .col2 { right:<?php echo $current_leftcolumn_width; ?>px;width:<?php echo $current_leftcolumn_width; ?>px;}
	
	.x-c-s .colright { margin-left:-<?php echo $current_rightcolumn_width; ?>px;}
	.x-c-s .col1 { margin-left:<?php echo $current_rightcolumn_width; ?>px;}
	.x-c-s .col3 { left:<?php echo $current_rightcolumn_width; ?>px;width:<?php echo $current_rightcolumn_width; ?>px;}
	
	a, #top-right ul li a:hover, .abstract-menu li a:hover, #main-content .cart_totals div, #roksearch_results .roksearch_odd-hover h3, #roksearch_results .roksearch_even-hover h3, #horiz-menu.splitmenu li:hover .item span, #horiz-menu.splitmenu li.active .item span, #horiz-menu.splitmenu li.active:hover .item span {color: <?php echo $nda_link_color; ?>}
	#main-body ul.menu li > a, #main-body ul.menu li > .separator, #main-body ul.menu li > .item, #main-body ul.menu li li > a, #main-body ul.menu li li > .separator, #main-body ul.menu li li > .item, .feature-block a .readon1-r {color: <?php echo $nda_link_color; ?>}	
	.pagination .page-active, .pagination .page-inactive:hover, .rokstories-layout4 .feature-block .feature-number-sub.active {background: <?php echo $nda_link_color; ?>}
	
</style>	

<?php if (rok_isIe()) :?>
<!--[if IE 8]>
<style type="text/css">
<link href="<?php echo base_path() . path_to_theme(); ?>/css/template_ie8.css" rel="stylesheet" type="text/css" />	
</style>
<![endif]-->
<!--[if IE 7]>
<link href="<?php echo base_path() . path_to_theme(); ?>/css/template_ie7.css" rel="stylesheet" type="text/css" />	
<![endif]-->	
<?php endif; ?>
<?php if (rok_isIe(6)) :?>
<!--[if lte IE 6]>
<link href="<?php echo base_path() . path_to_theme(); ?>/css/template_ie6.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_path() . path_to_theme(); ?>/css/<?php echo $nda_preset_style; ?>_ie6.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_path() . path_to_theme(); ?>/js/DD_belatedPNG.js"></script>
<script type="text/javascript">
	DD_belatedPNG.fix('.png, #main-trans, #main-trans2, #main-trans-top, .feature-module, .readon1-l, .feature-block .description, .readon1-m, .readon1-r, span.number-circle, .drop-top, .fusion-js-subs ul, #horiz-menu li li, .style2 #header, .style2 #header .wrapper, .style2 #horiz-menu, .style3 #header, .style3 #horiz-menu, .style4 #header, .style4 #horiz-menu, .style5 #header, .style5 #horiz-menu, .style5 .abstract-menu li a.am1, .style5 .abstract-menu li a.am2, .style5 .abstract-menu li a.am3, #horiz-menu li.root a, .style3 #header .wrapper, .style4 #header .wrapper, .style5 #logo, .style5 #header .wrapper, #main-trans-bottom');
</script>

<?php endif; ?>



<!-- If JS_COMPAT IS OFF AND NOT IN THE DRUPAL ADMIN, USE MOOTOOLS JS SCRIPTS -->
<?php if(theme_get_setting(js_compatibility) == 0 AND arg(0) != "admin" AND arg(1) != "add" AND arg(2) != "edit" AND arg(0) != "user") : ?>
	<?php include $theme_path . "/rt_mootools.php"; ?>
<?php endif; ?>


