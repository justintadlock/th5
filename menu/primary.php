<nav <?php hybrid_attr( 'menu', 'primary', array( 'class' => 'menu menu--primary' ) ); ?>>

	<h3 class="menu__title">
		<?php printf(
			'<button class="menu__button">%s<span class="screen-reader-text">%s</span></button>',
			//'<span class="icon">&#x22EE;</span>',
			'<i class="menu__icon fa fa-bars" aria-hidden="true"></i>',
			has_nav_menu( 'primary' ) ? hybrid_get_menu_name( 'primary' ) : hybrid_get_menu_location_name( 'primary' )
		); ?>
	</h3><!-- .menu-primary-toggle -->

	<?php if ( has_nav_menu( 'primary' ) ) : ?>

		<?php wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'container'       => '',
				'menu_id'         => '',
				'menu_class'      => 'menu__items',
				'link_before'     => '<span class="menu__anchor-text">',
				'link_after'      => '</span>',
				'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
				'item_spacing'    => 'discard'
			)
		); ?>

	<?php endif; ?>

</nav><!-- #menu-primary -->
