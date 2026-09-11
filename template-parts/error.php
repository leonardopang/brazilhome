<?php
/**
 * Template part for displaying 404 error page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

?>

<!-- 404 Error Section -->
<section class="error-404-section">
    <div class="product-details-container">
        <div class="error-404-content">
            <div class="error-404-main">
                <div class="error-code">
                    <h1>404</h1>
                </div>
                <div class="error-message">
                    <h2>PÁGINA NÃO ENCONTRADA</h2>
                    <p>Desculpe, a página que você está procurando não existe ou foi removida.</p>
                    <p>Verifique se o endereço foi digitado corretamente ou navegue através do nosso menu.</p>
                </div>
                <div class="error-actions">
                    <a href="<?php echo home_url(); ?>" class="btn-back-home">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/home-icon.png" alt="Home"
                            class="home-icon">
                        VOLTAR AO INÍCIO
                    </a>
                    <a href="<?php echo brazil_home_get_todos_produtos_page_url(); ?>" class="btn-view-products">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/package-delivered.png"
                            alt="Produtos" class="products-icon">
                        VER TODOS OS PRODUTOS
                    </a>
                </div>
            </div>


        </div>
    </div>
</section>