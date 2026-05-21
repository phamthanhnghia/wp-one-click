<?php

/**
 * Adds site status tests for Flatsome registration.
 *
 * @param array $tests An associative array of tests.
 * @return array
 */
function flatsome_site_status_tests( $tests ) {
	$tests['direct']['flatsome_registration'] = array(
		'label' => __( 'Flatsome registration', 'flatsome' ),
		'test'  => 'flatsome_site_health_registration_test',
	);

	return $tests;
}
add_filter( 'site_status_tests', 'flatsome_site_status_tests' );

/**
 * Performs the registration status test.
 *
 * @return array
 */
function flatsome_site_health_registration_test() {
	$errors = flatsome_envato()->registration->get_errors();
	$result = array(
		'test'        => 'flatsome_registration',
		'label'       => __( 'Flatsome is registered', 'flatsome' ),
		'status'      => 'good',
		'badge'       => array(
			'label' => __( 'Security', 'flatsome' ),
			'color' => 'blue',
		),
		'description' => sprintf( '<p>%s</p>', __( 'Register Flatsome to receive updates.', 'flatsome' ) ),
		'actions'     => '',
	);

	if ( ! flatsome_envato()->registration->is_registered() ) {
		$result['status']  = 'critical';
		$result['label']   = __( 'Flatsome is not registered', 'flatsome' );
		$result['actions'] = sprintf(
			'<p><a href="%s">%s</a></p>',
			esc_url( admin_url( 'admin.php?page=flatsome-panel' ) ),
			__( 'Register now', 'flatsome' )
		);
	} elseif ( ! empty( $errors ) ) {
		$result['status']      = 'critical';
		$result['label']       = __( 'Flatsome was unable to receive the latest update', 'flatsome' );
		$result['description'] = sprintf( '<p>%s</p>', implode( '</p><p>', $errors ) );
		?>
		<p>
			<a href="<?php echo esc_url_raw( admin_url( 'admin.php?page=flatsome-panel' ) ); ?>">
				<?php esc_html_e( 'Manage registration', 'flatsome' ); ?>
			</a>
		</p>
		<p>
			<a href="<?php echo esc_url_raw( UXTHEMES_ACCOUNT_URL ); ?>" target="_blank" rel="noopener">
				<?php esc_html_e( 'Manage your licenses', 'flatsome' ); ?>
			</a>
		</p>
		<?php
		$result['actions'] = ob_get_clean();
	}

	return $result;
}
