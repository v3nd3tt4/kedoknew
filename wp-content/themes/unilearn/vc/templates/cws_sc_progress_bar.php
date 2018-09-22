<?php
extract( shortcode_atts( array(
	'title'				=> '',
	'progress'			=> '',
	'use_custom_color'	=> '',
	'custom_fill_color'	=> '',
	'el_class'			=> ''
), $atts));
$title 				= esc_html( $title );
$progress 			= esc_html( $progress );
$use_custom_color 	= (bool)$use_custom_color;
$custom_fill_color 	= esc_attr( $custom_fill_color );
$el_class			= esc_attr( $el_class );
$out = "";
if ( empty( $progress ) || !is_numeric( $progress ) ) return $out;
$out .= "<div class='unilearn_pb unilearn_module" . ( !empty( $el_class ) ? " $el_class" : "" ) . "'>";
	$out .= !empty( $title ) ? "<h6 class='unilearn_pb_title'>$title</h6>" : "";
	$out .= "<div class='unilearn_pb_bar'>";
		$out .= "<div class='unilearn_pb_progress' data-value='$progress' style='width:0%;" . ( $use_custom_color && !empty( $custom_fill_color ) ? "background-color: $custom_fill_color;" : "" ) . "'>";
		$out .= "</div>";
	$out .= "</div>";
$out .= "</div>";
echo sprintf("%s", $out);
?>