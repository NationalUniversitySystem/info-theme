<?php
/**
 * Template for Displaying Quote
 *
 * @package info.*.edu
 */

$page_id        = get_the_ID();
$quote_text     = get_post_meta( $page_id, '_nus_template_quote_text', true );
$quote_citation = get_post_meta( $page_id, '_nus_template_quote_citation', true );
$quote_title    = get_post_meta( $page_id, '_nus_template_quote_title', true );
?>

<section class="info-section info-section--quote">
	<div class="container">
		<div class="row">
			<blockquote class="quote">
				<p>"<?php echo esc_html( $quote_text ); ?>"</p>
				<footer>
					<cite>
						<?php echo esc_html( $quote_citation ); ?>
						<span>
							<?php echo esc_html( $quote_title ); ?>
						</span>
					</cite>
				</footer>
			</blockquote>
		</div>
	</div>
</section>
