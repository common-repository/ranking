<?php
/**
 * @package GC-RANKING-POST
 * Plugin Name: Ranking SEO 一鍵發文
 * Description: 使用 Ranking SEO 一鍵發文，能讓你將透過 Ranking AI SEO 工具寫好的 SEO 文章，直接發佈到 WordPress  網站後台或前台。只要在 Ranking AI SEO 工具中，設定好排程時間與網址命名，即可輕鬆上稿，並連同 SEO 基本設定也幫你設置完成。
 * Version: 1.0
 * Author: Ranking AI SEO
 * Author URI:https://ranking.works/
 * Text Domain:gc-ranking-post
 * License:GPL-3.0+
 * License URI:https://www.gnu.org/licenses/gpl-3.0.txt
 * 
 */

# 如果直接調用該文件，則中止。
defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

# 定義常數
define('GCREATE_RANKING_POST', plugin_basename(__FILE__));

/**
 * 外掛啟用期間運行的代碼
 * # GC_Chandler 2024-03-20 Includes>GCREATE
 */
function gcreate_ranking_post_activate()
{
    GCREATE\Base\Activate::activate();
}
register_activation_hook(__FILE__, 'gcreate_ranking_post_activate');

/**
 * 外掛停用期間運行的代碼
 * # GC_Chandler 2024-03-20 Includes>GCREATE
 */
function gcreate_ranking_post_deactivate()
{
    GCREATE\Base\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'gcreate_ranking_post_deactivate');

/**
 * 初始化插件所有核心class
 * # GC_Chandler 2024-03-20 Includes>GCREATE
 */
if (class_exists('GCREATE\\Init')) {
    GCREATE\init::register_services();
}

function gcreate_ranking_post_my_redirect_on_plugin_activation($plugin)
{
    if ($plugin == GCREATE_RANKING_POST) {
        exit(wp_redirect(admin_url('admin.php?page=gc_ranking_post')));
    }
}

add_action('activated_plugin', 'gcreate_ranking_post_my_redirect_on_plugin_activation');