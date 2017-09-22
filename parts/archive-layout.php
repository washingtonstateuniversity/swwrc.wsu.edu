<section class="row side-right gutter pad-ends">

	<?php $title = ( is_search() ) ? 'Search Results' : 'News'; ?>

	<h1><?php echo esc_html( $title ); ?></h1>

	<div class="column one">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'articles/post', get_post_type() ); ?>

		<?php endwhile; ?>

	</div><!--/column-->

	<div class="column two">

		<?php get_sidebar(); ?>

	</div><!--/column two-->

</section>
