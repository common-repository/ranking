<?php
/**
 * @package GC-RANKING-POST
 */

namespace GCREATE\Api; # GC_Chandler 2024-03-20 Includes>GCREATE

class SettingsApi
{
    public $admin_pages = array();
    public $admin_subpages = array();
    public $settings = array();
    public $sections = array();
    public $fields = array();
    public $prefix = 'validation_';
    public function register()
    {
        if (!empty($this->admin_pages)) {
            add_action('admin_menu', array($this, 'addAdminMenu'));
        }

        if (!empty($this->settings)) {
            add_action('admin_init', array($this, 'registerCustomFields'));
        }
        # 註冊RK call API
        add_action('admin_init', array($this, 'rankPostregisterOrSave'), 999);
    }

    public function addPages(array $pages)
    {
        $this->admin_pages = $pages;

        return $this;
    }

    public function withSubPage(string $title = null)
    {
        if (empty($this->admin_pages)) {
            return $this;
        }

        $admin_page = $this->admin_pages[0];

        $subpage = array(
            array(
                'parent_slug' => $admin_page['menu_slug'],
                'page_title' => $admin_page['page_title'],
                'menu_title' => ($title) ? $title : $admin_page['menu_title'],
                'capability' => $admin_page['capability'],
                'menu_slug' => $admin_page['menu_slug'],
                'callback' => $admin_page['callback'],
            )
        );

        $this->admin_subpages = $subpage;

        return $this;
    }

    public function addSubPages(array $pages)
    {
        $this->admin_subpages = array_merge($this->admin_subpages, $pages);

        return $this;
    }
    public function addAdminMenu()
    {
        foreach ($this->admin_pages as $page) {
            add_menu_page(
                $page['page_title'],
                $page['menu_title'],
                $page['capability'],
                $page['menu_slug'],
                $page['callback'],
                $page['icon_url'],
                $page['position']
            );
        }

        foreach ($this->admin_subpages as $page) {
            add_submenu_page(
                $page['parent_slug'],
                $page['page_title'],
                $page['menu_title'],
                $page['capability'],
                $page['menu_slug'],
                $page['callback']
            );
        }
    }
    /**
     * 
     */
    public function setSettings(array $settings)
    {
        $this->settings = $settings;

        return $this;
    }
    public function setSections(array $sections)
    {
        $this->sections = $sections;

        return $this;
    }
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    public function registerCustomFields()
    {
        # 參考文獻 https://ithelp.ithome.com.tw/articles/10235331
        // register setting
        foreach ($this->settings as $setting) {
            register_setting(
                $setting["option_group"]
                ,
                $setting['option_name']
                ,
                isset($setting['callback']) ? $setting['callback'] : ''
            );
        }
        // add settings section
        foreach ($this->sections as $section) {
            add_settings_section(
                $section['id']
                ,
                $section['title']
                ,
                isset($section['callback']) ? $section['callback'] : ''
                ,
                $section['page']
            );
        }
        // add settings field
        foreach ($this->fields as $field) {
            add_settings_field(
                $field['id']
                ,
                $field['title']
                ,
                isset($field['callback']) ? $field['callback'] : ''
                ,
                $field['page']
                ,
                $field['section']
                ,
                isset($field['args']) ? $field['args'] : ''
            );
        }
    }

    public function rankPostregisterOrSave()
    {
        if (isset($_POST['submit_button_for_register_or_save'])) {
            // Verify nonce
            if ( ! isset( $_POST['rank_post_nonce'] ) || ! wp_verify_nonce(sanitize_text_field( wp_unslash( $_POST['rank_post_nonce'] ) ), 'rank_post_nonce_action' ) ) {
                wp_die('Security check failed. Please try again.');
            }
    
            $api_url = 'https://api.ranking.works/cms_plugins/validation';
            $website_api = esc_url( get_option('gcreate_ranking_post_website_api') );
            $validation_token = esc_attr( get_option( $this->prefix . 'token' ) );
            $rk_token = esc_attr( get_option('ranking_post_token') );
            $ranking_post_token = sanitize_text_field( $_POST['ranking_post_token'] );
    
            if( $ranking_post_token != $rk_token || empty( $rk_token ) ){
                $rk_token = ! empty( $ranking_post_token ) ? $ranking_post_token : null;
            }
    
            $api_data = array(
                'website_api' => $website_api,
                'rk_token' => $rk_token,
                'validation_token' => $validation_token
            );
            
            $response = wp_remote_post($api_url, array(
                'body'    => json_encode($api_data),
                'headers' => array('Content-Type' => 'application/json'),
            ));
    
            $response_code = json_decode(wp_remote_retrieve_response_code($response), true);
    
            if ($response_code != 200) {
                $response_body = json_decode(wp_remote_retrieve_body($response), true);
                add_settings_error('custom-error', 'custom-error', $response_body['message'], 'error');
            } 
        }
    }
}