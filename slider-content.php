<?php
/**
 * Featured Content (slider)
 *
 */

$cat_id = get_query_var('cat');

$args = array(
    'cat' => $cat_id,
    'meta_key' => '_oxygen_post_location',
    'meta_value' => 'slider',
    'post__not_in' => get_option( 'sticky_posts' )
);

$loop = new WP_Query( $args );
		
if ( $loop->have_posts() ) : ?>

    <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12 col-lg-offset-0 col-md-offset-0 col-sm-offset-1 col-xs-offset-0">

        <div class="featured-wrapper">

            <div id="featured-content">

                <div class="owl-carousel">

                    <!--                <img class="dummy --><?php //echo ( $loop->post_count == 1 ) ? 'hidden' : ''; ?><!--" src="--><?php //echo get_template_directory_uri() . '/images/empty.gif' ?><!--" alt="" width="750" height="380" />-->

                    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

                        <article class="featured-post">

                            <img class="img-responsive" src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="<?php the_title();?>">

                            <div class="excerpt"><?php the_excerpt(); ?></div>

                        </article> <!-- .featured-post -->

                    <?php endwhile; ?>

                </div>

            </div><!-- #featured-content -->

        </div><!-- .featured-wrapper-->

    </div>

    <?php wp_reset_postdata(); ?>

<?php endif; ?>