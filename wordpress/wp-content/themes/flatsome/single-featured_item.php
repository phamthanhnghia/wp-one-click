<?php
/**
 * The template for a single featured item.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.19.9
 */

get_header(); ?>

<div class="portfolio-page-wrapper portfolio-single-page">
	<?php get_template_part( 'template-parts/portfolio/single-portfolio', get_theme_mod( 'portfolio_layout', '' ) ); ?>
</div>

<?php get_footer(); ?>
