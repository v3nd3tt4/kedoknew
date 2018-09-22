<?php
	// Map Shortcode in Visual Composer
	$params = array(
		array(
			"type"			=> "textfield",
			"admin_label"	=> true,
			"heading"		=> esc_html__( 'Title', 'unilearn' ),
			"param_name"	=> "title",
		),
		array(
			"type"			=> "iconpicker",
			"heading"		=> esc_html__( 'Widget Icon', 'unilearn' ),
			"param_name"	=> "icon",
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Filter By', 'unilearn' ),
			"param_name"	=> "filter_by",
			"value"			=> array(
				esc_html__( 'None', 'unilearn' )						=> 'none',
				esc_html__( 'Departments', 'unilearn' )					=> 'department',
				esc_html__( 'Positions', 'unilearn' )					=> 'position',
				esc_html__( 'Departments and Positions', 'unilearn' )	=> 'department_position'
			)
		)
	);
	$dep_terms = get_terms( "cws_staff_member_department" );
	$deps = array();
	if ( !is_a( $dep_terms, 'WP_Error' ) ){
		foreach ( $dep_terms as $dep_term ){
			$deps[$dep_term->name] = $dep_term->slug;
		}
	}
	if ( !empty( $deps ) ){
		array_push( $params, array(
			'type'				=> 'cws_dropdown',
			'multiple'			=> "true",
			"heading"			=> esc_html__( "Departments", "unilearn" ),
			"param_name"		=> "departments",
			"dependency"		=> array(
				"element"			=> "filter_by",
				"value"				=> array( "department", "department_position" )
			),
			"value"				=> $deps
		));
	}
	$pos_terms = get_terms( "cws_staff_member_position" );
	$poss = array();
	if ( !is_a( $dep_terms, 'WP_Error' ) ){
		foreach ( $pos_terms as $pos_term ){
			$poss[$pos_term->name] = $pos_term->slug;
		}
	}
	if ( !empty( $poss ) ){
		array_push( $params, array(
			'type'				=> 'cws_dropdown',
			'multiple'			=> "true",
			"heading"			=> esc_html__( "Positions", "unilearn" ),
			"param_name"		=> "positions",
			"dependency"		=> array(
				"element"			=> "filter_by",
				"value"				=> array( "position", "department_position" )
			),
			"value"				=> $poss
		));
	}
	$params = array_merge( $params, array(
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Posts to Show', 'unilearn' ),
			"param_name"	=> "count",
			"value"			=> "4"
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Posts per slide', 'unilearn' ),
			"param_name"	=> "visible_count",
			"value"			=> "2"
		),
		array(
			'type'				=> 'cws_dropdown',
			'multiple'			=> "true",
			'heading'			=> esc_html__( 'Hide', 'unilearn' ),
			'param_name'		=> 'hide',
			'value'				=> array(
				esc_html__( 'None', 'unilearn' )			=> '',
				esc_html__( 'Departments', 'unilearn' )		=> 'departments',
				esc_html__( 'Positions', 'unilearn' )		=> 'positions',
				esc_html__( 'Description', 'unilearn' )		=> 'desc'
			)
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Chars Count', 'unilearn' ),
			"desc"			=> esc_html__( 'Count of chars from post content', 'unilearn' ),
			"param_name"	=> "chars_count",
			"value"			=> "70"
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "add_custom_color",
			"value"			=> array( esc_html__( 'Add Custom Color', 'unilearn' ) => true )
		),
		array(
			"type"			=> "colorpicker",
			"heading"		=> esc_html__( 'Custom Color', 'unilearn' ),
			"param_name"	=> "color",
			"dependency"	=> array(
				"element"		=> "add_custom_color",
				"not_empty"		=> true
			)
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html__( 'Extra class name', 'unilearn' ),
			"description"		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'unilearn' ),
			"param_name"		=> "el_class",
			"value"				=> ""
		)
	));
	vc_map( array(
		"name"				=> esc_html__( 'CWS Widget CWS Staff', 'unilearn' ),
		"base"				=> "cws_sc_widget_cws_staff",
		'category'			=> "Unilearn Theme Widgets",
		// "icon"				=> "boc_spacing",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Widget_CWS_Staff extends WPBakeryShortCode {
	    }
	}
?>