<?php

/* 
 * 背景編集エリアレスポンシブ対応可能部分
 */

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

// テンプレートパーツパラメータ変数化
$device = $args['device'];
$responsive = $args['responsive'];
$layer = $args['data'];

// 背景層nameの共通部分を取得
$layer_key = $args['key'] . '__' . $device;

// 背景層スタイル設定項目キーリスト取得
$layer_key_list = array_keys($layer);

// 位置設定セレクト選択肢リスト
$position_option_list = array(
  'center'       => __('Background Center', $lang_domain),
  'top'          => __('Background Top', $lang_domain),
  'bottom'       => __('Background Bottom', $lang_domain),
  'left'         => __('Background Left', $lang_domain),
  'right'        => __('Background Right', $lang_domain),
  'top left'     => __('Background Top Left', $lang_domain),
  'top right'    => __('Background Top Right', $lang_domain),
  'bottom left'  => __('Background Bottom Left', $lang_domain),
  'bottom right' => __('Background Bottom Right', $lang_domain),
  'custom'       => __('Background Custom Position', $lang_domain),
);

// 縦出発方向セレクト選択肢リスト
$from_y_option_list = array(
  'top'    => __('From Top', $lang_domain),
  'bottom' => __('From Bottom', $lang_domain),
);

// 横出発方向セレクト選択肢リスト
$from_x_option_list = array(
  'left'  => __('From Left', $lang_domain),
  'right' => __('From Right', $lang_domain),
);

// 単位セレクト選択肢リスト
$unit_option_list = array(
  'pct' => '%',
  'px'  => 'px',
);

// 変色タイプ選択肢リスト
$gradient_type_option_list = array(
  'linear' => __('Gradient Linear', $lang_domain),
  'radial' => __('Gradient Radial', $lang_domain),
  'conic'  => __('Gradient Conic', $lang_domain),
);

// 変色方向選択肢リスト
$direction_option_list = array(
  'to bottom'       => __('Gradient To Bottom', $lang_domain),
  'to right'        => __('Gradient To Right', $lang_domain),
  'to top right'    => __('Gradient To Top Right', $lang_domain),
  'to bottom right' => __('Gradient To Bottom Right', $lang_domain),
  'rotate'          => __('Gradient Custom Rotate', $lang_domain),
);

// 変色形状選択肢リスト
$shape_option_list = array(
  'ellipse' => __('Gradient Ellipse', $lang_domain),
  'circle'  => __('Gradient Circle', $lang_domain),
);

?>
<div class="form-responsive-area <?php if($responsive) { echo 'setting-' . $device; if($device == 'pc') { echo ' active'; }} ?>">
  <p class="form-background-type">
    <select class="form-background-seltype" name="<?php echo $layer_key; ?>__type">
      <option value="" hidden>Background Type Placeholder</option>
      <option value="solid" <?php if($layer['type'] == 'solid') { echo 'selected'; } ?>>Background Solid</option>
      <option value="picture" <?php if($layer['type'] == 'picture') { echo 'selected'; } ?>>Background Picture</option>
      <option value="gradient" <?php if($layer['type'] == 'gradient') { echo 'selected'; } ?>>Background Gradient</option>
    </select>
  </p>
  <div class="form-background-content" style="display: block;">
    
    
    <?php 
    // 純色タイプ設定エリアを構築
    if($layer['type'] == 'solid'): 
      // 設定値を整理
      $checked_transparent = (in_array('transparent', $layer_key_list) && $layer['transparent']=='on') ? 'checked' : '';
      $color = in_array('color', $layer_key_list) ? $layer['color'] : '';
      $opacity = in_array('opacity', $layer_key_list) && is_numeric($layer['opacity']) ? ((float) $layer['opacity']) : 1;
    ?>
    <div class="form-solid form-color">
      <p class="form-color-title"><?php echo __('Color And Opacity', $lang_domain); ?></p>
      <div class="form-color-line">
        <div class="form-color-showarea">
          <div class="form-color-show">
            <p class="form-color-checkbox <?php echo $checked_transparent; ?>">
              <input class="form-color-checkbox-check" type="checkbox" name="<?php echo $layer_key; ?>__transparent" <?php echo $checked_transparent; ?> />
            </p>
          </div>
        </div>
        <p class="form-color-picker">
          <input class="form-color-txtpicker" type="text" maxlength="6" name="<?php echo $layer_key; ?>__color" value="<?php echo $color; ?>" />
        </p>
        <p class="form-color-opacity">
          <select class="form-color-selopacity" name="<?php echo $layer_key; ?>__opacity">
            <?php for($opacity_value = 10; $opacity_value >= 0; $opacity_value = $opacity_value - 1): ?>
            <option value="<?php echo ($opacity_value / 10); ?>" <?php if(($opacity * 10) == $opacity_value) { echo 'selected'; } ?>>
              <?php echo $opacity_value * 10; ?>%
            </option>
            <?php endfor; ?>
          </select>
        </p>
      </div>
    </div>
    
    
    <?php 
    // 画像タイプ設定エリアを構築
    elseif($layer['type'] == 'picture'): 
      // 設定値を整理
      $image_id = in_array('image', $layer_key_list) ? $layer['image'] : '';
      $image_url = '';
      $image_name = '';
      if($image_id) {
        $image_url = wp_get_attachment_url($layer['image']);
        if($image_url) {
          $image_name = get_the_title($layer['image']) . '.' . wp_check_filetype($image_url)['ext'];
        }
      }
      $checked_repeat = (in_array('repeat', $layer_key_list) && $layer['repeat']=='on') ? 'checked' : '';
      $position = in_array('position', $layer_key_list) ? $layer['position'] : '';
      $from_y = '';
      $distance_y = 0;
      $unit_y = '';
      $from_x = '';
      $distance_x = 0;
      $unit_x = '';
      if($position == 'custom') {
        $from_y = in_array('from_y', $layer_key_list) ? $layer['from_y'] : $from_y;
        $distance_y = in_array('distance_y', $layer_key_list) ? $layer['distance_y'] : $distance_y;
        $unit_y = in_array('unit_y', $layer_key_list) ? $layer['unit_y'] : $unit_y;
        $from_x = in_array('from_x', $layer_key_list) ? $layer['from_x'] : $from_x;
        $distance_x = in_array('distance_x', $layer_key_list) ? $layer['distance_x'] : $distance_x;
        $unit_x = in_array('unit_x', $layer_key_list) ? $layer['unit_x'] : $unit_x;
      }
      $checked_unset = (in_array('unset', $layer_key_list) && $layer['unset']=='on') ? 'checked' : '';
      $checked_proportion = '';
      $width = 0;
      $height = 0;
      $unit_w = '';
      $unit_h = '';
      if(!$checked_unset) {
        $checked_proportion = (in_array('proportion', $layer_key_list) && $layer['proportion']=='on') ? 'checked' : $checked_proportion;
        $width = in_array('width', $layer_key_list) ? $layer['width'] : $width;
        $unit_w = in_array('unit_w', $layer_key_list) ? $layer['unit_w'] : $unit_w;
        if(!$checked_proportion) {
          $height = in_array('height', $layer_key_list) ? $layer['height'] : $height;
          $unit_h = in_array('unit_h', $layer_key_list) ? $layer['unit_h'] : $unit_h;
        }
      }
    ?>
    <div class="form-picture">
      <div class="form-upload" data-url="<?php echo $image_url;?>">
        <p class="form-upload-text <?php if($image_name) { echo 'active'; } ?>"><?php echo $image_name;?></p>
        <p class="form-upload-btndelete" <?php if($image_url) { echo 'style="display: block;"'; } ?>></p>
        <label class="form-upload-btnupload">
          <input type="file" class="form-upload-file">
        </label>
        <input type="hidden" class="form-upload-image" name="<?php echo $layer_key; ?>__image" value="<?php echo $image_id; ?>">
      </div>
      <p class="form-checkbox form-background-chkrepeat <?php echo $checked_repeat; ?>">
        <input class="form-background-chkrepeat-check" type="checkbox" name="<?php echo $layer_key; ?>__repeat" <?php echo $checked_repeat; ?> />
        <?php echo __('Background Repeat', $lang_domain); ?>
      </p>
      <div class="form-position">
        <p class="form-position-title"><?php echo __('Background Position', $lang_domain); ?></p>
        <p class="form-position-position">
          <select class="form-position-selposition" name="<?php echo $layer_key; ?>__position">
            <?php foreach($position_option_list as $key => $value): ?>
            <option value="<?php echo $key; ?>" <?php if($key == $position) { echo 'selected'; } ?>><?php echo $value; ?></option>
            <?php endforeach; ?>
          </select>
        </p>
        <div class="form-position-detail" <?php if($position != 'custom') { echo 'style="display: none;"'; } ?>>
          <div class="form-position-line">
            <p class="form-position-key">
              <select class="form-position-selfrom from-y" name="<?php echo $layer_key; ?>__from_y">
                <?php foreach($from_y_option_list as $key => $value): ?>
                <option value="<?php echo $key; ?>" <?php if($key == $from_y) { echo 'selected'; } ?>><?php echo $value; ?></option>
                <?php endforeach; ?>
              </select>
            </p>
            <p class="form-position-distance">
              <input class="form-position-txtdistance distance-y" type="number" name="<?php echo $layer_key; ?>__distance_y" value="<?php echo $distance_y; ?>">
            </p>
            <p class="form-position-unit">
              <select class="form-position-selunit unit-y" name="<?php echo $layer_key; ?>__unit_y">
                <?php foreach($unit_option_list as $key => $value): ?>
                <option value="<?php echo $key; ?>" <?php if($key == $unit_y) { echo 'selected'; } ?>><?php echo $value; ?></option>
                <?php endforeach; ?>
              </select>
            </p>
          </div>
          <div class="form-position-line">
            <p class="form-position-key">
              <select class="form-position-selfrom from-x" name="<?php echo $layer_key; ?>__from_x">
                <?php foreach($from_x_option_list as $key => $value): ?>
                <option value="<?php echo $key; ?>" <?php if($key == $from_x) { echo 'selected'; } ?>><?php echo $value; ?></option>
                <?php endforeach; ?>
              </select>
            </p>
            <p class="form-position-distance">
              <input class="form-position-txtdistance distance-x" type="number" name="<?php echo $layer_key; ?>__distance_x" value="<?php echo $distance_x; ?>">
            </p>
            <p class="form-position-unit">
              <select class="form-position-selunit unit-x" name="<?php echo $layer_key; ?>__unit_x">
                <?php foreach($unit_option_list as $key => $value): ?>
                <option value="<?php echo $key; ?>" <?php if($key == $unit_x) { echo 'selected'; } ?>><?php echo $value; ?></option>
                <?php endforeach; ?>
              </select>
            </p>
          </div>
        </div>
      </div>
      <div class="form-size">
        <p class="form-size-title"><?php echo __('Background Size', $lang_domain); ?></p>
        <div class="form-size-unset">
          <p class="form-checkbox form-size-chkunset <?php echo $checked_unset; ?>">
            <input class="form-size-chkunset-check" type="checkbox" name="<?php echo $layer_key; ?>__unset" <?php echo $checked_unset; ?> />
            <?php echo __('Original Size', $lang_domain); ?>
          </p>
        </div>
        <div class="form-size-setting" <?php if($checked_unset) { echo 'style="display: none;"'; } ?>>
          <div class="form-size-proportion">
            <p class="form-checkbox form-size-chkproportion <?php echo $checked_proportion; ?>">
              <input class="form-size-chkproportion-check" type="checkbox" name="<?php echo $layer_key; ?>__proportion" <?php echo $checked_proportion; ?> />
              <?php echo __('Keep Proportion', $lang_domain); ?>
            </p>
          </div>
          <div class="form-size-size">
            <div class="form-size-line line-width">
              <p class="form-size-key"><?php echo __('Width', $lang_domain); ?></p>
              <p class="form-size-value">
                <input class="form-size-txtvalue value-w" type="number" min="0" name="<?php echo $layer_key; ?>__width" value="<?php echo $width; ?>">
              </p>
              <p class="form-size-unit">
                <select class="form-size-selunit unit-w" name="<?php echo $layer_key; ?>__unit_w">
                  <?php foreach($unit_option_list as $key => $value): ?>
                  <option value="<?php echo $key; ?>" <?php if($key == $unit_w) { echo 'selected'; } ?>><?php echo $value; ?></option>
                  <?php endforeach; ?>
                </select>
              </p>
            </div>
            <div class="form-size-line line-height" style="">
              <p class="form-position-key"><?php echo __('Height', $lang_domain); ?></p>
              <p class="form-size-value">
                <input class="form-size-txtvalue value-h" type="number" min="0" name="<?php echo $layer_key; ?>__height" value="<?php echo $height; ?>">
              </p>
              <p class="form-size-unit">
                <select class="form-size-selunit unit-h" name="<?php echo $layer_key; ?>__unit_h">
                  <?php foreach($unit_option_list as $key => $value): ?>
                  <option value="<?php echo $key; ?>" <?php if($key == $unit_h) { echo 'selected'; } ?>><?php echo $value; ?></option>
                  <?php endforeach; ?>
                </select>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <?php 
    // 変色タイプ設定エリアを構築
    elseif($layer['type'] == 'gradient'): 
      // 設定値を整理
      $colors = (in_array('colors', $layer_key_list) && is_array($layer['colors'])) ? $layer['colors'] : array();
      array_multisort(array_column($colors, 'index'), SORT_ASC, SORT_NUMERIC, $colors);
      $gradient_type = in_array('gradient_type', $layer_key_list) ? $layer['gradient_type'] : '';
      $checked_gradient_repeat = (in_array('gradient_repeat', $layer_key_list) && $layer['gradient_repeat']=='on') ? 'checked' : '';
      $direction = '';
      $rotate = 0;
      $shape = '';
      $center = '';
      $center_from_y = '';
      $center_distance_y = 0;
      $center_unit_y = '';
      $center_from_x = '';
      $center_distance_x = 0;
      $center_unit_x = '';
      if($gradient_type == 'linear') {
        $direction = in_array('direction', $layer_key_list) ? $layer['direction'] : $direction;
        $rotate = in_array('rotate', $layer_key_list) ? $layer['rotate'] : $rotate;
      } elseif($gradient_type == 'radial' || $gradient_type == 'conic') {
        if($gradient_type == 'radial') {
          $shape = in_array('shape', $layer_key_list) ? $layer['shape'] : $shape;
        }
        $center = in_array('center', $layer_key_list) ? $layer['center'] : $center;
        if($center == 'custom') {
          $center_from_y = in_array('center_from_y', $layer_key_list) ? $layer['center_from_y'] : $center_from_y;
          $center_distance_y = in_array('center_distance_y', $layer_key_list) ? $layer['center_distance_y'] : $center_distance_y;
          $center_unit_y = in_array('center_unit_y', $layer_key_list) ? $layer['center_unit_y'] : $center_unit_y;
          $center_from_x = in_array('center_from_x', $layer_key_list) ? $layer['center_from_x'] : $center_from_x;
          $center_distance_x = in_array('center_distance_x', $layer_key_list) ? $layer['center_distance_x'] : $center_distance_x;
          $center_unit_x = in_array('center_unit_x', $layer_key_list) ? $layer['center_unit_x'] : $center_unit_x;
        }
      }
      $checked_unset = (in_array('unset', $layer_key_list) && $layer['unset']=='on') ? 'checked' : '';
      $width = 0;
      $height = 0;
      $unit_w = '';
      $unit_h = '';
      $checked_brepeat = '';
      $position = '';
      $from_y = '';
      $distance_y = 0;
      $unit_y = '';
      $from_x = '';
      $distance_x = 0;
      $unit_x = '';
      if(!$checked_unset) {
        $width = in_array('width', $layer_key_list) ? $layer['width'] : $width;
        $unit_w = in_array('unit_w', $layer_key_list) ? $layer['unit_w'] : $unit_w;
        $height = in_array('height', $layer_key_list) ? $layer['height'] : $height;
        $unit_h = in_array('unit_h', $layer_key_list) ? $layer['unit_h'] : $unit_h;
        $checked_brepeat = (in_array('brepeat', $layer_key_list) && $layer['brepeat']=='on') ? 'checked' : $checked_brepeat;
        $position = in_array('position', $layer_key_list) ? $layer['position'] : $position;
        if($position == 'custom') {
          $from_y = in_array('from_y', $layer_key_list) ? $layer['from_y'] : $from_y;
          $distance_y = in_array('distance_y', $layer_key_list) ? $layer['distance_y'] : $distance_y;
          $unit_y = in_array('unit_y', $layer_key_list) ? $layer['unit_y'] : $unit_y;
          $from_x = in_array('from_x', $layer_key_list) ? $layer['from_x'] : $from_x;
          $distance_x = in_array('distance_x', $layer_key_list) ? $layer['distance_x'] : $distance_x;
          $unit_x = in_array('unit_x', $layer_key_list) ? $layer['unit_x'] : $unit_x;
        }
      }
    ?>
    <div class="form-gradient" data-index="<?php echo count($colors); ?>">
      <div class="form-gradient-list">
        <?php 
        // 変色の各色の設定エリアを構築
        foreach($colors as $color_id => $color_info): 
          $color_key_list = array_keys($color_info);
          $color_key = $layer_key . '__colors__' . $color_id;
          $checked_transparent = (in_array('transparent', $color_key_list) && $color_info['transparent']=='on') ? 'checked' : '';
          $color = in_array('color', $color_key_list) ? $color_info['color'] : '';
          $opacity = in_array('opacity', $color_key_list) && is_numeric($color_info['opacity']) ? ((float) $color_info['opacity']) : 1;
          $size = in_array('size', $color_key_list) ? $color_info['size'] : '';
          $unit = in_array('unit', $color_key_list) ? $color_info['unit'] : '';
        ?>
        <div class="form-color form-gradient-color" data-colorid="<?php echo $color_id; ?>">
          <div class="form-gradient-color-header">
            <p class="form-gradient-color-btnsort"></p>
            <div class="form-color-showarea form-gradient-color-showarea">
              <div class="form-color-show">
                <p class="form-color-checkbox form-gradient-color-checkbox <?php echo $checked_transparent; ?>"></p>
              </div>
            </div>
            <p class="form-gradient-color-btnslide"></p>
            <p class="form-gradient-color-btndelete"></p>
          </div>
          <div class="form-gradient-color-body">
            <p class="form-color-title"><?php echo __('Color And Opacity', $lang_domain); ?></p>
            <div class="form-color-line">
              <div class="form-color-showarea">
                <div class="form-color-show form-color-show-body">
                  <p class="form-color-checkbox <?php echo $checked_transparent; ?>">
                    <input class="form-color-checkbox-check" type="checkbox" name="<?php echo $color_key; ?>__transparent" <?php echo $checked_transparent; ?> />
                  </p>
                </div>
              </div>
              <p class="form-color-picker">
                <input class="form-color-txtpicker" type="text" maxlength="6" name="<?php echo $color_key; ?>__color" value="<?php echo $color; ?>">
              </p>
              <p class="form-color-opacity">
                <select class="form-color-selopacity" name="<?php echo $color_key; ?>__opacity">
                  <?php for($opacity_value = 10; $opacity_value >= 0; $opacity_value = $opacity_value - 1): ?>
                  <option value="<?php echo ($opacity_value / 10); ?>" <?php if(($opacity * 10) == $opacity_value) { echo 'selected'; } ?>>
                    <?php echo $opacity_value * 10; ?>%
                  </option>
                  <?php endfor; ?>
                </select>
              </p>
            </div>
            <p class="form-color-title"><?php echo __('Gradient Size', $lang_domain); ?></p>
            <div class="form-color-line">
              <p class="form-color-size">
                <input class="form-color-txtsize" type="number" name="<?php echo $color_key; ?>__size" min="0" value="<?php echo $size; ?>">
              </p>
              <p class="form-color-unit">
                <select class="form-color-selunit" name="<?php echo $color_key; ?>__unit">
                  <?php foreach($unit_option_list as $key => $value): ?>
                  <option value="<?php echo $key; ?>" <?php if($key == $unit) { echo 'selected'; } ?>><?php echo $value; ?></option>
                  <?php endforeach; ?>
                </select>
              </p>
              <p class="form-color-percent" style="display: none;">%</p>
            </div>
          </div>
          <input type="hidden" class="form-gradient-index" name="<?php echo $color_key; ?>__index" value="<?php echo $color_id; ?>">
        </div>
        <?php endforeach; ?>
      </div>
      <p class="form-gradient-button"><?php echo __('Add Gradient Color', $lang_domain); ?></p>
      <div class="form-gradient-type">
        <?php 
        foreach($gradient_type_option_list as $key => $value): 
          $checked_gradient_type = ($key == $gradient_type) ? 'checked': '';
        ?>
        <div class="form-gradient-rdotype <?php echo $checked_gradient_type; ?>">
          <p class="form-gradient-rdotype-preview preview-<?php echo $key; ?>"></p>
          <p class="form-gradient-rdotype-title"><?php echo $value; ?></p>
          <input type="radio" class="form-gradient-rdotype-radio" name="<?php echo $layer_key; ?>__gradient_type" value="<?php echo $key; ?>" <?php echo $checked_gradient_type; ?> />
        </div>
        <?php endforeach; ?>
      </div>
      <p class="form-checkbox form-gradient-chkrepeat <?php echo $checked_gradient_repeat; ?>">
        <input class="form-gradient-chkrepeat-check" type="checkbox" name="<?php echo $layer_key; ?>__gradient_repeat" <?php echo $checked_gradient_repeat; ?> />
        <?php echo __('Gradient Repeat', $lang_domain); ?>
      </p>
      <div class="form-gradient-option">
        <p class="form-gradient-direction" <?php if($gradient_type != 'linear') { echo 'style="display: none;"'; } ?>>
          <select class="form-gradient-seldirection" name="<?php echo $layer_key; ?>__direction">
            <?php foreach($direction_option_list as $key => $value): ?>
            <option value="<?php echo $key; ?>" <?php if($key == $direction) { echo 'selected'; } ?>><?php echo $value; ?></option>
            <?php endforeach; ?>
          </select>
        </p>
        <div class="form-gradient-rotate" <?php if($gradient_type != 'linear' || $direction !='rotate') { echo 'style="display: none;"'; } ?>>
          <div class="form-gradient-rotate-inner">
            <p class="form-gradient-rotate-title"><?php echo __('Gradient Rotate', $lang_domain); ?></p>
            <input class="form-gradient-txtrotate" type="number" maxlength="3" max="359" min="0" name="<?php echo $layer_key; ?>__rotate" value="<?php echo $rotate; ?>">
            <p class="form-gradient-rotate-sim" style="transform: rotate(<?php echo $rotate; ?>deg);"></p>
          </div>
        </div>
        <p class="form-gradient-shape" <?php if($gradient_type != 'radial') { echo 'style="display: none;"'; } ?>>
          <select class="form-gradient-selshape" name="<?php echo $layer_key; ?>__shape">
            <?php foreach($shape_option_list as $key => $value): ?>
            <option value="<?php echo $key; ?>" <?php if($key == $shape) { echo 'selected'; } ?>><?php echo $value; ?></option>
            <?php endforeach; ?>
          </select>
        </p>
        <div class="form-position form-gradient-center" <?php if($gradient_type != 'radial' && $gradient_type != 'conic') { echo 'style="display: none;"'; } ?>>
          <p class="form-position-title"><?php echo __('Gradient Center', $lang_domain); ?></p>
          <p class="form-position-position">
            <select class="form-gradient-selcenter" name="<?php echo $layer_key; ?>__center">
              <?php foreach($position_option_list as $key => $value): ?>
              <option value="<?php echo $key; ?>" <?php if($key == $center) { echo 'selected'; } ?>><?php echo $value; ?></option>
              <?php endforeach; ?>
            </select>
          </p>
          <div class="form-position-detail form-gradient-center-detail" <?php if($center != 'custom') { echo 'style="display: none;"'; } ?>>
            <div class="form-position-line">
              <p class="form-position-key">
                <select class="form-position-selcenterfrom from-y" name="<?php echo $layer_key; ?>__center_from_y">
                  <?php foreach($from_y_option_list as $key => $value): ?>
                  <option value="<?php echo $key; ?>" <?php if($key == $center_from_y) { echo 'selected'; } ?>><?php echo $value; ?></option>
                  <?php endforeach; ?>
                </select>
              </p>
              <p class="form-position-distance">
                <input class="form-position-txtcenterdistance distance-y" type="number" min="0" 
                    name="<?php echo $layer_key; ?>__center_distance_y" value="<?php echo $center_distance_y; ?>">
              </p>
              <p class="form-position-unit">
                <select class="form-position-selcenterunit unit-y" name="<?php echo $layer_key; ?>__center_unit_y">
                  <?php foreach($unit_option_list as $key => $value): ?>
                  <option value="<?php echo $key; ?>" <?php if($key == $center_unit_y) { echo 'selected'; } ?>><?php echo $value; ?></option>
                  <?php endforeach; ?>
                </select>
              </p>
            </div>
            <div class="form-position-line">
              <p class="form-position-key">
                <select class="form-position-selcenterfrom from-x" name="<?php echo $layer_key; ?>__center_from_x">
                  <?php foreach($from_x_option_list as $key => $value): ?>
                  <option value="<?php echo $key; ?>" <?php if($key == $center_from_x) { echo 'selected'; } ?>><?php echo $value; ?></option>
                  <?php endforeach; ?>
                </select>
              </p>
              <p class="form-position-distance">
                <input class="form-position-txtcenterdistance distance-x" type="number" min="0" 
                    name="<?php echo $layer_key; ?>__center_distance_x" value="<?php echo $center_distance_x; ?>">
              </p>
              <p class="form-position-unit">
                <select class="form-position-selcenterunit unit-x" name="<?php echo $layer_key; ?>__center_unit_x">
                  <?php foreach($unit_option_list as $key => $value): ?>
                  <option value="<?php echo $key; ?>" <?php if($key == $center_unit_x) { echo 'selected'; } ?>><?php echo $value; ?></option>
                  <?php endforeach; ?>
                </select>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="form-size">
        <p class="form-size-title"><?php echo __('Background Size', $lang_domain); ?></p>
        <div class="form-size-unset">
          <p class="form-checkbox form-size-chkunset <?php echo $checked_unset; ?>">
            <input class="form-size-chkunset-check" type="checkbox" name="<?php echo $layer_key; ?>__unset" <?php echo $checked_unset; ?> />
            <?php echo __('Background Full Size', $lang_domain); ?>
          </p>
        </div>
        <div class="form-size-setting" <?php if($checked_unset) { echo 'style="display: none;"'; } ?>>
          <div class="form-size-size">
            <div class="form-size-line line-width">
              <p class="form-size-key"><?php echo __('Width', $lang_domain); ?></p>
              <p class="form-size-value">
                <input class="form-size-txtvalue value-w" type="number" min="0" name="<?php echo $layer_key; ?>__width" value="<?php echo $width; ?>">
              </p>
              <p class="form-size-unit">
                <select class="form-size-selunit unit-w" name="<?php echo $layer_key; ?>__unit_w">
                  <?php foreach($unit_option_list as $key => $value): ?>
                  <option value="<?php echo $key; ?>" <?php if($key == $unit_w) { echo 'selected'; } ?>><?php echo $value; ?></option>
                  <?php endforeach; ?>
                </select>
              </p>
            </div>
            <div class="form-size-line line-height">
              <p class="form-position-key"><?php echo __('Height', $lang_domain); ?></p>
              <p class="form-size-value">
                <input class="form-size-txtvalue value-h" type="number" min="0" name="<?php echo $layer_key; ?>__height" value="<?php echo $height; ?>">
              </p>
              <p class="form-size-unit">
                <select class="form-size-selunit unit-h" name="<?php echo $layer_key; ?>__unit_h">
                  <?php foreach($unit_option_list as $key => $value): ?>
                  <option value="<?php echo $key; ?>" <?php if($key == $unit_h) { echo 'selected'; } ?>><?php echo $value; ?></option>
                  <?php endforeach; ?>
                </select>
              </p>
            </div>
          </div>
          <p class="form-checkbox form-background-chkrepeat <?php echo $checked_brepeat; ?>">
            <input class="form-background-chkrepeat-check" type="checkbox" name="<?php echo $layer_key; ?>__brepeat" <?php echo $checked_brepeat; ?>>Background Repeat
          </p>
          <div class="form-position">
            <p class="form-position-title"><?php echo __('Background Position', $lang_domain); ?></p>
            <p class="form-position-position">
              <select class="form-position-selposition" name="<?php echo $layer_key; ?>__position">
                <?php foreach($position_option_list as $key => $value): ?>
                <option value="<?php echo $key; ?>" <?php if($key == $position) { echo 'selected'; } ?>><?php echo $value; ?></option>
                <?php endforeach; ?>
              </select>
            </p>
            <div class="form-position-detail" <?php if($position != 'custom') { echo 'style="display: none;"'; } ?>>
              <div class="form-position-line">
                <p class="form-position-key">
                  <select class="form-position-selfrom from-y" name="<?php echo $layer_key; ?>__from_y">
                    <?php foreach($from_y_option_list as $key => $value): ?>
                    <option value="<?php echo $key; ?>" <?php if($key == $from_y) { echo 'selected'; } ?>><?php echo $value; ?></option>
                    <?php endforeach; ?>
                  </select>
                </p>
                <p class="form-position-distance">
                  <input class="form-position-txtdistance distance-y" type="number" name="<?php echo $layer_key; ?>__distance_y" value="<?php echo $distance_y; ?>">
                </p>
                <p class="form-position-unit">
                  <select class="form-position-selunit unit-y" name="<?php echo $layer_key; ?>__unit_y">
                    <?php foreach($unit_option_list as $key => $value): ?>
                    <option value="<?php echo $key; ?>" <?php if($key == $unit_y) { echo 'selected'; } ?>><?php echo $value; ?></option>
                    <?php endforeach; ?>
                  </select>
                </p>
              </div>
              <div class="form-position-line">
                <p class="form-position-key">
                  <select class="form-position-selfrom from-x" name="<?php echo $layer_key; ?>__from_x">
                    <?php foreach($from_x_option_list as $key => $value): ?>
                    <option value="<?php echo $key; ?>" <?php if($key == $from_x) { echo 'selected'; } ?>><?php echo $value; ?></option>
                    <?php endforeach; ?>
                  </select>
                </p>
                <p class="form-position-distance">
                  <input class="form-position-txtdistance distance-x" type="number" name="<?php echo $layer_key; ?>__distance_x" value="<?php echo $distance_x; ?>">
                </p>
                <p class="form-position-unit">
                  <select class="form-position-selunit unit-x" name="<?php echo $layer_key; ?>__unit_x">
                    <?php foreach($unit_option_list as $key => $value): ?>
                    <option value="<?php echo $key; ?>" <?php if($key == $unit_x) { echo 'selected'; } ?>><?php echo $value; ?></option>
                    <?php endforeach; ?>
                  </select>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <?php endif; ?>
  </div>
</div>