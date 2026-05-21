<?php

// Options for resetting Customizer

if ( ! class_exists( 'Flatsome_Customizer_Reset' ) ) {
  final class Flatsome_Customizer_Reset {
    /**
     * @var Flatsome_Customizer_Reset
     */
    private static $instance = null;

    /**
     * @var WP_Customize_Manager
     */
    private $wp_customize;

    public static function get_instance() {
      if ( null === self::$instance ) {
        self::$instance = new self();
      }

      return self::$instance;
    }

    private function __construct() {
      add_action( 'customize_controls_print_scripts', array( $this, 'customize_controls_print_scripts' ) );
      add_action( 'wp_ajax_customizer_reset', array( $this, 'ajax_customizer_reset' ) );
      add_action( 'wp_ajax_customizer_clear_typography_cache', array( $this, 'ajax_customizer_clear_typography_cache' ) );
      add_action( 'customize_register', array( $this, 'customize_register' ) );
    }

    public function customize_controls_print_scripts() {
      $uri     = get_template_directory_uri();
      $theme   = wp_get_theme( get_template() );
      $version = $theme->get( 'Version' );

      wp_enqueue_script( 'flatsome-customizer-reset', $uri . '/inc/admin/customizer/js/customizer-reset.js', array(), $version, true );
      wp_localize_script( 'flatsome-customizer-reset', '_FlatsomeCustomizerReset', array(
        'reset'   => __( 'Reset', 'flatsome-admin' ),
        'confirm' => __( "Attention! This will remove all customizations ever made via customizer to this theme!\n\nThis action is irreversible!", 'flatsome-admin' ),
        'nonce'   => array(
          'reset' => wp_create_nonce( 'customizer-reset' ),
        )
      ) );
    }

    /**
     * Store a reference to `WP_Customize_Manager` instance
     *
     * @param $wp_customize
     */
    public function customize_register( $wp_customize ) {
      $this->wp_customize = $wp_customize;
    }

    public function ajax_customizer_reset() {
      if ( ! $this->wp_customize->is_preview() ) {
        wp_send_json_error( 'not_preview' );
      }

      if ( ! check_ajax_referer( 'customizer-reset', 'nonce', false ) ) {
        wp_send_json_error( 'invalid_nonce' );
      }

      $this->reset_customizer();

      wp_send_json_success();
    }

	  public function ajax_customizer_clear_typography_cache() {
		  if ( ! $this->wp_customize->is_preview() ) {
			  wp_send_json_error( 'not_preview' );
		  }
		  if ( ! check_ajax_referer( 'customizer-reset', 'nonce', false ) ) {
		    wp_send_json_error( 'invalid_nonce' );
		  }
		  $this->clear_typography_cache();
	  }

	  public function clear_typography_cache() {
		  try {
			  $fonts_dir = flatsome_get_fonts_dir();

			  delete_transient( 'kirki_remote_url_contents' );
			  delete_option( 'kirki_downloaded_font_files' );

			  global $wp_filesystem;
			  if ( ! $wp_filesystem ) {
				  if ( ! function_exists( 'WP_Filesystem' ) ) {
					  require_once wp_normalize_path( ABSPATH . '/wp-admin/includes/file.php' );
				  }
				  WP_Filesystem();
			  }

			  if ( $wp_filesystem instanceof WP_Filesystem_Base && $wp_filesystem->exists( $fonts_dir ) ) {
				  foreach ( $wp_filesystem->dirlist( $fonts_dir ) as $file ) {
					  if ( $wp_filesystem->is_dir( $fonts_dir . '/' . $file['name'] ) ) {
						  $wp_filesystem->rmdir( $fonts_dir . '/' . $file['name'], true );
					  }
				  }
			  }
		  } catch ( Exception $e ) {
			  wp_send_json_error( $e->getMessage() );
		  }

		  wp_send_json_success();
	  }

    public function reset_customizer() {
      $settings = $this->wp_customize->settings();

      // remove theme_mod settings registered in customizer
      foreach ( $settings as $setting ) {
        if ( 'theme_mod' == $setting->type ) {
          remove_theme_mod( $setting->id );
        }
      }
    }
  }
}

Flatsome_Customizer_Reset::get_instance();
