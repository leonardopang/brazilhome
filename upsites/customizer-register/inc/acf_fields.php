<?php

if (function_exists('acf_add_local_field_group')) :

  // Product FAQs Field Group
  acf_add_local_field_group(array(
    'key' => 'group_product_faqs',
    'title' => 'FAQs do Produto',
    'fields' => array(
      array(
        'key' => 'field_product_faqs',
        'label' => 'Perguntas Frequentes',
        'name' => 'product_faqs',
        'type' => 'repeater',
        'instructions' => 'Adicione perguntas e respostas frequentes específicas para este produto.',
        'required' => 0,
        'layout' => 'block',
        'button_label' => 'Adicionar FAQ',
        'sub_fields' => array(
          array(
            'key' => 'field_faq_question',
            'label' => 'Pergunta',
            'name' => 'question',
            'type' => 'text',
            'required' => 1,
            'placeholder' => 'Digite a pergunta aqui'
          ),
          array(
            'key' => 'field_faq_answer',
            'label' => 'Resposta',
            'name' => 'answer',
            'type' => 'textarea',
            'required' => 1,
            'rows' => 3,
            'placeholder' => 'Digite a resposta aqui'
          )
        )
      )
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'product',
        ),
      ),
    ),
    'menu_order' => 20,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
  ));

  // Product Custom Reviews Field Group
  acf_add_local_field_group(array(
    'key' => 'group_product_custom_reviews',
    'title' => 'Avaliações Personalizadas',
    'fields' => array(
      array(
        'key' => 'field_product_custom_reviews',
        'label' => 'Avaliações Customizadas',
        'name' => 'product_custom_reviews',
        'type' => 'repeater',
        'instructions' => 'Adicione avaliações personalizadas que serão exibidas junto com as avaliações reais dos clientes.',
        'required' => 0,
        'layout' => 'block',
        'button_label' => 'Adicionar Avaliação',
        'sub_fields' => array(
          array(
            'key' => 'field_review_author',
            'label' => 'Nome do Avaliador',
            'name' => 'author',
            'type' => 'text',
            'required' => 1,
            'placeholder' => 'Nome do cliente'
          ),
          array(
            'key' => 'field_review_picture',
            'label' => 'Foto do Avaliador (opcional)',
            'name' => 'reviewer_picture',
            'type' => 'image',
            'required' => 0,
            'return_format' => 'array',
            'preview_size' => 'thumbnail',
            'library' => 'all',
            'instructions' => 'Adicione uma foto do avaliador (opcional). Recomendado: 100x100px'
          ),
          array(
            'key' => 'field_review_rating',
            'label' => 'Avaliação (1-5 estrelas)',
            'name' => 'rating',
            'type' => 'number',
            'required' => 1,
            'default_value' => 5,
            'min' => 1,
            'max' => 5,
            'step' => 1
          ),
          array(
            'key' => 'field_review_content',
            'label' => 'Comentário',
            'name' => 'content',
            'type' => 'textarea',
            'required' => 1,
            'rows' => 4,
            'placeholder' => 'Escreva o comentário da avaliação'
          ),
          array(
            'key' => 'field_review_date',
            'label' => 'Data (opcional)',
            'name' => 'date',
            'type' => 'text',
            'required' => 0,
            'placeholder' => 'Ex: 2 dias atrás, 1 semana atrás',
            'instructions' => 'Deixe em branco para usar data automática'
          ),
          array(
            'key' => 'field_review_gallery',
            'label' => 'Imagens do Produto (opcional)',
            'name' => 'imagens_produto',
            'type' => 'gallery',
            'instructions' => 'Adicione imagens relacionadas ao review.',
            'required' => 0,
            'return_format' => 'array',
            'preview_size' => 'medium',
            'insert' => 'append',
            'library' => 'all'
          ),

        )
      )
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'product',
        ),
      ),
    ),
    'menu_order' => 21,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
  ));


  // Product Comparison Field Group
  acf_add_local_field_group(array(
    'key' => 'group_product_comparison',
    'title' => 'Comparação de Produtos',
    'fields' => array(
      array(
        'key' => 'field_comparison_product_1',
        'label' => 'Produto para Comparar 1',
        'name' => 'comparison_product_1',
        'type' => 'post_object',
        'instructions' => 'Selecione o primeiro produto para comparar com este produto',
        'required' => 0,
        'post_type' => array('produto_comparacao'),
        'allow_null' => 1,
        'multiple' => 0,
        'return_format' => 'id'
      ),
      array(
        'key' => 'field_comparison_product_2',
        'label' => 'Produto para Comparar 2',
        'name' => 'comparison_product_2',
        'type' => 'post_object',
        'instructions' => 'Selecione o segundo produto para comparar com este produto',
        'required' => 0,
        'post_type' => array('produto_comparacao'),
        'allow_null' => 1,
        'multiple' => 0,
        'return_format' => 'id'
      )
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'product',
        ),
      ),
    ),
    'menu_order' => 22,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
  ));

  // Add product attributes support to comparison products
  acf_add_local_field_group(array(
    'key' => 'group_comparison_product_attributes',
    'title' => 'Atributos do Produto',
    'fields' => array(
      array(
        'key' => 'field_comparison_attributes',
        'label' => 'Atributos/Materiais',
        'name' => 'comparison_attributes',
        'type' => 'repeater',
        'instructions' => 'Adicione os atributos e especificações do produto (Material, Cor, etc.)',
        'required' => 0,
        'layout' => 'table',
        'button_label' => 'Adicionar Atributo',
        'sub_fields' => array(
          array(
            'key' => 'field_attribute_name',
            'label' => 'Nome do Atributo',
            'name' => 'attribute_name',
            'type' => 'text',
            'required' => 1,
            'placeholder' => 'Ex: Material, Cor, Tamanho'
          ),
          array(
            'key' => 'field_attribute_value',
            'label' => 'Valor',
            'name' => 'attribute_value',
            'type' => 'text',
            'required' => 1,
            'placeholder' => 'Ex: Aço, Azul, Grande'
          )
        )
      )
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'produto_comparacao',
        ),
      ),
    ),
    'menu_order' => 10,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
  ));

endif;
