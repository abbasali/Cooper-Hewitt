<?php 
		if (isset($_GET['change']) ) {
	
			$change = $_GET['change'];
			$styleVar = $_GET['styleVar'];
			$bgVar = $_GET['bgstyle'];
			if (isset($_GET['page']) ) {
				$thisPage= $_GET['page'];
				nda_change_theme($change, $styleVar, $bgVar, $thisPage);
			}
			else {
				nda_change_theme($change, $styleVar, $bgVar);
			}
		}
?>

<?php
		if (isset($_GET['fontsize']) ) {
		
			$current_font = $nda_defaultfont;
			$change = $_GET['fontsize'];
			
			// support the font size toggler
			if ($change=="smaller" || $change =="larger") {
				$changeFont = "default";
				
				if ($change=="smaller" && $current_font=="default") $changeFont = "small";
				elseif ($change=="smaller" && $current_font=="small") $changeFont = "small";
				elseif ($change=="smaller" && $current_font=="large") $changeFont = "default";
				elseif ($change=="larger" && $current_font=="large") $changeFont = "large";
				elseif ($change=="larger" && $current_font=="default") $changeFont = "large";
				elseif ($change=="larger" && $current_font=="small") $changeFont = "default";
			}
			
			if (isset($_GET['page']) ) {
				$thisPage= $_GET['page'];
				change_font($changeFont, $thisPage);
			}
			else {
				change_font($changeFont);
			}
		}
?>
