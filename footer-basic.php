<?php
/**
 * The template for displaying a blank footer
 *
 * Only outputs the wp_footer content, no html.
 *
 * @package nusa
 */

$site_terms = get_theme_mod( 'terms_conditions' );
?>
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
