// PCサイト調整
const resizePC = function(){
  // 仮ページ幅設定適用
  var rate = -1;
  var width_original = $('.header-sim-setting-width-pc').val();
  $('.sim-html-pc').css('width', width_original).css('max-width', width_original).css('height', 'auto').css('transform', 'none').css('margin-right', 0).css('margin-bottom', 0);
  $('.sim-inner-pc').css('overflow-x', 'auto');
  
  var adaptive = $('.header-sim-adaptive-pc').hasClass('checked');
  if(adaptive) {
    $('.sim-inner-pc').css('overflow-x', 'hidden');
    // シミュレーションエリアの幅に合わせる場合
    var width_sim = $('.sim-inner-pc')[0].clientWidth;
    
    if(width_original > width_sim) {
      //設定された仮ページの幅がシミュレーションエリアの幅を超える
      rate = width_sim / width_original;
      $('.sim-html-pc').css('transform', 'scale(' + rate + ')');
      
      var margin_right = width_sim - width_original;
      $('.sim-html-pc').css('margin-right', margin_right + 'px');
      
      var height_original = $('.sim-html-pc').height();
      var height_scale = height_original * rate;
      var height_sim = $('.sim-inner-pc').height();
      
      if(height_scale > height_sim) {
        var margin_bottom = height_scale - height_original;
        $('.sim-html-pc').css('margin-bottom', margin_bottom + 'px');
      } else {
        $('.sim-html-pc').css('height', (width_original * 100 / width_sim) + '%');
        var margin_bottom = (height_scale - height_sim) * width_original / width_sim;
        $('.sim-html-pc').css('margin-bottom', margin_bottom + 'px');
      }
    }
  }
  
  return rate;
}

// SPサイト調整
const resizeSP = function(){
  // 仮ページ幅設定適用
  var rate = -1;
  var width_original = $('.header-sim-setting-width-sp').val();
  var height_original = $('.header-sim-setting-height-sp').val();
  $('.sim-html-sp').css('width', width_original).css('height', height_original).css('transform', 'none').css('margin-right', 0).css('margin-bottom', 0);
  $('.sim-sp').css('overflow', 'auto');
  
  var width_sim = $('.sim-sp')[0].clientWidth;
  var height_sim = $('.sim-sp')[0].clientHeight;
  
  var adaptive = $('.header-sim-adaptive-sp').hasClass('checked');
  if(adaptive) {
    // シミュレーションエリアの幅に合わせる場合
    $('.sim-sp').css('overflow', 'hidden');
    if(width_original > width_sim || height_original > height_sim) {
      //設定された仮ページの幅か高さがシミュレーションエリアの幅や高さを超える
      rate = width_sim / width_original;
      var rate_height = height_sim / height_original;
      if(rate > rate_height) {
          rate = rate_height;
      }
      $('.sim-html-sp').css('transform', 'scale(' + rate + ')');
      
      var margin_right = width_original * (rate - 1);
      $('.sim-html-sp').css('margin-right', margin_right + 'px');
      
      var margin_bottom = height_original * (rate - 1);
      $('.sim-html-sp').css('margin-bottom', margin_bottom + 'px');
    }
  }
  
  var height_sim_inner = $('.sim-inner-sp').height();
  $('.sim-inner-sp').css('margin-top', 0);
  if(height_sim > height_sim_inner) {
    var margin_top = (height_sim - height_sim_inner) / 2;
    $('.sim-inner-sp').css('margin-top', margin_top + 'px');
  }
  
  return rate;
}