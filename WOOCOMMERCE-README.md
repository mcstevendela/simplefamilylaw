# Video Learning Subscription Store - WooCommerce Setup

This WordPress theme includes a complete WooCommerce integration for selling video learning subscriptions.

## Quick Start

### 1. Install Required Plugins
```
WordPress Admin > Plugins > Add New
- Search "WooCommerce" and install
- Search "WooCommerce Subscriptions" and install
- Activate both plugins
```

### 2. Configure WooCommerce
1. Go to **WooCommerce > Settings**
2. Configure:
   - **General**: Currency, Store Address
   - **Products**: Default product settings
   - **Payments**: Add your payment gateway (Stripe, PayPal, etc.)
   - **Emails**: Email notification settings

### 3. Create Required Pages
Create these pages in WordPress (Pages > Add New):
- **Shop** - Product listing (assign in WooCommerce > Settings > Products)
- **Cart** - Shopping cart page
- **Checkout** - Payment/checkout page
- **My Account** - User account and subscription management

### 4. Create Your First Subscription Product
1. Go to **Products > Add New**
2. Fill in product details:
   - **Product name**: "Learn Family Law - Monthly Subscription"
   - **Product type**: Select "Subscription"
   - **Price**: Set your subscription price
   - **Subscription settings**:
     - Billing cycle: Monthly, Yearly, etc.
     - Billing interval: 1
   - **Product image**: Add a course thumbnail
   - **Description**: Course description
   - **Video Learning Content**: Add your video embed code or URL
   - **Video Duration**: "2 hours" (example)
   - **Course Level**: "Beginner"

### 5. Customize Styling
Edit `src/scss/components/woocommerce.scss` to match your brand

## Project Structure

```
simplefamilylaw/
├── src/
│   ├── includes/
│   │   └── woocommerce-integration.php    # Custom WooCommerce functions
│   ├── scss/
│   │   └── components/
│   │       └── woocommerce.scss           # WooCommerce styles
│   └── templates/
│       └── woocommerce/
│           ├── archive-product.twig       # Product listing
│           ├── single-product.twig        # Single product page
│           ├── cart.twig                  # Shopping cart
│           ├── checkout.twig              # Checkout page
│           ├── myaccount.twig             # Account page
│           └── subscription-product.twig  # Subscription component
├── WOOCOMMERCE-SETUP.md                   # Detailed setup guide
└── README.md                              # This file
```

## Features

### ✅ Product Management
- Create subscription products
- Set billing cycles (daily, weekly, monthly, yearly)
- Add product images and descriptions
- Embed video content directly

### ✅ Video Learning Integration
- Embed video from YouTube, Vimeo, or custom player
- Track video duration
- Set course difficulty levels
- Display course features and benefits

### ✅ Subscription Management
- Automatic recurring billing
- Customer can manage subscriptions
- Cancel anytime policy
- Renewal reminders via email

### ✅ Customer Portal
- View active subscriptions
- Manage billing information
- Download video access information
- View order history

### ✅ Admin Features
- Manage subscriptions from WordPress admin
- View customer subscription status
- Handle refunds and cancellations
- Email customization

## Template Files

### `archive-product.twig`
Displays product listing in grid format
- Responsive columns (1-3)
- Product image, title, price
- Subscription renewal info
- Add to cart button

### `single-product.twig`
Single product page with:
- Product gallery
- Product details
- Subscription information
- Video learning content section
- Subscription benefits list
- Add to cart button

### `cart.twig`
Shopping cart page showing:
- Cart items table
- Quantities and prices
- Cart totals
- Coupon code field
- Checkout button

### `checkout.twig`
Checkout/payment page with:
- Billing information form
- Shipping information
- Order review
- Payment form
- Subscription terms notice

### `myaccount.twig`
User account page with:
- Navigation menu
- Account details
- Order history
- Active subscriptions
- Billing address

## Adding Video Content

### Method 1: YouTube/Vimeo Embed
1. Get embed code from YouTube or Vimeo
2. Go to product > Video Learning Content meta box
3. Paste embed code in WYSIWYG editor
4. Save product

### Method 2: Self-Hosted Video
1. Upload video to media library
2. Use WordPress video shortcode:
   ```
   [video src="url-to-video.mp4"]
   ```
3. Paste in Video Learning Content field

### Method 3: Custom Video Player
Add HTML/video tag code in meta box:
```html
<video width="100%" controls>
  <source src="video-url.mp4" type="video/mp4">
</video>
```

## Customization

### Change Button Colors
Edit in `src/scss/components/woocommerce.scss`:
```scss
.button,
button[type="submit"] {
  background-color: #YOUR_COLOR;
}
```

### Add Custom Product Fields
Edit `src/includes/woocommerce-integration.php` and add new meta boxes in `add_video_learning_fields()` function

### Modify Product Layout
Edit `src/templates/woocommerce/single-product.twig` to reorganize sections

### Add Newsletter Signup
Add signup form in checkout:
```twig
<div class="newsletter-signup">
  {# Your signup form #}
</div>
```

## Hooks and Filters

### Custom Functions Available

#### `user_has_video_access( $product_id, $user_id )`
Check if user has subscription access:
```php
if ( user_has_video_access( 42 ) ) {
  // User has access to product ID 42
}
```

#### Available Hooks
- `woocommerce_before_main_content`
- `woocommerce_after_main_content`
- `woocommerce_single_product_summary`
- `woocommerce_subscription_status_active`
- `woocommerce_subscription_status_cancelled`

## Testing

### Test Subscription Flow
1. Create a test product with subscription
2. Use test payment card:
   - **Card Number**: 4242 4242 4242 4242
   - **Expiry**: Any future date
   - **CVC**: Any 3 digits
3. Complete purchase
4. Check customer account for subscription

### Verify Video Access
1. Login as customer with active subscription
2. Visit product page - video should display
3. Visit My Account - subscription should be listed
4. Cancel subscription - access should be revoked

## Troubleshooting

### Products Not Displaying
- Check WooCommerce is activated
- Verify shop page is created and assigned
- Check browser console for errors

### Checkout Not Working
- Verify payment gateway is configured
- Check SSL certificate is installed
- Test with admin account first

### Subscription Not Renewing
- Check WooCommerce Subscriptions is active
- Verify billing dates in subscription settings
- Check server cron jobs are running

### Videos Not Playing
- Verify embed code is correct
- Check HTTPS/SSL for external videos
- Test with different video source

### Styling Issues
- Ensure SCSS is compiled to CSS
- Clear browser cache
- Check CSS file is loaded in page source

## Payment Gateway Setup

### Stripe Setup
1. Go to WooCommerce > Settings > Payments
2. Click **Stripe**
3. Enable Stripe
4. Add Stripe keys (get from Stripe dashboard)
5. Save settings

### PayPal Setup
1. Go to WooCommerce > Settings > Payments
2. Click **PayPal Standard**
3. Enable PayPal
4. Add PayPal email
5. Save settings

## Email Notifications

Configure automated emails in **WooCommerce > Settings > Emails**:
- New Order
- Processing Order
- Completed Order
- Failed Order
- New Subscription
- Subscription Renewal
- Subscription Cancelled

## Security Checklist

- [ ] SSL certificate installed (https://)
- [ ] Payment gateway configured
- [ ] Privacy policy updated
- [ ] Terms and conditions set
- [ ] Admin password is strong
- [ ] Regular backups configured
- [ ] WooCommerce plugins updated

## Performance Tips

1. **Optimize Product Images**
   - Compress images before uploading
   - Use WebP format when possible

2. **Cache Settings**
   - Install WP Super Cache or similar
   - Configure WooCommerce caching

3. **Database Optimization**
   - Use WP-Optimize plugin
   - Regular cleanups

4. **CDN Integration**
   - Use Cloudflare or similar
   - Serve static assets globally

## Support & Resources

- [WooCommerce Docs](https://docs.woocommerce.com/)
- [WooCommerce Subscriptions Plugin](https://woocommerce.com/products/woocommerce-subscriptions/)
- [WordPress Support Forum](https://wordpress.org/support/)
- [Timber Documentation](https://timber.github.io/docs/)

## Next Steps

1. ✅ Install and activate plugins
2. ✅ Create required pages
3. ✅ Configure payment gateway
4. ✅ Create first subscription product
5. ✅ Customize styling
6. ✅ Test checkout flow
7. ✅ Launch!

---

**Last Updated**: January 2026
**WooCommerce Version**: 8.0+
**Theme**: Simple Family Law (Timber-based)
