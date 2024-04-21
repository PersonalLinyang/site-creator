<?php

require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

$lang = new LanguageSupporter();

// テンプレートパーツパラメータ変数化
$site_id = $args['site_id'];

$design_width_pc = 1500;
$design_width_sp = 375;
if($site_id) {
  $design_width_pc = get_field('design_width_pc', $site_id);
  $design_width_sp = get_field('design_width_sp', $site_id);
}
?>

<header class="header">
  <div class="header-inner  header-inner">
    <div class="header-sim">
      <div class="header-sim-devicearea">
        <div class="header-sim-button header-sim-device header-sim-device-pc checked" data-device="pc">
          <p class="header-sim-button-icon"><?php echo file_get_contents(get_template_directory() . '/assets/svg/editor/computer.svg'); ?></p>
          <p class="header-sim-button-text sp-only"><?php echo $lang->translate( 'Switch to PC' ); ?></p>
        </div>
        <div class="header-sim-button header-sim-device header-sim-device-sp" data-device="sp">
          <p class="header-sim-button-icon"><?php echo file_get_contents(get_template_directory() . '/assets/svg/editor/smartphone.svg'); ?></p>
          <p class="header-sim-button-text sp-only"><?php echo $lang->translate( 'Switch to SP' ); ?></p>
        </div>
      </div>
      <div class="header-sim-setting active" data-device="pc">
        <div class="header-sim-line">
          <p class="header-sim-setting-title"><?php echo $lang->translate( 'Width' ); ?></p>
          <p><input class="header-sim-setting-input header-sim-setting-width-pc" type="number" value="<?php echo $design_width_pc; ?>" /></p>
          <p class="header-sim-setting-unit"><?php echo $lang->translate( 'px' ); ?></p>
        </div>
      </div>
      <div class="header-sim-setting" data-device="sp">
        <div class="header-sim-line">
          <p class="header-sim-setting-select">
            <select class="header-sim-setting-input header-sim-setting-device">
              <option value="1" data-width="375" data-height="667">iPhone SE</option>
              <option value="2" data-width="414" data-height="896">iPhone XR</option>
            </select>
          </p>
          <div class="header-sim-button header-sim-swirl">
            <p class="header-sim-button-icon"><?php echo file_get_contents(get_template_directory() . '/assets/svg/editor/swirl.svg'); ?></p>
            <p class="header-sim-button-text sp-only"><?php echo $lang->translate( 'Swirl' ); ?></p>
          </div>
        </div>
        <div class="header-sim-line">
          <p class="header-sim-setting-title"><?php echo $lang->translate( 'Width' ); ?></p>
          <p><input class="header-sim-setting-input header-sim-setting-width-sp" type="number" value="<?php echo $design_width_sp; ?>" /></p>
          <p class="header-sim-setting-unit"><?php echo $lang->translate( 'px' ); ?></p>
          <p class="header-sim-setting-title"><?php echo $lang->translate( 'Height' ); ?></p>
          <p><input class="header-sim-setting-input header-sim-setting-height-sp" type="number" value="667" /></p>
          <p class="header-sim-setting-unit"><?php echo $lang->translate( 'px' ); ?></p>
        </div>
        <div class="header-sim-line">
        </div>
      </div>
    </div>
    <div class="header-button header-handler sp-only">
      <p class="header-button-icon"><?php echo file_get_contents(get_template_directory() . '/assets/svg/editor/resize.svg'); ?></p>
      <p class="header-button-text"><?php echo $lang->translate('Resize'); ?></p>
    </div>
    <div class="header-button header-adaptive checked">
      <p class="header-button-icon header-adaptive-expand active"><?php echo file_get_contents(get_template_directory() . '/assets/svg/editor/expand.svg'); ?></p>
      <p class="header-button-icon header-adaptive-shrink"><?php echo file_get_contents(get_template_directory() . '/assets/svg/editor/shrink.svg'); ?></p>
      <p class="header-button-text sp-only header-adaptive-expand active"><?php echo $lang->translate('Expand'); ?></p>
      <p class="header-button-text sp-only header-adaptive-shrink"><?php echo $lang->translate('Shrink'); ?></p>
    </div>
    <div class="header-button header-save">
      <p class="header-button-icon"><?php echo file_get_contents(get_template_directory() . '/assets/svg/editor/save.svg'); ?></p>
      <p class="header-button-text"><?php echo $lang->translate('Save'); ?></p>
    </div>
  </div>
</header>

<main class="main">