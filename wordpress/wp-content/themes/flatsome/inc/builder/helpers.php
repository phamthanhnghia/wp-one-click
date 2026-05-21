<?php

function flatsome_ux_builder_template( $path ) {
  ob_start();
  include get_template_directory() . '/inc/builder/shortcodes/templates/' . $path;
  return ob_get_clean();
}

function flatsome_ux_builder_thumbnail( $name ) {
  return get_template_directory_uri() . '/inc/builder/shortcodes/thumbnails/' . $name . '.svg';
}

function flatsome_ux_builder_template_thumb( $name ) {
  return get_template_directory_uri() . '/inc/builder/templates/thumbs/' . $name . '.jpg';
}

function flatsome_ux_builder_image_sizes( $sizes = array() ) {
  $image_sizes      = get_intermediate_image_sizes();
  $additional_sizes = wp_get_additional_image_sizes();

  $sizes['original'] = __( 'Original', 'flatsome' );

  foreach ( $image_sizes as $key ) {
    if ( isset( $additional_sizes[ $key ] ) ) {
      $width  = $additional_sizes[ $key ]['width'];
      $height = $additional_sizes[ $key ]['height'];
    } else {
      $width  = get_option( $key . '_size_w' );
      $height = get_option( $key . '_size_h' );
    }

    $name = ucfirst( str_replace( '_', ' ', $key ) );
    $size = join( 'x', array_filter( array( $width, $height ) ) );

    if ( $size != $key ) {
      $name .= " ($size)";
    }

    $sizes[ $key ] = $name;
  }

  if ( is_woocommerce_activated() ) {
    foreach ( array( 'shop_catalog', 'shop_single', 'shop_thumbnail' ) as $key ) {
      if ( array_key_exists( $key, $sizes ) ) {
        unset( $sizes[ $key ] );
      }
    }
  }

  return $sizes;
}

/**
 * Inserts a new element into an array immediately after a specified key.
 *
 * This function takes an array, a key in the array, and a new element as parameters.
 * It finds the position of the provided key in the array and inserts the new element
 * immediately after it. If the key is not found in the array, the new element is
 * appended at the end of the array.
 *
 * @param array $array The original array.
 * @param mixed $key   The key after which the new element should be inserted.
 * @param mixed $new   The new element to be inserted.
 *
 * @return array The updated array with the new element inserted.
 */
function flatsome_ux_builder_array_insert_after( $array, $key, $new ) {
	$keys  = array_keys( $array );
	$index = array_search( $key, $keys, true );
	$pos   = false === $index ? count( $array ) : $index + 1;

	return array_merge( array_slice( $array, 0, $pos ), $new, array_slice( $array, $pos ) );
}
