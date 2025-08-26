<?php

use WpApp\App;

while (have_posts()) : the_post();
    $post_id = get_the_ID();
    $content = App::get_post($post_id);
    render('single-post', $content);
endwhile;
