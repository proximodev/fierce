<?php
/**
 * Fierce
 *
 * @package Fierce
 * @author  4All Digital
 * @link    https://4all.digital
 */

// Start the engine
include_once( get_template_directory() . '/lib/init.php' );

// Setup theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'digital_localization_setup' );
function digital_localization_setup(){
	load_child_theme_textdomain( '4all-digital', get_stylesheet_directory() . '/languages' );
}

// Add the theme's helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Child theme
define( 'CHILD_THEME_NAME', 'Fierce' );
define( 'CHILD_THEME_URL', 'https://getfierce.com' );
$rand = rand();
define( 'CHILD_THEME_VERSION', '1.0');

// Enqueue scripts and styles.
add_action( 'wp_enqueue_scripts', 'digital_scripts_styles' );
function digital_scripts_styles() {

    // wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600', array(), CHILD_THEME_VERSION );
	// wp_enqueue_style( 'fancy-box-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css', array(), CHILD_THEME_VERSION);
	// wp_enqueue_script( 'fontawesome', 'https://kit.fontawesome.com/273d628194.js', array( 'jquery' ), CHILD_THEME_VERSION);
	// wp_enqueue_script( 'fancy-box', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true);

    wp_enqueue_script( 'digital-global-scripts', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), CHILD_THEME_VERSION, true);

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'digital-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'digital-responsive-menu',
		'genesis_responsive_menu',
		digital_responsive_menu_settings()
	);

}


/*
* Tracking
*/

/** Add google tag manager **/
if ((!current_user_can('administrator')) && (!current_user_can('editor')))
{
    add_action( 'wp_head', 'add_tag_manager' );
    add_action( 'genesis_before',  'add_tag_manager' );
    function add_tag_manager() {
        if ( current_filter() == 'wp_head' ):
            ?>
            <!-- Google Tag Manager -->
            <!-- End Google Tag Manager -->
            <?php
        else:
            ?>
            <!-- Google Tag Manager (noscript) -->
            <!-- End Google Tag Manager (noscript) -->
            <?php
        endif;
    }
}

/** Add hubspot **/
if ((!current_user_can('administrator')) && (!current_user_can('editor')))
{
    add_action( 'wp_footer',  'add_hubspot', 9999 );
    function add_hubspot() {
        ?>
        <!-- Start of HubSpot Embed Code -->
        <!-- End of HubSpot Embed Code -->
        <?php
    }
}

// Add last modified file to stylesheet URL
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'wd_genesis_child_stylesheet' );
function wd_genesis_child_stylesheet() {
	$theme_name = defined('CHILD_THEME_NAME') && CHILD_THEME_NAME ? sanitize_title_with_dashes(CHILD_THEME_NAME) : 'child-theme';
	$version = defined( 'CHILD_THEME_VERSION' ) && CHILD_THEME_VERSION ? CHILD_THEME_VERSION : PARENT_THEME_VERSION;
	$version .= '.' . date ( "njYHi", filemtime( get_stylesheet_directory() . '/style.css' ) );
	wp_enqueue_style( $theme_name, get_stylesheet_uri(), array(), $version );
}

// Remove WP emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

//* Remove Font Awesome
add_action( 'wp_print_styles', 'tn_dequeue_font_awesome_style' );
function tn_dequeue_font_awesome_style() {
      wp_dequeue_style( 'genesis-blocks-fontawesome' );
      wp_deregister_style( 'genesis-blocks-fontawesome' );
}

//* Add DNS Prefetch
function dns_prefetch() {
    echo '<meta http-equiv="x-dns-prefetch-control" content="on">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//www.googletagservices.com">';
}
add_action('genesis_meta', 'dns_prefetch', 10000);

// Update for cropping in local env
add_filter ('wp_image_editors', 'wpse303391_change_graphic_editor');
function wpse303391_change_graphic_editor ($array) {
    return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Add accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add screen reader class to archive description.
add_filter( 'genesis_attr_author-archive-description', 'genesis_attributes_screen_reader_class' );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );


/*
* Header and navigation
*/

// Define our responsive menu settings.
function digital_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( '<label for="genesis-mobile-nav-primary">Menu</label>', 'digital-pro' ),
		'menuIconClass'    => 'ionicons-before far fa-bars',
		'subMenu'          => __( '', 'digital-pro' ),
		'subMenuIconClass' => 'ionicons-before ion-ios-arrow-down',
		'menuClasses'      => array(
			'others'  => array(
				'.nav-primary',
			),
		),
	);
	return $settings;
}

// Add Custom CTA Menu
function register_additional_menu() {
	register_nav_menu( 'cta-menu' ,__( 'Primary CTA Menu' ));
}
add_action( 'init', 'register_additional_menu' );
add_action( 'genesis_header', 'add_third_nav_genesis',13 );
function add_third_nav_genesis() {
	echo'<div class="nav-cta">';
		wp_nav_menu( array( 'theme_location' => 'cta-menu', 'container_class' => 'genesis-nav-menu' ) );
	echo'</div>';
}
remove_action( 'genesis_header','genesis_do_nav' ) ;

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => ",
	'height'          => ",
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Header Menu', 'digital-pro' ), 'secondary' => __( 'Footer Menu', 'digital-pro' ) ) );

// Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Remove navigation meta box.
add_action( 'genesis_theme_settings_metaboxes', 'digital_remove_genesis_metaboxes' );
function digital_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}

// Remove header right widget area.
unregister_sidebar( 'header-right' );

// Reposition primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Reposition secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 12 );

// Reduce secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'digital_secondary_menu_args' );
function digital_secondary_menu_args( $args ) {
	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}
	$args['depth'] = 1;
	return $args;
}

// Remove skip link for primary navigation.
add_filter( 'genesis_skip_links_output', 'digital_skip_links_output' );
function digital_skip_links_output( $links ) {
	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}
	return $links;
}


/*
* Custom Content Types
*/


/**
 * Post Settings
*/

/** Blog archive settings **/
add_action('init', function(){
   add_rewrite_rule(
      '^blog/category/([^/]+)([/]?)(.*)',
      'index.php?pagename=blog&post-category=$matches[1]',
      'top'
   );
});

add_filter('query_vars', function( $vars ){
    $vars[] = 'pagename';
    $vars[] = 'post-category';
    return $vars;
});

/** Add sidebar to archive and post pages **/
add_filter( 'genesis_pre_get_option_site_layout', 'custom_set_single_posts_layout' );
function custom_set_single_posts_layout() {
    if ( is_single() || is_archive() || ! is_singular()) {
 	    return 'content-sidebar';
 	}
}

// Reposition post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 4 );

// Post page updates
function add_news_title() {

    // Set archive entry
    if (is_archive()) {
        echo '<h1 class="entry-title">Blog</h1>';
    }

    // Hide blog title and metadata
    if ( is_singular('post') ) {
         remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
         remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    }

};
add_action('genesis_before_content', 'add_news_title');

// Customize post index metadata
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	if ( !is_page() ) {
		$post_info = '[post_date] | [post_terms sep=", " before=""]';
		return $post_info;
	}
}

// Remove entry meta in the entry footer on category pages
add_action( 'genesis_before_entry', 'digital_remove_entry_footer' );
function digital_remove_entry_footer() {
	if ( is_single() ) {
		return;
	}
	remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
}

// Remove secondary sidebar
unregister_sidebar( 'sidebar-alt' );

// Remove site layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

add_action( 'genesis_footer', 'license_widget_area',14);
function license_widget_area() {
	genesis_widget_area( 'licenses', array(
		'before' => '<div class="footer-widgets footer-licenses"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

// Customize the content limit more markup
add_filter( 'get_the_content_limit', 'digital_content_limit_read_more_markup', 10, 3 );
function digital_content_limit_read_more_markup( $output, $content, $link ) {
	$output = sprintf( '<p>%s &#x02026;</p><p class="more-link-wrap">%s</p>', $content, str_replace( '&#x02026;', '', $link ) );
	return $output;
}

// Customize author box title
add_filter( 'genesis_author_box_title', 'digital_author_box_title' );
function digital_author_box_title() {
	return '<span itemprop="name">' . get_the_author() . '</span>';
}

/*
* Widget Updates
*/

// Create blog social widget
function blog_social_widget_init() {
register_sidebar( array(
'name'          => 'Blog Social Icons',
'id'            => 'blog_social_icons',
'before_widget' => '<div class="widget simple-social-icons">',
    'after_widget'  => '</div>',
'before_title'  => '',
'after_title'   => '',
) );

}
add_action( 'widgets_init', 'blog_social_widget_init' );

// Create blog social widget
genesis_register_sidebar( array(
'id'          => 'licenses',
'name'        => __( 'Footer Licences' ),
) );

// Setup widget counts
function digital_count_widgets( $id ) {
	$sidebars_widgets = wp_get_sidebars_widgets();
	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}
}

/*
* Custom classes
*/

// Flexible widget classes
function digital_widget_area_class( $id ) {
	$count = digital_count_widgets( $id );
	$class = '';
	if ( $count == 1 ) {
		$class .= ' widget-full';
	} elseif ( $count % 3 == 1 ) {
		$class .= ' widget-thirds';
	} elseif ( $count % 4 == 1 ) {
		$class .= ' widget-fourths';
	} elseif ( $count % 2 == 0 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves even';
	}
	return $class;
}

// Flexible widget classes.
function digital_halves_widget_area_class( $id ) {
	$count = digital_count_widgets( $id );
	$class = '';
	if ( $count == 1 ) {
		$class .= ' widget-full';
	} elseif ( $count % 2 == 0 ) {
		$class .= ' widget-halves';
	} else {
		$class .= ' widget-halves uneven';
	}
	return $class;
}

// Add support for 9-column footer widget.
add_theme_support( 'genesis-footer-widgets', 8);

//* Reposition the breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_before_footer', 'genesis_do_breadcrumbs',1 );

//* Add custom body class
add_filter( 'body_class', 'sp_body_class' );
function sp_body_class( $classes ) {
	$classes[] = '4alldigital';
	return $classes;
}

/*
* Ninja Forms
*/

/** custom form icon **/
add_filter( 'ninja_forms_field_template_file_paths', 'custom_field_file_path' );
function custom_field_file_path( $paths ){
	$paths[] =  get_stylesheet_directory() . '/lib/ninja-forms/templates/';
	return $paths;
}

/*
* Media
*/

// Add custom image sizes
add_theme_support( 'post-thumbnails' );
add_image_size( 'one-quarter-column', 600, 400, FALSE);
add_image_size( 'one-third-column', 800, 533, FALSE );
add_image_size( 'one-half-column', 1300, 750, FALSE);
add_image_size( 'post-tile', 800, 800, TRUE);


// Add images to Gutenberg block editor
add_filter( 'image_size_names_choose', 'wpmudev_custom_image_sizes' );
function wpmudev_custom_image_sizes( $sizes ) {
return array_merge( $sizes, array(
'one-quarter-column' => __( 'One-Quarter Column Image' ),
'one-third-column' => __( 'One-Third Column Image' ),
'one-half-column' => __( 'One-Half Column Image' ),
'post-tile' => __( 'Post Tile Image' ),
) );
}


/*
* Admin
*/

//* Add body class to admin
add_filter( 'admin_body_class', 'my_admin_body_class' );
function my_admin_body_class( $classes ) {
	return "4alldigital";
}

// Remove portfolio content type
remove_action( 'init', 'kadence_toolkit_portfolio_post_init', 1 );


// Display reusable blocks menu
function be_reusable_blocks_admin_menu() {
    add_menu_page( 'Reusable Blocks', 'Reusable Blocks', 'edit_posts', 'edit.php?post_type=wp_block', '', 'dashicons-editor-table', 22 );
}
add_action( 'admin_menu', 'be_reusable_blocks_admin_menu' );
