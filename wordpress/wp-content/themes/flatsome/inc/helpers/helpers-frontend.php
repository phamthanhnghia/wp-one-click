<?php

/**
 * Load a template.
 *
 * @param  string $name
 * @param  array  $vars
 * @return string
 */
function flatsome_template( $name, array $vars = array() ) {
  $located_template = locate_template( 'template-parts/' . $name . '.php' );
  if ( $located_template != '' ) {
    extract( $vars );
    ob_start();
    include $located_template;
    return ob_get_clean();
  }
  return '';
}

/**
 * Converts an array into html attributes.
 * The 'class' and 'rel' attributes can be supplied as arrays and will be converted to space-separated strings.
 *
 * @param array $atts Attributes array.
 *
 * @return string
 */
function flatsome_html_atts( array $atts ) {
	$result = [];

	$atts = apply_filters( 'flatsome_html_atts', $atts );

	foreach ( $atts as $key => $value ) {
		if ( $value === null || $value === '' ) continue;

		if ( str_starts_with( $key, 'aria-' ) ) {
			if ( is_bool( $value ) ) {
				$value = $value ? 'true' : 'false';
			}
		} elseif ( $key === 'class' || $key === 'rel' ) {
			if ( is_array( $value ) ) {
				$value = implode( ' ', $value );
			}
		}

		if ( $value === false ) continue;

		if ( $value === true ) {
			$result[] = $key;
		} else {
			$result[] = $key . '="' . $value . '"';
		}
	}

	return implode( ' ', $result );
}

/**
 * Filter function, processes the 'target' and 'rel' attributes for an HTML tag.
 *
 * This function prepares the 'target' and 'rel' attributes for an HTML tag based on the given input attributes.
 * If the 'target' attribute is set to '_blank', it adds 'noopener' to the 'rel' attribute.
 * The function also filters and removes any duplicate values from the 'rel' attribute.
 *
 * @param array $atts An array containing the input attributes.
 *
 * @return array An array with the processed 'target' and 'rel' attributes, merged with the original input attributes.
 */
function flatsome_process_target_rel_attributes( array $atts ) {
	if ( empty( $atts['target'] ) && empty( $atts['rel'] ) ) {
		return $atts;
	}

	$rel_values = ! empty( $atts['rel'] ) ? ( is_array( $atts['rel'] ) ? $atts['rel'] : explode( ' ', $atts['rel'] ) ) : [];

	if ( ! empty( $atts['target'] ) ) {
		if ( $atts['target'] === '_blank' ) {
			$rel_values[] = 'noopener';
		}

		if ( $atts['target'] === '_self' ) {
			unset( $atts['target'] );
		}
	}

	$rel_values = array_unique( array_filter( $rel_values ) );
	$rel_values = ! empty( $rel_values ) ? $rel_values : null;

	unset( $atts['rel'] );

	return array_merge( $atts, [ 'rel' => $rel_values ] );
}

add_filter( 'flatsome_html_atts', 'flatsome_process_target_rel_attributes' );

/**
 * Filter function, add attributes to the HTML tag.
 *
 * @param array $atts An array containing the input attributes.
 *
 * @return array An array with the processed attributes.
 */
function flatsome_html_atts_add_attributes( array $atts ) {
	if ( empty( $atts['role'] ) ) {
		return $atts;
	}

	$data = [];

	if ( $atts['role'] === 'button' ) {
		$data['data-flatsome-role-button'] = true;
	}
	if ( $atts['role'] === 'radiogroup' ) {
		$data['data-flatsome-role-radiogroup'] = true;
	}

	return empty( $data ) ? $atts : array_merge( $atts, $data );
}

add_filter( 'flatsome_html_atts', 'flatsome_html_atts_add_attributes' );

/**
 * Get Flatsome Icon classes
  */
function get_flatsome_icon_class($style, $size = null){

    $classes = array();
    if($style == 'small'){ $classes[] = 'icon plain';}
    if($style == 'outline'){ $classes[] = 'icon button circle is-outline';}
    if($style == 'outline-round'){ $classes[] = 'icon button round is-outline';}
    if($style == 'fill'){ $classes[] = 'icon primary button circle';}
    if($style == 'fill-round'){ $classes[] = 'icon primary button round';}
    if($size){ $classes[] = 'is-'.$size;}

    return implode(' ', $classes);
}

/**
 * Minify CSS
  */
function flatsome_minify_css($css){
  //$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
  $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
  return $css;
}


function flatsome_dummy_text(){
	$content = '<p><strong>This is a dummy text for demo purpose</strong>. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p><p> Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>';
	return apply_filters( 'flatsome_dummy_text', $content );
}
