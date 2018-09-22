<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Banner', 'unilearn' ),
		"base"				=> "cws_sc_banner",
		'category'			=> "Unilearn Theme Shortcodes",
		// "icon"				=> "boc_spacing",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Url', 'unilearn' ),
				"param_name"	=> "url",
			),
			array(
				"type"			=> "textarea",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Title', 'unilearn' ),
				"param_name"	=> "title",
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Offer', 'unilearn' ),
				"param_name"	=> "offer",
			),
			array(
				"type"			=> "iconpicker",
				"heading"		=> esc_html__( 'Icon', 'unilearn' ),
				"param_name"	=> "icon",
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Icon Position', 'unilearn' ),
				"param_name"	=> "icon_pos",
				"value"			=> array(
					esc_html__( 'Right', 'unilearn' )		=> 'right',
					esc_html__( 'Left', 'unilearn' )		=> 'left'
				) 
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
				"value"			=> UNILEARN_THEME_COLOR
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
				"value"			=> UNILEARN_THEME_COLOR
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
				"type"				=> "textfield",
				"heading"			=> esc_html__( 'Extra class name', 'unilearn' ),
				"description"		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'unilearn' ),
				"param_name"		=> "el_class",
				"value"				=> ""
			)
		)
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Banner extends WPBakeryShortCode {
	    }
	}
?>