<?php
/**
 * Template for Displaying Widgets
 *
 * @package info.*.edu
 */

$columns           = get_post_meta( get_the_ID(), '_nus_template_columns', true );
$global_why_choose = get_theme_mod( 'why_choose' );

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
