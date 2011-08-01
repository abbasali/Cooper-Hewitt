<?php
// $Id: node.tpl.php,v 1.4 2008/01/25 21:21:44 goba Exp $

/**
 * @file node.tpl.php
 **/
?>
<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?> clear-block">	
	<div class="full-article">
		<div class="module-tm">
			<div class="module-tl"></div>
			<div class="module-tr"></div>
		</div>
		
		<div class="module-inner">

			<div class="article-rel-wrapper">
                            <?php if ($node->type!="blog") { ?>
                            <?php } else {
                                $link = $node->links["comment_add"]["href"];
                            ?>
                                <h2 class="contentheading"><?php echo l($title,$link);?></h2>
                            <?php } ?>
			</div>
					  
			<?php if ($submitted): ?>	
				<div class="article-info-surround">
					<div class="iteminfo">
							<h1 style="font-size:20px;line-height:1.4em;font-family: vera-sans-1,vera-sans-2;margin:0px;" ><?php print l($node->title,$node->path); ?></h1>
							<?php print $content ?>
					</div>
				</div>
			<?php endif; ?>	
			<?php if ($node->type!="nda_news") { ?>
				<?php print $content ?>
			<?php } else {
			}
			?>
		
			</div>
		
		<div class="module-bm">	
			<div class="module-bl"></div>
			<div class="module-br"></div>
		</div>

		
	</div>
	<br /><br />
  
</div>