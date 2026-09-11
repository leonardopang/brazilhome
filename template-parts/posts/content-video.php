<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */

?>
<?php
$taxonomy = 'categoria_kabumtv';
$terms = get_the_terms($post->ID, $taxonomy );

if ($terms && ! is_wp_error($terms)) :
    $tslugs_arr = array();
    foreach ($terms as $term) {
        $tslugs_arr[] = $term->name;
    }
    $terms_slug_str = join( ", ", $tslugs_arr);
endif;
?>
<div class="item">
  <div class="videoList">
    <div class="content">
      <span class="tag"><?php echo $terms_slug_str; ?></span>
      <?php the_title( '<h3>', '</h3>' ); ?>
    </div>
    <div class="video" style="background-image:url(https://img.youtube.com/vi/<?php the_field('video_kabumTV') ?>/mqdefault.jpg);"></div>
  </div>
</div>

