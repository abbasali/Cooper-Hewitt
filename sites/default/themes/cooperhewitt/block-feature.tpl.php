<div class="block <?php echo $block->extraclass; ?>">
<div class="flush">

<?php if($class != ""): ?>
	<div class="<?php echo $class; ?>">
	
	<div class="moduletable">
		

<?php else: ?>
	<div class="moduletable">

<?php endif; ?>


	<?php if ($block->subject) : ?>
		<div class="side-style-h3"><h3 class="module-title"><?php print $block->subject; ?></h3></div>
	<?php endif; ?>
	<div class="module-padding">

		<?php print $block->content; ?>
	</div>
	

<?php if($class != ""): ?>
	</div></div>
<?php else: ?>
	</div>
<?php endif; ?>

</div>
</div>
