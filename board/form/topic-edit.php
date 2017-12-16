<?php
if ( !current_user_can( 'edit_topic', mb_get_topic_id() ) )
	return;
?>

<div class="form-block">

	<h3 class="form-block__title">Edit Topic</h3>

<form id="topic-form" class="mb-form mb-form-topic" method="post" action="<?php mb_topic_url(); ?>">

	<p>
		<label for="mb_topic_title"><?php mb_topic_label( 'mb_form_title' ); ?></label>
		<input type="text" id="mb_topic_title" name="mb_topic_title" value="<?php echo esc_attr( mb_get_topic_title() ); ?>" required />
	</p>

	<p>
		<label for="mb_topic_forum"><?php mb_topic_label( 'parent_item_colon' ); ?></label>
		<?php mb_dropdown_forums(
			array(
				'child_type' => mb_get_topic_post_type(),
				'name'       => 'mb_topic_forum',
				'id'         => 'mb_topic_forum',
				'selected'   => mb_get_topic_forum_id()
			)
		); ?>
	</p>

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

	<p>
		<label for="mb_topic_content"><?php mb_topic_label( 'mb_form_content' ); ?></label>
			<span class="mb-formatting">(Please read <a target="_blank" href="<?php th5_forum_formatting_url(); ?>">Formatting Content</a> before posting.)</span>
		<textarea id="mb_topic_content" name="mb_topic_content" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"><?php echo format_to_edit( mb_get_topic_content( mb_get_topic_id(), 'edit' ) ); ?></textarea>
	</p>

	<p>
		<input type="submit" value="<?php esc_attr_e( 'Submit', 'message-board' ); ?>" />
	</p>

	<p>
		<label>
			<input type="checkbox" name="mb_topic_subscribe" value="1" <?php checked( mb_is_user_subscribed_topic( mb_get_topic_author_id(), mb_get_topic_id() ) ); ?> />
			<?php _e( 'Notify me of follow-up posts via email', 'message-board' ); ?>
		</label>
	</p>

	<input type="hidden" name="mb_topic_id" value="<?php echo absint( mb_get_topic_id() ); ?>" />

	<?php wp_nonce_field( 'mb_edit_topic_action', 'mb_edit_topic_nonce', false ); ?>

</form>

</div>
