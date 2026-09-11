<?php

$facebook_url = get_theme_mod('US_link_facebook', '');
$instagram_url = get_theme_mod('US_link_instagram', '');
$whatsapp_url = get_theme_mod('US_link_whatsapp', '');
$youtube_url = get_theme_mod('US_link_youtube', '');
$tiktok_url = get_theme_mod('US_link_tiktok', '');

?>

<footer class="main-footer">
    <div class="footer-top">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-contact">
                    <p class="contact-phone">
                        <a
                            href="tel:<?php echo esc_attr(str_replace(['(', ')', ' ', '-'], '', get_theme_mod('US_phone_1', '(11)97672-4546'))); ?>"><?php echo esc_html(get_theme_mod('US_phone_1', '(11)97672-4546')); ?></a>
                        <?php if (get_theme_mod('US_phone_2')): ?>
                        <a
                            href="tel:<?php echo esc_attr(str_replace(['(', ')', ' ', '-'], '', get_theme_mod('US_phone_2'))); ?>"><?php echo esc_html(get_theme_mod('US_phone_2')); ?></a><?php endif; ?>
                    </p>
                    <p class="contact-email">
                        <a
                            href="mailto:<?php echo esc_attr(get_theme_mod('US_email', 'victorgaleazzo@live.com')); ?>"><?php echo esc_html(get_theme_mod('US_email', 'victorgaleazzo@live.com')); ?></a>
                    </p>
                    <p class="contact-hours">
                        <?php echo esc_html(get_theme_mod('US_business_hours', '08:00 às 19:00')); ?>
                    </p>
                </div>

                <div class="footer-center">
                    <div class="footer-logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-logo.png"
                            alt="Brazil Home Living" class="footer-logo-img">
                    </div>
                    <div class="social-media">
                        <?php if (!empty($facebook_url)): ?>
                        <a href="<?php echo esc_url($facebook_url); ?>" class="social-link" target="_blank"
                            rel="noopener noreferrer">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-facebook-01.png"
                                alt="Facebook">
                        </a>
                        <?php endif; ?>

                        <?php if (!empty($instagram_url)): ?>
                        <a href="<?php echo esc_url($instagram_url); ?>" class="social-link" target="_blank"
                            rel="noopener noreferrer">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-instagram.svg"
                                alt="Instagram">
                        </a>
                        <?php endif; ?>

                        <?php if (!empty($whatsapp_url)): ?>
                        <a href="<?php echo esc_url($whatsapp_url); ?>" class="social-link" target="_blank"
                            rel="noopener noreferrer">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-whatsapp.png"
                                alt="WhatsApp">
                        </a>
                        <?php endif; ?>

                        <?php if (!empty($youtube_url)): ?>
                        <a href="<?php echo esc_url($youtube_url); ?>" class="social-link" target="_blank"
                            rel="noopener noreferrer">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-youtube.svg"
                                alt="YouTube">
                        </a>
                        <?php endif; ?>

                        <?php if (!empty($tiktok_url)): ?>
                        <a href="<?php echo esc_url($tiktok_url); ?>" class="social-link" target="_blank"
                            rel="noopener noreferrer">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-tiktok.svg"
                                alt="TikTok">
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="payment-methods">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-visa.png" alt="Visa"
                        class="payment-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-amex.png"
                        alt="Mastercard" class="payment-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-mastercard.png"
                        alt="PayPal" class="payment-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-applepay.png"
                        alt="Apple Pay" class="payment-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-googlepay.png"
                        alt="Google Pay" class="payment-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-affirm.png"
                        alt="Affirm" class="payment-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-visa.png"
                        alt="Google Pay" class="payment-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-mastercard.png"
                        alt="Affirm" class="payment-icon">
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-container">
            <nav class="footer-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer-menu',
                    'menu_class' => 'footer-menu',
                    'container' => false,
                    'fallback_cb' => false,
                ));
                ?>
            </nav>

            <div class="footer-legal">
                <p class="copyright">
                    <?php echo esc_html(get_theme_mod('US_copyright', '© 2025 - Todos os direitos reservados')); ?>
                </p>
                <a href="/politica-de-privacidade" target="_blank" class="legal-link">Política de
                    Privacidade</a>

            </div>
        </div>
    </div>
</footer>