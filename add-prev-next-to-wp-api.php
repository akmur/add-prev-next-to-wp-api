<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://alexmuraro.me
 * @since             1.0.0
 * @package           Add previous and next posts to WP API
 *
 * @wordpress-plugin
 * Plugin Name:       Add previous and next posts to WP API
 * Plugin URI:        http://alexmuraro.me/extend-wp-api-with-prev-next/
 * Description:       Extend WP API with previous and next post
 * Version:           1.0.0
 * Author:            Alessandro Muraro
 * Author URI:        http://alexmuraro.me/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       extend-wp-api-with-prev-next
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'rest_api_init', 'add_prev_post' );
function add_prev_post() {
    register_rest_field( 'post',
        'previous_post',
        array(
            'get_callback'    => 'retrieve_prev_post',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

add_action( 'rest_api_init', 'add_next_post' );
function add_next_post() {
    register_rest_field( 'post',
        'next_post',
        array(
            'get_callback'    => 'retrieve_next_post',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

/**
 * Get the value of the previous post
 *
 * @param array $object Details of current post.
 */
function retrieve_prev_post( $object, $request ) {
    $post_id = $object[ 'id' ];
    global $post;
    $post = get_post( $post_id );
    $prev_post = get_previous_post();
    if ( ! empty( $prev_post ) ) {
          $prev_object = (object) [
		  'id' => $prev_post->ID,
    'slug' => $prev_post->post_name,
    'title' => $prev_post->post_title,
  ];
    	return $prev_object;
    }
}

/**
 * Get the value of the next post
 *
 * @param array $object Details of current post.
 */
function retrieve_next_post( $object, $request ) {
    $post_id = $object[ 'id' ];
    global $post;
    $post = get_post( $post_id );
    $next_post = get_next_post();
    if ( ! empty( $next_post ) ) {
                  $next_object = (object) [
    'id' => $next_post->ID,
	'slug' => $next_post->post_name,
    'title' => $next_post->post_title,
  ];
    	return $next_object;
    }
    
}


