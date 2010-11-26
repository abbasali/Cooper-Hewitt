<?php
/**
 * @file droktabs.tpl.php
 * Default theme implementation for droktabs.
 *
 * Available variables:
 * - $links: Array of primary links available to for the menu.
 *
 * @see template_preprocess_droktabs()
 * @see theme_droktabs()
 */
?>

<?php
	$prefix = $GLOBALS['db_prefix'];
	$storycat = variable_get("droktabs_category", 1);
	$limitnum = variable_get("droktabs_rotatorCount", 5);
	$width = variable_get("droktabs_width", 500);
	$duration = variable_get("droktabs_duration", 600);
	$transition = variable_get("droktabs_transition", "Quad.easeInOut");
	$autoplay = variable_get("droktabs_autoplay", 0);
	$delay = variable_get("droktabs_delay", 2000);
	$type = variable_get("droktabs_type", 'scrolling');
	$link_margins = variable_get("droktabs_link_margins", 0);
	
	

	$sql = "SELECT 
				".$prefix."node_revisions.*, ".$prefix."term_node.* 
			FROM 
				".$prefix."node_revisions, ".$prefix."term_node 
			WHERE  
				".$prefix."node_revisions.nid = ".$prefix."term_node.nid AND ".$prefix."term_node.tid = $storycat 
			ORDER BY 
				".$prefix."node_revisions.timestamp DESC 
			LIMIT $limitnum";
	
	global $theme_key;
	
	$result = db_query($sql);
	$result2 = db_query($sql);

?>			

<?php 
	if(variable_get('clean_url', 0)) {
		$preURL = "";
	}
	else {
		$preURL = "?q=";
	}
?>

<script type="text/javascript" src="<?php echo base_path(); ?>sites/all/modules/droktabs/roktabs-mt1.2.js"></script>

<script type="text/javascript">
	RokTabsOptions.duration.push(<?php echo $duration; ?>);
	RokTabsOptions.transition.push(Fx.Transitions.<?php echo $transition; ?>);
	RokTabsOptions.auto.push(<?php echo $autoplay; ?>);
	RokTabsOptions.delay.push(<?php echo $delay; ?>);
	RokTabsOptions.type.push('<?php echo $type; ?>');
	RokTabsOptions.linksMargins.push(<?php echo $link_margins; ?>);
	RokTabsOptions.mouseevent.push('click');
</script>


<div class="roktabs-wrapper" style="width: <?php echo $width; ?>px;">
	<div class="roktabs base">

		<!--<div class="roktabs-arrows">
			<span class="previous">&larr;</span>
			<span class="next">&rarr;</span>
		</div>-->
		<div class="roktabs-links">
			<ul class="roktabs-top">
				<?php $count = 1; ?>
				<?php while ($anode = db_fetch_object($result)) : ?>
					<li class="<?php if($count == 1): ?>first active<?php elseif($count == $limitnum): ?>last<?php endif; ?> icon-left"><span><?php echo $anode->title; ?></span></li>
					<?php $count++; ?>
				<?php endwhile; ?>
			</ul>
		</div>
		
		<div class="roktabs-container-inner">
			<div class="roktabs-container-wrapper">
				<?php $count2 = 1; ?>
				<?php while ($anode2 = db_fetch_object($result2)) : ?>
				<div class="roktabs-tab<?php echo $count2; ?>">
					<div class="wrapper">
						
						<?php echo $anode2->body; ?>

					</div>
				</div>
				<?php $count2++; ?>
				<?php endwhile; ?>
			
			
			</div><!--container-wrapper-->
		</div><!--container-inner-->
		
	</div><!--base-->
</div><!--wrapper-->

			
			


