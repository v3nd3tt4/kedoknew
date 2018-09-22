<?php

function cwsfw_get_sections() {
	$settings = array(
		'header_options' => array(
			'type' => 'section',
			'title' => esc_html__( 'Header', 'unilearn' ),
			'icon' => array('fa', 'header'),
			'active' => true, // true by default
			'layout' => array(
				'header_options' => array(
					'type' => 'tab',
					'init' => 'open',
					'icon' => array('fa', 'header'),
					'title' => esc_html__( 'General', 'unilearn' ),
					'layout' => array(
						'page_title_spacings' => array(
							'title' => esc_html__( 'Page Title Spacings', 'unilearn' ),
							'type' => 'margins',
							'value' => array(
								'top' => array('placeholder' => esc_html__( 'Top', 'unilearn' ), 'value' => '30px'),
								'left' => array('placeholder' => esc_html__( 'left', 'unilearn' ), 'value' => '0px'),
								'right' => array('placeholder' => esc_html__( 'Right', 'unilearn' ), 'value' => '0px'),
								'bottom' => array('placeholder' => esc_html__( 'Bottom', 'unilearn' ), 'value' => '80px'),
							),
						),
						'default_header_image'	=> array(
							'title'	=> esc_html__( 'Header Image', 'unilearn' ),
							'type'	=> 'media'
						),
						'header_bg_color' => array(
							'title' 		=> esc_html__( 'Header Background Color', 'unilearn' ),
							'atts' 			=> 'data-default-color="' . UNILEARN_THEME_HEADER_BG_COLOR . '"',
							'addrowclasses' => 'grid-col-6',
							'type' 			=> 'text',
							'value'			=> UNILEARN_THEME_HEADER_BG_COLOR
						),
						'header_font_color' => array(
							'title' 			=> esc_html__( 'Top Bar Text and Breadcrumbs Color', 'unilearn' ),							
							'atts' 				=> 'data-default-color="' . UNILEARN_THEME_HEADER_FONT_COLOR . '"',
							'addrowclasses' 	=> 'grid-col-6',
							'type' 				=> 'text',
							'value'				=> 	UNILEARN_THEME_HEADER_FONT_COLOR
						),
						'header_covers_slider' => array(
							'title' => esc_html__( 'Header Overlays Slider', 'unilearn' ),
							'type' => 'checkbox',
							'addrowclasses' => 'checkbox grid-col-12'
						),
					)
				),
				'logo' => array(
					'type' => 'tab',
					'icon' => array('fa', 'check-square'),
					'title' => esc_html__( 'Logo', 'unilearn' ),
					'layout' => array(
						'logo' => array(
							'title' => esc_html__( 'Logo', 'unilearn' ),
							'type' => 'media',
							'url-atts' => 'readonly',
							'layout' => array(
								'is_high_dpi' => array(
									'title' => esc_html__( 'High-Resolution logo', 'unilearn' ),
									'type' => 'checkbox',
									'addrowclasses' => 'checkbox'
								),
							),
						),
						'logo_dims' => array(
							'title' => esc_html__( 'Dimensions', 'unilearn' ),
							'type' => 'dimensions',
							'value' => array(
								'width' => array('placeholder' => esc_html__( 'Width', 'unilearn' ), 'value' => '' ),
								'height' => array('placeholder' => esc_html__( 'Height', 'unilearn' ), 'value' => '72px' ),
								),
						),
						'logo_pos' => array(
							'title' => esc_html__( 'Position', 'unilearn' ),
							'type' => 'radio',
							'subtype' => 'images',
							'value' => array(
								'left' => array( esc_html__( 'Left', 'unilearn' ), 	true, '', get_template_directory_uri() . '/img/fw_img/align-left.png' ),
								'center' =>array( esc_html__( 'Center', 'unilearn' ), false, '', get_template_directory_uri() . '/img/fw_img/align-center.png' ),
								'right' =>array( esc_html__( 'Right', 'unilearn' ), false, '', get_template_directory_uri() . '/img/fw_img/align-right.png' ),
							),
						),
						'logo_margins' => array(
							'title' => esc_html__( 'Spacings', 'unilearn' ),
							'type' => 'margins',
							'value' => array(
								'top' => array('placeholder' => esc_html__( 'Top', 'unilearn' ), 'value' => '14px'),
								'left' => array('placeholder' => esc_html__( 'left', 'unilearn' ), 'value' => '0px'),
								'right' => array('placeholder' => esc_html__( 'Right', 'unilearn' ), 'value' => '0px'),
								'bottom' => array('placeholder' => esc_html__( 'Bottom', 'unilearn' ), 'value' => '14px'),
								),
						),
						'mobile_logo' => array(
							'title' => esc_html__( 'Mobile Logo', 'unilearn' ),
							'type' => 'media',
							'url-atts' => 'readonly',
							'layout' => array(
								'is_high_dpi' => array(
									'title' => esc_html__( 'High-Resolution Mobile logo', 'unilearn' ),
									'type' => 'checkbox',
									'addrowclasses' => 'checkbox'
								),
							),
						),
					)
				),
				'menu' => array(
					'type' => 'tab',
					'icon' => array( 'fa', 'list-alt' ),
					'title' => esc_html__( 'Menu', 'unilearn' ),
					'layout' => array(
						'menu_pos' => array(
							'title' => esc_html__( 'Menu Position', 'unilearn' ),
							'type' => 'radio',
							'subtype' => 'images',
							'value' => array(
								'left' => array( esc_html__( 'Left', 'unilearn' ), 	true, '', get_template_directory_uri() . '/img/fw_img/align-left.png' ),
								'center' =>array( esc_html__( 'Center', 'unilearn' ), false, '', get_template_directory_uri() . '/img/fw_img/align-center.png' ),
								'right' =>array( esc_html__( 'Right', 'unilearn' ), false, '', get_template_directory_uri() . '/img/fw_img/align-right.png' ),
							),
						),						
						'customize_menu' => array(
							'title' 		=> esc_html__( 'Customize Menu Colors & Opacity', 'unilearn' ),
							'type' 			=> 'checkbox',
							'addrowclasses' => 'checkbox',
							'atts' 			=> 'data-options="e:menu_opacity;e:menu_bg_color;e:menu_font_color;"',
						),
						'menu_opacity' => array(
							'title' 		=> esc_html__( 'Opacity', 'unilearn' ),
							'tooltip' => array(
								'title' => esc_html__( 'Header Opacity', 'unilearn' ),
								'content' => esc_html__( 'This option will apply the transparent header when set to "0".', 'unilearn' ),
							),								
							'type' 			=> 'number',
							'addrowclasses' => 'disable grid-col-4',
							'atts' 			=> " min='0' max='100'",
							'value'			=> '0'
						),
						'menu_bg_color' => array(
							'title' 		=> esc_html__( 'Background Color', 'unilearn' ),
							'tooltip' => array(
								'title' => esc_html__( 'Background Color', 'unilearn' ),
								'content' => esc_html__( 'This color is applied to header section including top bar.', 'unilearn' ),
							),							
							'type' 			=> 'text',
							'addrowclasses' => 'disable grid-col-4',
							'atts' 			=> 'data-default-color="' . UNILEARN_THEME_HEADER_BG_COLOR . '"',
							'value'			=> UNILEARN_THEME_HEADER_BG_COLOR
						),
						'menu_font_color' => array(
							'title' 		=> esc_html__( 'Override Font Color', 'unilearn' ),
							'tooltip' => array(
								'title' => esc_html__( 'Override Font Color', 'unilearn' ),
								'content' => esc_html__( 'This color is applied to main menu items only, submenus will use the color which is set in Typography section.<br /> This option is very useful when transparent menu is set.', 'unilearn' ),
							),							
							'type' 			=> 'text',
							'addrowclasses' => 'disable grid-col-4',
							'atts' 			=> 'data-default-color="#fff;"',
							'value'			=> '#fff'
						),
						'menu_stick' => array(
							'title' => esc_html__( 'Apply sticky menu', 'unilearn' ),
							'type' => 'checkbox',
							'addrowclasses' => 'checkbox grid-col-12',
							'atts' => 'data-options="e:sticky_logo;"',
						),
						'sticky_logo' => array(
							'title' => esc_html__( 'Sticky Logo', 'unilearn' ),
							'type' => 'media',
							'addrowclasses' => 'disable grid-col-12',
							'url-atts' => 'readonly',
							'layout' => array(
								'is_high_dpi' => array(
									'title' => esc_html__( 'High-Resolution Sticky logo', 'unilearn' ),
									'type' => 'checkbox',
									'addrowclasses' => 'checkbox'
								),
							),
						),
						'sandwich_menu' => array(
							'title' => esc_html__( 'Show sandwich menu', 'unilearn' ),
							'type' => 'checkbox',
							'addrowclasses' => 'checkbox grid-col-12'
						),
					)
				),
				'topbar' => array(
					'type' => 'tab',
					'icon' => array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'TopBar', 'unilearn' ),
					'layout' => array(
						'enable_top_panel' => array(
							'title' => esc_html__( 'Top Panel', 'unilearn' ),
							'type' => 'checkbox',
							'addrowclasses' => 'checkbox alt',
							'atts' => 'data-options="e:top_panel_text;e:is_top_panel_transparent;"',
							'value'	=> '1'
						),
						'top_panel_text' => array(
							'title' => esc_html__( 'Content', 'unilearn' ),
							'tooltip' => array(
								'title' => esc_html__( 'Indent Adjusting', 'unilearn' ),
								'content' => esc_html__( 'Adjust Indents by multiple spaces.<br /> Line breaks are working too.', 'unilearn' ),
							),
							'type' => 'textarea',
							'atts' => 'rows="5"',
						),
						'is_top_panel_transparent' => array(
							'title' => esc_html__( 'Transparent', 'unilearn' ),
							'type' => 'checkbox',
							'addrowclasses' => 'checkbox',
						)
					)
				)
			)
		),	// end of sections
		'footer_options' => array(
			'type' => 'section',
			'title' => esc_html__('Footer', 'unilearn' ),
			'icon' => array('fa', 'columns'),
			//'active' => true // true by default
			'layout' => array(
				'footer' => array(
					'type' => 'tab',
					'init' => 'open',
					'icon' => array( 'fa', 'fa-book' ),
					'title' => esc_html__( 'Footer', 'unilearn' ),
					'layout' => array(
						'footer_sb'			=> array(
							'title'			=> esc_html__( "Footer's widget area", 'unilearn' ),
							'tooltip' => array(
								'title' => esc_html__( 'Footer area', 'unilearn' ),
								'content' => esc_html__( 'This options will set the default Footer widget area, unless you override it on each page', 'unilearn' ),
							),							
							'type'			=> 'select',
							'source'		=> 'sidebars'
						),
						'footer_bg_color'	=> array(
							'title'				=> esc_html__( 'Background Color', 'unilearn' ),
							'atts'				=> 'data-default-color="' . UNILEARN_THEME_FOOTER_BG_COLOR . ';"',
							'addrowclasses' 	=> 'grid-col-4',
							'type'				=> 'text',
							'value'				=> UNILEARN_THEME_FOOTER_BG_COLOR
						),
						'footer_font_color' => array(
							'title' 			=> esc_html__( 'Font color', 'unilearn' ),
							'atts' 				=> 'data-default-color="#b0b0b0;"',
							'addrowclasses' 	=> 'grid-col-4',
							'type' 				=> 'text',
							'value'				=> '#b0b0b0'
						),
						'footer_title_color' => array(
							'title' 			=> esc_html__( 'Title color', 'unilearn' ),
							'atts' 				=> 'data-default-color="#fff;"',
							'addrowclasses' 	=> 'grid-col-4',
							'type' 				=> 'text',
							'value'				=> '#fff'
						),
						'copyrights_text'	=> array(
							'title'			=> esc_html__( "Copyrights content", 'unilearn' ),
							'type'			=> 'textarea',
							'addrowclasses' => 'grid-col-12',
							'atts' 			=> 'rows="5"',
							'value'			=> esc_html__( "Copyrights&#169;2016: UniLearn – Education and Courses WordPress Theme", 'unilearn' )
						),
						'copyrights_bg_color'	=> array(
							'title'					=> esc_html__( 'Copyrights Background Color', 'unilearn' ),
							'atts'					=> 'data-default-color="#23272c;"',
							'addrowclasses' 		=> 'grid-col-6',
							'type'					=> 'text',
							'value'					=> '#23272c'
						),
						'copyrights_font_color' => array(
							'title' 				=> esc_html__( 'Copyrights Font color', 'unilearn' ),
							'atts' 					=> 'data-default-color="#fff;"',
							'addrowclasses' 		=> 'grid-col-6',
							'type' 					=> 'text',
							'value'					=> '#fff'	
						),
					)
				)
			)
		),	// end of sections
		'layout_options' => array(
			'type' => 'section',
			'title' => esc_html__('Pages', 'unilearn' ),
			'icon' => array('fa', 'th'),
			//'active' => true // true by default
			'layout'	=> array(
				'homepage_options' => array(
					'type' => 'tab',
					'init' 			=> 'open',					
					'title' => esc_html__('Home', 'unilearn' ),
					'icon' => array('fa', 'calendar-plus-o'),
					'layout' => array(
						'home_slider_type' => array(
							'title' => esc_html__('Slider Settings', 'unilearn' ),
							'type' => 'radio',
							'value' => array(
								'none' => 	array( esc_html__('None', 'unilearn' ), true, 'd:home_slider_shortcode;d:video_section;d:static_img_section' ),
								'img_slider'=>	array( esc_html__('Image Slider', 'unilearn' ), false, 'e:home_slider_shortcode;d:video_section;d:static_img_section' ),
								'video_slider' => 	array( esc_html__('Video Slider', 'unilearn' ), false, 'd:home_slider_shortcode;e:video_section;d:static_img_section' ),
								'stat_img_slider' => 	array( esc_html__('Static image', 'unilearn' ), false, 'd:home_slider_shortcode;d:video_section;e:static_img_section' ),
							),
						),
						'home_slider_shortcode' => array(
							'title' => esc_html__( 'Slider', 'unilearn' ),
							'addrowclasses' => 'disable',
							'type' => 'text',
							'value' => '[rev_slider homepage]',
						),
						'video_section' => array(
							'title' => esc_html__( 'Video Slider Settings', 'unilearn' ),
							'type' => 'fields',
							'addrowclasses' => 'disable',
							'layout' => array(
								'slider_switch' => array(
									'type' => 'checkbox',
									'addrowclasses' => 'checkbox',
									'title' => esc_html__( 'Slider', 'unilearn' ),
									'atts' => 'data-options="e:slider_shortcode;d:set_video_header_height"',
								),
								'slider_shortcode' => array(
									'title' => esc_html__( 'Slider', 'unilearn' ),
									'addrowclasses' => 'disable',
									'type' => 'text',
								),
								'set_video_header_height' => array(
									'type' => 'checkbox',
									'addrowclasses' => 'checkbox',
									'title' => esc_html__( 'Set Video height', 'unilearn' ),
									'atts' => 'data-options="e:video_header_height"',
								),
								'video_header_height' => array(
									'title' => esc_html__( 'Video height', 'unilearn' ),
									'addrowclasses' => 'disable',
									'type' => 'number',
									'value' => '600',
								),
								'video_type' => array(
									'title' => esc_html__('Video type', 'unilearn' ),
									'type' => 'radio',
									'value' => array(
										'self_hosted' => 	array( esc_html__('Self-hosted', 'unilearn' ), true, 'e:sh_source;d:youtube_source;d:vimeo_source' ),
										'youtube'=>	array( esc_html__('Youtube clip', 'unilearn' ), false, 'd:sh_source;e:youtube_source;d:vimeo_source' ),
										'vimeo' => 	array( esc_html__('Vimeo clip', 'unilearn' ), false, 'd:sh_source;d:youtube_source;e:vimeo_source' ),
									),
								),
								'sh_source' => array(
									'title' => esc_html__( 'Add video', 'unilearn' ),
									'type' => 'media',
								),
								'youtube_source' => array(
									'title' => esc_html__( 'Youtube video code', 'unilearn' ),
									'addrowclasses' => 'disable',
									'type' => 'text',
								),
								'vimeo_source' => array(
									'title' => esc_html__( 'Vimeo embed url', 'unilearn' ),
									'addrowclasses' => 'disable',
									'type' => 'text',
								),
								'use_pattern' => array(
									'type' => 'checkbox',
									'addrowclasses' => 'checkbox',
									'title' => esc_html__( 'Add pattern', 'unilearn' ),
									'atts' => 'data-options="e:pattern_image"',
								),
								'pattern_image' => array(
									'title' => esc_html__( 'Pattern image', 'unilearn' ),
									'addrowclasses' => 'disable',
									'type' => 'media',
								),
								'overlay_type' => array(
									'title' => esc_html__( 'Overlay type', 'unilearn' ),
									'type' => 'radio',
									'subtype' => 'images',
									'value' => array(
										'none' => array( esc_html__( 'None', 'unilearn' ), 	true, 'd:overlay_color;d:overlay_gradient_settings;d:overlay_opacity;', get_template_directory_uri() . '/img/fw_img/align-left.png' ),
										'color' => array( esc_html__( 'Color', 'unilearn' ), 	false, 'e:overlay_color;d:overlay_gradient_settings;e:overlay_opacity;', get_template_directory_uri() . '/img/fw_img/align-left.png' ),
										'gradient' =>array( esc_html__( 'Gradient', 'unilearn' ), false, 'd:overlay_color;e:overlay_gradient_settings;e:overlay_opacity;', get_template_directory_uri() . '/img/fw_img/align-center.png' ),
									),
								),
								'overlay_color' => array(
									'title' => esc_html__( 'Overlay Color', 'unilearn' ),
									'atts' => 'data-default-color=""',
									'type' => 'text',
									'value'	=> ''
								),
								'overlay_opacity' => array(
									'type' => 'number',
									'title' => esc_html__( 'Opacity', 'unilearn' ),
									'placeholder' => esc_html__( 'In percents', 'unilearn' ),
									'value' => '40'
								),
								'overlay_gradient_settings' => array(
									'title' => esc_html__( 'Gradient settings', 'unilearn' ),
									'type' => 'fields',
									'addrowclasses' => 'disable',
									'layout' => array(
										'first_color' => array(
											'type' => 'text',
											'title' => esc_html__( 'From', 'unilearn' ),
											'atts' => 'data-default-color=""',
											'value'	=> ''
										),
										'second_color' => array(
											'type' => 'text',
											'title' => esc_html__( 'To', 'unilearn' ),
											'atts' => 'data-default-color=""',
											'value'	=> ''
										),
										'type' => array(
											'title' => esc_html__( 'Gradient type', 'unilearn' ),
											'type' => 'radio',
											'value' => array(
												'linear' => array( esc_html__( 'Linear', 'unilearn' ),  true, 'e:angle;d:shape_settings' ),
												'radial' =>array( esc_html__( 'Radial', 'unilearn' ), false,  'd:angle;e:shape_settings' ),
											),
										),
										'angle' => array(
											'type' => 'number',
											'title' => esc_html__( 'Angle', 'unilearn' ),
											'value' => '45',
										),
										'shape_settings' => array(
											'title' => esc_html__( 'Gradient type', 'unilearn' ),
											'type' => 'radio',
											'addrowclasses' => 'disable',
											'value' => array(
												'simple' => array( esc_html__( 'Simple', 'unilearn' ),  true, 'e:shape;d:size_keyword;d:size' ),
												'extended' =>array( esc_html__( 'Extended', 'unilearn' ), false, 'd:shape;e:size_keyword;e:size' ),
											),
										),
										'shape' => array(
											'title' => esc_html__( 'Gradient type', 'unilearn' ),
											'type' => 'radio',
											'addrowclasses' => 'disable',
											'value' => array(
												'ellipse' => array( esc_html__( 'Ellipse', 'unilearn' ),  true ),
												'circle' =>array( esc_html__( 'Circle', 'unilearn' ), false ),
											),
										),
										'size_keyword' => array(
											'type' => 'select',
											'title' => esc_html__( 'Size keyword', 'unilearn' ),
											'addrowclasses' => 'disable',
											'source' => array(
												'closest-side' => array(esc_html__( 'Closest side', 'unilearn' ), false),
												'farthest-side' => array(esc_html__( 'Farthest side', 'unilearn' ), false),
												'closest-corner' => array(esc_html__( 'Closest corner', 'unilearn' ), false),
												'farthest-corner' => array(esc_html__( 'Farthest corner', 'unilearn' ), true),
											),
										),
										'size' => array(
											'type' => 'text',
											'addrowclasses' => 'disable',
											'title' => esc_html__( 'Size', 'unilearn' ),
											'atts' => 'placeholder="'.esc_html__( 'Two space separated percent values, for example (60% 55%)', 'unilearn' ).'"',
										),
									),
								),
							),
						),// end of video-section
						'static_img_section' => array(
							'title' => esc_html__( 'Static image', 'unilearn' ),
							'type' => 'fields',
							'addrowclasses' => 'disable',
							'layout' => array(
								'static_img' => array(
									'title' => esc_html__( 'Select an image', 'unilearn' ),
									'type' => 'media',
									'url-atts' => 'readonly',
								),
							),
						),// end of static img slider-section
						'def-home-layout' => array(
							'title' 			=> esc_html__('Sidebar Position', 'unilearn' ),
							'type' 				=> 'radio',
							'subtype' 			=> 'images',
							'value' 			=> array(
								'left' 				=> 	array( esc_html__('Left', 'unilearn' ), false, 'e:def-home-sidebar1;d:def-home-sidebar2;',	get_template_directory_uri() . '/img/fw_img/left.png' ),
								'right' 			=> 	array( esc_html__('Right', 'unilearn' ), false, 'e:def-home-sidebar1;d:def-home-sidebar2;', get_template_directory_uri() . '/img/fw_img/right.png' ),
								'both' 				=> 	array( esc_html__('Both', 'unilearn' ), false, 'e:def-home-sidebar1;e:def-home-sidebar2;', get_template_directory_uri() . '/img/fw_img/both.png' ),
								'none' 				=> 	array( esc_html__('None', 'unilearn' ), true, 'd:def-home-sidebar1;d:def-home-sidebar2;', get_template_directory_uri() . '/img/fw_img/none.png' )
							),
						),
						'def-home-sidebar1' => array(
							'title' 		=> esc_html__('Sidebar', 'unilearn' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						),
						'def-home-sidebar2' => array(
							'title' 		=> esc_html__('Right sidebar', 'unilearn' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						)
					)
				),
				'page'		=> array(
					'type'			=> 'tab',
					'customizer' 	=> array( 'show' => false ),
					'icon' 			=> array( 'fa', 'calendar-plus-o' ),
					'title' 		=> esc_html__( 'Page', 'unilearn' ),
					'layout'		=> array(
						'def-page-layout' => array(
							'title' 			=> esc_html__('Sidebar Position', 'unilearn' ),
							'type' 				=> 'radio',
							'subtype' 			=> 'images',
							'value' 			=> array(
								'left' 				=> 	array( esc_html__('Left', 'unilearn' ), false, 'e:def-page-sidebar1;d:def-page-sidebar2;',	get_template_directory_uri() . '/img/fw_img/left.png' ),
								'right' 			=> 	array( esc_html__('Right', 'unilearn' ), true, 'e:def-page-sidebar1;d:def-page-sidebar2;', get_template_directory_uri() . '/img/fw_img/right.png' ),
								'both' 				=> 	array( esc_html__('Both', 'unilearn' ), false, 'e:def-page-sidebar1;e:def-page-sidebar2;', get_template_directory_uri() . '/img/fw_img/both.png' ),
								'none' 				=> 	array( esc_html__('None', 'unilearn' ), false, 'd:def-page-sidebar1;d:def-page-sidebar2;', get_template_directory_uri() . '/img/fw_img/none.png' )
							),
						),
						'def-page-sidebar1' => array(
							'title' 		=> esc_html__('Sidebar', 'unilearn' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						),
						'def-page-sidebar2' => array(
							'title' 		=> esc_html__('Right sidebar', 'unilearn' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						),
					)
				),
				'blog' => array(
					'type' => 'tab',
					'icon' => array( 'fa', 'fa-book' ),
					'title' => esc_html__( 'Blog', 'unilearn' ),
					'layout' => array(
						'def-blog-layout' => array(
							'title' 			=> esc_html__('Sidebar Position', 'unilearn' ),
							'type' 				=> 'radio',
							'subtype' 			=> 'images',
							'value' 			=> array(
								'left' 				=> 	array( esc_html__('Left', 'unilearn' ), false, 'e:def-blog-sidebar1;d:def-blog-sidebar2;',	get_template_directory_uri() . '/img/fw_img/left.png' ),
								'right' 			=> 	array( esc_html__('Right', 'unilearn' ), false, 'e:def-blog-sidebar1;d:def-blog-sidebar2;', get_template_directory_uri() . '/img/fw_img/right.png' ),
								'both' 				=> 	array( esc_html__('Both', 'unilearn' ), false, 'e:def-blog-sidebar1;e:def-blog-sidebar2;', get_template_directory_uri() . '/img/fw_img/both.png' ),
								'none' 				=> 	array( esc_html__('None', 'unilearn' ), true, 'd:def-blog-sidebar1;d:def-blog-sidebar2;', get_template_directory_uri() . '/img/fw_img/none.png' )
							),
						),
						'def-blog-sidebar1' => array(
							'title' 		=> esc_html__('Sidebar', 'unilearn' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						),
						'def-blog-sidebar2' => array(
							'title' 		=> esc_html__('Right sidebar', 'unilearn' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						),
						'def_blog_layout'	=> array(
							'title'		=> esc_html__( 'Blog Layout', 'unilearn' ),
							'type'		=> 'radio',
							'subtype' 	=> 'images',
							'value' 	=> array(
								'1' 		=> array( esc_html__('Wide', 'unilearn' ), true, '', get_template_directory_uri() . '/img/fw_img/large.png'),
								'medium' 	=> array( esc_html__('Medium', 'unilearn' ), false, '', get_template_directory_uri() . '/img/fw_img/medium.png'),
								'small' 	=> array( esc_html__('Small', 'unilearn' ), false, '', get_template_directory_uri() . '/img/fw_img/small.png'),
								'2' 		=> array( esc_html__('2 Cols', 'unilearn' ), false, '', get_template_directory_uri() . '/img/fw_img/pinterest_2_columns.png'),
								'3'			=> array( esc_html__('3 Cols', 'unilearn' ), false, '', get_template_directory_uri() . '/img/fw_img/pinterest_3_columns.png'),
							),
						),
						'def_post_hide_meta'	=> array(
							'title'		=> esc_html__( 'Hide Post Meta', 'unilearn' ),
							'desc'	=> esc_html__( 'Properties specified here were hidden in post grid by default', 'unilearn' ),
							'type'	=> 'select',
							'atts'	=> 'multiple',
							'source'	=> array(
								'date'		=> array( esc_html__( 'Date', 'unilearn' ), false ),
								'post_info'	=> array( esc_html__( 'Post Info', 'unilearn' ), false ),
								'comments'	=> array( esc_html__( 'Comments', 'unilearn' ), false ),
								'read_more'	=> array( esc_html__( 'Read More', 'unilearn' ), false ),
								'terms'		=> array( esc_html__( 'Terms', 'unilearn' ), false ),
							),
						)
					)
				),
				'portfolio' => array(
					'type' => 'tab',
					'icon' => array( 'fa', 'fa-picture-o' ),
					'title' => esc_html__( 'Portfolio', 'unilearn' ),
					'layout' => array(
						'def_cws_portfolio_layout'	=> array(
							'title'		=> esc_html__( 'Layout', 'unilearn' ),
							'type'		=> 'radio',
							'subtype' => 'images',
							'value' => array(
								'1' => array( esc_html__('Wide', 'unilearn' ), false, '', get_template_directory_uri() . '/img/fw_img/large.png'),
								'2' => array( esc_html__('2 Cols', 'unilearn' ), false, '', get_template_directory_uri() . '/img/fw_img/pinterest_2_columns.png'),
								'3' => array( esc_html__('3 Cols', 'unilearn' ), false, '', get_template_directory_uri() . '/img/fw_img/pinterest_3_columns.png'),
								'4' => array( esc_html__('4 Cols', 'unilearn' ), true, '', get_template_directory_uri() . '/img/fw_img/pinterest_4_columns.png'),
							),
						),
						'def_cws_portfolio_data_to_show'	=> array(
							'title'		=> esc_html__( 'Show Meta Data', 'unilearn' ),
							'type'		=> 'select',
							'atts'		=> 'multiple',
							'source'		=> array(
									'title'		=> array( esc_html__( 'Title', 'unilearn' ), true ),
									'excerpt'	=> array( esc_html__( 'Excerpt', 'unilearn' ), true ),
									'cats'		=> array( esc_html__( 'Categories', 'unilearn' ), true )
							)
						),
						'portfolio_slug' => array(
							'type' 	=> 'text',
							'title' => esc_html__( 'Slug', 'unilearn' ),
							'value'	=> 'portfolio'
						)
					)
				),
				'staff' => array(
					'type' => 'tab',
					'icon' => array( 'fa', 'fa-picture-o' ),
					'title' => esc_html__( 'Staff', 'unilearn' ),
					'layout' => array(
						'def_cws_staff_layout'	=> array(
							'title'		=> esc_html__( 'Layout', 'unilearn' ),
							'type'		=> 'radio',
							'subtype' 	=> 'images',
							'value' 	=> array(
								'1' 		=> array( esc_html__('1 Col', 'unilearn' ), false, '', get_template_directory_uri() . '/img/fw_img/large.png'),
								'2' 		=> array( esc_html__('2 Cols', 'unilearn' ), true, '', get_template_directory_uri() . '/img/fw_img/pinterest_2_columns.png')
							),
						),
						'def_cws_staff_data_to_hide'	=> array(
							'title'		=> esc_html__( 'Hide Meta Data', 'unilearn' ),
							'type'		=> 'select',
							'atts'		=> 'multiple',
							'source'		=> array(
								'department'	=> array( esc_html__( 'Departments', 'unilearn' ), false ),
								'position'		=> array( esc_html__( 'Positions', 'unilearn' ), false )
							)
						),
						'staff_slug' => array(
							'type' 	=> 'text',
							'title' => esc_html__( 'Slug', 'unilearn' ),
							'value'	=> 'staff'
						)
					)
				),
				'sidebars' => array(
					'type' => 'tab',
					'customizer' => array('show' => false),
					'icon' => array('fa', 'calendar-plus-o'),
					'title' => esc_html__( 'Sidebars', 'unilearn' ),
					'layout' => array(
						'sidebars' => array(
							'type' => 'group',
							'addrowclasses' => 'group single_field',
							'title' => esc_html__('Sidebar generator', 'unilearn' ),
							'button_title' => esc_html__('Add new sidebar', 'unilearn' ),
							'layout' => array(
								'title' => array(
									'type' => 'text',
									'atts' => 'data-role="title"',
									'title' => esc_html__('Sidebar', 'unilearn' ),
								)
							)
						)
					)
				)
			)
		),
		'styling_options' => array(
			'type' => 'section',
			'title' => esc_html__('Layout', 'unilearn' ),
			'icon' => array('fa', 'paint-brush'),
			'layout' => array(
			'styling_options_color' => array(
					'type' => 'tab',
					'icon' => array('fa', 'calendar-plus-o'),
					'init' => 'open',
					'title' => esc_html__( 'Theme Colors', 'unilearn' ),
					'layout' => array(
						'theme_color' => array(
							'title' => esc_html__( 'Main Color', 'unilearn' ),
							'atts' => 'data-default-color="' . UNILEARN_THEME_COLOR . '"',
							'addrowclasses' => 'grid-col-4',
							'type' => 'text',
							'value'	=> UNILEARN_THEME_COLOR
						),
						'theme_2_color' => array(
							'title' => esc_html__( 'Secondary Color', 'unilearn' ),
							'atts' => 'data-default-color="' . UNILEARN_THEME_2_COLOR . '"',
							'addrowclasses' => 'grid-col-4',
							'type' => 'text',
							'value'	=> UNILEARN_THEME_2_COLOR
						),
						'theme_3_color' => array(
							'title' => esc_html__( 'Additional Color', 'unilearn' ),
							'atts' => 'data-default-color="' . UNILEARN_THEME_3_COLOR . '"',
							'addrowclasses' => 'grid-col-4',
							'type' => 'text',
							'value'	=> UNILEARN_THEME_3_COLOR
						),
						'boxed_layout'	=> array(
							'title'	=> esc_html__( 'Apply Boxed Layout', 'unilearn' ),
							'type'	=> 'checkbox',
							'atts' => 'data-options="e:url_background;"',
							'addrowclasses' => 'checkbox alt grid-col-12'		
						),	
						'url_background' => array(
					       'title' => esc_html__( 'Background Settings', 'unilearn' ),
					       'type' => 'info',
					       'subtype'	=> 'link',
					       'addrowclasses' => 'disable grid-col-12',
					       'value' => '<a href="themes.php?page=custom-background" target="_blank">'.esc_html__('Click this link to customize your background settings','unilearn').'</a>',
					    ),	
					),
				),
			),
		),
		'typography' => array(
			'type' => 'section',
			'title' => esc_html__('Typography', 'unilearn' ),
			'icon' => array('fa', 'font'),
			'layout' => array(
				'menu_font_options' => array(
					'type' => 'tab',
					'init' => 'open',
					'icon' => array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Menu', 'unilearn' ),
					'layout' => array(
						'menu_font' => array(
							'title' => esc_html__('Menu Font', 'unilearn' ),
							'type' => 'font',
							'font-color' => true,
							'font-size' => true,
							'font-sub' => true,
							'line-height' => true,
							'value' => array(
								'font-size' => '14px',
								'line-height' => '36px',
								'color' => '#5f5f5f',
								'font-family' => 'Raleway',
								'font-weight' => array( '500' ),
								'font-sub' => array('latin'),
							)
						)
					)
				),
				'header_font_options' => array(
					'type' => 'tab',
					'icon' => array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Header', 'unilearn' ),
					'layout' => array(
						'header_font' => array(
							'title' => esc_html__('Header\'s Font', 'unilearn' ),
							'type' => 'font',
							'font-color' => true,
							'font-size' => true,
							'font-sub' => true,
							'line-height' => true,
							'value' => array(
								'font-size' => '28px',
								'line-height' => '39px',
								'color' => '#333333',
								'font-family' => 'Merriweather',
								'font-weight' => array( '400', '300', '700' ),
								'font-sub' => array('latin'),
							),
						)
					)
				),
				'body_font_options' => array(
					'type' => 'tab',
					'icon' => array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Content', 'unilearn' ),
					'layout' => array(
						'body_font' => array(
							'title' => esc_html__('Content Font', 'unilearn' ),
							'type' => 'font',
							'font-color' => true,
							'font-size' => true,
							'font-sub' => true,
							'line-height' => true,
							'value' => array(
								'font-size' => '15px',
								'line-height' => '24px',
								'color' => '#545454',
								'font-family' => 'Raleway',
								'font-weight' => array( '300', '400', '500', '600', '700' ),
								'font-sub' => array('latin'),
							)
						)
					)
				)
			)
		), // end of sections
		'social_options' => array(
			'type' => 'section',
			'title' => esc_html__('Socials', 'unilearn' ),
			'icon' => array('fa', 'share-alt'),
			'layout' => array(
				'social_options'	=> array(
					'type' => 'tab',
					'init'	=> 'open',
					'icon' => array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Socials', 'unilearn' ),
					'layout' => array(
						'social_location' => array(
							'type' => 'select',
							'title' => esc_html__( 'Icon Location', 'unilearn' ),
							'source' => array(
								'top' => array( esc_html__( 'Top Panel', 'unilearn' ), true),
								'bottom' => array( esc_html__( 'Footer', 'unilearn' ), false),
								'both' => array( esc_html__( 'Both', 'unilearn' ), false)
							)
						),
						'social_group' => array(
							'type' => 'group',
							'addrowclasses' => 'group sortable',
							'title' => esc_html__('Social Networks', 'unilearn' ),
							'button_title' => esc_html__('Add new social network', 'unilearn' ),
							'layout' => array(
								'title' => array(
									'type' => 'text',
									'atts' => 'data-role="title"',
									'title' => esc_html__('Social account title', 'unilearn' ),
								),
								'icon' => array(
									'type' => 'select',
									'addrowclasses' => 'fai',
									'source' => 'fa',
									'title' => esc_html__('Select the icon for this social contact', 'unilearn' )
								),
								'url' => array(
									'type' => 'text',
									'title' => esc_html__('Url to your account', 'unilearn' ),
								)
							)
						)
					)
				)
			)
		),
		'maintenance' => array(
			'type' => 'section',
			'title' => esc_html__( 'Help & Maintenance', 'unilearn' ),
			'icon' => array('fa', 'life-ring'),
			'layout' => array(
				'maintenance'	=> array(
					'type' => 'tab',
					'init'	=> 'open',
					'icon' => array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Maintenance', 'unilearn' ),
					'layout' => array(
						'_theme_purchase_code' => array(
							'title' => esc_html__( 'Item Purchase Code', 'unilearn' ),
							'tooltip' => array(
								'title' => esc_html__( 'Item Purchase Code', 'unilearn' ),
								'content' => esc_html__( 'Fill in this field with your Item Purchase Code in order to get the demo content and further theme updates.<br/> Please note, this code is applied to the theme only, it will not register Revolution Slider or any other plugins.', 'unilearn' ),
							),													
							'type' 	=> 'text',
							'value' => 'abcd1234-ab12-cwst-13en-vatoelements'
						),
						'help' => array(
					       'title' 			=> esc_html__( 'Help', 'unilearn' ),
					       'type' 			=> 'info',
					       'addrowclasses'	=> 'grid-col-12',
					       'subtype'		=> 'custom',
					       'value' 			=> '<a class="cwsfw_info_button" href="http://unilearn.cwsthemes.com/manual" target="_blank"><i class="fa fa-life-ring"></i>&nbsp;&nbsp;' . esc_html__( 'Online Tutorial', 'unilearn' ) . '</a>&nbsp;&nbsp;<a class="cwsfw_info_button" href="https://www.youtube.com/user/cwsvideotuts/playlists" target="_blank"><i class="fa fa-video-camera"></i>&nbsp;&nbsp;' . esc_html__( 'Video Tutorial', 'unilearn' ) . '</a>',
					    ),
					)
				)
			)
		)	
	);
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )  {
		$settings['woo_options'] = array(
			'type'		=> 'section',
			'title'		=> esc_html__( 'WooCommerce', 'unilearn' ),
			'icon'		=> array('fa', 'shopping-cart'),
			'layout'	=> array(
				'woo_options' => array(
					'type' 	=> 'tab',
					'init'	=> 'open',
					'icon' 	=> array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Woocommerce', 'unilearn' ),
					'layout' => array(
						'woo_cart_enable'	=> array(
							'title'			=> esc_html__( 'Show WooCommerce Cart', 'unilearn' ),
							'type'			=> 'checkbox',
							'addrowclasses'	=> 'checkbox alt'
						),
						'woo_sb_layout' => array(
							'title' => esc_html__('Sidebar Position', 'unilearn' ),
							'type' => 'radio',
							'subtype' => 'images',
							'value' => array(
								'left' => 	array( esc_html__('Left', 'unilearn' ), false, 'e:woo_sidebar;',	get_template_directory_uri() . '/img/fw_img/left.png' ),
								'right' => 	array( esc_html__('Right', 'unilearn' ), true, 'e:woo_sidebar;', get_template_directory_uri() . '/img/fw_img/right.png' ),
								'none' => 	array( esc_html__('None', 'unilearn' ), false, 'd:woo_sidebar;', get_template_directory_uri() . '/img/fw_img/none.png' )
							),
						),
						'woo_sidebar' => array(
							'title' => esc_html__('Select a sidebar', 'unilearn' ),
							'type' => 'select',
							'addrowclasses' => 'disable',
							'source' => 'sidebars',
						),
						'woo_num_products'	=> array(
							'title'			=> esc_html__( 'Products per page', 'unilearn' ),
							'type'			=> 'number',
							'value'			=> get_option( 'posts_per_page' )
						),
						'woo_related_num_products'	=> array(
							'title'			=> esc_html__( 'Related products per page', 'unilearn' ),
							'type'			=> 'number',
							'value'			=> get_option( 'posts_per_page' )
						)
					)
				)
			)
		);
	}
	if ( in_array( 'learnpress/learnpress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )  {
		$settings['lp_options'] = array(
			'type'		=> 'section',
			'title'		=> esc_html__( 'LearnPress', 'unilearn' ),
			'icon'		=> array('fa', 'book'),
			'layout'	=> array(
				'lp_options' => array(
					'type' 	=> 'tab',
					'init'	=> 'open',
					'icon' 	=> array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'LearnPress', 'unilearn' ),
					'layout' => array(
						'lms-sb-layout' => array(
							'title' 			=> esc_html__('Sidebar Position', 'unilearn' ),
							'type' 				=> 'radio',
							'subtype' 			=> 'images',
							'value' 			=> array(
								'left' 				=> 	array( esc_html__('Left', 'unilearn' ), false, 'e:lms-sb1;d:lms-sb2;',	get_template_directory_uri() . '/img/fw_img/left.png' ),
								'right' 			=> 	array( esc_html__('Right', 'unilearn' ), false, 'e:lms-sb1;d:lms-sb2;', get_template_directory_uri() . '/img/fw_img/right.png' ),
								'both' 				=> 	array( esc_html__('Both', 'unilearn' ), false, 'e:lms-sb1;e:lms-sb2;', get_template_directory_uri() . '/img/fw_img/both.png' ),
								'none' 				=> 	array( esc_html__('None', 'unilearn' ), true, 'd:lms-sb1;d:lms-sb2;', get_template_directory_uri() . '/img/fw_img/none.png' )
							),
						),
						'lms-sb1' => array(
							'title' 		=> esc_html__('Sidebar', 'unilearn' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						),
						'lms-sb2' => array(
							'title' 		=> esc_html__('Right sidebar', 'unilearn' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						)
					)
				)
			)
		);
	}// end of sections
	return $settings;
}

?>