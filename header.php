<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package nusa
 */

$phone_number      = get_theme_mod( 'contact_phone_number' );
$page_phone_number = get_post_meta( get_the_ID(), '_page_contact_phone_number', true );
$phone_number      = ! empty( trim( $page_phone_number ) ) ? $page_phone_number : $phone_number;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<?php do_action( 'head_begin_hook' ); ?>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'nusa' ); ?></a>

	<header class="header py-4" role="banner">
		<!-- <div class="site-header__value-props">
			<div class="container">
				<span>4-Week Classes</span> <span>On Campus or Online</span> <span>WSCUC Accredited</span>
			</div>
		</div> -->
		<div class="container">
			<div class="row">
				<div class="header__logo col-8">
					<a class="d-block" href="<?php echo esc_url( network_home_url() ); ?>" rel="home"></a>
				</div>

				<?php if ( $phone_number ) { ?>
				<div class="header__contact col-4 d-flex align-items-center justify-content-end">
					<a href="tel:+1-<?php echo esc_attr( $phone_number ); ?>" class="phone__number d-none d-md-block pr-5"><?php echo esc_html( $phone_number ); ?></a>
					<a href="tel:+1-<?php echo esc_attr( $phone_number ); ?>" class="phone__icon"></a>
				</div>
				<?php } ?>
			</div>
		</div><!-- .container -->
	</header>

	<?php
	if ( is_page_template( 'page-templates/terms.php' ) ) {
		get_template_part( 'template-parts/fixed-cta-terms' );
	}
	?>
