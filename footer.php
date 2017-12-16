			</div><!-- .site__body -->

			<footer class="site-footer">

				<div class="site-footer__wrap">

					<p class="site-footer__credit">
						<?php printf(
							// Translators: 1 is WordPress name/link and 2 is theme name/link. */
							esc_html__( 'Powered by junk food and WordPress.', 'extant' ), hybrid_get_wp_link()
						); ?>
					</p><!-- .site-footer__credit -->

					<?php hybrid_get_menu( 'social' ); // Loads the menu/social.php template. ?>

				</div><!-- .site-footer__wrap -->

			</footer><!-- .site-footer -->

		</div><!-- .below-site-header -->

	</div><!-- .site -->

	<?php wp_footer(); // WordPress hook for loading JavaScript, toolbar, and other things in the footer. ?>

</body>
</html>
