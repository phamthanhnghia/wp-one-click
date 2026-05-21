<?php

function ux_payment_icons( $atts ) {
	extract( shortcode_atts( array(
		'link'       => '',
		'target'     => '',
		'rel'        => '',
		'icons'      => get_theme_mod( 'payment_icons', array( 'visa', 'paypal', 'stripe', 'mastercard', 'cashondelivery' ) ),
		'custom'     => get_theme_mod( 'payment_icons_custom' ),
		'class'      => '',
		'visibility' => '',
	), $atts ) );

	$classes   = array( 'payment-icons', 'inline-block' );
	$is_custom = ! empty( $custom );

	if ( $class ) $classes[] = $class;

	if ( $visibility ) $classes[] = $visibility;

	$classes = implode( ' ', $classes );

	$element_atts = array(
		'class'      => $classes,
		'role'       => $is_custom ? null : 'group',
		'aria-label' => $is_custom || $link ? null : esc_attr__( 'Payment icons', 'flatsome' ),
	);

	$link_atts = array(
		'href'       => esc_url( $link ),
		'target'     => esc_attr( $target ),
		'rel'        => esc_attr( $rel ),
		'aria-label' => $is_custom ? null : esc_attr__( 'Payment icons', 'flatsome' ), // Use image alt on custom.
	);

	$link_start = $link ? '<a ' . flatsome_html_atts( $link_atts ) . '>' : '';
	$link_end   = $link ? '</a>' : '';

	// Get custom icons if set.
	if ( $is_custom ) {
		return do_shortcode( '<div class="' . esc_attr( $classes ) . '">' . $link_start . flatsome_get_image( $custom ) . $link_end . '</div>' );
	} elseif ( empty( $icons ) ) {
		return false;
	}

	if ( ! is_array( $icons ) ) {
		$icons = explode( ',', $icons );
	}

	$payment_icons = flatsome_get_payment_icons_list();

	ob_start();

	echo '<div ' . flatsome_html_atts( $element_atts ) . '>';
	echo $link_start; // phpcs:disable WordPress.Security.EscapeOutput
	foreach ( $icons as $key => $value ) {
		$icon_atts = array(
			'class' => 'payment-icon',
		);
		echo '<div ' . flatsome_html_atts( $icon_atts ) . '>';
		if ( array_key_exists( $value, $payment_icons ) ) {
			echo Flatsome_Icon::get_payment_icon( $value );
			echo '<span class="screen-reader-text">' . esc_html( $payment_icons[ $value ] ) . '</span>';
		}
		echo '</div>';
	}
	echo $link_end; // phpcs:disable WordPress.Security.EscapeOutput
	echo '</div>';

	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

add_shortcode( 'ux_payment_icons', 'ux_payment_icons' );
