<?php

function unilearn_cws_portfolio_posts_grid_posts ( $q = null ){
	if ( !isset( $q ) ) return;
	$def_grid_atts = array(
					'layout'						=> '1',
					'cws_portfolio_data_to_show'	=> array(),
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
			unilearn_cws_portfolio_posts_grid_post ();
		endwhile;
		wp_reset_postdata();
		ob_end_flush();
	endif;				
}
function unilearn_get_cws_portfolio_thumbnail_dims ( $eq_thumb_height = false, $real_dims = array() ) {
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
		if ( empty( $sb_layout ) ){
			if ( ( empty( $real_dims ) || ( isset( $real_dims['width'] ) && $real_dims['width'] > 1170 ) ) || $eq_thumb_height ){
				$dims['width'] = 1170;
			}
		}
		else if ( $sb_layout === "single" ){
			if ( ( empty( $real_dims ) || ( isset( $real_dims['width'] ) && $real_dims['width'] > 870 ) ) || $eq_thumb_height ){
				$dims['width'] = 870;
			}
		}
		else if ( $sb_layout === "double" ){
			if ( ( empty( $real_dims ) || ( isset( $real_dims['width'] ) && $real_dims['width'] > 570 ) ) || $eq_thumb_height ){
				$dims['width'] = 570;
			}
		}
	}
	else{
		switch ($layout){
			case "1":
				if ( empty( $sb_layout ) ){
					$dims['width'] = 1170;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 659;
					}	
				}
				else if ( $sb_layout === "single" ){
					$dims['width'] = 870;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 490;
					}	
				}
				else if ( $sb_layout === "double" ){
					$dims['width'] = 570;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 321;
					}	
				}
				break;
			case '2':
				if ( empty( $sb_layout ) ){
					$dims['width'] = 570;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 321;
					}	
				}
				else if ( $sb_layout === "single" ){
					$dims['width'] = 420;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 237;
					}	
				}
				else if ( $sb_layout === "double" ){
					$dims['width'] = 270;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 152;
					}	
				}
				break;
			case '3':
				if ( empty( $sb_layout ) ){
					$dims['width'] = 370;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 208;
					}	
				}
				else if ( $sb_layout === "single" ){
					$dims['width'] = 270;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 152;
					}	
				}
				else if ( $sb_layout === "double" ){
					$dims['width'] = 270;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 152;
					}	
				}			
				break;
			case '4':
				$dims['width'] = 270;
				if ( !isset( $real_dims['height'] ) ){
					$dims['height'] = 152;
				}	
				break;
		}
	}
	return $dims;
}
function unilearn_get_cws_portfolio_chars_count ( $cols = null ){
	$number = 155;
	switch ( $cols ){
		case '1':
			$number = 300;
			break;
		case '2':
			$number = 130;
			break;
		case '3':
			$number = 70;
			break;
		case '4':
			$number = 55;
			break;
	}
	return $number;
}
function unilearn_cws_portfolio_posts_grid_post (){
	$def_grid_atts = array(
					'layout'						=> '1',
					'cws_portfolio_data_to_show'	=> array()
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;
	extract( $grid_atts );
	$pid = get_the_id();
	if ( empty( $cws_portfolio_data_to_show ) || empty( $cws_portfolio_data_to_show[0] ) ){
		if ( has_post_thumbnail( $pid ) ){
			echo "<article id='post_post_{$pid}' class='item portfolio_item_post portfolio_item_grid_post clearfix'>";
			unilearn_cws_portfolio_posts_grid_post_media ();
			echo "<hr class='posts_grid_spacing' />";
			echo "</article>";	
		}		
	}
	else{
		echo "<article id='post_post_{$pid}' class='item portfolio_item_post portfolio_item_grid_post clearfix'>";
		unilearn_cws_portfolio_posts_grid_post_media ();
		unilearn_cws_portfolio_posts_grid_post_title ();
		unilearn_cws_portfolio_posts_grid_post_content ();
		unilearn_cws_portfolio_posts_grid_post_terms ();
		echo "<hr class='posts_grid_divider' />";
		echo "</article>";
	}
}
function unilearn_cws_portfolio_posts_grid_post_media (){
	$pid = get_the_id();
	$permalink = get_the_permalink( $pid );
	$def_grid_atts = array(
					'layout'						=> '1',
					'cws_portfolio_data_to_show'	=> array()
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	$post_url = esc_url(get_the_permalink());
	$post_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$thumbnail_props = has_post_thumbnail() ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$real_thumbnail_dims = array();
	if ( !empty( $thumbnail_props ) && isset( $thumbnail_props[1] ) ) $real_thumbnail_dims['width'] = $thumbnail_props[1];
	if ( !empty(  $thumbnail_props ) && isset( $thumbnail_props[2] ) ) $real_thumbnail_dims['height'] = $thumbnail_props[2];
	$thumbnail_dims = unilearn_get_cws_portfolio_thumbnail_dims( false, $real_thumbnail_dims );
	$thumb_obj = bfi_thumb( $thumbnail, $thumbnail_dims, false );
	$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
	$retina_thumb_exists = false;
	$retina_thumb_url = "";	
	if ( isset( $thumb_obj[3] ) ){
		extract( $thumb_obj[3] );
	}			
	$retina_thumb_url = esc_attr($retina_thumb_url);
	$enable_hover = isset( $post_meta['enable_hover'] ) ? $post_meta['enable_hover'] : false;
	$custom_url = isset( $post_meta['link_options_url'] ) ? $post_meta['link_options_url'] : "";
	$fancybox = isset( $post_meta['link_options_fancybox'] ) ? $post_meta['link_options_fancybox'] : false;
	$link_atts = "";
	$link_url = $fancybox ? ( $custom_url ? $custom_url : $thumbnail ) : ( $custom_url ? $custom_url : $post_url );
	$link_icon = $fancybox ? ( $custom_url ? 'magic' : 'plus' ) : 'share';
	$link_class = $fancybox ? "fancy fa fa-{$link_icon}" : "fa fa-{$link_icon}";
	$link_atts .= !empty( $link_class ) ? " class='$link_class'" : "";
	$link_atts .= !empty( $link_url ) ? " href='$link_url'" : "";
	$link_atts .= !$fancybox && $custom_url ? " target='_blank'" : "";
	$link_atts .= $fancybox && $custom_url ? " data-fancybox-type='iframe'" : "";
	if ( !empty( $thumb_url ) ){
	?>
		<div class="post_media post_post_media post_posts_grid_post_media">
			<?php
				echo "<div class='pic" . ( !$enable_hover ? " wth_hover" : "" ) . "'>";
					if ( $retina_thumb_exists ) {
						echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
					}
					else{
						echo "<img src='$thumb_url' data-no-retina alt />";
					}
					if ( $enable_hover ){
						echo "<div class='hover-effect'></div>";
						echo "<div class='links'>
								<a{$link_atts}></a>
						</div>";
					}
				echo "</div>";
			?>
		</div>
	<?php
	}
}
function unilearn_cws_portfolio_posts_grid_post_title (){
	$pid = get_the_id ();
	$def_grid_atts = array(
					'layout'						=> '1',
					'cws_portfolio_data_to_show'	=> array(),
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	if ( in_array( 'title', $cws_portfolio_data_to_show ) ){
		$title = get_the_title();
		$permalink = get_the_permalink();
		echo !empty( $title ) ?	"<h3 class='cws_portfolio_post_title post_title'><a href='$permalink'>" . $title . "</a></h3>" : "";	
	}
}
function unilearn_cws_portfolio_posts_grid_post_content (){
	$pid = get_the_id ();
	$post = get_post( $pid );
	$def_grid_atts = array(
					'layout'						=> '1',
					'cws_portfolio_data_to_show'	=> array(),
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	$out = "";
	if ( in_array( 'excerpt', $cws_portfolio_data_to_show ) ){
		$chars_count = unilearn_get_cws_portfolio_chars_count( $layout );
		$out = !empty( $post->post_excerpt ) ? $post->post_excerpt : $post->post_content;
		$out = trim( preg_replace( "/[\s]{2,}/", " ", strip_shortcodes( strip_tags( $out ) ) ) );
		$out = wptexturize( $out );
		$out = substr( $out, 0, $chars_count );
		echo !empty( $out ) ? "<div class='cws_portfolio_posts_grid_post_content'>$out</div>" : "";
	}
}
function unilearn_cws_portfolio_posts_grid_post_terms (){
	$pid = get_the_id ();
	$def_grid_atts = array(
					'layout'						=> '1',
					'cws_portfolio_data_to_show'	=> array(),
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );	
	if ( in_array( 'cats', $cws_portfolio_data_to_show ) ){
		$p_category_terms = wp_get_post_terms( $pid, 'cws_portfolio_cat' );
		$p_cats = "";
		for ( $i=0; $i < count( $p_category_terms ); $i++ ){
			$p_category_term = $p_category_terms[$i];
			$p_cat_permalink = get_term_link( $p_category_term->term_id, 'cws_portfolio_cat' );
			$p_cat_name = $p_category_term->name;
			$p_cats .= "<a href='$p_cat_permalink'>$p_cat_name</a>";
			$p_cats .= $i < count( $p_category_terms ) - 1 ? esc_html__( ",&#x20;", 'unilearn' ) : "";
		}
		echo !empty($p_cats) ? "<div class='cws_portfolio_post_terms post_terms'>
									<i class='fa fa-bookmark'></i>&#x20;{$p_cats}
								</div>" : "";		
	}	
}
function unilearn_cws_portfolio_single_post_post_media (){
	$post_url = esc_url(get_the_permalink());
	$post_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$thumbnail_props = has_post_thumbnail() ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$real_thumbnail_dims = array();
	if ( !empty( $thumbnail_props ) && isset( $thumbnail_props[1] ) ) $real_thumbnail_dims['width'] = $thumbnail_props[1];
	if ( !empty(  $thumbnail_props ) && isset( $thumbnail_props[2] ) ) $real_thumbnail_dims['height'] = $thumbnail_props[2];
	$thumbnail_dims = unilearn_get_cws_portfolio_thumbnail_dims( false, $real_thumbnail_dims );
	$crop_thumb = isset( $thumbnail_dims['width'] ) && $thumbnail_dims['width'] > 0;
	$thumb_obj = bfi_thumb( $thumbnail, $thumbnail_dims, false );
	$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
	$retina_thumb_exists = false;
	$retina_thumb_url = "";	
	if ( isset( $thumb_obj[3] ) ){
		extract( $thumb_obj[3] );
	}			
	$retina_thumb_url = esc_attr($retina_thumb_url);
	$enable_hover = isset( $post_meta['enable_hover'] ) ? $post_meta['enable_hover'] : false;
	$custom_url = isset( $post_meta['link_options_url'] ) ? $post_meta['link_options_url'] : "";
	$fancybox = isset( $post_meta['link_options_fancybox'] ) ? $post_meta['link_options_fancybox'] : false;
	if ( $fancybox ){
		wp_enqueue_script( 'fancybox' );
	}
	$link_atts = "";
	$link_url = $custom_url ? $custom_url : $thumbnail;
	$link_icon = $fancybox ? ( $custom_url ? 'magic' : 'plus' ) : 'share';
	$link_class = $fancybox ? "fancy fa fa-{$link_icon}" : "fa fa-{$link_icon}";
	$link_atts .= !empty( $link_class ) ? " class='$link_class'" : "";
	$link_atts .= !empty( $link_url ) ? " href='$link_url'" : "";
	$link_atts .= !$fancybox ? " target='_blank'" : "";
	$link_atts .= $fancybox && $custom_url ? " data-fancybox-type='iframe'" : "";
	if ( !empty( $thumb_url ) ){
	?>
		<div class="post_media post_post_media post_posts_grid_post_media">
			<?php
				echo "<div class='pic" . ( !$enable_hover || ( !$crop_thumb && !$custom_url ) ? " wth_hover" : "" ) . "'>";
					if ( $retina_thumb_exists ) {
						echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
					}
					else{
						echo "<img src='$thumb_url' data-no-retina alt />";
					}
					if ( $enable_hover && ( $crop_thumb || $custom_url ) ){
						echo "<div class='hover-effect'></div>";
						echo "<div class='links'>
								<a{$link_atts}></a>
						</div>";
					}
				echo "</div>";
			?>
		</div>
	<?php
	$GLOBALS['unilearn_cws_portfolio_single_post_floated_media'] = !empty( $thumb_url ) && !$crop_thumb;
	}
}
function unilearn_cws_portfolio_single_post_content (){
	$content = apply_filters( 'the_content', get_the_content() );
	if ( !empty( $content ) ){
		echo "<div class='post_content post_post_content post_single_post_content'>";
			echo sprintf("%s", $content);
		echo "</div>";
	}
}
function unilearn_cws_portfolio_single_post_terms (){
		$pid = get_the_id ();
		$out = "";
		$p_category_terms = wp_get_post_terms( $pid, 'cws_portfolio_cat' );
		$p_cats = "";
		for ( $i=0; $i < count( $p_category_terms ); $i++ ){
			$p_category_term = $p_category_terms[$i];
			$p_cat_permalink = get_term_link( $p_category_term->term_id, 'cws_portfolio_cat' );
			$p_cat_name = $p_category_term->name;
			$p_cat_name = esc_html( $p_cat_name );
			$p_cats .= "<a href='$p_cat_permalink'>$p_cat_name</a>";
			$p_cats .= $i < count( $p_category_terms ) - 1 ? esc_html__( ",&#x20;", 'unilearn' ) : "";
		}
		if ( !empty( $p_cats ) ){
			echo "<div class='cws_portfolio_post_terms post_terms'>";
				echo "<i class='fa fa-bookmark'></i>&#x20;{$p_cats}";
			echo "</div>";
		}
}