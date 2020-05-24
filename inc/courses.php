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

if ( ! function_exists( 'print_territories_attached' ) ) {

    function print_territories_attached() {

        $post_type = get_post_type();

        if ( $post_type == 'courses' ) {

            // continue...

        }

    }

    add_action( 'after_entry_header_content_list', 'print_territories_attached' );

}