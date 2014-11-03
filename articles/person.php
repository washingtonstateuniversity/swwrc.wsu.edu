<?php if ( $last_name = get_post_meta( get_the_ID(), 'cereo_person_last_name', true ) ) : ?>
	<h2 class="article-title person-last-name"><?php echo esc_html( $last_name ); ?></h2>
<?php else : ?>
	<h2 class="article-title person-last-name"><?php the_title(); ?></h2>
<?php endif; ?>
<div class="article-body">
	<?php the_content(); ?>
</div>
