<?php
/**
 * This template part outputs the topic archive content (latest topics).  The topic archive is the
 * board home page if the plugin is set to show topics on front.
 */
?>

<header class="archive-header">
	<h1 class="archive-header__title">Support Topics</h1>

	<div class="archive-header__meta">
		<a href="<?php mb_user_url( get_current_user_id() ); ?>">View Profile</a>
		<span class="sep">&middot;</span>
		<a href="<?php echo esc_url( get_post_type_archive_link( mb_get_forum_post_type() ) ); ?>">Forums</a>
		<span class="sep">&middot;</span>
		<a href="#mb-topic-form">Create Topic &rarr;</a>
	</div>

	<?php mb_get_template_part( 'form', 'search-basic' ); ?>
</header>

<?php
	/* Loads the `loop-topic.php` template part.  Falls back to the `loop.php` template part. */
	mb_get_template_part( 'loop', 'topic' );
?>

<?php
	/* Loads the `form-topic-new.php` template part.  Falls back to the `form-topic.php` template part. */
	mb_get_template_part( 'form', 'topic-new' );
?>