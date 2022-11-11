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
  
  rate_pc = resizePC();
  rate_sp = resizeSP();
  
  $(window).resize(function(){
    rate_pc = resizePC();
    rate_sp = resizeSP();
  });
  
  $('.header-sim-adaptive-pc').on('click', function(){
    $(this).toggleClass('checked');
    rate_pc = resizePC();
  });
  
  $('.header-sim-adaptive-sp').on('click', function(){
    $(this).toggleClass('checked');
    rate_sp = resizeSP();
  });
  
  $('.header-sim-setting-width-pc').on('change', function(){
    rate_pc = resizePC();
  });
  
  $('.header-sim-setting-width-sp').on('change', function(){
    rate_sp = resizeSP();
  });
  
  $('.header-sim-setting-height-sp').on('change', function(){
    rate_sp = resizeSP();
  });
  
  $('.header-sim-swirl').on('click', function(){
    var width = $('.header-sim-setting-width-sp').val();
    var height = $('.header-sim-setting-height-sp').val();
    $('.header-sim-setting-width-sp').val(height);
    $('.header-sim-setting-height-sp').val(width);
    rate_sp = resizeSP();
  });
  
  $('.header-sim-setting-device').on('change', function(){
    var option = $(this).find('option[value="' + $(this).val() + '"]');
    var width = option.data('width');
    var height = option.data('height');
    $('.header-sim-width-sp').val(width);
    $('.header-sim-height-sp').val(height);
    rate_sp = resizeSP();
  });
  
//  $('.form-color').each(function(){ 
//    initFormColorEditor($(this)); 
//  });
  
  $('.form-background').each(function(){ 
    initFormBackground($(this)); 
  });
});