<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="article-header">
		<hgroup>
			<?php if ( is_single() ) : ?>
				<h1 class="article-title"><?php the_title(); ?></h1>
			<?php else : ?>
				<h2 class="article-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php endif; ?>
		</hgroup>
	</header>

	<?php if ( ! is_singular() ) : ?>
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
			<?php

			if ( has_post_thumbnail() ) {
				?><figure class="article-thumbnail"><?php the_post_thumbnail( 'thumbnail' ); ?></figure><?php
			}

			the_content();

			?>
		</div>
	<?php endif; ?>

</article>
