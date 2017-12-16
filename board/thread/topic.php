<li id="post-<?php mb_topic_id(); ?>" <?php //post_class(); ?> class="thread__item">

		<header class="thread__meta">
			<?php echo get_avatar( mb_get_topic_author_id(), 96, '', '', array( 'class' => 'thread__avatar' ) ); ?>

			<span class="thread__author"><?php mb_topic_author_profile_link(); ?></span>
			<br />

			<a class="mb-topic-permalink" href="<?php mb_post_jump_url(); ?>" rel="bookmark" itemprop="url"><time class="mb-topic-natural-time"><?php mb_topic_natural_time(); ?></time></a>

			<?php $sep = '<span class="sep">&middot;</span>'; ?>

			<?php echo ( $e = mb_get_topic_edit_link() ) ? "$sep $e" : ''; ?>
			<?php echo ( $t = mb_get_topic_toggle_trash_link() ) ? "$sep $t" : '' ; ?>
			<?php echo ( $o = mb_get_topic_toggle_open_link() ) ? "$sep $o" : '' ; ?>
			<?php echo ( $c = mb_get_topic_toggle_close_link() ) ? "$sep $c" : '' ; ?>
		</header>

		<div class="thread__content">
			<?php mb_topic_content(); ?>
		</div><!-- .mb-topic-content -->

</li>
