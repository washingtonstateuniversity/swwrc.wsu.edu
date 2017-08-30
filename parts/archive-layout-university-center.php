<section class="row side-right gutter pad-ends">

	<?php $post_type = ( get_queried_object() ) ? get_queried_object() : false; ?>

	<h1><?php echo esc_html( $post_type->label ); ?></h1>

	<div class="column one">

		<?php SWWRC\University_Center_Objects\display_tag_filters( $post_type->name ); // @codingStandardsIgnoreLine ?>

		<div>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'articles/post', get_post_type() ); ?>

		<?php endwhile; // end of the loop. ?>

		</div>

	</div><!--/column-->

	<div class="column two">

		<?php get_sidebar(); ?>

	</div><!--/column two-->

</section>
