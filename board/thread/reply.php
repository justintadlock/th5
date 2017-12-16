<li id="post-<?php mb_reply_id(); ?>" <?php // post_class(); ?>class="thread__item">

	<article>
		<header class="thread__meta">
			<?php echo get_avatar( mb_get_reply_author_id(), 96, '', '', array( 'class' => 'thread__avatar' ) ); ?>

			<span class="thread__author"><?php mb_reply_author_link(); ?></span>
			<br />

			<a class="mb-reply-permalink" href="<?php mb_post_jump_url(); ?>" rel="bookmark" itemprop="url"><time class="mb-reply-natural-time"><?php mb_reply_natural_time(); ?></time></a>

			<?php $sep = '<span class="sep">&middot;</span>'; ?>

			<?php echo ( $e = mb_get_reply_edit_link() ) ? "$sep $e" : ''; ?>
			<?php echo ( $t = mb_get_reply_toggle_trash_link() ) ? "$sep $t" : '' ; ?>
		</header>

		<div class="thread__content">
			<?php mb_reply_content(); ?>
		</div><!-- .mb-reply-content -->

	</article>
</li>
