<?php
/**
 * Flatsome Conditional Functions
 *
 * @author   UX Themes
 * @package  Flatsome/Functions
 */

/**
 * Checks whether a feature is enabled.
 *
 * @param string $name The feature name.
 */
function flatsome_is_feature_enabled( $name ) {
	$features = get_option( 'flatsome_features', [] );
	return ! empty( $features[ $name ] );
}

if ( ! function_exists( 'is_nextend_facebook_login' ) ) {
	/**
	 * Returns true if Nextend facebook provider is enabled for v3
	 *
	 * @return bool
	 */
	function is_nextend_facebook_login() {
		if ( class_exists( 'NextendSocialLogin', false ) && ! class_exists( 'NextendSocialLoginPRO', false ) ) {
			return NextendSocialLogin::isProviderEnabled( 'facebook' );
		}
		return false;
	}
}

if ( ! function_exists( 'is_nextend_google_login' ) ) {
	/**
	 * Returns true if Nextend google provider is enabled for v3
	 *
	 * @return bool
	 */
	function is_nextend_google_login() {
		if ( class_exists( 'NextendSocialLogin', false ) && ! class_exists( 'NextendSocialLoginPRO', false ) ) {
			return NextendSocialLogin::isProviderEnabled( 'google' );
		}
		return false;
	}
}

if ( ! function_exists( 'is_yith_wishlist_premium' ) ) {
	/**
	 * Returns true if YITH Wishlist Premium is installed and free version is not activated.
	 *
	 * @return bool
	 */
	function is_yith_wishlist_premium() {
		return ! defined( 'YITH_WCWL_FREE_INIT' ) && file_exists( WP_PLUGIN_DIR . '/yith-woocommerce-wishlist-premium/init.php' );
	}
}

if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	/**
	 * Returns true if WooCommerce plugin is activated
	 *
	 * @return bool
	 */
	function is_woocommerce_activated() {
		return class_exists( 'woocommerce' );
	}
}

if ( ! function_exists( 'is_portfolio_activated' ) ) {
	/**
	 * Returns "1" if Flatsome Portfolio option is enabled
	 *
	 * @return string
	 */
	function is_portfolio_activated() {
		return get_theme_mod( 'fl_portfolio', 1 );
	}
}

if ( ! function_exists( 'is_extension_activated' ) ) {
	/**
	 * Returns true if extension is activated
	 *
	 * @param string $extension The class name. The name is matched in a case-insensitive manner.
	 * @param bool   $autoload  Whether or not to call __autoload by default.
	 *
	 * @return bool
	 */
	function is_extension_activated( $extension, $autoload = true ) {
		return class_exists( $extension, $autoload );
	}
}

/**
 * Checks if the current request is a login request from WooCommerce.
 *
 * @return bool Returns true if all login-related POST parameters are set, false otherwise.
 */
function flatsome_is_login_request() {
	return isset( $_POST['login'], $_POST['username'], $_POST['password'] ); // phpcs:ignore WordPress.Security.NonceVerification
}

/**
 * Checks if the current request is a register request from WooCommerce.
 *
 * @return bool Returns true if all register-related POST parameters are set, false otherwise.
 */
function flatsome_is_register_request() {
	return isset( $_POST['register'], $_POST['email'] ) && ( isset( $_POST['password'] ) || 'yes' === get_option( 'woocommerce_registration_generate_password' ) ); // phpcs:ignore WordPress.Security.NonceVerification
}

/**
 * Checks if current page is a blog archive.
 *
 * @return bool
 */
function flatsome_is_blog_archive() {
	return apply_filters( 'flatsome_is_blog_archive', is_home() || is_search() || is_tag() || is_category() || is_date() || is_author() );
}

/**
 * Checks if current page is a WooCommerce shop archive.
 *
 * @return bool
 */
function flatsome_is_shop_archive() {
	$queried_object               = get_queried_object();
	$taxonomy                     = ( $queried_object && property_exists( $queried_object, 'taxonomy' ) ) ? $queried_object->taxonomy : false;
	$additional_taxonomy_archives = [
		'product_brand', // Included in WooCommerce core from 9.4
		'berocket_brand',
		'product_brands',
		'pwb-brand',
		'yith_product_brand',
	];

	$is_product_search_archive      = is_search() && is_post_type_archive( 'product' );
	$is_product_attribute_archive   = $taxonomy && taxonomy_is_product_attribute( $taxonomy );
	$is_additional_taxonomy_archive = $taxonomy && in_array( $taxonomy, $additional_taxonomy_archives, true );

	return apply_filters(
		'flatsome_is_shop_archive',
		is_shop() || is_product_category() || is_product_tag() || $is_product_search_archive || $is_product_attribute_archive || $is_additional_taxonomy_archive
	);
}
