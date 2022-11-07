<?php

function create_part_responsive($key, $inner) {
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  $translations = array(
    'responsive_flag' => __('Responsive Flag', $lang_domain),
    'responsive_pc' => __('Responsive PC', $lang_domain),
    'responsive_sp' => __('Responsive SP', $lang_domain),
  );
  
  $html = <<<EOT
<div class="form-responsive">
  <div class="form-responsive-controller">
    <label class="form-responsive-button form-responsive-pc setting-pc">
      <input class="form-responsive-pc-check" type="checkbox" name="{$key}__pc" />{$translations['responsive_pc']}
    </label>
    <label class="form-responsive-button form-responsive-sp setting-sp">
      <input class="form-responsive-sp-check" type="checkbox" name="{$key}__sp" />{$translations['responsive_sp']}
    </label>
    <label class="form-responsive-button form-responsive-flag">
      <input class="form-responsive-flag-check" type="checkbox" name="{$key}__responsive" />{$translations['responsive_flag']}
    </label>
  </div>
  <div class="form-responsive-area">
    {$inner}
  </div>
</div>
EOT;
  
  return $html;
}


function create_part_color($key, $gradient_flag=false) {
  $html_gradient = '';
  if($gradient_flag) {
    $html_gradient = <<<EOT
<div class="form-color-line">
  <input class="form-color-size" type="number" name="{$key}__size" value="" />
  <select class="form-color-unit" name="{$key}__unit">
    <option value="px">px</option>
    <option value="%">%</option>
  </select>
</div>
EOT;
  }
  
  $html = <<<EOT
<div class="form-color">
  <div class="form-color-line">
    <div class="form-color-showarea">
      <div class="form-color-show">
        <label class="form-color-checkbox">
          <input class="form-color-checkbox-check" type="checkbox" name="{$key}__transparent" checked />
        </label>
      </div>
    </div>
    <input class="form-color-picker" type="text" maxlength="7" name="{$key}__color" value="" />
    <select class="form-color-opacity" name="{$key}__opacity" disabled>
      <option value="1">100%</option>
      <option value="0.9">90%</option>
      <option value="0.8">80%</option>
      <option value="0.7">70%</option>
      <option value="0.6">60%</option>
      <option value="0.5">50%</option>
      <option value="0.4">40%</option>
      <option value="0.3">30%</option>
      <option value="0.2">20%</option>
      <option value="0.1">10%</option>
      <option value="0">0%</option>
    </select>
  </div>
  {$html_gradient}
</div>
EOT;
  
  return $html;
}


/*
 * 背景層を追加
 */
function func_editor_add_background_content(){
  $index = $_POST['index'];
  $target = $_POST['target'];
  $type = $_POST['type'];
  $key = $target . '__background__' . $index;
  
  $result = true;
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  $translations = array(
    'file_upload' => __('File Upload', $lang_domain),
    'direction_option_hidden' => __('Please select background gradient direction', $lang_domain),
    'to_bottom' => __('To Bottom', $lang_domain),
    'to_right' => __('To Right', $lang_domain),
    'to_top_right' => __('To Top Right', $lang_domain),
    'to_bottom_right' => __('To Bottom Right', $lang_domain),
    'custom_rotate' => __('Custom Rotate', $lang_domain),
    'to_outside' => __('To Outside', $lang_domain),
    'background_repeat' => __('Background Repeat', $lang_domain),
    'add_color' => __('Add a new color', $lang_domain),
  );
  
  $html = '';
  if($type == 'solid') {
    $html_inner = create_part_color($key);
    $html = <<<EOT
<div class="form-background-solid">
  {$html_inner}
</div>
EOT;
  } else if($type == 'picture') {
    $html = <<<EOT
<div class="form-background-picture">
  <label class="form-upload">
    <input type="hidden" name="{$key}__image" value="" />
    <input class="form-upload-file" type="file" />{$translations['file_upload']}
  </label>
</div>
EOT;
  } else if($type == 'gradient') {
    $html = <<<EOT
<div class="form-background-gradient" data-index="0">
  <div class="form-background-direction">
    <select class="form-background-direction-select">
      <option value="" hidden>{$translations['direction_option_hidden']}</option>
      <option value="to bottom">{$translations['to_bottom']}</option>
      <option value="to right">{$translations['to_right']}</option>
      <option value="to top right">{$translations['to_top_right']}</option>
      <option value="to bottom right">{$translations['to_bottom_right']}</option>
      <option value="rotate">{$translations['custom_rotate']}</option>
      <option value="outside">{$translations['to_outside']}</option>
    </select>
    <div class="form-background-rotate">
      <input class="form-background-rotate-input" type="number" maxlength="3" max="359" min="0" name="{$key}__rotate" value="0" />
      <div class="form-background-rotate-sim"></div>
    </div>
  </div>
  <div class="form-background-repeat">
    <label class="form-background-repeat-checkbox">
      <input class="form-background-repeat-checkbox-check" type="checkbox" name="{$key}__repeat" />{$translations['background_repeat']}
    </label>
  </div>
  <div class="form-background-btngradient">{$translations['add_color']}</div>
</div>
EOT;
  }
  
  // リポジトリ出力
  $response = array(
    'result' => $result,
    'html' => create_part_responsive($key, $html),
  );
  echo json_encode($response);
  die();
}
add_action('wp_ajax_editor_add_background_content', 'func_editor_add_background_content');
add_action('wp_ajax_nopriv_editor_add_background_content', 'func_editor_add_background_content');


/*
 * 背景層を追加
 */
function func_editor_add_background_gradient_color(){
  $layer = $_POST['layer'];
  $color = $_POST['color'];
  $target = $_POST['target'];
  $key = $target . '__background__' . $layer . '__' . $color;
  
  $result = true;
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  
  $html = create_part_color($key, true);
  
  // リポジトリ出力
  $response = array(
    'result' => $result,
    'html' => $html,
  );
  echo json_encode($response);
  die();
}
add_action('wp_ajax_editor_add_background_gradient_color', 'func_editor_add_background_gradient_color');
add_action('wp_ajax_nopriv_editor_add_background_gradient_color', 'func_editor_add_background_gradient_color');
