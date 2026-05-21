<?php
/**
 * Transparent footer.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.19.9
 */

?>
<div class="absolute-footer fixed dark nav-dark text-center">
		<div class="footer-primary">
				<div class="copyright-footer">
					<?php if ( get_theme_mod( 'footer_left_text', 'Copyright [ux_current_year] &copy; <strong>Flatsome Theme</strong>' ) ) { echo do_shortcode( get_theme_mod( 'footer_left_text', 'Copyright [ux_current_year] &copy; <strong>Flatsome Theme</strong>' ) ); } ?>
				</div>
		</div>
</div>
