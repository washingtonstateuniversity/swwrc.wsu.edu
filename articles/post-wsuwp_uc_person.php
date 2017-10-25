<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="article-header">
		<hgroup>
			<?php if ( has_post_thumbnail() ) { ?>
				<figure class="article-thumbnail"><?php the_post_thumbnail( array( 132, 132, true ) ); ?></figure>
			<?php } ?>

			<?php $display_data = SWWRC\University_Center_Objects\get_person_data( get_the_ID() ); ?>

			<h2 class="article-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo esc_html( $display_data['name'] ); ?></a>
			</h2>

			<?php if ( ! empty( $display_data['title'] ) ) { ?>
				<div class="person-meta person-title"><?php echo esc_html( $display_data['title'] ); ?></div>
			<?php } ?>

			<?php if ( ! empty( $display_data['title_secondary'] ) ) { ?>
				<div class="person-meta person-title-secondary"><?php echo esc_html( $display_data['title_secondary'] ); ?></div>
			<?php } ?>

			<?php if ( ! empty( $display_data['office'] ) ) { ?>
				<div class="person-meta person-office"><?php echo esc_html( $display_data['office'] ); ?></div>
			<?php } ?>
		</hgroup>
	</header>

	<div class="article-summary">
		<?php
		// Display the manual excerpt if one is available. Otherwise, only the most basic information is needed.
		if ( $post->post_excerpt ) {
			the_excerpt();
		}
		?>
	</div>

</article>
