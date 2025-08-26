<?php

namespace WpApp;

use Env\Env;

class Assets
{
    const ASSETS_DIR = '/public/';

    public function __construct()
    {

        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');

        add_action('wp_head', [$this, 'theme_enqueue_dev_assets']);
        add_action('wp_enqueue_scripts', [$this, 'theme_enqueue_prod_assets']);
        add_filter('script_loader_tag', [$this, 'add_attributes_to_script'], 10, 3);

    }

    function theme_enqueue_prod_assets(): void
    {
        if (defined('WP_ENV') && WP_ENV === 'development') return;

        $manifestPath = get_template_directory() . '/public/.vite/manifest.json';
        if (!file_exists($manifestPath)) return;

        $manifest = json_decode(file_get_contents($manifestPath), true);
        $app = $manifest['src/scripts/app.js'];

        wp_enqueue_script('theme-js', get_template_directory_uri() . self::ASSETS_DIR . $app['file'], [], null, true);

        if (!empty($app['css'])) {
            foreach ($app['css'] as $css) {
                wp_enqueue_style('theme-css', get_template_directory_uri() . self::ASSETS_DIR . $css, [], null);
            }
        }
    }

    function theme_enqueue_dev_assets(): void
    {
        if (defined('WP_ENV') && WP_ENV === 'development') {
            $port = Env::get('VITE_PORT');

            // HMR React support
            echo sprintf('<script type="module">
                  import RefreshRuntime from "https://localhost:%s/@react-refresh"
                  RefreshRuntime.injectIntoGlobalHook(window)
                  window.$RefreshReg$ = () => {}
                  window.$RefreshSig$ = () => (type) => type
                  window.__vite_plugin_react_preamble_installed__ = true
                  </script>', $port);

            echo sprintf('<script type="module" src="https://localhost:%s/src/scripts/app.js"></script>', $port);
        }
    }

    public function get_assets(): array
    {
        $base = get_template_directory_uri() . '/assets/';
        $manifest = get_template_directory() . '/assets/.vite/manifest.json';
        $output = [];

        if (file_exists($manifest)) {
            $assets = json_decode(file_get_contents($manifest), true);

            $scripts_path = 'src/scripts/';
            $styles_path = 'src/styles/';

            foreach ($assets as $key => $value) {
                if (str_contains($key, $scripts_path)) {
                    $name = str_replace($scripts_path, '', $key);
                    $output[$name] = $base . $value['file'];
                }

                if (str_contains($key, $styles_path)) {
                    $name = str_replace($styles_path, '', $key);
                    $output[$name] = $base . $value['file'];
                }
            }
        }

        return $output;
    }

    private function get_assets_base(): string
    {
        return get_template_directory_uri() . '/assets/';
    }

    public function do_assets(): void
    {
        $assets = $this->get_assets();
        $ver = null;

        wp_enqueue_style('app.css', $assets['app.css'], [], $ver);
        wp_enqueue_script('app.js', $assets['app.js'], [], $ver, true);
    }

    function add_attributes_to_script($tag, $handle, $src)
    {
        $scripts = $this->get_assets();
        $keys = array_keys($scripts);

        if (in_array($handle, $keys)) {
            $tag = '<script type="module" src="' . esc_url($src) . '" id="' . str_replace('.js', '', $handle) . '" ></script>';
        }

        return $tag;
    }

}
