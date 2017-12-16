<div class="archive-header">
	<h1 class="archive-header__title">
		<?php if ( mb_is_user_page() ) printf( '%s: ', mb_get_single_user_title() ); ?>
		<?php mb_user_page_title(); ?>
	</h1>

	<div class="archive-header__meta">
		<a href="<?php mb_user_url(); ?>">Profile</a>
		<span class="sep">&middot;</span>
		<?php mb_user_topics_link(); ?></li>
		<span class="sep">&middot;</span>
		<?php mb_user_replies_link(); ?></li>

		<?php if ( current_user_can( 'edit_user', mb_get_user_id() ) ) : ?>

			<span class="sep">&middot;</span>
			<a href="<?php mb_user_topic_subscriptions_url(); ?>">Subscriptions</a>

			<?php /*
			<span class="sep">&middot;</span>
			<?php mb_user_edit_link(); ?>
			*/ ?>
		<?php endif; ?>
	</div>

</div>

<?php if ( mb_is_user_page( array( 'forums', 'forum-subscriptions' ) ) ) : ?>

	<?php mb_get_template_part( 'loop', mb_show_hierarchical_forums() ? 'forum-hierarchical' : 'forum-flat' ); ?>

<?php elseif ( mb_is_user_page( array( 'topics', 'topic-subscriptions', 'bookmarks' ) ) ) : ?>

	<?php mb_get_template_part( 'loop', 'topic' ); ?>

<?php elseif ( mb_is_user_page( 'replies' ) ) : ?>

	<?php mb_get_template_part( 'loop', 'reply' ); ?>

<?php else : ?>

	<div class="entry-content">

	<?php //echo get_avatar( mb_get_user_id() ); ?>

	<div class="mb-user-info">

		<ul>
			<li><?php printf( __( 'Forums created: %s', 'message-board' ), mb_get_user_forum_count() ); ?></li>
			<li><?php printf( __( 'Topics started: %s', 'message-board' ), mb_get_user_topic_count() ); ?></li>
			<li><?php printf( __( 'Replies posted: %s', 'message-board' ), mb_get_user_reply_count() ); ?></li>
			<li><?php printf( __( 'Member since: %s', 'message-board' ), date( get_option( 'date_format' ), strtotime( get_the_author_meta( 'user_registered', get_query_var( 'author' ) ) ) ) ); ?></li>
			<li><?php printf( __( 'Web site: %s', 'message-board' ), make_clickable( get_the_author_meta( 'url', get_query_var( 'author' ) ) ) ); ?></li>
		</ul>

		<?php echo wpautop( get_the_author_meta( 'description', get_query_var( 'author' ) ) ); ?>

	</div><!-- .mb-user-info -->

	</div>

<?php endif; ?>