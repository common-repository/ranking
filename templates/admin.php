<?php
if ( ! defined( 'ABSPATH' ) ) exit; # GC_Chandler:2024-01-23
$image_url = plugins_url('assets/img/ranking_r_logo_blue.png', GCREATE_RANKING_POST);
$plugin_url = admin_url('admin.php?page=gc_ranking_post');
?>
<div class="wrap2">
    <div class="rank-post-header">
        <div class="rank-post-logo">
            <a href="<?php echo wp_kses_post($plugin_url) ?>">
                <?php
                    $image_url = plugins_url('assets/img/ranking_r_logo_blue.png', GCREATE_RANKING_POST);
                    echo '<div class="rank-post-icon"><img src="' . esc_url($image_url) . '" alt="Custom Image"></div>';
                ?>
            </a>
        </div>
        <h1 class="rank-post-logo-text">
            Ranking 一鍵發文
        </h1>
    </div>
    <?php settings_errors(); ?>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1">Manage Settings</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <form method="post" action="options.php">
                <?php
                settings_fields('gc_ranking_post_settings');
                do_settings_sections('gc_ranking_post'); # page
                wp_nonce_field('rank_post_nonce_action', 'rank_post_nonce');
                submit_button('儲存設定', 'primary', 'submit_button_for_register_or_save');
                ?>
            </form>
        </div>
    </div>
</div>
