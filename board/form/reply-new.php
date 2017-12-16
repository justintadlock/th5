<?php if ( !current_user_can( 'access_reply_form' ) )
	return;
?>

<div class="topic-reply-form comment-respond form-block">

	<h3 class="comment-reply-title form-block__title"><?php mb_reply_label( 'add_new_item' ); ?></h3>


<form id="mb-reply-form" class="mb-form mb-reply-form" method="post" action="<?php mb_topic_url(); ?>">

		<p class="mb-form-content">
			<label for="mb_reply_content"><?php mb_reply_label( 'mb_form_content' ); ?></label>
			<span class="mb-formatting">(Please read <a target="_blank" href="<?php th5_forum_formatting_url(); ?>">Formatting Content</a> before posting.)</span>
			<textarea id="mb_reply_content" name="mb_reply_content" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea>
		</p><!-- .mb-form-content -->

		<p class="mb-form-submit form-submit">
			<input type="submit" class="submit" value="<?php esc_attr_e( 'Post Reply', 'message-board' ); ?>" />
		</p>

		<?php if ( mb_is_subscriptions_active() && !mb_is_user_subscribed_topic( mb_get_topic_id() ) ) : ?>

			<p>
				<label>
					<input type="checkbox" name="mb_reply_subscribe" value="1" />
					<?php _e( 'Notify me of follow-up posts via email', 'message-board' ); ?>
				</label>
			</p>

		<?php endif; // End check if subscriptions enabled. ?>

		<input type="hidden" name="mb_reply_topic_id" value="<?php mb_topic_id(); ?>" />

		<?php wp_nonce_field( 'mb_new_reply_action', 'mb_new_reply_nonce', false ); ?>
</form>

</div>