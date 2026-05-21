<?php
/**
 * Product small content.
 *
 * @package          Flatsome/WooCommerce/Templates
 * @flatsome-version 3.19.0
 */

global $product;

$rating_count = $product->get_rating_count();
?>
<li>
	<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<?php echo $product->get_image( 'woocommerce_gallery_thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		<span class="product-title"><?php echo $product->get_title(); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
	</a>
	<?php if ( wc_review_ratings_enabled() && $rating_count > 0 ) echo wc_get_rating_html( $product->get_average_rating(), $rating_count ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	<?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
</li>
