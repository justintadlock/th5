<?php
// If a post password is required or no comments are given and comments/pings are closed, return.
if ( post_password_required() || ( ! have_comments() && ! comments_open() && ! pings_open() ) )
	return;
?>

<div id="comments" class="comments-template">

	<?php if ( have_comments() ) : // Check if there are any comments. ?>

		<div class="thread thread--comments">

			<h2 id="comments-number" class="thread__title"><?php comments_number(); ?></h2>

			<?php locate_template( array( 'misc/comments-nav.php' ), true ); // Loads the misc/comments-nav.php template. ?>

			<ol class="thread__items">
				<?php wp_list_comments(
					array(
						'style'        => 'ol',
						'callback'     => 'hybrid_comments_callback',
						'end-callback' => 'hybrid_comments_end_callback'
					)
				); ?>
			</ol><!-- .thread__items -->

		</div><!-- .thread -->

	<?php endif; // End check for comments. ?>

	<?php locate_template( array( 'misc/comments-error.php' ), true ); // Loads the misc/comments-error.php template. ?>

	<?php comment_form(
		array(
			'class_form'   => 'comment-form',
			'class_submit' => 'comment-form-submit'
		)
	); // Loads the comment form. ?>

</section><!-- .comments-template -->
