<?php
/**
 * Mini cart cross-sells.
 *
 * @package          Flatsome/WooCommerce/Templates
 * @flatsome-version 3.18.0
 */

?>

<?php do_action( 'flatsome_before_mini_cart_cross_sells' ); ?>

<?php if ( $cross_sells ) : ?>
	<div class="ux-mini-cart-cross-sells ux-mini-cart-widget">
		<p class="ux-mini-cart-cross-sells__title text-center"><?php esc_html_e( 'You may be interested in&hellip;', 'woocommerce' ); ?></p>
		<ul class="ux-mini-cart-cross-sells__list product_list_widget">
			<?php
			$original_post = $GLOBALS['post'];
			foreach ( $cross_sells as $product ) {
				$GLOBALS['post'] = get_post( $product->get_id() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				setup_postdata( $GLOBALS['post'] );
				?>
				<li class="ux-mini-cart-cross-sells__list-item">
					<?php woocommerce_template_loop_add_to_cart(); ?>
					<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
						<?php echo $product->get_image( 'woocommerce_gallery_thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span class="product-title"><?php echo $product->get_title(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					</a>
					<div class="price-wrapper">
						<?php woocommerce_template_loop_rating(); ?>
						<?php woocommerce_template_loop_price(); ?>
					</div>
				</li>
				<?php
				$GLOBALS['post'] = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			}
			?>
		</ul>
	</div>
<?php endif; ?>

<?php do_action( 'flatsome_after_mini_cart_cross_sells' ); ?>
