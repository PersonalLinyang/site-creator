// レスポンシブ対応PC/SPのみ表示選択肢
const responsive_device_optins = {
  'pc':translations.responsive_pc,
  'sp':translations.responsive_sp,
}

/* 
 * レスポンシブ対応可能パーツ初期化
 * params 
 *   obj : 対象レスポンシブ対応可能パーツ
 *   func_init_responsive_area : レスポンシブ対応編集部分初期化関数
 */
const initFormResponsive = function(obj, func_init_responsive_area) {
  // 編集対象識別キーを定義
  var target = obj.closest('.form-block').data('target');
  
  // レスポンシブ対応をクリック
  obj.children('.form-responsive-controller').find('.form-responsive-chkflag').on('click', function(){
    var checkbox = $(this);
    clickCheckbox(checkbox, function(){
      var check = checkbox.find('.form-responsive-chkflag-check');
      var device = $('.header-sim-device.checked').data('device');
      
      if(check.prop('checked')) {
        // SPサイト編集部分用HTML文を追加し、PC/SP表示コントロール用クラスを追加
        var responsive_area = obj.find('.form-responsive-area');
        responsive_area.addClass('setting-pc');
        responsive_area.after(responsive_area.prop('outerHTML').replace(/__pc/g, '__sp').replace('setting-pc', 'setting-sp'));
        var responsive_area_sp = obj.find('.form-responsive-area.setting-sp');
        
        // 現在編集中の端末の編集部分のみを表示
        obj.find('.form-responsive-area.setting-' + device).addClass('active');
        
        // SPサイトの入力、選択、チェックボックス、ラジオボタンでループする
        responsive_area_sp.find('input, select').each(function(){
          var name_pc = $(this).prop('name').replace('__sp', '__pc');
          var type = $(this).prop('type');
          
          if(type == 'checkbox') {
            // チェックボックスの場合現在のチェック状態をSP設定に反映
            if(responsive_area.find('[name="' + name_pc + '"]').prop('checked')) {
              $(this).prop('checked', true);
            } else {
              $(this).prop('checked', false);
            }
          } else if(type == 'radio') {
            // ラジオボタンの場合親要素にcheckedがあるかどうかでPCSP両方設定にチェックを反映
            if($(this).parent().hasClass('checked')) {
              $(this).prop('checked', true);
            }
          } else {
            // 入力、選択の場合現在の値をSP設定に反映
            $(this).val(responsive_area.find('[name="' + name_pc + '"]').val());
          }
        });
        
        // 画像アップロードの画像URLをSP設定に反映
        responsive_area_sp.find('.form-upload').data('url', responsive_area.find('.form-upload').data('url'))
        
        // SPサイト入力部分を初期化し直す
        func_init_responsive_area(responsive_area_sp);
      } else {
        // 現在表示中の編集部分を取得
        var responsive_area = obj.find('.form-responsive-area.active');
        
        // 現在表示しない編集部分を削除
        obj.find('.form-responsive-area').not('.active').remove();
        
        // PC/SP表示コントロール用クラスを削除
        responsive_area.removeClass('active').removeClass('setting-pc').removeClass('setting-sp');
        
        if(device == 'sp') {
          // 入力のnameの「__sp」を「__pc」にする
          responsive_area.find('input, select').each(function(){
            $(this).prop('name', $(this).prop('name').replace('__sp', '__pc'));
          });
          
          // シミュレーションを更新
          $('#sim-' + target + '-pc').attr('style', $('#sim-' + target + '-sp').attr('style'));
        } else {
          // シミュレーションを更新
          $('#sim-' + target + '-sp').attr('style', $('#sim-' + target + '-pc').attr('style'));
        }
      }
    });
  });
  
  // 既存レスポンシブ対応部分を初期化
  obj.find('.form-responsive-area').each(function(){
    func_init_responsive_area($(this));
  });
}


/* 
 * レスポンシブ対応パーツHTMLを構築
 * params 
 *   base_key : レスポンシブ対応部分ベースキー
 *   base_class : form-responsiveに追加クラス
 *   func_html_responsive_area_inner : レスポンシブ対応端末別編集部分HTML構築関数
 *   display_flag : PC/SPのみボタンありフラグ
 *   responsive_flag : レスポンシブ対応ボタンありフラグ
 *   options : 構築パラメータ(以下キーが必ずある、他キーは呼び出す場所によって相違がある)
 *     style : スタイル情報
 * return レスポンシブ対応パーツHTML
 */
const htmlFormResponsive = function(base_key, base_class, func_html_responsive_area_inner, display_flag, responsive_flag, options) {
  // スタイル情報を取得
  var style = (checkDirectionKey('style', options) && $.isPlainObject(options['style'])) ? options['style'] : {};
  
  // PC/SPのみボタンとレスポンシブ対応ボタンが片方のみの場合ボタンを中央寄せ
  var class_center = '';
  if((display_flag && !responsive_flag) || (!display_flag && responsive_flag)) {
    class_center = 'center';
  }
  
  // PC/SPのみボタンHTMLを構築
  var html_display = '';
  if(display_flag) {
    var device = $('.header-sim-device.checked').data('device');
    
    $.each(responsive_device_optins, function(device_key, device_text) {
      var device_class = (device == device_key) ? 'active' : '';
      var device_value = getStyleValue(style, [device_key + '_only'], '0');
      html_display += htmlCheckbox('form-responsive-chkdevice', base_key + '__' + device_key + '_only', device_text, device_value, {
                                     'box_class':'form-responsive-checkbox setting-' + device_key + ' ' + device_class + ' ' + class_center, 
                                     'check_class':'chkdevice-check-' + device_key
                                   });
    });
  }
  
  // レスポンシブ対応ボタンHTMLを構築
  var html_responsive = '';
  var responsive = false;
  if(responsive_flag) {
    responsive = getStyleValue(style, ['responsive'], '0');
    html_responsive += htmlCheckbox('form-responsive-chkflag', base_key + '__responsive', translations.responsive_flag, responsive, 
                                    {'box_class':'form-responsive-checkbox ' + class_center});
  }
  
  // HTMLを構築
  var html = `
    <div class="` + base_class + ` form-responsive">
      <div class="form-responsive-controller">
        ` + html_display + `
        ` + html_responsive + `
      </div>
  `;
  
  if(responsive_flag) {
    if(responsive != '0') {
      // レスポンシブ対応
      var options_pc = {};
      var options_sp = {};
      $.each(options, function(option_key, option_value) {
        if(option_key == 'style') {
          options_pc[option_key] = getStyleValue(style, ['pc'], {});
          options_sp[option_key] = getStyleValue(style, ['sp'], {});
        } else {
          options_pc[option_key] = option_value;
          options_sp[option_key] = option_value;
        }
      });
      options_pc['device'] = 'pc';
      options_sp['device'] = 'sp';
      
      html += `
        <div class="form-responsive-area setting-pc active">
          ` + func_html_responsive_area_inner(base_key, options_pc) + `
        </div>
        <div class="form-responsive-area setting-sp">
          ` + func_html_responsive_area_inner(base_key, options_sp) + `
        </div>
      `;
    } else {
      // レスポンシブ非対応
      options['style'] = getStyleValue(style, ['pc'], {});
      
      html += `
        <div class="form-responsive-area">
          ` + func_html_responsive_area_inner(base_key, options) + `
        </div>
      `;
    }
  } else {
    // レスポンシブ非対応
    html += `
      <div class="form-responsive-area">
        ` + func_html_responsive_area_inner(base_key, options) + `
      </div>
    `;
  }
  
  html += `
    </div>
  `;
  
  return html;
}
