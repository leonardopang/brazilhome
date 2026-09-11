<?php

/**
 * The Template for displaying product archives using categoria.php design
 * Custom Brazil Home Theme Template
 *
 * @package Brazil Home Theme
 * @version 8.6.0
 */

defined('ABSPATH') || exit;

get_header(); ?>

<!-- Main Content -->
<main class="category-main">
  <!-- Category Header -->
  <section class="category-header">
    <div class="category-container">
      <h1 class="category-title">
        <?php
        if (is_search()) {
          echo '"' . strtoupper(get_search_query()) . '"';
        } elseif (is_shop()) {
          echo 'NOSSA LOJA';
        } else {
          echo strtoupper(woocommerce_page_title(false));
        }
        ?>
      </h1>
      <?php
      $shop_page_id = wc_get_page_id('shop');
      $shop_page_description = get_post_field('post_content', $shop_page_id);
      if ($shop_page_description): ?>
        <p class="category-description">
          <?php echo wp_strip_all_tags($shop_page_description); ?>
        </p>
      <?php else: ?>

      <?php endif; ?>
    </div>
  </section>



  <!-- Products Grid -->
  <section class="category-products-section">
    <div class="category-container">
      <?php
      if (woocommerce_product_loop()) {
      ?>
        <div class="products-grid">
          <?php
          if (wc_get_loop_prop('total')) {
            while (have_posts()) {
              the_post();
              global $product;
          ?>
              <article class="product-card" data-product-url="<?php echo get_permalink(); ?>">
                <div class="product-image">
                  <a href="<?php echo get_permalink(); ?>">
                    <?php if (has_post_thumbnail()): ?>
                      <?php the_post_thumbnail('woocommerce_thumbnail', array('alt' => get_the_title())); ?>
                    <?php else: ?>
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product.png"
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
                    <a href="<?php echo get_permalink(); ?>" class="product-btn-buy">AVISE-ME QUANDO CHEGAR</a>
                  <?php endif; ?>

                  <div class="product-features">
                    <span class="product-feature-item">
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/truck-delivery.png"
                        alt="Frete grátis" class="feature-icon">
                      FRETE GRÁTIS
                    </span>
                    <?php if ($product->is_in_stock()): ?>
                      <span class="product-feature-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/package-delivered.png"
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
          }
          ?>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
          <div class="pagination">
            <?php
            // Get current page and total pages
            global $wp_query;
            $current_page = max(1, get_query_var('paged'));
            $total_pages = $wp_query->max_num_pages;

            if ($total_pages > 1):
              // Previous page link
              if ($current_page > 1): ?>
                <a href="<?php echo get_pagenum_link($current_page - 1); ?>" class="pagination-link prev">&laquo;
                  Anterior</a>
                <?php endif;

              // Page numbers
              for ($i = 1; $i <= $total_pages; $i++):
                if ($i == $current_page): ?>
                  <span class="pagination-link active"><?php echo $i; ?></span>
                <?php else: ?>
                  <a href="<?php echo get_pagenum_link($i); ?>" class="pagination-link"><?php echo $i; ?></a>
                <?php endif;
              endfor;

              // Next page link
              if ($current_page < $total_pages): ?>
                <a href="<?php echo get_pagenum_link($current_page + 1); ?>" class="pagination-link next">Próximo
                  &raquo;</a>
            <?php endif;
            endif; ?>
          </div>
        </div>
      <?php
      } else {
      ?>
        <div class="no-products-found">
          <?php if (is_search()): ?>
            <h2>Nenhum produto encontrado</h2>
            <p>Não encontramos produtos para "<?php echo get_search_query(); ?>". Tente pesquisar por outros termos.
            </p>
            <a href="<?php echo home_url(); ?>" class="btn btn-primary">Voltar ao início</a>
          <?php else: ?>
            <h2>Nenhum produto encontrado</h2>
            <p>Não encontramos produtos nesta categoria.</p>
            <a href="<?php echo home_url(); ?>" class="btn btn-primary">Voltar ao início</a>
          <?php endif; ?>
        </div>
      <?php
      } ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>