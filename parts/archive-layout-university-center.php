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

		<?php $project_years = array(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php // Customizations for the "Seed Grants" category archive.
			if ( is_post_type_archive( 'wsuwp_uc_project' ) && is_category( 'seed-grants' ) && ! is_year() ) {
				$project_year = get_the_date( 'Y', get_the_ID() );
				if ( ! in_array( $project_year, $project_years, true ) ) {
					$project_years[] = $project_year;
					$years = count( $project_years );
					if ( 1 === $years ) {
						$heading = 'Current Projects';
					} elseif ( 2 === $years ) {
						$heading = 'Past Projects';
					} elseif ( 3 === $years ) {
						break;
					}
					?>
					<header class="seed-grant-year-heading"><?php echo esc_html( $heading ); ?></header>
					<?php
				}
			}
			?>

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
