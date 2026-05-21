<?php
/**
 * Registers the `ux_lottie` shortcode.
 *
 * @package Flatsome
 */

/**
 * Renders the `ux_lottie` shortcode.
 *
 * @param array  $atts    An array of attributes.
 * @param string $content The shortcode content.
 * @param string $tag     The name of the shortcode, provided for context to enable filtering.
 *
 * @return string
 */
function flatsome_render_ux_lottie_shortcode( $atts, $content, $tag ) {
	$atts = shortcode_atts(
		array(
			'path'               => '',
			'loop'               => 'true',
			'autoplay'           => 'true',
			'trigger'            => '',
			'mouseout'           => '',
			'speed'              => '1',
			'reverse'            => 'false',
			'start'              => '0',
			'end'                => '100',
			'scroll_action_type' => 'seek',
			'visibility_start'   => '0',
			'visibility_end'     => '100',
			'controls'           => 'false',
			'width'              => '100%',
			'width__md'          => null,
			'width__sm'          => null,
			'height'             => '300px',
			'height__md'         => null,
			'height__sm'         => null,
			'padding'            => '',
			'padding__md'        => null,
			'padding__sm'        => null,
			'margin'             => '',
			'margin__md'         => null,
			'margin__sm'         => null,
			'link'               => '',
			'link_aria_label'    => '',
			'target'             => '_self',
			'rel'                => '',
			'class'              => '',
			'visibility'         => '',
		),
		$atts,
		$tag
	);

	$id             = 'ux-lottie-' . wp_rand();
	$classes        = array( 'ux-lottie' );
	$player_classes = array( 'ux-lottie__player' );

	if ( ! empty( $atts['class'] ) ) $classes[]      = $atts['class'];
	if ( ! empty( $atts['visibility'] ) ) $classes[] = $atts['visibility'];

	$element_atts = array(
		'id'    => $id,
		'class' => esc_attr( implode( ' ', $classes ) ),
	);

	$link_atts = array(
		'href'       => esc_url( $atts['link'] ),
		'target'     => esc_attr( $atts['target'] ),
 		'rel'        => esc_attr( $atts['rel'] ),
		'aria-label' => esc_attr( $atts['link_aria_label'] ),
	);

	$player_atts = array(
		'class'       => implode( ' ', $player_classes ),
		'data-params' => esc_attr( wp_json_encode( array(
			'src'              => ! empty( $atts['path'] ) ? $atts['path'] : 'https://assets7.lottiefiles.com/packages/lf20_wcq4npki.json',
			'loop'             => $atts['loop'] === 'true',
			'autoplay'         => $atts['autoplay'] === 'true',
			'controls'         => $atts['controls'] === 'true',
			'speed'            => $atts['speed'],
			'direction'        => $atts['reverse'] === 'true' ? - 1 : 1,
			'trigger'          => $atts['trigger'],
			'mouseout'         => $atts['mouseout'],
			'start'            => (int) $atts['start'],
			'end'              => (int) $atts['end'],
			'scrollActionType' => $atts['scroll_action_type'],
			'visibilityStart'  => (int) $atts['visibility_start'],
			'visibilityEnd'    => (int) $atts['visibility_end'],
			'id'               => $id,
		) ) ),
	);

	ob_start();

	?>
	<div <?php echo flatsome_html_atts( $element_atts ); ?>>
		<?php if ( ! empty( $atts['link'] ) ) printf( '<a %s>', flatsome_html_atts( $link_atts ) ); ?>
		<lottie-player <?php echo flatsome_html_atts( $player_atts ); ?>></lottie-player>
		<?php if ( ! empty( $atts['link'] ) ) echo '</a>'; ?>
		<?php
		echo ux_builder_element_style_tag(
			$id,
			array(
				'width'   => array(
					'selector' => '',
					'property' => 'width',
				),
				'height'  => array(
					'selector' => '',
					'property' => 'height',
				),
				'padding' => array(
					'selector' => '.ux-lottie__player',
					'property' => 'padding',
				),
				'margin'  => array(
					'selector' => '.ux-lottie__player',
					'property' => 'margin',
				),
			),
			$atts
		);
		?>
	</div>
	<?php

	return ob_get_clean();
}

add_shortcode( 'ux_lottie', 'flatsome_render_ux_lottie_shortcode' );
