<?php
/**
 * Template for Displaying Widgets
 *
 * @package info.*.edu
 */

?>
<div class="widget widget--alt">
	<div class="widget__border">
		<div class="widget__inner">
			<?php
			if ( $custom_callout ) {
				echo wp_kses_post( $custom_callout );
			} else {
				echo wp_kses_post( $global_callout );
			}
			?>
		</div>
	</div>
</div>
