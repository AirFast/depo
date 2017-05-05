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

    <div class="col-md-8">

        <div class="featured-wrapper">

            <div id="featured-content">

                <img class="dummy <?php echo ( $loop->post_count == 1 ) ? 'hidden' : ''; ?>" src="<?php echo get_template_directory_uri() . '/images/empty.gif' ?>" alt="" width="750" height="380" />

                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

                    <article class="featured-post">

                        <?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'featured-thumbnail' ) ); ?>

                        <div class="excerpt"><?php the_excerpt(); ?></div>

                    </article> <!-- .featured-post -->

                <?php endwhile; ?>

                <span id="slider-prev" class="slider-nav"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                <span id="slider-next" class="slider-nav"><i class="fa fa-angle-right" aria-hidden="true"></i></span>

            </div><!-- #featured-content -->

        </div><!-- .featured-wrapper-->

    </div>

    <?php wp_reset_postdata(); ?>

<?php endif; ?>