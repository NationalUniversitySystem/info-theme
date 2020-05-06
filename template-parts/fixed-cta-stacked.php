<?php
/**
 * Template for Displaying T&C header fixed-cta.
 *
 * @package info.nu.edu
 */

?>

<div class="fixed-cta--stacked d-none">
	<div class="container">
		<div class="row">
			<h3><?php echo wp_kses_post( apply_filters( 'stacked_cta_heading', 'Don\'t delay - new classes begin every 30 days!' ) ); ?></h3>
			<a href="#form-offset" class="button button--yellow"><?php echo wp_kses_post( apply_filters( 'stacked_cta', 'Request Info' ) ); ?></a>
		</div>
	</div>
</div>
