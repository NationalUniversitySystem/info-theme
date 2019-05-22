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
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'nusa' ); ?></a>

		<header id="masthead" class="site-header" role="banner">
			<div class="container">
				<div class="row">
					<div class="site-header__logo">
						<a href="<?php echo esc_url( network_home_url() ); ?>" rel="home"></a>
					</div>
					<div class="site-header__phone">
						<div data-id="c92fbc7abf" class="livechat_button d-none"><a href="https://www.livechatinc.com/customer-service/?partner=lc_1051665&amp;utm_source=chat_button">Chat Now</a></div>
						<div class="phone__inner">
						<?php if ( $phone_number ) { ?>
							<a href="tel:+1-<?php echo esc_attr( $phone_number ); ?>" class="phone__number">
								<span><?php echo esc_html( $phone_number ); ?></span>
							</a>
							<a href="tel:+1-<?php echo esc_attr( $phone_number ); ?>" class="phone__icon"></a>
						<?php } ?>
						</div>
					</div>
				</div>
			</div><!-- .site-branding -->
		</header><!-- #masthead -->

		<div id="content" class="site-content">
