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

// this array maps attributes to their function
$func_arr = [];

// Adding a shortcode to make wordpress queries from posts.
// [make_a_query type="post" cat="category_slug" limit=5]
function add_sc_make_a_query ($attributes) {
	$attributes = shortcode_atts([
		'type' => 'post'
		'cat' => false,
		'limit' => false,
		'template' => false
	], $attributes, 'make_a_query');
	$wp_query_arr = [];
	foreach ($attributes as $att => $val) {
		call_user_func($func_arr[$att], $wp_query_arr, $val);
	}
	$wp_query = new WP_Query($wp_query_arr);
	$template_file = maq_eval_template_path($attributes);
	$returnString = include $template_file;
}
add_shortcode('make_a_query', 'add_sc_make_a_query');

$func_arr['template'] = 'maq_att_template';
function maq_att_template (&$maq_arr['query'], $val) {
	if($val) {
		$maq_arr['template'] = $val;
	} else if()
}

$func_arr['type'] = 'maq_att_type';
function maq_att_type (&$wp_query_arr, $val) {
	$wp_query_arr['post_type'] = $val;
}

$func_arr['cat'] = 'maq_att_cat';
function maq_att_cat (&$wp_query_arr, $val) {
	if($val) {
		$wp_query_arr['category_name'] = $val;
	}
}

$func_arr['limit'] = 'maq_att_limit';
function maq_att_limit (&$wp_query_arr, $val) {
	if($val) {
		$wp_query_arr['post_count'] = $val . '';
	}
}