<?php

new Unilearn_Metaboxes();

class Unilearn_Metaboxes {

	public function __construct() {
		$this->init();
	}

	private function init() {
		add_action( 'add_meta_boxes', array($this, 'post_addmb') );
		add_action( 'add_meta_boxes_cws_portfolio', array($this, 'portfolio_addmb') );
		add_action( 'add_meta_boxes_cws_staff', array($this, 'staff_addmb') );

		add_action( 'admin_enqueue_scripts', array($this, 'mb_script_enqueue') );
		add_action( 'save_post', array($this, 'post_metabox_save'), 11, 2 );
	}

	public function portfolio_addmb() {
		add_meta_box( 'cws-post-metabox-id', 'CWS Portfolio Options', array($this, 'mb_portfolio_callback'), 'cws_portfolio', 'normal', 'high' );
	}

	public function staff_addmb() {
		add_meta_box( 'cws-post-metabox-id', 'CWS Staff Options', array($this, 'mb_staff_callback'), 'cws_staff', 'normal', 'high' );
	}

	public function post_addmb() {
		add_meta_box( 'cws-post-metabox-id', 'CWS Post Options', array($this, 'mb_post_callback'), 'post', 'normal', 'high' );
		add_meta_box( 'cws-post-metabox-id', 'CWS Page Options', array($this, 'mb_page_callback'), 'page', 'normal', 'high' );
	}

	public function mb_staff_callback( $post ) {
		wp_nonce_field( 'cws_mb_nonce', 'mb_nonce' );

		$mb_attr = array(
			'is_clickable' => array(
				'type' => 'checkbox',
				'title' => esc_html__('Clickable title', 'unilearn' ),
			),
			'social_group' => array(
				'type' => 'group',
				'addrowclasses' => 'group',
				'title' => esc_html__('Social networks', 'unilearn' ),
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
					),
				),
			),
			'color'		=> array(
				'type'	=> 'text',
				'title'	=> esc_html__( 'Color', 'unilearn' ),
				'desc'	=> esc_html__( 'Grid item background color', 'unilearn' ),
				'atts'	=> 'data-default-color="' . UNILEARN_THEME_COLOR . '"'
			)
		);

		$cws_stored_meta = get_post_meta( $post->ID, 'cws_mb_post' );
		unilearn_mb_fillMbAttributes($cws_stored_meta, $mb_attr);
		echo unilearn_mb_print_layout($mb_attr, 'cws_mb_');
	}

	public function mb_page_callback( $post ) {
		wp_nonce_field( 'cws_mb_nonce', 'mb_nonce' );

		$mb_attr = array(
			'header_override' => array(
				'type' => 'checkbox',
				'title' => esc_html__( 'Customize Header', 'unilearn' ),
				'atts' => 'data-options="e:header_covers_slider;e:menu_opacity;"',
			),
			'header_covers_slider' => array(
				'title' => esc_html__( 'Header Covers Slider', 'unilearn' ),
				'type' => 'checkbox',
				'addrowclasses' => 'checkbox disable'
			),
			'menu_opacity' => array(
				'title' => esc_html__( 'Header Opacity', 'unilearn' ),
				'type' => 'number',
				'atts' => " min='0' max='100'",
				'addrowclasses' => 'disable',
				'value'	=> '0'
			),
			'sb_layout' => array(
				'title' => esc_html__('Sidebar Position', 'unilearn' ),
				'type' => 'radio',
				'subtype' => 'images',
				'value' => array(
					'default'=>	array( esc_html__('Default', 'unilearn' ), true, 'd:sidebar1;d:sidebar2', get_template_directory_uri() . '/img/fw_img/default.png' ),
					'left' => 	array( esc_html__('Left', 'unilearn' ), false, 'e:sidebar1;d:sidebar2',	get_template_directory_uri() . '/img/fw_img/left.png' ),
					'right' => 	array( esc_html__('Right', 'unilearn' ), false, 'e:sidebar1;d:sidebar2', get_template_directory_uri() . '/img/fw_img/right.png' ),
					'both' => 	array( esc_html__('Double', 'unilearn' ), false, 'e:sidebar1;e:sidebar2', get_template_directory_uri() . '/img/fw_img/both.png' ),
					'none' => 	array( esc_html__('None', 'unilearn' ), false, 'd:sidebar1;d:sidebar2', get_template_directory_uri() . '/img/fw_img/none.png' )
				),
			),
			'sidebar1' => array(
				'title' => esc_html__('Select a sidebar', 'unilearn' ),
				'type' => 'select',
				'addrowclasses' => 'disable',
				'source' => 'sidebars',
			),
			'sidebar2' => array(
				'required' => array( 'sb_layout', '=', 'both' ),
				'title' => esc_html__('Select right sidebar', 'unilearn' ),
				'type' => 'select',
				'addrowclasses' => 'disable',
				'source' => 'sidebars',
			),
			'sb_foot_override' => array(
				'type' => 'checkbox',
				'title' => esc_html__( 'Customize footer', 'unilearn' ),
				'atts' => 'data-options="e:footer-sidebar-top"',
			),
			'footer-sidebar-top' => array(
				'title' => esc_html__('Footer Widgets area', 'unilearn' ),
				'type' => 'select',
				'addrowclasses' => 'disable',
				'source' => 'sidebars',
			),
			'sb_slider_override' => array(
				'type' => 'checkbox',
				'title' => esc_html__( 'Add Image Slider', 'unilearn' ),
				'atts' => 'data-options="e:slider_shortcode"',
			),
			'slider_shortcode' => array(
				'title' => esc_html__( 'Slider shortcode', 'unilearn' ),
				'addrowclasses' => 'disable',
				'type' => 'text',
				'default' => ''
			),
		);

		$cws_stored_meta = get_post_meta( $post->ID, 'cws_mb_post' );
		unilearn_mb_fillMbAttributes($cws_stored_meta, $mb_attr);
		echo unilearn_mb_print_layout($mb_attr, 'cws_mb_');
	}

	public function mb_portfolio_callback( $post ) {
		wp_nonce_field( 'cws_mb_nonce', 'mb_nonce' );

		$mb_attr = array(
			'show_related' => array(
				'title' => esc_html__( 'Show related projects', 'unilearn' ),
				'type' => 'checkbox',
				'atts' => 'checked data-options="e:related_projects_options;e:rpo_title;e:rpo_cols;e:rpo_items_count"',
			),
			'related_projects_options' => array(
				'type' => 'label',
				'title' => esc_html__( 'Related projects options', 'unilearn' ),
			),
			'rpo_title' => array(
				'type' => 'text',
				'title' => esc_html__( 'Title', 'unilearn' ),
				'value' => esc_html__( 'Related projects', 'unilearn' )
				),
			'rpo_cols' => array(
				'type' => 'select',
				'title' => esc_html__( 'Columns', 'unilearn' ),
				'source' => array(
					'1' => array(esc_html__( 'one', 'unilearn' ), false),
					'2' => array(esc_html__( 'two', 'unilearn' ), false),
					'3' => array(esc_html__( 'three', 'unilearn' ), false),
					'4' => array(esc_html__( 'four', 'unilearn' ), true),
					),
				),
			'rpo_items_count' => array(
				'type' => 'number',
				'title' => esc_html__( 'Items count', 'unilearn' ),
				'value' => '4'
			),
			'enable_hover' => array(
				'title' => esc_html__( 'Enable hover effect', 'unilearn' ),
				'type' => 'checkbox',
				'atts' => 'checked data-options="e:link_options;e:link_options_url;e:link_options_fancybox"',
			),
			'link_options' => array(
				'type' => 'label',
				'title' => esc_html__( 'Link options', 'unilearn' ),
			),
			'link_options_url' => array(
				'type' => 'text',
				'title' => esc_html__( 'Custom url', 'unilearn' ),
				'default' => ''
			),
			'link_options_fancybox' => array(
				'type' => 'checkbox',
				'title' => esc_html__( 'Open in fancybox', 'unilearn' ),
				'atts' => 'checked'
			)
		);

		$cws_stored_meta = get_post_meta( $post->ID, 'cws_mb_post' );
		unilearn_mb_fillMbAttributes($cws_stored_meta, $mb_attr);
		echo unilearn_mb_print_layout($mb_attr, 'cws_mb_');
	}

	public function mb_post_callback( $post ) {
		wp_nonce_field( 'cws_mb_nonce', 'mb_nonce' );

		$mb_attr = array(
			'gallery' => array(
				'type' => 'tab',
				'init' => 'closed',
				'title' => esc_html__( 'Gallery options', 'unilearn' ),
				'layout' => array(
					'gallery' => array(
						'title' => esc_html__( 'Gallery', 'unilearn' ),
						'type' => 'gallery'
					)
				)
			),
			'video' => array(
				'type' => 'tab',
				'init' => 'closed',
				'title' => esc_html__( 'Video options', 'unilearn' ),
				'layout' => array(
					'video' => array(
						'title' => esc_html__( 'Url to video file', 'unilearn' ),
						'type' => 'text'
					)
				)
			),
			'audio' => array(
				'type' => 'tab',
				'init' => 'closed',
				'title' => esc_html__( 'Audio options', 'unilearn' ),
				'layout' => array(
					'audio' => array(
						'title' => esc_html__( 'Self-hosted/soundclod audio url.', 'unilearn' ),
						'subtitle' => esc_html__( 'Ex.: /wp-content/uploads/audio.mp3 or http://soundcloud.com/...', 'unilearn' ),
						'type' => 'text'
					)
				)
			),
			'link' => array(
				'type' => 'tab',
				'init' => 'closed',
				'title' => esc_html__( 'Link options', 'unilearn' ),
				'layout' => array(
					'link' => array(
						'title' => esc_html__( 'Url', 'unilearn' ),
						'type' => 'text'
					)
				)
			),
			'quote' => array(
				'type' => 'tab',
				'init' => 'closed',
				'title' => esc_html__( 'Quote options', 'unilearn' ),
				'layout' => array(
					'quote[quote]' => array(
						'title' => esc_html__( 'Quote', 'unilearn' ),
						'subtitle' => esc_html__( 'Enter the quote', 'unilearn' ),
						'atts' => 'rows="5"',
						'type' => 'textarea'
					),
					'quote[author_name]' => array(
						'title' => esc_html__( 'Author Name', 'unilearn' ),
						'type' => 'text'
					),
					'quote[author_status]' => array(
						'title' => esc_html__( 'Author Status', 'unilearn' ),
						'type' => 'text'
					)
				)
			)
		);

		$cws_stored_meta = get_post_meta( $post->ID, 'cws_mb_post' );
		unilearn_mb_fillMbAttributes($cws_stored_meta, $mb_attr);
		echo unilearn_mb_print_layout($mb_attr, 'cws_mb_');
	}

	public function mb_script_enqueue($a) {
		global $pagenow;
		global $typenow;
		if( ($a == 'widgets.php' || $a == 'post-new.php' || $a == 'post.php' || $a == 'edit-tags.php') && ('customize.php' !== $pagenow) ) {
			if($typenow != 'product'){
				wp_enqueue_script('select2-js', get_template_directory_uri() . '/includes/core/assets/js/select2/select2.js', array('jquery') );
				wp_enqueue_style('select2-css', get_template_directory_uri() . '/includes/core/assets/js/select2/select2.css', false, '2.0.0' );
			}
			wp_enqueue_script('unilearn-metaboxes-js', get_template_directory_uri() . '/includes/core/assets/js/metaboxes.js', array('jquery') );
			wp_enqueue_style('unilearn-metaboxes-css', get_template_directory_uri() . '/includes/core/assets/css/metaboxes.css', false, '2.0.0' );
			wp_enqueue_media();
			wp_enqueue_style( 'wp-color-picker');
			wp_enqueue_script( 'wp-color-picker');
			wp_enqueue_style( 'mb_post_css' );
		}
	}

	public function post_metabox_save( $post_id, $post )
	{
		if ( in_array($post->post_type, array('post', 'page', 'cws_portfolio', 'cws_staff')) ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return;

			if ( !isset( $_POST['mb_nonce']) || !wp_verify_nonce($_POST['mb_nonce'], 'cws_mb_nonce') )
				return;

			if ( !current_user_can( 'edit_post', $post->ID ) )
				return;

			$save_array = array();

			foreach($_POST as $key => $value) {
				if (0 === strpos($key, 'cws_mb_')) {
					if ('on' === $value) {
						$value = '1';
					}
					if (is_array($value)) {
						foreach ($value as $k => $val) {
							if (is_array($val)) {
								$save_array[substr($key, 7)][$k] = $val;
							} else {
								$save_array[substr($key, 7)][$k] = esc_html($val);
							}
						}
					} else {
						$save_array[substr($key, 7)] = esc_html($value);
					}
				}
			}
			if (!empty($save_array)) {
				update_post_meta($post_id, 'cws_mb_post', $save_array);
			}
		}
	}
}
?>