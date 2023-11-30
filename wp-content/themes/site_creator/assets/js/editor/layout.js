// レイアウトタイプ選択肢
const layout_type_options = {
  'column':translations.layout_column, 
  'row':translations.layout_row,
}

// 並び方向文言リスト
const layout_direction_strs = {
  'column':translations.direction_bottom, 
  'row':translations.direction_right,
}

// 要素位置選択肢(レイアウトタイプ別文言が違う)
const layout_position_options = {
  'column': {
    'stretch':translations.layout_position_stretch_width,
    'flex-start':translations.layout_position_left,
    'center':translations.layout_position_center,
    'flex-end':translations.layout_position_right,
  },
  'row': {
    'stretch':translations.layout_position_stretch_height,
    'flex-start':translations.layout_position_top,
    'center':translations.layout_position_middle,
    'flex-end':translations.layout_position_bottom,
  },
}

// 全体位置選択肢(レイアウトタイプ別文言が違う)
const layout_space_options = {
  'column': {
    'flex-start':translations.layout_space_top,
    'center':translations.layout_space_middle,
    'flex-end':translations.layout_space_bottom,
    'space-between':translations.layout_space_between_column,
    'space-around':translations.layout_space_around_column,
  },
  'row': {
    'flex-start':translations.layout_space_left,
    'center':translations.layout_space_center,
    'flex-end':translations.layout_space_right,
    'space-between':translations.layout_space_between_row,
    'space-around':translations.layout_space_around_row,
  },
}


/* 
 * ブロックリスト要素のインデックス更新
 * params 
 *   items : ブロックリスト要素リスト
 */
const updateFormLayoutIndex = function(items) {
  items.each(function(){
    // 要素リストをループし、各要素のインデックスを取得
    var index = items.index($(this));
    
    // 各要素の関連シミュレーション部分要素のorderを更新
    var sim_items = null;
    var target = $(this).data('target');
    var device = 'pc';
    if($(this).closest('.form-responsive').children('.form-responsive-controller').find('.form-responsive-chkflag-check').prop('checked')) {
      if($(this).closest('.form-responsive-area').hasClass('setting-sp')) {
        device = 'sp';
      }
      sim_items = $('#sim-' + target + '-' + device);
    } else {
      sim_items = $('.sim-item[id^="sim-' + target + '-"]');
    }
    sim_items.css('order', index);
    
    // 各要素のorder非表示inputを更新
    $(this).find('.form-layout-sim-item-order').val(index);
  });
}


/* 
 * 余白のCSS情報を取得
 * params 
 *   area : レイアウト端末別編集部分
 * return : CSS情報配列
 */
const getLayoutPaddingInfo = function(area) {
  var key_list = ['top', 'left', 'right', 'bottom'];
  var css_list = {}
  
  $.each(key_list, function(index, key) {
    var number = area.find('.form-layout-padding-txtnumber.number-' + key).val();
    var unit = area.find('.form-layout-padding-selunit.unit-' + key).val();
    css_list['padding-' + key] = getValueWithUnit(number, unit);
  });
  
  return css_list;
}


/* 
 * フレックスのCSS情報を取得
 * params 
 *   area : レイアウト端末別編集部分
 * return : CSS情報配列
 */
const getLayoutFlexInfo = function(area) {
  var css_list = {
    'flex-direction': area.find('.form-layout-seltype').val(),
    'align-items' : area.find('.form-layout-rdoposition-radio:checked').val(),
    'justify-content' : area.find('.form-layout-rdospace-radio:checked').val(),
  }
  
  return css_list;
}


/* 
 * 子要素削除ボタンを初期化
 * params 
 *   obj : 子要素削除ボタン
 */
const initFormLayoutSimItemBtnDelete = function(obj) {
  obj.on('click', function(){
    var item = $(this).closest('.form-layout-sim-item');
    var target = item.data('target');
    item.remove();
    $('#sim-' + target + '-pc').remove();
    $('#sim-' + target + '-sp').remove();
    $('.form-block[data-target="' + target + '"]').remove();
    $(this).closest('.form-layout-sim').each(function(){
      if($(this).find('.form-layout-sim-item').length) {
        updateFormLayoutIndex($(this).find('.form-layout-sim-item'));
      } else {
        $(this).find('.form-layout-sim-dummy').addClass('active');
      }
    });
  });
}


/* 
 * レスポンシブ対応部分本体(レイアウト端末別編集部分)を初期化
 * params 
 *   obj : レイアウト端末別編集部分
 */
const initFormLayoutResponsiveArea = function(obj) {
  // レイアウト編集部分を取得
  var setting = obj.closest('.form-layout');
  
  // 編集対象識別キーを定義
  var target = obj.closest('.form-block').data('target');
  
  // 余白幅入力変更
  obj.find('.form-layout-padding-txtnumber').on('keyup change', function(){
    // シミュレーション更新
    updateSimulation(setting, getLayoutPaddingInfo);
  });
  
  // 余白単位選択変更
  obj.find('.form-layout-padding-selunit').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      // シミュレーション更新
      updateSimulation(setting, getLayoutPaddingInfo);
    });
  });
  
  
  initFormLayoutSimItemBtnDelete(obj.find('.form-layout-sim-item-btndelete'));
  
  // ブロック追加ボタンをクリック
  obj.find('.form-layout-btnadd').on('click', function(){
    var button = $(this);
    clickButton(button, function(){
      // 子ブロックリストを取得
      var sim = setting.find('.form-layout-sim');
      
      // 現在のブロック数を取得
      var block_index = parseInt($('.setting').data('index'));
      
      // 編集ブロックを追加
      var type = setting.find('.form-layout-seladd').val();
      addFormBlock({'key': 'block' + block_index, 'type': type}, target);
      
      // 子ブロック情報用の非表示inputを追加
      setting.closest('.form-line').append('<input class="form-layout-sim-item-hidden hidden-block' + block_index + '" type="hidden" name="' + target + '__blocks[]" value="block' + block_index + '" />');
      
      // ブロックがない場合のブロックリストダミー表示を非表示する
      sim.find('.form-layout-sim-dummy').removeClass('active');
      
      sim.each(function(){
        // 端末情報を取得
        var device = 'pc';
        if($(this).closest('.form-responsive').children('.form-responsive-controller').find('.form-responsive-chkflag-check').prop('checked')) {
          if($(this).closest('.form-responsive-area').hasClass('setting-sp')) {
            device = 'sp';
          }
        }
        
        // ブロックリストに要素HTMLを追加
        var form_layout_sim_item = htmlFormLayoutSimItem('block' + block_index, translations.block_without_name, device);
        $(this).find('.form-layout-sim-dummy').before(form_layout_sim_item);
        
        // 追加したブロックリスト要素を取得
        var sim_item = $(this).find('.form-layout-sim-item[data-target="block' + block_index + '"]');
        
        // ブロック削除ボタンを有効化
        initFormLayoutSimItemBtnDelete(sim_item.find('.form-layout-sim-item-btndelete'));
        
        // ブロック編集ボタンを有効化
        initFormBlockSlidehandler(sim_item.find('.form-layout-sim-item-btnedit'));
        
        // ブロック要素のインデックス更新
        updateFormLayoutIndex($(this).find('.form-layout-sim-item'));
      });
      
      // 現在のブロック数を更新
      $('.setting').data('index', (block_index + 1));
    });
  });
  
  // ブロックリストの並び替え機能を有効化
  obj.find('.form-layout-sim').sortable({
    handle: '.form-layout-sim-item-btnsort',
    stop: function(e, ui){
      // ブロック要素のインデックス更新
      updateFormLayoutIndex($(this).find('.form-layout-sim-item'));
    },
  });
  
  //レイアウトタイプ選択変更
  obj.find('.form-layout-seltype').on('change', function(){
    var select = $(this);
    changeSelect(select, function(){
      var type = select.val();
      if(checkDirectionKey(type, layout_type_options)) {
        if(type == 'row') {
          // 横並びの場合ラジオボタンにクラスを追加
          obj.find('.form-layout-position').addClass('row');
          obj.find('.form-layout-space').addClass('row');
        } else {
          // 縦並びの場合ラジオボタンにクラスを削除
          obj.find('.form-layout-position').removeClass('row');
          obj.find('.form-layout-space').removeClass('row');
        }
        
        // ブロックリストの並び方向文言変更
        obj.find('.form-layout-sim-direction').text(layout_direction_strs[type]);
        
        // レーアウト要素位置ラジオボタン文言変更
        $.each(layout_position_options[type], function(option_key, option_text){
          obj.find('.rdoposition-title-' + option_key).text(option_text);
        });
        
        // レーアウト全体位置ラジオボタン文言変更
        $.each(layout_space_options[type], function(option_key, option_text){
          obj.find('.rdoposition-title-' + option_key).text(option_text);
        });
        
        // シミュレーション更新
        updateSimulation(setting, getLayoutFlexInfo);
      }
    });
  });
  
  // 要素位置ラジオボタン選択変更
  obj.find('.form-layout-rdoposition').on('click', function(){
    var radio_button = $(this);
    clickRadio(radio_button, function(){
      // シミュレーション更新
      updateSimulation(setting, getLayoutFlexInfo);
    });
  });
  
  // 全体位置ラジオボタン選択変更
  obj.find('.form-layout-rdospace').on('click', function(){
    var radio_button = $(this);
    clickRadio(radio_button, function(){
      // シミュレーション更新
      updateSimulation(setting, getLayoutFlexInfo);
    });
  });
  
  // 初期化する際一回シミュレーション更新
  updateSimulation(setting, getLayoutPaddingInfo);
  updateSimulation(setting, getLayoutFlexInfo);
}


/* 
 * レイアウト編集部分を初期化
 * params 
 *   obj : 対象レイアウト編集部分
 */
const initFormLayout = function(obj) {
  // レスポンシブ対応可能パーツとして初期化
  initFormResponsive(obj, initFormLayoutResponsiveArea);
}


/* 
 * 子ブロックリスト要素HTMLを構築
 * params 
 *   block_key : 子ブロック識別キー
 *   block_name : 子ブロック名
 *   device : 構築端末
 * return 子ブロックリスト要素HTML
 */
const htmlFormLayoutSimItem = function(block_key, block_name, device) {
  // 順番inputのname
  var order_name = block_key + '__style__layout__' + device + '__order';
  
  // HTMLを構築
  var html = `
    <div class="form-layout-sim-item form-block-slide" data-target="` + block_key + `">
      <div class="form-layout-sim-item-inner">
        <p class="form-layout-sim-item-text" title="` + block_name + `">` + block_name + `</p>
        <p class="form-layout-sim-item-btnsort"></p>
        <p class="form-block-slidehandler form-layout-sim-item-btnedit" data-target="` + block_key + `"></p>
        <p class="form-layout-sim-item-btndelete"></p>
        <input class="form-layout-sim-item-order" type="hidden" name="` + order_name + `" value="" />
      </div>
    </div>
  `
  return html;
}


/* 
 * 要素位置ラジオボタンHTMLを構築
 * params 
 *   layout_key : レーアウト端末別キー([block_key]__style__layout__[device])
 *   value : 要素位置値
 *   type : レーアウトタイプ(縦並び/横並び)
 * return 要素位置ラジオボタンHTML
 */
const htmlFormLayoutPosition = function(layout_key, value, type) {
  // レーアウトタイプによって各選択肢の文言を取得
  var options = checkDirectionKey(type, layout_position_options) ? layout_position_options[type] : layout_position_options['column'];
  
  // HTMLを構築
  var html = '<div class="form-layout-position">';
  
  $.each(options, function(option_value, option_text){
    // 選択肢をループし、選択状態を取得
    var checked_str = '';
    if(option_value == value) {
      checked_str = 'checked';
    }
    
    // サイズ揃いかどうかのクラスを取得
    var class_unstretch = '';
    if(option_value != 'stretch') {
      class_unstretch = 'preview-unstretch';
    }
    
    // 選択肢HTMLを構築
    html += `
      <div class="form-layout-rdoposition ` + checked_str + `">
        <div class="form-layout-rdoposition-preview ` + class_unstretch + ` preview-` + option_value + `">
          <p class="form-layout-rdoposition-preview-item preview-item-1"></p>
          <p class="form-layout-rdoposition-preview-item preview-item-2"></p>
          <p class="form-layout-rdoposition-preview-item preview-item-3"></p>
        </div>
        <p class="form-layout-rdoposition-title rdoposition-title-` + option_value + `">` + option_text + `</p>
        <input type="radio" class="form-layout-rdoposition-radio" name="` + layout_key + `__position" value="` + option_value + `" ` + checked_str + ` />
      </div>
    `;
  });
  
  html += '</div>';
  
  return html;
}


/* 
 * 全体位置ラジオボタンHTMLを構築
 * params 
 *   layout_key : レーアウト端末別キー([block_key]__style__layout__[device])
 *   value : 全体位置値
 *   type : レーアウトタイプ(縦並び/横並び)
 * return 全体位置ラジオボタンHTML
 */
const htmlFormLayoutSpace = function(layout_key, value, type) {
  // レーアウトタイプによって各選択肢の文言を取得
  var options = checkDirectionKey(type, layout_space_options) ? layout_space_options[type] : layout_space_options['column'];
  
  // HTMLを構築
  var html = '<div class="form-layout-space">';
  
  $.each(options, function(option_value, option_text){
    // 選択肢をループし、選択状態を取得
    var checked_str = '';
    if(option_value == value) {
      checked_str = 'checked';
    }
    
    // 選択肢HTMLを構築
    html += `
      <div class="form-layout-rdospace ` + checked_str + `">
        <div class="form-layout-rdospace-preview preview-` + option_value + `">
          <p class="form-layout-rdospace-preview-item preview-item-1"></p>
          <p class="form-layout-rdospace-preview-item preview-item-2"></p>
          <p class="form-layout-rdospace-preview-item preview-item-3"></p>
        </div>
        <p class="form-layout-rdospace-title rdospace-title-` + option_value + `">` + option_text + `</p>
        <input type="radio" class="form-layout-rdospace-radio" name="` + layout_key + `__space" value="` + option_value + `" ` + checked_str + ` />
      </div>
    `;
  });
  
  html += '</div>';
  
  return html;
}


/* 
 * レーアウト端末別編集部分HTMLを構築
 * params 
 *   base_key : レーアウトベースキー([block_key]__style__layout)
 *   options : 構築パラメータ
 *     device : 構築端末(指定しない場合はレスポンシブ対応なしで、pcになる)
 *     style : スタイル情報
 *     blocks : 子ブロック情報
 * return レーアウト端末別編集部分HTML
 */
const htmlFormLayoutResponsiveAreaInner = function(base_key, options) {
  // レーアウト端末別キー取得
  var device = checkDirectionKey('device', options) ? options['device'] : 'pc';
  var layout_key = base_key + '__' + device;
  
  // ブロックタイプを取得
  var block_type = checkDirectionKey('type', options) ? options['type'] : '';
  
  // レーアウトスタイル情報を取得
  var style = (checkDirectionKey('style', options) && $.isPlainObject(options['style'])) ? options['style'] : {};
  
  // 子ブロック情報を取得
  var blocks = (checkDirectionKey('blocks', options) && $.isArray(options['blocks'])) ? options['blocks'] : {};
  
  // レーアウト背景タイプによって子ブロック並び方向文字を構築
  var type = getStyleValue(style, ['type'], '');
  var direction_str = checkDirectionKey(type, layout_type_options) ? layout_direction_strs[type] : layout_direction_strs['column'];
  
  // 子ブロックリストHTMLを構築
  var html_sim = '';
  if(blocks.length) {
    $.each(blocks, function(index, block){
      var block_key = '';
      if(checkDirectionKey('key', block) && block['key']) {
        block_key = block['key'];
        var block_name = checkDirectionKey('name', block) ? block['name'] : '';
        html_sim += htmlFormLayoutSimItem(block['key'], block['name'], device);
      }
    });
    html_sim += '<p class="form-layout-sim-dummy">' + translations.layout_dummy + '</p>';
  } else {
    html_sim = '<p class="form-layout-sim-dummy active">' + translations.layout_dummy + '</p>';
  }
  
  // 各タイプの子ブロックタイプの選択肢を定義
  var type_options = {
    'body': ['header', 'main', 'footer'],
    'header': ['block', 'headerline', 'text', 'image', 'video', 'table', 'list', 'link', 'button'],
    'main': ['block', 'headerline', 'text', 'image', 'video', 'table', 'list', 'link', 'button', 'form'],
    'footer': ['block', 'headerline', 'text', 'image', 'video', 'table', 'list', 'link', 'button'],
    'block': ['block', 'headerline', 'text', 'image', 'video', 'table', 'list', 'link', 'button', 'form'],
  }
  
  //HTMLを構築
  var html = `
    <div class="form-object">
      <p class="form-subtitle">` + translations.layout_padding + `</p>
      <div class="form-layout-padding">
        <div class="form-layout-padding-row">
          ` + htmlNumberInput('form-layout-padding', layout_key + '__padding_top', getStyleValue(style, ['padding_top'], 0), {'input_class':'number-top', 'min':0}) + `
          ` + htmlUnitSelect('form-layout-padding', layout_key + '__padding_top_unit', getStyleValue(style, ['padding_top_unit'], ''), {'select_class':'unit-top'}) + `
        </div>
        <div class="form-layout-padding-middle">
          <div class="form-layout-padding-line">
            ` + htmlNumberInput('form-layout-padding', layout_key + '__padding_left', getStyleValue(style, ['padding_left'], 0), {'input_class':'number-left', 'min':0}) + `
            ` + htmlUnitSelect('form-layout-padding', layout_key + '__padding_left_unit', getStyleValue(style, ['padding_left_unit'], ''), {'select_class':'unit-left'}) + `
          </div>
          <p class="form-layout-padding-center">` + translations.layout_content + `</p>
          <div class="form-layout-padding-line">
            ` + htmlNumberInput('form-layout-padding', layout_key + '__padding_right', getStyleValue(style, ['padding_right'], 0), {'input_class':'number-right', 'min':0}) + `
            ` + htmlUnitSelect('form-layout-padding', layout_key + '__padding_right_unit', getStyleValue(style, ['padding_right_unit'], ''), {'select_class':'unit-right'}) + `
          </div>
        </div>
        <div class="form-layout-padding-row">
          ` + htmlNumberInput('form-layout-padding', layout_key + '__padding_bottom', getStyleValue(style, ['padding_bottom'], 0), {'input_class':'number-bottom', 'min':0}) + `
          ` + htmlUnitSelect('form-layout-padding', layout_key + '__padding_bottom_unit', getStyleValue(style, ['padding_bottom_unit'], ''), {'select_class':'unit-bottom'}) + `
        </div>
      </div>
    </div>
    <div class="form-object">
      <p class="form-subtitle">` + translations.layout_block_list + `(<span class="form-layout-sim-direction">` + direction_str + `</span>)</p>
      <div class="form-layout-sim">
        ` + html_sim + `
      </div>
      <div class="form-layout-add">
        ` + htmlSelect('form-layout-seladd', '', '', part_block_options) + `
        <p class="form-layout-btnadd">` + translations.add + `</p>
      </div>
    </div>
    <div class="form-object">
      <p class="form-subtitle">` + translations.layout_type + `</p>
      <p class="form-layout-type">
        ` + htmlSelect('form-layout-seltype', layout_key + '__type', type, layout_type_options) + `
      </p>
    </div>
    <p class="form-object form-subtitle">` + translations.layout_position + `</p>
    ` + htmlFormLayoutPosition(layout_key, getStyleValue(style, ['position'], 'stretch'), type) + `
    <p class="form-object form-subtitle">` + translations.layout_space + `</p>
    ` + htmlFormLayoutSpace(layout_key, getStyleValue(style, ['space'], 'flex-start'), type) + `
  `;
  return html;
}


/* 
 * レーアウト編集部分HTMLを構築
 * params 
 *   block_key : ブロック識別キー
 *   options : 構築パラメータ
 *     style : スタイル情報
 *     blocks : 子ブロック情報
 * return レーアウト編集部分HTML
 */
const htmlFormLayout = function(block_key, options) {
  var base_key = block_key + '__style__layout';
  
  // 子ブロック情報を取得
  var blocks = (checkDirectionKey('blocks', options) && $.isArray(options['blocks'])) ? options['blocks'] : {};
  
  var html_blocks = '';
  $.each(blocks, function(child_block_index, child_block_info) {
    var child_block_key = (checkDirectionKey('key', child_block_info) && child_block_info['key']) ? child_block_info['key'] : '';
    if(child_block_key) {
      html_blocks += '<input class="form-layout-sim-item-hidden hidden-' + child_block_key + '" type="hidden" name="' + block_key + '__blocks[]" value="' + child_block_key + '">';
    }
  });
  
  var html = `
    <div class="form-line">
      <p class="form-title">` + translations.layout + `</p>
      ` + htmlFormResponsive(base_key, 'form-input form-layout', htmlFormLayoutResponsiveAreaInner, false, true, options) + `
      ` + html_blocks + `
    </div>
  `;
  
  return html;
}