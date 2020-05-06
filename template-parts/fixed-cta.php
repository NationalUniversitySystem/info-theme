<?php
/**
 * Template for Displaying Fixed CTA on Mobile
 *
 * @package info.*.edu
 */

$phone_number      = get_theme_mod( 'contact_phone_number' );
$page_phone_number = get_post_meta( get_the_ID(), '_page_contact_phone_number', true );
$phone_number      = ! empty( trim( $page_phone_number ) ) ? $page_phone_number : $phone_number;
?>

<div class="d-none" id="fixed-cta">
	<div class="btn-wrap">
		<a href="#page-form" class="button button--yellow">Request Info</a>
	</div>
	<div class="row">
		<div class="col-6">
			<a href="tel:+1-<?php echo esc_attr( $phone_number ); ?>">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/icons/icon-phone.svg" />
			</a>
		</div>
		<div class="col-6">
			<a href="#" id="chat-trigger">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/icons/icon-chat.svg" />
			</a>
		</div>
	</div>
</div>
