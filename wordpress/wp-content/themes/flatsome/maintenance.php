<?php
/**
 * Maintenance template.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.19.9
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php flatsome_html_classes(); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'flatsome_after_body_open' ); ?>
<?php wp_body_open(); ?>

<div id="wrapper">
	<main id="main" class="<?php flatsome_main_classes(); ?>">
		<?php
		if ( get_theme_mod( 'maintenance_mode_page', 0 ) ) {
			$post = get_post( get_theme_mod( 'maintenance_mode_page', 0 ) );
			echo do_shortcode( $post->post_content );
		} else {
			$logo_url = do_shortcode( get_theme_mod( 'site_logo', get_template_directory_uri() . '/assets/img/logo.png' ) );
			echo do_shortcode( '[ux_banner bg_color="#fff" bg_overlay="rgba(255,255,255,.9)" height="100%"] [text_box animate="fadeInUp" text_color="dark"] [ux_image id="' . $logo_url . '" width="70%"] [divider] <p class="lead">' . get_theme_mod( 'maintenance_mode_text', 'Please check back soon..' ) . '</p> [/text_box] [/ux_banner]' );
		}
		?>
	</main>
</div>
<?php wp_footer(); ?>
</body>
</html>
