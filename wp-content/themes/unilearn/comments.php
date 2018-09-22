<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
$p_id = get_queried_object_id ();
ob_start();

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( !comments_open( $p_id ) && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
		echo apply_filters( 'the_content', "[cws_sc_msg_box type='info']" . esc_html__( 'Comments are closed.', 'unilearn' ) . "[/cws_sc_msg_box]" );
	}
	else{
	ob_start();

		if ( have_comments() ) {
				$comments_number = number_format_i18n( get_comments_number() );
				echo "<h2 class='comments_title'> " . esc_html__( "Comments", 'unilearn' ) . " <span class='comments_number'>({$comments_number})</span>" . "</h2>";

				wp_list_comments( array(
					'walker' => new Unilearn_Walker_Comment(),
					'avatar_size' => 68,
				) );

				unilearn_comment_nav();

		} // have_comments()
		$list_comments = trim( ob_get_clean() );

		$comment_form_args = array(
			'label_submit' => esc_html__( 'Submit', 'unilearn' ),
			'title_reply_before' => "<h2 id='reply_title' class='comment_reply_title'>",
			'title_reply_after'	=> "</h2>"
		);
		ob_start();
		comment_form( $comment_form_args );
		$comment_form = trim( ob_get_clean() );

		if ( !empty( $list_comments ) && !empty( $comment_form ) ){
			echo sprintf("%s<hr />%s", $list_comments, $comment_form);
		}
		else{
			echo sprintf("%s", $list_comments);
			echo sprintf("%s", $comment_form);
		}

	}

$comments_section_content = ob_get_clean();
echo !empty( $comments_section_content ) ? "<section id='comments' class='comments-area'>$comments_section_content</section>" : "";
?>
