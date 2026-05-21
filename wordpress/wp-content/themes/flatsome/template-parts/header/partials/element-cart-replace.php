<?php
/**
 * Cart replace element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.19.9
 */

if ( get_theme_mod( 'catalog_mode_header', '' ) ) echo '<li class="html cart-replace">' . do_shortcode( get_theme_mod( 'catalog_mode_header', '' ) ) . '</li>';
