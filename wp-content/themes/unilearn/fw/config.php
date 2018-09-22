<?php
	define ('CWSFW_PATH', plugin_dir_path(__FILE__));
	require_once( CWSFW_PATH . '/pbfw.php' );
	require_once( CWSFW_PATH . '/sections.php' );

	$theme = wp_get_theme();

function cwsfw_get_args() {
	$theme = wp_get_theme();
	return array(
		'theme_slug'		=> 'unilearn',
		'theme_name'		=> $theme->get( 'Name' ),
		'theme_version'	=> $theme->get( 'Version' ),
		'menu_type'			=> 'menu',
		'menu_title'		=> esc_html__('Theme Options', 'unilearn' ),
		'page_title'		=> esc_html__('Theme Options', 'unilearn' ),
	);
};

function cwsfw_startFramework($args, $sections) {
	$theme_slug = $args['theme_slug'];
	$values = get_option('unilearn');
	if (empty($values)) {
		$sections = cwsfw_get_sections();
		$values = array();
		foreach ($sections as $key => $v) {
			cwsfw_print_layout($v['layout'], '', $values);
		}
		update_option('unilearn', $values);
	}

	// here we need to create theme options menu and admin sidebar
	$args = cwsfw_get_args();
	call_user_func( 'add'.'_menu_page', 'Theme Options', 'Theme Options', 'manage_options', 'cwsfw', 'cwsfw_callback', '', 199);
	foreach ($sections as $key => $value) {
		call_user_func( 'add'.'_submenu_page', 'cwsfw', $value['title'], $value['title'], 'manage_options', 'cwsfw&section=' . $key, '__return_null');
	}
	remove_submenu_page( 'cwsfw', 'cwsfw' ); // remove first duplicate
}

function cwsfw_callback($a) {
	$active_section = isset($_GET['section']) ? $_GET['section'] : '';
	$sections = cwsfw_get_sections();

	$values = get_option('unilearn');
	if (!empty($values)) {
		$s_sections = cwsfw_build_array_keys($sections);
		cwsfw_fillMbAttributes($values, $s_sections);
	}

	$nonce = esc_html(wp_create_nonce( "cwsfw_ajax_nonce_unilearn" ));

	global $wp_filesystem;
	WP_Filesystem();
	$result = $wp_filesystem->get_contents(CWSFW_PATH . '/def.json');
	$result = str_replace( array('},{', '[{', '}]'), array(',', '{', '}'), $result );
	echo '<script id="cwsfw_defaults" type="text/template">';
	echo sprintf("%s", $result);
	echo '</script>';

	echo "<form method='post' id='cwsfw' action='./options.php' enctype='multipart/form-data' data-nonce='$nonce' data-theme='unilearn'>";
	echo '<div class="sidebar-panel"><div class="cwsfw_header">';
	echo '<div class="theme_name">unilearn</div>';
	echo '</div>';
	echo '<div class="cwsfw_sections">';
	echo '<ul class="cwsfw_section_items">';
	foreach ($sections as $key => $value) {
		if (is_array($value['icon'])) {
			$icon = sprintf('<i class="%s %s-%s"></i>', $value['icon'][0], $value['icon'][0], $value['icon'][1]);
		} else {
			// direct link
			$icon = '<span></span>';
		}
		$active = ($key == $active_section) ? ' class="active"' : '';
		echo '<li' . $active . ' data-key="'. $key .'">' . $icon . '<p>' . $value['title'] . '</p></li>';
	}
	/*
	 now we need to add import/export section
	*/
	echo '<li data-key="impexp_options"><i class="fa fa-calendar-plus-o"></i><p>'. esc_html__('Import & Export options', 'unilearn') .'</p></li>';
	echo '</ul></div></div>';
	echo '<div class="cwsfw_controls_body"><div class="cwsfw_top_buttons">';
	submit_button( esc_attr__( 'Save Changes', 'unilearn' ), 'primary', 'cwsfw_save', false );
	cwsfw_e_notices();
	echo '</div>';
	echo '<div class="cwsfw_controls">';
	foreach ($sections as $key => $v) {
		if ( !isset($v['active']) || true === $v['active'] ) {
			$active_class = ($key == $active_section) ? '' : ' disable';
			echo '<div class="section' . $active_class . '" data-section="'. $key .'">';
			echo cwsfw_print_layout($v['layout'], '');
			echo '</div>';
		}
	}

	echo '<div class="section disable" data-section="impexp_options">';
	echo '<div class="cws_pb_ftabs"><a href="#" data-tab="impexp_options" class="active"><i class="fa fa-arrow-circle-o-up"></i>' . esc_html__('Import & Export options', 'unilearn') . '</a><div class="clear"></div></div>';
	echo '<div class="cws_form_tab open" data-tabkey="impexp_options">';
	echo '<div class="row row_options">';
?>
<textarea id="cwsfw_impexp_ta" style="display:none"></textarea>
<form enctype="multipart/form-data" id="cwsfw-impexp-upload-form" method="post" class="wp-form" action="">
<?php
	$upload_dir = wp_upload_dir();
	if ( ! empty( $upload_dir['error'] ) ) :
?><div class="error"><p><?php esc_html_e('Before you can upload your import file, you will need to fix the following error:', 'unilearn'); ?></p>
		<p><strong><?php echo sprintf("%s", $upload_dir['error']); ?></strong></p></div>
<?php
	else :
?>
	<label for="upload"><?php esc_html_e( 'Choose a file from your computer:', 'unilearn' ); ?></label>
	<div>
		<input type="file" id="cws_impexp_import" name="cws_impexp_import" size="25" />
	</div>
	<div>
<?php
	submit_button( esc_attr__( 'Import theme\'s data', 'unilearn' ), 'secondary disabled', 'cwsfw_import', false );
	echo ' <a href="#" class="button secondary" download="unilearn.json" id="cwsfw_export">'. esc_html__('Export current Theme Options', 'unilearn') .'</a></div>';
	endif;
	?>
</form>
<?php
	echo '</div>'; // row
	echo '<div class="clear"></div>';
	echo '</div>'; // cws_form_tab

	echo '</div>';
 echo '<div class="cwsfw_bottom_buttons">';
 submit_button( esc_attr__( 'Save Changes', 'unilearn' ), 'primary', 'cwsfw_save-1', false );
 submit_button( esc_attr__( 'Reset all', 'unilearn' ), 'secondary', 'cwsfw_reset_all', false );
 submit_button( esc_attr__( 'Reset section', 'unilearn' ), 'secondary', 'cwsfw_reset_sec', false );

	echo '</div></form>';
}

function cwsfw_e_notices() {
?>
<div class="cwsfw_notices">
<div class="cwsfw_unsaved"><?php esc_html_e('There\'re unsaved changes. Don\'t forget to save them.', 'unilearn' ) ?></div>
</div>
<?php
}

/* convert array to strings w/delimiter */
function cwsfw_array2str($arr) {
	$out = '';
	$i = 0;
	foreach ($arr as $k => $v) {
		$out .= ($i===0 ? '' : ';') . $v;
		$i++;
	}
	return $out;
}

add_action( 'wp_ajax_cwsfw_unilearn_ajax_save', 'cwsfw_ajax_save' );

function cwsfw_ajax_save() {
	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'cwsfw_ajax_nonce_unilearn' ) ) {
		echo json_encode( array( 'status' => esc_html__('Invalid nonce', 'unilearn') ) );
		die();
	}
	$pdata = stripslashes( $_POST['data'] );
	if (!get_magic_quotes_gpc()) {
		$pdata = str_replace(array('%22', '%5C'), array('\\%22', '\\%5C' ), $pdata);
	}
	$values = array();
	parse_str( $pdata, $values );

	$action = explode('_', $_POST['action']);
	update_option($action[1], $values);
	echo json_encode( array( 'status' => 'success' ) );
	die();
}

add_action( 'wp_ajax_cwsfw_unilearn_ajax_read_def', 'cwsfw_ajax_read_def' );

function cwsfw_ajax_read_def() {
	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'cwsfw_ajax_nonce_unilearn' ) ) {
		echo json_encode( array( 'status' => esc_html__('Invalid nonce', 'unilearn') ) );
		die();
	}
	global $wp_filesystem;
	WP_Filesystem();
	$result = json_decode($wp_filesystem->get_contents(CWSFW_PATH . '/def.json'), true);
	$val_str = '';
	foreach ($result as $k => $v) {
		reset($v);
		$key = key($v);
		$val_str .= $key . '=' . $v[$key] . '&';
	}
	$values = array();
	parse_str($val_str, $values);
	$action = explode('_', $_POST['action']);

	if (!empty($_POST['data'])) {
		// reset section
		$sec_keys = explode(',',$_POST['data']);
		foreach ($sec_keys as $key) {
			if (isset($values[$key])) {
				unset($values[$key]);
			}
		}
		$original = get_option($action[1]);
		$values = array_merge($original, $values);
	}
	//update_option($action[1], $values);
	echo json_encode( array(
		'status' => 'success',
	));
	die();
}

function cwsfw_admin_init() {
	cwsfw_startFramework(cwsfw_get_args(), cwsfw_get_sections());
}
add_action( 'admin_menu', 'cwsfw_admin_init' );

function cwsfw_admin_scripts($hook) {
	if ('toplevel_page_cwsfw' == $hook/* || 'widgets.php' == $hook*/) {
		$theme_fw_sub = substr(CWSFW_PATH, strrpos(CWSFW_PATH, 'unilearn') + strlen('unilearn') + 1 );
		wp_enqueue_script('qtip-js', get_template_directory_uri() . '/' . $theme_fw_sub . '/js/jquery.qtip.js', array('jquery'), false );
		wp_enqueue_style('qtip-css', get_template_directory_uri() . '/' . $theme_fw_sub . '/css/jquery.qtip.css', false, '2.0.0' );
		wp_enqueue_script('select2-js', get_template_directory_uri() . '/includes/core/assets/js/select2/select2.js', array('jquery') );
		wp_enqueue_style('select2-css', get_template_directory_uri() . '/includes/core/assets/js/select2/select2.css', false, '2.0.0' );
		wp_enqueue_media();
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_script('cwsfw-main-js', get_template_directory_uri() . '/' . $theme_fw_sub . '/js/cwsfw.js', array('jquery', 'wp-backbone', 'customize-controls'), false );
		wp_enqueue_style('cwsfw-main-css', get_template_directory_uri() . '/' . $theme_fw_sub . '/css/cwsfw.css', false, '2.0.0' );

		wp_enqueue_script('webfont_js','https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js',array('jquery'),'1.5.18', true);
	}
}
add_action('admin_enqueue_scripts', 'cwsfw_admin_scripts');

function cwsfw_customize_enqueue() {
	cwsfw_admin_scripts('toplevel_page_cwsfw');
}

add_action('customize_controls_enqueue_scripts', 'cwsfw_customize_enqueue' );

add_action( 'customize_save_after', 'cwsfw_customize_save_after' );

function cwsfw_customize_save_after($wp_customize) {
	$post_values = json_decode( stripslashes_deep( $_POST['customized'] ), true );
	$current_options = get_option('unilearn');
	if(isset($post_values['cwsfw_settings'])){
	$new_options = $post_values['cwsfw_settings'];
	foreach ($new_options as $key => $value) {
		$current_options[$key] = $value;
	}
	update_option('unilearn', $current_options);
}
}

add_action( 'customize_register', 'cwsfw_customize_register' );

function cwsfw_customize_register( $wp_customize ) {
	require_once( CWSFW_PATH . '/class-cwsfw-section.php' );

	$wp_customize->add_panel( 'cwsfw', array(
			'type'	=> 'cwsfw',
			'title' => esc_html__( 'Theme Options', 'unilearn' ),
			'description' => esc_html__( 'CWS Theme Options.', 'unilearn' ),
			//'priority'        => 100,
			//'active_callback' => array( $this, 'is_panel_active' ),
		) );

	$sections = cwsfw_get_sections();
	$values = get_option('unilearn');
	if (!empty($values)) {
		$s_sections = cwsfw_build_array_keys($sections);
		cwsfw_fillMbAttributes($values, $s_sections);
	}

	$wp_customize->add_setting('cwsfw_settings', array(
													'default' => array(),
													'sanitize_callback' => '__return_false'
												));

	foreach ($sections as $key => $value) {
		$sec_name = 'cwsfw_' . $key;

		$wp_customize->add_section( $sec_name, array(
			'title' => $value['title'],
			'panel' => 'cwsfw',
			'args' => array(),
		));
		$wp_customize->add_control(
			new CWSFW_Section(
				$wp_customize, $key . '_general', array(
					'label' => esc_html__( 'General', 'unilearn' ),
					'section' => $sec_name,
					'settings' => 'cwsfw_settings',
					'args' => &$value['layout'],
				)
			)
		);

	}
	return $wp_customize;
}
