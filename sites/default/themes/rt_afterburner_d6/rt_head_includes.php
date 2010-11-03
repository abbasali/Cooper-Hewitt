<?php

// This information has been pulled out to make the template more readible.
//
// This data goes between the <head></head> tags of the template

?>

<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />


<!--[if IE 7]>
<link href="<?php echo base_path() . path_to_theme(); ?>/css/styles.ie7.css" rel="stylesheet" type="text/css" />	
<![endif]-->	

<!--[if lte IE 6]>
<link href="<?php echo base_path() . path_to_theme(); ?>/css/styles.ie.css" rel="stylesheet" type="text/css" />
<![endif]-->

<?php if($mtype=="suckerfish" or $mtype=="splitmenu") : ?>
<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/js/ie_suckerfish.js"></script>
<?php endif; ?>