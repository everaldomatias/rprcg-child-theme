<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package coletivo
 */

get_header(); ?>

	<div id="content" class="site-content">

		<div class="page-header">
			<div class="container">
                <h1 class="page-title">Downloads</h1>
			</div><!-- /.container -->
		</div><!-- /.page-header -->

		<?php if ( function_exists( 'coletivo_breadcrumb' ) ) : ?>
			<?php echo coletivo_breadcrumb(); ?>
		<?php endif; ?>

		<div id="content-inside" class="container">
			<main id="main" class="site-main" role="main">

                <?php if ( have_posts() ) : ?>

                    <?php while ( have_posts() ) : the_post(); ?>
                    
                        <article id="post-<?php the_ID(); ?>" <?php post_class( array('clearfix', 'list-downloads') ); ?>>

                            <div class="list-article-thumb col-sm-4">
                                <?php
                                if ( has_post_thumbnail( ) ) {
                                    the_post_thumbnail( 'medium_large' );
                                } else {
                                    echo '<img alt="" src="'. get_template_directory_uri() . '/assets/images/placholder2.png' .'">';
                                } ?>
                            </div><!-- /.list-article-thumb -->

                            <div class="list-article-content col-sm-8">
                                
                                <header class="entry-header">
                                    <h2 class="entry-title"><?php the_title(); ?></h2>
                                </header><!-- /.entry-header -->
                                
                                <div class="entry-content">
                                    <?php the_content(); ?>
                                </div><!-- /.entry-content -->
                                
                                <div class="entry-file">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/file.png" alt="Download file">
                                    <?php
                                    $file_id = get_post_meta( get_the_ID(), 'download_file', true );
                                    $file = wp_get_attachment_url( $file_id );
                                    echo '<a href="' . $file . '" download>Download: ' . basename( get_attached_file( $file_id ) ) . ' (';
                                    the_file_size( $file_id );
                                    echo ')</a>'; ?>
                                </div><!-- /.entry-file -->
                                
                            </div><!-- /.list-article-content -->

                        </article><!-- /#post-## -->                        

					<?php endwhile; ?>

					<?php the_posts_navigation(); ?>

				<?php else : ?>

					<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->
		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer();