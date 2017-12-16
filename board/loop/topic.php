<?php if ( mb_topic_query() ) : // If there are any topics to show. ?>

	<div class="mb-loop mb-loop-topic">

	<?php if ( mb_is_single_forum() ) : ?>
		<h3 class="mb-loop-title">Topics</h3>
	<?php endif; ?>

	<ul>

		<?php while ( mb_topic_query() ) : // Loop through the topics. ?>

			<?php mb_the_topic(); // Sets up the topic data. ?>

			<?php
				$topic_class = 'topic-normal';
				$type = mb_get_topic_type();

				if ( mb_is_topic_archive() && ! is_paged() && in_array( $type, array( 'super' ) ) )
					$topic_class = 'topic-sticky';

				elseif ( mb_is_single_forum() && ! is_paged() && in_array( $type, array( 'super', 'sticky' ) ) )
					$topic_class = 'topic-sticky';
			?>

			<li class="<?php echo sanitize_html_class( $topic_class ); ?>">

				<?php mb_topic_link(); ?>

				<div class="mb-list-meta mb-topic-meta">
					<?php mb_topic_states(); ?>
					<?php mb_topic_author_profile_link(); ?>
					<span class="sep">&middot;</span>
					<?php $count = mb_get_topic_reply_count(); ?>
					<?php printf( _n( '%s Reply', '%s Replies', $count, 'th5' ), $count ); ?>
					<span class="sep">&middot;</span>
					<a href="<?php mb_topic_last_post_url(); ?>"><?php mb_topic_last_active_time(); ?></a>
				</div><!-- .mb-topic-meta -->

			</li>

		<?php endwhile; // End topics loop. ?>

	</ul>

	</div>

	<?php mb_loop_topic_pagination(); ?>

<?php endif; // End check for topics. ?>