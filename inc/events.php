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

    $events->register_taxonomy( [
        'taxonomy_name'      => 'event_terms',
        'singular'           => 'Categoria',
        'plural'             => 'Categorias',
        'slug'               => 'arquivo'
    ], [
        // 'public'             => false,
        // 'publicly_queryable' => true,
        // 'show_admin_column'  => false,
        // 'show_in_quick_edit' => false,
        // 'show_ui'            => false,
        // 'show_in_menu'       => false
    ] );

endif;

if ( ! function_exists( 'territories_loop_events' ) ) {

    function territories_loop_events( $id, $class = 'col-sm-6' ) {
        
        $args = [
            'post_type'      => 'events',
            'posts_per_page' => 2,
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

                if ( $posts->post_count >= 2 ) {
                    echo '<h3>Eventos <a href="' . esc_url( home_url() . '/eventos?territorio=' ) . $id . '">Veja todos eventos</a></h3>';
                } else {
                    echo '<h3>Eventos</h3>';
                }            

                while ( $posts->have_posts() ) :
                    $posts->the_post();                

                    get_template_part( 'template-parts/content', 'event' );

                endwhile;
            
                wp_reset_postdata();

            echo '</div><!-- /.events-list -->';

        else :

            $args = [
                'post_type'      => 'events',
                'posts_per_page' => 2,
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

                    if ( $posts->post_count >= 2 ) {
                        echo '<h3>Eventos Passados <a href="' . esc_url( home_url() . '/eventos?territorio=' ) . $id . '">Veja todos eventos</a></h3>';
                    } else {
                        echo '<h3>Eventos Passados</h3>';
                    }            

                    while ( $posts->have_posts() ) :
                        $posts->the_post();                

                        get_template_part( 'template-parts/content', 'event' );

                    endwhile;
                
                    wp_reset_postdata();

                echo '</div><!-- /.events-list.old-events-list -->';

            endif;

        endif; // Endif $posts->have_posts()

    }
    
}

if ( ! function_exists( 'territories_loop_past_events' ) ) {

    function territories_loop_past_events( $class = 'col-sm-6' ) {

        $what_territories = null;
        if ( isset( $_GET['territorio'] ) ) {
            $what_territories = sanitize_text_field( $_GET['territorio'] );
        }

        $args = [
            'post_type'      => 'events',
            'posts_per_page' => 2,
            'post_status'    => 'publish',
            'tax_query' => [
                [
                'taxonomy' => 'event_terms',
                'field'    => 'slug',
                'terms'    => 'passados',
                'operator' => 'EXISTS'
                ]
            ],
            'meta_query'     => [
                [
                'key'		=> 'what_territories',
                'value'		=> $what_territories,
                'compare'	=> 'LIKE'
                ]
            ]


        ];

        $posts = new WP_Query( $args );

        // Past events
        if ( $posts->have_posts() ) :

            echo '<div class="' . $class . ' events-list past-events-list">';

                echo '<h3>Eventos Passados</h3>';     

                while ( $posts->have_posts() ) :
                    $posts->the_post();                

                    get_template_part( 'template-parts/content', 'event' );

                endwhile;
            
                wp_reset_postdata();

                echo '<div class="link-all-past-events">';
                    echo '<a class="btn btn-theme-primary btn-sm" href="' . esc_url( home_url() ) . '/arquivo/passados/">Veja todos eventos passados</a>';
                echo '</div><!-- /.link-all-past-events -->';

            echo '</div><!-- /.events-list.past-events-list -->';
        
        endif; // Endif $posts->have_posts()

    }
    
}

if ( ! function_exists( 'print_events_meta' ) ) {

    function print_events_meta() {
        $id = get_the_ID();
        if ( 'events' == get_post_type( $id ) ) {

            $events_date             = get_post_meta( $id, 'events_date', true );
            $events_date_end         = get_post_meta( $id, 'events_date_end', true );
            $events_hour             = get_post_meta( $id, 'events_hour', true );
            $events_hour_end         = get_post_meta( $id, 'events_hour_end', true );
            $events_hour_alternative = get_post_meta( $id, 'events_hour_alternative', true );
            $events_local            = get_post_meta( $id, 'events_local', true );
            $events_address          = get_post_meta( $id, 'events_address', true );
            
            // Date
            if ( isset( $events_date ) && ! empty( $events_date ) ) {

                $events_date_timestamp = strtotime( $events_date );
                $events_date = date( "d/m/Y", $events_date_timestamp );

                echo '<div class="events-date"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M452 40h-24V0h-40v40H124V0H84v40H60C26.9 40 0 66.9 0 100v352c0 33.1 26.9 60 60 60h392c33.1 0 60-26.9 60-60V100C512 66.9 485.1 40 452 40zM472 452c0 11-9 20-20 20H60c-11 0-20-9-20-20V188h432V452zM472 148H40v-48c0-11 9-20 20-20h24v40h40V80h264v40h40V80h24c11 0 20 9 20 20V148z"/><rect x="76" y="230" width="40" height="40"/><rect x="156" y="230" width="40" height="40"/><rect x="236" y="230" width="40" height="40"/><rect x="316" y="230" width="40" height="40"/><rect x="396" y="230" width="40" height="40"/><rect x="76" y="310" width="40" height="40"/><rect x="156" y="310" width="40" height="40"/><rect x="236" y="310" width="40" height="40"/><rect x="316" y="310" width="40" height="40"/><rect x="76" y="390" width="40" height="40"/><rect x="156" y="390" width="40" height="40"/><rect x="236" y="390" width="40" height="40"/><rect x="316" y="390" width="40" height="40"/><rect x="396" y="310" width="40" height="40"/></svg>';
                echo esc_html( $events_date );

                if ( isset( $events_date_end ) && ! empty( $events_date_end ) ) {

                    $events_date_end_timestamp = strtotime( $events_date_end );
                    $events_date_end = date( "d/m/Y", $events_date_end_timestamp );

                    echo ' a ' . esc_html( $events_date_end );

                }

                echo '</div>';

            }

            // Hours
            if ( isset( $events_hour_alternative ) && ! empty( $events_hour_alternative ) ) {

                echo '<div class="events-hour">';
                echo '<svg id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><g><path d="m256 512c-68.38 0-132.667-26.629-181.02-74.98-48.351-48.353-74.98-112.64-74.98-181.02s26.629-132.667 74.98-181.02c48.353-48.351 112.64-74.98 181.02-74.98s132.667 26.629 181.02 74.98c48.351 48.353 74.98 112.64 74.98 181.02s-26.629 132.667-74.98 181.02c-48.353 48.351-112.64 74.98-181.02 74.98zm0-482c-60.367 0-117.12 23.508-159.806 66.194s-66.194 99.439-66.194 159.806 23.508 117.12 66.194 159.806 99.439 66.194 159.806 66.194 117.12-23.508 159.806-66.194 66.194-99.439 66.194-159.806-23.508-117.12-66.194-159.806-99.439-66.194-159.806-66.194z"/></g><g><path d="m241 60.036h30v40.032h-30z"/></g><g><path d="m360.398 116.586h40.032v30h-40.032z" transform="matrix(.707 -.707 .707 .707 18.375 307.534)"/></g><g><path d="m411.932 241h40.032v30h-40.032z"/></g><g><path d="m365.414 360.398h30v40.032h-30z" transform="matrix(.707 -.707 .707 .707 -157.573 380.414)"/></g><g><path d="m241 411.932h30v40.032h-30z"/></g><g><path d="m111.57 365.414h40.032v30h-40.032z" transform="matrix(.707 -.707 .707 .707 -230.453 204.466)"/></g><g><path d="m60.036 241h40.032v30h-40.032z"/></g><g><path d="m116.586 111.57h30v40.032h-30z" transform="matrix(.707 -.707 .707 .707 -54.505 131.586)"/></g><g><path d="m361.892 271h-120.892v-120.892h30v90.892h90.892z"/></g></g></svg>';
                echo '<div>' . esc_html( $events_hour_alternative ) . '</div>';
                echo '</div>';

            } elseif ( isset( $events_hour ) && ! empty( $events_hour ) ) {

                $events_hour_timestamp = strtotime( $events_hour );
                $events_hour = date( "G:i", $events_hour_timestamp );

                echo '<div class="events-hour"><svg id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><g><path d="m256 512c-68.38 0-132.667-26.629-181.02-74.98-48.351-48.353-74.98-112.64-74.98-181.02s26.629-132.667 74.98-181.02c48.353-48.351 112.64-74.98 181.02-74.98s132.667 26.629 181.02 74.98c48.351 48.353 74.98 112.64 74.98 181.02s-26.629 132.667-74.98 181.02c-48.353 48.351-112.64 74.98-181.02 74.98zm0-482c-60.367 0-117.12 23.508-159.806 66.194s-66.194 99.439-66.194 159.806 23.508 117.12 66.194 159.806 99.439 66.194 159.806 66.194 117.12-23.508 159.806-66.194 66.194-99.439 66.194-159.806-23.508-117.12-66.194-159.806-99.439-66.194-159.806-66.194z"/></g><g><path d="m241 60.036h30v40.032h-30z"/></g><g><path d="m360.398 116.586h40.032v30h-40.032z" transform="matrix(.707 -.707 .707 .707 18.375 307.534)"/></g><g><path d="m411.932 241h40.032v30h-40.032z"/></g><g><path d="m365.414 360.398h30v40.032h-30z" transform="matrix(.707 -.707 .707 .707 -157.573 380.414)"/></g><g><path d="m241 411.932h30v40.032h-30z"/></g><g><path d="m111.57 365.414h40.032v30h-40.032z" transform="matrix(.707 -.707 .707 .707 -230.453 204.466)"/></g><g><path d="m60.036 241h40.032v30h-40.032z"/></g><g><path d="m116.586 111.57h30v40.032h-30z" transform="matrix(.707 -.707 .707 .707 -54.505 131.586)"/></g><g><path d="m361.892 271h-120.892v-120.892h30v90.892h90.892z"/></g></g></svg>';
                echo esc_html( $events_hour );

                if ( isset( $events_hour_end ) && ! empty( $events_hour_end ) ) {

                    $events_hour_end_timestamp = strtotime( $events_hour_end );
                    $events_hour_end = date( "G:i", $events_hour_end_timestamp );

                    echo ' às ' . esc_html( $events_hour_end );

                }
                echo '</div>';

            }

            // Location
            if ( isset( $events_local ) && ! empty( $events_local ) ) {
                
                echo '<div class="events-location"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C156.7 0 76 80.7 76 180c0 33.5 9.3 66.3 26.9 94.7l142.9 230.3c2.7 4.4 7.6 7.1 12.7 7.1 0 0 0.1 0 0.1 0 5.2 0 10.1-2.8 12.8-7.3L410.6 272.2C427.2 244.4 436 212.5 436 180 436 80.7 355.3 0 256 0zM384.9 256.8L258.3 468.2l-129.9-209.3C113.7 235.2 105.8 208 105.8 180c0-82.7 67.5-150.2 150.2-150.2S406.1 97.3 406.1 180C406.1 207.1 398.7 233.7 384.9 256.8z"/><path d="M256 90c-49.6 0-90 40.4-90 90 0 49.3 39.7 90 90 90 50.9 0 90-41.2 90-90C346 130.4 305.6 90 256 90zM256 240.2c-33.3 0-60.2-27-60.2-60.2 0-33.1 27.1-60.2 60.2-60.2s60.1 27.1 60.1 60.2C316.1 212.7 289.8 240.2 256 240.2z"/></svg>';
                echo esc_html( $events_local );
                echo '</div>';

            }
            
        }

    }

}

if ( ! function_exists( 'events_pre_get_posts' ) ) {

    /**
     * 
     * WordPress function for filter posts Events with GET parameter in archive
     * 
     * @author  Everaldo Matias
     * @link    https://everaldo.dev
     * 
     * @version 1.0
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * 
     * @see     https://codex.wordpress.org/Class_Reference/WP_Meta_Query
     * @see     https://developer.wordpress.org/reference/hooks/pre_get_posts
     * 
     * @param   string,integer  $id of the attachment
     * 
     */
    function events_pre_get_posts( $query ) {
        
        // do not modify queries in the admin
        if ( is_admin() ) {
            return $query;
        }
        
        // only modify queries for 'events' post type
        if ( $query->is_main_query() && isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] == 'events' ) {
            
            // allow the url to alter the query
            if ( isset( $_GET['territorio'] ) ) {

                $meta_query[] = array(
                    'key'		=> 'what_territories',
                    'value'		=> sanitize_text_field( $_GET['territorio'] ),
                    'compare'	=> 'LIKE',
                );

                // update meta query
                $query->set( 'meta_query', $meta_query );
                
            } elseif ( is_post_type_archive( 'events' ) ) {

                // update query
                $query->set( 'meta_key', 'events_date' );
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'order', 'ASC' );
                
                $meta_query[] = array(
                    'key'     => 'events_date',
                    'compare' => '>=',
                    'value'   => date( 'Ymd' ),
                    'type'    => 'DATE'
                );

                // update meta query
                $query->set( 'meta_query', $meta_query );

            }
            
        }

        return $query;

    }

    add_action( 'pre_get_posts', 'events_pre_get_posts' );

}

/**
 * 
 * Add WP cron event to add taxonomy term on past events
 * 
 * @see http://codex.wordpress.org/Plugin_API/Filter_Reference/cron_schedules
 * @see https://codex.wordpress.org/Easier_Expression_of_Time_Constants
 * 
 */

add_filter( 'cron_schedules', 'events_add_cron_schedule' );
function events_add_cron_schedule( $schedules ) {
    
    $schedules['twicedaily'] = array(
        'interval' => 43200, // 12 hours in seconds
        'display'  => __( 'Twice a day' ),
    );
 
    return $schedules;

}
 
// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'events_cron_action' ) ) {

    wp_schedule_event( time(), 'twicedaily', 'events_cron_action' );

}
 
if ( ! function_exists( 'events_set_past_posts' ) ) {

    // Hook into that action that'll fire twicedaily
    add_action( 'events_cron_action', 'events_set_past_posts' );

    function events_set_past_posts() {

        $args = [
            'post_type'      => 'events',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'tax_query' => [
                [
                    'taxonomy' => 'event_terms',
                    'field'    => 'slug',
                    'terms'    => 'passados',
                    'operator' => 'NOT EXISTS',
                ]
            ],
            'meta_key'       => 'events_date',
            'meta_query'     => [
                [
                    'key'     => 'events_date',
                    'compare' => '<',
                    'value'   => date( 'Ymd' ),
                    'type'    => 'DATE'
                ]
            ]
        ];

        $posts = new WP_Query( $args );

        if ( $posts->have_posts() ) :

            $term = term_exists( 'Passados', 'event_terms' ); 
            if ( $term == 0 && $term == null ) {
                wp_insert_term( 'Passados', 'event_terms', ['slug' => 'passados'] );
            }
            
            while ( $posts->have_posts() ) :
                $posts->the_post();

                $wp_set_object_terms = wp_set_object_terms( get_the_ID(), 'passados', 'event_terms' );
            
            endwhile;
        
            wp_reset_postdata();

        endif;

    }

}
