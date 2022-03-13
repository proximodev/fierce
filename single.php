<?php
/**
 * This file adds the Single Post Template to any Genesis child theme.
 *
 * @author Brad Dalton
 * @link https://wpsites.net/web-design/basic-single-post-template-file-for-genesis-beginners/
 */
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );

//* Add custom body class to the head
add_filter( 'body_class', 'single_posts_body_class' );
function single_posts_body_class( $classes ) {

   $classes[] = 'blog-single';
   return $classes;

}

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove sidebar
remove_action( 'genesis_site_layout', '__genesis_return_content_sidebar' );
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

//* Run the Genesis loop
genesis();