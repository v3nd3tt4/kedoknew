<?php
extract( shortcode_atts( array(
	"spacing"			=> "30px",
	"el_class"			=> ""
	), $atts));
	$spacing = esc_attr( $spacing );
	$el_class = esc_attr( $el_class );
	$out = "";
	if ( !empty( $spacing ) ){
		$out .= "<div class='cws_spacing" . ( !empty( $el_class ) ? " $el_class" : "" ) . "' style='height: $spacing;'></div>";
	}
echo sprintf("%s", $out);
?>