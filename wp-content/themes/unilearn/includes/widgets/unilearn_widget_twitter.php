<?php
	/**
	 * CWS Twitter Widget Class
	 */
class Unilearn_Twitter_Widget extends WP_Widget {

	public function init_fields() {
		$this->fields = array(
			'title' => array(
				'title' => esc_html__( 'Widget Title', 'unilearn' ),
				'atts'	=> 'id="widget-title"',
				'type' => 'text',
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
			'number' => array(
				'type' => 'number',
				'title' => esc_html__( 'Post count', 'unilearn' ),
				'value' => '4',
			),
			'visible_number' => array(
				'type' => 'number',
				'title' => esc_html__( 'Posts per slide', 'unilearn' ),
				'value' => '2',
			)
		);
	}

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_unilearn_twitter', 'description' => esc_html__( 'Unilearn Twitter Widget', 'unilearn' ) );
		parent::__construct( 'unilearn-twitter', esc_html__( 'Unilearn Twitter', 'unilearn' ), $widget_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		extract(shortcode_atts(array(
			'title' => '',
			'icon'				=> '',
			'add_custom_color'	=> false,
			'color'				=> UNILEARN_THEME_COLOR,
			'number' => 4,
			'visible_number' => 2
		), $instance));
		$title = esc_html( $title );
		$icon = esc_attr( $icon );
		$add_custom_color = (bool)$add_custom_color;
		$color = esc_attr( $color );
		$number = (int)$number;
		$visible_number = (int)$visible_number;

		$title = apply_filters( 'widget_title', $title );

		$custom_color = $add_custom_color && !empty( $color );
		$widget_styles = "";
		if ( $custom_color ){
			$widget_styles .= "#$widget_id a:not(.unilearn_button):not(.unilearn_icon),
								#$widget_id a:not(.unilearn_button):not(.unilearn_icon):hover,
								#$widget_id input[type='submit'],
								#$widget_id .widget_icon,
								#$widget_id .latest_tweets .tweet:before{
				color: $color;
			}
			#$widget_id input[type='submit'],
			#$widget_id .latest_tweets .tweet:before,
			#$widget_id .owl-pagination .owl-page{
				border-color: $color;
			}
			#$widget_id input[type='submit']:hover,
			#$widget_id .owl-pagination .owl-page.active{
				background-color: $color;
			}			
			#footer_widgets #$widget_id .widget_header,
			#footer_widgets #$widget_id .widgettitle{
				background-color: $color;				
			}";
		}
		$before_widget = $custom_color ? preg_replace( "#class=\"(.+)\"#", "class=\"$1 custom_color\"", $before_widget ) : $before_widget;

		echo sprintf("%s", $before_widget);
		if ( !empty( $widget_styles ) ){
			echo "<style type='text/css' scoped>$widget_styles</style>";
		}

		$number = (int)$number;
		$visible_number = (int)$visible_number;
		$visible_number = $visible_number == 0 ? $number : $visible_number;
		$retrieved_tweets_number = 0;
		$is_plugin_installed = function_exists( 'getTweets' );
		$tweets = $is_plugin_installed ? getTweets( $number ) : array();
		$retrieved_tweets_number = count( $tweets );
		$is_carousel = $retrieved_tweets_number > $visible_number;
		if ( $is_carousel ){
			wp_enqueue_script( 'owl_carousel' );
		}

		if ( !empty( $icon ) ){
			echo sprintf("%s", $before_title . "<i class='widget_icon fa $icon'></i>" . $title . $after_title);	
		}
		else{
			echo !empty( $title ) ? $before_title . $title . $after_title : "";
		}

		if ( !empty( $tweets ) ){
			if ( isset( $tweets['error'] ) && !empty( $tweets['error'] ) ){
				echo do_shortcode( "[cws_sc_msg_box title='" . esc_html__( 'Twitter applyed with error', 'unilearn' ) . "' type='error']" . esc_html( $tweets['error'] ) . "[/cws_sc_msg_box]" );
			}
			else{
				if ( $is_carousel ){
					echo "<ul class='latest_tweets widget_carousel bullets_nav'>";
					$groups_count = ceil( $retrieved_tweets_number / $visible_number );
					for ( $i = 0; $i < $groups_count; $i++ ){
						echo "<li>";
							echo "<ul>";
								for( $j = $i * $visible_number; ( ( $j < ( $i + 1 ) * $visible_number ) && ( $j < $retrieved_tweets_number ) ); $j++ ){
									$tweet = $tweets[$j];
									$tweet_text = $tweet['text'];
									$tweet_date = $tweet['created_at'];
									echo "<li class='tweet'>";
										echo "<div class='text'>";
											echo esc_html( $tweet_text );
										echo "</div>";
										echo "<div class='date'>";
											echo esc_html( date( "Y-m-d H:i:s", strtotime( $tweet_date ) ) );
										echo "</div>";	
									echo "</li>";						
								}
							echo "</ul>";
						echo "</li>";
					}
					echo "</ul>";
				}
				else{
					echo "<ul class='latest_tweets'>";
						foreach ( $tweets as $tweet ) {
							echo "<li class='tweet'>";
								$tweet_text = $tweet['text'];
								$tweet_date = $tweet['created_at'];
								echo "<div class='text'>";
									echo esc_html( $tweet_text );
								echo "</div>";
								echo "<div class='date'>";
									echo esc_html( date( "Y-m-d H:i:s", strtotime( $tweet_date ) ) );
								echo "</div>";
							echo "</li>";
						}
					echo "</ul>";
				}
			}
		}
		else{
			if ( !$is_plugin_installed ){
				echo do_shortcode( "[cws_sc_msg_box title='" . esc_html__( 'Plugin not installed', 'unilearn' ) . "' type='warn']" . esc_html__( 'Please install and activate required plugin ', 'unilearn' ) . "<a href='https://ru.wordpress.org/plugins/oauth-twitter-feed-for-developers/'>" . esc_html__( "oAuth Twitter Feed for Developers", 'unilearn' ) . "</a>[/cws_sc_msg_box]" );
			}
		}
		echo sprintf("%s", $after_widget);
	}

	public function update( $new_instance, $old_instance ) {
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