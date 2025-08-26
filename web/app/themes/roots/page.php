<?php

use WpApp\App;

while (have_posts()) : the_post();
    $id = get_the_ID();
    $content = App::get_post_content($id);
    render('single-post', $content);
endwhile;

