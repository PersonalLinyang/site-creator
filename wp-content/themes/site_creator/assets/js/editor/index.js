$(document).ready(function(){
  var rate_pc = -1;
  var rate_sp = -1;
  
  // 表示シミュレーションを切り替える
  $('.header-sim-device').on('click', function(){
    if(!$(this).hasClass('checked')) {
      $('.header-sim-device').removeClass('checked');
      $(this).addClass('checked');
      var device = $(this).data('device');
      $('.header-sim-setting').hide();
      $('.header-sim-setting[data-device="' + device + '"]').show();
      $('.sim').hide();
      $('.sim-' + device).show();
      if(device == 'pc') {
        rate_pc = resizePC();
        $('.setting-sp').removeClass('active');
        $('.setting-pc').addClass('active');
      } else {
        rate_sp = resizeSP();
        $('.setting-pc').removeClass('active');
        $('.setting-sp').addClass('active');
      }
    }
  });
  
  // ページ初期化する際の表示比率を取得
  rate_pc = resizePC();
  rate_sp = resizeSP();
  
  // 画面全体リサイズ
  $(window).resize(function(){
    rate_pc = resizePC();
    rate_sp = resizeSP();
  });
  
  // ヘッダPCサイト拡大/縮小ボタンクリック
  $('.header-sim-adaptive-pc').on('click', function(){
    $(this).toggleClass('checked');
    rate_pc = resizePC();
  });
  
  // ヘッダSPサイト拡大/縮小ボタンクリック
  $('.header-sim-adaptive-sp').on('click', function(){
    $(this).toggleClass('checked');
    rate_sp = resizeSP();
  });
  
  // ヘッダPCサイト幅変更
  $('.header-sim-setting-width-pc').on('change', function(){
    rate_pc = resizePC();
  });
  
  // ヘッダSPサイト幅変更
  $('.header-sim-setting-width-sp').on('change', function(){
    rate_sp = resizeSP();
  });
  
  // ヘッダSPサイト高さ変更
  $('.header-sim-setting-height-sp').on('change', function(){
    rate_sp = resizeSP();
  });
  
  // ヘッダ端末向きボタン(SP用)クリック
  $('.header-sim-swirl').on('click', function(){
    var width = $('.header-sim-setting-width-sp').val();
    var height = $('.header-sim-setting-height-sp').val();
    $('.header-sim-setting-width-sp').val(height);
    $('.header-sim-setting-height-sp').val(width);
    rate_sp = resizeSP();
  });
  
  // ヘッダ表示端末(SP用)選択変更
  $('.header-sim-setting-device').on('change', function(){
    var option = $(this).find('option[value="' + $(this).val() + '"]');
    var width = option.data('width');
    var height = option.data('height');
    $('.header-sim-width-sp').val(width);
    $('.header-sim-height-sp').val(height);
    rate_sp = resizeSP();
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
  
  // 編集部分HTMLを構築
  addFormBlock(base_block, '', true);
  
  // 現在の編集ブロック数を更新
  $('.setting').data('index', $('.form-block').length);
});