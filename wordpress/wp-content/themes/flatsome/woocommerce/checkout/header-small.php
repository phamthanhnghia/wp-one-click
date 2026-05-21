<?php
/**
 * Checkout header small.
 *
 * @package          Flatsome/WooCommerce/Templates
 * @flatsome-version 3.20.0
 */

/**
 * Checkout breadcrumb class.
 *
 * @param string $endpoint Endpoint to check for.
 *
 * @return string
 */
function flatsome_checkout_breadcrumb_class( $endpoint ) {
	$classes = array();
	if ( ( $endpoint == 'cart' && is_cart() ) ||
	     ( $endpoint == 'checkout' && is_checkout() && ! is_wc_endpoint_url( 'order-received' ) ) ||
	     ( $endpoint == 'order-received' && is_wc_endpoint_url( 'order-received' ) ) ) {
		$classes[] = 'current';
	} else {
		$classes[] = 'hide-for-small';
	}

	return implode( ' ', $classes );
}

$steps = get_theme_mod( 'cart_steps_numbers', 0 );

// Get breadcrumb classes for each endpoint.
$cart_class           = flatsome_checkout_breadcrumb_class( 'cart' );
$checkout_class       = flatsome_checkout_breadcrumb_class( 'checkout' );
$order_received_class = flatsome_checkout_breadcrumb_class( 'order-received' );

// Navigation attributes.
$nav_atts = [
	'class'      => [
		'breadcrumbs flex-row flex-row-start checkout-breadcrumbs text-left medium-text-center is-large',
		esc_attr( get_theme_mod( 'cart_steps_case', 'uppercase' ) ),
	],
	'aria-label' => esc_attr__( 'Checkout steps', 'flatsome' ),
];

// Cart link attributes.
$cart_atts = [
	'href'          => esc_url( wc_get_cart_url() ),
	'class'         => $cart_class,
	'aria-current'  => str_contains( $cart_class, 'current' ) ? 'page' : null,
	'aria-disabled' => ! str_contains( $cart_class, 'current' ) ? 'true' : null,
];

// Checkout link attributes.
$checkout_atts = [
	'href'          => esc_url( wc_get_checkout_url() ),
	'class'         => $checkout_class,
	'aria-current'  => str_contains( $checkout_class, 'current' ) ? 'page' : null,
	'aria-disabled' => ! str_contains( $checkout_class, 'current' ) ? 'true' : null,
];

// Order received link attributes.
$order_received_atts = [
	'href'          => '#',
	'class'         => 'no-click ' . $order_received_class,
	'aria-current'  => str_contains( $order_received_class, 'current' ) ? 'page' : null,
	'aria-disabled' => ! str_contains( $order_received_class, 'current' ) ? 'true' : null,
];

// Divider attributes.
$divider_atts = [
	'class'       => 'divider hide-for-small',
	'aria-hidden' => 'true',
];
?>

<nav <?php echo flatsome_html_atts( $nav_atts ); ?>>
	<?php echo get_flatsome_icon( 'icon-lock', null, array( 'class' => 'op-5' ) ); ?>
	<a <?php echo flatsome_html_atts( $cart_atts ); ?>>
		<?php if ( $steps ) { echo '<span class="breadcrumb-step hide-for-small">1</span>'; } ?>
		<?php esc_html_e( 'Shopping Cart', 'flatsome' ); ?>
	</a>
	<span <?php echo flatsome_html_atts( $divider_atts ); ?>><?php echo get_flatsome_icon( 'icon-angle-right' ); ?></span>
	<a <?php echo flatsome_html_atts( $checkout_atts ); ?>>
		<?php if ( $steps ) { echo '<span class="breadcrumb-step hide-for-small">2</span>'; } ?>
		<?php esc_html_e( 'Checkout details', 'flatsome' ); ?>
	</a>
	<span <?php echo flatsome_html_atts( $divider_atts ); ?>><?php echo get_flatsome_icon( 'icon-angle-right' ); ?></span>
	<a <?php echo flatsome_html_atts( $order_received_atts ); ?>>
		<?php if ( $steps ) { echo '<span class="breadcrumb-step hide-for-small">3</span>'; } ?>
		<?php esc_html_e( 'Order Complete', 'flatsome' ); ?>
	</a>
</nav>
