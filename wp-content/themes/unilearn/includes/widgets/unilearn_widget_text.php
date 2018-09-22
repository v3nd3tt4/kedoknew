<?php
	/**
	 * Unilearn Text Widget Class
	 */
class Unilearn_Text_Widget extends WP_Widget {
	
	public function init_fields() {
		$this->fields = array(
			'title' => array(
				'title'	=> esc_html__( 'Widget Title', 'unilearn' ),
				'atts'	=> 'id="widget-title"',
				'type'	=> 'text',
			),
			'icon'	=> array(
				'title'			=> esc_html__( 'Widget Icon', 'unilearn' ),
				'type'			=> 'select',
				'addrowclasses' => 'fai',
				'source' 		=> 'fa'
			),
			'add_custom_color'	=> array(
				'title'			=> esc_html__( 'Add Custom Color', 'unilearn' ),
				'type'			=> 'checkbox',
				'addrowclasses' => 'checkbox',
				'atts'			=> 'data-options="e:color;"'
			),
			'color'	=> array(
				'title'					=> esc_html__( 'Custom Color', 'unilearn' ),
				'type'					=> 'text',
				'atts'					=> 'data-default-color="' . UNILEARN_THEME_COLOR . '"'
			),
			'text'				=> array(
				'title'			=> esc_html__( 'Widget Content', 'unilearn' ),
				'type'			=> 'textarea',
				'atts'			=> 'rows="8"',
				'default'		=> ''
			)
		);
	}
	public function __construct() {
		$widget_ops = array( 'classname' => 'widget-unilearn-text', 'description' => esc_html__( 'Unilearn Text Widget', 'unilearn' ) );
		parent::__construct( 'unilearn-text', esc_html__( 'Unilearn Text', 'unilearn' ), $widget_ops );
	}
	public function widget( $args, $instance ) {
		extract( $args );
		extract(shortcode_atts(array(
			'title' 			=> '',
			'icon'				=> '',
			'add_custom_color'	=> false,
			'color'				=> UNILEARN_THEME_COLOR,
			'text'				=> ''
		), $instance));
		$title = esc_html( $title );
		$icon = esc_html( $icon );
		$add_custom_color =(bool)$add_custom_color;
		$color = esc_attr( $color );
		$custom_color = $add_custom_color && !empty( $color );

		$title = apply_filters( 'widget_title', $title );

		$widget_styles = "";
		if ( $custom_color ){
			$widget_styles .= "#$widget_id a:not(.unilearn_button):not(.unilearn_icon),
								#$widget_id a:not(.unilearn_button):not(.unilearn_icon):hover,
								#$widget_id input[type='submit'],
								#$widget_id .widget_icon{
				color: $color;
			}
			#$widget_id input[type='submit']:hover{
				color: #fff;
			}
			#$widget_id input[type='submit'],
			#$widget_id .owl-pagination .owl-page{
				border-color: $color;
			}
			#$widget_id input[type='submit']:hover,
			#footer_widgets #$widget_id .widgettitle,
			#$widget_id .owl-pagination .owl-page.active{
				background-color: $color;
			}";
		}
		$before_widget = $custom_color ? preg_replace( "#class=\"(.+)\"#", "class=\"$1 custom_color\"", $before_widget ) : $before_widget;
		echo sprintf("%s", $before_widget);
		if ( !empty( $widget_styles ) ){
			echo "<style type='text/css' scoped>$widget_styles</style>";
		}
		if ( !empty( $title ) ){
			echo sprintf("%s", $before_title);
			if ( !empty( $icon ) ){
				echo "<i class='widget_icon fa $icon'></i>";
			}
			echo sprintf("%s", $title);
			echo sprintf("%s", $after_title);
		}
		$content =  wpautop(do_shortcode( $text ));
		if ( !empty( $content ) ){
			echo "<div class='cws_widget_content'>";
				echo sprintf("%s", $content);
			echo "</div>";
		}
		echo sprintf("%s", $after_widget);
	}
	public function update( $new_instance, $instance ) {
		$instance = (array)$new_instance;
		foreach ($new_instance as $key => $v) {
			switch ($this->fields[$key]['type']) {
				case 'text':
					$instance[$key] = strip_tags($v);
					break;
			}
		}
		return $instance;
	}
	public function form( $instance ) {
		$this->init_fields();
		$args[0] = $instance;
		unilearn_mb_fillMbAttributes( $args, $this->fields );
		echo unilearn_mb_print_layout( $this->fields, 'widget-' . $this->id_base . '[' . $this->number . '][');
	}
}
?>