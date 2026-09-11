<?php

defined('ABSPATH') || exit;

get_header();

global $wp_query;

$sorted_posts = array();

if (!empty($wp_query->posts) && is_array($wp_query->posts)) {
  $sorted_posts = $wp_query->posts;

  usort($sorted_posts, function ($post_a, $post_b) {
    $product_a = wc_get_product($post_a->ID);
    $product_b = wc_get_product($post_b->ID);

    $status_a = $product_a ? $product_a->get_stock_status() : 'outofstock';
    $status_b = $product_b ? $product_b->get_stock_status() : 'outofstock';

    $map = array(
      'instock' => 0,
      'onbackorder' => 1,
      'outofstock' => 2,
    );

    $order_a = isset($map[$status_a]) ? $map[$status_a] : 99;
    $order_b = isset($map[$status_b]) ? $map[$status_b] : 99;

    if ($order_a === $order_b) {
      return 0;
    }

    return ($order_a < $order_b) ? -1 : 1;
  });
}
?>

<main class="category-main">

  <section class="breadcrumb-section">
    <div class="category-container">
      <nav class="breadcrumb">
        <a href="<?php echo home_url(); ?>" class="breadcrumb-link">HOME</a>
        <span class="breadcrumb-separator">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bread-divider.png" />
        </span>
        <span class="breadcrumb-current"><?php echo strtoupper(single_cat_title('', false)); ?></span>
      </nav>
    </div>
  </section>

  <section class="category-header">
    <div class="category-container">
      <h1 class="category-title"><?php echo strtoupper(single_cat_title('', false)); ?></h1>
      <?php
      $category = get_queried_object();
      if ($category && !empty($category->description)):
      ?>
        <p class="category-description">
          <?php echo $category->description; ?>
        </p>
      <?php endif; ?>
    </div>
  </section>

  <section class="category-products-section">
    <div class="category-container">
      <?php if (woocommerce_product_loop() && !empty($sorted_posts)) : ?>
        <div class="products-grid">
          <?php
          foreach ($sorted_posts as $post) :
            setup_postdata($post);
            global $product;

            if (!$product || !is_a($product, 'WC_Product')) {
              $product = wc_get_product(get_the_ID());
            }

            if (!$product) {
              continue;
            }
          ?>
            <article class="product-card" data-product-url="<?php echo get_permalink(); ?>">
              <div class="product-image">
                <a href="<?php echo get_permalink(); ?>">
                  <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('woocommerce_thumbnail', array('alt' => get_the_title())); ?>
                  <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product.png" alt="<?php the_title(); ?>">
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

                  <?php if ($product->get_price()) : ?>
                    <div class="product-price-installments">
                      <span class="product-price-installments-text"><?php echo brazil_home_get_installment_text($product->get_price()); ?></span>
                    </div>
                  <?php endif; ?>
                </div>

                <?php if ($product->is_in_stock()) : ?>
                  <a href="<?php echo get_permalink(); ?>" class="product-btn-buy">COMPRAR AGORA</a>
                <?php else : ?>
                  <a href="<?php echo get_permalink(); ?>" class="product-btn-buy">AVISE-ME QUANDO CHEGAR</a>
                <?php endif; ?>

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
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/package-delivered.png" alt="Em estoque" class="feature-icon">
                      Em Breve
                    </span>
                  <?php endif; ?>
                </div>
              </div>
            </article>
          <?php
          endforeach;
          wp_reset_postdata();
          ?>
        </div>

        <div class="pagination-container">
          <div class="pagination">
            <?php
            $current_page = max(1, get_query_var('paged'));
            $total_pages = $wp_query->max_num_pages;

            if ($total_pages > 1) :
              if ($current_page > 1) :
            ?>
                <a href="<?php echo get_pagenum_link($current_page - 1); ?>" class="pagination-link prev">&laquo; Anterior</a>
                <?php
              endif;

              for ($i = 1; $i <= $total_pages; $i++) :
                if ($i == $current_page) :
                ?>
                  <span class="pagination-link active"><?php echo $i; ?></span>
                <?php else : ?>
                  <a href="<?php echo get_pagenum_link($i); ?>" class="pagination-link"><?php echo $i; ?></a>
                <?php
                endif;
              endfor;

              if ($current_page < $total_pages) :
                ?>
                <a href="<?php echo get_pagenum_link($current_page + 1); ?>" class="pagination-link next">Próximo &raquo;</a>
            <?php
              endif;
            endif;
            ?>
          </div>
        </div>
      <?php else : ?>
        <div class="no-products-found">
          <h2>Nenhum produto encontrado</h2>
          <p>Não encontramos produtos nesta categoria.</p>
          <a href="<?php echo home_url(); ?>" class="btn btn-primary">Voltar ao início</a>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <section class="faq-section">
    <div class="faq-content">
      <div class="faq-intro">
        <h2 class="faq-title">PERGUNTAS FREQUENTES</h2>
        <p class="faq-description">Tire suas dúvidas sobre nossos produtos e serviços.</p>
      </div>

      <div class="faq-list">
        <?php
        $home_faqs = brazil_home_get_home_faqs();
        if (!empty($home_faqs)) :
          foreach ($home_faqs as $faq) :
        ?>
            <div class="faq-item">
              <div class="faq-question">
                <div class="faq-question-icon-container">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/checkmark-circle-02.png" alt="Check" class="faq-icon">
                </div>
              </div>
              <div class="faq-question-text-container">
                <span class="faq-question-text"><?php echo esc_html($faq['question']); ?></span>
                <p><?php echo esc_html($faq['answer']); ?></p>
              </div>
            </div>
          <?php
          endforeach;
        else :
          ?>
          <div class="faq-item">
            <div class="faq-question">
              <div class="faq-question-icon-container">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/checkmark-circle-02.png" alt="Check" class="faq-icon">
              </div>
            </div>
            <div class="faq-question-text-container">
              <span class="faq-question-text">QUAIS SÃO NOSSAS FORMAS DE PAGAMENTO?</span>
              <p>Aceitamos cartão de crédito, débito, PIX e boleto bancário. Parcele em até 12x sem juros.</p>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>