<?php
/**
 * Set up all our theme related hooks the OOP way
 *
 * @package nusa
 */

/**
 * NUSA_Theme_Setup class.
 */
class NUSA_Theme_Setup {
	/**
	 * Instance of this class
	 *
	 * @var boolean
	 */
	public static $instance = false;

	/**
	 * Using construct function to add any actions and filters
	 */
	public function __construct() {
		$this->add_actions();
		$this->add_filters();
		$this->disable_features();
	}

	/**
	 * Add Actions
	 *
	 * Defines all the WordPress actions used by this theme.
	 */
	private function add_actions() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ], 99 );
		add_action( 'script_loader_tag', [ $this, 'do_script_loader_tag' ], 10, 3 );
		add_action( 'wp_head', [ $this, 'add_theme_color' ] );
		add_action( 'wp_head', [ $this, 'preload_fonts' ], 0 );
		add_action( 'init', [ $this, 'add_excerpts' ], 100 );
		add_action( 'send_headers', [ $this, 'security_headers' ], 1 );
	}

	/**
	 * Add Filters
	 *
	 * Defines all the WordPress filters used by this theme.
	 */
	private function add_filters() {
		add_filter( 'body_class', [ $this, 'body_class' ], 10, 2 );
		add_filter( 'post_class', [ $this, 'post_class' ] );
		add_filter( 'get_the_excerpt', [ $this, 'fix_the_excerpt' ] );
		add_filter( 'wp_kses_allowed_html', [ $this, 'allow_data_attributes' ], 10, 2 );
	}

	/**
	 * Disable features we have no use for in our builds and just add bloat to the site.
	 *
	 * @return void
	 */
	private function disable_features() {
		add_action( 'wp_print_styles', [ $this, 'dequeue_block_styles' ], 100 );
		add_action( 'do_feed_rss2_comments', [ $this, 'disable_feeds' ], 1 );
		add_action( 'do_feed_atom_comments', [ $this, 'disable_feeds' ], 1 );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_action( 'wp_head', 'wp_generator' );
	}

	/**
	 * Singleton
	 *
	 * Returns a single instance of this class.
	 */
	public static function singleton() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Enqueue Admin Assets
	 *
	 * Enqueues the necessary css and js files when the WordPress admin is loaded.
	 */
	public function enqueue_admin_assets() {
		wp_enqueue_style( 'nusa', get_template_directory_uri() . '/assets/css/wp-admin.min.css', [], filemtime( get_template_directory() . '/assets/css/wp-admin.min.css' ) );
		wp_enqueue_script( 'nusa', get_template_directory_uri() . '/assets/js/wp-admin.min.js', [ 'jquery', 'media-upload' ], filemtime( get_template_directory() . '/assets/js/wp-admin.min.js' ), true );
	}

	/**
	 * Enqueue Assets
	 *
	 * Enqueues the necessary css and js files when the theme is loaded.
	 */
	public function enqueue_assets() {
		$theme_path = get_template_directory();
		$theme_uri  = get_template_directory_uri();

		// Styles.
		wp_enqueue_style( 'nusa', $theme_uri . '/assets/css/theme.min.css', [], filemtime( $theme_path . '/assets/css/theme.min.css' ) );

		// Scripts.
		$script_dependencies = [
			'jquery',
		];
		if ( wp_script_is( 'polyfill-service', 'registered' ) ) {
			$script_dependencies[] = 'polyfill-service';
		}

		wp_enqueue_script( 'nusa', $theme_uri . '/assets/js/theme.min.js', $script_dependencies, filemtime( $theme_path . '/assets/js/theme.min.js' ), true );
		wp_localize_script( 'nusa', 'InfoAjaxObject', [ 'ajax_url' => admin_url( 'admin-ajax.php' ) ] );
	}

	/**
	 * Do Script Loader Tag
	 * - For organization purposes, this only handles the theme scripts.
	 *   Each plugin should handle their own scripts loading.
	 *
	 * Allows enqueued scripts to be loaded asynchronously, thus preventing the
	 * page from being blocked by js calls.
	 *
	 * @param  string $tag    The <script> tag for the enqueued script.
	 * @param  string $handle The script's registered handle.
	 * @param  string $src    The script's source URL.
	 *
	 * @return string The formatted HTML script tag of the given enqueued script.
	 */
	public function do_script_loader_tag( $tag, $handle, $src ) {
		// Add crossorigin attribute to specific scripts.
		$crossorigin_scripts = [];
		if ( in_array( $handle, $crossorigin_scripts, true ) ) {
			$tag = str_replace( ' src', ' crossorigin="anonymous" src', $tag );
		}

		// The handles of the enqueued scripts we want to async.
		$async_scripts = [];
		if ( in_array( $handle, $async_scripts, true ) ) {
			return str_replace( ' src', ' async="async" src', $tag );
		}

		// The handles of the enqueued scripts we want to defer.
		$defer_scripts = [
			'nusa',
			'wp-embed',
		];
		if ( in_array( $handle, $defer_scripts, true ) ) {
			return str_replace( ' src', ' defer="defer" src', $tag );
		}

		return $tag;
	}

	/**
	 * Disable gutenberg style in Front
	 *
	 * @return void
	 */
	public function dequeue_block_styles() {
		wp_dequeue_style( 'wp-block-library' );
	}

	/**
	 * Disable Feeds
	 *
	 * Disables all WordPress generated feeds.
	 */
	public function disable_feeds() {
		$message = 'No feed available, please visit the <a href="' . esc_url( home_url( '/' ) ) . '">homepage</a>!';
		wp_die( wp_kses_post( $message ) );
	}

	/**
	 * Add theme color option for android browsers
	 *
	 * @return void
	 */
	public function add_theme_color() {
		echo '<meta name="theme-color" content="#000" />' . "\n";
	}

	/**
	 * Preload the URLs for our custom fonts
	 *
	 * @return void
	 */
	public function preload_fonts() {
		?>
		<link rel="preload" as="font" crossorigin="anonymous" href="<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/fontello/fontello.woff2?36463184">
		<link rel="preload" as="font" crossorigin="anonymous" href="<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/open-sans/opensans-bold-webfont.woff2">
		<link rel="preload" as="font" crossorigin="anonymous" href="<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/open-sans/opensans-extrabold-webfont.woff2">
		<link rel="preload" as="font" crossorigin="anonymous" href="<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/open-sans/opensans-light-webfont.woff2">
		<link rel="preload" as="font" crossorigin="anonymous" href="<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/open-sans/opensans-regular-webfont.woff2">
		<link rel="preload" as="font" crossorigin="anonymous" href="<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/open-sans/opensans-semibold-webfont.woff2">
		<link rel="preload" as="font" crossorigin="anonymous" href="<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/oswald/oswald-bold-webfont.woff2">
		<link rel="preload" as="font" crossorigin="anonymous" href="<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/oswald/oswald-heavy-webfont.woff2">
		<link rel="preload" as="font" crossorigin="anonymous" href="<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/oswald/oswald-medium-webfont.woff2">
		<link rel="preload" as="font" crossorigin="anonymous" href="<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/oswald/oswald-regular-webfont.woff2">
		<?php
	}

	/**
	 * Add excerpts to pages
	 *
	 * Self explanatory.
	 */
	public function add_excerpts() {
		add_post_type_support( 'page', 'excerpt' );
	}

	/**
	 * Add Security Headers
	 *
	 * Makes our site super safe
	 */
	public function security_headers() {

		// Enforce the use of HTTPS.
		header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains' );

		// Prevent Clickjacking.
		header( 'X-Frame-Options: SAMEORIGIN' );

		// Prevent XSS Attack
		// Too strict for now.
		// header( 'Content-Security-Policy: default-src "self";' ); // FF 23+ Chrome 25+ Safari 7+ Opera 19+.
		// header( 'Content-Security-Policy: default-src https: "unsafe-eval" "unsafe-inline"; object-src "none";' );
		// header( 'Content-Security-Policy-Report-Only: default-src https:; report-uri /csp-violation-report-endpoint/' );

		// Too strict for now.
		// header( 'X-Content-Security-Policy: default-src "self";' ); // IE 10+.
		// header( 'X-Content-Security-Policy: default-src https: "unsafe-eval" "unsafe-inline"; object-src "none";' ); // IE 10+.

		// Block Access If XSS Attack Is Suspected.
		header( 'X-XSS-Protection: 1; mode=block' );

		// Prevent MIME-Type Sniffing.
		header( 'X-Content-Type-Options: nosniff' );

		// Referrer Policy.
		header( 'Referrer-Policy: no-referrer-when-downgrade' );
	}

	/**
	 * Body Class
	 *
	 * Filters the list of CSS body classes for the current post or page.
	 *
	 * @param array $classes An array of body classes.
	 * @param array $class   An array of additional classes added to the body.
	 */
	public function body_class( $classes = [], $class = [] ) {

		// If page, add hierarchy.
		if ( is_page() ) {
			global $post;

			$ancestors = get_post_ancestors( $post->ID );

			// Add the page itself to beginning of array.
			array_unshift( $ancestors, $post->ID );

			$ancestors = array_reverse( $ancestors );

			if ( ! empty( $ancestors ) ) {
				$page_slug_class = 'page-slug';

				foreach ( $ancestors as $key => $ancestor_id ) {
					$ancestor         = get_post( $ancestor_id );
					$classes[]        = 'pagelevel-' . $key . '-' . $ancestor->post_name; // Hierarchy on a level basis.
					$page_slug_class .= '-' . $ancestor->post_name;
				}

				$classes[] = $page_slug_class;
			}

			if ( class_exists( 'GFAPI' ) ) {
				$gform_id = get_post_meta( $post->ID, 'page_form_id', true );

				if ( ! $gform_id ) {
					$gform_id = get_theme_mod( 'rfi_sidebar_form_id' );
				}

				if ( $gform_id ) {
					$form      = GFAPI::get_form( $gform_id );
					$classes[] = 'page-gf-' . strtolower( str_replace( ' ', '-', $form['title'] ) );
				}
			}
		}

		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['ab-test'] ) ) {
			$classes[] = sanitize_text_field( wp_unslash( $_GET['ab-test'] ) );
		}
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		return $classes;
	}

	/**
	 * Post Class
	 *
	 * Filters the list of CSS classes for the current post.
	 *
	 * @param array $classes An array of post classes.
	 * @param array $class   An array of additional classes added to the post.
	 * @param int   $post_id The post ID.
	 */
	public function post_class( $classes = [], $class = [], $post_id = null ) {

		foreach ( $classes as $key => $value ) {
			if ( strpos( $value, 'post-' ) !== false || strpos( $value, 'status-' ) !== false ) {
				unset( $classes[ $key ] );
			}
		}

		return $classes;
	}

	/**
	 * Fix the excerpt for display.
	 *
	 * @param string $text Actual excerpt text.
	 *
	 * @return string
	 */
	public function fix_the_excerpt( $text ) {
		// Replace the hellip ending.
		$text = str_replace( '[&hellip;]', '...', $text );

		// Smart quotes are messing up.
		$text = html_entity_decode( $text );

		return $text;
	}



	/**
	 * Define extra HTML elements and attributes allowed in the post content.
	 *
	 * @param array  $allowed List of allowed tags and their allowed attributes.
	 * @param string $context Context to judge allowed tags by.
	 *
	 * @return array
	 */
	public function allow_data_attributes( $allowed, $context ) {
		if ( is_array( $context ) ) {
			return $allowed;
		}

		if ( 'post' === $context ) {
			$allowed['div']['data-ytid'] = true;
			$allowed['div']['data-ytId'] = true;
			$allowed['div']['data-bg']   = true;
			$allowed['img']['data-src']  = true;
		}

		return $allowed;
	}

	/**
	 * Set Theme Options
	 *
	 * Configures the necessary WordPress theme options once the theme is activated.
	 */
	public static function set_theme_options() {
		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in various locations.
		register_nav_menus( [
			'primary-footer' => __( 'Main Footer', 'nusa' ),
		] );

		/**
		 * Switch default core markup for search form, gallery, and caption to output valid HTML5.
		 */
		add_theme_support( 'html5', [
			'search-form',
			'gallery',
			'caption',
		] );

		// Allow WordPress to generate the title tag dynamically.
		add_theme_support( 'title-tag' );

		// Add theme support for Custom Logo.
		add_theme_support( 'custom-logo' );
	}
}
