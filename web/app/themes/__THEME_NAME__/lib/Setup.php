<?php /** @noinspection ALL */

namespace WpApp;

use DOMDocument;
use WpApp\Events;
use WP_Post;
use WP_Query;

class Setup
{
    public function __construct()
    {
        add_action('setup_theme', function () {
            if (defined('WP_INSTALLING') && WP_INSTALLING) {
                switch_theme('__THEME_NAME__');
            }
        });

        add_action('after_setup_theme', [$this, 'theme_supports']);
        add_action('after_setup_theme', [$this, 'remove_admin_bar']);
        add_action('after_setup_theme', [$this, 'register_menus']);

        load_theme_textdomain('__THEME_NAME__', get_template_directory() . '/languages');

        add_filter('the_content', [$this, 'override_img']);
        add_filter('embed_oembed_html', [$this, 'embed_oembed_html'], 10, 3);

        update_option('medium_size_w', 800);
        update_option('medium_size_h', 450);
        update_option('medium_crop', 0);
        update_option('thumbnail_crop', 0);

        new Admin();
        new Assets();
        new Ajax();
    }

    public function register_menus()
    {
        register_nav_menus([
            'primary' => __('Main Menu', '__THEME_NAME__'),
            'menu_social' => __('Social Menu', '__THEME_NAME__'),
        ]);
    }

    public function remove_admin_bar()
    {
        show_admin_bar(false);
    }

    public function theme_supports()
    {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('menus');

    }

    public function override_img($content)
    {
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();

        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $image) {
            $child = $image;

            $src = $child->getAttribute('src');
            $child->setAttribute('data-src', $src);
            $child->setAttribute('src', $src);

            $srcset = $child->getAttribute('srcset');
            $child->setAttribute('data-srcset', $srcset);
            $child->setAttribute('srcset', '');

            $wrapper = $image->parentNode;

            if ($wrapper->tagName == 'p') {
                $image->setAttribute('class', 'js-lazy');
                $figure = $dom->createElement('div');
                $figure->setAttribute('class', 'js-track-visibility image');
                $figure->appendChild($child);
                $wrapper->parentNode->replaceChild($figure, $wrapper);
            }
        }

        libxml_use_internal_errors(false);

        return str_replace(['<body>', '</body>'], '', $dom->saveHTML($dom->getElementsByTagName('body')->item(0)));
    }

    public function embed_oembed_html($html, $url, $attr)
    {
        return '<div class="iframe">' . $html . '</div>';
    }

    public function img($path)
    {
        return get_theme_root_uri() . '/images/' . $path;
    }
}
