$(document).ready(function(){
  
  // 投稿タイプ情報次へボタンをクリックする
  $('.creator-submit').on('click', function(){
    var button = $(this);
    
    if(!button.hasClass('working')) {
      button.addClass('working');
      button.closest('form').find('.warning').hide();
      button.closest('form').find('.error').removeClass('error');
      
      var fd = new FormData();
      fd.append('action', 'validate_creator');
      $($('#creator-form').serializeArray()).each(function(i, v) {
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
            fd.set('action', 'creator');
            
            $.ajax({
              type: 'POST',
              url: ajaxurl,
              data: fd,
              processData: false,
              contentType: false,
              success: function( response ){
                var res = JSON.parse(response);
                if(res['result'] == true) {
                  window.location.href = res['url'];
                } else {
                  $.each(res['errors'], function(key, value) {
                    addFormWarning(key, value);
                  });
                }
                button.removeClass('working');
              },
              error: function( response ){
                addFormWarning('system', translations.system_error);
                button.removeClass('working');
              }
            });
          } else {
            $.each(res['errors'], function(key, value) {
              addFormWarning(key, value);
            });
            button.removeClass('working');
          }
        },
        error: function( response ){
          addFormWarning('system', translations.system_error);
          button.removeClass('working');
        }
      });
    }
  });
  
});
