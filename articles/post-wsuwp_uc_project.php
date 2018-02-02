<?php if ( is_single() ) : ?>
<header class="article-header">
	<hgroup>
		<h1 class="article-title"><?php the_title(); ?></h1>
	</hgroup>
</header>
<?php endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( ! is_singular() ) : ?>

		<?php if ( has_post_thumbnail() ) { ?>
		<figure class="article-thumbnail"><?php the_post_thumbnail( array( 132, 132, true ) ); ?></figure>
		<?php } ?>

		<?php if ( is_category( 'seed-grants' ) ) { ?>
		<header class="article-header">
			<h2>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>
			<p><?php echo wp_kses_post( SWWRC\University_Center_Objects\project_authors( get_the_ID() ) ); ?>
			<span class="article-year">(<?php the_time( 'Y' ); ?>)</span></p>
		</header>
		<?php } else { ?>
		<h2 class="article-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>
		<?php } ?>

	<?php else : ?>

		<div class="article-body">

			<div class="the-content">
				<?php the_content(); ?>
			</div>

		</div>

	<?php endif; ?>

</article>
