<?php if ( mb_role_query() ) : // Checks if we have roles. ?>

	<div class="mb-loop mb-loop-user">

	<ul>

		<?php while ( mb_role_query() ) : // Begins the loop through found roles. ?>

			<?php mb_the_role(); // Set up role data. ?>

			<li>
				<?php mb_role_link(); ?>

				<div class="mb-list-meta">
					<?php $count = mb_get_role_user_count(); ?>
					<?php printf( _n( '%s User', '%s Users', $count, 'th5' ), $count ); ?>

					<br />
					<?php mb_role_description(); ?>
				</div><!-- .mb-role-description -->
			</li>

		<?php endwhile; // End found roles loop. ?>

	</ul>

	</div>

	<?php mb_loop_role_pagination(); ?>

<?php endif; // End check for roles. ?>
