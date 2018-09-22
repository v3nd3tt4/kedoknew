<?php
extract( shortcode_atts( array(
	"type"				=> "",
	"mtop"				=> "",
	"mbottom"			=> "",
	"customize_colors"	=> false,
	"first_color"		=> UNILEARN_THEME_COLOR,
	"second_color"		=> UNILEARN_THEME_2_COLOR,
	"third_color"		=> UNILEARN_THEME_3_COLOR,
	"el_class"			=> ""
	), $atts));
	$type 			= esc_attr( $type );
	$mtop 			= esc_attr( $mtop );
	$mbottom 		= esc_attr( $mbottom );
	$first_color 	= esc_attr( $first_color );
	$second_color 	= esc_attr( $second_color );
	$third_color 	= esc_attr( $third_color );
	$el_class		= esc_attr( $el_class );
$classes = "";
$classes .= !empty( $type ) ? " $type" : "";
$classes .= !empty( $el_class ) ? " $el_class" : "";
$classes = trim( $classes );
$id = uniqid( "cws_divider_" );
ob_start();
if ( !empty($mtop) ){
	echo "margin-top: {$mtop}px;";
}
if ( !empty($mbottom) ){
	echo "margin-bottom: {$mbottom}px;";
}
$spacing_styles = ob_get_clean();
ob_start();
if ( $customize_colors ){
	if ( !empty($first_color ) ){
		echo "border-left-color: $first_color;";
	}
	if ( !empty($second_color ) ){
		echo "background-color: $second_color;";			
	}
	if ( !empty($third_color ) ){
		echo "border-right-color: $third_color;";			
	}
}
$color_styles = ob_get_clean();
$out = "";
if ( !empty( $spacing_styles ) || !empty( $color_styles ) ){
	$out .= "<style type='text/css'>";
		$out .= !empty( $spacing_styles ) ? "#{$id}{{$spacing_styles}}" : "";
		$out .= !empty( $color_styles ) ? "#{$id}:before{{$color_styles}}" : "";
	$out .= "</style>";
}
$out .= "<hr" . ( !empty( $spacing_styles ) || !empty( $color_styles ) ? " id='$id'" : "" ) . ( !empty( $classes ) ? " class='$classes'" : "" ) . " />";
echo sprintf("%s", $out);
?>