<?php
/**
 * Product filter button.
 *
 * @package          Flatsome/WooCommerce/Templates
 * @flatsome-version 3.20.0
 */

$custom_filter_text = get_theme_mod( 'category_filter_text' );
$filter_text        = $custom_filter_text ? $custom_filter_text : __( 'Filter', 'woocommerce' );
$sidebar_position   = get_theme_mod( 'product_offcanvas_sidebar_position', 'left' );

$link_atts = [
	'href'          => '#product-sidebar',
	'data-open'     => '#product-sidebar',
	'data-pos'      => $sidebar_position,
	'class'         => 'filter-button uppercase plain',
	'role'          => 'button',
	'aria-expanded' => 'false',
	'aria-haspopup' => 'dialog',
	'aria-controls' => 'product-sidebar',
];
?>
<div class="category-filtering container text-center product-filter-row show-for-medium">
	<a <?php echo flatsome_html_atts( $link_atts ); ?>>
		<?php echo get_flatsome_icon( 'icon-equalizer' ); ?>
		<strong><?php echo esc_html( $filter_text ); ?></strong>
	</a>
</div>
