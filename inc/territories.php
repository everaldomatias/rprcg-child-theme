<?php

if ( class_exists( 'CPT' ) ) :

    $arguments = [
        'show_in_rest' => true, // Enable Gutenberg
        'supports'     => [ 'title', 'editor', 'thumbnail' ],
        'has_archive'  => true
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

    //add_action( 'save_post', 'auto_create_category_territories', 10, 3 );

}




// Ajax

function territories_register_ajax() {

	if ( is_home() || is_front_page() ) {
		wp_enqueue_script( 'territories', get_stylesheet_directory_uri() . '/assets/js/territories.js', array( 'jquery' ) );
		wp_localize_script( 'territories', 'territoriesajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
}
add_action( 'wp_enqueue_scripts', 'territories_register_ajax' );

add_action( 'wp_ajax_nopriv_territories_get_post_ajax', 'territories_get_post_ajax' );
add_action( 'wp_ajax_territories_get_post_ajax', 'territories_get_post_ajax' );

function territories_get_post_ajax() {

   $territoriesid = esc_attr( $_POST['territoriesid'] );
  
   $results = territories_return_html( $territoriesid );
   die( $results );

}

function territories_return_html( $territoriesid ) {

    $color = get_post_meta( $territoriesid, 'territories_color', true );

    $territory = get_post( $territoriesid );

    echo '<div class="col-sm-12">';

        echo '<h2 class="title">' . apply_filters( 'the_title', $territory->post_title ) . '<a href="' . esc_url( get_the_permalink( $territoriesid ) ) . '">Veja tudo sobre o território</a></h2>';

        if ( $territory->post_content ) {

            echo '<div class="summary">';
                echo get_excerpt( $territory->post_content, 600 );
            echo '</div><!-- /.summary -->';

        }

    echo '</div>';

    echo '<div class="col-sm-6 news-list">';

        $args = [
            'post_type'      => 'post',
            'posts_per_page' => 6,
            'order'          => 'DESC',
            'post_status'    => 'publish',
            'meta_query'	=> array(
                array(
                    'key'		=> 'what_territories',
                    'value'		=> $territory->ID,
                    'compare'	=> 'LIKE'
                )
            )
        ];

        $posts = new WP_Query( $args );

        if ( $posts->have_posts() ) :

            echo '<h3>Notícias</h3>';

            echo '<div class="row">';

                while ( $posts->have_posts() ) :
                    $posts->the_post();                

                    echo '<a href="' . esc_url( get_the_permalink() ) . '">';

                        echo '<div class="col-sm-12 each">';

                            if ( has_post_thumbnail() ) {
                                echo '<div class="col-sm-2 thumbnail no-padding">';
                                    the_post_thumbnail( 'thumbnail' );
                                echo '</div><!-- /.thumbnail -->';

                                echo '<div class="col-sm-10 desc">';
                            } else {
                                echo '<div class="col-sm-12 desc">';
                            }

                            echo '<h3>' . apply_filters( 'the_title', get_the_title() ) . '</h3>';
                            echo '<span style="color:' . $color . ';">' . get_the_date() . '</span>';

                            echo '</div><!-- /.desc -->';

                        echo '</div><!-- /.each -->';

                    echo '</a>';

                endwhile;

            echo '</div><!-- /.row -->';
            
            wp_reset_postdata();


        endif; // Endif $posts->have_posts()


    echo '</div>';

    echo '<div class="col-sm-6 cases-list">';

        $args = [
            'post_type'      => 'cases',
            'posts_per_page' => 4,
            'order'          => 'DESC',
            'post_status'    => 'publish',
            'meta_query'	=> array(
                array(
                    'key'		=> 'what_territories',
                    'value'		=> $territory->ID,
                    'compare'	=> 'LIKE'
                )
            )
        ];

        $cases = new WP_Query( $args );

        if ( $cases->have_posts() ) :

            echo '<h3>Casos</h3>';

            while ( $cases->have_posts() ) :
                $cases->the_post();                

                echo '<a href="' . esc_url( get_the_permalink() ) . '">';

                    echo '<div ' . thumbnail_bg() . ' class="col-sm-12 each">';
                        echo '<h3>' . apply_filters( 'the_title', get_the_title() ) . '</h3>';
                    echo '</div><!-- /.each -->';
                        
                echo '</a>';

            endwhile;

            wp_reset_postdata();

        endif; // Endif $cases->have_posts()

    echo '</div>';

    echo '<div class="col-sm-12 courses-list">';

        $args = [
            'post_type'      => 'courses',
            'posts_per_page' => 2,
            'order'          => 'DESC',
            'post_status'    => 'publish',
            'meta_query'	=> array(
                array(
                    'key'		=> 'what_territories',
                    'value'		=> $territory->ID,
                    'compare'	=> 'LIKE'
                )
            )
        ];

        $courses = new WP_Query( $args );

        if ( $courses->have_posts() ) :

            echo '<h3>Cursos</h3>';

                while ( $courses->have_posts() ) :
                    $courses->the_post();                

                    echo '<a href="' . esc_url( get_the_permalink() ) . '">';

                        echo '<div class="col-sm-12 each">';
                            echo '<h3>' . apply_filters( 'the_title', get_the_title() ) . '</h3>';
                            echo '<div class="col-sm-12 desc no-padding">';
                                echo get_excerpt( get_the_content(), 400 );
                            echo '</div><!-- /.desc -->';
                        echo '</div><!-- /.each -->';
                            
                    echo '</a>';

                endwhile;
            
            wp_reset_postdata();

        endif; // Endif $courses->have_posts()

    echo '</div>';

}

