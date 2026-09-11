<?php
/*
Template Name: Blog
*/
get_header();

// Get current page number for pagination
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Check if category filter is applied
$category_filter = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

if ($category_filter) {
    // If filtering by category, show only posts from that category
    $featured_args = array(
        'category_name' => $category_filter,
        'posts_per_page' => 6,
        'post_status' => 'publish'
    );
    $featured_query = new WP_Query($featured_args);

    $posts_args = array(
        'category_name' => $category_filter,
        'posts_per_page' => 9,
        'paged' => $paged,
        'post_status' => 'publish'
    );
    $posts_query = new WP_Query($posts_args);
} else {
    // Default behavior - show featured posts and exclude them from regular posts
    $featured_args = array(
        'category_name' => 'Destaque',
        'posts_per_page' => 6,
        'post_status' => 'publish'
    );
    $featured_query = new WP_Query($featured_args);

    $posts_args = array(
        'category__not_in' => array(get_cat_ID('Destaque')),
        'posts_per_page' => 9,
        'paged' => $paged,
        'post_status' => 'publish'
    );
    $posts_query = new WP_Query($posts_args);
}
?>

<main class="blog-main">
    <!-- Blog Header -->
    <section class="blog-header-section">
        <div class="blog-container">
            <div class="blog-header">
                <h1 class="blog-main-title">Blog</h1>
                <?php if ($category_filter): ?>
                    <h2 class="blog-main-subtitle">CATEGORIA:
                        <?php echo esc_html(strtoupper(str_replace('-', ' ', $category_filter))); ?>
                    </h2>
                    <a href="<?php echo get_permalink(); ?>" class="blog-clear-filter">Ver todos os posts</a>
                <?php else: ?>
                    <h2 class="blog-main-subtitle">FIQUE POR DENTRO DO BLOG</h2>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php if ($featured_query->have_posts() && !$category_filter): ?>
        <!-- Featured Blog Posts -->
        <section class="blog-featured-section">
            <div class="blog-featured-arrows">
                <button class="arrow-button arrow-prev" id="blog-prev">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-left-arrow.png"
                        alt="Previous">
                </button>
                <button class="arrow-button arrow-next" id="blog-next">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-right-arrow.png"
                        alt="Next">
                </button>
            </div>
            <div class="blog-container">
                <div class="blog-carousel">
                    <?php while ($featured_query->have_posts()):
                        $featured_query->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="blog-card-link">
                            <article class="blog-card">
                                <div class="blog-card-image">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('full', array('alt' => get_the_title())); ?>
                                    <?php else: ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-blog.png"
                                            alt="<?php the_title(); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="blog-card-content">
                                    <div class="blog-card-content-inner">
                                        <?php
                                        $categories = get_the_category();
                                        if (!empty($categories)): ?>
                                            <span class="blog-category"><?php echo strtoupper($categories[0]->name); ?></span>
                                        <?php endif; ?>
                                        <h3 class="blog-card-title"><?php echo strtoupper(get_the_title()); ?></h3>
                                    </div>
                                    <img class="blog-read-more"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-arrow-up-right.png"
                                        alt="Ler mais">
                                </div>
                            </article>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>

    <!-- Latest Posts Section -->
    <section class="blog-posts-section">
        <div class="blog-container">
            <div class="blog-section-header">
                <?php if ($category_filter): ?>
                    <h2 class="blog-section-title">POSTS DA CATEGORIA:
                        <?php echo esc_html(strtoupper(str_replace('-', ' ', $category_filter))); ?>
                    </h2>
                <?php else: ?>
                    <h2 class="blog-section-title">ÚLTIMAS POSTAGENS</h2>
                <?php endif; ?>
            </div>

            <?php if ($posts_query->have_posts()): ?>
                <div class="blog-posts-grid">
                    <?php while ($posts_query->have_posts()):
                        $posts_query->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="blog-card-link">
                            <article class="blog-card">
                                <div class="blog-card-image">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('full', array('alt' => get_the_title())); ?>
                                    <?php else: ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-blog.png"
                                            alt="<?php the_title(); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="blog-card-content">
                                    <div class="blog-card-content-inner">
                                        <?php
                                        $categories = get_the_category();
                                        if (!empty($categories)): ?>
                                            <span class="blog-category"><?php echo strtoupper($categories[0]->name); ?></span>
                                        <?php endif; ?>
                                        <h3 class="blog-card-title"><?php echo strtoupper(get_the_title()); ?></h3>
                                    </div>
                                    <img class="blog-read-more"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/brazil-home-arrow-up-right.png"
                                        alt="Ler mais">
                                </div>
                            </article>
                        </a>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <?php if ($posts_query->max_num_pages > 1): ?>
                    <div class="pagination">
                        <?php
                        $total_pages = $posts_query->max_num_pages;
                        $current_page = max(1, $paged);

                        // Previous page
                        if ($current_page > 1):
                            $prev_page = $current_page - 1;
                            $prev_link = ($prev_page == 1) ? get_permalink() : get_permalink() . 'page/' . $prev_page . '/';
                        ?>
                            <a href="<?php echo $prev_link; ?>" class="pagination-btn pagination-arrow">&laquo;</a>
                        <?php endif; ?>

                        <?php
                        // Show page numbers
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($total_pages, $current_page + 2);

                        for ($i = $start_page; $i <= $end_page; $i++):
                            $page_link = ($i == 1) ? get_permalink() : get_permalink() . 'page/' . $i . '/';
                            $active_class = ($i == $current_page) ? ' active' : '';
                        ?>
                            <a href="<?php echo $page_link; ?>" class="pagination-btn<?php echo $active_class; ?>">
                                <?php echo sprintf('%02d', $i); ?>
                            </a>
                        <?php endfor; ?>

                        <?php
                        // Next page
                        if ($current_page < $total_pages):
                            $next_page = $current_page + 1;
                            $next_link = get_permalink() . 'page/' . $next_page . '/';
                        ?>
                            <a href="<?php echo $next_link; ?>" class="pagination-btn pagination-arrow">&raquo;</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="no-posts">
                    <p>Nenhuma postagem encontrada.</p>
                </div>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>