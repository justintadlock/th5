<?php if ( !current_user_can( 'access_topic_form' ) )
	return;
?>

<div class="form-block">

	<h3 class="form-block__title"><?php mb_topic_label( 'add_new_item' ); ?></h3>

	<form id="mb-topic-form" class="mb-form mb-form-topic" method="post" action="<?php mb_board_url(); ?>">

		<p class="mb-form-block__title form-block__control">
			<label for="mb_topic_title"><?php mb_topic_label( 'mb_form_title' ); ?></label>
			<input type="text" id="mb_topic_title" name="mb_topic_title" maxlength="60" value="<?php echo esc_attr( mb_get_topic_title() ); ?>" placeholder="<?php echo esc_attr( mb_get_topic_label( 'mb_form_title_placeholder' ) ); ?>" required />
		</p><!-- .mb-form-block__title -->

		<?php if ( !mb_is_single_forum() ) : ?>

			<p class="mb-form-parent">
				<label for="mb_forum_id"><?php mb_topic_label( 'parent_item_colon' ); ?></label>
				<?php mb_dropdown_forums(
					array(
						'child_type' => mb_get_topic_post_type(),
						'name'       => 'mb_forum_id',
						'id'         => 'mb_forum_id',
						'selected'   => mb_get_topic_forum_id()
					)
				); ?>
			</p><!-- .mb-form-parent -->

		<?php endif; ?>

		<p class="mb-form-type">
			<label for="mb_topic_type"><?php mb_topic_label( 'mb_form_type' ); ?></label>
			<?php mb_dropdown_topic_type(); ?>
		</p><!-- .mb-form-type -->

		<p class="mb-form-status">
			<label for="mb_post_status"><?php mb_topic_label( 'mb_form_status' ); ?></label>
			<?php mb_dropdown_topic_status(
				array(
					'name'      => 'mb_post_status',
					'id'        => 'mb_post_status',
					'selected'  => mb_get_topic_status()
				)
			); ?>
		</p><!-- .mb-form-status -->

		<p class="mb-form-content">
			<label for="mb_topic_content"><?php mb_topic_label( 'mb_form_content' ); ?></label>
			<span class="mb-formatting">(Please read <a target="_blank" href="<?php th5_forum_formatting_url(); ?>">Formatting Content</a> before posting.)</span>
			<textarea id="mb_topic_content" name="mb_topic_content" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea>
		</p><!-- .mb-form-content -->

		<p class="mb-form-submit">
			<input type="submit" value="<?php esc_attr_e( 'Create Topic', 'message-board' ); ?>" />
		</p><!-- .mb-form-submit -->

		<?php if ( mb_is_subscriptions_active() ) : // Only show subscribe if subscriptions enabled. ?>

			<p class="mb-form-subscribe">
				<label>
					<input type="checkbox" name="mb_topic_subscribe" value="1" />
					<?php mb_topic_label( 'mb_form_subscribe' ); ?>
				</label>
			</p><!-- .mb-form-subscribe -->

		<?php endif; // End check if subscriptions enabled. ?>

		<?php do_action( 'mb_topic_form_fields' ); ?>

	</form><!-- #mb-topic-form -->

</div><!-- .form-block -->
