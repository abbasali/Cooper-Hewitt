
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
	<title><?php print $head_title ?></title>
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
		
		
		<link rel="stylesheet" href="<?php echo base_path() . path_to_theme(); ?>/css/<?php echo $afterburner_style; ?>.css" type="text/css" />
		
		<!--[if lte IE 6]>
		<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/js/ie_suckerfish.js"></script>
		<link rel="stylesheet" href="<?php echo base_path() . path_to_theme(); ?>/css/styles.ie.css" type="text/css" />
		<![endif]-->
		<!--[if lte IE 7]>
		<link rel="stylesheet" href="<?php echo base_path() . path_to_theme(); ?>/css/styles.ie7.css" type="text/css" />
		<![endif]-->
		
		<link href="<?php echo base_path() . path_to_theme(); ?>/css/general.css" rel="stylesheet" type="text/css" />

</head>


<body>
<?php echo $afterburer_style; ?>
<div class="background"></div>
<div id="main">
	<div id="wrapper" class="foreground">
	    <div id="header">
    		<?php print $top; ?>		
    	    <a href="<?php print check_url($front_page); ?>" id="logo"></a>
		</div>
		
		<div id="message">
		    <!--<jdoc:include type="message" />-->
		</div>
		<?php if ($showcase) : ?>
		<div id="showcase" class="dp100">
			<div class="background"></div>
			<div class="foreground">
		    	<?php print $showcase; ?>
		    </div>
		</div>
		<?php endif; ?>
		<?php print $advertisement; ?>
        <div id="main-content" class="<?php echo $col_mode; ?>">
            <div id="colmask" class="ckl-<?php echo theme_get_setting(leftcolumn_color); ?>">
                <div id="colmid" class="cdr-<?php echo theme_get_setting(rightcolumn_color); ?>">
                    <div id="colright" class="ctr-<?php echo theme_get_setting(rightcolumn_color); ?>">
                        
                        <div id="col1wrap">
							<div id="col1pad">
                            	<div id="col1">
									
									<?php if ($user123) : ?>
									<div id="mainmods" class="spacer <?php echo $user123_width; ?>">
										<?php print $user123; ?>
									</div>
									<?php endif; ?>
									
									
									
                                    <div class="component-pad">
                                        <?php if (theme_get_setting(show_frontpage_content) or !$is_front) : ?>
                                        	<?php if($messages): ?><br /><?php print $messages; ?><?php endif; ?>
                                        <?php endif; ?>
                                        
                                        <!-- Begin Admin Tabs -->
										<?php if ($tabs AND !$is_front): print '<br /><ul class="primary">' . $tabs .'</ul>'; print ""; endif; ?>
									  	<!-- End Admin Tabs -->
                                        
                                        <!-- Print Section Heading -->
										<?php
											if (!$is_front) {
												if (arg(0) == 'taxonomy' && arg(2)  ) {
													//print arg(2);
													$pageTerm = taxonomy_get_term(arg(2));
													echo "<div class='componentheading'>";
													print $pageTerm->name;
													echo "</div>";
												}
												elseif (arg(0) == 'search') {
													echo "<h2 class='componentheading'>Search</h2>";
												}
												elseif (arg(0) == 'aggregator') {
													echo "<h2 class='componentheading'>News</h2>";
												}
												
												elseif (arg(0) == 'node' && arg(1)) {
														$node = node_load(arg(1));
												  	echo "<h2 class='contentheading'>";
												  	print $node->title;
														echo "</h2>";
														$categories = taxonomy_node_get_terms(arg(1));
														foreach ($categories as $category) {
																print $category[0]->name;
														}
												}
												else {
													echo "<h2 class='componentheading'>" . $title . "</h2>";
												}
											}
											else {
												echo "<h2 class='componentheading'>" . $title . "</h2>";
											}
										?>
                             
                                        <?php print $content; ?>
                                        
                                    </div>
                                    
									<?php if ($user456) : ?>
									<div id="mainmods2" class="spacer <?php echo $user456_width; ?>">
										<?php print $user456; ?>
									</div>
									<?php endif; ?>
	                            </div>
							</div>
                        </div>
						<?php if ($left) : ?>
                        <div id="col2" class="<?php echo theme_get_setting(leftcolumn_color); ?>">
                        	<?php print $left; ?>
                        </div>
						<?php endif; ?>
						<?php if ($right) : ?>
                        <div id="col3" class="<?php echo theme_get_setting(rightcolumn_color); ?>">
                        	<?php print $right; ?>
                        </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
		<?php if ($user789) : ?>
		<div id="mainmods3" class="spacer <?php echo $user789_width; ?>">
			<?php print $user789; ?>
		</div>
		<?php endif; ?>
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

<?php print $closure; ?>

</body>
</html>