// 入力欄の内容が変わる
const pwdreset_input_change = function() {
  if($('#pwdreset-loginid').val()) {
    $('#pwdreset-submit').addClass('active');
  } else {
    $('#pwdreset-submit').removeClass('active');
  }
}

$(document).ready(function(){
  document.getElementById("pwdreset-loginid").addEventListener('change', pwdreset_input_change);
  $('#pwdreset-loginid').keyup(pwdreset_input_change);
  
  // 登録ボタンをクリックする
  $('#pwdreset-submit').on('click', function(){
    var fd = new FormData();
    fd.append('action', 'pwdreset');
    $($('#pwdreset-form').serializeArray()).each(function(i, v) {
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
          $('#pwdreset-reset').fadeOut(function(){
            $('#pwdreset-complete').fadeIn(function(){
              $('#pwdreset-button-complete').removeClass('active');
              $('#pwdreset-button-complete').addClass('active');
            });
          });
        } else {
          $('#pwdreset-form').find('.warning').slideUp(function(){
            $.each(res['errors'], function(key, value) {
              addFormWarning(key, value);
            });
          });
        }
      },
      error: function( response ){
        $('#pwdreset-warning-system').show();
      }
    });
  });
});