
<header class="article-header">
	<hgroup>
		<?php if ( is_single() ) : ?>
			<h1 class="article-title"><?php the_title(); ?></h1>
		<?php else : ?>

		<?php endif; ?>
	</hgroup>
</header>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! is_singular() ) : ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark"><h2 class="article-title"><?php the_title(); ?></h2></a>
		<div class="article-summary">
			<?php

			if ( has_post_thumbnail() ) {
				?><figure class="article-thumbnail"><?php the_post_thumbnail( array( 132, 132, true ) ); ?></figure><?php
			}

			the_content();

			?>
		</div><!-- .article-summary -->
	<?php else : ?>
		<div class="article-body">
		<figure class="article-thumbnail"><?php the_post_thumbnail( 'thumbnail' ); ?></figure>
<div class="the-content">
		<?php

			the_content();

			?>
		</div>
		</div>
	<?php endif; ?>

</article>
