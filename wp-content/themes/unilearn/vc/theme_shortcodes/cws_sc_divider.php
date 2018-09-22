<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Divider', 'unilearn' ),
		"base"				=> "cws_sc_divider",
		'category'			=> "Unilearn Theme Shortcodes",
		// "icon"				=> "boc_spacing",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Type', 'unilearn' ),
				"param_name"	=> "type",
				"value"			=> array(
					esc_html__( 'Default', 'unilearn' )				=> '',
					esc_html__( 'Simple', 'unilearn' )				=> 'simple',
					esc_html__( 'Thin', 'unilearn' )				=> 'thin',
					esc_html__( 'Short', 'unilearn' )				=> 'short',
					esc_html__( 'Short Simple', 'unilearn' )		=> 'short_simple',
					esc_html__( 'Short Thin', 'unilearn' )			=> 'short_thin'
				) 
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Margin Top', 'unilearn' ),
				"description"	=> esc_html__( 'in pixels', 'unilearn' ),
				"param_name"	=> "mtop",
				"value"			=> ""
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Margin Bottom', 'unilearn' ),
				"description"	=> esc_html__( 'in pixels', 'unilearn' ),
				"param_name"	=> "mbottom",
				"value"			=> ""
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize_colors",
				"dependency"	=> array(
					"element"		=> "type",
					"value"			=> array( "", "short" )
				),
				"value"			=> array( esc_html__( 'Customize Colors', 'unilearn' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'First Color', 'unilearn' ),
				"param_name"	=> "first_color",
				"dependency"	=> array(
					"element"		=> "customize_colors",
					"not_empty"		=> true
				),
				"value"			=> UNILEARN_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Second Color', 'unilearn' ),
				"param_name"	=> "second_color",
				"dependency"	=> array(
					"element"		=> "customize_colors",
					"not_empty"		=> true
				),
				"value"			=> UNILEARN_THEME_2_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Third Color', 'unilearn' ),
				"param_name"	=> "third_color",
				"dependency"	=> array(
					"element"		=> "customize_colors",
					"not_empty"		=> true
				),
				"value"			=> UNILEARN_THEME_3_COLOR
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
	    class WPBakeryShortCode_CWS_Sc_Divider extends WPBakeryShortCode {
	    }
	}
?>