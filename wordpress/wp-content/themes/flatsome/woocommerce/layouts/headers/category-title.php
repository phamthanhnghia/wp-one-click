<?php
/**
 * Category title.
 *
 * @package          Flatsome/WooCommerce/Templates
 * @flatsome-version 3.18.4
 */

$classes = [
	'shop-page-title',
	'category-page-title',
	'page-title',
	flatsome_header_title_classes( false ),
];

if ( get_theme_mod( 'content_color' ) === 'dark' ) {
	$classes[] = 'dark';
}
?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="page-title-inner flex-row  medium-flex-wrap container">
		<div class="flex-col flex-grow medium-text-center">
			<?php do_action( 'flatsome_category_title' ); ?>
		</div>
		<div class="flex-col medium-text-center">
			<?php do_action( 'flatsome_category_title_alt' ); ?>
		</div>
	</div>
</div>
