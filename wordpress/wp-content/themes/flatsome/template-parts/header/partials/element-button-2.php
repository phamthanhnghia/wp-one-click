<?php
/**
 * Button 2 element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.20.0
 */

?>
<li class="html header-button-2">
	<div class="header-button">
		<?php
		echo flatsome_apply_shortcode( 'button', array(
			'text'        => get_theme_mod( 'header_button_2', 'Button 2' ),
			'letter_case' => get_theme_mod( 'header_button_2_letter_case' ),
			'link'        => get_theme_mod( 'header_button_2_link' ),
			'target'      => get_theme_mod( 'header_button_2_link_target', '_self' ),
			'rel'         => get_theme_mod( 'header_button_2_link_rel' ),
			'radius'      => get_theme_mod( 'header_button_2_radius', '99px' ),
			'size'        => get_theme_mod( 'header_button_2_size' ),
			'color'       => get_theme_mod( 'header_button_2_color', 'secondary' ),
			'depth'       => get_theme_mod( 'header_button_2_depth', '0' ),
			'depth_hover' => get_theme_mod( 'header_button_2_depth_hover', '0' ),
			'style'       => get_theme_mod( 'header_button_2_style', 'outline' ),
			'icon'        => get_theme_mod( 'header_button_2_icon' ),
			'icon_pos'    => get_theme_mod( 'header_button_2_icon_position' ),
			'icon_reveal' => get_theme_mod( 'header_button_2_icon_visibility' ),
		) );
		?>
	</div>
</li>
