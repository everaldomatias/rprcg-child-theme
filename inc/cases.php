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
        
        // only modify queries for 'event' post type
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