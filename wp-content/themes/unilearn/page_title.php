<?php
$p_id = get_queried_object_id ();
$post_type = get_post_type ( $p_id );

$title = unilearn_get_page_title();
ob_start();
unilearn_dimox_breadcrumbs();
$breadcrumbs = ob_get_clean();
$page_title_content = "";
if ( !empty( $title ) ){
	$page_title_spacings = unilearn_get_option( 'page_title_spacings' );
	$page_title_content_styles = "";
	if ( is_array( $page_title_spacings ) ){
		foreach ( $page_title_spacings as $key => $value ){
			$page_title_content_styles .= "padding-$key:$value;";
		}
	}
	$page_title_content .= "<h1 id='page_title'>";
		$page_title_content .= esc_html( $title );
	$page_title_content .= "</h1>";
}
if ( !empty( $breadcrumbs ) ){
	$page_title_content .= $breadcrumbs;
}
if ( !empty( $page_title_content ) ){
	echo "<section id='page_title_section'>";
		echo "<div class='unilearn_layout_container'>";
			echo "<div class='page_title_content'" . ( !empty( $page_title_content_styles ) ? " style='$page_title_content_styles'" : "" ) . ">";
				echo sprintf("%s", $page_title_content);
			echo "</div>";
		echo "</div>";
	echo "</section>";
}
?>