<?php
/**
 * Template for displaying course content within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$user = LP_Global::user();
?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php

    ob_start();
    do_action( 'unilearn_lp_courses_loop_item_styles' );
    $styles = ob_get_clean();
    if ( !empty( $styles ) ){
        echo "<style type='text/css' scoped>$styles</style>";
    }?>
    <div class='post_wrapper lp_course_post_wrapper posts_grid_post_wrapper'>            
    <?php

    // @since 3.0.0
    do_action( 'learn-press/before-courses-loop-item' );
    ?>

    <a href="<?php the_permalink(); ?>" class="course-permalink">

		<?php
        // @since 3.0.0
        do_action( 'learn-press/courses-loop-item-title' );
        ?>

    </a>

	<?php

    // @since 3.0.0
	do_action( 'learn-press/after-courses-loop-item' );
    ?>
    </div>
</li>