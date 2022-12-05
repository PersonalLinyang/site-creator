<?php

/* 
 * 背景編集エリア
 */

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

// テンプレートパーツパラメータ変数化
$layer_list = $args['data'];
$block_key = $args['key'];

// 背景層リストをインデックスの昇順（数値）で並び替え
array_multisort(array_column($layer_list, 'index'), SORT_ASC, SORT_NUMERIC, $layer_list);

?>

<div class="form-line">
  <p class="form-title"><?php echo __('Background', $lang_domain); ?></p>
  <div class="form-input form-background" data-lastid="0">
    <p class="form-background-btninsert"><?php echo __('Add Background Layer', $lang_domain); ?></p>
    <div class="form-background-layerlist">
      <?php 
      $layer_id = 0;
      foreach($layer_list as $layer): 
        // 背景層nameの共通部分を取得
        $layer_key = $block_key . '__style__background__' . $layer_id;
        
        // 背景層スタイル設定項目キーリスト取得
        $layer_key_list = array_keys($layer);
        
        // 背景層スタイル設定値取得
        $class_responsive_target = '';
        $checked_pc_only = '';
        $checked_sp_only = '';
        $checked_responsive = '';
        $style_responsive = '';
        if(in_array('pc_only', $layer_key_list) && $layer['pc_only'] == 'on') {
          $class_responsive_target = 'setting-pc active';
          $checked_pc_only = 'checked';
          $style_responsive = 'style="display: none;"';
        } else if(in_array('sp_only', $layer_key_list) && $layer['sp_only'] == 'on') {
          $class_responsive_target = 'setting-sp';
          $checked_sp_only = 'checked';
          $style_responsive = 'style="display: none;"';
        } else if(in_array('responsive', $layer_key_list) && $layer['responsive'] == 'on') {
          $checked_responsive = 'checked';
        }
      ?>
      <div class="form-background-layer form-responsive-target <?php echo $class_responsive_target; ?>" data-layerid="<?php echo $layer_id; ?>">
        <div class="form-background-header">
          <p class="form-background-btnsort"></p>
          <p class="form-background-name">
            <input type="text" name="<?php echo $layer_key; ?>__name" 
                value="<?php echo $layer['name']; ?>" placeholder="<?php echo __('Background Layer Name Placeholder', $lang_domain); ?>" />
          </p>
          <p class="form-background-btnslide"></p>
          <p class="form-background-btndelete"></p>
        </div>
        <div class="form-background-body form-responsive">
          <div class="form-responsive-controller">
            <p class="form-checkbox form-responsive-checkbox form-responsive-chkdevice setting-pc active <?php echo $checked_pc_only; ?>">
              <input type="checkbox" name="<?php echo $layer_key; ?>__pc_only" class="form-responsive-chkdevice-check chkdevice-check-pc" <?php echo $checked_pc_only; ?> />
              <?php echo __('Responsive PC', $lang_domain); ?>
            </p>
            <p class="form-checkbox form-responsive-checkbox form-responsive-chkdevice setting-sp <?php echo $checked_sp_only; ?>">
              <input type="checkbox" name="<?php echo $layer_key; ?>__sp_only" class="form-responsive-chkdevice-check chkdevice-check-sp" <?php echo $checked_sp_only; ?> />
              <?php echo __('Responsive SP', $lang_domain); ?>
            </p>
            <p class="form-checkbox form-responsive-checkbox form-responsive-chkflag <?php echo $checked_responsive; ?>" <?php echo $style_responsive; ?>>
              <input type="checkbox" name="<?php echo $layer_key; ?>__responsive" class="form-responsive-chkflag-check" <?php echo $checked_responsive; ?> />
              <?php echo __('Responsive Flag', $lang_domain); ?>
            </p>
          </div>
          <?php 
          // レスポンシブ対応可能部分のテンプレートパーツパラメータ基層項目を初期化
          $param_base = array('key' => $layer_key, 'responsive' => $checked_responsive);
          if(in_array('pc', $layer_key_list)) {
            // レスポンシブ対応可能部分のPCスタイル設定エリアを構築
            get_template_part('template-parts/editor/background/responsive_area', null, array_merge($param_base, array('device' => 'pc', 'data' => $layer['pc']))); 
          }
          if(in_array('sp', $layer_key_list)) {
            // レスポンシブ対応可能部分のSPスタイル設定エリアを構築
            get_template_part('template-parts/editor/background/responsive_area', null, array_merge($param_base, array('device' => 'sp', 'data' => $layer['sp']))); 
          }
          ?>
        </div>
        <input type="hidden" class="form-background-index" name="<?php echo $layer_key; ?>__index" value="<?php echo $layer_id; ?>">
      </div>
      <?php 
        $layer_id++;
      endforeach; 
      ?>
    </div>
  </div>
</div>