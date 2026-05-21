<?php
/**
 * Mobile contact element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.20.0
 */

$mobile_link_atts = [
	'href'               => '#',
	'data-open'          => '#header-contact',
	'data-visible-after' => 'true',
	'data-pos'           => 'center',
	'class'              => 'icon show-for-medium',
	'role'               => 'button',
	'aria-label'         => esc_attr__( 'Contact information', 'flatsome' ),
	'aria-expanded'      => 'false',
	'aria-controls'      => 'header-contact',
	'aria-haspopup'      => 'dialog',
];

$class      = 'has-icon';
$icon_size  = get_theme_mod( 'contact_icon_size', '16px' );
$class_link = 'tooltip';
$nav        = 'nav-divided nav-uppercase';
$label      = true;

if ( get_theme_mod( 'contact_style', 'left' ) == 'icons' ) {
	$label = false;
}

if ( get_theme_mod( 'contact_style', 'left' ) == 'top' ) {
	$class .= ' icon-top';
}
?>
<li class="header-contact-wrapper">
	<?php
	printf( '<div class="header-button"><a %s>%s</a></div>',
		flatsome_html_atts( $mobile_link_atts ),
		get_flatsome_icon( 'icon-envelop', $icon_size )
	);
	?>

	<ul id="header-contact" class="nav <?php echo $nav; ?> header-contact hide-for-medium">
		<?php if ( get_theme_mod( 'contact_location', '' ) ) { ?>
			<li class="<?php echo $class; ?>">
			  <a target="_blank" rel="noopener" href="https://maps.google.com/?q=<?php echo get_theme_mod( 'contact_location', '' ); ?>" title="<?php echo get_theme_mod( 'contact_location', '' ); ?>" class="<?php echo $class_link;?>">
			  	 <?php echo get_flatsome_icon('icon-map-pin-fill',$icon_size); ?>
			     <?php if($label) _e('Location','flatsome'); ?>
			  </a>
			</li>
			<?php } ?>

			<?php if ( get_theme_mod( 'contact_email', 'youremail@gmail.com' ) ) { ?>
			<li class="<?php echo $class; ?>">
			  <a href="mailto:<?php echo get_theme_mod( 'contact_email', 'youremail@gmail.com' ); ?>" class="<?php echo $class_link;?>" title="<?php echo get_theme_mod( 'contact_email', 'youremail@gmail.com' ); ?>">
				  <?php echo get_flatsome_icon('icon-envelop',$icon_size); ?>
			      <?php if($label) _e('Contact','flatsome'); ?>
			  </a>
			</li>
			<?php } ?>

			<?php if ( get_theme_mod( 'contact_hours', '08:00 - 17:00' ) ) { ?>
			<li class="<?php echo $class; ?>">
			  <a href="#" onclick="event.preventDefault()" class="<?php echo $class_link;?>" title="<?php echo get_theme_mod( 'contact_hours', '08:00 - 17:00' ).' | '.get_theme_mod( 'contact_hours_details', '' ); ?>">
			  	   <?php echo get_flatsome_icon('icon-clock',$icon_size); ?>
			       <?php if($label) echo get_theme_mod( 'contact_hours', '08:00 - 17:00' ); ?>
			  </a>
			 </li>
			<?php } ?>

			<?php if ( get_theme_mod( 'contact_phone', '+47 900 99 000' ) ) { ?>
			<li class="<?php echo $class; ?>">
			  <a href="tel:<?php echo get_theme_mod( 'contact_phone', '+47 900 99 000' ); ?>" class="<?php echo $class_link;?>" title="<?php echo get_theme_mod( 'contact_phone', '+47 900 99 000' ); ?>">
			     <?php echo get_flatsome_icon('icon-phone',$icon_size); ?>
			     <?php if($label) echo get_theme_mod( 'contact_phone', '+47 900 99 000' ); ?>
			  </a>
			</li>
			<?php } ?>

		<?php if ( get_theme_mod( 'contact_whatsapp', '' ) ) { ?>
			<li class="<?php echo esc_attr( $class ); ?>">
				<a href="<?php echo esc_url( 'https://wa.me/' . get_theme_mod( 'contact_whatsapp', '' ) ); ?>" class="<?php echo esc_attr( $class_link ); ?>" title="<?php echo esc_attr( get_theme_mod( 'contact_whatsapp', '' ) ); ?>" target="_blank" rel="noopener">
					<?php echo get_flatsome_icon( 'icon-whatsapp', $icon_size ); ?>
					<span>
							<?php
							if ( $label ) {
								$contact_whatsapp_label = get_theme_mod( 'contact_whatsapp_label', '' );
								if ( $contact_whatsapp_label ) {
									echo esc_html( $contact_whatsapp_label );
								} else {
									esc_html_e( 'WhatsApp', 'flatsome' );
								}
							}
							?>
						</span>
				</a>
			</li>
		<?php } ?>
	</ul>
</li>
