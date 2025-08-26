<?php

namespace WpApp;

use WP_Post;

class Menu
{
    public static function get_current_url(): string
    {
        global $wp;
        return home_url(add_query_arg([], $wp->request)) . '/';
    }

    public static function get_menu_items(string $location = 'primary'): array
    {
        $locations = get_nav_menu_locations();
        $items = wp_get_nav_menu_items($locations[$location]);
        return $items ? array_map([self::class, 'map_menu_item'], $items) : [];

    }

    public static function map_menu_item(WP_Post $item): array
    {
        $current_url = self::get_current_url();

        return [
            'title' => $item->title,
            'target' => $item->target,
            'url' => $item->url,
            'is_current' => str_contains($current_url, $item->url),
        ];
    }

    public static function get_menu(string $menu, int $depth = 0, string $class = ''): bool|string|null
    {
        return wp_nav_menu([
            'menu' => $menu,
            'depth' => $depth,
            'echo' => false,
            'container' => false,
            'menu_class' => $class,
            'theme_location' => $menu,
        ]);
    }
}
