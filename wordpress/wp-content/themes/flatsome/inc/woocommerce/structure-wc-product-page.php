<?php

function flatsome_product_summary_fix(){
  if(is_product()){
    if(!get_theme_mod('product_info_meta', 1)){
      remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
    }
    if(!get_theme_mod('product_info_share', 1)){
      remove_action('woocommerce_single_product_summary','woocommerce_template_single_sharing',50);
    }
  }
}
add_action('wp_head','flatsome_product_summary_fix', 9999);

// Product summary classes
function flatsome_product_summary_classes( $main = true, $align = true, $form = true ) {
	$classes = $main ? array( 'product-summary' ) : array();
	if ( $align && get_theme_mod( 'product_info_align' ) ) {
		$classes[] = 'text-' . get_theme_mod( 'product_info_align', 'left' );
	}
	if ( $form && get_theme_mod( 'product_info_form' ) ) {
		$classes[] = 'form-' . get_theme_mod( 'product_info_form', '' );
	}
	echo implode( ' ', $classes );
}

function flatsome_product_upsell_sidebar(){
  // Product Upsell
    if(get_theme_mod('product_upsell','sidebar') == 'sidebar') {
        remove_action( 'woocommerce_after_single_product_summary' , 'woocommerce_upsell_display', 15);
        add_action('flatsome_before_product_sidebar','woocommerce_upsell_display', 2);
    }
    else if(get_theme_mod('product_upsell', 'sidebar') == 'disabled') {
        remove_action( 'woocommerce_after_single_product_summary' , 'woocommerce_upsell_display', 15);
    }
}
add_action('flatsome_before_product_sidebar','flatsome_product_upsell_sidebar', 1);

/* Add Share to product description */
if ( ! function_exists( 'flatsome_product_share' ) ) {
	function flatsome_product_share() {
		echo flatsome_apply_shortcode( 'share', array(
			'style'   => get_theme_mod( 'social_icons_style', 'outline' ),
			'tooltip' => get_theme_mod( 'social_icons_tooltip', 1 ) ? 'true' : 'false',
		) );
	}
}
add_action( 'woocommerce_share', 'flatsome_product_share', 10 );


/* Remove Product Description Heading */
function flatsome_remove_product_description_heading($heading){

     return $heading = '';
}
add_filter('woocommerce_product_description_heading','flatsome_remove_product_description_heading');


/* Remove Additional Product Information Heading */
function flatsome_remove_product_information_heading($heading){
     return $heading = '';
}
add_filter('woocommerce_product_additional_information_heading','flatsome_remove_product_information_heading');

// Move Sale Flash to another hook
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash',10);
add_action('flatsome_sale_flash','woocommerce_show_product_sale_flash',10);


if ( ! function_exists( 'flatsome_product_video_button' ) ) {
	/**
	 * Add product video button.
	 *
	 * @return void
	 */
	function flatsome_product_video_button() {
		global $wc_cpdf;

		if ( $wc_cpdf->get_value( get_the_ID(), '_product_video' ) ) {
			printf('<a %s>%s</a>',
				flatsome_html_atts( [
					'role'       => 'button',
					'href'       => esc_url( trim( $wc_cpdf->get_value( get_the_ID(), '_product_video' ) ) ),
					'class'      => 'button open-video is-outline circle icon button product-video-popup tip-top',
					'title'      => esc_attr__( 'Video', 'flatsome' ),
					'aria-label' => esc_attr__( 'Open video in lightbox', 'flatsome' ),
				] ),
				get_flatsome_icon( 'icon-play' )
			);
			?>
			<style>
			<?php
			// Set product video height.
			$height       = '900px';
			$width        = '900px';
			$iframe_scale = '100%';
			$custom_size  = $wc_cpdf->get_value( get_the_ID(), '_product_video_size' );
			if ( $custom_size ) {
				$split = explode( 'x', $custom_size );

				$height = $split[0];
				$width  = $split[1];

				$iframe_scale = ( $width / $height * 100 ) . '%';
			}
			echo '.has-product-video .mfp-iframe-holder .mfp-content{max-width: ' . $width . ';}';
			echo '.has-product-video .mfp-iframe-scaler{padding-top: ' . $iframe_scale . ';}';
			?>
			</style>
			<?php
		}
	}
}

add_action( 'flatsome_product_image_tools_bottom', 'flatsome_product_video_button', 1 );

/**
 * Product image lightbox button.
 */
function flatsome_product_lightbox_button() {
	if ( get_theme_mod( 'product_lightbox', 'default' ) === 'disabled' ) {
		return;
	}
	printf('<a %s>%s</a>',
		flatsome_html_atts( [
			'role'       => 'button',
			'href'       => '#product-zoom',
			'class'      => 'zoom-button button is-outline circle icon tooltip hide-for-small',
			'title'      => esc_attr__( 'Zoom', 'flatsome' ),
			'aria-label' => esc_attr__( 'Zoom', 'flatsome' ),
		] ),
		get_flatsome_icon( 'icon-expand' )
	);
}

add_action( 'flatsome_product_image_tools_bottom', 'flatsome_product_lightbox_button', 2 );


// Add Product Body Classes
function flatsome_product_body_classes( $classes ) {

    // Add Frame Class for Posts
    if(is_product() && get_theme_mod('product_lightbox', 'default') == 'flatsome'){
       $classes[] = 'has-lightbox';
    }

    return $classes;
}
add_filter( 'body_class', 'flatsome_product_body_classes' );


function flatsome_product_video_tab() {
	global $wc_cpdf;
	echo flatsome_apply_shortcode( 'ux_video', array(
		'url' => trim( $wc_cpdf->get_value( get_the_ID(), '_product_video' ) ),
	) );
}

// Custom Product Tabs
function flatsome_custom_product_tabs( $tabs ) {
  global $wc_cpdf;

    // Product video Tab
  if($wc_cpdf->get_value(get_the_ID(), '_product_video_placement') == 'tab'){
      $tabs['ux_video_tab'] = array(
        'title'   => __('Video','flatsome'),
        'priority'  => 10,
        'callback'  => 'flatsome_product_video_tab'
      );
  }

  // Adds the new tab
  if($wc_cpdf->get_value(get_the_ID(), '_custom_tab_title')){
    $tabs['ux_custom_tab'] = array(
      'title'   =>  $wc_cpdf->get_value(get_the_ID(), '_custom_tab_title'),
      'priority'  => 40,
      'callback'  => 'flatsome_custom_tab_content'
    );
  }

  // Custom Global Section
  if(get_theme_mod('tab_title')){
      $tabs['ux_global_tab'] = array(
        'title'   => get_theme_mod('tab_title'),
        'priority'  => 50,
        'callback'  => 'flatsome_global_tab_content'
      );
  }

  // Move review tab to the last position
  //$tabs['reviews']['priority'] = 100;

  return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'flatsome_custom_product_tabs' );

function flatsome_custom_tab_content() {
  // The new tab content
  global $wc_cpdf;
  echo do_shortcode($wc_cpdf->get_value(get_the_ID(), '_custom_tab'));
}

function flatsome_global_tab_content() {
  // The new tab content
  echo do_shortcode(get_theme_mod('tab_content'));
}


function flatsome_product_tabs_classes(){
    $classes = array('nav','nav-uppercase');
    $tab_style = get_theme_mod('product_display','tabs');
    if($tab_style == 'tabs' || !$tab_style){
      $classes[] = 'nav-line';
    } else{
      $tab_style = str_replace("tabs_","",$tab_style);
      if($tab_style == 'vertical') $classes[] = 'nav-line';
      if($tab_style == 'normal') $classes[] = 'nav-tabs';
      $classes[] = 'nav-'.$tab_style;
    }

    $align = get_theme_mod('product_tabs_align','left');

    if($align){
        $classes[] = 'nav-'.$align;
    }

    echo implode(' ', $classes);
}

/**
 * Displays the product brand(s).
 */
function flatsome_product_brands() {
	if ( ! get_theme_mod( 'product_brands' ) ) {
		return;
	}

	echo '<div class="ux-product-brands">';
	echo flatsome_apply_shortcode( 'product_brand', array(
		'class' => '',
	) );
	echo '</div>';
}

add_action( 'woocommerce_single_product_summary', 'flatsome_product_brands', 1 );

// Add Custom HTML Blocks
function flatsome_before_add_to_cart_html(){
    echo do_shortcode(get_theme_mod('html_before_add_to_cart'));
}
add_action( 'woocommerce_single_product_summary', 'flatsome_before_add_to_cart_html', 20);


// Add HTML after Add to Cart button
function flatsome_after_add_to_cart_html(){
    echo do_shortcode(get_theme_mod('html_after_add_to_cart'));
}
add_action( 'woocommerce_single_product_summary', 'flatsome_after_add_to_cart_html', 30);


// Add Custom HTML to top of product page
function flatsome_product_top_content(){
  global $wc_cpdf;
  if($wc_cpdf->get_value(get_the_ID(), '_top_content')){
    echo do_shortcode($wc_cpdf->get_value(get_the_ID(), '_top_content'));
  }
}

add_action('flatsome_before_product_page','flatsome_product_top_content', 10);

// Add Custom HTML to bottom of product page
function flatsome_product_bottom_content(){
  global $wc_cpdf;
  if($wc_cpdf->get_value(get_the_ID(), '_bottom_content')){
    echo do_shortcode($wc_cpdf->get_value(get_the_ID(), '_bottom_content'));
  }
}
add_action('flatsome_after_product_page','flatsome_product_bottom_content', 10);

function flatsome_related_products_args( $args ) {
	$args['posts_per_page'] = (int) get_theme_mod( 'max_related_products', 8 );

  return $args;
}

add_filter( 'woocommerce_output_related_products_args', 'flatsome_related_products_args' );

/**
 * Sticky add to cart template.
 *
 * @return void
 */
function flatsome_sticky_add_to_cart_template() {
	global $product;

	if (
		! get_theme_mod( 'product_sticky_cart', 0 )
		|| ! is_product()
		|| ! is_a( $product, 'WC_Product' )
		|| ! $product->is_purchasable()
		|| ! apply_filters( 'flatsome_sticky_add_to_cart_enabled', true, $product )
	) {
		return;
	}

	$classes         = array( 'sticky-add-to-cart' );
	$product_classes = implode( ' ', array_diff( wc_get_product_class( 'sticky-add-to-cart__product', $product ), [ 'product' ] ) );

	if ( get_theme_mod( 'content_color' ) === 'dark' ) {
		$classes[] = 'dark';
	}
	?>
	<!--Legacy wrapper-->
	<div class="sticky-add-to-cart-wrapper">
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
			<div class="<?php echo esc_attr( $product_classes ); ?>">
				<?php
				echo woocommerce_get_product_thumbnail( 'woocommerce_gallery_thumbnail', array( // phpcs:ignore WordPress.Security.EscapeOutput
					'class' => 'attachment-woocommerce_gallery_thumbnail size-woocommerce_gallery_thumbnail sticky-add-to-cart-img',
				) );
				?>
				<div class="product-title-small hide-for-small"><strong><?php the_title(); ?></strong></div>
				<?php
				if ( $product->is_type( 'simple' ) ) :
					woocommerce_simple_add_to_cart();
				else :
					echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput
					echo flatsome_apply_shortcode( 'button', array(
						'as'    => 'button',
						'class' => 'sticky-add-to-cart-select-options-button mb-0 ml-half',
						'color' => 'secondary',
						'text'  => $product->is_type( 'variable' ) ? esc_html__( 'Select options', 'flatsome' ) : $product->single_add_to_cart_text(),
					) );
				endif;
				?>
			</div>
		</div>
	</div>
	<?php
}

add_action( 'wp_footer', 'flatsome_sticky_add_to_cart_template' );

/**
 * Modifies the HTML attributes for a gallery image attachment.
 *
 * @param array  $atts          The existing HTML attributes.
 * @param int    $attachment_id The ID of the attachment.
 * @param string $image_size    The requested image size.
 * @param bool   $main_image    Whether the image is the main gallery image.
 *
 * @return array                The modified HTML attributes.
 */
function flatsome_woocommerce_gallery_image_html_attachment_image_params( $atts, $attachment_id, $image_size, $main_image ) {
	$classes = ! empty( $atts['class'] ) ? explode( ' ', $atts['class'] ) : array();

	// Skip lazy load on main product gallery image, attribute fetchpriority="high" may not always be present.
	if ( $main_image ) {
		$classes[] = 'ux-skip-lazy';
	}

	if (
		class_exists( 'Jetpack' )
		&& Jetpack::is_module_active( 'lazy-images' )
		&& ! get_theme_mod( 'product_gallery_woocommerce' )
	) {
		// skip-lazy, blacklist for Jetpack's lazy load.
		$classes[] = 'skip-lazy';
	}

	$atts['class'] = implode( ' ', $classes );

	return $atts;
}

add_filter( 'woocommerce_gallery_image_html_attachment_image_params', 'flatsome_woocommerce_gallery_image_html_attachment_image_params', 10, 4 );
