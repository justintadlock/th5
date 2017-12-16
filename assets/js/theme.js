( function() {

	/*
	 * Adds classes to the `<label>` element based on the type of form element the label belongs
	 * to. This allows theme devs to style specifically for certain labels (think, icons).
	 */
	var formInputs = document.querySelectorAll(
		'.site input, .site textarea, .site select'
	);

	for ( var i = 0; i < formInputs.length; i++ ) {

		var el   = formInputs[ i ];
		var type = el.tagName.toLowerCase();
		var id   = el.getAttribute( 'id' );

		if ( 'input' === type )
			type = el.getAttribute( 'type' );

		// Checking parenElement in case the label is wrapped around the field.
		var label = id ? document.querySelector( '[for="' + id + '"]' ) : el.parentElement;

		if ( null !== label && 'label' === label.tagName.toLowerCase() ) {

			// Add a class to the label based on the input type.
			label.classList.add( 'label-' + type );

			// Add the `.focus` class on focus and remove on blur.
			focusBlurLabel( el, label );
		}
	}

	function focusBlurLabel( input, label ) {

		input.onfocus = function() {
			label.classList.add( 'focus' );
		};

		input.onblur = function () {
			label.classList.remove( 'focus' );
		};
	}

	// Line numbers for code.
	var preCodeTags = document.querySelectorAll( 'pre code' );

	for ( var i = 0; i < preCodeTags.length; i++ ) {

		var pre = preCodeTags[ i ].closest( 'pre' );

		// Create a wrapper element for the line numbers.
		var numWrap = document.createElement( 'span' );

		numWrap.className = 'line-numbers';

		// Split everying within the `<pre>` elemenet by new line and get the count.
		// Note that we get an extra line number for some reason, so we're resetting
		// it here so that we have the correct number.
		var numbers = pre.innerHTML.split( /\n/ ).length - 1;

		// Insert the wrapper before the first child.
		pre.insertBefore( numWrap, pre.firstChild );

		// Loop through the array of lines and add a new number.
		for ( var j = 0; j < numbers; j++ ) {

			numWrap.innerHTML += '<span>' + ( j + 1 ) + '.</span>';
		}
	}

	// Add class to links with an image.
	var linkedImages = document.querySelectorAll( 'body a img, body a svg' );

	for ( var i = 0; i < linkedImages.length; i++ ) {

		var addClass = 'img' === linkedImages[ i ].tagName.toLowerCase() ? 'has-image' : 'has-svg';

		linkedImages[ i ].parentElement.classList.add( addClass );
	}

	// Wrap inner text function.
	function wrapInner( parent, el ) {

		if ( null === parent || null === el )
			return;

		// Append the button text element to the button.
		parent.appendChild( el );

		// Append first child (text) to the button text element.
		while ( parent.firstChild !== el )
			el.appendChild( parent.firstChild );
	}

	// Wrap text inside link buttons with a `<span>`.
	var buttons = document.querySelectorAll( 'a.button' );

	// Loop through all the buttons.
	for ( var i = 0; i < buttons.length; i++ ) {

		// Create a new `<span>` element to wrap the text.
		var buttonText = document.createElement( 'span' );

		// Add a custom class name.
		buttonText.className = 'button__text';

		wrapInner( buttons[ i ], buttonText );
	}

	// Screen reader text.
	var cancelReplyLink = document.getElementById( 'cancel-comment-reply-link' );
	var screenReaderText = document.createElement( 'span' );
	screenReaderText.className = 'screen-reader-text';

	wrapInner( cancelReplyLink, screenReaderText );

	// Custom-colored line-through.
	var strikes = document.querySelectorAll( 'del, strike, s' );

	for ( var i = 0; i < strikes.length; i++ ) {

		var lineThrough = document.createElement( 'span' );

		lineThrough.className = 'line-through';

		wrapInner( strikes[ i ], lineThrough );
	}

	// Hide separator for no comments span.
	var unlinkedComments = document.querySelectorAll( 'span.entry__comments-link' );

	for ( var i = 0; i < unlinkedComments.length; i++ ) {

		unlinkedComments[ i ].previousElementSibling.style.display = 'none';
	}

	// Pagination classes.  Suck it, WP!
	var pagination = document.querySelector( 'ul.page-numbers' );

	if ( null !== pagination ) {

		pagination.className = 'pagination__items';

		var items = pagination.querySelectorAll( 'li' );

		for ( var i = 0; i < items.length; i++ ) {

			var item = items[ i ];

			item.className = 'pagination__item';

			var anchor = item.querySelector( 'a, span' );

			if ( anchor.classList.contains( 'dots' ) ) {
				anchor.className = 'pagination__anchor pagination__anchor--dots';

			} else if ( anchor.classList.contains( 'current' ) ) {
				item.classList.add( 'pagination__item--current' );
				anchor.className = 'pagination__anchor pagination__anchor--current';

			} else {
				if ( anchor.classList.contains( 'prev' ) ) {
					item.classList.add( 'pagination__item--prev' );

				} else if ( anchor.classList.contains( 'next' ) ) {
					item.classList.add( 'pagination__item--next' );
				}

				anchor.className = 'pagination__anchor pagination__anchor--link';
			}
		}
	}

	/* === Lightgallery integration code. === */

	if ( 'function' === typeof lightGallery ) {

		// We only need this for one gallery on a page.
		var gallery = document.querySelector( '.gallery' );

		if ( null !== gallery ) {

			var items = gallery.querySelectorAll( '.gallery-item' );

			// Loop through each of the gallery items, get the URL to the larger
			// image on the `<a>` element, and set that as the `data-src` attribute
			// on the gallery item, which is required by lightGallery.
			for ( var i = 0; i < items.length; i++ ) {

				var anchor = items[ i ].querySelector( 'a' );

				items[ i ].setAttribute( 'data-src', anchor.getAttribute( 'href' ) );
			}

			lightGallery( gallery );
		}
	}

	/* === Menu toggle. === */

	// Adds our overlay div.
	//var belowSiteHeader = document.querySelector( '.site__below-header' );
	//var overlay         = document.createElement( 'div' );

	//overlay.className = 'site__overlay';

	//belowSiteHeader.insertBefore( overlay, belowSiteHeader.firstChild );

	// Assume the initial scroll position is 0.
	var scroll = 0;

	// Wait for a click on one of our menu toggles.
	var menuButtons = document.querySelectorAll( '.menu__button' );

	for ( var i = 0; i < menuButtons.length; i++ ) {

		menuButtons[ i ].onclick = menuToggle;
	}

	function menuToggle() {

		// Assign this (the button that was clicked) to a variable.
		var button = this;

		// Gets the actual menu (parent of the button that was clicked).
		var menu = button.closest( '.menu' ).querySelector( '.menu__items' );

		// Toggle the selected classes for this menu.
		button.classList.toggle( 'menu__button--selected' );
		menu.classList.toggle( 'menu__items--visible' );

		// Is the menu in an open state?
		var is_open = menu.classList.contains( 'menu__items--visible' );

		// If the menu is open and there wasn't a menu already open when clicking.
		if ( is_open && ! document.body.classList.contains( 'menu-open' ) ) {

			// Get the scroll position if we don't have one.
			if ( 0 === scroll ) {
				scroll = document.body.scrollTop;
			}

			// Add a custom body class.
			document.body.classList.add( 'menu-open' );

		// If we're closing the menu.
		} else if ( ! is_open ) {

			document.body.classList.remove( 'menu-open' );
			document.body.scrollTop = scroll;
			scroll = 0;
		}
	}

	// Close menus when somewhere else in the document is clicked.
	document.onclick = function( event ) {

		document.body.classList.remove( 'menu-open' );

		var button = document.querySelector( '.menu__button--selected' );
		var menu   = document.querySelector( '.menu__items--visible' );

		if ( null !== button )
			button.classList.remove( 'menu__button--selected' );

		if ( null !== menu )
			menu.classList.remove( 'menu__items--visible' );
	};

	// Stop propagation if clicking inside of our main menu.
	var menuPrimary = document.querySelector( '.menu--primary' );

	menuPrimary.onclick = function( event ) {

		event.stopPropagation();
	};

}() );
