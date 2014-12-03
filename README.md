make_a_query
============

A super simple WordPress plugin to add a shortcode which queries for posts.

**Plugin Name:** Make A Query

**Description:** A super simple plugin to add a shortcode which queries for posts.

**Author:** Luca Schmid

**Version:** 0.1

**License:** Public Domain

**Author URI:** http://netzkinder.cc/

**Plugin URI:** https://github.com/Kriegslustig/make_a_query

Requirements
============
It uses Output Buffering. It's often disabled by hosters.
It's used to open post-templates.

Usage
=====
`[make_a_query type="post" cat="category_slug" limit=5 template="path/to/template.php"]`

**type**: You can define a custom post-type. *Default: "`post`"*

**cat**: This attribute will filter posts by a categoy_slug. You can only use one. *Default: none*

**limit**: Limits the number of posts displayed. *Default: 10*

**template**: This must be a php file. *Default: *`<themedirectory>/<custom_template_dir/<type>.php`

If no template can be found, the default template (which is shown below) will be used.

Settings
========
Under `Settings > Writting` *Make A Query* adds a setting **Template Directory**. It should point to the place where the post-templates are.

Post Templates
==============
The post templates are called with a variable `$wp_query` defined. It must be used in the template.
Example:

    <?php
        // Check if '$wp_query' is defined and if there are any posts returned by it's query
        if($wp_query && $wp_query->have_posts()):
            // Initiate the_loop
            while($wp_query->have_posts()):
                // Call 'the_post()' to set the environment for 'the_content()' and so on
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

