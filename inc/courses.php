<?php

if ( class_exists( 'CPT' ) ) :

    $arguments = [
        'show_in_rest' => true, // Enable Gutenberg
        'supports'     => [ 'title', 'editor', 'thumbnail' ],
        'has_archive'  => true
    ];

    $courses = new CPT( [
        'post_type_name' => 'courses',
        'singular'       => 'Curso',
        'plural'         => 'Cursos',
        'slug'           => 'cursos'
    ], $arguments );

    $courses->menu_icon( 'dashicons-book-alt' );

endif;

/**
 * Print the loop courses
 */
function territories_loop_courses( $id, $class = 'col-sm-6' ) {

    echo '<div class="' . $class . ' courses-list">';

        $args = [
            'post_type'      => 'courses',
            'posts_per_page' => 2,
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

        $courses = new WP_Query( $args );

        if ( $courses->have_posts() ) :

            if ( $courses->post_count >= 2 ) {
                echo '<h3>Cursos <a href="' . esc_url( home_url() . '/cursos?territorio=' ) . $id . '">Veja todos os cursos</a></h3>';
            } else {
                echo '<h3>Cursos</h3>';
            }

            while ( $courses->have_posts() ) :
                $courses->the_post();                

                echo '<a href="' . esc_url( get_the_permalink() ) . '">';

                    echo '<div class="col-sm-12 each">';
                        echo '<h3>' . apply_filters( 'the_title', get_the_title() ) . '</h3>';
                        echo '<div class="col-sm-12 desc no-padding">';
                            echo get_excerpt( get_the_content(), 400 );
                        echo '</div><!-- /.desc -->';
                    echo '</div><!-- /.each -->';
                        
                echo '</a>';

            endwhile;
            
            wp_reset_postdata();

        endif; // Endif $courses->have_posts()

    echo '</div>';

}

if ( ! function_exists( 'courses_pre_get_posts' ) ) {

    /**
     * 
     * WordPress function for filter posts Courses with GET parameter
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
    function courses_pre_get_posts( $query ) {
        
        // do not modify queries in the admin
        if ( is_admin() ) {
            return $query;
        }
        
        // only modify queries for 'courses' post type
        if ( isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] == 'courses' ) {
            
            // allow the url to alter the query
            if ( isset( $_GET['territorio'] ) ) {

                $meta_query[] = array(
                    'key'		=> 'what_territories',
                    'value'		=> sanitize_text_field( $_GET['territorio'] ),
                    'compare'	=> 'LIKE',
                );

                // update meta query
                $query->set( 'meta_query', $meta_query );
                
            } 
            
        }

        return $query;

    }

    add_action( 'pre_get_posts', 'courses_pre_get_posts' );

}

if ( ! function_exists( 'print_territories_attached' ) ) {

    function print_territories_attached() {

        $post_type = get_post_type();

        if ( $post_type == 'courses' ) {

            // continue...

        }

    }

    add_action( 'after_entry_header_content_list', 'print_territories_attached' );

}