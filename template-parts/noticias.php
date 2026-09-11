<style>
.menu-container .menu-hamburguer {
    background-color: #EDDDC9;
}

.navbar-container .menu-container .menu-label {
    color: #F25C2D;
}
</style>


<?php
/*
Template Name: Notícias
*/
get_header();
?>

<?php if (!get_field('mostrar_secao_header')): ?>
<!-- News Header Section -->
<section class="noticias-header-section">
    <div class="noticias-header-container">
        <div class="noticias-header-content">
            <h1 class="noticias-main-title">NOTÍCIAS</h1>
            <div class="search-container">
                <div class="search-input-container" id="searchInputContainer">
                    <input type="text" class="search-input" placeholder="Buscar notícias..." id="searchInput">
                </div>
                <div class="search-icon" id="searchIcon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/home/search-01.png"
                        alt="Buscar">
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!get_field('mostrar_secao_destaque')): ?>
<!-- Featured News Section -->
<section class="featured-news-section">
    <div class="featured-news-container">
        <?php
            // Get the latest featured post
            $featured_post = new WP_Query(array(
                'posts_per_page' => 1,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC'
            ));

            if ($featured_post->have_posts()):
                while ($featured_post->have_posts()):
                    $featured_post->the_post();
                    ?>
        <div class="featured-news-card">
            <!-- Desktop Version -->
            <div class="featured-news-content featured-news-content-desktop">
                <a href="<?php the_permalink(); ?>">
                    <h2 class="featured-news-title"><?php the_title(); ?></h2>
                </a>

                <p class="featured-news-date"><?php echo get_the_date(); ?></p>

                <a href="<?php the_permalink(); ?>">
                    <p class="featured-news-description"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                </a>
                <a href="<?php the_permalink(); ?>" class="featured-news-link">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/home/tabler-icon-arrow-down-3.png"
                        alt="Ler mais">
                </a>
            </div>

            <!-- Mobile Version -->
            <div class="featured-news-content featured-news-content-mobile">
                <a href="<?php the_permalink(); ?>">
                    <h2 class="featured-news-title"><?php the_title(); ?></h2>
                </a>
                <p class="featured-news-date"><?php echo get_the_date(); ?></p>
                <a href="<?php the_permalink(); ?>">
                    <p class="featured-news-description"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                </a>
                <a href="<?php the_permalink(); ?>" class="featured-news-link">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/home/tabler-icon-arrow-down-3.png"
                        alt="Ler mais">
                </a>
            </div>

            <div class="featured-news-image">
                <?php if (has_post_thumbnail()): ?>
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('full', array('alt' => get_the_title())); ?>
                </a>
                <?php else: ?>
                <?php endif; ?>
            </div>
        </div>
        <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
    </div>
</section>
<?php endif; ?>

<?php if (!get_field('mostrar_secao_lista_noticias')): ?>
<!-- News Grid Section -->
<section class="news-grid-section">
    <div class="news-grid-container">
        <h2 class="news-grid-title">EM DESTAQUE</h2>

        <div class="news-grid" id="news-grid">
            <?php
                // Get current page number
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                // Query for posts (excluding the featured post)
                $news_query = new WP_Query(array(
                    'posts_per_page' => 12,
                    'paged' => $paged,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'offset' => 1 // Skip the featured post
                ));

                if ($news_query->have_posts()):
                    while ($news_query->have_posts()):
                        $news_query->the_post();
                        ?>
            <div class="noticias-noticia-item">
                <?php if (has_post_thumbnail()): ?>
                <div class="news-image">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium', array('alt' => get_the_title(), 'class' => 'news-image')); ?>
                    </a>
                </div>
                <?php else: ?>
                <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/home/image.png"
                        alt="<?php the_title(); ?>" class="news-image">
                </a>
                <?php endif; ?>
                <div class="news-content">
                    <a href="<?php the_permalink(); ?>">
                        <h3 class="news-title"><?php the_title(); ?></h3>
                    </a>
                    <p class="news-date"><?php echo get_the_date(); ?></p>
                    <div class="news-description-container">
                        <a href="<?php the_permalink(); ?>">
                            <p class="news-description"><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>
                        </a>
                        <a href="<?php the_permalink(); ?>" class="news-link">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/home/tabler-icon-arrow-down-3.png"
                                alt="Ler mais">
                        </a>
                    </div>
                </div>
            </div>
            <?php
                    endwhile;
                endif;
                ?>
        </div>

        <?php if ($news_query->max_num_pages > 1): ?>
        <div class="load-more-container">
            <button id="load-more-posts" class="load-more-btn" data-page="1"
                data-max-pages="<?php echo $news_query->max_num_pages; ?>">
                Carregar mais notícias
            </button>
            <div class="loading-spinner" style="display: none;">Carregando...</div>
        </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>











    </div>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>