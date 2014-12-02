<?php
class WSU_SWWRC_Video {
	/**
	 * @var string Meta key for storing headline.
	 */
	public $headline_meta_key = '_wsu_cob_headline';
	/**
	 * Setup the hooks.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10 );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		add_shortcode( 'cob_home_headline', array( $this, 'display_home_headline' ) );
	}
	/**
	 * Add metaboxes for subtitle and call to action to page and post edit screens.
	 *
	 * @param string $post_type Current post type screen being displayed.
	 */
	public function add_meta_boxes( $post_type ) {
		if ( ! in_array( $post_type, array( 'page', 'post' ) ) ) {
			return;
		}
		add_meta_box( 'wsu_cob_headlines', 'Page Headlines', array( $this, 'display_headlines_metabox' ), null, 'normal', 'high' );
	}
	/**
	 * Display the metabox used to capture additional headlines for a post or page.
	 *
	 * @param WP_Post $post
	 */
	public function display_headlines_metabox( $post ) {
		$headline = get_post_meta( $post->ID, $this->headline_meta_key, true );
		wp_nonce_field( 'cob-headlines-nonce', '_cob_headlines_nonce' );
		?>
		<label for="cob-page-headline">Headline:</label>
		<input type="text" class="widefat" id="cob-page-headline" name="cob_page_headline" value="<?php echo esc_attr( $headline ); ?>" />
		<p class="description">Primary headline to be used for the top of the page, under the logo.</p>
		<?php
	}
	/**
	 * Save the subtitle and call to action assigned to the post.
	 *
	 * @param int     $post_id ID of the post being saved.
	 * @param WP_Post $post    Post object of the post being saved.
	 */
	public function save_post( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! in_array( $post->post_type, array( 'page', 'post' ) ) ) {
			return;
		}
		if ( 'auto-draft' === $post->post_status ) {
			return;
		}
		if ( ! isset( $_POST['_cob_headlines_nonce'] ) || false === wp_verify_nonce( $_POST['_cob_headlines_nonce'], 'cob-headlines-nonce' ) ) {
			return;
		}
		if ( isset( $_POST['cob_page_headline'] ) ) {
			update_post_meta( $post_id, $this->headline_meta_key, strip_tags( $_POST['cob_page_headline'], '<br><span><em><strong>' ) );
		}
	}
	
	/**
	 * Retrieve the assigned headline of a page.
	 *
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public function get_headline( $post_id ) {
		return get_post_meta( $post_id, $this->headline_meta_key, true );
	}

}
$wsu_swwrc_video = new WSU_SWWRC_Video();
/**
 * Wrapper to retrieve an assigned page headline. Will fallback to the current page if
 * a post ID is not specified.
 *
 * @param int $post_id
 *
 * @return mixed
 */
function swwrc_get_page_headline( $post_id = 0 ) {
	global $wsu_swwrc_video;
	if ( is_404() ) {
		return "We're sorry. We can't find the page you're looking for.";
	}
	$post_id = absint( $post_id );
	if ( 0 === $post_id ) {
		$post_id = get_the_ID();
	}
	return $wsu_swwrc_video->get_headline( $post_id );
}