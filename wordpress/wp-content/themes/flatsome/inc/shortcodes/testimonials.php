<?php

// [testimonial]
function flatsome_testimonial($atts, $content = null) {
  global $flatsome_opt;
  $sliderrandomid = rand();
  extract(shortcode_atts(array(
    'name' => '',
    'class' => '',
    'visibility' => '',
    'company' => '',
    'stars' => '5',
    'font_size' => '',
    'text_align' => '',
    'image'  => '',
    'image_width' => '80',
    'pos' => 'left',
    'link' => '',
  ), $atts));
  ob_start();

  $classes = array('testimonial-box');
  $classes_img = array('icon-box-img','testimonial-image','circle');
  
  $classes[] = 'icon-box-'.$pos;
  if ( $class ) $classes[] = $class;
  if ( $visibility ) $classes[] = $visibility;

  if($pos == 'center') $classes[] = 'text-center';
  if($pos == 'left' || $pos == 'top') $classes[] = 'text-left';
  if($pos == 'right') $classes[] = 'text-right';
  if($font_size) $classes[] = 'is-'.$font_size;
  if($image_width) $image_width = 'width: '.intval($image_width).'px';

	$star_width = array(
		'1' => 25,
		'2' => 35,
		'3' => 55,
		'4' => 75,
		'5' => 100,
	);

	$star_row = '';
	if ( isset( $star_width[ $stars ] ) ) {
		$star_row = sprintf('<div class="star-rating" role="img" aria-label="%1$s"><span style="width:%2$d%%"><strong class="rating"></strong></span></div>',
			/* translators: %d is the star rating from 1-5. */
			esc_attr( sprintf( __( 'Rated %d out of 5', 'flatsome' ), $stars ) ),
			$star_width[ $stars ],
		);
	}

  $classes = implode(" ", $classes);
  $classes_img = implode(" ", $classes_img);
  ?>
  <div class="icon-box <?php echo esc_attr( $classes ); ?>">
        <?php if($image) { ?>
        <div class="<?php echo esc_attr( $classes_img ); ?>" style="<?php if($image_width) echo $image_width; ?>">
              <?php echo flatsome_get_image($image, $size = 'thumbnail', $alt = $name) ;?>
        </div>
        <?php } ?>
        <div class="icon-box-text p-last-0">
          <?php if($stars > 0) echo $star_row; ?>
  				<div class="testimonial-text line-height-small italic test_text first-reset last-reset is-italic">
            <?php echo do_shortcode( $content ); ?>
          </div>
          <div class="testimonial-meta pt-half">
             <strong class="testimonial-name test_name"><?php echo wp_kses_post( $name ); ?></strong>
             <?php if($name && $company) echo '<span class="testimonial-name-divider"> / </span>'; ?>
             <span class="testimonial-company test_company"><?php echo wp_kses_post( $company ); ?></span>
          </div>
        </div>
  </div>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}

add_shortcode("testimonial", "flatsome_testimonial");

