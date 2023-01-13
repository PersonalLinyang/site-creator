// 位置タイプ選択肢
const position_type_options = {
  'relative':translations.position_initial, 
  'absolute':translations.position_absolute, 
  'fixed':translations.position_fixed, 
}

// 幅タイプ選択肢
const position_width_type_options = {
  'auto':translations.width_auto, 
  'content':translations.width_content, 
  'relative':translations.width_relative, 
  'custom':translations.width_custom, 
}

// 高さタイプ選択肢
const position_height_type_options = {
  'auto':translations.height_auto, 
  'content':translations.height_content, 
  'relative':translations.height_relative, 
  'custom':translations.height_custom, 
}


const position_radio_options = {
  'horizontal':{
    'left': translations.position_left,
    'center': translations.position_center,
    'right': translations.position_right,
  }, 
  'vertical':{
    'top': translations.position_top,
    'center': translations.position_center,
    'bottom': translations.position_bottom,
  }, 
}


/* 
 * 最小/最大値のCSS情報を取得
 * params 
 *   area : 位置端末別編集部分
 * return : CSS情報配列
 */
const getPositionLimitInfo = function(area) {
  var attr_key_list = ['width', 'height'];
  var type_key_list = ['min', 'max'];
  var css_list = {}
  
  $.each(attr_key_list, function(index_attr, attr_key) {
    $.each(type_key_list, function(index_type, type_key) {
      if(type_key == 'min') {
        css_list[type_key + '-' + attr_key] = 'auto';
      } else {
        css_list[type_key + '-' + attr_key] = 'none';
      }
      
      var flag = area.find('.form-position-chklimitflag-check.check-' + attr_key + '-' + type_key).prop('checked');
      if(flag) {
        var number = area.find('.form-position-limit-txtnumber.number-' + attr_key + '-' + type_key).val();
        var unit = area.find('.form-position-limit-selunit.unit-' + attr_key + '-' + type_key).val();
        css_list[type_key + '-' + attr_key] = getValueWithUnit(number, unit);
      }
    });
  });
  
  return css_list;
}


/* 
 * 位置調整のCSS情報を取得
 * params 
 *   area : 位置端末別編集部分
 * return : CSS情報配列
 */
const getPositionMarginInfo = function(area) {
  var key_list = ['top', 'left'];
  var css_list = {}
  
  $.each(key_list, function(index, key) {
    var margin = area.find('.form-position-margin-txtnumber.number-margin-' + key).val();
    var margin_unit = area.find('.form-position-margin-selunit.unit-margin-' + key).val();
    css_list['margin-' + key] = getValueWithUnit(margin, margin_unit);
  });
  
  return css_list;
}


/* 
 * 位置の他項目CSS情報を取得
 * params 
 *   area : 位置端末別編集部分
 * return : CSS情報配列
 */
const getPositionSimInfo = function(area) {
  var position = area.find('.form-position-seltype').val();
  var widthtype = area.find('.form-position-selwidthtype').val();
  var horizontal = area.find('.form-position-rdohorizontal-radio:checked').val();
  var heighttype = area.find('.form-position-selheighttype').val();
  var vertical = area.find('.form-position-rdovertical-radio:checked').val();
  
  var css_list = {
    'position' : position,
    'top' : 'auto',
    'bottom' : 'auto',
    'left' : 'auto',
    'right' : 'auto',
    'width' : 'auto',
    'height' : 'auto',
    'transform' : {
      'translateX' : '0',
      'translateY' : '0',
    },
  }
  
  if(widthtype == 'relative') {
    var left = area.find('.form-position-relative-txtnumber.number-left').val();
    var left_unit = area.find('.form-position-relative-selunit.unit-left').val();
    var right = area.find('.form-position-relative-txtnumber.number-right').val();
    var right_unit = area.find('.form-position-relative-selunit.unit-right').val();
    var str_left = getValueWithUnit(left, left_unit);
    var str_right = getValueWithUnit(right, right_unit);
    
    css_list['width'] = 'calc(100% - ' + str_left + ' - ' + str_right + ')';
    
    if(horizontal == 'right') {
      css_list['left'] = 'calc(100% - ' + str_right + ')';
      css_list['transform']['translateX'] = '-100%';
    } else if(horizontal == 'center') {
      //css_list['left'] = 'calc((100% - ' + str_left + ') / 2)';
      css_list['left'] = 'calc((100% - ' + str_right + ' + ' + str_left + ') / 2)';
      css_list['transform']['translateX'] = '-50%';
    } else {
      css_list['left'] = str_left;
    }
  } else {
    if(widthtype == 'custom') {
      var width = area.find('.form-position-custom-txtnumber.number-width').val();
      var width_unit = area.find('.form-position-custom-selunit.unit-width').val();
      
      css_list['width'] = getValueWithUnit(width, width_unit);
    } else if(widthtype == 'content') {
      css_list['width'] = 'fit-content';
    }
    
    if(horizontal == 'right') {
      css_list['left'] = '100%';
      css_list['transform']['translateX'] = '-100%';
    } else if(horizontal == 'center') {
      css_list['left'] = '50%';
      css_list['transform']['translateX'] = '-50%';
    } else {
      css_list['left'] = '0';
      css_list['transform']['translateX'] = '0';
    }
  }
  
  if(heighttype == 'relative') {
    var top = area.find('.form-position-relative-txtnumber.number-top').val();
    var top_unit = area.find('.form-position-relative-selunit.unit-top').val();
    var bottom = area.find('.form-position-relative-txtnumber.number-bottom').val();
    var bottom_unit = area.find('.form-position-relative-selunit.unit-bottom').val();
    var str_top = getValueWithUnit(top, top_unit);
    var str_bottom = getValueWithUnit(bottom, bottom_unit);
    
    css_list['height'] = 'calc(100% - ' + str_top + ' - ' + str_bottom + ')';
    
    if(vertical == 'bottom') {
      css_list['bottom'] = str_bottom;
    } else if(vertical == 'center') {
      css_list['top'] = 'calc(50% - ' + str_top + ')';
      css_list['transform']['translateY'] = '-50%';
    } else {
      css_list['top'] = str_top;
    }
  } else {
    if(heighttype == 'custom') {
      var height = area.find('.form-position-custom-txtnumber.number-height').val();
      var height_unit = area.find('.form-position-custom-selunit.unit-height').val();
      
      css_list['height'] = getValueWithUnit(height, height_unit);
    } else if(heighttype == 'content') {
      css_list['height'] = 'fit-content';
    }
    
    if(vertical == 'bottom') {
      css_list['top'] = '100%';
      css_list['transform']['translateY'] = '-100%';
    } else if(vertical == 'center') {
      css_list['top'] = '50%';
      css_list['transform']['translateY'] = '-50%';
    } else {
      css_list['top'] = '0';
      css_list['transform']['translateY'] = '0';
    }
  }
  
  return css_list;
}


/* 
 * レスポンシブ対応部分本体(位置端末別編集部分)を初期化
 * params 
 *   obj : 位置端末別編集部分
 */
const initFormPositionResponsiveArea = function(obj) {
  // 位置編集部分を取得
  var setting = obj.closest('.form-position');
  
  // 位置タイプ選択変更
  obj.find('.form-position-seltype').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // シミュレーション更新
      updateSimulation(setting, getPositionSimInfo);
    });
  });
  
  // 最小/最大値ありをクリック
  obj.find('.form-position-chklimitflag').on('click', function(){
    var checkbox = $(this);
    clickCheckbox(checkbox, function(){
      var check = checkbox.find('.form-position-chklimitflag-check');
      
      // 相応最小/最大値編集部分を取得
      var limit_line = null;
      if(check.hasClass('check-width-min')) {
        limit_line = obj.find('.form-position-limit-line.limit-width-min');
      } else if(check.hasClass('check-width-max')) {
        limit_line = obj.find('.form-position-limit-line.limit-width-max');
      } else if(check.hasClass('check-height-min')) {
        limit_line = obj.find('.form-position-limit-line.limit-height-min');
      } else if(check.hasClass('check-height-max')) {
        limit_line = obj.find('.form-position-limit-line.limit-height-max');
      }
      
      if(limit_line) {
        if(check.prop('checked')) {
          // 最小/最大値編集部分を表示
          limit_line.slideDown();
        } else {
          // 最小/最大値編集部分を非表示
          limit_line.slideUp();
        }
      }
      
      // シミュレーション更新
      updateSimulation(setting, getPositionLimitInfo);
    });
  });
  
  // 幅タイプ選択変更
  obj.find('.form-position-selwidthtype').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      var widthtype = select.val();
      
      // 幅タイプによって該当幅編集部分を表示
      if(widthtype == 'relative') {
        obj.find('.form-position-relative.relative-width').slideDown();
        obj.find('.form-position-custom.custom-width').slideUp();
      } else if(widthtype == 'custom') {
        obj.find('.form-position-relative.relative-width').slideUp();
        obj.find('.form-position-custom.custom-width').slideDown();
      } else {
        obj.find('.form-position-relative.relative-width').slideUp();
        obj.find('.form-position-custom.custom-width').slideUp();
      }
      
      // シミュレーション更新
      updateSimulation(setting, getPositionSimInfo);
    });
  });
  
  // 高さタイプ選択変更
  obj.find('.form-position-selheighttype').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      var heighttype = select.val();
      
      // 高さタイプによって該当高さ編集部分を表示
      if(heighttype == 'relative') {
        obj.find('.form-position-relative.relative-height').slideDown();
        obj.find('.form-position-custom.custom-height').slideUp();
      } else if(heighttype == 'custom') {
        obj.find('.form-position-relative.relative-height').slideUp();
        obj.find('.form-position-custom.custom-height').slideDown();
      } else {
        obj.find('.form-position-relative.relative-height').slideUp();
        obj.find('.form-position-custom.custom-height').slideUp();
      }
      
      // シミュレーション更新
      updateSimulation(setting, getPositionSimInfo);
    });
  });
  
  // 相対幅/高さ数値入力変更
  obj.find('.form-position-relative-txtnumber').on('keyup change', function(){
    // シミュレーション更新
    updateSimulation(setting, getPositionSimInfo);
  });
  
  // 相対幅/高さ単位選択変更
  obj.find('.form-position-relative-selunit').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // シミュレーション更新
      updateSimulation(setting, getPositionSimInfo);
    });
  });
  
  // 固定幅/高さ数値入力変更
  obj.find('.form-position-custom-txtnumber').on('keyup change', function(){
    // シミュレーション更新
    updateSimulation(setting, getPositionSimInfo);
  });
  
  // 固定幅/高さ単位選択変更
  obj.find('.form-position-custom-selunit').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // シミュレーション更新
      updateSimulation(setting, getPositionSimInfo);
    });
  });
  
  // 最小/最大値数値入力変更
  obj.find('.form-position-limit-txtnumber').on('keyup change', function(){
    // シミュレーション更新
    updateSimulation(setting, getPositionLimitInfo);
  });
  
  // 最小/最大値単位選択変更
  obj.find('.form-position-limit-selunit').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // シミュレーション更新
      updateSimulation(setting, getPositionLimitInfo);
    });
  });
  
  // 水平位置ラジオボタンをクリック
  obj.find('.form-position-rdohorizontal').on('click', function(){
    var radio_item = $(this);
    var radio_group = obj.find('.form-position-rdohorizontal');
    clickRadio(radio_item, radio_group, function(){
      // シミュレーション更新
      updateSimulation(setting, getPositionSimInfo);
    });
  });
  
  // 垂直位置ラジオボタンをクリック
  obj.find('.form-position-rdovertical').on('click', function(){
    var radio_item = $(this);
    var radio_group = obj.find('.form-position-rdovertical');
    clickRadio(radio_item, radio_group, function(){
      // シミュレーション更新
      updateSimulation(setting, getPositionSimInfo);
    });
  });
  
  // 位置調整数値入力変更
  obj.find('.form-position-margin-txtnumber').on('keyup change', function(){
    // シミュレーション更新
    updateSimulation(setting, getPositionMarginInfo);
  });
  
  // 位置調整単位選択変更
  obj.find('.form-position-margin-selunit').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // シミュレーション更新
      updateSimulation(setting, getPositionMarginInfo);
    });
  });
  
  // 初期化する際一回シミュレーション更新
  updateSimulation(setting, getPositionSimInfo);
  updateSimulation(setting, getPositionLimitInfo);
  updateSimulation(setting, getPositionMarginInfo);
}


/* 
 * 位置編集部分を初期化
 * params 
 *   obj : 対象位置編集部分
 */
const initFormPosition = function(obj) {
  // レスポンシブ対応可能パーツとして初期化
  initFormResponsive(obj, initFormPositionResponsiveArea);
}


/* 
 * 水平/垂直位置ラジオボタンHTML構築
 * params 
 *   direction : 水平/垂直キー
 *   name : radioのname
 *   value : 水平/垂直位置値
 * return 水平/垂直位置ラジオボタンHTML
 */
const htmlPositionRadioGroup = function(direction, name, value) {
  // 水平/垂直によって選択肢を取得
  var options = checkDirectionKey(direction, position_radio_options) ? position_radio_options[direction] : position_radio_options['horizontal'];
  
  // HTMLを構築
  var html = '<div class="form-position-' + direction + '">';
  
  $.each(options, function(option_value, option_text) {
    // 選択肢をループし、選択状態を取得
    var checked_str = '';
    if(value == option_value) {
      checked_str = 'checked';
    }
    
    // 選択肢HTMLを構築
    html += `
      <div class="form-position-rdo` + direction + ` ` + checked_str + `">
        <div class="form-position-rdo` + direction + `-preview preview-` + option_value + `">
          <p class="form-position-rdo` + direction + `-preview-item"></p>
        </div>
        <p class="form-position-rdo` + direction + `-title">` + option_text + `</p>
        <input type="radio" class="form-position-rdo` + direction + `-radio" name="` + name + `" value="` + option_value + `" ` + checked_str + ` />
      </div>
    `;
  });
  
  html += '</div>';
  
  return html;
}


/* 
 * 位置端末別編集部分HTMLを構築
 * params 
 *   base_key : レーアウトベースキー([block_key]__style__position)
 *   options : 構築パラメータ
 *     device : 構築端末(指定しない場合はレスポンシブ対応なしで、pcになる)
 *     style : スタイル情報
 * return 位置端末別編集部分HTML
 */
const htmlFormPositionResponsiveAreaInner = function(base_key, options) {
  // 位置端末別キー取得
  var device = checkDirectionKey('device', options) ? options['device'] : 'pc';
  var position_key = base_key + '__' + device;
  
  // レーアウトスタイル情報を取得
  var style = (checkDirectionKey('style', options) && $.isPlainObject(options['style'])) ? options['style'] : {};
  
  // 幅タイプ値取得と各幅設定部分の表示スタイルを取得
  var widthtype = getStyleValue(style, ['widthtype'], '');
  var relative_width_str = 'style="display: none;"';
  var custom_width_str = 'style="display: none;"';
  if(widthtype == 'relative') {
    relative_width_str = '';
  } else if(widthtype == 'custom') {
    custom_width_str = '';
  }
  
  // 最小幅ありフラグ値取得と最小幅設定部分の表示スタイルを取得
  var width_min_flag = getStyleValue(style, ['width_min_flag'], '0');
  var width_min_str = 'style="display: none;"';
  if(width_min_flag == '1') {
    width_min_str = '';
  }
  
  // 最大幅ありフラグ値取得と最大幅設定部分の表示スタイルを取得
  var width_max_flag = getStyleValue(style, ['width_max_flag'], '0');
  var width_max_str = 'style="display: none;"';
  if(width_max_flag == '1') {
    width_max_str = '';
  }
  
  // 高さタイプ値取得と高さ設定部分の表示スタイルを取得
  var heighttype = getStyleValue(style, ['heighttype'], '');
  var relative_height_str = 'style="display: none;"';
  var custom_height_str = 'style="display: none;"';
  if(heighttype == 'relative') {
    relative_height_str = '';
  } else if(heighttype == 'custom') {
    custom_height_str = '';
  }
  
  // 最小高さありフラグ値取得と最小高さ設定部分の表示スタイルを取得
  var height_min_flag = getStyleValue(style, ['height_min_flag'], '0');
  var height_min_str = 'style="display: none;"';
  if(height_min_flag == '1') {
    height_min_str = '';
  }
  
  // 最大高さありフラグ値取得と最大高さ設定部分の表示スタイルを取得
  var height_max_flag = getStyleValue(style, ['height_max_flag'], '0');
  var height_max_str = 'style="display: none;"';
  if(height_max_flag == '1') {
    height_max_str = '';
  }
  
  // HTMLを構築
  var html = `
    <div class="form-object">
      <p class="form-subtitle">` + translations.position_type + `</p>
      <p>
        ` + htmlSelect('form-position-seltype', position_key + '__type', getStyleValue(style, ['type'], ''), position_type_options) + `
      </p>
    </div>
    <div class="form-object">
      <div class="form-position-limitflag">
        <p class="form-subtitle form-position-limitflag-title">` + translations.width + `</p>
        ` + htmlCheckbox('form-position-chklimitflag', position_key + '__width_min_flag', translations.has_min, width_min_flag, {'check_class':'check-width-min'}) + `
        ` + htmlCheckbox('form-position-chklimitflag', position_key + '__width_max_flag', translations.has_max, width_max_flag, {'check_class':'check-width-max'}) + `
      </div>
      <p class="form-position-whtype">
        ` + htmlSelect('form-position-selwidthtype', position_key + '__widthtype', widthtype, position_width_type_options) + `
      </p>
    </div>
    <div class="form-object form-position-relative relative-width" ` + relative_width_str + `>
      <p class="form-subtitle">` + translations.position_relative_width + `</p>
      <div class="form-position-relative-inner">
        <div class="form-position-relative-setting">
          ` + htmlNumberInput('form-position-relative', position_key + '__left', getStyleValue(style, ['left'], 0), {'input_class':'number-left'}) + `
          ` + htmlUnitSelect('form-position-relative', position_key + '__left_unit', getStyleValue(style, ['left_unit'], ''), {'select_class':'unit-left'}) + `
        </div>
        <p class="form-position-relative-self">` + translations.position_self + `</p>
        <div class="form-position-relative-setting">
          ` + htmlNumberInput('form-position-relative', position_key + '__right', getStyleValue(style, ['right'], 0), {'input_class':'number-right'}) + `
          ` + htmlUnitSelect('form-position-relative', position_key + '__right_unit', getStyleValue(style, ['right_unit'], ''), {'select_class':'unit-right'}) + `
        </div>
      </div>
    </div>
    <div class="form-position-custom custom-width" ` + custom_width_str + `>
      <div class="form-position-custom-inner">
        ` + htmlNumberInput('form-position-custom', position_key + '__width', getStyleValue(style, ['width'], 0), {'input_class':'number-width', 'min':0}) + `
        ` + htmlUnitSelect('form-position-custom', position_key + '__width_unit', getStyleValue(style, ['width_unit'], ''), {'select_class':'unit-width'}) + `
      </div>
    </div>
    <div class="form-object form-position-limit">
      <div class="form-position-limit-line limit-width-min" ` + width_min_str + `>
        <p class="form-position-limit-title">` + translations.min + `</p>
        ` + htmlNumberInput('form-position-limit', position_key + '__width_min', getStyleValue(style, ['width_min'], 0), {'input_class':'number-width-min', 'min':0}) + `
        ` + htmlUnitSelect('form-position-limit', position_key + '__width_min_unit', getStyleValue(style, ['width_min_unit'], ''), {'select_class':'unit-width-min'}) + `
      </div>
      <div class="form-position-limit-line limit-width-max" ` + width_max_str + `>
        <p class="form-position-limit-title">` + translations.max + `</p>
        ` + htmlNumberInput('form-position-limit', position_key + '__width_max', getStyleValue(style, ['width_max'], 0), {'input_class':'number-width-max', 'min':0}) + `
        ` + htmlUnitSelect('form-position-limit', position_key + '__width_max_unit', getStyleValue(style, ['width_max_unit'], ''), {'select_class':'unit-width-max'}) + `
      </div>
    </div>
    <div class="form-object form-position-position position-x">
      <p class="form-subtitle">` + translations.position_horizontal + `</p>
      ` + htmlPositionRadioGroup('horizontal', position_key + '__position_x', getStyleValue(style, ['position_x'], 'left')) + `
    </div>
    <div class="form-object form-position-margin margin-left">
      <p class="form-subtitle">` + translations.position_margin_left + `</p>
      <div class="form-position-margin-inner">
        ` + htmlNumberInput('form-position-margin', position_key + '__margin_left', getStyleValue(style, ['margin_left'], 0), {'input_class':'number-margin-left'}) + `
        ` + htmlUnitSelect('form-position-margin', position_key + '__margin_left_unit', getStyleValue(style, ['margin_left_unit'], ''), {'select_class':'unit-margin-left'}) + `
      </div>
    </div>
    <div class="form-object">
      <div class="form-position-limitflag">
        <p class="form-subtitle form-position-limitflag-title">` + translations.height + `</p>
        ` + htmlCheckbox('form-position-chklimitflag', position_key + '__height_min_flag', translations.has_min, height_min_flag, {'check_class':'check-height-min'}) + `
        ` + htmlCheckbox('form-position-chklimitflag', position_key + '__height_max_flag', translations.has_max, height_max_flag, {'check_class':'check-height-max'}) + `
      </div>
      <p class="form-position-whtype">
        ` + htmlSelect('form-position-selheighttype', position_key + '__heighttype', heighttype, position_height_type_options) + `
      </p>
    </div>
    <div class="form-object form-position-relative relative-height" ` + relative_height_str + `>
      <p class="form-subtitle">` + translations.position_relative_height + `</p>
      <div class="form-position-relative-inner">
        <div class="form-position-relative-setting">
          ` + htmlNumberInput('form-position-relative', position_key + '__top', getStyleValue(style, ['top'], 0), {'input_class':'number-top'}) + `
          ` + htmlUnitSelect('form-position-relative', position_key + '__top_unit', getStyleValue(style, ['top_unit'], ''), {'select_class':'unit-top'}) + `
        </div>
        <p class="form-position-relative-self">` + translations.position_self + `</p>
        <div class="form-position-relative-setting">
          ` + htmlNumberInput('form-position-relative', position_key + '__bottom', getStyleValue(style, ['bottom'], 0), {'input_class':'number-bottom'}) + `
          ` + htmlUnitSelect('form-position-relative', position_key + '__bottom_unit', getStyleValue(style, ['bottom_unit'], ''), {'select_class':'unit-bottom'}) + `
        </div>
      </div>
    </div>
    <div class="form-position-custom custom-height" ` + custom_height_str + `>
      <div class="form-position-custom-inner">
        ` + htmlNumberInput('form-position-custom', position_key + '__height', getStyleValue(style, ['height'], 0), {'input_class':'number-height', 'min':0}) + `
        ` + htmlUnitSelect('form-position-custom', position_key + '__height_unit', getStyleValue(style, ['height_unit'], ''), {'select_class':'unit-height'}) + `
      </div>
    </div>
    <div class="form-object form-position-limit">
      <div class="form-position-limit-line limit-height-min" ` + height_min_str + `>
        <p class="form-position-limit-title">` + translations.min + `</p>
        ` + htmlNumberInput('form-position-limit', position_key + '__height_min', getStyleValue(style, ['height_min'], 0), {'input_class':'number-height-min', 'min':0}) + `
        ` + htmlUnitSelect('form-position-limit', position_key + '__height_min_unit', getStyleValue(style, ['height_min_unit'], ''), {'select_class':'unit-height-min'}) + `
      </div>
      <div class="form-position-limit-line limit-height-max" ` + height_max_str + `>
        <p class="form-position-limit-title">` + translations.max + `</p>
        ` + htmlNumberInput('form-position-limit', position_key + '__height_max', getStyleValue(style, ['height_max'], 0), {'input_class':'number-height-max', 'min':0}) + `
        ` + htmlUnitSelect('form-position-limit', position_key + '__height_max_unit', getStyleValue(style, ['height_max_unit'], ''), {'select_class':'unit-height-max'}) + `
      </div>
    </div>
    <div class="form-object form-position-position position-y">
      <p class="form-subtitle">` + translations.position_vertical + `</p>
      ` + htmlPositionRadioGroup('vertical', position_key + '__position_y', getStyleValue(style, ['position_y'], 'top')) + `
    </div>
    <div class="form-object form-position-margin margin-top">
      <p class="form-subtitle">` + translations.position_margin_top + `</p>
      <div class="form-position-margin-inner">
        ` + htmlNumberInput('form-position-margin', position_key + '__margin_top', getStyleValue(style, ['margin_top'], 0), {'input_class':'number-margin-top'}) + `
        ` + htmlUnitSelect('form-position-margin', position_key + '__margin_top_unit', getStyleValue(style, ['margin_top_unit'], ''), {'select_class':'unit-margin-top'}) + `
      </div>
    </div>
  `;
  
  return html;
}


/* 
 * 位置編集部分HTMLを構築
 * params 
 *   block_key : ブロック識別キー
 *   options : 構築パラメータ
 *     style : スタイル情報
 * return 位置編集部分HTML
 */
const htmlFormPosition = function(block_key, options) {
  var base_key = block_key + '__style__position';
  
  var html = `
    <div class="form-line">
      <p class="form-title">` + translations.position + `</p>
      ` + htmlFormResponsive(base_key, 'form-input form-position', htmlFormPositionResponsiveAreaInner, false, true, options) + `
    </div>
  `;
  
  return html;
}