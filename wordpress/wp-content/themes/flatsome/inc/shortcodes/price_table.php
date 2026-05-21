<?php
// [ux_price_table]
function ux_price_table( $atts, $content = null ){
  extract( shortcode_atts( array(
    'class' => '',
    'visibility' => '',
    'title' => 'Title',
    'price' => '$99.99',
    'description' => '',
    'featured' => '',
    'radius' => '',
    'color' => '',
    'bg_color' => '',
    'depth' => '',
    'depth_hover' => '3',

    // Depricated
    'button_style' => '',
    'button_text' => '',
    'button_link' => '',
  ), $atts ) );

  if($visibility == 'hidden') return;

  ob_start();

  $classes = array('pricing-table','ux_price_table');
  $classes_wrapper = array('pricing-table-wrapper');

  $classes[] = 'text-center';

  if( $class ) $classes[] = $class;
  if( $visibility ) $classes[] = $visibility;

  if($color == 'dark') $classes_wrapper[] = 'dark';
  if($depth) $classes[] = 'box-shadow-'.$depth;
  if($depth_hover) $classes[] = 'box-shadow-'.$depth_hover.'-hover';
  if($featured) $classes[] = 'featured-table';

  $css_args = array(
      array( 'attribute' => 'border-radius', 'value' => $radius, 'unit' => 'px'),
      array( 'attribute' => 'background-color', 'value' => $bg_color ),
  );

?>
<div class="<?php echo esc_attr( implode( ' ', $classes_wrapper ) ); ?>">
  <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"<?php echo get_shortcode_inline_css($css_args); ?>>
    <div class="pricing-table-header">
      <div class="title uppercase strong"><?php echo wp_kses_post( $title ); ?></div>
      <div class="price is-xxlarge"><?php echo wp_kses_post( $price ); ?></div>
      <?php if(!empty($description)) { ?>
        <div class="description is-small">
          <?php echo wp_kses_post( $description ); ?>
        </div>
      <?php } ?>
    </div>
    <div class="pricing-table-items items">
      <?php echo do_shortcode( $content ); ?>
    </div>
    <?php if($button_text) { ?>
    <div class="cta-button">
        <a class="button <?php echo esc_attr( $button_style ); ?>" href="<?php echo esc_url( $button_link ); ?>">
        <?php echo wp_kses_post( $button_text ); ?></a>
    </div>
    <?php } ?>
  </div>
</div>

<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('ux_price_table', 'ux_price_table');

// Price bullet
function bullet_item( $atts, $content = null ){
  extract( shortcode_atts( array(
    'text' => 'Add any text here...',
    'tooltip' => '',
    'enabled' => ''
  ), $atts ) );
    $tooltip_html = '';
    $classes = array('bullet-item');
    if($enabled == 'false') $classes[] = 'is-disabled';
    if($tooltip) {
      $classes[] = 'tooltip';
      $classes[] = 'has-hover';
      $tooltip_html = '<span class="tag-label bullet-more-info circle">?</span>';
    }
    $content = '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" title="' . esc_attr( $tooltip ) . '"><span class="text">' . wp_kses_post( $text ) . '</span>' . $tooltip_html . '</div>';
    return $content;
}
add_shortcode('bullet_item', 'bullet_item');
