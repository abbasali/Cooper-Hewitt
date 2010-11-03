
<?php if($class != ""): ?>
	<div class="module <?php echo $class; ?>">
<?php else: ?>
	<div class="module">
<?php endif; ?>

	<?php if ($block->subject) : ?>
		<h3 class="module-title"><?php print $block->subject; ?></h3>
	<?php endif; ?>
	<div class="module-body">	
		<?php print $block->content; ?>
	</div>

</div>
