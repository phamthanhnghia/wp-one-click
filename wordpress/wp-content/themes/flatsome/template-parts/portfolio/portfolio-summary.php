<?php
/**
 * Portfolio summary.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.18.0
 */

if ( ! get_theme_mod( 'portfolio_title' ) ) { ?>
	<div class="featured_item_cats breadcrumbs mb-half">
		<?php echo get_the_term_list( get_the_ID(), 'featured_item_category', '', ' <span class="divider">|</span> ', '' ); ?>
	</div>
	<h1 class="entry-title uppercase"><?php the_title(); ?></h1>
<?php } ?>

<?php the_excerpt(); ?>

<?php if ( get_theme_mod( 'portfolio_share', 1 ) ) : ?>
	<div class="portfolio-share">
		<?php echo flatsome_apply_shortcode( 'share', array( 'style' => 'small' ) ); ?>
	</div>
<?php endif; ?>

<?php if ( get_the_term_list( get_the_ID(), 'featured_item_tag' ) ) { ?>
	<div class="item-tags is-small bt pt-half uppercase">
		<strong><?php esc_html_e( 'Tags', 'flatsome' ); ?>:</strong>
		<?php echo strip_tags( get_the_term_list( get_the_ID(), 'featured_item_tag', '', ' / ', '' ) ); ?>
	</div>
<?php } ?>
