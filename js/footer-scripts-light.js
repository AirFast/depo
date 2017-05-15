/* <![CDATA[ */

var jqu = jQuery.noConflict();

jqu( function () {
	
	/* Remove a class from the body tag if JavaScript is enabled */
	jqu( 'body' ).removeClass( 'no-js' );
	
	/* Masonry */
	var $container = jqu( '.hfeed-more');
	var width = $container.width();
	$container.imagesLoaded( function() {
		$container.masonry( {
			temSelector: '.hentry',
			columnWidth: width * 0.4787234042553191,
			gutterWidth: width * 0.0425531914893617,
			isResizable: true,
		} );
	} );

    /* Owl Carousel */
    jqu('.owl-carousel').owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
        autoplay: true,
        autoplayTimeout: slider_settings.timeout,
        autoplayHoverPause: true
    });
	
	/* FitVids */
	jqu( ".entry-content" ).fitVids();	
	
} );

/* ]]> */