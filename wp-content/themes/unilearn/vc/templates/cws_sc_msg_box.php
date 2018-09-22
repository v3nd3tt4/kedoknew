<?php
extract( shortcode_atts( array(
	'type'					=> 'success',
	'title'					=> '',
	'text'					=> '',
	'is_closable'			=> '',
	'customize'				=> '',
	'custom_icon'			=> '',
	'custom_fill_color'		=> UNILEARN_THEME_COLOR,
	'custom_font_color'		=> '#fff',
	'el_class'				=> ''
), $atts));
$out = "";
$type = esc_html( $type );
$is_closable = (bool)$is_closable;
$customize = (bool)$customize;
$custom_icon = esc_html( $custom_icon );
$el_class = esc_attr( $el_class );
$content = !empty( $text ) ? $text : $content;
$section_id = uniqid( "unilearn_msg_box_" );
ob_start();
if ( $customize ){
	echo !empty( $custom_fill_color ) ? "background-color: $custom_fill_color;" : "";
	echo !empty( $custom_font_color ) ? "color: $custom_font_color;" : "";
}
$section_styles = ob_get_clean();
ob_start();
if ( $customize ){
	echo !empty( $custom_font_color ) ? "background-color: $custom_font_color;" : "";
}
$icon_part_styles = ob_get_clean();	
ob_start();
if ( $customize ){
	echo !empty( $custom_fill_color ) ? "color: $custom_fill_color;" : "";
}
$icon_styles = ob_get_clean();
$icon_class = "msg_icon";
$icon_class .= $customize && !empty( $custom_icon ) ? " fa fa-{$custom_icon}" : "";
if ( !empty( $title ) || !empty( $content ) ){
	$out .= "<div id='$section_id' class='unilearn_msg_box unilearn_module $type" . ( $is_closable ? " closable" : "" ) . ( !empty( $el_class ) ? " $el_class" : "" ) . "'" . ( !empty( $section_styles ) ? " style='$section_styles'" : "" ) . ">";
		$out .= "<div class='icon_part'" . ( !empty( $icon_part_styles ) ? " style='$icon_part_styles'" : "" ) . ">";
			$out .= "<i class='$icon_class'" . ( !empty( $icon_styles ) ? " style='$icon_styles'" : "" ) . "></i>";
		$out .= "</div>";
		$out .= "<div class='content_part'>";
			$out .= !empty( $title ) ? "<div class='title'>$title</div>" : "";
			$out .= !empty( $content ) ? "<p>$content</p>" : "";
		$out .= "</div>";
		$out .= $is_closable ? "<a class='close_button'></a>" : "";
	$out .= "</div>";
}
echo sprintf("%s", $out);
?>