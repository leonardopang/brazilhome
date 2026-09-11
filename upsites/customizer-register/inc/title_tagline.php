<?php

$wp_customize->add_setting('US_link_facebook', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'esc_url_raw',
  'default' => '',
));
$wp_customize->add_control('US_link_facebook', array(
  'type' => 'text',
  'section' => 'title_tagline',
  'label' => __('Link facebook', 'upsites'),
));
$wp_customize->add_setting('US_link_instagram', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'esc_url_raw',
  'default' => '',
));
$wp_customize->add_control('US_link_instagram', array(
  'type' => 'text',
  'section' => 'title_tagline',
  'label' => __('Link instagram', 'upsites'),
));
$wp_customize->add_setting('US_link_whatsapp', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'esc_url_raw',
  'default' => '',
));
$wp_customize->add_control('US_link_whatsapp', array(
  'type' => 'text',
  'section' => 'title_tagline',
  'label' => __('Link whatsapp', 'upsites'),
));

$wp_customize->add_setting('US_link_youtube', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'esc_url_raw',
  'default' => '',
));
$wp_customize->add_control('US_link_youtube', array(
  'type' => 'text',
  'section' => 'title_tagline',
  'label' => __('Link YouTube', 'upsites'),
));

$wp_customize->add_setting('US_link_tiktok', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'esc_url_raw',
  'default' => '',
));
$wp_customize->add_control('US_link_tiktok', array(
  'type' => 'text',
  'section' => 'title_tagline',
  'label' => __('Link TikTok', 'upsites'),
));


$wp_customize->add_setting('US_copyright', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_text_field',
  'default' => '© 2025 - Todos os direitos reservados',
));
$wp_customize->add_control('US_copyright', array(
  'type' => 'text',
  'section' => 'title_tagline',
  'label' => __('Copyright', 'upsites'),
));

// Contact Information Settings
$wp_customize->add_setting('US_phone_1', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_text_field',
  'default' => '(11)97672-4546',
));
$wp_customize->add_control('US_phone_1', array(
  'type' => 'text',
  'section' => 'title_tagline',
  'label' => __('Telefone 1', 'upsites'),
));

$wp_customize->add_setting('US_phone_2', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_text_field',
  'default' => '',
));
$wp_customize->add_control('US_phone_2', array(
  'type' => 'text',
  'section' => 'title_tagline',
  'label' => __('Telefone 2', 'upsites'),
));

$wp_customize->add_setting('US_address', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_textarea_field',
  'default' => '',
));
$wp_customize->add_control('US_address', array(
  'type' => 'textarea',
  'section' => 'title_tagline',
  'label' => __('Endereço', 'upsites'),
));

$wp_customize->add_setting('US_business_hours', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_text_field',
  'default' => '08:00 às 19:00',
));
$wp_customize->add_control('US_business_hours', array(
  'type' => 'text',
  'section' => 'title_tagline',
  'label' => __('Horário de Funcionamento', 'upsites'),
));

$wp_customize->add_setting('US_email', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_email',
  'default' => 'victorgaleazzo@live.com',
));
$wp_customize->add_control('US_email', array(
  'type' => 'email',
  'section' => 'title_tagline',
  'label' => __('E-mail', 'upsites'),
));

// Hero Carousel Section
$wp_customize->add_section('US_hero_carousel', array(
  'title' => __('Hero Carousel (Slider Principal)', 'upsites'),
  'description' => __('Configure os slides personalizados na página inicial', 'upsites'),
  'priority' => 29,
));

// Number of products to display
$wp_customize->add_setting('US_hero_products_count', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'absint',
  'default' => 3,
));
$wp_customize->add_control('US_hero_products_count', array(
  'type' => 'number',
  'section' => 'US_hero_carousel',
  'label' => __('Número de Slides', 'upsites'),
  'description' => __('Quantidade de slides a exibir no carousel (1-5)', 'upsites'),
  'input_attrs' => array(
    'min' => 1,
    'max' => 5,
    'step' => 1,
  ),
));

// Default fallback description
$wp_customize->add_setting('US_hero_fallback_description', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_textarea_field',
  'default' => 'Descubra este produto incrível com a qualidade que você merece.',
));
$wp_customize->add_control('US_hero_fallback_description', array(
  'type' => 'textarea',
  'section' => 'US_hero_carousel',
  'label' => __('Descrição Padrão', 'upsites'),
  'description' => __('Texto exibido quando o produto não tem descrição', 'upsites'),
));

// CTA button text
$wp_customize->add_setting('US_hero_cta_text', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_text_field',
  'default' => 'COMPRAR AGORA',
));
$wp_customize->add_control('US_hero_cta_text', array(
  'type' => 'text',
  'section' => 'US_hero_carousel',
  'label' => __('Texto do Botão CTA', 'upsites'),
  'description' => __('Texto do botão de chamada para ação', 'upsites'),
));

// Autoplay speed
$wp_customize->add_setting('US_hero_autoplay_speed', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'absint',
  'default' => 5000,
));
$wp_customize->add_control('US_hero_autoplay_speed', array(
  'type' => 'number',
  'section' => 'US_hero_carousel',
  'label' => __('Velocidade do Autoplay (ms)', 'upsites'),
  'description' => __('Tempo entre slides em milissegundos (3000-8000)', 'upsites'),
  'input_attrs' => array(
    'min' => 3000,
    'max' => 8000,
    'step' => 500,
  ),
));

// Background color for text area
$wp_customize->add_setting('US_hero_bg_color', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_hex_color',
  'default' => '#1C4067',
));
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'US_hero_bg_color', array(
  'section' => 'US_hero_carousel',
  'label' => __('Cor de Fundo do Texto', 'upsites'),
  'description' => __('Cor de fundo da área de texto do hero', 'upsites'),
)));

// Text color
$wp_customize->add_setting('US_hero_text_color', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_hex_color',
  'default' => '#FFFFFF',
));
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'US_hero_text_color', array(
  'section' => 'US_hero_carousel',
  'label' => __('Cor do Texto', 'upsites'),
  'description' => __('Cor do texto (título, descrição) no hero', 'upsites'),
)));

// Custom Hero Items (up to 5 custom slides)
for ($i = 1; $i <= 5; $i++) {
  // Title
  $wp_customize->add_setting("US_hero_custom_{$i}_title", array(
    'capability' => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    'default' => '',
  ));
  $wp_customize->add_control("US_hero_custom_{$i}_title", array(
    'type' => 'text',
    'section' => 'US_hero_carousel',
    'label' => sprintf(__('Item Personalizado %d - Título', 'upsites'), $i),
    'description' => $i === 1 ? __('Adicione itens personalizados que serão exibidos junto com os produtos', 'upsites') : '',
  ));

  // Description
  $wp_customize->add_setting("US_hero_custom_{$i}_description", array(
    'capability' => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_textarea_field',
    'default' => '',
  ));
  $wp_customize->add_control("US_hero_custom_{$i}_description", array(
    'type' => 'textarea',
    'section' => 'US_hero_carousel',
    'label' => sprintf(__('Item Personalizado %d - Descrição', 'upsites'), $i),
  ));

  // CTA Text
  $wp_customize->add_setting("US_hero_custom_{$i}_cta_text", array(
    'capability' => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    'default' => 'SAIBA MAIS',
  ));
  $wp_customize->add_control("US_hero_custom_{$i}_cta_text", array(
    'type' => 'text',
    'section' => 'US_hero_carousel',
    'label' => sprintf(__('Item Personalizado %d - Texto do Botão', 'upsites'), $i),
  ));

  // Link
  $wp_customize->add_setting("US_hero_custom_{$i}_link", array(
    'capability' => 'edit_theme_options',
    'sanitize_callback' => 'esc_url_raw',
    'default' => '',
  ));
  $wp_customize->add_control("US_hero_custom_{$i}_link", array(
    'type' => 'url',
    'section' => 'US_hero_carousel',
    'label' => sprintf(__('Item Personalizado %d - Link', 'upsites'), $i),
  ));

  // Cover Image
  $wp_customize->add_setting("US_hero_custom_{$i}_image", array(
    'capability' => 'edit_theme_options',
    'sanitize_callback' => 'esc_url_raw',
    'default' => '',
  ));
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "US_hero_custom_{$i}_image", array(
    'section' => 'US_hero_carousel',
    'label' => sprintf(__('Item Personalizado %d - Imagem', 'upsites'), $i),
    'description' => __('Imagem de capa para este item', 'upsites'),
  )));
}

// Header Carousel Section
$wp_customize->add_section('US_header_carousel', array(
  'title' => __('Carousel do Cabeçalho', 'upsites'),
  'description' => __('Configure os textos e ícones do carousel animado no cabeçalho do site', 'upsites'),
  'priority' => 30,
));

// Header Carousel Text Settings
$wp_customize->add_setting('US_carousel_text_1', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_text_field',
  'default' => 'FRETE GRÁTIS PARA TODO O BRASIL',
));
$wp_customize->add_control('US_carousel_text_1', array(
  'type' => 'text',
  'section' => 'US_header_carousel',
  'label' => __('Texto Carousel 1', 'upsites'),
));

$wp_customize->add_setting('US_carousel_icon_1', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'esc_url_raw',
  'default' => '',
));
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'US_carousel_icon_1', array(
  'section' => 'US_header_carousel',
  'label' => __('Ícone Carousel 1', 'upsites'),
  'description' => __('Upload uma imagem para o ícone do primeiro item', 'upsites'),
)));

$wp_customize->add_setting('US_carousel_text_2', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_text_field',
  'default' => 'ENVIO NO MESMO DIA SÃO PAULO',
));
$wp_customize->add_control('US_carousel_text_2', array(
  'type' => 'text',
  'section' => 'US_header_carousel',
  'label' => __('Texto Carousel 2', 'upsites'),
));

$wp_customize->add_setting('US_carousel_icon_2', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'esc_url_raw',
  'default' => '',
));
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'US_carousel_icon_2', array(
  'section' => 'US_header_carousel',
  'label' => __('Ícone Carousel 2', 'upsites'),
  'description' => __('Upload uma imagem para o ícone do segundo item', 'upsites'),
)));

$wp_customize->add_setting('US_carousel_text_3', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_text_field',
  'default' => 'DESCONTO DE 5% NO PIX',
));
$wp_customize->add_control('US_carousel_text_3', array(
  'type' => 'text',
  'section' => 'US_header_carousel',
  'label' => __('Texto Carousel 3', 'upsites'),
));

$wp_customize->add_setting('US_carousel_icon_3', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'esc_url_raw',
  'default' => '',
));
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'US_carousel_icon_3', array(
  'section' => 'US_header_carousel',
  'label' => __('Ícone Carousel 3', 'upsites'),
  'description' => __('Upload uma imagem para o ícone do terceiro item', 'upsites'),
)));

$wp_customize->add_setting('US_carousel_text_4', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_text_field',
  'default' => 'COMPRA 100% SEGURA',
));
$wp_customize->add_control('US_carousel_text_4', array(
  'type' => 'text',
  'section' => 'US_header_carousel',
  'label' => __('Texto Carousel 4', 'upsites'),
));

$wp_customize->add_setting('US_carousel_icon_4', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'esc_url_raw',
  'default' => '',
));
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'US_carousel_icon_4', array(
  'section' => 'US_header_carousel',
  'label' => __('Ícone Carousel 4', 'upsites'),
  'description' => __('Upload uma imagem para o ícone do quarto item', 'upsites'),
)));

$wp_customize->add_setting('US_carousel_text_5', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'sanitize_text_field',
  'default' => 'ATENDIMENTO ESPECIALIZADO',
));
$wp_customize->add_control('US_carousel_text_5', array(
  'type' => 'text',
  'section' => 'US_header_carousel',
  'label' => __('Texto Carousel 5', 'upsites'),
));

$wp_customize->add_setting('US_carousel_icon_5', array(
  'capability' => 'edit_theme_options',
  'sanitize_callback' => 'esc_url_raw',
  'default' => '',
));
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'US_carousel_icon_5', array(
  'section' => 'US_header_carousel',
  'label' => __('Ícone Carousel 5', 'upsites'),
  'description' => __('Upload uma imagem para o ícone do quinto item', 'upsites'),
)));