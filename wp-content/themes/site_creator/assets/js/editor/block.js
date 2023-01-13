/* 
 * ブロック編集対象切り替え
 * params 
 *   now : 現在編集中ブロックの識別キー
 *   target : 編集したいブロックの識別キー
 */
const slideFormBlock = function(now, target) {
  // 切り替え前後の編集部分を取得
  var block_now = $('.form-block[data-target="' + now + '"]');
  var block_target = $('.form-block[data-target="' + target + '"]');
  if(block_target.length == 1) {
    // ターゲットのブロックが一つのみ存在する場合、切り替え前後のブロックの順番を取得
    var index_now = $('.form-block').index(block_now);
    var index_target = $('.form-block').index(block_target);
    
    // スライド距離を取得
    var width = $('.form-block').width();
    
    // 切り替え前後の編集部分のみ表示
    $('.form-block').hide();
    block_now.show();
    block_target.show();
    if(index_now > index_target) {
      // 現在のブロックが対象ブロックの後にある場合、左へスライド
      $('.form-body').css('margin-left', (0 - width) + 'px');
      $('.form-body').animate({'marginLeft': '0px'}, 500, 'linear', function(){
        block_now.hide();
      });
    } else {
      // 現在のブロックが対象ブロックの前にある場合、右へスライド
      $('.form-body').animate({'marginLeft': (0 - width) + 'px'}, 500, 'linear', function(){
        block_now.hide();
        $('.form-body').css('margin-left', '0px');
      });
    }
  }
}


/* 
 * ブロック編集対象切り替えハンドラーを初期化
 * params 
 *   obj : 対象ハンドラーボタン
 */
const initFormBlockSlidehandler = function(obj) {
  obj.on('click', function(){
    var button = $(this);
    // 全ブロック編集対象切り替えハンドラーを待機状態に変更
    $('.form-block-slidehandler').addClass('working');
    $.when(
      // ブロック編集部分をスライド
      slideFormBlock(button.closest('.form-block').data('target'), button.data('target'))
    ).done(function(){
      // 全ブロック編集対象切り替えハンドラーを稼働状態に変更
      $('.form-block-slidehandler').removeClass('working');
    });
  });
}


/* 
 * ブロックのレスポンシブ対応部分を初期化
 * params 
 *   obj : 対象レスポンシブ対応部分
 */
const initFormBlockResponsive = function(obj) {
  // 編集対象識別キーを定義
  var target = obj.closest('.form-block').data('target');
  
  // PC/SPのみ表示の選択を変更
  obj.children('.form-responsive-controller').find('.form-responsive-chkdevice').on('click', function(){
    var checkbox = $(this);
    clickCheckbox(checkbox, function(){
      // チェックボックスを取得
      var check = checkbox.find('.form-responsive-chkdevice-check');
      
      // 対象端末と反対端末を取得
      var device = 'pc';
      var other = 'sp';
      if(checkbox.hasClass('setting-sp')) {
        device = 'sp';
        other = 'pc';
      }
      
      if(check.prop('checked')) {
        // デバイスがPC/SPの場合のみ設定部分と親要素レイアウト部分編集ボタンを表示する
        obj.closest('.form-responsive-target').addClass('setting-' + device).addClass('active');
        $('.form-layout-sim-item-btnedit[data-target="' + target + '"]').closest('.form-layout-sim-item').addClass('setting-' + device).addClass('active');
        
        // 反対側端末の該当シミュレーションを表示しない
        $('#sim-' + target + '-' + other).hide();
      } else {
        // デバイスがどちらでも設定部分と親要素レイアウト部分編集ボタンを表示する
        obj.closest('.form-responsive-target').removeClass('setting-' + device).removeClass('active');
        $('.form-layout-sim-item-btnedit[data-target="' + target + '"]').closest('.form-layout-sim-item').removeClass('setting-' + device).removeClass('active');
        
        // 反対側端末の該当シミュレーションを表示する
        $('#sim-' + target + '-' + other).show();
      }
    });
  });
}


/* 
 * ブロック編集部分を初期化
 * params 
 *   obj : 対象ブロック編集部分
 */
const initFormBlock = function(obj) {
  // ブロック名を変更
  obj.find('.form-blockname-txtname').on('change', function(){
    var target = obj.data('target');
    obj.find('.form-topic-text').text($(this).val());
    $('.form-layout-sim-item[data-target="' + target + '"]').find('.form-layout-sim-item-text').text($(this).val()).prop('title', $(this).val());
  });
  
  // スライドハンドラーを有効化
  obj.find('.form-block-slidehandler').each(function(){ 
    initFormBlockSlidehandler($(this)); 
  });
  
  // 背景部分を有効化
  obj.find('.form-background').each(function(){ 
    initFormBackground($(this)); 
  });
  
  // レイアウト部分を有効化
  obj.find('.form-layout').each(function(){ 
    initFormLayout($(this)); 
  });
  
  // 位置部分を有効化
  obj.find('.form-position').each(function(){ 
    initFormPosition($(this)); 
  });
  
  // レスポンシブ対応部分(ブロック自体のもののみ)を有効化
  obj.find('.form-block-responsive').each(function(){ 
    initFormBlockResponsive($(this)); 
  });
}


/* 
 * ブロックレスポンシブ対応本体部分HTMLを構築
 * params 
 *   block_key : ブロック識別キー
 *   options : 構築パラメータ
 *     type : ブロックタイプ
 *     style : スタイル情報
 * return 背景層編集部分HTML
 */
const htmlFormBlockResponsiveAreaInner = function(block_key, options) {
  // ブロックタイプを取得
  var type = checkDirectionKey('type', options) ? options['type'] : '';
  
  // スタイル情報を取得
  var style = (checkDirectionKey('style', options) && $.isPlainObject(options['style'])) ? options['style'] : {};
  
  // 子ブロック情報を取得
  var blocks = (checkDirectionKey('blocks', options) && $.isArray(options['blocks'])) ? options['blocks'] : {};
  
  // HTMLを構築
  var html = '';
  
  // 特定タイプ以外のブロックなら位置編集部分HTMLを構築
  if(inArray(type, ['body']) == false) {
    var style_position = {};
    if(checkDirectionKey('position', style)) {
      style_position = style['position'];
    }
    html += htmlFormPosition(block_key, {'style':style_position});
  }
  
  // 背景編集部分HTMLを構築
  var style_background = {};
  if(checkDirectionKey('background', style)) {
    style_background = style['background'];
  }
  html += htmlFormBackground(block_key, {'style':style_background});
  
  // レイアウト編集部分HTMLを構築
  var style_layout = {};
  if(checkDirectionKey('layout', style)) {
    style_layout = style['layout'];
  }
  html += htmlFormLayout(block_key, {'style':style_layout, 'blocks':blocks});
  
  return html;
}


/* 
 * ブロック編集HTMLを構築(再帰関数)
 * params 
 *   block_info : ブロック情報、配列
 *     id : DB上ID
 *     key : 識別キー
 *     name : ブロック名
 *     type : ブロックタイプ
 *     style : スタイル情報
 *     blocks : 子ブロック情報
 *   parent_key : 親ブロック識別キー
 *   base_flag : ベースブロックフラグ
 * return ブロック編集HTML
 */
const htmlFormBlock = function(block_info, parent_key = '', base_flag = false) {
  // ブロック情報を変数化
  var id = checkDirectionKey('id', block_info) ? block_info['id'] : '';
  var key = checkDirectionKey('key', block_info) ? block_info['key'] : '';
  var name = checkDirectionKey('name', block_info) ? block_info['name'] : '';
  var type = checkDirectionKey('type', block_info) ? block_info['type'] : '';
  var style = (checkDirectionKey('style', block_info) && $.isPlainObject(block_info['style'])) ? block_info['style'] : {};
  var blocks = (checkDirectionKey('blocks', block_info) && $.isArray(block_info['blocks'])) ? block_info['blocks'] : [];
  
  // 子ブロック情報を軽量化
  var simple_blocks = [];
  $.each(blocks, function(index, block){
    var block_key = checkDirectionKey('key', block) ? block['key'] : '';
    if(block_key) {
      var block_name = checkDirectionKey('name', block) ? block['name'] : '';
      simple_blocks.push({'key':block_key, 'name':block_name});
    }
  });
  
  var active_flag = '';
  var form_topic_back = '';
  if(base_flag) {
    // ベースブロックなら表示する
    active_flag = 'active';
  } else if(parent_key) {
    // ベースブロック以外では戻りボタンHTMLを構築
    form_topic_back = '<p class="form-block-slidehandler form-topic-back" data-target="' + parent_key + '"></p>';
  }
  
  // ブロック名を取得して、特定タイプ以外のブロックならブロック名編集部分HTMLを構築
  var block_name = '';
  var form_block_name = '';
  if(name) {
    block_name = name;
  } else {
    block_name = translations.block_without_name;
  }
  if(inArray(type, ['body', 'header', 'main', 'footer']) == false) {
    form_block_name = `
      <div class="form-line">
        <p class="form-title">` + translations.block_name + `</p>
        <div class="form-input form-blockname">
          <input type="text" class="form-blockname-txtname" name="` + key + `__name" value="` + block_name + `" />
        </div>
      </div>
    `;
  }
  
  var form_block = `
    <div class="form-block ` + active_flag + `" data-target="` + key + `">
      <div class="form-topic">
        ` + form_topic_back + `<p class="form-topic-text">` + block_name + `</p>
      </div>
      <div class="form-content">
        ` + form_block_name + `
        <div class="form-responsive-target form-content-main">
          ` + htmlFormResponsive(key, 'form-block-responsive', htmlFormBlockResponsiveAreaInner, true, false, { 'type':type, 'style':style, 'blocks':simple_blocks }) + `
        </div>
      </div>
      <input type="hidden" name="` + key + `__block_id" value="` + id + `" />
    </div>
  `;
  
  return form_block;
}


/* 
 * 新しいブロックを追加
 * params 
 *   block_info : ブロック情報、配列
 *     id : DB上ID
 *     key : 識別キー
 *     name : ブロック名
 *     type : ブロックタイプ
 *     style : スタイル情報
 *     blocks : 子ブロック情報
 *   parent_key : 親ブロック識別キー
 *   base_flag : ベースブロックフラグ
 */
const addFormBlock = function(block_info, parent_key = '', base_flag = false) {
  // ブロック情報を変数化
  var key = checkDirectionKey('key', block_info) ? block_info['key'] : '';
  var blocks = (checkDirectionKey('blocks', block_info) && $.isArray(block_info['blocks'])) ? block_info['blocks'] : [];
  
  // シミュレーション部分に相応要素追加
  if(base_flag) {
    $('#sim-html-pc').append('<div class="sim-item sim-block" id="sim-' + key + '-pc"></div>');
    $('#sim-html-sp').append('<div class="sim-item sim-block" id="sim-' + key + '-sp"></div>');
  } else {
    $('#sim-' + parent_key + '-pc').append('<div class="sim-item sim-block" id="sim-' + key + '-pc"></div>');
    $('#sim-' + parent_key + '-sp').append('<div class="sim-item sim-block" id="sim-' + key + '-sp"></div>');
  }
  
  // 編集部分に相応要素追加
  var form_block = htmlFormBlock(block_info, parent_key, base_flag);
  $('.form-body').append(form_block);
  
  // 新しく追加したブロックを有効化
  initFormBlock($('.form-block[data-target="' + key + '"]'));
  
  // 子ブロックをループし、ブロック編集HTMLを構築(再帰処理)
  $.each(blocks, function(index, block){
    addFormBlock(block, key);
  });
}