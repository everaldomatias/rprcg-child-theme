<?php

if ( class_exists( 'CPT' ) ) :

    $arguments = [
        'show_in_rest' => true, // Enable Gutenberg
        'supports'     => [ 'title', 'editor', 'thumbnail' ],
    ];

    $territories = new CPT( [
        'post_type_name' => 'territories',
        'singular'       => 'Território',
        'plural'         => 'Territórios',
        'slug'           => 'territorios'
    ], $arguments );

    $territories->menu_icon( 'dashicons-admin-site' );

endif;


// Functions

if ( ! function_exists( 'auto_create_category_territories' ) ) {

    /**
     * 
     * Create category with territory is create or updated
     * 
     * @author  Everaldo Matias
     * @link    https://everaldo.dev
     * 
     * @version 1.0
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * 
     * @see     https://developer.wordpress.org/reference/hooks/save_post/
     * @see     https://developer.wordpress.org/reference/functions/wp_insert_term/
     * 
     */

    function auto_create_category_territories( $post_ID, $post, $update ) {

        // Only set for post_type = territories!
        if ( 'territories' !== $post->post_type ) {
            return;
        }

        $title = get_the_title( $post_ID );
        wp_insert_term( $title, 'category', ['slug' => $title] );

    }

    add_action( 'save_post', 'auto_create_category_territories', 10, 3 );

}