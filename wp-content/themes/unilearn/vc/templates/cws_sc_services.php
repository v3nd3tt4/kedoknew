<?php
extract( shortcode_atts( array(
	'title'				=> '',
	'icon'				=> '',
	// 'desc'				=> '',
	'add_button'		=> '',
	'button_text'		=> '',
	'button_url'		=> '',
	'button_new_tab'	=> '',
	'button_size'		=> 'regular',
	'button_fw'			=> '',
	'customize_colors'	=> '',
	'primary_color'		=> UNILEARN_THEME_COLOR,
	'secondary_color'	=> '#fff',
	'el_class'			=> ''
), $atts));
$title 				= esc_html( $title );
$icon 				= esc_attr( $icon );
$desc 				= apply_filters( 'the_content', $content );
$add_button 		= (bool)$add_button;
$customize_colors 	= (bool)$customize_colors;
$primary_color 		= esc_attr( $primary_color );
$secondary_color 	= esc_attr( $secondary_color );
$el_class			= esc_attr( $el_class );
$out = "";
$button_atts = array(
	'title'		=> $button_text,
	'url'		=> $button_url,
	'new_tab'	=> $button_new_tab,
	'size'		=> $button_size,
	'fw'		=> $button_fw,
	'alt'		=> true
);
if ( $customize_colors ){
	$button_atts['customize_colors'] = true;
	$button_atts['custom_color'] = $primary_color;
}
$section_id = uniqid( 'unilearn_services_column_' );
$button = $add_button ? unilearn_sc_button( $button_atts ) : "";
$title_part = $desc_part = "";
$title_part .= !empty( $title ) ? "<h3 class='unilearn_services_title'>$title</h3>" : "";
$title_part .= !empty( $icon ) ? "<div class='unilearn_services_icon'><i class='fa $icon'></i></div>" : "";
$desc_part .= !empty( $desc ) ? "<div class='unilearn_services_desc clearfix'>$desc</div>" : "";
/* styles */
ob_start();
if ( $customize_colors && !empty( $primary_color ) && !empty( $secondary_color ) ){
	echo "<style type='text/css'>";
		echo "#$section_id{
					border-top-color: $primary_color;
				}
				#$section_id .unilearn_services_title,
				#$section_id:hover .unilearn_services_icon i{
					color: $primary_color;
				}
				#$section_id .unilearn_services_icon i{
					border-color: $primary_color;
					background-color: $primary_color;
				}
				#$section_id .unilearn_services_icon i{
					color: $secondary_color;
				}
				#$section_id:hover .unilearn_services_icon i{
					background-color: $secondary_color;
				}
				#$section_id .unilearn_services_divider{
					background-color: $primary_color;
				}";
	echo "</style>";
}
/* \styles */
$styles = ob_get_clean();
$out .= !empty( $styles ) ? $styles : "";
$out .= "<div id='$section_id' class='unilearn_services_column unilearn_module" . ( !empty( $button ) ? " unilearn_flex_column_sb" : "" ) . ( !empty( $el_class ) ? " $el_class" : "" ) . "'>";
	if ( !empty( $title_part ) && !empty( $desc_part ) ){
		$out .= "<div class='unilearn_services_data'>";
			$out .= $title_part;
			$out .= "<hr class='unilearn_services_divider' />";
			$out .= $desc_part;
		$out .= "</div>";
		$out .= !empty( $button ) ? "<div class='unilearn_services_button'>$button</div>" : "";
	}
	else{
		$out .= "<div class='unilearn_services_data'>";
			$out .= $title_part;
			$out .= $desc_part;
		$out .= "</div>";
		$out .= !empty( $button ) ? "<div class='unilearn_services_button'>$button</div>" : "";
	}
$out .= "</div>";
echo sprintf("%s", $out);
?>