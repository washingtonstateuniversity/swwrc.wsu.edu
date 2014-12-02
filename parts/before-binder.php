<?php if( is_front_page() ) { ?>
	<div id="videobg" class="videobg">
		<div class="banner-container">
			<div class="logo-container">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/SWWRC-logo-vert-reverse1.png' ); ?>" alt="State of Washington Water Research Center" class="home-logo" />
			</div>
			<?php if ( $cob_page_headline = swwrc_get_page_headline() ) : ?>
				<h1><?php echo wp_kses_post( $cob_page_headline ); ?></h1>
			<?php endif; ?>
		</div>
	</div>
	<script type='text/javascript'>
		/* <![CDATA[ */
		var wsu_video_background = <?php echo swwrc_get_video_json_data(); ?>
		/* ]]> */
	</script>
<?php } ?>
<a class="mobilenav" href="#"><img id="mobilelogo" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/mobilelogo.png' ); ?>" alt="State of Washington Water Research"/></a>
<nav class="main-menu navreg">
	<a href="<?php echo esc_url( home_url() ); ?>"><img id="logo" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/SWWRC-logo-vert-rgb.png' ); ?>" alt="State of Washington Water Research"/></a><?php
	$spine_site_args = array(
		'theme_location'  => 'site',
		'menu'            => 'site',
		'container'       => false,
		'container_class' => false,
		'container_id'    => false,
		'menu_class'      => null,
		'menu_id'         => null,
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 3,
	);
	wp_nav_menu( $spine_site_args ); ?>
</nav>