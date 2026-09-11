<?php

if (!defined('ABSPATH')) {
  exit;
}

require get_template_directory() . '/upsites/functions.php';

function brazil_home_theme_setup()
{
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ));

  // WooCommerce support
  add_theme_support('woocommerce');
  add_theme_support('wc-product-gallery-zoom');
  add_theme_support('wc-product-gallery-lightbox');
  add_theme_support('wc-product-gallery-slider');

  register_nav_menus(array(
    'header-menu' => __('Header Menu', 'brazil-home'),
    'footer-menu' => __('Footer Menu', 'brazil-home'),
  ));

  add_image_size('product-thumb', 300, 300, true);
  add_image_size('product-large', 800, 600, true);
}

add_action('after_setup_theme', 'brazil_home_theme_setup');

function brazil_home_enqueue_scripts()
{
  // Load theme styles
  wp_enqueue_style('brazil-home-style', get_stylesheet_uri());
  wp_enqueue_style('brazil-home-main', get_template_directory_uri() . '/assets/css/main.css');
  wp_enqueue_style('brazil-home-header', get_template_directory_uri() . '/assets/css/header.css');
  wp_enqueue_style('brazil-home-footer', get_template_directory_uri() . '/assets/css/footer.css');
  wp_enqueue_style('brazil-home-whatsapp-float', get_template_directory_uri() . '/assets/css/whatsapp-float.css');

  // Page-specific styles: only load each stylesheet on the page type that
  // actually uses it, mirroring the conditionals already used for the
  // equivalent JS enqueues below.
  if (is_home() || is_front_page()) {
    wp_enqueue_style('brazil-home-homepage', get_template_directory_uri() . '/assets/css/homepage.css');
  }

  if (is_page_template('template-pages/quem-somos.php')) {
    wp_enqueue_style('brazil-home-about', get_template_directory_uri() . '/assets/css/about.css');
  }

  if (is_product()) {
    wp_enqueue_style('brazil-home-product-details', get_template_directory_uri() . '/assets/css/product-details.css');
  }

  if (is_product_category() || is_shop() || is_page_template('template-pages/todos-os-produtos.php') || is_page_template('template-pages/categoria.php')) {
    wp_enqueue_style('brazil-home-category', get_template_directory_uri() . '/assets/css/category.css');
  }

  // Shared "Perguntas Frequentes" section: category archives and the
  // single product page both render a .faq-section.
  if (is_product_category() || is_page_template('template-pages/categoria.php') || is_product()) {
    wp_enqueue_style('brazil-home-faq-section', get_template_directory_uri() . '/assets/css/faq-section.css');
  }

  // Shared product card styling: every page that renders a product card
  // (.featured-product-card or .product-card) except cart and checkout.
  if (
    is_home() || is_front_page()
    || is_product() || is_product_category() || is_shop()
    || is_page_template('template-pages/todos-os-produtos.php')
    || is_page_template('template-pages/categoria.php')
    || is_page_template('template-pages/quem-somos.php')
  ) {
    wp_enqueue_style('brazil-home-product-card', get_template_directory_uri() . '/assets/css/product-card.css');
  }

  if (is_cart()) {
    wp_enqueue_style('brazil-home-cart', get_template_directory_uri() . '/assets/css/cart.css');
  }

  if (is_page_template('template-pages/contato.php')) {
    wp_enqueue_style('brazil-home-contact', get_template_directory_uri() . '/assets/css/contact.css');
  }

  // The home page's "Fique por dentro com nosso blog" module and the single
  // post's "Veja também" related posts both reuse the .blog-card component
  // styled in blog.css.
  if (is_page_template('template-pages/blog.php') || is_home() || is_front_page() || is_singular('post')) {
    wp_enqueue_style('brazil-home-blog', get_template_directory_uri() . '/assets/css/blog.css');
  }

  // template-pages/politica-de-privacidade.php reuses the single-post
  // article layout (.post-article/.post-container/.post-content).
  if (is_singular('post') || is_page_template('template-pages/politica-de-privacidade.php')) {
    wp_enqueue_style('brazil-home-post', get_template_directory_uri() . '/assets/css/post.css');
  }

  // Despite its name, products.css styles the "latest posts" grid used on
  // the blog template and single post pages (.posts-grid/.post-card), not
  // the "Todos os Produtos" page.
  if (is_page_template('template-pages/blog.php') || is_singular('post')) {
    wp_enqueue_style('brazil-home-products', get_template_directory_uri() . '/assets/css/products.css');
  }

  if (is_page_template('template-pages/quem-somos.php')) {
    wp_enqueue_style('brazil-home-quem-somos', get_template_directory_uri() . '/assets/css/quem-somos.css');
  }

  if (is_checkout()) {
    wp_enqueue_style('brazil-home-ajax-checkout', get_template_directory_uri() . '/assets/css/ajax-checkout.css');
  }

  // Load scripts
  wp_enqueue_script('brazil-home-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '', true);
  wp_enqueue_script('brazil-home-header-scroll', get_template_directory_uri() . '/assets/js/header-scroll.js', array('jquery'), '', true);

  // WhatsApp floating button script
  if (get_theme_mod('whatsapp_enable', true) && get_theme_mod('whatsapp_number', '')) {
    // wp_enqueue_script('brazil-home-whatsapp-float', get_template_directory_uri() . '/assets/js/whatsapp-float.js', array('jquery'), '', true);
  }

  if (is_page_template('template-pages/blog.php')) {
    // Enqueue Slick Carousel for blog page
    wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
    wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '', true);

    // Enqueue blog carousel script
    wp_enqueue_script('brazil-home-blog-carousel', get_template_directory_uri() . '/assets/js/blog-carousel.js', array('jquery', 'slick-js'), '', true);
  }

  // Localize cart scripts for AJAX
  wp_localize_script('brazil-home-main', 'brazil_cart_ajax', array(
    'ajax_url' => admin_url('admin-ajax.php'),
    'update_cart_nonce' => wp_create_nonce('update_cart_quantity'),
    'remove_cart_nonce' => wp_create_nonce('remove_cart_item'),
    'cart_url' => wc_get_cart_url()
  ));

  // Load page-specific scripts conditionally
  if (is_home() || is_front_page()) {
    // Enqueue Slick Carousel for brands carousel on mobile
    wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
    wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '', true);

    wp_enqueue_script('brazil-home-homepage', get_template_directory_uri() . '/assets/js/homepage.js', array('jquery', 'slick-js'), '', true);
    wp_enqueue_script('brazil-home-hero-carousel', get_template_directory_uri() . '/assets/js/hero-carousel.js', array('jquery'), '', true);
    wp_enqueue_script('brazil-home-hero-carousel-mobile', get_template_directory_uri() . '/assets/js/hero-carousel-mobile.js', array(), '', true);
  }

  if (is_page_template('template-pages/quem-somos.php')) {
    wp_enqueue_script('brazil-home-about', get_template_directory_uri() . '/assets/js/about.js', array('jquery'), '', true);

    // Enqueue Slick Carousel
    wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
    wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '', true);

    // Enqueue quem-somos carousel script
    wp_enqueue_script('brazil-home-quem-somos-carousel', get_template_directory_uri() . '/assets/js/quem-somos-carousel.js', array('jquery', 'slick-js'), '', true);
  }

  if (is_product()) {
    // Enqueue Slick Carousel for product gallery
    wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
    wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '', true);

    wp_enqueue_script('brazil-home-product-detailsJS', get_template_directory_uri() . '/assets/js/product-details.js', array('jquery', 'slick-js'), '', true);
    wp_enqueue_script('brazil-home-reviews-carousel', get_template_directory_uri() . '/assets/js/reviews-carousel.js', array('jquery', 'slick-js'), '', true);

    // Localize script for product tracking
    global $post;
    wp_localize_script('brazil-home-product-detailsJS', 'brazil_product_tracker', array(
      'ajax_url' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('track_product_visit')
    ));
  }

  if (is_product_category()) {
    wp_enqueue_script('brazil-home-category', get_template_directory_uri() . '/assets/js/category.js', array('jquery'), '', true);
  }

  if (is_page_template('template-pages/contato.php')) {
    wp_enqueue_script('brazil-home-contact', get_template_directory_uri() . '/assets/js/contact.js', array('jquery'), '', true);
  }

  if (is_checkout()) {
    // wp_enqueue_script('brazil-home-ajax-checkout', get_template_directory_uri() . '/assets/js/ajax-checkout.js', array('jquery'), '', true);
  }

  // WooCommerce scripts
  if (class_exists('WooCommerce')) {
    wp_enqueue_script('wc-add-to-cart');

    // Localize shipping calculator for cart, product, and checkout pages
    if (is_cart() || is_product() || is_checkout()) {
      wp_localize_script('brazil-home-main', 'brazilHomeShipping', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('brazil_home_shipping'),
      ]);
    }
  }
}

add_action('wp_enqueue_scripts', 'brazil_home_enqueue_scripts');

function brazil_home_woocommerce_add_to_cart_text($text, $product)
{
  return 'COMPRAR AGORA';
}

add_filter('woocommerce_product_add_to_cart_text', 'brazil_home_woocommerce_add_to_cart_text', 10, 2);
add_filter('woocommerce_product_single_add_to_cart_text', 'brazil_home_woocommerce_add_to_cart_text', 10, 2);

function brazil_home_customize_woocommerce_cart_button()
{
?>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      // Change all "Add to cart" buttons to "COMPRAR AGORA"
      $('.add_to_cart_button, .single_add_to_cart_button, .product_type_simple').each(function() {
        var $button = $(this);
        var currentText = $button.text().trim();

        // List of texts to replace
        var textsToReplace = [
          'Add to cart',
          'Adicionar ao carrinho',
          'ADICIONAR AO CARRINHO',
          'Buy Now',
          'Comprar',
          'Add to basket'
        ];

        if (textsToReplace.includes(currentText)) {
          $button.text('COMPRAR AGORA');
        }
      });
    });
  </script>
<?php
}

add_action('wp_footer', 'brazil_home_customize_woocommerce_cart_button');

function woocommerce_ajax_add_to_cart()
{
  if (!wp_verify_nonce($_POST['nonce'], 'wc_ajax_add_to_cart_nonce')) {
    wp_die();
  }

  $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
  $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
  $variation_id = absint($_POST['variation_id']);
  $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
  $product_status = get_post_status($product_id);

  if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {
    do_action('woocommerce_ajax_added_to_cart', $product_id);

    if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
      wc_add_to_cart_message(array($product_id => $quantity), true);
    }

    WC_AJAX::get_refreshed_fragments();
  } else {
    $data = array(
      'error' => true,
      'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
    );

    echo wp_send_json($data);
  }

  wp_die();
}

// Enable AJAX add to cart functionality
add_action('wp_ajax_woocommerce_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_add_to_cart', 'woocommerce_ajax_add_to_cart');

// Redirect to cart after successful AJAX add to cart
add_filter('woocommerce_add_to_cart_redirect', 'brazil_home_redirect_to_cart');
function brazil_home_redirect_to_cart()
{
  return wc_get_cart_url();
}

// Add cart fragments for AJAX updates
add_filter('woocommerce_add_to_cart_fragments', 'brazil_home_cart_count_fragments');
function brazil_home_cart_count_fragments($fragments)
{
  $fragments['span.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
  return $fragments;
}

// AJAX add to cart for single product pages
add_action('wp_enqueue_scripts', 'brazil_home_enqueue_wc_ajax');
function brazil_home_enqueue_wc_ajax()
{
  // JS já está enfileirado com esse handle
  // wp_enqueue_script('brazil-home-main', ...)

  if (function_exists('is_product') && is_product()) {
    wp_localize_script('brazil-home-main', 'wc_add_to_cart_params', array(
      'ajax_url' => admin_url('admin-ajax.php'),
      'wc_ajax_url' => WC()->ajax_url(),
      'i18n_view_cart' => esc_attr__('View cart', 'brazil-home'),
      'cart_url' => wc_get_cart_url(),
      'is_cart' => is_cart(),
      'cart_redirect_after_add' => get_option('woocommerce_cart_redirect_after_add')
    ));
  }
  /*
  wp_localize_script('brazil-home-main', 'wc_checkout_params', array(
    'ajax_url' => admin_url('admin-ajax.php'),
    'apply_coupon_nonce' => wp_create_nonce('apply-coupon'),
    'remove_coupon_nonce' => wp_create_nonce('remove-coupon'),
    'update_order_review_nonce' => wp_create_nonce('update-order-review'),
    'checkout_url' => wc_get_checkout_url(),
    'is_checkout' => is_checkout(),
    'debug_mode' => defined('WP_DEBUG') && WP_DEBUG,
  ));*/

  if (is_checkout() || is_wc_endpoint_url('order-received')) {
    wp_localize_script('brazil-home-main', 'wc_checkout_params_extended', array(
      'ajax_url' => admin_url('admin-ajax.php'),
      'update_order_review_nonce' => wp_create_nonce('update-order-review'),
      'currency_symbol' => get_woocommerce_currency_symbol(),
      'is_user_logged_in' => is_user_logged_in()
    ));
  }
}

// AJAX handler for add to cart
add_action('wp_ajax_wc_ajax_add_to_cart', 'wc_ajax_add_to_cart_handler');
add_action('wp_ajax_nopriv_wc_ajax_add_to_cart', 'wc_ajax_add_to_cart_handler');

function wc_ajax_add_to_cart_handler()
{
  if (!wp_verify_nonce($_POST['nonce'], 'wc_ajax_add_to_cart')) {
    wp_send_json_error('Invalid nonce');
    return;
  }

  $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
  $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);

  if (!$product_id) {
    wp_send_json_error('Invalid product');
    return;
  }

  $product = wc_get_product($product_id);

  if (!$product) {
    wp_send_json_error('Product not found');
    return;
  }

  // Reject unpurchasable/out-of-stock products without touching the
  // visitor's existing cart contents.
  if (!$product->is_purchasable() || !$product->is_in_stock()) {
    wp_send_json_error('Product is not available for purchase');
    return;
  } else {
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if ($passed_validation && 'publish' === $product_status) {
      $result = WC()->cart->add_to_cart($product_id, $quantity);

      if ($result) {
        wp_send_json_success(array(
          'message' => 'Product added to cart',
          'cart_total' => WC()->cart->get_cart_total(),
          'cart_count' => WC()->cart->get_cart_contents_count()
        ));
      } else {
        wp_send_json_error('Failed to add product to cart');
      }
    } else {
      wp_send_json_error('Product validation failed');
    }
  }
}

// AJAX handler for updating cart quantities
add_action('wp_ajax_update_cart_quantity', 'update_cart_quantity_handler');
add_action('wp_ajax_nopriv_update_cart_quantity', 'update_cart_quantity_handler');

function update_cart_quantity_handler()
{
  if (!wp_verify_nonce($_POST['nonce'], 'update_cart_quantity')) {
    wp_send_json_error('Invalid nonce');
    return;
  }

  $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
  $quantity = intval($_POST['quantity']);

  if (!$cart_item_key || $quantity < 0) {
    wp_send_json_error('Invalid parameters');
    return;
  }

  if ($quantity == 0) {
    WC()->cart->remove_cart_item($cart_item_key);
  } else {
    WC()->cart->set_quantity($cart_item_key, $quantity, true);
  }

  WC()->cart->calculate_totals();

  // Get updated cart item for subtotal
  $cart_item = WC()->cart->get_cart_item($cart_item_key);
  $item_subtotal = '';
  if ($cart_item) {
    $_product = $cart_item['data'];
    $item_subtotal = WC()->cart->get_product_subtotal($_product, $quantity);
  }

  wp_send_json_success(array(
    'cart_total' => WC()->cart->get_cart_total(),
    'cart_subtotal' => WC()->cart->get_cart_subtotal(),
    'cart_count' => WC()->cart->get_cart_contents_count(),
    'item_subtotal' => $item_subtotal,
  ));
}

// AJAX handler for removing cart items
add_action('wp_ajax_remove_cart_item', 'remove_cart_item_handler');
add_action('wp_ajax_nopriv_remove_cart_item', 'remove_cart_item_handler');

function remove_cart_item_handler()
{
  if (!isset($_POST['nonce'])) {
    wp_send_json_error('No nonce provided');
    return;
  }

  if (!wp_verify_nonce($_POST['nonce'], 'remove_cart_item')) {
    wp_send_json_error('Invalid nonce');
    return;
  }

  $cart_item_key = sanitize_text_field($_POST['cart_item_key']);

  if (!$cart_item_key) {
    wp_send_json_error('Invalid cart item key');
    return;
  }

  $removed = WC()->cart->remove_cart_item($cart_item_key);

  if ($removed) {
    WC()->cart->calculate_totals();

    wp_send_json_success(array(
      'message' => 'Item removed from cart',
      'cart_total' => WC()->cart->get_cart_total(),
      'cart_subtotal' => WC()->cart->get_cart_subtotal(),
      'cart_count' => WC()->cart->get_cart_contents_count(),
      'cart_is_empty' => WC()->cart->is_empty(),
    ));
  } else {
    wp_send_json_error('Failed to remove item from cart');
  }
}

// Customize WooCommerce checkout for Brazil
add_action('wp_enqueue_scripts', 'brazil_home_enqueue_checkout_scripts');

// Custom checkout redirect
function brazil_home_custom_checkout_redirect()
{
  remove_action('template_redirect', 'wc_redirect_to_cart_after_error');

  add_action('template_redirect', function () {
    if (!is_admin() && current_user_can('manage_options')) {
      // Get WooCommerce pages
      $shop_page_id = wc_get_page_id('shop');
      $cart_page_id = wc_get_page_id('cart');
      $checkout_url = wc_get_checkout_url();
      $cart_url = wc_get_cart_url();

      // Redirect logic here if needed
    }
  });
}

add_action('init', 'brazil_home_custom_checkout_redirect');

function brazil_home_create_checkout_pages()
{
  if (!is_admin() || !current_user_can('manage_options')) {
    return;
  }

  // Create checkout page if it doesn't exist
  $checkout_page_id = wc_get_page_id('checkout');

  if ($checkout_page_id == -1) {
    $checkout_page_id = wp_insert_post(array(
      'post_title' => 'Checkout',
      'post_content' => '[woocommerce_checkout]',
      'post_status' => 'publish',
      'post_type' => 'page'
    ));

    update_option('woocommerce_checkout_page_id', $checkout_page_id);
  }

  // Create cart page if it doesn't exist  
  $cart_page_id = wc_get_page_id('cart');

  if ($cart_page_id == -1) {
    $cart_page_id = wp_insert_post(array(
      'post_title' => 'Cart',
      'post_content' => '[woocommerce_cart]',
      'post_status' => 'publish',
      'post_type' => 'page'
    ));

    update_option('woocommerce_cart_page_id', $cart_page_id);
  }
}

add_action('admin_init', 'brazil_home_create_checkout_pages');

// Override checkout template redirect
function brazil_home_checkout_redirect_override()
{
  if (!is_admin()) {
    // Only redirect on frontend
    if (is_checkout() && !is_wc_endpoint_url('order-received') && WC()->cart->is_empty()) {
      wp_safe_redirect(home_url());
      exit;
    }
  }
}

add_action('template_redirect', 'brazil_home_checkout_redirect_override');

// Remove WooCommerce styles that conflict
add_filter('woocommerce_enqueue_styles', 'brazil_home_dequeue_styles');
function brazil_home_dequeue_styles($enqueue_styles)
{
  unset($enqueue_styles['woocommerce-general']);    // Remove the gloss
  unset($enqueue_styles['woocommerce-layout']);     // Remove the layout
  unset($enqueue_styles['woocommerce-smallscreen']); // Remove the smallscreen optimisation
  return $enqueue_styles;
}

// Remove result count and sorting
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

// FAQ Functions
// Register customizer settings for FAQ
function brazil_home_customize_register($wp_customize)
{
  // FAQ Section
  $wp_customize->add_section('brazil_home_faq', array(
    'title' => 'FAQ dos Produtos',
    'priority' => 30,
    'description' => 'Configure as perguntas frequentes que aparecem em todas as páginas de produtos.'
  ));

  // WhatsApp Floating Button Section
  $wp_customize->add_section('brazil_home_whatsapp', array(
    'title' => 'WhatsApp Floating Button',
    'priority' => 35,
    'description' => 'Configure o botão flutuante do WhatsApp.'
  ));

  // WhatsApp Enable/Disable
  $wp_customize->add_setting('whatsapp_enable', array(
    'default' => true,
    'sanitize_callback' => 'wp_validate_boolean'
  ));

  $wp_customize->add_control('whatsapp_enable', array(
    'label' => 'Ativar Botão WhatsApp',
    'section' => 'brazil_home_whatsapp',
    'type' => 'checkbox'
  ));

  // WhatsApp Number
  $wp_customize->add_setting('whatsapp_number', array(
    'default' => '',
    'sanitize_callback' => 'sanitize_text_field'
  ));

  $wp_customize->add_control('whatsapp_number', array(
    'label' => 'Número do WhatsApp (com código do país)',
    'section' => 'brazil_home_whatsapp',
    'type' => 'text',
    'description' => 'Ex: 5511999999999'
  ));

  // WhatsApp Message
  $wp_customize->add_setting('whatsapp_message', array(
    'default' => 'Olá! Gostaria de mais informações.',
    'sanitize_callback' => 'sanitize_textarea_field'
  ));

  $wp_customize->add_control('whatsapp_message', array(
    'label' => 'Mensagem Padrão',
    'section' => 'brazil_home_whatsapp',
    'type' => 'textarea'
  ));

  // WhatsApp Tagline
  $wp_customize->add_setting('whatsapp_tagline', array(
    'default' => 'Fale conosco!',
    'sanitize_callback' => 'sanitize_text_field'
  ));

  $wp_customize->add_control('whatsapp_tagline', array(
    'label' => 'Texto do Botão (Tagline)',
    'section' => 'brazil_home_whatsapp',
    'type' => 'text'
  ));

  // Add FAQ questions and answers (up to 15)
  for ($i = 1; $i <= 15; $i++) {
    // Question
    $wp_customize->add_setting('home_faq_question_' . $i, array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('home_faq_question_' . $i, array(
      'label' => 'Pergunta ' . $i,
      'section' => 'brazil_home_faq',
      'type' => 'text'
    ));

    // Answer
    $wp_customize->add_setting('home_faq_answer_' . $i, array(
      'default' => '',
      'sanitize_callback' => 'sanitize_textarea_field'
    ));

    $wp_customize->add_control('home_faq_answer_' . $i, array(
      'label' => 'Resposta ' . $i,
      'section' => 'brazil_home_faq',
      'type' => 'textarea'
    ));
  }
}

add_action('customize_register', 'brazil_home_customize_register');

// Function to get FAQ answer by number
function brazil_home_get_faq_answer($number)
{
  // Default answers
  $answers = array(
    1 => 'Sim, oferecemos garantia de 12 meses contra defeitos de fabricação em todos os nossos produtos.',
    2 => 'Todos os nossos produtos possuem garantia do fabricante de 12 meses contra defeitos de fabricação.',
    3 => 'O prazo de entrega varia de 7 a 15 dias úteis, dependendo da sua região e do produto escolhido.',
    4 => 'Você pode trocar seu produto em até 30 dias após a compra. Entre em contato conosco.'
  );

  return isset($answers[$number]) ? $answers[$number] : '';
}

// Function to get all Home FAQ items (only non-empty ones)
function brazil_home_get_home_faqs()
{
  $faqs = array();

  for ($i = 1; $i <= 15; $i++) {
    $question = get_theme_mod('home_faq_question_' . $i, '');
    $answer = get_theme_mod('home_faq_answer_' . $i, '');

    // Only add FAQ if both question and answer are not empty
    if (!empty(trim($question)) && !empty(trim($answer))) {
      $faqs[] = array(
        'question' => $question,
        'answer' => $answer
      );
    }
  }

  return $faqs;
}

// Add custom meta fields for WooCommerce products (Produtos)
add_action('woocommerce_product_options_general_product_data', 'brazil_home_add_produtos_custom_fields');
function brazil_home_add_produtos_custom_fields()
{
  echo '<div class="options_group">';

  // YouTube Video field
  woocommerce_wp_text_input(array(
    'id' => '_produto_youtube_video',
    'label' => 'YouTube Video URL',
    'placeholder' => 'https://www.youtube.com/watch?v=...',
    'desc_tip' => true,
    'description' => 'Cole a URL completa do vídeo do YouTube para este produto.'
  ));

  // Manual file upload field
  global $post;
  $manual_file_value = '';
  if ($post && $post->ID) {
    $manual_file_value = get_post_meta($post->ID, '_produto_manual_file', true);
  }
  echo '<p class="form-field _produto_manual_file_field">
        <label for="_produto_manual_file">Manual do Produto</label>
        <input type="text" class="short" name="_produto_manual_file" id="_produto_manual_file" value="' . esc_attr($manual_file_value) . '" placeholder="URL do arquivo PDF" />
        <button type="button" class="upload_produto_manual_button button" data-target="_produto_manual_file">Upload Manual</button>
        <span class="description">Faça upload ou cole a URL do arquivo PDF do manual do produto.</span>
    </p>';

  echo '</div>';
}

// Save custom meta fields for produtos
add_action('woocommerce_process_product_meta', 'brazil_home_save_produtos_custom_fields');
function brazil_home_save_produtos_custom_fields($post_id)
{
  // Save YouTube video URL
  if (isset($_POST['_produto_youtube_video'])) {
    update_post_meta($post_id, '_produto_youtube_video', sanitize_text_field($_POST['_produto_youtube_video']));
  }

  // Save manual file URL
  if (isset($_POST['_produto_manual_file'])) {
    update_post_meta($post_id, '_produto_manual_file', sanitize_text_field($_POST['_produto_manual_file']));
  }
}

// Enqueue media uploader for produtos admin
add_action('admin_enqueue_scripts', 'brazil_home_produtos_admin_scripts');
function brazil_home_produtos_admin_scripts($hook)
{
  if ('post.php' !== $hook && 'post-new.php' !== $hook) {
    return;
  }

  global $post;
  if ($post && $post->post_type === 'product') {
    wp_enqueue_media();
    wp_add_inline_script('media-upload', '
            jQuery(document).ready(function($) {
                $(".upload_produto_manual_button").click(function(e) {
                    e.preventDefault();
                    
                    var target = $(this).data("target");
                    var file_frame = wp.media.frames.file_frame = wp.media({
                        title: "Selecionar Manual do Produto",
                        button: { text: "Usar este arquivo" },
                        multiple: false,
                        library: { type: "application/pdf" }
                    });
                    
                    file_frame.on("select", function() {
                        var attachment = file_frame.state().get("selection").first().toJSON();
                        $("#" + target).val(attachment.url);
                    });
                    
                    file_frame.open();
                });
            });
        ');
  }
}

// Helper function to get YouTube embed URL for produtos
function brazil_home_get_produto_youtube_embed_url($url)
{
  if (empty($url)) {
    return '';
  }

  // Extract video ID from various YouTube URL formats
  $video_id = '';
  if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
    $video_id = $matches[1];
  } elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $matches)) {
    $video_id = $matches[1];
  } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
    $video_id = $matches[1];
  }

  if ($video_id) {
    return 'https://www.youtube.com/embed/' . $video_id;
  }

  return $url; // Return original if no match found
}

// Helper function to get product FAQs
function brazil_home_get_product_faqs($product_id = null)
{
  // Get product ID if not provided
  if (!$product_id) {
    $product_id = get_the_ID();
  }

  // Check if ACF is available and get custom FAQs
  if (function_exists('get_field')) {
    $custom_faqs = get_field('product_faqs', $product_id);

    if (!empty($custom_faqs) && is_array($custom_faqs)) {
      return $custom_faqs;
    }
  }

  // Return fallback FAQs if no custom FAQs are defined
  return array(
    array(
      'question' => 'COMO FUNCIONA A GARANTIA?',
      'answer' => 'Oferecemos garantia de 12 meses contra defeitos de fabricação para todos os nossos produtos.'
    ),
    array(
      'question' => 'QUAL O PRAZO DE ENTREGA?',
      'answer' => 'O prazo de entrega varia de 7 a 15 dias úteis, dependendo da região e do produto escolhido.'
    ),
    array(
      'question' => 'POSSO TROCAR O PRODUTO?',
      'answer' => 'Você pode trocar o produto em até 7 dias após a compra. Entre em contato conosco para mais informações.'
    )
  );
}

// AJAX handler for shipping calculator
add_action('wp_ajax_wc_shipping_calculator', 'brazil_home_shipping_calculator_handler');
add_action('wp_ajax_nopriv_wc_shipping_calculator', 'brazil_home_shipping_calculator_handler');

function brazil_home_shipping_calculator_handler()
{
  check_ajax_referer('brazil_home_shipping', 'nonce');

  $country = sanitize_text_field($_POST['country']);
  $state = sanitize_text_field($_POST['state']);
  $postcode = sanitize_text_field($_POST['postcode']);
  $city = sanitize_text_field($_POST['city']);

  // Set customer location for shipping calculation
  WC()->customer->set_shipping_country($country);
  WC()->customer->set_shipping_state($state);
  WC()->customer->set_shipping_postcode($postcode);
  WC()->customer->set_shipping_city($city);

  // Calculate shipping
  WC()->cart->calculate_shipping();
  WC()->cart->calculate_totals();

  // Get available shipping methods
  $packages = WC()->shipping->get_packages();
  $shipping_methods = array();

  foreach ($packages as $package) {
    if (isset($package['rates']) && !empty($package['rates'])) {
      foreach ($package['rates'] as $rate) {
        $shipping_methods[] = array(
          'id' => $rate->get_id(),
          'label' => $rate->get_label(),
          'cost' => $rate->get_cost(),
          'formatted_cost' => wc_price($rate->get_cost())
        );
      }
    }
  }

  wp_send_json_success(array(
    'shipping_methods' => $shipping_methods,
    'cart_total' => WC()->cart->get_cart_total(),
    'shipping_total' => WC()->cart->get_shipping_total()
  ));
}

// Track visited products functionality
function brazil_home_track_visited_product($product_id)
{
  if (!$product_id)
    return;

  $visited_products = isset($_COOKIE['visited_products']) ? json_decode(stripslashes($_COOKIE['visited_products']), true) : array();

  if (!is_array($visited_products)) {
    $visited_products = array();
  }

  // Add product ID if not already in list
  if (!in_array($product_id, $visited_products)) {
    array_unshift($visited_products, $product_id); // Add to beginning
    // Keep only last 10 visited products
    $visited_products = array_slice($visited_products, 0, 10);

    // Set cookie for 30 days
    setcookie('visited_products', json_encode($visited_products), time() + (30 * 24 * 60 * 60), '/');
  }
}

// Get visited products
function brazil_home_get_visited_products()
{
  if (isset($_COOKIE['visited_products'])) {
    $visited_products = json_decode(stripslashes($_COOKIE['visited_products']), true);
    return is_array($visited_products) ? $visited_products : array();
  }
  return array();
}

// Hook to track product visits
add_action('wp', 'brazil_home_track_product_visit');
function brazil_home_track_product_visit()
{
  if (is_product()) {
    global $post;
    if ($post && $post->ID) {
      brazil_home_track_visited_product($post->ID);
    }
  }
}

// Helper function to get "Todos os Produtos" page URL
function brazil_home_get_todos_produtos_page_url()
{
  // Look for a page using the "Todos os Produtos" template
  $pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'template-pages/todos-os-produtos.php'
  ));

  if (!empty($pages)) {
    return get_permalink($pages[0]->ID);
  }

  // Fallback: look for page with slug "todos-os-produtos"
  $page = get_page_by_path('todos-os-produtos');
  if ($page) {
    return get_permalink($page->ID);
  }

  // Final fallback: shop page or home
  if (function_exists('wc_get_page_id')) {
    $shop_id = wc_get_page_id('shop');
    if ($shop_id > 0) {
      return get_permalink($shop_id);
    }
  }

  return home_url();
}

// Missing function for checkout scripts
function brazil_home_enqueue_checkout_scripts()
{
  // This function was being called but didn't exist
  // Add any checkout-specific scripts here if needed
}


// AJAX Handler for Shipping Calculator
function brazil_home_calculate_shipping_for_product()
{
  // Verify nonce
  if (!wp_verify_nonce($_POST['nonce'], 'brazil_home_shipping')) {
    wp_send_json_error('Invalid nonce');
    return;
  }

  if (!class_exists('WooCommerce')) {
    wp_send_json_error('WooCommerce not active');
    return;
  }

  $product_id = intval($_POST['product_id']);
  $quantity = intval($_POST['quantity']) ?: 1;
  $postcode = sanitize_text_field($_POST['postcode']);
  $country = sanitize_text_field($_POST['country']) ?: 'BR';

  if (!$product_id || !$postcode) {
    wp_send_json_error('Missing required parameters');
    return;
  }

  // Get product
  $product = wc_get_product($product_id);
  if (!$product) {
    wp_send_json_error('Product not found');
    return;
  }

  try {
    // Clear existing cart for clean calculation
    $original_cart_contents = WC()->cart->get_cart_contents();
    WC()->cart->empty_cart();

    // Add product to cart for calculation
    WC()->cart->add_to_cart($product_id, $quantity);

    // Set shipping destination
    WC()->customer->set_shipping_country($country);
    WC()->customer->set_shipping_postcode($postcode);
    WC()->customer->set_billing_country($country);
    WC()->customer->set_billing_postcode($postcode);

    // Calculate shipping
    WC()->cart->calculate_shipping();
    WC()->cart->calculate_totals();

    // Get available shipping methods
    $packages = WC()->shipping->get_packages();
    $shipping_methods = array();

    foreach ($packages as $package) {
      $available_methods = $package['rates'];

      foreach ($available_methods as $method_id => $method) {
        $shipping_methods[] = array(
          'id' => $method_id,
          'name' => $method->get_label(),
          'price' => wc_price($method->get_cost()),
          'cost' => $method->get_cost(),
          'days' => ""
        );
      }
    }

    // Restore original cart contents
    WC()->cart->empty_cart();
    foreach ($original_cart_contents as $cart_item_key => $cart_item) {
      WC()->cart->restore_cart_item($cart_item_key);
    }

    if (empty($shipping_methods)) {
      wp_send_json_error('Nenhum método de envio disponível para este CEP');
      return;
    }

    wp_send_json_success(array(
      'shipping_methods' => $shipping_methods
    ));
  } catch (Exception $e) {
    wp_send_json_error('Erro ao calcular frete: ' . $e->getMessage());
  }
}

add_action('wp_ajax_calculate_shipping_for_product', 'brazil_home_calculate_shipping_for_product');
add_action('wp_ajax_nopriv_calculate_shipping_for_product', 'brazil_home_calculate_shipping_for_product');

// AJAX Handler for Cart Shipping Calculator
function brazil_home_calculate_cart_shipping()
{
  // Verify nonce
  if (!wp_verify_nonce($_POST['nonce'], 'brazil_home_shipping')) {
    wp_send_json_error('Invalid nonce');
    return;
  }

  if (!class_exists('WooCommerce')) {
    wp_send_json_error('WooCommerce not active');
    return;
  }

  $postcode = sanitize_text_field($_POST['postcode']);
  $country = sanitize_text_field($_POST['country']) ?: 'BR';

  if (!$postcode) {
    wp_send_json_error('Missing CEP parameter');
    return;
  }

  // Check if cart is empty
  if (WC()->cart->is_empty()) {
    wp_send_json_success([
      'shipping_methods' => []
    ]);
  }

  try {
    // Set shipping destination
    WC()->customer->set_shipping_country($country);
    WC()->customer->set_shipping_postcode($postcode);
    WC()->customer->set_billing_country($country);
    WC()->customer->set_billing_postcode($postcode);

    // Calculate shipping for current cart contents
    WC()->cart->calculate_shipping();
    WC()->cart->calculate_totals();

    // Get available shipping methods
    $packages = WC()->shipping->get_packages();
    $shipping_methods = array();

    foreach ($packages as $package) {
      $available_methods = $package['rates'];

      foreach ($available_methods as $method_id => $method) {
        $shipping_methods[] = array(
          'id' => $method_id,
          'name' => $method->get_label(),
          'price' => wc_price($method->get_cost()),
          'cost' => $method->get_cost(),
          'days' => ""
        );
      }
    }

    if (empty($shipping_methods)) {
      wp_send_json_error('Nenhum método de envio disponível para este CEP');
      return;
    }

    wp_send_json_success(array(
      'shipping_methods' => $shipping_methods
    ));
  } catch (Exception $e) {
    wp_send_json_error('Erro ao calcular frete: ' . $e->getMessage());
  }
}

add_action('wp_ajax_calculate_cart_shipping', 'brazil_home_calculate_cart_shipping');
add_action('wp_ajax_nopriv_calculate_cart_shipping', 'brazil_home_calculate_cart_shipping');

// Installment Configuration and Functions
function brazil_home_get_installment_parcels()
{
  // This can be configured per product category, minimum value, etc.
  // For now, we'll use a simple configuration
  return apply_filters('brazil_home_installment_parcels', 10);
}

function brazil_home_get_installment_text($product_price)
{
  $parcels = brazil_home_get_installment_parcels();
  $installment_value = $product_price / $parcels;

  // You can add minimum installment value logic here
  $min_installment = apply_filters('brazil_home_min_installment_value', 10);

  if ($installment_value < $min_installment) {
    // Calculate maximum parcels based on minimum installment
    $max_parcels = floor($product_price / $min_installment);
    if ($max_parcels < 1) {
      return '';
    }
    $parcels = $max_parcels;
    $installment_value = $product_price / $parcels;
  }

  return sprintf(
    'Em até <mark>  %dx de %s</mark> sem juros',
    $parcels,
    wc_price($installment_value)
  );
}

// Add custom field to edit installment parcels globally
function brazil_home_add_installment_settings()
{
  add_settings_section(
    'brazil_home_installments',
    'Configurações de Parcelamento',
    function () {
      echo '<p>Configure o número de parcelas para os produtos.</p>';
    },
    'general'
  );

  add_settings_field(
    'brazil_home_max_parcels',
    'Número máximo de parcelas',
    function () {
      $value = get_option('brazil_home_max_parcels', 10);
      echo '<input type="number" name="brazil_home_max_parcels" value="' . esc_attr($value) . '" min="1" max="24" />';
      echo '<p class="description">Número máximo de parcelas sem juros (padrão: 10)</p>';
    },
    'general',
    'brazil_home_installments'
  );

  register_setting('general', 'brazil_home_max_parcels');
}
add_action('admin_init', 'brazil_home_add_installment_settings');

// Filter to use the setting
add_filter('brazil_home_installment_parcels', function ($default) {
  return get_option('brazil_home_max_parcels', $default);
});

// Handle WooCommerce Registration with Brazilian Fields
function brazil_home_validate_registration_fields($errors, $username, $email)
{
  // Validate Nome Completo
  if (!empty($_POST['nome_completo'])) {
    $nome_completo = sanitize_text_field($_POST['nome_completo']);
  } else {
    $nome_completo = trim(
      ($_POST['billing_first_name'] ?? '') . ' ' . ($_POST['billing_last_name'] ?? '')
    );
  }

  if (empty($nome_completo)) {
    $errors->add('nome_completo_error', 'Nome completo é obrigatório.');
  }

  $cpf_cnpj = '';

  if (!empty($_POST['cpf_cnpj'])) {
    $cpf_cnpj = sanitize_text_field($_POST['cpf_cnpj']);
  } elseif (!empty($_POST['billing_cpf'])) {
    $cpf_cnpj = sanitize_text_field($_POST['billing_cpf']);
  } elseif (!empty($_POST['billing_cnpj'])) {
    $cpf_cnpj = sanitize_text_field($_POST['billing_cnpj']);
  }

  // remove máscara
  $cpf_cnpj = preg_replace('/\D/', '', $cpf_cnpj);

  if (empty($cpf_cnpj)) {
    $errors->add('cpf_cnpj_error', 'CPF ou CNPJ é obrigatório.');
  } else {
    if (!brazil_home_validate_cpf_cnpj($cpf_cnpj)) {
      $errors->add('cpf_cnpj_error', 'CPF ou CNPJ inválido.');
    }
  }

  // Validate CEP (billing_postcode)
  if (empty($_POST['billing_postcode'])) {
    $errors->add('billing_postcode_error', 'CEP é obrigatório.');
  } else {
    $cep = sanitize_text_field($_POST['billing_postcode']);
    if (!preg_match('/^\d{5}-?\d{3}$/', $cep)) {
      $errors->add('billing_postcode_error', 'CEP deve ter o formato 00000-000.');
    }
  }

  // Validate Endereço (billing_address_1)
  if (empty($_POST['billing_address_1'])) {
    $errors->add('billing_address_1_error', 'Endereço é obrigatório.');
  }

  // Validate Número (billing_number)
  if (empty($_POST['billing_number'])) {
    $errors->add('billing_number_error', 'Número é obrigatório.');
  }

  // Validate Telefone (billing_phone)
  if (empty($_POST['billing_phone'])) {
    $errors->add('billing_phone_error', 'Telefone é obrigatório.');
  } else {
    $telefone = sanitize_text_field($_POST['billing_phone']);
    if (!preg_match('/^\(\d{2}\)\s?\d{4,5}-?\d{4}$/', $telefone)) {
      $errors->add('billing_phone_error', 'Telefone deve ter o formato (00) 00000-0000.');
    }
  }

  return $errors;
}
add_filter('woocommerce_registration_errors', 'brazil_home_validate_registration_fields', 10, 3);

// Save custom fields during registration
function brazil_home_save_registration_fields($customer_id)
{
  // Save Nome Completo and update WordPress display name and first/last name
  if (isset($_POST['nome_completo'])) {
    $nome_completo = sanitize_text_field($_POST['nome_completo']);
    update_user_meta($customer_id, 'nome_completo', $nome_completo);

    // Split name for first_name and last_name fields
    $name_parts = explode(' ', trim($nome_completo));
    $first_name = $name_parts[0];
    $last_name = count($name_parts) > 1 ? implode(' ', array_slice($name_parts, 1)) : '';

    update_user_meta($customer_id, 'first_name', $first_name);
    update_user_meta($customer_id, 'last_name', $last_name);
    update_user_meta($customer_id, 'display_name', $nome_completo);

    // Also update the user table
    wp_update_user(array(
      'ID' => $customer_id,
      'display_name' => $nome_completo,
      'first_name' => $first_name,
      'last_name' => $last_name
    ));
  }

  if (isset($_POST['cpf_cnpj'])) {
    if (strlen($_POST['cpf_cnpj']) == 14) {
      update_user_meta($customer_id, 'billing_cpf', sanitize_text_field($_POST['cpf_cnpj']));
    } else {
      update_user_meta($customer_id, 'billing_cnpj', sanitize_text_field($_POST['cpf_cnpj']));
    }
  }
  if (isset($_POST['billing_postcode'])) {
    update_user_meta($customer_id, 'billing_postcode', sanitize_text_field($_POST['billing_postcode']));
  }
  if (isset($_POST['billing_address_1'])) {
    update_user_meta($customer_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']));
  }
  if (isset($_POST['billing_number'])) {
    update_user_meta($customer_id, 'billing_number', sanitize_text_field($_POST['billing_number']));
  }
  if (isset($_POST['billing_phone'])) {
    update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
  }
}
add_action('woocommerce_created_customer', 'brazil_home_save_registration_fields');

// CPF/CNPJ validation function
function brazil_home_validate_cpf_cnpj($cpf_cnpj)
{
  if (empty($cpf_cnpj)) {
    return false;
  }

  // Remove tudo que não for número
  $cpf_cnpj = preg_replace('/\D/', '', $cpf_cnpj);

  // Evita sequências inválidas tipo 11111111111 / 00000000000
  if (preg_match('/^(\d)\1+$/', $cpf_cnpj)) {
    return false;
  }

  // CPF
  if (strlen($cpf_cnpj) === 11) {
    return brazil_home_validate_cpf($cpf_cnpj);
  }

  // CNPJ
  if (strlen($cpf_cnpj) === 14) {
    return brazil_home_validate_cnpj($cpf_cnpj);
  }

  return false;
}

// CPF validation
function brazil_home_validate_cpf($cpf)
{
  // Check for common invalid CPFs
  if (preg_match('/(\d)\1{10}/', $cpf))
    return false;

  // Validate CPF algorithm
  for ($t = 9; $t < 11; $t++) {
    for ($d = 0, $c = 0; $c < $t; $c++) {
      $d += $cpf[$c] * (($t + 1) - $c);
    }
    $d = ((10 * $d) % 11) % 10;
    if ($cpf[$c] != $d)
      return false;
  }

  return true;
}

// CNPJ validation
function brazil_home_validate_cnpj($cnpj)
{

  // Valida tamanho
  if (strlen($cnpj) != 14)
    return false;

  // Verifica se todos os digitos são iguais
  if (preg_match('/(\d)\1{13}/', $cnpj))
    return false;

  // Valida primeiro dígito verificador
  for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
    $soma += $cnpj[$i] * $j;
    $j = ($j == 2) ? 9 : $j - 1;
  }

  $resto = $soma % 11;

  if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
    return false;

  // Valida segundo dígito verificador
  for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
    $soma += $cnpj[$i] * $j;
    $j = ($j == 2) ? 9 : $j - 1;
  }

  $resto = $soma % 11;

  return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
}

// Register Custom Post Type: Produto Comparação
function brazil_home_register_comparison_product_post_type()
{
  $labels = array(
    'name' => 'Produtos para Comparação',
    'singular_name' => 'Produto para Comparação',
    'menu_name' => 'Produtos Comparação',
    'add_new' => 'Adicionar Novo',
    'add_new_item' => 'Adicionar Novo Produto para Comparação',
    'edit_item' => 'Editar Produto para Comparação',
    'new_item' => 'Novo Produto para Comparação',
    'view_item' => 'Ver Produto para Comparação',
    'search_items' => 'Buscar Produtos para Comparação',
    'not_found' => 'Nenhum produto encontrado',
    'not_found_in_trash' => 'Nenhum produto encontrado na lixeira',
    'all_items' => 'Todos os Produtos',
    'archives' => 'Arquivos de Produtos',
    'attributes' => 'Atributos do Produto',
  );

  $args = array(
    'labels' => $labels,
    'public' => false,
    'publicly_queryable' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'produto-comparacao'),
    'capability_type' => 'post',
    'has_archive' => false,
    'hierarchical' => false,
    'menu_position' => 56,
    'menu_icon' => 'dashicons-clipboard',
    'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
    'show_in_rest' => true,
  );

  register_post_type('produto_comparacao', $args);
}
add_action('init', 'brazil_home_register_comparison_product_post_type');

// Add custom meta boxes for comparison products
function brazil_home_add_comparison_product_meta_boxes()
{
  add_meta_box(
    'comparison_product_details',
    'Detalhes do Produto',
    'brazil_home_comparison_product_details_callback',
    'produto_comparacao',
    'normal',
    'high'
  );
}
add_action('add_meta_boxes', 'brazil_home_add_comparison_product_meta_boxes');

// Callback for product details meta box
function brazil_home_comparison_product_details_callback($post)
{
  wp_nonce_field('comparison_product_details_nonce', 'comparison_product_nonce');

  $price = get_post_meta($post->ID, '_comparison_price', true);
  $dimensions = get_post_meta($post->ID, '_comparison_dimensions', true);
  $weight = get_post_meta($post->ID, '_comparison_weight', true);
  $stock_status = get_post_meta($post->ID, '_comparison_stock_status', true);

?>
  <table class="form-table">
    <tr>
      <th><label for="comparison_price">Preço</label></th>
      <td>
        <input type="text" id="comparison_price" name="comparison_price" value="<?php echo esc_attr($price); ?>"
          placeholder="R$ 0,00" style="width: 100%;">
        <p class="description">Exemplo: R$ 299,90</p>
      </td>
    </tr>
    <tr>
      <th><label for="comparison_dimensions">Dimensões (C x L x A)</label></th>
      <td>
        <input type="text" id="comparison_dimensions" name="comparison_dimensions"
          value="<?php echo esc_attr($dimensions); ?>" placeholder="100 x 50 x 30 cm" style="width: 100%;">
        <p class="description">Exemplo: 400 x 300 x 260 cm</p>
      </td>
    </tr>
    <tr>
      <th><label for="comparison_weight">Peso</label></th>
      <td>
        <input type="text" id="comparison_weight" name="comparison_weight" value="<?php echo esc_attr($weight); ?>"
          placeholder="5 kg" style="width: 100%;">
        <p class="description">Exemplo: 5 kg ou 500 g</p>
      </td>
    </tr>
    <tr>
      <th><label for="comparison_stock_status">Status do Estoque</label></th>
      <td>
        <select id="comparison_stock_status" name="comparison_stock_status" style="width: 100%;">
          <option value="instock" <?php selected($stock_status, 'instock'); ?>>Em Estoque</option>
          <option value="outofstock" <?php selected($stock_status, 'outofstock'); ?>>Fora de Estoque</option>
        </select>
      </td>
    </tr>
  </table>
<?php
}

// Save comparison product meta data
function brazil_home_save_comparison_product_meta($post_id)
{
  if (!isset($_POST['comparison_product_nonce'])) {
    return;
  }

  if (!wp_verify_nonce($_POST['comparison_product_nonce'], 'comparison_product_details_nonce')) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (isset($_POST['comparison_price'])) {
    update_post_meta($post_id, '_comparison_price', sanitize_text_field($_POST['comparison_price']));
  }

  if (isset($_POST['comparison_dimensions'])) {
    update_post_meta($post_id, '_comparison_dimensions', sanitize_text_field($_POST['comparison_dimensions']));
  }

  if (isset($_POST['comparison_weight'])) {
    update_post_meta($post_id, '_comparison_weight', sanitize_text_field($_POST['comparison_weight']));
  }

  if (isset($_POST['comparison_stock_status'])) {
    update_post_meta($post_id, '_comparison_stock_status', sanitize_text_field($_POST['comparison_stock_status']));
  }
}
add_action('save_post_produto_comparacao', 'brazil_home_save_comparison_product_meta');

function brazil_home_avise_me_shortcode($atts)
{
  global $product;

  if (!is_product() || !$product instanceof WC_Product) {
    return '';
  }

  if ($product->is_in_stock()) {
    return '';
  }

  $atts = shortcode_atts([
    'id' => '3236b4d',
    'title' => 'Avise-me'
  ], $atts, 'avise_me_form');

  $product_id = $product->get_id();
  $product_name = $product->get_name();
  $product_url = get_permalink($product_id);

  ob_start();
?>
  <div class="avise-me-container">
    <button type="button" class="btn-add-cart btn-avise-me" data-target="avise-form-<?php echo esc_attr($product_id); ?>">
      AVISE-ME QUANDO CHEGAR
    </button>

    <div class="avise-me-form-wrapper" id="avise-form-<?php echo esc_attr($product_id); ?>" style="display:none;">
      <div class="avise-me-form-inner">
        <h3>Avise-me quando o produto estiver disponível</h3>

        <form class="avise-me-hidden-product-data">
          <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
          <input type="hidden" name="product_name" value="<?php echo esc_attr($product_name); ?>">
          <input type="hidden" name="product_url" value="<?php echo esc_url($product_url); ?>">
        </form>

        <?php echo do_shortcode('[contact-form-7 id="' . esc_attr($atts['id']) . '" title="' . esc_attr($atts['title']) . '"]'); ?>

        <span class="btn-close-avise-me">X</span>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var wrapper = document.getElementById('avise-form-<?php echo esc_js($product_id); ?>');
      if (!wrapper) return;

      var hiddenSource = wrapper.querySelector('.avise-me-hidden-product-data');
      var cf7Form = wrapper.querySelector('.wpcf7 form');
      if (!hiddenSource || !cf7Form || cf7Form.dataset.productDataInjected === 'true') return;

      ['product_id', 'product_name', 'product_url'].forEach(function(name) {
        var sourceInput = hiddenSource.querySelector('[name="' + name + '"]');
        if (!sourceInput) return;

        var targetInput = cf7Form.querySelector('[name="' + name + '"]');
        if (targetInput) {
          targetInput.value = sourceInput.value;
        } else {
          var input = document.createElement('input');
          input.type = 'hidden';
          input.name = name;
          input.value = sourceInput.value;
          cf7Form.appendChild(input);
        }
      });

      cf7Form.dataset.productDataInjected = 'true';
    });
  </script>
<?php
  return ob_get_clean();
}
add_shortcode('avise_me_form', 'brazil_home_avise_me_shortcode');

add_action('woocommerce_coupon_is_valid', function ($valid, $coupon) {
  if ($coupon->get_code() === 'primeiracompra') {
    $user_id = get_current_user_id();

    if ($user_id) {
      $customer_orders = wc_get_orders([
        'customer_id' => $user_id,
        'status'      => ['completed', 'processing', 'on-hold'],
        'limit'       => 1,
      ]);

      if (!empty($customer_orders)) {
        wc_add_notice(__('Este cupom é válido apenas para a primeira compra.', 'woocommerce'), 'error');
        return false;
      }
    } else {
      wc_add_notice(__('Você precisa estar logado para usar este cupom.', 'woocommerce'), 'error');
      return false;
    }
  }

  return $valid;
}, 10, 2);

add_action('pre_get_posts', 'bh_order_products_by_stock_status');
function bh_order_products_by_stock_status($query)
{
  if (is_admin()) return;
  if (!$query->is_main_query()) return;

  if ($query->get('post_type') === 'product' || $query->is_shop() || $query->is_product_taxonomy() || $query->is_search()) {
    $query->set('meta_key', '_stock_status');
    $query->set('orderby', array(
      'meta_value' => 'ASC',
      'menu_order' => 'ASC',
      'title' => 'ASC'
    ));
  }
}

add_filter('woocommerce_related_products_args', 'bh_related_order_stock_status');
function bh_related_order_stock_status($args)
{
  $args['meta_key'] = '_stock_status';
  $args['orderby'] = array(
    'meta_value' => 'ASC',
  );
  return $args;
}

/*
add_action('wp_ajax_apply_coupon_custom', 'apply_coupon_custom');
add_action('wp_ajax_nopriv_apply_coupon_custom', 'apply_coupon_custom');

function apply_coupon_custom()
{
  if (!WC()->cart) {
    wp_send_json_error('Carrinho não encontrado');
  }

  check_ajax_referer('apply-coupon', 'security');

  $coupon = sanitize_text_field($_POST['coupon_code'] ?? '');

  if (!$coupon) {
    wp_send_json_error('Cupom inválido');
  }

  if (WC()->cart->apply_coupon($coupon)) {
    WC()->cart->calculate_totals();
    wp_send_json_success();
  }

  wp_send_json_error('Cupom inválido ou expirado');
}*/

add_filter('woocommerce_checkout_fields', function ($fields) {

  if (isset($fields['billing']['billing_ie'])) {
    $fields['billing']['billing_ie']['required'] = false;
  }

  return $fields;
}, 100);

// 2) Address fields (validação interna do WC)
add_filter('woocommerce_default_address_fields', function ($fields) {

  if (isset($fields['state_registration'])) {
    $fields['state_registration']['required'] = false;
  }

  return $fields;
}, 100);

// 3) Mata validação forçada no checkout (Brazilian Market costuma validar aqui)
add_action('woocommerce_after_checkout_validation', function ($data, $errors) {

  foreach ($errors->get_error_codes() as $code) {
    if (
      stripos($code, 'ie') !== false ||
      stripos($code, 'state_registration') !== false ||
      stripos($code, 'inscricao') !== false
    ) {
      $errors->remove($code);
    }
  }
}, 100, 2);

// PHP CALCULO FRETE PAGINA PRODUTO
add_action('wp_ajax_get_shipping_nonce', 'brazilhome_get_shipping_nonce');
add_action('wp_ajax_nopriv_get_shipping_nonce', 'brazilhome_get_shipping_nonce');

function brazilhome_get_shipping_nonce()
{
  wp_send_json_success([
    'nonce' => wp_create_nonce('brazil_home_shipping')
  ]);
}

add_action('wp_footer', function() {
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var sliders = document.querySelectorAll('.custom-hero-slider, .custom-slide');
            sliders.forEach(function(slider) {
                slider.remove();
            });
        });
    </script>
    <?php
});

function custom_enqueue_checkout_scripts()
{
  if (is_checkout()) {
    wp_enqueue_script('wc-password-strength-meter');
    wp_enqueue_style('woocommerce-general');
  }
}
add_action('wp_enqueue_scripts', 'custom_enqueue_checkout_scripts');
