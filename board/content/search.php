<?php
/**
 * This template part outputs the search form page.
 */
?>

<header class="archive-header">
	<h1 class="archive-header__title"><?php mb_search_page_title(); ?></h1>

	<div class="archive-header__meta">
		<a href="<?php echo esc_url( get_post_type_archive_link( mb_get_forum_post_type() ) ); ?>">Forums</a>
		<span class="sep">&middot;</span>
		<a href="<?php echo esc_url( get_post_type_archive_link( mb_get_topic_post_type() ) ); ?>">Topics</a>
	</div>
</header>

<?php
	/* Loads the `form-search-advanced.php` template part. */
	mb_get_template_part( 'form', 'search-advanced' );
?>