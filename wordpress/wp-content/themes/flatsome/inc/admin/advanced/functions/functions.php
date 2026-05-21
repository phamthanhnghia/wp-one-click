<?php

/**
 * Retrieve a list or WP roles
 *
 * @param array|string $args Optional. Array or string of arguments.
 *
 * @return array List of roles matching defaults or `$args`.
 */
function flatsome_get_role_list( $args = '' ) {
	require_once ABSPATH . 'wp-admin/includes/user.php';

	$defaults = [
		'exclude' => array(),
	];

	$parsed_args = wp_parse_args( $args, $defaults );

	$roles  = [];
	$_roles = get_editable_roles();

	$_roles = is_multisite()
		? array( 'super_admin' => array( 'name' => esc_html__( 'Super Admin', 'flatsome' ) ) ) + $_roles
		: $_roles;

	foreach ( $_roles as $_roles_slug => $_roles_data ) {
		if ( in_array( $_roles_slug, $parsed_args['exclude'], true ) ) {
			continue;
		}

		$roles[ $_roles_slug ] = $_roles_data['name'];
	}

	return $roles;
}
