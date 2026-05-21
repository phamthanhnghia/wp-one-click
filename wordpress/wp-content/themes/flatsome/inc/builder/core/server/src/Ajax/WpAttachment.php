<?php

namespace UxBuilder\Ajax;

class WpAttachment {

  public function get_attachment() {
    $id = intval( $_GET['attachment_id'] );
    $size = array_key_exists( 'attachment_size', $_GET ) ? sanitize_text_field( $_GET['attachment_size'] ) : null;
    $width = array_key_exists( 'attachment_width', $_GET ) ? sanitize_text_field( $_GET['attachment_width'] ) : null;
    $height = array_key_exists( 'attachment_height', $_GET ) ? sanitize_text_field( $_GET['attachment_height'] ) : null;
    $icon = null;

    if( $width || $height ) {
      $size = array( $width, $height );
    }

    if( $attachment = wp_get_attachment_image_src( $id, $size, $icon ) ) {
      return wp_send_json_success( $attachment );
    }

    return wp_send_json_error();
  }
}
