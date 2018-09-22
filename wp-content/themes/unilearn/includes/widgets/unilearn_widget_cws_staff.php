<?php
	/**
	 * Unilearn CWS Staff Widget Class
	 */
class Unilearn_CWS_Staff_Widget extends WP_Widget {

	public function init_fields() {
		$this->fields = array(
			'title' => array(
				'title' => esc_html__( 'Widget Title', 'unilearn' ),
				'atts'	=> 'id="widget-title"',
				'type' => 'text',
			),
			'icon'	=> array(
				'title'			=> esc_html__( 'Widget Icon', 'unilearn' ),
				'type'			=> 'select',
				'addrowclasses' => 'fai',
				'source' 		=> 'fa'
			),
			'add_custom_color'	=> array(
				'title'			=> esc_html__( 'Add Custom Color', 'unilearn' ),
				'type'			=> 'checkbox',
				'addrowclasses' => 'checkbox',
				'atts'			=> 'data-options="e:color;"'
			),
			'color'	=> array(
				'title'					=> esc_html__( 'Custom Color', 'unilearn' ),
				'type'					=> 'text',
				'atts'					=> 'data-default-color="' . UNILEARN_THEME_COLOR . '"'
			),
			'filter_by' => array(
				'title' => esc_html__( 'Filter By', 'unilearn' ),
				'type' => 'select',
				'source'	=> array(
					'none'						=> array( esc_html__( 'None', 'unilearn' ), true, 'd:departments;d:positions' ),
					'department'			=> array( esc_html__( 'Departments', 'unilearn' ), false, 'e:departments;d:positions' ),
					'position'				=> array( esc_html__( 'Positions', 'unilearn' ), false, 'd:departments;e:positions' ),
					'department_position'	=> array( esc_html__( 'Departments & Positions', 'unilearn' ), false, 'e:departments;e:positions' )
				)
			),
			'departments' => array(
				'title' => esc_html__( 'Departments', 'unilearn' ),
				'type' => 'taxonomy',
				'addrowclasses' => 'disable',
				'taxonomy' => 'cws_staff_member_department',
				'atts' => 'multiple',
				'source' => array(),
			),
			'positions' => array(
				'title' => esc_html__( 'Positions', 'unilearn' ),
				'type' => 'taxonomy',
				'addrowclasses' => 'disable',
				'taxonomy' => 'cws_staff_member_position',
				'atts' => 'multiple',
				'source' => array(),
			),
			'count' => array(
				'type' => 'number',
				'title' => esc_html__( 'Post count', 'unilearn' ),
				'value' => '4',
			),
			'visible_count' => array(
				'type' => 'number',
				'title' => esc_html__( 'Posts per slide', 'unilearn' ),
				'value' => '2',
			),
			'hide' => array(
				'title' => esc_html__( 'Hide', 'unilearn' ),
				'type' => 'select',
				'atts' => 'multiple',
				'source' => array(
					'departments'	=> array( esc_html__( 'Departments', 'unilearn' ), false ),
					'positions'	=> array( esc_html__( 'Positions', 'unilearn' ), false ),
					'desc'	=> array( esc_html__( 'Description', 'unilearn' ), false )
				),
			),
			'chars_count' => array(
				'type' => 'number',
				'title' => esc_html__( 'Count of chars from post content', 'unilearn' ),
				'value' => '70',
			)
		);
	}

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget-unilearn-cws-staff', 'description' => esc_html__( 'Unilearn Our Teachers Widget', 'unilearn' ) );
		parent::__construct( 'unilearn-cws-staff', esc_html__( 'Unilearn Our Teachers', 'unilearn' ), $widget_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		extract( shortcode_atts( array(
			'title'				=> '',
			'icon'				=> '',
			'add_custom_color'	=> false,
			'color'				=> UNILEARN_THEME_COLOR,
			'filter_by'			=> '',
			'departments'		=> array(),
			'positions'			=> array(),
			'count'				=> '4',
			'visible_count'		=> '2',
			'hide'				=> array(),
			'chars_count'		=> '70'
		), $instance));

		$title = esc_html( $title );
		$icon = esc_attr( $icon );
		$add_custom_color = (bool)$add_custom_color;
		$color = esc_attr( $color );
		$count = (int)$count;
		$visible_count = (int)$visible_count;
		$chars_count = (int)$chars_count;

		$title = apply_filters( 'widget_title', $title );

		$query_args = array(
			'post_type'			=> array( 'cws_staff' ),
			'post_status'		=> 'publish',
			'posts_per_page'	=> $count
		);

		$tax_query = array();
		$dep_query_args = array();
		$pos_query_args = array();
		if ( in_array( $filter_by, array( 'department', 'department_position' ) ) ){
			$dep_tax = 'cws_staff_member_department';
			$dep_terms = $departments;
			if ( !empty( $dep_terms ) ){
				array_push( $dep_query_args, array(
					'taxonomy'	=> $dep_tax,
					'field'			=> 'slug',
					'terms'			=> $dep_terms
				));
			}
		}
		if ( in_array( $filter_by, array( 'position', 'department_position' ) ) ){
			$pos_tax = 'cws_staff_member_position';
			$pos_terms = $positions;
			if ( !empty( $pos_terms ) ){
				array_push( $pos_query_args, array(
					'taxonomy'	=> $pos_tax,
					'field'			=> 'slug',
					'terms'			=> $pos_terms
				));
			}
		}
		if ( !empty( $dep_query_args ) && !empty( $pos_query_args ) ){
			$tax_query['relation'] = 'OR';
		}
		$tax_query = array_merge( $tax_query, $dep_query_args, $pos_query_args );
		if ( !empty( $tax_query ) ){
			$query_args['tax_query'] = $tax_query;
		}

		$q = new WP_Query( $query_args );
		$post_count = $q->post_count;
		$carousel_mode = $post_count > $visible_count;

		$custom_color = $add_custom_color && !empty( $color );
		$widget_styles = "";
		if ( $custom_color ){
			$widget_styles .= "#$widget_id a:not(.unilearn_button):not(.unilearn_icon),
								#$widget_id a:not(.unilearn_button):not(.unilearn_icon):hover,
								#$widget_id .widget_post_title > a:hover,
								#$widget_id input[type='submit'],
								#$widget_id .widget_icon{
				color: $color;
			}
			#$widget_id .widget_post_title > a{
				color: inherit;
			}
			#$widget_id input[type='submit'],
			#$widget_id .owl-pagination .owl-page{
				border-color: $color;
			}
			#$widget_id input[type='submit']:hover,
			#$widget_id .owl-pagination .owl-page.active{
				background-color: $color;
			}
			#footer_widgets #$widget_id .widget_header,
			#footer_widgets #$widget_id .widgettitle{
				background-color: $color;				
			}";
		}
		$before_widget = $custom_color ? preg_replace( "#class=\"(.+)\"#", "class=\"$1 custom_color\"", $before_widget ) : $before_widget;

		echo sprintf("%s", $before_widget);
		if ( !empty( $widget_styles ) ){
			echo "<style type='text/css' scoped>$widget_styles</style>";
		}		

		if ( !empty( $title ) ){
			if ( !empty( $icon ) ){
				echo sprintf("%s", $before_title . "<i class='widget_icon fa $icon'></i>" . $title . $after_title);
			}
			else{
				echo sprintf("%s", $before_title . $title . $after_title);
			}
		}

		$post_list_classes = "post_list widget_post_list cws_staff_post_list";
		$post_list_classes .= $carousel_mode ? " widget_carousel bullets_nav" : "";
		echo "<div class='$post_list_classes'>";
		$counter = 0;
		while ( $q->have_posts() ):
			$q->the_post();
			$pid = get_the_id();
			$post_meta = get_post_meta( $pid, 'cws_mb_post' );
			$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
			$clickable = isset( $post_meta['is_clickable'] ) ? $post_meta['is_clickable']: false;
			$cur_post = get_post( $pid );
			$permalink = esc_url(get_permalink());
			if ( $carousel_mode && $counter <= 0 ){ /* open carousel item tag */
				echo "<div class='item'>";
			}
			echo "<article class='post widget_post cws_staff_post clearfix'>";
				$has_img = has_post_thumbnail( $pid );
				if ( $has_img ){
					$thumb_props = wp_get_attachment_image_src( get_post_thumbnail_id( $pid ), 'full' );
					$thumb = $thumb_props[0];
					$retina_thumb_exists = false;
					$retina_thumb_url = "";
					$thumb_obj = bfi_thumb( $thumb, array( 'width' => 60, 'height' => 60 ), false );
					$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";	
					if ( isset( $thumb_obj[3] ) ){
						extract( $thumb_obj[3] );
					}
					$thumb_url = esc_url( $thumb_url );			
					$retina_thumb_url = esc_url( $retina_thumb_url );							
					echo "<div class='post_media widget_post_media cws_staff_post_media'>";
						if ( $clickable ) { echo "<a href='$permalink'>"; }
							if ( $retina_thumb_exists ) {
								echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
							}
							else{
								echo "<img src='$thumb_url' data-no-retina alt />";
							}
						if ( $clickable ) { echo "</a>"; }
					echo "</div>";
				}
				$post_data = "";
				ob_start();
				$post_title = esc_html( get_the_title() );
				if ( !empty( $post_title ) ){
					echo "<h4 class='post_title widget_post_title cws_staff_post_title'>";
						if ( $clickable ) { echo "<a href='$permalink'>"; }
							echo sprintf("%s", $post_title);
						if ( $clickable ) { echo "</a>"; }
					echo "</h4>";
				}
				$terms = $deps = $poss = "";
				if ( !in_array( 'departments', $hide ) ){
					$deps = unilearn_get_post_term_links_str( 'cws_staff_member_department' );
				}
				if ( !in_array( 'positions', $hide ) ){
					$poss = unilearn_get_post_term_links_str( 'cws_staff_member_position' );
				}
				$terms .= $deps;
				$terms .= !empty( $deps ) && !empty( $terms ) ? "<br />" : "";
				$terms .= $poss;
				echo !empty( $terms ) ? "<div class='post_terms widget_post_terms cws_staff_post_terms'>$terms</div>" : "";
				if ( !in_array( 'desc', $hide ) ){
					$desc = !empty( $cur_post->post_excerpt ) ? wptexturize( $cur_post->post_excerpt ) : "";
					$desc = substr( $desc, 0, $chars_count );
					$desc = esc_html( $desc );
					echo !empty( $desc ) ? "<div class='post_desc widget_post_desc cws_staff_post_desc'>$desc</div>" : ""; 
				}
				$post_data = ob_get_clean();
				echo !empty( $post_data ) ? "<div class='post_data widget_post_data cws_staff_post_data'>$post_data</div>" : "";		
			echo "</article>";
			if ( $carousel_mode ){
				if ( $counter >= $visible_count-1 || $q->current_post >= $post_count-1 ){
					echo "</div>";
					$counter = 0;
				}
				else{
					$counter ++;
				}
			}
			endwhile;
			wp_reset_postdata();
			echo "</div>";
		echo sprintf("%s", $after_widget);
	}

	public function update( $new_instance, $old_instance ) {
		$instance = (array)$new_instance;
		foreach ($new_instance as $key => $v) {
			switch ($this->fields[$key]['type']) {
				case 'text':
					$instance[$key] = strip_tags($v);
					break;
			}
		}
		return $instance;
	}

	public function form( $instance ) {
		$this->init_fields();
		$args[0] = $instance;
		unilearn_mb_fillMbAttributes( $args, $this->fields );
		echo unilearn_mb_print_layout( $this->fields, 'widget-' . $this->id_base . '[' . $this->number . '][');
	}

}
?>