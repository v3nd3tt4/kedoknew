<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Icon', 'unilearn' ),
		"base"				=> "cws_sc_icon",
		'category'			=> "Unilearn Theme Shortcodes",
		// "icon"				=> "boc_spacing",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "iconpicker",
				// "hasSearch"		=> false,
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Icon', 'unilearn' ),
				"param_name"	=> "icon",
				"value"			=> ""
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Link', 'unilearn' ),
				"param_name"	=> "url",
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "new_tab",
				"value"			=> array( esc_html__( 'Open in New Tab', 'unilearn' ) => true )
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Title', 'unilearn' ),
				"param_name"	=> "title",
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Type', 'unilearn' ),
				"param_name"	=> "type",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"value"			=> array(
					esc_html__( 'Simple', 'unilearn' )			=> 'simple',
					esc_html__( 'Bordered', 'unilearn' )		=> 'bordered',
					esc_html__( 'Alternative', 'unilearn' )		=> 'alt'
				) 
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Shape', 'unilearn' ),
				"param_name"	=> "shape",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"dependency"	=> array(
									"element"	=> "type",
									"value"		=> array( "bordered", "alt" )
								),
				"value"			=> array(
					esc_html__( 'Square', 'unilearn' ) => 'square',
					esc_html__( 'Round', 'unilearn' ) => 'round'
				) 
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Size', 'unilearn' ),
				"param_name"	=> "size",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"value"			=> array(
					esc_html__( 'Small', 'unilearn' )		=> '2x',
					esc_html__( 'Mini', 'unilearn' )		=> 'lg',
					esc_html__( 'Medium', 'unilearn' )		=> '3x',
					esc_html__( 'Large', 'unilearn' )		=> '4x',
					esc_html__( 'Extra Large', 'unilearn' )	=> '5x'
				) 
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Aligning', 'unilearn' ),
				"param_name"	=> "aligning",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"value"			=> array(
					esc_html__( 'None', 'unilearn' )		=> '',
					esc_html__( 'Left', 'unilearn' )		=> 'left',
					esc_html__( 'Right', 'unilearn' )		=> 'right',
					esc_html__( 'Center', 'unilearn' )		=> 'center'
				) 
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "add_hover",
				"value"			=> array( esc_html__( 'Add Hover', 'unilearn' ) => true )				
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize_colors",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"value"			=> array( esc_html__( 'Customize Colors', 'unilearn' ) => true )				
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Fill Color', 'unilearn' ),
				"param_name"	=> "fill_color",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"dependency"	=> array(
					"element"	=> "customize_colors",
					"not_empty"	=> true
				),
				"value"			=> "#fff"
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
	    class WPBakeryShortCode_CWS_Sc_Icon extends WPBakeryShortCode {
	    }
	}
?>