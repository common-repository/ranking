<?php
/**
 * @package GC-RANKING-POST
 * GC_Chandler:2024-01-23 input wp_kses_post 判斷自動允許貼文內容中允許的所有 HTML
 */

namespace GCREATE\Api\Callbacks;  # GC_Chandler 2024-03-20 Includes>GCREATE

use GCREATE\Base\BaseController;

class AdminCallbacks extends BaseController
{
    public function adminDashboard()
    {
        return require_once( "$this->plugin_path/templates/admin.php" );
    }

    public function gcRankingPostGroup( $input )
    {
        return $input;
    }
    public function gcRankingPostSection()
    {
        #GC_minos:應沒有顯示必要echo 'Chick Section';
    }
    public function gcRankingPostTextExample()
    {
        $value = esc_attr( get_option( 'text_example' ) );
        echo '<input type="text" class="regular-text" name="text_example" value="'.wp_kses_post($value).'" placeholder="Chandler is handsome">';
    }
    public function gcRankingPostRKToken()
    {
        $value = esc_attr( get_option( 'ranking_post_token' ) );
        $rank_html = '<a href="https://app.ranking.works/auth?mode=login" target="_blank">Ranking後台</a>';
        echo '<input type="text" class="regular-text" name="ranking_post_token" value="'.wp_kses_post($value).'" placeholder="Ranking Post Token">';
        echo '<p class="description">請至您的 '.wp_kses_post($rank_html).' > 會員資訊中的已授權網站列表區塊新增網站並將 Ranking Post Website 的網址填入，接著Ranking會產生一組Token，再將取得的Token回填至此欄位。</p>';
    }
    public function gcRankingPostWebsite()
    {
        $url = esc_url( get_option( 'gcreate_ranking_post_website' ) );
        $url = empty($url) ? home_url() : $url ;
        update_option('gcreate_ranking_post_website', $url);
        $icon_img_html = '<span id="copyButton" class="material-symbols-outlined" title="複製網址">content_copy</span>';
        echo '<input type="url" class="regular-text" name="gcreate_ranking_post_website" value="'.wp_kses_post($url).'" placeholder="Ranking Post Website Default Home Url" readonly>';
        echo wp_kses_post($icon_img_html);
        echo '<div id="customDialog"><p>已複製成功！</p></div>';
    }
    public function gcRankingPostWebsiteAPI()
    {
        $url = esc_url( get_option( 'gcreate_ranking_post_website_api' ) ) ;
        $url = empty($url) ? home_url(). '/' .rest_get_url_prefix() : $url ;
        update_option('gcreate_ranking_post_website_api', $url);
        $icon_img_html = '<span id="copyButton2" class="material-symbols-outlined" title="複製網址">content_copy</span>';
        echo '<input type="url" class="regular-text" name="gcreate_ranking_post_website_api" value="'.wp_kses_post($url).'" placeholder="Ranking Post Website API Url" readonly>';
        echo wp_kses_post($icon_img_html);
        echo '<div id="customDialog2"><p>已複製成功！</p></div>';
    }
    public function gcRankingPostWPToken()
    {
        $value = esc_attr( get_option( $this->prefix.'token' ) );
        if(empty($value)){
            $url = esc_url( get_option( 'gcreate_ranking_post_website' ) );
            $url = empty($url) ? home_url() : $url ;
            $value = hash( 'md5', $url . 'gcreate' );
            update_option( $this->prefix.'token', $value );
        }
        echo '<input type="text" class="regular-text" name="gc_ranking_token" value="'.wp_kses_post($value).'" placeholder="WP Website Token" readonly>';
    }
    public function gcRankingPostWebAdminEmail()
    {
        $user_id = $this->convert_functions->GetTheFirstUserIdwithUserRole('administrator');
        
        if( $user_id == 0 ){
            echo '使用者權限不正確';
            return;
        }
        $user_data = get_user_by( 'id',$user_id);
        $user_email = $user_data->user_email;
        if( empty($user_email)){
            update_option($wpdb->prefix.'admin_email', $user_email);
            update_option($wpdb->prefix.'admin_user_id', $user_id);
        }
        echo '<input type="email" class="regular-text" name="wp_admin_email" value="'. wp_kses_post($user_data->user_email).'" readonly>';
        echo '<input type="hidden" class="regular-text" name="wp_admin_user_id" value="'. wp_kses_post($user_id).'">';
    }
}
