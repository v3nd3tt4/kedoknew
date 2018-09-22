<?php
extract( shortcode_atts( array(
	"icon"						=> "",
	'number' 					=> 4,
	'visible_number' 			=> 2,
	"customize_colors"			=> false,
	"custom_font_color"			=> "",
	// "custom_link_color"			=> "",
	"customize_divider"			=> false,
	"divider_first_color"		=> UNILEARN_THEME_COLOR,
	"divider_second_color"		=> UNILEARN_THEME_2_COLOR,
	"divider_third_color"		=> UNILEARN_THEME_3_COLOR,
	"el_class"					=> ""
	), $atts));
	$title 					= esc_attr( $icon );
	$title 					= esc_html( $title );
	$number 				= esc_textarea( $number );
	$visible_number 		= esc_textarea( $visible_number );
	$customize_colors 		= (bool)$customize_colors;
	$custom_font_color 	  	= esc_attr( $custom_font_color );
	// $custom_link_color 	  	= esc_attr( $custom_link_color );
	$customize_divider		= (bool)$customize_divider;
	$divider_first_color 	= esc_attr( $divider_first_color );
	$divider_second_color 	= esc_attr( $divider_second_color );
	$divider_third_color 	= esc_attr( $divider_third_color );
	$el_class				= esc_attr( $el_class );
	$number = empty( $number ) ? 4 : (int)$number;
	$visible_number = empty( $visible_number ) ? 2 : (int)$visible_number;
$classes = "cws_twitter unilearn_module";
$classes .= !empty( $el_class ) ? " $el_class" : "";
$classes = trim( $classes );
$id = uniqid( "cws_twitter_" );

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
$tweets_received = false;
ob_start();
if ( !empty( $tweets ) ){
	if ( isset( $tweets['error'] ) && !empty( $tweets['error'] ) ){
		echo do_shortcode( "[cws_sc_msg_box title='" . esc_html__( 'Twitter applyed with error', 'unilearn' ) . "' type='error']" . esc_html( $tweets['error'] ) . "[/cws_sc_msg_box]" );
	}
	else{
		if ( $is_carousel ){
			echo "<ul class='cws_tweets widget_carousel bullets_nav'>";
			$groups_count = ceil( $retrieved_tweets_number / $visible_number );
			for ( $i = 0; $i < $groups_count; $i++ ){
				echo "<li class='cws_tweets_group'>";
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
			echo "<ul class='cws_tweets'>";
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
		$tweets_received = true;
	}
}
else{
	if ( !$is_plugin_installed ){
		echo do_shortcode( "[cws_sc_msg_box title='" . esc_html__( 'Plugin not installed', 'unilearn' ) . "' type='warn']" . esc_html__( 'Please install and activate required plugin ', 'unilearn' ) . "<a href='https://ru.wordpress.org/plugins/oauth-twitter-feed-for-developers/'>" . esc_html__( "oAuth Twitter Feed for Developers", 'unilearn' ) . "</a>[/cws_sc_msg_box]" );
	}
}
$twitter_response = ob_get_clean();


ob_start();
if ( $customize_colors && !empty( $custom_font_color ) ){
	echo "#{$id} .cws_twitter_icon i,
			#{$id} .cws_tweets .tweet{
				color: $custom_font_color;
			}
			#{$id} .cws_twitter_icon i,
			#{$id} .owl-pagination .owl-page{
				border-color: $custom_font_color;
			}
			#{$id} .owl-pagination .owl-page.active{
				background-color: $custom_font_color;
			}";
}
if ( $customize_divider ){
	echo "#{$id} .cws_twitter_divider:before{";
		if ( !empty($divider_first_color ) ){
			echo "border-left-color: $divider_first_color;";
		}
		if ( !empty($divider_second_color ) ){
			echo "background-color: $divider_second_color;";			
		}
		if ( !empty($divider_third_color ) ){
			echo "border-right-color: $divider_third_color;";			
		}
	echo "}";
}
$styles = ob_get_clean();

ob_start();
if ( $tweets_received ){
	echo !empty( $styles ) ? "<style type='text/css'>$styles</style>" : "";
	echo "<div id='$id' class='$classes'>";
		if ( !empty( $icon ) ){
			echo "<div class='cws_twitter_icon'>";
				echo "<i class='$icon'></i>";
			echo "</div>";
			echo "<hr class='short cws_twitter_divider' />";
		}
		echo sprintf("%s", $twitter_response);
	echo "</div>";
}
else{
	echo sprintf("%s", $twitter_response);
}
$out = ob_get_clean();
echo sprintf("%s", $out);
?>