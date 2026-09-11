<?php
/*
Template Name: Política de Privacidade
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();
?>


<article class="post-article">
    <div class="post-container">
        <div class="post-content">
            <?php the_content(); ?>
        </div>
    </div>
</article>

<?php get_footer(); ?>