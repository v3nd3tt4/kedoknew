<?php
/*
Plugin Name: UniLearn Shortcodes
Plugin URI:  http://creaws.com
Description: Internal use for creaws/cwsthemes themes only.
Version:     1.1.3
Author:      Creative Web Solutions
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: unilearn-shortcodes
*/
if ( !defined( 'UNILEARN_THEME_COLOR' ) ){
	define( 'UNILEARN_THEME_COLOR', '#f27c66' );
}

function unilearn_msg_box ( $atts = array(), $content = "" ){
	extract( shortcode_atts( array(
		'type'					=> 'success',
		'title'					=> '',
		'text'					=> '',
		'lp_course_new_tab'		=> '',
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
	return $out;
}
add_shortcode( 'cws_sc_msg_box', 'unilearn_msg_box' );

function unilearn_vc_posts_grid ( $atts = array(), $content = "" ){
	$defaults = array(
		'title'				=> '',
		'title_align'		=> 'left',
		'post_type'			=> '',
		'total_items_count'	=> '',
		'display_style'		=> 'grid',
		'items_pp'			=> esc_html( get_option( 'posts_per_page' ) ),
		'el_class'			=> '',
	);
	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );
	$out = "";
	if ( empty( $post_type ) ) return $out;
	$cws_portfolio_layout = isset( $atts['cws_portfolio_layout'] ) && !empty( $atts['cws_portfolio_layout'] ) ? $atts['cws_portfolio_layout'] : 'def';
	$cws_portfolio_show_data_override = isset( $atts['cws_portfolio_show_data_override'] ) && !empty( $atts['cws_portfolio_show_data_override'] ) ? $atts['cws_portfolio_show_data_override'] : false;
	$cws_portfolio_data_to_show = isset( $atts['cws_portfolio_data_to_show'] ) && !empty( $atts['cws_portfolio_data_to_show'] ) ? $atts['cws_portfolio_data_to_show'] : "";
	$cws_staff_layout = isset( $atts['cws_staff_layout'] ) && !empty( $atts['cws_staff_layout'] ) ? $atts['cws_staff_layout'] : 'def';
	$cws_staff_hide_meta_override = isset( $atts['cws_staff_hide_meta_override'] ) && !empty( $atts['cws_staff_hide_meta_override'] ) ? $atts['cws_staff_hide_meta_override'] : false;
	$cws_staff_data_to_hide = isset( $atts['cws_staff_data_to_hide'] ) && !empty( $atts['cws_staff_data_to_hide'] ) ? $atts['cws_staff_data_to_hide'] : "";
	$tax = isset( $atts[$post_type . '_tax'] ) ? $atts[$post_type . '_tax'] : '';
	$terms = isset( $atts["{$post_type}_{$tax}_terms"] ) ? $atts["{$post_type}_{$tax}_terms"] : "";
	$proc_atts = array_merge( $proc_atts, array(
		'cws_portfolio_layout'					=> $cws_portfolio_layout,
		'cws_portfolio_show_data_override'		=> $cws_portfolio_show_data_override,
		'cws_portfolio_data_to_show'			=> $cws_portfolio_data_to_show,
		'cws_staff_layout'						=> $cws_staff_layout,
		'cws_staff_hide_meta_override'			=> $cws_staff_hide_meta_override,	
		'cws_staff_data_to_hide'				=> $cws_staff_data_to_hide,
		'tax'									=> $tax,
		'terms'									=> $terms
	));
	$out .= function_exists( "unilearn_posts_grid" ) ? unilearn_posts_grid( $proc_atts ) : "";
	return $out;
}
add_shortcode( 'cws_sc_vc_posts_grid', 'unilearn_vc_posts_grid' );
add_shortcode( 'cws_sc_posts_grid', 'unilearn_posts_grid' );

function unilearn_sc_vc_blog ( $atts = array(), $content = "" ){
	$post_type = "post";
	$def_blog_layout = unilearn_get_option( 'def_blog_layout' );
	$def_blog_layout = isset( $def_blog_layout ) ? $def_blog_layout : "";
	$def_chars_count = unilearn_get_option( 'def_blog_chars_count' );
	$def_chars_count = isset( $def_chars_count ) && is_numeric( $def_chars_count ) ? $def_chars_count : '200';
	$defaults = array(
		'title'						=> '',
		'title_align'				=> 'left',
		'total_items_count'			=> '',
		'layout'					=> $def_blog_layout,
		'post_hide_meta_override'	=> false,
		'post_hide_meta'			=> '',
		'chars_count'				=> $def_chars_count,
		'display_style'				=> 'grid',
		'items_pp'					=> esc_html( get_option( 'posts_per_page' ) ),
		'el_class'					=> '',
	);
	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );
	$out = "";
	$tax = isset( $atts[$post_type . '_tax'] ) ? $atts[$post_type . '_tax'] : '';
	$terms = isset( $atts["{$post_type}_{$tax}_terms"] ) ? $atts["{$post_type}_{$tax}_terms"] : "";
	$proc_atts = array_merge( $proc_atts, array(
		'post_hide_meta_override'				=> $post_hide_meta_override,
		'post_hide_meta'						=> $post_hide_meta,
		'tax'									=> $tax,
		'terms'									=> $terms
	));
	$out .= function_exists( "unilearn_sc_blog" ) ? unilearn_sc_blog( $proc_atts ) : "";
	return $out;
}
add_shortcode( 'cws_sc_vc_blog', 'unilearn_sc_vc_blog' );
add_shortcode( 'cws_sc_blog', 'unilearn_sc_blog' );

function unilearn_shortcode_carousel ( $atts, $content ){
	extract( shortcode_atts( array(
		'title' => '',
		'columns' => '1'
	), $atts));
	$has_title = !empty( $title );
	$section_class = "unilearn_sc_carousel unilearn_module";
	$section_class .= !$has_title ? " bullets_nav" : "";
	$section_atts = " data-columns='$columns'";
	$out = "";
	if ( !empty( $content ) ){
		$out .= "<div class='$section_class'" . ( !empty( $section_atts ) ? $section_atts : "" ) . ">";
			if ( $has_title ){
				$out .= "<div class='unilearn_sc_carousel_header clearfix'>";
					$out .= "<h2>$title</h2>";
					$out .= "<div class='carousel_nav'>";
						$out .= "<span class='prev'></span>";
						$out .= "<span class='next'></span>";
					$out .= "</div>";				
				$out .= "</div>";
			}
			$out .= "<div class='unilearn_wrapper'>";
				$out .= do_shortcode( $content );
			$out .= "</div>";
		$out .= "</div>";
	}
	wp_enqueue_script( 'owl_carousel' );
	return $out;
}
add_shortcode( 'cws_sc_carousel', 'unilearn_shortcode_carousel' );

function unilearn_sc_icon ( $atts = array(), $content = "" ){
	extract( shortcode_atts( array(
		"icon"				=> "",
		"url"				=> "",
		"new_tab"			=> "",
		"title"				=> "",
		"type"				=> "simple",
		"shape"				=> "square",
		"size"				=> "2x",
		"aligning"			=> "",
		"add_hover"			=> "",
		"customize_colors"	=> "",
		"fill_color"		=> "#fff",
		"font_color"		=> UNILEARN_THEME_COLOR,
		"el_class"			=> ""
	), $atts));
	$out = "";
	if ( empty( $icon ) ) return $out;
	$icon 				= esc_html( $icon );
	$url  				= esc_url( $url );
	$new_tab			= (bool)$new_tab;
	$title 				= esc_html( $title );
	$type 				= esc_html( $type );
	$shape				= esc_html( $shape );
	$size				= esc_html( $size );
	$aligning			= esc_html( $aligning );
	$add_hover			= (bool)$add_hover;
	$customize_colors	= (bool)$customize_colors;
	$fill_color			= esc_html( $fill_color );
	$font_color			= esc_html( $font_color );
	$el_class			= esc_attr( $el_class );
	$icon_id = uniqid( "unilearn_icon_" );
	ob_start();	
	if ( $customize_colors && !empty( $fill_color ) && !empty( $font_color ) ){
		echo "<style type='text/css'>";
			echo "#$icon_id{";
				if ( $type == "simple" ){
					echo "color: $font_color;";
				}
				else if ( $type == "bordered" ){
					echo "background-color: $fill_color;";
					echo "color: $font_color;";
					echo "border-color: $font_color;";
				}
				else if ( $type == "alt" ){
					echo "background-color: $font_color;";
					echo "color: $fill_color;";
					echo "border-color: $font_color;";
				}
			echo "}";
			if ( $add_hover ){
				echo "#$icon_id.hovered:hover{";
					if ( $type == "bordered" ){
						echo "background-color: $font_color;";
						echo "color: $fill_color;";
						echo "border-color: $font_color;";
					}
					else if ( $type == "alt" ){
						echo "background-color: $fill_color;";
						echo "color: $font_color;";
						echo "border-color: $font_color;";
					}
				echo "}";				
			}
		echo "</style>";
	}
	$styles = ob_get_clean();
	$al_class = !empty( $aligning ) ? "align{$aligning}" : "";
	$wrapper_tag = "div";
	$wrapper_classes = "unilearn_icon_wrapper";
	$wrapper_classes .= !empty( $styles ) ? " $al_class" : "";
	$tag = !empty( $url ) ? "a" : "i";
	$wrapper_tag_atts = $wrapper_tag;
	$wrapper_tag_atts .= " class='$wrapper_classes'";
	$classes = "unilearn_icon fa {$icon} $type fa-$size";
	$classes .= $type != "simple" ? " $shape" : "";
	$classes .= $add_hover ? " hovered" : "";
	$classes .= empty( $styles ) ? " $al_class" : "";
	$classes .= !empty( $el_class ) ? " $el_class" : "";
	$tag_atts = $tag == 'a' ? "$tag href='$url'" : $tag;
	$tag_atts .= " id='$icon_id'";
	$tag_atts .= " class='$classes'";
	$tag_atts .= !empty( $url ) && $new_tab ? " target='_blank'" : "";
	$tag_atts .= !empty( $title ) ? " title='$title'" : "";
	$out .= !empty( $styles ) ? "<$wrapper_tag_atts>$styles" : "";
		$out .= "<$tag_atts></$tag>";
	$out .= !empty( $styles ) ? "</$wrapper_tag>" : "";
	return $out;
}
add_shortcode( 'cws_sc_icon', 'unilearn_sc_icon' );

function unilearn_sc_button ( $atts = array(), $content = "" ){
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
	return $out;
}
add_shortcode( 'cws_sc_button', 'unilearn_sc_button' );

function unilearn_sc_dropcap ( $atts = array(), $content = "" ){
	return "<span class='dropcap'>$content</span>";
}
add_shortcode( 'cws_sc_dropcap', 'unilearn_sc_dropcap' );

function unilearn_sc_mark ( $atts = array(), $content = "" ){
	extract( shortcode_atts( array(
		'font_color'	=> '#fff',
		'bg_color'		=> UNILEARN_THEME_COLOR
	), $atts));
	return "<mark style='color: $font_color;background-color: $bg_color;'>$content</mark>";
}
add_shortcode( 'cws_sc_mark', 'unilearn_sc_mark' );

function unilearn_sc_embed ( $atts, $content ) {
	extract( shortcode_atts( array(
		'url' => '',
		'width' => '',
		'height' => ''
	), $atts));
	$url = esc_url( $url );
	return !empty( $url ) ? apply_filters( "the_content", "[embed" . ( !empty( $width ) && is_numeric( $width ) ? " width='$width'" : "" ) . ( !empty( $height ) && is_numeric( $height ) ? " height='$height'" : "" ) . "]" . $url . "[/embed]" ) : "";
}
add_shortcode( 'cws_sc_embed', 'unilearn_sc_embed' );

function unilearn_sc_banner ( $atts = array(), $content = "" ){
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
	return $out;
}
add_shortcode( 'cws_sc_banner', 'unilearn_sc_banner' );

function unilearn_sc_call_to_action ( $atts = array(), $content = "" ){
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
	return $out;
}
add_shortcode( 'cws_sc_call_to_action', 'unilearn_sc_call_to_action' );

function unilearn_sc_progress_bar ( $atts = array(), $content = "" ){
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
	return $out;
}
add_shortcode( 'cws_sc_progress_bar', 'unilearn_sc_progress_bar' );

function unilearn_sc_milestone ( $atts = array(), $content = "" ){
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
	return $out;
}
add_shortcode( 'cws_sc_milestone', 'unilearn_sc_milestone' );

function unilearn_sc_services ( $atts = array(), $content = "" ){
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
		$button_atts['customize_colors'] 	= true;
		$button_atts['custom_color'] 		= $primary_color;
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
	return $out;
}
add_shortcode( 'cws_sc_services', 'unilearn_sc_services' );

function unilearn_sc_vc_testimonial ( $atts = array(), $content = "" ){
	$atts['thumbnail'] = isset( $atts['thumbnail'] ) && !empty( $atts['thumbnail'] ) ? wp_get_attachment_url( $atts['thumbnail'] ) : "";
	return unilearn_testimonial_renderer( $atts, $content );
}
add_shortcode( 'cws_sc_vc_testimonial', 'unilearn_sc_vc_testimonial' );
function unilearn_sc_testimonial ( $atts = array(), $content = "" ){
	if ( !empty( $atts['thumbnail'] ) ){
		$thumbnail_data = json_decode( $atts['thumbnail'], true );
		$atts['thumbnail'] = ( isset( $thumbnail_data['@'] ) && isset( $thumbnail_data['@']['src'] ) ) ? $thumbnail_data['@']['src'] : "";
	}
	return function_exists( 'unilearn_testimonial_renderer' ) ? unilearn_testimonial_renderer( $atts, $content ) : '';
}
add_shortcode( 'cws_sc_testimonial', 'unilearn_sc_testimonial' );

function unilearn_sc_pricing_plan ( $atts = array(), $content = "" ){
	extract( shortcode_atts( array(
		'title'				=> '',
		'currency'			=> '',
		'price'				=> '29.99',
		'price_desc'		=> '',
		'add_button'		=> '',
		'button_text'		=> '',
		'button_url'		=> '',
		'button_new_tab'	=> '',
		'button_size'		=> 'regular',
		'button_fw'			=> '',
		'highlighted'		=> '',
		'use_custom_color'	=> '',
		'custom_color'		=> UNILEARN_THEME_COLOR,
		'el_class'			=> ''
 	), $atts));
 	$title 				= esc_html( $title );
 	$currency 			= esc_html( $currency );
 	$price 				= esc_html( $price );
 	$price_desc 		= esc_html( $price_desc );
 	$add_button 		= (bool)$add_button;
 	$highlighted		= (bool)$highlighted;
 	$use_custom_color 	= (bool)$use_custom_color;
 	$custom_color 		= esc_attr( $custom_color );
 	$el_class			= esc_attr( $el_class );
 	$out = "";
	$section_id = uniqid( 'unilearn_pricing_plan_' );
 	ob_start();
 	echo !empty( $title ) ? "<h3 class='pricing_plan_title'>$title</h3>" : "";
 	if ( !empty( $price ) ){
		preg_match( "/(\.|,)(\d+)$/", $price, $matches );
		$fract_price_part = isset( $matches[2] ) ? $matches[2] : '';
		$main_price_part = !empty( $fract_price_part ) ? esc_html( substr( $price, 0, strpos( $price, $fract_price_part ) ) ) : esc_html( $price ); 		
 		echo "<div class='pricing_plan_price'>";
 			echo !empty( $currency ) ? "<span class='currency'>$currency</span>" : "";
 			echo "<span class='main_price_part'>$main_price_part</span>";
 			echo !empty( $fract_price_part ) ? "<span class='fract_price_part'>$fract_price_part</span>" : "";
 			echo !empty( $price_desc ) ? "<span class='price_desc'>$price_desc</span>" : "";
 		echo "</div>";
 	}
	$content = apply_filters( 'the_content', $content );
	echo !empty( $content ) ? "<div class='pricing_plan_content'>$content</div>" : "";
 	$plan = ob_get_clean();
	$button_atts = array(
		'title'		=> $button_text,
		'url'		=> $button_url,
		'new_tab'	=> $button_new_tab,
		'size'		=> $button_size,
		'fw'		=> $button_fw
	);
	if ( $use_custom_color ){
		$button_atts['customize_colors'] = true;
		$button_atts['custom_color'] = $custom_color;
	}
	$button = $add_button ? unilearn_sc_button( $button_atts ) : "";
	/* styles */
	$styles = "#$section_id .pricing_plan_title{
		background-color: $custom_color;
	}
	#$section_id .pricing_plan_price,
	#$section_id .pricing_plan_content ul li:before{
		color: $custom_color;
	}";
	/* \styles */
	$section_class = "unilearn_pricing_plan unilearn_module";
	$section_class .= !empty( $plan ) && !empty( $button ) ? " unilearn_flex_column_sb" : "";
	$section_class .= $highlighted ? " highlighted" : "";
	$section_class .= !empty( $el_class ) ? " $el_class" : "";
	$out .= $use_custom_color && !empty( $custom_color ) ? "<style type='text/css'>$styles</style>" : "";
	$out .= "<div id='$section_id' class='$section_class'>";
		$out .= !empty( $plan ) ? "<div class='pricing_plan'>$plan</div>" : "";
		$out .= !empty( $button ) ? "<div class='pricing_plan_button'>$button</div>" : "";
	$out .= "</div>";
	return $out;
}
add_shortcode( 'cws_sc_pricing_plan', 'unilearn_sc_pricing_plan' );

function unilearn_sc_divider ( $atts = array(), $content = "" ){
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
	return $out;
}
add_shortcode( 'cws_sc_divider', 'unilearn_sc_divider' );

function unilearn_sc_spacing ( $atts = array(), $content = "" ){
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
	return $out;
}
add_shortcode( 'cws_sc_spacing', 'unilearn_sc_spacing' );

function unilearn_sc_twitter ( $atts = array(), $content = "" ){
	extract( shortcode_atts( array(
		"icon"						=> "",
		'number' 					=> 4,
		'visible_number' 			=> 2,
		"customize_colors"			=> false,
		"custom_font_color"			=> "",
		// "custom_link_color"			=> "",
		"customize_divider"			=> false,
		"divider_first_color"		=> UNILEARN_THEME_COLOR,
		"divider_second_color"		=> UNILEARN_THEME_2_COLOR,
		"divider_third_color"		=> UNILEARN_THEME_3_COLOR,
		"el_class"					=> ""
 	), $atts));
 	$title 					= esc_attr( $icon );
 	$title 					= esc_html( $title );
  	$number 				= esc_textarea( $number );
  	$visible_number 		= esc_textarea( $visible_number );
  	$customize_colors 		= (bool)$customize_colors;
  	$custom_font_color 	  	= esc_attr( $custom_font_color );
  	// $custom_link_color 	  	= esc_attr( $custom_link_color );
  	$customize_divider		= (bool)$customize_divider;
  	$divider_first_color 	= esc_attr( $divider_first_color );
 	$divider_second_color 	= esc_attr( $divider_second_color );
 	$divider_third_color 	= esc_attr( $divider_third_color );
 	$el_class				= esc_attr( $el_class );
 	$number = empty( $number ) ? 4 : (int)$number;
 	$visible_number = empty( $visible_number ) ? 2 : (int)$visible_number;
	$classes = "cws_twitter unilearn_module";
	$classes .= !empty( $el_class ) ? " $el_class" : "";
	$classes = trim( $classes );
	$id = uniqid( "cws_twitter_" );

	$number = (int)$number;
	$visible_number = (int)$visible_number;
	$visible_number = $visible_number == 0 ? $number : $visible_number;
	$retrieved_tweets_number = 0;
	$is_plugin_installed = function_exists( 'getTweets' );
	$tweets = $is_plugin_installed ? getTweets( $number ) : array();
	$retrieved_tweets_number = count( $tweets );
	$is_carousel = $retrieved_tweets_number > $visible_number;
	if ( $is_carousel ){
		wp_enqueue_script( 'owl_carousel' );
	}
	$tweets_received = false;
	ob_start();
	if ( !empty( $tweets ) ){
		if ( isset( $tweets['error'] ) && !empty( $tweets['error'] ) ){
			echo do_shortcode( "[cws_sc_msg_box title='" . esc_html__( 'Twitter applyed with error', 'unilearn' ) . "' type='error']" . esc_html( $tweets['error'] ) . "[/cws_sc_msg_box]" );
		}
		else{
			if ( $is_carousel ){
				echo "<ul class='cws_tweets widget_carousel bullets_nav'>";
				$groups_count = ceil( $retrieved_tweets_number / $visible_number );
				for ( $i = 0; $i < $groups_count; $i++ ){
					echo "<li class='cws_tweets_group'>";
						echo "<ul>";
						for( $j = $i * $visible_number; ( ( $j < ( $i + 1 ) * $visible_number ) && ( $j < $retrieved_tweets_number ) ); $j++ ){
							$tweet = $tweets[$j];
							$tweet_text = $tweet['text'];
							$tweet_date = $tweet['created_at'];
							echo "<li class='tweet'>";
								echo "<div class='text'>";
									echo esc_html( $tweet_text );
								echo "</div>";
								echo "<div class='date'>";
									echo esc_html( date( "Y-m-d H:i:s", strtotime( $tweet_date ) ) );
								echo "</div>";	
							echo "</li>";						
						}
						echo "</ul>";
					echo "</li>";
				}
				echo "</ul>";
			}
			else{
				echo "<ul class='cws_tweets'>";
					foreach ( $tweets as $tweet ) {
						echo "<li class='tweet'>";
							$tweet_text = $tweet['text'];
							$tweet_date = $tweet['created_at'];
							echo "<div class='text'>";
								echo esc_html( $tweet_text );
							echo "</div>";
							echo "<div class='date'>";
								echo esc_html( date( "Y-m-d H:i:s", strtotime( $tweet_date ) ) );
							echo "</div>";
						echo "</li>";
					}
				echo "</ul>";
			}
			$tweets_received = true;
		}
	}
	else{
		if ( !$is_plugin_installed ){
			echo do_shortcode( "[cws_sc_msg_box title='" . esc_html__( 'Plugin not installed', 'unilearn' ) . "' type='warn']" . esc_html__( 'Please install and activate required plugin ', 'unilearn' ) . "<a href='https://ru.wordpress.org/plugins/oauth-twitter-feed-for-developers/'>" . esc_html__( "oAuth Twitter Feed for Developers", 'unilearn' ) . "</a>[/cws_sc_msg_box]" );
		}
	}
	$twitter_response = ob_get_clean();


	ob_start();
	if ( $customize_colors && !empty( $custom_font_color ) ){
		echo "#{$id} .cws_twitter_icon i,
				#{$id} .cws_tweets .tweet{
					color: $custom_font_color;
				}
				#{$id} .cws_twitter_icon i,
				#{$id} .owl-pagination .owl-page{
					border-color: $custom_font_color;
				}
				#{$id} .owl-pagination .owl-page.active{
					background-color: $custom_font_color;
				}";
	}
	if ( $customize_divider ){
		echo "#{$id} .cws_twitter_divider:before{";
			if ( !empty($divider_first_color ) ){
				echo "border-left-color: $divider_first_color;";
			}
			if ( !empty($divider_second_color ) ){
				echo "background-color: $divider_second_color;";			
			}
			if ( !empty($divider_third_color ) ){
				echo "border-right-color: $divider_third_color;";			
			}
		echo "}";
	}
	$styles = ob_get_clean();

	ob_start();
	if ( $tweets_received ){
		echo !empty( $styles ) ? "<style type='text/css'>$styles</style>" : "";
		echo "<div id='$id' class='$classes'>";
			if ( !empty( $icon ) ){
				echo "<div class='cws_twitter_icon'>";
					echo "<i class='$icon'></i>";
				echo "</div>";
				echo "<hr class='short cws_twitter_divider' />";
			}
			echo sprintf("%s", $twitter_response);
		echo "</div>";
	}
	else{
		echo sprintf("%s", $twitter_response);
	}
	$out = ob_get_clean();
	return $out;
}
add_shortcode( 'cws_sc_twitter', 'unilearn_sc_twitter' );

/***********
* LEARNPRESS
***********/
function unilearn_sc_vc_lp_course_posts_grid ( $atts = array(), $content = "" ){
	$post_type = defined( "LP_COURSE_CPT" ) ? LP_COURSE_CPT : "lp_course";	
	$defaults = array(
		'title'				=> '',
		'title_align'		=> 'left',
		'total_items_count'	=> '',
		'display_style'		=> 'grid',
		'layout'			=> '3',
		'items_pp'			=> esc_html( get_option( 'posts_per_page' ) ),
		'el_class'			=> '',
	);
	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );
	$out = "";
	$tax = isset( $atts[$post_type . '_tax'] ) ? $atts[$post_type . '_tax'] : '';
	$terms = isset( $atts["{$post_type}_{$tax}_terms"] ) ? $atts["{$post_type}_{$tax}_terms"] : "";
	$proc_atts = array_merge( $proc_atts, array(
		'tax'									=> $tax,
		'terms'									=> $terms
	));
	$out .= function_exists( "unilearn_sc_lp_course_posts_grid" ) ? unilearn_sc_lp_course_posts_grid( $proc_atts ) : "";
	return $out;
}
if ( in_array( 'learnpress/learnpress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	add_shortcode( 'cws_sc_vc_lp_course_posts_grid', 'unilearn_sc_vc_lp_course_posts_grid' );
}
/************
* \LEARNPRESS
************/
?>