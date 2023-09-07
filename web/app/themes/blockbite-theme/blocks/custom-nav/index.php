<?php

/**
 * Register Custom Nav block
 */
add_action('init', 'custom_ponzo_nav_init');
function custom_ponzo_nav_init()
{
    $handle = 'custom-nav';
    wp_register_script(
        $handle,
        get_template_directory_uri() . "/blocks/" . $handle . "/index.js",
        [
            'wp-element',
            'wp-blocks',
            'wp-server-side-render'
        ]
    );
    register_block_type('blockbite/' . $handle, [
        'editor_script' => $handle,
        'render_callback' => 'custom_ponzo_nav_render',
        'attributes' => []
    ]);
}
/**
 * Render Custom Nav Block
 */
function custom_ponzo_nav_render($attrs)
{
    ob_start();
    get_template_part('blocks/custom-nav/menu');
    return ob_get_clean();
}
