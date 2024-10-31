<?php
/**
 * @package GC-RANKING-POST
 */

namespace GCREATE\Api\Callbacks; # GC_Chandler 2024-03-20 Includes>GCREATE

use GCREATE\Base\BaseController;

class RestApiCallbacks extends BaseController
{
    /**
     * 取得網站所有文章ID與title
     */
    function get_post_list($request)
    {
       
        $response = array();
        $input_wp_token = empty($request[$this->prefix . 'token']) ? null : $request[$this->prefix . 'token'];
        $v_wp_token = $this->verify_functions->VerifyRankingPostWebsiteToken($input_wp_token);
        if ($v_wp_token['code'] == 200) {
            $data = $this->queryinfo_functions->QueryPostList($request);
            $response = [
                'code' => $v_wp_token['code'],
                'message' => $v_wp_token['message'] . ' , ' . $v_wp_token['message'],
                'data' => $data
            ];
        } else {
            $response = [
                'code' => $v_wp_token['code'],
                'message' => $v_wp_token['message'],
            ];
        }

        return rest_ensure_response($response);
    }
    function get_categories($request)
    {
        $response = array();
        $input_token = empty($request[$this->prefix . 'token']) ? null : $request[$this->prefix . 'token'];
        $v_wp_token = $this->verify_functions->VerifyRankingPostWebsiteToken($input_token);
        if ($v_wp_token['code'] == 200) {
            $data = $this->queryinfo_functions->QueryCategories($request) ?? array();
            $response = [
                'code' => $v_wp_token['code'],
                'message' => $v_wp_token['message'] . ' , ' . $v_wp_token['message'],
                'data' => $data
            ];
        } else {
            $response = [
                'code' => $v_wp_token['code'],
                'message' => $v_wp_token['message'],
            ];
        }
        return rest_ensure_response($response);
    }

    function post_creating($request)
    {
        #GC_minos:新增log
        $response = array();
        $input_wp_token = empty($request[$this->prefix . 'token']) ? null : sanitize_text_field( $request[$this->prefix . 'token'] );
        $v_wp_token = $this->verify_functions->VerifyRankingPostWebsiteToken($input_wp_token);
        if ($v_wp_token['code'] !== 200) {
            $response = $v_wp_token;
            return rest_ensure_response($response);
        }

        $input_rk_token = empty($request['rk_token']) ? null : $request['rk_token'];
        $v_rk_token = $this->verify_functions->VerifyRankingPostRKToken($input_rk_token);
        if ($v_rk_token['code'] !== 200) {
            $response = $v_rk_token;
            return rest_ensure_response($response);
        }

        $post_name = empty($request['post_name']) ? $request['post_title'] : $request['post_name'];
        $v_post_name = $this->verify_functions->VerifyPostNameExists($post_name);
        if ($v_post_name['code'] !== 200) {
            $response = $v_post_name;
            return rest_ensure_response($response);
        }

        $response = $this->queryinfo_functions->QueryPostCreate($request);
        return rest_ensure_response($response);
    }
}