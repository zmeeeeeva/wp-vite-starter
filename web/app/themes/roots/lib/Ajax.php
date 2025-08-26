<?php

namespace WpApp;

class Ajax
{
    private function add_action(string $name): void
    {
        add_action('wp_ajax_' . $name, [$this, $name]);
        add_action('wp_ajax_nopriv_' . $name, [$this, $name]);
    }

    private function add_admin_action(string $name): void
    {
        add_action('wp_ajax_' . $name, [$this, $name]);
    }

    public function __construct()
    {
        $this->add_action('example');
    }

    private function example()
    {
        dump('Hello');
        wp_die();
    }
}
