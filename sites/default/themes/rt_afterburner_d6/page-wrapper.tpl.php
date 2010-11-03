<?php

/*
$color_style			= $this->params->get("colorStyle", "dark");
$template_width 		= $this->params->get("templateWidth", "962");
$leftcolumn_width		= $this->params->get("leftcolumnWidth", "210");
$rightcolumn_width		= $this->params->get("rightcolumnWidth", "210");
$leftcolumn_color		= $this->params->get("leftcolumnColor", "color2");
$rightcolumn_color		= $this->params->get("rightcolumnColor", "color1");
$mootools_enabled       = ($this->params->get("mootools_enabled", 1)  == 0)?"false":"true";
$caption_enabled        = ($this->params->get("caption_enabled", 1)  == 0)?"false":"true";
$rockettheme_logo       = ($this->params->get("rocketthemeLogo", 1)  == 0)?"false":"true";
*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
	<?php
			$rt_utils_includes = path_to_theme() . "/rt_utils.php";
			include $rt_utils_includes;
			$head_includes = path_to_theme() . "/rt_head_includes.php";
			include $head_includes;
			$style_switcher = path_to_theme() . "/rt_styleswitcher.php";
			include $style_switcher;
		?>
		<?php print $head ?>
		<?php print $styles ?>
		<?php print $scripts ?>
		
		
		<link rel="stylesheet" href="<?php echo path_to_theme(); ?>/css/<?php echo $afterburner_style; ?>.css" type="text/css" />
		
		<!--[if lte IE 6]>
		<script type="text/javascript" src="<?php echo path_to_theme(); ?>/js/ie_suckerfish.js"></script>
		<link rel="stylesheet" href="<?php echo path_to_theme(); ?>/css/styles.ie.css" type="text/css" />
		<![endif]-->
		<!--[if lte IE 7]>
		<link rel="stylesheet" href="<?php echo path_to_theme(); ?>/css/styles.ie7.css" type="text/css" />
		<![endif]-->
		
		<link href="<?php echo path_to_theme(); ?>/css/general.css" rel="stylesheet" type="text/css" />

</head>


<body>
<div class="background"></div>
<div id="main">
	<div id="wrapper" class="foreground">
	    <div id="header">
    		<?php print $top; ?>		
    	    <a href="<?php print check_url($front_page); ?>" id="logo"></a>
		</div>
		<div id="nav">
		   	<?php
				$tree = menu_tree_page_data('primary-links');  
				$main_menu = main_menu_tree_output($tree);
			   	print $main_menu;	
		  	?>
		  	
		 
		  	
		</div>
		<div id="message">
		    <!--<jdoc:include type="message" />-->
		</div>
		<?php if ($showcase) : ?>
		<div id="showcase" class="dp100">
			<div class="background"></div>
			<div class="foreground">
		    	
		    </div>
		</div>
		<?php endif; ?>

        <div id="main-content" class="x-c-x">
            <div id="colmask" class="ckl-<?php echo theme_get_setting(leftcolumn_color); ?>">
                <div id="colmid" class="cdr-<?php echo theme_get_setting(rightcolumn_color); ?>">
                    <div id="colright" class="ctr-<?php echo theme_get_setting(rightcolumn_color); ?>">
                        
                        <div id="col1wrap">
							<div id="col1pad">
                            	<div id="col1">
									
									<?php if ($breadcrumb AND theme_get_setting(show_breadcrumb) == true) : ?>
	                                    <div class="breadcrumbs-pad">
	                                        <?php print $breadcrumb; ?>
	                                    </div>
                                    <?php else : ?>
                                    	<div class="breadcrumbs-pad">
	                                        <div class="breadcrumbs">Home</div>
	                                    </div>	
									<?php endif; ?>
								
									
                                    <div class="component-pad">
                                        <script language="javascript" type="text/javascript">
													function iFrameHeight() {
														var h = 0;
														if ( !document.all ) {
															h = document.getElementById('blockrandom').contentDocument.height;
															document.getElementById('blockrandom').style.height = h + 60 + 'px';
														} else if( document.all ) {
															h = document.frames('blockrandom').document.body.scrollHeight;
															document.all.blockrandom.style.height = h + 20 + 'px';
														}
													}
													</script>
													<div class="contentpane">
													<iframe id="blockrandom"
														name="iframe"
														src="http://www.google.com"
														width="100%"
														height="600"
														scrolling="auto"
														align="top"
														frameborder="0"
														class="wrapper">
														This option will not work correctly. Unfortunately, your browser does not support Inline Frames
													</iframe>
                                        
                                    </div>
                                    
									<?php if ($user456) : ?>
									<div id="mainmods2" class="spacer <?php echo $user456_width; ?>">
										
									</div>
									<?php endif; ?>
	                            </div>
							</div>
                        </div>
						
                    </div>
                </div>
            </div>
        </div>
		
		<?php if ($bottom) : ?>
		<div id="footer">
			<div class="footer-pad">
                <?php print $bottom; ?>
            </div>
		</div>
		<?php endif; ?>
		<?php if (theme_get_setting(show_logo) =="true") : ?>
		<a href="http://www.rockettheme.com"><span id="logo2"></span></a>
		<?php endif; ?>
		<?php print $footer; ?>
		<?php print $debug; ?>
	</div>
</div>
</body>
</html>