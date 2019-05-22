<?php
/**
 * Template for Displaying Widgets
 *
 * @package info.*.edu
 */

if ( $columns ) {
	foreach ( $columns as $column ) {
		?>
		<div class="widget">
			<?php echo wp_kses_post( $column['content'] ); ?>
		</div>
		<?php
	};
} else {
	?>
	<div class="widget">
		<?php echo wp_kses_post( $global_why_choose ); ?>
	</div>
	<?php
}
