<?php
/*
Template Name: Quem Somos
*/

if (!defined('ABSPATH')) {
  exit;
}

get_header();
?>

<!-- Main Content -->
<main class="quem-somos-main">
  <!-- Hero Section -->
  <section class="quem-somos-hero">
    <div class="quem-somos-container">
      <h1 class="quem-somos-section-label"><?php echo get_field('keyword'); ?></h1>
      <h2 class="quem-somos-hero-title"><?php echo get_field('hero_titulo'); ?></h2>
      <p class="quem-somos-hero-text"><?php echo get_field('hero_texto'); ?></p>
    </div>
  </section>

  <!-- Images Section -->
  <section class="quem-somos-images">
    <div class="quem-somos-container">
      <div class="quem-somos-images-grid">
        <?php if (have_rows('hero_lista_imagens')): ?>
          <?php while (have_rows('hero_lista_imagens')):
            the_row(); ?>
            <img src="<?php echo get_sub_field('imagem'); ?>" alt="Gazebo" class="quem-somos-image">
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Content Section -->
  <section class="quem-somos-content">
    <div class="quem-somos-container">
      <div class="quem-somos-content-grid">
        <div class="quem-somos-content-left">
          <h2 class="quem-somos-content-title"><?php echo get_field('hero_lista_imagens_titulo'); ?></h2>
          <p class="quem-somos-content-text"><?php echo get_field('hero_lista_imagens_texto'); ?></p>
        </div>

        <!-- Value Propositions -->
        <div class="quem-somos-values">
          <!-- Circle Shape -->
          <div class="quem-somos-value-item">
            <div class="circle-wrapper">
              <div class="circle-quarter quarter-1">
                <div class="content"><?php echo get_field('ilustracao_1_markting'); ?></div>
              </div>
              <div class="circle-quarter quarter-2">
                <div class="content"><?php echo get_field('ilustracao_1_sales'); ?></div>
              </div>
              <div class="circle-quarter quarter-3">
                <div class="content"><?php echo get_field('ilustracao_1_operations'); ?></div>
              </div>
              <div class="circle-quarter quarter-4">
                <div class="content"><?php echo get_field('ilustracao_1_rd'); ?></div>
              </div>

              <div class="divider-horizontal"></div>
              <div class="divider-vertical"></div>
              <div class="center-circle">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-newsletter.png"
                  alt="Circle Icon">
              </div>
            </div>
            <h3 class="value-title">
              <?php echo get_field('ilustracao_1_texto'); ?>
            </h3>
          </div>

          <div class="quem-somos-value-item">
            <div class="funnel-container">
              <div class="funnel">
                <div class="funnel-segment segment-1">
                  <div class="funnel-text">
                    <?php echo get_field('ilustracao_2_awarness'); ?>
                  </div>
                </div>
                <div class="funnel-segment segment-2">
                  <div class="funnel-text"><?php echo get_field('ilustracao_2_interest'); ?></div>
                </div>
                <div class="funnel-segment segment-3">
                  <div class="funnel-text"><?php echo get_field('ilustracao_2_consideration'); ?>
                  </div>
                </div>
                <div class="funnel-segment segment-4"></div>
              </div>
            </div>
            <h3 class="value-title">
              <h3 class="value-title"><?php echo get_field('ilustracao_2_texto'); ?></h3>
            </h3>
          </div>

          <div class="quem-somos-value-item">
            <div class="value-icon-stool">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-chair.png"
                alt="Durabilidade" class="stool-image">
            </div>
            <h3 class="value-title"><?php echo get_field('ilustracao_3_texto'); ?></h3>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="national-presence">
    <div class="quem-somos-container-">
      <div class="bg-white"></div>
      <div class="national-presence-content">
        <div class="national-presence-info">
          <h3 class="national-presence-title"><?php echo get_field('seccao_presenta_nacional_titulo'); ?></h3>
          <p class="national-presence-text"><?php echo get_field('seccao_presenta_nacional_texto'); ?></p>
        </div>
        <div class="national-presence-images-grid">
          <?php if (have_rows('seccao_presenta_nacional_lista_imagens')): ?>
            <?php while (have_rows('seccao_presenta_nacional_lista_imagens')):
              the_row(); ?>
              <img src="<?php echo get_sub_field('imagem'); ?>" alt="NL" class="national-presence-image">
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>


  <section class="map-section">
    <div class="map-content">
      <p class="map-text"><?php echo get_field('seccao_mapa_texto'); ?></p>

      <div class="map-image-container">
        <div class="legend-container">
          <div class="legend-item">
            <div class="legend-item-color">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-truck-delivery.png"
                alt="Legend Item Color">
            </div>
            <span class="legend-item-text">Entrega
              em todo
              o Brasil</span>
          </div>
        </div>
        <img src="<?php echo get_field('seccao_mapa_imagem'); ?>" alt="Map" class="map-image">
      </div>
    </div>
  </section>



  <!-- Products Section -->
  <section class="detalhes-products-section">
    <div class="product-details-container product-details-container-quem-somos">
      <div class="products-header">
        <h2 class="products-section-title">NÃO DEIXE DE COMPRAR...</h2>
      </div>
      <div class="detalhes-products-grid">
        <?php if (class_exists('WooCommerce')): ?>
          <?php
          // Get visited products
          $visited_product_ids = brazil_home_get_visited_products();

          if (!empty($visited_product_ids)) {
            // Show visited products
            $carousel_args = array(
              'post_type' => 'product',
              'posts_per_page' => 10,
              'post_status' => 'publish',
              'post__in' => $visited_product_ids,
              'orderby' => 'post__in', // Maintain the order from visited products
              'meta_query' => WC()->query->get_meta_query(),
              'tax_query' => WC()->query->get_tax_query()
            );
          } else {
            // Fallback to recent products if no visited products
            $carousel_args = array(
              'post_type' => 'product',
              'posts_per_page' => 10,
              'post_status' => 'publish',
              'orderby' => 'date',
              'order' => 'DESC',
              'meta_query' => WC()->query->get_meta_query(),
              'tax_query' => WC()->query->get_tax_query()
            );
          }

          $carousel_products = new WP_Query($carousel_args);

          if ($carousel_products->have_posts()):
            while ($carousel_products->have_posts()):
              $carousel_products->the_post();
              global $product;
          ?>
              <article class="featured-product-card" data-product-url="<?php echo get_permalink(); ?>">
                <div class="product-image">
                  <a href="<?php echo get_permalink(); ?>" class="product-link">
                    <?php if (has_post_thumbnail()): ?>
                      <?php the_post_thumbnail('woocommerce_thumbnail', array('alt' => get_the_title())); ?>
                    <?php else: ?>
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-product.png"
                        alt="<?php the_title(); ?>">
                    <?php endif; ?>
                  </a>
                </div>
                <div class="product-info">
                  <a href="<?php echo get_permalink(); ?>" class="product-link">
                    <h3 class="product-title"><?php echo strtoupper(get_the_title()); ?></h3>
                  </a>
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

                  <?php if ($product->is_purchasable() && $product->is_in_stock()): ?>
                    <a href="<?php echo get_permalink(); ?>" class="product-btn-buy"
                      style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                      COMPRAR AGORA
                    </a>
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
            endwhile;
            wp_reset_postdata();
          else:
            // Fallback if no products exist
            ?>
            <article class="featured-product-card" data-product-url="<?php echo home_url(); ?>">
              <div class="product-image">
                <a href="<?php echo home_url(); ?>" class="product-link">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-product.png"
                    alt="Ver Produtos">
                </a>
              </div>
              <div class="product-info">
                <a href="/todos-os-produtos" class="product-link">
                  <h3 class="product-title">VER TODOS OS PRODUTOS</h3>
                </a>
                <div class="product-price">
                  <span class="product-price-current">Vários preços
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-price-tag.png"
                      alt="Arrow right" class="product-price-arrow">
                  </span>
                  <div class="product-price-installments">
                    <span class="product-price-installments-text">Produtos variados disponíveis</span>
                  </div>
                </div>
                <a href="<?php echo home_url(); ?>" class="product-btn-buy"
                  style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">VER
                  PRODUTOS</a>
                <div class="product-features">
                  <span class="product-feature-item">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-truck-delivery.png"
                      alt="Frete grátis" class="feature-icon">
                    FRETE GRÁTIS
                  </span>
                  <span class="product-feature-item">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-package-delivered.png"
                      alt="Produtos disponíveis" class="feature-icon">
                    DISPONÍVEL
                  </span>
                </div>
              </div>
            </article>
          <?php endif; ?>
        <?php else: ?>
          <!-- Fallback for non-WooCommerce sites -->
          <article class="featured-product-card">
            <div class="product-image">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-product.png"
                alt="Produto">
            </div>
            <div class="product-info">
              <h3 class="product-title">PRODUTOS DISPONÍVEIS</h3>
              <div class="product-price">
                <span class="product-price-current">Consulte preços
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-price-tag.png"
                    alt="Arrow right" class="product-price-arrow">
                </span>
                <div class="product-price-installments">
                  <span class="product-price-installments-text">Entre em contato para mais
                    informações</span>
                </div>
              </div>
              <button class="product-btn-buy">VER PRODUTOS</button>
              <div class="product-features">
                <span class="product-feature-item">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-truck-delivery.png"
                    alt="Frete grátis" class="feature-icon">
                  FRETE GRÁTIS
                </span>
                <span class="product-feature-item">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-package-delivered.png"
                    alt="Disponível" class="feature-icon">
                  DISPONÍVEL
                </span>
              </div>
            </div>
          </article>
        <?php endif; ?>
      </div>
    </div>
  </section>
</main>


<?php get_footer(); ?>