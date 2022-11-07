$(document).ready(function(){
  // 利用規約を同意する
  $('#signup-agreement').on('change',function() {
    if($(this).prop('checked')) {
      $('#signup-submit').addClass('active');
      $(this).closest('.checkbox-check').removeClass('error');
    } else {
      $('#signup-submit').removeClass('active');
    }
  });
  
  // 登録ボタンをクリックする
  $('#signup-submit').on('click', function(){
    var fd = new FormData();
    fd.append('action', 'signup');
    $($('#signup-form').serializeArray()).each(function(i, v) {
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
          window.location.href = '/';
        } else {
          $('#signup-submit').closest('form').find('.warning').html('');
          $.each(res['errors'], function(key, value) {
            addFormWarning(key, value);
          });
        }
      },
      error: function( response ){
        $('#signup-warning-system').show();
      }
    });
  });
});