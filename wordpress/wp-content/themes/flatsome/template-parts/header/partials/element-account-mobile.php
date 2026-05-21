<?php
/**
 * Mobile account element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.19.0
 */

if ( ! is_woocommerce_activated() ) {
	return;
}

$icon_style = get_theme_mod( 'account_icon_style' );
$is_button  = $icon_style && $icon_style !== 'image' && $icon_style !== 'plain';

$link_atts = [
	'href'       => esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
	'class'      => [ 'account-link-mobile', get_flatsome_icon_class( $icon_style, 'small' ) ],
	'title'      => esc_attr__( 'My account', 'woocommerce' ),
	'aria-label' => esc_attr__( 'My account', 'woocommerce' ),
];
?>

<li class="account-item has-icon">
	<?php if ( $is_button ) echo '<div class="header-button">'; ?>
	<a <?php echo flatsome_html_atts( $link_atts ); ?>>
		<?php echo get_flatsome_icon( 'icon-user' ); ?>
	</a>
	<?php if ( $is_button ) echo '</div>'; ?>
</li>
