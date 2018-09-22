<?php
function unilearn_sc_blog ( $atts = array(), $content = "" ){
	$out = "";
	$defaults = array(
		'title'									=> '',
		'title_align'							=> 'left',
		'total_items_count'						=> '',
		'layout'								=> 'def',
		'post_hide_meta_override'				=> false,
		'post_hide_meta'						=> '',
		'chars_count'							=> '',
		'display_style'							=> 'grid',
		'items_pp'								=>  esc_html( get_option( 'posts_per_page' ) ),
		'tax'									=> '',
		'terms'									=> '',
		'addl_query_args'						=> array(),
		'el_class'								=> ''
	);
	$atts = shortcode_atts( $defaults, $atts );
	extract( $atts );
	$post_type = "post";
	$section_id = uniqid( 'posts_grid_' );
	$total_items_count = !empty( $total_items_count ) ? (int)$total_items_count : PHP_INT_MAX;
	$items_pp = !empty( $items_pp ) ? (int)$items_pp : esc_html( get_option( 'posts_per_page' ) );
	$paged = get_query_var( 'paged' );
	$paged = empty( $paged ) ? 1 : $paged;

	$def_post_layout = unilearn_get_option( 'def_blog_layout' );
	$def_post_layout = isset( $def_post_layout ) ? $def_post_layout : "";
	$layout = ( empty( $layout ) || $layout === "def" ) ? $def_post_layout : $layout; 
	$post_hide_meta_override = !empty( $post_hide_meta_override ) ? true : false;
	$post_hide_meta = explode( ",", $post_hide_meta );
	$post_def_hide_meta = unilearn_get_option( 'def_post_hide_meta' );
	$post_def_hide_meta  = isset( $post_def_hide_meta ) ? $post_def_hide_meta : array();
	$post_hide_meta = $post_hide_meta_override ? $post_hide_meta : $post_def_hide_meta;
	
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
	if ( in_array( $display_style, array( 'grid' ) ) ){
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
	$cols = in_array( $layout, array( 'medium', 'small' ) ) ? 1 : (int)$layout;
	$is_carousel = $display_style == 'carousel' && $requested_posts > $cols;
	if ( $is_carousel ){
		wp_enqueue_script( 'owl_carousel' );
	}
	else if ( is_numeric( $layout ) ){
		wp_enqueue_script( 'isotope' );
	}
	wp_enqueue_script( 'fancybox' );
	$use_pagination = in_array( $display_style, array( 'grid' ) ) && $max_paged > 1;
	$pagination_type = "pagination";
	ob_start ();
	echo "<section id='$section_id' class='posts_grid {$post_type}_posts_grid posts_grid_{$layout} posts_grid_{$display_style}" . ( !empty( $el_class ) ? " $el_class" : "" ) . "'>";
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
		else{
			echo !empty( $title ) ? "<h2 class='widgettitle text_align{$title_align}'>" . esc_html( $title ) . "</h2>" : "";
		}
		echo "<div class='unilearn_wrapper'>";
			echo "<div class='" . ( $is_carousel ? "unilearn_carousel" : "unilearn_grid" . ( is_numeric( $layout ) ? " isotope" : "" ) ) . "'" . ( $is_carousel ? " data-cols='" . ( !is_numeric( $layout ) ? "1" : $layout ) . "'" : "" ) . ">";
				$GLOBALS['unilearn_posts_grid_atts'] = array(
					'layout'						=> $layout,
					'sb_layout'						=> $sb_layout,
					'post_hide_meta'				=> $post_hide_meta,
					'chars_count'					=> $chars_count,
					'total_items_count'				=> $total_items_count
					);
				if ( function_exists( "unilearn_{$post_type}_posts_grid_posts" ) ){
					call_user_func_array( "unilearn_{$post_type}_posts_grid_posts", array( $q ) );
				}
				unset( $GLOBALS['unilearn_posts_grid_atts'] );
			echo "</div>";
		echo "</div>";
		if ( $use_pagination ){
			unilearn_pagination ( $paged, $max_paged, false );
		}
	echo "</section>";
	$out = ob_get_clean();
	return $out;
}

function unilearn_get_special_post_formats (){
	return array( "aside", "link", "quote" );
}
function unilearn_is_special_post_format (){
	global $post;
	$sp_post_formats = unilearn_get_special_post_formats ();
	if ( isset($post) ){
		return in_array( get_post_format(), $sp_post_formats );
	}
	else{
		return false;
	}
}
function unilearn_post_format_mark (){
	global $post;
	if ( isset( $post ) ){
		$pf = get_post_format ();
		$icon = "book";
		switch ( $pf ){
			case "aside":
				$icon = "bullseye";
				break;
			case "gallery":
				$icon = "bullseye";
				break;
			case "link":
				$icon = "chain";
				break;
			case "image":
				$icon = "image";
				break;
			case "quote":
				$icon = "quote-left";
				break;
			case "status":
				$icon = "flag";
				break;
			case "video":
				$icon = "video-camera";
				break;
			case "audio":
				$icon = "music";
				break;
			case "chat":
				$icon = "wechat";
				break;
		}
		$out = "<i class='fa $icon'></i> $pf";
		return $out;
	}
	else{
		return "";
	}
}

function unilearn_get_post_thumbnail_dims ( $eq_thumb_height = false, $real_dims = array() ) {
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
	if ( $single ){
		if ( empty( $sb_layout ) ){
			if ( ( empty( $real_dims ) || ( isset( $real_dims['width'] ) && $real_dims['width'] > 1170 ) ) || $eq_thumb_height ){
				$dims['width'] = 1170;
				if ( $eq_thumb_height ) $dims['height'] = 659;
			}
		}
		else if ( $sb_layout === "single" ){
			if ( ( empty( $real_dims ) || ( isset( $real_dims['width'] ) && $real_dims['width'] > 870 ) ) || $eq_thumb_height ){
				$dims['width'] = 870;
				if ( $eq_thumb_height ) $dims['height'] = 490;
			}
		}
		else if ( $sb_layout === "double" ){
			if ( ( empty( $real_dims ) || ( isset( $real_dims['width'] ) && $real_dims['width'] > 570 ) ) || $eq_thumb_height ){
				$dims['width'] = 570;
				if ( $eq_thumb_height ) $dims['height'] = 321;
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
			case "medium":
				$dims['width'] = 570;
				if ( !isset( $real_dims['height'] ) ){
					$dims['height'] = 321;
				}	
				break;
			case "small":
				$dims['width'] = 370;
				if ( !isset( $real_dims['height'] ) ){
					$dims['height'] = 208;
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

function unilearn_post_posts_grid_posts ( $q = null ){
	if ( !isset( $q ) ) return;
	$def_grid_atts = array(
					'layout'				=> '1',
					'post_hide_meta'		=> array(),
					'total_items_count'		=> PHP_INT_MAX
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
			unilearn_post_posts_grid_post ();
		endwhile;
		wp_reset_postdata();
		ob_end_flush();
	endif;				
}
function unilearn_post_posts_grid_post (){
	$def_grid_atts = array(
					'layout'				=> '1',
					'post_hide_meta'				=> array(),
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;
	extract( $grid_atts );
	$pid = get_the_id();
	$floated_media = in_array( $layout, array( 'medium', 'small' ) );
	echo "<article id='post_post_{$pid}' ";
	post_class( array( 'item', 'post_post', 'post_grid_post' ) );
	echo ">";
		if ( $floated_media ) { echo "<div class='clearfix'>";}
			if ( $floated_media ) { echo "<div class='floated_media posts_grid_post_floated_media post_posts_grid_post_floated_media'>";}
				if ( $floated_media ) { echo "<div class='floated_media_wrapper posts_grid_post_floated_media_wrapper post_posts_grid_post_floated_media_wrapper'>";}
					unilearn_post_post_header ();
					unilearn_post_posts_grid_post_media ();	
				if ( $floated_media ) { echo "</div>" ;}
			if ( $floated_media ) { echo "</div>";}
			unilearn_post_posts_grid_post_title ();
			unilearn_post_posts_grid_post_content ();
			if ( !in_array( 'terms', $post_hide_meta ) ){
				unilearn_post_post_terms ();
			}
		if ( $floated_media ) { echo "</div>";}
		unilearn_page_links ();
		echo "<hr class='posts_grid_divider' />";	
	echo "</article>";
}
function unilearn_post_posts_grid_post_title (){
	$pid = get_the_id();
	$title = get_the_title();
	$permalink = get_the_permalink();
	$is_special_post_format = unilearn_is_special_post_format();
	echo !$is_special_post_format && !empty( $title ) ?	"<h3 class='post_post_title post_title'><a href='$permalink'>" . $title . "</a></h3>" : "";	
}
function unilearn_post_post_header (){
	$pid = get_the_id();
	$permalink = get_the_permalink( $pid );
	$def_grid_atts = array(
					'layout'				=> '1',
					'post_hide_meta'		=> array(),
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;
	extract( $grid_atts );
	$header_content = "";
	/* Date */
	if ( !in_array( 'date', $post_hide_meta ) ){
		$date = get_the_time( get_option("date_format") );
		$first_word_boundary = strpos( $date, " " );
		if ( $first_word_boundary ){
			$first_word = substr( $date, 0, $first_word_boundary );
			$header_content .= "<div class='date'>
				<div class='date_container'>
					<span class='first_word'>$first_word</span>" . substr( $date, $first_word_boundary + 1 ) . "
				</div>
			</div>";
		}
	}
	/* Post Info */
	if ( !in_array( 'post_info', $post_hide_meta ) ){
		$author = get_the_author();
		$special_pf = unilearn_is_special_post_format();
		if ( !empty($author) || $special_pf ){
			$header_content .= "<div class='info'>";
				$header_content .= "<div class='info_container'>";
					$header_content .= !empty($author) ? "<i class='fa fa-user'></i> by $author" : "";
					$header_content .= $special_pf ? ( !empty($author) ? UNILEARN_V_SEP : "" ) . unilearn_post_format_mark() : "";
				$header_content .= "</div>";
			$header_content .= "</div>";
		}
	}
	/* Comments */
	if ( !in_array( 'comments', $post_hide_meta ) ){
		$comments_n = get_comments_number();
		if ( (int)$comments_n > 0 ){
			$permalink .= "#comments";
			$header_content .= "<a href='$permalink' class='comments_link'>
									<span class='comments_container'>
										<i class='fa fa-comment'></i> $comments_n
									</span>
								</a>
			";
		}
	}
	/* Layout */
	if ( !empty( $header_content ) ){
		echo "<div class='post_post_header'>";
			echo sprintf("%s", $header_content);
		echo "</div>";		
	}
}

function unilearn_post_posts_grid_post_media (){
	$pid = get_the_id();
	$def_grid_atts = array(
					'layout'				=> '1',
					'post_hide_meta'		=> array(),
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );	
	$post_url = esc_url(get_the_permalink());
	$post_format = get_post_format( );
	$eq_thumb_height = in_array( $post_format, array( 'gallery' ) );
	$media_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$media_meta = isset( $media_meta[0] ) ? $media_meta[0] : array();
	$thumbnail_props = has_post_thumbnail( ) ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$real_thumbnail_dims = array();
	if ( !empty( $thumbnail_props ) && isset( $thumbnail_props[1] ) ) $real_thumbnail_dims['width'] = $thumbnail_props[1];
	if ( !empty(  $thumbnail_props ) && isset( $thumbnail_props[2] ) ) $real_thumbnail_dims['height'] = $thumbnail_props[2];
	$thumbnail_dims = unilearn_get_post_thumbnail_dims( $eq_thumb_height, $real_thumbnail_dims );
	$thumb_media = false;
	$some_media = false;
	ob_start();
	?>
		<div class="post_media post_post_media post_posts_grid_post_media">
			<?php
				switch ($post_format) {
					case 'link':
						$link = isset( $media_meta[$post_format] ) ? esc_url( $media_meta[$post_format] ) : "";
						if ( !empty($thumbnail) ) {
							$thumb_obj = bfi_thumb( $thumbnail, $thumbnail_dims, false );
							$thumb_url = isset( $thumb_obj[0] ) ? esc_url( $thumb_obj[0] ) : "";
							$thumbnail = esc_url($thumbnail);
							$retina_thumb_exists = false;
								$retina_thumb_url = "";
								if ( isset( $thumb_obj[3] ) ){
									extract( $thumb_obj[3] );
								}
							?>
							<div class="pic <?php echo !empty( $link ) ? 'link_post' : ''; ?>">
								<?php
								echo !empty($link) ? "<a href='$link'>" : '';
								if ( $retina_thumb_exists ) {
									echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
								}	else {
									echo "<img src='$thumb_url' data-no-retina alt />";
								}
								?>
								<div class="hover-effect"></div>
								<?php
								if ( !empty( $link ) ) {
									echo "<div class='link'><span>$link</span></div>";
								} else {
									echo "<div class='links'><a class='fancy fa fa-plus' href='$thumbnail'></a>" . ( !$single ? "<a class='fa fa-share' href='$post_url'></a>" : "" ) . "</div>";
								}
								echo !empty($link) ? "</a>" : '';
								?>
							</div>
							<?php
							$thumb_media = true;
							$some_media = true;
						}
						else{
							if ( !empty( $link ) ) {
								echo "<div class='link'><a href='$link'>$link</a></div>";
								$some_media = true;
							}
						}
						$some_media = true;
						break;
					case 'video':
						$video = $media_meta[$post_format];
						if ( !empty( $video ) ) {
							echo "<div class='video'>" . apply_filters('the_content',"[embed width='" . $thumbnail_dims['width'] . "']" . $video . "[/embed]") . "</div>";
							$some_media = true;
						}
						break;
					case 'audio':
						$audio = esc_attr( $media_meta[$post_format] );
						$is_soundcloud = is_int( strpos( (string) $audio, 'https://soundcloud' ) );
						if ( !empty( $thumbnail ) && !$is_soundcloud ){
							$thumb_obj = bfi_thumb( $thumbnail, $thumbnail_dims, false );
							$thumb_url = isset( $thumb_obj[0] ) ? esc_url( $thumb_obj[0] ) : "";
							$thumbnail = esc_url($thumbnail);
							$retina_thumb_exists = false;
							$retina_thumb_url = "";
							if ( isset( $thumb_obj[3] ) ){
								extract( $thumb_obj[3] );
							}
							echo "<div class='pic wth_hover'>";
								if ( $retina_thumb_exists ) {
									echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
								}	else {
									echo "<img src='$thumb_url' data-no-retina alt />";
								}
							echo "</div>";
							$thumb_media = true;
							$some_media = true;								
						}
						if ( !empty( $audio ) ){
							echo "<div class='audio" . ( $is_soundcloud ? " soundcloud" : "" ) . "'>";
								echo apply_filters( 'the_content', $audio );
							echo "</div>";
							$some_media = true;
						}
						break;
					case 'quote':
						$quote = isset( $media_meta[$post_format]['quote'] ) ? $media_meta[$post_format]['quote'] : '';
						$author_name = isset( $media_meta[$post_format]['author_name'] ) ? $media_meta[$post_format]['author_name'] : '';
						$author_status = isset( $media_meta[$post_format]['author_status'] ) ? $media_meta[$post_format]['author_status'] : '';						
						if ( !empty( $quote ) ) {
							echo unilearn_testimonial_renderer( array(
								'thumbnail'			=> $thumbnail,
								'quote'				=> $quote,
								'author_name'		=> $author_name,
								'author_status'		=> $author_status
							));
							$some_media = true;
						}
						break;
					case 'gallery':
						$gallery = isset( $media_meta[$post_format] ) ? $media_meta[$post_format] : "";
						if ( !empty( $gallery ) ) {
							$match = preg_match_all("/\d+/",$gallery,$images);
							if ($match){
								$images = $images[0];
								$image_srcs = array();
								foreach ( $images as $image ) {
									$image_src = wp_get_attachment_image_src($image,'full');
									if ( $image_src ){
										$image_url = $image_src[0];
										array_push( $image_srcs, $image_url );
									}
								}
								$thumb_media = $some_media = count( $image_srcs ) > 0 ? true : false;
								$carousel = count($image_srcs) > 1 ? true : false;
								$gallery_id = uniqid( 'cws-gallery-' );
								echo  $carousel ? "<a class='gallery_post_carousel_nav carousel_nav prev'>
													<span></span>
													</a>
													<a class='gallery_post_carousel_nav carousel_nav next'>
													<span></span>
													</a>
													<div class='gallery_post_carousel'>" : '';
								foreach ( $image_srcs as $image_src ) {
									$img_obj = bfi_thumb( $image_src, $thumbnail_dims , false );
									$img_url = isset( $img_obj[0] ) ? esc_url( $img_obj[0] ) : "";
									$retina_thumb_exists = false;
									$retina_thumb_url = "";
									if ( isset( $img_obj[3] ) ){
										extract( $img_obj[3] );
									}
									?>
									<div class='pic'>
										<?php
										if ( $retina_thumb_exists ) {
											echo "<img src='$img_url' data-at2x='$retina_thumb_url' alt />";
										}
										else{
											echo "<img src='$img_url' data-no-retina alt />";
										}
										?>
										<div class="hover-effect"></div>
										<div class="links">
											<a href="<?php echo esc_url($image_src); ?>" <?php if ( $carousel) { echo " data-fancybox-group='$gallery_id'";} ?> class="fancy fa <?php if ( $carousel) { echo 'fa-picture-o fancy_gallery'; } else { echo 'fa-plus';} ?>"></a>
										</div>
									</div>
									<?php
								}
								echo  $carousel ? "</div>" : '';
							}
						}
						break;
				}
				if ( !$some_media && !empty( $thumbnail ) ) {
					$thumb_obj = bfi_thumb( $thumbnail, $thumbnail_dims, false );
					$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
					$retina_thumb_exists = false;
					$retina_thumb_url = "";	
					if ( isset( $thumb_obj[3] ) ){
						extract( $thumb_obj[3] );
					}			
					$retina_thumb_url = esc_attr($retina_thumb_url);
					echo "<div class='pic'>";
						if ( $retina_thumb_exists ) {
							echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
						}
						else{
							echo "<img src='$thumb_url' data-no-retina alt />";
						}
						echo "<div class='hover-effect'></div>";
						echo "<div class='links'><a class='fancy fa fa-plus' href='$thumbnail'></a><a class='fa fa-share' href='$post_url'></a></div>";
					echo "</div>";
					$thumb_media = true;
					$some_media = true;
				}
			?>
		</div>
	<?php
	$some_media ? ob_end_flush() : ob_end_clean();
	if ( $thumb_media ){
		wp_enqueue_script( 'fancybox' );
	}
}

function unilearn_post_single_post_media (){
	$pid = get_the_id();
	$def_grid_atts = array(
					'layout'				=> '1',
					'post_hide_meta'		=> array(),
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );	
	$post_url = esc_url(get_the_permalink());
	$post_format = get_post_format( );
	$eq_thumb_height = in_array( $post_format, array( 'gallery' ) );
	$media_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$media_meta = isset( $media_meta[0] ) ? $media_meta[0] : array();
	$thumbnail_props = has_post_thumbnail( ) ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$real_thumbnail_dims = array();
	if ( !empty( $thumbnail_props ) && isset( $thumbnail_props[1] ) ) $real_thumbnail_dims['width'] = $thumbnail_props[1];
	if ( !empty(  $thumbnail_props ) && isset( $thumbnail_props[2] ) ) $real_thumbnail_dims['height'] = $thumbnail_props[2];
	$thumbnail_dims = unilearn_get_post_thumbnail_dims( $eq_thumb_height, $real_thumbnail_dims );
	$crop_thumb = isset( $thumbnail_dims['width'] ) && $thumbnail_dims['width'] > 0;
	$thumb_media = false;
	$some_media = false;
	ob_start();
	?>
		<div class='post_media post_post_media post_single_post_media'>
		<?php
			switch ($post_format) {
				case 'link':
					$link = isset( $media_meta[$post_format] ) ? esc_url( $media_meta[$post_format] ) : "";
					if ( !empty($thumbnail) ) {
						$thumb_obj = bfi_thumb( $thumbnail, $thumbnail_dims, false );
						$thumb_url = isset( $thumb_obj[0] ) ? esc_url( $thumb_obj[0] ) : "";
						$thumbnail = esc_url($thumbnail);
						$retina_thumb_exists = false;
							$retina_thumb_url = "";
							if ( isset( $thumb_obj[3] ) ){
								extract( $thumb_obj[3] );
							}
						?>
						<div class="pic <?php echo !empty( $link ) ? 'link_post' : ''; ?>">
							<?php
							echo !empty($link) ? "<a href='$link'>" : '';
							if ( $retina_thumb_exists ) {
								echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
							}	else {
								echo "<img src='$thumb_url' data-no-retina alt />";
							}
							?>
							<div class="hover-effect"></div>
							<?php
							if ( !empty( $link ) ) {
								echo "<div class='link'><span>$link</span></div>";
							} else {
								echo "<div class='links'><a class='fancy fa fa-plus' href='$thumbnail'></a></div>";
							}
							echo !empty($link) ? "</a>" : '';
							?>
						</div>
						<?php
						$thumb_media = true;
						$some_media = true;
					}
					else{
						if ( !empty( $link ) ) {
							echo "<div class='link'><a href='$link'>$link</a></div>";
							$some_media = true;
						}
					}
					$some_media = true;
					break;
				case 'video':
					$video = $media_meta[$post_format];
					if ( !empty( $video ) ) {
						echo "<div class='video'>" . apply_filters('the_content',"[embed width='" . $thumbnail_dims['width'] . "']" . $video . "[/embed]") . "</div>";
						$some_media = true;
					}
					break;
				case 'audio':
					$audio = esc_attr( $media_meta[$post_format] );
					$is_soundcloud = is_int( strpos( (string) $audio, 'https://soundcloud' ) );
					if ( !empty( $thumbnail ) ){
						$thumb_obj = bfi_thumb( $thumbnail, $thumbnail_dims, false );
						$thumb_url = isset( $thumb_obj[0] ) ? esc_url( $thumb_obj[0] ) : "";
						$thumbnail = esc_url($thumbnail);
						$retina_thumb_exists = false;
						$retina_thumb_url = "";
						if ( isset( $thumb_obj[3] ) ){
							extract( $thumb_obj[3] );
						}
						echo "<div class='pic wth_hover'>";
							if ( $retina_thumb_exists ) {
								echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
							}	else {
								echo "<img src='$thumb_url' data-no-retina alt />";
							}
						echo "</div>";
						$thumb_media = true;
						$some_media = true;								
					}
					if ( !empty( $audio ) ){
						echo "<div class='audio" . ( $is_soundcloud ? " soundcloud" : "" ) . "'>";
							echo apply_filters( 'the_content', $audio );
						echo "</div>";
						$some_media = true;
					}
					break;
				case 'quote':
					$quote = isset( $media_meta[$post_format]['quote'] ) ? $media_meta[$post_format]['quote'] : '';
					$author_name = isset( $media_meta[$post_format]['author_name'] ) ? $media_meta[$post_format]['author_name'] : '';
					$author_status = isset( $media_meta[$post_format]['author_status'] ) ? $media_meta[$post_format]['author_status'] : '';						
					if ( !empty( $quote ) ) {
						echo unilearn_testimonial_renderer( array(
							'thumbnail'			=> $thumbnail,
							'quote'				=> $quote,
							'author_name'		=> $author_name,
							'author_status'		=> $author_status
						));
						$some_media = true;
					}
					break;
				case 'gallery':
					$gallery = isset( $media_meta[$post_format] ) ? $media_meta[$post_format] : "";
					if ( !empty( $gallery ) ) {
						$match = preg_match_all("/\d+/",$gallery,$images);
						if ($match){
							$images = $images[0];
							$image_srcs = array();
							foreach ( $images as $image ) {
								$image_src = wp_get_attachment_image_src($image,'full');
								$image_url = $image_src[0];
								array_push( $image_srcs, $image_url );

							}
							$thumb_media = $some_media = count( $image_srcs ) > 0 ? true : false;
							$carousel = count($image_srcs) > 1 ? true : false;
							$gallery_id = uniqid( 'cws-gallery-' );
							echo  $carousel ? "<a class='gallery_post_carousel_nav carousel_nav prev'>
												<span></span>
												</a>
												<a class='gallery_post_carousel_nav carousel_nav next'>
												<span></span>
												</a>
												<div class='gallery_post_carousel'>" : '';
							foreach ( $image_srcs as $image_src ) {
								$img_obj = bfi_thumb( $image_src, $thumbnail_dims , false );
								$img_url = isset( $img_obj[0] ) ? esc_url( $img_obj[0] ) : "";
								$retina_thumb_exists = false;
								$retina_thumb_url = "";
								if ( isset( $img_obj[3] ) ){
									extract( $img_obj[3] );
								}
								?>
								<div class='pic'>
									<?php
									if ( $retina_thumb_exists ) {
										echo "<img src='$img_url' data-at2x='$retina_thumb_url' alt />";
									}
									else{
										echo "<img src='$img_url' data-no-retina alt />";
									}
									?>
									<div class="hover-effect"></div>
									<div class="links">
										<a href="<?php echo esc_url($image_src); ?>" <?php if ( $carousel ) { echo " data-fancybox-group='$gallery_id'";} ?> class="fancy fa <?php if ( $carousel ) { echo 'fa-picture-o fancy_gallery'; } else { echo 'fa-plus'; }?>"></a>
									</div>
								</div>
								<?php
							}
							echo  $carousel ? "</div>" : '';
						}
					}
					break;
			}
			if ( !$some_media && !empty( $thumbnail ) ) {
				$thumb_obj = bfi_thumb( $thumbnail, $thumbnail_dims, false );
				$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
				$retina_thumb_exists = false;
				$retina_thumb_url = "";	
				if ( isset( $thumb_obj[3] ) ){
					extract( $thumb_obj[3] );
				}			
				$retina_thumb_url = esc_attr($retina_thumb_url);
				echo "<div class='pic" . ( !$crop_thumb ? " wth_hover" : "" ) . "'>";
					if ( $retina_thumb_exists ) {
						echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
					}
					else{
						echo "<img src='$thumb_url' data-no-retina alt />";
					}
					if ( $crop_thumb ){
						echo "<div class='hover-effect'></div>";
						echo "<div class='links'><a class='fancy fa fa-plus' href='$thumbnail'></a></div>";
					}
				echo "</div>";
				$thumb_media = true;
				$some_media = true;
			}
			?>
		</div>
	<?php
	$some_media ? ob_end_flush() : ob_end_clean();
	if ( $thumb_media ){
		wp_enqueue_script( 'fancybox' );
	}
	$GLOBALS['unilearn_single_post_floated_media'] = $thumb_media && !$crop_thumb;
}

function unilearn_post_posts_grid_post_content (){
	global $post;
	global $more;
	$id = get_the_ID();
	$permalink = get_the_permalink( $id );
	$more = 0;
	$is_rtl = is_rtl();
	$def_grid_atts = array(
					'post_hide_meta'		=> array(),
					'chars_count'			=> '',
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	$content = $proc_content = $excerpt = $proc_excerpt = "";
	$terms_hidden = in_array( 'terms', $post_hide_meta );	
	$show_read_more = !in_array( 'read_more', $post_hide_meta );
	$read_more = $terms_hidden ? esc_html__( "Read More <i class='fa fa-angle-right'></i>", 'unilearn' ) : "<i class='fa fa-angle-double-" . ( $is_rtl ? "left" : "right" ) . "'></i>";
	$content = $post->post_content;
	$excerpt = $post->post_excerpt;
	$read_more_exists = false;
	if ( !empty( $excerpt ) ){
		$proc_content = get_the_excerpt();
		$read_more_exists = !empty( $content );
	}
	else if ( strpos( (string) $content, '<!--more-->' ) ){
		$proc_content = get_the_content( "" );
		$read_more_exists = true;
	}
	else{
		if ( !empty( $content ) ){
			$proc_content = get_the_content( "" );
			$proc_content = trim( preg_replace( '/[\s]{2,}/u', ' ', strip_shortcodes( strip_tags( $proc_content ) ) ) );
			$def_chars_count = unilearn_post_posts_grid_get_chars_count();
			$chars_count = empty( $chars_count ) ? $def_chars_count : $chars_count;
			$chars_count = (int)$chars_count;
			$proc_content = mb_substr( $proc_content, 0, $chars_count );
			$read_more_exists = strlen( $proc_content ) < strlen( $content );
		}
	}
	$proc_content .= $read_more_exists && $show_read_more ? "<a href='$permalink' class='more-link'>$read_more</a>" : "";
	echo "<div class='post_content post_post_content post_posts_grid_post_content clearfix" . ( !$terms_hidden ? " read_more_alt" : "" ) . "'>";	
		echo apply_filters( 'the_content', $proc_content );
	echo "</div>";	
}
function unilearn_post_posts_grid_get_chars_count() {
	$def_blog_layout = unilearn_get_option( "def_blog_layout" );
	$def_grid_atts = array(
					'layout'	=> $def_blog_layout
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	$number 	= 155;
	$p_id 		= get_queried_object_id();
	$sb 		= unilearn_get_sidebars( $p_id );
	$sb_layout 	= isset( $sb['sb_layout_class'] ) ? $sb['sb_layout_class'] : '';
	switch ( $layout ) {
		case '1':
		case 'medium':
		case 'small':
			switch ( $sb_layout ) {
				case 'double':
					$number = 130;
					break;
				case 'single':
					$number = 200;
					break;
				default:
					$number = 300;
			}
			break;
		case '2':
			switch ( $sb_layout ) {
				case 'double':
					$number = 55;
					break;
				case 'single':
					$number = 90;
					break;
				default:
					$number = 130;
			}
			break;
		case '3':
			switch ( $sb_layout ) {
				case 'double':
					$number = 60;
					break;
				case 'single':
					$number = 60;
					break;
				default:
					$number = 70;
			}
			break;
	}
	return $number;
}

function unilearn_post_post_terms (){
	$terms = $tags = $cats = "";
	if ( has_category() ) {
		ob_start();
		echo "<i class='fa fa-bookmark'></i>&#x20;";
		the_category ( "&#x2c;&#x20;" );
		$cats .= ob_get_clean();
	}
	if ( has_tag() ) {
		ob_start();
		the_tags ( "<i class='fa fa-tag'></i>&#x20;", "&#x2c;&#x20;", "" );
		$tags .= ob_get_clean();
	}
	$terms .= !empty( $cats ) ? $cats : "";
	$terms .= !empty( $tags ) ? ( ( !empty( $tags ) ? UNILEARN_V_SEP : "" ) . $tags ) : "";
	if ( !empty( $terms ) ){
		echo "<div class='post_post_terms post_terms'>";
			echo sprintf("%s", $terms);
		echo "</div>";
	}
}

?>