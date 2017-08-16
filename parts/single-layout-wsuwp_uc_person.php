<?php while ( have_posts() ) : the_post(); ?>
<section class="row single gutter pad-ends">

	<?php $display_data = SWWRC\University_Center_Objects\get_person_data( get_the_ID() ); ?>

	<div class="column one">
		<?php if ( ! empty( $display_data['name'] ) ) { ?>
		<h1 class="article-title"><?php echo esc_html( $display_data['name'] ); ?></h1>
		<?php } ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php if ( has_post_thumbnail() ) { ?>
			<figure class="article-thumbnail">
				<?php spine_the_featured_image(); ?>
			</figure>
			<?php } ?>

			<div class="article-body">
				<?php
				/* Leaving this for future reference.
				if ( ! empty( $display_data['title'] ) ) {
					?><div class="person-title"><?php echo esc_html( $display_data['title'] ); ?></div><?php
				}

				if ( ! empty( $display_data['title_secondary'] ) ) {
					?><div class="person-title-secondary"><?php echo esc_html( $display_data['title_secondary'] ); ?></div><?php
				}

				if ( ! empty( $display_data['office'] ) ) {
					?><div class="person-office"><strong>Office</strong> <?php echo esc_html( $display_data['office'] ); ?></div><?php
				}

				if ( ! empty( $display_data['email'] ) ) {
					?><div class="person-email"><strong>Email:</strong> <?php echo esc_html( $display_data['email'] ); ?></div><?php
				}

				if ( ! empty( $display_data['phone'] ) ) {
					?><div class="person-phone"><strong>Phone:</strong> <?php echo esc_html( $display_data['phone'] ); ?></div><?php
				}
				*/
				?>

				<?php the_content(); ?>
			</div>

		</article>

	</div>

</section>
<?php endwhile;
