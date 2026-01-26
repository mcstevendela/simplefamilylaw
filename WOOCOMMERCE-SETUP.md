# WooCommerce Subscription Setup Guide

This guide explains the basic WooCommerce structure for selling video learning subscriptions.

## File Structure

### Templates (`src/templates/woocommerce/`)
- **archive-product.twig** - Shop/product listing page
- **single-product.twig** - Individual product detail page with video content section
- **cart.twig** - Shopping cart page
- **checkout.twig** - Checkout page with subscription details
- **myaccount.twig** - User account page with subscription management
- **subscription-product.twig** - Reusable subscription product component

### Styling (`src/scss/components/woocommerce.scss`)
- Product archive/shop styling
- Single product page styling
- Cart and checkout styling
- Account page styling
- Subscription-specific styling

### Functions (`src/functions.php`)
- WooCommerce theme support registration
- Custom Timber context filters for product data
- Subscription metadata handling

## Key Features

### 1. **Product Archive Page** (`archive-product.twig`)
Displays all products in a responsive grid with:
- Product images
- Product titles
- Pricing information
- Subscription period display
- Add to cart button

### 2. **Single Product Page** (`single-product.twig`)
Features:
- Product gallery
- Product summary
- Video learning content section
- Subscription details with features list
- Price and subscription renewal information

### 3. **Subscription Details Section**
Located on single product pages, displays:
- Access to all video lessons
- Unlimited streaming
- Offline download capability
- Lifetime content access
- Cancel anytime policy

### 4. **Cart & Checkout**
- Standard WooCommerce cart
- Subscription renewal terms displayed
- Secure checkout process

### 5. **My Account**
Includes:
- User account management
- Subscription list and management
- Order history
- Billing and shipping information

## Setup Steps

### 1. Install Required Plugins
```
- WooCommerce (main plugin)
- WooCommerce Subscriptions (premium plugin)
```

### 2. Configure Products
1. Create a new product
2. Set product type to "Subscription"
3. Set subscription period (daily, weekly, monthly, yearly)
4. Set billing interval
5. Add product image and description
6. Add video content via custom field `_video_learning_content`

### 3. Enable WooCommerce Pages
1. Create pages for:
   - Shop (set in WooCommerce settings)
   - Cart
   - Checkout
   - My Account

2. Assign Twig templates in page settings

### 4. Customize Styling
Edit `src/scss/components/woocommerce.scss` to match your brand colors and design system.

## Template Tags and Hooks

### Available Timber Functions
- `is_product` - Check if on product page
- `is_product_taxonomy` - Check if on category/tag page
- `post.link` - Product URL
- `post.thumbnail` - Product image
- `fn('wc_get_product', post.ID)` - Get WooCommerce product object

### WooCommerce Hooks Used
- `woocommerce_before_main_content`
- `woocommerce_archive_description`
- `woocommerce_before_shop_loop`
- `woocommerce_after_shop_loop`
- `woocommerce_before_single_product`
- `woocommerce_single_product_summary`
- `woocommerce_after_single_product`

## Video Content Integration

To add video content to products:

1. Create a custom ACF field for video embedding
2. Store video embed code in `_video_learning_content` meta
3. Display in template using:
   ```twig
   {% set video_content = post.meta('_video_learning_content') %}
   {{ video_content }}
   ```

## Subscription Lifecycle

### Customer Flow
1. Browse video subscription products
2. View product details and video preview
3. Add subscription to cart
4. Proceed to checkout
5. Enter billing information
6. Complete purchase
7. Access video library in My Account
8. Manage subscription (pause, cancel) from account page

### Automatic Renewals
- Subscriptions auto-renew based on billing period
- Customers receive renewal reminders
- Payment method required for auto-renewal
- Customers can cancel anytime from account

## Customization Tips

### Change Primary Colors
Update CSS variables in your theme:
```css
--primary: #007bff;
--primary-dark: #0056b3;
```

### Customize Button Text
Edit button labels in TWIG templates:
```twig
<button>{{ 'Subscribe Now' }}</button>
```

### Add More Subscription Features
Add features to `subscription-details` section in `single-product.twig`

## WooCommerce Settings Checklist

- [ ] Install WooCommerce plugin
- [ ] Install WooCommerce Subscriptions plugin
- [ ] Configure general settings (currency, tax)
- [ ] Set up payment gateway (Stripe, PayPal, etc.)
- [ ] Create shop page
- [ ] Create cart page
- [ ] Create checkout page
- [ ] Create my account page
- [ ] Configure email notifications
- [ ] Set up SSL certificate (required for payments)
- [ ] Test subscription purchases

## Troubleshooting

### Products Not Displaying
- Check that WooCommerce pages are properly created
- Verify Timber is properly configured
- Check browser console for JavaScript errors

### Subscription Features Missing
- Ensure WooCommerce Subscriptions plugin is active
- Check plugin version compatibility
- Verify product is set to "Subscription" type

### Styling Issues
- Ensure SCSS is compiled to CSS
- Check that bundle.scss imports woocommerce.scss
- Clear browser cache

## Additional Resources

- [WooCommerce Documentation](https://docs.woocommerce.com/)
- [WooCommerce Subscriptions](https://woocommerce.com/products/woocommerce-subscriptions/)
- [Timber Documentation](https://timber.github.io/docs/)
- [Theme Customization Guide](./THEME-CUSTOMIZATION.md)

