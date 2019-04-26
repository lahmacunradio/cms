<?php
/**
 * The template for displaying Categories
 */

get_header(); ?>

<div id="main" class="site-main categoryposts" role="main">

	<div id="content" class="site-content">

		<div id="primary" class="content-area">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">

				<?php single_cat_title( '<h1 class="page-title">', '</h1>' ); ?>

			</header><!-- .page-header -->

			<?php while ( have_posts() ) : the_post(); ?>

				<article class="postslister">
				  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

				  <?php if ( has_post_thumbnail()) : ?>
				  <div class="newspic-container">
				   <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="newsimage">
				   <?php the_post_thumbnail("thumbnail"); ?>
				   </a>
				</div>
				<?php endif; ?>

				<div class="description">
				  <?php the_excerpt(); ?>
				  </div>
				<div class="clearfix"></div>

				</article>


			<?php endwhile; ?>

			<?php maker_posts_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</div><!-- #primary -->

		<?php // get_sidebar(); ?>

	</div><!-- #content -->
</div><!-- #main -->

<?php get_footer(); ?>
