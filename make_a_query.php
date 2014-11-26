<?php
/**
 * @package make_a_query
 * @version 0.1
 */
/*
Plugin Name: Make A Query
Description: A super simple plugin to add a shortcode which queries for posts.
Author: Luca Schmid
Version: 0.1
Author URI: http://netzkinder.cc/
*/

// Adding a shortcode to make wordpress queries from posts.
// [make_a_query type="post" cat="category_slug" limit=5]
function add_sc_make_a_query ($attributes) {
	$attributes = shortcode_atts([
		'type' => 'post'
		'cat' => false,
		'limit' => false
	], $attributes, 'make_a_query');
}
add_shortcode('make_a_query', 'add_sc_make_a_query');