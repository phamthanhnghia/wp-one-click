<?php
/**
 * Search element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.20.0
 */

$icon_style = get_theme_mod( 'search_icon_style', '' );
?>
<?php if ( get_theme_mod( 'header_search_style', 'dropdown' ) !== 'lightbox' ) { ?>
<li class="header-search header-search-dropdown has-icon has-dropdown menu-item-has-children">
	<?php if($icon_style) { ?><div class="header-button"><?php } ?>
	<a href="#" aria-label="<?php echo __('Search','woocommerce'); ?>" aria-haspopup="true" aria-expanded="false" aria-controls="ux-search-dropdown" class="nav-top-link <?php echo get_flatsome_icon_class( $icon_style, 'small' ); ?>"><?php echo get_flatsome_icon('icon-search'); ?></a>
	<?php if($icon_style) { ?></div><?php } ?>
	<ul id="ux-search-dropdown" class="nav-dropdown <?php flatsome_dropdown_classes(); ?>">
	 	<?php get_template_part('template-parts/header/partials/element-search-form'); ?>
	</ul>
</li>
<?php } else if(get_theme_mod('header_search_style') == 'lightbox') { ?>
<li class="header-search header-search-lightbox has-icon">
	<?php if($icon_style) { ?><div class="header-button"><?php } ?>
		<?php
		$lightbox_link_atts = array(
			'href'          => '#search-lightbox',
			'class'         => get_flatsome_icon_class( get_theme_mod( 'search_icon_style' ), 'small' ),
			'aria-label'    => esc_attr__( 'Search', 'woocommerce' ),
			'data-open'     => '#search-lightbox',
			'data-focus'    => 'input.search-field',
			'role'          => 'button',
			'aria-expanded' => 'false',
			'aria-haspopup' => 'dialog',
			'aria-controls' => 'search-lightbox',
		);
		printf( '<a %s>%s</a>',
			flatsome_html_atts( $lightbox_link_atts ),
			get_flatsome_icon( 'icon-search', '16px' )
		);
		?>
		<?php if($icon_style) { ?></div>
	<?php } ?>

	<div id="search-lightbox" class="mfp-hide dark text-center">
		<?php echo do_shortcode('[search size="large" style="'.get_theme_mod('header_search_form_style').'"]'); ?>
	</div>
</li>
<?php } ?>
