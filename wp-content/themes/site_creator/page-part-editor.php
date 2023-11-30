<?php

// 必要関数をロードする
require_once get_template_directory() . '/inc/custom-functions/check_part_editor_permission.inc.php';
require_once get_template_directory() . '/inc/custom-functions/get_html_block_info.inc.php';

get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

// 編集権限をチェックする
$check_result = check_part_editor_permission();

if($check_result['result']) :
  // 編集可能の場合編集ターゲットを取得
  $target_uid = $check_result['target_uid'];
?>

<section class="sim">
  <div class="sim-device sim-pc">
    <div class="sim-inner sim-inner-pc">
      <div class="sim-html sim-html-pc" id="sim-html-pc" data-scale="1">
        <div class="sim-selector" id="sim-selector-pc"  data-target="pc">
          <div class="sim-selector-point sim-selector-point-top" data-point="top"></div>
          <div class="sim-selector-point sim-selector-point-left" data-point="left"></div>
          <div class="sim-selector-point sim-selector-point-bottom" data-point="bottom"></div>
          <div class="sim-selector-point sim-selector-point-right" data-point="right"></div>
          <div class="sim-selector-point sim-selector-point-topleft" data-point="topleft"></div>
          <div class="sim-selector-point sim-selector-point-bottomleft" data-point="bottomleft"></div>
          <div class="sim-selector-point sim-selector-point-topright" data-point="topright"></div>
          <div class="sim-selector-point sim-selector-point-bottomright" data-point="bottomright"></div>
          <div class="sim-selector-line sim-selector-line-top"></div>
          <div class="sim-selector-line sim-selector-line-left"></div>
          <div class="sim-selector-line sim-selector-line-bottom"></div>
          <div class="sim-selector-line sim-selector-line-right"></div>
          <div class="sim-selector-sim"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="sim-device sim-sp">
    <div class="sim-inner sim-inner-sp">
      <div class="sim-html sim-html-sp" id="sim-html-sp" data-scale="1">
        <div class="sim-selector" id="sim-selector-sp" data-target="sp">
          <div class="sim-selector-point sim-selector-point-top" data-point="top"></div>
          <div class="sim-selector-point sim-selector-point-left" data-point="left"></div>
          <div class="sim-selector-point sim-selector-point-bottom" data-point="bottom"></div>
          <div class="sim-selector-point sim-selector-point-right" data-point="right"></div>
          <div class="sim-selector-point sim-selector-point-topleft" data-point="topleft"></div>
          <div class="sim-selector-point sim-selector-point-bottomleft" data-point="bottomleft"></div>
          <div class="sim-selector-point sim-selector-point-topright" data-point="topright"></div>
          <div class="sim-selector-point sim-selector-point-bottomright" data-point="bottomright"></div>
          <div class="sim-selector-line sim-selector-line-top"></div>
          <div class="sim-selector-line sim-selector-line-left"></div>
          <div class="sim-selector-line sim-selector-line-bottom"></div>
          <div class="sim-selector-line sim-selector-line-right"></div>
          <div class="sim-selector-sim"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="setting" data-index="">
  <div class="setting-title"><?php echo __('Site Common Style Edit', $lang_domain); ?><?php echo __('Site Common Style Edit', $lang_domain); ?><?php echo __('Site Common Style Edit', $lang_domain); ?><?php echo __('Site Common Style Edit', $lang_domain); ?></div>
  <form class="form">
    <input type="hidden" name="target_uid" value="<?php echo $target_uid; ?>" />
    <div class="form-tab">
      <div class="form-tab-navi">
        <p class="form-tab-navi-item active" target="param">パラメータ</p>
        <p class="form-tab-navi-item" target="style">スタイル</p>
      </div>
      <div class="form-tab-content">
        <div class="form-tab-content-item form-param">
        </div>
        <div class="form-tab-content-item form-body active">
        </div>
      </div>
    </div>
  </form>
</section>

<?php 
else: 
  // 編集権限がない場合エラーページを表示
  get_template_part('template-parts/error/' . $check_result['error']); 
endif;

get_footer();
