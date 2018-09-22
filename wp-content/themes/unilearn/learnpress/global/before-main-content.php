<?php
/**
 * Template for displaying before main content.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/global/before-main-content.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$user = learn_press_get_current_user();

$page_classes 		= "";
$sb_layout 			= unilearn_get_option( 'lms-sb-layout' );
$sb_enabled 		= in_array( $sb_layout, array( 'left', 'right', 'both' ) );
$sb1 				= unilearn_get_option( 'lms-sb1' );
$sb2 				= unilearn_get_option( 'lms-sb2' );
$sb1_exists 		= $sb_enabled && is_active_sidebar( $sb1 );
$sb2_exists 		= $sb_enabled && $sb_layout == 'both' && is_active_sidebar( $sb2 );
$sb_exists 			= $sb1_exists || $sb2_exists;
$sb_layout_class 	= "";
if ( $sb1_exists && $sb2_exists ){
	$sb_layout_class = "double_sidebar";
}
else if ( $sb1_exists || $sb2_exists ){
	$sb_layout_class = "single_sidebar";
}
$page_classes .= " $sb_layout_class";
echo "<div id='page'" . ( !empty( $page_classes ) ? " class='" . trim( $page_classes ) . "'" : "" ) . ">";
	echo "<div class='unilearn_layout_container'>";
		if ( $sb1_exists && in_array( $sb_layout, array( "left", "both" ) ) ){
			echo "<ul id='left_sidebar' class='sidebar'>";
				dynamic_sidebar( $sb1 );
			echo "</ul>";
		}
		if ( $sb1_exists && $sb_layout === "right" ){
			echo "<ul id='right_sidebar' class='sidebar'>";
				dynamic_sidebar( $sb1 );
			echo "</ul>";
		}
		else if ( $sb1_exists && $sb2_exists && $sb_layout === "both" ){
			echo "<ul id='right_sidebar' class='sidebar'>";
				dynamic_sidebar( $sb2 );
			echo "</ul>";	
		}?>
		<main id='page_content'>

			<?php if ( learn_press_is_course() ){ ?>

			<div id="lp-single-course" class="lp-single-course">

				<?php if ( ! learn_press_get_page_link( 'checkout' ) && ( $user->is_admin() || $user->is_instructor() ) ) { ?>

					<?php $message = __( 'LearnPress <strong>Checkout</strong> page is not set up. ', 'unilearn' );

					if ( $user->is_instructor() ) {
						$message .= __( 'Please contact administrator for setting up this page.', 'unilearn' );
					} else {
						$message .= sprintf( __( 'Please <a href=\"%s\" target=\"_blank\">setup</a> it so users can purchase courses.', 'unilearn' ), admin_url( 'admin.php?page=learn-press-settings&tab=checkout' ) );
					} ?>

					<?php learn_press_display_message( $message, 'error' ); ?>

				<?php } ?>

				<?php } else{ ?>

			    <div id="lp-archive-courses" class="lp-archive-courses">

					<?php } ?>
