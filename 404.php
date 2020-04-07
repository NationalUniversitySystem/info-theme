<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package nusa
 */

get_header();
?>

<main id="main" class="site-main">
	<section class="section section--fluid">
		<div class="container">
			<div class="row">
				<div class="hero hero--404 col-12 col-md-12">
					<div class="hero__copy py-4 py-md-0 px-8">
						<h1><span>404!</span></h1>
						<h2>Looks like you're looking for something that doesn't exist!</h2>
						<a href="#form" class="button button--yellow">Apply Now</a>
					</div>
				</div>

			</div>
		</div>
	</section>

	<section class="section section--content py-6">
		<div class="container">
			<div class="row">
				<div class="dynamic-content col-12 col-lg-8 mb-8">
					<article class="page type-page hentry">
						<div class="entry-content">
							<h2>Enroll in Four-Week Classes at National University</h2>
							<p>As a veteran-founded nonprofit, National University is proud to offer over 100 on-campus and online degree programs with one-month classes, so you can start classes sooner and finish your degree faster.</p>
						</div>
					</article>
				</div>

				<aside class="section section--widgets col-12 col-lg-4">
					<div class="row">
						<div class="widget col-12 mb-5">
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

						<div class="widget widget--alt col-12 p-5 d-md-flex flex-lg-wrap align-items-md-center align-content-lg-center">
							<img class="icon" src="/wp-content/themes/info-theme/images/nonprofit.svg" alt="Non-profits">
							<div class="widget__content">
								<h3>Why "Nonprofit" Matters</h3> As a nonprofit, we're proud to put our students first, reinvesting in quality education, experienced faculty, and dedicated support services.
							</div>
						</div>
					</div>
				</aside>
			</div>
		</div>
	</section>
</main><!-- #main -->

<?php
get_footer();
