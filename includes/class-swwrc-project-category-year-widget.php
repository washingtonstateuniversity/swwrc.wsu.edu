<?php

class SWWRC_Project_Category_Year_Widget extends WP_Widget {

	/**
	 * Register the widget officially through the parent class.
	 *
	 * @since 0.5.5
	 */
	public function __construct() {
		parent::__construct(
			'uc_projects_cateogry_year_widget',
			'Project Year Archives',
			array(
				'description' => 'A list of links to year archives for Projects in a given category.',
			)
		);
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @since 0.5.5
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$default_instance = array(
			'title' => '',
			'category' => '',
		);

		$instance = shortcode_atts( $default_instance, $instance );

		if ( empty( $instance['category'] ) ) {
			return '';
		}

		?>

		<aside class="widget">

			<header><?php echo esc_html( $instance['title'] ); ?></header>

			<?php
			$projects = get_posts( array(
				'posts_per_page' => -1,
				'post_type' => 'wsuwp_uc_project',
				'category' => $instance['category'],
				'post_status' => 'publish',
			) );

			$years = array();

			foreach ( $projects as $post ) {
				$post_year = get_the_date( 'Y', $post->ID );

				if ( ! in_array( $post_year, $years, true ) ) {
					$years[] = $post_year;
				}
			}

			if ( ! empty( $years ) ) {
				$post_type_slug = get_post_type_object( 'wsuwp_uc_project' )->rewrite['slug'];
				$term_slug = get_category( $instance['category'] )->slug;
				$url_base = get_home_url( null, $post_type_slug . '/category/' . $term_slug . '/' );
				?>
				<ul>
					<?php foreach ( $years as $year ) { ?>
					<li>
						<a href="<?php echo esc_url( $url_base . $year . '/' ); ?>"><?php echo esc_html( $year ); ?></a>
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
	 * @since 0.5.5
	 *
	 * @param array $instance The instance of the current widget form being displayed.
	 *
	 * @return void
	 */
	public function form( $instance ) {
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$category = ( ! empty( $instance['category'] ) ) ? $instance['category'] : '';
		$terms = get_terms( 'category', array(
			'post_type' => 'wsuwp_uc_project',
		) );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Title:</label>
			<input type="text"
				   class="widefat"
				   id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				   value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) { ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">Category:</label>
			<select class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
				<?php foreach ( $terms as $term ) { ?>
				<option value="<?php echo esc_attr( $term->term_id ); ?>" <?php selected( $category, $term->term_id ); ?>><?php echo esc_html( $term->name ); ?></option>
				<?php } ?>
			</select>
		</p>
		<?php }
	}

	/**
	 * Processes widget options on save.
	 *
	 * @since 0.5.5
	 *
	 * @param array $new_instance The new instance of the widget being saved.
	 * @param array $old_instance Previous instance of the current widget.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? sanitize_text_field( $new_instance['category'] ) : '';

		return $instance;
	}
}
