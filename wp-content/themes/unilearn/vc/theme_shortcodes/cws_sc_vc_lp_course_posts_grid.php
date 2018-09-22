<?php
	$post_type = defined( "LP_COURSE_CPT" ) ? LP_COURSE_CPT : "lp_course";
	$params = array(
		array(
			"type"			=> "textfield",
			"admin_label"	=> true,
			"heading"		=> esc_html__( 'Title', 'unilearn' ),
			"param_name"	=> "title",
			"value"			=> ""
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Title Alignment', 'unilearn' ),
			"param_name"	=> "title_align",
			"value"			=> array(
				esc_html__( "Left", 'unilearn' ) 	=> 'left',
				esc_html__( "Right", 'unilearn' )	=> 'right',
				esc_html__( "Center", 'unilearn' )	=> 'center'
			)		
		),
		array(
			'type'			=> 'checkbox',
			'param_name'	=> 'lp_course_new_tab',
			'value'			=> array(
				esc_html__( 'Open in a new tab', 'unilearn' ) => true
			)
		),			
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Display Style', 'unilearn' ),
			"param_name"	=> "display_style",
			"value"			=> array(
				esc_html__( 'Grid', 'unilearn' ) => 'grid',
				esc_html__( 'Grid with Filter', 'unilearn' ) => 'filter',
				esc_html__( 'Carousel', 'unilearn' ) => 'carousel'
			)
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Items to display', 'unilearn' ),
			"param_name"	=> "total_items_count",
			"value"			=> esc_html( get_option( 'posts_per_page' ) )
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Items per Page', 'unilearn' ),
			"param_name"	=> "items_pp",
			"dependency" 	=> array(
								"element"	=> "display_style",
								"value"		=> array( "grid", "filter" )
							),
			"value"			=> esc_html( get_option( 'posts_per_page' ) )
		),
		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__( 'Layout', 'unilearn' ),
			'param_name'	=> 'layout',
			'save_always'	=> true,
			'value'			=> array(
				esc_html__( 'One Column', 'unilearn' ) => '1',
				esc_html__( 'Two Columns', 'unilearn' ) => '2',
				esc_html__( 'Three Columns', 'unilearn' ) => '3',
				esc_html__( 'Four Columns', 'unilearn' ) => '4'
							)
		)
	);
	$taxes = get_object_taxonomies ( $post_type, 'object' );
	$avail_taxes = array(
		esc_html__( 'None', 'unilearn' )	=> ''
	);
	foreach ( $taxes as $tax => $tax_obj ){
		$tax_name = isset( $tax_obj->labels->name ) && !empty( $tax_obj->labels->name ) ? $tax_obj->labels->name : $tax;
		$avail_taxes[$tax_name] = $tax;
	}
	array_push( $params, array(
		"type"				=> "dropdown",
		"heading"			=> esc_html__( 'Filter by', 'unilearn' ),
		"param_name"		=> $post_type . "_tax",
		"value"				=> $avail_taxes
	));
	foreach ( $avail_taxes as $tax_name => $tax ) {
		$terms = get_terms( $tax );
		$avail_terms = array(
			''				=> ''
		);
		if ( !is_a( $terms, 'WP_Error' ) ){
			foreach ( $terms as $term ) {
				$avail_terms[$term->name] = $term->slug;
			}
		}
		array_push( $params, array(
			"type"			=> "cws_dropdown",
			"multiple"		=> "true",
			"heading"		=> $tax_name,
			"param_name"	=> "{$post_type}_{$tax}_terms",
			"dependency"	=> array(
								"element"	=> $post_type . "_tax",
								"value"		=> $tax
							),
			"value"			=> $avail_terms
		));				
	}
	array_push( $params, array(
		"type"				=> "textfield",
		"heading"			=> esc_html__( 'Extra class name', 'unilearn' ),
		"description"		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'unilearn' ),
		"param_name"		=> "el_class",
		"value"				=> ""
	));

	vc_map( array(
		"name"				=> esc_html__( 'CWS Courses Grid', 'unilearn' ),
		"base"				=> "cws_sc_vc_lp_course_posts_grid",
		'category'			=> "Unilearn Theme Shortcodes",
		"weight"			=> 80,
		"params"			=> $params
	));

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_CWS_Sc_Vc_LP_Course_Posts_Grid extends WPBakeryShortCode {
    }
}

?>