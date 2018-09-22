<?php
	get_header();

	$sb = unilearn_get_sidebars();
	extract( $sb );
	$page_classes = "";
	$page_classes .= !empty( $sb_layout_class ) ? " {$sb_layout_class}_sidebar" : "";
	$page_classes = trim( $page_classes );

	$blog_layout = unilearn_get_option( "def_blog_layout" );
	$posts_grid_atts = array(
			'post_type'			=> 'post',
			'total_items_count'	=> PHP_INT_MAX,
			'layout'			=> $blog_layout,
		);
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
				echo sprintf("%s", $posts_grid);
			echo "</main>";
		echo "</div>";
	echo "</div>";

	get_footer();
?>