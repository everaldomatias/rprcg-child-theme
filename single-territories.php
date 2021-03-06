<?php
/**
 * The template for displaying single territories.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package coletivo
 */

get_header(); ?>

<div id="content" class="site-content">

	<?php if ( has_post_thumbnail() && $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true ) ) : ?>
		<div class="page-fullheader">
			<img src="<?php echo esc_url( $img[0] ); ?>" alt="<?php the_title(); ?>">
		</div><!-- /.page-fullheader -->
	<?php endif; ?>
	
	<div class="page-header">
		<div class="container">
			<header class="entry-header">
				
				<div class="col-sm-8">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<div class="entry-meta">
						<?php coletivo_posted_on(); ?>
					</div><!-- .entry-meta -->	
				</div>

				<div class="col-sm-4">

					<?php if ( get_previous_post() ) { ?>
						<?php if ( get_previous_post() && strlen( get_previous_post()->post_title ) > 0 ) { ?>
							<div class="nav-previous nav-links">
								<?php previous_post_link( '%link', __( '<i class="fa fa-caret-left" aria-hidden="true"></i> Previous', 'coletivo' ) ); ?>
							</div>
						<?php } ?>
					<?php } ?>

					<?php if ( get_next_post() ) { ?>
						<?php if ( strlen( get_next_post()->post_title ) > 0 ) { ?>
							<div class="nav-next nav-links">
								<?php next_post_link( '%link', __( 'Next <i class="fa fa-caret-right" aria-hidden="true"></i>', 'coletivo' ) ); ?>
							</div>
						<?php } ?>
					<?php } ?>
					
				</div>

			</header><!-- /.entry-header -->
		</div><!-- /.container -->
	</div><!-- /.page-header -->

	<div id="content-inside" class="container right-sidebar">

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'template-parts/content', 'single' );
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endwhile; // End of the loop.
                
				// Aditional loops
				territories_loop_cases( get_the_ID(), 'col-sm-12 nopadding' );
				territories_loop_courses( get_the_ID(), 'col-sm-12 nopadding' );
				territories_loop_news( get_the_ID(), 'col-sm-12 nopadding' );
				territories_loop_articles( get_the_ID(), 'col-sm-12 nopadding' );
				territories_loop_events( get_the_ID(), 'col-sm-12 nopadding' ); ?>

			</main><!-- /#main -->
		</div><!-- /#primary -->

	</div><!-- /#content-inside -->

</div><!-- /#content -->

<?php get_footer();