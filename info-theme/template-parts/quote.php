<?php
/**
 * Template for Displaying Quote
 *
 * @package info.*.edu
 */

?>
<blockquote class="quote">
	<p>
		"<?php echo esc_html( $quote_text ); ?>"
	</p>
	<footer>
		<cite>
			<?php echo esc_html( $quote_citation ); ?>
			<span>
				<?php echo esc_html( $quote_title ); ?>
			</span>
		</cite>
	</footer>
</blockquote>
