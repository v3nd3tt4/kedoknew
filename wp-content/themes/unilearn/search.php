<?php
	$paged = !empty($_POST['paged']) ? (int)$_POST['paged'] : (!empty($_GET['paged']) ? (int)$_GET['paged'] : ( get_query_var("paged") ? get_query_var("paged") : 1 ) );
	$posts_per_page = (int)get_option('posts_per_page');
	$search_terms = get_query_var( 'search_terms' );
	get_header();
	$p_id = get_queried_object_id();
	$section_id = uniqid( 'posts_grid_' );	

	$sb = unilearn_get_sidebars();
	extract( $sb );
	$page_classes = "";
	$page_classes .= !empty( $sb_layout_class ) ? " {$sb_layout_class}_sidebar" : "";
	$page_classes = trim( $page_classes );
	
	global $wp_query;
	$total_post_count = $wp_query->found_posts;
	$max_paged = ceil( $total_post_count / $posts_per_page );
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
				if( have_posts() ){
					echo "<section id='$section_id' class='posts_grid search_posts_grid'>";
						echo "<div class='unilearn_wrapper'>";
							echo "<div class='unilearn_grid isotope'>";
								wp_enqueue_script ('isotope');
								$use_pagination = $max_paged > 1;
									while( have_posts() ) : the_post();									
										unilearn_searchPostsGrid_post ();							
									endwhile;
									wp_reset_postdata();
							echo "</div>";
						echo "</div>";
						if ( $use_pagination ) {
							unilearn_pagination($paged,$max_paged);
						}
					echo "</section>";
				}
				else {
					echo do_shortcode( "[cws_sc_msg_box type='info' title='" . esc_html__( "No search Results", 'unilearn' ) . "']" . esc_html__( "There are no posts matching your query", 'unilearn' ) . "[/cws_sc_msg_box]" );
					echo "<div class='widget'>"; 
						echo get_search_form( $search_terms );
					echo "</div>";
				}
			echo "</main>";
		echo "</div>";
	echo "</div>";
	get_footer ();
?>