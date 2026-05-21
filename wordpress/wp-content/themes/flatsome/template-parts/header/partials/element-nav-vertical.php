<?php
/**
 * Header vertical menu template.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.20.0
 */

$classes_opener  = array( 'header-vertical-menu__opener' );
$classes_fly_out = array( 'header-vertical-menu__fly-out' );

if ( get_theme_mod( 'header_nav_vertical_text_color', 'dark' ) === 'dark' ) $classes_opener[]            = 'dark';
if ( get_theme_mod( 'header_nav_vertical_fly_out_text_color', 'light' ) === 'dark' ) $classes_fly_out[]  = 'dark';
if ( is_front_page() && get_theme_mod( 'header_nav_vertical_fly_out_frontpage', 1 ) ) $classes_fly_out[] = 'header-vertical-menu__fly-out--open';
if ( get_theme_mod( 'header_nav_vertical_fly_out_shadow', 1 ) ) $classes_fly_out[]                       = 'has-shadow';

$is_open = is_front_page() && get_theme_mod( 'header_nav_vertical_fly_out_frontpage', 1 );

$opener_atts = [
	'class'         => $classes_opener,
	'tabindex'      => 0,
	'role'          => 'button',
	'aria-expanded' => $is_open ? 'true' : 'false',
	'aria-haspopup' => 'menu',
];

$flyout_atts = [
	'class' => $classes_fly_out,
];
?>

<li class="header-vertical-menu">
	<div <?php echo flatsome_html_atts( $opener_atts ); ?>>
		<?php if ( get_theme_mod( 'header_nav_vertical_icon_style', 'plain' ) ) : ?>
			<span class="header-vertical-menu__icon">
				<?php echo get_flatsome_icon( 'icon-menu' ); ?>
			</span>
		<?php endif; ?>
		<span class="header-vertical-menu__title">
			<?php if ( get_theme_mod( 'header_nav_vertical_tagline' ) ) : ?>
				<span class="header-vertical-menu__tagline"><?php echo esc_html( get_theme_mod( 'header_nav_vertical_tagline' ) ); ?></span>
			<?php endif; ?>
			<?php
			if ( get_theme_mod( 'header_nav_vertical_text' ) ) :
				echo esc_html( get_theme_mod( 'header_nav_vertical_text' ) );
			else :
				esc_html_e( 'Categories', 'flatsome' );
			endif;
			?>
		</span>
		<?php echo get_flatsome_icon( 'icon-angle-down' ); ?>
	</div>
	<div <?php echo flatsome_html_atts( $flyout_atts ); ?>>
		<?php
		if ( has_nav_menu( 'vertical' ) ) {
			wp_nav_menu( array(
				'theme_location' => 'vertical',
				'menu_class'     => 'ux-nav-vertical-menu nav-vertical-fly-out',
				'walker'         => new FlatsomeNavDropdown(),
			) );
		} elseif ( current_user_can( 'edit_theme_options' ) ) {
			$admin_url = get_admin_url() . 'customize.php?url=' . get_permalink() . '&autofocus%5Bsection%5D=menu_locations';
			echo '<div class="inner-padding"><a href="' . $admin_url . '">Assign a menu in Theme Options > Menus</a></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
	</div>
</li>
