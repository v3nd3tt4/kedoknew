<?php
extract( shortcode_atts( array(
	"title"				=> "",
	"text"				=> "",
	"icon"				=> "",
	'add_button'		=> '',
	'button_text'		=> '',
	'button_url'		=> '',
	'button_new_tab'	=> '',
	'button_size'		=> 'regular',
	"button_icon"		=> "",
	"button_icon_pos"	=> "left",
	"customize_colors"	=> "",
	"bg_color"			=> UNILEARN_THEME_FOOTER_BG_COLOR,
	"font_color"		=> "#fff",
	"icon_color"		=> UNILEARN_THEME_2_COLOR,
	"use_bg_img"		=> "",
	"bg_img"			=> "",
	"bg_size"			=> "auto",
	"bg_repeat"			=> "repeat",
	"bg_pos"			=> "left top",
	"color_over_img"	=> "",
	"el_class"			=> ""
), $atts));
$out = "";
$text 				= esc_html( $text );
$icon				= esc_html( $icon );
	$add_button 		= (bool)$add_button;
$customize_colors	= (bool)$customize_colors;
$bg_color			= esc_html( $bg_color );
$font_color			= esc_html( $font_color );
$icon_color			= esc_html( $icon_color );
$use_bg_img			= (bool)$use_bg_img;
$bg_img				= esc_html( $bg_img );
$bg_size			= esc_html( $bg_size );
$bg_repeat			= esc_html( $bg_repeat );
$bg_pos				= esc_html( $bg_pos );
$color_over_img 	= (bool)$color_over_img;
$el_class			= esc_attr( $el_class );
$cta_id 			= uniqid( "cta_id_" );
if ( empty( $title ) && empty( $offer ) && empty( $icon ) ){
	return $out;
}
$classes 	= "unilearn_cta unilearn_module";
$classes	.= !empty( $el_class ) ? " $el_class" : "";
$tag = "a";
/* section styles */
ob_start();
if ( $customize_colors ){
	echo !empty( $font_color ) 	? " color: $font_color;" : ""; 
}
$section_styles = ob_get_clean();
/* \section styles */
/* color layer styles */
ob_start();
if ( $customize_colors ){
	echo !empty( $bg_color ) 	? " background-color: $bg_color;" : ""; 
}
$color_layer_styles = ob_get_clean();
/* \color layer styles */
/* img layer styles */
ob_start();
if ( $use_bg_img && !empty( $bg_img ) ){
	$thumbnail  = wp_get_attachment_url( $bg_img );
	echo "background-image: 	url($thumbnail);"; 
	echo "background-size: 		$bg_size;"; 
	echo "background-repeat: 	$bg_repeat;"; 
	echo "background-position: 	$bg_pos;"; 
}
$img_layer_styles = ob_get_clean();
/* \img layer styles */
/* icon styles */
ob_start();
if ( $customize_colors ){
	echo !empty( $font_color ) ? " color: $icon_color;" : ""; 
	echo !empty( $font_color ) ? " border-color: $icon_color;" : ""; 
}
$icon_styles = ob_get_clean();
/* \icon styles */
$color_layer = !empty( $color_layer_styles ) ? "<div class='cta_bg_layer color_layer' style='$color_layer_styles'></div>" : "";
$img_layer = !empty( $img_layer_styles ) ? "<div class='cta_bg_layer img_layer' style='$img_layer_styles'></div>" : "";
$button_atts = array(
	'title'		=> $button_text,
	'url'		=> $button_url,
	'new_tab'	=> $button_new_tab,
	'size'		=> $button_size,
	'icon'		=> $button_icon,
	'icon_pos'	=> $button_icon_pos
);
if ( $customize_colors ){
	$button_atts['customize_colors'] 	= true;
	$button_atts['custom_color'] 		= $icon_color;
	$button_atts['font_color'] 			= $font_color;
}
$button = $add_button ? unilearn_sc_button( $button_atts ) : "";
$text_content = "";
$text_content .= !empty( $title ) ? "<h3 class='cta_title'>$title</h3>" : "";			
$text_content .= !empty( $text ) ? "<div class='cta_text'>$text</div>" : "";
$out .= "<div id='$cta_id' class='$classes'" . ( !empty( $section_styles ) ? " style='$section_styles'" : "" ) . ">";
	if ( $color_over_img ){
		$out .= !empty( $img_layer ) ? $img_layer : "";
		$out .= !empty( $color_layer ) ? $color_layer : "";			
	}
	else{
		$out .= !empty( $color_layer ) ? $color_layer : "";
		$out .= !empty( $img_layer ) ? $img_layer : "";
	}
	$out .= "<div class='cta_holder'>";
		$out .= !empty( $icon )	 ? "<div class='cta_icon'" . ( !empty( $icon_styles ) ? " style='$icon_styles'" : "" ) . "><i class='fa $icon'></i></div>" : "";
		$out .= !empty( $text_content ) ? "<div class='cta_content'>$text_content</div>" : "";
		$out .= !empty( $button ) ? "<div class='cta_button'>$button</div>" : "";
	$out .= "</div>";
$out .= "</div>";
echo sprintf("%s", $out);
?>