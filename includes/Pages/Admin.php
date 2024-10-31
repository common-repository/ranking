<?php
/**
 * @package GC-RANKING-POST
 */

namespace GCREATE\Pages; # GC_Chandler 2024-03-20 Includes>GCREATE

use \GCREATE\Api\SettingsApi;
use \GCREATE\Base\BaseController;
use \GCREATE\Api\Callbacks\AdminCallbacks;

class Admin extends BaseController
{
    public $settings;
    public $callbacks;
    public $pages = array();
    public $subpages = array();
    public function register()
    {

        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->setPages();

        # $this->setSubpages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addPages($this->pages)->withSubPage('SettingPage')->addSubPages($this->subpages)->register();

        if (is_admin()) {
            # GC_Chandler:2023-10-16 Powered by Ranking AI SEO & GCreate（是否可置入連結文字）
            add_action('in_admin_footer', array($this, 'modify_footer_text'));
        }
    }
    public function setPages()
    {
        $svg_url = plugins_url('assets/img/ranking_r_logo_white_615_615.svg', GCREATE_RANKING_POST);
        $response = wp_remote_get($svg_url);
        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            $svg = wp_remote_retrieve_body($response);

        } else {
            $svg = '';
        }
        $data_img_svg = 'data:image/svg+xml;base64,' . base64_encode($svg);
        $this->pages = array(
            array(
                'page_title' => 'Ranking Post',
                'menu_title' => 'Ranking Post',
                'capability' => 'manage_options',
                'menu_slug' => 'gc_ranking_post',
                'callback' => array($this->callbacks, 'adminDashboard'),
                'icon_url' => $data_img_svg,
                'position' => '110'
            )
        );
    }

    public function setSubpages()
    {
        $this->subpages = array(
            array(
                'parent_slug' => 'gc_ranking_post',
                'page_title' => 'Custom Sub Page1',
                'menu_title' => 'CSP1',
                'capability' => 'manage_options',
                'menu_slug' => 'gc_ranking_post_csp1',
                'callback' => function () {
                    echo '<h1>Chandler Hi! Custom Sub Page1</h1>';
                },
            ),
            array(
                'parent_slug' => 'gc_ranking_post',
                'page_title' => 'Custom Sub Page2',
                'menu_title' => 'CSP2',
                'capability' => 'manage_options',
                'menu_slug' => 'gc_ranking_post_csp2',
                'callback' => function () {
                    echo '<h1>Chandler Hi! Custom Sub Page2</h1>';
                },
            )
        );
    }
    public function setSettings()
    {
        global $wpdb;
        $args = array(
            array(
                'option_group' => 'gc_ranking_post_settings',
                'option_name' => 'ranking_post_token',
                'callback' => array($this->callbacks, 'gcRankingPostGroup'),
            ),
            array(
                'option_group' => 'gc_ranking_post_settings',
                'option_name' => 'gcreate_ranking_post_website',
                'callback' => array($this->callbacks, 'gcRankingPostGroup'),
            ),
            array(
                'option_group' => 'gc_ranking_post_settings',
                'option_name' => $this->prefix . 'token',
                'callback' => array($this->callbacks, 'gcRankingPostGroup'),
            ),
            array(
                'option_group' => 'gc_ranking_post_settings',
                'option_name' => $this->prefix . 'admin_email',
                'callback' => array($this->callbacks, 'gcRankingPostGroup'),
            ),
            array(
                'option_group' => 'gc_ranking_post_settings',
                'option_name' => $this->prefix . 'admin_user_id',
                'callback' => array($this->callbacks, 'gcRankingPostGroup'),
            ),
        );
        
        return $this->settings->setSettings($args);
    }
    public function setSections()
    {
        $args = array(
            array(
                'id' => 'gc_ranking_post_admin_index',
                'title' => 'Settings',
                'callback' => array($this->callbacks, 'gcRankingPostSection'),
                'page' => 'gc_ranking_post',
                # 某目錄頁
            )
        );

        return $this->settings->setSections($args);
    }
    public function setFields()
    {
        global $wpdb;
        $args = array(
            array(
                'id' => 'ranking_post_token',
                # 回到setting 欄位
                'title' => 'Ranking Post Token',
                'callback' => array($this->callbacks, 'gcRankingPostRKToken'),
                'page' => 'gc_ranking_post',
                # 某目錄頁
                'section' => 'gc_ranking_post_admin_index',
                # 某section
                'args' => array(
                    'label_for' => 'ranking_post_token',
                    'class' => '',
                ),
            ),
            array(
                'id' => 'gcreate_ranking_post_website',
                # 回到setting 欄位
                'title' => 'Ranking Post Website',
                'callback' => array($this->callbacks, 'gcRankingPostWebsite'),
                'page' => 'gc_ranking_post',
                # 某目錄頁
                'section' => 'gc_ranking_post_admin_index',
                # 某section
                'args' => array(
                    'label_for' => 'gcreate_ranking_post_website',
                    'class' => '',
                ),
            ),
            array(
                'id' => 'gcreate_ranking_post_website_api',
                # 回到setting 欄位
                'title' => 'Ranking Post Website API',
                'callback' => array($this->callbacks, 'gcRankingPostWebsiteAPI'),
                'page' => 'gc_ranking_post',
                # 某目錄頁
                'section' => 'gc_ranking_post_admin_index',
                # 某section
                'args' => array(
                    'label_for' => 'gcreate_ranking_post_website_api',
                    'class' => '',
                ),
            ),
            array(
                'id' => $this->prefix.'token',
                # 回到setting 欄位
                'title' => 'WP Website Token',
                'callback' => array($this->callbacks, 'gcRankingPostWPToken'),
                'page' => 'gc_ranking_post',
                # 某目錄頁
                'section' => 'gc_ranking_post_admin_index',
                # 某section
                'args' => array(
                    'label_for' => $this->prefix.'token',
                    'class' => '',
                ),
            ),
            array(
                'id' => $this->prefix.'admin_email',
                # 回到setting 欄位
                'title' => 'Web Admin Email',
                'callback' => array($this->callbacks, 'gcRankingPostWebAdminEmail'),
                'page' => 'gc_ranking_post',
                # 某目錄頁
                'section' => 'gc_ranking_post_admin_index',
                # 某section
                'args' => array(
                    'label_for' => $this->prefix.'admin_email',
                    'class' => '',
                ),
            ),
        );

        return $this->settings->setFields($args);
    }

    public function modify_footer_text()
    {
        if ($this->is_gc_ranking_post()) {
            add_filter('admin_footer_text', array($this, 'filter_modify_footer_text'), 999, 1);
        }
    }

    public function filter_modify_footer_text($text)
    {
        $a_html = '<a href="https://ranking.works/">Ranking AI SEO</a>';
        return 'Powered by ' . $a_html . ' & GCreate';
    }
    
    public function is_gc_ranking_post()
    {
        $result = false;
        $current_screen = get_current_screen();
        if ($current_screen && $current_screen->id === 'toplevel_page_gc_ranking_post') {
            $result = true;
        }
        return $result;
    }
}