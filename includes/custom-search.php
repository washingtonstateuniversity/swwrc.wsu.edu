<?php

namespace SWWRC\Site_Search;

add_filter( 'pre_get_posts', 'SWWRC\Site_Search\include_uc_post_types' );

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
