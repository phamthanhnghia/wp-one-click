<?php
/**
 * Shortcode button.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.20.0
 */

?>
<<?php echo tag_escape( $as ); ?> <?php echo $attributes; ?> <?php echo $styles; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<?php echo $icon_left; // phpcs:ignore WordPress.Security.EscapeOutput ?>
	<span><?php echo wp_kses_post( $text ); ?></span>
	<?php echo $icon_right; // phpcs:ignore WordPress.Security.EscapeOutput ?>
</<?php echo tag_escape( $as ); ?>>
