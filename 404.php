<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package nusa
 */

get_header();
?>

<div id="content" class="site-content">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="info-section info-section--fluid">
				<div class="container">
					<div class="row">
						<div class="info-section__hero">
							<div class="hero__inner">
								<div class="hero__title">
									<h1>
										<span>404!</span>
									</h1>
									<h2>Looks like you're looking for something that doesn't exist!</h2>
									<a href="#form" class="button button--yellow">Apply Now</a>
								</div>
							</div>
						</div>

					</div>
				</div>
			</section>

			<section class="info-section info-section--content">
				<div class="container">
					<div class="row">
						<div class="dynamic-content">

							<article class="page type-page hentry">
							<div class="entry-content">
								<h2>Enroll in Four-Week Classes at National University</h2>
								<p>As a veteran-founded nonprofit, National University is proud to offer over 100 on-campus and online degree programs with one-month classes, so you can start classes sooner and finish your degree faster.</p>
								<!-- <p>Ready to apply? Start your application below and our admissions team will make your application a priority and get you enrolled faster.</p> -->
							</div>
								<!-- .entry-footer -->
							</article>
							<span id="form"></span>
							<div class="info-section__form">
								<div class="form__inner">
									<!-- <div class="form__intro">Please complete the form below to get started today.</div> -->
									<?php // gravity_form( 'Applite', false, false, false, null, true ); ?>
								</div>
							</div>
						</div>

						<aside class="info-section info-section--widgets">
							<div class="row">
								<div class="widget">
									<h3>Why Choose National University?</h3>
									<ul>
										<li>Four-week classes start monthly</li>
										<li>100+ degrees, certificates, and credentials</li>
										<li>Classes available on campus or online</li>
										<li>Over 20 locations in CA and NV</li>
										<li>Transfer credits anytime</li>
										<li>Financial aid opportunities</li>
										<li>Yellow Ribbon school</li>
										<li>Military tuition discounts</li>
										<li>#1 choice for California teachers</li>
										<li>150,000 alumni worldwide</li>
									</ul>
								</div>

								<div class="widget widget--alt">
									<div class="widget__border">
										<div class="widget__inner">
											<img src="/wp-content/themes/info-theme/images/nonprofit.svg" alt="Non-profits">
											<div class="widget__content">
												<h3>Why "Nonprofit" Matters</h3> As a nonprofit, we're proud to put our students first, reinvesting in quality education, experienced faculty, and dedicated support services.
											</div>
										</div>
									</div>
								</div>
							</div>
						</aside>
					</div>
				</div>
			</section>

		</main>
		<!-- #main -->
	</div>
	<!-- #primary -->

</div>

<?php
get_footer();
