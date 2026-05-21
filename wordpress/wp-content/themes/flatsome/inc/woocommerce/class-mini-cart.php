<?php
/**
 * Mini cart class.
 *
 * @package Flatsome\WooCommerce
 */

namespace Flatsome\WooCommerce;

defined( 'ABSPATH' ) || exit;

/**
 * Class MiniCart
 *
 * @package Flatsome\WooCommerce
 */
final class MiniCart {

	/**
	 * The single instance of the class.
	 *
	 * @var MiniCart
	 */
	protected static $instance = null;

	/**
	 * MiniCart constructor.
	 */
	private function __construct() {
		add_action( 'flatsome_before_mini_cart_empty_message', [ $this, 'before_empty_message_html' ] );
		add_action( 'flatsome_after_mini_cart_empty_message', [ $this, 'after_empty_message_html' ] );

		add_action( 'wp_ajax_flatsome_ajax_cart_item_alter_quantity', [ $this, 'cart_item_alter_quantity' ] );
		add_action( 'wp_ajax_nopriv_flatsome_ajax_cart_item_alter_quantity', [ $this, 'cart_item_alter_quantity' ] );

		add_filter( 'woocommerce_widget_cart_item_quantity', [ $this, 'quantity_html' ], 11, 3 );
		add_action( 'flatsome_after_mini_cart_contents', [ $this, 'cross_sells' ] );

		add_action( 'flatsome_before_mini_cart_cross_sells', function () {
			add_filter( 'woocommerce_loop_add_to_cart_link', [ $this, 'loop_add_to_cart' ], 5, 3 );
		} );

		add_action( 'flatsome_after_mini_cart_cross_sells', function () {
			remove_filter( 'woocommerce_loop_add_to_cart_link', [ $this, 'loop_add_to_cart' ], 5 );
		} );

		add_action( 'wp_loaded', [ $this, 'refresh_on_customizer_open' ] );
	}

	/**
	 * Main instance.
	 *
	 * @deprecated in favor of get_instance()
	 * @return MiniCart
	 */
	public static function instance() {
		_deprecated_function( __METHOD__, '3.19.0', 'get_instance()' );
		return self::get_instance();
	}

	/**
	 * Main instance.
	 *
	 * @return MiniCart
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Update cart quantity.
	 *
	 * @return void
	 */
	public function cart_item_alter_quantity() {
		$quantity      = ! empty( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
		$cart_item_key = wc_clean( isset( $_POST['cart_item_key'] ) ? wp_unslash( $_POST['cart_item_key'] ) : '' ); // phpcs:ignore WordPress.Security.NonceVerification

		if ( empty( $cart_item_key ) ) {
			wp_send_json_error();
		}

		$cart         = WC()->cart->get_cart();
		$values       = array();
		$cart_updated = false;

		if ( ! empty( $cart[ $cart_item_key ] ) ) {
			$values = $cart[ $cart_item_key ];
		}

		$passed_validation = apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $values, $quantity );

		if ( $passed_validation && $quantity ) {
			WC()->cart->set_quantity( $cart_item_key, $quantity, false );
			$cart_updated = true;
		} elseif ( ! $quantity ) {
			WC()->cart->remove_cart_item( $cart_item_key );
		}

		// Trigger action - let 3rd parties update the cart if they need to and update the $cart_updated variable.
		$cart_updated = apply_filters( 'woocommerce_update_cart_action_cart_updated', $cart_updated );

		if ( $cart_updated ) {
			WC()->cart->calculate_totals();
		}

		wp_send_json( WC()->cart->get_cart_item( $cart_item_key ) );
	}


	/**
	 * Before empty message html.
	 *
	 * @return void
	 */
	public function before_empty_message_html() {
		?>
		<div class="ux-mini-cart-empty-icon">
			<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 19" style="opacity:.1;height:80px;">
				<path d="M8.5 0C6.7 0 5.3 1.2 5.3 2.7v2H2.1c-.3 0-.6.3-.7.7L0 18.2c0 .4.2.8.6.8h15.7c.4 0 .7-.3.7-.7v-.1L15.6 5.4c0-.3-.3-.6-.7-.6h-3.2v-2c0-1.6-1.4-2.8-3.2-2.8zM6.7 2.7c0-.8.8-1.4 1.8-1.4s1.8.6 1.8 1.4v2H6.7v-2zm7.5 3.4 1.3 11.5h-14L2.8 6.1h2.5v1.4c0 .4.3.7.7.7.4 0 .7-.3.7-.7V6.1h3.5v1.4c0 .4.3.7.7.7s.7-.3.7-.7V6.1h2.6z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor"></path>
			</svg>
		</div>
		<?php
	}

	/**
	 * After empty message html.
	 *
	 * @return void
	 */
	public function after_empty_message_html() {
		if ( wc_get_page_id( 'shop' ) > 0 ) :
			?>
			<p class="return-to-shop">
				<a class="button primary wc-backward<?php if ( fl_woocommerce_version_check( '7.0.1' ) ) {
					echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' );
				} ?>" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
					<?php
					/**
					 * Filter "Return To Shop" text.
					 *
					 * @param string $default_text Default text.
					 *
					 * @since 4.6.0
					 */
					echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to shop', 'woocommerce' ) ) );
					?>
				</a>
			</p>
			<?php
		endif;
	}

	/**
	 * Replace normal add to cart button html, to small add button.
	 *
	 * @param string      $link    The link html.
	 * @param \WC_product $product The product object.
	 * @param array       $args    The args.
	 *
	 * @return string The modified link html.
	 */
	public function loop_add_to_cart( $link, $product, $args ) {
		$insert = '<svg aria-hidden="true" width="10" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg"><path d="M11 5H7V1a1 1 0 00-2 0v4H1a1 1 0 000 2h4v4a1 1 0 002 0V7h4a1 1 0 000-2z" fill="currentColor" fill-rule="nonzero"></path></svg>' . esc_html_x( 'Add', 'mini cart add to cart button label', 'flatsome' );

		return preg_replace( '/(<a.*?>).*?(<\/a>)/', '$1' . $insert . '$2', $link );
	}

	/**
	 * Renders the quantity html.
	 *
	 * @param string $markup The markup.
	 * @param array  $cart_item The cart item.
	 * @param string $cart_item_key The cart item key.
	 */
	public function quantity_html( $markup, $cart_item, $cart_item_key ) {
		$header_cart_qty = get_theme_mod( 'header_cart_qty' );
		$product         = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_name    = apply_filters( 'woocommerce_cart_item_name', $product->get_name(), $cart_item, $cart_item_key );
		ob_start();
		?>
		<div class="ux-mini-cart-qty">
			<?php
			if ( $header_cart_qty && $product->is_purchasable() && apply_filters( 'flatsome_show_mini_cart_item_quantity', true, $cart_item_key ) ) {
				if ( $product->is_sold_individually() ) {
					$min_quantity = 1;
					$max_quantity = 1;
				} else {
					$min_quantity = 0;
					$max_quantity = $product->get_max_purchase_quantity();
				}

				$product_quantity = woocommerce_quantity_input(
					array(
						'input_name'   => "cart[{$cart_item_key}][qty]",
						'input_value'  => $cart_item['quantity'],
						'min_value'    => $min_quantity,
						'max_value'    => $max_quantity,
						'product_name' => $product_name,
					),
					$product,
					false
				);

				echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput
			}

			if ( $header_cart_qty ) {
				?>
				<span class="product-subtotal price-wrapper" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
					<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</span>
				<?php
			} else {
				echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput
			}
			?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Mini cart cross sells template.
	 */
	public function cross_sells() {
		if ( ! get_theme_mod( 'header_cart_cross_sells' ) ) {
			return;
		}

		$cross_sells = array_filter( array_map( 'wc_get_product', WC()->cart->get_cross_sells() ), 'wc_products_array_filter_visible' );
		$cross_sells = array_filter( array_map( function ( $product ) {
			if ( ! $product->is_in_stock() ) return false;

			return $product;
		}, $cross_sells ) );

		$cross_sells_orderby = apply_filters( 'woocommerce_cross_sells_orderby', 'date' );
		$cross_sells_orderby = apply_filters( 'flatsome_mini_cart_cross_sells_orderby', $cross_sells_orderby );
		$cross_sells_order   = apply_filters( 'woocommerce_cross_sells_order', 'desc' );
		$cross_sells_order   = apply_filters( 'flatsome_mini_cart_cross_sells_order', $cross_sells_order );
		$cross_sells         = wc_products_array_orderby( $cross_sells, $cross_sells_orderby, $cross_sells_order );

		$limit       = intval( apply_filters( 'flatsome_mini_cart_cross_sells_total', 5 ) );
		$cross_sells = $limit > 0 ? array_slice( $cross_sells, 0, $limit ) : $cross_sells;

		wc_get_template( 'cart/mini-cart/cross-sells.php', array( 'cross_sells' => $cross_sells ) );
	}

	/**
	 * Refresh mini cart on customizer open.
	 *
	 * @return void
	 */
	public function refresh_on_customizer_open() {
		if ( is_customize_preview() ) {
			do_action( 'wc_cart_fragments_refresh' );
		}
	}
}
