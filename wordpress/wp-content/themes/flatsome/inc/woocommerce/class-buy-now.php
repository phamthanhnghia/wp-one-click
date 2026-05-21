<?php
/**
 * Buy Now class.
 *
 * @package Flatsome\WooCommerce
 */

namespace Flatsome\WooCommerce;

defined( 'ABSPATH' ) || exit;

/**
 * Class BuyNow
 *
 * @package Flatsome\WooCommerce
 */
final class BuyNow {

	/**
	 * The single instance of the class.
	 *
	 * @var BuyNow
	 */
	protected static $instance = null;

	/**
	 * BuyNow constructor.
	 */
	private function __construct() {
		add_action( 'init', [ $this, 'init' ] );
		// Direct hooks (customizer refresh).
		add_action( 'woocommerce_after_add_to_cart_button', [ $this, 'render_buy_now_button' ], 1 );
	}

	/**
	 * Main instance.
	 *
	 * @return BuyNow
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
		if ( ! get_theme_mod( 'product_buy_now' ) ) {
			return;
		}

		add_action( 'wp_loaded', [ $this, 'add_to_cart_action' ], 19 );

		add_filter( 'woocommerce_add_to_cart_redirect', [ $this, 'buy_now_redirect' ], 99 );
		add_filter( 'flatsome_show_buy_now_button', [ $this, 'show_buy_now_button' ], 10, 2 );
	}

	/**
	 * Buy now button html.
	 */
	public function render_buy_now_button() {
		if ( ! get_theme_mod( 'product_buy_now' ) || ! is_singular( 'product' ) ) {
			return;
		}

		global $product;
		$product = wc_get_product( get_the_ID() );

		if ( ! $product ) {
			return;
		}

		if ( ! apply_filters( 'flatsome_show_buy_now_button', true, $product ) ) {
			return;
		}

		$button_atts = [
			'type'  => 'submit',
			'name'  => 'ux-buy-now',
			'value' => esc_attr( get_the_ID() ),
			'class' => [
				'ux-buy-now-button',
				'button',
				'primary',
				'ml-half',
			],
		];

		if ( $wc_wp_theme_element_class = wc_wp_theme_get_element_class_name( 'button' ) ) {
			$button_atts['class'][] = $wc_wp_theme_element_class;
		}
		?>
		<button <?php echo flatsome_html_atts( $button_atts ); ?>>
			<?php esc_html_e( 'Buy now', 'flatsome' ); ?>
		</button>
		<?php
	}

	/**
	 * Determines whether to show the "Buy Now" button for a product.
	 *
	 * @param bool        $show    Whether to show the "Buy Now" button.
	 * @param \WC_Product $product The product object.
	 *
	 * @return bool Whether to show the "Buy Now" button.
	 */
	public function show_buy_now_button( $show, $product ) {
		if ( $product->is_type( 'external' ) ) {
			return false;
		}

		return $show;
	}

	/**
	 * Checks if the current request is a Buy Now request.
	 *
	 * @return bool True if it is a Buy Now request, false otherwise.
	 */
	private function is_buy_now_request() {
		return isset( $_REQUEST['ux-buy-now'] ) && is_numeric( wp_unslash( $_REQUEST['ux-buy-now'] ) ); // phpcs:ignore
	}

	/**
	 * Buy now action.
	 *
	 * @return void
	 */
	public function add_to_cart_action() {
		if ( ! $this->is_buy_now_request() ) {
			return;
		}

		if ( isset( $_REQUEST['variation_id'] ) && ! $_REQUEST['variation_id'] ) { // phpcs:ignore
			return;
		}

		if ( isset( $_REQUEST['quantity'] ) && is_array( $_REQUEST['quantity'] ) ) {  // phpcs:ignore
			foreach ( $_REQUEST['quantity'] as $quantity ) {  // phpcs:ignore
				if ( ! $quantity ) {
					return;
				}
			}
		}

		if ( ! isset( $_REQUEST['add-to-cart'] ) || $_REQUEST['add-to-cart'] !== $_REQUEST['ux-buy-now'] ) { // phpcs:ignore
			$_REQUEST['add-to-cart'] = $_REQUEST['ux-buy-now']; // phpcs:ignore
		}
	}

	/**
	 * Redirect user after quick buy button is submitted.
	 *
	 * @param string $url Url.
	 *
	 * @return string
	 */
	public function buy_now_redirect( $url ) {
		if ( ! $this->is_buy_now_request() ) {
			return $url;
		}

		$redirect = $this->get_redirect_url();

		if ( ! $redirect['url'] ) {
			return $url;
		}

		return $redirect['url'];
	}

	/**
	 * Get redirect url.
	 *
	 * @return array
	 */
	private function get_redirect_url() {
		$url      = [ 'url' => '' ];
		$redirect = get_theme_mod( 'product_buy_now_redirect', 'checkout' );

		switch ( $redirect ) {
			case 'cart':
				$url = [
					'type' => 'internal',
					'url'  => wc_get_cart_url(),
				];
				break;
			case 'checkout':
				$url = [
					'type' => 'internal',
					'url'  => wc_get_checkout_url(),
				];
				break;
		}

		return $url;
	}
}
