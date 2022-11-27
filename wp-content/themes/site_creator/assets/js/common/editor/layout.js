// ボディレイアウトエリアを初期化
const initFormBodyLayout = function(obj) {
  var initFormBodyLayoutSelect = function(key) {
    $('.form-layout-sel' + key).on('change', function(){
      var selval = $(this).val();
      var item = obj.find('.form-layout-sim-item[data-target="' + key + '"]');
      var device = $('.header-sim-device.checked').data('device');
      
      item.removeClass('setting-none').removeClass('setting-pc').removeClass('setting-sp').removeClass('active');
      if(selval == 'pc') {
        item.addClass('setting-pc');
      } else if(selval == 'sp') {
        item.addClass('setting-sp');
      } else if(selval == 'none') {
        item.addClass('setting-none');
      }
      
      if(selval == 'all') {
        $('#sim-' + key + '-pc').show();
        $('#sim-' + key + '-sp').show();
      } else if(selval == 'none') {
        $('#sim-' + key + '-pc').hide();
        $('#sim-' + key + '-sp').hide();
      } else if(selval == device) {
        item.addClass('active');
        $('#sim-' + key + '-pc').hide();
        $('#sim-' + key + '-sp').hide();
        $('#sim-' + key + '-' + device).show();
      } else {
        $('#sim-' + key + '-pc').show();
        $('#sim-' + key + '-sp').show();
        $('#sim-' + key + '-' + device).hide();
      }
    });
  }
  
  initFormBodyLayoutSelect('header');
  initFormBodyLayoutSelect('footer');
}

// レイアウトエリアを初期化
const initFormLayout = function(obj) {
  var target = obj.closest('.form-block').data('target');
  if(target == 'body') {
    initFormBodyLayout(obj);
  }
}