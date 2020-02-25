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