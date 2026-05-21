<?php
/**
 * Catalog mode.
 *
 * @package Flatsome
 */

/**
 * Add body classes.
 *
 * @param array $classes Classes.
 *
 * @return array
 */
function flatsome_body_classes_catalog_mode( $classes ) {
	if ( get_theme_mod( 'catalog_mode' ) ) $classes[]        = 'catalog-mode';
	if ( get_theme_mod( 'catalog_mode_prices' ) ) $classes[] = 'no-prices';

	return $classes;
}

add_filter( 'body_class', 'flatsome_body_classes_catalog_mode' );

/**
 * Handle single product summary.
 *
 * @return void
 */
function flatsome_catalog_mode_product() {
	if ( get_theme_mod( 'catalog_mode_product' ) ) {
		echo '<div class="catalog-product-text pb relative">';
		echo do_shortcode( get_theme_mod( 'catalog_mode_product' ) );
		echo '</div>';
	}
	echo '<style>.woocommerce-variation-availability{display:none!important}</style>';
}

add_action( 'woocommerce_single_product_summary', 'flatsome_catalog_mode_product', 30 );

/**
 * Handle single product lightbox.
 *
 * @return void
 */
function flatsome_catalog_mode_lightbox() {
	if ( get_theme_mod( 'catalog_mode_lightbox' ) ) {
		echo '<div class="catalog-product-text pb relative">';
		echo do_shortcode( get_theme_mod( 'catalog_mode_lightbox' ) );
		echo '</div>';
	}
	echo '<style>.woocommerce-variation-availability{display:none!important}</style>';
}

add_action( 'flatsome_single_product_lightbox_summary', 'flatsome_catalog_mode_lightbox', 30 );

/**
 * Disable purchasing of products.
 *
 * @param bool       $is_purchasable Purchasable.
 * @param WC_Product $product        Product.
 *
 * @return false
 */
function flatsome_woocommerce_is_purchasable( $is_purchasable, $product ) {
	return false;
}

add_filter( 'woocommerce_is_purchasable', 'flatsome_woocommerce_is_purchasable', 10, 2 );

/**
 * Unregisters the WooCommerce Price Filter widget.
 *
 * @return void
 */
function flatsome_catalog_mode_unregister_price_filter() {
	if ( ! get_theme_mod( 'catalog_mode_prices' ) ) {
		return;
	}
	unregister_widget( 'WC_Widget_Price_Filter' );
}

add_action( 'widgets_init', 'flatsome_catalog_mode_unregister_price_filter', 20 );

/**
 * Removes the 'Sort by price' options from the WooCommerce product ordering dropdown.
 *
 * @param array $orderby_options An array of sorting options.
 *
 * @return array Modified sorting options.
 */
function flatsome_catalog_mode_woocommerce_catalog_orderby( $orderby_options ) {
	if ( ! get_theme_mod( 'catalog_mode_prices' ) ) {
		return $orderby_options;
	}

	unset( $orderby_options['price'] );
	unset( $orderby_options['price-desc'] );

	return $orderby_options;
}

add_filter( 'woocommerce_catalog_orderby', 'flatsome_catalog_mode_woocommerce_catalog_orderby', 20 );


/* Remove variations add to cart */
remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );

/* Remove add to cart quick button */
remove_action( 'flatsome_product_box_actions', 'flatsome_product_box_actions_add_to_cart', 1 );

if ( get_theme_mod( 'catalog_mode_prices' ) ) {
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
	remove_action( 'flatsome_single_product_lightbox_summary', 'woocommerce_template_single_price' );
	add_filter( 'woocommerce_get_price_html', '__return_empty_string' );
}

/* Remove sale badges */
if ( get_theme_mod( 'catalog_mode_sale_badge', 0 ) ) add_filter( 'woocommerce_sale_flash', '__return_empty_string' );
