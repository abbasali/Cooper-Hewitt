<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php print $head_title ?></title>
			<?php
			if ($_GET["format"] == "simple") {
			  $theme = path_to_theme() . '/simple.tpl.php';
			  include ($theme);
			  return;
			}
			?>
		<?php
			$pageclass = "";
			if($is_front) {$pageclass="cooperhewitt-home";}
			$rt_utils_includes = path_to_theme() . "/rt_utils.php";
			include $rt_utils_includes;
			$style_switcher = path_to_theme() . "/rt_styleswitcher.php";
			include $style_switcher;
		?>
		<?php print $head ?>
		<?php print $styles ?>		
		<?php print $scripts ?>
		
		<?php
			$head_includes = path_to_theme() . "/rt_head_includes.php";
			include $head_includes;
		?>	
		
		<?php
			if (isset($_GET['tstyle']) ) {
				$change = "tstyle";
				$styleVar = $_GET['tstyle'];
				cooperhewitt_change_theme($change, $styleVar);
			}
		?>
		<link href="<?php echo base_path() . path_to_theme(); ?>/css/general.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]><link type="text/css" rel="stylesheet" media="all" href="<?php print base_path().path_to_theme() ?>/css/ie7.css" /><![endif]-->
<!--[if IE 8]><link type="text/css" rel="stylesheet" media="all" href="<?php print base_path().path_to_theme() ?>/css/ie8.css" /><![endif]-->
<script type="text/javascript">var switchTo5x=true;</script><script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'808fd4d2-4b3f-457d-afda-337d5e5aa268'});</script>

<script>
	if (document.cookie.indexOf('visited=true') === -1) {
    	var expires = new Date();
    	expires.setDate(expires.getDate()+1);
    	document.cookie = "visited=true; expires="+expires.toUTCString();	
			$(document).ready(function(){
			          $.fn.colorbox({width:725, height:440, iframe:true, href:"/sites/default/files/announcement.html"});
			});
	}
</script>

	</head>
	
	<body id="ff-<?php echo $cooperhewitt_font_family; ?>" class="f-<?php echo $cooperhewitt_defaultfont; ?> <?php echo $cooperhewitt_preset_style; ?> <?php echo $cooperhewitt_bg_style; ?> <?php echo $pageclass; ?> iehandle">
	<!--Begin Top Advertisement-->
	<?php if ($advertisement) : ?>
	<div id="top-advertisement">
		<div class="wrapper">
			<?php print $advertisement; ?>
		</div>
	</div>
	<?php endif; ?>
	<!--End Top Advertisement-->
	<div id="bg-tile"><div id="bg-main">
	<!--Begin Header-->
	<div id="header">
		<div class="wrapper">
			<div class="padding">
				<!--Begin Logo-->
				<?php if ($logo_space or theme_get_setting(show_logo)) : ?>
				<div class="logo-module">
					<?php if ($logo_space) : ?>
						<?php print $logo_space; ?>
					<?php elseif (theme_get_setting(show_logo)) : ?>
						<a href="<?php echo check_url($front_page); ?>" id="logo"></a>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<!--End Logo-->
				<?php if ($top_right or $search or theme_get_setting(show_textsizer)) : ?>
				<div id="top-right-surround">
					<?php if (theme_get_setting(show_textsizer)) : ?>
					<div id="accessibility">
						<div class="textsizer-desc">Text Size</div>
						<div id="buttons">
							<a href="?fontsize=larger&page=<?php print arg(1); ?>" title="" class="large"><span class="button png">&nbsp;</span></a>
							<a href="?fontsize=smaller&page=<?php print arg(1); ?>" title="" class="small"><span class="button png">&nbsp;</span></a>
						</div>
					</div>
					<?php endif; ?>
					<?php if ($top_right) : ?>
					<div id="top-right"><?php print $top_right; ?></div>
					<?php endif; ?>
					<!--Begin Search-->
					<?php if ($search) : ?>
						<div id="searchmod">
							<div class="moduletable"><?php print $search; ?></div>
						</div>
					<?php endif; ?>
					<!--End Search-->
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<!--End Header-->
	<div class="wrapper">
		<!--Begin Horizontal Menu-->
		<?php if($cooperhewitt_menu_type != "none") : ?>
		<div id="horiz-menu" class="<?php echo $cooperhewitt_menu_type; ?>">
			<div class="wrapper">
				<div class="padding">
					<div id="horizmenu-surround">
					<?php if($cooperhewitt_menu_type != "module") : ?>
						<?php
							$tree = menu_tree_page_data('primary-links');  
							$main_menu = main_menu_tree_output($tree, 1);
						   	print $main_menu;	
						?>
					<?php else: ?>
						<?php print $toolbar; ?>
					<?php endif; ?>
					</div>
				<div class="clr"></div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<!--End Horizontal Menu-->
		<div id="main-trans-top">
		<!--Begin Showcase-->
		<?php if ($showcase) : ?>
		<div id="showmodules" class="spacer <?php echo $showcase_width; ?>">
			<?php print $showcase; ?>
		</div>
		<?php endif; ?>
		
		<?php if ($feature) : ?>
		<div id="showmodules2" class="spacer <?php echo $feature_width; ?>">
			<div class="feature-module">
				<?php print $feature; ?>
			</div>
		</div>
		<?php endif; ?>
		<!--End Showcase-->
		</div>
		<div id="main-trans">
		<!--Begin Main Body-->
		<div id="main-body">
			<div id="main-content" class="<?php echo $col_mode; ?>">
			    <div class="colmask leftmenu">
			        <div class="colmid">
			    	    <div class="colright">
					       <!--Begin Main Column (col1wrap)-->   
						    <div class="col1wrap">
						        <div class="col1pad">
						            <div class="col1">
								        <div id="maincol">
											<div id="main-content-surround">
												<?php if (theme_get_setting(show_breadcrumb) AND !$is_front) : ?>
		    									<div id="breadcrumbs">
													<a href="<?php echo check_url($front_page); ?>" id="breadcrumbs-home"></a>
		    										<?php print $breadcrumb; ?>
		    									</div>
		    									<?php endif; ?>
												
												
													<?php if ($main_feature) : ?>
		    										<div id="main-feature">
		    											<?php print $main_feature; ?>
		    										</div>
		    										<?php endif; ?>
		    										
													<?php if ($user123) : ?>
			    									<div id="mainmodules" class="spacer <?php echo $user123_width; ?>">
			    										<?php print $user123; ?>
			 		    							</div>
			    									<?php endif; ?>
			    									<div class="bodycontent">
			    										<?php if ($inset2) : ?>
			    										<div id="inset-block-right">
			    											<?php print $inset2; ?>
			    										</div>
			    										<?php endif; ?>
			    										<?php if ($inset) : ?>
			    										<div id="inset-block-left">
			    											<?php print $inset; ?>
			    										</div>
			    										<?php endif; ?>
			    										<div id="maincontent-block">
															<?php if ($main123) : ?>
					       									<div id="mainmodules5" class="spacer <?php echo $main123_width; ?>">
					       										<?php print $main123; ?>
					       										
					       									</div>
					       									<?php endif; ?>
															
															<!-- Begin Messages -->
															<?php if ($messages) : ?>
																<div class="messages">
																	<?php print $messages; ?>
																</div>
															<?php endif; ?>			
															<!-- End Messages -->
															
															<?php if($is_front) : ?>
																<?php if (theme_get_setting(promoted_content)) : ?>
																	<?php print $content; ?>
																<?php else : ?>
																	<?php print $frontpage; ?>
																<?php endif; ?>
															
															<?php else : ?>
																
															
																
																<?php print $content; ?>
																
																	<!-- Begin Admin Tabs -->
																	<?php if ($tabs): print '<ul class="primary png">' . $tabs .'</ul>'; print "<br>"; endif; ?>
																	<?php if ($tabs2): print '<ul class="secondary">' . $tabs2 .'</ul>'; print "<br>"; endif; ?>
																  	<!-- End Admin Tabs -->
																
															<?php endif; ?>
															
															
															
															<?php if ($main456) : ?>
					       									<div id="mainmodules6" class="spacer <?php echo $main456_width; ?>">
					       										<?php print $main456; ?>
					       										
					       									</div>
					       									<?php endif; ?>
			    										</div>
			    									</div>
			    									<div class="clr"></div>
			       									<?php if ($user456) : ?>
			       									<div id="mainmodules2" class="spacer <?php echo $user456_width; ?>">
			       										<?php print $user456; ?>
			       									</div>
			       									<?php endif; ?>
			       							
											</div>
										</div>    
									</div>
						        </div>
						    </div>
						    <!--End Main Column (col1wrap)-->
					        <!--Begin Left Column (col2)-->
					        <?php if ($current_leftcolumn_width != 0) : ?>
						    <div class="col2">
								<div id="leftcol">
									<?php if ($cooperhewitt_menu_type == "splitmenu" and theme_get_setting(splitmenu_col) == "leftcol" and !$is_front) : ?>
										<?php include 'subnav.php'; ?>
									<?php endif; ?>
									<?php print $left; ?>
									
								</div>
						    </div>
						    <?php endif; ?> 
						    <!--End Left Column (col2)-->
						    <!--Begin Right Column (col3)-->
						    <?php if ($current_rightcolumn_width != 0) : ?>
						    <div class="col3">
								<div id="rightcol">
									<?php if ($cooperhewitt_menu_type == "splitmenu" and theme_get_setting(splitmenu_col) == "rightcol" and !$is_front) : ?>
									<div class="sidenav-block">
										<?php include 'subnav.php'; ?>
									</div>
									<?php endif; ?>
								
										<?php print $right; ?>
								
								</div>
						    </div>
						    <?php endif; ?> 
						    <!--End Right Column (col3)-->
						</div>
					</div>
				</div>
			</div>
			<?php if ($main789) : ?>
			<div id="mainmodules7" class="spacer <?php echo $main789_width; ?>">
				<?php print $main789; ?>
				
			</div>
			<?php endif; ?>
		</div>
		<!--End Main Body-->
	</div>
	</div>
	<!--Begin Main Bottom-->
	<?php if ($user789) : ?>
	<div id="bottom-main">
		<div class="wrapper"><div id="main-trans-bottom">
			<div id="mainmodules3" class="spacer <?php echo $user789_width; ?>">
				<?php print $user789; ?>
			</div>
		</div></div>
	</div>
	<?php endif; ?>	
	<!--End Main Bottom-->
	<!--Begin Footer-->
	<?php if ($footer123 or theme_get_setting(show_copyright) or theme_get_setting(show_topbutton)) : ?>
	<div class="wrapper">
		<div id="main-trans2">
			<div id="footer">
				<div id="footer-bg"><div id="footer-bg2">
					<?php if ($footer123) : ?>
					<div id="mainmodules4" class="spacer <?php echo $footer123_width; ?>">
						<?php print $footer123; ?>
					</div>
					<?php endif; ?>
					<!--Begin Copyright Section-->
					<?php if ($footer4 or theme_get_setting(show_copyright) or theme_get_setting(show_topbutton)) : ?>
					<div class="copyright-block">
					<?php if ($footer4) : ?>
					<div class="footer-mod">
						<?php print $footer4; ?>
					</div>
					<?php elseif (theme_get_setting(show_copyright)) : ?>
					<a href="http://www.rockettheme.com/" title="<?php echo theme_get_setting(copyright_text); ?>" id="rocket"></a>
					<div id="copyright">
						&copy; <?php echo theme_get_setting(copyright_text); ?>
					</div>
					<?php endif; ?>
					<?php if (theme_get_setting(show_topbutton)) : ?>
					<div id="top-button"><a href="#" id="top-scroll" class="top-button-desc">Top</a></div>
					<?php endif; ?>
					</div>
					<?php endif; ?>
					<!--End Copyright Section-->
				</div></div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<!--End Footer-->
	<!--Begin Bottom Advertisment-->
	<?php if ($advertisement2) : ?>
	<div id="bottom-advertisement">
		<div class="wrapper">
			<?php print $advertisement2; ?>
		</div>
	</div>
	<?php endif; ?>
	<!--End Bottom Advertisment-->	
	<?php if ($debug) : ?>
	<div id="debug-mod"><?php print $debug; ?></div>
	<?php endif; ?>
	</div></div>
	
	<?php print $closure;?>

	<script type="text/javascript">
	    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
	    var disqus_shortname = 'cooperhewitt'; // required: replace example with your forum shortname

	    /* * * DON'T EDIT BELOW THIS LINE * * */
	    (function () {
	        var s = document.createElement('script'); s.async = true;
	        s.type = 'text/javascript';
	        s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
	        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
	    }());
	</script>
	</body>
</html>