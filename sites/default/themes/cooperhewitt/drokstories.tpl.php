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
	$showtitle = variable_get("drokstories_showtitle", 1);
	$showdate = variable_get("drokstories_showdate", 0);
	$showarticle = variable_get("drokstories_showarticle", 1);
	$showlink = variable_get("drokstories_showlink", 1);
	$showlabeltitle = variable_get("drokstories_showlabeltitle", 0);
	$linklabels = variable_get("drokstories_linklabels", 0);
	$showarrows = variable_get("drokstories_showarrows", 1);
	$arrowpos = variable_get("drokstories_arrowpos","inside");
	$linktitles = variable_get("drokstories_linktitles", 0);
	$linkimages = variable_get("drokstories_linkimages", 0);
	$delay = variable_get("drokstories_delay", 7000);
	$preview_length = variable_get("drokstories_preview_length", 200);
	$img_path = variable_get("drokstories_img_path", '');
	$showthumbs = variable_get("drokstories_showthumbs", 0);
	$thumbpos = variable_get("drokstories_thumbpos", 1);
	$opacity = variable_get("drokstories_opacity", '');
	$leftoffsetx = variable_get("drokstories_leftoffsetx", -40);
	$leftoffsety = variable_get("drokstories_leftoffsety", -100);
	$rightoffsetx = variable_get("drokstories_rightoffsetx", -30);
	$rightoffsety = variable_get("drokstories_rightoffsety", -100);
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
	$labels = db_query($sql);
	$photos = db_query($sql);
	$thumbs = db_query($sql);
	$numbers = db_query($sql);
?>			

<?php 
	if(variable_get('clean_url', 0)) {
		$preURL = "";
	}
	else {
		$preURL = "?q=";
	}
?>
<link href="<?php echo base_path() . path_to_theme(); ?>/css/rokstories.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_path(); ?>sites/all/modules/drokstories/rokstories-mt1.2.js"></script>

<script type="text/javascript">
	var RokStoriesImage = {}, RokStoriesLinks = {};

	RokStoriesImage['rokstories-45'] = [];
	RokStoriesLinks['rokstories-45'] = [];

	window.addEvent('domready', function() {
			new RokStories('rokstories-45', {
				'id': 45,
				'startElement': 0,
				'thumbsOpacity': <?php echo $opacity; ?>,
				'mousetype': 'click',
				'autorun': <?php echo $autoplay; ?>,
				'delay': <?php echo $delay; ?>,
				'startWidth': 'auto',
				'layout': 'layout4',
				'linkedImgs': <?php echo $linkimages; ?>,
				'showThumbs': <?php echo $showthumbs; ?>,
				'fixedThumb': <?php echo $thumbpos; ?>,
				'mask': 1,
				'descsAnim': 'topdown',
				'imgsAnim': 'bottomup',
				'thumbLeftOffsets': {x: <?php echo $leftoffsetx; ?>, y: <?php echo $leftoffsety; ?>},
				'thumbRightOffsets': {x: <?php echo $rightoffsetx; ?>, y: <?php echo $rightoffsety; ?>}
			});
		});
	
	
	<?php while ($imgs = db_fetch_object($photos)) : ?>		
	 	RokStoriesImage['rokstories-45'].push('<?php echo base_path() . path_to_theme(); ?>/<?php echo $img_path . $imgs->nid; ?>.jpg');
		<?php if ($linkimages == 1): ?>
			<?php
				$path = "node/" . $imgs->nid;
				$full_link_path = drupal_get_path_alias($path);
			?>
			RokStoriesLinks['rokstories-45'].push('<?php echo $full_link_path; ?>');
		<?php endif; ?>
	<?php endwhile; ?>	
</script>
			

<div id="rokstories-45" class="rokstories-layout4">
	<div class="feature-block">
		<div class="image-container" style="float: none;">
			<div class="image-full"></div>
			<div class="image-small">
				<?php while ($thumbnails = db_fetch_object($thumbs)) : ?>		 
					<img src="<?php echo base_path() . path_to_theme(); ?>/<?php echo $img_path . $thumbnails->nid; ?>_thumb.jpg" class="feature-sub" alt="image" width="90" height="35" />
				<?php endwhile; ?>	
			   
			</div>
								
		</div>

			
		<div class="desc-container" style="position: absolute; z-index: 5;">
			
			<div class="feature-block-top"><div class="feature-block-top2"></div><div class="feature-block-top3"></div></div>

			<div class="feature-block-inner">

			
			    <?php while ($anode = db_fetch_object($result)) : ?>
		  		
		  		<?php
					$path = "node/" . $anode->nid;
					$fullpath2 = drupal_get_path_alias($path);
							
			  		$final_text = "";
				  	$final_text = $anode->body;
				  	
				  	$final_text = preg_replace("/<?php[^>]+\?>/i", "", $final_text);
				  	$final_text = str_replace("<?", "", $final_text);
				  	$final_text = preg_replace("/<img[^>]+\>/i", "", $final_text);
				  	//$final_text = strip_tags($final_text);
				  	
			  		if(strlen($final_text) > $preview_length) {
				  		$final_text = substr($final_text, 0, strpos($final_text, ' ', $preview_length)) . "..." ;
				  	}
		  		
		  		?>
	
				<div class="description">
					<?php if ($showtitle==1): ?>
						<?php if ($linktitles == 1): ?>
							<a href="<?php echo $fullpath2; ?>" class="feature-link"><span class="feature-title"><?php echo $anode->title; ?></span></a>
						<?php else: ?>
							<span class="feature-title"><?php echo $anode->title; ?></span>					
						<?php endif; ?>
					<?php endif;?>
					<?php if ($showdate==1): ?>
					    <?php 
					    	$article_date = format_date($anode->timestamp, 'custom', 'F j, Y g:i a');
					    ?>
					    <span class="created-date"><?php echo $article_date; ?></span>
					<?php endif;?>
									
					<?php if ($showarticle==1): ?>
						<span class="feature-desc"><?php echo $final_text; ?></span>
					<?php endif; ?>
					
					<?php if ($showlink==1): ?>
						<div class="clr"></div><div class="readon-wrap1"><div class="readon1-l"></div><a href="<?php echo $fullpath2; ?>" title="<?php echo $anode->title; ?>" class="readon-main"><span class="readon1-m"><span class="readon1-r">Read the Full Story</span></span></a></div><div class="clr"></div>
					<?php endif; ?>
				</div>
				
		        <?php endwhile; ?>
		        
		    </div>
		    
		    <div class="feature-block-bottom"><div class="feature-block-bottom2"></div><div class="feature-block-bottom3"></div></div>
		
		</div>
		<div class="feature-numbers">
				<?php $numCount = 1; ?>
				<?php while ($anode = db_fetch_object($numbers)) : ?>
					<?php 
						if ($numCount == 1) $class = ' active';
						else $class = '';
					?>
			    	<span class="feature-number-sub <?php echo $class; ?>"><span><?php echo $numCount; ?></span></span>
					<?php $numCount++; ?>
				<?php endwhile; ?>
			</div>
		
	</div>
</div>



