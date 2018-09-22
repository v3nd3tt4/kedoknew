<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Milestone', 'unilearn' ),
		"base"				=> "cws_sc_milestone",
		'category'			=> "Unilearn Theme Shortcodes",
		// "icon"				=> "boc_spacing",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "iconpicker",
				"heading"		=> esc_html__( 'Icon', 'unilearn' ),
				"param_name"	=> "icon",
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Number', 'unilearn' ),
				"description"	=> esc_html__( 'Integer', 'unilearn' ),
				"param_name"	=> "number",
				"value"			=> "356",
				"save_always"	=> true
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Title', 'unilearn' ),
				"param_name"	=> "title",
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Speed', 'unilearn' ),
				"description"	=> esc_html__( 'Integer', 'unilearn' ),
				"param_name"	=> "speed",
				"value"			=> "2000",
				"save_always"	=> true
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "use_custom_color",
				"value"			=> array( esc_html__( 'Use Custom Color', 'unilearn' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Color', 'unilearn' ),
				"param_name"	=> "custom_color",
				"dependency"	=> array(
					"element"	=> "use_custom_color",
					"not_empty"	=> true
				),
				"value"			=> UNILEARN_THEME_COLOR
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html__( 'Extra class name', 'unilearn' ),
				"description"		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'unilearn' ),
				"param_name"		=> "el_class",
				"value"				=> ""
			)
		)
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Milestone extends WPBakeryShortCode {
	    }
	}
?>