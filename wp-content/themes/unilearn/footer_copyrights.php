<?php
$copyrights_text = unilearn_get_option( "copyrights_text" );
$social_location = unilearn_get_option( 'social_location' );
$social_links = unilearn_render_social_links ();
$show_social_in_cprs = in_array( $social_location, array( 'bottom', 'both' ) ) && !empty( $social_links );
$is_wpml_active = unilearn_is_wpml_active ();
$show_flags_in_footer = unilearn_show_flags_in_footer ();

$flags = '';
if ( is_plugin_active('sitepress-multilingual-cms/sitepress.php') ) {
	global $wpml_language_switcher;
	$slot = $wpml_language_switcher->get_slot( 'statics', 'footer' ); 
	$template = $slot->get_model();
	$flags = $slot->is_enabled();
}

if ( !empty( $copyrights_text ) || $show_social_in_cprs ){
	echo "<footer id='site_footer'>";
		echo "<div class='unilearn_layout_container clearfix'>";
			if ( $is_wpml_active ){

				$class_wpml = '';
				if(isset($template['template']) && !empty($template['template'])){
					if($template['template'] == 'wpml-legacy-vertical-list'){
						$class_wpml = 'wpml_language_switch lang_bar '. $template['template'];
					}
					else{
						$class_wpml = 'wpml_language_switch horizontal_bar '.$template['template'];
					}      
				} else{
					$class_wpml = 'lang_bar';
				}
				ob_start();
					do_action( 'wpml_footer_language_selector');				
				$wpml_footer_result = ob_get_clean();

				if ( $is_wpml_active && !empty($flags) && !empty($wpml_footer_result) ) : ?>
					<div id="footer_icl" class="<?php echo esc_attr($class_wpml);?>">
						<?php 
						echo sprintf("%s", $wpml_footer_result);

						?>
					</div>
				<?php endif;
			}

			if ($show_social_in_cprs){
				echo "<div id='footer_social' class='unilearn_social'>" . wp_kses( $social_links, array(
					'a' 	=> array(
				    	'class'	=> array(),					
					    'href'	=> array(),
					    'title' => array()
				    ),
				    'i' 	=> array(
				    	'class'	=> array()
				    )
				)) . "</div>";				
			}
			if (!empty( $copyrights_text )){
				echo "<div id='site_copyrights'>" . wp_kses( $copyrights_text, array(
					'a' 	=> array(
					    'href'	=> array(),
					    'title' => array()
				    ),
				    'span' 	=> array(),
				    'i' 	=> array(
				    	'class'	=> array()
				    ),
				    'br' 	=> array(),
				    'em' 	=> array(),
				    'strong'=> array(),
				)) . "</div>";
			}
		echo "</div>";
	echo "</footer>";
}
?>