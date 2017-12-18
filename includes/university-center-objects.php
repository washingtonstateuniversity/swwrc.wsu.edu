<?php

namespace SWWRC\University_Center_Objects;

add_filter( 'wsuwp_uc_people_to_add_to_content', 'SWWRC\University_Center_Objects\sort_object_people' );
add_filter( 'wsuwp_uc_people_sort_items', 'SWWRC\University_Center_Objects\sort_syndicate_people' );
add_action( 'init', 'SWWRC\University_Center_Objects\rewrite_rules', 11 );
add_action( 'init', 'SWWRC\University_Center_Objects\register_sidebars', 11 );
add_action( 'pre_get_posts', 'SWWRC\University_Center_Objects\filter_projects_query', 11 );

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

/**
 * Returns markup for filtering a list of posts by tag.
 *
 * @since 0.5.0
 *
 * @param string|array $post_type The post type(s) to retrieve associated tags for.
 *
 * @return string
 */
function display_tag_filters( $post_type ) {
	if ( in_array( $post_type, wsuwp_uc_get_object_type_slugs(), true ) ) {
		$tags = get_terms( 'post_tag', array(
			'post_type' => $post_type,
		) );

		if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
			wp_enqueue_script( 'swwrc-filter', get_stylesheet_directory_uri() . '/js/tag-filter.js', array( 'jquery' ), wrc_theme_version(), true );
			?>
			<ul class="swwrc-tag-filters">
				<?php foreach ( $tags as $tag ) { ?>
				<li>
					<label>
						<input type="checkbox"
							   value="tag-<?php echo esc_attr( $tag->slug ); ?>"
							   checked> <?php echo esc_html( $tag->name ); ?>
					</label>
				</li>
				<?php } ?>
			</ul>
			<?php
		}
	}
}

/**
 * Adds rewrite rules for University Center post type category term archive page views.
 *
 * @since 0.5.0
 */
function rewrite_rules() {
	foreach ( wsuwp_uc_get_object_type_slugs() as $uc_object ) {
		$slug = get_post_type_object( $uc_object )->rewrite['slug'];

		// Rules for the `wsuwp_uc_project` post type.
		if ( 'wsuwp_uc_project' === $uc_object ) {

			// Category and year archives.
			add_rewrite_rule(
				$slug . '/category/(.+?)/([0-9]{4})/?$',
				'index.php?post_type=' . $uc_object . '&category_name=$matches[1]&year=$matches[2]',
				'top'
			);

			// Paged category archives.
			add_rewrite_rule(
				$slug . '/category/(.+?)/page/?([0-9]{1,})/?$',
				'index.php?post_type=' . $uc_object . '&category_name=$matches[1]&paged=$matches[2]',
				'top'
			);
		}

		// Category archives for all University Center post types.
		add_rewrite_rule(
			$slug . '/category/(.+?)/?$',
			'index.php?post_type=' . $uc_object . '&category_name=$matches[1]',
			'top'
		);

		// Tag archives for all University Center post types.
		add_rewrite_rule(
			$slug . '/tag/(.+?)/?$',
			'index.php?post_type=' . $uc_object . '&tag=$matches[1]',
			'top'
		);
	}
}

/**
 * Registers a sidebar for each UC post type.
 *
 * @since 0.5.0
 */
function register_sidebars() {
	foreach ( wsuwp_uc_get_object_type_slugs() as $uc_object ) {
		$object = get_post_type_object( $uc_object );

		register_sidebar( array(
			'name' => $object->label . ' Sidebar',
			'id' => 'sidebar_' . $uc_object,
			'description' => 'Widgets in this area will be shown on all ' . $object->label . ' archive views.',
		) );
	}
}

/**
 * Registers the custom widget used by the theme.
 *
 * @since 0.5.0
 */
add_action( 'widgets_init', function() {
	register_widget( 'SWWRC_UC_Taxonomy_Terms_Widget' );
} );

/**
 * Filter Project archive view queries.
 *
 * Ordered descending by date with the posts_per_page limit set to 10.
 *
 * @since 0.5.5
 *
 * @param WP_Query $query
 */
function filter_projects_query( $query ) {
	if ( ! $query->is_main_query() || is_admin() ) {
		return;
	}

	if ( $query->is_post_type_archive( 'wsuwp_uc_project' ) ) {
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'DESC' );
		$query->set( 'posts_per_page', 10 );
	}
}
