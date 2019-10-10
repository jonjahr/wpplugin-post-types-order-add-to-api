<?php
// Add custom API endpoints
// echo '<pre> api.php </pre>';

function sdt_places_endpoint($request_data)
{

    // get posts
    $posts = get_posts([
        'post_type' => 'sdt_place',
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'numberposts' => -1,
    ]);

    // add custom field data to posts array
    foreach ($posts as $key => $post) {
        // Start with ACF fields
        $result = get_fields($post->ID);
        // Add index
        $result["index"] = $key;
        // Then add ID, permalink, and featured image.
        $result["title"] = get_the_title($post->ID);
        $result["ID"] = $post->ID;
        // $result["link"] = get_permalink($post->ID); // Full url
        $result["slug"] = get_post_field("post_name", $post->ID); // Just the slug
        // $result["image"] = get_the_post_thumbnail_url($post->ID); // The Post Thumbnail
        // $result["image"] = $result["image"]["url"]; // Full resolution image
        $result["image"] = $result["image"]["sizes"]["large"]; // Large image (scaled down if huge)

        // Icons Repeater Field
        // check if the repeater field has rows of data
        if (have_rows("icons", $post->ID)):
            $icons = [];
            // loop through the rows of data
            while (have_rows("icons", $post->ID)): the_row();
                $icons[] = get_sub_field("icon")["url"];
            endwhile;
            $result["icons"] = $icons;
            // else:
            // no rows found
        else:
            // $result["icons"] = null;
            unset($result["icons"]);
        endif;
        // ACF "clone" field adds .sound and .volume, but then adds the fields a second time.  Remove one of them.
        unset($result["sound_effect"]);
        // Overwrite the original fields.
        $posts[$key] = $result;
    }
    $return["places"] = $posts;
    $return["home"] = get_fields(38);
    // ACF "clone" field adds .sound and .volume, but then adds the fields a second time.  Remove one of them.
    unset($return["home"]["ambient_sound"]);
    return $return;
}

// Register custom endpoints
add_action('rest_api_init', function () {
    register_rest_route('sdt', '/places/', array(
        'methods' => 'GET',
        'callback' => 'sdt_places_endpoint',
    )
    );
});

// Remove default endpoints
add_filter('rest_endpoints', 'sdt_remove_endpoints');
function sdt_remove_endpoints($endpoints)
{
    // Remove all endpoints EXCEPT those starting with our prefix.
    $prefix = 'sdt';

    foreach ($endpoints as $endpoint => $details) {
        if (!fnmatch('/' . $prefix . '/*', $endpoint, FNM_CASEFOLD)) {
            unset($endpoints[$endpoint]);
        }
    }
    return $endpoints;
}

// Enable CORS Origins
add_filter('allowed_http_origins', 'pantheon_allowed_origins');
function pantheon_allowed_origins($urls)
{
    $urls[] = array('http://localhost', 'https://sandiego.org', 'https://preview.sandiego.org', 'https://sandiego.org', 'https://dev-sdt-balboa-landing-cms.pantheonsite.io', 'https://test-sdt-balboa-landing-cms.pantheonsite.io', 'https://live-sdt-balboa-landing-cms.pantheonsite.io');
    return $urls;
}
