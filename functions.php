<?php
/**
 * Theme Engine Room.
 * This theme uses OOP logic instead of procedural coding.
 * Every function, hook and action is properly organized inside related
 * folders and files.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * This Theme only works in WordPress 5.0 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '5.0', '<' ) ) {
	require get_template_directory() . '/includes/compats/class-mfit-back-compats.php';

	$messages = Mfit_Back_Compats::get_instance();
	$messages->actions();

	return;
}

if ( file_exists( get_parent_theme_file_path( 'includes/class-mfit-autoloader.php' ) ) ) {
	require_once get_parent_theme_file_path( 'includes/class-mfit-autoloader.php' );

	// Initializing Autoloading.
	$mfit_loader = new Mfit_Autoloader();
	$mfit_loader->register();
}

if ( class_exists( 'Mfit_Theme' ) ) {

	// Starting the app.
	$mfit_theme = Mfit_Theme::get_instance();
	$mfit_theme->register_services();
}
