<?php
/**
 * Brands class.
 *
 * @package Flatsome\WooCommerce
 */

namespace Flatsome\WooCommerce;

defined( 'ABSPATH' ) || exit;

/**
 * Class Brands
 *
 * @package Flatsome\WooCommerce
 */
final class Brands {

	/**
	 * The single instance of the class.
	 *
	 * @var Brands
	 */
	protected static $instance = null;

	/**
	 * Constructor.
	 */
	private function __construct() {
		if ( ! empty( $GLOBALS['WC_Brands'] ) ) {
			// Remove the default brand meta from the single product meta.
			remove_action( 'woocommerce_product_meta_end', [ $GLOBALS['WC_Brands'], 'show_brand' ] );
			add_action( 'woocommerce_product_meta_end', [ $this, 'render_brand_meta' ], 50 );
		}
	}

	/**
	 * Render the brand meta list.
	 *
	 * Unwrapped is_singular( 'product' ) check from WC_Brands show_brand().
	 *
	 * @see WC_Brands show_brand()
	 */
	public function render_brand_meta() {
		global $post;

		$terms       = get_the_terms( $post->ID, 'product_brand' );
		$brand_count = is_array( $terms ) ? count( $terms ) : 0;
		$taxonomy    = get_taxonomy( 'product_brand' );

		if (
			empty( $terms )
			|| ! is_array( $terms )
			|| is_wp_error( $terms )
			|| ! $taxonomy instanceof \WP_Taxonomy
			|| ! function_exists( 'wc_get_brands' )
		) {
			return;
		}

		$labels = $taxonomy->labels;

		/* translators: %s - Label name */
		$brand_output = wc_get_brands( $post->ID, ', ', ' <span class="posted_in">' . sprintf( _n( '%s: ', '%s: ', $brand_count, 'woocommerce' ), $labels->singular_name, $labels->name ), '</span>' );

		/**
		 * Filter the brand output in product meta.
		 *
		 * @since 9.8.0
		 *
		 * @param string $brand_output The HTML output for brands.
		 * @param array  $terms        Array of brand term objects.
		 * @param int    $post_id      The product ID.
		 */
		echo apply_filters( 'woocommerce_product_brands_output', $brand_output, $terms, $post->ID ); // phpcs:ignore WordPress.Security.EscapeOutput
	}

	/**
	 * Get the instance of the class.
	 *
	 * @return Brands
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
