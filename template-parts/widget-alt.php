<?php
/**
 * Template for Displaying Widgets
 *
 * @package info.*.edu
 */

$custom_callout = get_post_meta( get_the_ID(), '_nus_template_callout', true );
$global_callout = get_theme_mod( 'callout' );
$callout_text   = ! empty( $custom_callout ) ? $custom_callout : $global_callout;
?>
<div class="widget widget--alt">
	<div class="widget__border">
		<div class="widget__inner">
			<?php echo wp_kses_post( $callout_text ); ?>
		</div>
	</div>
</div>
