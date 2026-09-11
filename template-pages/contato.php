<?php
/*
Template Name: Contato
*/
get_header();

$facebook_url = get_theme_mod('US_link_facebook', '#');
$instagram_url = get_theme_mod('US_link_instagram', '#');
$whatsapp_url = get_theme_mod('US_link_whatsapp', '#');
$phone1 = get_theme_mod('US_phone_1', '(11)97672-4546');
$phone2 = get_theme_mod('US_phone_2', '');
$email = get_theme_mod('US_email', 'victorgaleazzo@live.com');
$youtube_url = get_theme_mod('US_link_youtube', '');
$tiktok_url = get_theme_mod('US_link_tiktok', '');


?>

<main class="contact-main">
    <!-- Contact Header -->
    <!-- Contact Content -->
    <section class="contact-content">
        <div class="contact-container">
            <div class="contact-grid">
                <!-- Contact Information -->
                <div class="contact-info-section">
                    <h2 class="contact-info-title"><?php echo get_field('form_titulo'); ?></h2>
                    <p class="contact-info-subtitle"><?php echo get_field('form_texto'); ?></p>

                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="contact-icon-container">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-tabler-icon-briefcase.png"
                                    alt="Telefone" class="contact-icon">
                            </div>
                            <div class="contact-item-content">
                                <div class="contact-phone">
                                    <a href="tel:<?php echo $phone1; ?>"
                                        class="contact-phone-link"><?php echo $phone1; ?></a>
                                    <div class="contact-phone-separator">|</div>
                                    <a href="tel:<?php echo $phone2; ?>"
                                        class="contact-phone-link"><?php echo $phone2; ?></a>
                                </div>
                                <div class="contact-email">
                                    <a href="mailto:<?php echo $email; ?>"
                                        class="contact-email-link"><?php echo $email; ?></a>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="social-links">
                        <?php if (!empty($youtube_url)): ?>
                        <a href="<?php echo esc_url($youtube_url); ?>" class="social-link" target="_blank"
                            rel="noopener noreferrer">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-youtube.svg"
                                alt="YouTube">
                        </a>
                        <?php endif; ?>

                        <?php if (!empty($instagram_url)): ?>
                        <a href="<?php echo esc_url($instagram_url); ?>" class="social-link" target="_blank"
                            rel="noopener noreferrer">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-instagram.svg"
                                alt="Instagram">
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

                <!-- Contact Form -->
                <div class="contact-form-section">
                    <?php echo do_shortcode('[contact-form-7 id="412" title="Fale Conosco"]'); ?>
                    <div class="privacy-agreement">
                        <input type="checkbox" id="privacy" name="privacy" class="privacy-checkbox" required>
                        <label for="privacy" class="privacy-label">
                            Ao informar meus dados, eu concordo com a
                            <a href="/politica-de-privacidade" class="privacy-link">Política de Privacidade</a>.
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>