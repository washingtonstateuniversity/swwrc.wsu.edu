<section class="row side-right gutter pad-ends">

	<h1><?php
	if ( is_category() && is_year() ) {
		single_cat_title();
		echo ' - ';
		the_time( 'Y' );
	} elseif ( is_category() || is_tag() ) {
		single_term_title();
	} else {
		post_type_archive_title();
	}
	?></h1>

	<div class="column one">

		<div>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'articles/post', get_post_type() ); ?>

		<?php endwhile; // end of the loop. ?>

		</div>

	</div><!--/column-->

	<div class="column two">

		<?php
		$post_type = $wp_query->query['post_type'];

		if ( is_active_sidebar( "sidebar_{$post_type}" ) ) {
			dynamic_sidebar( "sidebar_{$post_type}" );
		}
		?>

	</div><!--/column two-->

</section>
