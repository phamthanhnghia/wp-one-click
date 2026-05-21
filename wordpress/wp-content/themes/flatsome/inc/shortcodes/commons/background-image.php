<?php // phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
/**
 * Background image.
 *
 * @package Flatsome
 */

if ( ! empty( $atts['bg'] ) ) :
	$output = '';

	if ( ! is_numeric( $atts['bg'] ) ) {
		$image_id = attachment_url_to_postid( $atts['bg'] );
		$output   = $image_id
			? flatsome_get_attachment_image_no_srcset( $image_id, $atts['bg_size'], false, [
				'class' => "bg attachment-{$atts['bg_size']} size-{$atts['bg_size']}",
			] )
			: sprintf( '<img src="%s" class="bg" alt="" />', esc_url( $atts['bg'] ) );
	} else {
		$output = flatsome_get_attachment_image_no_srcset( $atts['bg'], $atts['bg_size'], false, [
			'class' => "bg attachment-{$atts['bg_size']} size-{$atts['bg_size']}",
		] );
	}

	if ( ! empty( $output ) ) {
		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput
	}
endif; // phpcs:enable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
