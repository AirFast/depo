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

                    <?php if ( have_posts() ) : ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <?php
                                $email = pll__( 'E-mail' );
                                $phone = pll__( 'Phone' );
                            ?>

                            <?php if ( get_post_meta($post->ID, 'departments_marketing_display', true) ) : ?>

                                <div class="department-box">

                                    <h3><?php echo get_post_meta($post->ID, 'departments_marketing_name', true); ?></h3>
                                    <p><span><?php echo $email . ' '; ?></span><?php echo get_post_meta($post->ID, 'departments_marketing_email', true); ?></p>
                                    <p><span><?php echo $phone . ' '; ?></span><?php echo get_post_meta($post->ID, 'departments_marketing_phone', true); ?></p>

                                </div>

                            <?php endif; ?>

                            <?php if ( get_post_meta($post->ID, 'departments_services_display', true) ) : ?>

                                <div class="department-box">

                                    <h3><?php echo get_post_meta($post->ID, 'departments_services_name', true); ?></h3>
                                    <p><span><?php echo $email . ' '; ?></span><?php echo get_post_meta($post->ID, 'departments_services_email', true); ?></p>
                                    <p><span><?php echo $phone . ' '; ?></span><?php echo get_post_meta($post->ID, 'departments_services_phone', true); ?></p>

                                </div>

                            <?php endif; ?>

                            <?php if ( get_post_meta($post->ID, 'departments_reservation_display', true) ) : ?>

                                <div class="department-box">

                                    <h3><?php echo get_post_meta($post->ID, 'departments_reservation_name', true); ?></h3>
                                    <p><span><?php echo $email . ' '; ?></span><?php echo get_post_meta($post->ID, 'departments_reservation_email', true); ?></p>
                                    <p><span><?php echo $phone . ' '; ?></span><?php echo get_post_meta($post->ID, 'departments_reservation_phone', true); ?></p>

                                </div>

                            <?php endif; ?>

                            <?php if ( get_post_meta($post->ID, 'departments_issues_display', true) ) : ?>

                                <div class="department-box">

                                    <h3><?php echo get_post_meta($post->ID, 'departments_issues_name', true); ?></h3>
                                    <p><span><?php echo $email . ' '; ?></span><?php echo get_post_meta($post->ID, 'departments_issues_email', true); ?></p>
                                    <p><span><?php echo $phone . ' '; ?></span><?php echo get_post_meta($post->ID, 'departments_issues_phone', true); ?></p>

                                </div>

                            <?php endif; ?>

                        <?php endwhile; ?>

                    <?php endif; ?>

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

                                <?php if ( get_post_meta($post->ID, 'google_map_display', true) ) : ?>

                                    <div id="page-map"></div>

                                <?php endif; ?>

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
