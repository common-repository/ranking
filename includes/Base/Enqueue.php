<?php
/**
 * @package GC-RANKING-POST
 */

namespace GCREATE\Base; # GC_Chandler 2024-03-20 Includes>GCREATE

use \GCREATE\Base\BaseController;
use \GCREATE\Pages\Admin;

class Enqueue extends BaseController
{
    public $AdminClass;
    public function register()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }
    function enqueue()
    {
        # GC_Chandler:2024-01-22
        if (isset($_GET['page']) && sanitize_text_field($_GET['page']) === 'gc_ranking_post') {
            wp_enqueue_style('grp-style', $this->plugin_url . 'assets/css/grp-style.css');
            wp_enqueue_script('grp-script', $this->plugin_url . 'assets/js/grp-script.js');
            wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200', array(), '1.0.0', 'all');
        }
    }
}