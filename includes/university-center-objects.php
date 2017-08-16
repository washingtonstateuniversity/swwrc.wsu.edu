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

/**
 * Return the display data for a person.
 *
 * @since 0.5.0
 *
 * @param int $post_id
 *
 * @return array
 */
function get_person_data( $post_id ) {
	$display_data = array(
		'prefix' => '',
		'first_name' => '',
		'last_name' => '',
		'name' => '',
		'suffix' => '',
		'title' => '',
		'title_secondary' => '',
		'office' => '',
		'email' => '',
		'phone' => '',
	);

	if ( function_exists( 'wsuwp_uc_get_meta' ) ) {
		foreach ( $display_data as $field => $v ) {
			$display_data[ $field ] = wsuwp_uc_get_meta( $post_id, $field );
		}
	}

	// Create the name for display. If a first and last name are set, then look for a suffix and attach.
	if ( ! empty( trim( $display_data['first_name'] ) ) && ! empty( trim( $display_data['last_name'] ) ) ) {
		$display_name_array = array( $display_data['prefix'], $display_data['first_name'], $display_data['last_name'] );
		$display_name_array = array_filter( $display_name_array, 'trim' );
		$display_name = join( ' ', $display_name_array );

		if ( ! empty( trim( $display_data['suffix'] ) ) ) {
			$display_name .= ', ' . $display_data['suffix'];
		}
	}

	// If no display name is available, use the title.
	if ( empty( $display_name ) ) {
		$display_name = get_the_title();
	}

	$display_data['name'] = $display_name;

	return $display_data;
}
