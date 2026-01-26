# WooCommerce Integration - Project Structure Diagram

## Complete File Structure

```
simplefamilylaw/
│
├── 📄 WOOCOMMERCE-QUICK-START.md        ⭐ START HERE - Quick overview
├── 📄 WOOCOMMERCE-README.md             Quick start & feature guide
├── 📄 WOOCOMMERCE-SETUP.md              Detailed technical setup
├── 📄 SETUP-CHECKLIST.md                Step-by-step checklist
├── 📄 WOOCOMMERCE-EXAMPLES.md           Code examples & usage
├── 📄 IMPLEMENTATION-SUMMARY.md         Technical summary
│
├── src/
│   │
│   ├── 📝 functions.php                 (MODIFIED - WooCommerce support added)
│   │
│   ├── templates/
│   │   ├── base.twig                    (Main template - unchanged)
│   │   └── 📁 woocommerce/              ✨ NEW FOLDER
│   │       ├── archive-product.twig     Product listing/shop page
│   │       ├── single-product.twig      Product detail page
│   │       ├── cart.twig                Shopping cart
│   │       ├── checkout.twig            Checkout/payment page
│   │       ├── myaccount.twig           User account page
│   │       └── subscription-product.twig Reusable component
│   │
│   ├── scss/
│   │   ├── bundle.scss                  (MODIFIED - imports woocommerce.scss)
│   │   └── components/
│   │       ├── buttons.scss             (unchanged)
│   │       ├── colors.scss              (unchanged)
│   │       ├── fonts.scss               (unchanged)
│   │       ├── forms.scss               (unchanged)
│   │       ├── header.scss              (unchanged)
│   │       ├── footer.scss              (unchanged)
│   │       └── 📝 woocommerce.scss      ✨ NEW - All WooCommerce styles
│   │
│   ├── js/
│   │   ├── bundle.js                    (unchanged)
│   │   ├── swiper.min.js                (unchanged)
│   │   └── 📝 woocommerce.js            ✨ NEW - WooCommerce JavaScript
│   │
│   └── includes/
│       ├── index.php                    (auto-loads all PHP files)
│       ├── register-post-types.php      (unchanged)
│       └── 📝 woocommerce-integration.php ✨ NEW - Custom WooCommerce functions
│
├── package.json                         (unchanged)
├── config.js                            (unchanged)
├── gulpfile.js                          (unchanged)
└── tailwind.config.js                   (unchanged)

✨ = New files/folders created
📝 = Modified files
📄 = Documentation files
```

## Data Flow Diagram

```
Customer Journey
═════════════════════════════════════════════════════════════════

1. BROWSE PRODUCTS
   └─→ archive-product.twig (Shop page)
       ├─ Display product grid
       ├─ Show prices
       ├─ Show subscription period
       └─ Add to cart button
           │
           └─→ Customer clicks product

2. VIEW PRODUCT DETAILS
   └─→ single-product.twig (Product detail page)
       ├─ Product gallery
       ├─ Product information
       ├─ Video learning content
       ├─ Subscription features
       └─ Subscribe button
           │
           └─→ Customer clicks "Subscribe"

3. SHOPPING CART
   └─→ cart.twig (Shopping cart)
       ├─ Cart items
       ├─ Quantities
       ├─ Pricing
       └─ Proceed to checkout
           │
           └─→ Customer clicks checkout

4. CHECKOUT
   └─→ checkout.twig (Payment page)
       ├─ Billing form
       ├─ Order review
       ├─ Subscription notice
       └─ Payment processing
           │
           └─→ Payment successful

5. ACCOUNT ACCESS
   └─→ myaccount.twig (User account)
       ├─ View active subscriptions
       ├─ Download video access
       ├─ Manage subscriptions
       ├─ View order history
       └─ Update billing info
```

## Technology Stack Diagram

```
Frontend Layer
══════════════════════════════════════════════════════════════

   Timber/Twig Templates (.twig files)
            ↓
   ┌─────────────────────┬─────────────────────┐
   │                     │                     │
SCSS Styling        JavaScript         HTML Output
(woocommerce.scss)  (woocommerce.js)   (browser)
   │                     │                     │
   └─────────────────────┴─────────────────────┘
            ↓
   Browser Rendering (CSS + JS)


Backend Layer
══════════════════════════════════════════════════════════════

   WordPress Core
         ↓
   ┌─────────────────────────────────────┐
   │   WooCommerce Plugin                │
   │   ├─ Product Management             │
   │   ├─ Cart/Checkout                  │
   │   ├─ Payment Processing             │
   │   └─ Order Management               │
   └─────────────────────────────────────┘
         ↓
   ┌─────────────────────────────────────┐
   │   WooCommerce Subscriptions         │
   │   ├─ Recurring Billing              │
   │   ├─ Access Control                 │
   │   ├─ Renewal Management             │
   │   └─ Customer Portal                │
   └─────────────────────────────────────┘
         ↓
   ┌─────────────────────────────────────┐
   │   Theme Custom Functions            │
   │   (woocommerce-integration.php)     │
   │   ├─ Meta Field Registration        │
   │   ├─ Access Grant/Revoke            │
   │   ├─ Email Customization            │
   │   └─ Subscription Hooks             │
   └─────────────────────────────────────┘
         ↓
   WordPress Database
   ├─ Products (wp_posts)
   ├─ Order Data (wp_woocommerce_order_items)
   ├─ Subscriptions (wp_woocommerce_subscription_items)
   ├─ Post Meta (wp_postmeta)
   └─ User Meta (wp_usermeta)
```

## Feature Integration Diagram

```
Video Learning System
══════════════════════════════════════════════════════════════

Product Creation
    ↓
├─ Set Type: Subscription
├─ Set Billing: Monthly/Yearly
├─ Set Price
├─ Upload Image
└─ Add Video Content
    │
    └─ Stored in Post Meta
       └─ _video_learning_content
       └─ _video_duration
       └─ _video_level


Subscription Management
    ↓
├─ Automatic Billing
├─ Renewal Reminders
├─ Access Control
└─ Customer Portal
    │
    └─ Managed by WooCommerce Subscriptions


Video Access Control
    ↓
├─ On Subscription Activation
│   └─ Grant Access (via user_meta)
│
├─ On Active Page
│   └─ Check: user_has_video_access()
│   └─ Display Video if Access
│
└─ On Subscription Cancellation
    └─ Revoke Access (remove user_meta)
```

## Template Hierarchy

```
WordPress Template Hierarchy (WooCommerce)
═══════════════════════════════════════════════════════════

is_product_taxonomy
    ↓
archive-product.twig
    ├─ Product Category
    ├─ Product Tag
    └─ Product Search Results


is_singular( 'product' )
    ↓
single-product.twig
    ├─ Product ID: [product_id]
    ├─ Product Type: product
    └─ Single Product Display


is_cart()
    ↓
cart.twig
    ├─ WC Cart Page
    └─ Cart Items Display


is_checkout()
    ↓
checkout.twig
    ├─ WC Checkout Page
    └─ Payment Form


is_account_page()
    ↓
myaccount.twig
    ├─ WC Account Page
    └─ Customer Portal


else (Regular Page)
    ↓
base.twig
    └─ Standard Page Template
```

## Hook Integration Points

```
Product Display Hooks
══════════════════════════════════════════════════════════════

woocommerce_before_single_product
    ↓
    [Product Summary Section]
    ├─ woocommerce_product_thumbnails
    ├─ woocommerce_before_single_product_summary
    ├─ [Product Details]
    │   ├─ woocommerce_single_product_summary
    │   ├─ [Price]
    │   ├─ [Description]
    │   ├─ [Add to Cart]
    │   └─ [Product Meta]
    │
    └─ woocommerce_after_single_product_summary
       ├─ [Product Tabs]
       ├─ [Related Products]
        └─ [Video Content Section] ← Custom hook
    ↓
woocommerce_after_single_product


Cart & Checkout Hooks
══════════════════════════════════════════════════════════════

woocommerce_before_cart
    ↓
    [Cart Table]
    ├─ woocommerce_before_cart_table
    ├─ woocommerce_cart_contents (loop items)
    ├─ woocommerce_after_cart_table
    │
    └─ woocommerce_cart_collaterals
       └─ [Cart Totals]
    ↓
woocommerce_after_cart


woocommerce_before_checkout_form
    ↓
    [Checkout Form]
    ├─ woocommerce_checkout_login_form
    ├─ woocommerce_checkout_coupon_form
    ├─ [Customer Details]
    │   ├─ woocommerce_checkout_before_customer_details
    │   ├─ woocommerce_checkout_billing
    │   ├─ woocommerce_checkout_shipping
    │   └─ woocommerce_checkout_after_customer_details
    │
    └─ [Order Review]
        ├─ woocommerce_checkout_before_order_review
        ├─ woocommerce_checkout_order_review
        └─ woocommerce_checkout_after_order_review
    ↓
woocommerce_after_checkout_form


Subscription Lifecycle Hooks
══════════════════════════════════════════════════════════════

Product Purchase
    ↓
    └─ Order Created
        ↓
        └─ Subscription Object Created


woocommerce_subscription_status_active ✨ Custom Hook
    ↓
    ├─ Grant Video Access
    ├─ Send Welcome Email
    └─ Set User Meta
        └─ video_access_product_[ID]


Active Subscription
    ↓
    ├─ Auto-Billing (monthly/yearly)
    ├─ Renewal Reminders
    └─ Customer Management


woocommerce_subscription_status_cancelled ✨ Custom Hook
    ↓
    ├─ Revoke Video Access
    ├─ Send Cancellation Email
    └─ Delete User Meta
        └─ video_access_product_[ID]
```

## File Dependencies

```
functions.php
    ├─ Imports: includes/index.php
    │   └─ Auto-loads: woocommerce-integration.php
    │       ├─ Registers Custom Meta Fields
    │       ├─ Creates Meta Boxes
    │       ├─ Adds Subscription Hooks
    │       └─ Defines Helper Functions
    │
    └─ Adds WooCommerce Theme Support
        └─ Enables Templates in: templates/woocommerce/


bundle.scss
    ├─ Imports: components/woocommerce.scss
    │   └─ Styles All: templates/woocommerce/*.twig
    │
    └─ Compiles to: dist/css/bundle.css
        └─ Loaded in: wp_head()


bundle.js
    ├─ Loads: js/woocommerce.js
    │   └─ Initializes: Subscription Handlers
    │
    └─ Loaded in: wp_footer() with jQuery dependency


Templates Load In Order:
    base.twig
        ├─ wp_head() hook
        ├─ [WooCommerce Hooks]
        │   ├─ woocommerce_before_main_content
        │   ├─ [Page Specific Template]
        │   │   ├─ archive-product.twig
        │   │   ├─ single-product.twig
        │   │   ├─ cart.twig
        │   │   ├─ checkout.twig
        │   │   └─ myaccount.twig
        │   └─ woocommerce_after_main_content
        │
        └─ wp_footer() hook
            └─ wp_footer_scripts()
                └─ bundle.js with woocommerce.js
```

## Documentation Reading Order

```
1. Start Here (30 minutes)
   └─→ WOOCOMMERCE-QUICK-START.md
       └─ Overview of everything


2. Installation (1-2 hours)
   └─→ WOOCOMMERCE-README.md
       └─ Plugin setup & configuration


3. Implementation (2-4 hours)
   └─→ SETUP-CHECKLIST.md
       └─ Step-by-step tasks


4. Deep Dive (1-2 hours)
   └─→ WOOCOMMERCE-SETUP.md
       └─ Technical details


5. Reference (as needed)
   ├─→ WOOCOMMERCE-EXAMPLES.md
   │   └─ Code samples
   │
   └─→ IMPLEMENTATION-SUMMARY.md
       └─ File listing & features
```

## Quick Reference

```
🎯 BUSINESS LOGIC
├─ Create subscription products ✓
├─ Accept payments for subscriptions ✓
├─ Auto-renew subscriptions ✓
├─ Give video access to subscribers ✓
├─ Revoke access on cancellation ✓
└─ Customer subscription management ✓

🎨 USER INTERFACE
├─ Product browsing ✓
├─ Product details with video ✓
├─ Shopping cart ✓
├─ Secure checkout ✓
├─ Account management ✓
└─ Responsive design ✓

⚙️ ADMIN FEATURES
├─ Product creation ✓
├─ Video content management ✓
├─ Subscription management ✓
├─ Email customization ✓
├─ Payment processing ✓
└─ Customer support ✓

📊 ANALYTICS
├─ Order tracking ✓
├─ Subscription metrics ✓
├─ Email notifications ✓
└─ Customer reporting ✓
```

---

**This diagram explains the complete structure of your WooCommerce implementation**
