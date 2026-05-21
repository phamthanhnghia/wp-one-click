<?php
/**
 * Checkout element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.20.0
 */

if ( ! is_woocommerce_activated() ) {
	fl_header_element_error( 'woocommerce' );
	return;
}

$link_atts = [
	'href'  => esc_url( wc_get_checkout_url() ),
	'class' => [ 'button', 'cart-checkout', 'secondary', 'is-small', 'circle' ],
];

if ( is_checkout() ) {
	$link_atts['href']          = 'javascript:void(0)';
	$link_atts['class'][]       = 'disabled';
	$link_atts['aria-disabled'] = 'true';
}
?>
<li>
	<div class="cart-checkout-button header-button">
		<a <?php echo flatsome_html_atts( $link_atts ); ?>>
			<span class="hide-for-small"><?php esc_html_e( 'Checkout', 'woocommerce' ); ?></span>
			<span class="show-for-small" aria-label="<?php esc_attr_e( 'Checkout', 'woocommerce' ); ?>">+</span>
		</a>
	</div>
</li>
