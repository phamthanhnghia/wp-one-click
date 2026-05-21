<?php

/*************
 * - Cart
 *************/

$_flatsome_mini_cart_active_callback = array(
	array(
		'setting'  => 'header_cart_style',
		'operator' => '!==',
		'value'    => 'link',
	),
);

Flatsome_Option::add_section( 'header_cart', array(
	'title'       => __( 'Cart', 'flatsome-admin' ),
	'panel'       => 'header',
	//'description' => __( 'This is the section description', 'flatsome-admin' ),
) );

Flatsome_Option::add_field( 'option', array(
	'type'      => 'select',
	'settings'  => 'header_cart_style',
	'label'     => __( 'Behavior', 'flatsome-admin' ),
	'section'   => 'header_cart',
	'transport' => flatsome_customizer_transport(),
	'default'   => 'dropdown',
	'choices'   => array(
		'dropdown'   => __( 'Show Mini Cart dropdown', 'flatsome-admin' ),
		'off-canvas' => __( 'Show Mini Cart drawer', 'flatsome-admin' ),
		'link'       => __( 'Go to cart page', 'flatsome-admin' ),
	),
) );

Flatsome_Option::add_field( 'option', array(
	'type'        => 'radio-image',
	'settings'     => 'cart_icon_style',
	'label'       => __( 'Cart Icon Style', 'flatsome-admin' ),
	'section'     => 'header_cart',
	'transport' => flatsome_customizer_transport(),
	'default'     => '',
	'choices'     => array(
		'' => $image_url . 'cart-icon-default.svg',
		'plain' => $image_url . 'cart-icon-plain.svg',
		'outline' => $image_url . 'cart-icon-outline.svg',
		'fill' => $image_url . 'cart-icon-fill.svg',
		'fill-round' => $image_url . 'cart-icon-fill-round.svg',
		'outline-round' => $image_url . 'cart-icon-outline-round.svg',
	),
));

Flatsome_Option::add_field( 'option', array(
	'type'        => 'radio-image',
	'settings'     => 'cart_icon',
	'label'       => __( 'Cart Icon', 'flatsome-admin' ),
	'section'     => 'header_cart',
	'transport' => flatsome_customizer_transport(),
	'default'     => 'basket',
	'choices'     => array(
		'basket' => $image_url . 'cart-icon-basket.svg',
		'cart' => $image_url . 'cart-icon-cart.svg',
		'bag' => $image_url . 'cart-icon-bag.svg',
	),
));

Flatsome_Option::add_field( 'option', array(
	'type'      => 'image',
	'settings'  => 'custom_cart_icon',
	'label'     => esc_html__( 'Custom Cart Icon', 'flatsome-admin' ),
	'section'   => 'header_cart',
	'transport' => flatsome_customizer_transport(),
	'choices'   => array( 'save_as' => 'id' ),
) );

Flatsome_Option::add_field( 'option',  array(
	'type'        => 'checkbox',
	'settings'     => 'header_cart_total',
	'label'       => __( 'Show cart totals', 'flatsome-admin' ),
	'section'     => 'header_cart',
	'transport' => flatsome_customizer_transport(),
	'default'     => 1,
));

Flatsome_Option::add_field( 'option',  array(
	'type'        => 'checkbox',
	'settings'     => 'header_cart_title',
	'label'       => __( 'Show cart title', 'flatsome-admin' ),
	'section'     => 'header_cart',
	'transport' => flatsome_customizer_transport(),
	'default'     => 1,
));

Flatsome_Option::add_field( '', array(
	'type'            => 'custom',
	'settings'        => 'custom_title_header_cart_content',
	'label'           => '',
	'section'         => 'header_cart',
	'default'         => '<div class="options-title-divider">Mini Cart content</div>',
	'active_callback' => $_flatsome_mini_cart_active_callback,
) );

Flatsome_Option::add_field( 'option', array(
	'type'            => 'checkbox',
	'settings'        => 'cart_dropdown_show',
	'label'           => __( 'Auto reveal mini cart', 'flatsome-admin' ),
	'description'     => __( 'Reveal mini cart after a product is added', 'flatsome-admin' ),
	'section'         => 'header_cart',
	'active_callback' => $_flatsome_mini_cart_active_callback,
	'default'         => 1,
) );

Flatsome_Option::add_field( 'option', array(
	'type'            => 'checkbox',
	'settings'        => 'header_cart_qty',
	'label'           => esc_html__( 'Show quantity input', 'flatsome' ),
	'section'         => 'header_cart',
	'transport'       => flatsome_customizer_transport(),
	'active_callback' => $_flatsome_mini_cart_active_callback,
	'default'         => 0,
) );

Flatsome_Option::add_field( 'option', array(
	'type'            => 'checkbox',
	'settings'        => 'header_cart_shipping',
	'label'           => esc_html__( 'Show free shipping', 'flatsome' ),
	'section'         => 'header_cart',
	'transport'       => flatsome_customizer_transport(),
	'default'         => 0,
	'active_callback' => $_flatsome_mini_cart_active_callback,
) );

Flatsome_Option::add_field( 'option', array(
	'type'              => 'textarea',
	'settings'          => 'html_cart_header',
	'transport'         => flatsome_customizer_transport(),
	'label'             => __( 'Custom Content after Cart', 'flatsome-admin' ),
	'description'       => __( 'Add Any HTML or Shortcode here...', 'flatsome-admin' ),
	'section'           => 'header_cart',
	'sanitize_callback' => 'flatsome_custom_sanitize',
	'active_callback'   => $_flatsome_mini_cart_active_callback,
) );

Flatsome_Option::add_field( '', array(
	'type'            => 'custom',
	'settings'        => 'custom_title_header_cart_drawer_content',
	'label'           => '',
	'section'         => 'header_cart',
	'default'         => '<div class="options-subtitle-divider">Mini Cart drawer</div>',
	'active_callback' => $_flatsome_mini_cart_active_callback,
) );

Flatsome_Option::add_field( 'option', array(
	'type'            => 'dimension',
	'settings'        => 'cart_drawer_width',
	'section'         => 'header_cart',
	'label'           => esc_html__( 'Drawer width', 'flatsome' ),
	'transport'       => flatsome_customizer_transport(),
	'default'         => '',
	'active_callback' => $_flatsome_mini_cart_active_callback,
) );

Flatsome_Option::add_field( 'option', array(
	'type'            => 'checkbox',
	'settings'        => 'header_cart_sticky_footer',
	'label'           => esc_html__( 'Sticky footer', 'flatsome' ),
	'section'         => 'header_cart',
	'transport'       => flatsome_customizer_transport(),
	'default'         => 1,
	'active_callback' => $_flatsome_mini_cart_active_callback,
) );

Flatsome_Option::add_field( 'option', array(
	'type'            => 'checkbox',
	'settings'        => 'header_cart_cross_sells',
	'label'           => esc_html__( 'Show cross sells', 'flatsome' ),
	'section'         => 'header_cart',
	'transport'       => flatsome_customizer_transport(),
	'default'         => 0,
	'active_callback' => $_flatsome_mini_cart_active_callback,
) );

function flatsome_refresh_header_cart_partials( WP_Customize_Manager $wp_customize ) {

	if ( ! isset( $wp_customize->selective_refresh ) ) {
	      return;
	}

	// Cart.
	$wp_customize->selective_refresh->add_partial( 'header-cart', array(
		'selector'            => '.cart-item',
		'container_inclusive' => true,
		'settings'            => array(
			'cart_icon',
			'header_cart_style',
			'cart_icon_style',
			'custom_cart_icon',
			'header_cart_total',
			'header_cart_title',
			'html_cart_header',
			'header_cart_qty',
			'header_cart_cross_sells',
			'header_cart_shipping',
		),
		'render_callback'     => function () {
			get_template_part( 'template-parts/header/partials/element', 'cart' );
		},
	) );

	// Cart.
	$wp_customize->selective_refresh->add_partial( 'header-cart', array(
		'selector'            => '.header-nav .cart-item',
		'container_inclusive' => true,
		'settings'            => array(
			'cart_icon',
			'header_cart_style',
			'cart_icon_style',
			'custom_cart_icon',
			'header_cart_total',
			'header_cart_title',
			'html_cart_header',
			'header_cart_qty',
			'header_cart_cross_sells',
			'header_cart_shipping',
		),
		'render_callback'     => function () {
			get_template_part( 'template-parts/header/partials/element', 'cart' );
		},
	) );

	$wp_customize->selective_refresh->add_partial( 'header-cart-mobile', array(
	    'selector' => '.mobile-nav .cart-item',
	    'container_inclusive' => true,
	    'settings' => array('cart_icon','header_cart_style','cart_icon_style','custom_cart_icon','header_cart_total','header_cart_title','html_cart_header'),
	    'render_callback' => function() {
	        get_template_part('template-parts/header/partials/element','cart-mobile');
	    },
	) );

}
add_action( 'customize_register', 'flatsome_refresh_header_cart_partials' );
