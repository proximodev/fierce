<?php
/**
 * Digital Pro.
 *
 * This file adds the Theme helper functions to the Digital Pro Theme.
 *
 * @package Digital
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/digital/
 */

/**
 * Get default link color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.1.0
 *
 * @return string Hex color code for accent color.
 */
function digital_customizer_get_default_link_color() {
	return '#e85555';
}

/**
 * Get default accent color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for accent color.
 */
function digital_customizer_get_default_accent_color() {
	return '#e85555';
}

/**
 * Calculate color contrast.
 *
 * @since 1.1.0
 */
function digital_color_contrast( $color ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? '#000000' : '#ffffff';

}

/**
 * Calculate color brightness.
 *
 * @since 1.1.0
 */
function digital_color_brightness( $color, $change ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$red   = max( 0, min( 255, $red + $change ) );
	$green = max( 0, min( 255, $green + $change ) );
	$blue  = max( 0, min( 255, $blue + $change ) );

	return '#'.dechex( $red ).dechex( $green ).dechex( $blue );

}

/**
 * Change color brightness.
 *
 * @since 1.1.0
 */
function digital_change_brightness( $color ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? digital_color_brightness( '#000000', 20 ) : digital_color_brightness( '#ffffff', -50 );

}

add_action( 'enqueue_block_editor_assets', 'load_admin_styles' );
function load_admin_styles() {
	wp_enqueue_style( 'font_awesome', 'https://pro.fontawesome.com/releases/v5.15.2/css/all.css', false, '1.0' );
	wp_enqueue_style( 'fonts', 'https://fonts.googleapis.com/css?family=Open+Sans%3Aital%2Cwght%400%2C300%3B0%2C400%3B0%2C600%3B0%2C700%3B0%2C800%3B1%2C400&display=swap&ver=1.0', false, '1.0' );
	wp_enqueue_style( 'custom_styles', get_stylesheet_directory_uri() . '/style-block-editor.css', false, '1.9' );
}