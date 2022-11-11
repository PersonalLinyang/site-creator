<?php

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

?>

<header class="header header-editor">
  <div class="header-inner  header-inner-editor">
    <div class="header-sim">
      <p class="header-sim-button header-sim-device header-sim-device-pc checked" data-device="pc"></p>
      <p class="header-sim-button header-sim-device header-sim-device-sp" data-device="sp"></p>
      <div class="header-sim-setting active" data-device="pc">
        <div class="header-sim-setting-inner">
          <p class="header-sim-setting-title"><?php echo __( 'Width', $lang_domain ); ?></p>
          <p><input class="header-sim-setting-input header-sim-setting-width-pc" type="number" value="1200" /></p>
          <p class="header-sim-setting-unit"><?php echo __( 'px', $lang_domain ); ?></p>
          <p class="header-sim-button header-sim-adaptive header-sim-adaptive-pc checked"></p>
        </div>
      </div>
      <div class="header-sim-setting" data-device="sp">
        <div class="header-sim-setting-inner">
          <p>
            <select class="header-sim-setting-input header-sim-setting-device">
              <option value="1" data-width="375" data-height="667">iPhone SE</option>
              <option value="2" data-width="414" data-height="896">iPhone XR</option>
            </select>
          </p>
          <p class="header-sim-setting-title"><?php echo __( 'Width', $lang_domain ); ?></p>
          <p><input class="header-sim-setting-input header-sim-setting-width-sp" type="number" value="375" /></p>
          <p class="header-sim-setting-unit"><?php echo __( 'px', $lang_domain ); ?></p>
          <p class="header-sim-setting-title"><?php echo __( 'Height', $lang_domain ); ?></p>
          <p><input class="header-sim-setting-input header-sim-setting-height-sp" type="number" value="667" /></p>
          <p class="header-sim-setting-unit"><?php echo __( 'px', $lang_domain ); ?></p>
          <p class="header-sim-button header-sim-adaptive header-sim-adaptive-sp checked"></p>
          <p class="header-sim-button header-sim-swirl"></p>
        </div>
      </div>
    </div>
    <div class="header-controller header-controller-editor">
      <p class="header-button header-save"><?php echo __( 'Save', $lang_domain ); ?></p>
    </div>
  </div>
</header>

<main class="main-editor">