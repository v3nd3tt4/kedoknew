<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Call To Action', 'unilearn' ),
		"base"				=> "cws_sc_call_to_action",
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
				"type"			=> "textarea",
				"heading"		=> esc_html__( 'Text', 'unilearn' ),
				"param_name"	=> "text",
			),
			array(
				"type"			=> "iconpicker",
				"heading"		=> esc_html__( 'Icon', 'unilearn' ),
				"param_name"	=> "icon",
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize_colors",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"value"			=> array( esc_html__( 'Customize Colors', 'unilearn' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Background Color', 'unilearn' ),
				"param_name"	=> "bg_color",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"dependency"	=> array(
					"element"	=> "customize_colors",
					"not_empty"	=> true
				),
				"value"			=> UNILEARN_THEME_FOOTER_BG_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Font Color', 'unilearn' ),
				"param_name"	=> "font_color",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"dependency"	=> array(
					"element"	=> "customize_colors",
					"not_empty"	=> true
				),
				"value"			=> "#fff"
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Icon Color', 'unilearn' ),
				"param_name"	=> "icon_color",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"dependency"	=> array(
					"element"	=> "customize_colors",
					"not_empty"	=> true
				),
				"value"			=> UNILEARN_THEME_2_COLOR
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "use_bg_img",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"value"			=> array( esc_html__( 'Use Background Image', 'unilearn' ) => true )
			),
			array(
				"type"			=> "attach_image",
				"heading"		=> esc_html__( 'Background Image', 'unilearn' ),
				"param_name"	=> "bg_img",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"dependency"	=> array(
					"element"	=> "use_bg_img",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Background Image Size', 'unilearn' ),
				"param_name"	=> "bg_size",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"dependency"	=> array(
					"element"	=> "use_bg_img",
					"not_empty"	=> true
				),
				"value"		=> array(
					esc_html__( 'Auto', 'unilearn' ) => 'auto',
					esc_html__( 'Cover', 'unilearn' ) => 'cover',
					esc_html__( 'Contain', 'unilearn' ) => 'contain',					
				)
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Background Image Repeat', 'unilearn' ),
				"param_name"	=> "bg_repeat",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"dependency"	=> array(
					"element"	=> "use_bg_img",
					"not_empty"	=> true
				),
				"value"		=> array(
					esc_html__( 'No Repeat', 'unilearn' ) 	=> 'repeat',
					esc_html__( 'Repeat', 'unilearn' ) 		=> 'no-repeat'				
				)
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Background Image Position', 'unilearn' ),
				"param_name"	=> "bg_pos",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"dependency"	=> array(
					"element"	=> "use_bg_img",
					"not_empty"	=> true
				),
				"value"		=> array(
					esc_html__( 'Left Top', 'unilearn' ) 		=> 'left top',
					esc_html__( 'Top Center', 'unilearn' ) 		=> 'top center',
					esc_html__( 'Top Right', 'unilearn' ) 		=> 'top right',
					esc_html__( 'Left Center', 'unilearn' ) 	=> 'left center',			
					esc_html__( 'Center Center', 'unilearn' ) 	=> 'center center',
					esc_html__( 'Right Center', 'unilearn' ) 	=> 'right center',
					esc_html__( 'Left Bottom', 'unilearn' ) 	=> 'left bottom',
					esc_html__( 'Bottom Center', 'unilearn' ) 	=> 'bottom center',	
					esc_html__( 'Right Bottom', 'unilearn' ) 	=> 'right bottom'				
				)
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "color_over_img",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"value"			=> array( esc_html__( 'Color Over Image', 'unilearn' ) => true )
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
				"group"			=> esc_html__( "Button Settings", "unilearn" ),
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Button Url', 'unilearn' ),
				"param_name"	=> "button_url",
				"group"			=> esc_html__( "Button Settings", "unilearn" ),
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				)
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_new_tab",
				"group"			=> esc_html__( "Button Settings", "unilearn" ),
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
				"group"			=> esc_html__( "Button Settings", "unilearn" ),
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
				"type"			=> "iconpicker",
				"heading"		=> esc_html__( 'Button Icon', 'unilearn' ),
				"param_name"	=> "button_icon",
				"group"			=> esc_html__( "Button Settings", "unilearn" ),
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),				
				"value"			=> ""
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Button Icon Position', 'unilearn' ),
				"param_name"	=> "button_icon_pos",
				"group"			=> esc_html__( "Button Settings", "unilearn" ),
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),				
				"value"			=> array(
					esc_html__( 'Left', 'unilearn' )		=> 'left',
					esc_html__( 'Right', 'unilearn' )		=> 'right'
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
	    class WPBakeryShortCode_CWS_Sc_Call_To_Action extends WPBakeryShortCode {
	    }
	}
?>