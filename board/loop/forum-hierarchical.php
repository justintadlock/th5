<?php if ( mb_forum_query() ) : // If there are forums to show. ?>

	<div class="mb-loop mb-loop-forum-hier">

	<ul>

		<?php while ( mb_forum_query() ) : // Loop through the forums. ?>

			<?php mb_the_forum(); // Set up forum data. ?>

			<li>
				<?php mb_forum_link(); ?>

				<div class="mb-list-meta mb-forum-meta">

					<?php mb_forum_states(); ?>

					<?php if ( mb_forum_allows_subforums() ) : ?>
						<?php $count = mb_get_forum_subforum_count(); ?>
						<?php printf( _n( '%s Sub-forum', '%s Sub-forums', $count, 'th5' ), $count ); ?>
						<span class="sep">&middot;</span>
					<?php endif; ?>

					<?php if ( mb_forum_allows_topics() ) : ?>
						<?php $count = mb_get_forum_topic_count(); ?>
						<?php printf( _n( '%s Topic', '%s Topics', $count, 'th5' ), $count ); ?>
					<?php endif; ?>

				</div><!-- .mb-forum-meta -->

				<?php if ( mb_subforum_query() ) : // If the forum has subforums. ?>

					<ul>

					<?php while ( mb_subforum_query() ) : // Loop through the subforums. ?>

						<?php mb_the_subforum(); ?>

						<li>
							<?php mb_forum_link(); ?>
							<?php $count = mb_get_forum_topic_count(); ?>
							<span class="count">(<?php printf( _n( '%s Topic', '%s Topics', $count, 'th5' ), $count ); ?>)</span>
						</li>

					<?php endwhile; // End subforums loop. ?>

					</ul>

				<?php endif; ?>

			</li>

		<?php endwhile; // End forum loop. ?>

	</ul>

	</div>

	<?php mb_loop_forum_pagination(); ?>

<?php endif; // End check for forums. ?>