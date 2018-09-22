<?php
/**
 * Template for displaying thumbnail of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/thumbnail.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $post;
$course      = learn_press_get_course();
$video_embed = $course->get_video_embed();

if ( $video_embed ) {
	?>
    <div class="course-video"><?php echo sprintf("%s", $video_embed); ?></div>
	<?php
}

if ( ! has_post_thumbnail() || $video_embed ) {
	return;
}

$image_title   = get_the_title( get_post_thumbnail_id() ) ? esc_attr( get_the_title( get_post_thumbnail_id() ) ) : '';
$image         = get_the_post_thumbnail( $post->ID, apply_filters( 'single_course_image_size', 'single_course' ), array(
	'title' => $image_title,
	'alt'   => $image_title
) );
?>

<div class='post_media lp_course_post_media post_single_post_media'>
	<div class='pic'>
		<?php
			if ( ! empty( $image )) {
				echo $image;
			}
		?>
	</div>
</div>
