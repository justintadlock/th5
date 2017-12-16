<?php get_header(); // Loads the header.php template. ?>

<main class="site__content">

	<?php if ( ! is_front_page() && hybrid_is_plural() ) : // If viewing a multi-post page ?>

		<?php locate_template( array( 'misc/loop-meta.php' ), true ); // Loads the misc/loop-meta.php template. ?>

	<?php endif; // End check for multi-post page. ?>

	<?php hybrid_get_template_part(
		'loop',
		is_post_type_archive( 'doc' ) || is_tax( array( 'doc_relationship', 'doc_type' ) ) ? 'doc' : ''
	); ?>

</main>

<?php get_footer(); // Loads the footer.php template. ?>
