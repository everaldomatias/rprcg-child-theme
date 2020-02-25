<?php

if ( class_exists( 'CPT' ) ) :

    $arguments = [
        'show_in_rest' => true, // Enable Gutenberg
        'supports'     => [ 'title', 'editor', 'thumbnail' ],
    ];

    $territories = new CPT( [
        'post_type_name' => 'courses',
        'singular'       => 'Curso',
        'plural'         => 'Cursos',
        'slug'           => 'cursos'
    ], $arguments );

    $territories->menu_icon( 'dashicons-book-alt' );

endif;