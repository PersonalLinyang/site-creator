<?php

function html_btnsp($responsive, $sp_flag, $target, $attr) {
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  $sp_float = __('SP style is defferent from PC', $lang_domain);
  
  $responsive_class = ($responsive == 1) ? 'active' : '';
  $sp_flag_class = ($sp_flag == 1) ? 'active' : '';
  $sp_flag_checked = ($sp_flag == 1) ? 'checked' : '';
  
  $html = <<<EOT
  <div class="form-btnsp {$responsive_class}">
    <label class="form-btnsp-inner {$sp_flag_class}">
      <input class="form-btnsp-check" type="checkbox" name="{$target}__{$attr}__flag_sp" {$sp_flag_checked} />SP
      <p class="float-description">{$sp_float}</p>
    </label>
  </div>
EOT;
  
  return $html;
}

/*
 * チェックボックスコード
 */
function asc_form_checkbox_editor($params) {
  $html = '<div class="form-input form-checkbox">';
  $html .= '<label class="form-checkbox-check">';
  $html .= '<input type="checkbox" class="';
  if(in_array('sp', array_keys($params)) && $params['sp'] == 1) {
    $html .= ' sp-flag';
  }
  $html .= '" id="chk-' . $params['name'] . '" ';
  $html .= 'name="' . $params['name'] . '" ';
  if(in_array('target', array_keys($params)) && $params['target'] == 'set') {
    $html .= 'data-target="set-' . $params['name'] . '" ';
  } else {
    $html .= 'data-target="' . $params['target'] . '" ';
  }
  $html .= 'data-type="' . $params['type'] . '" ';
  $html .= '/>';
  $html .= '</label>';
  $html .= '<label class="form-checkbox-text" for="chk-' . $params['name'] . '">' . $params['label'] . '</label>';
  $html .= '</div>';
  
  return $html;
}
add_shortcode('form_checkbox_editor', 'asc_form_checkbox_editor');


/*
 * カラーピーカーショットコード
 * パラメータ : 
 *     target     : 必須、文字列、simulation上に影響を受ける要素の識別キー
 *     attr       : 必須、文字列、色付けの対象
 *                    background-color：背景色
 *                    border-color    ：枠色
 *                    color           ：文字色
 *     sp         : 0/1、SPサイト別デザインフラグ
 *     color      : #XXXXXX、色のHEX値
 *     opacity    : 数値、透明度
 *     responsive : 0/1、レスポンシブ対応対象フラグ
 */
function html_form_color($sp_setting, $responsive, $sp_flag, $target, $attr, $color, $opacity) {
  if($sp_setting) {
    $input_class = 'form-input-sp-inner for-sp';
    $target_str = $target . '_sp';
    $btnsp_html = '';
  } else {
    $input_class = 'form-input';
    $target_str = $target;
    $btnsp_html = html_btnsp($responsive, $sp_flag, $target, $attr);
  }
  
  if(preg_match('/^#[a-f\d]{6}$/', $color) && preg_match('/^[0-1]{1}(\.[1-9]){0,1}$/', $opacity)) {
    $active_class = 'active';
    $check_checked = 'checked';
    $opacity_disabled = '';
  } else {
    $active_class = '';
    $check_checked = '';
    $opacity_disabled = 'disabled';
  }
  
  $opacity_options = '';
  for($i = 10; $i >= 0; $i = $i - 1) {
    $opacity_options .= '<option value="' . ($i / 10) . '" ' . (($opacity == strval($i / 10)) ? 'selected' : '') . '>' . ($i * 10) . '%</option>';
  }
  
  $html = <<<EOT
<div class="form-color {$input_class} {$active_class}" data-target="{$target}" data-attr="{$attr}">
  <div class="form-color-showarea">
    <div class="form-color-show">
      <label class="form-color-checkbox">
        <input class="form-color-checkbox-check" type="checkbox" name="{$target_str}__{$attr}__flag" {$check_checked} />
      </label>
    </div>
  </div>
  <input class="form-color-picker" type="text" maxlength="7" name="{$target_str}__{$attr}__rgb" value="{$color}" />
  <select class="form-color-opacity" name="{$target_str}__{$attr}__a" {$opacity_disabled}>
    {$opacity_options}
  </select>
  {$btnsp_html}
</div>
EOT;
  
  return $html;
}
function asc_form_color_editor($params) {
  $html = '';
  
  if(in_array('target', array_keys($params)) && in_array('attr', array_keys($params))) {
    $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
    $lang_domain = 'site-creator-' . $lang_code;
    
    $target = $params['target'];
    $attr = $params['attr'];
    $color = in_array('color', array_keys($params)) ? $params['color'] : '';
    $opacity = in_array('opacity', array_keys($params)) ? $params['opacity'] : '';
    $color_sp = in_array('color_sp', array_keys($params)) ? $params['color_sp'] : '';
    $opacity_sp = in_array('opacity_sp', array_keys($params)) ? $params['opacity_sp'] : '';
    $responsive = in_array('responsive', array_keys($params)) ? $params['responsive'] : 0;
    $sp_flag = in_array('sp', array_keys($params)) ? $params['sp'] : 0;
    
    $html .= html_form_color(false, $responsive, $sp_flag, $target, $attr, $color, $opacity);
    $html .= '<div class="form-input-sp ' . (($sp_flag == 1) ? 'active' : '') . '">';
    $html .= '<div class="form-input-sp-title">' . __('SP Site Style', $lang_domain) . '</div>';
    $html .= html_form_color(true, $responsive, $sp_flag, $target, $attr, $color_sp, $opacity_sp);
    $html .= '</div>';
  }
  
  return $html;
}
add_shortcode('form_color_editor', 'asc_form_color_editor');
