<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Pricing Plan', 'unilearn' ),
		"base"				=> "cws_sc_pricing_plan",
		'category'			=> "Unilearn Theme Shortcodes",
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
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Currency', 'unilearn' ),
				"param_name"	=> "currency",
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Price', 'unilearn' ),
				"description"	=> esc_html__( 'Split integer and decimal part by dot symbol', 'unilearn' ),
				"param_name"	=> "price",
				"value"			=> "29.99",
				"save_always"	=> true
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Price description', 'unilearn' ),
				"param_name"	=> "price_desc",
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "highlighted",
				"value"			=> array( esc_html__( 'Highlighted', 'unilearn' ) => true )			
			),			
			array(
				"type"			=> "checkbox",
				"param_name"	=> "use_custom_color",
				"value"			=> array( esc_html__( 'Use Custom Color', 'unilearn' ) => true )			
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Custom Color', 'unilearn' ),
				"param_name"	=> "custom_color",
				"dependency"	=> array(
					"element"	=> "use_custom_color",
					"not_empty"	=> true
				),
				"value"			=> UNILEARN_THEME_COLOR,
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "add_button",
				"value"			=> array( esc_html__( 'Add Button', 'unilearn' ) => true )
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Button Text', 'unilearn' ),
				"param_name"	=> "button_text",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Url', 'unilearn' ),
				"param_name"	=> "button_url",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				)
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_new_tab",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Open Link in New Tab', 'unilearn' ) => true )
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Button Size', 'unilearn' ),
				"param_name"	=> "button_size",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array(
					esc_html__( 'Regular', 'unilearn' )		=> 'regular',
					esc_html__( 'Mini', 'unilearn' )		=> 'mini',
					esc_html__( 'Small', 'unilearn' )		=> 'small',
					esc_html__( 'Large', 'unilearn' )		=> 'large'
				) 
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_fw",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Make Button Full Width', 'unilearn' ) => true )
			),
			array(
				"type"			=> "textarea_html",
				"heading"		=> esc_html__( 'Content', 'unilearn' ),
				"param_name"	=> "content",
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
	    class WPBakeryShortCode_CWS_Sc_Pricing_Plan extends WPBakeryShortCode {
	    }
	}
?>