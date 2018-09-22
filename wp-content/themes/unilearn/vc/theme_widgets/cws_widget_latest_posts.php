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
				esc_html__( 'None', 'unilearn' )				=> 'none',
				esc_html__( 'Categories', 'unilearn' )			=> 'cat',
				esc_html__( 'Tags', 'unilearn' )				=> 'tag',
				esc_html__( 'Categories and Tags', 'unilearn' )	=> 'cat_tag'
			)
		)
	);
	$cat_terms = get_terms( "category" );
	$cats = array();
	foreach ( $cat_terms as $cat_term ){
		$cats[$cat_term->name] = $cat_term->slug;
	}
	if ( !empty( $cats ) ){
		array_push( $params, array(
			'type'			=> 'cws_dropdown',
			'multiple'		=> "true",
			"heading"		=> esc_html__( "Categories", "unilearn" ),
			"param_name"	=> "cats",
			"dependency"	=> array(
				"element"		=> "filter_by",
				"value"			=> array( "cat", "cat_tag" )
			),
			"value"			=> $cats
		));
	}
	$tag_terms = get_terms( "post_tag" );
	$tags = array();
	foreach ( $tag_terms as $tag_term ){
		$tags[$tag_term->name] = $tag_term->slug;
	}
	if ( !empty( $tags ) ){
		array_push( $params, array(
			'type'			=> 'cws_dropdown',
			'multiple'		=> "true",
			"heading"		=> esc_html__( "Tags", "unilearn" ),
			"param_name"	=> "tags",
			"dependency"	=> array(
				"element"		=> "filter_by",
				"value"			=> array( "tag", "cat_tag" )
			),
			"value"			=> $tags
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
			'value'			=> array(
				esc_html__( 'None', 'unilearn' )					=> '',
				esc_html__( 'Categories', 'unilearn' )		=> 'cats',
				esc_html__( 'Tags', 'unilearn' )				=> 'tags',
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
		"name"				=> esc_html__( 'CWS Widget Latest Posts', 'unilearn' ),
		"base"				=> "cws_sc_widget_latest_posts",
		'category'			=> "Unilearn Theme Widgets",
		// "icon"				=> "boc_spacing",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Widget_Latest_Posts extends WPBakeryShortCode {
	    }
	}
?>