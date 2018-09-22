<?php
function unilearn_searchPostsGrid_post (){
	$pid = get_the_id();
	echo "<article id='post_post_{$pid}' class='item post post_post post_grid_post clearfix'>";
		
		unilearn_searchPostsGrid_postMedia ();

		unilearn_searchPostsGrid_postTitle ();

		unilearn_searchPostsGrid_postContent ();
		
		unilearn_searchPostsGrid_postTerms ();

		echo "<hr class='posts_grid_divider' />";											
	echo "</article>";	
}
function unilearn_searchPostsGrid_postMedia (){
	$pid = get_the_id();
	$permalink = esc_url( get_the_permalink() );
	if ( has_post_thumbnail() ) {
		$thumbnail_props = has_post_thumbnail( ) ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
		$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
		$thumb_obj = bfi_thumb( $thumbnail, array( 'width' => 150, 'height' => 150 ), false );
		$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
		$retina_thumb_exists = false;
		$retina_thumb_url = "";	
		if ( isset( $thumb_obj[3] ) ){
			extract( $thumb_obj[3] );
		}			
		$retina_thumb_url = esc_attr($retina_thumb_url);
		echo "<div class='floated_media posts_grid_post_floated_media post_posts_grid_post_floated_media search_posts_grid_post_floated_media'>";
			echo "<div class='floated_media_wrapper posts_grid_post_floated_media_wrapper post_posts_grid_post_floated_media_wrapper search_posts_grid_post_floated_media_wrapper'>";
				echo "<div class='post_media search_post_media posts_grid_post_media'>";								
					echo "<a href='$permalink'>";
						if ( $retina_thumb_exists ) {
							echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
						}
						else{
							echo "<img src='$thumb_url' data-no-retina alt />";
						}
					echo "</a>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	}
}
function unilearn_searchPostsGrid_postTitle (){
	$search_terms = get_query_var( 'search_terms' );	
	if ( empty( $search_terms ) ){
		unilearn_searchPostsGrid_postTitle_emptyQuery ();	
	}
	else{
		unilearn_searchPostsGrid_postTitle_searchByTerms ();
	}
}
function unilearn_searchPostsGrid_postTitle_emptyQuery (){
	$pid = get_the_id();
	$title = esc_html( get_the_title() );
	$permalink = esc_url( get_the_permalink() );
	echo !empty( $title ) ?	"<h3 class='post_post_title post_title'><a href='$permalink'>" . $title . "</a></h3>" : "";	
}
function unilearn_searchPostsGrid_postTitle_searchByTerms (){
	$search_terms = get_query_var( 'search_terms' );
	$title = esc_html( get_the_title() );
	$permalink = esc_url( get_the_permalink() );
	$title = preg_replace( '/('.implode( '|', $search_terms ) .')/iu', '<mark>\0</mark>', $title );	
	echo !empty( $title ) ? "<h3 class='post_title post_post_title'><a href='$permalink'>$title</a></h3>" : "";							
}
function unilearn_postPostsGrid_getCharsCount() {
	$layout = "small";
	$number 	= 300;
	$p_id 		= get_queried_object_id();
	$sb 		= unilearn_get_sidebars( $p_id );
	$sb_layout 	= isset( $sb['sb_layout_class'] ) ? $sb['sb_layout_class'] : '';
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
	return $number;
}
function unilearn_searchPostsGrid_postContent (){
	$search_terms = get_query_var( 'search_terms' );	
	if ( empty( $search_terms ) ){
		unilearn_searchPostsGrid_postContent_emptyQuery ();	
	}
	else{
		unilearn_searchPostsGrid_postContent_searchByTerms ();
	}
}
function unilearn_searchPostsGrid_postContent_emptyQuery (){
	global $post;
	global $more;
	$id = get_the_ID();
	$permalink = get_the_permalink( $id );
	$more = 0;
	$def_grid_atts = array(
					'chars_count'			=> '',
				);
	$grid_atts = isset( $GLOBALS['unilearn_posts_grid_atts'] ) ? $GLOBALS['unilearn_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	$terms = unilearn_searchPostsGrid_get_postTerms ();
	$content = $proc_content = $excerpt = $proc_excerpt = "";
	$read_more_exists = false;
	$read_more = empty( $terms ) ? esc_html__( "Read More ", 'unilearn' ) . "<i class='fa fa-angle-right'></i>" : "<i class='fa fa-angle-double-right'></i>";
	$content = $post->post_content;
	$excerpt = $post->post_excerpt;
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
			$def_chars_count = unilearn_postPostsGrid_getCharsCount();
			$chars_count = empty( $chars_count ) ? $def_chars_count : $chars_count;
			$chars_count = (int)$chars_count;
			$proc_content = mb_substr( $proc_content, 0, $chars_count );
			$read_more_exists = strlen( $proc_content ) < strlen( $content );
		}
	}
	$proc_content .= $read_more_exists ? "<a href='$permalink' class='more-link'>$read_more</a>" : "";
	echo "<div class='post_content post_post_content post_posts_grid_post_content clearfix" . ( !empty( $terms ) ? " read_more_alt" : "" ) . "'>";	
		echo apply_filters( 'the_content', $proc_content );
	echo "</div>";	
}
function unilearn_searchPostsGrid_postContent_searchByTerms (){
	global $post;
	$search_terms = get_query_var( 'search_terms' );
	$permalink = esc_url( get_the_permalink() );
	$terms = unilearn_searchPostsGrid_get_postTerms ();
	$ext_content = get_extended( $post->post_content );
	$content = $ext_content['main'] . $ext_content['extended'];
	$content = preg_replace( '/\[.*?(\"title\":\"(.*?)\").*?\]/', '$2', $content );
	$content = preg_replace( '/\[.*?(|title=\"(.*?)\".*?)\]/', '$2', $content );
	$content = strip_tags( $content );
	$content = preg_replace( '|\s+|', ' ', $content );
	$title = get_the_title();
	$cont = '';
	$bFound = false;
	$contlen = strlen( $content );
	foreach ($search_terms as $term) {
		$pos = 0;
		$term_len = strlen($term);
		do {
			if ( $contlen <= $pos ) {
				break;
			}
			$pos = stripos( $content, $term, $pos );
			if ( strlen((string)$pos) ) {
				$start = ($pos > 50) ? $pos - 50 : 0;
				$temp = substr( $content, $start, $term_len + 100 );
				$cont .= ! empty( $temp ) ? $temp . ' ... ' : '';
				$pos += $term_len + 50;
			}
		} while ($pos);
	}
	if (strlen($cont) > 0) {
		$bFound = true;
	}
	else {
		$cont = mb_substr( $content, 0, $contlen < 100 ? $contlen : 100 );
		if ( $contlen > 100 ) {
			$cont .= '...';
		}
		$bFound = true;
	}
	$pattern = "#\[[^\]]+\]#";
	$replace = "";
	$cont = preg_replace($pattern, $replace, $cont);
	$cont = preg_replace('/('.implode('|', $search_terms) .')/iu', '<mark>\0</mark>', $cont);
	if ( !empty( $cont ) ){
		echo "<div class='post_content post_post_content post_posts_grid_post_content clearfix" . ( !empty( $terms ) ? " read_more_alt" : "" ) . "'>";
			$cont .= "<a href='$permalink' class='more-link'>";
			if ( empty( $terms ) ){
				$cont .= esc_html__( "Read More", 'unilearn' ) . " <i class='fa fa-angle-right'></i>";
			}
			else{
				$cont .= "<i class='fa fa-angle-double-right'></i>";
			}
			$cont .= "</a>";
			$cont = apply_filters( 'the_content', $cont );
			echo sprintf("%s", $cont);
		echo "</div>";
	}
}
function unilearn_searchPostsGrid_get_postTerms (){
	$pid = get_the_id();
	$post_type = get_post_type( $pid );
	$terms = $tags = $cats = $pcats = $deps = $poss = "";
	if ( $post_type == 'cws_portfolio' ){
		$pcats = unilearn_get_post_term_links_str( 'cws_portfolio_cat' );
		$terms .= !empty( $pcats ) ? "<i class='fa fa-bookmark'></i>&#x20;$pcats" : "";
	}
	else if ( $post_type == 'cws_staff' ){
		$deps = unilearn_get_post_term_links_str( 'cws_staff_member_department' );
		$poss = unilearn_get_post_term_links_str( 'cws_staff_member_position' );
		$terms = "";
		if ( !empty( $deps ) || !empty( $poss ) ){
			$terms .= !empty( $deps ) ? "<i class='fa fa-bank'></i>&#x20;$deps" : "";
			if ( !empty( $poss ) ){
				$terms .= !empty( $terms ) ? UNILEARN_V_SEP : "";
				$terms .= "<i class='fa fa-pencil'></i>&#x20;$poss";
			}
		}												
	}
	else if( $post_type == 'post' ){
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
	}
	return $terms;	
}
function unilearn_searchPostsGrid_postTerms (){
	$terms = unilearn_searchPostsGrid_get_postTerms ();
	if ( !empty( $terms ) ){
		echo "<div class='post_terms post_post_terms post_terms'>";
			echo sprintf("%s", $terms);
		echo "</div>";
	}		
}
?>