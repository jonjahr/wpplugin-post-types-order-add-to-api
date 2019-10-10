<?php
// echo '<pre> admin-customize.php </pre>';
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
// Customize the TinyMCE toolbars in the ACF WYSIWYG field
//
// ACF Docs:
//     https://www.advancedcustomfields.com/resources/customize-the-wysiwyg-toolbars/
//
// List of TinyMCE Buttons:
//     https://www.tiny.cloud/docs-3x/reference/buttons/
//

add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
    // Uncomment to view format of $toolbars

    // echo '< pre >';
    // print_r($toolbars);
    // echo '< /pre >';
    // die;

    // Add a new toolbar called "Very Simple"
    // - this toolbar has only 1 row of buttons
    $toolbars['Very Simple'] = array();
    $toolbars['Very Simple'][1] = array('bold', 'italic');

    // Add a new toolbar called "Full"
    // - this toolbar has only 1 row of buttons
    $toolbars['Full'] = array();
    $toolbars['Full'][1] = array('styleselect', 'bold', 'italic', 'bullist', 'numlist', 'link', '|', 'undo', 'redo');

    // Edit the "Full" toolbar and remove 'code'
    // delete from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
    /*
    if( ($key = array_search('code' , $toolbars['Full' ][2])) !== false )
    {
    unset( $toolbars['Full' ][2][$key] );
    }
     */

    // remove the 'Basic' toolbar completely
    unset($toolbars['Basic']);

    // return $toolbars - IMPORTANT!
    return $toolbars;
});

// Enqueue our custom Admin JavaScript
add_action('admin_enqueue_scripts', function () {
    wp_enqueue_script('admin_scripts_js', plugin_dir_url( __FILE__ ) . 'js/admin.js');
}, 100);