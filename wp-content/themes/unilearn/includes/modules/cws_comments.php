<?php

class Unilearn_Walker_Comment extends Walker_Comment {
	// init classwide variables
	var $tree_type = 'comment';
	var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

	/** CONSTRUCTOR
	 * You'll have to use this if you plan to get to the top of the comments list, as
	 * start_lvl() only goes as high as 1 deep nested comments */
	public function __construct() { ?>

		<div class="comment_list">

	<?php }

	/** START_LVL
	 * Starts the list before the CHILD elements are added. Unlike most of the walkers,
	 * the start_lvl function means the start of a nested comment. It applies to the first
	 * new level under the comments that are not replies. Also, it appear that, by default,
	 * WordPress just echos the walk instead of passing it to &$output properly. Go figure.  */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1; ?>
		<div class="comments_children">
	<?php }

	/** END_LVL
	 * Ends the children list of after the elements are added. */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1; ?>
		</div><!-- /.children -->

	<?php }

	/** START_EL */
	public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;
		$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); ?>

		<div <?php comment_class( $parent_class ); ?> id="comment_<?php comment_ID() ?>">
			<?php
				$avatar = $args['avatar_size'] != 0 ? get_avatar( $comment, $args['avatar_size'] ) : '';
			?>
			<div id="comment_body_<?php comment_ID() ?>" class="comment_body clearfix">
				<?php
					if ( !empty( $avatar ) ){
						echo "<div class='avatar_section'>";
							echo sprintf("%s", $avatar);
						echo "</div>";
					}
				?>
				<div class="comment_section">
					<div class="comment_meta comment_meta_data">
						<cite class="fn n author_name"><?php echo get_comment_author_link(); ?></cite>
						&#x20;&#x2F;&#x20;
						<span class="comment_date">
							<?php
								comment_date();
								echo esc_html__( '&#x20;at&#x20;', 'unilearn' );
								comment_time();
							?>
						</span>
						<?php edit_comment_link( esc_html__( 'Edit Comment', 'unilearn' ), "&#x20;&#x2F;&#x20;" ); ?>
					</div><!-- /.comment-meta -->
					<div id="comment_content_<?php comment_ID(); ?>" class="comment_content">
						<?php if( !$comment->comment_approved ) : ?>
						<em class="comment_awaiting_moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'unilearn'); ?></em>
						<?php else: comment_text(); ?>
						<?php endif; ?>
					</div><!-- /.comment-content -->
					<div class="reply clearfix">
						<?php $reply_args = array(
							'reply_text' => "<i class='fa fa-repeat'></i>&#x20;" . esc_html__( "Reply", 'unilearn' ),
							'depth' => $depth,
							'max_depth' => $args['max_depth']
						);
						comment_reply_link( array_merge( $args, $reply_args ) );  ?>
					</div><!-- /.reply -->
				</div>
			</div><!-- /.comment-body -->

	<?php }

	public function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>

		</div><!-- /#comment-' . get_comment_ID() . ' -->

	<?php }

	/** DESTRUCTOR
	 * I just using this since we needed to use the constructor to reach the top
	 * of the comments list, just seems to balance out :) */
	public function __destruct() { ?>

	</div><!-- /#comment-list -->

	<?php }
}

function unilearn_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<div class="comments_nav clearfix">
		<?php
			$prev_link = get_previous_comments_link( "<i class='fa fa-angle-double-left'></i>&#x20;<span>" . esc_html__( 'Older Comments', 'unilearn' ) . "</span>" );
			$next_link = get_next_comments_link( "<span>" . esc_html__( 'Newer Comments', 'unilearn' ) . "</span>&#x20;<i class='fa fa-angle-double-right'></i>" );
			if ( !empty( $prev_link ) ) :
				echo "<div class='prev_section'>" . $prev_link . "</div>";
			endif;
			if ( !empty( $next_link ) ) :
				echo "<div class='next_section'>" . $next_link . "</div>";
			endif;
		?>
	</div><!-- .comment-navigation -->
	<?php
	endif;
}

function unilearn_comment_post( $incoming_comment ) {
	$comment = strip_tags($incoming_comment['comment_content']);
	$comment = esc_html($comment);
	$incoming_comment['comment_content'] = $comment;
	return( $incoming_comment );
}
add_filter('preprocess_comment', 'unilearn_comment_post', '', 1);

?>