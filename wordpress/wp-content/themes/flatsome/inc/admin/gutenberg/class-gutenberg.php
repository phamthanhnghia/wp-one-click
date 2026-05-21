<?php
/**
 * Block editor (Gutenberg)
 *
 * @author     UX Themes
 * @category   Gutenberg
 * @package    Flatsome\Admin
 * @since      3.7.0
 */

namespace Flatsome\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Class Gutenberg
 *
 * @package Flatsome\Admin
 */
class Gutenberg {

	/**
	 * Current version
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Holds assets directory.
	 *
	 * @var string
	 */
	private $assets;

	/**
	 * Gutenberg constructor.
	 */
	public function __construct() {
		$theme = wp_get_theme( get_template() );

		$this->version = $theme->get( 'Version' );
		$this->assets  = get_template_directory_uri() . '/inc/admin/gutenberg/assets';

		$this->init();
	}

	/**
	 * Initialise
	 */
	private function init() {
		if ( $this->is_block_editor_available() ) {
			add_action( 'enqueue_block_assets', [ $this, 'enqueue_block_assets' ] );
			add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_styles' ] );
			add_action( 'enqueue_block_editor_assets', [ $this, 'add_edit_button' ], 11 );
			add_action( 'enqueue_block_editor_assets', [ $this, 'add_block_settings' ] );
			add_action( 'enqueue_block_editor_assets', [ $this, 'add_page_layout' ] );
		}
	}

	/**
	 * Check if block editor is available.
	 *
	 * @return bool
	 */
	private function is_block_editor_available() {
		return function_exists( 'register_block_type' );
	}

	/**
	 * Whether a post type should display the Gutenberg/block editor.
	 *
	 * @param string $post_type The name of the post type.
	 *
	 * @return bool
	 */
	private function is_post_type_gutenberg( $post_type ) {
		if ( function_exists( 'use_block_editor_for_post_type' ) ) {
			// WP 5.0 or greater.
			return use_block_editor_for_post_type( $post_type );
		} elseif ( function_exists( 'gutenberg_can_edit_post_type' ) ) {
			// Lower then WP 5.0 and Gutenberg plugin is installed.
			return gutenberg_can_edit_post_type( $post_type );
		}
		return false;
	}

	/**
	 * Register and enqueue main styles.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'flatsome-gutenberg', $this->assets . '/css/style.css', [], $this->version );
	}

	/**
	 * Enqueues block assets for both frontend + backend.
	 */
	public function enqueue_block_assets() {
		if ( is_admin() ) {
			wp_enqueue_style( 'wp-editor-classic-layout-styles' );
		}
	}

	/**
	 * Add 'Edit with UX Builder' inside gutenberg editor header.
	 */
	public function add_edit_button() {
		global $typenow;
		if ( ! $this->is_post_type_gutenberg( $typenow ) ) {
			return;
		}
		wp_enqueue_script( 'flatsome-gutenberg-edit-button', $this->assets . '/js/edit-button.js', array( 'wp-edit-post', 'wp-dom-ready' ), $this->version, true );

		$page_id = get_the_ID();

		$params = [
			'edit_button' => [
				'enabled' => $this->is_edit_button_visible( $page_id ),
				'text'    => __( 'Edit with UX Builder', 'flatsome' ),
				'url'     => ux_builder_edit_url( $page_id ),
			],
		];

		wp_localize_script( 'flatsome-gutenberg-edit-button', 'flatsome_gutenberg', $params );
	}

	/**
	 * Generates the `window.flatsomeBlockSettings` object.
	 */
	public function add_block_settings() {
		$blocks_js      = $this->assets . '/js/blocks.js';
		$blocks_deps    = array(
			'wp-data',
			'wp-blocks',
			'wp-element',
			'wp-edit-post',
			'wp-components',
			'wp-block-editor',
		);
		wp_enqueue_script( 'flatsome-gutenberg-blocks', $blocks_js, $blocks_deps, $this->version, true );
	}

	public function add_page_layout() {
		if ( ! flatsome_wp_version_check( '6.3' ) ) {
			return; // We register meta boxes for WordPress 6.2 and below.
		}
		$script = $this->assets . '/js/page-layout.js';
		$deps   = array(
			'wp-data',
			'wp-editor',
			'wp-plugins',
			'wp-element',
			'wp-edit-post',
			'wp-components',
			'wp-dom-ready',
		);
		wp_enqueue_script( 'flatsome-gutenberg-post-layout', $script, $deps, $this->version, true );
	}

	/**
	 * Determines when the edit button should be visible or not.
	 *
	 * @param int $page_id The ID of the current post.
	 *
	 * @return bool
	 */
	private function is_edit_button_visible( $page_id ) {
		// Do not show UX Builder link on Shop page.
		if ( function_exists( 'is_woocommerce' ) && $page_id == wc_get_page_id( 'shop' ) ) {
			return false;
		}

		// Do not show UX Builder link on Posts Page.
		$page_for_posts = get_option( 'page_for_posts' );
		if ( $page_id == $page_for_posts ) {
			return false;
		}

		return true;
	}
}

new Gutenberg();
