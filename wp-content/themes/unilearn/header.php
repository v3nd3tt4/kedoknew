<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php do_action( 'unilearn_header_meta' ); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php
		$boxed_layout = unilearn_get_option( "boxed_layout" );
		?>
		<div id="document"<?php if ($boxed_layout ){ echo " class='boxed'";} ?>>
		<?php
			unilearn_header();
	?>