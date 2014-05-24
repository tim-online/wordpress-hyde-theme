<?php
/**
 * @package hyde
 */
?>

<article class="post">
	<?php the_title( '<h1 class="post-title">', '</h1>' ); ?>
	<?php hyde_posted_on(); ?>

	<?php the_content(); ?>
	<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'hyde' ),
			'after'  => '</div>',
		) );
	?>
</article><!-- #post-## -->
