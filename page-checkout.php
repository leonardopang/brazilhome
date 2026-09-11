<?php
/**
 * Checkout Page Template
 * 
 * @package Brazil Home Theme
 */

get_header(); ?>

<main class="main-content">
    <section class="checkout-section">
        <div class="homepage-container">
            <div class="checkout-header">
                <h1 class="checkout-title">FINALIZAR COMPRA</h1>
            </div>
            
            <?php
            // Check if WooCommerce is active
            if (class_exists('WooCommerce')) {
                // Check if cart is empty
                if (WC()->cart->is_empty()) {
                    ?>
                    <div class="cart-empty">
                        <p><?php esc_html_e('Seu carrinho está vazio.', 'woocommerce'); ?></p>
                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="button">
                            <?php esc_html_e('Voltar à loja', 'woocommerce'); ?>
                        </a>
                    </div>
                    <?php
                } else {
                    // Display checkout form
                    echo do_shortcode('[woocommerce_checkout]');
                }
            } else {
                echo '<p>WooCommerce não está ativo.</p>';
            }
            ?>
        </div>
    </section>
</main>

<style>
.checkout-section {
    padding: 2rem 0;
    min-height: 60vh;
}

.checkout-header {
    text-align: center;
    margin-bottom: 3rem;
}

.checkout-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.cart-empty {
    text-align: center;
    padding: 3rem 0;
}

.cart-empty p {
    font-size: 1.2rem;
    color: #6b7280;
    margin-bottom: 2rem;
}

.cart-empty .button {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    padding: 1rem 2rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Ensure WooCommerce checkout styles work */
.woocommerce-checkout {
    max-width: 100%;
}

@media (max-width: 768px) {
    .checkout-title {
        font-size: 2rem;
    }
    
    .checkout-section {
        padding: 1rem 0;
    }
}
</style>

<?php get_footer(); ?>