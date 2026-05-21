<?php
/**
 * Handles flatsome option upgrades
 *
 * @author     UX Themes
 * @category   Class
 * @package    Flatsome/Classes
 * @since      3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Flatsome_Upgrade
 */
class Flatsome_Upgrade {

	/**
	 * Holds flatsome DB version
	 *
	 * @var string
	 */
	private $db_version;

	/**
	 * Holds flatsome current running parent theme version
	 *
	 * @var string
	 */
	private $running_version;

	/**
	 * Holds update callback that need to be run per version
	 *
	 * @var array
	 */
	private $updates = array(
		'3.4.0'  => array(
			'update_340',
		),
		'3.6.0'  => array(
			'update_360',
		),
		'3.9.0'  => array(
			'update_390',
		),
		'3.12.1' => array(
			'update_3121',
		),
		'3.15.0' => array(
			'update_3150',
		),
		'3.16.0' => array(
			'update_3160',
		),
		'3.17.0' => array(
			'update_3170',
		),
		'3.18.0' => array(
			'update_3180',
		),
		'3.18.5' => array(
			'update_3185',
		),
		'3.19.0' => array(
			'update_3190',
		),
		'3.20.0' => array(
			'update_3200',
		),
	);

	/**
	 * Flatsome_Upgrade Class constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'check_version' ), 5, 0 );
	}

	/**
	 * Check Flatsome version and run the updater if required.
	 */
	public function check_version() {
		$this->db_version      = get_theme_mod( 'flatsome_db_version', '3.0.0' );
		$this->running_version = flatsome()->version();

		// If current version is new.
		if ( version_compare( $this->db_version, $this->running_version, '<' ) ) {
			$this->update();
			Flatsome_Cache::clear( [ 'third_party' => true ] );
		}
	}

	/**
	 * Push all needed updates
	 */
	private function update() {
		if ( version_compare( $this->db_version, $this->highest_update_version(), '<' ) ) {
			try {
				foreach ( $this->updates as $version => $update_callbacks ) {
					if ( version_compare( $this->db_version, $version, '<' ) ) {

						// Run all callbacks.
						foreach ( $update_callbacks as $update_callback ) {
							if ( method_exists( $this, $update_callback ) ) {
								$this->$update_callback();
							} elseif ( function_exists( $update_callback ) ) {
								$update_callback();
							}
						}
					}
				}

				$this->update_db_version();
			} catch ( Exception $e ) {
				error_log( $e->getMessage() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions
			}
		} else {
			$this->update_db_version();
		}
	}

	/**
	 * Retrieve the version number of the highest update available.
	 *
	 * @return string Version number
	 */
	private function highest_update_version() {
		return array_reduce( array_keys( $this->updates ), function ( $highest, $current ) {
			return version_compare( $highest, $current, '>' ) ? $highest : $current;
		}, '1.0.0' );
	}

	/**
	 * Performs upgrades to Flatsome 3.4.0
	 */
	private function update_340() {
		$portfolio_archive_filter = get_theme_mod( 'portfolio_archive_filter' );
		if ( empty( $portfolio_archive_filter ) ) {
			set_theme_mod( 'portfolio_archive_filter', 'left' );
		}
	}

	/**
	 * Performs upgrades to Flatsome 3.6.0
	 */
	private function update_360() {
		// Set cart layout as checkout layout if its set.
		if ( get_theme_mod( 'checkout_layout' ) ) {
			set_theme_mod( 'cart_layout', get_theme_mod( 'checkout_layout' ) );
		}

		// Fixes old headlines.
		$fonts = array(
			'type_headings' => array(
				'font-family' => 'Lato',
				'variant'     => '700',
			),
			'type_texts'    => array(
				'font-family' => 'Lato',
				'variant'     => '400',
			),
			'type_nav'      => array(
				'font-family' => 'Lato',
				'variant'     => '700',
			),
			'type_alt'      => array(
				'font-family' => 'Dancing Script',
				'variant'     => '400',
			),
		);

		// Reset font to default if it contains an empty array.
		foreach ( $fonts as $font => $default ) {
			$setting = get_theme_mod( $font );
			if ( ! $setting ) {
				set_theme_mod( $font, $default );
			}
		}
	}

	/**
	 * Performs upgrades to Flatsome 3.9.0
	 */
	private function update_390() {
		remove_theme_mod( 'follow_google' );
		remove_theme_mod( 'lazy_load_google_fonts' );
		remove_theme_mod( 'lazy_load_icons' );

		set_theme_mod( 'pages_template', 'default' );
	}

	/**
	 * Performs upgrades to Flatsome 3.12.1
	 */
	private function update_3121() {
		// Change 404_block setting value from post_name to ID if one is chosen.
		$block = get_theme_mod( '404_block' );
		if ( ! empty( $block ) && ! is_numeric( $block ) ) {
			$blocks = flatsome_get_post_type_items( 'blocks' );
			if ( $blocks ) {
				foreach ( $blocks as $block_post ) {
					if ( $block_post->post_name == $block ) {
						set_theme_mod( '404_block', $block_post->ID );
						break;
					}
				}
			}
		}

		// Set mod to empty string if value is 0.
		if ( 0 == get_theme_mod( 'site_loader' ) ) {
			set_theme_mod( 'site_loader', '' );
		}
	}

	/**
	 * Performs upgrades to Flatsome 3.15.0
	 */
	private function update_3150() {
		foreach ( array( 'site_logo', 'site_logo_dark', 'site_logo_sticky' ) as $name ) {
			$value = get_theme_mod( $name );

			if ( empty( $value ) ) continue;
			if ( is_numeric( $value ) ) continue;

			if ( $post_id = attachment_url_to_postid( $value ) ) {
				set_theme_mod( $name, $post_id );
			}
		}
	}

	/**
	 * Performs upgrades to Flatsome 3.16.0
	 */
	private function update_3160() {
		// Mirror vertical menu opener width.
		if ( get_theme_mod( 'header_nav_vertical_width', '250' ) != 250 ) {
			set_theme_mod( 'header_nav_vertical_fly_out_width', get_theme_mod( 'header_nav_vertical_width' ) );
		}

		// Change variant 400 to 'regular'.
		foreach ( array( 'type_headings', 'type_texts', 'type_nav', 'type_alt' ) as $font_type ) {
			$setting = get_theme_mod( $font_type );

			if ( $setting && isset( $setting['variant'] ) && $setting['variant'] == '400' ) {
				$setting['variant'] = 'regular';
				set_theme_mod( $font_type, $setting );
			}
		}
	}

	/**
	 * Performs upgrades to Flatsome 3.17.0
	 */
	private function update_3170() {
		// Iterate sticky sidebar options and set their mode to 'javascript' if enabled before the upgrade.
		foreach ( array( 'blog_sticky_sidebar', 'category_sticky_sidebar', 'cart_sticky_sidebar', 'checkout_sticky_sidebar' ) as $name ) {
			if ( empty( get_theme_mod( $name ) ) ) continue;
			set_theme_mod( $name . '_mode', 'javascript' );
		}
	}

	/**
	 * Performs upgrades to Flatsome 3.18.0
	 */
	private function update_3180() {
		if ( get_theme_mod( 'flatsome_infinite_scroll', 0 ) ) {
			set_theme_mod( 'shop_pagination', 'infinite-scroll' );
		}
		remove_theme_mod( 'flatsome_infinite_scroll' );
	}

	/**
	 * Performs upgrades to Flatsome 3.18.5
	 */
	private function update_3185() {
		// Clear typography cache.
		try {
			$fonts_dir = flatsome_get_fonts_dir();

			delete_transient( 'kirki_remote_url_contents' );
			delete_option( 'kirki_downloaded_font_files' );

			global $wp_filesystem;
			if ( ! $wp_filesystem ) {
				if ( ! function_exists( 'WP_Filesystem' ) ) {
					require_once wp_normalize_path( ABSPATH . '/wp-admin/includes/file.php' );
				}
				WP_Filesystem();
			}

			if ( $wp_filesystem instanceof WP_FileSystem_Base && $wp_filesystem->exists( $fonts_dir ) ) {
				foreach ( $wp_filesystem->dirlist( $fonts_dir ) as $file ) {
					if ( $wp_filesystem->is_dir( $fonts_dir . '/' . $file['name'] ) ) {
						$wp_filesystem->rmdir( $fonts_dir . '/' . $file['name'], true );
					}
				}
			}
		} catch ( Exception $e ) {
			error_log( $e->getMessage() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions
		}
	}

	/**
	 * Performs upgrades to Flatsome 3.19.0
	 */
	private function update_3190() {
		// Convert custom cart icon URL to attachment ID.
		$name  = 'custom_cart_icon';
		$value = get_theme_mod( $name );

		if ( ! empty( $value ) && ! is_numeric( $value ) ) {
			if ( $post_id = attachment_url_to_postid( $value ) ) {
				set_theme_mod( $name, $post_id );
			}
		}

		// Remove lazy load background setting.
		remove_theme_mod( 'lazy_load_backgrounds' );

		// If swatch color selected setting matches color secondary it likely has the
		// previous default value, reset it so it will use custom secondary color if set.
		if ( get_theme_mod( 'swatches_color_selected' ) === Flatsome_Default::COLOR_SECONDARY ) {
			set_theme_mod( 'swatches_color_selected', '' );
		}
		if ( get_theme_mod( 'swatches_box_color_selected' ) === Flatsome_Default::COLOR_SECONDARY ) {
			set_theme_mod( 'swatches_box_color_selected', '' );
		}
	}

	/**
	 * Performs upgrades to Flatsome 3.20.0
	 */
	private function update_3200() {
		// Replace old lightbox multi gallery option with separate lightbox galleries options.
		if ( get_theme_mod( 'flatsome_lightbox_multi_gallery', 0 ) ) {
			set_theme_mod( 'flatsome_separate_lightbox_galleries', [ 'gallery' ] );
			remove_theme_mod( 'flatsome_lightbox_multi_gallery' );
		}
	}

	/**
	 * Set the DB version to the current running version.
	 * Should only be called when all upgrades are performed.
	 */
	private function update_db_version() {
		set_theme_mod( 'flatsome_db_version', $this->running_version );
	}
}

if ( ! wp_doing_ajax() ) {
	new Flatsome_Upgrade();
}
