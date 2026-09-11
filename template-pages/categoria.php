<?php
/*
Template Name: Categoria
*/

if (!defined('ABSPATH')) {
  exit;
}

get_header();
?>

<!-- Main Content -->
<main class="category-main">
    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="category-container">
            <nav class="breadcrumb">
                <a href="<?php echo home_url(); ?>" class="breadcrumb-link">HOME</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">GAZEBOS</span>
            </nav>
        </div>
    </section>

    <!-- Category Header -->
    <section class="category-header-section">
        <div class="category-container">
            <h1 class="category-title">GAZEBOS</h1>
            <p class="category-description">
                Encontre o gazebo perfeito para sua casa, quintal ou jardim. Produtos de alta qualidade
                com estrutura resistente e design moderno.
            </p>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="filters-section">
        <div class="category-container">
            <div class="filters-header">
                <span class="filters-title">Filtros:</span>
                <div class="filters-controls">
                    <select class="filter-select">
                        <option>Ordenar por</option>
                        <option>Menor preço</option>
                        <option>Maior preço</option>
                        <option>Mais vendidos</option>
                    </select>
                    <div class="view-toggle">
                        <button class="view-btn grid-view active" data-view="grid">
                            <span class="grid-icon"></span>
                        </button>
                        <button class="view-btn list-view" data-view="list">
                            <span class="list-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="category-products-section">
        <div class="category-container">
            <div class="products-grid">
                <?php
                // Sample product data - in real implementation, this would come from WordPress posts/custom post types
                $products = [
                    [
                        'name' => 'SOJAG VENTURA GAZEBO',
                        'price' => 'R$ 580,00',
                        'installments' => '10x de R$ 58,00',
                        'image' => get_template_directory_uri() . '/assets/images/product.png'
                    ],
                    [
                        'name' => 'SOJAG PREMIUM GAZEBO',
                        'price' => 'R$ 750,00',
                        'installments' => '10x de R$ 75,00',
                        'image' => get_template_directory_uri() . '/assets/images/product.png'
                    ],
                    [
                        'name' => 'MESA DOBRÁVEL PREMIUM',
                        'price' => 'R$ 450,00',
                        'installments' => '10x de R$ 45,00',
                        'image' => get_template_directory_uri() . '/assets/images/product.png'
                    ],
                    [
                        'name' => 'CARRINHO DE CARGA ULTRA',
                        'price' => 'R$ 320,00',
                        'installments' => '10x de R$ 32,00',
                        'image' => get_template_directory_uri() . '/assets/images/product.png'
                    ]
                ];

                foreach ($products as $product): ?>
                    <article class="product-card">
                        <div class="product-image">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title"><?php echo $product['name']; ?></h3>
                            <div class="product-price">
                                <span class="product-price-current"><?php echo $product['price']; ?>
                                </span>
                                <div class="product-price-installments">
                                    <span class="product-price-installments-text">Em até
                                        <mark><?php echo $product['installments']; ?></mark> sem juros</span>
                                </div>
                            </div>
                            <button class="product-btn-buy">COMPRAR AGORA</button>
                            <div class="product-features">
                                <span class="product-feature-item">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/truck-delivery.png"
                                        alt="Frete grátis" class="feature-icon">
                                    FRETE GRÁTIS
                                </span>
                                <span class="product-feature-item">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/package-delivered.png"
                                        alt="Em estoque" class="feature-icon">
                                    Em estoque
                                </span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <div class="pagination">
                    <a href="#" class="pagination-link prev">&laquo; Anterior</a>
                    <a href="#" class="pagination-link active">1</a>
                    <a href="#" class="pagination-link">2</a>
                    <a href="#" class="pagination-link">3</a>
                    <a href="#" class="pagination-link next">Próximo &raquo;</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="homepage-container">
            <div class="faq-content">
                <div class="faq-intro">
                    <h2 class="faq-title">PERGUNTAS FREQUENTES</h2>
                    <p class="faq-description">Tire suas dúvidas sobre nossos produtos e serviços.</p>
                </div>

                <div class="faq-list">
                    <?php
                    $home_faqs = brazil_home_get_home_faqs();
                    if (!empty($home_faqs)):
                        foreach ($home_faqs as $faq):
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
                                <span class="faq-question-text">QUAIS SÃO NOSSAS FORMAS DE PAGAMENTO?</span>
                                <p>Aceitamos cartão de crédito, débito, PIX e boleto bancário. Parcele em até 12x sem juros.
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>