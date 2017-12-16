<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( thds_is_single_theme( get_the_ID() ) ) : // If viewing a single post. ?>

		<?php get_the_image( array( 'size' => 'full', 'image_class' => 'alignright', 'link' => false ) ); ?>

		<header class="entry__header">
			<h1 class="entry__title"><?php thds_theme_title(); ?></h1>
		</header><!-- .entry__header -->

		<div class="entry__summary">
			<?php thds_theme_excerpt(); ?>
		</div><!-- .entry__summary -->

		<div class="meta-block">

			<?php
			// Variables we need.
			$author_id      = thds_get_theme_author_id();
			$buynow         = th5_get_buynow_details();
			$plans_url      = th5_get_plans_url();
			$is_club_member = current_user_can( 'view_club_content' );
			$has_access     = 1 !== $author_id || $is_club_member;
			// End variables.
			?>

			<p class="meta-block__buttons">

			<?php if ( ! $has_access ) : ?>

				<?php $price = $buynow ? 'All-Access For $49' : 'Plans Starting At $29'; ?>

				<a href="<?php echo esc_url( $plans_url ); ?>" class="button button--purchase"><?php echo $price; ?></a>

			<?php elseif ( $has_access && $buynow ) : ?>

				<a href="<?php echo esc_url( $buynow['url'] ); ?>" class="button button--purchase"><?php echo esc_html( $buynow['text'] ); ?></a>

			<?php else : ?>

				<?php if ( $download_link = thds_get_theme_download_link( array( 'text' => '<i class="fa fa-cloud-download"></i> Download' ) ) ) : ?>

					<?php echo str_replace( 'thds-theme-download-link', 'button button--download', $download_link ); ?>

				<?php endif; ?>

				<?php if ( $repo_link = thds_get_theme_repo_link(array( 'text' => '<i class="fa fa-github"></i> Repository' )) ) : ?>

					<?php echo str_replace( 'thds-theme-repo-link', 'button button--repo', $repo_link ); ?>

				<?php endif; ?>

			<?php endif; ?>

			</p>

			<p class="meta-block__meta">

			<?php if ( ! $has_access && $buynow ) : ?>

				<a href="<?php echo esc_url( $buynow['url'] ); ?>"><?php echo esc_html( $buynow['text'] ); ?></a>

			<?php endif; ?>

			<?php if ( $version = thds_get_theme_version() ) : ?>

				<?php if ( ! $has_access && $buynow ) echo '<span class="sep">&middot;</span>'; ?>

				<?php echo esc_html( sprintf( __( 'Version %s', 'extant' ), $version ) ); ?>

			<?php endif; ?>

			<?php if ( $has_access ) : ?>

				<?php if ( $docs_link = thds_get_theme_docs_link() ) : ?>

					<?php printf( '<span class="sep">&middot;</span> %s', $docs_link ); ?>

				<?php endif; ?>

				<?php if ( $support_link = thds_get_theme_support_link() ) : ?>

					<?php printf( '<span class="sep">&middot;</span> %s', $support_link ); ?>

				<?php endif; ?>

			<?php elseif ( ! $buynow ) : ?>

				<?php if ( $download_link = thds_get_theme_download_link() ) : ?>

					<?php printf( '<span class="sep">&middot;</span> %s', $download_link ); ?>

				<?php endif; ?>

				<?php if ( $repo_link = thds_get_theme_repo_link() ) : ?>

					<?php printf( '<span class="sep">&middot;</span> %s', $repo_link ); ?>

				<?php endif; ?>

			<?php endif; ?>

			</p>
		</div><!-- .meta-block -->

		<div class="entry__content">
			<?php thds_theme_content(); ?>
		</div><!-- .entry__content -->

	<?php else : // If not viewing a single post. ?>

		<?php extant_featured_image(); ?>

		<header class="entry__header">
			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry__title' ) . '><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
		</header><!-- .entry__header -->

	<?php endif; // End single post check. ?>

</article><!-- .entry -->

<?php if ( thds_is_single_theme( get_the_ID() ) ) : // If viewing a single post. ?>

<?php $loop = new WP_Query( array( 'post_type' => 'theme', 'posts_per_page' => -1, 'post_parent' => get_the_ID() ) ); ?>

<?php if ( $loop->have_posts() ) : ?>

<h2 class="big">Child Themes</h2>

<p class="p-one">Do you like the theme but want a different look? No problem. Pick from one of the available child themes.</p>

<?php add_filter( 'post_class', 'extant_post_alt_class' ); ?>

<div class="plural">

<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

	<?php hybrid_get_content_template(); ?>

<?php endwhile; wp_reset_postdata(); ?>

</div>

<?php endif; ?>

<?php endif; ?>
