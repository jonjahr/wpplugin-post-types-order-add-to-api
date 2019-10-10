<?php
/*
Plugin Name: Post Types Order: Add To REST API
GitHub Plugin URI: jonjahr/wpplugin-post-types-order-add-to-api
Plugin URI: https://github.com/jonjahr/wpplugin-post-types-order-add-to-api
Description: Enable "orderby: menu_order" in the REST API, because it's not enabled by default.
Version: 1.0.1
Author: jonjahr
Author URI: https://example.com
Copyright: jonjahr
Text Domain: jonjahr
Domain Path: /lang
 */

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

// Typical plugin organization.  Not needed for this plugin.
// include_once 'includes/admin-customize.php';
// include_once 'includes/post-types.php';
// include_once 'includes/api.php';

function add_menu_order_api_init()
{

    register_rest_field(
        get_post_types(), // add to these post types
        'menu_order', // name of field
        array(
            'get_callback' => function ($post) {
                return get_post_field('menu_order', $post->ID);
            },
        )
    );
}

add_action('rest_api_init', 'add_menu_order_api_init');