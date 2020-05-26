<?php

function territories_loop_news( $id, $class = 'col-sm-6' ) {

    echo '<div class="' . $class . ' news-list">';

        $args = [
            'post_type'      => 'post',
            'posts_per_page' => 6,
            'order'          => 'DESC',
            'post_status'    => 'publish',
            'meta_query'	=> array(
                array(
                    'key'		=> 'what_territories',
                    'value'		=> $id,
                    'compare'	=> 'LIKE'
                )
            )
        ];

        $posts = new WP_Query( $args );

        if ( $posts->have_posts() ) :

            if ( $posts->post_count >= 6 ) {
                echo '<h3>Notícias <a href="' . esc_url( home_url() . '/' . get_permalink( get_option( 'page_for_posts' ) ) . '?territorio=' ) . $id . '">Veja todas notícias</a></h3>';
            } else {
                echo '<h3>Notícias</h3>';
            }            

            while ( $posts->have_posts() ) :
                $posts->the_post();                

                get_template_part( 'template-parts/content', 'list' );

            endwhile;
         
            wp_reset_postdata();

        endif; // Endif $posts->have_posts()

    echo '</div>';

}

if ( ! function_exists( 'news_pre_get_posts' ) ) {

    /**
     * 
     * WordPress function for filter posts Post with GET parameter
     * 
     * @author  Everaldo Matias
     * @link    https://everaldo.dev
     * 
     * @version 1.0
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * 
     * @see     https://codex.wordpress.org/Class_Reference/WP_Meta_Query
     * @see     https://developer.wordpress.org/reference/hooks/pre_get_posts
     * 
     * @param   string,integer  $id of the attachment
     * 
     */
    function news_pre_get_posts( $query ) {
        
        // do not modify queries in the admin
        if ( is_admin() ) {
            return $query;
        }

        // only modify queries for 'post' post type
        if ( isset( $query->is_home ) && $query->is_home ) {

            // allow the url to alter the query
            if ( isset( $_GET['territorio'] ) ) {

                $meta_query[] = array(
                    'key'		=> 'what_territories',
                    'value'		=> sanitize_text_field( $_GET['territorio'] ),
                    'compare'	=> 'LIKE',
                );

                // update meta query
                $query->set( 'meta_query', $meta_query );
                
            } 
            
        }

        return $query;

    }

    add_action( 'pre_get_posts', 'news_pre_get_posts' );

}