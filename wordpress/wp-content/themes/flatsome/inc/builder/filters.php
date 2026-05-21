<?php

/**
 * Enable the native editor when saving a page builder layout.
 * HS ticket #179473
 *
 * @param bool $is_translation_with_native_editor Whether to use native editor for translation.
 *
 * @return bool
 */
function ux_builder_is_editing_translation_with_native_editor( $is_translation_with_native_editor ) {
	if ( isset( $_POST['action'] ) && 'ux_builder_save' === $_POST['action'] ) {
		return true;
	}

	return $is_translation_with_native_editor;
}

add_filter( 'wpml_pb_is_editing_translation_with_native_editor', 'ux_builder_is_editing_translation_with_native_editor' );
