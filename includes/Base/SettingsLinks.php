<?php
/**
 * @package GC-RANKING-POST
 */

namespace GCREATE\Base; # GC_Chandler 2024-03-20 Includes>GCREATE

class SettingsLinks extends BaseController
{
    public function register()
    {
        # 雙引號 
        add_filter('plugin_action_links_'.GCREATE_RANKING_POST, array($this, 'setting_link'));
    }

    public function setting_link($links)
    {
        # add custom settings link
        $settings_link = '<a href="admin.php?page=gc_ranking_post">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }
}