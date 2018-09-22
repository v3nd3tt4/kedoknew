<?php
	get_header();

	$sb = unilearn_get_sidebars();
	extract( $sb );
	$page_classes = "";
	$page_classes .= !empty( $sb_layout_class ) ? " {$sb_layout_class}_sidebar" : "";
	$page_classes = trim( $page_classes );

	$taxonomy = get_query_var( 'taxonomy' );
	$term_slug = get_query_var( $taxonomy );
	$post_type = "";
	if ( in_array( $taxonomy, array( 'cws_portfolio_cat' ) ) ){
		$post_type = 'cws_portfolio';
	}
	else if ( in_array( $taxonomy, array( 'cws_staff_member_department', 'cws_staff_member_position' ) ) ){
		$post_type = 'cws_staff';
	}
	$posts_grid_atts = array(
			'post_type'						=> $post_type,
			'total_items_count'				=> PHP_INT_MAX,
			'tax'							=> $taxonomy,
			'terms'							=> $term_slug
		);
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
				$posts_grid = unilearn_posts_grid( $posts_grid_atts );
				echo sprintf("%s", $posts_grid);
			echo "</main>";
		echo "</div>";
	echo "</div>";

	get_footer();
?>