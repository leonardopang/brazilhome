<?php
/**
 * Cart Page Template
 * Following Brazil Home Theme Design System
 * 
 * @package Brazil Home Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<!-- Main Content -->
<main class="cart-page-main">


    <!-- Cart Section -->
    <section class="cart-page-section">
        <div class="cart-page-container">
            <h1 class="cart-page-title">Meu Carrinho</h1>

            <?php if (WC()->cart->is_empty()): ?>
            <div class="cart-empty-message">
                <p>Seu carrinho está vazio.</p>
                <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="cart-continue-shopping-btn">Continuar
                    Comprando</a>
            </div>
            <?php else: ?>

            <form class="cart-page-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

                <div class="cart-page-content">
                    <!-- Cart Items -->
                    <div class="cart-items-section">

                        <!-- Cart Items Header -->
                        <div class="cart-items-header">
                            <div class="cart-header-produtos">PRODUTOS</div>
                            <div class="cart-header-preco">PREÇO</div>
                            <div class="cart-header-quantidade">QUANTIDADE</div>
                            <div class="cart-header-subtotal">SUB TOTAL</div>
                        </div>

                        <!-- Cart Items List -->
                        <div class="cart-items-list">
                            <?php
                                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                                        ?>

                            <div class="cart-item-row">
                                <!-- Product Info -->
                                <div class="cart-item-produto">
                                    <div class="cart-item-image">
                                        <?php
                                                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                                                    if (!$product_permalink) {
                                                        echo $thumbnail;
                                                    } else {
                                                        printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
                                                    }
                                                    ?>
                                    </div>
                                    <div class="cart-item-details">
                                        <h3 class="cart-item-name">
                                            <?php
                                                        if (!$product_permalink) {
                                                            echo wp_kses_post($_product->get_name());
                                                        } else {
                                                            echo wp_kses_post(sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()));
                                                        }
                                                        ?>
                                        </h3>
                                    </div>
                                </div>

                                <!-- Product Price -->
                                <div class="cart-item-preco">
                                    <?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); ?>
                                </div>

                                <!-- Product Quantity -->
                                <div class="cart-item-quantidade">
                                    <div class="cart-quantity-controls">
                                        <button type="button" class="cart-quantity-decrease">-</button>
                                        <input type="number" name="cart[<?php echo $cart_item_key; ?>][qty]"
                                            value="<?php echo $cart_item['quantity']; ?>" min="0"
                                            max="<?php echo $_product->get_max_purchase_quantity(); ?>"
                                            class="cart-quantity-input">
                                        <button type="button" class="cart-quantity-increase">+</button>
                                    </div>
                                    <button type="button" class="cart-item-remove"
                                        data-cart-item-key="<?php echo $cart_item_key; ?>">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M8 10L12 6M12 10L8 6M19 10C19 14.9706 14.9706 19 10 19C5.02944 19 1 14.9706 1 10C1 5.02944 5.02944 1 10 1C14.9706 1 19 5.02944 19 10Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Product Subtotal -->
                                <div class="cart-item-subtotal">
                                    <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                                </div>
                            </div>

                            <?php
                                    }
                                }
                                ?>
                        </div>

                        <!-- Coupon Section -->
                        <div class="cart-coupon-section">
                            <div class="cart-coupon-input-group">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/voucher-icon.svg"
                                    alt="Cupom" class="cart-coupon-icon">
                                <input type="text" name="coupon_code" class="cart-coupon-input"
                                    placeholder="CÓDIGO DO CUPOM">
                                <button type="submit" name="apply_coupon" class="cart-coupon-apply-btn">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                            <div class="cart-coupon-actions">
                                <div class="cart-total-display"><?php echo WC()->cart->get_cart_total(); ?></div>
                                <a href="<?php echo home_url('/todos-os-produtos/'); ?>"
                                    class="cart-continue-shopping-btn">
                                    Comprar mais produtos
                                </a>
                            </div>
                        </div>


                    </div>

                    <!-- Cart Totals Sidebar -->
                    <div class="cart-totals-section">
                        <div class="cart-totals-wrapper">
                            <h3 class="cart-totals-title">TOTAIS DO CARRINHO</h3>

                            <div class="cart-totals-row">
                                <span class="cart-totals-label">SUBTOTAL</span>
                                <span class="cart-totals-value"> <?php echo WC()->cart->get_cart_subtotal(); ?></span>
                            </div>

                            <div class="cart-totals-row cart-totals-final">
                                <span class="cart-totals-label">TOTAL</span>
                                <span class="cart-totals-value"><?php echo WC()->cart->get_cart_total(); ?></span>
                            </div>

                            <a href="<?php echo wc_get_checkout_url(); ?>" class="cart-checkout-btn">AVANÇAR</a>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="update_cart" value="Update Cart" />
                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
            </form>

            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>