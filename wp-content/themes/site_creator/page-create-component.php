<?php

// 必要関数をロードする
require_once get_template_directory() . '/inc/custom-functions/check_editor_permission.inc.php';
require_once get_template_directory() . '/inc/custom-functions/get_html_block_info.inc.php';
require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

get_header();

$lang = new LanguageSupporter();

// 編集権限をチェックする
$check_result = check_editor_permission();

if($check_result['result']) :
  // 編集可能の場合編集ターゲットを取得
  $target_uid = md5(uniqid(rand(), true));
  
  $design_width_pc = 1200;
  $design_width_sp = 375;
  $design_fontsize_pc = 16;
  $design_fontsize_sp = 12;
?>

<section class="sim">
  <div class="sim-device sim-pc">
    <div class="sim-inner sim-inner-pc">
      <div class="sim-html sim-html-pc" id="sim-html-pc" data-scale="1" style="--design-width: <?php echo $design_width_pc; ?>; --design-fontsize: <?php echo $design_fontsize_pc; ?>;">
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
      <div class="sim-html sim-html-sp" id="sim-html-sp" data-scale="1" style="--design-width: <?php echo $design_width_sp; ?>; --design-fontsize: <?php echo $design_fontsize_sp; ?>;">
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

<section class="setting">
  <div class="setting-tab">
    <p class="setting-tab-handler" data-tab="information"><?php echo $lang->translate('Base Setting'); ?></p>
    <p class="setting-tab-handler active" data-tab="design"><?php echo $lang->translate('Design'); ?></p>
    <p class="setting-tab-handler" data-tab="parameter"><?php echo $lang->translate('Parameter'); ?></p>
    <p class="setting-tab-handler" data-tab="script"><?php echo $lang->translate('Script'); ?></p>
    <p class="setting-tab-handler" data-tab="user-simulation"><?php echo $lang->translate('User Simulation'); ?></p>
  </div>
  
  <form class="form" id="component-form">
  
    <div class="form-tab" data-tab="information">
      <div class="form-topic">
        <p class="form-topic-text"><?php echo $lang->translate('Base Setting'); ?></p>
      </div>
      <div class="form-content">
        <div class="form-line">
          <p class="form-title"><?php echo $lang->translate('Component Name'); ?></p>
          <div class="form-input">
            <input type="text" name="component_name" placeholder="<?php echo $lang->translate('Component Name'); ?>" />
          </div>
        </div>
        <div class="form-line">
          <p class="form-title"><?php echo $lang->translate('Editor Permission Setting'); ?></p>
        </div>
        <div class="form-line">
          <p class="form-title"><?php echo $lang->translate('User Permission Setting'); ?></p>
        </div>
        <div class="form-line">
          <p class="form-title"><?php echo $lang->translate('Price'); ?></p>
        </div>
      </div>
    </div>
    
    <div class="form-tab active" data-tab="design">
      <div class="form-slider">
      </div>
    </div>
    
    <div class="form-tab" data-tab="parameter">
      <div class="form-topic">
        <p class="form-topic-text"><?php echo $lang->translate('Parameter'); ?></p>
      </div>
      <div class="form-content">
      </div>
    </div>
    
    <div class="form-tab" data-tab="script">
      <div class="form-topic">
        <p class="form-topic-text"><?php echo $lang->translate('Script'); ?></p>
      </div>
      <div class="form-content">
      </div>
    </div>
    
    <div class="form-tab" data-tab="user-simulation">
      <div class="form-topic">
        <p class="form-topic-text"><?php echo $lang->translate('User Simulation'); ?></p>
      </div>
      <div class="form-content">
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
