<?php

/**
 * Maintenance mode.
 *
 * @return void
 */
function flatsome_maintenance_mode() {
	// Exit if not active.
	if ( ! get_theme_mod( 'maintenance_mode', 0 ) ) {
		return;
	}

	global $pagenow;

	nocache_headers();

	if ( $pagenow === 'wp-login.php' || is_admin() ) {
		return;
	}

	$maintenance_mode_bypass_key = get_theme_mod( 'maintenance_mode_bypass_key' );
	$has_access_by_key           = ! empty( $maintenance_mode_bypass_key ) && isset( $_GET[ $maintenance_mode_bypass_key ] ); // phpcs:ignore WordPress.Security.NonceVerification

	if ( $has_access_by_key ) {
		return;
	}

	$args = apply_filters( 'flatsome_maintenance_mode', [
		'access_mode' => 'roles',
	] );

	switch ( $args['access_mode'] ) {
		case 'current_user_can':
			if ( current_user_can( ! empty( $args['capability'] ) ? $args['capability'] : 'manage_options' ) ) {
				return;
			}
			break;

		case 'logged_in':
			if ( is_user_logged_in() ) {
				return;
			}
			break;

		case 'roles':
			$user       = wp_get_current_user();
			$user_roles = $user->roles;

			if ( is_multisite() && is_super_admin() ) {
				$user_roles[] = 'super_admin';
			}

			$exclude_roles = array_keys(
				array_filter(
					get_theme_mod( 'maintenance_mode_excluded_roles', [] ),
					function ( $value ) {
						return ! empty( $value );
					}
				)
			);

			// Super admin and administrator roles should always be excluded.
			$exclude_roles[] = 'super_admin';
			$exclude_roles[] = 'administrator';

			$compare_roles = array_intersect( $user_roles, $exclude_roles );

			if ( ! empty( $compare_roles ) ) {
				return;
			}
			break;

		default:
			break;
	}

	// Enter maintenance mode.
	add_filter( 'body_class', function ( $classes ) {
		$classes[] = 'ux-maintenance-mode';

		return $classes;
	} );

	// Remove unnecessary templates.
	remove_action( 'wp_footer', 'woocommerce_demo_store' );
	remove_action( 'wp_footer', 'flatsome_cookie_notice_template' );

	// Clear Cachify Cache.
	if ( has_action( 'cachify_flush_cache' ) ) {
		do_action( 'cachify_flush_cache' );
	}

	// Clear Super Cache.
	if ( function_exists( 'wp_cache_clear_cache' ) ) {
		ob_end_clean();
		wp_cache_clear_cache();
	}

	// Clear W3 Total Cache.
	if ( function_exists( 'w3tc_pgcache_flush' ) ) {
		ob_end_clean();
		w3tc_pgcache_flush();
	}

	$protocol = wp_get_server_protocol();
	header( "$protocol 503 Service Unavailable", true, 503 );
	header( 'Content-Type: text/html; charset=utf-8' );
	header( 'Retry-After: 600' );

	get_template_part( 'maintenance' );
	die();
}

add_action( 'template_redirect', 'flatsome_maintenance_mode' );
