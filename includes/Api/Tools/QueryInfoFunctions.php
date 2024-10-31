<?php
/**
 * @package GC-RANKING-POST
 */

namespace GCREATE\Api\Tools; # GC_Chandler 2024-03-20 Includes>GCREATE

class QueryInfoFunctions
{
    public function QueryPostList($request)
    {
        $post_status = isset($_GET['post_status']) ? sanitize_text_field($_GET['post_status']) : null;
        $args = array(
            'post_type' => 'post',
            'post_status' => $post_status,
            'posts_per_page' => -1,
        );
        $posts = get_posts($args);

        $data = array();

        foreach ($posts as $post) {
            $data[] = array(
                'post_id' => $post->ID,
                'post_title' => $post->post_title,
            );
        }

        # 合併後給的
        return $data;
    }
    public function QueryCategories($request = array())
    {
        $data = array();
        // Get all categories
        $categories = get_categories() ?? array();

        // Loop through the categories and access their properties
        if ($categories) {
            foreach ($categories as $category) {
                $data[] = array(
                    'category_id' => $category->cat_ID, // Category name
                    'category_name' => $category->cat_name,
                    'parent_id' => $category->parent
                );
                # $category_link = get_category_link($category->term_id); // Category link
            }
        } 

        return $data;
    }
    public function QueryPostCreate($post_args)
    {
        global $wpdb;
        $response = array();

        $post_author =  get_option($wpdb->prefix.'admin_user_id');

        $new_post = array(
            'post_author' => $post_author,
            'post_title' => $post_args['post_title'],
            'post_status' => ($post_args['post_status']) ?? 'publish',
            'post_date' => ($post_args['post_date']) ?? date_i18n('Y-m-d H:i:s'),
            'post_name' => ($post_args['post_name']) ?? sanitize_title($post_args['post_title']),
            'post_content' => $post_args['post_content'],
            'post_category' => $post_args['post_category'] ?? array(0),
        );
        // Insert the post into the database
        $new_post_id = wp_insert_post($new_post);

        // Check if the post creation was successful
        if ($new_post_id instanceof WP_Error) {
            // Handle the error
            $response = [
                'code' => 400,
                'message' => $new_post_id->get_error_message(),
            ];
        } elseif ($new_post_id === 0) {
            $response = [
                'code' => 500,
                'message' => __('創建文章發生未知錯誤', 'gc-ranking-post')
            ];
        } else {
            $data = [
                'post_id' => $new_post_id,
                'post_url' => get_permalink($new_post_id),
            ];
            $response = [
                'code' => 200,
                'message' => __('創建文章成功', 'gc-ranking-post'),
                'data' => $data,
            ];
        }
        return $response;
    }
}