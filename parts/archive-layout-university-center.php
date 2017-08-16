<section class="row side-right gutter pad-ends">

	<div class="column one">

		<?php
		$post_type = ( get_queried_object() ) ? get_queried_object()->name : false;

		swwrc_display_uco_tag_filters( $post_type ); // @codingStandardsIgnoreLine
		?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'articles/post', get_post_type() ); ?>

		<?php endwhile; // end of the loop. ?>

	</div><!--/column-->

	<div class="column two">

		<?php get_sidebar(); ?>

	</div><!--/column two-->

</section>
