<?php
/**
 * Shop category filter button template
 *
 * @package          Flatsome/WooCommerce/Templates
 * @flatsome-version 3.20.0
 */

$layout = get_theme_mod( 'category_sidebar', 'left-sidebar' );

if ( 'none' === $layout || ( get_theme_mod( 'html_shop_page_content' ) && ! is_product_category() && ! is_product_tag() && ! is_search() ) ) {
	return;
}

$is_off_canvas_layout = 'off-canvas' === $layout;
$class                = 'show-for-medium';

if ( $is_off_canvas_layout ) {
	$class = '';
}

$custom_filter_text = get_theme_mod( 'category_filter_text' );
$filter_text        = $custom_filter_text ? $custom_filter_text : __( 'Filter', 'woocommerce' );
$overlay_position   = get_theme_mod( 'category_filter_overlay_position', 'left' );

$link_atts = [
	'href'               => '#',
	'data-open'          => '#shop-sidebar',
	'data-pos'           => $overlay_position,
	'class'              => 'filter-button uppercase plain',
	'role'               => 'button',
	'aria-controls'      => 'shop-sidebar',
	'aria-expanded'      => 'false',
	'aria-haspopup'      => 'dialog',
	'data-visible-after' => $is_off_canvas_layout ? null : 'true',
];
?>
<div class="category-filtering category-filter-row <?php echo esc_attr( $class ); ?>">
	<a <?php echo flatsome_html_atts( $link_atts ); ?>>
		<?php echo get_flatsome_icon( 'icon-equalizer' ); ?>
		<strong><?php echo esc_html( $filter_text ); ?></strong>
	</a>
	<div class="inline-block">
		<?php the_widget( 'WC_Widget_Layered_Nav_Filters', array( 'title' => '' ) ); ?>
	</div>
</div>
