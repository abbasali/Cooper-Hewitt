<?php
/**
 * @file drokstories.tpl.php
 * Default theme implementation for drokstories.
 *
 * Available variables:
 * - $links: Array of primary links available to for the menu.
 *
 * @see template_preprocess_drokstories()
 * @see theme_drokstories()
 */
?>

<?php
	$prefix = $GLOBALS['db_prefix'];
	$limitnum = variable_get("drokstories_rotatorCount", 5);
	$delay = variable_get("drokstories_delay", 7000);
	$preview_length = variable_get("drokstories_preview_length", 200);
	$img_path = variable_get("drokstories_img_path", '');
	$opacity = variable_get("drokstories_opacity", '');
	$storyCat = variable_get("drokstories_category",'');
	$autoplay = variable_get("drokstories_autoplay", '');

	$sql = "SELECT 
			".$prefix."node_revisions.*, ".$prefix."term_node.* 
		FROM 
			".$prefix."node_revisions, ".$prefix."term_node 
		WHERE  
			".$prefix."node_revisions.nid = ".$prefix."term_node.nid AND ".$prefix."term_node.tid = $storyCat 
		ORDER BY 
			".$prefix."node_revisions.timestamp DESC 
		LIMIT 
			$limitnum";
	
	global $theme_key;
	
	$result = db_query($sql);
	$photos = db_query($sql);
	$thumbs = db_query($sql);
?>			

<?php 
	if(variable_get('clean_url', 0)) {
		$preURL = "";
	}
	else {
		$preURL = "?q=";
	}
?>

<script type="text/javascript" src="./sites/all/modules/drokstories/rokstories.js"></script>

<script type="text/javascript">
	RokStoriesImage = [];
	RokStoriesImage['rokstories-1'] = [];
	
				
				
	<?php while ($imgs = db_fetch_object($photos)) : ?>		
	 	RokStoriesImage['rokstories-1'].push('<?php echo drupal_get_path("theme", $theme_key); ?>/<?php echo $img_path . $imgs->nid; ?>.jpg');
	<?php endwhile; ?>	
			
	window.addEvent('domready', function() {
		new RokStories('rokstories-1', {
			id: 1,
			startElement: 0,
			thumbsOpacity:<?php echo $opacity; ?>,
			mousetype: 'click',
			autorun: <?php echo $autoplay; ?>,
			delay: <?php echo $delay; ?>,
			startWidth: 615	
		});
	});
</script>
			
			
		
<div id="rokstories-1">
	<div class="feature-block">
			
		<div class="image-container">
			<div class="image-full"></div>
			<div class="image-small">
				     
				<?php while ($thumbnails = db_fetch_object($thumbs)) : ?>		 
					<img src="<?php echo drupal_get_path("theme", $theme_key); ?>/<?php echo $img_path . $thumbnails->nid; ?>_thumb.jpg" class="feature-sub" alt="image" />
				<?php endwhile; ?>		
		
			</div>
		</div>
		
		<div class="desc-container">
			
			
			<?php while ($anode = db_fetch_object($result)) : ?>
		  		
		  		<?php
			  		$final_text = "";
				  	$final_text = $anode->body;
				  	
				  	$final_text = preg_replace("/<?php[^>]+\?>/i", "", $final_text);
				  	$final_text = str_replace("<?", "", $final_text);
				  	$final_text = strip_tags($final_text);
				  	
			  		if(strlen($final_text) > $preview_length) {
				  		$final_text = substr($final_text, 0, strpos($final_text, ' ', $preview_length)) . "..." ;
				  	}
		  		
		  		?>
	  		
			
				<div class="description">
					<span class="feature-title"><?php echo $anode->title; ?></span>
					<span class="feature-desc"><?php echo $final_text; ?></span>
					<div class="clr"></div>
					<div class="readon-wrap1">
						<div class="readon1-l png"></div>
							<a href="<?php echo $preURL; ?>node/<?php echo $anode->nid; ?>" title="<?php echo $anode->title; ?>" class="readon-main png"><span class="readon1-m png"><span class="readon1-r png">Read the Full Story</span></span></a>
					</div>
					<div class="clr"></div>
				</div>
			
			
			<?php endwhile; ?>
			
			
			<!--end  desc-container, feature-block, drokstories-1-->
		</div>
	</div>
</div>

