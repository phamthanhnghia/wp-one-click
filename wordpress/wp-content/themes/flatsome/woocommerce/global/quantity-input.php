<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see              https://woocommerce.com/document/template-structure/
 * @package          WooCommerce\Templates
 * @version          10.1.0
 * @flatsome-version 3.20.0
 *
 * @var bool   $readonly If the input should be set to readonly mode.
 * @var string $type     The input type attribute.
 */

defined( 'ABSPATH' ) || exit;

if ( fl_woocommerce_version_check( '7.4.0' ) ) :
	/* translators: %s: Quantity. */
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'woocommerce' );

	$reduce_quantity_label = ! empty( $args['product_name'] )
		// translators: %s is the name of the product in cart.
		? sprintf( __( 'Reduce quantity of %s', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) )
		: __( 'Decrease quantity', 'flatsome' );
	$increase_quantity_label = ! empty( $args['product_name'] )
		// translators: %s is the name of the product in cart.
		? sprintf( __( 'Increase quantity of %s', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) )
		: __( 'Increase quantity', 'flatsome' );

	$qty_start       = '<input type="button" value="-" class="ux-quantity__button ux-quantity__button--minus button minus is-form" aria-label="' . esc_attr( $reduce_quantity_label ) . '">';
	$qty_end         = '<input type="button" value="+" class="ux-quantity__button ux-quantity__button--plus button plus is-form" aria-label="' . esc_attr( $increase_quantity_label ) . '">';
	$wrapper_classes = array( 'ux-quantity', 'quantity', 'buttons_added' );

	if ( $type === 'hidden' ) {
		$wrapper_classes[] = 'hidden';
	}
	if ( get_theme_mod( 'product_info_form' ) ) {
		$wrapper_classes[] = 'form-' . get_theme_mod( 'product_info_form', 'normal' );
	}
	?>
	<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>">
		<?php echo $qty_start; ?>
		<?php
		/**
		 * Hook to output something before the quantity input field.
		 *
		 * @since 7.2.0
		 */
		do_action( 'woocommerce_before_quantity_input_field' );
		?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $label ); ?></label>
		<input
			type="<?php echo esc_attr( $type ); ?>"
			<?php echo $readonly ? 'readonly="readonly"' : ''; ?>
			id="<?php echo esc_attr( $input_id ); ?>"
			class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
			name="<?php echo esc_attr( $input_name ); ?>"
			value="<?php echo esc_attr( $input_value ); ?>"
			aria-label="<?php esc_attr_e( 'Product quantity', 'woocommerce' ); ?>"
			<?php if ( in_array( $type, array( 'text', 'search', 'tel', 'url', 'email', 'password' ), true ) ) : ?>
			size="4"
			<?php endif; ?>
			min="<?php echo esc_attr( $min_value ); ?>"
			max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
			<?php if ( ! $readonly ) : ?>
				step="<?php echo esc_attr( $step ); ?>"
				placeholder="<?php echo esc_attr( $placeholder ); ?>"
				inputmode="<?php echo esc_attr( $inputmode ); ?>"
				autocomplete="<?php echo esc_attr( isset( $autocomplete ) ? $autocomplete : 'on' ); ?>"
			<?php endif; ?>
		/>
		<?php
		/**
		 * Hook to output something after quantity input field
		 *
		 * @since 3.6.0
		 */
		do_action( 'woocommerce_after_quantity_input_field' );
		?>
		<?php echo $qty_end; ?>
	</div>
	<?php
elseif ( fl_woocommerce_version_check( '7.2.0' ) ) :
	/* translators: %s: Quantity. */
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'woocommerce' );

	$qty_start       = '<input type="button" value="-" class="ux-quantity__button ux-quantity__button--minus button minus is-form">';
	$qty_end         = '<input type="button" value="+" class="ux-quantity__button ux-quantity__button--plus button plus is-form">';
	$wrapper_classes = array( 'ux-quantity', 'quantity', 'buttons_added' );
	if ( get_theme_mod( 'product_info_form' ) ) {
		$wrapper_classes[] = 'form-' . get_theme_mod( 'product_info_form', 'normal' );
	}

	// In some cases we wish to display the quantity but not allow for it to be changed.
	if ( $max_value && $min_value === $max_value ) {
		$is_readonly = true;
		$input_value = $min_value;
	} else {
		$is_readonly = false;
	}
	?>
	<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>">
		<?php echo $qty_start; ?>
		<?php
		/**
		 * Hook to output something before the quantity input field.
		 *
		 * @since 7.2.0
		 */
		do_action( 'woocommerce_before_quantity_input_field' );
		?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $label ); ?></label>
		<input
			type="<?php echo $is_readonly ? 'number' : 'number'; // Keep as type number for count alignment. ?>"
			<?php echo $is_readonly ? 'readonly="readonly"' : ''; ?>
			id="<?php echo esc_attr( $input_id ); ?>"
			class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
			name="<?php echo esc_attr( $input_name ); ?>"
			value="<?php echo esc_attr( $input_value ); ?>"
			title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
			size="4"
			min="<?php echo esc_attr( $min_value ); ?>"
			<?php if ( 0 < $max_value ) : ?>
				max="<?php echo esc_attr( $max_value ); ?>"
			<?php endif; ?>
			<?php if ( ! $is_readonly ) : ?>
				step="<?php echo esc_attr( $step ); ?>"
				placeholder="<?php echo esc_attr( $placeholder ); ?>"
				inputmode="<?php echo esc_attr( $inputmode ); ?>"
				autocomplete="<?php echo esc_attr( isset( $autocomplete ) ? $autocomplete : 'on' ); ?>"
			<?php endif; ?>
		/>
		<?php
		/**
		 * Hook to output something after quantity input field
		 *
		 * @since 3.6.0
		 */
		do_action( 'woocommerce_after_quantity_input_field' );
		?>
		<?php echo $qty_end; ?>
	</div>
	<?php
else : // Pre WooCommerce 7.2.0.
	$qty_start = '<input type="button" value="-" class="minus button is-form">';
	$qty_end   = '<input type="button" value="+" class="plus button is-form">';

	if ( $max_value && $min_value === $max_value ) {
		?>
		<div class="quantity hidden">
			<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
		</div>
		<?php
	} else {
		/* translators: %s: Quantity. */
		$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'woocommerce' );
		// Add wrapper classes.
		$wrapper_classes = array( 'quantity', 'buttons_added' );
		if ( get_theme_mod( 'product_info_form' ) ) {
			$wrapper_classes[] = 'form-' . get_theme_mod( 'product_info_form', 'normal' );
		}
		?>
		<div class="<?php echo implode( ' ', $wrapper_classes ); ?>">
			<?php echo $qty_start; ?>
			<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
			<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $label ); ?></label>
			<input
				type="number"
				id="<?php echo esc_attr( $input_id ); ?>"
				class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
				step="<?php echo esc_attr( $step ); ?>"
				min="<?php echo esc_attr( $min_value ); ?>"
				max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
				name="<?php echo esc_attr( $input_name ); ?>"
				value="<?php echo esc_attr( $input_value ); ?>"
				title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
				size="4"
				placeholder="<?php echo esc_attr( $placeholder ); ?>"
				inputmode="<?php echo esc_attr( $inputmode ); ?>" />
			<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
			<?php echo $qty_end; ?>
		</div>
		<?php
	}
endif;

