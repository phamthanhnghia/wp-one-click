<?php
/**
 * Registers the `ux_products_list` shortcode.
 *
 * @package flatsome
 */

/**
 * Renders the `ux_products_list` shortcode.
 *
 * @param array  $atts    An array of attributes.
 * @param string $content The shortcode content.
 * @param string $tag     The name of the shortcode, provided for context to enable filtering.
 *
 * @return string
 */
function ux_products_list( $atts, $content = null, $tag = '' ) {
	extract( $atts = shortcode_atts( array(
		'title'        => '',
		'ids'          => '',
		'products'     => '8',
		'cat'          => '',
		'excerpt'      => 'visible',
		'offset'       => '',
		'orderby'      => '', // normal, sales, rand, date.
		'order'        => '',
		'tags'         => '',
		'show'         => '', // featured, onsale.
		'out_of_stock' => '', // exclude.
		'class'        => '',
		'visibility'   => '',

	), $atts ) );

	$classes = array( 'ux-products-list', 'product_list_widget' );

	if ( ! empty( $atts['class'] ) ) $classes[]      = $atts['class'];
	if ( ! empty( $atts['visibility'] ) ) $classes[] = $atts['visibility'];

	ob_start();

	echo '<ul class="' . esc_attr( implode( ' ', $classes ) ) . '">';
	if ( empty( $ids ) ) {
		$products = ux_list_products( $atts );
	} else {
		// Get custom ids.
		$ids = explode( ',', $ids );
		$ids = array_map( 'trim', $ids );

		$args = array(
			'post__in'            => $ids,
			'post_type'           => 'product',
			'numberposts'         => -1,
			'posts_per_page'      => -1,
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => true,
		);

		$products = new WP_Query( $args );
	}

	if ( $products->have_posts() ) : ?>

		<?php while ( $products->have_posts() ) : $products->the_post(); ?>
			<?php wc_get_template_part( 'content', 'product-small' ); ?>
		<?php endwhile; // end of the loop. ?>

		<?php
	endif;
	wp_reset_query();

	echo '</ul>';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

add_shortcode( 'ux_products_list', 'ux_products_list' );
