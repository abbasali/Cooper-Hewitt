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


			
			<?php print $content ?>
			       
			   
		</div>
		
		<div class="module-bm">
			<div class="module-bl"></div>
			<div class="module-br"></div>
		</div>

		
	</div>
	<br /><br />
  
</div>