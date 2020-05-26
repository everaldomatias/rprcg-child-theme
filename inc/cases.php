<?php

if ( class_exists( 'CPT' ) ) :

    $arguments = [
        'show_in_rest' => true, // Enable Gutenberg
        'supports'     => [ 'title', 'editor', 'thumbnail' ],
        'has_archive'  => true
    ];

    $cases = new CPT( [
        'post_type_name' => 'cases',
        'singular'       => 'Caso',
        'plural'         => 'Casos',
        'slug'           => 'casos'
    ], $arguments );

    $cases->menu_icon( 'dashicons-grid-view' );

endif;

/**
 * Print the loop cases
 */
function territories_loop_cases( $id, $class = 'col-sm-6' ) {
    
    echo '<div class="' . $class . ' cases-list">';

        $args = [
            'post_type'      => 'cases',
            'posts_per_page' => 4,
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

        $cases = new WP_Query( $args );

        if ( $cases->have_posts() ) :

            if ( $cases->post_count >= 4 ) {
                echo '<h3>Casos <a href="' . esc_url( home_url() . '/casos?territorio=' ) . $id . '">Veja todos os casos</a></h3>';
            } else {
                echo '<h3>Casos</h3>';
            }

            while ( $cases->have_posts() ) :
                $cases->the_post();                

                echo '<a href="' . esc_url( get_the_permalink() ) . '">';

                    echo '<div ' . thumbnail_bg() . ' class="col-sm-12 each">';
                        echo '<h3>' . apply_filters( 'the_title', get_the_title() ) . '</h3>';
                        $what_territories = get_post_meta( get_the_ID(), 'what_territories' );
                    echo '</div><!-- /.each -->';
                        
                echo '</a>';

            endwhile;

            wp_reset_postdata();

        endif; // Endif $cases->have_posts()

    echo '</div>';
}


if ( ! function_exists( 'cases_pre_get_posts' ) ) {

    /**
     * 
     * WordPress function for filter posts Cases with GET parameter
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
    function cases_pre_get_posts( $query ) {
        
        // do not modify queries in the admin
        if ( is_admin() ) {
            return $query;
        }
        
        // only modify queries for 'cases' post type
        if ( isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] == 'cases' ) {
            
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

    add_action( 'pre_get_posts', 'cases_pre_get_posts' );

}