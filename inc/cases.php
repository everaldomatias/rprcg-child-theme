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

    function cases_pre_get_posts( $query ) {
        
        // do not modify queries in the admin
        if ( is_admin() ) {
            return $query;
        }
        
        // only modify queries for 'event' post type
        if ( isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] == 'cases' ) {
            
            // allow the url to alter the query
            if ( isset( $_GET['what_territories'] ) ) {

                $meta_query[] = array(
                    'key'		=> 'what_territories',
                    'value'		=> sanitize_text_field( $_GET['what_territories'] ),
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