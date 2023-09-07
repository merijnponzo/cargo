<?php

namespace Blockbite\PostTypes;

class sitePostTypes
{

    // create a construct where the manifest file is loaded and decoded
    public function __construct($version = '1.0.0')
    {
        add_action('init', [$this, 'register_posttypes']);
        add_filter('get_the_archive_title_prefix', '__return_false');
    }


    public static function register_posttypes()
    {
        // https://cnpagency.com/blog/the-right-way-to-do-wordpress-custom-taxonomy-rewrites/
        // REGISTER TAXONOMIES (BEFORE REGISTERING POST TYPES)
        $taxonomies = [
            [
                "name" => "branche",
                "slug" => "branche",
                "posttype" => "blog",
                'rewrite'      => array('slug' => 'blog/branche'),
            ]
        ];


        foreach ($taxonomies as $p => $taxonomy) {
            $t = (object) $taxonomy;
            $labels = array(
                'name' => "{$t->name}",
                'singular_name' => "{$t->name}",
                'search_items' => "Zoek {$t->name}",
                'popular_items' => "Veelgebruikte category",
                'all_items' => "Alle {$t->name}",
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __("Bewerk {$t->name}"),
                'update_item' => __("Update {$t->name}"),
                'add_new_item' => __("Nieuwe {$t->name} toevoegen"),
                'new_item_name' => __("Nieuwe {$t->name}"),
                'separate_items_with_commas' => __("Separate {$t->name} with commas"),
                'add_or_remove_items' => __('Toevoegen of verwijderen'),
                'choose_from_most_used' => __('Kies uit meestgebruikte tags'),
                'menu_name' => __("{$t->name}"),
            );
            register_taxonomy($t->slug, $t->posttype, array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
                'rewrite'  => $t->rewrite,
                'show_in_rest' => true,
                'show_admin_column' => true,
            ));
        }

            // POST_TYPES
        $blockbite_register_cpt = [
            [
                'title' => 'Diensten',
                'name' => 'diensten',
                'gutenberg' => true,
                'rest' => true,
                'icon' => 'dashicons-media-document',
                'template' => [],
                'rewrite' =>
                array(
                    'slug' => 'services',
                    'with_front' => false
                ),
            ],
            [
                'title' => 'Blog',
                'name' => 'blog',
                'gutenberg' => true,
                'rest' => true,
                'icon' => 'dashicons-media-document',
                'template' => [],
                'rewrite' =>
                array(
                    'slug' => 'blog',
                    'with_front' => false
                ),
            ]
        ];

        foreach ($blockbite_register_cpt as $post_type) {
            $labels = array(
                'name' => _x($post_type['title'], 'post type general name'),
                'singular_name' => _x($post_type['title'], 'post type singular name'),
                'menu_name' => _x($post_type['title'], 'admin menu'),
                'name_admin_bar' => _x($post_type['title'], 'add new on admin bar'),
                'add_new' => _x('Nieuwe toevoegen', 'selectedby'),
                'add_new_item' => __("Nieuwe {$post_type['title']} toevoegen"),
                'new_item' => __("Nieuwe {$post_type['title']}"),
                'edit_item' => __("Bewerk {$post_type['title']}"),
                'view_item' => __("Bekijk {$post_type['title']} toevoegen"),
                'all_items' => __("Alle {$post_type['title']}"),
                'search_items' => __("Zoek {$post_type['title']}"),
                'parent_item_colon' => __("Bovenliggend {$post_type['title']} :"),
                'not_found' => __("Bovenliggend {$post_type['title']} :"),
                'not_found_in_trash' => __("Geen {$post_type['title']} gevonden."),
            );

            $args = array(
                'labels' => $labels,
                'description' => __('Description.'),
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_nav_menus' => true,
                'query_var' => true,
                'capability_type' => 'post',
                'has_archive' => true,
                'taxonomies' => array(),
                'hierarchical' => true,
                'menu_position' => null,
                'rewrite'  => $post_type['rewrite'],
                'show_in_rest' => $post_type['rest'],
                'menu_icon' => $post_type['icon'],
                'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields'),
            );
            if (isset($post_type['template'])) {
                $args['template'] = $post_type['template'];
            }
            register_post_type($post_type['name'], $args);
        }
    }
}
