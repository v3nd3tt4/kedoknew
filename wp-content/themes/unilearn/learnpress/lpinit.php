<?php

class Unilearn_LPExt{

	public $def_args;
	public $args;
	public $def_img_sizes;

	public function __construct ( $args = array() ){
		add_theme_support( 'learnpress' );	// Declare LearnPress Support
		require_once( trailingslashit( get_template_directory() ) . 'learnpress/cws_lp_course.php' );
		$this->def_args = array(
			'learn_press_single_course_image_size' 		=> array(),
			'learn_press_course_thumbnail_image_size'	=> array(),
		);
		$this->args = wp_parse_args( $args, $this->def_args );
		add_action( 'after_switch_theme', array( $this, 'init' ) );
		add_action( 'init', array( $this, 'lp_init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'cws_enqueue_style' ) );

		add_action( 'add_meta_boxes_lp_course', array( $this, 'add_mb_lp_course' ) );
		add_action( 'save_post', array( $this, 'post_metabox_save' ), 11, 2 );
		add_filter( 'cws_sb_settings', array( $this, 'sb_settings_filter' ) );
		// add_action( 'learn_press_before_courses_loop', 'courses_loop_panel' );
		
		remove_action( 'learn-press/before-main-content', 'learn_press_wrapper_start' );
		remove_action( 'learn-press/after-main-content', 'learn_press_wrapper_end' );

		add_action( 'learn_press_before_courses_loop', array( $this, 'courses_loop_grid_wrapper_open' ) );
		add_action( 'learn_press_after_courses_loop', array( $this, 'courses_loop_grid_wrapper_close' ) );
		remove_action( 'learn_press_after_courses_loop', 'learn_press_courses_pagination', 5 );
		add_action( 'learn_press_after_courses_loop', 'learn_press_courses_pagination', 15 );
		add_filter( 'post_class', array( $this, 'lp_course_classes' ) );

		remove_action( 'learn-press/courses-loop-item-title', 'learn_press_courses_loop_item_thumbnail', 10 );
		remove_action( 'learn-press/courses-loop-item-title', 'learn_press_courses_loop_item_title', 15 );	  
		remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_begin_meta', 10 );	  		
	    remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_instructor', 25 );
  		remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_students', 20 );
  		remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_price', 20 );
		remove_action( 'learn-press/after-courses-loop-item', 'learn_press_course_loop_item_buttons', 35 );  		
  		remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_end_meta', 30 );
		
		add_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_thumbnail', 1 );		
  		add_action( 'unilearn_lp_courses_loop_item_gen_info', 'unilearn_lp_courses_loop_item_title' );
    	add_action( 'unilearn_lp_courses_loop_item_gen_info', 'learn_press_courses_loop_item_price' );
    	add_action( 'learn-press/after-courses-loop-item', 'unilearn_lp_courses_loop_item_gen_info', 1 );
        add_action( 'learn-press/after-courses-loop-item', 'unilearn_lp_courses_loop_item_info_wrapper_open', 2 );
        add_action( 'learn-press/after-courses-loop-item', 'unilearn_lp_courses_loop_item_info_wrapper_close', 99 );
  		add_action( 'unilearn_lp_courses_loop_item_sec_info', 'learn_press_courses_loop_item_students' );
    	add_action( 'unilearn_lp_courses_loop_item_sec_info', 'learn_press_courses_loop_item_instructor' );
        add_action( 'learn-press/after-courses-loop-item', 'unilearn_lp_courses_loop_item_sec_info', 3 );
        add_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_introduce', 4 );    	
		
        add_action( 'unilearn_lp_courses_loop_item_styles', array( $this, 'courses_loop_item_styles' ) );

		remove_action( 'learn_press_content_landing_summary', 'learn_press_course_title', 10 );

		add_action( 'learn_press_content_landing_summary', 'learn_press_course_thumbnail', 5 );

		remove_action( 'learn_press_single_quiz_summary', 'learn_press_single_quiz_title', 5 );
		
		add_action( 'learn_press_single_quiz_sidebar', 'unilearn_lp_single_quiz_sidebar_opener', 99 );

		add_action( "init", "unilearn_remove_learnpress_theContent" );
		

	}
	public function init (){
		/* set course thumbnail dimensions */
		update_option( 'learn_press_single_course_image_size', $this->args['learn_press_single_course_image_size'] ); 
		update_option( 'learn_press_course_thumbnail_image_size', $this->args['learn_press_course_thumbnail_image_size'] ); 
		/* set course thumbnail dimensions */
	}
	public function lp_init (){
		remove_action( 'learn-press/before-main-content', 'learn_press_breadcrumb' );
		add_filter( 'learn_press_show_page_title', '__return_false' );
	}
	public function enqueue_script (){
		// if ( in_array( 'learnpress', apply_filters( 'body_class', '' ) ) ){
			wp_register_script( 'learnpress_cws_ext_front', UNILEARN_THEME_URI . '/learnpress/js/learnpress.js' );
			wp_enqueue_script( 'learnpress_cws_ext_front' );		
		// }
	}
	public function cws_enqueue_style (){
		$is_rtl = is_rtl();
		// if ( in_array( 'learnpress', apply_filters( 'body_class', '' ) ) ){
			wp_register_style( 'learnpress_cws_ext', get_template_directory_uri() . '/learnpress/css/learnpress.css' );
			wp_enqueue_style( 'learnpress_cws_ext' );
			if ( $is_rtl ){
				wp_register_style( 'learnpress_cws_ext-rtl', get_template_directory_uri() . '/learnpress/css/learnpress-rtl.css' );
				wp_enqueue_style( 'learnpress_cws_ext-rtl' );				
			}
			wp_add_inline_style( 'learnpress_cws_ext', $this->custom_colors_styles() );		
			wp_add_inline_style( 'learnpress_cws_ext', $this->front_dynamic_styles() );
			wp_add_inline_style( 'learnpress_cws_ext', $this->body_font_styles() );				
			wp_add_inline_style( 'learnpress_cws_ext', $this->header_font_styles() );				
		// }
	}
	public function custom_colors_styles (){
		ob_start();
		do_action( 'unilearn_lp_custom_colors_hook' );
		return ob_get_clean();
	}
	public function front_dynamic_styles (){
		ob_start ();
		do_action( 'unilearn_lp_front_dynamic_styles_hook' );
		return ob_get_clean ();				
	}
	public function body_font_styles (){
		ob_start ();
		do_action( 'unilearn_lp_body_font_styles_hook' );
		return ob_get_clean ();			
	}
	public function header_font_styles (){
		ob_start ();
		do_action( 'unilearn_lp_header_font_styles_hook' );
		return ob_get_clean ();			
	}
	public function add_mb_lp_course (){
		add_meta_box( 'cws-post-metabox-id', 'CWS Course Options', array($this, 'mb_callback_lp_course'), 'lp_course', 'side', 'low' );
	}
	public function mb_callback_lp_course ( $post ){
		wp_nonce_field( 'cws_mb_nonce', 'mb_nonce' );

		$mb_attr = array(
			'lp_course_spec_color' => array(
				'title' 		=> esc_html__( 'Specific Color', 'unilearn' ),
				'atts' 			=> 'data-default-color="' . UNILEARN_THEME_COLOR . '"',
				'type' 			=> 'text',
				'value'			=> UNILEARN_THEME_COLOR
			),
		);

		$cws_stored_meta = get_post_meta( $post->ID, 'cws_mb_post' );
		unilearn_mb_fillMbAttributes($cws_stored_meta, $mb_attr);
		echo unilearn_mb_print_layout($mb_attr, 'cws_mb_');		
	}
	public function post_metabox_save( $post_id, $post ){
		if ( in_array( $post->post_type, array( 'lp_course' ) ) ) {
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
	public function sb_settings_filter ( $sb_settings ){
		if ( learn_press_is_course() && is_single() ){
			$sb_settings['sidebar_pos'] = unilearn_get_option( "lms-sb-layout" );
			$sb_settings['sidebar1'] = unilearn_get_option( "lms-sb1" );
			$sb_settings['sidebar2'] = unilearn_get_option( "lms-sb2" );
		}
		return $sb_settings;
	}
	public function courses_loop_grid_wrapper_open (){
		$sb_layout 			= unilearn_get_option( 'lms-sb-layout' );
		$sb_enabled 		= in_array( $sb_layout, array( 'left', 'right', 'both' ) );
		$sb1 				= unilearn_get_option( 'lms-sb1' );
		$sb2 				= unilearn_get_option( 'lms-sb2' );
		$sb1_exists 		= $sb_enabled && is_active_sidebar( $sb1 );
		$sb2_exists 		= $sb_enabled && $sb_layout == 'both' && is_active_sidebar( $sb2 );
		$sb_exists 			= $sb1_exists || $sb2_exists;
		$sb_layout_class 	= "";
		if ( $sb1_exists && $sb2_exists ){
			$sb_layout_class = "double_sidebar";
		}
		else if ( $sb1_exists || $sb2_exists ){
			$sb_layout_class = "single_sidebar";
		}
		$section_id = uniqid( 'posts_grid_' );
		if ( $sb_layout_class == 'double_sidebar' ){
			$grid_layout = "2";
		}
		else if ( $sb_layout_class == 'single_sidebar' ){
			$grid_layout = "3";
		}
		else{
			$grid_layout = "4";
		}
		$grid_classes = "posts_grid posts_grid_lp_courses posts_grid_{$grid_layout}";
		?>
		<section id="<?php echo sprintf("%s", $section_id); ?>" class="<?php echo sprintf("%s", $grid_classes); ?>">
			<div class="unilearn_wrapper">
				<div class="unilearn_grid isotope">
		<?php
	}
	public function courses_loop_grid_wrapper_close (){
		?>
				</div>
			</div>
		</section>
		<?php
	}
	public function lp_course_classes ( $classes ){
		$add = array();
		$pid 		= get_the_id();
		$post_type 	= get_post_type( $pid );
		if ( $post_type != 'lp_course' ){
			return $classes;
		}
		$classes = array_merge( $classes, array( 'item', 'lp_course_post' ) );
		if ( is_single() ){
			array_push( $classes, 'post_single_post' );
		}
		else{
			array_push( $classes, 'post_grid_post' );			
		}
		return $classes;
	}
	public function courses_loop_item_styles (){
		$pid = get_the_id();
		$meta = get_post_meta( $pid, 'cws_mb_post' );
		$meta = isset( $meta[0] ) ? $meta[0] : array();
		extract( wp_parse_args( $meta, array(
			'lp_course_spec_color'	=> UNILEARN_THEME_COLOR
		)));
		echo "#post-{$pid}.lp_course_post.post_grid_post > .post_wrapper,
		#post-{$pid}.lp_course_post.post_grid_post > .post_wrapper > .post_media > .pic > .hover-effect{
			background-color: $lp_course_spec_color;
		}";
	}

}

/**/
/* Config and enable extension */
/**/
$unilearn_lp_args = array(
	'learn_press_single_course_image_size'		=> array(
		'width'	=> 1170,
		'height'=> 580,
		'crop'	=> 'yes'
	),
	'learn_press_course_thumbnail_image_size'		=> array(
		'width'	=> 370,
		'height'=> 280,
		'crop'	=> 'yes'
	)
);
$unilearn_lp_ext = new Unilearn_LPExt ( $unilearn_lp_args );
/**/
/* \Config and enable extension */
/**/

function unilearn_lp_courses_loop_item_gen_info (){
	ob_start();
	do_action( 'unilearn_lp_courses_loop_item_gen_info' );
	$gen_info = ob_get_clean();
	if ( !empty( $gen_info ) ){
		echo "<div class='cws_lp_courses_loop_item_gen_info clearfix'>";
			echo sprintf("%s", $gen_info);
		echo "</div>";
	}
}
function unilearn_lp_courses_loop_item_sec_info (){
	ob_start();
	do_action( 'unilearn_lp_courses_loop_item_sec_info' );
	$sec_info = ob_get_clean();
	if ( !empty( $sec_info ) ){
		echo "<div class='cws_lp_courses_loop_item_sec_info clearfix'>";
			echo sprintf("%s", $sec_info);
		echo "</div>";
	}
}
function unilearn_lp_courses_loop_item_title (){
	$title 		= get_the_title();
	$grid_atts = isset($GLOBALS['unilearn_posts_grid_atts']) ? $GLOBALS['unilearn_posts_grid_atts'] : array();
	extract($grid_atts);
	if ( empty( $title ) ){
		return false;
	}
	$permalink 	= get_the_permalink();
	$cws_is_blank = !empty($lp_course_new_tab) ? "target = '_blank'" : "";
	echo "<h3 class='post_title lp_course_post_title posts_grid_post_title'>";
		echo "<a href='$permalink' $cws_is_blank>$title</a>";
	echo "</h3>";
}
function unilearn_lp_courses_loop_item_info_wrapper_open (){
	?>
	<div class='cws_lp_courses_loop_item_info_wrapper'>
	<?php
}
function unilearn_lp_courses_loop_item_info_wrapper_close (){
	?>
	</div>
	<?php
}

if ( !function_exists( "unilearn_lp_custom_colors_styles" ) ){
	function unilearn_lp_custom_colors_styles (){
		$theme_custom_color = esc_attr( unilearn_get_option( 'theme_color' ) );
		$theme_2_custom_color = esc_attr( unilearn_get_option( 'theme_2_color' ) );
		$theme_3_custom_color = esc_attr( unilearn_get_option( 'theme_3_color' ) );
		$custom_colors_styles = "";
		$custom_colors_styles .= "
			.lp-course-progress .lp-progress-bar .lp-passing-conditional,
			#course-reviews .course-average-rate,
			.learn-press-user-profile .learn-press-subtabs > li.current{
				background-color: $theme_custom_color;
			}
			.learn-press-user-profile .learn-press-subtabs > li.current{
				border-color: $theme_custom_color;
			}
		";
		$custom_colors_styles .= "
			.lp-course-progress .lp-progress-bar .lp-progress-value,
			.lp-course-progress .lp-progress-bar .lp-progress-value > span{
				background-color: $theme_2_custom_color;
			}
			.lp-course-progress .lp-progress-bar .lp-progress-value > span:after{
				border-top-color: $theme_2_custom_color;			
			}
			.review-stars > li span.hover:before,
			.course-reviews-list .review-stars-rated .review-stars.filled:before{
				color: $theme_2_custom_color;
			}
		";
		$custom_colors_styles .= "
			.lp-course-progress.passed .lp-progress-value,
			.lp-course-progress.passed .lp-progress-bar .lp-progress-value > span,
			#learn-press-course-curriculum .section-header,
			#learn-press-course-curriculum .section-header:hover,
			.learn-press-search-course-form .search-course-button{
				background-color: $theme_3_custom_color;
			}
			.lp-course-progress.passed .lp-progress-bar .lp-progress-value > span:after,
			.learn-press-tabs .learn-press-nav-tabs .learn-press-nav-tab.active{
				border-top-color: $theme_3_custom_color;
			}
			.learn-press-search-course-form .search-course-button{
				border-color: $theme_3_custom_color;			
			}
			.learn-press-search-course-form .search-course-button:hover{
				color: $theme_3_custom_color;			
			}
			@media screen and (max-width: 767px){
				.learn-press-tabs .learn-press-nav-tabs .learn-press-nav-tab.active{
					background-color: $theme_3_custom_color;
					border-color: $theme_3_custom_color;
					border-top-color: $theme_3_custom_color !important;
				}			
			}
		";
		echo sprintf("%s", $custom_colors_styles);
	}
}
add_action( 'unilearn_lp_custom_colors_hook', 'unilearn_lp_custom_colors_styles' );

function unilearn_lp_front_dynamic_styles (){
	echo "
		body.admin-bar .single-quiz .quiz-sidebar{
			margin-top: 32px;
		}
		@media screen and ( max-width:782px ){
			body.admin-bar .single-quiz .quiz-sidebar{
				margin-top: 46px;
			}
		}
	";
}
add_action( 'unilearn_lp_front_dynamic_styles_hook', 'unilearn_lp_front_dynamic_styles' );

function unilearn_lp_body_font_styles (){
	$font_options = unilearn_get_option( 'body_font' );
	$font_family = esc_attr( $font_options['font-family'] );
	$font_size = esc_attr( $font_options['font-size'] );
	$line_height = esc_attr( $font_options['line-height'] );
	$font_color = esc_attr( $font_options['color'] );
	echo "
		.quiz-question-nav-buttons > button{
			font-size: $font_size;
		}
	";
}
add_action( 'unilearn_lp_body_font_styles_hook', 'unilearn_lp_body_font_styles' );

function unilearn_lp_header_font_styles (){
	$font_options = unilearn_get_option( 'header_font' );
	$font_family = esc_attr( $font_options['font-family'] );
	$font_size = esc_attr( $font_options['font-size'] );
	$line_height = esc_attr( $font_options['line-height'] );
	$font_color = esc_attr( $font_options['color'] );
	echo "
		#learn-press-course-curriculum .course-item.viewable:hover > a{
			color: $font_color;
		}
	";
}
add_action( 'unilearn_lp_header_font_styles_hook', 'unilearn_lp_header_font_styles' );

function unilearn_lp_single_quiz_sidebar_opener (){
	$title = esc_html__( 'Quiz Sidebar', 'unilearn' );
	echo "<div id='unilearn_lp_single_quiz_sidebar_opener' title='$title'></div>";
}

function unilearn_lp_single_quiz_description_divider (){
	ob_start();
	the_content();
	$content = ob_get_clean();
	if ( strlen( $content ) ){
		echo "<hr class='short' />";
	}
}
function unilearn_lp_divider_short (){
	echo "<hr class='short' />";
}

function unilearn_remove_learnpress_theContent (){
	remove_filter( "the_content", 'learn_press_course_the_content', 99999 );
}

add_action( 'learn_press_single_quiz_summary', 'unilearn_lp_single_quiz_description_divider', 12 );
add_action( 'learn_press_single_quiz_summary', 'unilearn_lp_divider_short', 27 );
add_action( 'learn_press_single_quiz_summary', 'unilearn_lp_divider_short', 32 );

?>