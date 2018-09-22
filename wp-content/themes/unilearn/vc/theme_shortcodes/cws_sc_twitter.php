<?php
	// Map Shortcode in Visual Composer
	$font_options = unilearn_get_option( 'body_font' );
	$font_color = $font_options['color'];
	vc_map( array(
		"name"				=> esc_html__( 'CWS Twitter', 'unilearn' ),
		"base"				=> "cws_sc_twitter",
		'category'			=> "Unilearn Theme Shortcodes",
		// "icon"				=> "boc_spacing",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "iconpicker",
				"heading"		=> esc_html__( 'Icon', 'unilearn' ),
				"param_name"	=> "icon",
				"value"			=> ""
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Post Count', 'unilearn' ),
				"param_name"	=> "number",
				"value"			=> "4"
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Posts per slide', 'unilearn' ),
				"param_name"	=> "visible_number",
				"value"			=> "2"
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize_colors",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"value"			=> array( esc_html__( 'Use Custom Font Color', 'unilearn' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Font Color', 'unilearn' ),
				"param_name"	=> "custom_font_color",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"dependency"	=> array(
					"element"		=> "customize_colors",
					"not_empty"		=> true
				),
				"value"			=> $font_color
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize_divider",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"value"			=> array( esc_html__( 'Customize Divider', 'unilearn' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Divider First Color', 'unilearn' ),
				"param_name"	=> "divider_first_color",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"dependency"	=> array(
					"element"		=> "customize_divider",
					"not_empty"		=> true
				),
				"value"			=> UNILEARN_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Divider Second Color', 'unilearn' ),
				"param_name"	=> "divider_second_color",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"dependency"	=> array(
					"element"		=> "customize_divider",
					"not_empty"		=> true
				),
				"value"			=> UNILEARN_THEME_2_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Divider Third Color', 'unilearn' ),
				"param_name"	=> "divider_third_color",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"dependency"	=> array(
					"element"		=> "customize_divider",
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
	    class WPBakeryShortCode_CWS_Sc_Twitter extends WPBakeryShortCode {
	    }
	}
?>