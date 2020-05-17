<?php

if ( class_exists( 'CPT' ) ) :

    $arguments = [
        'show_in_rest' => true, // Enable Gutenberg
        'supports'     => [ 'title', 'editor', 'thumbnail' ],
        'has_archive'  => true
    ];

    $downloads = new CPT( [
        'post_type_name' => 'downloads',
        'singular'       => 'Download',
        'plural'         => 'Downloads',
        'slug'           => 'downloads'
    ], $arguments );

    $downloads->menu_icon( 'dashicons-download' );

endif;