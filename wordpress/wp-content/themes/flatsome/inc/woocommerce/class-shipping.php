<?php
/**
 * Shipping class.
 *
 * @package Flatsome\WooCommerce
 */

namespace Flatsome\WooCommerce;

defined( 'ABSPATH' ) || exit;

/**
 * Class Shipping
 *
 * @package Flatsome\WooCommerce
 */
final class Shipping {

	/**
	 * The single instance of the class.
	 *
	 * @var Shipping
	 */
	protected static $instance = null;

	/**
	 * Shipping constructor.
	 */
	private function __construct() {
		if ( get_theme_mod( 'catalog_mode' ) ) {
			return;
		}

		add_action( 'wp_loaded', [ $this, 'init' ] );

		add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'fragments' ] );
		add_filter( 'woocommerce_update_order_review_fragments', [ $this, 'fragments' ] );
	}

	/**
	 * Main instance.
	 *
	 * @deprecated in favor of get_instance()
	 * @return Shipping
	 */
	public static function instance() {
		_deprecated_function( __METHOD__, '3.19.0', 'get_instance()' );
		return self::get_instance();
	}

	/**
	 * Main instance.
	 *
	 * @return Shipping
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize.
	 *
	 * @return void
	 */
	public function init() {
		if ( get_theme_mod( 'header_cart_shipping' ) ) {
			add_action( 'flatsome_before_mini_cart_total', array( $this, 'free_shipping' ) );
		}

		if ( get_theme_mod( 'cart_shipping' ) ) {
			add_action( 'woocommerce_before_cart_table', array( $this, 'free_shipping' ) );
		}

		if ( get_theme_mod( 'checkout_shipping' ) ) {
			add_action( 'woocommerce_checkout_order_review', array( $this, 'free_shipping' ) );
		}
	}

	/**
	 * Render free shipping html.
	 *
	 * @return void
	 */
	public function free_shipping() {
		if ( ! WC()->cart->needs_shipping() || ! WC()->cart->show_shipping() ) {
			return;
		}

		$free_shipping_threshold = 0;
		$subtotal                = WC()->cart->get_displayed_subtotal();
		$classes                 = array( 'ux-free-shipping' );
		$free_shipping_by_coupon = false;
		$ignore_discounts        = false;

		// Check shipping packages.
		$packages = WC()->cart->get_shipping_packages();
		$package  = reset( $packages );
		$zone     = wc_get_shipping_zone( $package );

		foreach ( $zone->get_shipping_methods( true ) as $method ) {
			if ( 'free_shipping' === $method->id ) {
				$free_shipping_threshold = $method->get_option( 'min_amount' );

				if ( in_array( $method->get_option( 'requires' ), array( 'min_amount', 'either', 'both' ), true ) ) {
					$ignore_discounts = $method->get_option( 'ignore_discounts' ) === 'yes'; // Apply minimum order rule before coupon discount option.
				}
			}
		}

		// WPML.
		if ( class_exists( 'woocommerce_wpml' ) && ! class_exists( 'WCML_Multi_Currency_Shipping' ) ) {
			global $woocommerce_wpml;

			$multi_currency = $woocommerce_wpml->get_multi_currency();

			if ( ! empty( $multi_currency->prices ) && method_exists( $multi_currency->prices, 'convert_price_amount' ) ) {
				$free_shipping_threshold = $multi_currency->prices->convert_price_amount( $free_shipping_threshold );
			}
		}

		// Check coupons.
		if ( $subtotal && wc_coupons_enabled() ) {
			$coupons = WC()->cart->get_coupons();

			foreach ( $coupons as $coupon ) {
				if ( ! $coupon->is_valid() ) continue;

				if ( $coupon->get_free_shipping() ) {
					$free_shipping_by_coupon = true;
					break;
				}

				$discount_amount = WC()->cart->get_coupon_discount_amount( $coupon->get_code(), WC()->cart->display_cart_ex_tax );

				if ( ! $ignore_discounts && $subtotal >= $discount_amount ) {
					$subtotal -= $discount_amount;
				}
			}
		}

		$free_shipping_threshold = apply_filters( 'flatsome_shipping_free_shipping_threshold', $free_shipping_threshold );

		if ( ! $free_shipping_threshold ) {
			return;
		}

		if ( $subtotal < $free_shipping_threshold && ! $free_shipping_by_coupon ) :
			$percent = floor( ( $subtotal / $free_shipping_threshold ) * 100 );
			?>
			<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
				<div class="ux-free-shipping__notice ux-free-shipping__notice--threshold">
					<?php
					$threshold = wc_price( $free_shipping_threshold - $subtotal );
					printf(
					/* translators: %s: The threshold */
						esc_html__( 'Add %s to cart and get free shipping!', 'flatsome' ),
						$threshold // phpcs:ignore WordPress.Security.EscapeOutput
					);
					?>
				</div>
				<div class="ux-free-shipping__bar ux-free-shipping__bar--striped">
					<span class="ux-free-shipping__bar-progress" style="width:<?php echo $percent; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>%;"></span>
				</div>
			</div>
		<?php else : // Success message. ?>
			<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
				<div class="ux-free-shipping__notice ux-free-shipping__notice--success"><?php esc_html_e( 'Your order qualifies for free shipping 🎉', 'flatsome' ); ?></div>
				<div class="ux-free-shipping__bar ux-free-shipping__bar--striped">
					<span class="ux-free-shipping__bar-progress" style="width:100%;"></span>
				</div>
			</div>
			<?php
		endif;
	}

	/**
	 * Fragments.
	 *
	 * @param array $fragments_array Fragments.
	 *
	 * @return array
	 */
	public function fragments( $fragments_array ) {
		ob_start();
		$this->free_shipping();
		$fragments_array['div.ux-free-shipping'] = ob_get_clean();

		return $fragments_array;
	}
}
