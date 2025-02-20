$(document).ready(function(){
  // [SP]リサイズをクリックすると設定エリアを広げる、以外の部分をクリックすると選択肢を閉じる
  $(document).on('click',function(e) {
    if($(e.target).closest('.header-handler').length) {
      $('.header-sim').toggleClass('active');
    } else if($(e.target).closest('.header-sim').length == 0) {
      $('.header-sim').removeClass('active');
    }
  });
  
  // 表示シミュレーションを切り替える
  $('.header-sim-device').on('click', function(){
    if(!$(this).hasClass('checked')) {
      var device = $(this).data('device');
      
      $('.header-sim-device').removeClass('checked');
      $(this).addClass('checked');
      
      $('.header-sim-setting').removeClass('active');
      $('.header-sim-setting[data-device="' + device + '"]').addClass('active');
      
      $('.sim-device').css('z-index', -1);
      $('.sim-' + device).css('z-index', 0);
      if(device == 'pc') {
        $('.setting-sp').removeClass('active');
        $('.setting-pc').addClass('active');
      } else {
        $('.setting-pc').removeClass('active');
        $('.setting-sp').addClass('active');
      }
    }
  });
  
  // ページ初期化する際の表示比率を取得
  resizeSimulationPC();
  resizeSimulationSP();
  
  // 画面全体リサイズ
  $(window).resize(function(){
    resizeSimulationPC();
    resizeSimulationSP();
  });
  
  // 拡大/縮小ボタンクリック
  $('.header-adaptive').on('click', function(){
    if($(this).hasClass('checked')) {
      $(this).removeClass('checked');
      $(this).find('.header-adaptive-shrink').addClass('active');
      $(this).find('.header-adaptive-expand').removeClass('active');
    } else {
      $(this).addClass('checked');
      $(this).find('.header-adaptive-shrink').removeClass('active');
      $(this).find('.header-adaptive-expand').addClass('active');
    }
    resizeSimulationPC();
    resizeSimulationSP();
  });
  
  // ヘッダPCサイト幅変更
  $('.header-sim-setting-width-pc').on('change', function(){
    resizeSimulationPC();
  });
  
  // ヘッダSPサイト幅変更
  $('.header-sim-setting-width-sp').on('change', function(){
    resizeSimulationSP();
  });
  
  // ヘッダSPサイト高さ変更
  $('.header-sim-setting-height-sp').on('change', function(){
    resizeSimulationSP();
  });
  
  // ヘッダ端末向きボタン(SP用)クリック
  $('.header-sim-swirl').on('click', function(){
    var width = $('.header-sim-setting-width-sp').val();
    var height = $('.header-sim-setting-height-sp').val();
    $('.header-sim-setting-width-sp').val(height);
    $('.header-sim-setting-height-sp').val(width);
    resizeSimulationSP();
  });
  
  // ヘッダ表示端末(SP用)選択変更
  $('.header-sim-setting-device').on('change', function(){
    var option = $(this).find('option[value="' + $(this).val() + '"]');
    var width = option.data('width');
    var height = option.data('height');
    $('.header-sim-width-sp').val(width);
    $('.header-sim-height-sp').val(height);
    resizeSimulationSP();
  });
  
  // ヘッダ「保存」ボタンクリック
  $('.header-save').on('click', function(){
    var button = $(this);
    clickButton(button, function(){
      var fd = new FormData();
      fd.append('action', 'editor_save_style');
      $($('.form-style').serializeArray()).each(function(i, v) {
        fd.append(v.name, v.value);
      });
      
      $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: fd,
        processData: false,
        contentType: false,
        success: function( response ){
          var res = JSON.parse(response);
          if(res['result'] == true) {
            $.each(res['block_id_list'], function(target, block_id) {
              $('input[name="' + target + '__block_id"]').val(block_id);
            });
          } else {
          }
        },
        error: function( response ){
        }
      });
    });
  });
  
  // 設定エリアを初期化
  initSetting();
});
