<?php
	// Map Shortcode in Visual Composer
	$font_options = function_exists( 'unilearn_get_option' ) ? unilearn_get_option( 'body_font' ) : array();
	$font_color = isset( $font_options['color'] ) ? $font_options['color'] : "";
	vc_map( array(
		"name"				=> esc_html__( 'CWS Button', 'unilearn' ),
		"base"				=> "cws_sc_button",
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
				"heading"		=> esc_html__( 'Link', 'unilearn' ),
				"param_name"	=> "url",
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "new_tab",
				"value"			=> array( esc_html__( 'Open in New Tab', 'unilearn' ) => true )
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Size', 'unilearn' ),
				"param_name"	=> "size",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"value"			=> array(
					esc_html__( 'Regular', 'unilearn' )		=> 'regular',
					esc_html__( 'Mini', 'unilearn' )		=> 'mini',
					esc_html__( 'Small', 'unilearn' )		=> 'small',
					esc_html__( 'Large', 'unilearn' )		=> 'large'
				) 
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Left/Right Padding', 'unilearn' ),
				"param_name"	=> "ofs",
				"group"			=> esc_html__( "Styling", "unilearn" ),
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
				"param_name"	=> "fw",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"value"			=> array( esc_html__( 'Full Width', 'unilearn' ) => true )
			),
			array(
				"type"			=> "iconpicker",
				"heading"		=> esc_html__( 'Icon', 'unilearn' ),
				"param_name"	=> "icon",
				"value"			=> ""
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
				"param_name"	=> "alt",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"value"			=> array( esc_html__( 'Alternative', 'unilearn' ) => true )
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize_colors",
				"group"			=> esc_html__( "Styling", "unilearn" ),
				"value"			=> array( esc_html__( 'Customize Colors', 'unilearn' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Custom Color', 'unilearn' ),
				"param_name"	=> "custom_color",
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
				"value"			=> $font_color
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
	    class WPBakeryShortCode_CWS_Sc_Button extends WPBakeryShortCode {
	    }
	}
?>