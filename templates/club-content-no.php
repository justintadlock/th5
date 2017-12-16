<?php get_header(); // Loads the header.php template. ?>

<main <?php hybrid_attr( 'content' ); ?>>

	<div class="entry">

		<h1 class="entry__title">Whoah, partner!</h1>

		<p class="p-one">It looks like you stumbled upon a section reserved for Theme Hybrid members.  We'd love to have you as part of our community.</p>

		<div class="meta-block">
		<p class="meta-block__buttons"><a class="button button--purchase" href="#plans-pricing">See Plans & Pricing</a></p>
		</div>

		<?php if ( ! is_user_logged_in() ) : ?>

			<div class="login-wrap">
				<h2 class="aligncenter">Already a member? Log into your account.</h2>
				<?php wp_login_form(); ?>
			</div><!-- .login-wrap -->

		<?php endif; ?>

		<h2 id="plans-pricing" class="big">Plans <span class="amp">&amp;</span> Pricing</h2>

		<p class="p-one">You want premium products and service at an affordable price, right?  Everyone does.  Get dedicated support, access to the entire product line, and a community of like-minded users who love WordPress.</p>

		<?php echo th_post_content_shortcode( array( 'post_id' => 9913 ) ); ?>

</main><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>
