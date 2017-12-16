<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_single( get_the_ID() ) ) : // If viewing a single post. ?>

		<header class="entry__header">
			<h1 class="entry__title"><?php single_post_title(); ?></h1>
		</header><!-- .entry__header -->

		<div class="entry__content">
			<?php the_content(); ?>
			<?php th5_link_pages(); ?>
		</div><!-- .entry__content -->

	<?php else : // If not viewing a single post. ?>

		<?php extant_featured_image(); ?>

		<header class="entry__header">
			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry__title' ) . '><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
		</header><!-- .entry__header -->

	<?php endif; // End single post check. ?>

</article><!-- .entry -->
