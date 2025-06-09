<?php

namespace WpApp;

use WpApp\Menu;
use Twig;

class Render
{
    private $twig = null;
    public $header = null;

    function load_twig(): void
    {
        $loader = new Twig\Loader\FilesystemLoader(get_template_directory() . '/templates');
        $this->twig = new Twig\Environment($loader, ['debug' => true]);

        $this->twig->addExtension(new Twig\Extension\DebugExtension());

        $this->twig->addFilter(new Twig\TwigFilter('slugify', function ($string = '') {
            return sanitize_title($string);
        }));


        $this->twig->addFunction(new Twig\TwigFunction('function', [$this, 'exec_function']));
        $this->twig->addFunction(new Twig\TwigFunction('img', [$this, 'img']));
        $this->twig->addFunction(new Twig\TwigFunction('template_img', [$this, 'template_img']));

        $wp_functions = [
            '__',
            '_e',
            'do_shortcode',
            'the_widget',
            'body_class',
        ];

        foreach ($wp_functions as $function) {
            $this->twig->addFunction(new Twig\TwigFunction($function, $function));
        }

        $this->twig->addFunction(new Twig\TwigFunction('header', [$this->header, 'get_content']));
    }

    public function render(string $template, $params = array(), $echo = true)
    {
        if ($this->twig == null) {
            $this->load_twig();
        }

        $template = $this->twig
            ->render($template . '.twig', array_merge([
                'gtag' => App::get_gtag(),
                'menu' => Menu::get_menu_items(),
                'ajaxurl' => admin_url('admin-ajax.php'),
            ], $params));
        if ($echo) {
            echo $template;
        } else {
            return $template;
        }
    }

    public function img(string $path): string
    {
        return get_template_directory_uri() . '/images/' . $path;
    }

    public function template_img(string $template, string $name): string
    {
        return get_template_directory_uri() . '/images/' . $template . '/' . $name;
    }

    public function exec_function(string $function_name)
    {
        $args = func_get_args();
        array_shift($args);
        $function_name = trim($function_name);
        return call_user_func_array($function_name, ($args));
    }

}
