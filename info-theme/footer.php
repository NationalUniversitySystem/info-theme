<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package nusa
 */

$site_terms = get_theme_mod( 'terms_conditions' );
?>

		</div><!-- #content -->

		<footer class="site-footer">
			<div class="container">
				<div class="site-footer__navigation">
					<nav class="footer-navigation" role="navigation" aria-label="Footer Navigation - <?php echo esc_attr( wp_get_nav_menu_name( 'primary-footer' ) ); ?>">
						<?php
						wp_nav_menu( array(
							'theme_location' => 'primary-footer',
							'container'      => false,
							'fallback_cb'    => false,
						) );
						?>
					</nav>
				</div>
				<div class="site-footer__copyright">
					<p><?php printf( '&copy; Copyright %s %s. All Rights Reserved.', esc_html( date( 'Y' ) ), esc_html( get_bloginfo( 'name' ) ) ); ?></p>
				</div>
			</div>
		</footer>
	</div><!-- #page -->

	<div class="modal fade" id="terms-modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="icon icon-cancel close" data-dismiss="modal"></button>
					<?php echo wp_kses_post( $site_terms ); ?>
				</div>
			</div>
		</div>
	</div>

	<?php wp_footer(); ?>

</body>
</html>
