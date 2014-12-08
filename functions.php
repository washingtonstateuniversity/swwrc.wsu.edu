<?php

/**
 * Include the functionality used to load the home page's headline
 * and video background features.
 */
include_once( __DIR__ . '/includes/plugin-swwrc-video.php' );

add_action( 'wp_enqueue_scripts', 'swwrc_child_enqueue_scripts', 11 );
/**
 * Enqueue custom scripting in child theme.
 */
function swwrc_child_enqueue_scripts() {
	wp_enqueue_script( 'swwrc-videobg', get_stylesheet_directory_uri() . '/js/jQuery.videobg.js', array( 'jquery' ), spine_get_script_version(), true );
	wp_enqueue_script( 'swwrc-custom', get_stylesheet_directory_uri() . '/custom.js', array( 'jquery' ), spine_get_script_version(), true );
}
if ( ! function_exists( 'wpse0001_custom_wp_trim_excerpt' ) ) : 

    function wpse0001_custom_wp_trim_excerpt($wpse0001_excerpt) {
        global $post;
        $raw_excerpt = $wpse0001_excerpt;
        if ( '' == $wpse0001_excerpt ) {

            $wpse0001_excerpt = get_the_content('');
            $wpse0001_excerpt = strip_shortcodes( $wpse0001_excerpt );
            $wpse0001_excerpt = apply_filters('the_content', $wpse0001_excerpt);
            $wpse0001_excerpt = substr( $wpse0001_excerpt, 0, strpos( $wpse0001_excerpt, '</p>' ) + 4 );
            $wpse0001_excerpt = str_replace(']]>', ']]&gt;', $wpse0001_excerpt);

            $excerpt_end = ' <a href="'. esc_url( get_permalink() ) . '">' . '&nbsp;&raquo;&nbsp;' . sprintf(__( 'Read more about: %s &nbsp;&raquo;', 'pietergoosen' ), get_the_title()) . '</a>'; 
            $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end); 

            //$pos = strrpos($wpse0001_excerpt, '</');
            //if ($pos !== false)
                // Inside last HTML tag
                //$wpse0001_excerpt = substr_replace($wpse0001_excerpt, $excerpt_end, $pos, 0);
            //else
                // After the content
            $wpse0001_excerpt .= $excerpt_end;

            return $wpse0001_excerpt;

        }
        return apply_filters('wpse0001_custom_wp_trim_excerpt', $wpse0001_excerpt, $raw_excerpt);
    }

endif; 

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wpse0001_custom_wp_trim_excerpt');