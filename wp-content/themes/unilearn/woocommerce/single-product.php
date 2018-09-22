<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version	 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
get_header( 'shop' );

$page_class = "";
$woo_sb_layout = unilearn_get_option( "woo_sb_layout" );
$woo_sb_exists = in_array( $woo_sb_layout, array( "left", "right" ) );
ob_start();
do_action( 'woocommerce_sidebar' );
$woo_sb = ob_get_clean();
$page_class .= $woo_sb_exists ? "single_sidebar" : "";

	echo "<div id='page'" . ( !empty( $page_class ) ? " class='$page_class'" : "" ) . ">";
		echo "<div class='unilearn_layout_container'>";
			if ( $woo_sb_exists ) { echo "<div id='{$woo_sb_layout}_sidebar' class='sidebar'>$woo_sb</div>";}
			echo "<main id='page_content'>";
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action( 'woocommerce_before_main_content' );
			?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php
				/**
				 * woocommerce_after_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action( 'woocommerce_after_main_content' );

			echo "</main>";
		echo "</div>";
	echo "</div>";

get_footer( 'shop' );
?>
