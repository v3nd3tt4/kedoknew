<?php
$post_type = "post";
$def_blog_layout = unilearn_get_option( 'def_blog_layout' );
$def_blog_layout = isset( $def_blog_layout ) ? $def_blog_layout : "";
$def_chars_count = unilearn_get_option( 'def_blog_chars_count' );
$def_chars_count = isset( $def_chars_count ) && is_numeric( $def_chars_count ) ? $def_chars_count : '200';
$defaults = array(
	'title'						=> '',
	'title_align'				=> 'left',
	'total_items_count'			=> esc_html( get_option( 'posts_per_page' ) ),
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
echo sprintf("%s", $out);
?>