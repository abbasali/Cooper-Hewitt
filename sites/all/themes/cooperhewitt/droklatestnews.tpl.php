<?php
/**
 * @file droklatestnews.tpl.php
 * Default theme implementation for droklatestnews.
 *
 * Available variables:
 * - $links: Array of primary links available to for the menu.
 *
 * @see template_preprocess_droklatestnews()
 * @see theme_droklatestnews()
 */
?>

<?php
	$prefix = $GLOBALS['db_prefix'];
	$limitnum = variable_get("latestnews_rotatorCount", 5);
	$preview_length = variable_get("latestnews_preview_length", 50);
	$flashCat = variable_get("latestnews_category",'');
	$linkLabel = variable_get("latestnews_linklabel", '');
	$img_path = variable_get("latestnews_img_path", '');
	$feature_1 = variable_get("latestnews_feature", 1);

	$sql = "SELECT 
				".$prefix."node_revisions.*, ".$prefix."term_node.* 
			FROM 
				".$prefix."node_revisions, ".$prefix."term_node 
			WHERE  
				".$prefix."node_revisions.nid = ".$prefix."term_node.nid AND ".$prefix."term_node.tid = $flashCat 
			ORDER BY 
				".$prefix."node_revisions.timestamp DESC 
			LIMIT $limitnum";
	
	$result = db_query($sql);
	
	global $theme_key;
?>

<?php 
	if(variable_get('clean_url', 0)) {
		$preURL = "";
	}
	else {
		$preURL = "?q=";
	}
?>			

<div class="blog">
	<div class="leading">
		<div class="">
			<div class="article-rel-wrapper"></div>
			
			
			<?php $i = 1; ?>
			<?php while ($anode = db_fetch_object($result)) : ?>
				
				<?php
				  	$path = "node/" . $anode->nid;
					$fullpath2 = drupal_get_path_alias($path);
							
			  		$final_text = "";
				  	$final_text = $anode->teaser;
				  	
				  	$final_text = preg_replace("/<?php[^>]+\?>/i", "", $final_text);
				  	$final_text = str_replace("<?", "", $final_text);
				  	$final_text = preg_replace("/<img[^>]+\>/i", "", $final_text);
				  	//$final_text = strip_tags($final_text);
				  	
			  		if(strlen($final_text) > $preview_length) {
				  		$final_text = substr($final_text, 0, strpos($final_text, ' ', $preview_length)) . "..." ;
				  	}
			  	?>
				
				
				
					<div class="fp-sub">
						<div class="fp-sub1">
							<h4><a href="<?php echo $preURL; ?>node/<?php echo $anode->nid; ?>" title="<?php echo $anode->title; ?>"><?php echo $anode->title; ?></a></h4>
						</div>
						<div>
							<div class="latestnews_image"><a href="<?php echo $preURL; ?>node/<?php echo $anode->nid; ?>" title="<?php echo $anode->title; ?>"><img alt="image" src="<?php echo drupal_get_path("theme", $theme_key); ?>/<?php echo $img_path . $anode->nid; ?>_thumb.jpg" /></a></div>
							<div class="latestnews_text"><?php echo $final_text; ?><span><a href="?q=node/<?php echo $anode->nid; ?>" title="<?php echo $anode->title; ?>"><?php echo $linkLabel; ?></a></div>
							<div style="clear: both;"></div>
						</div>
						
					</div>
				
					<hr class="dotted">
			
			<?php endwhile; ?>
			
		
		</div>
	</div>
</div>
<div style="clear: both;"></div>
		