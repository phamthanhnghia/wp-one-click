<?php
/**
 * Flatsome_Registration class.
 *
 * @package Flatsome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The Flatsome registration.
 */
final class Flatsome_WUpdates_Registration extends Flatsome_Base_Registration {

	/**
	 * Setup instance.
	 *
	 * @param UxThemes_API $api The UX Themes API instance.
	 */
	public function __construct( UxThemes_API $api ) {
		parent::__construct( $api, 'flatsome_wupdates' );
	}

	/**
	 * Registers Flatsome.
	 *
	 * @param string $code Purchase code.
	 * @return array|WP_error
	 */
	public function register( $code ) {
		$registration = new Flatsome_Registration( $this->api );
		$result       = $registration->register( $code );

		if ( is_wp_error( $result ) ) {
			return $this->api->get_error( $result, 'wupdates-register' );
		}

		if ( empty( $registration->get_code() ) ) {
			return $result;
		}

		$this->delete_options();

		return $result;
	}

	/**
	 * Unregisters theme.
	 *
	 * @return array|WP_error
	 */
	public function unregister() {
		$this->delete_options();
		return array();
	}

	/**
	 * Get latest Flatsome version.
	 *
	 * @return string|WP_error
	 */
	public function get_latest_version() {
		return new WP_Error( 'not-verified', __( 'Purchase code not verified.', 'flatsome' ) );
	}

	/**
	 * Get a temporary download URL.
	 *
	 * @param string $version Version number to download.
	 * @return string|WP_error
	 */
	public function get_download_url( $version ) {
		return new WP_Error( 'not-verified', __( 'Purchase code not verified.', 'flatsome' ) );
	}

	/**
	 * Checks whether Flatsome is registered or not.
	 *
	 * @return boolean
	 */
	public function is_registered() {
		return $this->get_code() !== '';
	}

	/**
	 * Checks whether the registration has been verified by Envato.
	 *
	 * @return boolean
	 */
	public function is_verified() {
		return false;
	}

	/**
	 * Delete options.
	 */
	public function delete_options() {
		$slug = flatsome_theme_key();

		delete_option( $slug . '_wup_buyer' );
		delete_option( $slug . '_wup_sold_at' );
		delete_option( $slug . '_wup_purchase_code' );
		delete_option( $slug . '_wup_supported_until' );
		delete_option( $slug . '_wup_errors' );
		delete_option( $slug . '_wup_attempts' );

		parent::delete_options();
	}

	/**
	 * Checks whether the purchase code was registered with WPUpdates.
	 *
	 * @return boolean
	 */
	public function get_code() {
		return get_option( flatsome_theme_key() . '_wup_purchase_code', '' );
	}
}
