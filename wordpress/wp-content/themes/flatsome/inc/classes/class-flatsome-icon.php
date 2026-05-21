<?php
/**
 * Icon handling.
 *
 * @package Flatsome
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Flatsome_Icon
 */
final class Flatsome_Icon {

	/**
	 * Get a payment icon using get_template_part.
	 *
	 * @param string $icon_name The name of the payment icon.
	 * @param array  $args      Optional arguments for the icon.
	 *
	 * @return string The payment icon HTML.
	 */
	public static function get_payment_icon( $icon_name, $args = [] ) {
		$defaults = [
			'attributes' => [
				'aria-hidden' => 'true',
			],
		];

		$args = wp_parse_args( $args, $defaults );

		ob_start();
		get_template_part( 'assets/img/payment-icons/icon', $icon_name . '.svg' );
		$svg = ob_get_clean();

		if ( empty( $svg ) ) {
			return '';
		}

		$p = new WP_HTML_Tag_Processor( $svg );

		if ( $p->next_tag( 'svg' ) && ! empty( $args['attributes'] ) ) {
			foreach ( $args['attributes'] as $attribute => $value ) {
				if ( $attribute === 'class' ) {
					$existing_class = $p->get_attribute( 'class' );
					$classes        = ! empty( $existing_class )
						? $existing_class . ' ' . $value
						: $value;
					$p->set_attribute( 'class', $classes );
				} else {
					$p->set_attribute( $attribute, $value );
				}
			}
		}

		return $p->get_updated_html();
	}
}
