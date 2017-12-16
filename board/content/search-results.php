<?php
/**
 * This template part outputs the search results content.
 */
?>

<header class="archive-header">
	<h1 class="archive-header__title">Search Results For: <?php the_search_query(); ?></h1>

	<div class="archive-header__meta">
		<a href="<?php echo esc_url( get_post_type_archive_link( mb_get_forum_post_type() ) ); ?>">Forums</a>
		<span class="sep">&middot;</span>
		<a href="<?php echo esc_url( get_post_type_archive_link( mb_get_topic_post_type() ) ); ?>">Topics</a>
		<span class="sep">&middot;</span>
		<a href="<?php mb_search_url(); ?>">Advanced Search</a>
	</div>

<?php
	/* Loads the `form-search-basic.php` template part. */
	mb_get_template_part( 'form', 'search-basic' );
?>

</header>

<?php
	/* Loads the `loop-search.php` template part.  Falls back to the `loop.php` template part. */
	mb_get_template_part( 'loop', 'search' );
?>