<?php
/**
 * @file droksidemenu.tpl.php
 * Default theme implementation for roksidemenu.
 *
 * Available variables:
 * - $links: Array of primary links available to for the menu.
 *
 * @see template_preprocess_droksidemenu()
 * @see theme_droksidemenu()
 */
?>

<?php 
	if(variable_get('clean_url', 0)) {
		$preURL = "";
	}
	else {
		$preURL = "?q=";
	}
?>

<ul class="menu level1">
<?php foreach ($links as $link): ?>

	<?php
    
		$href = $link['link']['href'] == "<front>" ? base_path() : base_path() . $preURL . drupal_get_path_alias($link['link']['href']);
	 
	    $title = t($link['link']['title']);
	    $subtext = $link['link']['localized_options']['attributes']['title'];
	  	
	  	$class = "";
		$class .= "orphan item bullet link";
		if($subtext != "") {
		  	$class .= " subtext";
		}
 		
 		$li_class = "item1";
 		if($link['link']['in_active_trail']) {
 			$li_class .= " parent active";
 		}
 	
    ?>
    
 
    
    <li class="<?php echo $li_class; ?>">
        <a href="<?php echo $href; ?>" class="<?php echo $class; ?>"><span><?php echo $title;?><em><?php echo $subtext; ?></em></span></a>
        
        
    <?php if ($link['link']['in_active_trail'] AND $link['below']): ?>
        <div class="fusion-submenu-wrapper level2 columns2">
			<div class="drop-top"></div>

			<ul class="level2 columns2">

	        <?php foreach ($link['below'] as $sublink): ?>
	        
	        <?php
	        	$subhref = $sublink['link']['href'] == "<front>" ? base_path() : base_path() . $preURL . drupal_get_path_alias($sublink['link']['href']);
	       
	            $secID = ($sublink['link']['in_active_trail'])?'':'';
	            $subtitle = t($sublink['link']['title']);
	       		
	       		$subtext2 = $sublink['link']['localized_options']['attributes']['title'];
	  	
			  	$subclass = "";
				$subclass .= "orphan item";
				if($subtext2 != "") {
				  	$subclass .= " subtext";
				}	
	       			     
	            $sub_li_class = "item1";
		 		if($sublink['link']['in_active_trail']) {
		 			$sub_li_class .= " active";
		 		}
	            
	        ?>
	        
            <li class="<?php echo $sub_li_class; ?>">
                <a href="<?php echo $subhref;?>" class="<?php echo $subclass; ?>" id="<?php echo $secID;?>"><?php echo $subtitle;?><em><?php echo $subtext2; ?></em></a>
             </li>
           <?php endforeach;?>
        </ul>
        
        
      </div>
    <?php endif; ?>
    </li>
<?php endforeach;?>
</ul>




