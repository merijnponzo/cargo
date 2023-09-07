<?php

namespace Blockbite\Assets;

class SiteAssets
{
    public $assets = [];
    public $manifest = false;
    public $dir = false;
    public $uri = false;
    public $version = '1.0.3';

    public function __construct()
    {
        $this->dir = get_template_directory();
        $this->uri = get_template_directory_uri();
        $this->manifest = $this->manifestAssets();
        
        $defaultAssets = [
            [
                'name' => 'alpine',
                'type' => 'js',
                'file' => 'https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js'
            ],
            [
                'name' => 'plyr-video',
                'type' => 'js',
                'file' => 'https://cdn.plyr.io/3.7.8/plyr.js'
            ],
            [
                'name' => 'plyr-css',
                'type' => 'css',
                'file' => 'https://cdn.plyr.io/3.7.8/plyr.css'
            ],
            [
                'name' => 'gsap-js',
                'type' => 'js',
                'file' => 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js'
            ],
            [
                'name' => 'gsap-css',
                'type' => 'js',
                'file' => 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js'
            ]
        ];
        
        if (is_admin()) {
            $defaultAssets[] = [
                'name' => 'theme-blockstyles',
                'type' => 'js',
                'file' => $this->uri . '/blocks/block-styles.js'
            ];
        }

        $this->assets = array_merge($defaultAssets, $this->manifestAssets());

        if (current_user_can('editor') || current_user_can('administrator')) {
            add_action('admin_init', [$this, 'enqueueAdminAssets']);
        }
        
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    public function manifestAssets()
    {
        $files = $this->getManifest();
        $manifestAssets = [];

        foreach ((array) $files as $name => $asset) {
            if (isset($asset)) {
                $ext = pathinfo($asset, PATHINFO_EXTENSION);

                $file = [
                    'name' => $name,
                    'type' => $ext,
                    'manifest' => true,
                    'file' => "{$this->uri}{$asset}"
                ];

                $manifestAssets[] = $file;
            }
        }

        return $manifestAssets;
    }

    public function getManifest()
    {
        $manifestFile = $this->dir . '/mix-manifest.json';

        if (file_exists($manifestFile)) {
            return json_decode(file_get_contents($manifestFile), true);
        } else {
            throw new Exception($manifestFile . ' is not found');
        }
    }

    public function enqueueAssets()
    {
        $version = WP_ENV !== null && WP_ENV == 'production' ? null : rand(1, 100);
        
        foreach ((array) $this->assets as $asset) {
            if ($asset['type'] == 'js') {
                wp_enqueue_script($asset['name'], $asset['file'], [], $version);
            } elseif ($asset['type'] == 'css') {
                wp_enqueue_style($asset['name'], $asset['file'], [], $version);
            }
        }
    }

    public function enqueueAdminAssets()
    {
        $editorStyles = [];
        $version = WP_ENV !== null && WP_ENV == 'production' ? null : rand(1, 100);

        foreach ((array) $this->assets as $asset) {
            if ($asset['type'] == 'js') {
                wp_enqueue_script($asset['name'], $asset['file'], [], $version);
            } elseif ($asset['type'] == 'css') {
                $editorStyles[] = $asset['file'];
            }
        }
        add_editor_style($editorStyles);
    }
}
