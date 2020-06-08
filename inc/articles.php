<?php

if ( class_exists( 'CPT' ) ) :

    $arguments = [
        'show_in_rest' => true, // Enable Gutenberg
        'supports'     => [ 'title', 'editor', 'thumbnail' ],
        'has_archive'  => true
    ];

    $articles = new CPT( [
        'post_type_name' => 'articles',
        'singular'       => 'Artigo',
        'plural'         => 'Artigos',
        'slug'           => 'artigos'
    ], $arguments );

    $articles->menu_icon( 'dashicons-media-text' );

endif;

if ( ! function_exists( 'territories_loop_articles' ) ) {

    function territories_loop_articles( $id, $class = 'col-sm-6' ) {

        $args = [
            'post_type'      => 'articles',
            'posts_per_page' => 3,
            'order'          => 'DESC',
            'post_status'    => 'publish',
            'meta_query'	=> array(
                array(
                    'key'		=> 'what_territories',
                    'value'		=> $id,
                    'compare'	=> 'LIKE'
                )
            )
        ];

        $posts = new WP_Query( $args );

        if ( $posts->have_posts() ) :

            echo '<div class="' . $class . ' articles-list">';

                if ( $posts->post_count >= 3 ) {
                    echo '<h3>Artigos <a href="' . esc_url( home_url() . '/artigos?territorio=' ) . $id . '">Veja todos artigos</a></h3>';
                } else {
                    echo '<h3>Artigos</h3>';
                }            

                while ( $posts->have_posts() ) :
                    $posts->the_post();                

                    get_template_part( 'template-parts/content', 'list' );

                endwhile;
            
                wp_reset_postdata();

            echo '</div><!-- /.articles-list -->';

        endif; // Endif $posts->have_posts()

    }
    
}