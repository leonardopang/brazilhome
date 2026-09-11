<?php

/**
 * The template for displaying product content within loops
 * Custom Brazil Home Theme Template
 *
 * @package Brazil Home Theme
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || ! $product->is_visible()) {
    return;
}
?>
<article <?php wc_product_class('featured-product-card', $product); ?>>
    <div class="product-image">
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action('woocommerce_before_shop_loop_item');

        /**
         * Hook: woocommerce_before_shop_loop_item_title.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action('woocommerce_before_shop_loop_item_title');
        ?>
    </div>

    <div class="product-info">
        <?php
        /**
         * Hook: woocommerce_shop_loop_item_title.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action('woocommerce_shop_loop_item_title');
        ?>

        <div class="product-price">
            <?php
            /**
             * Hook: woocommerce_after_shop_loop_item_title.
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action('woocommerce_after_shop_loop_item_title');
            ?>

            <?php if ($product->get_price()) : ?>
                <div class="product-price-installments">
                    <span class="product-price-installments-text">
                        <?php echo brazil_home_get_installment_text($product->get_price()); ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <?php
        /**
         * Hook: woocommerce_after_shop_loop_item.
         *
         * @hooked woocommerce_template_loop_product_link_close - 5
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */
        do_action('woocommerce_after_shop_loop_item');
        ?>

        <div class="product-features">
            <span class="product-feature-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/truck-delivery.png" alt="Frete grátis" class="feature-icon">
                FRETE GRÁTIS
            </span>
            <?php if ($product->is_in_stock()) : ?>

                <span class="product-feature-item">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/package-delivered.png" alt="Em estoque" class="feature-icon">
                    Em estoque
                </span>
            <?php else : ?>
                <span class="product-feature-item out-of-stock">
                    Fora de estoque
                </span>
            <?php endif; ?>
        </div>
    </div>
</article>