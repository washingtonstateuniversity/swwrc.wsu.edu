<?php while ( have_posts() ) : the_post(); ?>
<section class="row single gutter pad-ends">

	<?php
	$display_data = SWWRC\University_Center_Objects\get_person_data( get_the_ID() );
	$display_data['url'] = get_post_meta( get_the_ID(), '_wsuwp_uc_object_url', true );
	?>

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
				if ( ! empty( $display_data['title'] ) ) {
					?><div class="person-meta person-title">
						<p><?php echo esc_html( $display_data['title'] ); ?></p>
					</div><?php
				}

				if ( ! empty( $display_data['title_secondary'] ) ) {
					?><div class="person-meta person-title-secondary">
						<p><?php echo esc_html( $display_data['title_secondary'] ); ?></p>
					</div><?php
				}

				if ( ! empty( $display_data['office'] ) ) {
					?><div class="person-meta person-office">
						<p><?php echo esc_html( $display_data['office'] ); ?></p>
					</div><?php
				}

				if ( ! empty( $display_data['email'] ) ) {
					?><div class="person-meta person-email">
						<p><a href="mailto:<?php echo esc_attr( $display_data['email'] ); ?>"><?php echo esc_html( $display_data['email'] ); ?></a></p>
					</div><?php
				}

				if ( ! empty( $display_data['phone'] ) ) {
					?><div class="person-meta person-phone">
						<p><?php echo esc_html( $display_data['phone'] ); ?></p>
					</div><?php
				}

				if ( ! empty( $display_data['url'] ) ) {
					?><div class="person-meta person-url">
						<p><a href="<?php echo esc_url( $display_data['url'] ); ?>"><?php echo esc_url( $display_data['url'] ); ?></a></p>
					</div><?php
				}
				?>

				<?php the_content(); ?>
			</div>

		</article>

	</div>

</section>
<?php endwhile;
