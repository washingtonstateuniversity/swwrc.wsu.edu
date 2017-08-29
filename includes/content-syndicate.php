<?php

namespace SWWRC\Content_Syndicate;

add_action( 'rest_api_init', 'SWWRC\Content_Syndicate\register_api_fields' );
add_filter( 'wsu_content_syndicate_host_data', 'SWWRC\Content_Syndicate\subset_data_include_tags', 10, 2 );
add_filter( 'wsu_content_syndicate_host_data', 'SWWRC\Content_Syndicate\subset_data_image_size', 10, 2 );

add_filter( 'wsuwp_uc_organizations_item_html', 'SWWRC\Content_Syndicate\uc_item_output', 10, 3 );
add_filter( 'wsuwp_uc_people_item_html', 'SWWRC\Content_Syndicate\uc_item_output', 10, 3 );
add_filter( 'wsuwp_uc_project_item_html', 'SWWRC\Content_Syndicate\uc_item_output', 10, 3 );
add_filter( 'wsuwp_uc_publications_item_html', 'SWWRC\Content_Syndicate\uc_item_output', 10, 3 );

add_shortcode( 'swwrc_uc_syndicate_filters', 'SWWRC\Content_Syndicate\display_swwrc_uc_syndicate_filters' );

/**
 * Register a syndicate_tags field in the REST API to provide specific
 * data on tags that should appear with posts pulled in content syndicate.
 *
 * @since 0.5.0
 */
function register_api_fields() {
	if ( function_exists( 'wsuwp_uc_get_object_type_slugs' ) ) {
		foreach ( wsuwp_uc_get_object_type_slugs() as $post_type ) {
			register_rest_field( $post_type, 'syndicate_tag_slugs', array(
				'get_callback' => 'SWWRC\Content_Syndicate\get_api_syndicate_tag_slugs',
			) );
		}
	}
}

/**
 * Return the tag data required by content syndicate.
 *
 * @since 0.5.0
 *
 * @param array  $object     The current post being processed.
 * @param string $field_name Name of the field being retrieved.
 *
 * @return mixed Tag data associated with the post.
 */
function get_api_syndicate_tag_slugs( $object, $field_name ) {
	if ( 'syndicate_tag_slugs' !== $field_name ) {
		return null;
	}

	$tags = wp_get_post_tags( $object['id'] );
	$data = array();

	foreach ( $tags as $tag ) {
		$term = get_term( $tag );
		$data[] = $term->slug;
	}

	return $data;
}

/**
 * Ensure the subset data in content syndicate has been populated
 * with tag information from the REST API.
 *
 * @since 0.5.0
 *
 * @param object $subset Data associated with a single remote item.
 * @param object $post   Original data used to build the subset.
 *
 * @return object Modified data.
 */
function subset_data_include_tags( $subset, $post ) {
	if ( isset( $post->syndicate_tags ) ) {
		$subset->tags = $post->syndicate_tags;
	} else {
		$subset->tags = array();
	}

	return $subset;
}

/**
 * Filter the thumbnail used from a remote host with WSU Content Syndicate.
 *
 * @since 0.5.0
 *
 * @param object $subset Data associated with a single remote item.
 * @param object $post   Original data used to build the subset.
 *
 * @return object Modified data.
 */
function subset_data_image_size( $subset, $post ) {
	if ( isset( $post->featured_media ) && isset( $subset->featured_media ) ) {
		if ( isset( $subset->featured_media->media_details->sizes->{'spine-medium_size'} ) ) {
			$subset->thumbnail = $subset->featured_media->media_details->sizes->{'spine-medium_size'}->source_url;
		} else {
			$subset->thumbnail = $subset->featured_media->source_url;
		}
	} else {
		$subset->thumbnail = false;
	}

	return $subset;
}

/**
 * Generate the HTML used for individual University Center posts when called with the shortcode.
 *
 * @since 0.5.0
 *
 * @param string   $html   The HTML to output for an individual object.
 * @param stdClass $object Data returned from the WP REST API.
 * @param string   $type   The type of output expected.
 *
 * @return string The generated HTML for an individual post.
 */
function uc_item_output( $html, $object, $type ) {
	$uco_type = $object->type;
	$classes = array( 'content-syndicate-item', $uco_type );

	foreach ( $object->syndicate_tag_slugs as $slug ) {
		$classes[] = 'tag-' . $slug;
	}

	ob_start();
	?>
	<article class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

		<?php
		if ( 'swwrc-excerpt' === $type || 'swwrc-full' === $type ) {
			?>
			<div class="content-syndicate-thumbnail">
			<?php
			if ( ! empty( $object->featured_media ) && isset( $object->_embedded->{'wp:featuredmedia'} ) && 0 < count( $object->_embedded->{'wp:featuredmedia'} ) ) {
				$feature = $object->_embedded->{'wp:featuredmedia'}[0]->media_details;

				if ( isset( $feature->sizes->{'post-thumbnail'} ) ) {
					$thumbnail = $feature->sizes->{'post-thumbnail'}->source_url;
				} elseif ( isset( $subset_feature->sizes->{'thumbnail'} ) ) {
					$thumbnail = $feature->sizes->{'thumbnail'}->source_url;
				} else {
					$thumbnail = $object->_embedded->{'wp:featuredmedia'}[0]->source_url;
				}

				?><img src="<?php echo esc_url( $thumbnail ); ?>"><?php
			}
			?>
			</div>
			<?php
		}
		?>

		<div class="content-syndicate-name">
			<a href="<?php echo esc_url( $object->link ); ?>"><?php echo esc_html( $object->title->rendered ); ?></a>
		</div>

		<?php
		if ( 'swwrc-excerpts' === $type ) {
			?>
			<div class="content-syndicate-excerpt">
				<?php echo wp_kses_post( $object->excerpt->rendered ); ?>
				<a class="content-syndicate-read-more" href="<?php echo esc_url( $object->link ); ?>">Read Story</a>
			</div>
			<?php
		} elseif ( 'swwrc-full' === $type ) {
			?>
			<div class="uco-syndicate-project-content">
				<?php echo wp_kses_post( $object->content->rendered ); ?>
			</div>
			<?php

		}
		?>

	</article>
	<?php
	$html = ob_get_clean();

	return $html;
}

/**
 * Displays a site search form.
 *
 * @since 0.5.0
 */
function display_swwrc_uc_syndicate_filters( $atts ) {
	$defaults = array(
		'post_type' => '',
	);

	$atts = shortcode_atts( $defaults, $atts );

	if ( empty( $atts['post_type'] ) ) {
		return '';
	}

	if ( ! function_exists( 'wsuwp_uc_get_object_type_slugs' ) ) {
		return '';
	}

	if ( ! in_array( $atts['post_type'], wsuwp_uc_get_object_type_slugs(), true ) ) {
		return '';
	}

	ob_start();

	\SWWRC\University_Center_Objects\display_tag_filters( $atts['post_type'] );

	$content = ob_get_clean();

	return $content;
}
