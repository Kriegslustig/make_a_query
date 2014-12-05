<?php
/**
 * @package make_a_query
 * @version 0.1
 */
/*
 * Plugin Name: Make A Query
 * Description: A super simple plugin to add a shortcode which queries for posts.
 * Author: Luca Schmid
 * Version: 0.1
 * License: Public Domain
 * Author URI: http://netzkinder.cc/
 * Plugin URI: https://github.com/Kriegslustig/make_a_query
*/

// Creates the settings page
require 'maq_settings.php';

// Adding a shortcode to make wordpress queries from posts.
// [make_a_query type="post" cat="category_slug" limit=5]
function add_sc_make_a_query ($attributes) {

  // Defining shortcode defaults
  $attributes = shortcode_atts([
    'type' => 'post',
    'cat' => false,
    'limit' => false,
    'template' => false
  ], $attributes, 'make_a_query');

  /*
   * this array maps shortcode attributes to their processors
   * the processor is an anonymous function
   * The processor the handles the attribute
   * Most attributes are integrated into the $wp-query
   */
  $make_a_query_func_arr = [];


  /*
   * Searches a Template File
   * Fallback: default-post-template.php
   */
  function maq_eval_template_path($attributes) {

    // The users teplate should be in this dir
    $user_dir = get_option('make_a_query_templates_directory');
    $user_dir = $user_dir ?
      $user_dir :
      '';
    if($attributes['template'] && is_file(get_template_directory() . '/' . $user_dir . $attributes['template'])) {
      return get_template_directory() . '/' . $user_dir . $attributes['template'];
    }
    $post_type_templ = get_template_directory() . '/' . $user_dir . $attributes['type'] . '.php';
    if(is_file($post_type_templ)) {
      return $post_type_templ;
    }
    return plugin_dir_path(__FILE__) . '/default-post-template.php';
  }

  // Process the template attribute
  $make_a_query_func_arr['template'] = function ($wp_query_arr, $val) {
    if($val) {
      $maq_arr['template'] = $val;
    }
    return $wp_query_arr;
  };

  // Process the type attribute
  $make_a_query_func_arr['type'] = function ($wp_query_arr, $val) {
    $wp_query_arr['post_type'] = $val;
    return $wp_query_arr;
  };

  // Process the cat attribute
  $make_a_query_func_arr['cat'] = function ($wp_query_arr, $val) {
    if($val) {
      $wp_query_arr['category_name'] = $val;
    }
    return $wp_query_arr;
  };

  // Process the limit attribute
  $make_a_query_func_arr['limit'] = function ($wp_query_arr, $val) {
    if($val) {
      $wp_query_arr['post_count'] = $val . '';
    }
    return $wp_query_arr;
  };

  $wp_query_arr = [];
  foreach ($attributes as $att => $val) {
    $wp_query_arr = $make_a_query_func_arr[$att]($wp_query_arr, $val);
  }
  $wp_query = new WP_Query($wp_query_arr);

  // Look for a valid template_file
  $template_file = maq_eval_template_path($attributes);
  ob_start();
  include $template_file;
  return ob_get_clean();
}
add_shortcode('make_a_query', 'add_sc_make_a_query');