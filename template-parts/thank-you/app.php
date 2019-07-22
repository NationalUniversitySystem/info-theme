<?php
/**
 * Handle the display for the Applite Leadgen form thank you page
 */

if ( ! empty( $degree_url ) ) {
	$link_text = $program;
	$link_url  = 'https://www.nu.edu' . $degree_url;
} else {
	$link_text = 'degree programs';
	$link_url  = 'https://www.nu.edu/program-finder/';
}
?>
<article class="page type-page hentry">
	<div class="entry-title">
		<h1>Thank you, <?php echo esc_html( $first_name . ' ' . $last_name ); ?>.</h1>
	</div>
	<div class="entry-content">
		<h3>Watch our video for a special message from President Andrews.</h3>
		<div class="video-container">
			<div class="responsive-video">
				<iframe width="auto" height="auto" src="https://www.youtube.com/embed/N2iyy2oLRRI?controls=1&loop=1&rel=0&showinfo=0&modestbranding=0&autohide=1" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
		<p>Here's what you can expect next: an admissions advisor will contact you to answer any questions you may have and guide you through the simple admissions process.</p>

		<strong>In the meantime, you can:</strong>

		<ul>
			<li><span>Learn more about National University's <a href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $link_text ); ?></a></span></li>
			<li><span>Connect with us on <a href="https://www.facebook.com/nationaluniversity/">Facebook</a></span></li>
		</ul>
		<p>We look forward to speaking with you!</p>
		<!-- .entry-footer -->
	</div>
</article>
