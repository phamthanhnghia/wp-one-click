<?php
/**
 * This class is responsible for extracting images from shortcodes in content.
 *
 * @package Flatsome
 * @since   3.18.3
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Flatsome_Shortcode_Image_Extractor
 */
final class Flatsome_Shortcode_Image_Extractor {
	/**
	 * The single instance of the class.
	 *
	 * @var Flatsome_Shortcode_Image_Extractor
	 */
	protected static $instance = null;

	/**
	 * Array of shortcodes to extract images from.
	 *
	 * @var array
	 */
	private $shortcodes = [];

	/**
	 * Class constructor.
	 */
	private function __construct() {
		// Add default shortcodes.
		$this->add_shortcode( 'block', '' );
		$this->add_shortcode( 'featured_box', 'img' );
		$this->add_shortcode( 'logo', 'img' );
		$this->add_shortcode( 'section', 'bg' );
		$this->add_shortcode( 'team_member', 'img' );
		$this->add_shortcode( 'ux_banner', 'bg' );
		$this->add_shortcode( 'ux_gallery', 'ids' );
		$this->add_shortcode( 'ux_image', 'id' );
		$this->add_shortcode( 'ux_image_box', 'img' );
	}

	/**
	 * Adds a new shortcode to the list of shortcodes to extract from.
	 *
	 * @param string      $tag     The name of the shortcode.
	 * @param string      $source  The source attribute to extract the image attachment URL from.
	 * @param string|null $pattern Optional. The pattern to match the shortcode in the content.
	 *
	 * @throws InvalidArgumentException If params $name or $source is not a not string.
	 */
	public function add_shortcode( $tag, $source, $pattern = null ) {
		if ( ! is_string( $tag ) || ! is_string( $source ) ) {
			throw new InvalidArgumentException( 'Expected shortcode parameters to be strings.' );
		}

		if ( $pattern == null ) {
			$pattern = '/\[' . $tag . '(.+?)?](?:(.+?)?\[\/' . $tag . '])?/';
		}

		$this->shortcodes[ $tag ] = [
			'pattern' => $pattern,
			'source'  => $source,
		];
	}

	/**
	 * Extract images from shortcodes in content.
	 *
	 * @param string $content The content that may contain shortcodes.
	 *
	 * @return array An array of extracted images.
	 * @throws InvalidArgumentException If the content is not a string.
	 */
	public function extract_images( $content ) {
		if ( ! is_string( $content ) ) {
			throw new InvalidArgumentException( 'Expected string content.' );
		}

		$images = [];

		foreach ( $this->shortcodes as $tag => $shortcode_data ) {
			$extracted_images = $tag === 'block'
				? $this->extract_ux_block_images( $shortcode_data, $content )
				: $this->extract_shortcode_images( $shortcode_data, $content );

			$images = array_merge( $images, $extracted_images );
		}

		return $images;
	}

	/**
	 * Extract images from a shortcode.
	 *
	 * @param array  $shortcode_data The shortcode pattern and source attribute.
	 * @param string $content        The content to search for shortcodes.
	 *
	 * @return array An array of extracted images.
	 */
	private function extract_shortcode_images( $shortcode_data, $content ) {
		$images = [];

		if ( preg_match_all( $shortcode_data['pattern'], $content, $matches ) ) {
			$atts_strings = isset( $matches[1] ) ? $matches[1] : [];

			foreach ( $atts_strings as $atts_string ) {
				$atts = shortcode_parse_atts( $atts_string );
				if ( empty( $atts[ $shortcode_data['source'] ] ) ) continue;

				$image_ids = explode( ',', $atts[ $shortcode_data['source'] ] );
				foreach ( $image_ids as $image_id ) {
					$image_url = wp_get_attachment_url( $image_id );
					if ( $image_url ) {
						$images[] = [
							'src'   => $image_url,
							'title' => get_the_title( $image_id ),
							'alt'   => get_post_meta( $image_id, '_wp_attachment_image_alt', true ),
						];
					}
				}
			}
		}

		return $images;
	}

	/**
	 * Extract images from a block shortcode content.
	 *
	 * @param array  $shortcode_data The shortcode pattern and source attribute.
	 * @param string $content        The content that may contain a block shortcode.
	 *
	 * @return array An array of extracted images.
	 */
	private function extract_ux_block_images( $shortcode_data, $content ) {
		$images = [];

		if ( preg_match_all( $shortcode_data['pattern'], $content, $matches ) ) {
			$atts_strings = isset( $matches[1] ) ? $matches[1] : [];

			foreach ( $atts_strings as $atts_string ) {
				$atts = shortcode_parse_atts( $atts_string );
				if ( empty( $atts['id'] ) ) continue;

				$block_id = flatsome_get_block_id( $atts['id'] );
				$block    = $block_id ? get_post( $block_id ) : null;
				if ( $block === null ) continue;

				$block_content = $block->post_content;
				if ( empty( $block_content ) ) continue;

				$block_images = $this->extract_images( $block_content );
				if ( empty( $block_images ) ) continue;

				$images = array_merge( $images, $block_images );
			}
		}

		return $images;
	}

	/**
	 * Main instance.
	 *
	 * @return Flatsome_Shortcode_Image_Extractor
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
