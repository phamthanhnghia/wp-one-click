<?php
/**
 * Add assets to Customizer
 *
 * @package Flatsome
 */

/**
 * Enqueue custom stylesheets for the Customizer controls.
 */
function flatsome_enqueue_customizer_stylesheet() {
	flatsome_enqueue_asset( 'flatsome-customizer-admin-js', 'admin/customizer-admin' );
	wp_enqueue_style( 'flatsome-header-builder-css', get_template_directory_uri() . '/assets/css/admin/admin-header-builder.css', [], flatsome()->version() );
	wp_enqueue_style( 'flatsome-customizer-admin', get_template_directory_uri() . '/assets/css/admin/admin-customizer.css', [], flatsome()->version() );
}

add_action( 'customize_controls_print_styles', 'flatsome_enqueue_customizer_stylesheet' );

/**
 * Enqueue custom stylesheets and scripts for the Customizer live preview.
 */
function flatsome_customizer_live_preview() {
	flatsome_enqueue_asset( 'flatsome-customizer-frontend-js', 'admin/customizer-frontend' );
	wp_enqueue_style( 'flatsome-customizer-preview', get_template_directory_uri() . '/assets/css/admin/admin-frontend.css', [], flatsome()->version() );
}

add_action( 'customize_preview_init', 'flatsome_customizer_live_preview' );
