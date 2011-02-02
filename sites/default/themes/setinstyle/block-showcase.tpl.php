
<div class="block <?php echo $block->extraclass; ?>">
<div class="flush">
	<div class="moduletable">

	<?php if ($block->subject) : ?>
		<h3><?php print $block->subject; ?></h3>
	<?php endif; ?>
	<div class="module-padding">

		<?php print $block->content; ?>
	</div>

	</div>
	</div>
</div>


