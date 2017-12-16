<form class="search-form doc-search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="label-search">
		<span class="screen-reader-text">Search for:</span>
		<input type="search" class="search-field" placeholder="Search &hellip;" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="Search for:">
	</label>
	<input type="hidden" name="post_type" value="doc" />
</form>

<?php if ( have_posts() ) : // Checks if any posts were found. ?>

	<div class="loop loop-list">

		<ul>

		<?php while ( have_posts() ) : // Begins the loop through found posts. ?>

			<?php the_post(); // Loads the post data. ?>

			<li>
				<a class="list-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

				<div class="list-meta">
					<?php echo get_the_modified_date(); ?>
					<?php hybrid_post_terms( array( 'taxonomy' => 'doc_relationship', 'before' => ' <span class="sep">&middot;</span> ' ) ); ?>
					<?php hybrid_post_terms( array( 'taxonomy' => 'doc_type', 'before' => ' <span class="sep">&middot;</span> ' ) ); ?>
				</div><!-- .mb-topic-meta -->
			</li>

		<?php endwhile; // End found posts loop. ?>

		</ul>

	</div><!-- .loop -->

	<?php locate_template( array( 'misc/loop-nav.php' ), true ); // Loads the misc/loop-nav.php template. ?>

<?php else : // If no posts were found. ?>

	<?php locate_template( array( 'content/error.php' ), true ); // Loads the content/error.php template. ?>

<?php endif; // End check for posts. ?>
