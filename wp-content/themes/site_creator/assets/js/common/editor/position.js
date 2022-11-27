// 位置エリアを初期化
const initFormHeaderPosition = function(obj) {
  var device = 'pc';
  if(obj.hasClass('setting-sp')) {
    device = 'sp';
  }
  
  var updateHeaderPosition = function() {
    var header_type = obj.find('.form-position-seltype-header-' + device).val();
    
    if(header_type == 'following') {
      var width_body = $('#sim-body-' + device).width();
      var top = $('.sim-html-' + device).scrollTop();
      
      $('#sim-header-' + device).css('top', top + 'px');
    } else if(header_type == 'scroll') {
      var width_body = $('#sim-body-' + device).width();
      var top = $('.sim-html-' + device).scrollTop();
      
      if(top < 300) {
        $('#sim-header-' + device).css('top', '300px');
      } else {
        $('#sim-header-' + device).css('top', top + 'px');
      }
    } else {
      $('#sim-header-' + device).css('top', '0');
    }
  }
  
  $('.sim-html-' + device).on('scroll', function(){
    updateHeaderPosition();
  });
  
  $('.form-position-seltype-header-' + device).on('change', function(){
    updateHeaderPosition();
  });
  
  updateHeaderPosition();
}

// 位置エリアを初期化
const initFormPosition = function(obj) {
  var target = obj.closest('.form-block').data('target');
  if(target == 'header') {
    initFormHeaderPosition(obj);
  }
}