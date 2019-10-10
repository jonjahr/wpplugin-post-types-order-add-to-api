<?php
// echo '<pre> post-types.php </pre>';
///////////////////////////////////
// Custom page types

add_action('init', function () {

    register_post_type('sdt_place',
        array(
            'labels' => array(
                'name' => __('Places'),
                'singular_name' => __('Place'),
            ),
            'rewrite' => array('slug' => 'places'),
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-admin-post',
            'hierarchical' => true, // Turn on Simple Page Ordering
        )
    );
});