<?php if($class != ""): ?>
	<div class="<?php echo $class; ?>">
	
	<div class="moduletable">
		

<?php else: ?>
	<div class="moduletable">

<?php endif; ?>
		
		<div class="module-inner">
			<?php print $block->content; ?>
		</div>

		

	

<?php if($class != ""): ?>
	</div></div>
<?php else: ?>
	</div>
<?php endif; ?>
