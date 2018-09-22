<?php
$defaults = array(
	'title'				=> '',
	'title_align'		=> 'left',
	'post_type'			=> '',
	'total_items_count'	=> esc_html( get_option( 'posts_per_page' ) ),
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
echo sprintf("%s", $out);
?>