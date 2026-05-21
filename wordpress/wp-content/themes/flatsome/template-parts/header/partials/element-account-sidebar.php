<?php
/**
 * Account sidebar element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.19.7
 */

if ( ! is_woocommerce_activated() ) {
	fl_header_element_error( 'woocommerce' );

	return;
}
?>

<li class="account-item has-icon menu-item">
	<?php
	if ( is_user_logged_in() ) :
		$link_atts = [
			'href'  => esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
			'class' => [ 'account-link', 'account-login' ],
			'title' => esc_attr__( 'My account', 'woocommerce' ),
		];
		?>
		<a <?php echo flatsome_html_atts( $link_atts ); ?>>
			<span class="header-account-title">
				<?php esc_html_e( 'My account', 'woocommerce' ); ?>
			</span>
		</a>
		<?php
	else :
		$link_atts = [
			'href'  => esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
			'class' => [ 'nav-top-link', 'nav-top-not-logged-in' ],
			'title' => esc_attr__( 'Login', 'woocommerce' ),
		];
		?>
		<a <?php echo flatsome_html_atts( $link_atts ); ?>>
			<span class="header-account-title">
				<?php
				esc_html_e( 'Login', 'woocommerce' );
				if ( get_theme_mod( 'header_account_register' ) ) :
					echo ' / ' . esc_html__( 'Register', 'woocommerce' );
				endif;
				?>
			</span>
		</a>
	<?php endif; ?>

	<?php
	// Show Dropdown for logged in users.
	if ( is_user_logged_in() ) :
		?>
		<ul class="children">
			<?php wc_get_template( 'myaccount/account-links.php' ); ?>
		</ul>
	<?php endif; ?>
</li>
