<?php 
		if (isset($_GET['change']) ) {
	
			$change = $_GET['change'];
			$styleVar = $_GET['styleVar'];
			if (isset($_GET['page']) ) {
				$thisPage= $_GET['page'];
				afterburner_change_theme($change, $styleVar, $thisPage);
			}
			else {
				afterburner_change_theme($change, $styleVar);
			}
		}
?>
