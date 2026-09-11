<!-- Header -->


<header class="main-header">
    <div class="header-top">
        <div class="header-top-container">
            <div class="header-top-content">
                <a href="<?php echo home_url('/quem-somos'); ?>" class="header-top-text">Quem somos</a>
                <!-- up and down texts with animation -->
                <div class="animated-text-carousel">
                    <div class="text-carousel-container">
                        <?php
                        // Define carousel items with defaults
                        $carousel_items = array(
                            array(
                                'text' => get_theme_mod('US_carousel_text_1', 'FRETE GRÁTIS PARA TODO O BRASIL'),
                                'icon' => get_theme_mod('US_carousel_icon_1', '')
                            ),
                            array(
                                'text' => get_theme_mod('US_carousel_text_2', 'ENVIO NO MESMO DIA SÃO PAULO'),
                                'icon' => get_theme_mod('US_carousel_icon_2', '')
                            ),
                            array(
                                'text' => get_theme_mod('US_carousel_text_3', 'DESCONTO DE 5% NO PIX'),
                                'icon' => get_theme_mod('US_carousel_icon_3', '')
                            ),
                            array(
                                'text' => get_theme_mod('US_carousel_text_4', 'COMPRA 100% SEGURA'),
                                'icon' => get_theme_mod('US_carousel_icon_4', '')
                            ),
                            array(
                                'text' => get_theme_mod('US_carousel_text_5', 'ATENDIMENTO ESPECIALIZADO'),
                                'icon' => get_theme_mod('US_carousel_icon_5', '')
                            )
                        );

                        $first_item = true;
                        foreach ($carousel_items as $item) {
                            // Only display items that have non-empty text
                            if (!empty(trim($item['text']))) {
                                $active_class = $first_item ? ' active' : '';

                                // Handle uploaded images vs fallback to default image
                                if (!empty(trim($item['icon']))) {
                                    // Use uploaded image URL
                                    $icon_src = esc_url($item['icon']);
                                } else {
                                    // Fallback to default image
                                    $icon_src = get_template_directory_uri() . '/assets/images/brazil-home-truck-delivery-white.png';
                                }
                                ?>
                        <span class="carousel-text<?php echo $active_class; ?>">
                            <img class="carousel-text-icon" src="<?php echo $icon_src; ?>"
                                alt="<?php echo esc_attr($item['text']); ?>" />
                            <?php echo esc_html($item['text']); ?>
                        </span>
                        <?php
                                $first_item = false;
                            }
                        }
                        ?>
                    </div>
                </div>
                <a href="<?php echo home_url('/fale-conosco'); ?>" class="header-top-text">Fale conosco</a>
            </div>
        </div>
    </div>

    <div class="header-main">
        <div class="header-main-container">
            <div class="header-main-content">
                <button class="mobile-menu-toggle" aria-label="Toggle mobile menu">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>

                <button class="custom-search-button-mobile" id="custom-search-button-mobile">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-busca.svg"
                        alt="Buscar">
                </button>

                <div class="logo-section">
                    <a href="<?php echo home_url(); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-logo.png"
                            alt="Brazil Home Living" class="main-logo">
                    </a>
                </div>

                <?php if (class_exists('WooCommerce')): ?>
                <div style="display: none;">
                    <?php get_product_search_form(); ?>
                </div>
                <?php endif; ?>

                <div class="search-section">
                    <div class="search-bar">
                        <input type="text" placeholder="QUE ESTÁ PROCURANDO?" class="search-input"
                            id="custom-search-input">
                        <button class="search-button" id="custom-search-button">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-busca.svg"
                                alt="Buscar">
                        </button>
                    </div>
                </div>

                <div class="user-actions">
                    <div class="user-account">
                        <?php if (is_user_logged_in()): ?>
                        <?php $current_user = wp_get_current_user(); ?>
                        <a href="<?php echo get_permalink(get_page_by_path('minha-conta')); ?>"
                            class="user-account-link">
                            <span class="user-greeting">Olá <?php echo $current_user->display_name; ?></span>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-login.svg"
                                alt="Usuário" class="user-icon">
                        </a>
                        <?php else: ?>
                        <?php
                            // Use WooCommerce my-account page if available, otherwise fall back to wp-login
                            $login_url = class_exists('WooCommerce') ? wc_get_page_permalink('myaccount') : wp_login_url(home_url());
                            ?>
                        <a href="<?php echo esc_url($login_url); ?>" class="user-account-link">
                            <span class="user-greeting">Entrar</span>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-login.svg"
                                alt="Usuário" class="user-icon">
                        </a>
                        <?php endif; ?>
                    </div>
                    <div class="shopping-cart">
                        <?php if (class_exists('WooCommerce')): ?>
                        <a href="<?php echo wc_get_cart_url(); ?>" class="cart-link">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-carrinho.svg"
                                alt="Carrinho" class="cart-icon">
                            <?php
                                $cart_count = WC()->cart->get_cart_contents_count();
                                ?>
                            <span class="cart-count"
                                style="display: <?php echo $cart_count > 0 ? 'flex' : 'none'; ?>"><?php echo $cart_count; ?></span>
                        </a>
                        <?php else: ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-carrinho.svg"
                            alt="Carrinho" class="cart-icon">
                        <span class="cart-count" style="display: none;">0</span>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <nav class="main-navigation">
        <div class="header-nav-container">
            <div class="logo-section logo-scetion-mobile">
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-logo.png"
                        alt="Brazil Home Living" class="main-logo">
                </a>
            </div>
            <?php
            if (has_nav_menu('menu')) {
                wp_nav_menu(array(
                    'theme_location' => 'menu',
                    'menu_class' => 'nav-menu',
                    'menu_id' => 'mobile-menu',
                    'container' => false,
                    'fallback_cb' => false,
                ));
            } else {
                echo '<ul class="nav-menu" id="mobile-menu">';
                echo '<li class="menu-item"><a href="' . home_url() . '">No menu assigned - Go to Appearance > Menus and assign a menu to "Header Menu" location</a></li>';
                echo '</ul>';
            }
            ?>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>
</header>

<div class="header-cover"></div>