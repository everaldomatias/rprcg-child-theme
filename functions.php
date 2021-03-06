<?php

/**
 * Customizer Fields
 */
include_once( 'inc/customizer.php' );

/**
 * CPT Class
 */
include_once( 'classes/CPT.php' );

/**
 * Posts (News)
 */
include_once( 'inc/news.php' );

/**
 * CPT Territories (Territórios)
 */
include_once( 'inc/territories.php' );

/**
 * CPT Articles
 */
include_once( 'inc/articles.php' );

/**
 * CPT Courses (Cursos)
 */
include_once( 'inc/courses.php' );

/**
 * CPT Cases (Casos)
 */
include_once( 'inc/cases.php' );

/**
 * CPT Events
 */
include_once( 'inc/events.php' );

/**
 * CPT Downloads
 */
include_once( 'inc/downloads.php' );

// Functions

if ( ! function_exists( 'get_excerpt' ) ) {

    /**
     * 
     * Function get_excerpt
     * 
     * @author Everaldo Matias
     * @link https://everaldo.dev
     *
     * @since  0.1
     *
     * @param  string $content with text to excerpt.
     * @param  string $limit number of the limit.
     * @param  string $after with element to print in end excerpt.
     *
     * @return string
     * 
     */
    function get_excerpt( $content = '', $limit = '', $after = '' ) {
        
        if ( $limit ) {
            $l = $limit;
        } else {
            $l = '140';
        }
    
        if ( $content ) {
            $excerpt = $content;
        } else {
            $excerpt = get_the_content();
        }
    
        $excerpt = preg_replace( " (\[.*?\])",'', $excerpt );
        $excerpt = strip_shortcodes( $excerpt );
        $excerpt = strip_tags( $excerpt );
        $excerpt = substr( $excerpt, 0, $l );
        $excerpt = substr( $excerpt, 0, strripos( $excerpt, " " ) );
        $excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
        
        if ( $after ) {
            $a = $after;
        } else {
            $a = '...';
        }
    
        $excerpt = $excerpt . $a;
        return $excerpt;
    }

}

if ( ! function_exists( 'thumbnail_bg' ) ) {

    
    /**
     * 
     * Function to print thumbnail on bg div
     * 
     * @author  Everaldo Matias
     * @link    https://everaldo.dev
     * 
     * @version 1.0
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * 
     * @see     https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
     * @see     https://developer.wordpress.org/reference/functions/get_post_thumbnail_id/
     * @see     https://brasa.art.br/post-thumbnail-como-background/
     * 
     * @param   string,integer  $size of the thumbnail
     * 
     */
    function thumbnail_bg( $size = 'thumbnail' ) {
        
        global $post;
        $get_post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size, false, '' );
        
        return 'style="background-image: url(' . esc_url( $get_post_thumbnail[0] ) . ' )"';
    }

}

if ( ! function_exists( 'the_file_size' ) ) {

    /**
     * 
     * WordPress function for get file size in attachment
     * 
     * @author  Everaldo Matias
     * @link    https://everaldo.dev
     * 
     * @version 1.0
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * 
     * @see     https://developer.wordpress.org/reference/functions/get_attached_file/
     * @see     https://www.php.net/manual/pt_BR/function.filesize.php
     * 
     * @param   string,integer  $id of the attachment
     * 
     */

    function the_file_size( $id ) {

        // Get the file path
        $file_path = get_attached_file( $id );

        // Get the file size
        $file_size = filesize( $file_path );

        // Return file size in megabytes
        $file_size = round( $file_size / 1024 / 1024, 1 );

        echo $file_size . ' MB';

    }
    
}

if ( ! function_exists( 'filter_get_the_archive_title' ) ) {

	/**
     * 
     * Filter the archives title
     * 
     * @author  Everaldo Matias
     * @link    https://everaldo.dev
     * 
     * @version 1.0
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * 
     * @see     https://developer.wordpress.org/reference/functions/get_the_archive_title/
     * @see     https://developer.wordpress.org/reference/functions/is_post_type_archive/
	 * @see		https://developer.wordpress.org/reference/functions/post_type_archive_title/
     * 
     * @param   string $title to filter
     * 
     */

	function filter_get_the_archive_title( $title ) {

		if ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}

		return $title;

	}

	add_filter( 'get_the_archive_title', 'filter_get_the_archive_title' );

}
