<?php
extract( shortcode_atts( array(
	"url"				=> "",
	"title"				=> "",
	"offer"				=> "",
	"icon"				=> "",
	"icon_pos"			=> "right",
	"customize_colors"	=> "",
	"bg_color"			=> UNILEARN_THEME_COLOR,
	"font_color"		=> UNILEARN_THEME_COLOR,
	"icon_color"		=> UNILEARN_THEME_COLOR,
	"use_bg_img"		=> "",
	"bg_img"			=> "",
	"bg_size"			=> "auto",
	"bg_repeat"			=> "repeat",
	"bg_pos"			=> "left top",
	"el_class"			=> ""
), $atts));
$out = "";
$url 				= esc_url( $url );
$offer 				= wp_kses( $offer, array( "small" => array() ) );
$icon				= esc_html( $icon );
$customize_colors	= (bool)$customize_colors;
$bg_color			= esc_html( $bg_color );
$font_color			= esc_html( $font_color );
$icon_color			= esc_html( $icon_color );
$use_bg_img			= (bool)$use_bg_img;
$bg_img				= esc_html( $bg_img );
$bg_size			= esc_html( $bg_size );
$bg_repeat			= esc_html( $bg_repeat );
$bg_pos				= esc_html( $bg_pos );
$el_class			= esc_attr( $el_class );
$banner_id 			= uniqid( "banner_id_" );
if ( empty( $title ) && empty( $offer ) && empty( $icon ) ){
	return $out;
}
$classes 	= "unilearn_banner" . ( empty( $url ) ? " unilearn_module" : "" );
$classes    .= !empty( $icon ) ? " icon_{$icon_pos}" : "";
$classes	.= !empty( $el_class ) ? " $el_class" : "";
$tag = "a";
/* section styles */
ob_start();
if ( $customize_colors ){
	echo !empty( $font_color ) 	? " color: $font_color;" : ""; 
	echo !empty( $bg_color ) 	? " background-color: $bg_color;" : ""; 
}
if ( $use_bg_img && !empty( $bg_img ) ){
	$thumbnail  = wp_get_attachment_url( $bg_img );
	echo "background-image: 	url($thumbnail);"; 
	echo "background-size: 		$bg_size;"; 
	echo "background-repeat: 	$bg_repeat;"; 
	echo "background-position: 	$bg_pos;"; 
}
$section_styles = ob_get_clean();
/* \section styles */
/* icon styles */
ob_start();
if ( $customize_colors ){
	echo !empty( $font_color ) ? " color: $icon_color;" : ""; 
}
$icon_styles = ob_get_clean();
/* \icon styles */
$out .= !empty( $url ) ? "<a class='banner_link unilearn_module' href='$url'>" : "";
	$out .= "<span id='$banner_id' class='$classes'" . ( !empty( $section_styles ) ? " style='$section_styles'" : "" ) . ">";
		$out .= "<span class='banner_wrapper clearfix'>";
			$out .= !empty( $icon )	 ? "<span class='banner_icon'" . ( !empty( $icon_styles ) ? " style='$icon_styles'" : "" ) . "><i class='fa $icon'></i></span>" : "";
			$out .= !empty( $offer ) ? "<span class='banner_offer'>$offer</span>" : "";
			$out .= !empty( $title ) ? "<span class='banner_title'>$title</span>" : "";
		$out .= "</span>";
	$out .= "</span>";
$out .= !empty( $url ) ? "</a>" : "";
	echo sprintf("%s", $out);
?>