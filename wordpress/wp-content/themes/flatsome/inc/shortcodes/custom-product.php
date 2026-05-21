<?php

add_shortcode( 'ux_product_gallery', function ( $atts ) {
	extract( shortcode_atts( array(
		'style'       => 'normal',
		'grid_layout' => '',
		'slider_type' => '',
	), $atts ) );

	if ( ! is_product() ) {
		return null;
	}

	add_filter( 'theme_mod_product_image_style', function () use ( $style ) {
		if ( ! in_array( $style, [ 'normal', 'vertical' ], true ) ) {
			return 'normal';
		}
		return $style;
	} );

	add_filter( 'theme_mod_product_layout', function () use ( $style ) {
		$layout = '';

		if ( $style === 'full-width' ) $layout = 'gallery-wide';
		if ( $style === 'stacked' ) $layout = 'stacked-right';

		return $layout;
	} );

	add_filter( 'theme_mod_product_gallery_grid_layout', function () use ( $grid_layout ) {
		if ( ! in_array( $grid_layout, [ '', '1-2', '2', '3-1-2' ], true ) ) {
			return '';
		}
		return $grid_layout;
	} );

	add_filter( 'theme_mod_product_gallery_slider_type', function () use ( $slider_type ) {
		if ( ! in_array( $slider_type, [ '', 'fade' ], true ) ) {
			return '';
		}
		return $slider_type;
	} );

	ob_start();
	wc_get_template_part( 'single-product/product-image' );

	return ob_get_clean();
} );

add_shortcode( 'ux_product_title', function ( $atts ) {
	extract( shortcode_atts( array(
		'size'      => false,
		'divider'   => true,
		'case'      => 'normal',
		'uppercase' => false,
	), $atts ) );

	if ( ! is_product() ) {
		return null;
	}

	add_filter( 'theme_mod_product_title_divider', function ( $input ) use ( $divider ) {
		if ( $divider ) {
			return true;
		}
	} );

	$classes = array( 'product-title-container' );
	if ( $size ) {
		$classes[] = 'is-' . $size;
	}
	if ( $uppercase ) {
		$classes[] = 'is-uppercase';
	}

	ob_start();
	echo '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
	woocommerce_template_single_title();
	echo '</div>';

	return ob_get_clean();
} );

add_shortcode( 'ux_product_rating', function ( $atts ) {
	extract( shortcode_atts( array(
		'size'  => 'normal',
		'count' => false,
		'style' => 'inline',
	), $atts ) );

	if ( ! is_product() ) {
		return null;
	}

	add_filter( 'theme_mod_product_info_review_count', function () use ( $count ) {
		return $count === 'true';
	} );

	add_filter( 'theme_mod_product_info_review_count_style', function () use ( $style ) {
		if ( ! in_array( $style, [ 'tooltip', 'stacked', 'inline' ], true ) ) {
			return 'inline';
		}
		return $style;
	} );

	ob_start();
	woocommerce_template_single_rating();

	return ob_get_clean();
} );

add_shortcode( 'ux_product_hook', function ( $atts ) {
	extract( shortcode_atts( array(
		'hook' => 'woocommerce_single_product_summary',
	), $atts ) );

	if ( ! is_product() ) {
		return null;
	}

	$hooks = array_keys( apply_filters( 'flatsome_custom_product_single_product_hooks', [
		'woocommerce_before_single_product_summary' => 'woocommerce_before_single_product_summary',
		'woocommerce_single_product_summary'        => 'woocommerce_single_product_summary',
		'woocommerce_after_single_product_summary'  => 'woocommerce_after_single_product_summary',
		'flatsome_custom_single_product_1'          => 'flatsome_custom_single_product_1',
		'flatsome_custom_single_product_2'          => 'flatsome_custom_single_product_2',
		'flatsome_custom_single_product_3'          => 'flatsome_custom_single_product_3',
	] ) );

	ob_start();

	if ( in_array( $hook, $hooks, true ) ) {
		do_action( $hook );
	}

	return ob_get_clean();
} );


add_shortcode( 'ux_product_price', function ( $atts ) {
	extract( shortcode_atts( array(
		'size' => 'normal',
	), $atts ) );

	if ( ! is_product() ) {
		return null;
	}

	ob_start();
	echo '<div class="product-price-container is-' . esc_attr( $size ) . '">';
	woocommerce_template_single_price();
	echo '</div>';

	return ob_get_clean();
} );

add_shortcode( 'ux_product_excerpt', function ( $atts ) {
	extract( shortcode_atts( array(
		'type' => 'default',
	), $atts ) );

	if ( ! is_product() ) {
		return null;
	}

	ob_start();
	woocommerce_template_single_excerpt();

	return ob_get_clean();
} );

add_shortcode( 'ux_product_description', function ( $atts ) {
	extract( shortcode_atts( array(
		'type' => 'default',
	), $atts ) );

	if ( ! is_product() ) {
		return null;
	}

	ob_start();
	the_content();

	return ob_get_clean();
} );

add_shortcode( 'ux_product_add_to_cart', function ( $atts ) {
	extract( shortcode_atts( array(
		'style' => 'normal',
		'size'  => 'normal',
	), $atts ) );

	if ( ! is_product() ) {
		return null;
	}

	add_filter( 'theme_mod_product_info_form', function () use ( $style ) {
		if ( in_array( $style, [ '', 'flat', 'minimal' ], true ) ) {
			return $style;
		}
	} );

	ob_start();
	echo '<div class="add-to-cart-container form-' . esc_attr( $style ) . ' is-' . esc_attr( $size ) . '">';
	woocommerce_template_single_add_to_cart();
	echo '</div>';

	return ob_get_clean();
} );

add_shortcode( 'ux_product_meta', function ( $atts ) {
	extract( shortcode_atts( array(
		'type' => 'default',
	), $atts ) );

	if ( ! is_product() ) {
		return null;
	}

	ob_start();
	woocommerce_template_single_meta();

	return ob_get_clean();
} );

add_shortcode( 'ux_product_tabs', function ( $atts ) {
	extract( shortcode_atts( array(
		'style' => 'tabs',
		'align' => 'left'
	), $atts ) );

	if ( ! is_product() ) {
		return null;
	}

	add_filter( 'theme_mod_product_display', function ( $input ) use ( $style ) {
		if ( in_array( $style, [ 'tabs', 'tabs_normal', 'line-grow', 'tabs_vertical', 'tabs_pills', 'tabs_outline', 'sections', 'accordian', 'accordian-collapsed' ], true ) ) {
			return $style;
		}
	} );

	add_filter( 'theme_mod_product_tabs_align', function ( $input ) use ( $align ) {
		if ( in_array( $align, [ 'left', 'center', 'right' ], true ) ) {
			return $align;
		}
	} );

	ob_start();
	wc_get_template_part( 'single-product/tabs/tabs' );

	return ob_get_clean();
} );


add_shortcode( 'ux_product_upsell', function ( $atts ) {
	extract( shortcode_atts( array(
		'style' => 'sidebar',
	), $atts ) );

	if ( ! is_product() ) {
		return null;
	}

	add_filter( 'theme_mod_product_upsell', function ( $input ) use ( $style ) {
		if ( in_array( $style, [ 'sidebar', 'bottom', 'disabled' ], true ) ) {
			return $style;
		}
	} );

	ob_start();
	woocommerce_upsell_display();

	return ob_get_clean();
} );

add_shortcode( 'ux_product_related', function ( $atts ) {
	extract( shortcode_atts( array(
		'style' => 'slider',
	), $atts ) );

	if ( ! is_product() ) {
		return null;
	}

	add_filter( 'theme_mod_related_products', function ( $input ) use ( $style ) {
		if ( in_array( $style, [ 'slider', 'grid', 'hidden' ] ) ) {
			return $style;
		}
	} );

	ob_start();
	woocommerce_output_related_products();

	return ob_get_clean();
} );

add_shortcode( 'ux_product_breadcrumbs', function ( $atts ) {
	extract( shortcode_atts( array(
		'size' => 'normal',
	), $atts ) );

	if ( ! is_product() ) {
		return null;
	}

	ob_start();
	echo '<div class="product-breadcrumb-container is-' . esc_attr( $size ) . '">';
	flatsome_breadcrumb();
	echo '</div>';

	return ob_get_clean();
} );

add_shortcode( 'ux_product_next_prev_nav', function ( $atts ) {
	$atts = shortcode_atts( array(
		'class' => '',
	), $atts, 'ux_product_next_prev_nav' );

	if ( ! is_product() ) {
		return null;
	}

	ob_start();
	flatsome_product_next_prev_nav( $atts['class'] );

	return ob_get_clean();
} );
