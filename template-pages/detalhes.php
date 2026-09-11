<?php
/*
Template Name: Product Details
*/

if (!defined('ABSPATH')) {
  exit;
}

get_header();
?>

<!-- Main Content -->
<main class="product-details-main">
    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="product-details-container">
            <nav class="breadcrumb">
                <a href="<?php echo home_url(); ?>" class="breadcrumb-link">HOME</a>
                <span class="breadcrumb-separator">/</span>
                <a href="<?php echo home_url('/categoria'); ?>" class="breadcrumb-link">GAZEBOS</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">SOJAG VENTURA GAZEBO</span>
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
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product.png"
                            alt="Sojag Ventura Gazebo" id="mainProductImage">
                    </div>
                    <div class="thumbnail-gallery">
                        <button class="thumbnail active"
                            data-image="<?php echo get_template_directory_uri(); ?>/assets/images/product.png">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product.png"
                                alt="Vista 1">
                        </button>
                        <button class="thumbnail"
                            data-image="<?php echo get_template_directory_uri(); ?>/assets/images/product.png">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product.png"
                                alt="Vista 2">
                        </button>
                        <button class="thumbnail"
                            data-image="<?php echo get_template_directory_uri(); ?>/assets/images/product.png">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product.png"
                                alt="Vista 3">
                        </button>
                        <button class="thumbnail"
                            data-image="<?php echo get_template_directory_uri(); ?>/assets/images/product.png">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product.png"
                                alt="Vista 4">
                        </button>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-info">
                    <div class="product-header">
                        <div class="product-badges">
                            <span class="badge-ready-delivery">PRONTA ENTREGA</span>
                            <span class="badge-in-stock">EM ESTOQUE</span>
                        </div>
                        <h1 class="product-title">SOJAG VENTURA GAZEBO</h1>
                        <p class="product-description">
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                            unknown printer took a galley of type and scrambled it to make a type specimen book.
                        </p>
                    </div>

                    <div class="product-price">
                        <span class="product-price-current">R$ 580,00
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/price-tag.png"
                                alt="Price tag" class="product-price-arrow">
                        </span>
                        <div class="product-price-installments">
                            <span class="product-price-installments-text">Em até <mark>10x de R$ 58,00</mark> sem
                                juros</span>
                        </div>
                    </div>

                    <div class="product-options">
                        <div class="cep-calculator">
                            <div class="cep-input-group">
                                <div class="cep-input-container">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/truck-delivery.png"
                                        alt="Delivery" class="cep-icon">
                                    <input type="text" id="cep" class="cep-input"
                                        placeholder="Calcule o frete Informe seu CEP" maxlength="9">
                                </div>
                                <button type="button" class="cep-button">CALCULAR</button>
                            </div>
                        </div>

                        <div class="product-actions-row">
                            <div class="quantity-selector">
                                <div class="quantity-controls">
                                    <button type="button" class="quantity-btn quantity-decrease">
                                        <img src="../assets/images/minus.png" alt="Minus">
                                    </button>
                                    <input type="number" id="quantity" class="quantity-input" value="1" min="1"
                                        max="10">
                                    <button type="button" class="quantity-btn quantity-increase">
                                        <img src="../assets/images/plus.png" alt="Plus">
                                    </button>
                                </div>
                            </div>

                            <div class="product-actions">
                                <button class="btn-add-cart">COMPRAR AGORA</button>
                            </div>
                        </div>
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
                <button class="tab-button" data-tab="maintenance">MONTAGEM</button>
                <button class="tab-button" data-tab="reviews">Compare</button>
            </div>

            <div class="tabs-content">
                <div class="tab-panel active" id="description">
                    <p>Este produto Gazebo adequa-se perfeitamente para os verões e invernos. Dispõe de muito espaço
                        para relaxar no seu pátio durante todo o verão. Este gazebo Sojag Ventura é um dos melhores
                        valores que oferecemos nos nossos produtos. É uma opção perfeita para um pequeno jantar, um
                        evento especial ou até mesmo uma reunião com a família. A sua estrutura em alumínio é fácil
                        de montar, tem boa qualidade e garante grande qualidade premium. É simples e elegante que
                        vai dar uma excelente contribuição ao seu jardim e elevará ainda mais o seu ambiente. Tem
                        estrutura robusta de PVC fabricado em ambiente seco, sendo de extrema durabilidade e
                        resistência e não vai um aspecto. Tem estrutura robusta de alumínio resistente às
                        intempéries.</p>
                </div>

                <div class="tab-panel" id="specifications">
                    <div class="specifications-grid">
                        <div class="spec-item">
                            <span class="spec-label">Material principal:</span>
                            <span class="spec-value">Alumínio</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Origem:</span>
                            <span class="spec-value">Nacional</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>