<?php

/**
 * Get the values from Customizer
 */
$coletivo_articles_disable  = get_theme_mod( 'coletivo_articles_disable' ) == 1 ? true : false;
$coletivo_articles_id       = get_theme_mod( 'coletivo_articles_id', esc_html__( 'articles', 'coletivo' ) );
$coletivo_articles_title    = get_theme_mod( 'coletivo_articles_title', esc_html__( 'Section Title', 'coletivo' ) );
$coletivo_articles_subtitle = get_theme_mod( 'coletivo_articles_subtitle', esc_html__( 'Section Subtitle', 'coletivo' ) );
$coletivo_articles_desc     = get_theme_mod( 'coletivo_articles_desc', '' );

if ( coletivo_is_selective_refresh() ) {
    $coletivo_articles_disable = false;
} ?>

<?php if ( ! coletivo_is_selective_refresh() ){ ?>
    <section id="<?php if ( $coletivo_articles_id != '' ) echo $coletivo_articles_id; ?>" <?php do_action( 'coletivo_section_atts', 'articles' ); ?> class="<?php echo esc_attr( apply_filters( 'coletivo_section_class', 'section-articles section-padding onepage-section', 'articles' ) ); ?>">
<?php } ?>

    <?php do_action( 'coletivo_section_before_inner', 'articles' ); ?>
    
    <div class="container">
		<?php if ( $coletivo_articles_title || $coletivo_articles_subtitle || $coletivo_articles_desc ) { ?>
		
            <div class="section-title-area">
                <?php if ( $coletivo_articles_subtitle != '' ) echo '<h5 class="section-subtitle">' . esc_html( $coletivo_articles_subtitle ) . '</h5>'; ?>
                <?php if ( $coletivo_articles_title != '' ) echo '<h2 class="section-title">' . esc_html( $coletivo_articles_title ) . '</h2>'; ?>
                <?php if ( $coletivo_articles_desc ) {
                    echo '<div class="section-desc">' . apply_filters( 'the_content', wp_kses_post( $coletivo_articles_desc ) ) . '</div>';
                } ?>
            </div>

		<?php } ?>

		<div class="section-content">
			<div class="row">
				<div class="col-sm-12">
					<div class="articles-entry wow slideInUp">

                        <?php
                        
                        $args = [
                            'post_type'      => 'articles',
                            'posts_per_page' => 3,
                            'post_status'    => 'publish'
                        ];

                        $articles = new WP_Query( $args );

                        if ( $articles->have_posts() ) :

                            while ( $articles->have_posts() ) :
                                $articles->the_post();

                                get_template_part( 'template-parts/content', 'list' );
                            
                            endwhile;

                            wp_reset_postdata();

                        endif; // Endif $articles->have_posts()
                        
                        ?>

					</div><!-- /.articles-entry -->

                    <div class="all-articles">
                        <a class="btn btn-theme-primary btn-lg" href="<?php echo get_post_type_archive_link( 'territorios' ); ?>">Conheça todos Territórios</a>
                    </div><!-- /.articles -->

				</div><!-- /.col-sm-12 -->
			</div><!-- /.row -->

		</div><!-- /.section-content -->
	</div><!-- /.container -->

	<?php do_action( 'coletivo_section_after_inner', 'articles' ); ?>

<?php if ( ! coletivo_is_selective_refresh() ){ ?>
    </section>
<?php }
