<?php if ( mb_user_query() ) : // Checks if we have users. ?>

	<div class="mb-loop mb-loop-user">

	<ul>

		<?php while ( mb_user_query() ) : // Begins the loop through found users. ?>

			<?php mb_the_user(); // Set up user data. ?>

			<li>

				<?php echo get_avatar( mb_get_user_id() ); ?>

				<?php mb_user_link(); ?>

				<div class="mb-list-meta mb-user-meta">

					<?php if ( $role = mb_get_user_role() ) : ?>
						<?php mb_role_link( $role ); ?>

						<span class="sep">&middot;</span>
					<?php endif; ?>

					<?php $count = mb_get_user_topic_count(); ?>
					<?php printf( _n( '%s Topic', '%s Topics', $count, 'th5' ), $count ); ?>

					<span class="sep">&middot;</span>
					<?php $count = mb_get_user_reply_count(); ?>
					<?php printf( _n( '%s Reply', '%s Replies', $count, 'th5' ), $count ); ?>

				</div><!-- .mb-topic-meta -->

			</li>

		<?php endwhile; // End found users loop. ?>

	</ul>

	<?php do_action( 'mb_loop_user_after' ); ?>

	</div>

	<?php mb_loop_user_pagination(); ?>

<?php endif; // End check for users. ?>