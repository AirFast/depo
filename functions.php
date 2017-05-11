<?php
/**
 * @package Oxygen
 * @subpackage Functions
 * @version 0.5.7
 * @author AlienWP
 * @author Justin Tadlock <justin@justintadlock.com>
 * @link http://alienwp.com
 * @link http://justintadlock.com
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

/* Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
$theme = new Hybrid();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'oxygen_theme_setup' );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 */
function oxygen_theme_setup() {
	
	/* Admin functionality */
//	if ( is_admin() ) {
//		// Add Theme Documentation Page
//		require_once( get_template_directory() . '/admin/getting-started/getting-started.php' );
//	}

	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-styles', array( 'style' ) );
	add_theme_support( 'hybrid-core-menus', array( 'primary', 'secondary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-sidebars', array( 'primary', 'secondary', 'subsidiary', 'after-singular', 'header' ) );
	add_theme_support( 'hybrid-core-theme-settings', array( 'footer', 'about' ) );
	add_theme_support( 'hybrid-core-meta-box-footer' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-template-hierarchy' );

	/* Add theme support for framework extensions. */
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'cleaner-gallery' );
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'hybrid-core-scripts', array( 'comment-reply', 'drop-downs' ) );

	/* Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );

	/* Embed width/height defaults. */
	add_filter( 'embed_defaults', 'oxygen_embed_defaults' );

	/* Filter the sidebar widgets. */
	add_filter( 'sidebars_widgets', 'oxygen_disable_sidebars' );
        
	/* Image sizes */
	add_action( 'init', 'oxygen_image_sizes' );

	/* Excerpt ending */
	add_filter( 'excerpt_more', 'oxygen_excerpt_more' );
 
	/* Custom excerpt length */
	add_filter( 'excerpt_length', 'oxygen_excerpt_length' );    
        
	/* Filter the pagination trail arguments. */
	add_filter( 'loop_pagination_args', 'oxygen_pagination_args' );
	
	/* Filter the comments arguments */
	add_filter( "{$prefix}_list_comments_args", 'oxygen_comments_args' );	
	
	/* Filter the commentform arguments */
	add_filter( 'comment_form_defaults', 'oxygen_commentform_args', 11, 1 );
	
	/* Enqueue scripts (and related stylesheets) */
	add_action( 'wp_enqueue_scripts', 'oxygen_scripts' );
	
	/* Add the breadcrumb trail just after the container is open. */
	add_action( "{$prefix}_open_content", 'breadcrumb_trail' );
	
	/* Breadcrumb trail arguments. */
	add_filter( 'breadcrumb_trail_args', 'oxygen_breadcrumb_trail_args' );

	/* Add support for custom headers. */
	$args = array(
		'width'         => 400,
		'height'        => 100,
		'flex-height'   => true,
		'flex-width'    => true,		
		'header-text'   => false,
		'uploads'       => true,
	);
	add_theme_support( 'custom-header', $args );	
	
	/* Add support for custom backgrounds */
	add_theme_support( 'custom-background' );

	/* Add theme settings to the customizer. */
	require_once( trailingslashit( get_template_directory() ) . 'admin/customize.php' );
		
	/* Add support for Title Tag */    
	add_theme_support( 'title-tag' );
	
	/* Metaboxes */
	add_action( 'add_meta_boxes', 'oxygen_create_metabox' );
	add_action( 'save_post', 'oxygen_save_meta', 1, 2 );
	
	

	/** 
	* Disqus plugin: use higher priority.
	* URL: http://themehybrid.com/support/topic/weird-problem-wit-disqus-plugin 
	*/
	if( function_exists( 'dsq_comments_template' ) ) :
		remove_filter( 'comments_template', 'dsq_comments_template' );
		add_filter( 'comments_template', 'dsq_comments_template', 11 );
	endif;

	/* Remove the "Theme Settings" submenu. */
	add_action( 'admin_menu', 'oxygen_remove_theme_settings_submenu', 11 );	
	
}

/**
 * Disables sidebars if viewing a one-column page.
 *
 */
function oxygen_disable_sidebars( $sidebars_widgets ) {
	
	global $wp_query;
	
	    if ( is_page_template( 'page-template-fullwidth.php' ) ) {
		    $sidebars_widgets['primary'] = false;
			$sidebars_widgets['secondary'] = false;
	    }

	return $sidebars_widgets;
}

/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.  This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 */
function oxygen_embed_defaults( $args ) {
	
	$args['width'] = 470;
		
	if ( is_page_template( 'page-template-fullwidth.php' ) )
		$args['width'] = 940;

	return $args;
}

/**
 * Excerpt ending 
 *
 */
function oxygen_excerpt_more( $more ) {	
	return '...';
}

/**
 *  Custom excerpt lengths 
 *
 */
function oxygen_excerpt_length( $length ) {
	return 25;
}

/**
 * Enqueue scripts (and related stylesheets)
 *
 */
function oxygen_scripts() {
	
	if ( !is_admin() ) {
		
		/* Enqueue Scripts */	
		wp_enqueue_script( 'oxygen_imagesloaded', get_template_directory_uri() . '/js/jquery.imagesloaded.js', array( 'jquery' ), '1.0', true );	
		wp_enqueue_script( 'oxygen_masonry', get_template_directory_uri() . '/js/jquery.masonry.min.js', array( 'jquery' ), '1.0', true );	
		wp_enqueue_script( 'oxygen_cycle', get_template_directory_uri() . '/js/cycle/jquery.cycle.min.js', array( 'jquery' ), '1.0', true );		
		wp_enqueue_script( 'oxygen_fitvids', get_template_directory_uri() . '/js/fitvids/jquery.fitvids.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'oxygen_navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20130301', true );		
		wp_enqueue_script( 'oxygen_footer_scripts', get_template_directory_uri() . '/js/footer-scripts.js', array( 'jquery', 'oxygen_imagesloaded', 'oxygen_masonry', 'oxygen_cycle', 'oxygen_fancybox', 'oxygen_fitvids' ), '1.0', true );
		
		/* Enqueue Fancybox if enabled. */	
		if ( get_theme_mod( 'oxygen_fancybox_enable' ) ) {
			wp_enqueue_script( 'oxygen_fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox-1.3.4.pack.js', array( 'jquery' ), '1.0', true );
			wp_enqueue_style( 'fancybox-stylesheet', get_template_directory_uri() . '/js/fancybox/jquery.fancybox-1.3.4.css', false, 1.0, 'screen' );
			wp_enqueue_script( 'oxygen_footer_scripts', get_template_directory_uri() . '/js/footer-scripts.js', array( 'jquery', 'oxygen_imagesloaded', 'oxygen_masonry', 'oxygen_cycle', 'oxygen_fancybox', 'oxygen_fitvids' ), '1.0', true );
		} else {
			wp_enqueue_script( 'oxygen_footer_scripts_light', get_template_directory_uri() . '/js/footer-scripts-light.js', array( 'jquery', 'oxygen_imagesloaded', 'oxygen_masonry', 'oxygen_cycle', 'oxygen_fitvids' ), '1.0', true );
		}
				
	}
}

/**
 * Pagination args 
 *
 */
function oxygen_pagination_args( $args ) {
	
	$args['prev_text'] = __( '&larr; Previous', 'oxygen' );
	$args['next_text'] = __( 'Next &rarr;', 'oxygen' );

	return $args;
}

/**
 *  Image sizes
 *
 */
function oxygen_image_sizes() {
	
	add_image_size( 'archive-thumbnail', 470, 140, true );
	add_image_size( 'single-thumbnail', 470, 260, true );
	add_image_size( 'featured-thumbnail', 750, 380, true );
	add_image_size( 'slider-nav-thumbnail', 110, 70, true );
}

/**
 *  Unregister Hybrid widgets
 *
 */
function oxygen_unregister_widgets() {
	
	unregister_widget( 'Hybrid_Widget_Search' );
	register_widget( 'WP_Widget_Search' );	
}

/**
 * Custom comments arguments
 * 
 */
function oxygen_comments_args( $args ) {
	
	$args['avatar_size'] = 40;
	return $args;
}

/**
 *  Custom comment form arguments
 * 
 */
function oxygen_commentform_args( $args ) {
	
	global $user_identity;

	/* Get the current commenter. */
	$commenter = wp_get_current_commenter();

	/* Create the required <span> and <input> element class. */
	$req = ( ( get_option( 'require_name_email' ) ) ? ' <span class="required">' . __( '*', 'oxygen' ) . '</span> ' : '' );
	$input_class = ( ( get_option( 'require_name_email' ) ) ? ' req' : '' );
	
	
	$fields = array(
		'author' => '<p class="form-author' . $input_class . '"><input type="text" class="text-input" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" size="40" /><label for="author">' . __( 'Name', 'oxygen' ) . $req . '</label></p>',
		'email' => '<p class="form-email' . $input_class . '"><input type="text" class="text-input" name="email" id="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="40" /><label for="email">' . __( 'Email', 'oxygen' ) . $req . '</label></p>',
		'url' => '<p class="form-url"><input type="text" class="text-input" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="40" /><label for="url">' . __( 'Website', 'oxygen' ) . '</label></p>'
	);
	
	$args = array(
		'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field' => '<p class="form-textarea req"><!--<label for="comment">' . __( 'Comment', 'oxygen' ) . '</label>--><textarea name="comment" id="comment" cols="60" rows="10"></textarea></p>',
		'must_log_in' => '<p class="alert">' . sprintf( __( 'You must be <a href="%1$s" title="Log in">logged in</a> to post a comment.', 'oxygen' ), wp_login_url( get_permalink() ) ) . '</p><!-- .alert -->',
		'logged_in_as' => '<p class="log-in-out">' . sprintf( __( 'Logged in as <a href="%1$s" title="%2$s">%2$s</a>.', 'oxygen' ), admin_url( 'profile.php' ), esc_attr( $user_identity ) ) . ' <a href="' . wp_logout_url( get_permalink() ) . '" title="' . esc_attr__( 'Log out of this account', 'oxygen' ) . '">' . __( 'Log out &rarr;', 'oxygen' ) . '</a></p><!-- .log-in-out -->',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'id_form' => 'commentform',
		'id_submit' => 'submit',
		'title_reply' => __( 'Leave a Reply', 'oxygen' ),
		'title_reply_to' => __( 'Leave a Reply to %s', 'oxygen' ),
		'cancel_reply_link' => __( 'Click here to cancel reply.', 'oxygen' ),
		'submit_button' => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
		'submit_field' => '<p class="form-submit">%1$s %2$s</p>',
		'label_submit' => __( 'Post Comment &rarr;', 'oxygen' ),
	);
	
	return $args;
}

/**
 * Breadcrumb trail arguments.
 *
 */
function oxygen_breadcrumb_trail_args( $args ) {

	$args['before'] = '';
	$args['separator'] = '&nbsp; / &nbsp;';
	$args['front_page'] = false;
	
	return $args;
}


/**
 * Metaboxes
 *
 */
function oxygen_create_metabox() {
    add_meta_box( 'oxygen_metabox', __( 'Location', 'oxygen' ), 'oxygen_metabox', ['post', 'oxygen_gallery'], 'advanced', 'default' );
}
             
function oxygen_metabox() {
	
	global $post;
	
	/* Retrieve metadata values if they already exist. */
	$oxygen_post_location = get_post_meta( $post->ID, '_oxygen_post_location', true ); ?>	
	
	<p><label><input type="radio" name="oxygen_post_location" value="slider" <?php echo esc_attr( $oxygen_post_location ) == 'slider' ? 'checked="checked"' : '' ?> /> <?php echo __( 'Slider', 'oxygen' ) ?></label></p>
    <p><label><input type="radio" name="oxygen_post_location" value="gallery" <?php echo esc_attr( $oxygen_post_location ) == 'gallery' ? 'checked="checked"' : '' ?> /> <?php echo __( 'Gallery', 'oxygen' ) ?></label></p>
    <p><label><input type="radio" name="oxygen_post_location" value="standard" <?php echo esc_attr( $oxygen_post_location ) == 'standard' ? 'checked="checked"' : '' ?> /> <?php echo __( 'Standard', 'oxygen' ) ?></label></p>
	<p><label><input type="radio" name="oxygen_post_location" value="primary" <?php echo esc_attr( $oxygen_post_location ) == 'primary' ? 'checked="checked"' : '' ?> /> <?php echo __( 'Primary', 'oxygen' ) ?></label></p>
	<p><label><input type="radio" name="oxygen_post_location" value="secondary" <?php echo esc_attr( $oxygen_post_location ) == 'secondary' ? 'checked="checked"' : '' ?> /> <?php echo __( 'Secondary', 'oxygen' ) ?></label></p>
	<p><label><input type="radio" name="oxygen_post_location" value="no-display" <?php echo esc_attr( $oxygen_post_location ) == 'no-display' ? 'checked="checked"' : '' ?> /> <?php echo __( 'Do not display', 'oxygen' ) ?></label></p>	
		
	<span class="description"><?php _e( 'Post location on the home page', 'oxygen' ); ?>
	<?php           
}

/* Save post metadata. */
function oxygen_save_meta( $post_id, $post ) {
	if ( isset( $_POST['oxygen_post_location'] ) ) {
		update_post_meta( $post_id, '_oxygen_post_location', strip_tags( $_POST['oxygen_post_location'] ) );
	}
}

/**
 * Oxygen site title.
 * 
 */
function oxygen_site_title() {
	
	$tag = ( is_front_page() ) ? 'h1' : 'div';

	if ( get_header_image() ) {

		echo '<' . $tag . ' id="site-title">' . "\n";
			echo '<a href="' . get_home_url() . '" title="' . get_bloginfo( 'name' ) . '" rel="Home">' . "\n";
				echo '<img class="logo" src="' . get_header_image() . '" alt="' . get_bloginfo( 'name' ) . '" />' . "\n";
			echo '</a>' . "\n";
		echo '</' . $tag . '>' . "\n";
	
	} elseif ( hybrid_get_setting( 'oxygen_logo_url' ) ) { // check for legacy setting
			
		echo '<' . $tag . ' id="site-title">' . "\n";
			echo '<a href="' . get_home_url() . '" title="' . get_bloginfo( 'name' ) . '" rel="Home">' . "\n";
				echo '<img class="logo" src="' . esc_url( hybrid_get_setting( 'oxygen_logo_url' ) ) . '" alt="' . get_bloginfo( 'name' ) . '" />' . "\n";
			echo '</a>' . "\n";
		echo '</' . $tag . '>' . "\n";
	
	} else {
	
		hybrid_site_title();
	
	}
}

/**
 * Remove the "Theme Settings" submenu.
 *
 */
function oxygen_remove_theme_settings_submenu() {

	/* Remove the Theme Settings settings page. */
	remove_submenu_page( 'themes.php', 'theme-settings' );
}

// register custom post type 'add_gallery_post_type'
add_action( 'init', 'add_gallery_post_type' );
function add_gallery_post_type() {
    register_post_type( 'oxygen_gallery',
        array(
            'labels' => array(
                'name' => __( 'Gallery' ),
                'singular_name' => __( 'Gallery' ),
                'all_items' => __( 'All Images' ),
            ),
            'public' => true,
            'menu_icon'   => 'dashicons-images-alt',
            'has_archive' => false,
            'exclude_from_search' => true,
            'rewrite' => array('slug' => 'gallery-item'),
            'supports' => array( 'title', 'thumbnail' ),
            'menu_position' => 4,
            'show_in_admin_bar'   => false,
            'show_in_nav_menus'   => false,
            'publicly_queryable'  => false,
            'query_var'           => false
        )
    );
}

function oxygen_get_backend_preview_thumb($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'thumbnail');
        return $post_thumbnail_img[0];
    }
}

function oxygen_preview_thumb_column_head($defaults) {
    $defaults['featured_image'] = __(  'Image' );
    return $defaults;
}
add_filter('manage_oxygen_gallery_posts_columns', 'oxygen_preview_thumb_column_head');

function oxygen_preview_thumb_column($column_name, $post_ID) {
    if ($column_name == 'featured_image') {
        $post_featured_image = oxygen_get_backend_preview_thumb($post_ID);
        if ($post_featured_image) {
            echo '<img src="' . $post_featured_image . '" />';
        }
    }
}
add_action('manage_posts_custom_column', 'oxygen_preview_thumb_column', 10, 2);

add_action( 'init', 'wp_add_gallery_cats' );
function wp_add_gallery_cats()
{
    register_taxonomy_for_object_type( 'category', 'oxygen_gallery' );
}

add_action('do_meta_boxes', 'oxygen_move_meta_box');

function oxygen_move_meta_box(){
    remove_meta_box( 'postimagediv', 'oxygen_gallery', 'side' );
    add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', 'oxygen_gallery', 'normal', 'high');
}


class oxygenMetaBox {
	function __construct($options) {
		$this->options = $options;
		$this->prefix = $this->options['id'] .'_';
		add_action( 'add_meta_boxes', array( &$this, 'create' ) );
		add_action( 'save_post', array( &$this, 'save' ), 1, 2 );
	}
	function create() {
		foreach ($this->options['post'] as $post_type) {
			if (current_user_can( $this->options['cap'])) {
				add_meta_box($this->options['id'], $this->options['name'], array(&$this, 'fill'), $post_type, $this->options['pos'], $this->options['pri']);
			}
		}
	}
	function fill(){
		global $post; $p_i_d = $post->ID;
		wp_nonce_field( $this->options['id'], $this->options['id'].'_wpnonce', false, true );
		?>
		<table class="form-table"><tbody><?php
		foreach ( $this->options['args'] as $param ) {
			if (current_user_can( $param['cap'])) {
			?><tr><?php
				if(!$value = get_post_meta($post->ID, $this->prefix .$param['id'] , true)) $value = $param['std'];
				switch ( $param['type'] ) {
					case 'text':{ ?>
						<th scope="row"><label for="<?php echo $this->prefix .$param['id'] ?>"><?php echo $param['title'] ?></label></th>
						<td>
							<input name="<?php echo $this->prefix .$param['id'] ?>" type="<?php echo $param['type'] ?>" id="<?php echo $this->prefix .$param['id'] ?>" value="<?php echo $value ?>" placeholder="<?php echo $param['placeholder'] ?>" class="regular-text" /><br />
							<span class="description"><?php echo $param['desc'] ?></span>
						</td>
						<?php
						break;
					}
					case 'textarea':{ ?>
						<th scope="row"><label for="<?php echo $this->prefix .$param['id'] ?>"><?php echo $param['title'] ?></label></th>
						<td>
							<textarea name="<?php echo $this->prefix .$param['id'] ?>" type="<?php echo $param['type'] ?>" id="<?php echo $this->prefix .$param['id'] ?>" value="<?php echo $value ?>" placeholder="<?php echo $param['placeholder'] ?>" class="large-text" /><?php echo $value ?></textarea><br />
							<span class="description"><?php echo $param['desc'] ?></span>
						</td>
						<?php
						break;
					}
					case 'checkbox':{ ?>
						<th scope="row"><label for="<?php echo $this->prefix .$param['id'] ?>"><?php echo $param['title'] ?></label></th>
						<td>
							<label for="<?php echo $this->prefix .$param['id'] ?>"><input name="<?php echo $this->prefix .$param['id'] ?>" type="<?php echo $param['type'] ?>" id="<?php echo $this->prefix .$param['id'] ?>"<?php echo ($value=='on') ? ' checked="checked"' : '' ?> />
							<?php echo $param['desc'] ?></label>
						</td>
						<?php
						break;
					}
					case 'select':{ ?>
						<th scope="row"><label for="<?php echo $this->prefix .$param['id'] ?>"><?php echo $param['title'] ?></label></th>
						<td>
							<label for="<?php echo $this->prefix .$param['id'] ?>">
							<select name="<?php echo $this->prefix .$param['id'] ?>" id="<?php echo $this->prefix .$param['id'] ?>"><option><?php echo $param['std']; ?></option><?php
								foreach($param['args'] as $val=>$name){
									?><option value="<?php echo $val ?>"<?php echo ( $value == $val ) ? ' selected="selected"' : '' ?>><?php echo $name ?></option><?php
								}
							?></select></label><br />
							<span class="description"><?php echo $param['desc'] ?></span>
						</td>
						<?php
						break;
					}
				}
			?></tr><?php
			}
		}
		?></tbody></table><?php
	}
	function save($post_id, $post){
		if ( !wp_verify_nonce( $_POST[ $this->options['id'].'_wpnonce' ], $this->options['id'] ) ) return;
		if ( !current_user_can( 'edit_post', $post_id ) ) return;
		if ( !in_array($post->post_type, $this->options['post'])) return;
		foreach ( $this->options['args'] as $param ) {
			if ( current_user_can( $param['cap'] ) ) {
				if ( isset( $_POST[ $this->prefix . $param['id'] ] ) && trim( $_POST[ $this->prefix . $param['id'] ] ) ) {
					update_post_meta( $post_id, $this->prefix . $param['id'], trim($_POST[ $this->prefix . $param['id'] ]) );
				} else {
					delete_post_meta( $post_id, $this->prefix . $param['id'] );
				}
			}
		}
	}
}


$options = array(
	array( // первый метабокс
		'id'	=>	'departments', // ID метабокса, а также префикс названия произвольного поля
		'name'	=>	__('Контактна інформація відділів', 'oxygen'), // заголовок метабокса
		'post'	=>	array('page'), // типы постов для которых нужно отобразить метабокс
		'pos'	=>	'normal', // расположение, параметр $context функции add_meta_box()
		'pri'	=>	'high', // приоритет, параметр $priority функции add_meta_box()
		'cap'	=>	'edit_posts', // какие права должны быть у пользователя
		'args'	=>	array(

		    array(
				'id'			=>	'marketing_name',
				'title'			=>	__('Назва відділу', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'desc'			=>	__('введіть назву відділу', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'marketing_email',
				'title'			=>	__('E-mail відділу', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'desc'			=>	__('введіть email відділу', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'marketing_phone',
				'title'			=>	__('Телефон відділу', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'desc'			=>	__('введіть номер телефона відділу', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'marketing_display',
				'title'			=>	__('Чи показувати контактну інформацію цього віддіу?', 'oxygen'),
				'type'			=>	'checkbox',
				'desc'			=>	__('якщо бажаєте то поставте/або зніміть відмітку', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),

			array(
				'id'			=>	'services_name',
				'title'			=>	__('Назва відділу', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'desc'			=>	__('введіть назву відділу', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'services_email',
				'title'			=>	__('E-mail відділу', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'desc'			=>	__('введіть email відділу', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'services_phone',
				'title'			=>	__('Телефон відділу', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'desc'			=>	__('введіть номер телефона відділу', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'services_display',
				'title'			=>	__('Чи показувати контактну інформацію цього віддіу?', 'oxygen'),
				'type'			=>	'checkbox',
				'desc'			=>	__('якщо бажаєте то поставте/або зніміть відмітку', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),

			array(
				'id'			=>	'reservation_name',
				'title'			=>	__('Назва відділу', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'desc'			=>	__('введіть назву відділу', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'reservation_email',
				'title'			=>	__('E-mail відділу', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'desc'			=>	__('введіть email відділу', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'reservation_phone',
				'title'			=>	__('Телефон відділу', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'desc'			=>	__('введіть номер телефона відділу', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'reservation_display',
				'title'			=>	__('Чи показувати контактну інформацію цього віддіу?', 'oxygen'),
				'type'			=>	'checkbox',
				'desc'			=>	__('якщо бажаєте то поставте/або зніміть відмітку', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),

			array(
				'id'			=>	'issues_name',
				'title'			=>	__('Назва відділу', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'desc'			=>	__('введіть назву відділу', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'issues_email',
				'title'			=>	__('E-mail відділу', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'desc'			=>	__('введіть email відділу', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'issues_phone',
				'title'			=>	__('Телефон відділу', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'desc'			=>	__('введіть номер телефона відділу', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'issues_display',
				'title'			=>	__('Чи показувати контактну інформацію цього віддіу?', 'oxygen'),
				'type'			=>	'checkbox',
				'desc'			=>	__('якщо бажаєте то поставте/або зніміть відмітку', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			)
		)
	),
	array( // второй метабокс
		'id'	=>	'google_map',
		'name'	=>	__('Дані для Google крти', 'oxygen'),
		'post'	=>	array('page'), // не только для постов, но и для страниц
		'pos'	=>	'normal',
		'pri'	=>	'high',
		'cap'	=>	'edit_posts',
		'args'	=>	array(
			array(
				'id'			=>	'api_key',
				'title'			=>	'API key',
				'desc'			=>	__('введіть API key для Google карти', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'std'           =>  'YOUR_API_KEY',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'lat',
				'title'			=>	__('Широта', 'oxygen'),
				'desc'			=>	__('введіть координати - широту', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'std'           =>  '50.450912',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'lng',
				'title'			=>	__('Довгота', 'oxygen'),
				'desc'			=>	__('введіть координати - довготу', 'oxygen'),
				'type'			=>	'text',
				'placeholder'	=>	'',
				'std'           =>  '30.522663',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'zoom',
				'title'			=>	__('Зум карти', 'oxygen'),
				'type'			=>	'select',
				'desc'			=>	__('виберіть зручне наближення до карти', 'oxygen'),
				'cap'			=>	'edit_posts',
				'std'           =>  '5',
				'args'			=>	array('8' => '8', '10' => '10', '12' => '12', '14' => '14', '15' => '15', '17' => '17') // элементы списка задаются через массив args, по типу value=>лейбл
			),
			array(
				'id'			=>	'description',
				'title'			=>	__('Додатковий опис', 'oxygen'),
				'desc'			=>	__('введіть опис, який буде відображатися при кліку на мркер карти', 'oxygen'),
				'type'			=>	'textarea',
				'placeholder'	=>	'',
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			),
			array(
				'id'			=>	'display',
				'title'			=>	__('Чи показувати карту?', 'oxygen'),
				'type'			=>	'checkbox',
				'desc'			=>	__('якщо бажаєте то поставте/або зніміть відмітку', 'oxygen'),
				'std'           =>  '',
				'cap'			=>	'edit_posts'
			)
		)
	)
);

foreach ($options as $option) {
	$oxygenmetabox = new oxygenMetaBox($option);
}

//Registration translation rows for departments
pll_register_string('Емейл', 'E-mail', 'Departments');
pll_register_string('Телефон', 'Phone', 'Departments');

?>