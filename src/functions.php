<?php

require_once 'includes/index.php';

$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

if ( ! class_exists( 'Timber' ) ) {
	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

Timber::$dirname = array( 'templates', 'views' );
Timber::$autoescape = false;

class StarterSite extends Timber\Site {
	public function __construct() {
		add_theme_support( 'post-formats', array( 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio','post-thumbnails' ) );
		add_theme_support( 'title-tag' );
		add_theme_support( 'menus' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'widgets' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'editor-styles' ) );
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'timber_context', array( $this, 'global_info' ) );
		add_filter( 'timber_context', array( $this, 'areas' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_filter( 'screen_options_show_screen', '__return_true' );
		parent::__construct();
	}

	public function register_post_types() {
	}

	public function register_taxonomies() {
	}

	public function areas( $context ) {
		$context['areas'] = get_posts( 'areas' );
		return $context;
	}

	public function global_info( $context ) {
		$context['global'] = get_fields( 'option' );
		$context['header'] = get_fields( 'option' );
		$context['footer'] = get_fields( 'option' );
		return $context;
	}

	public function add_to_context( $context ) {
		$context['primary'] = get_field( 'global.color_scheme.colors[0].color.color_value' );
		$context['global'] = get_field( 'global', 'options' );
		$context['topbar'] = get_field( 'topbar', 'options' );
		$context['header'] = get_field( 'header', 'options' );
		$context['company_info'] = get_field( 'company_info', 'options' );
		$context['footer'] = get_field( 'footer', 'options' );
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu'] = new Timber\Menu( 'Main menu' );
		$context['site'] = $this;

		$current_post_id = get_the_ID();
		if ( ! $current_post_id ) {
			$current_post_id = get_queried_object_id();
		}

		$context['current_post_id'] = $current_post_id;
		$context['user_logged_in'] = is_user_logged_in();
		$context['logout_url'] = wp_logout_url();

		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();
			$member = pms_get_member( $user_id );
			$context['membership_plan'] = $member->subscriptions[0]['subscription_plan_id'] ?? '';
			$context['membership_status'] = $member->subscriptions[0]['status'] ?? '';
		}

		return $context;
	}

	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		$twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		$twig->addFunction( new Twig\TwigFunction( 'get_permalink', function( $post ) {
			return get_permalink( $post );
		} ) );
		return $twig;
	}
}

new StarterSite();

remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
add_filter( 'emoji_svg_url', '__return_false' );

function rd_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'rd_disable_emojis_tinymce' );
}
add_action( 'init', 'rd_disable_emojis' );

function rd_disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

function rd_enable_svg_upload( $upload_mimes ) {
	$upload_mimes['svg'] = 'image/svg+xml';
	$upload_mimes['svgz'] = 'image/svg+xml';
	return $upload_mimes;
}
add_filter( 'upload_mimes', 'rd_enable_svg_upload', 10, 1 );

add_filter( 'set-screen-option', 'rd_myFilterScreenOption', 11, 3 );
function rd_myFilterScreenOption( $keep, $option, $value ) {
	if ( $option === 'myitem_per_page' ) {
		if ( $value < 0 ) {
			$value = 0;
		} elseif ( $value > 100 ) {
			$value = 100;
		}
	}
	return $value;
}

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page( array(
		'page_title' => 'Global',
		'menu_title' => 'Global settings',
		'menu_slug' => 'global-settings',
		'icon_url' => 'dashicons-admin-generic',
		'capability' => 'edit_posts',
		'redirect' => false
	) );
}

function rd_acf_wysiwyg_remove_wpautop() {
	remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'the_content', 'wptexturize' );
}
add_action( 'acf/init', 'rd_acf_wysiwyg_remove_wpautop' );

add_filter( 'jpeg_quality', function( $arg ) {
	return 100;
} );

function rd_theme_custom_scripts() {
	wp_enqueue_script( 'main-scripts', get_template_directory_uri() . '/js/bundle.js', array( 'jquery' ), '1.1.2', true );
}
add_action( 'wp_enqueue_scripts', 'rd_theme_custom_scripts' );

function rd_my_login_stylesheet() {
	wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/css/bundle.css' );
}
add_action( 'login_enqueue_scripts', 'rd_my_login_stylesheet' );

add_filter( 'login_headerurl', 'rd_codecanal_loginlogo_url' );
function rd_codecanal_loginlogo_url( $url ) {
	return home_url();
}

function rd_enqueuing_editor_styling() {
	wp_enqueue_style( 'gutenberg-styles', get_template_directory_uri() . '/css/bundle.css' );
}
add_action( 'enqueue_block_assets', 'rd_enqueuing_editor_styling' );

function rd_blocks( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'rd-blocks',
				'title' => __( 'Rotate Digital Blocks' ),
			),
		)
	);
}
add_filter( 'block_categories_all', 'rd_blocks', 10, 2 );

function rd_block_acf_init() {
	$blocks = require( __DIR__ . '/blocks.php' );
	foreach ( $blocks as $block ) {
		acf_register_block( $block );
	}
}
add_action( 'acf/init', 'rd_block_acf_init' );

function rd_my_acf_block_render_callback( $block, $innerblock, $content = '', $is_preview = false ) {
	$context = Timber::context();

	$context['block'] = $block;
	$context['fields'] = get_fields();

	$context['is_preview'] = $is_preview;
	Timber::render( 'templates/blocks/' . str_replace( 'acf/', '', strtolower( $block['name'] ) ) . '.twig', $context );
}

add_action( 'admin_init', 'rd_my_remove_admin_menus' );
function rd_my_remove_admin_menus() {
	remove_menu_page( 'edit-comments.php' );
}

add_action( 'admin_menu', 'rd_set_admin_menu_separator' );
function rd_set_admin_menu_separator() {
	$position = 25;
	global $menu;
	$menu[ $position ] = array(
		0 => '',
		1 => 'read',
		2 => 'separator' . $position,
		3 => '',
		4 => 'wp-menu-separator'
	);
}

function rd_redirect_to_login_if_not_logged_in() {
	if ( ! is_user_logged_in() && ( is_page( 1684 ) || is_singular( 'documents' ) ) ) {
		wp_redirect( '/my-account/' );
		exit;
	} elseif ( is_user_logged_in() && ( is_page( 1684 ) || is_singular( 'documents' ) ) ) {
		$user_id = get_current_user_id();
		$member = pms_get_member( $user_id );
		$subscription_status = pms_get_member_subscription( $member->subscriptions[0]['id'] );

		if ( $subscription_status->status != 'active' ) {
			wp_redirect( '/update-payment/' );
			exit;
		}
	}
}
add_action( 'template_redirect', 'rd_redirect_to_login_if_not_logged_in' );

add_action( 'admin_head', 'rd_remove_annoying_notification' );
function rd_remove_annoying_notification() {
	echo '<style>
		.notice.notice-error.is-dismissible {
			display: none !important;
		}
	</style>';
}

/**
 * Remove /services/ from the services post type URL structure
 */
function rd_remove_services_slug() {
    // Add rewrite rule to handle service posts without /services/ prefix
    add_rewrite_rule(
        '^([^/]+)/?$',
        'index.php?services=$matches[1]&post_type=services',
        'bottom' // Changed to bottom priority
    );
}
add_action( 'init', 'rd_remove_services_slug' );

/**
 * Filter the permalink for services post type
 */
function rd_services_post_link( $post_link, $post ) {
	if ( $post->post_type === 'services' ) {
		return home_url( '/' . $post->post_name . '/' );
	}
	return $post_link;
}
add_filter( 'post_type_link', 'rd_services_post_link', 10, 2 );

/**
 * Prevent conflicts - only load services if they exist
 */
function rd_services_parse_request( $wp ) {
	// Check if this might be a services request
	if ( array_key_exists( 'services', $wp->query_vars ) ) {
		$slug = $wp->query_vars['services'];

		// Check if a service post exists with this slug
		$service = get_page_by_path( $slug, OBJECT, 'services' );

		if ( ! $service ) {
			// No service found, let WordPress handle it normally (could be a page/post)
			unset( $wp->query_vars['services'] );
			unset( $wp->query_vars['post_type'] );
		}
	}
}
add_action( 'parse_request', 'rd_services_parse_request' );

/**
 * Force login before accessing cart and checkout pages
 */
function rd_force_login_before_cart_and_checkout() {
	if ( is_admin() ) {
		return;
	}

	if (
		function_exists( 'is_cart' ) &&
		function_exists( 'is_checkout' ) &&
		( is_cart() || ( is_checkout() && ! is_wc_endpoint_url( 'order-received' ) ) ) &&
		! is_user_logged_in()
	) {
		$target = is_cart() ? wc_get_cart_url() : wc_get_checkout_url();
		$myaccount = wc_get_page_permalink( 'myaccount' );

		wp_safe_redirect( add_query_arg( 'redirect_to', rawurlencode( $target ), $myaccount ) );
		exit;
	}
}
add_action( 'template_redirect', 'rd_force_login_before_cart_and_checkout' );

/**
 * Redirect to a custom page after payment confirmation
 */
function rd_redirect_after_payment_confirmation() {
	// Only run on WooCommerce order-received page
	if ( ! function_exists( 'is_wc_endpoint_url' ) || ! is_wc_endpoint_url( 'order-received' ) ) {
		return;
	}

	// Require order key in URL
	if ( empty( $_GET['key'] ) ) {
		return;
	}

	// Get order ID from order key
	$order_id = wc_get_order_id_by_order_key( wc_clean( wp_unslash( $_GET['key'] ) ) );
	$order    = $order_id ? wc_get_order( $order_id ) : false;

	if ( ! $order ) {
		return;
	}

	// Optional: only redirect paid orders
	if ( ! $order->is_paid() ) {
		return;
	}

	// Change this to your target page
	$target_url = home_url( '/thank-you-registration/' );

	wp_safe_redirect( $target_url );
	exit;
}
add_action( 'template_redirect', 'rd_redirect_after_payment_confirmation' );

/**
 * Redirect shop to store page
 */
function rd_redirect_shop_to_store() {
	if ( is_shop() || is_product() ) {
		wp_safe_redirect( home_url( '/store/' ) );
		exit;
	}
}
add_action( 'template_redirect', 'rd_redirect_shop_to_store' );

/**
 * Fix TypeError: count(): Argument #1 must be of type Countable|array, null given
 * Caused by WooCommerce PayPal Payments calling get_the_content() during wp_enqueue_scripts.
 * Timber never calls the_post() / setup_postdata(), so the global $pages array is never
 * populated. get_the_content() depends on $pages, causing count(null) on PHP 8+.
 */
add_action( 'wp_enqueue_scripts', function() {
	global $post, $pages;
	if ( empty( $pages ) ) {
		if ( ! $post instanceof WP_Post ) {
			$queried = get_queried_object();
			if ( $queried instanceof WP_Post ) {
				$post = $queried;
			}
		}
		if ( $post instanceof WP_Post ) {
			setup_postdata( $post );
		}
	}
}, 1 );

// Add a shortcode to display the WooCommerce cart button with item count
add_shortcode( 'woocommerce_cart_button', 'rd_woocommerce_cart_button' );
function rd_woocommerce_cart_button() {
	ob_start();
	$cart_count = WC()->cart->cart_contents_count;
	$cart_url = wc_get_cart_url();
	?>
	<a class="rd-header__cart" href="<?php echo $cart_url; ?>" title="Basket">
		<img src="/wp-content/uploads/2026/01/grocery-store.png" alt="Cart">
		<?php if ( $cart_count > 0 ) { ?>
			<span class="rd-header__cart-count"><?php echo esc_html($cart_count); ?></span>
		<?php } ?>
	</a>
	<?php
	return ob_get_clean();
}
