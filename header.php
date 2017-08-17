<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js no-svg lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]><html class="no-js no-svg lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]><html class="no-js no-svg lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=EDGE">
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php echo esc_html( spine_get_title() ); ?></title>

	<!-- FAVICON -->
	<link rel="shortcut icon" href="https://repo.wsu.edu/spine/1/favicon.ico" />

	<!-- RESPOND -->
	<meta name="viewport" content="width=device-width, user-scalable=yes">

	<!-- DOCS -->
	<link type="text/plain" rel="author" href="https://repo.wsu.edu/spine/1/authors.txt" />
	<link type="text/html" rel="help" href="https://brand.wsu.edu/media/web" />

	<!-- SCRIPTS and STYLES -->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
	$jacket_classes = array(
		'style-' . spine_get_option( 'theme_style' ),
		'colors-' . spine_get_option( 'secondary_colors' ),
		'spacing-' . spine_get_option( 'theme_spacing' ),
	);

	$binder_classes = array(
		spine_get_option( 'grid_style' ),
		spine_get_option( 'large_format' ),
		spine_get_option( 'broken_binding' ),
	);
?>

<a href="#wsuwp-main" class="screen-reader-shortcut"><?php esc_html_e( 'Skip to main content' ); ?></a>

<?php get_template_part( 'parts/before-jacket' ); ?>
<div id="jacket" class="<?php echo esc_attr( implode( ' ', $jacket_classes ) ); ?>">
<?php get_template_part( 'parts/before-binder' ); ?>
<div id="binder" class="<?php echo esc_attr( implode( ' ', $binder_classes ) ); ?>">
<?php get_template_part( 'parts/before-main' );
