<?php
/**
 * The template for displaying all pages.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.19.9
 */

if ( get_theme_mod( 'pages_template', 'default' ) != 'default' ) {

	// Get default template from theme options.
	get_template_part( 'page', get_theme_mod( 'pages_template', 'default' ) );
	return;

} else {

get_header();
do_action( 'flatsome_before_page' ); ?>
<div id="content" class="content-area page-wrapper" role="main">
	<div class="row row-main">
		<div class="large-12 col">
			<div class="col-inner">

				<?php if(get_theme_mod('default_title', 0)){ ?>
				<header class="entry-header">
					<h1 class="entry-title mb uppercase"><?php the_title(); ?></h1>
				</header>
				<?php } ?>

				<?php while ( have_posts() ) : the_post(); ?>
					<?php do_action( 'flatsome_before_page_content' ); ?>

						<?php the_content(); ?>

					<?php
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>

					<?php do_action( 'flatsome_after_page_content' ); ?>
				<?php endwhile; // end of the loop. ?>
			</div>
		</div>
	</div>
</div>

<?php
do_action( 'flatsome_after_page' );
get_footer();

}

?>
