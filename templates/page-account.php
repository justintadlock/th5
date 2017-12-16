<?php
/**
 * Template Name: Account
 */

get_header(); // Loads the header.php template. ?>

<main <?php hybrid_attr( 'content' ); ?>>

	<?php if ( is_user_logged_in() ) : ?>

		<?php hybrid_get_template_part( 'loop' ); ?>

	<?php else : ?>

		<div class="entry">
			<h1 class="entry__title">Sign In</h1>

			<div class="entry__summary">
				<p>Log into your account. Not a member yet? See our <a href="/#plans-pricing">plans &amp; pricing</a>.</p>
			</div>

			<div class="login-wrap">
				<?php wp_login_form(); ?>
			</div><!-- .login-wrap -->
		</div>

	<?php endif; ?>

</main><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>
