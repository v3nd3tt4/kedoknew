<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Widget Text', 'unilearn' ),
		"base"				=> "cws_sc_widget_text",
		'category'			=> "Unilearn Theme Widgets",
		// "icon"				=> "boc_spacing",
		"weight"			=> 80,
		"params"			=> array(
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
				"type"			=> "textarea",
				"heading"		=> esc_html__( 'Widget Content', 'unilearn' ),
				"param_name"	=> "text"
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
		)
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Widget_Text extends WPBakeryShortCode {
	    }
	}
?>