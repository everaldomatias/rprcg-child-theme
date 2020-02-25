<?php

if ( class_exists( 'CPT' ) ) :

    $arguments = [
        'show_in_rest' => true, // Enable Gutenberg
        'supports'     => [ 'title', 'editor', 'thumbnail' ],
    ];

    $territories = new CPT( [
        'post_type_name' => 'cases',
        'singular'       => 'Caso',
        'plural'         => 'Casos',
        'slug'           => 'casos'
    ], $arguments );

    $territories->menu_icon( 'dashicons-grid-view' );

endif;