<?php
// [ux_hotspot]
function ux_hotspot( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'class'          => '',
		'visibility'     => '',
		'type'           => 'text',
		'text'           => 'Enter text here',
		'link'           => '#hotspot',
		'bg_color'       => '',
		'position_x'     => '50',
		'position_x__sm' => '',
		'position_x__md' => '',
		'position_y'     => '50',
		'position_y__sm' => '',
		'position_y__md' => '',
		'size'           => '',
		'icon'           => 'plus',
		'depth'          => '',
		'depth_hover'    => '',
		'animate'        => 'bounceIn',
		'prod_id'        => '149',
	), $atts ) );

	$classes       = array( 'hotspot-wrapper' );
	$classes_inner = array( 'hotspot tooltip' );

	if ( $class ) {
		$classes[] = $class;
	}
	if ( $visibility ) {
		$classes[] = $visibility;
	}

	// Set positions.
	$classes[] = flatsome_position_classes( 'x', $position_x, $position_x__sm, $position_x__md );
	$classes[] = flatsome_position_classes( 'y', $position_y, $position_y__sm, $position_y__md );

	// Size.
	if ( $size ) {
		$classes[] = 'is-' . $size;
	}

	$classes = implode( ' ', $classes );

	if ( $depth ) {
		$classes_inner[] = 'box-shadow-' . $depth;
	}
	if ( $depth_hover ) {
		$classes_inner[] = 'box-shadow-' . $depth . '-hover';
	}

	$classes_inner = implode( ' ', $classes_inner );

	$css_args = array(
		'bg_color' => array(
			'attribute' => 'background-color',
			'value'     => $bg_color,
		),
	);

	// load quick view script for products.
	if ( $type == 'product' && ! get_theme_mod( 'disable_quick_view' ) ) {
		wp_enqueue_script( 'wc-add-to-cart-variation' );
	}

	$icon_html = get_flatsome_icon( 'icon-' . esc_attr( $icon ) );
	?>
	<div class="<?php echo esc_attr( $classes ); ?> dark">
		<div data-animate="<?php echo esc_attr( $animate ); ?>">
			<?php
			if ( $type == 'text' ) :
				$link_atts = array(
					'href'       => esc_url( $link ),
					'class'      => esc_attr( $classes_inner ),
					'title'      => esc_attr( $text ),
					'aria-label' => esc_attr( $text ),
				);
				?>
				<a <?php echo flatsome_html_atts( $link_atts ) . ' ' . get_shortcode_inline_css( $css_args ); ?>>
					<?php echo $icon_html; // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</a>
				<?php
			elseif ( $type == 'product' ) :
				$product_title = get_the_title( $prod_id );

				if ( get_theme_mod( 'disable_quick_view' ) ) :
					$link_atts     = array(
						'href'       => esc_url( get_permalink( $prod_id ) ),
						'class'      => esc_attr( $classes_inner ),
						'title'      => esc_attr( $product_title ),
						'aria-label' => esc_attr( $product_title ),
					);
					?>
					<a <?php echo flatsome_html_atts( $link_atts ) . ' ' . get_shortcode_inline_css( $css_args ); ?>>
						<?php echo $icon_html; // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</a>
					<?php
				else :
					$link_atts     = array(
						'href'          => '#quick-view',
						'class'         => esc_attr( $classes_inner . ' quick-view' ),
						'title'         => esc_attr( $product_title ),
						'data-prod'     => esc_attr( $prod_id ),
						'role'          => 'button',
						'aria-label'    => esc_attr( $product_title ),
						'aria-expanded' => 'false',
						'aria-haspopup' => 'dialog',
					);
					?>
					<a <?php echo flatsome_html_atts( $link_atts ) . ' ' . get_shortcode_inline_css( $css_args ); ?>>
						<?php echo $icon_html; // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</a>
					<?php
				endif;
			endif;
			?>
		</div>
	</div>
	<?php
}

add_shortcode( 'ux_hotspot', 'ux_hotspot' );
