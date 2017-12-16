<?php if ( mb_reply_query() ) : // Checks if any posts were found. ?>

	<div class="mb-loop mb-loop-reply">

	<ul>

		<?php while ( mb_reply_query() ) : // Begins the loop through found posts. ?>

			<?php mb_the_reply(); // Loads the post data. ?>

			<li>
				<?php mb_reply_link(); ?>

				<div class="mb-list-meta mb-reply-meta">
					<?php mb_reply_author_link(); ?>
					<span class="sep">&middot;</span>
					<?php mb_reply_natural_time(); ?>
				</div>
			</li>

		<?php endwhile; // End found posts loop. ?>

	</ul>

	</div>

	<?php mb_loop_reply_pagination(); ?>

<?php endif; // End check for posts. ?>
