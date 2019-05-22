<?php
/**
 * Template for Displaying Hero
 *
 * @package info.*.edu
 */

$page_id = get_the_ID();

$hero_title         = get_post_meta( $page_id, '_nus_template_headline', true );
$hero_sub_title     = get_post_meta( $page_id, '_nus_template_subheadline', true );
$hero_student_name  = get_post_meta( $page_id, '_nus_template_student_info', true );
$hero_student_title = get_post_meta( $page_id, '_nus_template_student_title', true );

if ( has_post_thumbnail() ) {
	$hero_background_image = get_the_post_thumbnail_url();
} else {
	$hero_background_image = get_post_meta( $page_id, '_nus_template_background', true );
}

if ( '' !== $hero_background_image ) {
	?>
	<style>
		@media( min-width: 768px ) {
			.hero__inner {
				background-image:url('<?php echo esc_url( $hero_background_image ); ?>');
			}
		}
	</style>
	<?php
}
?>

<div class="info-section__hero">
	<div class="hero__inner">
		<div class="hero__title">
			<?php if ( ! is_page_template( 'page-templates/full-width-hero.php' ) ) { ?>
				<h1>
					<?php echo wp_kses_post( strip_tags( $hero_title, '<span>' ) ); ?>
				</h1>
				<h2>
					<?php echo wp_kses_post( strip_tags( $hero_sub_title, '<span>' ) ); ?>
				</h2>
				<div class="hero__title--caption">
					<strong>
						<?php echo esc_html( $hero_student_name ); ?>
					</strong>
					<em>
						<?php echo esc_html( $hero_student_title ); ?>
					</em>
				</div>
			<?php } else { ?>
				<h1>
					<?php echo wp_kses_post( strip_tags( $hero_title, '<span>' ) ); ?>
				</h1>
				<a href="#form" class="button button--yellow">Apply Now</a>
			<?php } ?>
		</div>
	</div>
</div>

