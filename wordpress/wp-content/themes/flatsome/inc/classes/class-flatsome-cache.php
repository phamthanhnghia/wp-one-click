<?php
/**
 * Flatsome_Cache class.
 *
 * @package Flatsome
 */

defined( 'ABSPATH' ) || exit;

/**
 * The Flatsome Cache.
 */
final class Flatsome_Cache {

	/**
	 * Purge caches.
	 *
	 * Note: The theme is not responsible for clearing 3rd party cache. Clearing 3rd party caches is mainly
	 * to prevent issues for who don't clear their caches properly. Please contact your hosting provider or
	 * cache plugin support if you experience caching issues.
	 *
	 * Warning: The list of supported caches may change or be added to in the future. Do not rely
	 * on or use this functionality outside of Flatsome core code.
	 *
	 * @param array $caches An array of caches to delete.
	 */
	public static function clear( array $caches = [] ): void {
		$default_caches = [ 'third_party' => false ];

		$caches = wp_parse_args( $caches, $default_caches );
		$caches = apply_filters( 'flatsome_cache_clear_items', $caches );

		// Exit if all are false.
		if ( ! in_array( true, $caches, true ) ) {
			return;
		}

		try {
			if ( $caches['third_party'] ) {
				self::clear_third_party();
			}
		} catch ( Throwable $e ) {
			error_log( $e->getMessage() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions
		}
	}

	/**
	 * Clear third party caches.
	 */
	private static function clear_third_party(): void {
		self::clear_w3_total_cache();
		self::clear_wp_cache();
		self::clear_wp_fastest_cache();
		self::clear_cachify();
		self::clear_comet_cache();
		self::clear_zencache();
		self::clear_litespeed_cache();
		self::clear_siteground_cache();
		self::clear_wp_optimize();
		self::clear_godaddy_cache();
		self::clear_wp_engine_cache();
		self::clear_wp_rocket();
		self::clear_wp_super_cache();
		self::clear_autoptimize();
		self::clear_fast_velocity_minify();
		self::clear_hummingbird();
		self::clear_swift_performance();
		self::clear_shortpixel();
		self::clear_perfmatters();
		self::clear_breeze();
		self::clear_varnish_cache();
	}

	/**
	 * Clear W3 Total Cache
	 */
	private static function clear_w3_total_cache(): void {
		if ( function_exists( 'w3tc_pgcache_flush' ) ) {
			w3tc_pgcache_flush();
		}

		if ( function_exists( 'w3tc_flush_all' ) ) {
			w3tc_flush_all();
		}
	}

	/**
	 * Clear WordPress default cache
	 */
	private static function clear_wp_cache(): void {
		if ( function_exists( 'wp_cache_flush' ) ) {
			wp_cache_flush();
		}
	}

	/**
	 * Clear WP Fastest Cache
	 */
	private static function clear_wp_fastest_cache(): void {
		if (
			isset( $GLOBALS['wp_fastest_cache'] )
			&& method_exists( $GLOBALS['wp_fastest_cache'], 'deleteCache' )
		) {
			$GLOBALS['wp_fastest_cache']->deleteCache();
			$GLOBALS['wp_fastest_cache']->deleteCache( true );
		}
	}

	/**
	 * Clear Cachify
	 */
	private static function clear_cachify(): void {
		if ( function_exists( 'cachify_flush_cache' ) ) {
			cachify_flush_cache();
		}
	}

	/**
	 * Clear Comet Cache
	 */
	private static function clear_comet_cache(): void {
		if (
			class_exists( 'comet_cache' )
			&& method_exists( 'comet_cache', 'clear' )
		) {
			comet_cache::clear();
		}
	}

	/**
	 * Clear ZenCache
	 */
	private static function clear_zencache(): void {
		if (
			class_exists( 'zencache' )
			&& method_exists( 'zencache', 'clear' )
		) {
			zencache::clear();
		}
	}

	/**
	 * Clear LiteSpeed Cache
	 */
	private static function clear_litespeed_cache(): void {
		if (
			class_exists( 'LiteSpeed_Cache_Tags' )
			&& method_exists( 'LiteSpeed_Cache_Tags', 'add_purge_tag' )
		) {
			LiteSpeed_Cache_Tags::add_purge_tag( '*' );
		}
	}

	/**
	 * Clear SiteGround Cache
	 */
	private static function clear_siteground_cache(): void {
		if ( function_exists( 'sg_cachepress_purge_cache' ) ) {
			sg_cachepress_purge_cache();
		}

		if ( function_exists( 'sg_cachepress_purge_everything' ) ) {
			sg_cachepress_purge_everything();
		}

		if (
			class_exists( 'SG_CachePress_Supercacher' )
			&& method_exists( 'SG_CachePress_Supercacher', 'purge_cache' )
		) {
			SG_CachePress_Supercacher::purge_cache();
		}

		if (
			class_exists( 'LiteSpeed_Cache_Purge' )
			&& method_exists( 'LiteSpeed_Cache_Purge', 'purge_all' )
		) {
			LiteSpeed_Cache_Purge::purge_all( 'Clear Cache For Me' );
		}
	}

	/**
	 * Clear WP Optimize
	 */
	private static function clear_wp_optimize(): void {
		if (
			class_exists( 'WP_Optimize' )
			&& defined( 'WPO_PLUGIN_MAIN_PATH' )
		) {
			ob_start();
			if ( ! class_exists( 'WP_Optimize_Cache_Commands' ) ) include_once WPO_PLUGIN_MAIN_PATH . 'cache/class-cache-commands.php';
			if ( ! class_exists( 'WP_Optimize_Minify_Commands' ) ) include_once WPO_PLUGIN_MAIN_PATH . 'minify/class-wp-optimize-minify-commands.php';
			if ( ! class_exists( 'WP_Optimize_Minify_Cache_Functions' ) ) include_once WPO_PLUGIN_MAIN_PATH . 'minify/class-wp-optimize-minify-cache-functions.php';

			if (
				class_exists( 'WP_Optimize_Cache_Commands' )
				&& method_exists( 'WP_Optimize_Cache_Commands', 'purge_page_cache' )
			) {
				$wpoptimize_cache_commands = new WP_Optimize_Cache_Commands();
				$wpoptimize_cache_commands->purge_page_cache();
			}

			if (
				class_exists( 'WP_Optimize_Minify_Commands' )
				&& method_exists( 'WP_Optimize_Minify_Commands', 'purge_minify_cache' )
			) {
				$wpoptimize_minify_commands = new WP_Optimize_Minify_Commands();
				$wpoptimize_minify_commands->purge_minify_cache();
			}
			ob_get_clean();
		}
	}

	/**
	 * Clear GoDaddy Hosting Cache
	 */
	private static function clear_godaddy_cache(): void {
		if (
			class_exists( 'WPaaS\Plugin' )
			&& function_exists( 'fastvelocity_godaddy_request' )
		) {
			fastvelocity_godaddy_request( 'BAN' );
		}
	}

	/**
	 * Clear WP Engine Cache
	 */
	private static function clear_wp_engine_cache(): void {
		if ( class_exists( 'WpeCommon' ) ) {
			if ( method_exists( 'WpeCommon', 'purge_memcached' ) ) {
				WpeCommon::purge_memcached();
			}

			if ( method_exists( 'WpeCommon', 'clear_maxcdn_cache' ) ) {
				WpeCommon::clear_maxcdn_cache();
			}

			if ( method_exists( 'WpeCommon', 'purge_varnish_cache' ) ) {
				WpeCommon::purge_varnish_cache();
			}
		}
	}

	/**
	 * Clear WP Rocket
	 */
	private static function clear_wp_rocket(): void {
		if ( function_exists( 'rocket_clean_domain' ) ) {
			rocket_clean_domain();

			$container = apply_filters( 'rocket_container', null );

			if ( $container ) {
				$rucss_admin_subscriber = $container->get( 'rucss_admin_subscriber' );

				if (
					$rucss_admin_subscriber
					&& method_exists( $rucss_admin_subscriber, 'truncate_used_css' )
				) {
					$rucss_admin_subscriber->truncate_used_css();
				}
			}
		}

		if ( function_exists( 'rocket_clean_minify' ) ) {
			rocket_clean_minify();
		}
	}

	/**
	 * Clear WP Super Cache
	 */
	private static function clear_wp_super_cache(): void {
		if ( function_exists( 'wp_cache_clean_cache' ) ) {
			wp_cache_clean_cache();
		}
	}

	/**
	 * Clear Autoptimize
	 */
	private static function clear_autoptimize(): void {
		if (
			class_exists( 'autoptimizeCache' )
			&& method_exists( 'autoptimizeCache', 'clearall' )
		) {
			autoptimizeCache::clearall();
		}
	}

	/**
	 * Clear Fast Velocity Minify
	 */
	private static function clear_fast_velocity_minify(): void {
		if ( function_exists( 'fvm_purge_all' ) ) {
			fvm_purge_all();
		}

		if ( function_exists( 'fastvelocity_purge_others' ) ) {
			fastvelocity_purge_others();
		}
	}

	/**
	 * Clear Hummingbird Performance
	 */
	private static function clear_hummingbird(): void {
		if ( has_action( 'wphb_clear_page_cache' ) ) {
			do_action( 'wphb_clear_page_cache' );
		}
	}

	/**
	 * Clear Swift Performance
	 */
	private static function clear_swift_performance(): void {
		if (
			class_exists( 'Swift_Performance_Cache' )
			&& method_exists( 'Swift_Performance_Cache', 'clear_all_cache' )
		) {
			Swift_Performance_Cache::clear_all_cache();
		}
	}

	/**
	 * Clear ShortPixel AI
	 */
	private static function clear_shortpixel(): void {
		if (
			class_exists( 'ShortPixelAI' )
			&& method_exists( 'ShortPixelAI', 'clear_css_cache' )
		) {
			ShortPixelAI::clear_css_cache();
		}
	}

	/**
	 * Clear Perfmatters
	 */
	private static function clear_perfmatters(): void {
		if (
			class_exists( 'Perfmatters\CSS' )
			&& method_exists( 'Perfmatters\CSS', 'clear_used_css' )
		) {
			Perfmatters\CSS::clear_used_css();
		}
	}

	/**
	 * Clear Breeze Cache
	 */
	private static function clear_breeze(): void {
		if ( has_action( 'breeze_clear_all_cache' ) ) {
			do_action( 'breeze_clear_all_cache' );
		}
	}

	/**
	 * Clear varnish cache for the dynamic files.
	 * Credit @davidbarratt: https://github.com/davidbarratt/varnish-http-purge
	 */
	private static function clear_varnish_cache(): void {
		// Early bail if Varnish cache is not enabled on the site.
		if ( ! isset( $_SERVER['HTTP_X_VARNISH'] ) ) {
			return;
		}

		// Parse the URL for proxy proxies.
		$parsed_url = wp_parse_url( home_url() );

		// Build a varniship.
		$varniship = get_option( 'vhp_varnish_ip' );
		if ( defined( 'VHP_VARNISH_IP' ) && false !== VHP_VARNISH_IP ) {
			$varniship = VHP_VARNISH_IP;
		}

		// If we made varniship, let it sail.
		$purgeme = ( isset( $varniship ) && null !== $varniship ) ? $varniship : $parsed_url['host'];
		wp_remote_request(
			$parsed_url['scheme'] . '://' . $purgeme,
			[
				'method'   => 'PURGE',
				'blocking' => false,
				'headers'  => [
					'host'           => $parsed_url['host'],
					'X-Purge-Method' => 'default',
				],
			]
		);
	}
}
