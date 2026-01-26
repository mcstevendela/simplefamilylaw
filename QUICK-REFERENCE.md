# WooCommerce Integration - Quick Reference Card

## 📋 Essential Files at a Glance

| File | Type | Purpose | Location |
|------|------|---------|----------|
| archive-product.twig | Template | Shop/product listing | `src/templates/woocommerce/` |
| single-product.twig | Template | Product detail page | `src/templates/woocommerce/` |
| cart.twig | Template | Shopping cart | `src/templates/woocommerce/` |
| checkout.twig | Template | Payment page | `src/templates/woocommerce/` |
| myaccount.twig | Template | User account | `src/templates/woocommerce/` |
| subscription-product.twig | Component | Reusable product card | `src/templates/woocommerce/` |
| woocommerce.scss | Styling | All WooCommerce styles | `src/scss/components/` |
| woocommerce.js | Script | WooCommerce JS logic | `src/js/` |
| woocommerce-integration.php | PHP | Custom functions | `src/includes/` |

## 🚀 5-Minute Setup

```bash
1. Install WooCommerce plugin
2. Install WooCommerce Subscriptions plugin
3. Create Shop, Cart, Checkout, Account pages
4. Configure payment gateway
5. Create first subscription product
```

## 🎯 Key Functions

```php
// Check if user has video access
user_has_video_access( $product_id, $user_id )

// Get product object
$product = wc_get_product( $product_id );

// Get subscription info
$product->get_meta( '_subscription_period' );
$product->get_meta( '_subscription_interval' );
$product->get_meta( '_video_learning_content' );
```

## 🎨 Key Templates

```twig
{# Check if product is subscription #}
{% if product.get_type == 'subscription' %}
  <div class="subscription-badge">Subscription</div>
{% endif %}

{# Display video content #}
{{ post.meta('_video_learning_content')|raw }}

{# Add to cart link #}
<a href="{{ fn('esc_url', fn('wc_get_cart_url')) }}">Cart</a>
```

## 🔗 Important WooCommerce Hooks

```php
// Before/after product display
woocommerce_before_single_product
woocommerce_after_single_product

// Subscription status changes
woocommerce_subscription_status_active
woocommerce_subscription_status_cancelled

// Checkout process
woocommerce_before_checkout_form
woocommerce_checkout_before_customer_details
woocommerce_checkout_after_customer_details
```

## 🎯 Custom Meta Fields

```php
_video_learning_content    // Video embed code or URL
_video_duration            // Video length (e.g., "2 hours")
_video_level               // Difficulty level (beginner/intermediate/advanced)
_subscription_period       // Billing period (month/year)
_subscription_interval     // How many periods
```

## 📱 Responsive Breakpoints

```scss
Mobile:   < 768px   (1 column)
Tablet:   768-1024px (2 columns)
Desktop:  > 1024px   (3 columns)
```

## 🔐 Required for Launch

- [ ] SSL certificate installed (HTTPS)
- [ ] Payment gateway configured
- [ ] All pages created and set up
- [ ] Product created and tested
- [ ] Checkout tested with test card
- [ ] Email notifications working
- [ ] Styling customized

## 🛠️ Common Customizations

### Change Button Text
```php
add_filter( 'woocommerce_product_single_add_to_cart_text', function() {
  return 'Enroll Now';
});
```

### Modify Price Display
```php
add_filter( 'woocommerce_get_price_html', function( $price, $product ) {
  if ( 'subscription' === $product->get_type() ) {
    $period = $product->get_meta( '_subscription_period' );
    $price .= ' / ' . strtolower( $period );
  }
  return $price;
}, 10, 2 );
```

### Add Custom Checkout Field
```php
add_action( 'woocommerce_after_order_notes', function() {
  woocommerce_form_field( 'custom_field', array(
    'type'        => 'text',
    'label'       => 'Special Request',
    'placeholder' => 'Enter your request'
  ));
});
```

## 🧪 Test Cards (Payment Processing)

| Network | Card | Expiry | CVC |
|---------|------|--------|-----|
| Visa | 4242 4242 4242 4242 | Any future | Any 3 digits |
| Visa | 4000 0000 0000 0002 | Any future | Any 3 digits |
| Mastercard | 5555 5555 5555 4444 | Any future | Any 3 digits |

## 📊 File Sizes (Approximate)

- woocommerce.scss: ~500 lines
- woocommerce.js: ~150 lines
- woocommerce-integration.php: ~350 lines
- Templates (combined): ~400 lines

## ⏱️ Implementation Timeline

| Phase | Duration | Tasks |
|-------|----------|-------|
| Setup | 1-2 hours | Install plugins, configure basics |
| Configuration | 2-4 hours | Create pages, set payment, test flow |
| Customization | 2-4 hours | Update styling, customize templates |
| Testing | 1-2 hours | Comprehensive testing |
| Launch | 30 min | Enable live mode, monitor |

## 🔍 Debugging Tips

| Issue | Solution |
|-------|----------|
| Products not showing | Check Shop page is set in WooCommerce settings |
| Cart not updating | Verify AJAX is working in browser console |
| Checkout errors | Check payment gateway configuration |
| Video not playing | Verify embed code is correct, check HTTPS |
| Email not sending | Check email settings in WordPress |

## 📞 Support Links

- WooCommerce: https://docs.woocommerce.com/
- Subscriptions: https://woocommerce.com/products/woocommerce-subscriptions/
- Timber: https://timber.github.io/docs/
- WordPress: https://developer.wordpress.org/

## 🎓 Learning Path

1. **Understand WooCommerce** (1 hour)
   - Read WooCommerce docs
   - Understand product types

2. **Understand Subscriptions** (1 hour)
   - Read subscription plugin docs
   - Understand billing cycles

3. **Review Templates** (1 hour)
   - Review Twig files
   - Understand template structure

4. **Review Functions** (1 hour)
   - Review woocommerce-integration.php
   - Understand hooks and filters

5. **Test Full Flow** (2-4 hours)
   - Create test product
   - Complete purchase
   - Verify subscription
   - Check access control

## 💡 Pro Tips

1. **Use test mode** while setting up (payment settings)
2. **Test on mobile** before launching
3. **Keep backups** before major changes
4. **Monitor logs** after launch
5. **Update plugins** monthly for security
6. **Test emails** to ensure notifications work
7. **Use CDN** for faster media delivery
8. **Enable caching** for better performance

## 🚨 Critical Checklist

- [ ] WordPress updated
- [ ] WooCommerce installed
- [ ] Subscriptions plugin installed
- [ ] SSL certificate active
- [ ] Payment gateway configured
- [ ] Required pages created
- [ ] Test purchase completed
- [ ] Email notifications working
- [ ] Styling customized
- [ ] Mobile tested
- [ ] Backups configured

## 📈 After Launch

**Week 1**: Monitor for errors and customer issues
**Week 2-4**: Analyze conversion data, optimize flow
**Monthly**: Update plugins, review analytics, add content

## 🎯 Success Metrics

- ✅ Products display correctly
- ✅ Checkout completes successfully
- ✅ Subscriptions auto-renew
- ✅ Customers receive videos
- ✅ Access revoked on cancellation
- ✅ Email notifications working
- ✅ Site performance acceptable
- ✅ Zero payment errors

---

## Quick Links

**Documentation**
- [Start Here](WOOCOMMERCE-QUICK-START.md)
- [Setup Guide](WOOCOMMERCE-README.md)
- [Checklist](SETUP-CHECKLIST.md)
- [Examples](WOOCOMMERCE-EXAMPLES.md)
- [Structure](STRUCTURE-DIAGRAM.md)

**Code Files**
- [Functions](src/functions.php)
- [Integration](src/includes/woocommerce-integration.php)
- [Templates](src/templates/woocommerce/)
- [Styling](src/scss/components/woocommerce.scss)
- [JavaScript](src/js/woocommerce.js)

**External Resources**
- [WooCommerce Docs](https://docs.woocommerce.com/)
- [WordPress Codex](https://developer.wordpress.org/)
- [Timber Docs](https://timber.github.io/docs/)
- [Twig Docs](https://twig.symfony.com/doc/)

---

**Last Updated**: January 2026
**Version**: 1.0
**Status**: ✅ Ready to Use
