<?php
/**
 * Flatsome_Theme_JSON class.
 *
 * @author  UX Themes
 * @package Flatsome
 * @since   3.18.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Flatsome_Theme_JSON
 *
 * @package Flatsome
 */
final class Flatsome_Theme_JSON {

	/**
	 * Initialize.
	 */
	public function init() {
		add_filter( 'wp_theme_json_data_user', [ $this, 'update_data' ] );
	}

	/**
	 * Modifies the `theme.json` values.
	 *
	 * @param WP_Theme_JSON_Data $theme_json Theme JSON data instance.
	 */
	public function update_data( $theme_json ) {
		return $theme_json->update_with(
			array(
				'version'  => 2,
				'settings' => array(
					'color' => array(
						'palette' => array(
							'theme' => $this->get_color_palette(),
						),
					),
				),
			)
		);
	}

	/**
	 * Get color values.
	 */
	private function get_color_palette() {
		return array(
			array(
				'slug'  => 'primary',
				'color' => get_theme_mod( 'color_primary', Flatsome_Default::COLOR_PRIMARY ),
			),
			array(
				'slug'  => 'secondary',
				'color' => get_theme_mod( 'color_secondary', Flatsome_Default::COLOR_SECONDARY ),
			),
			array(
				'slug'  => 'success',
				'color' => get_theme_mod( 'color_success', Flatsome_Default::COLOR_SUCCESS ),
			),
			array(
				'slug'  => 'alert',
				'color' => get_theme_mod( 'color_alert', Flatsome_Default::COLOR_ALERT ),
			),
		);
	}
}
