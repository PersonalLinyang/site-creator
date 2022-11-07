$(document).ready(function(){
  $('.button-download-theme').on('click', function(){
    var fd = new FormData();
    fd.append('action', 'zip_theme');
    fd.append('site_uid', $('#site-uid').val());
    
    $.ajax({
      type: 'POST',
      url: ajaxurl,
      data: fd,
      processData: false,
      contentType: false,
      success: function( response ){
        var res = JSON.parse(response);
        if(res['result'] == true) {
          let element = document.createElement('a');
          element.href = res['zip_url'];
          element.download = res['zip_name'];
          element.target = '_blank';
          element.click();
          element.remove();
        }
      },
      error: function( response ){
      }
    });
  });
});