<?php

if ( class_exists( 'CPT' ) ) :

    $arguments = [
        'show_in_rest' => true, // Enable Gutenberg
        'supports'     => [ 'title', 'editor', 'thumbnail' ],
        'has_archive'  => true
    ];

    $events = new CPT( [
        'post_type_name' => 'events',
        'singular'       => 'Evento',
        'plural'         => 'Eventos',
        'slug'           => 'eventos'
    ], $arguments );

    $events->menu_icon( 'dashicons-calendar-alt' );

endif;

if ( ! function_exists( 'territories_loop_events' ) ) {

    function territories_loop_events( $id, $class = 'col-sm-6' ) {
        
        $args = [
            'post_type'      => 'events',
            'posts_per_page' => 3,
            'post_status'    => 'publish',
            'meta_key'       => 'events_date',
            'orderby'        => 'meta_value_num',
            'order'          => 'ASC',
            'meta_query'     => array(
                array(
                    'key'		=> 'what_territories',
                    'value'		=> $id,
                    'compare'	=> 'LIKE'
                ),
                 array(
                    'key'     => 'events_date',
                    'compare' => '>=',
                    'value'   => date( 'Ymd' ),
                    'type'    => 'DATE'
                )
            )
        ];

        $posts = new WP_Query( $args );

        if ( $posts->have_posts() ) :

            echo '<div class="' . $class . ' events-list">';

                if ( $posts->post_count >= 3 ) {
                    echo '<h3>Eventos <a href="' . esc_url( home_url() . '/artigos?territorio=' ) . $id . '">Veja todos eventos</a></h3>';
                } else {
                    echo '<h3>Eventos</h3>';
                }            

                while ( $posts->have_posts() ) :
                    $posts->the_post();                

                    get_template_part( 'template-parts/content', 'list' );

                endwhile;
            
                wp_reset_postdata();

            echo '</div><!-- /.events-list -->';

        else :

            $args = [
                'post_type'      => 'events',
                'posts_per_page' => 3,
                'post_status'    => 'publish',
                'meta_key'       => 'events_date',
                'orderby'        => 'meta_value_num',
                'order'          => 'ASC',
                'meta_query'     => array(
                    array(
                        'key'		=> 'what_territories',
                        'value'		=> $id,
                        'compare'	=> 'LIKE'
                    ),
                    array(
                        'key'     => 'events_date',
                        'compare' => '<',
                        'value'   => date( 'Ymd' ),
                        'type'    => 'DATE'
                    )
                )
            ];

            $posts = new WP_Query( $args );

            // Old events
            if ( $posts->have_posts() ) :

                echo '<div class="' . $class . ' events-list old-events-list">';

                    if ( $posts->post_count >= 3 ) {
                        echo '<h3>Eventos Passados <a href="' . esc_url( home_url() . '/artigos?territorio=' ) . $id . '">Veja todos eventos</a></h3>';
                    } else {
                        echo '<h3>Eventos Passados</h3>';
                    }            

                    while ( $posts->have_posts() ) :
                        $posts->the_post();                

                        get_template_part( 'template-parts/content', 'list' );

                    endwhile;
                
                    wp_reset_postdata();

                echo '</div><!-- /.events-list.old-events-list -->';

            endif;

        endif; // Endif $posts->have_posts()

    }
    
}