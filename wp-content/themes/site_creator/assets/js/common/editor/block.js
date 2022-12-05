// ブロック編集対象切り替え
const slideFormBlock = function(now, target) {
  $('.form-block-slidehandler').addClass('working');
  var block_now = $('.form-block[data-target="' + now + '"]');
  var block_target = $('.form-block[data-target="' + target + '"]');
  if(block_target.length == 1) {
    // ターゲットのブロックが一つのみ存在する場合、該当ブロック編集エリアにスライドする
    var index_now = $('.form-block').index(block_now);
    var index_target = $('.form-block').index(block_target);
    var width = $('.form-block').width();
    
    $('.form-block').hide();
    block_now.show();
    block_target.show();
    if(index_now > index_target) {
      // 現在のブロックが対象ブロックの後にある場合、左へスライド
      $('.form-body').css('margin-left', (0 - width) + 'px');
      $('.form-body').animate({'marginLeft': '0px'}, 500, 'linear', function(){
        block_now.hide();
        $('.form-block-slidehandler').removeClass('working');
      });
    } else {
      // 現在のブロックが対象ブロックの前にある場合、右へスライド
      $('.form-body').animate({'marginLeft': (0 - width) + 'px'}, 500, 'linear', function(){
        block_now.hide();
        $('.form-body').css('margin-left', '0px');
        $('.form-block-slidehandler').removeClass('working');
      });
    }
  } else if(block_target.length) {
    // ターゲットのブロックが二つ以上存在する場合、エラーを出す
    alert('There are blocks with same key more than two');
    $('.form-block-slidehandler').removeClass('working');
  } else {
    // ターゲットのブロックが存在しない場合、エラーを出す
    alert('There is no block named that');
    $('.form-block-slidehandler').removeClass('working');
  }
}

// ブロック編集対象切り替えハンドラーを初期化
const initFormBlockSlidehandler = function(obj) {
  obj.on('click', function(){
    var button = $(this);
    if(!button.hasClass('working')) {
      
      var now = button.closest('.form-block').data('target');
      var target = button.data('target');
      slideFormBlock(now, target);
    }
  });
}

// ブロックレスポンシブ対応を初期化
const initFormBlockResponsive = function(obj_responsive) {
  // 編集対象取得用の変数を定義
  var target = obj_responsive.closest('.form-block').data('target');
  
  // PC/SPのみ表示の選択を変更
  obj_responsive.children('.form-responsive-controller').find('.form-responsive-chkdevice').on('click', function(){
    // チェックボックスクリックのロックをかける
    var checkbox = $(this);
    
    if(!checkbox.hasClass('working')) {
      checkbox.addClass('working');
      
      var check = checkbox.find('.form-responsive-chkdevice-check');
      
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
        
        // デバイスがどちらでも設定部分と親要素レイアウト部分編集ボタンを表示する
        obj_responsive.closest('.form-responsive-target').removeClass('setting-' + device).removeClass('active');
        $('.form-layout-sim-item-btnedit[data-target="' + target + '"]').closest('.form-layout-sim-item').removeClass('setting-' + device).removeClass('active');
        
        // 該当シミュレーションの反対側端末で表示しない
        $('#sim-' + target + '-' + other).show();
        checkbox.removeClass('working');
      } else {
        // PC/SPのみ表示を有効にする
        check.prop('checked', true);
        checkbox.addClass('checked');
        
        // デバイスがPC/SPの場合のみ設定部分と親要素レイアウト部分編集ボタンを表示する
        obj_responsive.closest('.form-responsive-target').addClass('setting-' + device).addClass('active');
        $('.form-layout-sim-item-btnedit[data-target="' + target + '"]').closest('.form-layout-sim-item').addClass('setting-' + device).addClass('active');
        
        // 該当シミュレーションの反対側端末で表示しない
        $('#sim-' + target + '-' + other).hide();
        checkbox.removeClass('working');
      }
    }
  });
}

// ブロック編集エリアを初期化
const initFormBlock = function(obj_block) {
  obj_block.find('.form-blockname-txtname').on('change', function(){
    var target = obj_block.data('target');
    obj_block.find('.form-topic-text').text($(this).val());
    $('.form-layout-sim-item[data-target="' + target + '"]').find('.form-layout-sim-item-text').text($(this).val()).prop('title', $(this).val());
  });
  
  obj_block.find('.form-block-slide-handler').each(function(){ 
    initFormBlockSlidehandler($(this)); 
  });
  
  obj_block.find('.form-background').each(function(){ 
    initFormBackground($(this)); 
  });
  
  obj_block.find('.form-layout').each(function(){ 
    initFormLayout($(this)); 
  });
  
  obj_block.find('.form-position').each(function(){ 
    initFormPosition($(this)); 
  });
  
  obj_block.find('.form-block-responsive').each(function(){ 
    initFormBlockResponsive($(this)); 
  });
}

// 新しいブロックのHTML取得
const addFormBlock = function(block_type, block_index, block_parent) {
  var block_key = block_type + block_index;
  
  // 基層開始部分
  var form_block = `
    <div class="form-block" data-target="` + block_key + `">
      <div class="form-topic">
        <p class="form-block-slide-handler form-topic-back" data-target="` + block_parent + `"></p>
        <p class="form-topic-text">` + translations.block_without_name + `</p>
      </div>
      <div class="form-content">
        <div class="form-line">
          <p class="form-title">` + translations.block_name + `</p>
          <div class="form-input form-blockname">
            <input type="text" class="form-blockname-txtname" name="` + block_key + `__name" value="` + translations.block_without_name + `" />
          </div>
        </div>
        <div class="form-responsive-target form-content-main">
          <div class="form-responsive form-block-responsive">
            <div class="form-responsive-controller">
              <p class="form-checkbox form-responsive-checkbox form-responsive-chkdevice center setting-pc active">
                <input type="checkbox" name="` + block_key + `__pc_only" class="form-responsive-chkdevice-check chkdevice-check-pc" />
                ` + translations.responsive_pc + `
              </p>
              <p class="form-checkbox form-responsive-checkbox form-responsive-chkdevice center setting-sp">
                <input type="checkbox" name="` + block_key + `__sp_only" class="form-responsive-chkdevice-check chkdevice-check-sp" />
                ` + translations.responsive_sp + `
              </p>
            </div>
            <div class="form-responsive-area">
  `;
  
  // レイアウト部分
  form_block += `
              <div class="form-line">
                <p class="form-title">` + translations.layout + `</p>
                <div class="form-input form-layout">
                  <p class="form-layout-type">
                    <select class="form-layout-seltype" name="` + block_key + `__style__layout__type">
                      <option value="l">` + translations.layout_line + `</option>
                      <option value="r">` + translations.layout_row + `</option>
                    </select>
                  </p>
                  <p class="form-layout-btnadd">` + translations.block_add + `</p>
                  <div class="form-layout-sim">
                    <p class="form-layout-sim-dummy active">` + translations.layout_dummy + `</p>
                  </div>
                </div>
              </div>
  `;
  
  // 背景部分
  form_block += `
              <div class="form-line">
                <p class="form-title">` + translations.background + `</p>
                <div class="form-input form-background" data-lastid="0">
                  <p class="form-background-btninsert">` + translations.background_layer_add + `</p>
                  <div class="form-background-layerlist"></div>
                </div>
              </div>
  `;
  
  // 基層終了部分
  form_block += `
            </div>
          </div>
        </div>
      </div>
      <input type="hidden" name="` + block_key + `__block_id" value="" />
    </div>
  `;
  
  // 編集エリアにブロックを追加
  $('.form-body').append(form_block);
  
  // 新しく追加したブロックを有効化
  initFormBlock($('.form-block[data-target="' + block_key + '"]'));
}