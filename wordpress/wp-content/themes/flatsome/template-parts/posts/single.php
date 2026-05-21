<?php
/**
 * Posts single.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.19.9
 */

if ( have_posts() ) : ?>

<?php /* Start the Loop */ ?>

<?php while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="article-inner <?php flatsome_blog_article_classes(); ?>">
		<?php
			if ( get_theme_mod( 'blog_post_style', 'default' ) == 'default' || get_theme_mod( 'blog_post_style', 'default' ) == 'inline' ) {
				get_template_part( 'template-parts/posts/partials/entry-header', get_theme_mod( 'blog_posts_header_style', 'normal' ) );
			}
		?>
		<?php get_template_part( 'template-parts/posts/content', 'single' ); ?>
	</div>
</article>

<?php endwhile; ?>

<?php else : ?>

	<?php get_template_part( 'no-results', 'index' ); ?>

<?php endif; ?>
