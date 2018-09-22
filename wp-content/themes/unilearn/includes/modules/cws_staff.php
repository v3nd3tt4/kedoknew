<?php

function unilearn_cws_staff_posts_grid_posts ( $q = null ){
	if ( !isset( $q ) ) return;
	$def_grid_atts = array(
					'layout'						=> '1',
					'cws_staff_data_to_hide'		=> array(),
					'total_items_count'				=> PHP_INT_MAX
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;
	extract( $grid_atts );
	$paged = $q->query_vars['paged'];
	if ( $paged == 0 && $total_items_count < $q->post_count ){
		$post_count = $total_items_count;
	}
	else{
		$ppp = $q->query_vars['posts_per_page'];
		$posts_left = $total_items_count - ( $paged - 1 ) * $ppp;
		$post_count = $posts_left < $ppp ? $posts_left : $q->post_count;
	}
	if ( $q->have_posts() ):
		ob_start();
		while( $q->have_posts() && $q->current_post < $post_count - 1 ):
			$q->the_post();
			unilearn_cws_staff_posts_grid_post ();
		endwhile;
		wp_reset_postdata();
		ob_end_flush();
	endif;		
}

function unilearn_get_cws_staff_thumbnail_dims ( $real_dims = array() ) {
	$def_grid_atts = array(
					'layout'				=> '1',
					'sb_layout'				=> '',
				);
	$def_single_atts = array(
					'sb_layout'				=> '',
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;
	$single_atts = isset( $GLOBALS['unilearn_single_post_atts'] ) ? $GLOBALS['unilearn_single_post_atts'] : $def_single_atts;
	$single = is_single();
	if ( $single ){
		extract( $single_atts );
	}
	else{
		extract( $grid_atts );
	}
	$dims = array( 'width' => 0, 'height' => 0 );
	if ($single){
		if ( ( empty( $real_dims ) || ( isset( $real_dims['width'] ) && $real_dims['width'] > 1170 ) ) ) {
			$dims['width']	= 1170;
		}
	}
	else{
		$dims['width']		= 210;
	}
	return $dims;
}

function unilearn_cws_staff_posts_grid_post (){
	$def_grid_atts = array(
					'layout'					=> '1',
					'cws_staff_data_to_hide'	=> array(),
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;
	extract( $grid_atts );
	$pid = get_the_id();
	$item_id = uniqid( "cws_staff_post_" );
	$post_meta = get_post_meta( $pid, 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$color = isset( $post_meta['color'] ) ? $post_meta['color']: UNILEARN_THEME_COLOR;
	$style = "";
	$style .= "<style type='text/css' scoped>";
		$style .= "#{$item_id}:hover .cws_staff_posts_grid_post_data_divider{
			background-color: $color;
		}
		#{$item_id}:hover .post_social_links{
			color: $color;
		}
		#{$item_id} > .unilearn_wrapper{
			background-color: $color;
		}
		@media screen and ( min-width: 981px ){
			#page.single_sidebar .cws_staff_posts_grid.posts_grid_2 #{$item_id} .cws_staff_posts_grid_post_data_divider,
			#page.double_sidebar .cws_staff_posts_grid.posts_grid_2 #{$item_id} .cws_staff_posts_grid_post_data_divider{
				background-color: $color;
			}
			#page.single_sidebar .cws_staff_posts_grid.posts_grid_2 #{$item_id} .post_social_links,
			#page.double_sidebar .cws_staff_posts_grid.posts_grid_2 #{$item_id} .post_social_links{
				color: $color;
			}
		}
		@media screen and ( max-width: 479px ){
			#{$item_id} .cws_staff_posts_grid_post_data_divider{
				background-color: $color;
			}
			#{$item_id} .post_social_links{
				color: $color;
			}
		}";
	$style .= "</style>";
	echo "<article id='$item_id' data-pid='$pid' class='item cws_staff_post posts_grid_post' data-color='" . esc_html( $color ) . "'>";
		echo sprintf("%s", $style);
		echo "<div class='unilearn_wrapper clearfix'>";
			ob_start();
			unilearn_cws_staff_posts_grid_post_media ();
			$media = ob_get_clean();
			if ( !empty($media ) ){
				echo "<div class='floated_media posts_grid_post_floated_media cws_staff_posts_grid_post_floated_media'>";
					echo "<div class='floated_media_wrapper posts_grid_post_floated_media_wrapper cws_staff_posts_grid_post_floated_media_wrapper'>";			
						echo sprintf("%s", $media);
					echo "</div>";
				echo "</div>";
			}
			echo "<div class='unilearn_cws_staff_posts_grid_post_data'>";
				ob_start();
				unilearn_cws_staff_posts_grid_post_title ();
				if ( !in_array( 'department', $cws_staff_data_to_hide ) ) {
					$deps = unilearn_get_post_term_links_str( 'cws_staff_member_department' );
					if ( !empty( $deps ) ){
						echo "<div class='post_terms cws_staff_post_terms posts_grid_post_terms'>";
							echo sprintf("%s", $deps);
						echo "</div>";	
					}
				}
				if ( !in_array( 'position', $cws_staff_data_to_hide ) ) {
					$poss = unilearn_get_post_term_links_str( 'cws_staff_member_position' );
					if ( !empty( $poss ) ){
						echo "<div class='post_terms cws_staff_post_terms posts_grid_post_terms'>";
							echo sprintf("%s", $poss);
						echo "</div>";	
					}
				}	
				$title_terms = ob_get_clean();	
				ob_start();
				unilearn_cws_staff_posts_grid_post_content ();
				unilearn_cws_staff_posts_grid_social_links ();
				$content_links = ob_get_clean();
				if ( empty( $title_terms ) || empty( $content_links ) ){
					echo sprintf("%s", $title_terms);
					echo sprintf("%s", $content_links);
				}
				else{
					echo sprintf("%s", $title_terms);
					echo "<hr class='cws_staff_posts_grid_post_data_divider' />";
					echo sprintf("%s", $content_links);
				}
			echo "</div>";
		echo "</div>";
		echo "<hr class='posts_grid_spacing' />";
	echo "</article>";
}
function unilearn_cws_staff_posts_grid_post_media (){
	$pid = get_the_id();
	$permalink = get_the_permalink( $pid );
	$def_grid_atts = array(
					'layout'						=> '1',
					'cws_staff_data_to_hide'	=> array()
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	$post_url = esc_url(get_the_permalink());
	$post_meta = get_post_meta( $pid, 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$thumbnail_props = has_post_thumbnail() ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$thumbnail_dims = unilearn_get_cws_staff_thumbnail_dims();
	$thumb_obj = bfi_thumb( $thumbnail, $thumbnail_dims, false );
	$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
	$retina_thumb_exists = false;
	$retina_thumb_url = "";	
	if ( isset( $thumb_obj[3] ) ){
		extract( $thumb_obj[3] );
	}			
	$retina_thumb_url = esc_attr($retina_thumb_url);
	$clickable = isset( $post_meta['is_clickable'] ) ? $post_meta['is_clickable']: false;
	if ( !empty( $thumb_url ) ){
	?>
		<div class="post_media cws_staff_post_media cws_staff_posts_grid_post_media">
			<?php
				echo "<div class='cws_staff_photo'>";
					if ( $clickable ) { echo "<a href='$permalink'>";}
					if ( $retina_thumb_exists ) {
						echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
					}
					else{
						echo "<img src='$thumb_url' data-no-retina alt />";
					}
					if ( $clickable ) { echo "</a>";}
				echo "</div>";
			?>
		</div>
	<?php
	}	
}
function unilearn_cws_staff_posts_grid_post_title (){
	$title = get_the_title();
	echo !empty( $title ) ?	"<h3 class='post_title cws_staff_post_title posts_grid_post_title'>$title</h3>" : "";	
}
function unilearn_cws_staff_posts_grid_post_content (){
	$pid = get_the_id();
	$post = get_post( $pid );
	$post_content = !empty( $post->post_excerpt ) ? wptexturize( $post->post_excerpt ) : "";
	$post_content = esc_html( $post_content );
	if ( !empty( $post_content ) ){
		echo "<div class='post_content posts_grid_post_content cws_staff_post_content'>";
			echo sprintf("%s", $post_content);
		echo "</div>";
	}
}
function unilearn_cws_staff_posts_grid_social_links (){
	$pid = get_the_id();
	$post_meta = get_post_meta( $pid, 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$social_group = isset( $post_meta['social_group'] ) ? $post_meta['social_group']: array();
	$icons = "";
	foreach ( $social_group as $social ) {
		$title = isset( $social['title'] ) ? $social['title'] : "";
		$icon = isset( $social['icon'] ) ? $social['icon'] : "";
		$url = isset( $social['url'] ) ? $social['url'] : "";
		if ( !empty( $icon ) && !empty( $url ) ){
			$icons .= "<a href='$url' target='_blank' class='fa {$icon}'" . ( !empty( $title ) ? " title='$title'" : "" ) . "></a>";
		}
	}
	if ( !empty( $icons ) ){
		echo "<div class='post_social_links cws_staff_social_links posts_grid_social_links'>";
			echo sprintf("%s", $icons);	
		echo "</div>";
	}
}
function unilearn_cws_staff_single_social_links (){
	$pid = get_the_id();
	$post_meta = get_post_meta( $pid, 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$social_group = isset( $post_meta['social_group'] ) ? $post_meta['social_group']: array();
	$icons = "";
	foreach ( $social_group as $social ) {
		$title = isset( $social['title'] ) ? $social['title'] : "";
		$icon = isset( $social['icon'] ) ? $social['icon'] : "";
		$url = isset( $social['url'] ) ? $social['url'] : "";
		if ( !empty( $icon ) && !empty( $url ) ){
			$icons .= "<a href='$url' target='_blank' class='fa {$icon} fa-lg'" . ( !empty( $title ) ? " title='$title'" : "" ) . "></a>";
		}
	}
	if ( !empty( $icons ) ){
		echo "<div class='post_social_links cws_staff_social_links single_social_links'>";
			echo sprintf("%s", $icons);	
		echo "</div>";
	}	
}

function unilearn_cws_staff_single_post_media (){
	$pid = get_the_id();
	$post_meta = get_post_meta( $pid, 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$thumbnail_props = has_post_thumbnail() ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$real_thumbnail_dims = array();
	if ( !empty( $thumbnail_props ) && isset( $thumbnail_props[1] ) ) $real_thumbnail_dims['width'] = $thumbnail_props[1];
	if ( !empty(  $thumbnail_props ) && isset( $thumbnail_props[2] ) ) $real_thumbnail_dims['height'] = $thumbnail_props[2];
	$thumbnail_dims = unilearn_get_cws_staff_thumbnail_dims( $real_thumbnail_dims );
	$crop_thumb = isset( $thumbnail_dims['width'] ) && $thumbnail_dims['width'] > 0;
	$thumb_obj = bfi_thumb( $thumbnail, $thumbnail_dims, false );
	$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
	$retina_thumb_exists = false;
	$retina_thumb_url = "";	
	if ( isset( $thumb_obj[3] ) ){
		extract( $thumb_obj[3] );
	}			
	$retina_thumb_url = esc_attr($retina_thumb_url);
	if ( !empty( $thumb_url ) ){
	?>
		<div class="post_media cws_staff_post_media single_post_media">
			<?php
				echo "<div class='cws_staff_photo'>";
					if ( $retina_thumb_exists ) {
						echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
					}
					else{
						echo "<img src='$thumb_url' data-no-retina alt />";
					}
				echo "</div>";
			?>
		</div>
	<?php
		$GLOBALS['unilearn_cws_portfolio_single_post_floated_media'] = !$crop_thumb ? true : false;
	}	
}

function unilearn_cws_staff_single_post_content (){
	$pid = get_the_id();
	$post = get_post( $pid );
	$post_content =  apply_filters( 'the_content', $post->post_content );
	if ( !empty( $post_content ) ){
		echo "<div class='post_content single_post_content cws_staff_post_content'>";
			echo sprintf("%s", $post_content);
		echo "</div>";
	}
}

?>