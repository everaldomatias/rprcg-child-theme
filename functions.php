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
 * CPT Territories (Territórios)
 */
include_once( 'inc/territories.php' );

/**
 * CPT Courses (Cursos)
 */
include_once( 'inc/courses.php' );

/**
 * CPT Cases (Casos)
 */
include_once( 'inc/cases.php' );


// Functions

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


/**
 * 
 */
function thumbnail_bg( $size = 'thumbnail' ) {
	global $post;
	$get_post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size, false, '' );
	return 'style="background-image: url(' . esc_url( $get_post_thumbnail[0] ) . ' )"';
}