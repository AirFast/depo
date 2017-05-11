<?php
/**
 * Standard Content
 *
 */

$cat_id = get_query_var('cat');

$args = array(
    'cat' => $cat_id,
    'meta_key' => '_oxygen_post_location',
    'meta_value' => 'standard',
    'post__not_in' => get_option( 'sticky_posts' )
);

$loop = new WP_Query( $args );

if ( $loop->have_posts() ) : ?>

    <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12 col-lg-offset-0 col-md-offset-0 col-sm-offset-1 col-xs-offset-0">

        <div class="standard-wrapper">

            <div id="standard-content">

                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

                        <article class="standard-post">

                            <div class="standard-post-img">

                                <img class="img-responsive" src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="<?php the_title();?>">

                            </div>

                            <div class="standard-post-content">

                                <h2><?php the_title();?></h2>

                                <?php the_content(); ?>

                            </div>

                        </article>

                <?php endwhile; ?>

            </div><!-- #standard-content -->

        </div><!-- .standard-wrapper-->

    </div>

    <?php wp_reset_postdata(); ?>

<?php endif; ?>