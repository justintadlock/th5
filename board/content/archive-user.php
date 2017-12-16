<?php
/**
 * This template part outputs the user archive content.
 */
?>

<header class="archive-header">
	<h1 class="archive-header__title"><?php the_archive_title(); ?></h1>
</header>

<?php
	/* Loads the `loop-user.php` template part.  Falls back to the `loop.php` template part. */
	mb_get_template_part( 'loop', 'user' );
?>