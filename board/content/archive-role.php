<?php
/**
 * This template part outputs the role archive content.
 */
?>

<header class="archive-header">
	<h1 class="archive-header__title"><?php the_archive_title(); ?></h1>
</header>

<?php
	/* Loads the `loop-role.php` template part.  Falls back to the `loop.php` template part. */
	mb_get_template_part( 'loop', 'role' );
?>