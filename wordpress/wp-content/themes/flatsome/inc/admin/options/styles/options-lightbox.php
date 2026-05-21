<?php

Flatsome_Option::add_section( 'lightbox', array(
	'title' => __( 'Drawer & Lightbox', 'flatsome-admin' ),
	'panel' => 'style',
) );


Flatsome_Option::add_field( 'option', array(
	'type'            => 'color',
	'settings'        => 'flatsome_lightbox_bg',
	'label'           => __( 'Backdrop color', 'flatsome-admin' ),
	'section'         => 'lightbox',
	'transport'       => flatsome_customizer_transport(),
	'default'         => '',
) );

Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'style_drawer_title',
	'label'    => '',
	'section'  => 'lightbox',
	'default'  => '<div class="options-title-divider" style="margin-bottom:15px">Drawer</div><p>Drawers are special sections that appear over your website. Think of them like sliding panels that can hold menus, filters, shopping carts, or mobile navigation.</p>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'      => 'dimension',
	'settings'  => 'drawer_width',
	'section'   => 'lightbox',
	'label'     => __( 'Drawer width', 'flatsome' ),
	'transport' => flatsome_customizer_transport(),
	'default'   => Flatsome_Default::DRAWER_WIDTH,
) );

Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'style_lightbox_title',
	'label'    => '',
	'section'  => 'lightbox',
	'default'  => '<div class="options-title-divider" style="margin-bottom:15px">Lightbox</div><p>Lightboxes are like pop-up windows that showcase photos or content, making the rest of the website fade into the background.</p>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'flatsome_lightbox',
	'label'    => __( 'Use Flatsome lightbox', 'flatsome-admin' ),
	'description' => __( 'When enabled, lightbox can be activated per image or gallery. Disable if you experience conflict with other lightbox plugins.', 'flatsome-admin' ),
	'section'  => 'lightbox',
	'default'  => 1,
) );

Flatsome_Option::add_field( 'option', array(
	'type'            => 'multicheck',
	'settings'        => 'flatsome_separate_lightbox_galleries',
	'label'           => __( 'Multi-Gallery Lightbox', 'flatsome-admin' ),
	'description'     => __( 'Choose which galleries open in their own lightbox. Unchecked galleries combine into a single lightbox.', 'flatsome-admin' ),
	'section'         => 'lightbox',
	'default'         => [],
	'choices'         => [
		'gallery'     => __( 'Enable multi-gallery for UX Gallery', 'flatsome-admin' ),
		'banner-grid' => __( 'Enable multi-gallery for UX Grid', 'flatsome-admin' ),
	],
	'active_callback' => array(
		array(
			'setting'  => 'flatsome_lightbox',
			'operator' => '==',
			'value'    => true,
		),
	),
) );
