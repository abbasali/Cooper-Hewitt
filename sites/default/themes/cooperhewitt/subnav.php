
				

<?php if($thisTitle != "") : ?>

<div class="side-style-h3">
	<div class="moduletable">
		<h3 class="module-title"><?php echo $thisTitle; ?> Menu</h3>       									
	
		<?php
			
			foreach($menus as $menu) {
			    if(!empty($menu['link']['in_active_trail']))
			        echo split_menu_tree_output($menu['below']);
			}
		?>
		
	</div>
</div>

<?php endif; ?>