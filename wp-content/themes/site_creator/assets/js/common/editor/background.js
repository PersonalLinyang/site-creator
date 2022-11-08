// 背景編集ブロックのindex更新
const updateBackgroundLayerIndex = function(layer_list) {
  layer_list.each(function(){
    var target = $(this).closest('.form-block').data('target');
    var index = $(this).data('index');
    var number = layer_list.index($(this));
    $(this).find('.form-background-index').val(number);
    $('.sim-' + target + '-background-' + index).css('z-index', 0 - number - 1);
  });
}

var changeHexToRgb = function(hex) {
  var result = /^([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  return result ? {
    r: parseInt(result[1], 16),
    g: parseInt(result[2], 16),
    b: parseInt(result[3], 16)
  } : null;
}

var changeUnitValueToAttr = function(unit) {
  var result = '';
  if(unit == 'pixel') {
    result = 'px';
  } else if(unit == 'percent') {
    result = '%';
  }
  return result;
}


// 背景編集ブロック純色エリアを初期化
const initFormBackgroundSolid = function(obj) {
  // 重複初期化回避
  if(!obj.hasClass('inited')) {
    obj.addClass('inited');
    
    var picker = obj.find('.form-color-picker');
    var show = obj.find('.form-color-show');
    var checkbox = obj.find('.form-color-checkbox');
    var check = obj.find('.form-color-checkbox-check');
    var opacity = obj.find('.form-color-opacity');
    var target = obj.closest('.form-block').data('target');
    var layer = obj.closest('.form-background-layer').data('index');
    
    var updateSimulation = function() {
      var hex = picker.val();
      var opa = opacity.val();
      var sim_target = $('.sim-' + target + '-background-' + layer);
      if(obj.closest('.form-responsive-area').hasClass('setting-pc')) {
        sim_target = $('#sim-' + target + '-background-' + layer + '-pc');
      } else if(obj.closest('.form-responsive-area').hasClass('setting-sp')) {
        sim_target = $('#sim-' + target + '-background-' + layer + '-sp');
      }
      
      if(hex.match(/[a-f\d]{6}/) && opa.match(/[0-1]{1}(\.[1-9]){0,1}/)) {
        var rgb = changeHexToRgb(hex);
        var color = 'rgba(' + rgb['r'] + ', ' + rgb['g'] + ', ' + rgb['b'] + ', ' + opa + ')';
        sim_target.css('background', color);
        show.css('background', color);
        check.prop('checked', true);
        checkbox.addClass('checked');
        opacity.prop('disabled', false);
      } else {
        sim_target.css('background', 'transparent');
        show.css('background', 'transparent');
        check.prop('checked', false);
        checkbox.removeClass('checked');
        opacity.prop('disabled', true);
      }
    }
    
    var checkFormBackgroundSolidHex = function() {
      var hex = picker.val();
      var opa = opacity.val();
      if(hex.match(/[a-f\d]{6}/)) {
        var rgb = changeHexToRgb(hex);
        var color = 'rgba(' + rgb['r'] + ', ' + rgb['g'] + ', ' + rgb['b'] + ', ' + opa + ')';
        show.css('background', color);
        check.prop('checked', true);
        checkbox.addClass('checked');
        opacity.prop('disabled', false);
      } else {
        show.css('background', 'transparent');
        check.prop('checked', false);
        checkbox.removeClass('checked');
        opacity.prop('disabled', true);
      }
    }
    
    checkFormBackgroundSolidHex();
    updateSimulation();
    
    show.on('click', function(e){
      e.preventDefault();
      if(checkbox.hasClass('checked')) {
        picker.val('');
        checkFormBackgroundSolidHex();
        updateSimulation();
      } else {
        picker.click();
      }
    });
    
    picker.ColorPicker({
      onSubmit: function(hsb, hex, rgb, el) {
        $(el).val(hex);
        $(el).ColorPickerHide();
        checkFormBackgroundSolidHex();
        updateSimulation();
      },
      onBeforeShow: function () {
        $(this).ColorPickerSetColor(this.value);
      }
    }).bind('keyup', function(){
      $(this).ColorPickerSetColor('#' + this.value);
      checkFormBackgroundSolidHex();
      updateSimulation();
    });
    
    opacity.on('change', function(){
      updateSimulation();
    });
  }
}

// 背景編集ブロック変色エリアを初期化
const initFormBackgroundGradient = function(obj) {
  // 重複初期化回避
  if(!obj.hasClass('inited')) {
    obj.addClass('inited');
    
    var option = obj.find('.form-gradient-option');
    var target = obj.closest('.form-block').data('target');
    var layer = parseInt(obj.closest('.form-background-layer').data('index'));
    
    var updateSimulation = function() {
      var type = obj.find('.form-gradient-type-radio:checked').val();
      
      var sim_target = $('.sim-' + target + '-background-' + layer);
      if(obj.closest('.form-responsive-area').hasClass('setting-pc')) {
        sim_target = $('#sim-' + target + '-background-' + layer + '-pc');
      } else if(obj.closest('.form-responsive-area').hasClass('setting-sp')) {
        sim_target = $('#sim-' + target + '-background-' + layer + '-sp');
      }
      
      var background = '';
      if(obj.find('.form-background-repeat-button-check').prop('checked')) {
        background = 'repeating-';
      }
      background += type + '-gradient(';
      
      done_flag = true;
      if(type == 'linear') {
        var direction = obj.find('.form-gradient-direction-select').val();
        if(direction == 'rotate') {
          var rotate = $('.form-gradient-rotate-input').val();
          if(rotate.match(/^\d+$/)) {
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
        if(type == 'radial') {
          var shape = obj.find('.form-gradient-shape-select').val();
          if(shape != '') {
            background += shape + ' at ';
          } else {
            done_flag = false;
          }
        } else {
          background += ' from 0deg at '
        }
        
        var center = obj.find('.form-gradient-center-select').val();
        if(center == 'position') {
          var number_x = obj.find('.form-gradient-position-number.number-x').val();
          var number_y = obj.find('.form-gradient-position-number.number-y').val();
          var unit_x = changeUnitValueToAttr(obj.find('.form-gradient-position-unit.unit-x').val());
          var unit_y = changeUnitValueToAttr(obj.find('.form-gradient-position-unit.unit-y').val());
          
          if(number_x.match(/^\d+$/) && number_y.match(/^\d+$/) && unit_x && unit_y) {
            background += number_x + unit_x + ' ' + number_y + unit_y + ' ';
          } else {
            done_flag = false;
          }
        } else if(center != '') {
          background += center + ' ';
        } else {
          done_flag = false;
        }
      }
      
      if(done_falg = true) {
        var calc_percent = 0;
        var calc_pixel = 0;
        var counter = 0;
        
        var color = 'transparent';
        
        obj.find('.form-gradient-color').each(function(){
          var check = $(this).find('.form-color-checkbox-check');
          var hex = $(this).find('.form-color-picker').val();
          var opa = $(this).find('.form-color-opacity').val();
          var size = $(this).find('.form-color-size').val();
          var unit = $(this).find('.form-color-unit').val();
          
          color = 'transparent';
          var sv = 0;
          
          if(check.prop('checked')) {
            if(hex.match(/[a-f\d]{6}/) && opa.match(/[0-1]{1}(\.[1-9]){0,1}/)) {
              var rgb = changeHexToRgb(hex);
              color = 'rgba(' + rgb['r'] + ', ' + rgb['g'] + ', ' + rgb['b'] + ', ' + opa + ')';
            }
          }
          
          if(size.match(/^\d+$/)) {
            sv = parseInt(size);
          } else {
            return true;  // continue
          }
          
          if(type ==  'conic') {
            calc_percent += sv;
            background += ', ' + color + ' ' + calc_percent + '% ';
          } else {
            if(unit == 'pixel') {
              calc_pixel += sv;
            } else if(unit == 'percent') {
              calc_percent += sv;
            } else {
              return true;  // continue
            }
            background += ', ' + color + ' calc(' + calc_percent + '% + ' + calc_pixel + 'px) ';
          }
          
          counter++;
        });
        
        background += ')';
        
        if(counter == 1) {
          sim_target.css('background', color);
        } else if(counter > 0) {
          sim_target.css('background', background);
        }
      }
    }
    
    var initFormBackgroundGradientColor = function(obj_c) {
      // 重複初期化回避
      if(!obj_c.hasClass('inited')) {
        obj_c.addClass('inited');
        
        var picker = obj_c.find('.form-color-picker');
        var show = obj_c.find('.form-color-show');
        var checkbox = obj_c.find('.form-color-checkbox');
        var check = obj_c.find('.form-color-checkbox-check');
        var opacity = obj_c.find('.form-color-opacity');
        var size = obj_c.find('.form-color-size');
        var unit = obj_c.find('.fom-color-unit');
        
        var checkFormBackgroundGradientColorHex = function() {
          var hex = picker.val();
          var opa = opacity.val();
          if(hex.match(/[a-f\d]{6}/)) {
            var rgb = changeHexToRgb(hex);
            var color = 'rgba(' + rgb['r'] + ', ' + rgb['g'] + ', ' + rgb['b'] + ', ' + opa + ')';
            show.css('background', color);
            check.prop('checked', true);
            checkbox.addClass('checked');
            opacity.prop('disabled', false);
          } else {
            show.css('background', 'transparent');
            check.prop('checked', false);
            checkbox.removeClass('checked');
            opacity.prop('disabled', true);
          }
        }
        
        updateSimulation();
        
        show.on('click', function(e){
          e.preventDefault();
          if(checkbox.hasClass('checked')) {
            picker.val('');
            checkFormBackgroundGradientColorHex();
            updateSimulation();
          } else {
            picker.click();
          }
        });
        
        picker.ColorPicker({
          onSubmit: function(hsb, hex, rgb, el) {
            $(el).val(hex);
            $(el).ColorPickerHide();
            checkFormBackgroundGradientColorHex();
            updateSimulation();
          },
          onBeforeShow: function () {
            $(this).ColorPickerSetColor(this.value);
          }
        }).bind('keyup', function(){
          $(this).ColorPickerSetColor('#' + this.value);
          checkFormBackgroundGradientColorHex();
          updateSimulation();
        });
        
        opacity.on('change', function(){
          updateSimulation();
        });
        
        size.on('change keyup', function(){
          updateSimulation();
        });
        
        unit.on('change', function(){
          updateSimulation();
        });
      }
    }
    
    obj.find('.form-gradient-type-radio').on('click', function(e){
      var radio = obj.find('.form-gradient-type-radio:checked');
      var button = radio.closest('.form-gradient-type-items');
      if(obj.find('.form-gradient-type-items.working').length == 0) {
        obj.find('.form-gradient-type-items').removeClass('checked');
        button.addClass('checked').addClass('working');
        var type = button.find('.form-gradient-type-radio').val();
        
        option.slideUp(function(){
          if(type == 'linear') {
            option.find('.form-gradient-direction').show();
            if(obj.find('.form-gradient-direction-select').val() == 'rotate') {
              option.find('.form-gradient-rotate').show();
            } else {
              option.find('.form-gradient-rotate').hide();
            }
            option.find('.form-gradient-shape').hide();
            option.find('.form-gradient-center').hide();
            option.find('.form-gradient-position').hide();
          } else if(type == 'radial') {
            option.find('.form-gradient-direction').hide();
            option.find('.form-gradient-rotate').hide();
            option.find('.form-gradient-shape').show();
            option.find('.form-gradient-center').show();
            if(obj.find('.form-gradient-center-select').val() == 'position') {
              option.find('.form-gradient-position').show();
            } else {
              option.find('.form-gradient-position').hide();
            }
          } else if(type == 'conic') {
            option.find('.form-gradient-direction').hide();
            option.find('.form-gradient-rotate').hide();
            option.find('.form-gradient-shape').hide();
            option.find('.form-gradient-center').show();
            if(obj.find('.form-gradient-center-select').val() == 'position') {
              option.find('.form-gradient-position').show();
            } else {
              option.find('.form-gradient-position').hide();
            }
          }
          
          if(type == 'conic') {
            obj.find('.form-color-percent').show();
            obj.find('.form-color-unit').hide();
          } else {
            obj.find('.form-color-percent').hide();
            obj.find('.form-color-unit').show();
          }
          updateSimulation();
          
          option.slideDown(function(){
            button.removeClass('working');
          });
        });
      }
    });
    
    obj.find('.form-background-repeat-button-check').on('change', function(){
      if($(this).prop('checked')) {
        $(this).parent().addClass('checked');
      } else {
        $(this).parent().removeClass('checked');
      }
      updateSimulation();
    });
    
    obj.find('.form-gradient-direction-select').on('change', function(){
      if($(this).val() == 'rotate') {
        obj.find('.form-gradient-rotate').slideDown();
      } else {
        obj.find('.form-gradient-rotate').slideUp();
      }
      updateSimulation();
    });
    
    obj.find('.form-gradient-rotate-input').on('keyup change', function() {
      if($(this).val().match(/^\d+$/)) {
        var rotate = parseInt($(this).val());
        if(rotate < 0) {
          $(this).val(0);
        } else if(rotate > 359) {
          $(this).val(359);
        }
        $(this).siblings('.form-gradient-rotate-sim').css('transform', 'rotate(' + $(this).val() + 'deg)');
      } else {
        $(this).val(0);
      }
      updateSimulation();
    });
    
    obj.find('.form-gradient-center-select').on('change', function(){
      if($(this).val() == 'position') {
        obj.find('.form-gradient-position').slideDown();
      } else {
        obj.find('.form-gradient-position').slideUp();
      }
      updateSimulation();
    });
    
    obj.find('.form-gradient-position-number').on('keyup change', function() {
      if($(this).val().match(/^\d+$/)) {
        var number = parseInt($(this).val());
      } else {
        $(this).val(0);
      }
      updateSimulation();
    });
    
    obj.find('.form-gradient-position-unit').on('keyup change', function() {
      updateSimulation();
    });
    
    obj.find('.form-gradient-shape-select').on('change', function() {
      updateSimulation();
    });
    
    // 背景色を追加ボタンをクリック
    obj.find('.form-gradient-button').on('click', function(){
      var button = $(this);
      if(!button.hasClass('working')) {
        button.addClass('working');
          
        // 背景色部分HTML作成
        var layer = obj.closest('.form-background-layer').data('index');
        var color = parseInt(obj.data('index'));
        var target = obj.closest('.form-block').data('target');
        var key = target + '__background__' + layer + '__' + color;
        var id = 'fbg-' + target + '-' + layer + '-' + color;
        var type = obj.find('.form-gradient-type-radio:checked').val();
    
        html = `
          <div class="form-color form-gradient-color" id="` + id + `">
            <div class="form-color-line">
              <div class="form-color-showarea">
                <div class="form-color-show">
                  <label class="form-color-checkbox">
                    <input class="form-color-checkbox-check" type="checkbox" name="` + key + `__transparent" checked />
                  </label>
                </div>
              </div>
              <div class="form-color-color">
                <input class="form-color-picker" type="text" maxlength="6" name="` + key + `__color" value="" />
              </div>
              <select class="form-color-opacity" name="` + key + `__opacity" disabled>
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
            <div class="form-color-line">
              <input class="form-color-size" type="number" name="` + key + `__size" min="0" value="0" />
              <select class="form-color-unit" name="` + key + `__unit">
                <option value="percent">%</option>
                <option value="pixel">px</option>
              </select>
              <p class="form-color-percent">%</p>
            </div>
          </div>
        `;
        
        obj.find('.form-gradient-list').append(html);
        var new_color = obj.find('#' + id);
        new_color.hide();
        if(type == 'conic') {
          new_color.find('.form-color-percent').show();
          new_color.find('.form-color-unit').hide();
        } else {
          new_color.find('.form-color-percent').hide();
          new_color.find('.form-color-unit').show();
        }
        new_color.slideDown();
        initFormBackgroundGradientColor(new_color);
        
        // 背景層index更新
        obj.data('index', (color + 1).toString());
        
        // ボタンクリックのロックを外す
        button.removeClass('working');
      }
    });
  }
}

// 背景編集ブロック画像エリアを初期化
const initFormBackgroundPicture = function(obj) {
  // 重複初期化回避
  if(!obj.hasClass('inited')) {
    obj.addClass('inited');
    
    var target = obj.closest('.form-block').data('target');
    var layer = parseInt(obj.closest('.form-background-layer').data('index'));
    
    var updateSimulation = function() {
      var sim_target = $('.sim-' + target + '-background-' + layer);
      if(obj.closest('.form-responsive-area').hasClass('setting-pc')) {
        sim_target = $('#sim-' + target + '-background-' + layer + '-pc');
      } else if(obj.closest('.form-responsive-area').hasClass('setting-sp')) {
        sim_target = $('#sim-' + target + '-background-' + layer + '-sp');
      }
      var url = obj.find('.form-upload').data('url');
      
      if(url) {
        sim_target.css('background-image', 'url(' + url + ')');
        sim_target.css('background-size', '20%');
        sim_target.css('background-position', 'center');
      } else {
        sim_target.css('background-image', 'none');
      }
      
      if(obj.find('.form-background-repeat-button-check').prop('checked')) {
        sim_target.css('background-repeat', 'repeat');
      } else {
        sim_target.css('background-repeat', 'no-repeat');
      }
    }
    
    obj.find('.form-background-repeat-button-check').on('change', function(){
      if($(this).prop('checked')) {
        $(this).parent().addClass('checked');
      } else {
        $(this).parent().removeClass('checked');
      }
      updateSimulation();
    });
    
    obj.find('.form-upload-delete').on('click', function(){
      obj.find('.form-upload').data('url', '');
      obj.find('.form-upload-image').val('');
      obj.find('.form-upload-file').val('');
      obj.find('.form-upload-text').removeClass('active').html(translations.file_upload);
      obj.find('.form-upload-delete').fadeOut();
      updateSimulation();
    });
    
    obj.find('.form-upload-text').on('click', function(){
      obj.find('.form-upload-button').click();
    });
    
    obj.find('.form-upload-file').on('change', function (e) {
      var file = $(this);
      
      // 通常動作を止める
      e.preventDefault();
      
      // ajax送信用パラメータ作成
      let data = new FormData;
      data.append( 'action', 'upload-attachment' );
      data.append( 'async-upload', file[0].files[0] );
      data.append( 'name', file[0].files[0].name );
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
          obj.find('.form-upload').data('url', data.data.url);
          obj.find('.form-upload-image').val(data.data.id);
          obj.find('.form-upload-text').addClass('active').html(data.data.title + '.' + data.data.subtype);
          obj.find('.form-upload-delete').fadeIn();
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
  }
}


// スタイル編集のレスポンシブ対応部分本体を初期化
const initFormBackgroundResponsiveArea = function(obj) {
  // 重複初期化回避
  if(!obj.hasClass('inited')) {
    obj.addClass('inited');
    
    // 背景層タイプを選択
    obj.find('.form-background-type-select').on('change', function(){
      // 選択変更のロックをかける
      var select = $(this);
      if(!select.hasClass('working')) {
        obj.find('.form-background-content').slideUp(function(){
          select.addClass('working');
          
          // 背景層各タイプエリアHTML作成
          var type = select.val();
          var index = parseInt(obj.closest('.form-background-layer').data('index'));
          var target = obj.closest('.form-block').data('target');
          var key = target + '__background__' + index;
          
          var html = '';
          if(type == 'solid') {
            // 純色タイプ背景
            html = `
              <div class="form-solid form-color">
                <div class="form-color-line">
                  <div class="form-color-showarea">
                    <div class="form-color-show">
                      <label class="form-color-checkbox">
                        <input class="form-color-checkbox-check" type="checkbox" name="` + key + `__transparent" checked />
                      </label>
                    </div>
                  </div>
                  <div class="form-color-color">
                    <input class="form-color-picker" type="text" maxlength="6" name="` + key + `__color" value="" />
                  </div>
                  <select class="form-color-opacity" name="` + key + `__opacity" disabled>
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
              </div>
            `;
            obj.find('.form-background-content').html(html);
            initFormBackgroundSolid(obj.find('.form-solid'));
            obj.find('.form-background-content').slideDown();
          } else if(type == 'picture') {
            // 画像タイプ背景
            html = `
              <div class="form-picture">
                <div class="form-upload" data-url="">
                  <p class="form-upload-text">` + translations.file_upload + `</p>
                  <input type="hidden" class="form-upload-image" name="` + key + `__image" value="" />
                  <p class="form-upload-delete"></p>
                  <label class="form-upload-button">
                    <input type="file" class="form-upload-file" />
                  </label>
                </div>
                <div class="form-background-repeat">
                  <label class="form-background-repeat-button">
                    <input class="form-background-repeat-button-check" type="checkbox" name="` + key + `__repeat" />` + translations.background_repeat + `
                  </label>
                </div>
              </div>
            `;
            obj.find('.form-background-content').html(html);
            initFormBackgroundPicture(obj.find('.form-picture'));
            obj.find('.form-background-content').slideDown();
          } else if(type == 'gradient') {
            // 変色タイプ背景
            html = `
              <div class="form-gradient" data-index="0">
                <div class="form-gradient-list"></div>
                <div class="form-gradient-button">` + translations.add_gradient + `</div>
                <div class="form-background-repeat">
                  <label class="form-background-repeat-button">
                    <input class="form-background-repeat-button-check" type="checkbox" name="` + key + `__repeat" />` + translations.background_repeat + `
                  </label>
                </div>
                <div class="form-gradient-type">
                  <label class="form-gradient-type-items checked">
                    <span class="form-gradient-type-preview form-gradient-type-preview-solid"></span>
                    <input type="radio" class="form-gradient-type-radio" name="` + key + `__type" value="linear" checked />
                    <span class="form-gradient-type-title">` + translations.gradient_linear + `</span>
                  </label>
                  <label class="form-gradient-type-items">
                    <span class="form-gradient-type-preview form-gradient-type-preview-radial"></span>
                    <input type="radio" class="form-gradient-type-radio" name="` + key + `__type" value="radial" />
                    <span class="form-gradient-type-title">` + translations.gradient_radial + `</span>
                  </label>
                  <label class="form-gradient-type-items">
                    <span class="form-gradient-type-preview form-gradient-type-preview-conic"></span>
                    <input type="radio" class="form-gradient-type-radio" name="` + key + `__type" value="conic" />
                    <span class="form-gradient-type-title">` + translations.gradient_conic + `</span>
                  </label>
                </div>
                <div class="form-gradient-option">
                  <div class="form-gradient-direction">
                    <select class="form-gradient-direction-select" name="` + key + `__direction">
                      <option value="to bottom">` + translations.gradient_to_bottom + `</option>
                      <option value="to right">` + translations.gradient_to_right + `</option>
                      <option value="to top right">` + translations.gradient_to_top_right + `</option>
                      <option value="to bottom right">` + translations.gradient_to_bottom_right + `</option>
                      <option value="rotate">` + translations.gradient_custom_rotate + `</option>
                    </select>
                  </div>
                  <div class="form-gradient-rotate" style="display: none;">
                    <div class="form-gradient-rotate-inner">
                      <p class="form-gradient-rotate-title">` + translations.gradient_rotate + `</p>
                      <input class="form-gradient-rotate-input" type="number" maxlength="3" max="359" min="0" name="` + key + `__rotate" value="0" />
                      <div class="form-gradient-rotate-sim"></div>
                    </div>
                  </div>
                  <div class="form-gradient-shape" style="display: none;">
                    <select class="form-gradient-shape-select" name="` + key + `__shape">
                      <option value="ellipse">` + translations.gradient_ellipse + `</option>
                      <option value="circle">` + translations.gradient_circle + `</option>
                    </select>
                  </div>
                  <div class="form-gradient-center" style="display: none;">
                    <select class="form-gradient-center-select" name="` + key + `__center">
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
                  </div>
                  <div class="form-gradient-position" style="display: none;">
                    <div class="form-gradient-position-line">
                      <p class="form-gradient-position-title">` + translations.gradient_center_position_x + `</p>
                      <input class="form-gradient-position-number number-x" type="number" min="0" name="` + key + `__position_x" value="0" />
                      <select class="form-gradient-position-unit unit-x" name="` + key + `__unit_x">
                        <option value="percent">%</option>
                        <option value="pixel">px</option>
                      </select>
                    </div>
                    <div class="form-gradient-position-line">
                      <p class="form-gradient-position-title">` + translations.gradient_center_position_y + `</p>
                      <input class="form-gradient-position-number number-y" type="number" min="0" name="` + key + `__position_y" value="0" />
                      <select class="form-gradient-position-unit unit-y" name="` + key + `__unit_y">
                        <option value="percent">%</option>
                        <option value="pixel">px</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            `;
            
            obj.find('.form-background-content').html(html);
            initFormBackgroundGradient(obj.find('.form-gradient'));
            obj.find('.form-background-content').slideDown();
          }
          
          // 選択変更のロックを外す
          select.removeClass('working');
        });
      }
    });
    
    // 既存背景設定部分を初期化
    obj.find('.form-solid').each(function(){
      initFormBackgroundSolid($(this));
    });
    obj.find('.form-gradient').each(function(){
      initFormBackgroundGradient($(this));
    });
  }
}


const initFormBackgroundResponsiveDevice = function(obj) {
  // 重複初期化回避
  if(!obj.hasClass('inited')) {
    obj.addClass('inited');
    var target = obj.closest('.form-block').data('target');
    var layer = obj.closest('.form-background-layer').data('index');
    var device = 'pc';
    var other = 'sp';
    if(obj.hasClass('setting-sp')) {
      device = 'sp';
      other = 'pc';
    }
    var flag = obj.siblings('.form-responsive-flag');
    
    obj.find('.form-responsive-device-check').on('change', function(){
      if($(this).prop('checked')) {
        // PCのみ表示ボタンスタイル変更
        obj.addClass('checked');
        // デバイスがPCの場合のみ設定部分の背景層を表示する
        $(this).closest('.form-responsive-target').addClass('setting-' + device).addClass('active');
        // レスポンシブ対応ボタン部分を非表示
        flag.slideUp(function(){
          $('#sim-' + target + '-background-' + layer + '-' + other).hide();
        });
      } else {
        // PCのみ表示ボタンスタイル変更
        obj.removeClass('checked');
        // デバイスがどちらでも設定部分の背景層を表示する
        $(this).closest('.form-responsive-target').removeClass('setting-' + device).removeClass('active');
        // レスポンシブ対応ボタン部分を表示
        flag.slideDown(function() {
          $('#sim-' + target + '-background-' + layer + '-' + other).show();
        });
      }
    });
  }
}


// スタイル編集のレスポンシブ対応部分を初期化
const initFormBackgroundResponsive = function(obj) {
  // 重複初期化回避
  if(!obj.hasClass('inited')) {
    obj.addClass('inited');
    var target = obj.closest('.form-block').data('target');
    var layer = obj.closest('.form-background-layer').data('index');
    
    // レスポンシブ対応の選択を変更
    obj.find('.form-responsive-flag-check').on('change', function(){
      var device = $('.header-sim-model.checked').data('model');
      
      if($(this).prop('checked')) {
        // レスポンシブ対応を有効にする
        $(this).closest('.form-responsive-flag').addClass('checked');
        var responsive_area = $(this).closest('.form-responsive').find('.form-responsive-area');
        // SPサイト編集エリア用HTML文を追加し、PC/SP表示コントロール用クラスを追加
        responsive_area.addClass('setting-pc');
        responsive_area.before(responsive_area.prop('outerHTML').replace('setting-pc', 'setting-sp'));
        var responsive_area_sp = $(this).closest('.form-responsive').find('.form-responsive-area.setting-sp');
        // SPサイト入力に対して値をコピーし、nameに「__sp」を付ける
        responsive_area_sp.find('input, select').each(function(){
          var name = $(this).prop('name');
          $(this).prop('name', name + '__sp');
          $(this).val(responsive_area.find('[name="' + name + '"]').val());
        });
        // 現在編集中の対象のみを表示
        $(this).closest('.form-responsive').find('.form-responsive-area.setting-' + device).addClass('active');
        // SPサイト入力部分を初期化し直す
        responsive_area_sp.removeClass('inited');
        responsive_area_sp.find('.inited').removeClass('inited');
        initFormBackgroundResponsiveArea(responsive_area_sp);
      } else {
        // レスポンシブ対応を無効にする
        $(this).closest('.form-responsive-flag').removeClass('checked');
        // 現在表示しない編集エリアを削除
        $(this).closest('.form-responsive').find('.form-responsive-area').not('.active').remove();
        // PC/SP表示コントロール用クラスを削除
        var responsive_area = $(this).closest('.form-responsive').find('.form-responsive-area');
        responsive_area.removeClass('active').removeClass('setting-pc').removeClass('setting-sp');
        if(device == 'pc') {
          // シミュレーションの相応部分のPCスタイルをSPスタイルにコピー
          $('#sim-' + target + '-background-' + layer + '-sp').css('background', $('#sim-' + target + '-background-' + layer + '-pc').css('background'));
        } else {
          // シミュレーションの相応部分のPCスタイルをSPスタイルにコピー
          $('#sim-' + target + '-background-' + layer + '-pc').css('background', $('#sim-' + target + '-background-' + layer + '-sp').css('background'));
          // 入力のnameの「__sp」を消す
          responsive_area.find('input, select').each(function(){
            $(this).prop('name', $(this).prop('name').replace('__sp', ''));
          });
        }
      }
    });
    
    // PC/SPのみ表示の選択を変更
    obj.find('.form-responsive-device').each(function(){
      initFormBackgroundResponsiveDevice($(this));
    });
    
    // レスポンシブ対応部分本体を初期化
    obj.find('.form-responsive-area').each(function(){
      initFormBackgroundResponsiveArea($(this));
    });
  }
}


// 背景編集ブロックを初期化
const initFormBackgroundLayer = function(obj) {
  // 重複初期化回避
  if(!obj.hasClass('inited')) {
    obj.addClass('inited');
    
    // 背景層を削除
    obj.find('.form-background-btndelete').on('click', function(){
      var layer = $(this).closest('.form-background-layer');
      var layerlist = layer.closest('.form-background-layerlist');
      var target = obj.closest('.form-block').data('target');
      var index = layer.data('index');
      layer.slideUp(function(){
        layer.remove();
        $('.sim-' + target + '-background-' + index).remove();
        updateBackgroundLayerIndex(layerlist.find('.form-background-layer'));
      });
    });
    
    // 背景層の本体をスライド
    obj.find('.form-background-btnslide').on('click', function(){
      var button = $(this);
      var body = button.closest('.form-background-layer').find('.form-background-body');
      if(!button.hasClass('working')) {
        button.addClass('working');
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
    
    // 既存レスポンシブ対応部分を有効化
    obj.find('.form-responsive').each(function(){
      initFormBackgroundResponsive($(this));
    });
  }
}


// 背景編集エリアを初期化
const initFormBackground = function(obj) {
  // 重複初期化回避
  if(!obj.hasClass('inited')) {
    obj.addClass('inited');
    
    // 背景層を追加
    obj.find('.form-background-btninsert').on('click', function(){
      // ボタンクリックのロックをかける
      var button = $(this);
      if(!button.hasClass('working')) {
        button.addClass('working');
        
        // 背景層HTML作成
        var index = parseInt(obj.data('index'));
        var target = obj.closest('.form-block').data('target');
        var key = target + '__background__' + index;
        var responsive_pc = '';
        var responsive_sp = '';
        var device = $('.header-sim-model.checked').data('model');
        if(device == 'pc') {
          responsive_pc = 'active';
        } else {
          responsive_sp = 'active';
        }
        var html = `
          <div class="form-background-layer form-responsive-target" id="fbl-` + target + `-` + index + `" data-index="` + index + `">
            <div class="form-background-header">
              <div class="form-background-btnsort"></div>
              <div class="form-background-name">
                <input type="text" name="` + key + `__name" value="` + translations.background_layer + (index + 1).toString() + `" 
                    placeholder="` + translations.background_layer_name_ph + `" />
              </div>
              <div class="form-background-btnslide"></div>
              <div class="form-background-btndelete"></div>
            </div>
            <div class="form-background-body form-responsive">
              <div class="form-responsive-controller">
                <label class="form-responsive-button form-responsive-device setting-pc ` + responsive_pc + `">
                  <input class="form-responsive-device-check" type="checkbox" name="` + key + `__pc" />` + translations.responsive_pc + `
                </label>
                <label class="form-responsive-button form-responsive-device setting-sp ` + responsive_sp + `">
                  <input class="form-responsive-device-check" type="checkbox" name="` + key + `__sp" />` + translations.responsive_sp + `
                </label>
                <label class="form-responsive-button form-responsive-flag">
                  <input class="form-responsive-flag-check" type="checkbox" name="` + key + `__responsive" />` + translations.responsive_flag + `
                </label>
              </div>
              <div class="form-responsive-area">
                <div class="form-background-type">
                  <select class="form-background-type-select" name="` + key + `__type">
                    <option value="" hidden>` + translations.background_type_ph + `</option>
                    <option value="solid">` + translations.background_solid + `</option>
                    <option value="picture">` + translations.background_picture + `</option>
                    <option value="gradient">` + translations.background_gradient + `</option>
                  </select>
                </div>
                <div class="form-background-content">
                </div>
              </div>
            </div>
            <input type="hidden" class="form-background-index" name="` + key + `__index" value="` + index + `" />
          </div>
        `;
        
        // 背景層を表示
        obj.find('.form-background-layerlist').prepend(html);
        var layer = $('#fbl-' + target + '-' + index.toString());
        layer.hide();
        layer.slideDown();
        
        // 相応シミュレーションブロックを追加
        $('#sim-' + target + '-pc').append('<div class="sim-background sim-' + target + '-background-' + index.toString() + '" ' 
            + 'id="sim-' + target + '-background-' + index.toString() + '-pc"></div>');
        $('#sim-' + target + '-sp').append('<div class="sim-background sim-' + target + '-background-' + index.toString() + '" ' 
            + 'id="sim-' + target + '-background-' + index.toString() + '-sp"></div>');
        
        // 背景ブロック動作を有効化
        initFormBackgroundLayer(layer);
        
        // 背景層数index更新
        obj.data('index', (index + 1).toString());
        updateBackgroundLayerIndex(obj.find('.form-background-layer'));
        
        // ボタンクリックのロックを外す
        button.removeClass('working');
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
}