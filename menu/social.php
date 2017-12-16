<?php if ( has_nav_menu( 'social' ) ) : // Check if there's a menu assigned to the 'social' location. ?>


	<div <?php hybrid_attr( 'menu', 'social', array( 'class' => 'menu menu--social' ) ); ?>>

		<h3 class="screen-reader-text"><?php echo hybrid_get_menu_name( 'social' ); ?></h3>

		<?php wp_nav_menu(
			array(
				'theme_location'  => 'social',
				'container'       => '',
				'container_id'    => 'menu-social',
				'container_class' => 'menu',
				'menu_id'         => 'menu-social-items',
				'menu_class'      => 'menu__items',
				'depth'           => 1,
				'link_before'     => '<span class="menu__anchor-text screen-reader-text">',
				'link_after'      => '</span>',
				'fallback_cb'     => '',
				'item_spacing'    => 'discard'
			)
		); ?>

	</div><!-- .menu-social -->

<?php endif; // End check for menu. ?>
