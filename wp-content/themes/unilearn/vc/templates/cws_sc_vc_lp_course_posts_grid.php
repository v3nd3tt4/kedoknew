<?php
$post_type = defined( "LP_COURSE_CPT" ) ? LP_COURSE_CPT : "lp_course";	
$defaults = array(
	'title'				=> '',
	'title_align'		=> 'left',
	'lp_course_new_tab'	=> '',	
	'total_items_count'	=> esc_html( get_option( 'posts_per_page' ) ),
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
echo sprintf("%s", $out);
?>