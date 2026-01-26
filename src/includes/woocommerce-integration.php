<?php

/**
 * WooCommerce Integration File
 * 
 * This file contains custom WooCommerce functionality including:
 * - Subscription product handling
 * - Video content management
 * - Custom hooks and filters
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom meta fields for video learning products
 */
function register_video_learning_meta() {
	register_meta( 'post', '_video_learning_content', array(
		'type'              => 'string',
		'sanitize_callback' => 'wp_kses_post',
		'show_in_rest'      => true,
		'single'            => true,
	) );

	register_meta( 'post', '_video_duration', array(
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_text_field',
		'show_in_rest'      => true,
		'single'            => true,
	) );

	register_meta( 'post', '_video_level', array(
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_text_field',
		'show_in_rest'      => true,
		'single'            => true,
	) );
}
add_action( 'init', 'register_video_learning_meta' );

/**
 * Add custom fields to subscription products in WP-Admin
 */
function add_video_learning_fields() {
	add_meta_box(
		'video_learning_content',
		'Video Learning Content',
		'render_video_learning_meta_box',
		'product',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'add_video_learning_fields' );

/**
 * Render the video learning meta box
 */
function render_video_learning_meta_box( $post ) {
	wp_nonce_field( 'video_learning_nonce', 'video_learning_nonce' );

	$video_content = get_post_meta( $post->ID, '_video_learning_content', true );
	$video_duration = get_post_meta( $post->ID, '_video_duration', true );
	$video_level = get_post_meta( $post->ID, '_video_level', true );

	echo '<div class="video-learning-meta-box">';
	echo '<div class="meta-field">';
	echo '<label for="video_learning_content"><strong>Video Embed Code or URL:</strong></label>';
	wp_editor( $video_content, 'video_learning_content', array(
		'media_buttons' => true,
		'textarea_rows' => 10,
	) );
	echo '</div>';

	echo '<div class="meta-field">';
	echo '<label for="video_duration"><strong>Video Duration (e.g., 45 minutes):</strong></label>';
	echo '<input type="text" id="video_duration" name="video_duration" value="' . esc_attr( $video_duration ) . '" />';
	echo '</div>';

	echo '<div class="meta-field">';
	echo '<label for="video_level"><strong>Course Level:</strong></label>';
	echo '<select id="video_level" name="video_level">';
	echo '<option value="">Select Level</option>';
	echo '<option value="beginner" ' . selected( $video_level, 'beginner' ) . '>Beginner</option>';
	echo '<option value="intermediate" ' . selected( $video_level, 'intermediate' ) . '>Intermediate</option>';
	echo '<option value="advanced" ' . selected( $video_level, 'advanced' ) . '>Advanced</option>';
	echo '</select>';
	echo '</div>';
	echo '</div>';
}

/**
 * Save video learning meta data
 */
function save_video_learning_meta( $post_id ) {
	if ( ! isset( $_POST['video_learning_nonce'] ) || 
		 ! wp_verify_nonce( $_POST['video_learning_nonce'], 'video_learning_nonce' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Save video content
	if ( isset( $_POST['video_learning_content'] ) ) {
		update_post_meta( $post_id, '_video_learning_content', wp_kses_post( $_POST['video_learning_content'] ) );
	}

	// Save video duration
	if ( isset( $_POST['video_duration'] ) ) {
		update_post_meta( $post_id, '_video_duration', sanitize_text_field( $_POST['video_duration'] ) );
	}

	// Save video level
	if ( isset( $_POST['video_level'] ) ) {
		update_post_meta( $post_id, '_video_level', sanitize_text_field( $_POST['video_level'] ) );
	}
}
add_action( 'save_post_product', 'save_video_learning_meta' );

/**
 * Add subscription information to product display
 */
function add_subscription_badge_to_product( $product ) {
	if ( $product && 'subscription' === $product->get_type() ) {
		$billing_period = $product->get_meta( '_subscription_period' );
		$billing_interval = $product->get_meta( '_subscription_interval' );

		$interval_text = ( 1 == $billing_interval ) ? $billing_period : $billing_interval . ' ' . $billing_period . 's';

		echo '<div class="subscription-badge-wrapper">';
		echo '<span class="subscription-badge">Subscription - Renews every ' . esc_html( $interval_text ) . '</span>';
		echo '</div>';
	}
}
add_action( 'woocommerce_product_meta_start', 'add_subscription_badge_to_product' );

/**
 * Customize subscription order emails
 */
function customize_subscription_email_content( $order ) {
	if ( function_exists( 'wcs_order_contains_subscription' ) && wcs_order_contains_subscription( $order->get_id() ) ) {
		// Add custom message for subscription orders
		echo '<p><strong>Your subscription is now active!</strong></p>';
		echo '<p>You now have full access to all video learning content. Check your account to get started.</p>';
	}
}
add_action( 'woocommerce_thankyou', 'customize_subscription_email_content' );

/**
 * Add subscription notice on checkout page
 */
function add_subscription_checkout_notice() {
	if ( is_checkout() ) {
		$cart = WC()->cart->get_cart();
		$has_subscription = false;

		foreach ( $cart as $cart_item ) {
			$product = $cart_item['data'];
			if ( $product && 'subscription' === $product->get_type() ) {
				$has_subscription = true;
				break;
			}
		}

		if ( $has_subscription ) {
			wc_print_notice(
				'This purchase contains one or more subscriptions. Your subscription will automatically renew at the regular price. You can cancel your subscription anytime from your account.',
				'notice'
			);
		}
	}
}
add_action( 'woocommerce_before_checkout_form', 'add_subscription_checkout_notice' );

/**
 * Grant video access on subscription activation
 */
function grant_video_access_on_subscription( $subscription ) {
	if ( ! class_exists( 'WC_Subscription' ) ) {
		return;
	}

	$customer_id = $subscription->get_customer_id();
	$items = $subscription->get_items();

	foreach ( $items as $item ) {
		$product_id = $item->get_product_id();

		// Add customer meta indicating they have access
		add_user_meta( $customer_id, 'video_access_product_' . $product_id, true );
		
		// You can also send a welcome email with video access link here
	}
}
add_action( 'woocommerce_subscription_status_active', 'grant_video_access_on_subscription' );

/**
 * Revoke video access on subscription cancellation
 */
function revoke_video_access_on_subscription_cancel( $subscription ) {
	if ( ! class_exists( 'WC_Subscription' ) ) {
		return;
	}

	$customer_id = $subscription->get_customer_id();
	$items = $subscription->get_items();

	foreach ( $items as $item ) {
		$product_id = $item->get_product_id();

		// Remove customer meta access
		delete_user_meta( $customer_id, 'video_access_product_' . $product_id );
	}
}
add_action( 'woocommerce_subscription_status_cancelled', 'revoke_video_access_on_subscription_cancel' );

/**
 * Add video access check function
 * Use this in templates to check if user has access
 */
function user_has_video_access( $product_id, $user_id = false ) {
	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}

	if ( ! $user_id ) {
		return false;
	}

	// Check if user has active subscription for this product
	if ( function_exists( 'wcs_user_has_subscription' ) ) {
		return wcs_user_has_subscription( $user_id, $product_id, 'active' );
	}

	return false;
}

/**
 * Prevent non-subscribers from downloading videos
 */
function check_video_access_before_content() {
	if ( is_singular( 'product' ) ) {
		$product = wc_get_product( get_the_ID() );

		if ( $product && 'subscription' === $product->get_type() ) {
			if ( ! current_user_can( 'manage_options' ) && ! user_has_video_access( get_the_ID() ) ) {
				// User doesn't have access, content will be shown in template with conditional
			}
		}
	}
}
add_action( 'wp_loaded', 'check_video_access_before_content' );
