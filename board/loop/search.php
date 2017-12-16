<?php if ( mb_search_query() ) : // If there are any posts found in the search results. ?>

	<div class="mb-loop mb-loop-search">

		<ul>
			<?php while ( mb_search_query() ) : // Begins the loop through found posts. ?>

				<?php mb_the_search_result(); // Loads the post data. ?>

				<li>

				<?php if ( mb_is_forum() ) : ?>

					<?php mb_forum_link(); ?>

					<div class="mb-list-meta mb-forum-meta">
						<?php the_excerpt(); ?>
					</div>

				<?php elseif ( mb_is_topic() ) : ?>

					<?php mb_topic_link(); ?>

					<div class="mb-list-meta mb-topic-meta">
						<?php the_excerpt(); ?>
					</div>
				<?php elseif ( mb_is_reply() ) : ?>

					<?php mb_reply_link(); ?>

					<div class="mb-list-meta mb-reply-meta">
						<?php the_excerpt(); ?>
					</div>

				<?php endif; // End content type check. ?>

				</li>

			<?php endwhile; // End found posts loop. ?>

		</ul>

	</div>

	<?php mb_loop_search_pagination(); ?>

<?php endif; // End check for search results. ?>