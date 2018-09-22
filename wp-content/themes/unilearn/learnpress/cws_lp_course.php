<?php
function unilearn_sc_lp_course_posts_grid ( $atts = array(), $content = "" ){
	$out = "";
	$defaults = array(
		'title'									=> '',
		'title_align'							=> 'left',
		'lp_course_new_tab'						=> '',
		'total_items_count'						=> '',
		'layout'								=> '3',
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
	$lp_course_new_tab = (bool)$lp_course_new_tab;
	$post_type = defined( "LP_COURSE_CPT" ) ? LP_COURSE_CPT : "lp_course";
	$section_id = uniqid( 'posts_grid_' );
	$ajax_data = array();
	$total_items_count = !empty( $total_items_count ) ? (int)$total_items_count : PHP_INT_MAX;
	$items_pp = !empty( $items_pp ) ? (int)$items_pp : esc_html( get_option( 'posts_per_page' ) );
	$paged = (int)$paged;
	$el_class = esc_attr( $el_class );
	$sb = unilearn_get_sidebars();
	$sb_layout = isset( $sb['sb_layout_class'] ) ? $sb['sb_layout_class'] : '';	
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
	$query_args = array_merge( $query_args, $addl_query_args );
	$q = new WP_Query( $query_args );
	$found_posts = $q->found_posts;
	$requested_posts = $found_posts > $total_items_count ? $total_items_count : $found_posts;
	$max_paged = $found_posts > $total_items_count ? ceil( $total_items_count / $items_pp ) : ceil( $found_posts / $items_pp );
	$cols = (int)$layout;
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
					'lp_course_new_tab'				=> $lp_course_new_tab,
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
			$ajax_data['lp_course_new_tab']					= $lp_course_new_tab;
			$ajax_data['section_id']						= $section_id;
			$ajax_data['post_type']							= $post_type;
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
function unilearn_lp_course_posts_grid_posts ( $q = null ){
	if ( !isset( $q ) ) return;
	$def_total_items_count = $q->found_posts;
	$def_grid_atts = array(
					'layout'				=> '1',
					'total_items_count'		=> $def_total_items_count
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;
	extract( $grid_atts );
	$paged = $q->query_vars['paged'];
	$total_items_count = (int)$total_items_count;
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
			learn_press_get_template_part( 'content', 'course' );
		endwhile;
		wp_reset_postdata();
		ob_end_flush();
	endif;		
}
function unilearn_get_lp_course_thumbnail_dims ( $eq_thumb_height = false, $real_dims = array() ) {
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
?>