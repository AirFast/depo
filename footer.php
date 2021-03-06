<?php
/**
 * Footer Template
 *
 * The footer template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the bottom of the file. It is used mostly as a closing
 * wrapper, which is opened with the header.php file. It also executes key functions needed
 * by the theme, child themes, and plugins. 
 *
 * @package Oxygen
 * @subpackage Template
 */
?>
				
				
				<?php get_sidebar( 'secondary' ); // Loads the sidebar-secondary.php template. ?>
				
				</div><!-- .content-wrap -->

				<?php do_atomic( 'close_main' ); // oxygen_close_main ?>

		</section><!-- #main -->

		<?php do_atomic( 'after_main' ); // oxygen_after_main ?>

		<?php get_sidebar( 'subsidiary' ); // Loads the sidebar-subsidiary.php template. ?>		

		<?php do_atomic( 'before_footer' ); // oxygen_before_footer ?>

		<footer id="footer">

            <div class="container">

                <div class="row">

                    <div class="col-lg-4 col-md-4 col-sm-10 col-xs-12 col-lg-offset-0 col-md-offset-0 col-sm-offset-1 col-xs-offset-0">

                        <div id="footer-content" class="footer-content">
                            <p class="address">ул. Антоновича, 50, Киев</p>
                            <p class="country">03150, Украина</p>
                            <div class="social-networks">
                                <a href="" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                <a href="" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                                <a href="" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                            </div>
                            <p class="copyright"><?php bloginfo( 'name' ); ?> &#169; <?php echo date('Y'); ?></p>
                        </div>

                    </div>

                    <div class="col-md-8">

                        <?php get_template_part( 'menu', 'subsidiary' ); // Loads the menu-subsidiary.php template.  ?>

                        <?php do_atomic( 'footer' ); // oxygen_footer ?>

                        <?php do_atomic( 'close_footer' ); // oxygen_close_footer ?>

                    </div>

                </div>

            </div>

		</footer><!-- #footer -->

		<?php do_atomic( 'after_footer' ); // oxygen_after_footer ?>
		
		</div><!-- .wrap -->

	</div><!-- #container -->

	<?php do_atomic( 'close_body' ); // oxygen_close_body ?>
	
	<?php wp_footer(); // wp_footer ?>

    <?php if ( is_page_template( 'page-contacts.php' ) ) : ?>

        <?php if ( get_post_meta($post->ID, 'google_map_display', true) ) : ?>

            <?php

                $api_key = get_post_meta($post->ID, 'google_map_api_key', true);
                $lat = get_post_meta($post->ID, 'google_map_lat', true);
                $lng = get_post_meta($post->ID, 'google_map_lng', true);
                $zoom = get_post_meta($post->ID, 'google_map_zoom', true);
                $description = get_post_meta($post->ID, 'google_map_description', true);

            ?>

            <script>
                // Google map
                function initMap() {
                    var LatLng = {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>};
                    var map = new google.maps.Map(document.getElementById('page-map'), {
                        zoom: <?php echo $zoom; ?>, // 17
                        center: LatLng
                    });
                    var contentString = '<div id="content">'+
                        '<h1 id="firstHeading" class="firstHeading"><?php bloginfo( 'name' ); ?></h1>'+
                        '<div id="bodyContent">'+
                        '<p><?php bloginfo( 'name' ); ?>, <?php bloginfo( 'description' ); ?></p>'+
                        '<p><?php echo $description; ?></p>'+
                        '</div>'+
                        '</div>';
                    var infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });
                    var marker = new google.maps.Marker({
                        position: LatLng,
                        map: map,
                        title: '<?php bloginfo( 'name' ); ?>' + ' - ' + '<?php bloginfo( 'description' ); ?>'
                    });
                    marker.addListener('click', function() {
                        infowindow.open(map, marker);
                    });
                }
            </script>

            <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $api_key;?>&callback=initMap" type="text/javascript"></script>

        <?php endif; ?>

    <?php endif; ?>

</body>
</html>