<?php
/**
 * Back to top.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.20.0
 */

$classes   = [ 'back-to-top', 'button', 'icon', 'invert', 'plain', 'fixed', 'bottom', 'z-1', 'is-outline' ];
$shape     = get_theme_mod( 'back_to_top_shape', 'circle' );
$classes[] = $shape === 'circle' ? 'circle' : 'round';

if ( get_theme_mod( 'back_to_top_position' ) === 'left' ) {
	$classes[] = 'left';
}

if ( ! get_theme_mod( 'back_to_top_mobile' ) ) {
	$classes[] = 'hide-for-medium';
}

printf( '<button type="button" %s>%s</button>',
	flatsome_html_atts( [
		'id'         => 'top-link',
		'class'      => $classes,
		'aria-label' => esc_attr__( 'Go to top', 'flatsome' ),
	] ),
	get_flatsome_icon( 'icon-angle-up' )
);
