<?php

/**
 * Get the values from Customizer
 */
$coletivo_territories_disable  = get_theme_mod( 'coletivo_territories_disable' ) == 1 ? true : false;
$coletivo_territories_id       = get_theme_mod( 'coletivo_territories_id', esc_html__( 'territories', 'coletivo' ) );
$coletivo_territories_title    = get_theme_mod( 'coletivo_territories_title', esc_html__( 'Section Title', 'coletivo' ) );
$coletivo_territories_subtitle = get_theme_mod( 'coletivo_territories_subtitle', esc_html__( 'Section Subtitle', 'coletivo' ) );
$coletivo_territories_desc     = get_theme_mod( 'coletivo_territories_desc', esc_html__( 'Section Description', 'coletivo' ) );

if ( coletivo_is_selective_refresh() ) {
    $coletivo_territories_disable = false;
} ?>

<?php if ( ! coletivo_is_selective_refresh() ){ ?>
    <section id="<?php if ( $coletivo_territories_id != '' ) echo $coletivo_territories_id; ?>" <?php do_action( 'coletivo_section_atts', 'territories' ); ?> class="<?php echo esc_attr( apply_filters( 'coletivo_section_class', 'section-territories section-padding onepage-section', 'territories' ) ); ?>">
<?php } ?>

    <?php do_action( 'coletivo_section_before_inner', 'territories' ); ?>
    
    <div class="container">
		<?php if ( $coletivo_territories_title || $coletivo_territories_subtitle || $coletivo_territories_desc ) { ?>
		
            <div class="section-title-area">
                <?php if ( $coletivo_territories_subtitle != '' ) echo '<h5 class="section-subtitle">' . esc_html( $coletivo_territories_subtitle ) . '</h5>'; ?>
                <?php if ( $coletivo_territories_title != '' ) echo '<h2 class="section-title">' . esc_html( $coletivo_territories_title ) . '</h2>'; ?>
                <?php if ( $coletivo_territories_desc ) {
                    echo '<div class="section-desc">' . apply_filters( 'the_content', wp_kses_post( $coletivo_territories_desc ) ) . '</div>';
                } ?>
            </div>

		<?php } ?>

		<div class="section-content">
			<div class="row">
				<div class="col-sm-12">
					<div class="territories-entry wow slideInUp">

                        <div class="territories-list">

                            <?php
                            
                            $args = [
                                'post_type'      => 'territories',
                                'posts_per_page' => 5,
                                'order'          => 'ASC',
                                'orderby'        => 'title',
                                'post_status'    => 'publish'
                            ];

                            $territories = new WP_Query( $args );

                            if ( $territories->have_posts() ) :

                                $count = 0;

                                while ( $territories->have_posts() ) :
                                    $territories->the_post();

                                    $color = get_post_meta( get_the_ID(), 'territories_color', true );

                                    $count++; ?>

                                    <?php if ( $count == 1 ) {
                                        $first = get_the_ID();
                                        $class = 'active';
                                    } else {
                                        $class = 'off';
                                    } ?>
                                    <a style="background-color: <?php echo esc_attr( $color ); ?>;" data-idpost="<?php echo( basename( get_permalink() ) ); ?>" class="buttons-sections <?php echo $class; ?>" onclick="apfaddpost( <?php echo get_the_ID(); ?> );" ><?php the_title(); ?></a>		
                                    
                                <?php endwhile;

                                wp_reset_postdata();

                            endif; // Endif $territories->have_posts()
                            
                            ?>

                        </div><!-- /.territories-list -->

                        <div id="territories-print" class="row">
                            <?php territories_return_html( $first ); ?>
                        </div><!-- /.territories-print -->

                        <div class="all-territories">
                            <a class="btn btn-theme-primary btn-lg" href="<?php echo get_post_type_archive_link( 'territorios' ); ?>">Conheça todos Territórios</a>
                        </div><!-- /.territories -->

					</div><!-- /.territories-entry -->
				</div><!-- /.col-sm-12 -->
			</div><!-- /.row -->

		</div><!-- /.section-content -->
	</div><!-- /.container -->

	<?php do_action( 'coletivo_section_after_inner', 'territories' ); ?>

<?php if ( ! coletivo_is_selective_refresh() ){ ?>
    </section>
<?php }
