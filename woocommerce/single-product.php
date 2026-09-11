<?php

/**
 * The Template for displaying all single products
 * Uses the exact structure from detalhes.html
 * Custom Brazil Home Theme Template
 *
 * @package Brazil Home Theme
 * @version 1.6.4
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

get_header();

global $product;
?>

<!-- Main Content -->
<main class="product-details-main">
  <!-- Breadcrumb -->
  <section class="breadcrumb-section">
    <div class="product-details-container">
      <nav class="breadcrumb">
        <a href="<?php echo home_url(); ?>" class="breadcrumb-link">HOME</a>
        <span class="breadcrumb-separator">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bread-divider.png" />
        </span>
        <?php
        $terms = get_the_terms(get_the_ID(), 'product_cat');
        if ($terms && !is_wp_error($terms)):
          $main_term = array_pop($terms);
        ?>
          <a href="<?php echo get_term_link($main_term); ?>"
            class="breadcrumb-link"><?php echo strtoupper($main_term->name); ?></a>
          <span class="breadcrumb-separator">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bread-divider.png" />

          </span>
        <?php endif; ?>
        <span class="breadcrumb-current"><?php echo strtoupper(get_the_title()); ?></span>
      </nav>
    </div>
  </section>

  <!-- Product Details -->
  <section class="product-details-section">
    <div class="product-details-container">
      <div class="product-details-grid">
        <!-- Product Gallery -->
        <div class="product-gallery">
          <div class="main-image">
            <?php
            // Main product image
            if (has_post_thumbnail()):
            ?>
              <div>
                <?php the_post_thumbnail('woocommerce_single', array('alt' => get_the_title())); ?>
              </div>
            <?php
            else:
            ?>
              <div>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product.png"
                  alt="<?php echo get_the_title(); ?>">
              </div>
              <?php
            endif;

            // Gallery images for slider
            $attachment_ids = $product->get_gallery_image_ids();
            if ($attachment_ids):
              foreach ($attachment_ids as $attachment_id):
              ?>
                <div>
                  <?php echo wp_get_attachment_image($attachment_id, 'woocommerce_single'); ?>
                </div>
            <?php
              endforeach;
            endif;
            ?>
          </div>

          <div class="gallery-carousel-container">
            <div class="thumbnail-gallery">
              <?php
              // Main product image thumbnail
              if (has_post_thumbnail()):
              ?>
                <div class="thumbnail">
                  <?php the_post_thumbnail('woocommerce_gallery_thumbnail'); ?>
                </div>
                <?php
              endif;

              // Gallery thumbnails
              if ($attachment_ids):
                foreach ($attachment_ids as $attachment_id):
                ?>
                  <div class="thumbnail">
                    <?php echo wp_get_attachment_image($attachment_id, 'woocommerce_gallery_thumbnail'); ?>
                  </div>
              <?php
                endforeach;
              endif;
              ?>
            </div>
          </div>
        </div>

        <!-- Product Info -->
        <div class="product-info">
          <div class="product-header">
            <div class="product-badges">
              <span class="product-status ">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/truck-delivery.png"
                  alt="Frete grátis" class="feature-icon">
                FRETE GRÁTIS</span>
              <?php if ($product->is_in_stock()): ?>

                <span class="product-status ">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/package-delivered.png"
                    alt="Delivery" class="cep-icon">
                  EM ESTOQUE</span>
              <?php else: ?>
                <span class="product-status ">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/package-delivered.png"
                    alt="Delivery" class="cep-icon">
                  EM BREVE</span>
              <?php endif; ?>
            </div>
            <h1 class="product-title"><?php the_title(); ?></h1>
            <?php if ($product->get_short_description()): ?>
              <p class="product-description">
                <?php echo $product->get_short_description(); ?>
              </p>
            <?php endif; ?>
          </div>

          <?php if ($product->get_review_count()): ?>
            <div class="product-rating">
              <div class="rating-stars">
                <?php
                $average_rating = $product->get_average_rating();
                $rounded_rating = round($average_rating);
                for ($i = 1; $i <= 5; $i++): ?>
                  <span class="star <?php echo ($i <= $rounded_rating) ? 'filled' : ''; ?>">★</span>
                <?php endfor; ?>
              </div>
              <span class="rating-text">
                <?php echo $average_rating; ?>/5 (<?php echo $product->get_review_count(); ?> avaliações)
              </span>
            </div>
          <?php endif; ?>

          <div class="product-price">
            <span class="product-price-current">
              <?php echo $product->get_price_html(); ?>

            </span>
            <?php if ($product->get_price()): ?>
              <div class="product-price-installments">
                <span
                  class="product-price-installments-text"><?php echo brazil_home_get_installment_text($product->get_price()); ?></span>
              </div>
            <?php endif; ?>

          </div>

          <div class="product-options">
            <?php if ($product->is_in_stock()): ?>
              <div class="cep-calculator">
                <div class="cep-input-group">
                  <div class="cep-input-container">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/truck-delivery.png"
                      alt="Delivery" class="cep-icon">
                    <input type="text" id="cep" class="cep-input"
                      placeholder="Calcule o frete Informe seu CEP" maxlength="9">
                  </div>
                  <button type="button" class="cep-button"
                    onclick="window.calculateShipping && window.calculateShipping()">CALCULAR</button>
                </div>
                <div id="cep-results" class="cep-results" style="display: none;">
                  <!-- Shipping results will be displayed here -->
                </div>
              </div>
            <?php endif; ?>
            <?php if ($product->is_purchasable() && $product->is_in_stock()): ?>
              <div class="product-actions-row">
                <div class="quantity-selector">
                  <div class="quantity-controls">
                    <button type="button" class="quantity-btn quantity-decrease">
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/minus.png"
                        alt="Minus">
                    </button>
                    <input type="number" id="quantity" class="quantity-input" value="1" min="1"
                      max="<?php echo $product->get_max_purchase_quantity(); ?>">
                    <button type="button" class="quantity-btn quantity-increase">
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/plus.png"
                        alt="Plus">
                    </button>
                  </div>
                </div>
              <?php endif; ?>
              <div class="product-actions">
                <?php if ($product->is_purchasable() && $product->is_in_stock()): ?>
                  <form class="cart"
                    action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
                    method="post" enctype='multipart/form-data'>
                    <input type="hidden" name="quantity" class="qty" value="1">
                    <button type="submit" name="add-to-cart"
                      value="<?php echo esc_attr($product->get_id()); ?>"
                      class="btn-add-cart single_add_to_cart_button">COMPRAR</button>
                  </form>
                <?php else: ?>
                  <?= do_shortcode('[avise_me_form]') ?>
                <?php endif; ?>
              </div>
              </div>
              <?php $faleConosco = get_field('button', 'tema'); ?>
              <a href="<?= $faleConosco['url']; ?>" target="<?= $faleConosco['target']; ?>" rel="noopener noreferrer" class="product-contact-link">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"></path>
                </svg>
                <?= $faleConosco['title']; ?></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Product Tabs -->
  <section class="product-tabs-section">
    <div class="product-details-container">
      <div class="tabs-header">
        <button class="tab-button active" data-tab="description">DESCRIÇÃO DO PRODUTO</button>
        <button class="tab-button" data-tab="specifications">Especificações</button>
        <button class="tab-button" data-tab="dimensions">Manual</button>
        <button class="tab-button" data-tab="maintenance">Video</button>
        <button class="tab-button" data-tab="reviews">Compare</button>
      </div>

      <div class="tabs-content">
        <div class="tab-panel active" id="description">
          <?php the_content(); ?>
        </div>

        <div class="tab-panel" id="specifications">
          <section class="product-specifications-section">
            <div class="product-details-container">
              <h3 class="specifications-title">PRINCIPAIS ESPECIFICAÇÕES E INFORMAÇÕES DO PRODUTO.</h3>
              <div class="specifications-table">
                <?php
                $attributes = $product->get_attributes();
                if ($attributes):
                  foreach ($attributes as $attribute):
                    $label = wc_attribute_label($attribute->get_name());
                    $value = $product->get_attribute($attribute->get_name());
                ?>
                    <div class="spec-row">
                      <span class="spec-label"><?php echo $label; ?></span>
                      <span class="spec-value"><?php echo $value; ?></span>
                    </div>
                  <?php
                  endforeach;
                endif;

                // Add dimensions as part of the specifications table
                if ($product->get_length()) {
                  ?>
                  <div class="spec-row">
                    <span class="spec-label">Comprimento</span>
                    <span
                      class="spec-value"><?php echo $product->get_length() . ' ' . get_option('woocommerce_dimension_unit'); ?></span>
                  </div>
                <?php
                }
                if ($product->get_width()) {
                ?>
                  <div class="spec-row">
                    <span class="spec-label">Largura</span>
                    <span
                      class="spec-value"><?php echo $product->get_width() . ' ' . get_option('woocommerce_dimension_unit'); ?></span>
                  </div>
                <?php
                }
                if ($product->get_height()) {
                ?>
                  <div class="spec-row">
                    <span class="spec-label">Altura</span>
                    <span
                      class="spec-value"><?php echo $product->get_height() . ' ' . get_option('woocommerce_dimension_unit'); ?></span>
                  </div>
                <?php
                }
                if ($product->get_weight()) {
                ?>
                  <div class="spec-row">
                    <span class="spec-label">Peso</span>
                    <span
                      class="spec-value"><?php echo $product->get_weight() . ' ' . get_option('woocommerce_weight_unit'); ?></span>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
          </section>
        </div>

        <div class="tab-panel" id="dimensions">
          <div class="manual-content">
            <?php
            $manual_file_url = get_post_meta(get_the_ID(), '_produto_manual_file', true);
            if ($manual_file_url): ?>
              <div class="manual-download-section">
                <h3>Manual do Produto</h3>
                <p>Baixe o manual completo do produto em PDF:</p>
                <a href="<?php echo esc_url($manual_file_url); ?>" class="manual-download-btn" download
                  target="_blank">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-download-icon.png"
                    alt="Download" class="download-icon">
                  BAIXAR MANUAL
                </a>
              </div>
            <?php else: ?>
              <div class="manual-not-available">
                <h3>Manual do Produto</h3>
                <p>Manual não disponível para este produto no momento.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="tab-panel" id="maintenance">
          <div class="product-video-container">
            <?php
            $youtube_url = get_post_meta(get_the_ID(), '_produto_youtube_video', true);
            if ($youtube_url):
              $embed_url = brazil_home_get_produto_youtube_embed_url($youtube_url);
              if ($embed_url): ?>
                <iframe src="<?php echo esc_url($embed_url); ?>" title="Product Video" frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  allowfullscreen>
                </iframe>
              <?php else: ?>
                <div class="video-not-available">
                  <h3>Vídeo do Produto</h3>
                  <p>URL do vídeo inválida.</p>
                </div>
              <?php endif; ?>
            <?php else: ?>
              <div class="video-not-available">
                <h3>Vídeo do Produto</h3>
                <p>Vídeo não disponível para este produto no momento.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="tab-panel" id="reviews">
          <div class="product-comparison-content">
            <?php
            // Get comparison products from ACF (custom post type)
            $comparison_product_1_id = get_field('comparison_product_1');
            $comparison_product_2_id = get_field('comparison_product_2');

            $comparison_products = array();

            if ($comparison_product_1_id) {
              $comparison_products[] = array(
                'id' => $comparison_product_1_id,
                'title' => get_the_title($comparison_product_1_id),
                'price' => get_post_meta($comparison_product_1_id, '_comparison_price', true),
                'dimensions' => get_post_meta($comparison_product_1_id, '_comparison_dimensions', true),
                'weight' => get_post_meta($comparison_product_1_id, '_comparison_weight', true),
                'stock_status' => get_post_meta($comparison_product_1_id, '_comparison_stock_status', true),
                'image_id' => get_post_thumbnail_id($comparison_product_1_id),
                'attributes' => get_field('comparison_attributes', $comparison_product_1_id)
              );
            }

            if ($comparison_product_2_id) {
              $comparison_products[] = array(
                'id' => $comparison_product_2_id,
                'title' => get_the_title($comparison_product_2_id),
                'price' => get_post_meta($comparison_product_2_id, '_comparison_price', true),
                'dimensions' => get_post_meta($comparison_product_2_id, '_comparison_dimensions', true),
                'weight' => get_post_meta($comparison_product_2_id, '_comparison_weight', true),
                'stock_status' => get_post_meta($comparison_product_2_id, '_comparison_stock_status', true),
                'image_id' => get_post_thumbnail_id($comparison_product_2_id),
                'attributes' => get_field('comparison_attributes', $comparison_product_2_id)
              );
            }

            if (!empty($comparison_products)):
            ?>
              <h3 class="comparison-title">COMPARAÇÃO DE PRODUTOS</h3>
              <div class="comparison-table-wrapper">
                <!-- Desktop Table View -->
                <table class="product-comparison-table">
                  <thead>
                    <tr>
                      <th>Especificação</th>
                      <th class="current-product"><?php echo get_the_title(); ?></th>
                      <?php foreach ($comparison_products as $compare_product): ?>
                        <th><?php echo esc_html($compare_product['title']); ?></th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Product Image -->
                    <tr>
                      <td class="spec-label">Imagem</td>
                      <td class="current-product">
                        <?php if (has_post_thumbnail()): ?>
                          <?php the_post_thumbnail('thumbnail'); ?>
                        <?php else: ?>
                          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product.png" alt="<?php echo get_the_title(); ?>">
                        <?php endif; ?>
                      </td>
                      <?php foreach ($comparison_products as $compare_product): ?>
                        <td>
                          <?php if ($compare_product['image_id']): ?>
                            <?php echo wp_get_attachment_image($compare_product['image_id'], 'thumbnail'); ?>
                          <?php else: ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product.png" alt="<?php echo esc_attr($compare_product['title']); ?>">
                          <?php endif; ?>
                        </td>
                      <?php endforeach; ?>
                    </tr>

                    <!-- Price -->
                    <tr>
                      <td class="spec-label">Preço</td>
                      <td class="current-product"><?php echo $product->get_price_html(); ?></td>
                      <?php foreach ($comparison_products as $compare_product): ?>
                        <td><?php echo !empty($compare_product['price']) ? esc_html($compare_product['price']) : '—'; ?></td>
                      <?php endforeach; ?>
                    </tr>

                    <!-- Attributes -->
                    <?php
                    // Get all attributes from all products
                    $all_attributes = array();

                    // Current product attributes (WooCommerce)
                    $current_attributes = $product->get_attributes();
                    foreach ($current_attributes as $attribute) {
                      $attr_name = wc_attribute_label($attribute->get_name());
                      if (!isset($all_attributes[$attr_name])) {
                        $all_attributes[$attr_name] = array('current' => $product->get_attribute($attribute->get_name()));
                      }
                    }

                    // Comparison products attributes (ACF)
                    foreach ($comparison_products as $index => $compare_product) {
                      if (!empty($compare_product['attributes']) && is_array($compare_product['attributes'])) {
                        foreach ($compare_product['attributes'] as $attr) {
                          $attr_name = $attr['attribute_name'];
                          if (!isset($all_attributes[$attr_name])) {
                            $all_attributes[$attr_name] = array('current' => '—');
                          }
                          $all_attributes[$attr_name]['compare_' . $index] = $attr['attribute_value'];
                        }
                      }
                    }

                    // Display each attribute
                    foreach ($all_attributes as $attr_name => $values):
                    ?>
                      <tr>
                        <td class="spec-label"><?php echo esc_html($attr_name); ?></td>
                        <td class="current-product">
                          <?php echo isset($values['current']) ? esc_html($values['current']) : '—'; ?>
                        </td>
                        <?php foreach ($comparison_products as $index => $compare_product): ?>
                          <td>
                            <?php echo isset($values['compare_' . $index]) ? esc_html($values['compare_' . $index]) : '—'; ?>
                          </td>
                        <?php endforeach; ?>
                      </tr>
                    <?php endforeach; ?>

                    <!-- Dimensions -->
                    <tr>
                      <td class="spec-label">Dimensões (C x L x A)</td>
                      <td class="current-product">
                        <?php
                        $dimensions = array();
                        if ($product->get_length()) $dimensions[] = $product->get_length();
                        if ($product->get_width()) $dimensions[] = $product->get_width();
                        if ($product->get_height()) $dimensions[] = $product->get_height();
                        if (!empty($dimensions)) {
                          echo implode(' x ', $dimensions) . ' ' . get_option('woocommerce_dimension_unit');
                        } else {
                          echo '—';
                        }
                        ?>
                      </td>
                      <?php foreach ($comparison_products as $compare_product): ?>
                        <td>
                          <?php echo !empty($compare_product['dimensions']) ? esc_html($compare_product['dimensions']) : '—'; ?>
                        </td>
                      <?php endforeach; ?>
                    </tr>

                    <!-- Weight -->
                    <tr>
                      <td class="spec-label">Peso</td>
                      <td class="current-product">
                        <?php
                        if ($product->get_weight()) {
                          echo $product->get_weight() . ' ' . get_option('woocommerce_weight_unit');
                        } else {
                          echo '—';
                        }
                        ?>
                      </td>
                      <?php foreach ($comparison_products as $compare_product): ?>
                        <td>
                          <?php echo !empty($compare_product['weight']) ? esc_html($compare_product['weight']) : '—'; ?>
                        </td>
                      <?php endforeach; ?>
                    </tr>

                    <!-- Stock Status -->
                    <tr>
                      <td class="spec-label">Disponibilidade</td>
                      <td class="current-product">
                        <?php echo $product->is_in_stock() ? '<span class="in-stock">Em Estoque</span>' : '<span class="out-of-stock">Fora de Estoque</span>'; ?>
                      </td>
                      <?php foreach ($comparison_products as $compare_product): ?>
                        <td>
                          <?php
                          $stock = $compare_product['stock_status'];
                          if ($stock === 'instock') {
                            echo '<span class="in-stock">Em Estoque</span>';
                          } else {
                            echo '<span class="out-of-stock">Fora de Estoque</span>';
                          }
                          ?>
                        </td>
                      <?php endforeach; ?>
                    </tr>
                  </tbody>
                </table>

                <!-- Mobile Card View -->
                <div class="mobile-comparison-cards">
                  <!-- Current Product Card -->
                  <div class="mobile-product-card current-product">
                    <div class="mobile-product-header">
                      <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('thumbnail'); ?>
                      <?php else: ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product.png" alt="<?php echo get_the_title(); ?>">
                      <?php endif; ?>
                      <div class="mobile-product-title">
                        <h4><?php echo get_the_title(); ?></h4>
                        <div class="mobile-product-price"><?php echo $product->get_price_html(); ?></div>
                      </div>
                    </div>
                    <div class="mobile-product-specs">
                      <?php
                      // Get all attributes for current product
                      $current_attributes = $product->get_attributes();
                      foreach ($current_attributes as $attribute) {
                        $attr_name = wc_attribute_label($attribute->get_name());
                        $attr_value = $product->get_attribute($attribute->get_name());
                      ?>
                        <div class="mobile-spec-row">
                          <span class="mobile-spec-label"><?php echo esc_html($attr_name); ?></span>
                          <span class="mobile-spec-value"><?php echo esc_html($attr_value); ?></span>
                        </div>
                      <?php } ?>

                      <!-- Dimensions -->
                      <div class="mobile-spec-row">
                        <span class="mobile-spec-label">Dimensões</span>
                        <span class="mobile-spec-value">
                          <?php
                          $dimensions = array();
                          if ($product->get_length()) $dimensions[] = $product->get_length();
                          if ($product->get_width()) $dimensions[] = $product->get_width();
                          if ($product->get_height()) $dimensions[] = $product->get_height();
                          if (!empty($dimensions)) {
                            echo implode(' x ', $dimensions) . ' ' . get_option('woocommerce_dimension_unit');
                          } else {
                            echo '—';
                          }
                          ?>
                        </span>
                      </div>

                      <!-- Weight -->
                      <div class="mobile-spec-row">
                        <span class="mobile-spec-label">Peso</span>
                        <span class="mobile-spec-value">
                          <?php
                          if ($product->get_weight()) {
                            echo $product->get_weight() . ' ' . get_option('woocommerce_weight_unit');
                          } else {
                            echo '—';
                          }
                          ?>
                        </span>
                      </div>

                      <!-- Availability -->
                      <div class="mobile-spec-row">
                        <span class="mobile-spec-label">Disponibilidade</span>
                        <span class="mobile-spec-value">
                          <?php echo $product->is_in_stock() ? '<span class="in-stock">Em Estoque</span>' : '<span class="out-of-stock">Fora de Estoque</span>'; ?>
                        </span>
                      </div>
                    </div>
                  </div>

                  <!-- Comparison Products Cards -->
                  <?php foreach ($comparison_products as $compare_product): ?>
                    <div class="mobile-product-card">
                      <div class="mobile-product-header">
                        <?php if ($compare_product['image_id']): ?>
                          <?php echo wp_get_attachment_image($compare_product['image_id'], 'thumbnail'); ?>
                        <?php else: ?>
                          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product.png" alt="<?php echo esc_attr($compare_product['title']); ?>">
                        <?php endif; ?>
                        <div class="mobile-product-title">
                          <h4><?php echo esc_html($compare_product['title']); ?></h4>
                          <div class="mobile-product-price"><?php echo !empty($compare_product['price']) ? esc_html($compare_product['price']) : '—'; ?></div>
                        </div>
                      </div>
                      <div class="mobile-product-specs">
                        <?php
                        // Display attributes from comparison product
                        if (!empty($compare_product['attributes']) && is_array($compare_product['attributes'])) {
                          foreach ($compare_product['attributes'] as $attr) {
                        ?>
                            <div class="mobile-spec-row">
                              <span class="mobile-spec-label"><?php echo esc_html($attr['attribute_name']); ?></span>
                              <span class="mobile-spec-value"><?php echo esc_html($attr['attribute_value']); ?></span>
                            </div>
                        <?php }
                        }
                        ?>

                        <!-- Dimensions -->
                        <div class="mobile-spec-row">
                          <span class="mobile-spec-label">Dimensões</span>
                          <span class="mobile-spec-value"><?php echo !empty($compare_product['dimensions']) ? esc_html($compare_product['dimensions']) : '—'; ?></span>
                        </div>

                        <!-- Weight -->
                        <div class="mobile-spec-row">
                          <span class="mobile-spec-label">Peso</span>
                          <span class="mobile-spec-value"><?php echo !empty($compare_product['weight']) ? esc_html($compare_product['weight']) : '—'; ?></span>
                        </div>

                        <!-- Availability -->
                        <div class="mobile-spec-row">
                          <span class="mobile-spec-label">Disponibilidade</span>
                          <span class="mobile-spec-value">
                            <?php
                            $stock = $compare_product['stock_status'];
                            if ($stock === 'instock') {
                              echo '<span class="in-stock">Em Estoque</span>';
                            } else {
                              echo '<span class="out-of-stock">Fora de Estoque</span>';
                            }
                            ?>
                          </span>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php else: ?>
              <div class="no-comparison">
                <p>Não há produtos disponíveis para comparação no momento.</p>
              </div>
            <?php endif; ?>

            <!-- Review Button -->
            <div class="comparison-review-button">
              <?php if (comments_open() || get_comments_number()): ?>
                <button class="btn-leave-review"
                  onclick="document.getElementById('reviews').scrollIntoView({behavior: 'smooth'})">
                  DEIXAR MINHA AVALIAÇÃO
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Product Specifications Section -->

  <!-- FAQ Section -->
  <section class="faq-section">
    <div class="faq-content">
      <div class="faq-intro">
        <h2 class="faq-title">PERGUNTAS FREQUENTES</h2>
        <p class="faq-description">Tire suas dúvidas sobre este produto.</p>
      </div>

      <div class="faq-list">
        <?php
        $faqs = brazil_home_get_product_faqs();
        if (!empty($faqs)):
          foreach ($faqs as $faq):
        ?>
            <div class="faq-item">
              <div class="faq-question">
                <div class="faq-question-icon-container">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/checkmark-circle-02.png"
                    alt="Check" class="faq-icon">
                </div>
              </div>
              <div class="faq-question-text-container">
                <span class="faq-question-text"><?php echo esc_html($faq['question']); ?></span>
                <p><?php echo esc_html($faq['answer']); ?></p>
              </div>
            </div>
          <?php
          endforeach;
        else:
          // Fallback content if no FAQs are configured
          ?>
          <div class="faq-item">
            <div class="faq-question">
              <div class="faq-question-icon-container">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/checkmark-circle-02.png"
                  alt="Check" class="faq-icon">
              </div>
            </div>
            <div class="faq-question-text-container">
              <span class="faq-question-text">COMO FUNCIONA A ENTREGA?</span>
              <p>A entrega é realizada pelos Correios ou transportadora, conforme região de destino. O prazo
                varia de 7 a 15 dias úteis.</p>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Reviews Section -->
  <section class="reviews-summary-section">
    <div class="product-details-container">
      <div class="reviews-header">
        <h2 class="reviews-title">AVALIAÇÕES<br>DOS CLIENTES</h2>
        <?php if (comments_open() || get_comments_number()): ?>
          <button class="btn-leave-review"
            onclick="document.getElementById('reviews').scrollIntoView({behavior: 'smooth'})">
            DEIXAR MINHA AVALIAÇÃO
          </button>
        <?php endif; ?>
      </div>

      <?php
      // Get real reviews from WooCommerce
      $real_reviews = get_comments(array(
        'post_id' => get_the_ID(),
        'status' => 'approve',
        'type' => 'review',
        'number' => 50
      ));

      // Get custom reviews from ACF
      $custom_reviews = array();
      if (function_exists('get_field')) {
        $custom_reviews_data = get_field('product_custom_reviews');

        if (!empty($custom_reviews_data)) {
          foreach ($custom_reviews_data as $custom_review) {

            $review_obj = new stdClass();
            $review_obj->comment_author = $custom_review['author'];
            $review_obj->comment_content = $custom_review['content'];
            $review_obj->rating = $custom_review['rating'];
            $review_obj->is_custom = true;

            // Foto do avaliador
            $review_obj->reviewer_picture = !empty($custom_review['reviewer_picture'])
              ? $custom_review['reviewer_picture']
              : null;

            // Data
            $review_obj->date_display = !empty($custom_review['date'])
              ? $custom_review['date']
              : '1 semana atrás';

            // ⭐ ADICIONA A GALERIA
            $review_obj->gallery = !empty($custom_review['imagens_produto'])
              ? $custom_review['imagens_produto']
              : array();

            $custom_reviews[] = $review_obj;
          }
        }
      }

      // Converte reviews reais
      $standardized_real_reviews = array();
      foreach ($real_reviews as $review) {
        $review->rating = get_comment_meta($review->comment_ID, 'rating', true);
        $review->is_custom = false;
        $review->reviewer_picture = null;
        $review->gallery = array(); // REAL NÃO TEM FOTOS
        $standardized_real_reviews[] = $review;
      }

      // Junta tudo
      $all_reviews = array_merge($custom_reviews, $standardized_real_reviews);

      // Limita carrossel
      $reviews = array_slice($all_reviews, 0, 10);

      if (!empty($reviews)): ?>
        <div class="reviews-carousel-container">
          <button class="reviews-nav-arrow reviews-nav-prev" id="reviews-prev">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/left-arrow.png" alt="Anterior">
          </button>

          <div class="reviews-carousel">
            <?php foreach ($reviews as $review): ?>
              <div class="review-card"
                data-has-gallery="<?= !empty($review->gallery) ? '1' : '0' ?>"
                data-review='<?php echo json_encode([
                                "author" => $review->comment_author,
                                "content" => $review->comment_content,
                                "rating" => $review->rating,
                                "date" => $review->is_custom ? $review->date_display : human_time_diff(strtotime($review->comment_date), current_time('timestamp')) . " atrás",
                                "gallery" => array_map(fn($g) => $g['url'], $review->gallery)
                              ]); ?>'>

                <div class="review-header">
                  <div class="reviewer-info">
                    <?php if (!empty($review->reviewer_picture)): ?>
                      <img src="<?php echo esc_url($review->reviewer_picture['url']); ?>"
                        class="reviewer-avatar">
                    <?php else: ?>
                      <div class="reviewer-avatar-placeholder">
                        <?php echo strtoupper(substr($review->comment_author, 0, 1)); ?>
                      </div>
                    <?php endif; ?>
                    <h3 class="reviewer-name"><?php echo strtoupper($review->comment_author); ?></h3>
                  </div>

                  <div class="rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                      <span class="star <?= ($i <= round($review->rating)) ? 'filled' : '' ?>">★</span>
                    <?php endfor; ?>

                  </div>
                </div>

                <p class="review-text"><?= esc_html($review->comment_content); ?></p>
                <!--
                <?php if (!empty($review->gallery)): ?>
                  <div class="review-gallery-thumbs">
                    <?php foreach ($review->gallery as $index => $img): ?>
                      <img
                        src="<?= esc_url($img['sizes']['thumbnail']); ?>"
                        class="review-thumb"
                        data-index="<?= $index ?>"
                        data-full="<?= esc_url($img['url']); ?>"
                        data-review='<?= json_encode([
                                        "author" => $review->comment_author,
                                        "content" => $review->comment_content,
                                        "rating" => $review->rating,
                                        "date" => $review->is_custom ? $review->date_display : human_time_diff(strtotime($review->comment_date), current_time('timestamp')) . " atrás",
                                        "gallery" => array_map(fn($g) => $g['url'], $review->gallery)
                                      ]); ?>'>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?> -->

                <span class="review-date">
                  <?= $review->is_custom ? esc_html($review->date_display) : human_time_diff(strtotime($review->comment_date), current_time('timestamp')) . ' atrás'; ?>
                </span>
                <?php if (!empty($review->gallery)): ?>
                  <div class="eye-view">
                    <span>
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                          <path d="M 85.999 46.764 c -0.974 0 -1.95 -0.354 -2.721 -1.069 c -25.757 -23.91 -50.799 -23.911 -76.557 0 c -1.619 1.502 -4.15 1.41 -5.653 -0.21 c -1.503 -1.619 -1.409 -4.15 0.21 -5.653 c 29.012 -26.931 58.431 -26.93 87.443 0 c 1.619 1.503 1.713 4.034 0.21 5.653 C 88.144 46.334 87.073 46.764 85.999 46.764 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: white; fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                          <path d="M 45 70.267 c -9.741 0 -17.667 -7.926 -17.667 -17.667 S 35.259 34.933 45 34.933 S 62.667 42.858 62.667 52.6 S 54.741 70.267 45 70.267 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: white; fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        </g>
                      </svg>
                      Fotos</span>
                  </div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>

          <button class="reviews-nav-arrow reviews-nav-next" id="reviews-next">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/right-arrow.png" alt="Próximo">
          </button>

        </div>

      <?php else: ?>
        <div class="no-reviews">
          <p>Ainda não há avaliações para este produto.</p>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- MODAL COMPLETO DE REVIEWS -->
  <div id="reviewModal" class="review-modal">
    <div class="review-modal-content">

      <button class="review-modal-close">&times;</button>

      <div class="review-modal-inner">

        <!-- COLUNA ESQUERDA (IMAGEM) -->
        <div class="review-modal-left">

          <div class="review-modal-image-wrapper">
            <img id="reviewModalImage" src="">
          </div>

          <div class="review-modal-thumbs-container">

            <button class="review-modal-prev thumbs-prev"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/left-arrow.png" alt="Anterior"></button>

            <div class="review-modal-thumbs" id="reviewModalThumbs"></div>

            <button class="review-modal-next thumbs-next"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/right-arrow.png" alt="Próximo"></button>

          </div>

          <div class="review-modal-counter" id="reviewModalCounter"></div>

        </div>

        <!-- COLUNA DIREITA (TEXTO) -->
        <div class="review-modal-right">

          <h3 id="reviewModalAuthor"></h3>

          <div id="reviewModalRating"></div>

          <span id="reviewModalDate" class="modal-date"></span>

          <hr>

          <h4 id="reviewModalTitle" class="modal-title"></h4>

          <p id="reviewModalText" class="modal-comment"></p>

        </div>

      </div>

    </div>
  </div>


  <?php
  $recent_products = array();

  if (isset($_COOKIE['woocommerce_recently_viewed'])) {
    $viewed_products = array_reverse(array_map('absint', explode('|', $_COOKIE['woocommerce_recently_viewed'])));
    $viewed_products = array_filter(array_slice($viewed_products, 0, 4));

    foreach ($viewed_products as $product_id) {
      if ($product_id != get_the_ID()) {
        $recent_product = wc_get_product($product_id);
        if ($recent_product) {
          $recent_products[] = $recent_product;
        }
      }
    }
  }

  if (empty($recent_products)) {
    $related_ids = wc_get_related_products(get_the_ID(), 4);

    foreach ($related_ids as $related_id) {
      $related_product = wc_get_product($related_id);
      if ($related_product) {
        $recent_products[] = $related_product;
      }
    }
  }

  if (!empty($recent_products)) {
    usort($recent_products, function ($a, $b) {
      $map = array(
        'instock' => 0,
        'onbackorder' => 1,
        'outofstock' => 2,
      );

      $status_a = $a->get_stock_status();
      $status_b = $b->get_stock_status();

      $order_a = isset($map[$status_a]) ? $map[$status_a] : 99;
      $order_b = isset($map[$status_b]) ? $map[$status_b] : 99;

      if ($order_a === $order_b) {
        return 0;
      }

      return ($order_a < $order_b) ? -1 : 1;
    });
  }

  if ($recent_products):
  ?>
    <section class="detalhes-products-section">
      <div class="product-details-container">
        <div class="products-header">
          <h2 class="products-section-title detalhes-products-section-title">VOCÊ TAMBÉM PODE GOSTAR DE ...</h2>
        </div>

        <div class="detalhes-products-grid">
          <?php foreach ($recent_products as $recent_product): ?>
            <article class="featured-product-card" data-product-url="<?php echo get_permalink($recent_product->get_id()); ?>">
              <div class="product-image">
                <a href="<?php echo get_permalink($recent_product->get_id()); ?>">
                  <?php if (has_post_thumbnail($recent_product->get_id())): ?>
                    <?php echo get_the_post_thumbnail($recent_product->get_id(), 'woocommerce_thumbnail'); ?>
                  <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product.png" alt="<?php echo esc_attr($recent_product->get_name()); ?>">
                  <?php endif; ?>
                </a>
              </div>

              <div class="product-info">
                <h3 class="product-title">
                  <a href="<?php echo get_permalink($recent_product->get_id()); ?>">
                    <?php echo esc_html($recent_product->get_name()); ?>
                  </a>
                </h3>

                <div class="product-price">
                  <span class="product-price-current">
                    <?php echo $recent_product->get_price_html(); ?>
                  </span>

                  <?php if ($recent_product->get_price()): ?>
                    <div class="product-price-installments">
                      <span class="product-price-installments-text">
                        <?php echo brazil_home_get_installment_text($recent_product->get_price()); ?>
                      </span>
                    </div>
                  <?php endif; ?>
                </div>

                <?php if ($recent_product->is_in_stock()): ?>
                  <a href="<?php echo get_permalink($recent_product->get_id()); ?>" class="product-btn-buy">COMPRAR AGORA</a>
                <?php else: ?>
                  <a href="<?php echo get_permalink($recent_product->get_id()); ?>" class="product-btn-buy">AVISE-ME QUANDO CHEGAR</a>
                <?php endif; ?>

                <div class="product-features">
                  <span class="product-feature-item">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/truck-delivery.png" alt="Frete grátis" class="feature-icon">
                    FRETE GRÁTIS
                  </span>

                  <?php if ($recent_product->is_in_stock()): ?>
                    <span class="product-feature-item">
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/package-delivered.png" alt="Em estoque" class="feature-icon">
                      Em estoque
                    </span>
                  <?php else: ?>
                    <span class="product-feature-item out-of-stock">
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/package-delivered.png" alt="Em estoque" class="feature-icon">
                      Em Breve
                    </span>
                  <?php endif; ?>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>
</main>


<?php get_footer(); ?>