<?php

/**
 * Template Name: Todos os Produtos
 * The Template for displaying all products
 * Custom Brazil Home Theme Template
 *
 * @package Brazil Home Theme
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

get_header(); ?>

<!-- Main Content -->
<main class="category-main">


  <!-- Page Header -->
  <section class="category-header">
    <div class="category-container">
      <h1 class="category-title">TODOS OS PRODUTOS</h1>
      <p class="category-description">
        Explore nossa linha completa de produtos com qualidade e preços especiais.
      </p>
      <?php
      // Show total product count
      $total_products = wp_count_posts('product');
      if ($total_products && $total_products->publish > 0): ?>
        <p class="products-count">
          <strong><?php echo $total_products->publish; ?> produtos</strong> encontrados
        </p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Products Grid -->
  <section class="category-products-section">
    <div class="category-container">
      <?php
      // Get current page for pagination
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

      // Query ALL products that exist on the site
      $args = array(
        'post_type' => 'product',
        'posts_per_page' => 12, // Show 12 products per page
        'paged' => $paged,
        'post_status' => 'publish',
        'orderby' => 'menu_order title',
        'order' => 'ASC',
        // No meta_query or tax_query restrictions to show ALL products
        'ignore_sticky_posts' => true,
        'no_found_rows' => false,
        'meta_key' => '_stock_status',
        'orderby' => array(
          'meta_value' => 'ASC',      // "instock" vem antes de "outofstock"
          'menu_order' => 'ASC',
          'title'      => 'ASC'
        )
      );

      $products_query = new WP_Query($args);

      if ($products_query->have_posts()) { ?>
        <div class="products-grid">
          <?php
          while ($products_query->have_posts()) {
            $products_query->the_post();
            global $product;
          ?>
            <article class="product-card" data-product-url="<?php echo get_permalink(); ?>">
              <div class="product-image">
                <a href="<?php echo get_permalink(); ?>">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('woocommerce_thumbnail', array('alt' => get_the_title())); ?>
                  <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-product.png"
                      alt="<?php the_title(); ?>">
                  <?php endif; ?>
                </a>
              </div>
              <div class="product-info">
                <a href="<?php echo get_permalink(); ?>">
                  <h3 class="product-title"><?php the_title(); ?></h3>
                </a>
                <div class="product-price">
                  <span class="product-price-current">
                    <?php echo $product->get_price_html(); ?>
                  </span>
                  <?php if ($product->get_price()): ?>
                    <div class="product-price-installments">
                      <span class="product-price-installments-text"><?php echo brazil_home_get_installment_text($product->get_price()); ?></span>
                    </div>
                  <?php endif; ?>
                </div>

                <?php if ($product->is_in_stock()): ?>
                  <a href="<?php echo get_permalink(); ?>" class="product-btn-buy">COMPRAR AGORA</a>
                <?php else: ?>
                  <a href="<?php echo get_permalink(); ?>" class="product-btn-buy out-of-stock">AVISE-ME QUANDO CHEGAR</a>
                <?php endif; ?>

                <div class="product-features">
                  <span class="product-feature-item">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-truck-delivery.png"
                      alt="Frete grátis" class="feature-icon">
                    FRETE GRÁTIS
                  </span>
                  <?php if ($product->is_in_stock()): ?>

                    <span class="product-feature-item">
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-package-delivered.png"
                        alt="Em estoque" class="feature-icon">
                      Em estoque
                    </span>
                  <?php else: ?>
                    <span class="product-feature-item out-of-stock">
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/package-delivered.png"
                        alt="Em estoque" class="feature-icon">
                      Em Breve
                    </span>
                  <?php endif; ?>
                </div>
              </div>
            </article>
          <?php
          }
          wp_reset_postdata();
          ?>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
          <div class="pagination">
            <?php
            // Get current page and total pages for the custom query
            $current_page = max(1, get_query_var('paged'));
            $total_pages = $products_query->max_num_pages;

            if ($total_pages > 1):
              // Get the page permalink for pagination links
              $page_link = get_permalink();

              // Previous page link
              if ($current_page > 1):
                $prev_link = ($current_page == 2) ? $page_link : $page_link . 'page/' . ($current_page - 1) . '/';
            ?>
                <a href="<?php echo $prev_link; ?>" class="pagination-link prev">&laquo; Anterior</a>
                <?php endif;

              // Page numbers
              for ($i = 1; $i <= $total_pages; $i++):
                $page_url = ($i == 1) ? $page_link : $page_link . 'page/' . $i . '/';
                if ($i == $current_page): ?>
                  <span class="pagination-link active"><?php echo $i; ?></span>
                <?php else: ?>
                  <a href="<?php echo $page_url; ?>" class="pagination-link"><?php echo $i; ?></a>
                <?php endif;
              endfor;

              // Next page link
              if ($current_page < $total_pages):
                $next_link = $page_link . 'page/' . ($current_page + 1) . '/';
                ?>
                <a href="<?php echo $next_link; ?>" class="pagination-link next">Próximo &raquo;</a>
            <?php endif;
            endif; ?>
          </div>
        </div>
      <?php
      } else {
      ?>
        <div class="no-products-found">
          <h2>Nenhum produto encontrado</h2>
          <p>Não encontramos produtos disponíveis no momento.</p>
          <a href="<?php echo home_url(); ?>" class="btn btn-primary">Voltar ao início</a>
        </div>
      <?php
      } ?>
    </div>
  </section>

</main>

<?php get_footer(); ?>