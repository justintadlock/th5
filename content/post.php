<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_single( get_the_ID() ) ) : // If viewing a single post. ?>

		<header class="entry__header">

			<h1 class="entry__title"><?php single_post_title(); ?></h1>

			<div class="entry__byline">
				<?php hybrid_post_author( array( 'wrap' => '<span class="entry__author">%2$s</span>' ) ); ?>
				<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'extant' ); ?></span>
				<time class="entry__published"><?php echo get_the_date(); ?></time>
				<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'extant' ); ?></span>
				<?php comments_popup_link( false, false, false, 'entry__comments-link' ); ?>
			</div><!-- .entry-byline -->

		</header><!-- .entry__header -->

		<div class="entry__content">
			<?php the_content(); ?>
			<?php th5_link_pages(); ?>
		</div><!-- .entry__content -->

		<footer class="entry__footer">
			<?php hybrid_post_terms( array( 'taxonomy' => 'category', 'text' => '<i class="fa fa-tags"></i> Posted in %s', 'wrap' => '<span class="entry__terms">%2$s</span>' ) ); ?>
		</footer><!-- .entry__footer -->

	<?php else : // If not viewing a single post. ?>

		<?php extant_featured_image(); ?>

		<header class="entry__header">

			<?php the_title( '<h2 class="entry__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>

			<div class="entry__byline">
				<a class="entry__permalink" href="<?php the_permalink(); ?>" rel="bookmark" itemprop="url"><tim class="entry__published"><?php echo get_the_date(); ?></time></a>
				<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'extant' ); ?></span>
				<?php comments_popup_link( false, false, false, 'entry__comments-link' ); ?>
			</div><!-- .entry-byline -->

		</header><!-- .entry__header -->

	<?php endif; // End single post check. ?>

</article><!-- .entry -->
