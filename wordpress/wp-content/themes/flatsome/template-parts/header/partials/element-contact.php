<?php
/**
 * Contact element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.20.2
 */

?>
<li class="header-contact-wrapper">
	<?php
		$icon_size = get_theme_mod( 'contact_icon_size', '16px' );
		$class_link = 'tooltip';
		$nav = 'nav-divided nav-uppercase';
		$label = true;

		if ( get_theme_mod( 'contact_style', 'left' ) == 'icons' ) {
			$label = false;
		}
	?>
	<ul id="header-contact" class="nav medium-nav-center <?php echo $nav; ?> header-contact">
		<?php if ( get_theme_mod( 'contact_location', '' ) ) { ?>
			<li>
			  <a target="_blank" rel="noopener" href="https://maps.google.com/?q=<?php echo get_theme_mod( 'contact_location', '' ); ?>" title="<?php echo get_theme_mod( 'contact_location', '' ); ?>" class="<?php echo $class_link;?>">
			  	 <?php echo get_flatsome_icon('icon-map-pin-fill',$icon_size); ?>
			     <span>
			     	<?php
			     	$location_label = get_theme_mod( 'contact_location_label', '' );
		       		if($location_label && $label){
		       			echo $location_label;
		       		} else if($label){
		       			_e('Location','flatsome');
			    	} ?>
			     </span>
			  </a>
			</li>
			<?php } ?>

			<?php
			 $contact_email = get_theme_mod('contact_email','youremail@gmail.com');
			 if($contact_email){ ?>
			<li>
			  <a href="mailto:<?php echo $contact_email; ?>" class="<?php echo $class_link;?>" title="<?php echo  $contact_email; ?>">
				  <?php echo get_flatsome_icon('icon-envelop',$icon_size); ?>
			       <span>
			       	<?php
			       	$contact_label = get_theme_mod('contact_email_label');
		       		if($contact_label && $label) {
		       			echo $contact_label;
		       		} else if($label){
		       			_e('Contact','flatsome');
			    	} ?>
			       </span>
			  </a>
			</li>
			<?php } ?>

			<?php
			$contact_hours = get_theme_mod('contact_hours','08:00 - 17:00');
			if($contact_hours){
				$contact_hours_details = get_theme_mod( 'contact_hours_details', '' );
			?>
			<li>
			  <a href="#" onclick="event.preventDefault()" class="<?php echo $class_link;?>" title="<?php echo $contact_hours; ?><?php if($contact_hours_details) echo ' | '.$contact_hours_details; ?> ">
			  	   <?php echo get_flatsome_icon('icon-clock',$icon_size); ?>
			        <span><?php if($label) echo $contact_hours; ?></span>
			  </a>
			 </li>
			<?php } ?>

			<?php if ( get_theme_mod( 'contact_phone', '+47 900 99 000' ) ) { ?>
			<li>
			  <a href="tel:<?php echo get_theme_mod( 'contact_phone', '+47 900 99 000' ); ?>" class="<?php echo $class_link;?>" title="<?php echo get_theme_mod( 'contact_phone', '+47 900 99 000' ); ?>">
			     <?php echo get_flatsome_icon('icon-phone',$icon_size); ?>
			      <span><?php if($label) echo get_theme_mod( 'contact_phone', '+47 900 99 000' ); ?></span>
			  </a>
			</li>
			<?php } ?>

			<?php if ( get_theme_mod( 'contact_whatsapp', '' ) ) { ?>
				<li>
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
