/**
 * WooCommerce Configuration
 * 
 * This file can be used to configure WooCommerce settings programmatically
 */

(function($) {
  'use strict';

  // WooCommerce initialization
  $(document).ready(function() {
    
    // Update cart on quantity change
    $('body').on('change', '.qty', function() {
      $('[name="update-cart"]').trigger('click');
    });

    // Handle subscription notices
    const subscriptionNotice = $('.woocommerce-message');
    if (subscriptionNotice.length) {
      subscriptionNotice.fadeIn(300);
    }

    // Add to cart button handling
    $('.add-to-cart-button, .single_add_to_cart_button').on('click', function() {
      const $button = $(this);
      const originalText = $button.text();
      
      $button.text('Adding...');
      $button.prop('disabled', true);

      // Re-enable after 2 seconds (WooCommerce will handle actual action)
      setTimeout(function() {
        $button.text(originalText);
        $button.prop('disabled', false);
      }, 2000);
    });

    // Smooth scroll to reviews
    $('a[href="#reviews"]').on('click', function() {
      $('html, body').animate({
        scrollTop: $('#reviews').offset().top - 100
      }, 800);
    });

    // Product gallery lightbox (if using default WooCommerce)
    if ($.fn.magnificPopup) {
      $('.product-gallery__image a').magnificPopup({
        type: 'image',
        mainClass: 'mfp-fade'
      });
    }
  });

  // Subscription specific features
  const SubscriptionHandler = {
    init: function() {
      this.setupPeriodSelector();
      this.setupRenewalNotice();
    },

    setupPeriodSelector: function() {
      // Handle subscription period selection if available
      const periodSelect = $('select[name="subscription_period"]');
      if (periodSelect.length) {
        periodSelect.on('change', function() {
          SubscriptionHandler.updatePrice();
        });
      }
    },

    setupRenewalNotice: function() {
      // Auto-hide renewal notice after 5 seconds
      const notice = $('.subscription-notice');
      if (notice.length) {
        setTimeout(function() {
          notice.fadeOut(500);
        }, 5000);
      }
    },

    updatePrice: function() {
      // Update displayed price based on selection
      // This would typically trigger an AJAX call to recalculate
      $(document).trigger('woocommerce_variation_has_changed');
    }
  };

  // Initialize on ready
  $(document).ready(function() {
    SubscriptionHandler.init();
  });

})(jQuery);
