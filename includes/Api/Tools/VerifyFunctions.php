<?php
/**
 * @package GC-RANKING-POST
 */

namespace GCREATE\Api\Tools; # GC_Chandler 2024-03-20 Includes>GCREATE

class VerifyFunctions
{

    public $prefix = 'validation_';

    public function VerifyUserName($username)
    {
        $args = array();
        if (empty($username)) {
            $args = [
                'code' => 400,
                'message' => __('未輸入帳號', 'gc-ranking-post')
            ];
        } else if (username_exists($username)) {
            $args = [
                'code' => 200,
                'message' => __('帳號存在', 'gc-ranking-post')
            ];
        } else {
            $args = [
                'code' => 404,
                'message' => __('帳號不存在', 'gc-ranking-post')
            ];
        }
        return $args;
    }

    public function VerifyRankingPostWebsiteToken($input_token)
    {
        $args = array();
        $wp_token = get_option($this->prefix.'token');
        if (empty($input_token)) {
            $args = [
                'code' => 400,
                'message' => __( '未輸入Token', 'gc-ranking-post')
            ];
        } else if ($wp_token === $input_token) {
            $args = [
                'code' => 200,
                'message' => __( 'Token正確', 'gc-ranking-post')
            ];
        } else {
            $args = [
                'code' => 404,
                'message' => __( 'Token錯誤', 'gc-ranking-post')
            ];
        }
        return $args;
    }

    public function VerifyRankingPostRKToken($input_token)
    {
        $args = array();
        $ranking_post_token = get_option('ranking_post_token');
        if (empty($input_token)) {
            $args = [
                'code' => 400,
                'message' => __('未輸入RankingSEO系統的Token', 'gc-ranking-post')
            ];
        } else if ($ranking_post_token == $input_token) {
            $args = [
                'code' => 200,
                'message' => __('Token正確', 'gc-ranking-post')
            ];
        } else {
            $args = [
                'code' => 404,
                'message' => __('Token錯誤', 'gc-ranking-post')
            ];
        }
        return $args;
    }

    public function VerifyPostNameExists($post_name)
    {
        if (empty($post_name)) {
            $args = [
                'code' => 400,
                'message' => __('未輸入文章標題', 'gc-ranking-post')
            ];
        }else{
            $existing_post = get_page_by_path($post_name, OBJECT, 'post');
            if ($existing_post) {
                $args = [
                    'code' => 202,
                    'message' => __('文章標題已存在，不需要創建', 'gc-ranking-post')
                ];
            } else {
                $args = [
                    'code' => 200,
                    'message' => __('文章標題不存在可創建', 'gc-ranking-post')
                ];
            }
        }
        return $args;
    }

    public function VerifyPostCategoryExists( array $post_category )
    {
        if (empty($post_category)) {
            $args = [
                'code' => 400,
                'message' => __('沒有輸入分類', 'gc-ranking-post')
            ];
        }else{
            $args = [
                'code' => 200,
                'message' => __('有輸入分類', 'gc-ranking-post')
            ];
            $exists_cat_ids = $not_exists_cat_ids = array();
            
            foreach ($post_category as $category_id) {
                $category = get_term_by('id', $category_id, 'category');
                if ($category !== false && !is_wp_error($category)) {
                    array_push($exists_cat_ids, $category_id);
                }else{
                    array_push($not_exists_cat_ids, $category_id);
                }
            }
            $args['categories']['existsCatIds'] = $exists_cat_ids;
            $args['categories']['notExistsCatIds'] = $not_exists_cat_ids;
        }
        return $args;
    }

    public function VerifyPostStatusExists($post_status)
    {
        $all_post_statuses = array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash');
        if( empty( $post_status ) ){
            $args = [
                'code' => 400,
                'message' => __('沒有輸入文章類型', 'gc-ranking-post')
            ];
        }else if(!in_array($post_status, $all_post_statuses)){
            $args = [
                'code' => 404,
                'message' => __('文章狀態不存在', 'gc-ranking-post')
            ];
        }else{
            $args = [
                'code' => 200,
                'message' => __('文章狀態存在', 'gc-ranking-post')
            ];
        }
        return $args;
    }
}