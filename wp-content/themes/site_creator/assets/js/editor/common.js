// 透明度選択肢
const opacity_options = {
  '1.0':'100%',
  '0.9':'90%',
  '0.8':'80%',
  '0.7':'70%',
  '0.6':'60%',
  '0.5':'50%',
  '0.4':'40%',
  '0.3':'30%',
  '0.2':'20%',
  '0.1':'10%',
  '0.0':'0%',
}


/* 
 * スタイル計算リスト更新
 * params 
 *   calc_inner : 更新前のスタイル計算リスト
 *   value : 追加する値
 *   unit : 追加する単位
 * return 更新後のスタイル計算リスト
 */
const updateCalcInner = function(calc_inner, value, unit) {
  if(checkDirectionKey(unit, calc_inner)) {
    // 該当単位はキーとしてリストに存在する場合、その要素に値を加算
    calc_inner[unit] = calc_inner[unit] + value;
  } else {
    // 該当単位はキーとしてリストに存在しない場合、要素を追加
    calc_inner[unit] = value;
  }
  return calc_inner;
}


/* 
 * スタイル計算結果を取得
 * params 
 *   calc_inner : スタイル計算リスト
 * return スタイル計算結果
 */
const getCalcText = function(calc_inner) {
  if($.isPlainObject(calc_inner) && Object.keys(calc_inner).length) {
    // 計算リストが連想配列で、要素がある場合、計算結果文字列を構築
    var calc_text = 'calc(';
    var counter = 0;
    // 計算リストをループし、計算結果を取得
    $.each(calc_inner, function(unit, size){
      if(counter) {
        calc_text += ' + ';
      }
      calc_text += getValueWithUnit(size, unit, true);
      counter++;
    });
    calc_text += ')';
    return calc_text;
  } else {
    return '0';
  }
}


/* 
 * 単位付きのサイズ値をスタイル文字列に変更
 * params 
 *   value : サイズ値
 *   unit : 単位
 *   in_calc : 計算の中かどうかのフラグ
 * return スタイル文字列
 */
const getValueWithUnit = function(value, unit, in_calc=false) {
  var result = '';
  value = $.isNumeric(value) ? parseFloat(value) : 0;
  if(inArray(unit, ['vw', 'rem'])) {
    // 一部特殊単位では計算する、すでに計算の中なら「calc」を省略
    if(!in_calc) {
      result = 'calc';
    }
    
    // 単位によって計算方法が違う、計算時にスタイル変数を使う
    if(unit == 'vw') {
      result += '(' + value + 'px * var(--device-width) / var(--design-width))';
    } else if(unit == 'rem') {
      result += '(' + value + 'px * var(--sim-fontsize) / var(--design-fontsize))';
    }
  } else {
    // 通常ならサイズ値と単位を繋ぐ
    result = value + unit;
  }
  return result;
}


/* 
 * 連想配列からスタイル文字列に取得
 * params 
 *   style : スタイル配列
 *   route : 探したい項目のキールート、配列
 *   default_value : デフォルト値
 * return スタイル文字列
 */
const getStyleValue = function(style, route, default_value) {
  $.each(route, function(index, value){
    // キールートをループして、そのキーがスタイル配列のキーとして存在するかどうかをチェック
    if(checkDirectionKey(value, style)) {
      // 存在する場合スタイル配列を該当項目下のスタイル配列に更新
      style = style[value];
    } else {
      style = default_value;
      return;  // break;
    }
  });
  
  return style;
}


/* 
 * 色をHEX形式(#ffffff)からRGB形式に変換
 * params 
 *   hex : HEX形式色番号
 * return RGB形式色番号
 */
var getRgbByHex = function(hex) {
  // 正規表現を2桁単位で16進数に分割
  var rgb = /^([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  
  // 分割できる場合16進数を10進数に変換して返す
  return rgb ? {
    r: parseInt(rgb[1], 16),
    g: parseInt(rgb[2], 16),
    b: parseInt(rgb[3], 16)
  } : '';
}


/* 
 * シミュレーション部分の対象要素を取得
 * params 
 *   obj : 端末別編集エリア
 * return 対象要素リスト
 */
const getTargetSimulationItem = function(obj) {
  var target = obj.closest('.form-block').data('target');
  
  var items = null;
  if(obj.closest('.form-responsive').length) {
    if(obj.closest('.form-responsive').children('.form-responsive-controller').find('.form-responsive-chkflag-check').prop('checked')) {
      // PC/SPのみがチェックされている場合、該当端末のシミュレーション要素のみを取得
      var device = 'pc';
      if(obj.closest('.form-responsive-area').hasClass('setting-sp')) {
        device = 'sp';
      }
      items = $('#sim-' + target + '-' + device);
    } else {
      // PC/SPのみがチェックされていない場合、両方のシミュレーション要素を取得
      items = $('.sim-item[id^="sim-' + target + '-"]');
    }
  }
  
  return items;
}


/* 
 * 連想配列のキーリストを取得
 * params 
 *   direction : 対象連想配列
 * return 連想配列のキーリスト
 */
var getDirectionKeys = function(direction) {
  var keys = [];
  if($.isPlainObject(direction)) {
    keys = $.map(direction, function(value, key) {
      return key;
    });
  }
  return keys;
}


/* 
 * 連想配列に指定のキーにあたる要素があるかどうかをチェック
 * params 
 *   key : 対象キー
 *   direction : 対象連想配列
 * return ある場合はtrue、ない場合はfalse
 */
const checkDirectionKey = function(key, direction) {
  if($.inArray(key, getDirectionKeys(direction)) != -1) {
    return true;
  } else {
    return false;
  }
}


/* 
 * 配列に指定の値があるかどうかをチェック
 * params 
 *   value : 対象値
 *   array : 対象配列
 * return ある場合はtrue、ない場合はfalse
 */
const inArray = function(value, array) {
  if($.inArray(value, array) != -1) {
    return true;
  } else {
    return false;
  }
}


/* 
 * 文字列がHEX形式で色番号かどうかをチェック
 * params 
 *   hex : 対象文字列
 * return HEX形式の場合はtrue、そうではない場合はfalse
 */
const checkHex = function(hex) {
  if(hex.match(/[a-f\d]{6}/)) {
    return true;
  } else {
    return false;
  }
}


/* 
 * 文字列が透明度形式かどうかをチェック
 * params 
 *   hex : 対象文字列
 * return 透明度形式の場合はtrue、そうではない場合はfalse
 */
const checkOpacity = function(opacity) {
  if(opacity.match(/[0-1]{1}(\.[1-9]){0,1}/)) {
    return true;
  } else {
    return false;
  }
}


/* 
 * 文字列が数値形式かどうかをチェック
 * params 
 *   number : 対象文字列
 *   minus_flag : マイナス許可フラグ
 *   float_flag : 少数許可フラグ
 * return 数値形式の場合はtrue、そうではない場合はfalse
 */
const checkNumber = function(number, options = '') {
  // オプションを基づいてHTMLを整理
  var base_str = '\\d';
  var minus_str = '\\-?';
  var int_digit_str = '+';
  var decimal_str = '(\\.\\d+)?';
  if($.isPlainObject(options)) {
    // 正数のみの場合、「-」正規表現を消す
    if(checkDirectionKey('positive', options) && options['positive']) {
      minus_str = '';
    }
    
    // 進数によってベースを変更
    if(checkDirectionKey('binary', options) && options['binary']) {
      base_str = '[0-1]';
    } else if(checkDirectionKey('quaternary', options) && options['quaternary']) {
      base_str = '[0-3]';
    } else if(checkDirectionKey('octal', options) && options['octal']) {
      base_str = '[0-7]';
    } else if(checkDirectionKey('hexadecimal', options) && options['hexadecimal']) {
      base_str = '[a-f\\d]';
    }
    
    // 整数の桁数部分正規表現を整理
    var min_int_digit = checkDirectionKey('min_int_digit', options) ? options['min_int_digit'] : '';
    var max_int_digit = checkDirectionKey('max_int_digit', options) ? options['max_int_digit'] : '';
    if(min_int_digit || max_int_digit) {
      int_digit_str = '{' + min_int_digit + ',' + max_int_digit + '}';
    }
    
    if(checkDirectionKey('integer', options) && options['integer']) {
      // 整数のみの場合、小数部分正規表現を消す
      decimal_str = '';
    } else {
      // 整数のみではないの場合、小数部分正規表現を整理
      var decimal_start_str = '(';
      var decimal_end_str = ')?';
      var decimal_digit_str = '+';
      if(checkDirectionKey('min_del_digit', options) && options['min_del_digit']) {
        decimal_start_str = '';
        decimal_end_str = '';
        decimal_digit_str = '{' + options['min_del_digit'] + ',';
        if(checkDirectionKey('max_del_digit', options) && options['max_del_digit']) {
          decimal_digit_str += options['max_del_digit'];
        }
        decimal_digit_str += '}';
      } else if(checkDirectionKey('max_del_digit', options) && options['max_del_digit']) {
        decimal_digit_str = '{,' + options['max_del_digit'] + '}';
      }
      decimal_str = decimal_start_str + '\\.' + base_str + decimal_digit_str + decimal_end_str;
    }
  }
  
  // 正規表現を取得
  var regex = new RegExp('^' + minus_str + base_str + int_digit_str + decimal_str + '$');
  
  // 正規表現にマッチするかどうかを判定
  if(number.match(regex)) {
    return true;
  } else {
    return false;
  }
}


/* 
 * 特定シミュレーション部分要素のtransformの特定項目の値をリセットか追加か削除
 * params 
 *   item : 対象要素
 *   target_key : 対象transform項目キー
 *   target_value : 設定値
 */
const updateTransform = function(item, target_key, target_value) {
  // 更新後の対象項目スタイル値
  var new_value = target_key + '(' + target_value + ')';
  
  // 現在の対象要素のtransform値を配列に整理
  var transform_list = [];
  if(item[0].style.transform && item[0].style.transform != 'none') {
    transform_list = item[0].style.transform.split(' ');
  }
  
  // 更新後のtransformの設定値を新transformリストに整理
  var new_transform_list = [];
  var insert_flag = true;
  $.each(transform_list, function(index, transform) {
    // transformリストをループし、項目名を取得
    var key = transform.split('(')[0];
    
    if(key == target_key) {
      // 項目が今回の更新対象項目で、設定値が空白ではないの場合、対象項目スタイル値を新transformリストに追加
      if(target_value) {
        new_transform_list.push(new_value);
      }
      insert_flag = false;
    } else {
      // 項目が今回の更新対象項目ではない場合、現在のスタイル値を新transformリストに追加
      new_transform_list.push(transform);
    }
  });
  
  if(insert_flag) {
    new_transform_list.push(new_value);
  }
  
  if(new_transform_list.length) {
    // 新transformリストに要素がある場合、transformを更新
    item.css('transform', new_transform_list.join(' '));
  } else {
    // 新transformリストに要素がない場合、transformをnoneに設定
    item.css('transform', 'none');
  }
}


/* 
 * シミュレーション部分のスタイル情報を更新
 * params 
 *   setting : 編集部分
 *   func_info : CSS情報取得関数
 */
const updateSimulation = function(setting, func_info) {
  /* 
   * シミュレーション部分のCSSを更新
   * params 
   *   area : 対象端末別編集部分
   */
  var updateSimulationCss = function(area) {
    // CSS情報取得関数を実行
    var css_list = func_info(area);
    
    // 対象シミュレーション要素を取得
    var items = getTargetSimulationItem(area);
    
    // CSS情報リストをループし、シミュレーション要素のCSSを更新
    $.each(css_list, function(key, value) {
      if(key == 'transform') {
        // transform項目を更新する
        $.each(value, function(key_trans, value_trans) {
          items.each(function(){
            updateTransform($(this), key_trans, value_trans);
          });
        });
      } else {
        // 通常項目を更新する
        items.css(key, value);
      }
    });
  }
  
  if(setting.length) {
    // レスポンシブ対応フラグチェック状態を取得
    var re_flag = setting.find('.form-responsive-chkflag-check').prop('checked');
    
    if(re_flag) {
      // レスポンシブ対応の場合PCとSP別々で更新
      var area_pc = setting.find('.form-responsive-area.setting-pc').first();
      updateSimulationCss(area_pc);
      
      var area_sp = setting.find('.form-responsive-area.setting-sp').first();
      updateSimulationCss(area_sp);
    } else {
      // レスポンシブ対応でない場合一括で更新
      var area = setting.find('.form-responsive-area').first();
      updateSimulationCss(area);
    }
  }
}


/* 
 * 選択要素の選択の変更イベント
 * params 
 *   select : 選択要素
 *   func_change : 変更時に実行する処理
 */
const changeSelect = function(select, func_change) {
  // セレクトを待機状態に変更
  select.addClass('working');
  $.when(
    func_change()
  ).done(function(){
    // セレクトを稼働状態に変更
    select.removeClass('working');
  });
}


/* 
 * チェックボタンのクリックイベント
 * params 
 *   checkbox : 選択要素
 *   func_click : クリック時に実行する処理
 */
const clickCheckbox = function(checkbox, func_click) {
  var check = checkbox.find('input[type="checkbox"]');
  
  // チェックボタンを待機状態に変更
  checkbox.addClass('working');
  
  // チェックボックスのチェック状態を変更
  if(check.prop('checked')) {
    check.prop('checked', false);
    checkbox.removeClass('checked');
  } else {
    check.prop('checked', true);
    checkbox.addClass('checked');
  }
  
  $.when(
    func_click()
  ).done(function(){
    // チェックボタンを稼働状態に変更
    checkbox.removeClass('working');
  });
}


/* 
 * ラジオボタンのクリックイベント
 * params 
 *   radio_button : クリックしたラジオボタン
 *   func_click : クリック時に実行する処理
 */
const clickRadio = function(radio_button, func_click) {
  var radio_group = radio_button.parent().children();
  var radio = radio_button.find('input[type="radio"]');
  
  // クリックしたラジオボタンが稼働状態で、現在選択されてない場合のみ有効
  if(!radio_button.hasClass('working') && !radio_button.hasClass('checked')) {
    // 同組のラジオボタンを全部待機状態に変更
    radio_group.removeClass('checked').addClass('working');
    
    // ラジオチェック状態を更新
    radio.prop('checked', true);
    radio_button.addClass('checked');
    
    $.when(
      func_click()
    ).done(function(){
      // 同組のラジオボタンを全部稼働状態に変更
      radio_group.removeClass('working');
    });
  }
}


/* 
 * ボタンのクリックイベント
 * params 
 *   button : ボタン
 *   func_click : クリック時に実行する処理
 */
const clickButton = function(button, func_click) {
  // セレクトを待機状態に変更
  button.addClass('working');
  $.when(
    func_click()
  ).done(function(){
    // セレクトを稼働状態に変更
    button.removeClass('working');
  });
}


/* 
 * 色編集要素を初期化
 * params 
 *   form_color : 色編集要素
 *   func_update : シミュレーション更新処理
 *   other_showarea : 他に同時更新の色プレビュー要素
 */
const initFormColor = function(form_color, func_update, other_showarea=null) {
  // 内部要素の変数を定義
  var show = form_color.find('.form-color-show');
  var checkbox = form_color.find('.form-color-checkbox');
  var check = form_color.find('.form-color-checkbox-check');
  var picker = form_color.find('.form-color-txtpicker');
  var opacity = form_color.find('.form-color-selopacity');
  
  // 編集対象取得用の変数を定義
  var target = form_color.closest('.form-block').data('target');
  
  // 色編集部分色プレビューにスタイル反映
  var updateShowSimulation = function() {
    // 編集の設定値を取得
    var hex = picker.val();
    var opa = opacity.val();
    
    if(checkHex(hex) && checkOpacity(opa)) {
      // 色と透明度のフォーマットが正しい場合シミュレーションに反映
      var rgb = getRgbByHex(hex);
      var color = 'rgba(' + rgb['r'] + ', ' + rgb['g'] + ', ' + rgb['b'] + ', ' + opa + ')';
      show.css('background', color);
      check.prop('checked', false);
      checkbox.removeClass('checked');
      opacity.prop('disabled', false);
      
      // 同時更新色プレビューがある場合その要素にも反映
      if(other_showarea) {
        other_showarea.find('.form-color-show').css('background', color);
        other_showarea.find('.form-color-checkbox').removeClass('checked');
      }
    } else {
      // 色と透明度のフォーマットが正しくない場合シミュレーションが透明になる
      show.css('background', 'transparent');
      check.prop('checked', true);
      checkbox.addClass('checked');
      opacity.prop('disabled', true);
      
      // 同時更新色プレビューがある場合その要素にも反映
      if(other_showarea) {
        other_showarea.find('.form-color-show').css('background', color);
        other_showarea.find('.form-color-checkbox').addClass('checked');
      }
    }
  }
  
  // 色プレビュー部分をクリック
  show.on('click', function(){
    var button = $(this);
    clickButton(button, function() {
      if(checkbox.hasClass('checked')) {
        picker.click();
      } else {
        picker.val('');
        updateShowSimulation();
        func_update(target);
      }
    });
  });
  
  // カラーピーカーを定義
  picker.ColorPicker({
    onSubmit: function(hsb, hex, rgb, el) {
      $(el).val(hex);
      $(el).ColorPickerHide();
      updateShowSimulation();
      func_update(target);
    },
    onBeforeShow: function () {
      $(this).ColorPickerSetColor(this.value);
    }
  }).bind('keyup', function(){
    $(this).ColorPickerSetColor('#' + this.value);
    updateShowSimulation();
    func_update(target);
  });
  
  // 透明度を変更
  opacity.on('change', function(){
    var select = $(this);
    changeSelect($(this), function(){
      updateShowSimulation();
      func_update(target);
    });
  });
  
  // 初期化にプレビューを一度反映
  updateShowSimulation();
}


/* 
 * アップロードボタン要素を初期化
 * params 
 *   form_upload : アップロードボタン要素
 *   func_update : シミュレーション更新処理
 */
const initFormUpload = function(form_upload, func_update) {
  // 編集対象取得用の変数を定義
  var target = form_upload.closest('.form-block').data('target');
  
  // アップロード画像ファイル名部分をクリック
  form_upload.find('.form-upload-text').on('click', function(){
    form_upload.find('.form-upload-btnupload').click();
  });
  
  // 画像をアップロードする
  form_upload.find('.form-upload-file').on('change', function () {
    var file = $(this);
    
    // ajax送信用パラメータ作成
    let data = new FormData;
    data.append( 'action', 'upload-attachment' );
    data.append( 'async-upload', file[0].files[0] );
    data.append( '_wpnonce', upload_param.nonce );
    
    // 画像アップロード
    $.ajax( {
      url         : upload_param.upload_url,
      data        : data,
      processData : false,
      contentType : false,
      dataType    : 'json',
      type        : 'POST',
    }).then(
      function ( data ) {
        // 画像アップロード部分内容更新
        form_upload.data('url', data.data.url);
        form_upload.find('.form-upload-image').val(data.data.id);
        form_upload.find('.form-upload-text').addClass('active').html(data.data.title + '.' + data.data.subtype);
        form_upload.find('.form-upload-btndelete').fadeIn();
        
        // シミュレーション更新
        func_update(target);
      },
      function ( jqXHR, textStatus, errorThrown ) {
        console.log( 'Faled to upload file' );
      }
    );
  });
  
  // アップロード画像削除ボタンをクリック
  form_upload.find('.form-upload-btndelete').on('click', function(){
    var button = $(this);
    clickButton(button, function(){
      // アップロード画像を削除
      form_upload.data('url', '');
      form_upload.find('.form-upload-image').val('');
      form_upload.find('.form-upload-file').val('');
      form_upload.find('.form-upload-text').removeClass('active').html(translations.file_upload);
      form_upload.find('.form-upload-btndelete').fadeOut(function(){
        // シミュレーション更新
        func_update(target);
      });
    });
  });
}


/* 
 * 選択要素HTMLを構築 
 * params 
 *   select_class : 選択要素につけるクラス
 *   name : 選択要素name(フォーム送信用)
 *   value : 選択値
 *   choices : 選択肢リスト、連想配列で、キーは選択肢のvalue、値は選択肢のテキストになる
 *   options : オプション、選択要素を構築に使う拡張項目
 *     hidden : 初期化する際選択不可の選択肢のテキスト
 *     disabled : true/false、選択要素が操作不能かどうかのフラグ
 * return 選択要素HTML
 */
const htmlSelect = function(select_class, name, value, choices, options='') {
  // オプションを基づいてHTMLを整理
  hidden_str = '';
  disabled_str = '';
  if($.isPlainObject(options)) {
    if(checkDirectionKey('hidden', options)) {
      hidden_str = '<option value="" hidden>' + options['hidden'] + '</option>';
    }
    
    if(checkDirectionKey('disabled', options) && options['disabled']) {
      disabled_str = 'disabled';
    }
  }
  
  // HTMLを構築
  var html = '<select class="' + select_class + '" name="' + name + '" ' + disabled_str + '>' + hidden_str;
  $.each(choices, function(option_value, option_text){
    // valueパラメータと一致する選択肢を選択状態にする
    var selected_str = (option_value == value) ? 'selected' : '';
    html += '<option value="' + option_value + '" ' + selected_str + '>' + option_text + '</option>';
  });
  html += '</select>';
  
  return html;
}


/* 
 * チェックボタン要素HTMLを構築 
 * params 
 *   class_key : チェックボタン要素につけるクラスで使うキーワード
 *   name : チェックボックス要素(非表示)name(フォーム送信用)
 *   text : ボタンテキスト
 *   value : true/false、チェック状態
 *   options : オプション、チェックボタン要素を構築に使う拡張項目
 *     box_class : チェックボタン要素につける追加クラス
 *     check_class : チェックボックス要素(非表示)につける追加クラス
 * return チェックボタン要素HTML
 */
const htmlCheckbox = function(class_key, name, text, value, options='') {
  // チェック状態をHTMLに反映
  var checked_str = '';
  if(value == '1') {
    checked_str = 'checked';
  }
  
  // オプションを基づいてHTMLを整理
  var box_class = '';
  var check_class = '';
  if($.isPlainObject(options)) {
    if(checkDirectionKey('box_class', options)) {
      box_class = options['box_class'];
    }
    
    if(checkDirectionKey('check_class', options)) {
      check_class = options['check_class'];
    }
  }
  
  // HTMLを構築
  var html = `
    <p class="form-checkbox ` + class_key + ` ` + checked_str + ` ` + box_class + `">
      <input type="hidden" name="` + name + `" value="0" />
      <input type="checkbox" class="` + class_key + `-check ` + check_class + `" name="` + name + `" ` + checked_str + ` value="1" />` + text + `
    </p>
  `;
  
  return html;
}


/* 
 * 数値入力HTMLを構築 
 * params 
 *   class_key : 数値入力につけるクラスで使うキーワード
 *   name : 入力要素name(フォーム送信用)
 *   value : 数値の値
 *   options : オプション、数値入力を構築に使う拡張項目
 *     number_class : 数値入力につける追加クラス
 *     input_class : 入力要素につける追加クラス
 *     min : 最小値
 * return 数値入力HTML
 */
const htmlNumberInput = function(class_key, name, value, options='') {
  // オプションを基づいてHTMLを整理
  var number_class = '';
  var input_class = '';
  var min_str = '';
  if($.isPlainObject(options)) {
    if(checkDirectionKey('number_class', options)) {
      number_class = options['number_class'];
    }
    
    if(checkDirectionKey('input_class', options)) {
      input_class = options['input_class'];
    }
    
    if(checkDirectionKey('min', options)) {
      min_str = 'min="' + options['min'] + '"';
    }
  }
  
  // HTMLを構築
  var html = `
    <p class="` + class_key + `-number ` + number_class + `">
      <input type="number" class="` + class_key + `-txtnumber ` + input_class + `" name="` + name + `" value="` + value + `" ` + min_str + ` />
    </p>
  `;
  
  return html;
}


/* 
 * 単位選択HTMLを構築 
 * params 
 *   class_key : 単位選択につけるクラスで使うキーワード
 *   name : 選択要素name(フォーム送信用)
 *   value : 単位選択値
 *   options : オプション、単位選択を構築に使う拡張項目
 *     unit_class : 単位選択につける追加クラス
 *     select_class : 選択要素につける追加クラス
 *     exclusion_list : 除外したい選択肢洗いリスト
 * return 単位選択HTML
 */
const htmlUnitSelect = function(class_key, name, value, options='') {
  // オプションを基づいてHTMLを整理
  var unit_class = '';
  var select_class = '';
  var exclusion_list = [];
  if($.isPlainObject(options)) {
    if(checkDirectionKey('unit_class', options)) {
      unit_class = options['unit_class'];
    }
    
    if(checkDirectionKey('select_class', options)) {
      select_class = options['select_class'];
    }
    
    if(checkDirectionKey('exclusion_list', options) && $.isArray(options['exclusion_list'])) {
      exclusion_list = options['exclusion_list'];
    }
  }
  
  // HTMLを構築
  var html = `
    <p class="` + class_key + `-unit ` + unit_class + `">
      <select class="` + class_key + `-selunit ` + select_class + `" name="` + name + `">
  `;
  
  $.each(unit_options, function(index, unit_value) {
    // 除外リスト以外の場合のみ選択肢として追加
    if(inArray(unit_value, exclusion_list) == false) {
      // valueパラメータと一致する選択肢を選択状態にする
      var selected_str = '';
      if(value == unit_value) {
        selected_str = 'selected';
      }
      html += '<option value="' + unit_value + '" ' + selected_str + '>' + unit_value + '</option>';
    }
  });
  
  html += `
      </select>
    </p>
  `;
  
  return html;
}


/* 
 * チェックボックス無しの色プレビューHTMLを構築 
 * params 
 *   class_key : 色プレビューにつけるクラスで使うキーワード
 *   checked_str : チェック状態(チェックしているなら「checked」が入る)
 * return 色プレビューHTML
 */
const htmlFormColorShowareaWithouCheck = function(class_key, checked_str) {
  // HTMLを構築
  var html = `
    <div class="form-color-showarea ` + class_key + `-showarea">
      <div class="form-color-show">
        <p class="form-color-checkbox ` + class_key + `-checkbox ` + checked_str + `"></p>
      </div>
    </div>
  `;
  return html;
}


/* 
 * 色編集部分HTMLを構築 
 * params 
 *   color_class : 色編集部分につけるクラス
 *   name_key : 各入力/選択要素nameで使うキーワード(フォーム送信用)
 *   style : 色スタイル情報
 *     transparent : 透明色フラグ
 *     color : 色番号(HEX)
 *     opacity : 透明度
 * return 単位選択HTML
 */
const htmlFormColor = function(color_class, name_key, style) {
  // 透明色のチェック状態を取得
  var transparent_str = '';
  if(getStyleValue(style, ['transparent'], '1') == '1') {
    transparent_str = 'checked';
  }
  
  // HTMLを構築
  var html = `
    <div class="` + color_class + ` form-color">
      <div class="form-color-showarea">
        <div class="form-color-show">
          <p class="form-color-checkbox ` + transparent_str + `">
            <input type="hidden" name="` + name_key + `__transparent" value="0" />
            <input type="checkbox" class="form-color-checkbox-check" name="` + name_key + `__transparent" value="1" ` + transparent_str + ` />
          </p>
        </div>
      </div>
      <p class="form-color-picker">
        <input class="form-color-txtpicker" type="text" maxlength="6" name="` + name_key + `__color" value="` + getStyleValue(style, ['color'], '') + `" />
      </p>
      <p class="form-color-opacity">
        ` + htmlSelect('form-color-selopacity', name_key + '__opacity', getStyleValue(style, ['opacity'], ''), opacity_options) + `
      </p>
    </div>
  `;
  return html;
}


/* 
 * アップロードボタン要素HTMLを構築 
 * params 
 *   upload_class : アップロードボタン要素につけるクラス
 *   name : ファイル要素(非表示)name(フォーム送信用)
 *   value : ファイル値(アップロードしたファイルがDB上での投稿ID)
 * return アップロードボタン要素HTML
 */
const hmtlFormUpload = function(upload_class, name, value, func_update_simulation) {
  // デフォルトのURL、ファイル名を取得して、削除ボタンを非表示にする
  var data_url = '';
  var delete_style = '';
  var upload_text = translations.file_upload;
  
  // HTMLを構築
  var html = `
    <div class="form-upload ` + upload_class + `" data-url="` + data_url + `">
      <p class="form-upload-text ` + (upload_text ? 'active' : '') + `">` + upload_text + `</p>
      <p class="form-upload-btndelete" style="` + delete_style + `"></p>
      <label class="form-upload-btnupload">
        <input type="file" class="form-upload-file" />
      </label>
      <input type="hidden" class="form-upload-image" name="` + name + `" value="` + value + `" />
    </div>
  `;
  
  if(value) {
    // ファイル値がある場合、ajaxでファイル情報を取得してアップロードボタン要素を更新
    var fd = new FormData();
    fd.append('action', 'get_media_info');
    fd.append('media_id', value);
    
    $.ajax({
      type: 'POST',
      url: ajaxurl,
      data: fd,
      processData: false,
      contentType: false,
      success: function( response ){
        var res = JSON.parse(response);
        if(res['result'] == true) {
          // 画像アップロード部分内容更新
          var data = res['data'];
          var form_upload = $('input[name="' + name + '"]').closest('.form-upload');
          form_upload.data('url', data['url']);
          form_upload.find('.form-upload-text').addClass('active').html(data['name']);
          form_upload.find('.form-upload-btndelete').fadeIn();
          func_update_simulation();
        } else {
        }
      },
      error: function( response ){
      }
    });
  }
  
  return html;
}
