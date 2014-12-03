<?php
  // Check if '$wp_query' is defined and if there are any posts returned 
  if($wp_query && $wp_query->have_posts()):
    // Initiate the_loop
    while($wp_query->have_posts()):
      // Call 'the_post()' to set the environment for 
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