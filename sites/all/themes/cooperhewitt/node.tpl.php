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
					<div class="article-info-right">
					<span class="createdby"><?php
                                            $uprofile = user_load(array('uid'=>$node->uid));
                                            $user_fname = $uprofile->profile_;
                                            if ($user_fname!="")
                                                echo l($user_fname,'user/'.$node->uid);
                                            else
                                                echo $name;
                                            ?></span>
					</div>
					<div class="iteminfo">
	
						<div class="article-info-left">
							<h2><?php echo l($title,$link);?></h2>
							<span class="createdate">
							
								<span class="date1"><?php print format_date($node->created, 'custom', "F j, Y g:i a") ?></span>
							</span>
							<div class="clr"></div>
						</div>
	
					</div>
				</div>
			
			<?php endif; ?>	

							
			
			
			<?php print $content ?>
			    
			<?php print $links; ?>   
			   
		</div>
		
		<div class="module-bm">
			<div class="module-bl"></div>
			<div class="module-br"></div>
		</div>

		
	</div>
	<br /><br />
  
</div>