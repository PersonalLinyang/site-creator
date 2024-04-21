/* 
 * シミュレーションブロック選択
 * params 
 *   key : 目標ブロック識別キー
 */
const selectSimulationBlock = function(key) {
  // PC選択部CSS値計算
  var scale_pc = parseFloat($('.sim-html-pc').data('scale'));
  if(scale_pc < 1) {
    var top_pc = ($('#sim-' + key + '-pc').offset().top - $('.header').height() - 2) / scale_pc + $('.sim-html-pc').scrollTop();
  } else {
    var top_pc = ($('#sim-' + key + '-pc').offset().top - $('.header').height() - 2) / scale_pc + $('.sim-inner-pc').scrollTop();
  }
  var left_pc = ($('#sim-' + key + '-pc').offset().left - 2) / scale_pc + $('.sim-inner-pc').scrollLeft();
  var width_pc = $('#sim-' + key + '-pc').innerWidth();
  var height_pc = $('#sim-' + key + '-pc').innerHeight();
  
  // PC選択部CSS更新
  $('#sim-selector-pc').css('top', top_pc + 'px').css('left', left_pc + 'px').css('width', width_pc + 'px').css('height', height_pc + 'px');
  $('#sim-selector-pc').addClass('active');
  $('#sim-selector-pc').data('target', key);
  
  // SP選択部CSS値計算
  var scale_sp = parseFloat($('.sim-html-sp').data('scale'));
  var top_sp = ($('#sim-' + key + '-sp').offset().top - $('.sim-inner-sp').offset().top - 2) / scale_sp + $('.sim-html-sp').scrollTop();
  var left_sp = ($('#sim-' + key + '-sp').offset().left - $('.sim-inner-sp').offset().left - 2) / scale_sp + $('.sim-inner-sp').scrollLeft();
  var width_sp = $('#sim-' + key + '-sp').innerWidth();
  var height_sp = $('#sim-' + key + '-sp').innerHeight();
  
  // SP選択部CSS更新
  $('#sim-selector-sp').css('top', top_sp + 'px').css('left', left_sp + 'px').css('width', width_sp + 'px').css('height', height_sp + 'px');
  $('#sim-selector-sp').addClass('active');
  $('#sim-selector-sp').data('target', key);
}


/* 
 * PCシミュレーションリサイズ 
 *   * scaleにより余白問題があるから、縮小する際のスクロールバーはhtmlのほうにつける必要がある
 * return シミュレーションの縮小倍数
 */
const resizeSimulationPC = function(){
  var adaptive = $('.header-adaptive').hasClass('checked');
  if(adaptive) {
    // シミュレーションアリアに合わせて表示
    // 高さ計算のため、スクロールするエリアを変換
    $('.sim-inner-pc').css('overflow', 'hidden');
    $('.sim-html-pc').css('overflow-y', 'scroll');
    
    // CSS調整のためサイズ関連の計算を行う
    var scrollbar_size = parseFloat($('.sim-html-pc').css('--scrollbar-size'));
    var border_width = parseFloat($('.sim-inner-pc').css('border-top-width'));
    var width_original = parseFloat($('.header-sim-setting-width-pc').val()) + scrollbar_size;
    var width_sim = $('.sim-pc')[0].clientWidth - border_width;
    var height_html = $('.sim-inner-pc').height();
    var rate = 1;
    
    if(width_original > width_sim) {
      // 設定した幅よりシミュレーションエリアが小さい場合、シミュレーションエリアを縮小する
      rate = width_sim / width_original;
      var height_html = height_html / rate;
    }
    
    // シミュレーションエリアCSS更新
    $('.sim-html-pc').css('width', width_original).css('height', height_html).css('transform', 'scale(' + rate + ')');
    $('.sim-html-pc').data('scale', rate);
    $('.sim-inner-pc').css('border-bottom-width', border_width);
    
    // 変換前にシミュレーションエリアがスクロールした距離をシミュレーションHTMLに継承
    var scroll_top = $('.sim-inner-pc')[0].scrollTop;
    $('.sim-inner-pc').scrollTop(0);
    $('.sim-html-pc').scrollTop(scroll_top);
  } else {
    // 元サイズで表示
    // 変換前にシミュレーションHTMLがスクロールした距離をシミュレーションエリアに継承
    var scroll_top = $('.sim-html-pc')[0].scrollTop;
    $('.sim-html-pc').scrollTop(0);
    $('.sim-inner-pc').scrollTop(scroll_top);
    
    // 設定の幅に合わせてシミュレーションエリアCSSを調整
    var width_original = $('.header-sim-setting-width-pc').val();
    $('.sim-html-pc').css('width', width_original).css('height', 'auto').css('transform', 'scale(1)').css('overflow-y', 'hidden');
    $('.sim-html-pc').data('scale', 1);
    $('.sim-inner-pc').css('overflow', 'scroll').css('border-bottom-width', 0);
  }
  
  // PCサイトシミュレーション端末幅をCSSとして設定(単位がvwの際に使う)
  $('.sim-html-pc').css('--device-width', width_original);
  
  if($('#sim-selector-pc').hasClass('active')) {
    var selector_target = $('#sim-selector-pc').data('target');
    selectSimulationBlock(selector_target);
  }
  
  return rate;
}


/* 
 * SPシミュレーションリサイズ 
 * return シミュレーション端末の縮小倍数
 */
const resizeSimulationSP = function(){
  // 設定の幅と高さに合わせてシミュレーションエリアCSSを調整
  var scrollbar_size = parseFloat($('.sim-html-sp').css('--scrollbar-size'));
  var width_original = parseFloat($('.header-sim-setting-width-sp').val()) + scrollbar_size;
  var height_original = parseFloat($('.header-sim-setting-height-sp').val());
  $('.sim-html-sp').css('width', width_original).css('height', height_original).css('transform', 'scale(1)').css('margin-right', 0).css('margin-bottom', 0);
  $('.sim-html-sp').data('scale', 1);
  $('.sim-sp').css('overflow', 'auto');
  
  // シミュレーションエリアの内側幅と高さを取得
  var border_width = parseInt($(".sim-inner-sp").css('border-width'));
  var width_sim = $('.sim-sp')[0].clientWidth - border_width;
  var height_sim = $('.sim-sp')[0].clientHeight - border_width * 2;
  
  var adaptive = $('.header-adaptive').hasClass('checked');
  var rate = 1;
  if(adaptive) {
    // シミュレーションアリアに合わせて表示
    $('.sim-sp').css('overflow', 'hidden');
    if(width_original > width_sim || height_original > height_sim) {
      //設定された幅か高さがシミュレーションエリアの幅や高さを超える場合シミュレーション端末を縮小
      rate = width_sim / width_original;
      var rate_height = height_sim / height_original;
      if(rate > rate_height) {
          rate = rate_height;
      }
      $('.sim-html-sp').css('transform', 'scale(' + rate + ')');
      $('.sim-html-sp').data('scale', rate);
      
      // 縮小するにより発生する余白を調整
      var margin_right = width_original * (rate - 1);
      var margin_bottom = height_original * (rate - 1);
      $('.sim-html-sp').css('margin-right', margin_right + 'px').css('margin-bottom', margin_bottom + 'px');
    }
  }
  
  // シミュレーション端末の高さはシミュレーションエリアの内側高さより低い場合、端末上部の余白を調整して中央寄せにする
  var height_sim_inner = $('.sim-inner-sp').height();
  $('.sim-inner-sp').css('margin-top', 0);
  if(height_sim > height_sim_inner) {
    var margin_top = (height_sim - height_sim_inner) / 2;
    $('.sim-inner-sp').css('margin-top', margin_top + 'px');
  }
  
  // PCサイトシミュレーション端末幅をCSSとして設定(単位がvwの際に使う)
  $('.sim-html-sp').css('--device-width', width_original);
  
  if($('#sim-selector-sp').hasClass('active')) {
    var selector_target = $('#sim-selector-sp').data('target');
    selectSimulationBlock(selector_target);
  }
  
  return rate;
}


/* 
 * シミュレーションブロック追加
 * params 
 *   block_info : ブロック情報、配列
 *     id : DB上ID
 *     key : 識別キー
 *     name : ブロック名
 *     type : ブロックタイプ
 *     style : スタイル情報
 *     blocks : 子ブロック情報
 *   parent_key : 親ブロック識別キー
 */
const addSimulationBlock = function(block_info, parent_key = '') {
  // ブロック情報を変数化
  var key = checkDirectionKey('key', block_info) ? block_info['key'] : '';
  var type = checkDirectionKey('type', block_info) ? block_info['type'] : '';
  
  // シミュレーションブロックを追加
  $('#sim-' + parent_key + '-pc').append('<div class="sim-item sim-' + type + '" id="sim-' + key + '-pc" data-key="' + key + '"></div>');
  $('#sim-' + parent_key + '-sp').append('<div class="sim-item sim-' + type + '" id="sim-' + key + '-sp" data-key="' + key + '"></div>');
  
  // PCシミュレーション部分要素を選択
  $('#sim-' + key + '-pc').click(function(){
    // 上層要素クリック無効化
    event.stopPropagation();
    var key_now = $('#sim-selector-pc').data('target');
    
    if(key_now != key) {
      selectSimulationBlock(key);
      changeFormBlock(key);
    }
  });
  
  // SPシミュレーション部分要素を選択
  $('#sim-' + key + '-sp').click(function(){
    // 上層要素クリック無効化
    event.stopPropagation();
    var key_now = $('#sim-selector-sp').data('target');
    
    if(key_now != key) {
      selectSimulationBlock(key);
      changeFormBlock(key);
    }
  });
}