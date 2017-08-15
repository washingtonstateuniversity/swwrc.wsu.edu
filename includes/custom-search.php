<?php

namespace SWWRC\Site_Search;

add_filter( 'pre_get_posts', 'SWWRC\Site_Search\include_uc_post_types' );
add_shortcode( 'swwrc_site_search', 'SWWRC\Site_Search\display_swwrc_site_search' );
add_filter( 'wp_nav_menu_items', 'SWWRC\Site_Search\add_search_to_menu', 10, 2 );

/**
 * Includes University Center post types in search results.
 *
 * @since 0.5.0
 *
 * @param WP_Query $query
 */
function include_uc_post_types( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}

	$query->set( 'post_type', array(
		'post',
		'page',
		'wsuwp_uc_project',
		'wsuwp_uc_person',
		'wsuwp_uc_publication',
		'wsuwp_uc_entity',
	) );
}

/**
 * Displays a site search form.
 *
 * @since 0.5.0
 */
function display_swwrc_site_search() {
	ob_start();
	?>
	<form class="swwrc-site-search-form"
		  action="<?php echo esc_url( trailingslashit( get_home_url() ) ); ?>"
		  method="get">
		<div>
			<label class="screen-reader-text" for="s">Search for:</label>
			<input type="text" value="" name="s" id="s" />
			<input type="submit" value="Search" />
		</div>
	</form>
	<?php
	$content = ob_get_clean();

	return $content;
}

/**
 * Filters the nav items attached to the global navigation and appends a search form.
 *
 * @since 0.5.0
 *
 * @param $items
 * @param $args
 *
 * @return string
 */
function add_search_to_menu( $items, $args ) {
	if ( 'site' !== $args->theme_location ) {
		return $items;
	}

	return $items . '<li class="search">' . get_search_form( false ) . '</li>';
}
