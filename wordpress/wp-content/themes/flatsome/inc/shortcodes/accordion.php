<?php
/**
 * Accordion Shortcode
 *
 * Accordion and Accordion Item Shortcode builder.
 *
 * @author UX Themes
 * @package Flatsome/Shortcodes/Accordion
 */

$flatsome_accordion_state = array();
$flatsome_accordion_faq_schema = array();

/**
 * Output the accordion shortcode.
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content Accordion content.
 *
 * @return string.
 */
function ux_accordion( $atts, $content = null ) {
	global $flatsome_accordion_state;

	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		$flatsome_accordion_state = array();
	}

	extract( shortcode_atts( array(
		'auto_open'  => '',
		'open'       => '',
		'title'      => '',
		'class'      => '',
		'faq_schema' => '',
	), $atts ) );

	if ($auto_open) $open = 1;

	array_push( $flatsome_accordion_state, array(
		'open'       => (int) $open,
		'current'    => 1,
		'faq_schema' => filter_var( $faq_schema, FILTER_VALIDATE_BOOLEAN ),
	) );

	$classes                 = array( 'accordion' );
	if ( $class ) $classes[] = $class;

	if ($title) $title = '<h3 class="accordion_title">' . $title . '</h3>';

	$result = wp_kses_post( $title ) . '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . do_shortcode( $content ) . '</div>';

	array_pop( $flatsome_accordion_state );

	return $result;
}
add_shortcode( 'accordion', 'ux_accordion' );


/**
 * Output the accordion-item shortcode.
 *
 * @param array  $atts    Shortcode attributes.
 * @param string $content Accordion content.
 * @param string $tag     The name of the shortcode, provided for context to enable filtering.
 *
 * @return string.
 */
function ux_accordion_item( $atts, $content = null, $tag = '' ) {
	global $flatsome_accordion_state, $flatsome_accordion_faq_schema;

	$current = count( $flatsome_accordion_state ) - 1;
	$state   = isset( $flatsome_accordion_state[ $current ] )
		? $flatsome_accordion_state[ $current ]
		: null;

	$atts = shortcode_atts(
		array(
			'id'     => 'accordion-' . wp_rand(),
			'title'  => 'Accordion Panel',
			'anchor' => '',
			'class'  => '',
		),
		$atts,
		$tag
	);

	$is_open       = false;
	$classes       = array( 'accordion-item' );
	$title_classes = array( 'accordion-title', 'plain' );

	if ( is_array( $state ) && $state['current'] === $state['open'] ) {
		$is_open         = true;
		$title_classes[] = 'active';
	}

	if ( ! empty( $atts['class'] ) ) $classes[] = $atts['class'];

	if ( isset( $flatsome_accordion_state[ $current ]['current'] ) ) {
		$flatsome_accordion_state[ $current ]['current'] ++;
	}

	if ( isset( $flatsome_accordion_state[ $current ]['faq_schema'] ) && $flatsome_accordion_state[ $current ]['faq_schema'] ) {
		$question = wp_strip_all_tags( $atts['title'] );
		$answer   = $content;

		$answer = do_shortcode( $answer );
		$answer = shortcode_unautop( $answer );
		$answer = wptexturize( $answer );

		if ( $GLOBALS['wp_embed'] instanceof \WP_Embed ) {
			$answer = $GLOBALS['wp_embed']->autoembed( $answer );
		}

		$flatsome_accordion_faq_schema[] = array(
			'question' => $question,
			'answer'   => $answer,
		);
	}

	$link_atts = array(
		'id'            => esc_attr( $atts['id'] ) . '-label',
		'class'         => esc_attr( implode( ' ', $title_classes ) ),
		'href'          => ! empty( $atts['anchor'] )
			? '#' . rawurlencode( $atts['anchor'] )
			: esc_url( '#accordion-item-' . flatsome_to_dashed( $atts['title'] ) ),
		'aria-expanded' => $is_open ? 'true' : 'false',
		'aria-controls' => esc_attr( $atts['id'] ) . '-content',
	);

	$accordion_inner_atts = array(
		'id'              => esc_attr( $atts['id'] ) . '-content',
		'class'           => 'accordion-inner',
		'style'           => $is_open ? 'display: block;' : null,
		'aria-labelledby' => esc_attr( $atts['id'] ) . '-label',

	);

	ob_start();

	?>
	<div id="<?php echo esc_attr( $atts['id'] ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<a <?php echo flatsome_html_atts( $link_atts ); ?>>
			<button class="toggle" aria-label="<?php esc_attr_e( 'Toggle', 'flatsome' ); ?>"><?php echo get_flatsome_icon( 'icon-angle-down' ); ?></button>
			<span><?php echo wp_kses_post( $atts['title'] ); ?></span>
		</a>
		<div <?php echo flatsome_html_atts( $accordion_inner_atts ); ?>>
			<?php echo do_shortcode( $content ); ?>
		</div>
	</div>
	<?php

	return ob_get_clean();
}
add_shortcode( 'accordion-item', 'ux_accordion_item' );

/**
 * Printing FAQ Schema.
 *
 * @return void
 */
function flatsome_print_faq_schema() {
	global $flatsome_accordion_faq_schema;

	if ( empty( $flatsome_accordion_faq_schema ) ) {
		return;
	}

	$json = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => array(),
	);

	foreach ( $flatsome_accordion_faq_schema as $faq ) {
		$json['mainEntity'][] = array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $faq['question'] ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => wp_kses_post( $faq['answer'] ),
			),
		);
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $json ) . '</script>';
}

add_action( 'wp_footer', 'flatsome_print_faq_schema' );
