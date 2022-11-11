// 背景層のindexを更新
const updateBackgroundLayerIndex = function(layer_list) {
  layer_list.each(function(){
    var target = $(this).closest('.form-block').data('target');
    var layerid = $(this).data('layerid');
    var index = layer_list.index($(this));
    $(this).find('.form-background-index').val(index);
    $('.sim-' + target + '-background-' + layerid).css('z-index', 0 - index - 1);
  });
}


// 色をhex形式(#ffffff)からrgb形式に変換
var changeHexToRgb = function(hex) {
  // 正規表現を2桁単位で16進数に分割
  var rgb = /^([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  
  // 分割できる場合16進数を10進数に変換して返す
  return rgb ? {
    r: parseInt(rgb[1], 16),
    g: parseInt(rgb[2], 16),
    b: parseInt(rgb[3], 16)
  } : '';
}


// 単位値を属性に変換
var changeUnitValueToAttr = function(unit) {
  var result = '';
  if(unit == 'pixel') {
    result = 'px';
  } else if(unit == 'percent') {
    result = '%';
  }
  return result;
}


// 純色背景スタイル編集エリアを初期化
const initFormBackgroundSolid = function(obj) {
  // 内部要素の変数を定義
  var show = obj.find('.form-color-show');
  var checkbox = obj.find('.form-color-checkbox');
  var check = obj.find('.form-color-checkbox-check');
  var picker = obj.find('.form-color-txtpicker');
  var opacity = obj.find('.form-color-opacity-select');
  
  // 編集対象取得用の変数を定義
  var target = obj.closest('.form-block').data('target');
  var layerid = obj.closest('.form-background-layer').data('layerid');
  
  // 編集対象シミュレーションと色編集エリア色シミュレーションにスタイル反映
  var updateSimulation = function() {
    // 編集対象を取得
    var sim_target = $('.sim-' + target + '-background-' + layerid);
    if(obj.closest('.form-responsive-area').hasClass('setting-pc')) {
      sim_target = $('#sim-' + target + '-background-' + layerid + '-pc');
    } else if(obj.closest('.form-responsive-area').hasClass('setting-sp')) {
      sim_target = $('#sim-' + target + '-background-' + layerid + '-sp');
    }
    
    // 編集の設定値を取得
    var hex = picker.val();
    var opa = opacity.val();
    
    if(hex.match(/[a-f\d]{6}/) && opa.match(/[0-1]{1}(\.[1-9]){0,1}/)) {
      // 色と透明度のフォーマットが正しい場合シミュレーションに反映
      var rgb = changeHexToRgb(hex);
      var color = 'rgba(' + rgb['r'] + ', ' + rgb['g'] + ', ' + rgb['b'] + ', ' + opa + ')';
      sim_target.css('background', color);
      show.css('background', color);
      check.prop('checked', true);
      checkbox.addClass('checked');
      opacity.prop('disabled', false);
    } else {
      // 色と透明度のフォーマットが正しくない場合シミュレーションが透明になる
      sim_target.css('background', 'transparent');
      show.css('background', 'transparent');
      check.prop('checked', false);
      checkbox.removeClass('checked');
      opacity.prop('disabled', true);
    }
  }
  
  // 色シミュレーション部分をクリック
  show.on('click', function(e){
    e.preventDefault();
    if(checkbox.hasClass('checked')) {
      picker.val('');
      updateSimulation();
    } else {
      picker.click();
    }
  });
  
  // カラーピーカーを定義
  picker.ColorPicker({
    onSubmit: function(hsb, hex, rgb, el) {
      $(el).val(hex);
      $(el).ColorPickerHide();
      updateSimulation();
    },
    onBeforeShow: function () {
      $(this).ColorPickerSetColor(this.value);
    }
  }).bind('keyup', function(){
    $(this).ColorPickerSetColor('#' + this.value);
    updateSimulation();
  });
  
  // 透明度を変更
  opacity.on('change', function(){
    updateSimulation();
  });
  
  // 初期化にシミュレーションを一度反映
  updateSimulation();
}


// 背景編集ブロック画像エリアを初期化
const initFormBackgroundPicture = function(obj) {
  // 編集対象取得用の変数を定義
  var target = obj.closest('.form-block').data('target');
  var layerid = parseInt(obj.closest('.form-background-layer').data('layerid'));
  
  // 編集対象シミュレーションと色編集エリア色シミュレーションにスタイル反映
  var updateSimulation = function() {
    // 編集対象を取得
    var sim_target = $('.sim-' + target + '-background-' + layerid);
    if(obj.closest('.form-responsive-area').hasClass('setting-pc')) {
      sim_target = $('#sim-' + target + '-background-' + layerid + '-pc');
    } else if(obj.closest('.form-responsive-area').hasClass('setting-sp')) {
      sim_target = $('#sim-' + target + '-background-' + layerid + '-sp');
    }
    
    // 画像URL反映
    var url = obj.find('.form-upload').data('url');
    if(url) {
      sim_target.css('background-image', 'url(' + url + ')');
    } else {
      sim_target.css('background-image', 'none');
    }
    
    // 背景重複性反映
    if(obj.find('.form-background-chkrepeat-check').prop('checked')) {
      sim_target.css('background-repeat', 'repeat');
    } else {
      sim_target.css('background-repeat', 'no-repeat');
    }
    
    // 背景場所反映
    if(obj.find('.form-position-selposition').val() == 'custom') {
      var from_y = obj.find('.form-position-selfrom.from-y').val();
      var distance_y = obj.find('.form-position-txtdistance.distance-y').val();
      var unit_y = changeUnitValueToAttr(obj.find('.form-position-selunit.unit-y').val());
      var from_x = obj.find('.form-position-selfrom.from-x').val();
      var distance_x = obj.find('.form-position-txtdistance.distance-x').val();
      var unit_x = changeUnitValueToAttr(obj.find('.form-position-selunit.unit-x').val());
      sim_target.css('background-position', from_y + ' ' + distance_y + unit_y + ' ' + from_x + ' ' + distance_x + unit_x);
    } else {
      sim_target.css('background-position', obj.find('.form-position-selposition').val());
    }
    
    // 背景サイズ反映
    if(!obj.find('.form-size-chkunset-check').prop('checked')) {
      var width = obj.find('.form-size-txtvalue.value-w').val();
      var unit_w = changeUnitValueToAttr(obj.find('.form-size-selunit.unit-w').val());
      var size = width + unit_w;
      if(!obj.find('.form-size-chkproportion-check').prop('checked')) {
        var height = obj.find('.form-size-txtvalue.value-h').val();
        var unit_h = changeUnitValueToAttr(obj.find('.form-size-selunit.unit-h').val());
        size += ' ' + height + unit_h;
      }
      sim_target.css('background-size', size);
    } else {
      sim_target.css('background-size', 'unset');
    }
  }
  
  // アップロード画像ファイル名部分をクリック
  obj.find('.form-upload-text').on('click', function(){
    obj.find('.form-upload-btnupload').click();
  });
  
  // 画像をアップロードする
  obj.find('.form-upload-file').on('change', function (e) {
    var file = $(this);
    
    // 通常動作を止める
    e.preventDefault();
    
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
        // 画像アップロードエリア内容更新
        obj.find('.form-upload').data('url', data.data.url);
        obj.find('.form-upload-image').val(data.data.id);
        obj.find('.form-upload-text').addClass('active').html(data.data.title + '.' + data.data.subtype);
        obj.find('.form-upload-btndelete').fadeIn();
        
        // シミュレーション更新
        updateSimulation();
      },
      function ( jqXHR, textStatus, errorThrown ) {
        console.log( 'error!' );
        console.log( 'jqXHR' );
        console.log( jqXHR );
        console.log( 'textStatus' );
        console.log( textStatus );
        console.log( 'errorThrown' );
        console.log( errorThrown );
      }
    );
  });
  
  // 背景重複性チェックボックスをクリック
  obj.find('.form-background-chkrepeat').on('click', function(){
    // チェックボックスクリックのロックをかける
    var checkbox = $(this);
    
    if(!checkbox.hasClass('working')) {
      checkbox.addClass('working');
      
      // チェックボックスチェック状態変更
      var check = checkbox.find('.form-background-chkrepeat-check');
      if(check.prop('checked')) {
        check.prop('checked', false);
        checkbox.removeClass('checked');
      } else {
        check.prop('checked', true);
        checkbox.addClass('checked');
      }
      
      // シミュレーション更新
      updateSimulation();
      
      // ボタンクリックのロックを外す
      checkbox.removeClass('working');
    }
  });
  
  // アップロード画像削除ボタンをクリック
  obj.find('.form-upload-btndelete').on('click', function(){
    // ボタンクリックのロックをかける
    var button = $(this);
    
    if(!button.hasClass('working')) {
      button.addClass('working');
      
      // アップロード画像を削除
      obj.find('.form-upload').data('url', '');
      obj.find('.form-upload-image').val('');
      obj.find('.form-upload-file').val('');
      obj.find('.form-upload-text').removeClass('active').html(translations.file_upload);
      obj.find('.form-upload-btndelete').fadeOut(function(){
        // シミュレーション更新
        updateSimulation();
        
        // ボタンクリックのロックを外す
        button.removeClass('working');
      });
    }
  });
  
  // 背景画像位置タイプ選択変更
  obj.find('.form-position-selposition').on('change', function(){
    // 選択変更のロックをかける
    var select = $(this);
    if(!select.hasClass('working')) {
      select.addClass('working');
      
      // 選択によって詳細設定部分の表示を切り替える
      if($(this).val() == 'custom') {
        $(this).closest('.form-position').find('.form-position-detail').slideDown(function(){
          // シミュレーション更新
          updateSimulation();
          select.removeClass('working');
        });
      } else {
        $(this).closest('.form-position').find('.form-position-detail').slideUp(function(){
          // シミュレーション更新
          updateSimulation();
          select.removeClass('working');
        });
      }
    }
  });
  
  // 背景画像位置出発方向選択変更
  obj.find('.form-position-selfrom').on('change', function(){
    // シミュレーション更新
    updateSimulation();
  });
  
  // 背景画像位置距離入力変更
  obj.find('.form-position-txtdistance').on('keyup change', function(){
    // 数値ではない場合0にする
    if(!$(this).val().match(/^[\d,]+(\.\d+)?$/)) {
      $(this).val(0);
    }
    // シミュレーション更新
    updateSimulation();
  });
  
  // 背景画像位置単位変更
  obj.find('.form-position-selunit').on('change', function(){
    // シミュレーション更新
    updateSimulation();
  });
  
  // 画像の元サイズで表示のボタンをクリック
  obj.find('.form-size-chkunset').on('click', function(){
    // チェックボックスクリックのロックをかける
    var checkbox = $(this);
    
    if(!checkbox.hasClass('working')) {
      checkbox.addClass('working');
      
      // チェックボックスチェック状態変更
      var check = checkbox.find('.form-size-chkunset-check');
      if(check.prop('checked')) {
        check.prop('checked', false);
        checkbox.removeClass('checked');
        // 画像サイズ詳細設定部分表示
        checkbox.closest('.form-size').find('.form-size-setting').slideDown(function(){
          // シミュレーション更新
          updateSimulation();
          // ボタンクリックのロックを外す
          checkbox.removeClass('working');
        });
      } else {
        check.prop('checked', true);
        checkbox.addClass('checked');
        // 画像サイズ詳細設定部分非表示
        checkbox.closest('.form-size').find('.form-size-setting').slideUp(function(){
          // シミュレーション更新
          updateSimulation();
          // ボタンクリックのロックを外す
          checkbox.removeClass('working');
        });
      }
    }
  });
  
  // 画像の等比率でサイズ調整のボタンをクリック
  obj.find('.form-size-chkproportion').on('click', function(){
    // チェックボックスクリックのロックをかける
    var checkbox = $(this);
    
    if(!checkbox.hasClass('working')) {
      checkbox.addClass('working');
      
      // チェックボックスチェック状態変更
      var check = checkbox.find('.form-size-chkproportion-check');
      if(check.prop('checked')) {
        check.prop('checked', false);
        checkbox.removeClass('checked');
        // 画像サイズ高さ設定部分表示
        checkbox.closest('.form-size').find('.form-size-line.line-height').slideDown(function(){
          // シミュレーション更新
          updateSimulation();
          // ボタンクリックのロックを外す
          checkbox.removeClass('working');
        });
      } else {
        check.prop('checked', true);
        checkbox.addClass('checked');
        // 画像サイズ高さ設定部分非表示
        checkbox.closest('.form-size').find('.form-size-line.line-height').slideUp(function(){
          // シミュレーション更新
          updateSimulation();
          // ボタンクリックのロックを外す
          checkbox.removeClass('working');
        });
      }
    }
  });
  
  // 画像サイズ入力変更
  obj.find('.form-size-txtvalue').on('keyup change', function(){
    // 数値ではない場合0にする
    if(!$(this).val().match(/^[\d,]+(\.\d+)?$/)) {
      $(this).val(0);
    }
    // シミュレーション更新
    updateSimulation();
  });
  
  // 画像サイズ単位変更
  obj.find('.form-size-selunit').on('change', function(){
    // シミュレーション更新
    updateSimulation();
  });
  
  // 初期化にシミュレーションを一度反映
  updateSimulation();
}











































// 背景編集ブロック変色エリアを初期化
const initFormBackgroundGradient = function(obj) {
  // 編集対象取得用の変数を定義
  var target = obj.closest('.form-block').data('target');
  var layerid = parseInt(obj.closest('.form-background-layer').data('layerid'));
  
  // シミュレーション更新
  var updateSimulation = function() {
    // 編集対象を取得
    var sim_target = $('.sim-' + target + '-background-' + layerid);
    if(obj.closest('.form-responsive-area').hasClass('setting-pc')) {
      sim_target = $('#sim-' + target + '-background-' + layerid + '-pc');
    } else if(obj.closest('.form-responsive-area').hasClass('setting-sp')) {
      sim_target = $('#sim-' + target + '-background-' + layerid + '-sp');
    }
    
    // 背景関数を取得
    var type = obj.find('.form-gradient-rdotype-radio:checked').val();
    var background = '';
    if(obj.find('.form-gradient-chkrepeat-check').prop('checked')) {
      background = 'repeating-';
    }
    background += type + '-gradient(';
    
    // 背景詳細設定取得
    var done_flag = true;
    if(type == 'linear') {
      // 線型変色で変色方向を取得
      var direction = obj.find('.form-gradient-seldirection').val();
      if(direction == 'rotate') {
        var rotate = $('.form-gradient-txtrotate').val();
        if(rotate.match(/^[\d,]+(\.\d+)?$/)) {
          background += rotate + 'deg ';
        } else {
          done_flag = false;
        }
      } else if(direction != '') {
        background += direction + ' ';
      } else {
        done_flag = false;
      }
    } else if(type == 'conic' || type == 'radial') {
      // 円型・扇型変色
      if(type == 'radial') {
        // 円型変色で形状を取得
        var shape = obj.find('.form-gradient-selshape').val();
        if(shape != '') {
          background += shape + ' at ';
        } else {
          done_flag = false;
        }
      } else {
        background += ' from 0deg at '
      }
      
      // 中心点を取得
      var center = obj.find('.form-gradient-selcenter').val();
      if(center == 'position') {
        var distance_x = obj.find('.form-position-txtcenterdistance.centerdistance-x').val();
        var distance_y = obj.find('.form-position-txtcenterdistance.centerdistance-y').val();
        var unit_x = changeUnitValueToAttr(obj.find('.form-position-selcenterunit.centerunit-x').val());
        var unit_y = changeUnitValueToAttr(obj.find('.form-position-selcenterunit.centerunit-y').val());
        
        if(distance_x.match(/^[\d,]+(\.\d+)?$/) && distance_y.match(/^[\d,]+(\.\d+)?$/) && unit_x && unit_y) {
          background += distance_x + unit_x + ' ' + distance_y + unit_y + ' ';
        } else {
          done_flag = false;
        }
      } else if(center != '') {
        background += center + ' ';
      } else {
        done_flag = false;
      }
    }
    
    if(done_flag == true) {
      // 詳細設定に問題がない場合色配列を整理
      var calc_percent = 0;
      var calc_pixel = 0;
      var counter = 0;
      
      obj.find('.form-gradient-color').each(function(){
        // 色設定エリアをループして処理
        var check = $(this).find('.form-color-checkbox-check');
        var hex = $(this).find('.form-color-txtpicker').val();
        var opa = $(this).find('.form-color-selopacity').val();
        var size = $(this).find('.form-color-txtsize').val();
        var unit = $(this).find('.form-color-selunit').val();
        var color = 'transparent';
        
        // 色と透明度を整理、色が設定されてない場合は透明のまま
        if(check.prop('checked')) {
          if(hex.match(/[a-f\d]{6}/) && opa.match(/[0-1]{1}(\.[1-9]){0,1}/)) {
            var rgb = changeHexToRgb(hex);
            color = 'rgba(' + rgb['r'] + ', ' + rgb['g'] + ', ' + rgb['b'] + ', ' + opa + ')';
          }
        }
        
        if(size.match(/^[\d,]+(\.\d+)?$/)) {
          // 変色範囲サイズが数値の場合データ型切り替え
          size = parseInt(size);
        } else {
          // 変色範囲サイズが数値ではない場合スキップ
          return true;  // continue
        }
        
        if(counter == 0) {
          background += ', ' + color + ' 0 ';
        }
        
        if(type ==  'conic') {
          calc_percent += size;
          background += ', ' + color + ' ' + calc_percent + '% ';
        } else {
          if(unit == 'pixel') {
            calc_pixel += size;
          } else if(unit == 'percent') {
            calc_percent += size;
          } else {
            return true;  // continue
          }
          background += ', ' + color + ' calc(' + calc_percent + '% + ' + calc_pixel + 'px) ';
        }
        
        counter++;
      });
      
      background += ')';
      
      sim_target.css('background-image', background);
    }
    
    // 背景重複性反映
    if(obj.find('.form-background-chkrepeat-check').prop('checked')) {
      sim_target.css('background-repeat', 'repeat');
    } else {
      sim_target.css('background-repeat', 'no-repeat');
    }
    
    // 背景場所反映
    if(obj.find('.form-position-selposition').val() == 'custom') {
      var from_y = obj.find('.form-position-selfrom.from-y').val();
      var distance_y = obj.find('.form-position-txtdistance.distance-y').val();
      var unit_y = changeUnitValueToAttr(obj.find('.form-position-selunit.unit-y').val());
      var from_x = obj.find('.form-position-selfrom.from-x').val();
      var distance_x = obj.find('.form-position-txtdistance.distance-x').val();
      var unit_x = changeUnitValueToAttr(obj.find('.form-position-selunit.unit-x').val());
      sim_target.css('background-position', from_y + ' ' + distance_y + unit_y + ' ' + from_x + ' ' + distance_x + unit_x);
    } else {
      sim_target.css('background-position', obj.find('.form-position-selposition').val());
    }
    
    // 背景サイズ反映
    if(!obj.find('.form-size-chkunset-check').prop('checked')) {
      var width = obj.find('.form-size-txtvalue.value-w').val();
      var unit_w = changeUnitValueToAttr(obj.find('.form-size-selunit.unit-w').val());
      var size = width + unit_w;
      if(!obj.find('.form-size-chkproportion-check').prop('checked')) {
        var height = obj.find('.form-size-txtvalue.value-h').val();
        var unit_h = changeUnitValueToAttr(obj.find('.form-size-selunit.unit-h').val());
        size += ' ' + height + unit_h;
      }
      sim_target.css('background-size', size);
    } else {
      sim_target.css('background-size', 'unset');
    }
  }
  
  // 色のindexを更新
  const updateBackgroundGradientColorIndex = function(gradient_list) {
    gradient_list.each(function(){
      var colorid = $(this).data('colorid');
      var index = gradient_list.index($(this));
      $(this).find('.form-gradient-index').val(index);
      updateSimulation();
    });
  }
  
  // 変色の色設定エリアを初期化
  var initFormBackgroundGradientColor = function(obj_c) {
    // 色シミュレーション部分を更新
    var updateColorSimulation = function() {
      var hex = obj_c.find('.form-color-txtpicker').val();
      var opacity = obj_c.find('.form-color-selopacity').val();
      if(hex.match(/[a-f\d]{6}/)) {
        var rgb = changeHexToRgb(hex);
        var color = 'rgba(' + rgb['r'] + ', ' + rgb['g'] + ', ' + rgb['b'] + ', ' + opacity + ')';
        obj_c.find('.form-color-show').css('background', color);
        obj_c.find('.form-color-checkbox-check').prop('checked', true);
        obj_c.find('.form-color-checkbox').addClass('checked');
        obj_c.find('.form-color-selopacity').prop('disabled', false);
      } else {
        obj_c.find('.form-color-show').css('background', 'transparent');
        obj_c.find('.form-color-checkbox-check').prop('checked', false);
        obj_c.find('.form-color-checkbox').removeClass('checked');
        obj_c.find('.form-color-selopacity').prop('disabled', true);
      }
    }
    
    // 背景層スライドボタンをクリック
    obj_c.find('.form-gradient-color-btnslide').on('click', function(){
      // ボタンクリックのロックをかける
      var button = $(this);
      var body = obj_c.find('.form-gradient-color-body');
      if(!button.hasClass('working')) {
        button.addClass('working');
        
        // 背景層をスライド
        if(button.hasClass('checked')) {
          button.removeClass('checked');
          body.slideDown(function(){
            button.removeClass('working');
          });
        } else {
          button.addClass('checked');
          body.slideUp(function(){
            button.removeClass('working');
          });
        }
      }
    });
    
    obj_c.find('.form-gradient-color-btndelete').on('click', function(){
      // ボタンクリックのロックをかける
      var button = $(this);
      if(!button.hasClass('working')) {
        button.addClass('working');
        
        // 背景層を削除
        var gradient_list = obj_c.closest('.form-gradient-list');
        var colorid = obj_c.data('colorid');
        obj_c.slideUp(function(){
          obj_c.remove();
          $('.sim-' + target + '-background-' + colorid).remove();
          updateSimulation();
          updateBackgroundLayerIndex(gradient_list.find('.form-gradient-color'));
        });
      }
    });
    
    // ボディー内の色シミュレーション部分をクリック
    obj_c.find('.form-color-show-body').on('click', function(e){
      e.preventDefault();
      if(obj_c.find('.form-color-checkbox').hasClass('checked')) {
        obj_c.find('.form-color-txtpicker').val('');
        updateColorSimulation();
        updateSimulation();
      } else {
        obj_c.find('.form-color-txtpicker').click();
      }
    });
    
    // カラーピーカーを定義
    obj_c.find('.form-color-txtpicker').ColorPicker({
      onSubmit: function(hsb, hex, rgb, el) {
        $(el).val(hex);
        $(el).ColorPickerHide();
        updateColorSimulation();
        updateSimulation();
      },
      onBeforeShow: function () {
        $(this).ColorPickerSetColor(this.value);
      }
    }).bind('keyup', function(){
      $(this).ColorPickerSetColor('#' + this.value);
      updateColorSimulation();
      updateSimulation();
    });
    
    // 透明度変更
    obj_c.find('.form-color-selopacity').on('change', function(){
      // シミュレーション更新
      updateSimulation();
    });
    
    // 変色範囲サイズ変更
    obj_c.find('.form-color-txtsize').on('change keyup', function(){
      // 数値ではない場合0にする
      if(!$(this).val().match(/^[\d,]+(\.\d+)?$/)) {
        $(this).val(0);
      }
      // シミュレーション更新
      updateSimulation();
    });
    
    // 変色範囲単位変更
    obj_c.find('.form-color-selunit').on('change', function(){
      // シミュレーション更新
      updateSimulation();
    });
    
    // 初期化にシミュレーションを一度反映
    updateSimulation();
    
    // 色のindexを更新
    updateBackgroundGradientColorIndex(obj.find('.form-gradient-color'));
  }
  
  // 背景色を追加ボタンをクリック
  obj.find('.form-gradient-button').on('click', function(){
    // ボタンクリックのロックをかける
    var button = $(this);
    if(!button.hasClass('working')) {
      button.addClass('working');
        
      // 背景色部分HTML作成
      var color = parseInt(obj.data('index'));
      var key = target + '__background__' + layerid + '__' + color;
      var id = 'fbg-' + target + '-' + layerid + '-' + color;
      var type = obj.find('.form-gradient-rdotype-radio:checked').val();
      
      html = `
        <div class="form-color form-gradient-color" id="` + id + `" data-colorid="` + color + `">
          <div class="form-gradient-color-header">
            <p class="form-gradient-color-btnsort"></p>
            <div class="form-color-showarea form-gradient-color-showarea">
              <div class="form-color-show">
                <p class="form-color-checkbox form-gradient-color-checkbox">
                  <input class="form-color-checkbox-check" type="checkbox" name="` + key + `__transparent" checked />
                </p>
              </div>
            </div>
            <p class="form-gradient-color-btnslide"></p>
            <p class="form-gradient-color-btndelete"></p>
          </div>
          <div class="form-gradient-color-body">
            <p class="form-color-title">` + translations.color_and_opacity + `</p>
            <div class="form-color-line">
              <div class="form-color-showarea">
                <div class="form-color-show form-color-show-body">
                  <p class="form-color-checkbox">
                    <input class="form-color-checkbox-check" type="checkbox" name="` + key + `__transparent" checked />
                  </p>
                </div>
              </div>
              <p class="form-color-picker">
                <input class="form-color-txtpicker" type="text" maxlength="6" name="` + key + `__color" value="" />
              </p>
              <p class="form-color-opacity">
                <select class="form-color-selopacity" name="` + key + `__opacity" disabled>
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
              </p>
            </div>
            <p class="form-color-title">` + translations.gradient_size + `</p>
            <div class="form-color-line">
              <p class="form-color-size">
                <input class="form-color-txtsize" type="number" name="` + key + `__size" min="0" value="10" />
              </p>
              <p class="form-color-unit">
                <select class="form-color-selunit" name="` + key + `__unit">
                  <option value="percent">%</option>
                  <option value="pixel">px</option>
                </select>
              </p>
              <p class="form-color-percent">%</p>
            </div>
          </div>
          <input type="hidden" class="form-gradient-index" name="` + key + `__index" />
        </div>
      `;
      
      // 新しい色設定エリアを追加
      obj.find('.form-gradient-list').append(html);
      var new_color = obj.find('#' + id);
      new_color.hide();
      
      if(type == 'conic') {
        // 扇型の場合単位は「%」に固定
        new_color.find('.form-color-percent').show();
        new_color.find('.form-color-unit').hide();
      } else {
        // 線型と円型の場合単位を選択させる
        new_color.find('.form-color-percent').hide();
        new_color.find('.form-color-unit').show();
      }
      
      // 背景色をドラッグで並び替え
      obj.find('.form-gradient-list').sortable({
        handle: '.form-gradient-color-btnsort',
        stop: function(e, ui){
          updateSimulation();
          updateBackgroundGradientColorIndex(obj.find('.form-gradient-color'));
        },
      });
      
      // 新しい色設定エリアを初期化して表示
      initFormBackgroundGradientColor(new_color);
      
      // 色設定エリアを表示
      new_color.slideDown(function(){
        // 背景層index更新
        obj.data('index', (color + 1).toString());
        // ボタンクリックのロックを外す
        button.removeClass('working');
      });
    }
  });
  
  // 変色タイプラジオボタンをクリック
  obj.find('.form-gradient-rdotype').on('click', function(e){
    // ラジオボタンクリックのロックをかける
    var button = $(this);
    var button_group = obj.find('.form-gradient-rdotype');
    if(!button.hasClass('working') && !button.hasClass('checked')) {
      button_group.removeClass('checked').addClass('working');
      
      var radio = button.find('.form-gradient-rdotype-radio');
      var option = obj.find('.form-gradient-option');
      var type = radio.val();
      
      // ラジオチェック状態を更新
      radio.prop('checked', true);
      button.addClass('checked');
      
      // 詳細設定部分非表示
      option.slideUp(function(){
        if(type == 'linear') {
          // 線型変色
          // 各色の範囲単位を選択させる
          obj.find('.form-color-percent').hide();
          obj.find('.form-color-unit').show();
          
          // 変色方向設定を表示
          option.find('.form-gradient-direction').show();
          if(obj.find('.form-gradient-seldirection').val() == 'rotate') {
            option.find('.form-gradient-rotate').show();
          } else {
            option.find('.form-gradient-rotate').hide();
          }
          
          // 変色形状設定を非表示
          option.find('.form-gradient-shape').hide();
          
          // 変色中心点設定を非表示
          option.find('.form-gradient-center').hide();
        } else if(type == 'radial') {
          // 円型変色
          // 各色の範囲単位を選択させる
          obj.find('.form-color-percent').hide();
          obj.find('.form-color-unit').show();
          
          // 変色方向設定を非表示
          option.find('.form-gradient-direction').hide();
          option.find('.form-gradient-rotate').hide();
          
          // 変色形状設定を表示
          option.find('.form-gradient-shape').show();
          
          // 変色中心点設定を表示
          option.find('.form-gradient-center').show();
          if(obj.find('.form-gradient-selcenter').val() == 'position') {
            // 変色中心点詳細設定を表示
            option.find('.form-gradient-center-detail').show();
          } else {
            // 変色中心点詳細設定を非表示
            option.find('.form-gradient-center-detail').hide();
          }
        } else if(type == 'conic') {
          // 扇型変色
          // 各色の範囲単位を「%」に固定
          obj.find('.form-color-percent').show();
          obj.find('.form-color-unit').hide();
          
          // 変色方向設定を非表示
          option.find('.form-gradient-direction').hide();
          option.find('.form-gradient-rotate').hide();
          
          // 変色形状設定を非表示
          option.find('.form-gradient-shape').hide();
          
          // 変色中心点設定を表示
          option.find('.form-gradient-center').show();
          if(obj.find('.form-gradient-selcenter').val() == 'position') {
            // 変色中心点詳細設定を表示
            option.find('.form-gradient-center-detail').show();
          } else {
            // 変色中心点詳細設定を非表示
            option.find('.form-gradient-center-detail').hide();
          }
        }
        
        // 詳細設定部分表示
        option.slideDown(function(){
          // シミュレーション更新
          updateSimulation();
          // ラジオボタンクリックのロックを外す
          button_group.removeClass('working');
        });
      });
    }
  });
  
  // 変色重複性チェックボックスをクリック
  obj.find('.form-gradient-chkrepeat').on('click', function(){
    // チェックボックスクリックのロックをかける
    var checkbox = $(this);
    
    if(!checkbox.hasClass('working')) {
      checkbox.addClass('working');
      
      // チェックボックスチェック状態変更
      var check = checkbox.find('.form-gradient-chkrepeat-check');
      if(check.prop('checked')) {
        check.prop('checked', false);
        checkbox.removeClass('checked');
      } else {
        check.prop('checked', true);
        checkbox.addClass('checked');
      }
      
      // シミュレーション更新
      updateSimulation();
      
      // ボタンクリックのロックを外す
      checkbox.removeClass('working');
    }
  });
  
  // 線型変色方向変更
  obj.find('.form-gradient-seldirection').on('change', function(){
    // 選択変更のロックをかける
    var select = $(this);
    if(!select.hasClass('working')) {
      select.addClass('working');
      
      // 選択によって詳細設定部分の表示を切り替える
      if($(this).val() == 'position') {
        obj.find('.form-gradient-rotate').slideDown(function(){
          // シミュレーション更新
          updateSimulation();
          select.removeClass('working');
        });
      } else {
        obj.find('.form-gradient-rotate').slideUp(function(){
          // シミュレーション更新
          updateSimulation();
          select.removeClass('working');
        });
      }
    }
  });
  
  // 線型変色角度変更
  obj.find('.form-gradient-txtrotate').on('keyup change', function() {
    if($(this).val().match(/^[\d,]+(\.\d+)?$/)) {
      // 数値の場合0~359の間に固定
      var rotate = parseInt($(this).val());
      if(rotate < 0) {
        $(this).val(0);
      } else if(rotate > 359) {
        $(this).val(359);
      }
      // 角度シミュレーション更新
      $(this).siblings('.form-gradient-rotate-sim').css('transform', 'rotate(' + $(this).val() + 'deg)');
    } else {
      $(this).val(0);
    }
    // シミュレーション更新
    updateSimulation();
  });
  
  // 円型変色形状選択変更
  obj.find('.form-gradient-selshape').on('change', function() {
    // シミュレーション更新
    updateSimulation();
  });
  
  // 円型・扇型変色中心点位置タイプ変更
  obj.find('.form-gradient-selcenter').on('change', function(){
    // 選択変更のロックをかける
    var select = $(this);
    if(!select.hasClass('working')) {
      select.addClass('working');
      
      // 選択によって詳細設定部分の表示を切り替える
      if($(this).val() == 'position') {
        obj.find('.form-gradient-center-detail').slideDown(function(){
          // シミュレーション更新
          updateSimulation();
          select.removeClass('working');
        });
      } else {
        obj.find('.form-gradient-center-detail').slideUp(function(){
          // シミュレーション更新
          updateSimulation();
          select.removeClass('working');
        });
      }
    }
  });
  
  // 円型・扇型変色中心点位置座標変更
  obj.find('.form-position-txtcenterdistance').on('keyup change', function(){
    // 数値ではない場合0にする
    if(!$(this).val().match(/^[\d,]+(\.\d+)?$/)) {
      $(this).val(0);
    }
    // シミュレーション更新
    updateSimulation();
  });
  
  // 円型・扇型変色中心点位置単位選択変更
  obj.find('.form-position-selcenterunit').on('change', function(){
    // シミュレーション更新
    updateSimulation();
  });
  
  // 完全に背景カバーボタンをクリック
  obj.find('.form-size-chkunset').on('click', function(){
    // チェックボックスクリックのロックをかける
    var checkbox = $(this);
    
    if(!checkbox.hasClass('working')) {
      checkbox.addClass('working');
      
      // チェックボックスチェック状態変更
      var check = checkbox.find('.form-size-chkunset-check');
      if(check.prop('checked')) {
        check.prop('checked', false);
        checkbox.removeClass('checked');
        // 画像サイズ詳細設定部分表示
        checkbox.closest('.form-size').find('.form-size-setting').slideDown(function(){
          // シミュレーション更新
          updateSimulation();
          // ボタンクリックのロックを外す
          checkbox.removeClass('working');
        });
      } else {
        check.prop('checked', true);
        checkbox.addClass('checked');
        // 画像サイズ詳細設定部分非表示
        checkbox.closest('.form-size').find('.form-size-setting').slideUp(function(){
          // シミュレーション更新
          updateSimulation();
          // ボタンクリックのロックを外す
          checkbox.removeClass('working');
        });
      }
    }
  });
  
  // 背景サイズ入力変更
  obj.find('.form-size-txtvalue').on('keyup change', function(){
    // 数値ではない場合0にする
    if(!$(this).val().match(/^[\d,]+(\.\d+)?$/)) {
      $(this).val(0);
    }
    // シミュレーション更新
    updateSimulation();
  });
  
  // 背景サイズ単位変更
  obj.find('.form-size-selunit').on('change', function(){
    // シミュレーション更新
    updateSimulation();
  });
  
  // 背景重複性チェックボックスをクリック
  obj.find('.form-background-chkrepeat').on('click', function(){
    // チェックボックスクリックのロックをかける
    var checkbox = $(this);
    
    if(!checkbox.hasClass('working')) {
      checkbox.addClass('working');
      
      // チェックボックスチェック状態変更
      var check = checkbox.find('.form-background-chkrepeat-check');
      if(check.prop('checked')) {
        check.prop('checked', false);
        checkbox.removeClass('checked');
      } else {
        check.prop('checked', true);
        checkbox.addClass('checked');
      }
      
      // シミュレーション更新
      updateSimulation();
      
      // ボタンクリックのロックを外す
      checkbox.removeClass('working');
    }
  });
  
  // 背景位置タイプ選択変更
  obj.find('.form-position-selposition').on('change', function(){
    // 選択変更のロックをかける
    var select = $(this);
    if(!select.hasClass('working')) {
      select.addClass('working');
      
      // 選択によって詳細設定部分の表示を切り替える
      if($(this).val() == 'custom') {
        $(this).closest('.form-position').find('.form-position-detail').slideDown(function(){
          // シミュレーション更新
          updateSimulation();
          select.removeClass('working');
        });
      } else {
        $(this).closest('.form-position').find('.form-position-detail').slideUp(function(){
          // シミュレーション更新
          updateSimulation();
          select.removeClass('working');
        });
      }
    }
  });
  
  // 背景位置出発方向選択変更
  obj.find('.form-position-selfrom').on('change', function(){
    // シミュレーション更新
    updateSimulation();
  });
  
  // 背景画像位置距離入力変更
  obj.find('.form-position-txtdistance').on('keyup change', function() {
    // 数値ではない場合0にする
    if(!$(this).val().match(/^[\d,]+(\.\d+)?$/)) {
      $(this).val(0);
    }
    // シミュレーション更新
    updateSimulation();
  });
  
  // 背景画像位置単位変更
  obj.find('.form-position-selunit').on('change', function() {
    // シミュレーション更新
    updateSimulation();
  });
  
  // 初期化にシミュレーションを一度反映
  updateSimulation();
  
  // 既存色設定エリアを初期化
  obj.find('.form-gradient-color').each(function(){
    initFormBackgroundGradientColor($(this));
  });
}


// レスポンシブ対応部分本体(背景層編集エリア)を初期化
const initFormBackgroundResponsiveArea = function(obj) {
  // 背景層タイプを選択
  obj.find('.form-background-seltype').on('change', function(){
    // 選択変更のロックをかける
    var select = $(this);
    if(!select.hasClass('working')) {
      select.addClass('working');
      
      var content = obj.find('.form-background-content');
      
      var target = obj.closest('.form-block').data('target');
      var layerid = parseInt(obj.closest('.form-background-layer').data('layerid'));
      var key = target + '__background__' + layerid;
      var type = select.val();
      
      content.slideUp(function(){
        // 背景層各タイプエリアHTML作成
        var html = '';
        if(type == 'solid') {
          // 純色タイプ背景
          html = `
            <div class="form-solid form-color">
              <p class="form-color-title">` + translations.color_and_opacity + `</p>
              <div class="form-color-line">
                <div class="form-color-showarea">
                  <div class="form-color-show">
                    <p class="form-color-checkbox">
                      <input class="form-color-checkbox-check" type="checkbox" name="` + key + `__transparent" checked />
                    </p>
                  </div>
                </div>
                <p class="form-color-picker">
                  <input class="form-color-txtpicker" type="text" maxlength="6" name="` + key + `__color" value="" />
                </p>
                <p class="form-color-opacity">
                  <select class="form-color-selopacity" name="` + key + `__opacity" disabled>
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
                </p>
              </div>
            </div>
          `;
          
          // 純色編集エリアを初期化
          content.html(html);
          initFormBackgroundSolid(obj.find('.form-solid'));
        } else if(type == 'picture') {
          // 画像タイプ背景
          html = `
            <div class="form-picture">
              <div class="form-upload" data-url="">
                <p class="form-upload-text">` + translations.file_upload + `</p>
                <p class="form-upload-btndelete"></p>
                <label class="form-upload-btnupload">
                  <input type="file" class="form-upload-file" />
                </label>
                <input type="hidden" class="form-upload-image" name="` + key + `__image" value="" />
              </div>
              <p class="form-checkbox form-background-chkrepeat">
                <input class="form-background-chkrepeat-check" type="checkbox" name="` + key + `__repeat" />` + translations.background_repeat + `
              </p>
              <div class="form-position">
                <p class="form-position-title">` + translations.background_position + `</p>
                <p class="form-position-position">
                  <select class="form-position-selposition" name="` + key + `__position">
                    <option value="center">` + translations.background_center + `</option>
                    <option value="top">` + translations.background_top + `</option>
                    <option value="bottom">` + translations.background_bottom + `</option>
                    <option value="left">` + translations.background_left + `</option>
                    <option value="right">` + translations.background_right + `</option>
                    <option value="top left">` + translations.background_top_left + `</option>
                    <option value="top right">` + translations.background_top_right + `</option>
                    <option value="bottom left">` + translations.background_bottom_left + `</option>
                    <option value="bottom right">` + translations.background_bottom_right + `</option>
                    <option value="custom">` + translations.background_custom_position + `</option>
                  </select>
                </p>
                <div class="form-position-detail" style="display: none;">
                  <div class="form-position-line">
                    <p class="form-position-key">
                      <select class="form-position-selfrom from-y" name="` + key + `__from_y">
                        <option value="top">` + translations.from_top + `</option>
                        <option value="bottom">` + translations.from_bottom + `</option>
                      </select>
                    </p>
                    <p class="form-position-distance">
                      <input class="form-position-txtdistance distance-y" type="number" name="` + key + `__distance_y" value="0" />
                    </p>
                    <p class="form-position-unit">
                      <select class="form-position-selunit unit-y" name="` + key + `__unit_y">
                        <option value="percent">%</option>
                        <option value="pixel">px</option>
                      </select>
                    </p>
                  </div>
                  <div class="form-position-line">
                    <p class="form-position-key">
                      <select class="form-position-selfrom from-x" name="` + key + `__from_x">
                        <option value="left">` + translations.from_left + `</option>
                        <option value="right">` + translations.from_right + `</option>
                      </select>
                    </p>
                    <p class="form-position-distance">
                      <input class="form-position-txtdistance distance-x" type="number" name="` + key + `__distance_x" value="0" />
                    </p>
                    <p class="form-position-unit">
                      <select class="form-position-selunit unit-x" name="` + key + `__unit_x">
                        <option value="percent">%</option>
                        <option value="pixel">px</option>
                      </select>
                    </p>
                  </div>
                </div>
              </div>
              <div class="form-size">
                <p class="form-size-title">` + translations.background_size + `</p>
                <div class="form-size-unset">
                  <p class="form-checkbox form-size-chkunset checked">
                    <input class="form-size-chkunset-check" type="checkbox" name="` + key + `__unset" checked />` + translations.original_size + `
                  </p>
                </div>
                <div class="form-size-setting" style="display: none;">
                  <div class="form-size-proportion">
                    <p class="form-checkbox form-size-chkproportion checked">
                      <input class="form-size-chkproportion-check" type="checkbox" name="` + key + `__proportion" checked />` + translations.keep_proportion + `
                    </p>
                  </div>
                  <div class="form-size-size">
                    <div class="form-size-line line-width">
                      <p class="form-size-key">` + translations.width + `</p>
                      <p class="form-size-value">
                        <input class="form-size-txtvalue value-w" type="number" min="0" name="` + key + `__width" value="100" />
                      </p>
                      <p class="form-size-unit">
                        <select class="form-size-selunit unit-w" name="` + key + `__unit_w">
                          <option value="percent">%</option>
                          <option value="pixel">px</option>
                        </select>
                      </p>
                    </div>
                    <div class="form-size-line line-height" style="display: none;">
                      <p class="form-position-key">` + translations.height + `</p>
                      <p class="form-size-value">
                        <input class="form-size-txtvalue value-h" type="number" min="0" name="` + key + `__height" value="100" />
                      </p>
                      <p class="form-size-unit">
                        <select class="form-size-selunit unit-h" name="` + key + `__unit_h">
                          <option value="percent">%</option>
                          <option value="pixel">px</option>
                        </select>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          `;
          
          // 背景図編集エリアを初期化
          content.html(html);
          initFormBackgroundPicture(obj.find('.form-picture'));
        } else if(type == 'gradient') {
          // 変色タイプ背景
          html = `
            <div class="form-gradient" data-index="0">
              <div class="form-gradient-list"></div>
              <p class="form-gradient-button">` + translations.add_gradient + `</p>
              <div class="form-gradient-type">
                <div class="form-gradient-rdotype checked">
                  <p class="form-gradient-rdotype-preview preview-solid"></p>
                  <p class="form-gradient-rdotype-title">` + translations.gradient_linear + `</p>
                  <input type="radio" class="form-gradient-rdotype-radio" name="` + key + `__type" value="linear" checked />
                </div>
                <div class="form-gradient-rdotype">
                  <p class="form-gradient-rdotype-preview preview-radial"></p>
                  <p class="form-gradient-rdotype-title">` + translations.gradient_radial + `</p>
                  <input type="radio" class="form-gradient-rdotype-radio" name="` + key + `__type" value="radial" />
                </div>
                <div class="form-gradient-rdotype">
                  <p class="form-gradient-rdotype-preview preview-conic"></p>
                  <p class="form-gradient-rdotype-title">` + translations.gradient_conic + `</p>
                  <input type="radio" class="form-gradient-rdotype-radio" name="` + key + `__type" value="conic" />
                </div>
              </div>
              <p class="form-checkbox form-background-chkrepeat form-gradient-chkrepeat">
                <input class="form-gradient-chkrepeat-check" type="checkbox" name="` + key + `__grepeat" />` + translations.gradient_repeat + `
              </p>
              <div class="form-gradient-option">
                <p class="form-gradient-direction">
                  <select class="form-gradient-seldirection" name="` + key + `__direction">
                    <option value="to bottom">` + translations.gradient_to_bottom + `</option>
                    <option value="to right">` + translations.gradient_to_right + `</option>
                    <option value="to top right">` + translations.gradient_to_top_right + `</option>
                    <option value="to bottom right">` + translations.gradient_to_bottom_right + `</option>
                    <option value="rotate">` + translations.gradient_custom_rotate + `</option>
                  </select>
                </p>
                <div class="form-gradient-rotate" style="display: none;">
                  <div class="form-gradient-rotate-inner">
                    <p class="form-gradient-rotate-title">` + translations.gradient_rotate + `</p>
                    <input class="form-gradient-txtrotate" type="number" maxlength="3" max="359" min="0" name="` + key + `__rotate" value="0" />
                    <p class="form-gradient-rotate-sim"></p>
                  </div>
                </div>
                <p class="form-gradient-shape" style="display: none;">
                  <select class="form-gradient-selshape" name="` + key + `__shape">
                    <option value="ellipse">` + translations.gradient_ellipse + `</option>
                    <option value="circle">` + translations.gradient_circle + `</option>
                  </select>
                </p>
                <div class="form-position form-gradient-center" style="display: none;">
                  <p class="form-position-title">` + translations.gradient_center + `</p>
                  <p class="form-position-position">
                    <select class="form-gradient-selcenter" name="` + key + `__centerunit">
                      <option value="center">` + translations.background_center + `</option>
                      <option value="top">` + translations.background_top + `</option>
                      <option value="bottom">` + translations.background_bottom + `</option>
                      <option value="left">` + translations.background_left + `</option>
                      <option value="right">` + translations.background_right + `</option>
                      <option value="top left">` + translations.background_top_left + `</option>
                      <option value="top right">` + translations.background_top_right + `</option>
                      <option value="bottom left">` + translations.background_bottom_left + `</option>
                      <option value="bottom right">` + translations.background_bottom_right + `</option>
                      <option value="position">` + translations.background_custom_position + `</option>
                    </select>
                  </p>
                  <div class="form-position-detail form-gradient-center-detail">
                    <div class="form-position-line">
                      <p class="form-position-key">` + translations.gradient_center_position_x + `</p>
                      <p class="form-position-distance">
                        <input class="form-position-txtcenterdistance centerdistance-x" type="number" min="0" name="` + key + `__centerdistance_x" value="0" />
                      </p>
                      <p class="form-position-unit">
                        <select class="form-position-selcenterunit centerunit-x" name="` + key + `__centerunit_x">
                          <option value="percent">%</option>
                          <option value="pixel">px</option>
                        </select>
                      </p>
                    </div>
                    <div class="form-position-line">
                      <p class="form-position-key">` + translations.gradient_center_position_y + `</p>
                      <p class="form-position-distance">
                        <input class="form-position-txtcenterdistance centerdistance-y" type="number" min="0" name="` + key + `__centerdistance_y" value="0" />
                      </p>
                      <p class="form-position-unit">
                        <select class="form-position-selcenterunit centerunit-y" name="` + key + `__centerunit_y">
                          <option value="percent">%</option>
                          <option value="pixel">px</option>
                        </select>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-size">
                <p class="form-size-title">` + translations.background_size + `</p>
                <div class="form-size-unset">
                  <p class="form-checkbox form-size-chkunset checked">
                    <input class="form-size-chkunset-check" type="checkbox" name="` + key + `__unset" checked />` + translations.background_full_size + `
                  </p>
                </div>
                <div class="form-size-setting" style="display: none;">
                  <div class="form-size-size">
                    <div class="form-size-line line-width">
                      <p class="form-size-key">` + translations.width + `</p>
                      <p class="form-size-value">
                        <input class="form-size-txtvalue value-w" type="number" min="0" name="` + key + `__width" value="100" />
                      </p>
                      <p class="form-size-unit">
                        <select class="form-size-selunit unit-w" name="` + key + `__unit_w">
                          <option value="percent">%</option>
                          <option value="pixel">px</option>
                        </select>
                      </p>
                    </div>
                    <div class="form-size-line line-height">
                      <p class="form-position-key">` + translations.height + `</p>
                      <p class="form-size-value">
                        <input class="form-size-txtvalue value-h" type="number" min="0" name="` + key + `__height" value="100" />
                      </p>
                      <p class="form-size-unit">
                        <select class="form-size-selunit unit-h" name="` + key + `__unit_h">
                          <option value="percent">%</option>
                          <option value="pixel">px</option>
                        </select>
                      </p>
                    </div>
                  </div>
                  <p class="form-checkbox form-background-chkrepeat">
                    <input class="form-background-chkrepeat-check" type="checkbox" name="` + key + `__brepeat" />` + translations.background_repeat + `
                  </p>
                  <div class="form-position">
                    <p class="form-position-title">` + translations.background_position + `</p>
                    <p class="form-position-position">
                      <select class="form-position-selposition" name="` + key + `__position">
                        <option value="center">` + translations.background_center + `</option>
                        <option value="top">` + translations.background_top + `</option>
                        <option value="bottom">` + translations.background_bottom + `</option>
                        <option value="left">` + translations.background_left + `</option>
                        <option value="right">` + translations.background_right + `</option>
                        <option value="top left">` + translations.background_top_left + `</option>
                        <option value="top right">` + translations.background_top_right + `</option>
                        <option value="bottom left">` + translations.background_bottom_left + `</option>
                        <option value="bottom right">` + translations.background_bottom_right + `</option>
                        <option value="custom">` + translations.background_custom_position + `</option>
                      </select>
                    </p>
                    <div class="form-position-detail" style="display: none;">
                      <div class="form-position-line">
                        <p class="form-position-key">
                          <select class="form-position-selfrom from-y" name="` + key + `__from_y">
                            <option value="top">` + translations.from_top + `</option>
                            <option value="bottom">` + translations.from_bottom + `</option>
                          </select>
                        </p>
                        <p class="form-position-distance">
                          <input class="form-position-txtdistance distance-y" type="number" name="` + key + `__distance_y" value="0" />
                        </p>
                        <p class="form-position-unit">
                          <select class="form-position-selunit unit-y" name="` + key + `__unit_y">
                            <option value="percent">%</option>
                            <option value="pixel">px</option>
                          </select>
                        </p>
                      </div>
                      <div class="form-position-line">
                        <p class="form-position-key">
                          <select class="form-position-selfrom from-x" name="` + key + `__from_x">
                            <option value="left">` + translations.from_left + `</option>
                            <option value="right">` + translations.from_right + `</option>
                          </select>
                        </p>
                        <p class="form-position-distance">
                          <input class="form-position-txtdistance distance-x" type="number" name="` + key + `__distance_x" value="0" />
                        </p>
                        <p class="form-position-unit">
                          <select class="form-position-selunit unit-x" name="` + key + `__unit_x">
                            <option value="percent">%</option>
                            <option value="pixel">px</option>
                          </select>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          `;
          
          // 変色編集エリアを初期化
          content.html(html);
          initFormBackgroundGradient(obj.find('.form-gradient'));
        }
        
        content.slideDown(function(){
          // 選択変更のロックを外す
          select.removeClass('working');
        });
      });
    }
  });
  
  // 既存背景層編集エリアを初期化
  obj.find('.form-solid').each(function(){
    initFormBackgroundSolid($(this));
  });
  obj.find('.form-picture').each(function(){
    initFormBackgroundPicture($(this));
  });
  obj.find('.form-gradient').each(function(){
    initFormBackgroundGradient($(this));
  });
}


// スタイル編集のレスポンシブ対応部分を初期化
const initFormBackgroundResponsive = function(obj) {
  // 編集対象取得用の変数を定義
  var target = obj.closest('.form-block').data('target');
  var layerid = obj.closest('.form-background-layer').data('layerid');
  
  // PC/SPのみ表示の選択を変更
  obj.find('.form-responsive-chkdevice').on('click', function(){
    // チェックボックスクリックのロックをかける
    var checkbox = $(this);
    
    if(!checkbox.hasClass('working')) {
      checkbox.addClass('working');
      
      var check = checkbox.find('.form-responsive-chkdevice-check');
      var flag = obj.find('.form-responsive-chkflag');
      
      var device = 'pc';
      var other = 'sp';
      if(checkbox.hasClass('setting-sp')) {
        device = 'sp';
        other = 'pc';
      }
      
      if(check.prop('checked')) {
        // PC/SPのみ表示を無効にする
        check.prop('checked', false);
        checkbox.removeClass('checked');
        
        // デバイスがどちらでも設定部分の背景層を表示する
        obj.closest('.form-responsive-target').removeClass('setting-' + device).removeClass('active');
        // レスポンシブ対応ボタン部分を表示
        flag.slideDown(function() {
          // 相応シミュレーションを非表示
          $('#sim-' + target + '-background-' + layerid + '-' + other).show();
          checkbox.removeClass('working');
        });
      } else {
        // PC/SPのみ表示を有効にする
        check.prop('checked', true);
        checkbox.addClass('checked');
        
        // デバイスがPCの場合のみ設定部分の背景層を表示する
        obj.closest('.form-responsive-target').addClass('setting-' + device).addClass('active');
        // レスポンシブ対応ボタン部分を非表示
        flag.slideUp(function(){
          // 相応シミュレーションを非表示
          $('#sim-' + target + '-background-' + layerid + '-' + other).hide();
          checkbox.removeClass('working');
        });
      }
    }
  });
  
  // レスポンシブ対応の選択を変更
  obj.find('.form-responsive-chkflag').on('click', function(){
    // チェックボックスクリックのロックをかける
    var checkbox = $(this);
    
    if(!checkbox.hasClass('working')) {
      checkbox.addClass('working');
      
      var check = checkbox.find('.form-responsive-chkflag-check');
      var device = $('.header-sim-device.checked').data('device');
      
      if(check.prop('checked')) {
        // レスポンシブ対応を無効にする
        check.prop('checked', false);
        checkbox.removeClass('checked');
        
        // 現在表示しない編集エリアを削除
        obj.find('.form-responsive-area').not('.active').remove();
        
        // PC/SP表示コントロール用クラスを削除
        var responsive_area = obj.find('.form-responsive-area');
        responsive_area.removeClass('active').removeClass('setting-pc').removeClass('setting-sp');
        
        if(device == 'pc') {
          // シミュレーションの相応部分のPCスタイルをSPスタイルにコピー
          $('#sim-' + target + '-background-' + layerid + '-sp').css('background', $('#sim-' + target + '-background-' + layerid + '-pc').css('background'));
        } else {
          // シミュレーションの相応部分のPCスタイルをSPスタイルにコピー
          $('#sim-' + target + '-background-' + layerid + '-pc').css('background', $('#sim-' + target + '-background-' + layerid + '-sp').css('background'));
          
          // 入力のnameの「__sp」を消す
          responsive_area.find('input, select').each(function(){
            $(this).prop('name', check.prop('name').replace('__sp', ''));
          });
        }
      } else {
        // レスポンシブ対応を有効にする
        check.prop('checked', true);
        checkbox.addClass('checked');
        
        // SPサイト編集エリア用HTML文を追加し、PC/SP表示コントロール用クラスを追加
        var responsive_area = obj.find('.form-responsive-area');
        responsive_area.addClass('setting-pc');
        responsive_area.before(responsive_area.prop('outerHTML').replace('setting-pc', 'setting-sp'));
        var responsive_area_sp = obj.find('.form-responsive-area.setting-sp');
        
        // 現在編集中の端末の編集エリアのみを表示
        obj.find('.form-responsive-area.setting-' + device).addClass('active');
        
        // SPサイト入力に対して値をコピーし、nameに「__sp」を付ける
        responsive_area_sp.find('input, select').each(function(){
          var name = $(this).prop('name');
          $(this).prop('name', name + '__sp');
          $(this).val(responsive_area.find('[name="' + name + '"]').val());
        });
        
        // SPサイト入力部分を初期化し直す
        initFormBackgroundResponsiveArea(responsive_area_sp);
      }
      
      checkbox.removeClass('working');
    }
  });
  
  // レスポンシブ対応部分本体を初期化
  obj.find('.form-responsive-area').each(function(){
    initFormBackgroundResponsiveArea($(this));
  });
}


// 背景編集ブロックを初期化
const initFormBackgroundLayer = function(obj) {
  // 背景層スライドボタンをクリック
  obj.find('.form-background-btnslide').on('click', function(){
    // ボタンクリックのロックをかける
    var button = $(this);
    var body = obj.find('.form-background-body');
    if(!button.hasClass('working')) {
      button.addClass('working');
      
      // 背景層をスライド
      if(button.hasClass('checked')) {
        button.removeClass('checked');
        body.slideDown(function(){
          button.removeClass('working');
        });
      } else {
        button.addClass('checked');
        body.slideUp(function(){
          button.removeClass('working');
        });
      }
    }
  });
  
  // 背景層削除ボタンをクリック
  obj.find('.form-background-btndelete').on('click', function(){
    // ボタンクリックのロックをかける
    var button = $(this);
    if(!button.hasClass('working')) {
      button.addClass('working');
      
      // 背景層を削除
      var layerlist = obj.closest('.form-background-layerlist');
      var target = obj.closest('.form-block').data('target');
      var layerid = obj.data('layerid');
      layer.slideUp(function(){
        layer.remove();
        $('.sim-' + target + '-background-' + layerid).remove();
        updateBackgroundLayerIndex(layerlist.find('.form-background-layer'));
      });
    }
  });
  
  // レスポンシブ対応を有効化
  obj.find('.form-responsive').each(function(){
    initFormBackgroundResponsive($(this));
  });
}


// 背景編集エリアを初期化
const initFormBackground = function(obj) {
  // 背景層追加ボタンをクリック
  obj.find('.form-background-btninsert').on('click', function(){
    // ボタンクリックのロックをかける
    var button = $(this);
    if(!button.hasClass('working')) {
      button.addClass('working');
      
      // 背景層HTML作成
      var lastid = parseInt(obj.data('lastid'));
      var target = obj.closest('.form-block').data('target');
      var key = target + '__background__' + lastid;
      var class_pc = '';
      var class_sp = '';
      var device = $('.header-sim-device.checked').data('device');
      if(device == 'pc') {
        class_pc = 'active';
      } else {
        class_sp = 'active';
      }
      var html = `
        <div class="form-background-layer form-responsive-target" id="fbl-` + target + `-` + lastid + `" data-layerid="` + lastid + `" style="display: none;">
          <div class="form-background-header">
            <p class="form-background-btnsort"></p>
            <p class="form-background-name">
              <input type="text" name="` + key + `__name" value="` + translations.background_layer + (lastid + 1).toString() + `" 
                  placeholder="` + translations.background_layer_name_ph + `" />
            </p>
            <p class="form-background-btnslide"></p>
            <p class="form-background-btndelete"></p>
          </div>
          <div class="form-background-body form-responsive">
            <div class="form-responsive-controller">
              <p class="form-checkbox form-responsive-checkbox form-responsive-chkdevice setting-pc ` + class_pc + `">
                <input type="checkbox" name="` + key + `__pc" class="form-responsive-chkdevice-check"/>` + translations.responsive_pc + `
              </p>
              <p class="form-checkbox form-responsive-checkbox form-responsive-chkdevice setting-sp ` + class_sp + `">
                <input type="checkbox" name="` + key + `__sp" class="form-responsive-chkdevice-check" />` + translations.responsive_sp + `
              </p>
              <p class="form-checkbox form-responsive-checkbox form-responsive-chkflag">
                <input type="checkbox" name="` + key + `__responsive" class="form-responsive-chkflag-check" />` + translations.responsive_flag + `
              </p>
            </div>
            <div class="form-responsive-area">
              <p class="form-background-type">
                <select class="form-background-seltype" name="` + key + `__type">
                  <option value="" hidden>` + translations.background_type_ph + `</option>
                  <option value="solid">` + translations.background_solid + `</option>
                  <option value="picture">` + translations.background_picture + `</option>
                  <option value="gradient">` + translations.background_gradient + `</option>
                </select>
              </p>
              <div class="form-background-content">
              </div>
            </div>
          </div>
          <input type="hidden" class="form-background-index" name="` + key + `__index" value="0" />
        </div>
      `;
      
      // 背景層HTMLを追加して一時的に非表示
      obj.find('.form-background-layerlist').prepend(html);
      var layer = $('#fbl-' + target + '-' + lastid.toString());
      
      // 相応シミュレーションブロックを追加
      var key_sim = 'sim-' + target + '-background-' + lastid.toString();
      $('#sim-' + target + '-pc').append('<div class="sim-background ' + key_sim + '" id="' + key_sim + '-pc"></div>');
      $('#sim-' + target + '-sp').append('<div class="sim-background ' + key_sim + '" id="' + key_sim + '-sp"></div>');
      
      // 背景ブロック動作を有効化
      initFormBackgroundLayer(layer);
      
      // 背景編集エリアlastid更新
      obj.data('lastid', (lastid + 1).toString());
      
      // 背景層index更新
      updateBackgroundLayerIndex(obj.find('.form-background-layer'));
      
      // 背景層を表示
      layer.slideDown(function(){
        // ボタンクリックのロックを外す
        button.removeClass('working');
      });
    }
  });
  
  // 背景層をドラッグで並び替え
  obj.find('.form-background-layerlist').sortable({
    handle: '.form-background-btnsort',
    stop: function(e, ui){
      updateBackgroundLayerIndex(obj.find('.form-background-layer'));
    },
  });
  
  // 背景層index初期化
  updateBackgroundLayerIndex(obj.find('.form-background-layer'));
  
  // 既存背景層を初期化
  obj.find('.form-background-layer').each(function(){
    initFormBackgroundLayer($(this));
  });
}