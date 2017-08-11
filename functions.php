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
	wp_enqueue_style( 'ascent-style', get_stylesheet_directory_uri() . '/scss/swwrc.css' );
	wp_enqueue_script( 'swwrc-videobg', get_stylesheet_directory_uri() . '/js/jQuery.videobg.js', array( 'jquery' ), spine_get_script_version(), true );
	wp_enqueue_script( 'swwrc-custom', get_stylesheet_directory_uri() . '/custom.js', array( 'jquery' ), spine_get_script_version(), true );
}

add_action( 'pre_get_posts', 'projects_104b' );
/**
 * Query the `wsuwp_uc_project` post type for the 104b category archive.
 */
function projects_104b( $query ) {
	if ( is_category( '104b' ) && $query->is_main_query() ) {
		$query->set( 'post_type', array(
			'wsuwp_uc_project',
		) );
	}
}

add_action( 'admin_init', 'swwrc_register_announcement_settings' );
/**
 * Register settings for the Home Page Announcement settings admin page.
 */
function swwrc_register_announcement_settings() {
	register_setting(
		'swwrc_options',
		'announcement_settings'
	);

	add_settings_section(
		'category_id',
		null,
		null,
		'swwrc_options'
	);

	add_settings_field(
		'announcement_category',
		'Announcement Category',
		'swwrc_announcement_category_dropdown',
		'swwrc_options',
		'category_id',
		array(
			'label_for' => 'category_id',
		)
	);
}

/**
 * Output for the Announcement Category field.
 *
 * @param array $args Extra arguments used when outputting the field.
 */
function swwrc_announcement_category_dropdown( $args ) {
	$options = get_option( 'announcement_settings' );
	$category_id = ( $options && isset( $options[ $args['label_for'] ] ) ) ? $options[ $args['label_for'] ] : 0;
	?>
	<select name="announcement_settings[<?php echo esc_attr( $args['label_for'] ); ?>]">
		<option value="">- Select -</option>
		<?php
		$categories = get_categories( array(
			'orderby' => 'name',
			'order' => 'ASC',
			'hide_empty' => 0,
		) );

		foreach ( $categories as $category ) {
			?><option value="<?php echo esc_attr( $category->cat_ID ); ?>"<?php selected( $category_id, $category->cat_ID ); ?>><?php echo esc_html( $category->cat_name ); ?></option><?php
		}
		?>
	</select>
	<p class="description">Select the category to use for displaying special announcements on the home page.</p>
	<?php
}

add_action( 'admin_menu', 'swwrc_add_announcement_settings_page' );
/**
 * Create an admin page for Home Page Announcements.
 */
function swwrc_add_announcement_settings_page() {
	add_submenu_page(
		'options-general.php',
		'Home Page Announcements',
		'Home Page Announcements',
		'manage_options',
		'swwrc_options',
		'swwrc_announcement_settings_page'
	);
}

/**
 * Display the Home Page Announcements settings page.
 */
function swwrc_announcement_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form method="post" action="options.php">
			<?php
				settings_fields( 'swwrc_options' );
				do_settings_sections( 'swwrc_options' );
				submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php
}
