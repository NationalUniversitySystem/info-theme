<?php
/**
 * Template for Displaying Form
 *
 * @package info.*.edu
 */

global $wp_query;
?>
<div class="info-section__form">
	<div class="form__inner">
		<?php
		if ( is_page_template( 'page-templates/split-50.php' ) || isset( $wp_query->query_vars['outreach'] ) ) {
			?>
			<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/nu-seal.svg' ); ?>" class="form__logo"/>
			<h3>Connect with us</h3>
			<p>Please complete the form below, and an admissions advisor will contact you soon.</p>
			<?php
		} else {
			echo '<div class="form__intro">' . wp_kses_post( $form_intro_text ) . '</div>';
		}

		if ( function_exists( 'gravity_form' ) ) {
			if ( isset( $wp_query->query_vars['outreach'] ) ) {
				$ipad_user = ! empty( $wp_query->query_vars['outreach'] ) ? $wp_query->query_vars['outreach'] : '1';

				$outreach_values = array(
					'utm_content_outreach' => 'ipad' . $ipad_user,
					'utm_source_outreach'  => 'ipad',
					'form_id'              => site_url() . '/nu-outreach',
				);

				gravity_form( 'Outreach', false, false, false, $outreach_values, true );
			} else {
				gravity_form( $gform_id, false, false, false, null, true );
			}
		}

		if ( is_page_template( 'page-templates/split-50.php' ) || isset( $wp_query->query_vars['outreach'] ) ) {
			?>
			<div class="split__copyright">
				<p><?php printf( '&copy; Copyright %s %s. All Rights Reserved.', esc_html( date( 'Y' ) ), esc_html( get_bloginfo( 'name' ) ) ); ?></p>
			</div>
			<?php
		}
		?>
	</div>
</div>
