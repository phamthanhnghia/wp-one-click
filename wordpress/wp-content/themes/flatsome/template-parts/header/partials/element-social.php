<?php
/**
 * Social element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.20.0
 */

?>
<li class="html header-social-icons ml-0">
	<?php
	echo flatsome_apply_shortcode( 'follow', array(
		'style'    => get_theme_mod( 'follow_style', 'small' ),
		'tooltip'  => get_theme_mod( 'follow_tooltip', 1 ) ? 'true' : 'false',
	) );
	?>
</li>
