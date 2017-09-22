<?php

class SWWRC_UC_Taxonomy_Terms_Widget extends WP_Widget {

	/**
	 * Register the widget officially through the parent class.
	 *
	 * @since 0.5.0
	 */
	public function __construct() {
		parent::__construct(
			'uc_taxonomies_widget',
			'University Center Taxonomy Terms',
			array(
				'description' => 'Display the taxonomy terms used for the selected University Center post type.',
			)
		);
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @since 0.5.0
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$default_instance = array(
			'title' => '',
			'post_type' => '',
			'taxonomy' => '',
		);

		$instance = shortcode_atts( $default_instance, $instance );

		if ( empty( $instance['post_type'] ) || empty( $instance['taxonomy'] ) ) {
			return '';
		}

		if ( ! in_array( $instance['post_type'], wsuwp_uc_get_object_type_slugs(), true ) ) {
			return '';
		}

		if ( ! in_array( $instance['taxonomy'], array( 'post_tag', 'category' ), true ) ) {
			return;
		}
		?>

		<aside class="widget">

			<header><?php echo esc_html( $instance['title'] ); ?></header>

			<?php
			$terms = get_terms( $instance['taxonomy'], array(
				'post_type' => $instance['post_type'],
			) );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				?>
				<ul>
					<?php foreach ( $terms as $term ) { ?>
					<li>
						<a href="<?php echo esc_url( get_term_link( $term->term_id ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
					</li>
					<?php } ?>
				</ul>
				<?php
			}
			?>

		</aside>

		<?php
	}

	/**
	 * Displays the form used to update the widget.
	 *
	 * @since 0.5.0
	 *
	 * @param array $instance The instance of the current widget form being displayed.
	 *
	 * @return void
	 */
	public function form( $instance ) {
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$post_type = ( ! empty( $instance['post_type'] ) ) ? $instance['post_type'] : '';
		$taxonomy = ( ! empty( $instance['taxonomy'] ) ) ? $instance['taxonomy'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Title:</label>
			<input type="text"
				   class="widefat"
				   id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				   value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>">Post Type:</label>
			<select class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>">
				<?php foreach ( wsuwp_uc_get_object_type_slugs() as $uc_object ) { ?>
				<?php $object = get_post_type_object( $uc_object ); ?>
				<option value="<?php echo esc_attr( $uc_object ); ?>" <?php selected( $post_type, $uc_object ); ?>><?php echo esc_html( $object->label ); ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>">Post Type:</label>
			<select class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>">
				<?php foreach ( array( 'post_tag', 'category' ) as $taxonomy_option ) { ?>
				<?php $tax = get_taxonomy( $taxonomy_option ); ?>
				<option value="<?php echo esc_attr( $taxonomy_option ); ?>" <?php selected( $taxonomy, $taxonomy_option ); ?>><?php echo esc_html( $tax->label ); ?></option>
				<?php } ?>
			</select>
		</p>
		<?php
	}

	/**
	 * Processes widget options on save.
	 *
	 * @since 0.5.0
	 *
	 * @param array $new_instance The new instance of the widget being saved.
	 * @param array $old_instance Previous instance of the current widget.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['post_type'] = ( ! empty( $new_instance['post_type'] ) ) ? sanitize_text_field( $new_instance['post_type'] ) : '';
		$instance['taxonomy'] = ( ! empty( $new_instance['taxonomy'] ) ) ? sanitize_text_field( $new_instance['taxonomy'] ) : '';

		return $instance;
	}
}
