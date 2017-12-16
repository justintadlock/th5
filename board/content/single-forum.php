<header class="archive-header">
	<h1 class="archive-header__title"><?php mb_single_forum_title(); ?></h1>

	<div class="archive-header__meta">

		<?php if ( mb_forum_allows_subforums() ) : ?>
			<?php $count = mb_get_forum_subforum_count(); ?>
			<?php printf( _n( '%s Sub-forum', '%s Sub-forums', $count, 'th5' ), $count ); ?>
			<span class="sep">&middot;</span>
		<?php endif; ?>

		<?php if ( mb_forum_allows_topics() ) : ?>
			<?php $count = mb_get_forum_topic_count(); ?>
			<?php printf( _n( '%s Topic', '%s Topics', $count, 'th5' ), $count ); ?>

			<span class="sep">&middot;</span>
			<a href="#mb-topic-form">Create Topic &rarr;</a>
		<?php endif; ?>

		<?php $sep = '<span class="sep">&middot;</span>'; ?>

		<?php echo ( $e = mb_get_topic_edit_link() ) ? "$sep $e" : ''; ?>
	</div>

</header>

<?php if ( current_user_can( 'read_forum', mb_get_forum_id() ) ) : // Check if the current user can read the forum. ?>

	<?php mb_get_template_part( 'loop', mb_show_hierarchical_forums() ? 'forum-hierarchical' : 'forum-flat' ); ?>

	<?php if ( mb_forum_type_allows_topics( mb_get_forum_type() ) ) : // Only show topics if they're allowed. ?>

		<?php mb_get_template_part( 'loop', 'topic' ); ?>

	<?php endif; // End show topics check. ?>

<?php endif; // End check to see if user can read forum. ?>

<?php mb_get_template_part( 'form', 'topic-new' ); ?>