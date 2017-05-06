<?php
/**
 * Archive Template
 *
 * The archive template is the default template used for archives pages without a more specific template. 
 *
 * @package Oxygen
 * @subpackage Template
 */

get_header(); // Loads the header.php template. ?>

    <div class="container">

        <div class="row is-flex">

            <div class="col-md-4">

	            <aside class="aside">

                    <?php $cat_id = get_query_var('cat'); ?>

                    <div class="category-title">

                        <h1><?php echo get_cat_name( $cat_id );?></h1>

                    </div>

                    <div class="category-description">

                        <?php echo category_description( $cat_id ); ?>

                    </div>

                    <?php
                    $args = array(
                        'cat' => $cat_id,
                        'post_type' => 'oxygen_gallery',
                    );

                    $loop = new WP_Query( $args );
                    ?>

                    <?php if ( $loop->have_posts() ) : ?>

                        <p>ТАК</p>

                    <?php endif; ?>

		            <?php get_template_part( 'menu', 'secondary' ); // Loads the menu-secondary.php template.  ?>
		
		            <?php get_sidebar( 'primary' ); // Loads the sidebar-primary.php template. ?>
	
	            </aside>

            </div>

            <?php get_template_part( 'slider', 'content' ); ?>

            <?php get_template_part( 'gallery', 'content' ); ?>

        </div>

    </div>
	

<?php get_footer(); // Loads the footer.php template. ?>