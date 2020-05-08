<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package nusa
 */

?>
	<?php get_template_part( 'template-parts/fixed-cta' ); ?>

	<footer class="footer py-5">
		<div class="container">
			<?php if ( has_nav_menu( 'primary-footer' ) ) { ?>
				<div class="footer__navigation d-md-inline-block">
					<nav class="footer-navigation d-inline-block" role="navigation" aria-label="Footer Navigation - <?php echo esc_attr( wp_get_nav_menu_name( 'primary-footer' ) ); ?>">
						<?php
						wp_nav_menu( [
							'theme_location' => 'primary-footer',
							'container'      => false,
							'fallback_cb'    => false,
							'menu_class'     => 'm-0 p-0',
						] );
						?>
					</nav>
				</div>
			<?php } // end check for $footer_nav ?>

			<div class="footer__copyright d-md-inline-block">
				<p class="mb-0"><?php printf( '&copy; Copyright %s %s. All Rights Reserved.', esc_html( gmdate( 'Y' ) ), esc_html( get_bloginfo( 'name' ) ) ); ?></p>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
