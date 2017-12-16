<?php
/**
 * This template part outputs the forum archive content.  The forum archive is the board home page if
 * the plugin is set to show forums on front (default).
 *
 * Theme authors can overwrite this template by placing a `/board/content-archive-forum.php` template
 * in their theme folder.
 */
?>

<header class="archive-header">
	<h1 class="archive-header__title">Support Forums</h1>

	<div class="archive-header__meta">
		<a href="<?php mb_user_url( get_current_user_id() ); ?>">View Profile</a>
		<span class="sep">&middot;</span>
		<a href="<?php echo esc_url( get_post_type_archive_link( mb_get_topic_post_type() ) ); ?>">Topics</a>
		<span class="sep">&middot;</span>
		<a href="<?php echo esc_url( get_post_type_archive_link( mb_get_topic_post_type() ) ); ?>#mb-topic-form">Create Topic &rarr;</a>
	</div>

	<?php mb_get_template_part( 'form', 'search-basic' ); ?>
</header>

<?php
	/**
	  Loads the `loop-forum-hierarchical.php` template part if the forum archive should be hierarchical.
	  Otherwise, it uses the `loop-forum-flat.php` template part.  Falls back to the `loop-forum.php`
	  template part.
	 */
	mb_get_template_part( 'loop', mb_show_hierarchical_forums() ? 'forum-hierarchical' : 'forum-flat' );
?>

<?php
	/* Loads the `form-forum-new.php` template part.  Falls back to the `form-forum.php` template part. */
	mb_get_template_part( 'form', 'forum-new' );
?>
