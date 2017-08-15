<?php

namespace SWWRC\University_Center_Objects;

add_filter( 'wsuwp_uc_people_to_add_to_content', 'SWWRC\University_Center_Objects\sort_object_people' );
add_filter( 'wsuwp_uc_people_sort_items', 'SWWRC\University_Center_Objects\sort_syndicate_people' );

/**
 * Sort a University Center object's associated people alphabetically by last name.
 *
 * @since 0.5.0
 *
 * @param array $people
 *
 * @return array
 */
function sort_object_people( $people ) {
	if ( ! $people ) {
		return $people;
	}

	foreach ( $people as $unique_data_id => $person ) {
		$last_name = get_post_meta( $person['id'], '_wsuwp_uc_person_last_name', true );
		$people[ $unique_data_id ]['last_name'] = $last_name;
	}

	usort( $people, function( $a, $b ) {
		return strcasecmp( $a['last_name'], $b['last_name'] );
	} );

	return $people;
}

/**
 * Sort Content Syndicate results for University Center People alphabetically by last name.
 *
 * @since 0.5.0
 *
 * @param array $people
 *
 * @return array
 */
function sort_syndicate_people( $people ) {
	foreach ( $people as $index => $person ) {
		$last_name = get_post_meta( $person->id, '_wsuwp_uc_person_last_name', true );
		$people[ $index ]->last_name = $last_name;
	}

	usort( $people, function( $a, $b ) {
		return strcasecmp( $a->last_name, $b->last_name );
	} );

	return $people;
}
