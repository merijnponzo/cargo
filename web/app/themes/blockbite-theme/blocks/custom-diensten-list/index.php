<?php

/**
 * Register Custom Nav block
 */
add_action('init', 'custom_ponzo_diensten_list_init');
function custom_ponzo_diensten_list_init()
{
    $handle = 'custom-diensten-list';
    wp_register_script(
        $handle,
        get_template_directory_uri() . "/custom-blocks/" . $handle . "/index.js",
        [
            'wp-element',
            'wp-blocks',
            'wp-server-side-render'
        ]
    );
    register_block_type('blockbite/' . $handle, [
        'editor_script' => $handle,
        'render_callback' => 'custom_ponzo_diensten_list_render',
        'attributes' => []
    ]);
}
/**
 * Render Custom Nav Block
 */
function custom_ponzo_diensten_list_render($attrs)
{
    ob_start();
    get_template_part('custom-blocks/custom-diensten-list/list');
    return ob_get_clean();
}
