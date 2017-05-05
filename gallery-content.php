<?php
/**
 * Gallery Content
 *
 */

$cat_id = get_query_var('cat');

$args = array(
    'cat' => $cat_id,
    'post_type' => 'oxygen_gallery',
    'meta_key' => '_oxygen_post_location',
    'meta_value' => 'gallery',
    'post__not_in' => get_option( 'sticky_posts' )
);

$loop = new WP_Query( $args );

if ( $loop->have_posts() ) :
$postCount = 0; ?>

    <div class="col-md-8">

        <div class="gallery-wrapper">

            <div id="gallery-content">

                <?php while ( $loop->have_posts() ) : $loop->the_post(); $postCount++; ?>

                    <?php if ($postCount == 1) : ?>

                        <div class="first-img">

                            <img class="img-responsive" src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="<?php the_title();?>">

                        </div>

                    <?php else : ?>

                        <div class="secondary-img">

                            <img class="img-responsive" src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="<?php the_title();?>">

<!--                            --><?php //the_post_thumbnail( 'large', 'class=img-responsive' ); ?>

                        </div>

                    <?php endif; ?>

                <?php endwhile; ?>

            </div><!-- #gallery-content -->

        </div><!-- .gallery-wrapper-->

    </div>

    <?php wp_reset_postdata(); ?>

<?php endif; ?>