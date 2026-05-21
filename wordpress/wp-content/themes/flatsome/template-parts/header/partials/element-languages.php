<?php
/**
 * Custom Languages dropdown.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.20.0
 */

$current_lang = 'Languages';
$flag         = null;
$languages    = null;

// Polylang elseif WMPL.
if ( function_exists( 'pll_the_languages' ) ) {
	$languages = pll_the_languages( array( 'raw' => 1 ) );
	foreach ( $languages as $lang ) {
		if ( $lang['current_lang'] ) {
			$flag         = '<i class="image-icon" aria-hidden="true"><img src="' . $lang['flag'] . '" alt=""/></i>';
			$current_lang = $lang['name'];
		}
	}
} elseif ( function_exists( 'wpml_get_active_languages_filter' ) ) {
	$languages = apply_filters( 'wpml_active_languages', null );
	foreach ( $languages as $lang ) {
		if ( $lang['active'] ) {
			$flag         = '<i class="image-icon" aria-hidden="true"><img src="' . $lang['country_flag_url'] . '" alt=""/></i>';
			$current_lang = $lang['native_name'];
		}
	}
}
?>
<li class="has-dropdown header-language-dropdown">
	<a href="#" class="header-language-dropdown__link nav-top-link" aria-expanded="false" aria-controls="ux-language-dropdown" aria-haspopup="menu">
		<?php echo esc_html( $current_lang ); ?>
		<?php echo $flag; ?>
		<?php echo get_flatsome_icon( 'icon-angle-down' ); ?>
	</a>
	<ul id="ux-language-dropdown" class="nav-dropdown <?php flatsome_dropdown_classes(); ?>" role="menu">
		<?php
		// Polylang elseif WMPL.
		if ( $languages && function_exists( 'pll_the_languages' ) ) {
			foreach ( $languages as $lang ) {
				$current = $lang['current_lang'] ? 'class="active"' : '';
				echo '<li ' . $current . '><a href="' . esc_url( $lang['url'] ) . '" hreflang="' . esc_attr( $lang['slug'] ) . '" role="menuitem"><i class="icon-image" aria-hidden="true"><img src="' . esc_url( $lang['flag'] ) . '" alt=""/></i> ' . esc_html( $lang['name'] ) . '</a></li>';
			}
		} elseif ( $languages && function_exists( 'wpml_get_active_languages_filter' ) ) {
			foreach ( $languages as $lang ) {
				$current = $lang['active'] ? 'class="active"' : '';
				echo '<li ' . $current . '><a href="' . esc_url( $lang['url'] ) . '" hreflang="' . esc_attr( $lang['language_code'] ) . '" role="menuitem"><i class="icon-image" aria-hidden="true"><img src="' . esc_url( $lang['country_flag_url'] ) . '" alt=""/></i> ' . esc_html( $lang['native_name'] ) . '</a></li>';
			}
		}
		if ( ! function_exists( 'pll_the_languages' ) && ! function_exists( 'icl_get_languages' ) ) {
			echo '<li><a>You need Polylang or WPML plugin for this to work. You can remove it from Theme Options.</a></li>';
		}
		?>
	</ul>
</li>
