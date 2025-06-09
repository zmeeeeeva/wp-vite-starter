<?php

use WpApp\Render;

function render($template, $params = [], $echo = true): void
{
    $render = new Render();
    $render->render($template, $params, $echo);
}
