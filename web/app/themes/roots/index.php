<?php
/**
 * The main template file
 */

use WpApp\App;

global $wp_query;
$content = App::get_content($wp_query);
render('posts', $content);
