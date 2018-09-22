<?php
/**
 * Template for displaying thumbnail of course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/thumbnail.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = LP_Global::course();

if( !has_post_thumbnail() ){
	return;
}

if ( isset( $GLOBALS['unilearn_posts_grid_atts'] ) ){
	$thumbnail_props = wp_get_attachment_image_src( get_post_thumbnail_id( ), 'full' );
	$real_thumbnail_dims = array();
	if ( !empty( $thumbnail_props ) && isset( $thumbnail_props[1] ) ) $real_thumbnail_dims['width'] = $thumbnail_props[1];
	if ( !empty(  $thumbnail_props ) && isset( $thumbnail_props[2] ) ) $real_thumbnail_dims['height'] = $thumbnail_props[2];
	$thumbnail_dims = unilearn_get_lp_course_thumbnail_dims( false, $real_thumbnail_dims );
}
else{
	$thumbnail_dims = get_option( "learn_press_course_thumbnail_image_size" );
}

$thumb_id 		= get_post_thumbnail_id ();
$thumb_obj 		= wp_get_attachment_image_src ( $thumb_id, 'full' );
$thumb_src 		= $thumb_obj[0];
$bfi_obj 		= bfi_thumb( $thumb_src, $thumbnail_dims, false );
$thumb_url 		= $bfi_obj[0];
$retina_thumb_exists 	= false;
$retina_thumb_url 		= "";
if ( isset( $bfi_obj[3] ) && !empty( $bfi_obj[3] ) ){
	extract( $bfi_obj[3] );
}
$post_url = esc_url( get_the_permalink() );

$grid_atts = isset($GLOBALS['unilearn_posts_grid_atts']) ? $GLOBALS['unilearn_posts_grid_atts'] : array();
extract($grid_atts);
if (isset($lp_course_new_tab)) {
	$cws_is_blank = $lp_course_new_tab ? "target = '_blank'" : "";
} else {
	$cws_is_blank = "";
}


?>

<div class='post_media lp_course_post_media posts_grid_post_media'>
	<div class='pic'>
		<?php
			if ( $retina_thumb_exists ) {
				echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
			}	else {
				echo "<img src='$thumb_url' data-no-retina alt />";
			}
		?>
		<div class='hover-effect'></div>
		<div class='links'>
			<a href="<?php echo sprintf("%s", $post_url); ?>" class='read_more' <?php echo sprintf("%s", $cws_is_blank); ?>>
				<?php esc_html_e( 'Learn More', 'unilearn' ); ?>
			</a>
		</div>
	</div>
</div>
