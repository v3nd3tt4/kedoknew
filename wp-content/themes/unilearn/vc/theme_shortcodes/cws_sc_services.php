<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Services Column', 'unilearn' ),
		"base"				=> "cws_sc_services",
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
				"type"			=> "iconpicker",
				"heading"		=> esc_html__( 'Icon', 'unilearn' ),
				"param_name"	=> "icon",
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize_colors",
				"value"			=> array( esc_html__( 'Customize Colors', 'unilearn' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Primary Color', 'unilearn' ),
				"param_name"	=> "primary_color",
				"dependency"	=> array(
					"element"	=> "customize_colors",
					"not_empty"	=> true
				),
				"value"			=> UNILEARN_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Secondary Color', 'unilearn' ),
				"param_name"	=> "secondary_color",
				"dependency"	=> array(
					"element"	=> "customize_colors",
					"not_empty"	=> true
				),
				"value"			=> "#fff"
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "add_button",
				"value"			=> array( esc_html__( 'Add Button', 'unilearn' ) => true )
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Button Text', 'unilearn' ),
				"param_name"	=> "button_text",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "textfield",
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
				"type"				=> "textfield",
				"heading"			=> esc_html__( 'Extra class name', 'unilearn' ),
				"description"		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'unilearn' ),
				"param_name"		=> "el_class",
				"value"				=> ""
			),			
			array(
				"type"			=> "textarea_html",
				"heading"		=> esc_html__( 'Description', 'unilearn' ),
				"param_name"	=> "content",
			)
		)
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Services extends WPBakeryShortCode {
	    }
	}
?>