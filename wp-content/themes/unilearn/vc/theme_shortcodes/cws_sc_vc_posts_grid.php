<?php
	$post_types = array( 'cws_portfolio', 'cws_staff' );
	$avail_post_types = array();
	foreach ( $post_types as $post_type ){
		if ( post_type_exists( $post_type ) ){
			$post_type_obj = get_post_type_object( $post_type );
			$post_type_name = isset( $post_type_obj->labels->name ) && !empty( $post_type_obj->labels->name ) ? $post_type_obj->labels->name : $post_type;
			$avail_post_types[$post_type_name] = $post_type;
		}
	}
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
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Post Type', 'unilearn' ),
			"param_name"	=> "post_type",
			"save_always" 	=> true,
			"value"			=> $avail_post_types
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
	);
	foreach ( $avail_post_types as $post_type_name => $post_type ) {
		$layout_vals = array();
		switch ( $post_type ){
			case "cws_portfolio":
				$layout_vals = array(
					esc_html__( 'Default', 'unilearn' ) => 'def',
					esc_html__( 'One Column', 'unilearn' ) => '1',
					esc_html__( 'Two Columns', 'unilearn' ) => '2',
					esc_html__( 'Three Columns', 'unilearn' ) => '3',
					esc_html__( 'Four Columns', 'unilearn' ) => '4'
				);
				break;
			case "cws_staff":
				$layout_vals = array(
					esc_html__( 'Default', 'unilearn' ) => 'def',
					esc_html__( 'One Column', 'unilearn' ) => '1',
					esc_html__( 'Two Columns', 'unilearn' ) => '2'
				);
				break;
		}
		if ( !empty( $layout_vals ) ){
			array_push( $params, array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Layout', 'unilearn' ),
				'param_name'	=> $post_type . '_layout',
				'group'			=> $post_type_name . esc_html__( " Options", 'unilearn' ),
				'dependency'	=> array(
									'element'	=> 'post_type',
									'value'		=> $post_type
								),
				'save_always'	=> true,
				'value'			=> $layout_vals
			));
		}
		if ( $post_type == 'cws_portfolio' ){
			$params = array_merge( $params, array(
				array(
					'type'			=> 'checkbox',
					'param_name'	=> $post_type . '_show_data_override',
					'group'			=> $post_type_name . esc_html__( " Options", 'unilearn' ),
					'dependency'	=> array(
							'element'	=> 'post_type',
							'value'		=> $post_type
						),
					'value'			=> array(
						esc_html__( 'Customize Output', 'unilearn' ) => true
					)
				),
				array(
					'type'				=> 'cws_dropdown',
					'multiple'			=> "true",
					'heading'			=> esc_html__( 'Show', 'unilearn' ),
					'param_name'		=> $post_type . '_data_to_show',
					'group'				=> $post_type_name . esc_html__( " Options", 'unilearn' ),					
					'dependency'		=> array(
						'element'			=> $post_type . '_show_data_override',
						'not_empty'			=> true
					),
					'value'				=> array(
						esc_html__( 'None', 'unilearn' )		=> '',
						esc_html__( 'Title', 'unilearn' )		=> 'title',
						esc_html__( 'Excerpt', 'unilearn' )		=> 'excerpt',
						esc_html__( 'Categories', 'unilearn' )	=> 'cats'
					)
				)
			));
		}
		if ( $post_type == 'cws_staff' ){
			$params = array_merge( $params, array(
				array(
					'type'			=> 'checkbox',
					'param_name'	=> $post_type . '_hide_meta_override',
					'group'			=> $post_type_name . esc_html__( " Options", 'unilearn' ),
					'dependency'	=> array(
							'element'	=> 'post_type',
							'value'		=> $post_type
						),
					'value'			=> array(
						esc_html__( 'Customize Output', 'unilearn' ) => true
					)
				),
				array(
					'type'				=> 'cws_dropdown',
					'multiple'			=> "true",
					'heading'			=> esc_html__( 'Hide', 'unilearn' ),
					'param_name'		=> $post_type . '_data_to_hide',
					'group'				=> $post_type_name . esc_html__( " Options", 'unilearn' ),					
					'dependency'		=> array(
						'element'			=> $post_type . '_hide_meta_override',
						'not_empty'			=> true
					),
					'value'				=> array(
						esc_html__( 'None', 'unilearn' )			=> '',
						esc_html__( 'Departments', 'unilearn' )		=> 'department',
						esc_html__( 'Positions', 'unilearn' )		=> 'position'
					)
				)
			));
		}		
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
			"group"				=> $post_type_name . esc_html__( " Options", 'unilearn' ),
			"dependency"		=> array(
					'element'	=> 'post_type',
					'value'		=> $post_type
				),
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
				"group"				=> $post_type_name . esc_html__( " Options", 'unilearn' ),
				"dependency"	=> array(
									"element"	=> $post_type . "_tax",
									"value"		=> $tax
								),
				"value"			=> $avail_terms
			));				
		}
	}
	array_push( $params, array(
		"type"				=> "textfield",
		"heading"			=> esc_html__( 'Extra class name', 'unilearn' ),
		"description"		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'unilearn' ),
		"param_name"		=> "el_class",
		"value"				=> ""
	));
	vc_map( array(
		"name"				=> esc_html__( 'CWS Posts Grid', 'unilearn' ),
		"base"				=> "cws_sc_vc_posts_grid",
		'category'			=> "Unilearn Theme Shortcodes",
		"weight"			=> 80,
		"params"			=> $params
	));

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_CWS_Sc_Vc_Posts_Grid extends WPBakeryShortCode {
    }
}
?>