<?php
/**
 * @package GC-RANKING-POST
 */

namespace GCREATE\Base; # GC_Chandler 2024-03-20 Includes>GCREATE

use \GCREATE\Api\Callbacks\RestApiCallbacks;

class RestAPIs extends BaseController
{
    public $callbacks;
    public function register()
    {
        $this->callbacks = new RestApiCallbacks();

        add_action('rest_api_init', array($this,'post_list_register_routes') );
        add_action('rest_api_init', array($this,'categories_register_routes') );
        add_action('rest_api_init', array($this,'post_create_register_routes') );
    }
    function post_list_register_routes() {
        register_rest_route('post', '/list', array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => [$this->callbacks,'get_post_list'],
        ));
    }
    function categories_register_routes() {
        register_rest_route('post', '/categories', array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => [$this->callbacks,'get_categories'],
        ));
    }
    function post_create_register_routes() {
        register_rest_route('post', '/create', array(
            'methods' => \WP_REST_Server::EDITABLE,
            'callback' => [$this->callbacks,'post_creating'],
        ));
    }
}