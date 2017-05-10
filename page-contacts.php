<?php
/**
 * Template Name: Contacts
 *
 */
get_header(); // Loads the header.php template. ?>

    <div class="container">

    <div class="row is-flex">

        <div class="col-md-4">

            <aside class="aside">

                <div class="page-title">

                    <h1><?php the_title(); ?></h1>

                </div>

                <div class="page-description">

                    <?php  ?>

                </div>

                <?php get_template_part( 'menu', 'secondary' ); // Loads the menu-secondary.php template.  ?>

                <?php get_sidebar( 'primary' ); // Loads the sidebar-primary.php template. ?>

            </aside>

        </div>

        <div class="col-md-8">

            <div class="page-wrap">

                <div id="page-content">

                    <?php if ( have_posts() ) : ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <article class="page">

                                <div class="page-img">

                                    <img class="img-responsive" src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="<?php the_title();?>">

                                </div>

                                <div id="page-map"></div>

                                <div class="content">

                                    <?php the_content(); ?>

                                </div>

                            </article>

                        <?php endwhile; ?>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>


<?php get_footer(); // Loads the footer.php template. ?>
