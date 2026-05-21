<?php

/**
 * [lightbox]
 */
function ux_lightbox( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id'         => 'enter-id-here',
		'width'      => '650px',
		'padding'    => '20px',
		'class'      => '',
		'auto_open'  => false,
		'auto_timer' => '2500',
		'auto_show'  => '',
		'version'    => '1',
	), $atts ) );

	ob_start();
	?>
	<div id="<?php echo esc_attr( $id ); ?>"
	     class="lightbox-by-id lightbox-content mfp-hide lightbox-white <?php echo esc_attr( $class ); ?>"
	     style="max-width:<?php echo esc_attr( $width ); ?> ;padding:<?php echo esc_attr( $padding ); ?>">
		<?php echo do_shortcode( $content ); ?>
	</div>
	<?php if ( $auto_open ) : ?>
		<script>
			// Auto open lightboxes
			jQuery(document).ready(function ($) {
				/* global flatsomeVars */
				'use strict'
				var cookieId = '<?php echo 'lightbox_' . esc_js( $id ); ?>'
				var cookieValue = '<?php echo 'opened_' . esc_js( $version ); ?>'
				var timer = parseInt('<?php echo intval( $auto_timer ); ?>', 10)

				// Auto open lightbox
				<?php if ( $auto_show == 'always' ) : ?>
				Flatsome.Cookies.set(cookieId, false)
				<?php endif; ?>

				// Run lightbox if no cookie is set
				if (Flatsome.Cookies.get(cookieId) !== cookieValue) {

					// Ensure closing off canvas
					setTimeout(function () {
						if (jQuery.fn.magnificPopup) jQuery.magnificPopup.close()
					}, timer - 350)

					// Open lightbox
					setTimeout(function () {
						$.loadMagnificPopup().then(function() {
							$.magnificPopup.open({
								midClick: true,
								removalDelay: 300,
								// closeBtnInside: flatsomeVars.lightbox.close_btn_inside,
								// closeMarkup: flatsomeVars.lightbox.close_markup,
								items: {
									src: '#<?php echo esc_js( $id ); ?>',
									type: 'inline'
								}
							})
						})
					}, timer)

					Flatsome.Cookies.set(cookieId, cookieValue, { expires: 365 })
				}
			})
		</script>
	<?php endif; ?>

	<?php
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

add_shortcode( 'lightbox', 'ux_lightbox' );
