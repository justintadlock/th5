<!DOCTYPE html>
<html <?php language_attributes( 'html' ); echo is_admin_bar_showing() ? ' class="has-admin-bar"' : ''; ?>>

<head <?php hybrid_attr( 'head' ); ?>>
<?php wp_head(); // Hook required for scripts, styles, and other <head> items. ?>
</head>

<body <?php hybrid_attr( 'body' ); ?>>

	<div class="site">

<?php if ( ! current_user_can( 'view_club_content' ) ) : ?>

<div class="notice">

	<p class="notice__message">Christmas special! Get 25% off your entire purchase by using the <strong>XMAS2017</strong> discount code at checkout.</p>

</div>

<?php endif; ?>

		<header class="site-header">

			<div class="site-header__wrap">

				<div class="site-header__branding">
					<h1 class="site-header__title"><a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
					<div class="site-header__description"><?php bloginfo( 'description' ); ?></div>
				</div><!-- #branding -->

				<?php hybrid_get_menu( 'primary' ); // Loads the `menu/super.php` template. ?>

			</div><!-- .site-header__wrap -->

		</header><!-- .site-header -->

		<div class="site__below-header">

			<div class="site__overlay"></div>

			<?php hybrid_get_menu( 'breadcrumbs' ); // Loads the menu/breadcrumbs.php template. ?>

			<div class="site__body">
