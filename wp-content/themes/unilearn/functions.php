<?php
// CONSTANTS
$theme = wp_get_theme();
define('UNILEARN_THEME_NAME', $theme->get( 'Name' ));
define( 'UNILEARN_THEME_DIR', get_template_directory() );
define( 'UNILEARN_THEME_URI', get_template_directory_uri() );
define( 'UNILEARN_BEFORE_CE_TITLE', '<div class="ce_title">' );
define( 'UNILEARN_AFTER_CE_TITLE', '</div>' );
define( 'UNILEARN_V_SEP', '<span class="v_sep"></span>' );
if ( !defined( 'UNILEARN_THEME_COLOR' ) ){
	define( 'UNILEARN_THEME_COLOR', '#f27c66' );
}
define( 'UNILEARN_THEME_2_COLOR', '#f9cb8f' );
define( 'UNILEARN_THEME_3_COLOR', '#18bb7c' );
define( 'UNILEARN_THEME_HEADER_BG_COLOR', '#272b31' );
define( 'UNILEARN_THEME_HEADER_FONT_COLOR', '#f0f0f0' );
define( 'UNILEARN_THEME_FOOTER_BG_COLOR', '#2d3339' );
define( 'UNILEARN_MB_PAGE_LAYOUT_KEY', 'cws_mb_post' );
// \CONSTANTS

# TEXT DOMAIN
load_theme_textdomain( 'unilearn', get_template_directory() .'/languages' );
# \TEXT DOMAIN

// INCLUDES
require_once( trailingslashit( get_template_directory() ) . 'fw/config.php');	// theme options 
// config 
require_once( trailingslashit( get_template_directory() ) . 'includes/config/metaboxes.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/config/scg.php' );
// \config 
// core 
require_once( trailingslashit( get_template_directory() ) . 'includes/core/bfi_thumb.php' );
require_once get_template_directory() . '/includes/core/class-tgm-plugin-activation.php';
require_once( trailingslashit( get_template_directory() ) . 'includes/core/pb.php' );
// \core 
// modules 
require_once( trailingslashit( get_template_directory() ) . 'includes/modules/cws_blog.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/modules/cws_breadcrumbs.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/modules/cws_comments.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/modules/cws_portfolio.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/modules/cws_staff.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/modules/cws_search.php' );
// \modules 
// widgets 
require_once( trailingslashit( get_template_directory() ) . 'includes/widgets/unilearn_widget_social.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/widgets/unilearn_widget_twitter.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/widgets/unilearn_widget_cws_staff.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/widgets/unilearn_widget_latest_posts.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/widgets/unilearn_widget_text.php' );
// \widgets 
// \INCLUDES

function unilearn_clear_closing_prgs ( $content ){
	$match = preg_match( "#^</p>#", $content, $matches, PREG_OFFSET_CAPTURE );
	if ( $match ){
		$match_data = $matches[0];
		$content = substr_replace( $content, "", $match_data[1], strlen( $match_data[0] ) );
	}
	return $content;
}
add_filter( 'the_content', 'unilearn_clear_closing_prgs', 11 );

add_action( 'tgmpa_register', 'unilearn_register_required_plugins' );

// Check plugin's version
function cws_check_plugin_version ( $plugin ){
	$opt_res = wp_remote_get('http://up.cwsthemes.com/plugins/update.php?pname=' . $plugin );

	if (( ! isset($opt_res->errors)) && (200 == $opt_res['response']['code'] ) ){
		$cws_chk_ret = $opt_res['body'];
	} else {
		$cws_chk_ret = "5.4.7.4";
	}
	return $cws_chk_ret;
}
// \Check plugin's version

function unilearn_register_required_plugins (){
	$plugins = array(
		array(
			'name'					=> esc_html__( 'Unilearn Shortcodes', 'unilearn' ), // The plugin name
			'slug'					=> 'unilearn-shortcodes', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/unilearn-shortcodes.zip', // The plugin source
			'required'				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.1.3',			
			'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'			=> '', // If set, overrides default API URL and points to an external URL
		),			
		array(
			'name'					=> esc_html__( 'CWS Portfolio & Staff', 'unilearn' ), // The plugin name
			'slug'					=> 'cws-portfolio-staff', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/cws-portfolio-staff.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.1.0',
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__( 'CWS MegaMenu', 'unilearn' ), // The plugin name
			'slug'					=> 'cws-megamenu', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/cws-megamenu.zip', // The plugin source
			'required'				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.1.1',
			'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__( 'CWS Demo Importer', 'unilearn' ), // The plugin name
			'slug'					=> 'cws-demo-importer', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/cws-demo-importer.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '2.0.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__( 'WPBakery Visual Composer', 'unilearn' ), // The plugin name
			'slug'					=> 'js_composer', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/js_composer.zip', // The plugin source
			'required'				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '5.5.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__( 'Revolution Slider', 'unilearn' ), // The plugin name
			'slug'					=> 'revslider', // The plugin slug (typically the folder name)
			'source'				=> 'http://up.cwsthemes.com/plugins/revslider.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> cws_check_plugin_version('revslider'),
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://up.cwsthemes.com/plugins/', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__( 'LearnPress', 'unilearn' ), // The plugin name
			'slug'					=> 'learnpress', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'					=> esc_html__( 'Contact Form 7', 'unilearn' ), // The plugin name
			'slug'					=> 'contact-form-7', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'					=> esc_html__( 'WP Google Maps', 'unilearn' ), // The plugin name
			'slug'					=> 'wp-google-maps', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'					=> esc_html__( 'oAuth Twitter Feed for Developers', 'unilearn' ), // The plugin name
			'slug'					=> 'oauth-twitter-feed-for-developers', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'unilearn',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_slug' 		=> 'themes.php', 				// Default parent menu slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
	);

	tgmpa( $plugins, $config );

}

class Unilearn_Theme_Features{

	public function __construct (){
		// Check if JS_Composer is active
		if (class_exists('Vc_Manager')) {
			$vc_man = Vc_Manager::getInstance();
			$vc_man->disableUpdater(true);
			if (!isset($_COOKIE['vchideactivationmsg_vc11'])) {
				setcookie('vchideactivationmsg_vc11', WPB_VC_VERSION);
			}
		}
		if ( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			require_once( get_template_directory() . '/vc/unilearn_vc_config.php' ); // JS_Composer Theme config file
			vc_disable_frontend(); //Disable Visual Composer Front-End Editor
		};
		// Load Woocommerce Extension
		require_once( get_template_directory() . '/woocommerce/wooinit.php' ); // WooCommerce Shop ini file
		// Check if LearnPress is active
		if ( in_array( 'learnpress/learnpress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			require_once( get_template_directory() . '/learnpress/lpinit.php' ); // Larnpress Theme config file
		};
		// Check if WPML is active
		if ( unilearn_check_for_plugin('sitepress-multilingual-cms/sitepress.php') ) {
			unilearn_wpml_ext_init();
		}
		if ( class_exists( 'Unilearn_SCG' ) ){
			new Unilearn_SCG;
		}
		$this->theme_options_customizer_init ();
		$this->set_content_width ();
		add_action( 'unilearn_header_meta', array( $this, 'default_header_meta' ) );
		add_action( 'after_setup_theme', array( $this, 'after_setup' ) );
		add_action( 'wp', array( $this, 'page_meta_vars' ) );
		add_filter( 'wp_title', array( $this, 'wp_title_filter' ) );
		add_filter('pre_set_site_transient_update_themes', array($this, 'unilearn_check_for_update') );		
		if ( !function_exists( '_wp_render_title_tag' ) ){
			add_action( 'wp_head', array( $this, 'render_title' ) );
		}
		add_action( 'wp_head', array( $this, 'render_site_icon' ) );
		add_filter( 'wp_get_nav_menu_items', array( $this, 'split_nav_menu' ) );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'nav_menu_pointer' ), 10, 2 );
		add_filter( 'wp_nav_menu_items', array( $this, 'sandwich_menu_switcher' ), 10 ,2 );
		add_filter( 'wp_nav_menu_args', array( $this, 'sandwich_menu_class' ) );
		add_filter( 'widget_title', array( $this, 'wrap_widget_title' ), 11, 3 );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_reset_styles' ), 1 );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_theme_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_main_theme_stylesheet' ), 11 );		
		add_action( 'wp_enqueue_scripts', array( $this, 'sandwich_menu_animation' ), 11 );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_youtube_api' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'define_ajaxurl' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'localize_data' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_theme_stylesheet' ), 999 );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_styles' ) );
	}

	# UPDATE THEME
	public function unilearn_check_for_update($transient) {
		if (empty($transient->checked)) { return $transient; }

		$theme_pc = unilearn_get_option( '_theme_purchase_code' );
		if (empty($theme_pc)) {
			add_action( 'admin_notices', array($this, 'unilearn_an_purchase_code') );
		}

		$result = wp_remote_get('http://up.cwsthemes.com/products-updater.php?pc=' . $theme_pc . '&tname=' . 'unilearn');
		if (!is_wp_error( $result ) ) {
			if (200 == $result['response']['code'] && 0 != strlen($result['body']) ) {
				$resp = json_decode($result['body'], true);
				$h = isset( $resp['h'] ) ? (float) $resp['h'] : 0;
				$theme = wp_get_theme(get_template());
				if ( version_compare( $theme->get('Version'), $resp['new_version'], '<' ) ) {
					$transient->response['unilearn'] = $resp;
				}
			}
			else{
				unset($transient->response['unilearn']);
			}
		}
		return $transient;
	}


	public function unilearn_an_purchase_code() {
		$unilearn_theme = wp_get_theme();
		echo "<div class='update-nag'>" . esc_html( $unilearn_theme->get( 'Name' ) ) . esc_html__( ' theme notice: Please insert your Item Purchase Code in Theme Options to get the latest theme updates!', 'unilearn' ) .'</div>';
	}
// \UPDATE THEME	

	public function default_header_meta (){
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">		
		<?php
	}

	public function theme_options_customizer_init (){
		if ( is_customize_preview() ) {
			if ( isset( $_POST['wp_customize']) && isset( $_POST['customized']) && $_POST['wp_customize'] == "on" ) {
				if (strlen($_POST['customized']) > 10) {
					global $cwsfw_settings;
					$post_values = json_decode( stripslashes_deep( $_POST['customized'] ), true );
					if (isset($post_values['cwsfw_settings'])) {
						$cwsfw_settings = $post_values['cwsfw_settings'];						
					}
				}
			}
		}
	}

	public function set_content_width (){
		if ( ! isset( $content_width ) ) {
			$content_width = 600;
		}
	}

	public function wrap_widget_title ( $title, $instance = array(), $id_base = "" ){
		if ( $id_base == "rss" && isset( $instance['url'] ) && !empty( $instance['url'] ) ){
			return $title;
		}
		else{
			return !empty( $title ) ? "<span>$title</span>" : $title;
		}
	}
	
	public function enqueue_theme_stylesheet () {
		wp_enqueue_style( 'style', get_stylesheet_uri() );
	}

	public function after_setup (){
		add_theme_support( 'menus' );
		add_theme_support( 'widgets' );
	   	add_theme_support( 'title-tag' );
	   	add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
		add_theme_support( 'automatic-feed-links' );
		$bg_defaults = array(
			'default-color'				=> '#fff'
		);
		add_theme_support( 'custom-background', $bg_defaults );
	   	register_nav_menus( array(
		    'primary' => 'Primary Menu',
		    'secondary' => 'Secondary Menu'
		));		
	}

	public function wp_title_filter ( $title_text, $sep ){
		$site_name = get_bloginfo( 'name' );
		$site_tagline = get_bloginfo( 'description' );
		if ( is_home() ){
			$title_text = $site_name . $sep . $site_tagline;
		}
		else{
			$title_text .= $site_name;
		}
		return $title_text;		
	}

	public function render_title (){
		?>
		<title><?php wp_title( ' | ', true, 'right' ); ?></title>
		<?php		
	}
	public function render_site_icon (){
		if ( !function_exists( 'wp_site_icon' ) ){
			$site_icon_id = get_option( 'site_icon' );
			if ( !empty( $site_icon_id ) ){
				echo "<link rel='icon' href='" . wp_get_attachment_image_src( $site_icon_id, array( 32, 32 ) ) . "' sizes='32x32' />";
				echo "<link rel='icon' href='" . wp_get_attachment_image_src( $site_icon_id, array( 192, 192 ) ) . "' sizes='192x192' />";
				echo "<link rel='apple-touch-icon-precomposed' href='" . wp_get_attachment_image_src( $site_icon_id, array( 180, 180 ) ) . "' />";
				echo "<link rel='msapplication-TileImage' href='" . wp_get_attachment_image_src( $site_icon_id, array( 270, 270 ) ) . "' />";
			}
		}
	}
	public function split_nav_menu ( $items ){
		if ( is_admin() ) return $items;
		$top_level_items = array();
		for ( $i = 0; $i < count( $items ); $i++ ){
			$item = &$items[$i];
			if ( $item->menu_item_parent == '0' ){
				array_push( $top_level_items, $item );
			}
		}
		$top_level_items_count = count( $top_level_items );
		for ( $i = ceil( $top_level_items_count / 2 ); $i < $top_level_items_count; $i++ ){
			array_push( $top_level_items[$i]->classes, 'right' );
		}
		return $items;
	}
	public function nav_menu_pointer ( $item_output, $item ){
		if ( in_array( 'menu-item-has-children', $item->classes ) ){
			$item_output .= "<span class='pointer'></span>";
		}
		return $item_output;
	}
	public function sandwich_menu_switcher ( $items, $args){
		if ( !in_array( $args->menu_id, array( 'main_menu', 'sticky_menu' ) ) ) return $items;
		$sandwich_menu = unilearn_get_option( 'sandwich_menu' );		
		if ( $sandwich_menu && $args->theme_location == 'primary' && !empty( $items ) ){
			$items .= "<div class='sandwich_switcher' data-sandwich-action='show_hide_main_menu_items' >";
				$items .= "<a class='switcher'>";
					$items .= "<span class='ham'>";
					$items .= "</span>";
				$items .= "</a>";
			$items .= "</div>";
		}
		return $items;
	}
	public function sandwich_menu_class ( $args ){
		if ( !in_array( $args['menu_id'], array( 'main_menu', 'sticky_menu' ) ) ) return $args;
		$sandwich_menu = unilearn_get_option( 'sandwich_menu' );
		if ( $sandwich_menu ){
			if ( isset( $args['menu_class'] ) ){
				if ( !empty( $args['menu_class'] ) ){
					$args['menu_class'] .= ' sandwich';
				}
				else{
					$args['menu_class'] = 'sandwich';				
				}
			}
			else{
				$args['menu_class'] = 'sandwich';
			}
		}
		return $args;
	}
	public function sandwich_menu_animation (){
		$sandwich_menu 		= unilearn_get_option( 'sandwich_menu' );
		$logo_pos 			= unilearn_get_option( 'logo_pos' );
		$menu_pos 			= unilearn_get_option( 'menu_pos' );
		$invert_items_anim 	= $logo_pos == 'right';
		if ( $sandwich_menu ){
			$anim_dur = 250;
			$anim_del = 60;
			$top_level_items = 0;
			$menu_locations = get_nav_menu_locations();
			if ( isset( $menu_locations['primary'] ) ){
				$term_id = $menu_locations['primary'];
				$items = wp_get_nav_menu_items( $term_id );
				if ( is_array( $items ) ){
					for ( $i = 0; $i < count( $items ); $i++ ){
						$item = $items[$i];
						if ( $item->menu_item_parent == '0' ){
							$top_level_items ++;
						}
					}
				}
			}
			$styles = "";
			for ( $i = 1; $i <= $top_level_items; $i++ ){
				$styles .= "
					.main_menu.sandwich.sandwich_active > .menu-item:nth-" . ( $invert_items_anim ? "" : "last-" ) . "child(n+$i){
						-webkit-transition: opacity "  . $anim_dur . "ms ease " . $anim_del . "ms;
						transition: opacity "  . $anim_dur . "ms ease " . $anim_del . "ms;
					}
					.main_menu.sandwich > .menu-item:nth-" . ( $invert_items_anim ? "last-" : "" ) . "child(n+$i){
						-webkit-transition: opacity "  . $anim_dur . "ms ease " . $anim_del . "ms;
						transition: opacity "  . $anim_dur . "ms ease " . $anim_del . "ms;
					}
				";
				$anim_dur += 50;
				$anim_del += 30;
			}
			if ( !empty( $styles ) ) wp_add_inline_style( 'main', $styles );
		}
	}
	public function register_reset_styles (){
		wp_enqueue_style( 'reset', UNILEARN_THEME_URI . '/css/reset.css' );
	}
	public function register_theme_styles (){
		$is_rtl = is_rtl();
		$stylesheets = array(
			'font_awesome'	=> UNILEARN_THEME_URI . '/css/font-awesome.min.css',
			'select2'		=> UNILEARN_THEME_URI . '/css/select2.css',
			'animate'		=> UNILEARN_THEME_URI . '/css/animate.css',
			'layout'		=> UNILEARN_THEME_URI . '/css/layout.css',
			'fancybox'		=> UNILEARN_THEME_URI . '/css/jquery.fancybox.css',
			'odometer'		=> UNILEARN_THEME_URI . '/css/odometer-theme-default.css'
		);
    	if ( 'off' !== _x( 'on', 'Google font: on or off', 'unilearn' ) ) {
			$gf_url = esc_url( $this->render_fonts_url () );
			if ( !empty( $gf_url ) ) $stylesheets['gf'] = $gf_url;
		}
		foreach ( $stylesheets as $alias => $src ){
			wp_enqueue_style( $alias, $src );
		}
		$rtl_stylesheets = array(
			'layout-rtl'		=> UNILEARN_THEME_URI . '/css/layout-rtl.css',
		);
		if ( $is_rtl ){
			foreach ( $rtl_stylesheets as $alias => $src ){
				wp_enqueue_style( $alias, $src );
			}
		}
	}
	public function enqueue_main_theme_stylesheet (){
		$deps = array(
			'mediaelement',
			'wp-mediaelement',
			'select2',
			'animate',
			'layout',
			'fancybox',
			'odometer'
		);
		wp_enqueue_style( 'main', UNILEARN_THEME_URI . '/css/main.css', $deps );
		wp_add_inline_style( 'main', $this->body_font_styles () );
		wp_add_inline_style( 'main', $this->menu_font_styles () );
		wp_add_inline_style( 'main', $this->header_font_styles () );
		wp_add_inline_style( 'main', $this->custom_colors_styles () );
		wp_add_inline_style( 'main', $this->header_styles () );
		wp_add_inline_style( 'main', $this->footer_widgets_styles () );
		wp_add_inline_style( 'main', $this->footer_copyrights_styles () );
		wp_add_inline_style( 'main', $this->front_dynamic_styles () );	
	}
	public function load_youtube_api (){
	?>
		<script type="text/javascript">
			// Loads the IFrame Player API code asynchronously.
			var tag = document.createElement("script");
			tag.src = "https://www.youtube.com/player_api";
			var firstScriptTag = document.getElementsByTagName("script")[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
		</script>
	<?php
	}
	public function register_scripts (){
		if ( is_singular() ) wp_enqueue_script( "comment-reply" );
		$common_scripts = array(
			'retina'				=> UNILEARN_THEME_URI . '/js/retina_1.3.0.js',
			'select2'				=> UNILEARN_THEME_URI . '/js/select2.min.js',
			'cws_helpers'			=> UNILEARN_THEME_URI . '/js/cws_helpers.js',
			'cws_toggle'			=> UNILEARN_THEME_URI . '/js/cws_toggle.js',
			'cws_mobile_menu'		=> UNILEARN_THEME_URI . '/js/cws_mobile_menu.js'
		);
		$specific_scripts = array(
			'greensock_tween_lite'	=> UNILEARN_THEME_URI . '/js/TweenLite.min.js',
			'greensock_css_plugin'	=> UNILEARN_THEME_URI . '/js/CSSPlugin.min.js',
			'greensock_easing'		=> UNILEARN_THEME_URI . '/js/EasePack.min.js',	
			'vimeo_api'				=> UNILEARN_THEME_URI . '/js/jquery.vimeo.api.min.js',
			'cws_self_vimeo'		=> UNILEARN_THEME_URI . '/js/cws_self_vimeo_bg.js',
			'cws_YT_bg'				=> UNILEARN_THEME_URI . '/js/cws_YT_bg.js',
			'owl_carousel'			=> UNILEARN_THEME_URI . '/js/owl.carousel.js',
			'isotope'				=> UNILEARN_THEME_URI . '/js/isotope.pkgd.min.js',
			'fancybox'				=> UNILEARN_THEME_URI . '/js/jquery.fancybox.pack.js',
			'images_loaded'			=> UNILEARN_THEME_URI . '/js/imagesloaded.pkgd.min.js',
			'odometer'				=> UNILEARN_THEME_URI . '/js/odometer.js'
		);
		foreach ( $common_scripts as $handle => $src ) {
			wp_enqueue_script( $handle, $src, array( 'jquery' ), '', true );
		}
		foreach ( $specific_scripts as $handle => $src ) {
			wp_register_script( $handle, $src, array( 'jquery' ), '', true );
		}
		$main_deps = array(
			'jquery',
			'greensock_tween_lite',
			'greensock_css_plugin',
			'greensock_easing',
			'vimeo_api',
			'cws_self_vimeo',
			'cws_YT_bg',
			'owl_carousel',
			'isotope',
			'fancybox',
			'images_loaded'
		);
		wp_enqueue_script( 'main', UNILEARN_THEME_URI . '/js/main.js', $main_deps, '', true );
	}
	public function define_ajaxurl (){
		wp_localize_script( 'main', 'ajaxurl', esc_url( admin_url( 'admin-ajax.php' ) ) );
	}
	public function register_admin_scripts (){
		$scripts = array(
			'custom-admin'	=> UNILEARN_THEME_URI . '/includes/core/assets/js/custom-admin.js'
		);
		foreach ( $scripts as $alias => $src ){
			wp_enqueue_script( $alias, $src );
		}
	}
	public function register_admin_styles (){
		$stylesheets = array(
			'font_awesome'	=> UNILEARN_THEME_URI . '/css/font-awesome.min.css'
		);
		foreach ( $stylesheets as $alias => $src ){
			wp_enqueue_style( $alias, $src );
		}
		wp_enqueue_style( 'mb-post-styles', UNILEARN_THEME_URI . '/includes/core/assets/css/mb-post-styles.css' );		
		wp_add_inline_style( 'mb-post-styles', $this->back_dynamic_styles () );
	}
	public function localize_data (){
		$data = array(
			'admin_bar' 			=> is_admin_bar_showing(),
			'rtl' 					=> is_rtl(),
			'menu_stick' 			=> (bool)unilearn_get_option( 'menu_stick' ),
			'sandwich_menu' 		=> (bool)unilearn_get_option( 'sandwich_menu' ),
		);

		$header_page_meta_vars 	= unilearn_get_page_meta_var( array( 'header' ) );
		$page_override_header 	= !empty( $header_page_meta_vars );
		$header_covers_slider 	= false;
		if ( $page_override_header ){
			$header_covers_slider 	= isset( $header_page_meta_vars['header_covers_slider'] ) ? (bool)$header_page_meta_vars['header_covers_slider'] : $header_covers_slider;
		}
		else{
			$header_covers_slider 	= (bool)unilearn_get_option( 'header_covers_slider' );
		}
		$data['header_covers_slider'] = $header_covers_slider;

		wp_localize_script( 'main', 'theme_opts', $data );
	}
	public function merge_fonts_options ( $fonts_arr = array(), $ind = 0 ){
		$r = $temp = $rem_inds = array();
		if ( !isset( $fonts_arr[ $ind ] ) ){
			return $fonts_arr;
		}
		$cur_font_opts = $fonts_arr[ $ind ];
		$cur_font_family = $cur_font_opts['font-family'];
		if ( empty( $cur_font_family ) ){
			$r = $this->merge_fonts_options( array_splice( $fonts_arr, $ind, 1 ), $ind );
		}
		else{
			for ( $i = $ind + 1; $i < count( $fonts_arr ); $i++ ){
				if ( $fonts_arr[$i]['font-family'] == $cur_font_family ){
					$temp['font-family'] = $cur_font_family;
					$temp['font-weight'] = $cur_font_opts['font-weight'];
					for ( $j = 0; $j < count(  $fonts_arr[$i]['font-weight'] ); $j ++ ){
						if ( !in_array( $fonts_arr[$i]['font-weight'][$j],  $temp['font-weight'] ) ){
							array_push( $temp['font-weight'], $fonts_arr[$i]['font-weight'][$j] );
						}
					}
					$temp['font-sub'] = $cur_font_opts['font-sub'];
					for ( $j = 0; $j < count(  $fonts_arr[$i]['font-sub'] ); $j ++ ){
						if ( !in_array( $fonts_arr[$i]['font-sub'][$j], $temp['font-sub'] ) ){
							array_push( $temp['font-sub'], $fonts_arr[$i]['font-sub'][$j] );
						}
					}
					$fonts_arr[$ind] = $temp;
					$r = $this->merge_fonts_options( array_splice( $fonts_arr, $i, 1 ), $ind ); 
				}
			}
			$r = $this->merge_fonts_options( $fonts_arr, $ind + 1 );
		}
		unset( $r['color'] );
		unset( $r['font-size'] );
		unset( $r['line-height'] );
		return $r;
	}
	public function render_fonts_url (){
		$url = "";
		$query_args = "";
		$body_font_opts = unilearn_get_option( "body_font" );
		$menu_font_opts = unilearn_get_option( "menu_font" );
		$header_font_opts = unilearn_get_option( "header_font" );
		$fonts_opts = $this->merge_fonts_options( array( $body_font_opts, $menu_font_opts, $header_font_opts ) );
		if ( empty( $fonts_opts ) ) return $url;
		$fonts_urls = array( count( $fonts_opts ) );
		$subsets_arr = array();
		$base_url = "//fonts.googleapis.com/css";
		$url = "";
		for ( $i = 0; $i < count( $fonts_opts ); $i++ ){
			$fonts_urls[$i] = "" . $fonts_opts[$i]['font-family'];
			$fonts_urls[$i] .= !empty( $fonts_opts[$i]['font-weight'] ) ? ":" . implode( $fonts_opts[$i]['font-weight'], ',' ) : "";
			for ( $j = 0; $j < count( $fonts_opts[$i]['font-sub'] ); $j++ ){
				if ( !in_array( $fonts_opts[$i]['font-sub'][$j], $subsets_arr ) ){
					array_push( $subsets_arr, $fonts_opts[$i]['font-sub'][$j] );
				}
			}
		};
		$query_args = array(
			'family'	=> urlencode( implode( $fonts_urls, '|' ) )
		);
		if ( !empty( $subsets_arr ) ){
			$query_args['subset']	= urlencode( implode( $subsets_arr, ',' ) );
		}
		$url = add_query_arg( $query_args, $base_url );
		return $url;
	}
	public function body_font_styles (){
		ob_start ();
		do_action( 'unilearn_body_font_hook' );
		return ob_get_clean ();
	}
	public function menu_font_styles (){
		ob_start ();
		do_action( 'unilearn_menu_font_hook' );
		return ob_get_clean ();
	}
	public function header_font_styles (){
		ob_start ();
		do_action( 'unilearn_header_font_hook' );
		return ob_get_clean ();
	}
	public function custom_colors_styles (){
		ob_start ();
		do_action( 'unilearn_custom_colors_hook' );
		return ob_get_clean ();
	}
	public function header_styles (){
		ob_start ();
		do_action( 'unilearn_header_styles_hook' );
		return ob_get_clean ();		
	}
	public function footer_widgets_styles (){
		ob_start ();
		do_action( 'unilearn_footer_widgets_styles_hook' );
		return ob_get_clean ();		
	}
	public function footer_copyrights_styles (){
		ob_start ();
		do_action( 'unilearn_footer_copyrights_styles_hook' );
		return ob_get_clean ();		
	}
	public function front_dynamic_styles (){
		ob_start ();
		do_action( 'unilearn_front_dynamic_styles_hook' );
		return ob_get_clean ();				
	}
	public function back_dynamic_styles (){
		ob_start ();
		do_action( 'unilearn_back_dynamic_styles_hook' );
		return ob_get_clean ();				
	}
	public function page_meta_vars() {
		if ( is_page() ) {
			$pid = get_query_var( 'page_id' );
			$pid = ! empty( $pid ) ? $pid : get_queried_object_id();
			$post = get_post( $pid );
			$stored_meta = get_post_meta( $pid, UNILEARN_MB_PAGE_LAYOUT_KEY );
			$stored_meta = isset( $stored_meta[0] ) ? $stored_meta[0] : array();
			$GLOBALS['unilearn_page_meta'] = array();
			$GLOBALS['unilearn_page_meta']['header'] = array();
			if ( isset( $stored_meta['header_override'] ) && $stored_meta['header_override'] !== '0' ){
				$GLOBALS['unilearn_page_meta']['header']['menu_opacity']			= $stored_meta['menu_opacity'];
				$GLOBALS['unilearn_page_meta']['header']['header_covers_slider'] 	= $stored_meta['header_covers_slider'];
			}
			else{
				$GLOBALS['unilearn_page_meta']['header']['menu_opacity'] 			= unilearn_get_option( 'menu_opacity' );
				$GLOBALS['unilearn_page_meta']['header']['header_covers_slider'] 	= unilearn_get_option( 'header_covers_slider' );
			}
			$GLOBALS['unilearn_page_meta']['sb'] = unilearn_get_sidebars( $pid );
			$GLOBALS['unilearn_page_meta']['footer'] = array( 'footer_sb_top' => '', 'footer_sb_bottom' => '' );
			if ( isset( $stored_meta['sb_foot_override'] ) && $stored_meta['sb_foot_override'] !== '0' ) {
				$GLOBALS['unilearn_page_meta']['footer']['footer_sb_top'] = isset( $stored_meta['footer-sidebar-top'] ) ? $stored_meta['footer-sidebar-top'] : '';
			} else {
				$GLOBALS['unilearn_page_meta']['footer']['footer_sb_top'] = unilearn_get_option( 'footer_sb' );
			}
			$GLOBALS['unilearn_page_meta']['slider'] = array( 'slider_override' => '', 'slider_shortcode' => '' );
			$GLOBALS['unilearn_page_meta']['slider']['slider_override'] = isset( $stored_meta['sb_slider_override'] ) && $stored_meta['sb_slider_override'] !== '0' ? $stored_meta['sb_slider_override'] : false;
			$GLOBALS['unilearn_page_meta']['slider']['slider_shortcode'] = isset( $stored_meta['slider_shortcode'] ) ? $stored_meta['slider_shortcode'] : '';
			return true;
		} else {
			return false;
		}
	}
}
$unilearn_theme_features = new Unilearn_Theme_Features;

function unilearn_check_for_plugin ( $plugin ){   /* $plugin - folder/file  */
    return in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}

/*****
* WPML
*****/

function unilearn_wpml_ext_init (){
	// Check if WPML is active
	define('CWS_WPML_ACTIVE', true);
}

function unilearn_is_wpml_active (){
	return defined("CWS_WPML_ACTIVE") && CWS_WPML_ACTIVE;
}

function unilearn_show_flags_in_footer () {
	return isset( $GLOBALS['wpml_settings']['icl_lang_sel_footer'] ) ? $GLOBALS['wpml_settings']['icl_lang_sel_footer'] : false;
}
/******
* \WPML
******/

function unilearn_site_header_html (){
	ob_start();
	$header_class = $sticky_header_class = $mobile_header_class = "site_header";
	$mobile_header_class .= " sandwich";
	$logo = unilearn_get_option( 'logo' );
	$logo_dims = unilearn_get_option( 'logo_dims' );
	$logo_id = isset( $logo['id'] ) ? $logo['id'] : "";
	$logo_hdpi = isset( $logo['is_high_dpi'] ) ? (bool)$logo['is_high_dpi'] : false;
	$logo_obj = !empty( $logo_id ) ? wp_get_attachment_image_src( $logo_id, 'full' ) : array();
	$logo_bfi_args = array();
	if ( is_array( $logo_dims ) ){
		foreach ( $logo_dims as $key => $value ) {
			if ( !empty($value) ){
				$logo_bfi_args[$key] = $value;
			}
		}
	}
	$logo_srcs = unilearn_get_img_srcs( $logo_obj, $logo_hdpi, $logo_bfi_args );
	$logo_exists 				= isset( $logo_srcs['src'] ) && !empty( $logo_srcs['src'] );
	$logo_src 					= $logo_exists ? $logo_srcs['src'] : '';
	$logo_retina_thumb_exists 	= $logo_exists ? $logo_srcs['retina_thumb_exists'] : false;
	$logo_retina_thumb_url 		= $logo_exists ? $logo_srcs['retina_thumb_url'] : '';
	/* sticky logo */
	$sticky_logo = unilearn_get_option( 'sticky_logo' );
	$sticky_logo_id = isset( $sticky_logo['id'] ) ? $sticky_logo['id'] : "";
	$sticky_logo_hdpi = isset( $sticky_logo['is_high_dpi'] ) ? (bool)$sticky_logo['is_high_dpi'] : false;
	$sticky_logo_obj = !empty( $sticky_logo_id ) ? wp_get_attachment_image_src( $sticky_logo_id, 'full' ) : array();
	$sticky_logo_exists = !empty( $sticky_logo_obj );	
	$sticky_logo_src 					= "";
	$sticky_logo_retina_thumb_exists 	= false;
	$sticky_logo_thumb_url 				= "";
	if ( $sticky_logo_exists ){
		$sticky_logo_url = $sticky_logo_obj[0];
		if ( $sticky_logo_hdpi ){
			$sticky_logo_bfi_obj = bfi_thumb( $sticky_logo_url, array( 'width' => floor( $sticky_logo_obj[1] / 2 ) ), false );
			$sticky_logo_src = $sticky_logo_bfi_obj[0];
			$sticky_logo_retina_thumb_exists = $sticky_logo_bfi_obj[3]["retina_thumb_exists"];
			$sticky_logo_retina_thumb_url = $sticky_logo_bfi_obj[3]["retina_thumb_url"];
		}
		else{
			$sticky_logo_src = $sticky_logo_url;
		}
	}
	else{
		$sticky_logo_exists 				= $logo_exists;
		$sticky_logo_src 					= $logo_src;
		$sticky_logo_retina_thumb_exists 	= $logo_retina_thumb_exists;
		$sticky_logo_retina_thumb_url 		= $logo_retina_thumb_url;
	}		
	/* \sticky logo */
	/* mobile logo */
	$mobile_logo = unilearn_get_option( 'mobile_logo' );
	$mobile_logo_id = isset( $mobile_logo['id'] ) ? $mobile_logo['id'] : "";
	$mobile_logo_hdpi = isset( $mobile_logo['is_high_dpi'] ) ? (bool)$mobile_logo['is_high_dpi'] : false;
	$mobile_logo_obj = !empty( $mobile_logo_id ) ? wp_get_attachment_image_src( $mobile_logo_id, 'full' ) : array();
	$mobile_logo_exists = !empty( $mobile_logo_obj );	
	$mobile_logo_src 					= "";
	$mobile_logo_retina_thumb_exists 	= false;
	$mobile_logo_retina_thumb_url 		= "";
	if ( $mobile_logo_exists ){
		$mobile_logo_url = $mobile_logo_obj[0];
		if ( $mobile_logo_hdpi ){
			$mobile_logo_bfi_obj = bfi_thumb( $mobile_logo_url, array( 'width' => floor( $mobile_logo_obj[1] / 2 ) ), false );
			$mobile_logo_src = $mobile_logo_bfi_obj[0];
			$mobile_logo_retina_thumb_exists = $mobile_logo_bfi_obj[3]["retina_thumb_exists"];
			$mobile_logo_retina_thumb_url = $mobile_logo_bfi_obj[3]["retina_thumb_url"];
		}
		else{
			$mobile_logo_src = $mobile_logo_url;
		}
	}
	else{
		$mobile_logo_exists 				= $logo_exists;
		$mobile_logo_src 					= $logo_src;
		$mobile_logo_retina_thumb_exists 	= $logo_retina_thumb_exists;
		$mobile_logo_retina_thumb_url 		= $logo_retina_thumb_url;		
	}
	/* \mobile logo */
	$logo_pos = unilearn_get_option( 'logo_pos' );
	$header_class .= $logo_exists && !empty( $logo_pos ) ? " logo_$logo_pos" : "";
	$sticky_header_class .= $logo_exists && !empty( $logo_pos ) ? " logo_$logo_pos" : "";
	$logo_margins = unilearn_get_option( 'logo_margins' );
	$logo_styles = "";
	if ( is_array( $logo_margins ) ){
		foreach ( $logo_margins as $side => $value ) {
			$logo_styles .= "padding-$side: $value;";
		}
	}
	$sticky_logo_styles = "";
	if ( is_array( $logo_margins ) ){
		$sticky_logo_styles .= !empty( $logo_margins['left'] ) ? "padding-left:" . $logo_margins['left'] . ";" : "";
		$sticky_logo_styles .= !empty( $logo_margins['right'] ) ? "padding-right:" . $logo_margins['right'] . ";" : "";
	}
	$logo_pos = unilearn_get_option( 'logo_pos' );
	$menu_pos = unilearn_get_option( 'menu_pos' );
	if ( $logo_pos == 'right' ){
		$menu_display_pos = 'left';
	}
	else if ( $logo_pos == 'left' ){
		$menu_display_pos = 'right';
	}
	else{
		$menu_display_pos = $menu_pos;
	}
	$menu_args = array(
		'menu_id' => 'main_menu',
		'menu_class' => 'main_menu' . ( !empty( $menu_display_pos ) ? " a_{$menu_display_pos}_flex" : "" ),
		'container' => false,
		'echo' => false,
		'theme_location' => 'primary'
	);
	$sticky_menu_args = array(
		'menu_id' => 'sticky_menu',
		'menu_class' => 'main_menu' . ( !empty( $menu_display_pos ) ? " a_{$menu_display_pos}_flex" : "" ),
		'container' => false,
		'echo' => false,
		'theme_location' => 'primary'
	);
	$mobile_menu_args = array(
		'menu_id'	=> 'mobile_menu',
		'menu_class'=> 'main_menu',
		'container'	=> false,
		'echo' => false,
		'theme_location' => 'primary'
	);
	$menu_exists = has_nav_menu( 'primary' );
	$menu = $menu_exists ? wp_nav_menu( $menu_args ) : "";
	$menu_stick = unilearn_get_option( 'menu_stick' );
	$sticky_menu = $menu_stick && $menu_exists ? wp_nav_menu( $sticky_menu_args ) : "";
	$mobile_menu = $menu_exists ? wp_nav_menu( $mobile_menu_args ) : "";
	$logo = "";
	$sticky_logo = "";
	$mobile_logo = "";
	if ( $logo_exists ){
		$logo .= "<div class='header_logo'" . ( !empty( $logo_styles ) ? " style='$logo_styles'" : "" ) . " role='banner'>";
			$logo .= "<a href='" . esc_url( get_site_url() ) . "'>";
				$logo .= "<img src='$logo_src' class='header_logo_img'" . ( $logo_retina_thumb_exists ? " data-at2x='$logo_retina_thumb_url'" : " data-no-retina" ) . " alt />";
			$logo .= "</a>";
		$logo .= "</div>";
	}
	if ( $sticky_logo_exists ){
		$sticky_logo .= "<div class='header_logo'" . ( !empty( $sticky_logo_styles ) ? " style='$sticky_logo_styles'" : "" ) . " role='banner'>";
			$sticky_logo .= "<a href='" . esc_url( get_site_url() ) . "'>";					
				$sticky_logo .= "<img src='$sticky_logo_src' class='header_logo_img'" . ( $sticky_logo_retina_thumb_exists ? " data-at2x='$sticky_logo_retina_thumb_url'" : " data-no-retina" ) . " alt />";
			$sticky_logo .= "</a>";				
		$sticky_logo .= "</div>";
	}
	if ( $mobile_logo_exists ){
		$mobile_logo .= "<div class='header_logo' role='banner'>";
			$mobile_logo .= "<a href='" . esc_url( get_site_url() ) . "'>";
				$mobile_logo .= "<img src='$mobile_logo_src' class='header_logo_img'" . ( $mobile_logo_retina_thumb_exists ? " data-at2x='$mobile_logo_retina_thumb_url'" : " data-no-retina" ) . " alt />";
			$mobile_logo .= "</a>";				
		$mobile_logo .= "</div>";
	}			
	if ( !empty( $logo ) || !empty( $menu ) ){
		echo "<header id='site_header'" . ( !empty( $header_class ) ? " class='" . trim( $header_class ) . "'" : "" ) . ">";
			if ( !empty( $logo ) ){
				if ( $logo_pos == 'center' ){
					echo "<div class='unilearn_layout_container'>";
						echo sprintf("%s", $logo);
					echo "</div>";
					echo "<div class='unilearn_layout_container'>";
						echo sprintf("%s", $menu);
					echo "</div>";
				}
				else{
					echo "<div class='unilearn_layout_container'>";
						if ( $logo_pos == 'right' ){
							echo sprintf("%s", $menu);
							echo sprintf("%s", $logo);
						}
						else{
							echo sprintf("%s", $logo);
							echo sprintf("%s", $menu);
						}
					echo "</div>";
				}
			}
			else{
				echo "<div class='unilearn_layout_container'>";
					echo sprintf("%s", $menu);
				echo "</div>";						
			}
		echo "</header>";
	}
	if ( $menu_stick && !empty( $sticky_menu ) ){
		echo "<section id='sticky'" . ( !empty( $sticky_header_class ) ? " class='$sticky_header_class'" : "" ) . ">";
			echo "<div id='sticky_box'>";
				echo "<div class='unilearn_layout_container'>";
				if ( !empty( $sticky_logo ) ){
					if ( $logo_pos == 'center' ){
						echo sprintf("%s", $sticky_menu);
					}
					else if ( $logo_pos == 'right' ){
						echo sprintf("%s", $sticky_menu);
						echo sprintf("%s", $sticky_logo);
					}
					else{
						echo sprintf("%s", $sticky_logo);
						echo sprintf("%s", $sticky_menu);
					}
				}
				else{
					echo sprintf("%s", $sticky_menu);
				}
				echo "</div>";
			echo "</div>";
		echo "</section>";
	}
	if ( !empty( $logo ) || !empty( $mobile_menu ) ){
		$mobile_sandwich = "";
		$mobile_sandwich .= "<div class='sandwich_switcher' data-sandwich-action='toggle_mobile_menu' >";
			$mobile_sandwich .= "<a class='switcher'>";
				$mobile_sandwich .= "<span class='ham'>";
				$mobile_sandwich .= "</span>";
			$mobile_sandwich .= "</a>";
		$mobile_sandwich .= "</div>";
		echo "<section id='mobile_header'" . ( !empty( $mobile_header_class ) ? " class='$mobile_header_class'" : "" ) . ">";
				echo "<div class='unilearn_layout_container" . ( empty( $mobile_logo ) && !empty( $mobile_menu ) ? " a_right_flex" : "" ) . "'>";
				if ( !empty( $mobile_logo ) ){
					echo sprintf("%s", $mobile_logo);
					echo !empty( $mobile_menu ) ? $mobile_sandwich : "";
				}
				else{
					echo !empty( $mobile_menu ) ? $mobile_sandwich : "";
				}
				echo "</div>";
				if ( !empty( $mobile_menu ) ){
					echo "<div id='mobile_menu_wrapper'>";
						echo "<div class='unilearn_layout_container'>";
							echo sprintf("%s", $mobile_menu);
						echo "</div>";
					echo "</div>";	
				}				
		echo "</section>";
	}
	$site_header_html = ob_get_clean();
	return $site_header_html;
}
function unilearn_header (){
	$header = "";

	$header_page_meta_vars 	= unilearn_get_page_meta_var( array( 'header' ) );
	$page_override_header 	= !empty( $header_page_meta_vars );
	$customize_menu 		= (bool)unilearn_get_option( 'customize_menu' );
	$header_covers_slider 	= false;
	$menu_opacity 			= '100';
	if ( $page_override_header ){
		$header_covers_slider 	= isset( $header_page_meta_vars['header_covers_slider'] ) ? (bool)$header_page_meta_vars['header_covers_slider'] : $header_covers_slider;
		$menu_opacity 			= isset( $header_page_meta_vars['menu_opacity'] ) ? $header_page_meta_vars['menu_opacity'] : $menu_opacity;	
	}
	else{
		$header_covers_slider 	= (bool)unilearn_get_option( 'header_covers_slider' );
		if ( $customize_menu ){
			$menu_opacity 			= unilearn_get_option( 'menu_opacity' );
		}
	}
	$menu_opacity = (int)$menu_opacity;

	ob_start();
	get_template_part( "top_panel" );
	$top_panel = ob_get_clean();
	
	$site_header_html = unilearn_site_header_html();

	$slider = "";
	ob_start();
	get_template_part( 'slider' );
	$slider_section_content = ob_get_clean();
	if ( !empty( $slider_section_content ) ){
		$slider .= "<section id='main_slider_section'>";
			$slider .= $slider_section_content;
		$slider .= "</section>";
	}

	ob_start();
	get_template_part( "page_title" );
	$page_title = ob_get_clean();

	$header .= $header_covers_slider && empty( $slider ) ? "<div id='header_wrapper'>" : "";
		$header .= $top_panel;
		$header .= $menu_opacity < 20 ? "<hr class='header_divider' />" : "";
		$header .= $site_header_html;
		if ( empty( $slider ) ){
			$header .= $page_title;
		}
		else{
			$header .= $slider;
		}
	$header .= $header_covers_slider && empty( $slider ) ? "</div>" : "";

	echo sprintf("%s", $header);	
}

function unilearn_get_img_srcs ( $img_data = array(), $hdpi = false, $bfi_args = array() ){
	if ( empty( $img_data ) ) return false;
	$url = $img_data[0];	
	$srcs = array(
		'src' 					=> '',
		'retina_thumb_exists'	=> false,
		'retina_thumb_url'		=> '' 
	);
	if ( empty( $bfi_args ) ){
		if ( $hdpi ){
			$bfi_obj = bfi_thumb( $url, array( 'width' => floor( $img_data[1] / 2 ) ), false );
			$srcs['src'] = $bfi_obj[0];
			$srcs['retina_thumb_exists'] = $bfi_obj[3]["retina_thumb_exists"];
			$srcs['retina_thumb_url'] = $bfi_obj[3]["retina_thumb_url"];
		}
		else{
			$srcs['src'] = $url;
		}
	}
	else{
		$bfi_obj = bfi_thumb( $url, $bfi_args, false );
		$srcs['src'] = $bfi_obj[0];
		$srcs['retina_thumb_exists'] = $bfi_obj[3]["retina_thumb_exists"];
		$srcs['retina_thumb_url'] = $bfi_obj[3]["retina_thumb_url"];
	}
	return $srcs;
}

function unilearn_scroll_to_top (){
	ob_start();
	?>
	<div id='scroll_to_top' class='animated'>
		<i class='fa fa-angle-up'></i>
	</div>
	<?php
	return ob_get_clean();
}

function unilearn_get_post_term_links_str ( $tax = "", $delim = "&#x2c;&#x20;" ){
	$pid = get_the_id();
	$terms_arr = wp_get_post_terms( $pid, $tax );
	$terms = "";
	if ( is_wp_error( $terms_arr ) ){
		return $terms;
	}
	for( $i = 0; $i < count( $terms_arr ); $i++ ){
		$term_obj	= $terms_arr[$i];
		$term_slug	= $term_obj->slug;
		$term_name	= esc_html( $term_obj->name );
		$term_link	= esc_url( get_term_link( $term_slug, $tax ) );
		$terms		.= "<a href='$term_link'>$term_name</a>" . ( $i < ( count( $terms_arr ) - 1 ) ? $delim : "" ); 	
	}
	return $terms;	
}

function unilearn_dbl_to_sngl_quotes ( $content ){
	return preg_replace( "|\"|", "'", $content );
}
add_filter( "unilearn_dbl_to_sngl_quotes", "unilearn_dbl_to_sngl_quotes" );

function unilearn_Hex2RGBA( $hex, $opacity = '1' ) {
	$hex = str_replace('#', '', $hex);
	$color = '';

	if(strlen($hex) == 3) {
		$color = hexdec(substr($hex, 0, 1 )) . ',';
		$color .= hexdec(substr($hex, 1, 1 )) . ',';
		$color .= hexdec(substr($hex, 2, 1 )) . ',';
	}
	else if(strlen($hex) == 6) {
		$color = hexdec(substr($hex, 0, 2 )) . ',';
		$color .= hexdec(substr($hex, 2, 2 )) . ',';
		$color .= hexdec(substr($hex, 4, 2 )) . ',';
	}
	$color .= $opacity;
	return $color;
}

function unilearn_get_option($name) {
	$ret = null;
	if (is_customize_preview()) {
		global $cwsfw_settings;
		if (isset($cwsfw_settings[$name])) {
			$ret = $cwsfw_settings[$name];
			if (is_array($ret)) {
				$theme_options = get_option( 'unilearn' );
				if (isset($theme_options[$name])) {
					$to = $theme_options[$name];
					foreach ($ret as $key => $value) {
						$to[$key] = $value;
					}
					$ret = $to;
				}
			}
			return $ret;
		}
	}
	$theme_options = get_option( 'unilearn' );
	$ret = isset($theme_options[$name]) ? $theme_options[$name] : null;
	$ret = stripslashes_deep( $ret );
	return $ret;
}

function unilearn_get_all_fa_icons (){
	$meta = get_option('cws_fa');
	if (empty($meta) || (time() - $meta['t']) > 3600*7 ) {
		global $wp_filesystem;
		if( empty( $wp_filesystem ) ) {
			require_once( ABSPATH .'/wp-admin/includes/file.php' );
			WP_Filesystem();
		}
		$file = get_template_directory() . '/css/font-awesome.min.css';
		$fa_content = '';
		if ( $wp_filesystem && $wp_filesystem->exists($file) ) {
			$fa_content = $wp_filesystem->get_contents($file);
			if ( preg_match_all( "/fa-((\w+|-?)+):before/", $fa_content, $matches, PREG_PATTERN_ORDER ) ) {
				return $matches[1];
			}
		}
	} else {
		return $meta['fa'];
	}		
}

function unilearn_render_social_links (){
	$out = "";
	$social_group = unilearn_get_option( "social_group" );
	for ( $i = 0; $i < count( $social_group ); $i++ ){
		$social_icon = esc_html( $social_group[$i]['icon'] );
		$social_title = esc_html( $social_group[$i]['title'] );
		$social_url = esc_url( $social_group[$i]['url'] );
		if ( !empty( $social_icon ) ){
			$out .= "<a class='social_icon'" . ( !empty( $social_url ) ? " href='$social_url'" : "" ) . ( !empty( $social_title ) ? " title='$social_title'" : "" ) . "><i class='fa $social_icon'></i></a>";
		}
	}
	return $out;
}

function unilearn_pagination ( $paged=1, $max_paged=1, $dynamic = true ){
	$is_rtl = is_rtl();

	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts	= explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = $GLOBALS['wp_rewrite']->using_permalinks() ? trailingslashit( $pagenum_link ) . '%_%' : trailingslashit( $pagenum_link ) . '?%_%';
	$pagenum_link = add_query_arg( $query_args, $pagenum_link );

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : 'paged=%#%';
	$dynamic = $dynamic ? ' dynamic' : '';
	?>
	<div class="pagination<?php echo sprintf("%s", $dynamic); ?>">
		<div class='page_links'>
		<?php
		$pagination_args = array( 'base' => $pagenum_link,
									'format' => $format,
									'current' => $paged,
									'total' => $max_paged,
									"prev_text" => "<i class='fa fa-angle-" . ( $is_rtl ? "right" : "left" ) . "'></i>",
									"next_text" => "<i class='fa fa-angle-" . ( $is_rtl ? "left" : "right" ) . "'></i>",
									"link_before" => "",
									"link_after" => "",
									"before" => "",
									"after" => "",
									"mid_size" => 2,
									);
		$pagination = paginate_links( $pagination_args );
		echo sprintf("%s", $pagination);
		?>
		</div>
	</div>
	<?php
}

function unilearn_page_links(){
	$args = array(
	 'before'		   => ''
	,'after'			=> ''
	,'link_before'	  => '<span>'
	,'link_after'	   => '</span>'
	,'next_or_number'   => 'number'
	,'nextpagelink'	 =>  esc_html__("Next Page",'unilearn')
	,'previouspagelink' => esc_html__("Previous Page",'unilearn')
	,'pagelink'		 => '%'
	,'echo'			 => 0 );
	$pagination = wp_link_pages( $args );
	echo !empty( $pagination ) ? "<div class='pagination'><div class='page_links'>$pagination</div></div>" : "";
}

function unilearn_load_more ( $paged = 1, $max_paged = PHP_INT_MAX ){
	?>
		<a class="unilearn_button large unilearn_load_more" href="#"><?php echo esc_html__( "Load More", 'unilearn' ); ?></a>
	<?php
}

function unilearn_get_date_part ( $part = '' ){
	$part_val = '';
	$p_id = get_queried_object_id();
	$perm_struct = get_option( 'permalink_structure' );
	$use_perms = !empty( $perm_struct );
	$merge_date = get_query_var( 'm' );
	$match = preg_match( '#(\d{4})?(\d{1,2})?(\d{1,2})?#', $merge_date, $matches );
	switch ( $part ){
		case 'y':
			$part_val = $use_perms ? get_query_var( 'year' ) : ( isset( $matches[1] ) ? $matches[1] : '' );
			break;
		case 'm':
			$part_val = $use_perms ? get_query_var( 'monthnum' ) : ( isset( $matches[2] ) ? $matches[2] : '' );
			break;
		case 'd':
			$part_val = $use_perms ? get_query_var( 'day' ) : ( isset( $matches[3] ) ? $matches[3] : '' );
			break;
	}
	return $part_val;
}

function unilearn_body_font_styles (){
	$font_options = unilearn_get_option( 'body_font' );
	$font_family = esc_attr( $font_options['font-family'] );
	$font_size = esc_attr( $font_options['font-size'] );
	$line_height = esc_attr( $font_options['line-height'] );
	$font_color = esc_attr( $font_options['color'] );
	$font_styles = "";
	$font_styles .= "body,
					.main_menu .cws_megamenu_item{
						" . ( !empty( $font_family ) ? "font-family: $font_family;" : "" ) . "
						" . ( !empty( $font_size ) ? "font-size: $font_size;" : "" ) . "
						" . ( !empty( $line_height ) ? "line-height: $line_height;" : "" ) . "
						" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
					}";
	$font_styles .= "#wp-calendar td#prev a:before,
					#wp-calendar td#next a:before,
					.widget #searchform .screen-reader-text:before,
					#search_bar_item input[name='s']{
						" . ( !empty($font_size ) ? "font-size:$font_size;" : "" ) . "
					}";
	$font_styles .= ".site_header#sticky.alt .main_menu .menu-item,
						.unilearn_button,
						.unilearn_button.alt:hover,
						.testimonial.without_image .author_info + .author_info:before{
						" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
					}";
	$font_styles .= ".site_header#sticky.alt .main_menu.sandwich .sandwich_switcher .ham,
					.site_header#sticky.alt .main_menu.sandwich .sandwich_switcher .ham:before,
					.site_header#sticky.alt .main_menu.sandwich .sandwich_switcher .ham:after{
						" . ( !empty( $font_color ) ? "background-color: $font_color;" : "" ) . "
					}";
	$font_styles .= ".widget ul>li.recentcomments:before,
					.widget ul>li.recentcomments:after{
						width: $line_height;
						height: $line_height;
					}
					.widget .menu .pointer{
						height: $line_height;
					}
					";
/*	$font_styles .= "#footer_icl #lang_sel a{
						" . ( !empty( $line_height ) ? "line-height: $line_height;" : "" ) . "
					}
					";*/
	$font_styles .= !empty( $line_height ) ? ".dropcap{
						line-height: -webkit-calc($line_height*2);
						line-height: -ms-calc($line_height*2);
						line-height: calc($line_height*2);
						width: -webkit-calc($line_height*2);
						width: -ms-calc($line_height*2);
						width: calc($line_height*2);
					}
					" : "";			
	echo sprintf("%s", $font_styles);
}
add_action( 'unilearn_body_font_hook', 'unilearn_body_font_styles' );

function unilearn_menu_font_styles (){
	$font_options = unilearn_get_option( 'menu_font' );
	$font_family = esc_attr( $font_options['font-family'] );
	$font_size = esc_attr( $font_options['font-size'] );
	$line_height = esc_attr( $font_options['line-height'] );
	$font_color = esc_attr( $font_options['color'] );
	$font_styles = "";
	$font_styles .= ".main_menu .menu-item,
					#mobile_menu .megamenu_item_column_title,
					#mobile_menu .widget_nav_menu .menu-item{
						" . ( !empty( $font_family ) ? "font-family: $font_family;" : "" ) . "
						" . ( !empty( $font_size ) ? "font-size: $font_size;" : "" ) . "
						" . ( !empty( $line_height ) ? "line-height: $line_height;" : "" ) . "
						" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
					}";
	$font_styles .= ".main_menu.sandwich .sandwich_switcher .ham,
					.main_menu.sandwich .sandwich_switcher .ham:before,
					.main_menu.sandwich .sandwich_switcher .ham:after,
					#mobile_header .sandwich_switcher .ham,
					#mobile_header .sandwich_switcher .ham:before,
					#mobile_header .sandwich_switcher .ham:after{
						background-color: $font_color;
					}";
	$font_styles .= ".main_menu > .menu-item + .menu-item:before{
						" . ( !empty( $font_size ) ? "height:$font_size;" : "" ) . "
					}";
	$font_styles .= ".cws_megamenu_item .megamenu_item_column_title .pointer{
						" . ( !empty( $font_size ) ? "font-size:$font_size;" : "" ) . "
					}";
	$font_styles .= "#mobile_menu .menu-item:hover{
						" . ( !empty( $font_color ) ? "color:$font_color;" : "" ) . "
					}";
	echo sprintf("%s", $font_styles);
}
add_action( 'unilearn_menu_font_hook', 'unilearn_menu_font_styles' );

function unilearn_header_font_styles (){
	$font_options = unilearn_get_option( 'header_font' );
	$font_family = esc_attr( $font_options['font-family'] );
	$font_size = esc_attr( $font_options['font-size'] );
	$line_height = esc_attr( $font_options['line-height'] );
	$font_color = esc_attr( $font_options['color'] );
	$font_styles = "";
	$font_styles .= ".widgettitle{
						" . ( !empty( $font_family ) ? "font-family: $font_family;" : "" ) . "
						" . ( !empty( $font_size ) ? "font-size: $font_size;" : "" ) . "
						" . ( !empty( $line_height ) ? "line-height: $line_height;" : "" ) . "
						" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
					}";
	$font_styles .= ".widgettitle + .carousel_nav{
						" . ( !empty( $line_height ) ? "line-height: $line_height;" : "" ) . "
	}
	";
	$font_styles .= "h1, h2, h3, h4, h5, h6{
						" . ( !empty( $font_family ) ? "font-family: $font_family;" : "" ) . "
						" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
					}";
	$font_styles .= "ul, ol, blockquote, .widget ul a,
					.widget_header .carousel_nav > *:hover,
					.unilearn_sc_carousel_header .carousel_nav > *:hover,
					.pagination .page_links > a,
					#comments .comment_meta,
					.cws_staff_post.posts_grid_post:hover .post_title,
					.pricing_plan_content ul,
					.cws_megamenu_item .megamenu_item_column_title{
						" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
	}";
	$font_styles .= ".widget_header .carousel_nav > *:hover,
					.unilearn_sc_carousel_header .carousel_nav > *:hover{
						" . ( !empty( $font_color ) ? "border-color: $font_color;" : "" ) . "
	}";
	$font_styles .= "#banner_404,
					.pricing_plan_price{
					" . ( !empty( $font_family ) ? "font-family: $font_family;" : "" ) . "
	}";
	$font_styles .= "
					@media screen and ( min-width: 981px ){
						#page.single_sidebar .cws_staff_posts_grid.posts_grid_2 .cws_staff_post_title.posts_grid_post_title,
						#page.double_sidebar .cws_staff_posts_grid.posts_grid_2 .cws_staff_post_title.posts_grid_post_title{
							" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "							
						}
					}
	";
	$font_styles .= "
					@media screen and ( max-width: 479px ){
						.cws_staff_post_title.posts_grid_post_title{
							" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "							
						}
					}
	";
	echo sprintf("%s", $font_styles);
}
add_action( 'unilearn_header_font_hook', 'unilearn_header_font_styles' );

if ( !function_exists( "unilearn_custom_colors_styles" ) ){
	function unilearn_custom_colors_styles (){
		$theme_custom_color = esc_attr( unilearn_get_option( 'theme_color' ) );
		$theme_2_custom_color = esc_attr( unilearn_get_option( 'theme_2_color' ) );
		$theme_3_custom_color = esc_attr( unilearn_get_option( 'theme_3_color' ) );
		$footer_bg_color = esc_attr( unilearn_get_option( 'footer_bg_color' ) );
		$custom_colors_styles = "";
		$custom_colors_styles .= "a,
									ul li:before,
									ul.custom_icon_style .list_list,
									q:before, q:after,
									.main_menu .menu-item:hover,
									.main_menu .menu-item.current-menu-item,
									.main_menu .menu-item.current-menu-ancestor,
									#main_menu > .menu-item:hover,
									#main_menu > .menu-item.current-menu-item,
									#main_menu > .menu-item.current-menu-ancestor,
									#page_title,
									#page_title_section .bread-crumbs a:hover,
									.widget ul a:hover,
									.widget .social_icon,
									.latest_tweets .tweet:before,
									.gallery_post_carousel_nav:hover,
									h1 > a:hover,
									h2 > a:hover,
									h3 > a:hover,
									h4 > a:hover,
									h5 > a:hover,
									h6 > a:hover,
									.post_posts_grid_post_content.read_more_alt .more-link:hover,
									.post_post_terms,
									.cws_portfolio_post_terms,
									#comments .comments_number,
									#comments .author_name,
									.wp-playlist-light .wp-playlist-current-item:before,
									.wp-playlist-light .wp-playlist-tracks .wp-playlist-playing,
									.cws_staff_post_terms.single_post_terms,
									#footer_widgets .widget ul a:hover,
									#footer_social .social_icon:hover,
									#banner_404_title,
									.unilearn_icon,
									.unilearn_icon.alt.hovered:hover,
									.banner_icon,
									.unilearn_milestone,
									.unilearn_services_title,
									.unilearn_services_column:hover .unilearn_services_icon i,
									.testimonial .author_status,
									.pricing_plan_price,
									.vc_images_carousel .vc_carousel-control .icon-next:hover,
									.vc_images_carousel .vc_carousel-control .icon-prev:hover,
									.cws_twitter .cws_twitter_icon i,
									.select2-results .select2-highlighted,
									.widget_icon,
									.cws_megamenu_item .widget.widget_nav_menu .menu-item:hover,
									.cws_megamenu_item .widget.widget_nav_menu .menu-item:hover > a,
									.cws_megamenu_item .widget.widget_nav_menu .menu-item:hover > span,
									.cws_megamenu_item .widget.widget_nav_menu .menu-item:hover > .pointer,
									.cta_icon,
									span.wpcf7-form-control-wrap:first-of-type:last-of-type:first-child input.wpcf7-validates-as-required.wpcf7-not-valid + .wpcf7-not-valid-tip:after{
			color: $theme_custom_color;
		}
								hr:before,
								.post_terms .v_sep,
								.cws_staff_social_links.single_social_links > a + a{
			border-left-color: $theme_custom_color;
		}
								abbr{
			border-bottom-color: $theme_custom_color;
		}
								mark,
								.unilearn_button:hover,
								.more-link:hover,
								input[type='submit']:hover,
								button:hover,
								#top_panel_bar #searchsubmit,
								#top_panel_bar #searchsubmit:hover,
								.widget ul>li.recentcomments:after,
								.widget .menu .pointer:before,
								.widget .menu .pointer:after,
								.widget .menu .menu-item.active,
								.widget .menu .menu-item:hover,
								.widget_social .social_icon:hover,
								.post_post_header,
								.pic .hover-effect,
								.pagination .page_links > a:hover,
								a[rel^=\"attachment\"]:before,
								.gallery .gallery-item a:before,
								.pagination .page_links > span,
								.cws_portfolio_posts_grid.posts_grid_2 .item:hover .posts_grid_divider,
								.cws_portfolio_posts_grid.posts_grid_3 .item:hover .posts_grid_divider,
								.cws_portfolio_posts_grid.posts_grid_4 .item:hover .posts_grid_divider,
								.wp-playlist-light .wp-playlist-current-item,
								.owl-pagination .owl-page.active,
								#footer_widgets .widget .widget_header,
								#footer_widgets .widgettitle,
								.unilearn_icon.bordered.hovered:hover,
								.unilearn_icon.alt,
								.unilearn_button.alt,
								.dropcap,
								.unilearn_banner,
								.unilearn_pb_progress,
								.unilearn_services_icon i,
								.unilearn_services_divider,
								.pricing_plan_title,
								.cws_staff_social_links.single_social_links a:hover,
								#top_panel i{
			background-color: $theme_custom_color;
		}
								.unilearn_button,
								.more-link,
								input[type='submit'],
								button,
								.unilearn_icon.alt,
								.widget .social_icon,
								.latest_tweets .tweet:before,
								.pagination .page_links > a:hover,
								.pagination .page_links > span,
								.owl-pagination .owl-page,
								.unilearn_icon.bordered,
								.unilearn_services_icon i,
								.cws_staff_social_links.single_social_links,
								.cws_twitter .cws_twitter_icon i,
								.cta_icon,
								span.wpcf7-form-control-wrap:first-of-type:last-of-type:first-child input.wpcf7-not-valid{
			border-color: $theme_custom_color;
		}
								.main_menu > .menu-item >.sub-menu,
								.unilearn_services_column{
			border-top-color: $theme_custom_color;
		}
		";
		$custom_colors_styles .= ".star-rating>span:before,
									.comment-form-rating .stars .stars-active{
										color: $theme_2_custom_color;
									}#top_panel_bar #search_bar_item input[name='s']{
										background-color: rgba(" . unilearn_Hex2RGBA( $theme_custom_color, '0.85' ) . ");
									}hr:before,
									#top_panel_social_el,
									.post_post_header .comments_link,
									.unilearn_button.button_color_2:hover,
									.unilearn_button.alt.button_color_2{
										background-color: $theme_2_custom_color;
									}unilearn_button.button_color_2{
										border-color: $theme_2_custom_color;
									}
									";
		$custom_colors_styles .= "thead th,
									#wp-calendar th,
									.widget #searchform .screen-reader-text,
									.vc_toggle .vc_toggle_icon,
									.unilearn_button.button_color_3,
									span.wpcf7-form-control-wrap:first-of-type:last-of-type:first-child + input[type='submit']{
			border-color: $theme_3_custom_color;
		}
								.vc_tta.vc_general.vc_tta-tabs.vc_tta-tabs-position-top .vc_tta-tab.vc_active{
			border-top-color: $theme_3_custom_color;
		}
								.vc_tta.vc_general.vc_tta-tabs.vc_tta-tabs-position-bottom .vc_tta-tab.vc_active{
			border-bottom-color: $theme_3_custom_color;
		}
								hr:before{
			border-right-color: $theme_3_custom_color;
		}
								#wp-calendar td:not(#prev):not(#next) a,
								#wp-calendar td:not(#prev):not(#next) a:before,
								#wp-calendar td:not(#prev):not(#next) a:after,
								.widget #searchform .screen-reader-text,
								.vc_tta.vc_general.vc_tta-accordion .vc_tta-panel-title > a,
								.vc_toggle.vc_toggle_active .vc_toggle_icon,
								.unilearn_button.button_color_3:hover,
								.unilearn_button.alt.button_color_3,
								span.wpcf7-form-control-wrap:first-of-type:last-of-type:first-child + input[type='submit'],
								.post_post.sticky > .post_post_header{
			background-color: $theme_3_custom_color;
		}
								#wp-calendar td#prev a:hover:before,
								#wp-calendar td#next a:hover:before,
								.widget #searchform .screen-reader-text.hover,
								.vc_toggle .vc_toggle_icon,
								.vc_toggle.vc_toggle_active .vc_toggle_title > h4{
			color: $theme_3_custom_color;
		}
								#scroll_to_top{
			background-color: $footer_bg_color;
		}";
		$custom_colors_styles .= "
								.vc_tta.vc_general .vc_tta-panel.vc_active .vc_tta-panel-heading{
									border-color: $theme_3_custom_color !important;
		}
								.vc_tta.vc_general .vc_tta-panel.vc_active .vc_tta-panel-title > a{
										background-color: $theme_3_custom_color !important;
		}
		";
		$custom_colors_styles .= "
			.vc_row.top_line,
			.vc_row.bottom_line{
				-webkit-border-image: -webkit-linear-gradient( left, transparent 0, transparent 15px, #f2f2f2 15px, #f2f2f2 -webkit-calc(50% - 65px), $theme_custom_color -webkit-calc(50% - 65px), $theme_custom_color -webkit-calc(50% - 20px), $theme_2_custom_color -webkit-calc(50% - 20px), $theme_2_custom_color -webkit-calc(50% + 25px), $theme_3_custom_color -webkit-calc(50% + 25px), $theme_3_custom_color -webkit-calc(50% + 70px), #f2f2f2 -webkit-calc(50% + 70px), #f2f2f2 -webkit-calc(100% - 15px), transparent -webkit-calc(100% - 15px), transparent 100% ) 1 0 round;
				border-image: -webkit-linear-gradient( left, transparent 0, transparent 15px, #f2f2f2 15px, #f2f2f2 -webkit-calc(50% - 65px), $theme_custom_color -webkit-calc(50% - 65px), $theme_custom_color -webkit-calc(50% - 20px), $theme_2_custom_color -webkit-calc(50% - 20px), $theme_2_custom_color -webkit-calc(50% + 25px), $theme_3_custom_color -webkit-calc(50% + 25px), $theme_3_custom_color -webkit-calc(50% + 70px), #f2f2f2 -webkit-calc(50% + 70px), #f2f2f2 -webkit-calc(100% - 15px), transparent -webkit-calc(100% - 15px), transparent 100% ) 1 0 round;
				border-image: linear-gradient( left, transparent 0, transparent 15px, #f2f2f2 15px, #f2f2f2 -webkit-calc(50% - 65px), $theme_custom_color -webkit-calc(50% - 65px), $theme_custom_color -webkit-calc(50% - 20px), $theme_2_custom_color -webkit-calc(50% - 20px), $theme_2_custom_color -webkit-calc(50% + 25px), $theme_3_custom_color -webkit-calc(50% + 25px), $theme_3_custom_color -webkit-calc(50% + 70px), #f2f2f2 -webkit-calc(50% + 70px), #f2f2f2 -webkit-calc(100% - 15px), transparent -webkit-calc(100% - 15px), transparent 100% ) 1 0 round;	
				-o-border-image: -o-linear-gradient( left, transparent 0, transparent 15px, #f2f2f2 15px, #f2f2f2 calc(50% - 65px), $theme_custom_color calc(50% - 65px), $theme_custom_color calc(50% - 20px), $theme_2_custom_color calc(50% - 20px), $theme_2_custom_color calc(50% + 25px), $theme_3_custom_color calc(50% + 25px), $theme_3_custom_color calc(50% + 70px), #f2f2f2 calc(50% + 70px), #f2f2f2 calc(100% - 15px), transparent calc(100% - 15px), transparent 100% ) 1 0 round;
				-moz-border-image: -moz-linear-gradient( left, transparent 0, transparent 15px, #f2f2f2 15px, #f2f2f2 -moz-calc(50% - 65px), $theme_custom_color -moz-calc(50% - 65px), $theme_custom_color -moz-calc(50% - 20px), $theme_2_custom_color -moz-calc(50% - 20px), $theme_2_custom_color -moz-calc(50% + 25px), $theme_3_custom_color -moz-calc(50% + 25px), $theme_3_custom_color -moz-calc(50% + 70px), #f2f2f2 -moz-calc(50% + 70px), #f2f2f2 -moz-calc(100% - 15px), transparent -moz-calc(100% - 15px), transparent 100% ) 1 0 round;
				-o-border-image: linear-gradient( left, transparent 0, transparent 15px, #f2f2f2 15px, #f2f2f2 calc(50% - 65px), $theme_custom_color calc(50% - 65px), $theme_custom_color calc(50% - 20px), $theme_2_custom_color calc(50% - 20px), $theme_2_custom_color calc(50% + 25px), $theme_3_custom_color calc(50% + 25px), $theme_3_custom_color calc(50% + 70px), #f2f2f2 calc(50% + 70px), #f2f2f2 calc(100% - 15px), transparent calc(100% - 15px), transparent 100% ) 1 0 round;
				border-image: -moz-linear-gradient( left, transparent 0, transparent 15px, #f2f2f2 15px, #f2f2f2 -moz-calc(50% - 65px), $theme_custom_color -moz-calc(50% - 65px), $theme_custom_color -moz-calc(50% - 20px), $theme_2_custom_color -moz-calc(50% - 20px), $theme_2_custom_color -moz-calc(50% + 25px), $theme_3_custom_color -moz-calc(50% + 25px), $theme_3_custom_color -moz-calc(50% + 70px), #f2f2f2 -moz-calc(50% + 70px), #f2f2f2 -moz-calc(100% - 15px), transparent -moz-calc(100% - 15px), transparent 100% ) 1 0 round;
				border-image: linear-gradient( left, transparent 0, transparent 15px, #f2f2f2 15px, #f2f2f2 calc(50% - 65px), $theme_custom_color calc(50% - 65px), $theme_custom_color calc(50% - 20px), $theme_2_custom_color calc(50% - 20px), $theme_2_custom_color calc(50% + 25px), $theme_3_custom_color calc(50% + 25px), $theme_3_custom_color calc(50% + 70px), #f2f2f2 calc(50% + 70px), #f2f2f2 calc(100% - 15px), transparent calc(100% - 15px), transparent 100% ) 1 0 round;
			}
		";
		echo sprintf("%s", $custom_colors_styles);
	}
}
add_action( 'unilearn_custom_colors_hook', 'unilearn_custom_colors_styles' );

function unilearn_header_styles (){
	$p_id = get_queried_object_id();
	$post_type = get_post_type( $p_id );

	$header_bg_color = esc_attr( unilearn_get_option( 'header_bg_color' ) );
	$header_font_color = esc_attr( unilearn_get_option( 'header_font_color' ) );

	$header_page_meta_vars 	= unilearn_get_page_meta_var( array( 'header' ) );
	$page_override_header 	= !empty( $header_page_meta_vars );
	$customize_menu 		= (bool)unilearn_get_option( 'customize_menu' );
	$header_covers_slider 	= false;
	$menu_opacity 			= '100';
	if ( $page_override_header ){
		$header_covers_slider 	= isset( $header_page_meta_vars['header_covers_slider'] ) ? (bool)$header_page_meta_vars['header_covers_slider'] : $header_covers_slider;
		$menu_opacity 			= isset( $header_page_meta_vars['menu_opacity'] ) ? $header_page_meta_vars['menu_opacity'] : $menu_opacity;	
	}
	else{
		$header_covers_slider 	= (bool)unilearn_get_option( 'header_covers_slider' );
		if ( $customize_menu ){
			$menu_opacity 			= unilearn_get_option( 'menu_opacity' );
		}
	}
	$menu_bg_color 			= unilearn_get_option( 'menu_bg_color' );
	$menu_font_color 		= unilearn_get_option( 'menu_font_color' );

	$menu_opacity_css = $menu_opacity !== "" ? strval( (int)$menu_opacity / 100 ) : "";
	$post_thumb_url = "";
	if ( has_post_thumbnail () && !in_array( $post_type, array( 'post', 'cws_portfolio', 'cws_staff', 'product', 'lp_course' ) ) ){
		$post_thumb_id = get_post_thumbnail_id( $p_id );
		$post_thumb_obj = !empty( $post_thumb_id ) ? wp_get_attachment_image_src( $post_thumb_id, 'full' ) : array();
		$post_thumb_url = isset( $post_thumb_obj[0] ) ? $post_thumb_obj[0] : "";		
	}
	else{
		$post_thumb_obj = unilearn_get_option( 'default_header_image' );
		$post_thumb_url = isset( $post_thumb_obj['src'] ) ? $post_thumb_obj['src'] : "";
	}
	$header_styles = "";
	$header_styles .= "
	#top_panel i{
		color: $header_bg_color;
	}
	";
	$header_styles .= "#top_panel,
							#page_title_section,
							#top_panel_social .social_icon{
		color: $header_font_color;
	}";
	if ( $customize_menu ){
		if ( $menu_opacity_css !== "" ){
			$header_styles .=  "
				#site_header,
				#mobile_header{
					background-color:rgba(" . unilearn_Hex2RGBA( $menu_bg_color, $menu_opacity_css ) . ");
			}";
		}
		else{
			$header_styles .=  "
				#site_header,
				#mobile_header{
					background-color:$menu_bg_color;
			}";
		}
		$header_styles .= "
		#main_menu > .menu-item{
			color: $menu_font_color;
		}
		#main_menu.sandwich .sandwich_switcher .ham,
		#main_menu.sandwich .sandwich_switcher .ham:before,
		#main_menu.sandwich .sandwich_switcher .ham:after,
		#mobile_header .sandwich_switcher .ham,
		#mobile_header .sandwich_switcher .ham:before,
		#mobile_header .sandwich_switcher .ham:after{
			background-color: $menu_font_color;
		}
		";		
	}
	else{
		if ( $menu_opacity_css !== "" ){
			$header_styles .=  "
				#site_header,
				#mobile_header{
					background-color:rgba(" . unilearn_Hex2RGBA( "#ffffff", $menu_opacity_css ) . ");
			}";
		}
	}
	if ( $header_covers_slider ){
		$header_styles .= "
		#header_wrapper{
			background-color: $header_bg_color;
		}
		";
		if ( !empty( $post_thumb_url ) ){
			$header_styles .= "
			#header_wrapper{
				background-image: url($post_thumb_url);
			}
			";			
		}
	}
	else{
		$header_styles .= "
		#top_panel,
		#page_title_section{
			background-color: $header_bg_color;
		}
		";
		if ( !empty( $post_thumb_url ) ){
			$header_styles .= "
			#page_title_section{
				background-image: url($post_thumb_url);
			}
			";			
		}
	}
	echo sprintf("%s", $header_styles);
}
add_action( 'unilearn_header_styles_hook', 'unilearn_header_styles' );

function unilearn_footer_widgets_styles (){
	$footer_bg_color 	= unilearn_get_option( 'footer_bg_color' );
	$footer_bg_color 	= esc_attr( $footer_bg_color );
	$footer_font_color	= unilearn_get_option( 'footer_font_color' );
	$footer_font_color 	= esc_attr( $footer_font_color );
	$footer_title_color	= unilearn_get_option( 'footer_title_color' );
	$footer_title_color = esc_attr( $footer_title_color );
	ob_start();
	echo "
		#footer_widgets{
			background-color: 	$footer_bg_color;
			color:				$footer_font_color;
		}
		#footer_widgets .carousel_nav > *{
			color: 			$footer_font_color;
			border-color:	$footer_font_color;
		}
		#footer_widgets h1,
		#footer_widgets h2,
		#footer_widgets h3,
		#footer_widgets h4,
		#footer_widgets h5,
		#footer_widgets h6,
		#footer_widgets i,
		#footer_widgets .carousel_nav > *:hover,
		#footer_widgets .widget ul a,
		#footer_widgets .widget.custom_color input[type='submit']:hover,
		#footer_widgets .widget input,
		#footer_widgets .widget textarea{
			color:			$footer_title_color;
		}
		#footer_widgets .widget_icon{
			color: $footer_bg_color !important;
		}
		#footer_widgets .carousel_nav > *:hover{
			border-color:	$footer_title_color;
		}
		#footer_widgets .widget_header .carousel_nav > *:hover{
			background-color: $footer_title_color;
		}
	";
	$styles = ob_get_clean();
	if ( is_page() ){
		$footer_sb = unilearn_get_page_meta_var ( array( 'footer', 'footer_sb_top' ) );
	}
	else{
		$footer_sb = unilearn_get_option( 'footer_sb' );
	}
	if ( is_active_sidebar( $footer_sb ) ){
		echo sprintf("%s", $styles);
	}
}
add_action( 'unilearn_footer_widgets_styles_hook', 'unilearn_footer_widgets_styles' );

function unilearn_footer_copyrights_styles (){
	$copyrights_bg_color = unilearn_get_option( 'copyrights_bg_color' );
	$copyrights_bg_color = esc_attr( $copyrights_bg_color );
	$copyrights_font_color = unilearn_get_option( 'copyrights_font_color' );
	$copyrights_font_color = esc_attr( $copyrights_font_color );
	ob_start();
	echo "
		#site_footer{
			background-color: $copyrights_bg_color;
			color: $copyrights_font_color;
		}
		#footer_social .social_icon{
			color: $copyrights_font_color;
		}
	";
	$styles = ob_get_clean();
	echo sprintf("%s", $styles);
}
add_action( 'unilearn_footer_copyrights_styles_hook', 'unilearn_footer_copyrights_styles' );

function unilearn_front_dynamic_styles (){
	ob_start();
	echo "
		#document > #wpadminbar{
			margin-top: auto;
		}
	";
	echo ob_get_clean();
}
add_action( 'unilearn_front_dynamic_styles_hook', 'unilearn_front_dynamic_styles' );

function unilearn_back_dynamic_styles (){
	ob_start();
	echo "
	";
	echo ob_get_clean();
}
add_action( 'unilearn_back_dynamic_styles_hook', 'unilearn_back_dynamic_styles' );

function unilearn_get_sidebars() {
	$sidebar_pos = "";
	if ( is_home() ){
		$sidebar_pos = unilearn_get_option( 'def-home-layout' );
		$sidebar1 = unilearn_get_option( 'def-home-sidebar1' );
		$sidebar2 = unilearn_get_option( 'def-home-sidebar2' );		
	}
	else if ( is_front_page() ){
		$p_id = get_queried_object_id ();
		$unilearn_stored_meta = get_post_meta( $p_id, UNILEARN_MB_PAGE_LAYOUT_KEY );
		$sidebar1 = $sidebar2 = $sidebar_pos = $sb_block = '';
		if ( isset( $unilearn_stored_meta[0] ) ) {
			$sidebar_pos = $unilearn_stored_meta[0]['sb_layout'];
			if ( $sidebar_pos == 'default' ) {
				$sidebar_pos = unilearn_get_option( 'def-home-layout' );
				$sidebar1 = unilearn_get_option( 'def-home-sidebar1' );
				$sidebar2 = unilearn_get_option( 'def-home-sidebar2' );

			} else {
				$sidebar1 = isset( $unilearn_stored_meta[0]['sidebar1'] ) ? $unilearn_stored_meta[0]['sidebar1'] : '';
				$sidebar2 = isset( $unilearn_stored_meta[0]['sidebar2'] ) ? $unilearn_stored_meta[0]['sidebar2'] : '';
			}
		} else {
			$sidebar_pos = unilearn_get_option( 'def-home-layout' );
			$sidebar1 = unilearn_get_option( 'def-home-sidebar1' );
			$sidebar2 = unilearn_get_option( 'def-home-sidebar2' );
		}
	}
 	else if ( is_category() || is_tag() || is_archive() ) {
		$sidebar_pos = unilearn_get_option( 'def-blog-layout' );
		$sidebar1 = unilearn_get_option( 'def-blog-sidebar1' );
		$sidebar2 = unilearn_get_option( 'def-blog-sidebar2' );
	} else if ( is_search() ) {
		$sidebar_pos = unilearn_get_option( 'def-page-layout' );
		$sidebar1 = unilearn_get_option( 'def-page-sidebar1' );
		$sidebar2 = unilearn_get_option( 'def-page-sidebar2' );
	}else if ( is_single() ) {
		$p_id = get_queried_object_id ();
		$post_type = get_post_type($p_id);
		if( in_array( $post_type, array( 'attachment', 'cws_portfolio', 'cws_staff' ) ) ){
			$sidebar_pos = unilearn_get_option("def-page-layout");
			$sidebar1 = unilearn_get_option("def-page-sidebar1");
			$sidebar2 = unilearn_get_option("def-page-sidebar2");
		}else if ( in_array( $post_type, array( 'post', 'attachment' ) ) ){
			$sidebar_pos = unilearn_get_option("def-blog-layout");
			$sidebar1 = unilearn_get_option("def-blog-sidebar1");
			$sidebar2 = unilearn_get_option("def-blog-sidebar2");			
		}else{
			$sidebar_pos = unilearn_get_option("def-page-layout");
			$sidebar1 = unilearn_get_option("def-page-sidebar1");
			$sidebar2 = unilearn_get_option("def-page-sidebar2");			
		}		
	}
	else if ( is_tax() ){
		$sidebar_pos = unilearn_get_option("def-page-layout");
		$sidebar1 = unilearn_get_option("def-page-sidebar1");
		$sidebar2 = unilearn_get_option("def-page-sidebar2");		
	}
	else if ( is_page() ){
		$p_id = get_queried_object_id ();
		$unilearn_stored_meta = get_post_meta( $p_id, UNILEARN_MB_PAGE_LAYOUT_KEY );
		$sidebar1 = $sidebar2 = $sidebar_pos = $sb_block = '';
		if ( isset( $unilearn_stored_meta[0] ) ) {
			$sidebar_pos = $unilearn_stored_meta[0]['sb_layout'];
			if ( $sidebar_pos == 'default' ) {
				$sidebar_pos = unilearn_get_option( 'def-page-layout' );
				$sidebar1 = unilearn_get_option( 'def-page-sidebar1' );
				$sidebar2 = unilearn_get_option( 'def-page-sidebar2' );

			} else {
				$sidebar1 = isset( $unilearn_stored_meta[0]['sidebar1'] ) ? $unilearn_stored_meta[0]['sidebar1'] : '';
				$sidebar2 = isset( $unilearn_stored_meta[0]['sidebar2'] ) ? $unilearn_stored_meta[0]['sidebar2'] : '';
			}
		} else {
			$sidebar_pos = unilearn_get_option( 'def-page-layout' );
			$sidebar1 = unilearn_get_option( 'def-page-sidebar1' );
			$sidebar2 = unilearn_get_option( 'def-page-sidebar2' );
		}
	}


	$ret = array();
	$ret['sb_layout'] = isset( $sidebar_pos ) ? $sidebar_pos : '';
	$ret['sidebar1'] = isset( $sidebar1 ) ? $sidebar1 : '';
	$ret['sidebar2'] = isset( $sidebar2 ) ? $sidebar2 : '';

	$sb_enabled = $ret['sb_layout'] != 'none';
	$ret['sb1_exists'] = $sb_enabled && is_active_sidebar( $ret['sidebar1'] );
	$ret['sb2_exists'] = $sb_enabled && $ret['sb_layout'] == 'both' && is_active_sidebar( $ret['sidebar2'] );

	$ret['sb_exist'] = $ret['sb1_exists'] || $ret['sb2_exists'];
	$ret['sb_layout_class'] = in_array( $sidebar_pos, array( 'left', 'right' ) ) ? 'single' : ( ( $sidebar_pos === "both" ) ? 'double' : '' );

	return $ret;
}

function unilearn_get_page_meta_var( $keys = array() ){
	$p_meta = array();
	if ( isset( $GLOBALS['unilearn_page_meta'] ) ) {
		$p_meta = $GLOBALS['unilearn_page_meta'];
	} else {
		return false;
	}
	if ( is_string( $keys ) && ! empty( $keys ) ) {
		if ( isset( $p_meta[ $keys ] ) ) {
			return  $p_meta[ $keys ];
		} else {
			return false;
		}
	} else if ( is_array( $keys ) && ! empty( $keys ) ) {
		for ( $i = 0; $i < count( $keys ); $i++ ) {
			if ( isset( $p_meta[ $keys[ $i ] ] ) ) {
				if ( $i < count( $keys ) - 1 ) {
					if ( is_array( $p_meta[ $keys[ $i ] ] ) ) {
						$p_meta = $p_meta[ $keys[ $i ] ];
					} else {
						return false;
					}
				} else {
					return $p_meta[ $keys[ $i ] ];
				}
			} else {
				return false;
			}
		}
	} else {
		return false;
	}
}

function unilearn_render_gradient_rules( $args = array() ) {
	extract( shortcode_atts( array(
		'settings' => array(),
		'selectors' => '',
		'use_extra_rules' => false
	), $args));
	$selectors_wth_pseudo = '';
	extract( shortcode_atts( array(
		'first_color' => UNILEARN_THEME_COLOR,
		'second_color' => '#0eecbd',
		'type' => 'linear',
		'angle' => '45',
		'shape_settings' => 'simple',
		'shape' => 'ellipse',
		'size_keyword' => '',
		'size' => ''
	), $settings));
	$out = '';
	$rules = '';
	$border_extra_rules = "border-color: transparent;\n-moz-background-clip: border;\n-webkit-background-clip: border;\nbackground-clip: border-box;\n-moz-background-origin:border;\n-webkit-background-origin:border;\nbackground-origin:border-box;\nbackground-repeat: no-repeat;";
	$transition_extra_rules = "-webkit-transition-property: background, color, border-color, opacity;\n-webkit-transition-duration: 0s, 0s, 0s, 0.6s;\n-o-transition-property: background, color, border-color, opacity;\n-o-transition-duration: 0s, 0s, 0s, 0.6s;\n-moz-transition-property: background, color, border-color, opacity;\n-moz-transition-duration: 0s, 0s, 0s, 0.6s;\ntransition-property: background, color, border-color, opacity;\ntransition-duration: 0s, 0s, 0s, 0.6s;";
	if ( $type == 'linear' ) {
		$rules .= "background: -webkit-linear-gradient(" . $angle . "deg, $first_color, $second_color);";
		$rules .= "background: -o-linear-gradient(" . $angle . "deg, $first_color, $second_color);";
		$rules .= "background: -moz-linear-gradient(" . $angle . "deg, $first_color, $second_color);";
		$rules .= "background: linear-gradient(" . $angle . "deg, $first_color, $second_color);";
	}
	else if ( $type == 'radial' ) {
		if ( $shape_settings == 'simple' ) {
			$rules .= "background: -webkit-radial-gradient(" . ( !empty( $shape ) ? " " . $shape . "," : "" ) . " $first_color, $second_color);";
			$rules .= "background: -o-radial-gradient(" . ( !empty( $shape ) ? " " . $shape . "," : "" ) . " $first_color, $second_color);";
			$rules .= "background: -moz-radial-gradient(" . ( !empty( $shape ) ? " " . $shape . "," : "" ) . " $first_color, $second_color);";
			$rules .= "background: radial-gradient(" . ( !empty( $shape ) ? " " . $shape . "," : "" ) . " $first_color, $second_color);";
		}
		else if ( $shape_settings == 'extended' ) {
			$rules .= "background: -webkit-radial-gradient(" . ( !empty( $size ) ? " " . $size . "," : "" ) . ( !empty( $size_keyword ) ? " " . $size_keyword . "," : "" ) . " $first_color, $second_color);";
			$rules .= "background: -o-radial-gradient(" . ( !empty( $size ) ? " " . $size . "," : "" ) . ( !empty( $size_keyword ) ? " " . $size_keyword . "," : "" ) . " $first_color, $second_color);";
			$rules .= "background: -moz-radial-gradient(" . ( !empty( $size ) ? " " . $size . "," : "" ) . ( !empty( $size_keyword ) ? " " . $size_keyword . "," : "" ) . " $first_color, $second_color);";
			$rules .= "background: radial-gradient(" . ( !empty( $size_keyword ) && !empty( $size ) ? " $size_keyword at $size" : "" ) . " $first_color, $second_color);";
		}
	}
	if ( !empty( $rules ) ) {
		$out .= !empty( $selectors ) ? "$selectors{\n$rules\n}" : $rules;
		if ( $use_extra_rules ) {
			$out .= !empty( $selectors ) ? "$selectors{\n$border_extra_rules\n}" : $border_extra_rules;
			$out .= !empty( $selectors ) ? "\n$selectors{\ncolor: #fff !important;\n}" : "color: #fff !important;";
			if ( !empty( $selectors ) ) {
				$selectors_wth_pseudo = str_replace( array( ":hover" ), "", $selectors );
				if ( !empty( $selectors_wth_pseudo ) ) {
					$out .= "\n$selectors_wth_pseudo{\n$transition_extra_rules\n}";
				}
			}
			else{
				$out .= $transition_extra_rules;
			}
		}
	}
	return preg_replace('/\s+/',' ', $out);
}

function unilearn_widgets_init (){
	global $wp_registered_sidebars;
	register_widget( 'Unilearn_Social_Widget' );
	register_widget( 'Unilearn_Twitter_Widget' );
	register_widget( 'Unilearn_CWS_Staff_Widget' );
	register_widget( 'Unilearn_Latest_Posts' );
	register_widget( 'Unilearn_Text_Widget' );
	if ( !array_key_exists( 'page_left_sidebar', $wp_registered_sidebars ) ){
		register_sidebar( array(
			'name' => esc_html__( 'Page Left Sidebar', 'unilearn' ),
			'id' => 'page_left_sidebar',
			'before_title'	=> "<h3 class=\"widgettitle\">",
			'after_title'	=> "</h3>"
		));
	}
	if ( !array_key_exists( 'page_right_sidebar', $wp_registered_sidebars ) ){
		register_sidebar( array(
			'name' => esc_html__( 'Page Right Sidebar', 'unilearn' ),
			'id' => 'page_right_sidebar',
			'before_title'	=> "<h3 class=\"widgettitle\">",
			'after_title'	=> "</h3>"
		));	
	}
	if ( !array_key_exists( 'footer_area', $wp_registered_sidebars ) ){
		register_sidebar( array(
			'name' => esc_html__( 'Footer', 'unilearn' ),
			'id' => 'footer_area',
			'before_title'	=> "<h3 class=\"widgettitle\">",
			'after_title'	=> "</h3>"
		));	
	}
	$sidebars = unilearn_get_option('sidebars');
	if (!empty($sidebars) && function_exists('register_sidebars') ) {
		foreach ($sidebars as $k => $sb) {
			if ( isset( $sb['title'] ) && !empty( $sb['title'] ) ) {
				register_sidebar( array(
				'name' => $sb['title'],
				'id' => strtolower(preg_replace("/[^a-z0-9\-]+/i", "_", $sb['title'])),
				));
			}
		}
	}
}
add_action( 'widgets_init', 'unilearn_widgets_init' );

/******************** TESTIMONIAL ********************/

function unilearn_testimonial_renderer( $atts ) {
	extract( shortcode_atts( array(
		'thumbnail'		=> null,
		'quote'			=> '',
		'author_name'	=> '',
		'author_status'	=> '',
		'el_class'		=> ''
	), $atts));
	$quote        	= esc_html( $quote );
	$author_name 	= esc_html( $author_name );
	$author_status	= esc_html( $author_status );
	$el_class    	= esc_attr( $el_class );
	ob_start();
	$author_section = '';
	if ( !empty( $thumbnail ) ) {
		$author_section .= "<figure class='author'>";
			if ( !empty( $thumbnail ) ) {
				$thumb_obj = bfi_thumb( $thumbnail, array( 'width'=>98, 'height'=>98 ), false );
				$thumb_url = isset( $thumb_obj[0] ) ? esc_url( $thumb_obj[0] ) : "";
				if ( isset( $thumb_obj[3] ) ){
					extract( $thumb_obj[3] );
				}
				else{
	                $retina_thumb_exists = false;
	                $retina_thumb_url = '';
				}
				if ( $retina_thumb_exists ) {
					$author_section .= "<span class='thumb'><img src='$thumb_url' data-at2x='$retina_thumb_url' alt /></span>";
				}
				else{
					$author_section .= "<span class='thumb'><img src='$thumb_url' data-no-retina alt /></span>";
				}
			}
			if ( !empty( $author_name ) || !empty( $author_status ) ){
				$author_section .= "<figcaption>";
					$author_section .= !empty( $author_name ) ? "<span class='author_name author_info'>" . esc_html( $author_name ) . "</span>" : "";
					$author_section .= !empty( $author_status ) ? "<span class='author_status author_info'>" . esc_html( $author_status ) . "</span>" : "";
				$author_section .= "</figcaption>";
			}
		$author_section .= "</figure>";
	}
	else{
		$author_section .= "<div class='author'>";
			$author_section .= !empty( $author_name ) ? "<span class='author_name author_info'>" . esc_html( $author_name ) . "</span>" : "";
			$author_section .= !empty( $author_status ) ? "<span class='author_status author_info'>" . esc_html( $author_status ) . "</span>" : "";			
		$author_section .= "</div>";
	}
	$quote_section_class = "quote";
	$quote_section_atts = '';
	$quote_section_atts .= !empty( $quote_section_class ) ? " class='" . trim( $quote_section_class ) . "'" : '';
	$quote = esc_html($quote);
	$quote_section = "";
	if ( !empty( $quote ) ){
		$quote_section .= "<div" . ( !empty( $quote_section_atts ) ? $quote_section_atts : "" ) . ">";
			$quote_section .= "<q>$quote</q>";
		$quote_section .= "</div>";
	}
	$cws_test_img_class = $thumbnail ? '' : 'without_image';
	?>
	<div class="testimonial unilearn_module clearfix <?php echo sprintf("%s", $cws_test_img_class); echo !empty( $el_class ) ? " $el_class" : ""; ?>">
		<?php
		if (!empty($thumbnail)) {
			echo sprintf("%s%s", $author_section, $quote_section);
		}
		else{
			echo sprintf("%s%s", $quote_section, $author_section);
		}
		?>
	</div>
	<?php
	return ob_get_clean();
}

/******************** \TESTIMONIAL ********************/

/****************** POSTS GRID AJAX *******************/

function unilearn_posts_grid_dynamic_pagination (){
	extract( wp_parse_args( $_POST['data'], array(
		'section_id'				=> '',
		'post_type' 				=> '',
		'post_hide_meta'			=> array(),
		'cws_portfolio_data_to_show'=> '',
		'cws_staff_data_to_hide'	=> array(),
		'layout'					=> '1',
		'sb_layout'					=> '',
		'total_items_count'			=> get_option( 'posts_per_page' ),
		'items_pp'					=> get_option( 'posts_per_page' ),
		'page'						=> '1',
		'tax'						=> '',
		'terms'						=> array(),
		'filter'					=> 'false',
		'current_filter_val'		=> '',
		'req_page_url'				=> '',
		'addl_query_args'			=> array()
	)));
	$req_page = $page;
	if ( !empty( $req_page_url ) ){
		$match = preg_match( "#paged?(=|/)(\d+)#", $req_page_url, $matches );
		$req_page = $match ? $matches[2] : '1';								// if page parameter absent show first page 
	};
	$not_in = ( 1 == $req_page ) ? array() : get_option( 'sticky_posts' );
	$query_args = array('post_type'			=> array( $post_type ),
						'post_status'		=> 'publish',
						'post__not_in'		=> $not_in
						);
	$query_args['posts_per_page']		= $items_pp;
	$query_args['paged']				= $req_page;
	if ( $filter == 'true' && $current_filter_val != '_all_' && !empty( $current_filter_val ) ){
		$terms = array( $current_filter_val );
	}
	if ( !empty( $terms ) ){
		$query_args['tax_query'] = array(
			array(
				'taxonomy'		=> $tax,
				'field'			=> 'slug',
				'terms'			=> $terms
			)
		);
	}
	if ( in_array( $post_type, array( "cws_portfolio", "cws_staff" ) ) ){
		$query_args['orderby'] 	= "menu_order date title";
		$query_args['order']	= "ASC";
	}
	$query_args = array_merge( $query_args, $addl_query_args );
	$q = new WP_Query( $query_args );
	$found_posts = $q->found_posts;
	$max_paged = $found_posts > $total_items_count ? ceil( $total_items_count / $items_pp ) : ceil( $found_posts / $items_pp );
	$GLOBALS['unilearn_posts_grid_atts'] = array(
		'layout'					=> $layout,
		'sb_layout'					=> $sb_layout,
		'post_hide_meta'			=> $post_hide_meta,
		'cws_portfolio_data_to_show'=> $cws_portfolio_data_to_show,
		'cws_staff_data_to_hide'	=> $cws_staff_data_to_hide,
		'total_items_count'			=> $total_items_count
	);
	if ( function_exists( "unilearn_{$post_type}_posts_grid_posts" ) ){
		call_user_func_array( "unilearn_{$post_type}_posts_grid_posts", array( $q ) );
	}
	unset ( $GLOBALS['unilearn_posts_grid_atts'] );
	unilearn_pagination ( $req_page, $max_paged );
	echo "<input type='hidden' id='{$section_id}_dynamic_pagination_page_number' name='{$section_id}_dynamic_pagination_page_number' class='unilearn_posts_grid_dynamic_pagination_page_number' value='$req_page' />";
	wp_die();
}	
add_action( 'wp_ajax_unilearn_posts_grid_dynamic_pagination', 'unilearn_posts_grid_dynamic_pagination' );
add_action( 'wp_ajax_nopriv_unilearn_posts_grid_dynamic_pagination', 'unilearn_posts_grid_dynamic_pagination' );

function unilearn_posts_grid_dynamic_filter (){
	extract( wp_parse_args( $_POST['data'], array(
		'section_id'				=> '',
		'post_type' 				=> '',
		'post_hide_meta'			=> array(),
		'cws_portfolio_data_to_show'=> '',
		'cws_staff_data_to_hide'	=> array(),
		'layout'					=> '1',
		'sb_layout'					=> '',
		'total_items_count'			=> get_option( 'posts_per_page' ),
		'items_pp'					=> get_option( 'posts_per_page' ),
		'page'						=> '1',
		'tax'						=> '',
		'terms'						=> array(),
		'filter'					=> 'false',
		'current_filter_val'		=> '',
		'addl_query_args'			=> array()
	)));
	$not_in = ( 1 == $req_page ) ? array() : get_option( 'sticky_posts' );
	$query_args = array('post_type'			=> array( $post_type ),
						'post_status'		=> 'publish',
						'post__not_in'		=> $not_in
						);
	$query_args['posts_per_page']		= $items_pp;
	$query_args['paged']		= $page;
	if ( $current_filter_val != '_all_' && !empty( $current_filter_val ) ){
		$terms = array( $current_filter_val );
	}
	if ( !empty( $terms ) ){
		$query_args['tax_query'] = array(
			array(
				'taxonomy'		=> $tax,
				'field'			=> 'slug',
				'terms'			=> $terms
			)
		);
	}
	if ( in_array( $post_type, array( "cws_portfolio", "cws_staff" ) ) ){
		$query_args['orderby'] 	= "menu_order date title";
		$query_args['order']	= "ASC";
	}
	$query_args = array_merge( $query_args, $addl_query_args );
	$q = new WP_Query( $query_args );
	$found_posts = $q->found_posts;
	$max_paged = $found_posts > $total_items_count ? ceil( $total_items_count / $items_pp ) : ceil( $found_posts / $items_pp );
	$is_pagination = $max_paged > 1;	
	$GLOBALS['unilearn_posts_grid_atts'] = array(
		'layout'						=> $layout,
		'sb_layout'						=> $sb_layout,
		'post_hide_meta'				=> $post_hide_meta,
		'cws_portfolio_data_to_show'	=> $cws_portfolio_data_to_show,
		'cws_staff_data_to_hide'		=> $cws_staff_data_to_hide,
		'total_items_count'				=> $total_items_count
		);
	if ( function_exists( "unilearn_{$post_type}_posts_grid_posts" ) ){
		call_user_func_array( "unilearn_{$post_type}_posts_grid_posts", array( $q ) );
	}
	unset ( $GLOBALS['unilearn_posts_grid_atts'] );
	if ( $is_pagination ){
		unilearn_pagination ( $page, $max_paged );
	}
	wp_die();
}	
add_action( 'wp_ajax_unilearn_posts_grid_dynamic_filter', 'unilearn_posts_grid_dynamic_filter' );
add_action( 'wp_ajax_nopriv_unilearn_posts_grid_dynamic_filter', 'unilearn_posts_grid_dynamic_filter' );

/****************** \POSTS GRID AJAX ******************/

function unilearn_get_page_title (){
	$text['home']		= esc_html__( 'Home', 'unilearn' ); // text for the 'Home' link
	$text['category']	= esc_html__( 'Category "%s"', 'unilearn' ); // text for a category page
	$text['search']		= esc_html__( 'Search for "%s"', 'unilearn' ); // text for a search results page
	$text['taxonomy']	= esc_html__( 'Archive by %s "%s"', 'unilearn' );
	$text['tag']		= esc_html__( 'Posts Tagged "%s"', 'unilearn' ); // text for a tag page
	$text['author']		= esc_html__( 'Articles Posted by %s', 'unilearn' ); // text for an author page
	$text['404']		= esc_html__( 'Error 404', 'unilearn' ); // text for the 404 page
	$page_title = "";
	if ( is_404() ) {
		$page_title = esc_html__( '404 Page', 'unilearn' );
	} else if ( is_search() ) {
		$page_title = esc_html__( 'Search', 'unilearn' );
	} else if ( is_front_page() ) {
		$page_title = esc_html__( 'Home', 'unilearn' );
	} else if ( is_category() ) {
		$cat = get_category( get_query_var( 'cat' ) );
		$cat_name = isset( $cat->name ) ? $cat->name : '';
		$page_title = sprintf( $text['category'], $cat_name );
	} else if ( is_tag() ) {
		$page_title = sprintf( $text['tag'], single_tag_title( '', false ) );
	} elseif ( is_day() ) {
		echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
		echo sprintf( $link, get_month_link( get_the_time( 'Y' ),get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;
		$page_title = get_the_time( 'd' );
	} elseif ( is_month() ) {
		$page_title = get_the_time( 'F' );
	} elseif ( is_year() ) {
		$page_title = get_the_time( 'Y' );
	} elseif ( has_post_format() && ! is_singular() ) {
		$page_title = get_post_format_string( get_post_format() );
	} else if ( is_tax( array( 'cws_portfolio_cat', 'cws_staff_member_department', 'cws_staff_member_position' ) ) ) {
		$tax_slug = get_query_var( 'taxonomy' );
		$term_slug = get_query_var( $tax_slug );
		$tax_obj = get_taxonomy( $tax_slug );
		$term_obj = get_term_by( 'slug', $term_slug, $tax_slug );
		$singular_tax_label = isset( $tax_obj->labels ) && isset( $tax_obj->labels->singular_name ) ? $tax_obj->labels->singular_name : '';
		$term_name = isset( $term_obj->name ) ? $term_obj->name : '';
		$page_title = $singular_tax_label . ' ' . $term_name ;
	} elseif ( is_archive() ) {
		$post_type = get_post_type();
		$post_type_obj = get_post_type_object( $post_type );
		$post_type_name = isset( $post_type_obj->label ) ? $post_type_obj->label : '';
		$page_title = $post_type_name ;
	} else if ( is_post_type_archive( 'cws_portfolio' ) ) {
		$portfolio_slug = unilearn_get_option('portfolio_slug');
		$post_type = get_post_type();
		$post_type_obj = get_post_type_object( $post_type );
		$post_type_name = isset( $post_type_obj->labels->menu_name ) ? $post_type_obj->labels->menu_name : '';
		$page_title = !empty($portfolio_slug) ? $portfolio_slug : $post_type_name ;
	}else if ( is_post_type_archive( 'cws_staff' ) ) {
		$stuff_slug = unilearn_get_option('staff_slug');
		$post_type = get_post_type();
		$post_type_obj = get_post_type_object( $post_type );
		$post_type_name = isset( $post_type_obj->labels->menu_name ) ? $post_type_obj->labels->menu_name : '';
		$page_title = !empty($stuff_slug) ? $stuff_slug : $post_type_name ;
	}else {
		$blog_title = unilearn_get_option('blog_title');
		$page_title = (!is_page() && !empty($blog_title)) ? $blog_title : get_the_title();
	}
	return $page_title;
}

add_action( 'after_setup_theme', 'unilearn_after_setup_theme' );
function unilearn_after_setup_theme() {
	add_editor_style();
}
add_filter( 'mce_buttons_2', 'unilearn_mce_buttons_2' );
function unilearn_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'tiny_mce_before_init', 'unilearn_tiny_mce_before_init' );
function unilearn_tiny_mce_before_init( $settings ) {
	$settings['theme_advanced_blockformats'] = 'p,h1,h2,h3,h4';
	$style_formats = array(
		array( 'title' => 'Title', 'block' => 'h3', 'classes' => 'widgettitle' ),
		array( 'title' => 'Font-Size', 'items' => array(
			array( 'title' => '28px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '28px' , 'line-height' => '1.4em') ),
			array( 'title' => '24px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '24px' , 'line-height' => '1.4em') ),
			array( 'title' => '18px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '18px' , 'line-height' => '1.4em') ),
			array( 'title' => '15px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '15px' , 'line-height' => '1.6em') ),
			array( 'title' => '14px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '14px' , 'line-height' => '1.64em') ),
			array( 'title' => '13px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '13px' , 'line-height' => '1.54em') ),
			)
		),
		array( 'title' => 'Margin-Top', 'items' => array(
			array( 'title' => '0px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '0' ) ),
			array( 'title' => '10px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '10px' ) ),
			array( 'title' => '15px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '15px' ) ),
			array( 'title' => '20px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '20px' ) ),
			array( 'title' => '25px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '25px' ) ),
			array( 'title' => '30px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '30px' ) ),
			array( 'title' => '40px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '40px' ) ),
			array( 'title' => '50px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '50px' ) ),
			array( 'title' => '60px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '60px' ) ),
			)
		),
		array( 'title' => 'Margin-Bottom', 'items' => array(
			array( 'title' => '0px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '0px' ) ),
			array( 'title' => '10px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '10px' ) ),
			array( 'title' => '15px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '15px' ) ),
			array( 'title' => '20px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '20px' ) ),
			array( 'title' => '25px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '25px' ) ),
			array( 'title' => '30px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '30px' ) ),
			array( 'title' => '40px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '40px' ) ),
			array( 'title' => '50px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '50px' ) ),
			array( 'title' => '60px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '60px' ) ),
			)
		),
		array(
			'title' => 'Horizontal line', 'block' => 'hr', 'items' => array(
				array( 'title' => 'Simple',			'selector' => 'hr:not(.thin):not(.short):not(.short_simple):not(.short_thin)', 			'classes' => 'simple' ),
				array( 'title' => 'Thin',			'selector' => 'hr:not(.simple):not(.short):not(.short_simple):not(.short_thin)', 		'classes' => 'thin' ),
				array( 'title' => 'Short', 			'selector' => 'hr:not(.simple):not(.thin):not(.short_simple):not(.short_thin)', 		'classes' => 'short' ),
				array( 'title' => 'Short Simple', 	'selector' => 'hr:not(.simple):not(.thin):not(.short):not(.short_thin)', 'classes' => 	'short_simple' ),
				array( 'title' => 'Short Thin', 	'selector' => 'hr:not(.simple):not(.thin):not(.short):not(.short_simple)', 'classes' =>	'short_thin' )	
			)
	 	),
		array( 'title' => 'Borderless image', 'selector' => 'img', 'classes' => 'noborder' ),
	);
	// Before 3.1 you needed a special trick to send this array to the configuration.
	// See this post history for previous versions.
	$settings['style_formats'] = str_replace( '"', "'", json_encode( $style_formats ) );
	return $settings;
}

/* POSTS GRID */
function unilearn_posts_grid ( $atts = array(), $content = "" ){
	$out = "";
	$defaults = array(
		'title'									=> '',
		'title_align'							=> 'left',
		'post_type'								=> '',
		'total_items_count'						=> '',
		'cws_portfolio_layout'					=> 'def',
		'cws_portfolio_show_data_override'		=> false,
		'cws_portfolio_data_to_show'			=> '',
		'cws_staff_layout'						=> 'def',
		'cws_staff_hide_meta_override'			=> false,			
		'cws_staff_data_to_hide'				=> '',
		'display_style'							=> 'grid',
		'items_pp'								=>  esc_html( get_option( 'posts_per_page' ) ),
		'paged'									=> 1,
		'tax'									=> '',
		'terms'									=> '',
		'addl_query_args'						=> array(),
		'el_class'								=> ''
	);
	$atts = shortcode_atts( $defaults, $atts );
	extract( $atts );
	$section_id = uniqid( 'posts_grid_' );
	$ajax_data = array();
	$total_items_count = !empty( $total_items_count ) ? (int)$total_items_count : PHP_INT_MAX;
	$items_pp = !empty( $items_pp ) ? (int)$items_pp : esc_html( get_option( 'posts_per_page' ) );
	$paged = (int)$paged;

	$def_cws_portfolio_layout = unilearn_get_option( 'def_cws_portfolio_layout' );
	$def_cws_portfolio_layout = isset( $def_cws_portfolio_layout ) ? $def_cws_portfolio_layout : "";
	$cws_portfolio_layout = ( empty( $cws_portfolio_layout ) || $cws_portfolio_layout === "def" ) ? $def_cws_portfolio_layout : $cws_portfolio_layout; 
	$cws_portfolio_show_data_override = !empty( $cws_portfolio_show_data_override ) ? true : false;
	$cws_portfolio_data_to_show = explode( ",", $cws_portfolio_data_to_show );
	$cws_portfolio_def_data_to_show = unilearn_get_option( 'def_cws_portfolio_data_to_show' );
	$cws_portfolio_def_data_to_show  = isset( $cws_portfolio_def_data_to_show ) ? $cws_portfolio_def_data_to_show : array();
	$cws_portfolio_data_to_show = $cws_portfolio_show_data_override ? $cws_portfolio_data_to_show : $cws_portfolio_def_data_to_show;

	$def_cws_staff_layout = unilearn_get_option( 'def_cws_staff_layout' );
	$def_cws_staff_layout = isset( $def_cws_staff_layout ) ? $def_cws_staff_layout : "";
	$cws_staff_layout = ( empty( $cws_staff_layout ) || $cws_staff_layout === "def" ) ? $def_cws_staff_layout : $cws_staff_layout; 
	$cws_staff_hide_meta_override = !empty( $cws_staff_hide_meta_override ) ? true : false;
	$cws_staff_data_to_hide = explode( ",", $cws_staff_data_to_hide );
	$cws_staff_def_data_to_hide = unilearn_get_option( 'def_cws_staff_data_to_hide' );
	$cws_staff_def_data_to_hide  = isset( $cws_staff_def_data_to_hide ) ? $cws_staff_def_data_to_hide : array();
	$cws_staff_data_to_hide = $cws_staff_hide_meta_override ? $cws_staff_data_to_hide : $cws_staff_def_data_to_hide;	

	$el_class = esc_attr( $el_class );
	$sb = unilearn_get_sidebars();
	$sb_layout = isset( $sb['sb_layout_class'] ) ? $sb['sb_layout_class'] : '';	
	$layout = "1";
	$post_type_obj = get_post_type_object( $post_type );
	switch ( $post_type ){
		case "cws_portfolio":
			$layout = $cws_portfolio_layout;
			break;
		case "cws_staff":
			$layout = $cws_staff_layout;
			break;
	}
	$terms = explode( ",", $terms );	
	$terms_temp = array();
	foreach ( $terms as $term ) {
		if ( !empty( $term ) ){
			array_push( $terms_temp, $term );
		}
	}
	$terms = $terms_temp;
	$all_terms = array();
	$all_terms_temp = !empty( $tax ) ? get_terms( $tax ) : array();
	$all_terms_temp = !is_wp_error( $all_terms_temp ) ? $all_terms_temp : array();
	foreach ( $all_terms_temp as $term ){
		array_push( $all_terms, $term->slug );
	}
	$terms = !empty( $terms ) ? $terms : $all_terms;
	$not_in = (1 == $paged) ? array() : get_option( 'sticky_posts' );
	$query_args = array('post_type'			=> array( $post_type ),
						'post_status'		=> 'publish',
						'post__not_in'		=> $not_in
						);
	if ( in_array( $display_style, array( 'grid', 'filter' ) ) ){
		$query_args['posts_per_page']		= $items_pp;
		$query_args['paged']		= $paged;
	}
	else{
		$query_args['nopaging']				= true;
		$query_args['posts_per_page']		= -1;
	}
	if ( !empty( $terms ) ){
		$query_args['tax_query'] = array(
			array(
				'taxonomy'		=> $tax,
				'field'			=> 'slug',
				'terms'			=> $terms
			)
		);
	}
	if ( in_array( $post_type, array( "cws_portfolio", "cws_staff" ) ) ){
		$query_args['orderby'] 	= "menu_order date title";
		$query_args['order']	= "ASC";
	}
	$query_args = array_merge( $query_args, $addl_query_args );
	$q = new WP_Query( $query_args );
	$found_posts = $q->found_posts;
	$requested_posts = $found_posts > $total_items_count ? $total_items_count : $found_posts;
	$max_paged = $found_posts > $total_items_count ? ceil( $total_items_count / $items_pp ) : ceil( $found_posts / $items_pp );
	$cols = in_array( $layout, array( 'medium', 'small' ) ) ? 1 : (int)$layout;
	$is_carousel = $display_style == 'carousel' && $requested_posts > $cols;
	wp_enqueue_script( 'fancybox' );
	$is_filter = in_array( $display_style, array( 'filter' ) ) && !empty( $terms ) ? true : false;
	$filter_vals = array();
	$use_pagination = in_array( $display_style, array( 'grid', 'filter' ) ) && $max_paged > 1;
	$pagination_type = "pagination";
	if ( !$is_filter && in_array( $layout, array( '2', '3', '4' ) ) ){
		$pagination_type = "load_more";
	}
	$dynamic_content = $is_filter || $use_pagination;
	if ( $is_carousel ){
		wp_enqueue_script( 'owl_carousel' );
	}
	else if ( in_array( $layout, array( "2", "3", "4" ) ) || $dynamic_content ){
		wp_enqueue_script( 'isotope' );
	}
	if ( $dynamic_content ){
		wp_enqueue_script( 'owl_carousel' ); // for dynamically loaded gallery posts
		wp_enqueue_script( 'images_loaded' );
	}
	ob_start ();
	echo "<section id='$section_id' class='posts_grid {$post_type}_posts_grid posts_grid_{$layout} posts_grid_{$display_style}" . ( $dynamic_content ? " dynamic_content" : "" ) . ( !empty( $el_class ) ? " $el_class" : "" ) . "'>";
		if ( $is_carousel ){
			echo "<div class='widget_header clearfix'>";
				echo !empty( $title ) ? "<h2 class='widgettitle'>" . esc_html( $title ) . "</h2>" : "";				
				echo "<div class='carousel_nav'>";
					echo "<span class='prev'>";
					echo "</span>";
					echo "<span class='next'>";
					echo "</span>";
				echo "</div>";
			echo "</div>";			
		}
		else if ( $is_filter && count( $terms ) > 1 ){
			foreach ( $terms as $term ) {
				if ( empty( $term ) ) continue;
				$term_obj = get_term_by( 'slug', $term, $tax );
				if ( empty( $term_obj ) ) continue;
				$term_name = $term_obj->name;
				$filter_vals[$term] = $term_name;
			}
			if ( $filter_vals > 1 ){
				echo "<div class='widget_header'>";
					echo !empty( $title ) ? "<h2 class='widgettitle'>" . esc_html( $title ) . "</h2>" : "";
					echo "<select class='filter'>";
						echo "<option value='_all_' selected>" . esc_html__( 'All', 'unilearn' ) . "</option>";
						foreach ( $filter_vals as $term_slug => $term_name ){
							echo "<option value='" . esc_html( $term_slug ) . "'>" . esc_html( $term_name ) . "</option>";
						}
					echo "</select>";				
				echo "</div>";
			}
			else{
				echo !empty( $title ) ? "<h2 class='widgettitle text_align{$title_align}'>" . esc_html( $title ) . "</h2>" : "";				
			}
		}
		else{
			echo !empty( $title ) ? "<h2 class='widgettitle text_align{$title_align}'>" . esc_html( $title ) . "</h2>" : "";
		}
		echo "<div class='unilearn_wrapper'>";
			echo "<div class='" . ( $is_carousel ? "unilearn_carousel" : "unilearn_grid" . ( ( in_array( $layout, array( "2", "3", "4" ) ) || $dynamic_content ) ? " isotope" : "" ) ) . "'" . ( $is_carousel ? " data-cols='" . ( !is_numeric( $layout ) ? "1" : $layout ) . "'" : "" ) . ">";
				$GLOBALS['unilearn_posts_grid_atts'] = array(
					'layout'						=> $layout,
					'sb_layout'						=> $sb_layout,
					'cws_portfolio_data_to_show'	=> $cws_portfolio_data_to_show,
					'cws_staff_data_to_hide'		=> $cws_staff_data_to_hide,
					'total_items_count'				=> $total_items_count
					);
				if ( function_exists( "unilearn_{$post_type}_posts_grid_posts" ) ){
					call_user_func_array( "unilearn_{$post_type}_posts_grid_posts", array( $q ) );
				}
				unset( $GLOBALS['unilearn_posts_grid_atts'] );
			echo "</div>";
			if ( $dynamic_content ){
				unilearn_loader_html();
			}
		echo "</div>";
		if ( $use_pagination ){
			if ( $pagination_type == 'load_more' ){
				unilearn_load_more ();
			}
			else{
				unilearn_pagination ( $paged, $max_paged );
			}
		}
		if ( $dynamic_content ){
			$ajax_data['section_id']						= $section_id;
			$ajax_data['post_type']							= $post_type;
			$ajax_data['cws_portfolio_data_to_show']		= $cws_portfolio_data_to_show;
			$ajax_data['cws_staff_data_to_hide']			= $cws_staff_data_to_hide;
			$ajax_data['layout']							= $layout;
			$ajax_data['sb_layout']							= $sb_layout;
			$ajax_data['total_items_count']					= $total_items_count;
			$ajax_data['items_pp']							= $items_pp;
			$ajax_data['page']								= $paged;
			$ajax_data['max_paged']							= $max_paged;
			$ajax_data['tax']								= $tax;
			$ajax_data['terms']								= $terms;
			$ajax_data['filter']							= $is_filter;
			$ajax_data['current_filter_val']				= '_all_';
			$ajax_data['addl_query_args']					= $addl_query_args;
			$ajax_data_str = json_encode( $ajax_data );
			echo "<form id='{$section_id}_data' class='posts_grid_data'>";
				echo "<input type='hidden' id='{$section_id}_ajax_data' class='posts_grid_ajax_data' name='{$section_id}_ajax_data' value='$ajax_data_str' />";
			echo "</form>";
		}
	echo "</section>";
	$out = ob_get_clean();
	return $out;
}
/* \POSTS GRID */

/*	Visual Composer Overrides */

if ( unilearn_check_for_plugin( 'cws-megamenu/cws-megamenu.php' ) && unilearn_check_for_plugin( 'js_composer/js_composer.php' ) ){
	function vc_theme_vc_column ( $atts = array(), $content = "" ){
	    /**
	     * Shortcode attributes
	     * @var $atts
	     * @var $el_class
	     * @var $width
	     * @var $css
	     * @var $offset
	     * @var $content - shortcode content
	     * Shortcode class
	     * @var $this WPBakeryShortCode_VC_Column
	     */
	    $output = "";
	    $tag = "vc_column";
	    $sc_obj = Vc_Shortcodes_Manager::getInstance()->getElementClass( $tag );
	    $el_class = $width = $css = $offset = $mm_column_title = '';
	    $output = '';
	    $atts = vc_map_get_attributes( $sc_obj->getShortcode(), $atts );
	    extract( $atts );

	    $width = wpb_translateColumnWidthToSpan( $width );
	    $width = vc_column_offset_class_merge( $offset, $width );

	    $mm_column_title = !empty( $mm_column_title ) ? $mm_column_title : esc_html__( 'Title Must be Entered', 'unilearn' );

	    $css_classes = array(
	        $sc_obj->getExtraClass( $el_class ),
	        'wpb_column',
	        'vc_column_container',
	        $width,
	    );

	    if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') )) {
	        $css_classes[]='vc_col-has-fill';
	    }

	    $wrapper_attributes = array();

	    $css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $tag, $atts ) );
	    $wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

	    $output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
	    $output .= '<div class="vc_column-inner ' . esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) ) . '">';
	    $output .= '<div class="wpb_wrapper">';

	    if ( Cws_Megamenu::$megamenu_content_redered ){
	        $output .= "<div class='megamenu_item_column_title'><span>$mm_column_title</span><span class='pointer'></span></div>";
	        $output .= "<div class='megamenu_item_column_content'>";
	            $output .= "<div class='megamenu_item_column_content_wrapper'>";
	            	$output .= wpb_js_remove_wpautop( $content );
	            $output .= "</div>";
	        $output .= "</div>";        
	    }
	    else{
	        $output .= wpb_js_remove_wpautop( $content );        
	    }
	    $output .= '</div>';
	    $output .= '</div>';
	    $output .= '</div>';

	    return $output;  
	}
}

/*	\Visual Composer Overrides */

function unilearn_loader_html ( $args = array() ){
	extract( wp_parse_args( $args, array(
		'holder_id'		=> '',
		'holder_class' 	=> '',
		'loader_id'		=> '',
		'loader_class'	=> ''
	)));
	$holder_class 	.= " cws_loader_holder";
	$loader_class 	.= " cws_loader";
	$holder_id		= esc_attr( $holder_id );
	$holder_class 	= esc_attr( trim( $holder_class ) );
	$loader_id		= esc_attr( $loader_id );
	$loader_class 	= esc_attr( trim( $loader_class ) );
	echo "<div " . ( !empty( $holder_id ) ? " id='$holder_id'" : "" ) . " class='$holder_class'>";
		echo "<div " . ( !empty( $loader_id ) ? " id='$loader_id'" : "" ) . " class='$loader_class'>";
			?>
			<svg width='104px' height='104px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-default"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(0 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(30 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.08333333333333333s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(60 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.16666666666666666s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(90 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.25s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(120 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.3333333333333333s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(150 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.4166666666666667s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(180 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.5s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(210 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.5833333333333334s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(240 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.6666666666666666s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(270 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.75s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(300 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.8333333333333334s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(330 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.9166666666666666s' repeatCount='indefinite'/></rect></svg>
			<?php
		echo "</div>";
	echo "</div>";
}

/*	Slider Overlaying body class */

function unilearn_slider_overlaying_body_class ( $classes ){
	$header_page_meta_vars 	= unilearn_get_page_meta_var( array( 'header' ) );
	$page_override_header 	= !empty( $header_page_meta_vars );
	$header_covers_slider 	= false;
	if ( $page_override_header ){
		$header_covers_slider 	= isset( $header_page_meta_vars['header_covers_slider'] ) ? (bool)$header_page_meta_vars['header_covers_slider'] : $header_covers_slider;
	}
	else{
		$header_covers_slider 	= (bool)unilearn_get_option( 'header_covers_slider' );
	}
	if ( $header_covers_slider ){
		$classes[] = 'header_covers_slider';
	}
	return $classes;	
}
add_filter( 'body_class', 'unilearn_slider_overlaying_body_class' );

?>