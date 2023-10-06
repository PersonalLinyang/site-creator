// 背景タイプ選択肢
const background_type_options = {
  'solid':translations.background_solid, 
  'picture':translations.background_picture, 
  'gradient':translations.background_gradient, 
}

// 変色タイプ選択肢
const gradient_type_options = {
  'linear':translations.gradient_linear,
  'radial':translations.gradient_radial,
  'conic':translations.gradient_conic,
}

// 変色方向選択肢
const gradient_direction_options = { 
  'to bottom':translations.gradient_to_bottom,
  'to right':translations.gradient_to_right,
  'to top right':translations.gradient_to_top_right,
  'to bottom right':translations.gradient_to_bottom_right,
  'rotate':translations.gradient_custom_rotate,
}

// 変色形状選択肢
const gradient_shape_options = { 
  'ellipse':translations.gradient_ellipse, 
  'circle':translations.gradient_circle, 
};

// 背景位置選択肢
const background_position_options = { 
  'center':translations.background_center,
  'top':translations.background_top,
  'bottom':translations.background_bottom,
  'left':translations.background_left,
  'right':translations.background_right,
  'top left':translations.background_top_left,
  'top right':translations.background_top_right,
  'bottom left':translations.background_bottom_left,
  'bottom right':translations.background_bottom_right,
  'custom':translations.background_custom_position,
}

// 縦方向選択肢
const background_from_y_options = { 
  'top':translations.from_top, 
  'bottom':translations.from_bottom, 
}

// 横方向選択肢
const background_from_x_options = { 
  'left':translations.from_left, 
  'right':translations.from_right, 
}


/* 
 * シミュレーション更新 
 * params 
 *   target : 対象識別キー
 */
const updateBackgroundSimulation = function(target) {
  /* 
   * 背景設定値を取得 
   * params 
   *   area : 対象背景層設定部分(レスポンシブ対応の場合端末単位)
   * return 
   *   bg_image : 背景画像URL/変色関数
   *   bg_repeat : 背景重複
   *   bg_size : 背景サイズ
   *   bg_position : 背景位置
   */
  var getBackgroundInfo = function(area) {
    // return初期化
    var bg_image = '';
    var bg_repeat = '';
    var bg_size = '';
    var bg_position = '';
    
    // 取得失敗時return定義
    var fail_result = [bg_image, bg_repeat, bg_size, bg_position];
    
    if(typeof(area) != 'undefined') {
      var type = area.find('.form-background-seltype').val();
      if(checkDirectionKey(type, background_type_options)) {
        if(type == 'solid') { 
          // 純色背景設定値取得
          var hex = area.find('.form-color-txtpicker').val();
          var opa = area.find('.form-color-selopacity').val();
          if(checkHex(hex) && checkOpacity(opa)) {
            var rgb = getRgbByHex(hex);
            var color = 'rgba(' + rgb['r'] + ', ' + rgb['g'] + ', ' + rgb['b'] + ', ' + opa + ')';
            bg_image = 'linear-gradient(0deg, ' + color + ', ' + color + ')';
            bg_repeat = 'repeat';
            bg_size = '100% 100%';
            bg_position = 'center';
          }
        } else if(type == 'picture') { 
          // 画像URL取得
          var url = area.find('.form-upload').data('url');
          if(url) {
            bg_image = 'url(' + url + ')';
          }
          
          // 背景重複設定値を取得
          if(area.find('.form-background-chkrepeat-check').prop('checked')) {
            bg_repeat = 'repeat';
          } else {
            bg_repeat = 'no-repeat';
          }
          
          // 背景位置設定値を取得
          var position = area.find('.form-background-position-selposition').val();
          if(position == 'custom') {
            var from_x = area.find('.form-background-position-selfrom.from-x').val();
            var from_y = area.find('.form-background-position-selfrom.from-y').val();
            var distance_x = area.find('.form-background-position-txtnumber.distance-x').val();
            var distance_y = area.find('.form-background-position-txtnumber.distance-y').val();
            var unit_x = area.find('.form-background-position-selunit.unit-x').val();
            var unit_y = area.find('.form-background-position-selunit.unit-y').val();
            
            if(checkDirectionKey(from_x, background_from_x_options) && checkNumber(distance_x) && inArray(unit_x, unit_options) && 
               checkDirectionKey(from_y, background_from_y_options) && checkNumber(distance_y) && inArray(unit_y, unit_options)) {
              bg_position = from_y + ' ' + getValueWithUnit(distance_y, unit_y) + ' ' + from_x + ' ' + getValueWithUnit(distance_x, unit_x);
            } else {
              return fail_result;
            }
          } else if(checkDirectionKey(position, background_position_options)) {
            bg_position = position;
          } else {
            return fail_result;
          }
          
          // 背景サイズ設定値を取得
          if(area.find('.form-background-size-chkunset-check').prop('checked')) {
            bg_size = 'auto';
          } else {
            var size = '';
            var width = area.find('.form-background-size-txtnumber.value-w').val();
            var unit_w = area.find('.form-background-size-selunit.unit-w').val();
            if(checkNumber(width) && inArray(unit_w, unit_options)) {
              size += getValueWithUnit(width, unit_w);
              if(!area.find('.form-background-size-chkproportion-check').prop('checked')) {
                var height = area.find('.form-background-size-txtnumber.value-h').val();
                var unit_h = area.find('.form-background-size-selunit.unit-h').val();
                if(checkNumber(height) && inArray(unit_h, unit_options)) {
                  size += ' ' + getValueWithUnit(height, unit_h);
                } else {
                  return fail_result;
                }
              }
              bg_size = size;
            } else {
              return fail_result;
            }
          }
        } else if(type == 'gradient') { 
          // 変色重複取得
          if(area.find('.form-background-gradient-chkrepeat-check').prop('checked')) {
            bg_image += 'repeating-';
          }
          
          var gradient_type = area.find('.form-background-gradient-rdotype-radio:checked').val();
          if(checkDirectionKey(gradient_type, gradient_type_options)) {
            // 変色タイプ取得
            bg_image += gradient_type + '-gradient(';
            
            if(gradient_type == 'linear') {
              // 線型変色方向を取得
              var direction = area.find('.form-background-gradient-seldirection').val();
              if(direction == 'rotate') {
                var rotate = $('.form-background-gradient-txtrotate').val();
                if(checkNumber(rotate)) {
                  bg_image += rotate + 'deg ';
                } else {
                  return fail_result;
                }
              } else if(checkDirectionKey(direction, gradient_direction_options)) {
                bg_image += direction + ' ';
              } else {
                return fail_result;
              }
            } else if(gradient_type == 'conic' || gradient_type == 'radial') {
              // 円型変色形状を取得
              if(gradient_type == 'radial') {
                var shape = area.find('.form-background-gradient-selshape').val();
                if(checkDirectionKey(shape, gradient_shape_options)) {
                  bg_image += shape + ' at ';
                } else {
                  return fail_result;
                }
              } else {
                bg_image += ' from 0deg at '
              }
              
              // 円型/扇型変色中心点を取得
              var center = area.find('.form-background-gradient-selcenter').val();
              if(center == 'custom') {
                var from_x = area.find('.form-background-position-selfrom.center-from-x').val();
                var from_y = area.find('.form-background-position-selfrom.center-from-y').val();
                var distance_x = area.find('.form-background-position-txtnumber.center-distance-x').val();
                var distance_y = area.find('.form-background-position-txtnumber.center-distance-y').val();
                var unit_x = area.find('.form-background-position-selunit.center-distance-x-unit').val();
                var unit_y = area.find('.form-background-position-selunit.center-distance-y-unit').val();
                
                if(checkDirectionKey(from_x, background_from_x_options) && checkNumber(distance_x) && inArray(unit_x, unit_options) && 
                   checkDirectionKey(from_y, background_from_y_options) && checkNumber(distance_y) && inArray(unit_y, unit_options)) {
                  bg_image += from_x + ' ' + getValueWithUnit(distance_x, unit_x) + ' ' + from_y + ' ' + getValueWithUnit(distance_y, unit_y) + ' ';
                } else {
                  return fail_result;
                }
              } else if(checkDirectionKey(center, background_position_options)) {
                bg_image += center + ' ';
              } else {
                return fail_result;
              }
            }
            
            // 色配列を整理
            var calc_inner = {};
            var counter = 0;
            if(area.find('.form-background-gradient-color').length) {
              area.find('.form-background-gradient-color').each(function(){
                // 色設定をループして整理
                var check = $(this).find('.form-color-checkbox-check');
                var hex = $(this).find('.form-color-txtpicker').val();
                var opa = $(this).find('.form-color-selopacity').val();
                var size = $(this).find('.form-background-gradient-color-size-txtnumber').val();
                var unit = '%';
                if(gradient_type == 'linear' || gradient_type == 'radial') {
                  unit = $(this).find('.form-background-gradient-color-size-selunit').val();
                }
                
                // 色と透明度を取得
                var color = 'transparent';
                if(!check.prop('checked')) {
                  if(checkHex(hex) && checkOpacity(opa)) {
                    var rgb = getRgbByHex(hex);
                    color = 'rgba(' + rgb['r'] + ', ' + rgb['g'] + ', ' + rgb['b'] + ', ' + opa + ')';
                  }
                }
                
                // 変色範囲サイズを取得
                if(checkNumber(size, {'positive':true})) {
                  size = parseFloat(size);
                } else {
                  return true;  // continue
                }
                
                // 変色範囲単位を取得して、計算要素を更新
                if(inArray(unit, unit_options)) {
                  calc_inner = updateCalcInner(calc_inner, size, unit);
                } else {
                  return true;  // continue
                }
                
                // 最初の色の純色範囲を設定
                if(counter == 0) {
                  bg_image += ', ' + color + ' 0 ';
                  counter++;
                }
                
                // 色設定値を追加
                bg_image += ', ' + color + ' ' + getCalcText(calc_inner) + ' ';
              });
            } else {
              return fail_result;
            }
            
            bg_image += ')';
            
            // 背景サイズ設定値を取得
            if(!area.find('.form-background-size-chkunset-check').prop('checked')) {
              var width = area.find('.form-background-size-txtnumber.value-w').val();
              var unit_w = area.find('.form-background-size-selunit.unit-w').val();
              var height = area.find('.form-background-size-txtnumber.value-h').val();
              var unit_h = area.find('.form-background-size-selunit.unit-h').val();
              if(checkNumber(width) && inArray(unit_w, unit_options) && 
                 checkNumber(height) && inArray(unit_h, unit_options)) {
                bg_size = getValueWithUnit(width, unit_w) + ' ' + getValueWithUnit(height, unit_h);
              } else {
                return fail_result;
              }
              
              // 背景重複設定値を取得
              if(area.find('.form-background-chkrepeat-check').prop('checked')) {
                bg_repeat = 'repeat';
              } else {
                bg_repeat = 'no-repeat';
              }
              
              // 背景位置設定値を取得
              var position = area.find('.form-background-position-selposition').val();
              if(position == 'custom') {
                var from_x = area.find('.form-background-position-selfrom.from-x').val();
                var from_y = area.find('.form-background-position-selfrom.from-y').val();
                var distance_x = area.find('.form-background-position-txtnumber.distance-x').val();
                var distance_y = area.find('.form-background-position-txtnumber.distance-y').val();
                var unit_x = area.find('.form-background-position-selunit.unit-x').val();
                var unit_y = area.find('.form-background-position-selunit.unit-y').val();
                
                if(checkDirectionKey(from_x, background_from_x_options) && checkNumber(distance_x) && inArray(unit_x, unit_options) && 
                   checkDirectionKey(from_y, background_from_y_options) && checkNumber(distance_y) && inArray(unit_y, unit_options)) {
                  bg_position = from_y + ' ' + getValueWithUnit(distance_y, unit_y) + ' ' + from_x + ' ' + getValueWithUnit(distance_x, unit_x);
                } else {
                  return fail_result;
                }
              } else if(checkDirectionKey(position, background_position_options)) {
                bg_position = position;
              } else {
                return fail_result;
              }
            } else {
              bg_size = '100% 100%';
              bg_repeat = 'no-repeat';
              bg_position = 'top left';
            }
          } else {
            return fail_result;
          }
        }
      } else {
        return fail_result;
      }
    }
    
    return [bg_image, bg_repeat, bg_size, bg_position];
  }
  
  /* 
   * 背景設定値を取得 
   * params 
   *   old_list : 更新前背景設定値リスト
   *   value_list : 新しい背景設定値リスト
   * return 更新後背景設定値リスト
   */
  var updateBackgroundInfo = function(old_list, value_list) {
    var new_list = [];
    var skip_flag = false;
    $.each(value_list, function(index, value) {
      if(value) {
        new_list[index] = old_list[index] + (old_list[index] ? ', ' : '') + value;
      } else {
        skip_flag = true;
      }
    });
    
    if(skip_flag) {
      return old_list;
    } else {
      return new_list;
    }
  }
  
  // updateBackgroundSimulation本体
  // 背景設定部分取得
  var background = $('.form-block[data-target="' + target + '"]').find('.form-background');
  if(background.length) {
    // 設定値を初期化
    var bg_info_pc = ['', '', '', ''];
    var bg_info_sp = ['', '', '', ''];
    
    // 背景層をループして背景情報を取得
    var layer_list = background.first().find('.form-background-layer');
    layer_list.each(function(){
      var layer = $(this);
      var pc_flag = layer.find('.form-responsive-chkdevice-check.chkdevice-check-pc').prop('checked');
      var sp_flag = layer.find('.form-responsive-chkdevice-check.chkdevice-check-sp').prop('checked');
      var re_flag = layer.find('.form-responsive-chkflag-check').prop('checked');
      
      if(pc_flag == true) {
        // PCのみ表示部分の背景を取得
        var area = layer.find('.form-responsive-area').first();
        var value_list = getBackgroundInfo(area);
        bg_info_pc = updateBackgroundInfo(bg_info_pc, value_list);
      } else if(sp_flag == true) {
        // SPのみ表示部分の背景を取得
        var area = layer.find('.form-responsive-area').first();
        var value_list = getBackgroundInfo(area);
        bg_info_sp = updateBackgroundInfo(bg_info_sp, value_list);
      } else if(re_flag == true ) {
        // レスポンシブ対応部分の背景をPCとSPで別々で取得
        var area_pc = layer.find('.form-responsive-area.setting-pc').first();
        var value_list_pc = getBackgroundInfo(area_pc);
        bg_info_pc = updateBackgroundInfo(bg_info_pc, value_list_pc);
        
        var area_sp = layer.find('.form-responsive-area.setting-sp').first();
        var value_list_sp = getBackgroundInfo(area_sp);
        bg_info_sp = updateBackgroundInfo(bg_info_sp, value_list_sp);
      } else {
        // 一般部分の背景を取得
        var area = layer.find('.form-responsive-area').first();
        var value_list = getBackgroundInfo(area);
        bg_info_pc = updateBackgroundInfo(bg_info_pc, value_list);
        bg_info_sp = updateBackgroundInfo(bg_info_sp, value_list);
      }
    });
    
    // 各項目設定値取得
    [bg_image_pc, bg_repeat_pc, bg_size_pc, bg_position_pc] = bg_info_pc;
    [bg_image_sp, bg_repeat_sp, bg_size_sp, bg_position_sp] = bg_info_sp;
    
    // PC用シミュレーション部分の背景を反映
    $('#sim-' + target + '-pc').css('background-image', bg_image_pc).css('background-repeat', bg_repeat_pc)
        .css('background-size', bg_size_pc).css('background-position', bg_position_pc);
    
    // SP用シミュレーション部分の背景を反映
    $('#sim-' + target + '-sp').css('background-image', bg_image_sp).css('background-repeat', bg_repeat_sp)
        .css('background-size', bg_size_sp).css('background-position', bg_position_sp);
  }
}


/* 
 * 背景層のindexを更新
 * params 
 *   layer_list : 対象背景層リスト
 */
const updateBackgroundLayerIndex = function(layer_list) {
  layer_list.each(function(){
    var target = $(this).closest('.form-block').data('target');
    var index = layer_list.index($(this));
    $(this).find('.form-background-index').val(index);
  });
}


/* 
 * 純色背景編集部分を初期化
 * params 
 *   obj : 対象純色背景編集部分
 */
const initFormBackgroundSolid = function(obj) {
  // 編集対象識別キーを定義
  var target = obj.closest('.form-block').data('target');
  
  // 色編集部分を初期化
  obj.find('.form-color').each(function(){
    initFormColor($(this), updateBackgroundSimulation);
  });
}


/* 
 * 画像背景編集部分を初期化
 * params 
 *   obj : 対象画像背景編集部分
 */
const initFormBackgroundPicture = function(obj) {
  // 編集対象識別キーを定義
  var target = obj.closest('.form-block').data('target');
  
  // 背景重複性チェックボックスをクリック
  obj.find('.form-background-chkrepeat').on('click', function(){
    var checkbox = $(this);
    clickCheckbox(checkbox, function(){
      // シミュレーション更新
      updateBackgroundSimulation(target);
    });
  });
  
  // 背景画像位置タイプ選択変更
  obj.find('.form-background-position-selposition').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // 選択によって詳細設定部分の表示を切り替える
      if(select.val() == 'custom') {
        select.closest('.form-background-position').find('.form-background-position-detail').slideDown(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      } else {
        select.closest('.form-background-position').find('.form-background-position-detail').slideUp(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      }
    });
  });
  
  // 背景画像位置出発方向選択変更
  obj.find('.form-background-position-selfrom').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // シミュレーション更新
      updateBackgroundSimulation(target);
    });
  });
  
  // 背景画像位置距離入力キーアップと変更
  obj.find('.form-background-position-txtnumber').on('keyup change', function(){
    // シミュレーション更新
    updateBackgroundSimulation(target);
  });
  
  // 背景画像位置単位変更
  obj.find('.form-background-position-selunit').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // シミュレーション更新
      updateBackgroundSimulation(target);
    });
  });
  
  // 画像の元サイズで表示のボタンをクリック
  obj.find('.form-background-size-chkunset').on('click', function(){
    var checkbox = $(this);
    clickCheckbox(checkbox, function(){
      // チェック状態によって画像サイズ詳細設定部分の表示を切り替える
      var check = checkbox.find('.form-background-size-chkunset-check');
      if(check.prop('checked')) {
        checkbox.closest('.form-background-size').find('.form-background-size-setting').slideUp(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      } else {
        checkbox.closest('.form-background-size').find('.form-background-size-setting').slideDown(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      }
    });
  });
  
  // 画像の等比率でサイズ調整のボタンをクリック
  obj.find('.form-background-size-chkproportion').on('click', function(){
    var checkbox = $(this);
    clickCheckbox(checkbox, function(){
      // チェック状態によって画像サイズ高さ設定部分の表示を切り替える
      var check = checkbox.find('.form-background-size-chkproportion-check');
      if(check.prop('checked')) {
        checkbox.closest('.form-background-size').find('.form-background-size-line.line-height').slideUp(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      } else {
        checkbox.closest('.form-background-size').find('.form-background-size-line.line-height').slideDown(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      }
    });
  });
  
  // 画像サイズ入力キーアップと変更
  obj.find('.form-background-size-txtnumber').on('keyup change', function(){
    // シミュレーション更新
    updateBackgroundSimulation(target);
  });
  
  // 画像サイズ単位変更
  obj.find('.form-background-size-selunit').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // シミュレーション更新
      updateBackgroundSimulation(target);
    });
  });
  
  // 既存アップロード部分を初期化
  obj.find('.form-upload').each(function(){
    initFormUpload($(this), updateBackgroundSimulation);
  });
}


/* 
 * 変色背景編集部分を初期化
 * params 
 *   obj : 対象変色背景編集部分
 */
const initFormBackgroundGradient = function(obj) {
  /* 
   * 色のindexを更新
   * params 
   *   gradient_list : 対象色設定部分リスト
   */
  var updateBackgroundGradientColorIndex = function(gradient_list) {
    gradient_list.each(function(){
      var index = gradient_list.index($(this));
      $(this).find('.form-background-gradient-index').val(index);
    });
  }
  
  /* 
   * 変色の色設定部分を初期化
   * params 
   *   obj_color : 対象色設定部分
   */
  var initFormBackgroundGradientColor = function(obj_color) {
    // 色設定部分スライドボタンをクリック
    obj_color.find('.form-background-gradient-color-btnslide').on('click', function(){
      var button = $(this);
      clickButton(button, function(){
        var body = obj_color.find('.form-background-gradient-color-body');
        if(button.hasClass('checked')) {
          button.removeClass('checked');
          body.slideDown();
        } else {
          button.addClass('checked');
          body.slideUp();
        }
      });
    });
    
    // 色設定部分を削除
    obj_color.find('.form-background-gradient-color-btndelete').on('click', function(){
      var button = $(this);
      clickButton(button, function(){
        obj_color.slideUp(function(){
          obj_color.remove();
          updateBackgroundSimulation(target);
          updateBackgroundLayerIndex(obj_color.closest('.form-background-gradient-list').find('.form-background-gradient-color'));
        });
      });
    });
    
    // 変色範囲サイズ変更
    obj_color.find('.form-background-gradient-color-size-txtnumber').on('change keyup', function(){
      // シミュレーション更新
      updateBackgroundSimulation(target);
    });
    
    // 変色範囲単位変更
    obj_color.find('.form-background-gradient-color-size-selunit').on('change', function(){
      var select = $(this);
      changeSelect(select, function(){
        // シミュレーション更新
        updateBackgroundSimulation(target);
      });
    });
    
    // 色編集部分を初期化
    obj_color.find('.form-color').each(function(){
      initFormColor($(this), updateBackgroundSimulation, obj_color.find('.form-background-gradient-color-showarea'));
    });
    
    var type = obj.find('.form-background-gradient-rdotype-radio:checked').val();
    if(type == 'conic') {
      // 扇型の場合単位は「%」に固定
      obj_color.find('.form-background-gradient-color-size-percent').show();
      obj_color.find('.form-background-gradient-color-size-unit').hide();
    } else {
      // 線型と円型の場合単位を選択させる
      obj_color.find('.form-background-gradient-color-size-percent').hide();
      obj_color.find('.form-background-gradient-color-size-unit').show();
    }
    
    // 色のindexを更新
    updateBackgroundGradientColorIndex(obj.find('.form-background-gradient-color'));
  }
  
  // initFormBackgroundGradient本体
  // 編集対象識別キーを定義
  var target = obj.closest('.form-block').data('target');
  
  // 背景色を追加ボタンをクリック
  obj.find('.form-background-gradient-button').on('click', function(){
    var button = $(this);
    clickButton(button, function(){
      // 色のキーを取得
      var index = parseInt(obj.data('index'));
      var key = target + '__style__background__' + obj.closest('.form-background-layer').data('layerid');
      var device = $('.header-sim-device.checked').data('device');
      if(obj.closest('.form-responsive').find('.form-responsive-chkdevice-check.chkdevice-check-' + device).prop('checked')) {
        key += '__' + device;
      } else if(obj.closest('.form-responsive').find('.form-responsive-chkflag-check').prop('checked')) {
        key += '__' + device;
      } else {
        key += '__pc';
      }
      
      // 新しい色設定部分を追加
      var html = htmlFormBackgroundGradientColor(key, index, {});
      obj.find('.form-background-gradient-list').append(html);
      var new_color = obj.find('.form-background-gradient-list').find('.form-background-gradient-color').last();
      new_color.hide();
      
      // 背景色をドラッグで並び替え
      obj.find('.form-background-gradient-list').sortable({
        handle: '.form-background-gradient-color-btnsort',
        stop: function(e, ui){
          updateBackgroundSimulation(target);
          updateBackgroundGradientColorIndex(obj.find('.form-background-gradient-color'));
        },
      });
      
      // 新しい色設定部分を初期化
      initFormBackgroundGradientColor(new_color);
      
      // 新しい色設定部分を表示
      new_color.slideDown(function(){
        // 背景層index更新
        obj.data('index', (index + 1).toString());
        
        // シミュレーション更新
        updateBackgroundSimulation(target);
      });
    });
  });
  
  // 変色タイプラジオボタンをクリック
  obj.find('.form-background-gradient-rdotype').on('click', function(e){
    var radio_button = $(this);
    // ラジオボタンクリックイベント実行
    clickRadio(radio_button, function(){
      var radio = radio_button.find('.form-background-gradient-rdotype-radio');
      var option = obj.find('.form-background-gradient-option');
      var type = radio.val();
      
      // 詳細設定部分非表示
      option.slideUp(function(){
        // 各色設定部分の単位設定の表示を切り替える
        obj.find('.form-background-gradient-color-size-percent').hide();
        obj.find('.form-background-gradient-color-size-unit').hide();
        if(type == 'linear' || type == 'radial') {
          obj.find('.form-background-gradient-color-size-unit').show();
        } else if(type == 'conic') {
          obj.find('.form-background-gradient-color-size-percent').show();
        }
        
        // 変色方向と角度設定の表示を切り替える
        option.find('.form-background-gradient-direction').hide();
        option.find('.form-background-gradient-rotate').hide();
        if(type == 'linear') {
          option.find('.form-background-gradient-direction').show();
          if(obj.find('.form-background-gradient-seldirection').val() == 'rotate') {
            option.find('.form-background-gradient-rotate').show();
          }
        }
        
        // 変色形状設定の表示を切り替える
        option.find('.form-background-gradient-shape').hide();
        if(type == 'radial') {
          option.find('.form-background-gradient-shape').show();
        }
        
        // 変色中心点設定の表示を切り替える
        option.find('.form-background-gradient-center').hide();
        option.find('.form-background-gradient-center-detail').hide();
        if(type == 'radial' || type == 'conic') {
          option.find('.form-background-gradient-center').show();
          if(obj.find('.form-background-gradient-selcenter').val() == 'custom') {
            // 変色中心点詳細設定を表示
            option.find('.form-background-gradient-center-detail').show();
          }
        }
        
        // 詳細設定部分表示
        option.slideDown(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      });
    });
  });
  
  // 変色重複チェックボックスをクリック
  obj.find('.form-background-gradient-chkrepeat').on('click', function(){
    var checkbox = $(this);
    clickCheckbox(checkbox, function(){
      // シミュレーション更新
      updateBackgroundSimulation(target);
    });
  });
  
  // 線型変色方向変更
  obj.find('.form-background-gradient-seldirection').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // 選択によって詳細設定部分の表示を切り替える
      if(select.val() == 'rotate') {
        obj.find('.form-background-gradient-rotate').slideDown(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      } else {
        obj.find('.form-background-gradient-rotate').slideUp(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      }
    });
  });
  
  // 線型変色角度キーアップと変更
  obj.find('.form-background-gradient-txtrotate').on('keyup change', function() {
    if(checkNumber($(this).val())) {
      // 角度シミュレーション更新
      $(this).siblings('.form-background-gradient-rotate-sim').css('transform', 'rotate(' + $(this).val() + 'deg)');
    }
    // シミュレーション更新
    updateBackgroundSimulation(target);
  });
  
  // 円型変色形状選択変更
  obj.find('.form-background-gradient-selshape').on('change', function() {
    var select = $(this);
    changeSelect(select, function(){
      // シミュレーション更新
      updateBackgroundSimulation(target);
    });
  });
  
  // 円型・扇型変色中心点位置タイプ変更
  obj.find('.form-background-gradient-selcenter').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // 選択によって詳細設定部分の表示を切り替える
      if(select.val() == 'custom') {
        obj.find('.form-background-gradient-center-detail').slideDown(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      } else {
        obj.find('.form-background-gradient-center-detail').slideUp(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      }
    });
  });
  
  // 完全に背景カバーボタンをクリック
  obj.find('.form-background-size-chkunset').on('click', function(){
    var checkbox = $(this);
    clickCheckbox(checkbox, function(){
      // チェックボックスチェック状態変更
      var check = checkbox.find('.form-background-size-chkunset-check');
      if(check.prop('checked')) {
        // 画像サイズ詳細設定部分非表示
        checkbox.closest('.form-background-size').find('.form-background-size-setting').slideUp(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      } else {
        // 画像サイズ詳細設定部分表示
        checkbox.closest('.form-background-size').find('.form-background-size-setting').slideDown(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      }
    });
  });
  
  // 背景サイズ入力変更
  obj.find('.form-background-size-txtnumber').on('keyup change', function(){
    // シミュレーション更新
    updateBackgroundSimulation(target);
  });
  
  // 背景サイズ単位変更
  obj.find('.form-background-size-selunit').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // シミュレーション更新
      updateBackgroundSimulation(target);
    });
  });
  
  // 背景重複性チェックボックスをクリック
  obj.find('.form-background-chkrepeat').on('click', function(){
    var checkbox = $(this);
    clickCheckbox(checkbox, function(){
      // シミュレーション更新
      updateBackgroundSimulation(target);
    });
  });
  
  // 背景位置タイプ選択変更
  obj.find('.form-background-position-selposition').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // 選択によって詳細設定部分の表示を切り替える
      if(select.val() == 'custom') {
        select.closest('.form-background-position').find('.form-background-position-detail').slideDown(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      } else {
        select.closest('.form-background-position').find('.form-background-position-detail').slideUp(function(){
          // シミュレーション更新
          updateBackgroundSimulation(target);
        });
      }
    });
  });
  
  // 位置系出発方向選択変更
  obj.find('.form-background-position-selfrom').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // シミュレーション更新
      updateBackgroundSimulation(target);
    });
  });
  
  // 位置系座標変更
  obj.find('.form-background-position-txtnumber').on('keyup change', function(){
    // シミュレーション更新
    updateBackgroundSimulation(target);
  });
  
  // 位置系単位選択変更
  obj.find('.form-background-position-selunit').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // シミュレーション更新
      updateBackgroundSimulation(target);
    });
  });
  
  // 既存色設定部分を初期化
  obj.find('.form-background-gradient-color').each(function(){
    initFormBackgroundGradientColor($(this));
  });
}


/* 
 * レスポンシブ対応部分本体(背景層端末別編集部分)を初期化
 * params 
 *   obj : 対象背景層端末別編集部分
 */
const initFormBackgroundResponsiveArea = function(obj) {
  // 編集対象識別キーを定義
  var target = obj.closest('.form-block').data('target');
  
  // 背景層タイプを選択
  obj.find('.form-background-seltype').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // 背景層のnameキーを取得
      var key = target + '__style__background__' + obj.closest('.form-background-layer').data('layerid');
      var device = $('.header-sim-device.checked').data('device');
      if(obj.closest('.form-responsive').find('.form-responsive-chkdevice-check.chkdevice-check-' + device).prop('checked')) {
        key += '__' + device;
      } else if(obj.closest('.form-responsive').find('.form-responsive-chkflag-check').prop('checked')) {
        key += '__' + device;
      } else {
        key += '__pc';
      }
      
      // 背景層編集部分を作成
      var content = obj.find('.form-background-content');
      content.slideUp(function(){
        // 背景層各タイプ部分HTML作成
        var type = select.val();
        if(type == 'solid') {
          // 純色背景編集部分を作成
          var html = htmlFormBackgroundSolid(key, {});
          content.html(html);
          initFormBackgroundSolid(obj.find('.form-background-solid'));
        } else if(type == 'picture') {
          // 画像背景編集部分を作成
          var html = htmlFormBackgroundPicture(key, {});
          content.html(html);
          initFormBackgroundPicture(obj.find('.form-background-picture'));
        } else if(type == 'gradient') {
          // 変色背景編集部分を作成
          var html = htmlFormBackgroundGradient(key, {});
          content.html(html);
          initFormBackgroundGradient(obj.find('.form-background-gradient'));
        }
        
        // 背景層編集部分を表示
        content.slideDown();
      });
    });
  });
  
  // 既存背景層編集部分を初期化
  obj.find('.form-background-solid').each(function(){
    // 純色背景層編集部分を初期化
    initFormBackgroundSolid($(this));
  });
  obj.find('.form-background-picture').each(function(){
    // 画像背景層編集部分を初期化
    initFormBackgroundPicture($(this));
  });
  obj.find('.form-background-gradient').each(function(){
    // 変色背景層編集部分を初期化
    initFormBackgroundGradient($(this));
  });
}


/* 
 * 背景レスポンシブ対応部分を初期化
 * params 
 *   obj : 対象背景レスポンシブ対応部分
 */
const initFormBackgroundResponsive = function(obj) {
  // 編集対象識別キーを定義
  var target = obj.closest('.form-block').data('target');
  
  // PC/SPのみ表示の選択を変更
  obj.find('.form-responsive-chkdevice').on('click', function(){
    var checkbox = $(this);
    clickCheckbox(checkbox, function(){
      // 必要変数取得
      var check = checkbox.find('.form-responsive-chkdevice-check');
      var flag = obj.find('.form-responsive-chkflag');
      var device = 'pc';
      var other = 'sp';
      if(checkbox.hasClass('setting-sp')) {
        device = 'sp';
        other = 'pc';
      }
      
      if(check.prop('checked')) {
        // デバイスがPC/SPの場合のみ設定部分の背景層を表示する
        obj.closest('.form-responsive-target').addClass('setting-' + device).addClass('active');
        
        // レスポンシブ対応ボタンがONの場合、不要な設定部分を削除する、対象の設定部分の表示制限を外す
        if(flag.find('.form-responsive-chkflag-check').prop('checked')) {
          obj.find('.form-responsive-area.setting-' + other).remove();
          obj.find('.form-responsive-area').removeClass('setting-pc').removeClass('setting-sp').removeClass('active');
        }
        
        // PCのみなら入力のnameの「__sp」を「__pc」に、SPのみなら入力のnameの「__pc」を「__sp」にする
        obj.find('.form-responsive-area').find('input, select').each(function(){
          $(this).prop('name', $(this).prop('name').replace('__' + other + '__', '__' + device + '__'));
        });
        
        // レスポンシブ対応ボタン部分を非表示
        flag.slideUp(function(){
          // シミュレーションを更新
          updateBackgroundSimulation(target);
          
          // レスポンシブ対応ボタンをOFFにする
          flag.removeClass('checked');
          flag.find('.form-responsive-chkflag-check').prop('checked', false);
        });
      } else {
        // デバイスがどちらでも設定部分の背景層を表示する
        obj.closest('.form-responsive-target').removeClass('setting-pc').removeClass('setting-sp').removeClass('active');
        
        // 入力のnameの「__sp」を「__pc」にする
        obj.find('.form-responsive-area').find('input, select').each(function(){
          $(this).prop('name', $(this).prop('name').replace('__sp__', '__pc__'));
        });
        
        // レスポンシブ対応ボタン部分を表示
        flag.slideDown(function() {
          // シミュレーションを更新
          updateBackgroundSimulation(target);
        });
      }
    });
  });
}


/* 
 * 背景層編集部分を初期化
 * params 
 *   obj : 対象背景層編集部分
 */
const initFormBackgroundLayer = function(obj) {
  // 編集対象識別キーを定義
  var target = obj.closest('.form-block').data('target');
  
  // 背景層スライドボタンをクリック
  obj.find('.form-background-btnslide').on('click', function(){
    var button = $(this);
    clickButton(button, function(){
      var body = obj.find('.form-background-body');
      
      // 背景層をスライド
      if(button.hasClass('checked')) {
        button.removeClass('checked');
        body.slideDown();
      } else {
        button.addClass('checked');
        body.slideUp();
      }
    });
  });
  
  // 背景層削除ボタンをクリック
  obj.find('.form-background-btndelete').on('click', function(){
    var button = $(this);
    clickButton(button, function(){
      // 背景層を削除
      var layerlist = obj.closest('.form-background-layerlist');
      var layerid = obj.data('layerid');
      
      obj.slideUp(function(){
        obj.remove();
        updateBackgroundLayerIndex(layerlist.find('.form-background-layer'));
        updateBackgroundSimulation(target);
      });
    });
  });
  
  // レスポンシブ対応を有効化
  obj.find('.form-responsive').each(function(){
    initFormResponsive($(this), initFormBackgroundResponsiveArea);
    initFormBackgroundResponsive($(this));
  });
}


/* 
 * 背景編集部分を初期化
 * params 
 *   obj : 対象背景編集部分
 */
const initFormBackground = function(obj) {
  // 編集対象識別キーを定義
  var target = obj.closest('.form-block').data('target');
  
  // 背景層追加ボタンをクリック
  obj.find('.form-background-btninsert').on('click', function(){
    var button = $(this);
    clickButton(button, function(){
      // 背景層HTML作成
      var lastid = parseInt(obj.data('lastid'));
      var html = htmlFormBackgroundLayer(target + '__style__background', lastid, {}, true);
      obj.find('.form-background-layerlist').prepend(html);
      var layer = obj.find('.form-background-layer').first();
      
      // 背景ブロック動作を有効化
      initFormBackgroundLayer(layer);
      
      // 背景編集部分lastid更新
      obj.data('lastid', (lastid + 1).toString());
      
      // 背景層index更新
      updateBackgroundLayerIndex(obj.find('.form-background-layer'));
      
      // 背景層を表示
      layer.slideDown();
    });
  });
  
  // 背景層をドラッグで並び替え
  obj.find('.form-background-layerlist').sortable({
    handle: '.form-background-btnsort',
    stop: function(e, ui){
      updateBackgroundLayerIndex(obj.find('.form-background-layer'));
      updateBackgroundSimulation(target);
    },
  });
  
  // 既存背景層を初期化
  obj.find('.form-background-layer').each(function(){
    initFormBackgroundLayer($(this));
  });
  
  // 背景層index初期化
  updateBackgroundLayerIndex(obj.find('.form-background-layer'));
  
  // 既存背景情報でシミュレーション初期化
  updateBackgroundSimulation(target);
}


/* 
 * 純色背景編集部分HTMLを構築
 * params 
 *   layer_key : 背景層端末別キー([block_key]__style__background__[layer_index]__[device])
 *   style : 背景層スタイル情報
 * return 純色背景編集部分HTML
 */
const htmlFormBackgroundSolid = function(layer_key, style) {
  var html = `
    <div class="form-background-solid">
      <p class="form-background-solid-title">` + translations.color_and_opacity + `</p>
      ` + htmlFormColor('form-background-solid-line', layer_key, style) + `
    </div>
  `;
  
  return html;
}


/* 
 * 画像背景編集部分HTMLを構築
 * params 
 *   layer_key : 背景層端末別キー([block_key]__style__background__[layer_index]__[device])
 *   style : 背景層スタイル情報
 * return 画像背景編集部分HTML
 */
const htmlFormBackgroundPicture = function(layer_key, style) {
  // 準備として必要変数を取得
  var position = getStyleValue(style, ['position'], '');
  var unset = getStyleValue(style, ['unset'], '1');
  var target = layer_key.split('__style__background__')[0];
  
  var proportion = true;
  var width = 0;
  var width_unit = '';
  var height = 0;
  var height_unit = '';
  if(unset == '0') {
    proportion = getStyleValue(style, ['proportion'], '1');
    if(proportion == '0') {
      width = getStyleValue(style, ['width'], 0);
      width_unit = getStyleValue(style, ['width_unit'], '');
      height = getStyleValue(style, ['height'], 0);
      height_unit = getStyleValue(style, ['height_unit'], '');
    }
  }
  
  // HTML文構築
  var html = `
    <div class="form-background-picture">
      ` + hmtlFormUpload('', layer_key + '__image', getStyleValue(style, ['image'], ''), function(){ updateBackgroundSimulation(target); }) + `
      ` + htmlCheckbox('form-background-chkrepeat', layer_key + '__repeat', translations.background_repeat, getStyleValue(style, ['repeat'], '0')) + `
      <div class="form-background-position">
        <p class="form-background-position-title">` + translations.background_position + `</p>
        <p class="form-background-position-position">
          ` + htmlSelect('form-background-position-selposition', layer_key + '__position', position, background_position_options) + `
        </p>
        <div class="form-background-position-detail" ` + ((position == 'custom') ? '' : 'style="display: none;"') + `>
          <div class="form-background-position-line">
            <p class="form-background-position-key">
              ` + htmlSelect('form-background-position-selfrom from-y', layer_key + '__from_y', getStyleValue(style, ['from_y'], ''), background_from_y_options) + `
            </p>
            ` + htmlNumberInput('form-background-position', layer_key + '__distance_y', getStyleValue(style, ['distance_y'], 0), 
                                { 'input_class':'distance-y', 'number_class':'form-background-position-distance' }) + `
            ` + htmlUnitSelect('form-background-position', layer_key + '__distance_y_uit', getStyleValue(style, ['distance_y_uit'], ''), {'select_class':'unit-y'}) + `
          </div>
          <div class="form-background-position-line">
            <p class="form-background-position-key">
              ` + htmlSelect('form-background-position-selfrom from-x', layer_key + '__from_x', getStyleValue(style, ['from_x'], ''), background_from_x_options) + `
            </p>
            ` + htmlNumberInput('form-background-position', layer_key + '__distance_x', getStyleValue(style, ['distance_x'], 0), 
                                { 'input_class':'distance-x', 'number_class':'form-background-position-distance' }) + `
            ` + htmlUnitSelect('form-background-position', layer_key + '__distance_x_unit', getStyleValue(style, ['distance_x_unit'], ''), {'select_class':'unit-x'}) + `
          </div>
        </div>
      </div>
      <div class="form-background-size">
        <p class="form-background-size-title">` + translations.background_size + `</p>
        <div class="form-background-size-unset">
          ` + htmlCheckbox('form-background-size-chkunset', layer_key + '__unset', translations.original_size, unset) + `
        </div>
        <div class="form-background-size-setting" ` + (unset == '1' ? 'style="display: none;"' : '') + `>
          <div class="form-background-size-proportion">
            ` + htmlCheckbox('form-background-size-chkproportion', layer_key + '__proportion', translations.keep_proportion, proportion) + `
          </div>
          <div class="form-background-size-size">
            <div class="form-background-size-line line-width">
              <p class="form-background-size-key">` + translations.width + `</p>
              ` + htmlNumberInput('form-background-size', layer_key + '__width', width, { 'input_class':'value-w', 'number_class':'form-background-size-value', 'min':0 }) + `
              ` + htmlUnitSelect('form-background-size', layer_key + '__width_unit', width_unit, {'select_class':'unit-w'}) + `
            </div>
            <div class="form-background-size-line line-height" ` + (proportion == '1' ? 'style="display: none;"' : '') + `>
              <p class="form-background-size-key">` + translations.height + `</p>
              ` + htmlNumberInput('form-background-size', layer_key + '__height', height, { 'input_class':'value-h', 'number_class':'form-background-size-value', 'min':0 }) + `
              ` + htmlUnitSelect('form-background-size', layer_key + '__height_unit', height_unit, {'select_class':'unit-h'}) + `
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
  
  return html;
}


/* 
 * 変色背景色編集部分HTMLを構築
 * params 
 *   layer_key : 背景層端末別キー([block_key]__style__background__[layer_index]__[device])
 *   color_index : 色番号
 *   style : 色スタイル情報
 * return 変色背景色編集部分HTML
 */
const htmlFormBackgroundGradientColor = function(layer_key, color_index, style) {
  // 準備として必要変数を取得
  var color_key = layer_key + '__colors__' + color_index;
  var checked_str = '';
  if(getStyleValue(style, ['transparent'], true)) {
    checked_str = 'checked';
  }
  
  // HTML文構築
  html = `
    <div class="form-background-gradient-color" data-colorid="` + color_index + `">
      <div class="form-background-gradient-color-header">
        <p class="form-background-gradient-color-btnsort"></p>
        ` + htmlFormColorShowareaWithouCheck('form-background-gradient-color', checked_str) + `
        <p class="form-background-gradient-color-btnslide"></p>
        <p class="form-background-gradient-color-btndelete"></p>
      </div>
      <div class="form-background-gradient-color-body">
        <p class="form-background-gradient-color-title">` + translations.color_and_opacity + `</p>
        ` + htmlFormColor('form-background-gradient-color-line', color_key, style) + `
        <p class="form-background-gradient-color-title">` + translations.gradient_size + `</p>
        <div class="form-background-gradient-color-line">
          ` + htmlNumberInput('form-background-gradient-color-size', color_key + '__size', getStyleValue(style, ['size'], 0), 
                              { 'number_class':'form-background-gradient-color-size', 'min':0 }) + `
          ` + htmlUnitSelect('form-background-gradient-color-size', color_key + '__unit', getStyleValue(style, ['unit'], '')) + `
          <p class="form-background-gradient-color-size-percent">%</p>
        </div>
      </div>
      <input type="hidden" class="form-background-gradient-index" name="` + color_key + `__index" />
    </div>
  `;
  
  return html;
}


/* 
 * 変色背景変色タイプラジオボタンHTMLを構築
 * params 
 *   layer_key : 背景層端末別キー([block_key]__style__background__[layer_index]__[device])
 *   value : 変色タイプ値
 * return 変色背景変色タイプラジオボタンHTML
 */
const htmlFormBackgroundGradientType = function(layer_key, value) {
  var html = '<div class="form-background-gradient-type">';
  $.each(gradient_type_options, function(option_value, option_text){
    var checked_str = '';
    if(option_value == value) {
      checked_str = 'checked';
    }
    
    html += `
      <div class="form-background-gradient-rdotype ` + checked_str + `">
        <p class="form-background-gradient-rdotype-preview preview-` + option_value + `"></p>
        <p class="form-background-gradient-rdotype-title">` + option_text + `</p>
        <input type="radio" class="form-background-gradient-rdotype-radio" name="` + layer_key + `__gradient_type" value="` + option_value + `" ` + checked_str + ` />
      </div>
    `;
  });
  html += '</div>';
  
  return html;
}


/* 
 * 変色背景編集部分HTMLを構築
 * params 
 *   layer_key : 背景層端末別キー([block_key]__style__background__[layer_index]__[device])
 *   style : 背景層スタイル情報
 * return 変色背景編集部分HTML
 */
const htmlFormBackgroundGradient = function(layer_key, style) {
  // 準備として必要変数を取得
  var colors = (checkDirectionKey('colors', style) && $.isArray(style['colors'])) ? style['colors'] : {};
  var type = getStyleValue(style, ['gradient_type'], 'linear');
  
  var direction = '';
  var rotate = 0;
  var shape = '';
  var center = '';
  var center_from_y = '';
  var center_distance_y = 0;
  var center_distance_y_unit = '';
  var center_from_x = '';
  var center_distance_x = 0;
  var center_distance_x_unit = '';
  if(type == 'linear') {
    direction = getStyleValue(style, ['direction'], '');
    if(direction == 'rotate') {
      rotate = getStyleValue(style, ['rotate'], 0);
    }
  } else {
    if(type == 'radial') {
      shape = getStyleValue(style, ['shape'], '');
    }
    center = getStyleValue(style, ['center'], '');
    if(center == 'customer') {
      center_from_y = getStyleValue(style, ['center_from_y'], '');
      center_distance_y = getStyleValue(style, ['center_distance_y'], 0);
      center_distance_y_unit = getStyleValue(style, ['center_distance_y_unit'], '');
      center_from_x = getStyleValue(style, ['center_from_x'], '');
      center_distance_x = getStyleValue(style, ['center_distance_x'], 0);
      center_distance_x_unit = getStyleValue(style, ['center_distance_x_unit'], '');
    }
  }
  
  var unset = getStyleValue(style, ['unset'], '1');
  var width = 0;
  var width_unit = '';
  var height = 0;
  var height_unit = '';
  var repeat = '0';
  var position = '';
  var from_y = '';
  var distance_y = 0;
  var distance_y_unit = '';
  var from_x = '';
  var distance_x = 0;
  var distance_x_unit = '';
  if(unset == '1') {
    width = getStyleValue(style, ['width'], 0);
    width_unit = getStyleValue(style, ['width_unit'], '');
    height = getStyleValue(style, ['height'], 0);
    height_unit = getStyleValue(style, ['height_unit'], '');
    repeat = getStyleValue(style, ['repeat'], '0');
    position = getStyleValue(style, ['position'], '');
    if(position == 'custom') {
      from_y = getStyleValue(style, ['from_y'], '');
      distance_y = getStyleValue(style, ['distance_y'], 0);
      distance_y_unit = getStyleValue(style, ['distance_y_unit'], '');
      from_x = getStyleValue(style, ['from_x'], '');
      distance_x = getStyleValue(style, ['distance_x'], 0);
      distance_x_unit = getStyleValue(style, ['distance_x_unit'], '');
    }
  }
  
  // HTML文構築
  var html = `
    <div class="form-background-gradient" data-index="` + Object.keys(colors).length + `">
      <div class="form-background-gradient-list">
  `;
  
  $.each(colors, function(index, color){
    html += htmlFormBackgroundGradientColor(layer_key, index, color);
  });
  
  html += `
      </div>
      <p class="form-background-gradient-button">` + translations.gradient_add + `</p>
      ` + htmlFormBackgroundGradientType(layer_key, type) + `
      ` + htmlCheckbox('form-background-gradient-chkrepeat', layer_key + '__gradient_repeat', translations.gradient_repeat, getStyleValue(style, ['gradient_repeat'], '0')) + `
      <div class="form-background-gradient-option">
        <p class="form-background-gradient-direction" ` + (type != 'linear' ? 'style="display: none;"' : '') + `>
          ` + htmlSelect('form-background-gradient-seldirection', layer_key + '__direction', direction, gradient_direction_options) + `
        </p>
        <div class="form-background-gradient-rotate" ` + ((type != 'linear' || direction != 'rotate') ? 'style="display: none;"' : '') + `>
          <div class="form-background-gradient-rotate-inner">
            <p class="form-background-gradient-rotate-title">` + translations.gradient_rotate + `</p>
            <input class="form-background-gradient-txtrotate" type="number" name="` + layer_key + `__rotate" value="` + rotate + `" />
            <p class="form-background-gradient-rotate-sim" style="transform: rotate(` + rotate + `deg);"></p>
          </div>
        </div>
        <p class="form-background-gradient-shape" ` + (type != 'radial' ? 'style="display: none;"' : '') + `>
          ` + htmlSelect('form-background-gradient-selshape', layer_key + '__shape', shape, gradient_shape_options) + `
        </p>
        <div class="form-background-position form-background-gradient-center" ` + ((type != 'radial' && type != 'conic') ? 'style="display: none;"' : '') + `>
          <p class="form-background-position-title">` + translations.gradient_center + `</p>
          <p class="form-background-position-position">
            ` + htmlSelect('form-background-gradient-selcenter', layer_key + '__center', center, background_position_options) + `
          </p>
          <div class="form-background-position-detail form-background-gradient-center-detail" ` + (center != 'custom' ? 'style="display: none;"' : '') + `>
            <div class="form-background-position-line">
              <p class="form-background-position-key">
                ` + htmlSelect('form-background-position-selfrom center-from-y', layer_key + '__center_from_y', center_from_y, background_from_y_options) + `
              </p>
              ` + htmlNumberInput('form-background-position', layer_key + '__center_distance_y', center_distance_y, 
                                  { 'input_class':'center-distance-y', 'number_class':'form-background-position-distance', 'min':0 }) + `
              ` + htmlUnitSelect('form-background-position', layer_key + '__center_distance_y_unit', getStyleValue(style, ['center_distance_y_unit'], ''), 
                                 {'select_class':'center_distance_y-unit'}) + `
            </div>
            <div class="form-background-position-line">
              <p class="form-background-position-key">
                ` + htmlSelect('form-background-position-selfrom center-from-x', layer_key + '__center_from_x', center_from_x, background_from_x_options) + `
              </p>
              ` + htmlNumberInput('form-background-position', layer_key + '__center_distance_x', center_distance_x, 
                                  { 'input_class':'center-distance-x', 'number_class':'form-background-position-distance', 'min':0 }) + `
              ` + htmlUnitSelect('form-background-position', layer_key + '__center_distance_x_unit', getStyleValue(style, ['center_distance_x_unit'], ''), 
                                 {'select_class':'center_distance_x-unit'}) + `
            </div>
          </div>
        </div>
      </div>
      <div class="form-background-size">
        <p class="form-background-size-title">` + translations.background_size + `</p>
        <div class="form-background-size-unset">
          ` + htmlCheckbox('form-background-size-chkunset', layer_key + '__unset', translations.background_full_size, unset) + `
        </div>
        <div class="form-background-size-setting" ` + (unset ? 'style="display: none;"' : '') + `>
          <div class="form-background-size-size">
            <div class="form-background-size-line line-width">
              <p class="form-background-size-key">` + translations.width + `</p>
              ` + htmlNumberInput('form-background-size', layer_key + '__width', width, { 'input_class':'value-w', 'number_class':'form-background-size-value', 'min':0 }) + `
              ` + htmlUnitSelect('form-background-size', layer_key + '__width_unit', width_unit, {'select_class':'unit-w'}) + `
            </div>
            <div class="form-background-size-line line-height">
              <p class="form-background-size-key">` + translations.height + `</p>
              ` + htmlNumberInput('form-background-size', layer_key + '__height', height, { 'input_class':'value-h', 'number_class':'form-background-size-value', 'min':0 }) + `
              ` + htmlUnitSelect('form-background-size', layer_key + '__height_unit', height_unit, {'select_class':'unit-h'}) + `
            </div>
          </div>
          ` + htmlCheckbox('form-background-chkrepeat', layer_key + '__repeat', translations.background_repeat, repeat) + `
          <div class="form-background-position">
            <p class="form-background-position-title">` + translations.background_position + `</p>
            <p class="form-background-position-position">
              ` + htmlSelect('form-background-position-selposition', layer_key + '__position', position, background_position_options) + `
            </p>
            <div class="form-background-position-detail" ` + (position != 'custom' ? 'style="display: none;"' : '') + `>
              <div class="form-background-position-line">
                <p class="form-background-position-key">
                  ` + htmlSelect('form-background-position-selfrom from-y', layer_key + '__from_y', from_y, background_from_y_options) + `
                </p>
                ` + htmlNumberInput('form-background-position', layer_key + '__distance_y', getStyleValue(style, ['distance_y'], 0), 
                                    { 'input_class':'distance-y', 'number_class':'form-background-position-distance' }) + `
                ` + htmlUnitSelect('form-background-position', layer_key + '__distance_y_uit', getStyleValue(style, ['distance_y_uit'], ''), {'select_class':'unit-y'}) + `
              </div>
              <div class="form-background-position-line">
                <p class="form-background-position-key">
                  ` + htmlSelect('form-background-position-selfrom from-x', layer_key + '__from_x', from_x, background_from_x_options) + `
                </p>
                ` + htmlNumberInput('form-background-position', layer_key + '__distance_x', getStyleValue(style, ['distance_x'], 0), 
                                    { 'input_class':'distance-x', 'number_class':'form-background-position-distance' }) + `
                ` + htmlUnitSelect('form-background-position', layer_key + '__distance_x_uit', getStyleValue(style, ['distance_x_uit'], ''), {'select_class':'unit-x'}) + `
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
  
  return html;
}


/* 
 * 背景層端末別編集部分HTMLを構築
 * params 
 *   base_key : 背景層キー([block_key]__style__background__[layer_index])
 *   options : 構築パラメータ
 *     device : 構築端末(指定しない場合はレスポンシブ対応なしで、pcになる)
 *     style : スタイル情報
 * return 背景層端末別編集部分HTML
 */
const htmlFormBackgroundResponsiveAreaInner = function(base_key, options) {
  // 背景層端末別キー取得
  var device = checkDirectionKey('device', options) ? options['device'] : 'pc';
  var layer_key = base_key + '__' + device;
  
  // 背景層スタイル情報を取得
  var style = (checkDirectionKey('style', options) && $.isPlainObject(options['style'])) ? options['style'] : {};
  
  // 背景タイプによって編集本体部分HTMLを構築
  var type = getStyleValue(style, ['type'], '');
  var form_background_content = '';
  var display_content_str = 'style="display:none;"';
  if(type == 'solid') {
    form_background_content += htmlFormBackgroundSolid(layer_key, style);
    display_content_str = '';
  } else if(type == 'picture') {
    form_background_content += htmlFormBackgroundPicture(layer_key, style);
    display_content_str = '';
  } else if(type == 'gradient') {
    form_background_content += htmlFormBackgroundGradient(layer_key, style);
    display_content_str = '';
  }
  
  // HTMLを構築
  var html = `
    <p class="form-background-type">
      ` + htmlSelect('form-background-seltype', layer_key + '__type', type, background_type_options, {'hidden':translations.background_type_ph}) + `
    </p>
    <div class="form-background-content" ` + display_content_str + `>
      ` + form_background_content + `
    </div>
  `;
  
  return html;
}


/* 
 * 背景層HTMLを構築
 * params 
 *   base_key : 背景層ベースキー([block_key]__style__background)
 *   layer_index : 背景層番号
 *   style : 背景層スタイル情報
 *   hidden : 非表示フラグ(新規追加する際最初は非表示)
 * return 背景層HTML
 */
const htmlFormBackgroundLayer = function(base_key, layer_index, style, hidden=false) {
  // 背景層キーを取得
  var layer_key = base_key + '__' + layer_index;
  
  // 非表示部分を取得
  var display_str = '';
  if(hidden) {
    display_str = 'style="display: none;"';
  }
  
  // HTMLを構築
  var html = `
    <div class="form-background-layer form-responsive-target" data-layerid="` + layer_index + `" ` + display_str + `>
      <div class="form-background-header">
        <p class="form-background-btnsort"></p>
        <p class="form-background-name">
          <input type="text" name="` + layer_key + `__name" placeholder="` + translations.background_layer_name_ph + `" 
              value="` + getStyleValue(style, ['name'], translations.background_layer + (layer_index + 1).toString()) + `" />
        </p>
        <p class="form-background-btnslide"></p>
        <p class="form-background-btndelete"></p>
      </div>
      ` + htmlFormResponsive(layer_key, 'form-background-body', htmlFormBackgroundResponsiveAreaInner, true, true, { 'style':style }) + `
      <input type="hidden" class="form-background-index" name="` + layer_key + `__index" value="" />
    </div>
  `;
  
  return html;
}


/* 
 * 背景編集部分HTMLを構築
 * params 
 *   block_key : ブロック識別キー
 *   options : 構築パラメータ
 *     style : スタイル情報
 * return 背景編集部分HTML
 */
const htmlFormBackground = function(block_key, options) {
  var base_key = block_key + '__style__background';
  var style = (checkDirectionKey('style', options) && $.isArray(options['style'])) ? options['style'] : [];
  
  var html = `
    <div class="form-line">
      <p class="form-title">` + translations.background + `</p>
      <div class="form-input form-background" data-lastid="` + Object.keys(style).length + `">
        <p class="form-background-btninsert">` + translations.background_layer_add + `</p>
        <div class="form-background-layerlist">
  `;
  
  if(style.length) {
    $.each(style, function(index, layer_style){
      html += htmlFormBackgroundLayer(base_key, index, layer_style);
    });
  }
  
  html += `
        </div>
      </div>
    </div>
  `;
  
  return html;
}
