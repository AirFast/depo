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

    <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12 col-lg-offset-0 col-md-offset-0 col-sm-offset-1 col-xs-offset-0">

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

                        </div>

                    <?php endif; ?>

                <?php endwhile; ?>

            </div><!-- #gallery-content -->

            <div class="btn more-content">
                <button id="button">Більше фото</button>
            </div>

        </div><!-- .gallery-wrapper-->

    </div>

    <?php wp_reset_postdata(); ?>

<?php endif; ?>