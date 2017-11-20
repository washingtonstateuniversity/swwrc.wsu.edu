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

		<h2 class="article-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

	<?php else : ?>

		<div class="article-body">

			<?php if ( has_post_thumbnail() ) { ?>
			<figure class="article-thumbnail"><?php the_post_thumbnail( 'thumbnail' ); ?></figure>
			<?php } ?>

			<div class="the-content">
				<?php the_content(); ?>
			</div>

		</div>

	<?php endif; ?>

</article>
