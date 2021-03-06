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
							<h1 style="font-size:36px;line-height:1.4em;font-family: minerva-modern-1,minerva-modern-2;" ><?php print l($node->title,$node->path); ?></h1>
							 Written by 
									<?php
		                            $uprofile = user_load(array('uid'=>$node->uid));
		                            $user_fname = $uprofile->profile_;
		                            	if ($user_fname!="")
		                                	echo l($user_fname,'user/'.$node->uid);
		                                else
		                                    echo $name;
		                            ?>
							on <?php print format_date($node->created, 'custom', "F j, Y") ?> |  
							<a href="<?php echo $node->path ?>#disqus_thread">Comments</a><br /><br />
							<span  class='st_twitter' st_title="<?php echo $node->title ?>" st_url="http://cooperhewitt.org/<?php echo $node->path ?>" displayText='Tweet'></span><span  class='st_facebook' st_title="<?php echo $node->title ?>" st_url="http://cooperhewitt.org/<?php echo $node->path ?>" displayText='Facebook'></span><span  class='st_email' st_title="<?php echo $node->title ?>" st_url="http://cooperhewitt.org/<?php echo $node->path ?>" displayText='Email'></span><span  class='st_sharethis' st_title="<?php echo $node->title ?>" st_url="http://cooperhewitt.org/<?php echo $node->path ?>" displayText='ShareThis'></span>
							<div class="clr"></div>
					</div>
				</div>
			<?php endif; ?>	

			<?php print $content ?>
		
			</div>
		
		<div class="module-bm">	
			<div class="module-bl"></div>
			<div class="module-br"></div>
		</div>

		
	</div>
	<br /><br />
  
</div>