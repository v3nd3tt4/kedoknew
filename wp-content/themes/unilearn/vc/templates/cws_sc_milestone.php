<?php
extract( shortcode_atts( array(
	'icon'				=> '',
	'number'			=> '',
	'title'				=> '',
	'speed'				=> '',
	'use_custom_color'	=> '',
	'custom_color'		=> '',
	'el_class'			=> ''
), $atts));
$icon 				= esc_attr( $icon );
$number				= esc_html( $number );
$title 				= esc_html( $title );
$speed				= esc_html( $speed );
$use_custom_color 	= (bool)$use_custom_color;
$custom_color 		= esc_attr( $custom_color );
$el_class			= esc_attr( $el_class );
$out = "";
if ( empty( $number ) || !is_numeric( $number ) ) return $out;
wp_enqueue_script( 'odometer' );
$out .= "<div class='unilearn_milestone unilearn_module" . ( !empty( $el_class ) ? " $el_class" : "" ) . "'" . ( $use_custom_color && !empty( $custom_color ) ? " style='color: $custom_color;'" : "" ) . ">";
	$out .= !empty( $icon ) ? "<div class='unilearn_milestone_icon'><i class='fa $icon'></i></div>" : "";
	$out .= "<div class='unilearn_milestone_number'" . ( !empty( $speed ) && is_numeric( $speed ) ? " data-speed='$speed'" : "" ) . ">$number</div>";
	$out .= !empty( $title ) ? "<h6 class='unilearn_milestone_title'>$title</h6>" : "";
$out .= "</div>";
echo sprintf("%s", $out);
?>