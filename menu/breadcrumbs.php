<?php if (
	function_exists( 'breadcrumb_trail' )
	//&& function_exists( 'mb_is_message_board' )
	//&& mb_is_message_board()
	//&& ! mb_is_forum_front()
) : ?>

	<?php breadcrumb_trail(
		array(
			'container'       => 'nav',
			'container_class' => 'breadcrumbs',
			'list_class'      => 'breadcrumbs__items',
			'item_class'      => 'breadcrumbs__item',
			'show_browse'     => false,
			'show_on_front'   => false
		)
	); ?>

<?php endif; // End check for breadcrumb support. ?>
