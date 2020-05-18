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

if ( ! function_exists( 'tm_download_single_redirect' ) ) {

    function tm_download_single_redirect() {

        if ( ! is_singular( 'downloads' ) )
            return;

        wp_redirect( get_post_type_archive_link( 'downloads' ), 301 );

        exit;

    }

    add_action( 'template_redirect', 'tm_download_single_redirect' );

}