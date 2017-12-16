<?php get_header(); // Loads the header.php template. ?>

<main class="site__content">

	<?php
		/*
		 * Action hook for the plugin to output its content. Technically, what this will
		 * do is load one of the `content-*.php` template parts for the specific page
		 * that is being viewed. Themes can either overwrite those template parts or
		 * overwrite this entire template.
		 */
		do_action( 'mb_theme_compat' );
	?>

</main><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>
