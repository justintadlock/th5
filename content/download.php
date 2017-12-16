<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_single( get_the_ID() ) ) : // If viewing a single post. ?>

		<header class="entry__header">
			<h1 class="entry__title"><?php single_post_title(); ?></h1>
		</header><!-- .entry__header -->

		<?php get_the_image(
			array(
				'size'         => extant_get_featured_size(),
				'srcset_sizes' => array( extant_get_featured_size_2x() => '2x' ),
				'order'        => array( 'featured' ),
				'min_width'    => extant_get_featured_min_width(),
				'before'       => '<div class="featured-media">',
				'after'        => '</div>',
				'link'         => false
			)
		); ?>

		<?php if ( ! get_post_meta( get_the_ID(), '_edd_hide_purchase_link', true ) ) : ?>

			<?php echo edd_get_purchase_link(); ?>

		<?php endif; ?>

		<div class="entry__content">
			<?php the_content(); ?>
			<?php th5_link_pages(); ?>
		</div><!-- .entry__content -->

		<footer class="entry__footer">
			<?php hybrid_post_terms( array( 'taxonomy' => 'download_category' ) ); ?>
			<?php hybrid_post_terms( array( 'taxonomy' => 'download_tag' ) ); ?>
		</footer><!-- .entry__footer -->

	<?php else : // If not viewing a single post. ?>

		<?php extant_featured_image(); ?>

		<header class="entry__header">

			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry__title' ) . '><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>

			<div class="entry__byline">
				<?php if ( function_exists( 'edd_price' ) ) edd_price(); ?>
			</div><!-- .entry-byline -->

		</header><!-- .entry__header -->

	<?php endif; // End single post check. ?>

</article><!-- .entry -->
