<?php
get_header();

if (have_posts()):
    while (have_posts()):
        the_post();
        ?>

<!-- Main Content -->
<main class="post-main">

    <!-- Hero Section -->
    <section class="post-hero">
        <div class="post-hero-image">
            <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
            <?php else: ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog.png" alt="<?php the_title(); ?>">
            <?php endif; ?>
        </div>
        <div class="post-hero-overlay">
            <div class="post-hero-container">
                <div class="post-hero-content">
                    <!-- Back Button -->
                    <div class="post-back-button">
                        <a href="<?php echo get_permalink(get_page_by_title('Blog')); ?>" class="back-link">VOLTAR AO
                            BLOG</a>
                    </div>

                    <div class="post-hero-content-container">
                        <div class="left-content-container">
                            <div class="post-meta">
                                <span
                                    class="post-date"><?php echo strtoupper(get_the_date('j \D\E F \D\E Y')); ?></span>
                                <span class="post-separator">|</span>
                                <?php
                                        $categories = get_the_category();
                                        if (!empty($categories)): ?>
                                <a href="<?php echo get_permalink(get_page_by_title('Blog')) . '?category=' . $categories[0]->slug; ?>"
                                    class="post-category-link">
                                    <span class="post-category"><?php echo strtoupper($categories[0]->name); ?></span>
                                </a>
                                <?php endif; ?>
                            </div>

                            <!-- Title -->
                            <h1 class="post-title"><?php echo strtoupper(get_the_title()); ?></h1>
                        </div>

                        <!-- Social Share -->
                        <div class="post-social-share">
                            <span class="share-text">Compartilhe</span>
                            <div class="social-buttons">
                                <a href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_permalink()); ?>"
                                    class="social-btn">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Mail-post.png"
                                        alt="Mail">
                                </a>
                                <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' - ' . get_permalink()); ?>"
                                    class="social-btn" target="_blank">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Whatsup-post.png"
                                        alt="Whatsapp">
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                                    class="social-btn" target="_blank">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/linkedin-post.png"
                                        alt="Linkedin">
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                                    class="social-btn" target="_blank">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/facebook-post.png"
                                        alt="Facebook">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Content -->
    <article class="post-article">
        <div class="post-container">
            <div class="post-content">
                <?php the_content(); ?>
            </div>
        </div>
    </article>

    <!-- Related Posts Section -->
    <section class="related-posts-section">
        <div class="post-container">
            <h2 class="related-posts-title">VEJA TAMBÉM</h2>
            <div class="related-posts-grid">
                <?php
                        // Get related posts from the same category
                        $categories = get_the_category();
                        $category_ids = array();
                        if ($categories) {
                            foreach ($categories as $category) {
                                $category_ids[] = $category->term_id;
                            }
                        }

                        $related_args = array(
                            'category__in' => $category_ids,
                            'post__not_in' => array(get_the_ID()),
                            'posts_per_page' => 3,
                            'orderby' => 'rand'
                        );
                        $related_query = new WP_Query($related_args);

                        if ($related_query->have_posts()):
                            while ($related_query->have_posts()):
                                $related_query->the_post();
                                ?>
                <a href="<?php the_permalink(); ?>" class="blog-card-link">
                    <article class="blog-card">
                        <div class="blog-card-image">
                            <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
                            <?php else: ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog.png"
                                alt="<?php the_title(); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="blog-card-content">
                            <div class="blog-card-content-inner">
                                <?php
                                                $post_categories = get_the_category();
                                                if (!empty($post_categories)): ?>
                                <span class="blog-category"><?php echo strtoupper($post_categories[0]->name); ?></span>
                                <?php endif; ?>
                                <h3 class="blog-card-title"><?php echo strtoupper(get_the_title()); ?></h3>
                            </div>
                            <img class="blog-read-more"
                                src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-up-right.png"
                                alt="Ler mais">
                        </div>
                    </article>
                </a>
                <?php
                            endwhile;
                        else:
                            // If no related posts, show recent posts
                            $recent_args = array(
                                'post__not_in' => array(get_the_ID()),
                                'posts_per_page' => 3,
                                'orderby' => 'date',
                                'order' => 'DESC'
                            );
                            $recent_query = new WP_Query($recent_args);

                            if ($recent_query->have_posts()):
                                while ($recent_query->have_posts()):
                                    $recent_query->the_post();
                                    ?>
                <a href="<?php the_permalink(); ?>" class="blog-card-link">
                    <article class="blog-card">
                        <div class="blog-card-image">
                            <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
                            <?php else: ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog.png"
                                alt="<?php the_title(); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="blog-card-content">
                            <div class="blog-card-content-inner">
                                <?php
                                                    $post_categories = get_the_category();
                                                    if (!empty($post_categories)): ?>
                                <span class="blog-category"><?php echo strtoupper($post_categories[0]->name); ?></span>
                                <?php endif; ?>
                                <h3 class="blog-card-title"><?php echo strtoupper(get_the_title()); ?></h3>
                            </div>
                            <img class="blog-read-more"
                                src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-up-right.png"
                                alt="Ler mais">
                        </div>
                    </article>
                </a>
                <?php
                                endwhile;
                            endif;
                            wp_reset_postdata();
                        endif;
                        wp_reset_postdata();
                        ?>
            </div>
        </div>
    </section>
</main>

<?php
    endwhile;
endif;

get_footer();
?>