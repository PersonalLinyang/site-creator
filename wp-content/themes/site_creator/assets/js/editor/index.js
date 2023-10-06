$(document).ready(function(){
  // 表示シミュレーションを切り替える
  $('.header-sim-device').on('click', function(){
    if(!$(this).hasClass('checked')) {
      $('.header-sim-device').removeClass('checked');
      $(this).addClass('checked');
      var device = $(this).data('device');
      $('.header-sim-setting').hide();
      $('.header-sim-setting[data-device="' + device + '"]').show();
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
  
  // ヘッダPCサイト拡大/縮小ボタンクリック
  $('.header-sim-adaptive-pc').on('click', function(){
    $(this).toggleClass('checked');
    resizeSimulationPC();
  });
  
  // ヘッダSPサイト拡大/縮小ボタンクリック
  $('.header-sim-adaptive-sp').on('click', function(){
    $(this).toggleClass('checked');
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
  
  // 編集部分HTMLを構築、JS用変数として直接JS読み出しPHPの中で取得
  addFormBlock(base_block, '', true);
  
  // 現在の編集ブロック数を更新
  $('.setting').data('index', $('.form-block').length);
});