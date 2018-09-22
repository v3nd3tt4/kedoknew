<?php
	get_header();

	$sb = unilearn_get_sidebars();
	extract( $sb );
	$page_classes = "";
	$page_classes .= !empty( $sb_layout_class ) ? " {$sb_layout_class}_sidebar" : "";
	$page_classes = trim( $page_classes );

	$posts_grid_atts = array(
			'post_type'			=> 'post',
			'total_items_count'	=> PHP_INT_MAX
	);
	if ( is_category() ) {
		$term_id = get_query_var( 'cat' );
		$term = get_term_by( 'id', $term_id, 'category' );
		$term_slug = $term->slug;
		$posts_grid_atts['tax']		= 'category';
		$posts_grid_atts['terms']	= $term_slug;
	}
	else if ( is_tag() ) {
		$term_slug = get_query_var( 'tag' );
		$posts_grid_atts['tax']		= 'post_tag';
		$posts_grid_atts['terms']	= $term_slug;
	}
	if ( is_date() ){
		$year = unilearn_get_date_part( 'y' );
		$month = unilearn_get_date_part( 'm' );
		$day = unilearn_get_date_part( 'd' );
		if ( !empty( $year ) ){
			$posts_grid_atts['addl_query_args']['year'] = $year;
		}
		if ( !empty( $month ) ){
			$posts_grid_atts['addl_query_args']['monthnum'] = $month;
		}
		if ( !empty( $day ) ){
			$posts_grid_atts['addl_query_args']['day'] = $day;
		}
	}

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
				$posts_grid = unilearn_sc_blog( $posts_grid_atts );
				echo sprintf("%s", $posts_grid );
			echo "</main>";
		echo "</div>";
	echo "</div>";

	get_footer();
?>