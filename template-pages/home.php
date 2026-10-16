<?php
/*
Template Name: Home
*/

if (!defined('ABSPATH')) {
  exit;
}

get_header();
?>

<!-- Main Content -->
<main class="main-content">
  <!-- Hero Section -->
  <section class="hero-section">
    <?php
    $hero_autoplay_speed = get_theme_mod('US_hero_autoplay_speed', 5000);
    $hero_bg_color = get_theme_mod('US_hero_bg_color', '#1C4067');
    $hero_text_color = get_theme_mod('US_hero_text_color', '#FFFFFF');
    ?>
    <style>
      .hero-content {
        background-color:
          <?php echo esc_attr($hero_bg_color);
          ?> !important;
        color:
          <?php echo esc_attr($hero_text_color);
          ?> !important;
      }

      .hero-content .hero-title,
      .hero-content .hero-description,
      .hero-content p {
        color:
          <?php echo esc_attr($hero_text_color);
          ?> !important;
      }

      .polign-form {
        background-color:
          <?php echo esc_attr($hero_bg_color);
          ?> !important;
      }
    </style>
    <div class="hero-slider" data-autoplay-speed="<?php echo esc_attr($hero_autoplay_speed); ?>">
      <?php
      // Get hero carousel settings
      $hero_slides_count = get_theme_mod('US_hero_products_count', 3);
      $hero_fallback_desc = get_theme_mod('US_hero_fallback_description', 'Descubra este produto incrível com a qualidade que você merece.');
      $hero_cta_text = get_theme_mod('US_hero_cta_text', 'COMPRAR AGORA');

      // Collect custom hero items
      $hero_items = array();
      for ($i = 1; $i <= 5; $i++) {
        $title = get_theme_mod("US_hero_custom_{$i}_title", '');
        if (!empty($title)) {
          $hero_items[] = array(
            'title' => $title,
            'description' => get_theme_mod("US_hero_custom_{$i}_description", ''),
            'cta_text' => get_theme_mod("US_hero_custom_{$i}_cta_text", 'SAIBA MAIS'),
            'link' => get_theme_mod("US_hero_custom_{$i}_link", '#'),
            'image' => get_theme_mod("US_hero_custom_{$i}_image", '')
          );
        }
      }

      // If no custom items, use products from WooCommerce
      if (empty($hero_items) && class_exists('WooCommerce')) {
        $hero_args = array(
          'post_type' => 'product',
          'posts_per_page' => $hero_slides_count,
          'post_status' => 'publish',
          'orderby' => 'date',
          'order' => 'DESC',
          'meta_query' => WC()->query->get_meta_query(),
          'tax_query' => WC()->query->get_tax_query()
        );

        $hero_products = new WP_Query($hero_args);

        if ($hero_products->have_posts()):
          while ($hero_products->have_posts()):
            $hero_products->the_post();
            global $product;
            $excerpt = get_the_excerpt();
            $hero_items[] = array(
              'title' => get_the_title(),
              'description' => $excerpt ? $excerpt : $hero_fallback_desc,
              'cta_text' => $hero_cta_text,
              'link' => get_permalink(),
              'image' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : ''
            );
          endwhile;
          wp_reset_postdata();
        endif;
      } else {
        // Limit custom items to configured count
        $hero_items = array_slice($hero_items, 0, $hero_slides_count);
      }

      if (!empty($hero_items)):
        foreach ($hero_items as $item):
      ?>
          <div class="hero-slide">
            <div class="hero-content">
              <div class="hero-content-container">
                <h2 class="hero-title"><?php echo strtoupper(esc_html($item['title'])); ?></h2>
                <p class="hero-description">
                  <?php echo wp_strip_all_tags($item['description']); ?>
                </p>
                <a href="<?php echo esc_url($item['link']); ?>"
                  class="hero-cta-button"><?php echo esc_html($item['cta_text']); ?></a>

                <div class="carousel-control-buttons">
                  <button class="carousel-control-button hero-prev" id="hero-prev">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-left-arrow.png"
                      alt="Anterior">
                  </button>
                  <button class="carousel-control-button hero-next" id="hero-next">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-right-arrow.png"
                      alt="Próximo">
                  </button>
                </div>
              </div>
            </div>
            <div class="hero-image">
              <a href="<?php echo esc_url($item['link']); ?>">
                <div class="polign-form"></div>
                <?php if (!empty($item['image'])): ?>
                  <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>"
                    class="hero-bg-image">
                <?php else: ?>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-hero.png"
                    alt="<?php echo esc_attr($item['title']); ?>" class="hero-bg-image">
                <?php endif; ?>
              </a>
            </div>
          </div>
        <?php
        endforeach;
      else:
        // Fallback to static content if no custom items configured
        ?>
        <div class="hero-slide">
          <div class="hero-content">
            <div class="hero-content-container">
              <h2 class="hero-title">VIVA CADA ESPAÇO DO SEU LAR</h2>
              <p class="hero-description">Descubra nossa linha completa de produtos com a qualidade que você
                merece.</p>
              <a href="<?php echo home_url(); ?>" class="hero-cta-button">VER PRODUTOS</a>

              <div class="carousel-control-buttons">
                <button class="carousel-control-button hero-prev" id="hero-prev">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-left-arrow.png"
                    alt="Anterior">
                </button>
                <button class="carousel-control-button hero-next" id="hero-next">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-right-arrow.png"
                    alt="Próximo">
                </button>
              </div>
            </div>
          </div>
          <div class="hero-image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-hero.png"
              alt="Produtos" class="hero-bg-image">
          </div>
        </div>
      <?php endif; ?>
    </div>

  </section>
  <div class="hero-slider-controls">
    <!-- <div class="hero-slider-controls-container">
            <div class="hero-slider-controls-item"></div>
            <div class="hero-slider-controls-item"></div>
            <div class="hero-slider-controls-item"></div>
        </div> -->
  </div>
  <!-- CTA Section -->
  <section class="cta-section">
    <div class="homepage-container">
      <div class="cta-content">
        <h2 class="cta-title"><?php echo get_field('banner_marca_texto'); ?></h2>
      </div>
    </div>
  </section>

  <!-- Brands Section -->
  <section class="brands-section">
    <div class="brands-container">
      <h2 class="brands-title"><?php echo get_field("titulo_marcas") ?></h2>
      <div class="brands-grid">
        <?php if (have_rows('lista_marcas')): ?>
          <?php while (have_rows('lista_marcas')):
            the_row(); ?>
            <div class="brand-item">
              <img src="<?php echo get_sub_field('logo'); ?>" alt="" class="brand-logo">
            </div>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Featured Products Section -->
  <section class="featured-products-section">
    <div class="homepage-container">
      <div class="featured-products-grid">
        <?php if (class_exists('WooCommerce')): ?>
          <?php
          // Get featured or latest products
          $args = array(
            'post_type' => 'product',
            'posts_per_page' => 7,
            'post_status' => 'publish',
            'meta_query' => WC()->query->get_meta_query(),
            'tax_query' => WC()->query->get_tax_query()
          );

          $products = new WP_Query($args);

          if ($products->have_posts()):
            while ($products->have_posts()):
              $products->the_post();
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
                    <h3 class="product-title"><?php the_title(); ?></h3>
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
                    <form class="cart"
                      action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
                      method="post" enctype='multipart/form-data'>
                      <?php do_action('woocommerce_before_add_to_cart_button'); ?>

                      <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"
                        class="product-btn-buy ajax_add_to_cart add_to_cart_button"
                        data-product_id="<?php echo $product->get_id(); ?>"
                        data-product_sku="<?php echo esc_attr($product->get_sku()); ?>"
                        aria-label="<?php echo esc_attr('Comprar agora: ' . $product->get_name()); ?>"
                        rel="nofollow">
                        COMPRAR AGORA
                      </button>

                      <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                    </form>
                  <?php else: ?>
                    <a href="<?php echo get_permalink(); ?>" class="product-btn-buy">AVISE-ME QUANDO CHEGAR</a>
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
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-package-delivered.png"
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
          endif;
          ?>
        <?php else: ?>
          <!-- Fallback - redirect to shop page if no WooCommerce products -->
          <article class="featured-product-card" data-product-url="<?php echo home_url(); ?>">
            <div class="product-image">
              <a href="<?php echo home_url(); ?>" class="product-link">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-product.png"
                  alt="Ver Produtos">
              </a>
            </div>
            <div class="product-info">
              <a href="/todos-os-produtos/" class="product-link">
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
      </div>
    </div>
  </section>

  <?php if (class_exists('WooCommerce') && $products->found_posts > 7): ?>
    <!-- View All Products Button -->
    <section class="view-all-section">
      <div class="homepage-container">
        <div class="view-all-content">
          <a href="<?php echo home_url(); ?>" class="view-all-button">VER TODOS OS
            PRODUTOS</a>
        </div>
      </div>
    </section>
  <?php endif; ?>


  <!-- Banner Section -->
  <section class="banner-section">
    <div class="homepage-container">
      <div class="banner-content">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-truck-delivery-white.png"
          alt="Banner" class="banner-image" width="20" height="20">
        <p class="banner-text"><?php echo get_field('banner_servico_texto'); ?></p>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features-section">
    <div class="service-features-grid">
      <?php if (have_rows('lista_servicos')): ?>
        <?php while (have_rows('lista_servicos')):
          the_row(); ?>
          <div class="service-feature-item">
            <div class="service-icon">
              <img src="<?php echo get_sub_field('icone'); ?>" alt="">
            </div>
            <div class="service-content">
              <h3 class="service-title"><?php echo get_sub_field('titulo'); ?></h3>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </section>

  <!-- Blog Section -->
  <section class="blog-section blog-section-home">
    <div class="blog-section-container">
      <div class="blog-header">
        <h1 class="blog-section-header-title">FIQUE POR DENTRO COM NOSSO BLOG</h1>
      </div>

      <div class="blog-cards-container">
        <?php
        // Query for recent blog posts
        $blog_args = array(
          'posts_per_page' => 2,
          'post_status' => 'publish',
          'orderby' => 'date',
          'order' => 'DESC'
        );
        $blog_query = new WP_Query($blog_args);

        if ($blog_query->have_posts()):
          while ($blog_query->have_posts()):
            $blog_query->the_post();
        ?>
            <a href="<?php the_permalink(); ?>" class="blog-card-link">
              <article class="blog-card">
                <div class="blog-card-image">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                  <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-blog.png"
                      alt="<?php the_title(); ?>">
                  <?php endif; ?>
                </div>
                <div class="blog-card-content">
                  <div class="blog-card-content-inner">
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)): ?>
                      <span class="blog-category"><?php echo strtoupper($categories[0]->name); ?></span>
                    <?php endif; ?>
                    <h2 class="blog-card-title"><?php echo strtoupper(get_the_title()); ?></h2>
                  </div>
                  <img class="blog-read-more"
                    src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-arrow-up-right.png"
                    alt="Ler mais">
                </div>
              </article>
            </a>
          <?php
          endwhile;
          wp_reset_postdata();
        else:
          // Fallback content if no posts exist
          ?>
          <a href="#" class="blog-card-link">
            <article class="blog-card">
              <div class="blog-card-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-blog.png"
                  alt="Blog post">
              </div>
              <div class="blog-card-content">
                <div class="blog-card-content-inner">
                  <span class="blog-category">BLOG</span>
                  <h2 class="blog-card-title">NENHUMA POSTAGEM ENCONTRADA</h2>
                </div>
                <img class="blog-read-more"
                  src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-arrow-up-right.png"
                  alt="Ler mais">
              </div>
            </article>
          </a>
        <?php endif; ?>
      </div>
    </div>
    </div>
  </section>

  <!-- Info Section -->
  <section class="info-section">
    <div class="homepage-container">
      <div class="info-content">
        <h2 class="info-title"><?php echo get_field('home_seccao_informacao_titulo'); ?></h2>

        <div class="info-items">
          <?php if (have_rows('lista_home_seccao_informacao')): ?>
            <?php while (have_rows('lista_home_seccao_informacao')):
              the_row(); ?>
              <div class="info-item">
                <div class="info-icon">
                  <img src="<?php echo get_sub_field('icone'); ?>" alt="">

                </div>
                <div class="info-text">
                  <h3 class="info-item-title"><?php echo get_sub_field('titulo'); ?></h3>
                  <p class="info-item-description"><?php echo get_sub_field('texto'); ?></p>
                </div>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </section>


  <!-- Newsletter Section -->
  <section class="newsletter-section">
    <div class="homepage-container">
      <div class="newsletter-content">

        <h2 class="newsletter-title"><?php echo get_field('seccao_newsletter_titulo'); ?></h2>
        <p class="newsletter-description"><?php echo get_field('seccao_newsletter_texto'); ?></p>

        <form class="newsletter-form">
          <div class="newsletter-input-group">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-search-01.png"
              alt="Email" class="newsletter-input-icon">
            <input type="email" placeholder="E-mail" class="newsletter-input" required>
            <button type="submit" class="newsletter-button">CADASTRAR</button>
          </div>
        </form>

        <?php echo do_shortcode('[contact-form-7 id="424c71a" title="Newsletter"]'); ?>

      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>