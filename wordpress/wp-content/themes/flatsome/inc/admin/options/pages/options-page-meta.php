<?php
// PAGE META OPTIONS
include('meta/meta_box_framework.php');

function flatsome_custom_meta_boxes() {
    if (
      flatsome_wp_version_check( '6.3' ) &&
      use_block_editor_for_post_type( 'page' ) &&
      ! isset( $_REQUEST['classic-editor'] )
    ) {
      // Don't use meta boxes in WordPress 6.3 and above, as they will
      // prevent the Block Editor from rendering the blocks in an iframe.
      return;
    }
    $meta_box = array(
        'id'         => 'flatsome_page_options2', // Meta box ID
        'title'      => 'Page Layout', // Meta box title
        'pages'      => array('page'), // Post types this meta box should be shown on
        'context'    => 'side', // Meta box context
        'priority'   => 'core', // Meta box priority
        'fields' => array(
            array(
                'id' => '_footer',
                'name' => 'Page Footer',
                //'desc' => 'This is a description.',
                'type' => 'select',
                'std' => 'normal',
                'choices' => array(
                    'normal' => 'Normal',
                    'simple' => 'Simple',
                    'custom' => 'Custom',
                    'transparent' => 'Transparent',
                    'disabled' => 'Hide',
                )
            ),
        )
    );
    dev7_add_meta_box( $meta_box );
}
add_action( 'dev7_meta_boxes', 'flatsome_custom_meta_boxes' );
