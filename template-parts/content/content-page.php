<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package nusa
 */

?>

<article <?php post_class( 'col-12' ); ?> aria-label="Content area #1">
	<?php if ( is_page_template( 'page-templates/thank-you.php' ) ) { ?>
		<div class="entry-title">
			<?php the_title( '<h1>', '</h1>' ); ?>
		</div>
	<?php } ?>
	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'nusa' ),
						[
							'span' => [
								'class' => [],
							],
						]
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article>
