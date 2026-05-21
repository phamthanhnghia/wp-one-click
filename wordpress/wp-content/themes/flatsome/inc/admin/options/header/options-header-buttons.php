<?php

Flatsome_Option::add_section( 'header_buttons',
	array(
		'title' => __( 'Buttons', 'flatsome-admin' ),
		'panel' => 'header',
	)
);

Flatsome_Option::add_field( '',
	array(
		'type'     => 'custom',
		'settings' => 'custom_title_button_1',
		'label'    => __( '', 'flatsome-admin' ),
		'section'  => 'header_buttons',
		'default'  => '<div class="options-title-divider">Button 1</div>',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'text',
		'settings'  => 'header_button_1',
		'transport' => flatsome_customizer_transport(),
		'default'   => 'Button 1',
		'label'     => __( 'Text', 'flatsome-admin' ),
		'section'   => 'header_buttons',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'header_button_1_letter_case',
		'transport' => flatsome_customizer_transport(),
		'label'     => __( 'Letter case', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'default'   => '',
		'choices'   => array(
			''          => __( 'ABC', 'flatsome-admin' ),
			'lowercase' => __( 'Abc', 'flatsome-admin' ),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'        => 'text',
		'settings'    => 'header_button_1_link',
		'transport'   => flatsome_customizer_transport(),
		'default'     => '',
		'label'       => __( 'Link', 'flatsome-admin' ),
		'section'     => 'header_buttons',
		'description' => $smart_links,
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'select',
		'settings'  => 'header_button_1_link_target',
		'transport' => flatsome_customizer_transport(),
		'label'     => __( 'Target', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'default'   => '_self',
		'choices'   => array(
			'_self'  => __( 'Same window', 'flatsome-admin' ),
			'_blank' => __( 'New window', 'flatsome-admin' ),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'        => 'text',
		'settings'    => 'header_button_1_link_rel',
		'transport'   => flatsome_customizer_transport(),
		'default'     => '',
		'label'       => __( 'Rel', 'flatsome-admin' ),
		'section'     => 'header_buttons',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'text',
		'settings'  => 'header_button_1_radius',
		'transport' => flatsome_customizer_transport(),
		'default'   => '99px',
		'label'     => __( 'Radius', 'flatsome-admin' ),
		'section'   => 'header_buttons',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'select',
		'settings'  => 'header_button_1_icon',
		'transport' => flatsome_customizer_transport(),
		'label'     => __( 'Icon', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'default'   => '',
		'choices'   => require get_template_directory() . '/inc/builder/shortcodes/values/icons.php',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'            => 'radio-buttonset',
		'settings'        => 'header_button_1_icon_position',
		'transport'       => flatsome_customizer_transport(),
		'label'           => __( 'Icon position', 'flatsome-admin' ),
		'section'         => 'header_buttons',
		'default'         => '',
		'choices'         => array(
			'left' => __( 'Left', 'flatsome-admin' ),
			''     => __( 'Right', 'flatsome-admin' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_button_1_icon',
				'operator' => '!=',
				'value'    => '',
			),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'            => 'radio-buttonset',
		'settings'        => 'header_button_1_icon_visibility',
		'transport'       => flatsome_customizer_transport(),
		'label'           => __( 'Icon visibility', 'flatsome-admin' ),
		'section'         => 'header_buttons',
		'default'         => '',
		'choices'         => array(
			''     => __( 'Always visible', 'flatsome-admin' ),
			'true' => __( 'Visible on hover', 'flatsome-admin' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_button_1_icon',
				'operator' => '!=',
				'value'    => '',
			),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'header_button_1_color',
		'transport' => flatsome_customizer_transport(),
		'label'     => __( 'Color', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'default'   => 'primary',
		'choices'   => array(
			'plain'     => __( 'Plain', 'flatsome-admin' ),
			'primary'   => __( 'Primary', 'flatsome-admin' ),
			'secondary' => __( 'Secondary', 'flatsome-admin' ),
			'success'   => __( 'Success', 'flatsome-admin' ),
			'alert'     => __( 'Alert', 'flatsome-admin' ),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'header_button_1_style',
		'transport' => flatsome_customizer_transport(),
		'label'     => __( 'Style', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'choices'   => $button_styles,
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'header_button_1_size',
		'transport' => flatsome_customizer_transport(),
		'label'     => __( 'Size', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'choices'   => $nav_sizes,
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'slider',
		'settings'  => 'header_button_1_depth',
		'label'     => __( 'Depth', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'default'   => 0,
		'choices'   => array(
			'min'  => 0,
			'max'  => 5,
			'step' => 1,
		),
		'transport' => flatsome_customizer_transport(),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'slider',
		'settings'  => 'header_button_1_depth_hover',
		'label'     => __( 'Depth :hover', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'default'   => 0,
		'choices'   => array(
			'min'  => 0,
			'max'  => 5,
			'step' => 1,
		),
		'transport' => flatsome_customizer_transport(),
	)
);

Flatsome_Option::add_field( '',
	array(
		'type'     => 'custom',
		'settings' => 'custom_title_button_2',
		'label'    => __( '', 'flatsome-admin' ),
		'section'  => 'header_buttons',
		'default'  => '<div class="options-title-divider">Button 2</div>',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'text',
		'settings'  => 'header_button_2',
		'transport' => flatsome_customizer_transport(),
		'default'   => 'Button 2',
		'label'     => __( 'Text', 'flatsome-admin' ),
		'section'   => 'header_buttons',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'header_button_2_letter_case',
		'transport' => flatsome_customizer_transport(),
		'label'     => __( 'Letter case', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'default'   => '',
		'choices'   => array(
			''          => __( 'ABC', 'flatsome-admin' ),
			'lowercase' => __( 'Abc', 'flatsome-admin' ),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'        => 'text',
		'settings'    => 'header_button_2_link',
		'transport'   => flatsome_customizer_transport(),
		'default'     => '',
		'label'       => __( 'Link', 'flatsome-admin' ),
		'section'     => 'header_buttons',
		'description' => $smart_links,
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'select',
		'settings'  => 'header_button_2_link_target',
		'transport' => flatsome_customizer_transport(),
		'label'     => __( 'Target', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'default'   => '_self',
		'choices'   => array(
			'_self'  => __( 'Same window', 'flatsome-admin' ),
			'_blank' => __( 'New window', 'flatsome-admin' ),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'        => 'text',
		'settings'    => 'header_button_2_link_rel',
		'transport'   => flatsome_customizer_transport(),
		'default'     => '',
		'label'       => __( 'Rel', 'flatsome-admin' ),
		'section'     => 'header_buttons',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'text',
		'settings'  => 'header_button_2_radius',
		'transport' => flatsome_customizer_transport(),
		'default'   => '99px',
		'label'     => __( 'Radius', 'flatsome-admin' ),
		'section'   => 'header_buttons',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'select',
		'settings'  => 'header_button_2_icon',
		'transport' => flatsome_customizer_transport(),
		'label'     => __( 'Icon', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'default'   => '',
		'choices'   => require get_template_directory() . '/inc/builder/shortcodes/values/icons.php',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'            => 'radio-buttonset',
		'settings'        => 'header_button_2_icon_position',
		'transport'       => flatsome_customizer_transport(),
		'label'           => __( 'Icon position', 'flatsome-admin' ),
		'section'         => 'header_buttons',
		'default'         => '',
		'choices'         => array(
			'left' => __( 'Left', 'flatsome-admin' ),
			''     => __( 'Right', 'flatsome-admin' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_button_2_icon',
				'operator' => '!=',
				'value'    => '',
			),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'            => 'radio-buttonset',
		'settings'        => 'header_button_2_icon_visibility',
		'transport'       => flatsome_customizer_transport(),
		'label'           => __( 'Icon visibility', 'flatsome-admin' ),
		'section'         => 'header_buttons',
		'default'         => '',
		'choices'         => array(
			''     => __( 'Always visible', 'flatsome-admin' ),
			'true' => __( 'Visible on hover', 'flatsome-admin' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_button_2_icon',
				'operator' => '!=',
				'value'    => '',
			),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'header_button_2_color',
		'transport' => flatsome_customizer_transport(),
		'label'     => __( 'Color', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'default'   => 'secondary',
		'choices'   => array(
			'plain'     => __( 'Plain', 'flatsome-admin' ),
			'primary'   => __( 'Primary', 'flatsome-admin' ),
			'secondary' => __( 'Secondary', 'flatsome-admin' ),
			'success'   => __( 'Success', 'flatsome-admin' ),
			'alert'     => __( 'Alert', 'flatsome-admin' ),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'header_button_2_style',
		'transport' => flatsome_customizer_transport(),
		'label'     => __( 'Style', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'default'   => 'outline',
		'choices'   => $button_styles,
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'header_button_2_size',
		'transport' => flatsome_customizer_transport(),
		'label'     => __( 'Size', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'choices'   => $nav_sizes,
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'slider',
		'settings'  => 'header_button_2_depth',
		'label'     => __( 'Depth', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'default'   => 0,
		'choices'   => array(
			'min'  => 0,
			'max'  => 5,
			'step' => 1,
		),
		'transport' => flatsome_customizer_transport(),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'slider',
		'settings'  => 'header_button_2_depth_hover',
		'label'     => __( 'Depth :hover', 'flatsome-admin' ),
		'section'   => 'header_buttons',
		'default'   => 0,
		'choices'   => array(
			'min'  => 0,
			'max'  => 5,
			'step' => 1,
		),
		'transport' => flatsome_customizer_transport(),
	)
);

function flatsome_refresh_header_buttons_partials( WP_Customize_Manager $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial( 'header-button-2',
		array(
			'selector'            => '.header-button-2',
			'container_inclusive' => true,
			'settings'            => array(
				'header_button_2',
				'header_button_2_radius',
				'header_button_2_link',
				'header_button_2_style',
				'header_button_2_color',
				'header_button_2_size',
				'header_button_2_depth',
				'header_button_2_depth_hover',
				'header_button_2_icon',
				'header_button_2_icon_position',
				'header_button_2_icon_visibility',
				'header_button_2_letter_case',
			),
			'render_callback'     => function () {
				get_template_part( 'template-parts/header/partials/element', 'button-2' );
			},
		)
	);

	$wp_customize->selective_refresh->add_partial( 'header-button-1',
		array(
			'selector'            => '.header-button-1',
			'container_inclusive' => true,
			'settings'            => array(
				'header_button_1',
				'header_button_1_radius',
				'header_button_1_link',
				'header_button_1_style',
				'header_button_1_color',
				'header_button_1_size',
				'header_button_1_depth',
				'header_button_1_depth_hover',
				'header_button_1_icon',
				'header_button_1_icon_position',
				'header_button_1_icon_visibility',
				'header_button_1_letter_case',
			),
			'render_callback'     => function () {
				get_template_part( 'template-parts/header/partials/element', 'button-1' );
			},
		)
	);

}

add_action( 'customize_register', 'flatsome_refresh_header_buttons_partials' );
