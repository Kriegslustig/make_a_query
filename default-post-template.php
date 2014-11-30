<?php
	if($wp_query && $wp_query->have_posts()):
		while($wp_query->have_posts()):
			$wp_query->the_post();
?>
			<article>
				<h2><?php the_title(); ?></h2>
				<?php the_content(); ?>
			</article>
<?php
		endwhile;
	endif;
?>