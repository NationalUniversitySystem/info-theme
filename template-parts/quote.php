<?php
/**
 * Template for Displaying Quote
 *
 * @package info.*.edu
 */

$page_id        = get_the_ID();
$quote_text     = get_post_meta( $page_id, '_quote_text', true );
$quote_citation = get_post_meta( $page_id, '_quote_citation', true );
$quote_title    = get_post_meta( $page_id, '_quote_title', true );

if ( $quote_text && $quote_citation && $quote_title ) :
	?>
	<section class="section section--quote py-6">
		<div class="container">
			<div class="row">
				<blockquote class="quote col-12 col-lg-8 offset-lg-2 mb-0">
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
