<?php

namespace WpApp;

use WP_Post;
use WP_Term;
use WP_Query;

class App
{

    public static function get_gtag()
    {
        return env('GTAG') ?? '';
    }

    public static function get_content(WP_Query $wp_query): array
    {
        $object = $wp_query->get_queried_object();

        $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;

        $pagination = paginate_links([
            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format' => '?paged=%#%',
            'current' => $paged,
            'total' => $wp_query->max_num_pages,
            'mid_size' => 2,
            'prev_text' => __('«', '__THEME_NAME__'),
            'next_text' => __('»', '__THEME_NAME__'),
        ]);

        return [
            'pagination' => $pagination,
            'object' => $object,
            'posts' => array_map([self::class, 'map_post'], $wp_query->posts),
        ];
    }

    public static function get_post(int $post_id): array
    {
        $post = get_post($post_id);
        return self::map_post($post);
    }

    public static function map_post(WP_Post $post): array
    {
        $id = $post->ID;
        $date_format = 'd.m.Y';

        $categories = get_the_category($id);
        $tags = get_the_tags($id);

        $content = [
            'id' => $id,
            'title' => apply_filters('the_title', $post->post_title),
            'excerpt' => apply_filters('the_excerpt', $post->post_excerpt),
            'content' => apply_filters('the_content', $post->post_content),
            'url' => get_permalink($id),
            'date' => get_the_date($date_format, $id),
            'author' => get_the_author_meta('display_name', get_post_field('post_author', $id)),
            'categories' => $categories ? array_map([self::class, 'map_term'],$categories) : [],
            'tags' => $tags ? array_map([self::class, 'map_term'], $tags) : [],
        ];

        $featured_image_id = get_post_thumbnail_id($id);

        if ($featured_image_id) {
            $content['image'] = self::map_image($featured_image_id, 'medium');
        }

        return $content;
    }

    public static function map_term(WP_Term $term): array
    {
        return [
            'name' => $term->name,
            'url' => get_tag_link($term->term_id)
        ];
    }

    public static function map_image(int $attachment_id, string $size = 'large'): array
    {
        $full = wp_get_attachment_image_src($attachment_id, 'large')[0];
        $medium = wp_get_attachment_image_src($attachment_id, 'medium')[0];

        $data = wp_get_attachment_image_src($attachment_id, $size);
        $thumb = wp_get_attachment_image_src($attachment_id);

        $src = $data[0];
        $parts = explode('/', $src);
        $filename = end($parts);

        return [
            'id' => $attachment_id,
            'full' => $full,
            'medium' => $medium,
            'src' => $src,
            'filename' => $filename,
            'thumbnail' => $thumb[0],
            'w' => $data[1],
            'h' => $data[2],
            'caption' => wp_get_attachment_caption($attachment_id),
        ];
    }

    public static function get_post_content(int $id): array
    {
        $post = get_post($id);
        $title = apply_filters('the_title', $post->post_title);
        $content = apply_filters('the_content', $post->post_content);
        $excerpt = apply_filters('the_excerpt', $post->post_excerpt);

        $content = [
            'id' => $id,
            'type' => $post->post_type,
            'title' => $title,
            'date' => get_the_date('d.m.Y', $id),
            'content' => $content,
            'excerpt' => $excerpt,
            'url' => get_permalink($id),
        ];

        $featured_image_id = get_post_thumbnail_id($id);

        if ($featured_image_id) {
            $content['image'] = self::map_image($featured_image_id, 'cover');
        }

        return $content;
    }
}
