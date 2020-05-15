<?php
/**
 * Template for Displaying Quote on the Stacked template
 *
 * @package info.*.edu
 */

$page_id        = get_the_ID();
$quote_text     = get_post_meta( $page_id, '_quote_text', true );
$quote_citation = get_post_meta( $page_id, '_quote_citation', true );
$quote_title    = get_post_meta( $page_id, '_quote_title', true );
$quote_img_id   = get_post_meta( $page_id, '_quote_image', true );
$quote_img      = wp_get_attachment_image( $quote_img_id, 'full', false, ['class' => 'd-md-none' ] );
//$quote_img_alt  = get_post_meta( $quote_img_id, '_wp_attachment_image_alt', true );

if ( $quote_text && $quote_citation && $quote_title ) :
	?>
	<section class="section section--quote">
		<div class="container">
			<div class="row">
				<blockquote class="quote mx-auto mb-0">
					<?php
						if ( $quote_img_id ) {
							echo wp_kses_post( $quote_img );
						}
					?>
					<p class="mb-3">"<?php echo esc_html( $quote_text ); ?>"</p>
					<footer>
						<cite>
							<?php echo esc_html( $quote_citation ); ?>
							<span><?php echo esc_html( $quote_title ); ?></span>
						</cite>
					</footer>
				</blockquote>
			</div>
		</div>
	</section>
	<?php
endif;
