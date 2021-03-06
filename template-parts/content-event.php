<?php
/**
 * Template part for displaying events posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package coletivo
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'list-article', 'clearfix' ) ); ?>>

	<div class="list-article-thumb">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php
		if ( has_post_thumbnail( ) ) {
			the_post_thumbnail( 'coletivo-blog-small' );
		} else {
			echo '<img alt="" src="'. get_template_directory_uri() . '/assets/images/placholder2.png' .'">';
		} ?>
	</div><!-- /.list-article-thumb -->

	<div class="list-article-content">

		<div class="list-article-meta">
			<?php print_events_meta(); ?>
		</div><!-- /.list-article-meta -->

        <?php do_action( 'after_entry_header_content_list' ); ?>

		<div class="entry-excerpt">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->

        <a class="btn btn-theme-primary btn-sm" href="<?php echo esc_url( get_the_permalink() ); ?>">Veja mais</a>
	</div><!-- /.list-article-content -->

</article><!-- /#post-## -->
