<header class="archive-header">
	<h1 class="archive-header__title"><?php mb_single_reply_title(); ?></h1>
</header>

<?php if ( current_user_can( 'read_reply', mb_get_reply_id() ) ) :

	<div class="thread">

	<ol class="thread__items">

		<?php if ( mb_reply_query() ) : ?>

			<?php while ( mb_reply_query() ) : ?>

				<?php mb_the_reply(); ?>

				<?php mb_get_template_part( 'thread', 'reply' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</ol><!-- #thread -->

	</div>

<?php endif; ?>