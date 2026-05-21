<?php
/**
 * Menu icon element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.20.0
 */

$icon_style = get_theme_mod( 'menu_icon_style', '' );
$link_atts  = [
	'href'          => '#',
	'class'         => get_flatsome_icon_class( $icon_style, 'small' ),
	'data-open'     => '#main-menu',
	'data-pos'      => get_theme_mod( 'mobile_overlay', 'left' ),
	'data-bg'       => 'main-menu-overlay',
	'data-color'    => get_theme_mod( 'mobile_overlay_color', '' ),
	'role'          => 'button',
	'aria-label'    => esc_attr__( 'Menu', 'flatsome' ),
	'aria-controls' => 'main-menu',
	'aria-expanded' => 'false',
	'aria-haspopup' => 'dialog',
];
?>
<li class="nav-icon has-icon">
	<?php if ( $icon_style ) { ?><div class="header-button"><?php } ?>
		<a <?php echo flatsome_html_atts( $link_atts ); ?>>
			<?php echo get_flatsome_icon( 'icon-menu' ); ?>
			<?php if ( get_theme_mod( 'menu_icon_title', 0 ) ) echo '<span class="menu-title uppercase hide-for-small">' . esc_html__( 'Menu', 'flatsome' ) . '</span>'; ?>
		</a>
	<?php if ( $icon_style ) { ?> </div> <?php } ?>
</li>
