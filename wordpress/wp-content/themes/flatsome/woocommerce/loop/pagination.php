<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see              https://woocommerce.com/document/template-structure/
 * @package          WooCommerce\Templates
 * @version          9.3.0
 * @flatsome-version 3.20.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}
?>
<div class="container">
	<nav class="woocommerce-pagination" aria-label="<?php esc_attr_e( 'Product Pagination', 'woocommerce' ); ?>">
		<?php
		$pages = paginate_links(
			apply_filters( 'woocommerce_pagination_args',
				array( // WPCS: XSS ok.
					'base'      => $base,
					'format'    => $format,
					'add_args'  => false,
					'current'   => max( 1, $current ),
					'total'     => $total,
					'prev_text' => get_flatsome_icon( 'icon-angle-left' ),
					'next_text' => get_flatsome_icon( 'icon-angle-right' ),
					'type'      => 'array',
					'end_size'  => 3,
					'mid_size'  => 3,
				)
			)
		);

		if ( is_array( $pages ) ) {
			$paged = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
			echo '<ul class="page-numbers nav-pagination links text-center">';
			foreach ( $pages as $page ) {
				$page = str_replace( 'page-numbers', 'page-number', $page );
				$page = str_replace( '<a class="next page-number', '<a aria-label="' . esc_attr__( 'Next', 'flatsome' ) . '" class="next page-number', $page );
				$page = str_replace( '<a class="prev page-number', '<a aria-label="' . esc_attr__( 'Previous', 'flatsome' ) . '" class="prev page-number', $page );
				echo '<li>' . $page . '</li>';
			}
			echo '</ul>';
		}
		?>
	</nav>
</div>
