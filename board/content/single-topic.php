<header class="archive-header">

	<h1 class="archive-header__title"><?php mb_single_topic_title(); ?></h1>

	<div class="archive-header__meta">
		<?php $count = mb_get_topic_reply_count(); ?>
		<?php printf( _n( '%s Reply', '%s Replies', $count, 'th5' ), $count ); ?>
		<span class="sep">&middot;</span>
		<?php mb_topic_subscribe_link(); ?>
	</div>

</header>

<?php if ( current_user_can( 'read_topic', mb_get_topic_id() ) ) : ?>

	<div class="thread thread--forum-topic">

	<ol id="mb-thread" class="thread__items">

		<?php if ( mb_show_lead_topic() && mb_topic_query() ) : ?>

			<?php while ( mb_topic_query() ) : ?>

				<?php mb_the_topic(); ?>

				<?php mb_get_template_part( 'thread', 'topic' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

		<?php if ( mb_reply_query() ) : ?>

			<?php while ( mb_reply_query() ) : ?>

				<?php mb_the_reply(); ?>

				<?php mb_get_template_part( 'thread', 'reply' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</ol>

	</div><!-- .thread -->

	<?php mb_single_topic_pagination(); ?>

<?php endif; ?>

<?php mb_get_template_part( 'form', 'reply-new' ); // Loads the topic reply form. ?>
