<?php if ( !current_user_can( 'edit_reply', mb_get_reply_id() ) )
	return;
?>

<div class="form-block">

	<h3 class="form-block__title">Edit Reply</h3>

	<form id="reply-form" class="mb-form mb-form-reply" method="post" action="<?php mb_reply_url(); ?>">

		<p>
			<label for="mb_reply_content" name="mb_reply_content"><?php mb_reply_label( 'mb_form_content' ); ?></label>
			<span class="mb-formatting">(Please read <a target="_blank" href="<?php th5_forum_formatting_url(); ?>">Formatting Content</a> before posting.)</span>
			<textarea id="mb_reply_content" name="mb_reply_content" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"><?php echo format_to_edit( mb_get_reply_content( mb_get_reply_id(), 'edit' ) ); ?></textarea>
		</p>

		<p>
			<input type="submit" value="<?php esc_attr_e( 'Submit', 'message-board' ); ?>" />
		</p>

		<p>
			<label>
				<input type="checkbox" name="mb_topic_subscribe" value="1" <?php checked( mb_is_user_subscribed_topic( mb_get_reply_author_id(), mb_get_reply_topic_id() ) ); ?>" />
				<?php _e( 'Notify me of follow-up posts via email', 'message-board' ); ?>
			</label>
		</p>

		<input type="hidden" name="mb_reply_id" value="<?php mb_reply_id(); ?>" />

		<?php wp_nonce_field( 'mb_edit_reply_action', 'mb_edit_reply_nonce', false ); ?>

	</form>

</div>
