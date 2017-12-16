<li <?php hybrid_attr( 'comment' ); ?>>

			<header class="thread__meta">
		<?php echo get_avatar( $comment, 96, '', '', array( 'class' => 'thread__avatar' ) ); ?>

				<span class="thread__author"><?php comment_author_link(); ?></span>

		<?php extant_comment_parent_link(
			array(
				'depth'  => 3,
				'text'   => __( 'In reply to %s', 'extant' )
			)
		); ?>

				<br />
				<a href="<?php comment_link(); ?>" <?php hybrid_attr( 'comment-permalink' ); ?>><time <?php hybrid_attr( 'comment-published' ); ?>><?php printf( __( '%s ago', 'extant' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time></a>
				<?php edit_comment_link( null, '<span class="sep">' . _x( '&middot;', 'comment meta separator', 'extant' ) . '</span>' ); ?>
				<?php hybrid_comment_reply_link( array( 'before' => '<span class="sep">' . _x( '&middot;', 'comment meta separator', 'extant' ) . '</span>' ) ); ?>
			</header>

			<div class="thread__content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>
