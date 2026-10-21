<?php

/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section, opens the <body> tag and adds the site's header.
 *
 * @package Brazil Home Theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!-- Google tag (gtag.js): config is queued right away, the library loads on first interaction or after page load to keep it off the critical path -->
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-MPBDMY6JB0');

        (function() {
            var loaded = false;

            function loadGtag() {
                if (loaded) return;
                loaded = true;
                if (document.querySelector('script[src*="gtag/js?id=G-MPBDMY6JB0"]')) return;
                var s = document.createElement('script');
                s.async = true;
                s.src = 'https://www.googletagmanager.com/gtag/js?id=G-MPBDMY6JB0';
                document.head.appendChild(s);
            }
            ['scroll', 'click', 'touchstart', 'keydown', 'mousemove'].forEach(function(evt) {
                window.addEventListener(evt, loadGtag, {
                    once: true,
                    passive: true
                });
            });
            window.addEventListener('load', function() {
                setTimeout(loadGtag, 3500);
            });
        })();
    </script>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="author" content="Criação de Site por UpSites">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style data-no-optimize="1" data-nowprocket>body.home #custom-banner-section{aspect-ratio:1143/568}.home-banner-spacer{width:100%;aspect-ratio:1143/568}body:has(#custom-banner-section) .home-banner-spacer{display:none}</style>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php
    get_template_part('template-parts/header');

    // Reserves the height of the JS-injected home banner (#custom-banner-section) to avoid layout shift.
    if (is_front_page() || is_home()) {
        echo '<div class="home-banner-spacer" aria-hidden="true"></div>';
    }

    // WhatsApp Floating Button
    if (get_theme_mod('whatsapp_enable', true) && get_theme_mod('whatsapp_number', '')) {
        $whatsapp_number = get_theme_mod('whatsapp_number', '');
        $whatsapp_message = get_theme_mod('whatsapp_message', 'Olá! Gostaria de mais informações.');
        $whatsapp_tagline = get_theme_mod('whatsapp_tagline', 'Fale conosco!');
        $whatsapp_url = 'https://api.whatsapp.com/send?phone=' . $whatsapp_number . '&text=' . urlencode($whatsapp_message);
    ?>
        <div id="whatsapp-float" class="whatsapp-float">
            <a href="<?php echo esc_url($whatsapp_url); ?>" target="_blank" rel="noopener" class="whatsapp-button">
                <div class="whatsapp-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"
                            fill="currentColor" />
                    </svg>
                </div>
            </a>
        </div>
    <?php
    }