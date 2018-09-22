<?php
extract( shortcode_atts( array(
	'url' => '',
	'width' => '',
	'height' => ''
), $atts));
$url = esc_url( $url );
echo !empty( $url ) ? apply_filters( "the_content", "[embed" . ( !empty( $width ) && is_numeric( $width ) ? " width='$width'" : "" ) . ( !empty( $height ) && is_numeric( $height ) ? " height='$height'" : "" ) . "]" . $url . "[/embed]" ) : "";
?>