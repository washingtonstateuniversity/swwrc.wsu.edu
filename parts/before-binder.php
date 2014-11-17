<?php if( is_front_page() ) { ?> <div class="videobg">
	<div class="banner-container">
		<div class="logo-container">
	<img src="/wp-content/uploads/sites/354/2014/11/SWWRC-logo-vert-reverse1.png" alt="State of Washington Water Research Center" class="home-logo" />
</div>

<?php if ( $cob_page_headline = cob_get_page_headline() ) : ?><h1><?php echo wp_kses_post( $cob_page_headline ); ?> </h1><?php endif; ?>
</div>
</div>
<?php } ?>
<a class="mobilenav" href="#"></a>
<nav class="main-menu navreg">
	<a href="/"><img id="logo" src="/wp-content/uploads/sites/354/2014/11/SWWRC-logo-vert-rgb.png" alt="State of Washington Water Research"/></a><img id="mobilelogo" src="wp-content/uploads/sites/354/2014/11/mobilelogo.png" alt="State of Washington Water Research"/><?php
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
	wp_nav_menu( $spine_site_args );
	?></nav>