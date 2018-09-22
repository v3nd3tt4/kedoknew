<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Testimonial', 'unilearn' ),
		"base"				=> "cws_sc_vc_testimonial",
		'category'			=> "Unilearn Theme Shortcodes",
		// "icon"				=> "boc_spacing",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "textarea",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Quote', 'unilearn' ),
				"param_name"	=> "quote",
			),
			array(
				"type"			=> "attach_image",
				"heading"		=> esc_html__( 'Thumbnail', 'unilearn' ),
				"param_name"	=> "thumbnail",
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Author Name', 'unilearn' ),
				"param_name"	=> "author_name",
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Author Status', 'unilearn' ),
				"param_name"	=> "author_status",
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
	    class WPBakeryShortCode_CWS_Sc_Testimonial extends WPBakeryShortCode {
	    }
	}
?>