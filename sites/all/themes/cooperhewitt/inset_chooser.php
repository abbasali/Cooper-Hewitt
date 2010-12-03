
<script type="text/javascript">
	window.addEvent('domready', function() {
		var select = document.id('variation_chooser'), preview = document.id('variation_preview'), next = document.id('variation_chooser_next'), prev = document.id('variation_chooser_prev');
		if (select && preview && prev && next) {
			select.addEvent('change', function(e) {
				new Event(e).stop();
				selectImage(select.selectedIndex);
			});
			prev.addEvent('click', function() {
				var index = select.selectedIndex;
				if (index - 1 < 0) index = select.options.length - 1;
				else index -= 1;
				select.selectedIndex = index;
				selectImage(index);
			});
			next.addEvent('click', function() {
				var index = select.selectedIndex;
				if (index + 1 >= select.options.length) index = 0;
				else index += 1;
				select.selectedIndex = index;
				selectImage(index);
			});
			
			var asset;
			var selectImage = function(index) {
				preview.setStyle('background', 'url(<?php echo path_to_theme(); ?>/images/loading.gif) center center no-repeat');
				asset = new Asset.image('<?php echo path_to_theme(); ?>/images/stories/demo/styles/ss_' + select.options[index].value + '.jpg', {
					onload: function() { 
						if (index == select.selectedIndex) preview.setStyle('background-image', 'url(' + this.src + ')');
					}
				});
			};
			
			selectImage(select.selectedIndex);
		};
	});


</script>

<?php
	if( isset( $_COOKIE['iridium_preset_style'] ) )
		$this_preset_style = $_COOKIE['iridium_preset_style']; 
	else
		$this_preset_style = theme_get_setting('preset_style');
?>
<div class="variation-chooser-surround">
	<div style="width: 280px;" class="variation-chooser-width">
		<img src="<?php echo path_to_theme(); ?>/images/blank.png" name="preview" id="variation_preview" class="variation-img" width="280" height="208" alt="Preview" />
	
		<form action="<?php echo base_path(); ?>" name="chooserform" method="get" class="variation-chooser">
		
		<div class="selection">
			<input type="submit" class="button" value="" />
			<select name="tstyle" id="variation_chooser" class="button">
				<option value="style1"<?php if($this_preset_style == "style1"): ?> selected="selected"<?php endif; ?>>Style 1</option>
				<option value="style2"<?php if($this_preset_style == "style2"): ?> selected="selected"<?php endif; ?>>Style 2</option>
				<option value="style3"<?php if($this_preset_style == "style3"): ?> selected="selected"<?php endif; ?>>Style 3</option>
				<option value="style4"<?php if($this_preset_style == "style4"): ?> selected="selected"<?php endif; ?>>Style 4</option>
				<option value="style5"<?php if($this_preset_style == "style5"): ?> selected="selected"<?php endif; ?>>Style 5</option>
				<option value="style6"<?php if($this_preset_style == "style6"): ?> selected="selected"<?php endif; ?>>Style 6</option>
			</select>
		</div>
		<div class="clr"></div>
		<div class="controls">
			<img class="control-prev" id="variation_chooser_prev" title="Previous" alt="prev" src="<?php echo path_to_theme(); ?>/images/blank.png" style="background-image: url('<?php echo path_to_theme(); ?>/images/showcase-controls.png');" />
			<span class="text-prev">Prev Style</span>
	
			<span class="text-next">Next Style</span>
			<img class="control-next" id="variation_chooser_next" title="Next" alt="next" src="<?php echo path_to_theme(); ?>/images/blank.png" style="background-image: url('<?php echo path_to_theme(); ?>/images/showcase-controls.png');"/>
		</div>
		</form>
	</div>
</div>

	