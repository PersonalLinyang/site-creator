/* 
 * 設定タブを初期化
 */
const initSettingTab = function() {
  $('.setting-tab').find('.setting-tab-handler').on('click', function(){
    var handler = $(this);
    var tab = handler.data('tab');
    // 全設定タブハンドラーを待機状態に変更
    $('.setting-tab-handler').removeClass('active');
    $('.form-tab').removeClass('active');
    handler.addClass('active');
    $('.form-tab[data-tab="' + tab + '"]').addClass('active');
  });
}

/* 
 * デザインタブを初期化
 */
const initSettingTabDesign = function() {
  var tab_design = $('.form-tab[data-tab="design"]');
  
  if(tab_design.length) {
    // 編集部分HTMLを構築、JS用変数design_baseとして直接JS読み出しPHPの中で取得
    addFormBlock(tab_design.find('.form-slider'), design_base, '', true);
  }
}

/* 
 * 設定エリアを初期化
 */
const initSetting = function() {
  // 設定タブを初期化
  initSettingTab();
  
  // デザインタブを初期化
  initSettingTabDesign();
  
  // スライドエリアをループで初期化
  $('.form-slider').each(function(){
    initFormSlider($(this));
  });
  
  // 設定単位のハンドラーをクリックすると操作ボタンを広げる、以外の部分をクリックすると操作ボタンを閉じる
  $(document).on('click',function(e) {
    if($(e.target).hasClass('form-item-handler')) {
      var handler = $(e.target);
      handler.closest('.form-item').toggleClass('active');
      handler.toggleClass('active');
      handler.find('.form-item-button-list').show();
    } else if($(e.target).closest('.form-item-handler').length == 0) {
      $('.form-item').removeClass('active');
      $('.form-item-handler').removeClass('active');
      $('.form-item-button-list').hide();
    }
  });
}