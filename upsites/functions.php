<?php

if (!defined('ABSPATH')) {
  exit;
}

/* url da pasta upsites no thema */
$upsites = get_template_directory() . '/upsites/';

/** 
 * After theme setup hook actions
 */
add_action('after_setup_theme', function () {

  add_theme_support('widgets');
  add_theme_support('woocommerce');
  add_theme_support('wc-product-gallery-zoom');
  add_theme_support('wc-product-gallery-lightbox');
  add_theme_support('wc-product-gallery-slider');
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');

  // This theme uses wp_nav_menu() in two locations.
  register_nav_menus(
    array(
      'menu' => __('Top Menu', 'upsites'),
      'menufooter' => __('Footer Menu', 'upsites'),
    )
  );
  add_theme_support(
    'custom-logo',
    array(
      'height' => 197,
      'width' => 50,
      'flex-height' => true,
      'flex-width' => true,
    )
  );
});


// Note: this boilerplate block used to re-enqueue assets/css/main.css and
// assets/js/main.js a second time under the 'theme' handle, duplicating the
// 'brazil-home-main' enqueue in the theme's own functions.php. That double
// load of main.js registered every click listener twice, so cart quantity
// +/- buttons incremented by 2 per click. Removed as dead/duplicate.


/*add_action('admin_enqueue_scripts', function () {
  $assets_src = get_template_directory_uri() . '/assets';
  $version = wp_get_theme()->get('Version');

  wp_enqueue_style('admincss', "{$assets_src}/css/admin.css", [], $version, 'all');
  wp_enqueue_script('adminjs', "{$assets_src}/js/admin.js", ['jquery'], $version, true);

  wp_localize_script('adminjs', 'usAjaxAdmin', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'nonce'   => wp_create_nonce('nonce')
  ));
  wp_enqueue_script('adminjs');
});*/


/* CUSTOMIZER_REPEATER_VERSION */
define('CUSTOMIZER_REPEATER_VERSION', '1.1.0');
require $upsites . 'customizer-repeater/inc/customizer.php';

/* US_SET_POST_VIEWS */
define('US_SET_POST_VIEWS', '1.1.0');
require $upsites . 'post-views/post-views.php';

/* US_CUSTOMIZER_CONTROLS */
define('US_CUSTOMIZER_CONTROLS', '1.1.0');
require $upsites . 'customizer-controls/customizer-controls.php';

/* US_CUSTOMIZER_REGISTER */
define('US_CUSTOMIZER_REGISTER', '1.1.0');
require $upsites . 'customizer-register/customizer-register.php';

/* US_COMMENTS */
define('US_COMMENTS', '1.1.0');
require $upsites . 'comments/comments.php';

/* US_PAGINATION */
/**
 * US_paging_nav($postcat, $paged, $maxpages)
 */
define('US_PAGINATION', '1.1.0');
require $upsites . 'pagination/pagination.php';

/* US_TERMS */
/** 
 * Return Category Primary
 * US_term_list(get_the_ID(), 'category', 'tag')
 * link = Return category more permalink
 * tags = Return only category text 
 */
define('US_TERMS', '1.1.0');
require $upsites . 'terms/terms.php';

/* add in menu */
function US_add_link_my_account($items)
{
  unset($items['downloads']);
  $newitems = array(
    'orders' => __('Pedidos', 'woocommerce'),
    'edit-address' => __('Endereços', 'woocommerce'),
    'edit-account' => __('Detalhes da Conta', 'woocommerce'),
    'customer-logout' => __('Log out', 'woocommerce'),
  );
  return $newitems;
}
add_filter('woocommerce_account_menu_items', 'US_add_link_my_account');
/* end: add in menu */