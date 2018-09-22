<?php
$font_options = unilearn_get_option( 'body_font' );
$font_color = esc_attr( $font_options['color'] );
extract( shortcode_atts( array(
	"title"				=> "",
	"url"				=> "",
	"new_tab"			=> "",
	"size"				=> "regular",
	"ofs"				=> "",
	"aligning"			=> "",
	"fw"				=> "",
	"icon"				=> "",
	"icon_pos"			=> "right",
	"alt"				=> "",
	"customize_colors"	=> "",
	"custom_color"		=> UNILEARN_THEME_COLOR,
	"font_color"		=> $font_color,
	"el_class"			=> ""
), $atts));
$out = "";
$title 				= esc_html( $title );
$url  				= esc_url( $url );
$new_tab			= (bool)$new_tab;
$size 				= esc_html( $size );
$ofs 				= (int)$ofs;
$aligning			= esc_html( $aligning );
$fw					= (bool)$fw;
$icon				= esc_html( $icon );
$alt				= (bool)$alt;
$customize_colors	= (bool)$customize_colors;
$custom_color		= esc_attr( $custom_color );
$font_color			= esc_attr( $font_color );
$el_class			= esc_attr( $el_class );
$button_id = uniqid( "unilearn_button_" );

/* styles */
ob_start();
if ( $ofs > 0 ){
	echo "#$button_id{";
		echo "padding-left: {$ofs}px;";
		echo "padding-right: {$ofs}px;";
	echo "}";
}
if ( $customize_colors ){
	echo "#$button_id{";
		if ( $alt ){
			echo !empty( $custom_color ) ? "background-color: $custom_color;" : "";
			echo "color: #fff;";
			echo !empty( $custom_color ) ? "border-color: $custom_color;" : "";
		}
		else{
			echo "background-color: transparent;";
			echo !empty( $font_color ) ? "color: $font_color;" : "";
			echo !empty( $custom_color ) ? "border-color: $custom_color;" : "";					
		}
	echo "}";
	echo "#$button_id:hover{";
	if ( $alt ){
		echo !empty( $font_color ) ? "color: $font_color;" : "";
		echo "background-color: transparent;";
		echo !empty( $custom_color ) ? "border-color: $custom_color;" : "";
	}
	else{
		echo !empty( $custom_color ) ? "background-color: $custom_color;" : "";
		echo "color: #fff;";
		echo empty( $custom_color ) ? "border-color: $custom_color;" : "";			
	echo "}";				
	}
}
$styles = ob_get_clean();
/* \styles */

$al_class = !empty( $aligning ) ? " align{$aligning}" : "";
$wrapper_tag = "div";
$wrapper_classes = "unilearn_button_wrapper";
$wrapper_classes .= !empty( $styles ) ? $al_class : "";
$wrapper_tag_atts = $wrapper_tag;
$wrapper_tag_atts .= !empty( $wrapper_classes ) ? " class='$wrapper_classes'" : "";

$tag = "a";
$tag_atts = !empty( $url ) ? "$tag href='$url'" : $tag;
$tag_atts .= " id='$button_id'";
$classes = "unilearn_button $size";
$classes .= $fw ? " fw" : "";
$classes .= $alt ? " alt" : "";
$classes .= empty( $styles ) ? $al_class : "";
$classes .= !empty( $el_class ) ? " $el_class" : "";
$tag_atts .= " class='$classes'";
$tag_atts .= !empty( $url ) && $new_tab ? " target='_blank'" : "";

$out .= !empty( $styles ) ? "<$wrapper_tag_atts>" : "";
	$out .= !empty( $styles ) ? "<style type='text/css'>$styles</style>" : "";
	$out .= "<$tag_atts>";
		if ( !empty( $icon ) && $icon_pos == 'left' ){
			$out .= "<i class='fa $icon'></i>&#x20;";
		}
		$out .= $title;
		if ( !empty( $icon ) && $icon_pos == 'right' ){
			$out .= "&#x20;<i class='fa $icon'></i>";
		}		
	$out .= "</$tag>";
$out .= !empty( $styles ) ? "</$wrapper_tag>" : "";
echo sprintf("%s", $out);
?>