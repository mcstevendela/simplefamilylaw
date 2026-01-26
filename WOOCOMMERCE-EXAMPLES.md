# WooCommerce Integration - Code Examples & Usage

## Template Examples

### Using Products in Custom Templates

#### Check if on product page
```twig
{% if is_product %}
  <div class="product-page-banner">
    Product Page
  </div>
{% endif %}
```

#### Display product information
```twig
{% set product = fn('wc_get_product', post.ID) %}

{% if product %}
  <h1>{{ product.get_name() }}</h1>
  <p>{{ product.get_description() }}</p>
  <p>{{ product.get_price_html|raw }}</p>
{% endif %}
```

#### Check if subscription product
```twig
{% set product = fn('wc_get_product', post.ID) %}

{% if product.get_type == 'subscription' %}
  <div class="subscription-badge">
    This is a subscription product
  </div>
  
  <p>Renewal: {{ product.get_meta('_subscription_period') }}</p>
{% endif %}
```

#### Add to Cart Button for Subscriptions
```twig
<form class="cart" action="{{ fn('esc_url', fn('wc_get_cart_url')) }}" method="post">
  <button type="submit" name="add-to-cart" value="{{ product.get_id() }}" class="single_add_to_cart_button button alt">
    Subscribe Now
  </button>
</form>
```

### Displaying Video Content
```twig
{% set video_content = post.meta('_video_learning_content') %}

{% if video_content %}
  <div class="video-player">
    {{ video_content|raw }}
  </div>
  
  <div class="video-info">
    Duration: {{ post.meta('_video_duration') }}
    Level: {{ post.meta('_video_level') }}
  </div>
{% endif %}
```

### Product Cart/Checkout Links
```twig
{# Link to cart #}
<a href="{{ context.cart_url }}">View Cart</a>

{# Link to checkout #}
<a href="{{ fn('wc_get_checkout_url') }}">Checkout</a>

{# Link to account #}
<a href="{{ context.account_url }}">My Account</a>
```

## PHP Function Examples

### Check User Subscription Access
```php
<?php
// Check if user has access to video content
if ( user_has_video_access( 42 ) ) {
  echo "User has access to this video";
  // Display video content
}
?>
```

### Grant/Revoke Access Programmatically
```php
<?php
// Grant access
add_user_meta( $user_id, 'video_access_product_42', true );

// Check access
if ( get_user_meta( $user_id, 'video_access_product_42', true ) ) {
  echo "User has access";
}

// Revoke access
delete_user_meta( $user_id, 'video_access_product_42' );
?>
```

### Get Product Information
```php
<?php
$product = wc_get_product( 42 );

// Get basic info
$product->get_name();
$product->get_description();
$product->get_price();
$product->get_price_html();
$product->get_image();

// Get subscription info
$product->get_meta( '_subscription_period' ); // 'month', 'year', etc.
$product->get_meta( '_subscription_interval' ); // 1, 3, 6, etc.
$product->get_meta( '_video_learning_content' );
$product->get_meta( '_video_duration' );
$product->get_meta( '_video_level' );
?>
```

### Subscription Management
```php
<?php
// Get active subscriptions for user
if ( function_exists( 'wcs_get_users_subscriptions' ) ) {
  $subscriptions = wcs_get_users_subscriptions( $user_id, 'active' );
  
  foreach ( $subscriptions as $subscription ) {
    echo "Subscription: " . $subscription->get_id();
    echo "Status: " . $subscription->get_status();
    echo "Next Payment: " . $subscription->get_date( 'next_payment' );
  }
}

// Check if user has specific subscription
if ( function_exists( 'wcs_user_has_subscription' ) ) {
  if ( wcs_user_has_subscription( $user_id, 42, 'active' ) ) {
    echo "User has active subscription to product 42";
  }
}
?>
```

## Hook Examples

### Add Custom Content Before Product Price
```php
<?php
function custom_before_price() {
  echo '<div class="custom-banner">Special offer!</div>';
}
add_action( 'woocommerce_single_product_summary', 'custom_before_price', 9 );
?>
```

### Send Email When Subscription Activates
```php
<?php
function send_welcome_email_on_subscription( $subscription ) {
  $customer_email = $subscription->get_billing_email();
  $subject = "Welcome to Your Subscription!";
  $message = "Your subscription is now active. Check your account to access videos.";
  
  wp_mail( $customer_email, $subject, $message );
}
add_action( 'woocommerce_subscription_status_active', 'send_welcome_email_on_subscription' );
?>
```

### Customize Add to Cart Text
```php
<?php
function custom_add_to_cart_text() {
  return 'Subscribe to Access Videos';
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'custom_add_to_cart_text' );
?>
```

### Add Custom Product Tab
```php
<?php
function add_custom_product_tab( $tabs ) {
  $tabs['video_info'] = array(
    'title'    => 'Video Information',
    'priority' => 50,
    'callback' => 'display_video_info_tab'
  );
  return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'add_custom_product_tab' );

function display_video_info_tab() {
  $product = wc_get_product();
  $duration = $product->get_meta( '_video_duration' );
  $level = $product->get_meta( '_video_level' );
  
  echo "Duration: " . esc_html( $duration );
  echo "Level: " . esc_html( $level );
}
?>
```

## JavaScript Examples

### Update Cart on Quantity Change
```javascript
jQuery(document).ready(function($) {
  $('body').on('change', '.qty', function() {
    $('[name="update-cart"]').trigger('click');
  });
});
```

### Handle Add to Cart Click
```javascript
jQuery(document).ready(function($) {
  $('.add-to-cart-button').on('click', function(e) {
    const $button = $(this);
    const originalText = $button.text();
    
    $button.text('Adding to cart...');
    $button.prop('disabled', true);
    
    // Wait for WooCommerce to process
    setTimeout(function() {
      $button.text(originalText);
      $button.prop('disabled', false);
    }, 2000);
  });
});
```

### Smooth Scroll to Reviews
```javascript
jQuery(document).ready(function($) {
  $('a[href="#reviews"]').on('click', function(e) {
    e.preventDefault();
    
    $('html, body').animate({
      scrollTop: $('#reviews').offset().top - 100
    }, 800);
  });
});
```

## CSS/SCSS Examples

### Styling Subscription Badge
```scss
.subscription-badge {
  display: inline-block;
  background-color: #e8f4f8;
  color: #007bff;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  font-weight: 600;
  margin-bottom: 1rem;
  
  &:hover {
    background-color: #d4e9f2;
  }
}
```

### Styling Subscribe Button
```scss
.single_add_to_cart_button,
.button.product_type_subscription {
  background-color: var(--primary, #007bff);
  color: white;
  padding: 1rem 2rem;
  border-radius: 4px;
  font-weight: 600;
  transition: all 0.3s ease;
  
  &:hover {
    background-color: var(--primary-dark, #0056b3);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
  }
  
  &:disabled {
    background-color: #ccc;
    cursor: not-allowed;
  }
}
```

### Styling Subscription Details Section
```scss
.subscription-details {
  background-color: #f0f7ff;
  border-left: 4px solid #007bff;
  padding: 1.5rem;
  border-radius: 4px;
  margin-top: 2rem;
  
  h2 {
    color: #007bff;
    margin-bottom: 1rem;
  }
  
  ul {
    list-style: none;
    padding: 0;
    
    li {
      padding: 0.5rem 0;
      padding-left: 1.5rem;
      position: relative;
      
      &:before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #007bff;
        font-weight: bold;
      }
    }
  }
}
```

## WooCommerce Hooks Reference

### Product Page Hooks
```php
woocommerce_before_single_product
woocommerce_product_thumbnails
woocommerce_before_single_product_summary
woocommerce_single_product_summary
woocommerce_after_single_product_summary
woocommerce_after_single_product
```

### Shop Page Hooks
```php
woocommerce_before_shop_loop
woocommerce_before_shop_loop_item
woocommerce_shop_loop_item_title
woocommerce_after_shop_loop_item
woocommerce_after_shop_loop_item_title
woocommerce_after_shop_loop
```

### Cart & Checkout Hooks
```php
woocommerce_before_cart
woocommerce_cart_collaterals
woocommerce_after_cart

woocommerce_before_checkout_form
woocommerce_checkout_before_customer_details
woocommerce_checkout_billing
woocommerce_checkout_shipping
woocommerce_checkout_after_customer_details
woocommerce_checkout_before_order_review
woocommerce_checkout_order_review
woocommerce_checkout_after_order_review
woocommerce_after_checkout_form
```

### Subscription Hooks
```php
woocommerce_subscription_status_active
woocommerce_subscription_status_on-hold
woocommerce_subscription_status_cancelled
woocommerce_subscription_status_expired
woocommerce_subscription_status_pending-cancel
```

## Common Customizations

### Change "Subscribe Now" Button Text
```php
<?php
add_filter( 'woocommerce_product_single_add_to_cart_text', function() {
  return 'Enroll Now';
});
?>
```

### Add Custom Field to Checkout
```php
<?php
add_action( 'woocommerce_before_order_notes', function() {
  woocommerce_form_field( 'custom_field', array(
    'type'        => 'text',
    'class'       => array( 'form-row-wide' ),
    'label'       => 'Special Instructions',
    'placeholder' => 'Any special requests?'
  ));
});

add_action( 'woocommerce_checkout_process', function() {
  if ( ! $_POST['post_data'] ) {
    parse_str( $_POST['post_data'], $post_data );
  } else {
    $post_data = $_POST;
  }
  
  if ( empty( $post_data['custom_field'] ) ) {
    wc_add_notice( 'Special instructions are required', 'error' );
  }
});
?>
```

### Modify Product Price Display
```php
<?php
add_filter( 'woocommerce_get_price_html', function( $price, $product ) {
  if ( 'subscription' === $product->get_type() ) {
    $period = $product->get_meta( '_subscription_period' );
    $price .= ' <span class="billing-period">/' . strtolower( $period ) . '</span>';
  }
  return $price;
}, 10, 2 );
?>
```

## Testing Examples

### Test Subscription Creation
```php
<?php
// In your test file or WordPress admin
$product_id = 42;
$product = wc_get_product( $product_id );

// Verify it's a subscription
if ( 'subscription' === $product->get_type() ) {
  echo "✓ Product is a subscription";
} else {
  echo "✗ Product is not a subscription";
}

// Verify video content
if ( $product->get_meta( '_video_learning_content' ) ) {
  echo "✓ Video content exists";
} else {
  echo "✗ No video content found";
}
?>
```

### Test User Access
```php
<?php
$user_id = 42;
$product_id = 10;

if ( user_has_video_access( $product_id, $user_id ) ) {
  echo "✓ User has access";
} else {
  echo "✗ User does not have access";
}
?>
```

## Performance Tips

### Cache Product Data
```php
<?php
$product = wp_cache_get( 'product_' . $product_id );

if ( false === $product ) {
  $product = wc_get_product( $product_id );
  wp_cache_set( 'product_' . $product_id, $product, '', 3600 );
}
?>
```

### Optimize Product Queries
```php
<?php
$args = array(
  'post_type'           => 'product',
  'posts_per_page'      => 12,
  'tax_query'           => array(
    array(
      'taxonomy' => 'product_type',
      'field'    => 'slug',
      'terms'    => 'subscription'
    )
  ),
  'orderby'             => 'date',
  'order'               => 'DESC',
  'no_found_rows'       => true, // Skip pagination count
  'update_post_meta_cache' => false // Skip meta data
);

$products = new WP_Query( $args );
?>
```

---

## Additional Resources

- [WooCommerce Hooks Reference](https://woocommerce.github.io/code-reference/hooks/)
- [WooCommerce Template Guide](https://docs.woocommerce.com/document/template-structure/)
- [Subscription Plugin Documentation](https://docs.woocommerce.com/document/subscriptions/)

