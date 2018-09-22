<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Message Box', 'unilearn' ),
		"base"				=> "cws_sc_msg_box",
		'category'			=> "Unilearn Theme Shortcodes",
		// "icon"				=> "boc_spacing",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Type', 'unilearn' ),
				"param_name"	=> "type",
				"value"			=> array(
					esc_html__( 'Success', 'unilearn' )				=> 'success',
					esc_html__( 'Warning', 'unilearn' )				=> 'warn',
					esc_html__( 'Error', 'unilearn' )				=> 'error',
					esc_html__( 'Informational', 'unilearn' )		=> 'info',
				) 
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Title', 'unilearn' ),
				"param_name"	=> "title",
			),
			array(
				"type"			=> "textarea",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Text', 'unilearn' ),
				"param_name"	=> "text",
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "is_closable",
				"value"			=> array(
					esc_html__( 'Closable', 'unilearn' ) => true
				)
			),			
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize",
				"value"			=> array( esc_html__( 'Customize', 'unilearn' ) => true )
			),
			array(
				"type"			=> "iconpicker",
				"heading"		=> esc_html__( 'Icon', 'unilearn' ),
				"param_name"	=> "custom_icon",
				"dependency"	=> array(
					"element"	=> "customize",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Fill Color', 'unilearn' ),
				"param_name"	=> "custom_fill_color",
				"dependency"	=> array(
					"element"	=> "customize",
					"not_empty"	=> true
				),
				"value"			=> UNILEARN_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Font Color', 'unilearn' ),
				"param_name"	=> "custom_font_color",
				"dependency"	=> array(
					"element"	=> "customize",
					"not_empty"	=> true
				),
				"value"			=> "#fff"
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
	    class WPBakeryShortCode_CWS_Sc_Msg_Box extends WPBakeryShortCode {
	    }
	}
?>