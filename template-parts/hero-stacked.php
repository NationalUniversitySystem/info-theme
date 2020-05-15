<?php
/**
 * Template for Displaying Hero on Stacked Template
 *
 * @package info.*.edu
 */

$page_id = get_the_ID();

$hero_title     = get_post_meta( $page_id, '_headline', true );
$hero_sub_title = get_post_meta( $page_id, '_subheadline', true );
$headings_tags  = [
	'span' => [],
];

$hero_classes = ! is_page_template( 'page-templates/full-width-hero.php' ) ? ' col-lg-8 pr-md-0' : '';
$copy_classes = ! is_page_template( 'page-templates/stacked.php' ) ? ' ml-md-4' : '';


if ( has_post_thumbnail() ) {
	$hero_background_image = get_the_post_thumbnail_url();
	?>
	<style>
		.hero__background {
			background-image:url('<?php echo esc_url( $hero_background_image ); ?>');
		}
	</style>
	<?php
}
?>

<article class="hero col-12<?php echo esc_attr( $hero_classes ); ?>" aria-label="Page hero image and title"><?php // "md" breakpoint styles are in SCSS files since we needed a 6.5 column. ?>
	<div class="hero__background position-relative"></div>
	<div class="hero__copy<?php echo esc_attr( $copy_classes ); ?>">
		<div class="hero__terms-container">
			<?php if ( $hero_title ) { ?>
				<h1><?php echo wp_kses( $hero_title, $headings_tags ); ?></h1>
			<?php } ?>

			<?php if ( is_page_template( 'page-templates/full-width-hero.php' ) ) { ?>
				<a href="#form" class="button button--yellow">Apply Now</a>
			<?php } elseif ( $hero_sub_title ) { ?>
				<h2><?php echo wp_kses( $hero_sub_title, $headings_tags ); ?></h2>
			<?php } ?>
			<?php
			if ( has_post_thumbnail() ) {
				$image_id      = get_post_thumbnail_id();
				$image_caption = get_the_post_thumbnail_caption();
				$image_text    = ! empty( $image_caption ) ? $image_caption : get_post_meta( $image_id, '_wp_attachment_image_alt', true );
				?>
				<div class="hero__caption">
					<?php echo wp_kses_post( $image_text ); ?>
				</div>
				<?php
			}
			?>

			<div class="hero__cta d-none">
				<div class="cta__inner">
					<h3>Don't Delay</h3>
					<p>New classes begin every 30 days!</p>
					<a href="#form-offset" class="button button--yellow">Request Info</a>
				</div>
			</div>
		</div>


	</div>
</article>

