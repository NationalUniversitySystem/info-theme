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

		<footer class="site-footer site-footer--applite">
			<div class="container">
				<div class="row">
					<div class="site-footer__navigation">
						<nav class="footer-navigation" role="navigation" aria-label="Footer Navigation - <?php echo esc_attr( wp_get_nav_menu_name( 'primary-footer' ) ); ?>">
							<?php
							wp_nav_menu( array(
								'theme_location' => 'applite-footer',
								'container'      => false,
								'fallback_cb'    => false,
							) );
							?>
						</nav>
					</div>
					<div class="site-footer__social">
						<ul>
							<li><a href="https://www.facebook.com/nationaluniversity" class="icon icon-facebook"><span class="sr-only">Facebook</span></a></li>
							<li><a href="https://twitter.com/natuniv" class="icon icon-twitter"><span class="sr-only">Twitter</span></a></li>
							<li><a href="https://www.linkedin.com/school/national-university/" class="icon icon-linkedin"><span class="sr-only">Linkedin</span></a></li>
							<li><a href="https://www.instagram.com/nationaluniversity/" class="icon icon-instagram"><span class="sr-only">Instagram</span></a></li>
							<li><a href="https://www.youtube.com/user/NatUniv" class="icon icon-youtube-play"><span class="sr-only">Youtube</span></a></li>
						</ul>
					</div>
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
