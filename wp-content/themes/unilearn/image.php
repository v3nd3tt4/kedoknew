<?php
get_header();

$sb = unilearn_get_sidebars();
extract( $sb );
$page_classes = "";
$page_classes .= !empty( $sb_layout_class ) ? " {$sb_layout_class}_sidebar" : "";
$page_classes = trim( $page_classes );

echo "<div id='page'" . ( !empty( $page_classes ) ? " class='$page_classes'" : "" ) . ">";
	echo "<div class='unilearn_layout_container'>";
		if ( in_array( $sb_layout, array( "left", "both" ) ) ){
			echo "<ul id='left_sidebar' class='sidebar'>";
				dynamic_sidebar( $sidebar1 );
			echo "</ul>";
		}
		if ( $sb_layout === "right" ){
			echo "<ul id='right_sidebar' class='sidebar'>";
				dynamic_sidebar( $sidebar1 );
			echo "</ul>";
		}
		else if ( $sb_layout === "both" ){
			echo "<ul id='right_sidebar' class='sidebar'>";
				dynamic_sidebar( $sidebar2 );
			echo "</ul>";	
		}
		echo "<main id='page_content'>";
			while ( have_posts() ) : the_post();
				$pid = get_the_id();
				echo "<article id='attachment_post_{$pid}' class='attachment_post post_single clearfix'>";
					ob_start();
					$thumbnail_props = wp_get_attachment_image_src( $pid,'full');
					$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
					$real_thumbnail_dims = array();
					if ( !empty( $thumbnail_props ) && isset( $thumbnail_props[1] ) ) $real_thumbnail_dims['width'] = $thumbnail_props[1];
					if ( !empty(  $thumbnail_props ) && isset( $thumbnail_props[2] ) ) $real_thumbnail_dims['height'] = $thumbnail_props[2];
					$thumbnail_dims = unilearn_get_post_thumbnail_dims( false, $real_thumbnail_dims );
					$crop_thumb = isset( $thumbnail_dims['width'] ) && $thumbnail_dims['width'] > 0;
					$wth_hover = !$crop_thumb;
					$floated_media = !$crop_thumb;					
					$thumb_obj = bfi_thumb( $thumbnail, $thumbnail_dims, false );
					$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
					$retina_thumb_exists = false;
					$retina_thumb_url = "";	
					if ( isset( $thumb_obj[3] ) ){
						extract( $thumb_obj[3] );
					}			
					$retina_thumb_url = esc_attr($retina_thumb_url);
					if ($floated_media){
						echo "<div class='floated_media post_floated_media image_floated_media single_post_floated_media'>";	
							echo "<div class='floated_media_wrapper post_floated_media_wrapper image_floated_media_wrapper single_post_floated_media_wrapper'>";							
					}
								echo "<div class='post_media attachment_post_media attachment_single_post_media'>";
									echo "<div class='pic" . ( $wth_hover ? " wth_hover" : "" ) . "'>";
										if ( $retina_thumb_exists ) {
											echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
										}
										else{
											echo "<img src='$thumb_url' data-no-retina alt />";
										}
										if ( !$wth_hover ){
											echo "<div class='hover-effect'></div>";
											echo "<div class='links'><a class='fancy fa fa-plus' href='$thumbnail'></a></div>";
										}
									echo "</div>";
								echo "</div>";
					if ($floated_media){
							echo "</div>";
						echo "</div>";
					}								
					$content = apply_filters( 'the_content', get_the_content () );
					if ( !empty( $content ) ){
						echo "<div class='post_content attachment_post_content  attachment_single_post_content" . ( $floated_media ? " clearfix" : "" ) . "'>";
							echo sprintf("%s", $content);
						echo "</div>";
					}
					unilearn_page_links ();
				echo "</article>";
				/* ATTACHMENTS NAVIGATION */
				ob_start();
				$prev_link_text = is_rtl() ? "<span>" . esc_html__( 'Previous Image', 'unilearn' ) . "</span>&#x20;<i class='fa fa-angle-double-right'></i>" : "<i class='fa fa-angle-double-left'></i>&#x20;<span>" . esc_html__( 'Previous Image', 'unilearn' ) . "</span>";
				$next_link_text = is_rtl() ? "<i class='fa fa-angle-double-left'></i>&#x20;<span>" . esc_html__( 'Nexts Image', 'unilearn' ) . "</span>" : "<span>" . esc_html__( 'Next Image', 'unilearn' ) . "</span>&#x20;<i class='fa fa-angle-double-right'></i>";
				previous_image_link( false, $prev_link_text );
				$prev_img_link = ob_get_clean();
				ob_start();
				next_image_link( false, $next_link_text );
				$next_img_link = ob_get_clean();
				if ( !empty( $prev_img_link ) || !empty( $next_img_link ) ){
					echo "<nav class='attachment_nav clearfix'>";
						echo !empty( $prev_img_link ) ? "<div class='prev_section'>$prev_img_link</div>" : "";
						echo !empty( $next_img_link ) ? "<div class='next_section'>$next_img_link</div>" : "";
					echo "</nav>";
				}
				/* \ATTACHMENTS NAVIGATION */
			endwhile;
			wp_reset_postdata();
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				echo "<hr />";
				comments_template();
			}
		echo "</main>";
	echo "</div>";
echo "</div>";

get_footer();
?>