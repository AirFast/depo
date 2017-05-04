<?php
/**
 * Gallery Content
 *
 */

$cat_id = get_query_var('cat');
$args = array(
    'post_type'      => 'zm_gallery',
    'posts_per_page' => -1,
    'cat'            => $cat_id,
);
$query = new WP_Query( $args );
?>
<div class="col-md-8">

    <div class="gallery-wrapper">

        <?php if ( $query->have_posts() ) : $postCount = 0; while ( $query->have_posts() ) : $query->the_post(); $postCount++; ?>

            <?php if ($postCount == 1) : ?>

                    <div class="first-img">

                        <?php the_post_thumbnail( 'large' ); ?>

                    </div>

            <?php else : ?>

                    <div class="secondary-img">

                        <?php the_post_thumbnail( 'large' ); ?>

                    </div>

            <?php endif; ?>

        <?php endwhile; endif; ?>

    </div>

</div>