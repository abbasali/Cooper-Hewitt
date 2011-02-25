
<!-- MOOTOOLS LIBRARY -->
<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/js/mootools.js"></script>

<!-- FONT SPAN -->
<?php if(theme_get_setting(enable_fontspans)) : ?>	
	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/js/rokfonts-mt1.2.js"></script>
	<script type="text/javascript">
		window.addEvent('domready', function() {
			var modules = ['side-mod', 'showcase-panel', 'moduletable', 'article-rel-wrapper'];
			var header = ['h3','h2','h1'];
			RokBuildSpans(modules, header);
		});
	</script>
<?php endif; ?>	

<!-- ROKBOX -->
<link href="<?php echo base_path() . path_to_theme(); ?>/js/rokbox/themes/light/rokbox-style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/js/rokbox/rokbox.js"></script>
<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/js/rokbox/themes/light/rokbox-config.js"></script>

<!-- IE WARN -->
<?php if(rok_isIe(6) AND theme_get_setting(enable_ie6warn) == 1)	: ?>
	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/js/rokie6warn.js"></script>
<?php endif; ?>

<!-- FUSION MENU -->
<?php if($cooperhewitt_menu_type=="fusion" AND theme_get_setting(f_enablejs)) : ?>
	
	<?php if(f_enablejs) : ?>
	
	<?php endif; ?>
	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/js/fusion/js/fusion-mt1.2.js"></script>
	<script type="text/javascript">
	window.addEvent('domready', function() {
		new Fusion('ul.menutop', {
			<?php if(rok_isIe(7) OR rok_isIE(6)) : ?>
				pill: 0,
				opacity: 1, 
			<?php else : ?>
				pill: <?php echo theme_get_setting(f_pill); ?>,
				<?php if(rok_isIe(8)) : ?>
					effect: 'slide',
					opacity: 1, 
				<?php else: ?>
					effect: '<?php echo theme_get_setting(f_effect); ?>',
					opacity: <?php echo theme_get_setting(f_opacity); ?>,
				<?php endif; ?>
			<?php endif; ?>
			hideDelay: <?php echo theme_get_setting(f_hidedelay); ?>,
			tweakInitial: {'x': <?php echo theme_get_setting(f_tweakInitial_x); ?>, 'y': <?php echo theme_get_setting(f_tweakInitial_y); ?>},
			tweakSubsequent: {'x': <?php echo theme_get_setting(f_tweakSubsequent_x); ?>, 'y': <?php echo theme_get_setting(f_tweakSubsequent_y); ?>},
			menuFx: {duration: <?php echo theme_get_setting(f_menu_duration); ?>, transition: Fx.Transitions.<?php echo theme_get_setting(f_menu_animation); ?>},
			pillFx: {duration: <?php echo theme_get_setting(f_pill_duration); ?>, transition: Fx.Transitions.<?php echo theme_get_setting(f_pill_animation); ?>}
		});
	});
	</script>
<?php endif; ?>