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
				  	$final_text = "";
				  	$final_text = strip_tags($anode->body);
		
					if(strlen($final_text) > $preview_length) {
				  		$final_text = substr($final_text, 0, strpos($final_text, ' ', $preview_length)) . "..." ;
				  	}
			  	?>
				
				<?php if($i == 1 AND $feature_1 == 1) : ?>
					
					<div class="fp-leading">
						<div class="fp-caption">
							
							<a href="<?php echo $preURL; ?>node/<?php echo $anode->nid; ?>" title="<?php echo $anode->title; ?>"><img alt="image" src="<?php echo drupal_get_path("theme", $theme_key); ?>/<?php echo $img_path . $anode->nid; ?>.jpg" /></a> 
							<br />
							<span><a href="<?php echo $preURL; ?>node/<?php echo $anode->nid; ?>" title="<?php echo $anode->title; ?>"><?php echo $linkLabel; ?></a>
					
						</div>
						<div>
							<h3><a href="<?php echo $preURL; ?>node/<?php echo $anode->nid; ?>" title="<?php echo $anode->title; ?>"><?php echo $anode->title; ?></a></h3><?php echo $final_text; ?>
						</div>
					</div>
				
				
				<?php else : ?>
				
					<div class="fp-sub">
						<div class="fp-sub1">
							<a href="<?php echo $preURL; ?>node/<?php echo $anode->nid; ?>" title="<?php echo $anode->title; ?>"><img alt="image" src="<?php echo drupal_get_path("theme", $theme_key); ?>/<?php echo $img_path . $anode->nid; ?>.jpg" width="66" height="58" /></a> 
						</div>
						<div>
							<h4><a href="<?php echo $preURL; ?>node/<?php echo $anode->nid; ?>" title="<?php echo $anode->title; ?>"><?php echo $anode->title; ?></a></h4>
							<?php echo $final_text; ?><br /><span><a href="?q=node/<?php echo $anode->nid; ?>" title="<?php echo $anode->title; ?>"><?php echo $linkLabel; ?></a>
						</div>
					</div>
					
				<?php endif; ?>
				
				<?php $i++; ?>
			
			<?php endwhile; ?>
			
		
		</div>
	</div>
</div>
<div style="clear: both;"></div>
		