<?php

add_action( 'admin_notices', 'flatsome_status_check_admin_notice' );
add_action( 'admin_notices', 'flatsome_maintenance_admin_notice' );

function flatsome_maintenance_admin_notice() {
	$screen       = get_current_screen();
	$advanced_url = get_admin_url() . 'admin.php?page=optionsframework&tab=';
	$errors       = flatsome_envato()->registration->get_errors();

	if ( get_theme_mod( 'maintenance_mode', 0 ) && get_theme_mod( 'maintenance_mode_admin_notice', 1 ) ) {
		?>
		<div class="notice notice-info">
				<p><?php echo sprintf( __( 'Flatsome Maintenance Mode is <strong>active</strong>. Please don\'t forget to <a href="%s">deactivate</a> it as soon as you are done.', 'flatsome-admin' ), $advanced_url . 'of-option-maintenancemode' ); ?></p>
		</div>
		<?php
	}

	if ( in_array( $screen->id, array( 'update-core', 'update-core-network' ), true ) && ! flatsome_envato()->registration->is_registered() ) {
		?>
		<div class="updated"><p><?php echo sprintf( __( '<a href="%s">Please enter your purchase code</a> to activate Flatsome and get one-click updates.', 'flatsome' ), esc_url_raw( network_admin_url( 'admin.php?page=flatsome-panel' ) ) ); ?></p></div>
		<?php
	}

	if (
		count( $errors ) &&
		flatsome_envato()->registration->get_option( 'show_notice' ) &&
		$screen->id !== 'toplevel_page_flatsome-panel'
	) {
		?>
		<div id="flatsome-notice" class="notice notice-warning notice-alt is-dismissible">
			<h3 class="notice-title"><?php esc_html_e( 'Flatsome issues', 'flatsome' ); ?></h3>
			<?php foreach ( $errors as $error ) : ?>
				<?php echo wpautop( $error ); ?>
			<?php endforeach; ?>
			<p>
				<a href="<?php echo esc_url_raw( admin_url( 'admin.php?page=flatsome-panel' ) ); ?>">
					<?php esc_html_e( 'Manage registration', 'flatsome' ); ?>
				</a>
			</p>
			<p>
				<a href="<?php echo esc_url_raw( UXTHEMES_ACCOUNT_URL ); ?>" target="_blank" rel="noopener">
					<?php esc_html_e( 'Manage your licenses', 'flatsome' ); ?>
					<span class="dashicons dashicons-external" style="vertical-align:middle;font-size:18px;text-decoration: none;"></span>
				</a>
			</p>
			<script>
				jQuery(function($){
					$('#flatsome-notice').on('click', '.notice-dismiss', function(){
						$.post('<?php echo admin_url( 'admin-ajax.php?action=flatsome_registration_dismiss_notice' ) ?>');
					});
				});
			</script>
		</div>
		<?php
	}
}

/**
 * Outdated template files notice.
 *
 * @return void
 */
function flatsome_status_check_admin_notice() {
	if ( ! is_child_theme() ) return;
	if ( in_array( get_current_screen()->id, array( 'dashboard', 'themes', 'theme-editor', 'update-core', 'update-core-network', 'site-health' ), true )
		&& Flatsome\Admin\status()->has_outdated_template() ) {
		?>
		<div class="notice notice-info">
			<h3>
				<svg width="20" height="20" viewBox="0 0 438 438" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-top: -3px; vertical-align: middle">
					<path d="M218.505 437.013V375.737L169.875 327.108L218.505 278.476V217.2L139.236 296.471L61.2764 218.51L218.505 61.2804V0.00683594L0 218.51L218.505 437.013Z" fill="black"></path>
					<path opacity="0.5" d="M218.507 61.2759L375.735 218.505L297.776 296.464L218.507 217.198V278.472L267.139 327.103L218.507 375.732V437.006L328.413 327.103L437.012 218.505L218.507 0V61.2759Z" fill="black"></path>
				</svg>
				<?php esc_html_e( 'Flatsome', 'flatsome' ); ?>
			</h3>
			<p>
				<?php /* translators: %1$s: Theme name, %2$s: The URL to the status page. */ ?>
				<?php echo sprintf( __( '<strong>Your theme (%1$s) contains outdated copies of some Flatsome template files.</strong> These files may need updating to ensure they are compatible with the current version of Flatsome. Suggestions:', 'flatsome' ), esc_html( wp_get_theme()->name ) ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>
			</p>
			<ol>
				<li><?php esc_html_e( 'If you copied over a template file to change something, then you will need to copy the new version of the template and apply your changes again.', 'flatsome' ); ?></li>
				<li><?php esc_html_e( 'If you are unfamiliar with code/templates and resolving potential conflicts, reach out to a developer for assistance.', 'flatsome' ); ?></li>
			</ol>
			<p class="submit">
				<a class="button button-large" href="https://docs.uxthemes.com/article/414-system-status#templates" target="_blank" rel="noopener"><?php esc_html_e( 'Learn more about templates', 'flatsome' ); ?>
					<span style="font-size:16px;width:auto;vertical-align:middle;" class="dashicons dashicons-external"></span>
				</a>
				<a class="button button-large button-primary" href="<?php echo esc_url_raw( network_admin_url( 'admin.php?page=flatsome-panel-status#templates' ) ); ?>"><?php esc_html_e( 'View affected templates', 'flatsome' ); ?></a>
			</p>
		</div>
		<?php
	}
}
