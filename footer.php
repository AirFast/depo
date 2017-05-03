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

                    <div class="col-md-4">

                        <div id="footer-content" class="footer-content">
                            <p class="address">ул. Антоновича, 50, Киев 03150, Украина</p>
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

</body>
</html>