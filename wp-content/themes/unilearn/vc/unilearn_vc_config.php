<?php
	if ( !class_exists( 'Unilearn_VC_Config' ) ){
		class Unilearn_VC_Config{

			public function __construct ( $args = array() ){
				add_action( 'admin_init', array( $this, 'remove_meta_boxes' ) );
				add_action( 'admin_menu', array( $this, 'remove_grid_elements_menu' ) );
				add_action( 'init', array( $this, 'remove_vc_elements' ) );
				add_action( 'init', array( $this, 'modify_vc_elements' ) );
				add_action( 'init', array( $this, 'config' ) );
				add_action( 'init', array( $this, 'extend_shortcodes' ) );
				add_action( 'init', array( $this, 'extend_params' ) );
			}
			public function config (){
				vc_set_default_editor_post_types( array(
					'page',					
					'megamenu_item'
				));
				vc_set_shortcodes_templates_dir( trailingslashit( get_template_directory() ) . 'vc/templates' );
			}
			public function get_defaults (){
				$this->args = wp_parse_args( $this->args, $this->defaults );
			}
			// Extend Composer with Theme Shortcodes
			public function extend_shortcodes (){
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_vc_posts_grid.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_vc_blog.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_icon.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_button.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_embed.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_banner.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_call_to_action.php' );			
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_msg_box.php' );	
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_progress_bar.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_milestone.php' );			
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_services.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_testimonial.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_pricing_plan.php' );	
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_divider.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_twitter.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_spacing.php' );

				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_widgets/cws_widget_text.php' );					
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_widgets/cws_widget_social.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_widgets/cws_widget_twitter.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_widgets/cws_widget_latest_posts.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/theme_widgets/cws_widget_staff.php' );

				if ( in_array( 'learnpress/learnpress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/cws_sc_vc_lp_course_posts_grid.php' );	
				};												
			}
			// Extend Composer with Custom Parametres
			public function extend_params (){
				require_once( trailingslashit( get_template_directory() ) . 'vc/params/cws_dropdown.php' );
			}
			// Modify VC Elements
			public function modify_vc_elements (){
				vc_remove_param( 'vc_row', 'full_height' );
				vc_remove_param( 'vc_row', 'columns_placement' );
				vc_remove_param( 'vc_row', 'el_class' );
				vc_add_param( 'vc_row' , array(
					'type' => 'dropdown',
					'heading' => "Row Divider",
					'param_name' => 'el_class',
					'value' => array(
						esc_html__( 'None', 'unilearn' ) => "",
						esc_html__( 'Top', 'unilearn' ) => "top_line",
						esc_html__( 'Bottom', 'unilearn' ) => "bottom_line",
						esc_html__( 'Top and Bottom', 'unilearn' ) => "top_line bottom_line",						
					)
				));

				vc_remove_param( 'vc_tta_accordion', 'style' );
				vc_remove_param( 'vc_tta_accordion', 'shape' );
				vc_remove_param( 'vc_tta_accordion', 'color' );
				vc_remove_param( 'vc_tta_accordion', 'no_fill' );
				vc_remove_param( 'vc_tta_accordion', 'spacing' );
				vc_remove_param( 'vc_tta_accordion', 'gap' );

				vc_remove_param( 'vc_tta_tabs', 'style' );
				vc_remove_param( 'vc_tta_tabs', 'shape' );
				vc_remove_param( 'vc_tta_tabs', 'color' );
				vc_remove_param( 'vc_tta_tabs', 'no_fill_content_area' );
				vc_remove_param( 'vc_tta_tabs', 'spacing' );
				vc_remove_param( 'vc_tta_tabs', 'gap' );
				vc_remove_param( 'vc_tta_tabs', 'pagination_style' );
				vc_remove_param( 'vc_tta_tabs', 'pagination_color' );

				vc_remove_param( 'vc_toggle', 'style' );
				vc_remove_param( 'vc_toggle', 'color' );
				vc_remove_param( 'vc_toggle', 'size' );

				vc_remove_param( 'vc_images_carousel', 'partial_view' );	
			}
			// Remove VC Elements
			public function remove_vc_elements (){
				vc_remove_element( 'vc_separator' );
				vc_remove_element( 'vc_text_separator' );
				vc_remove_element( 'vc_message' );
				vc_remove_element( 'vc_gallery' );
				vc_remove_element( 'vc_tta_tour' );
				vc_remove_element( 'vc_tta_pageable' );
				vc_remove_element( 'vc_custom_heading' );
				vc_remove_element( 'vc_btn' );
				vc_remove_element( 'vc_cta' );
				vc_remove_element( 'vc_posts_slider' );
				vc_remove_element( 'vc_progress_bar' );
				vc_remove_element( 'vc_basic_grid' );
				vc_remove_element( 'vc_media_grid' );
				vc_remove_element( 'vc_masonry_grid' );
				vc_remove_element( 'vc_masonry_media_grid' );
				vc_remove_element( 'vc_widget_sidebar' );
			}
			// Remove teaser metabox
			public function remove_meta_boxes() {
				remove_meta_box( 'vc_teaser', 'page', 		'side' );
				remove_meta_box( 'vc_teaser', 'post', 		'side' );
				remove_meta_box( 'vc_teaser', 'portfolio', 	'side' );
				remove_meta_box( 'vc_teaser', 'product', 	'side' );
			}
			// Remove 'Grid Elements' from Admin menu
			public function remove_grid_elements_menu(){
			  remove_menu_page( 'edit.php?post_type=vc_grid_item' );
			}
		}
	}
	/**/
	/* Config and enable extension */
	/**/
	$vc_config = new Unilearn_VC_Config ();
	/**/
	/* \Config and enable extension */
	/**/
?>