const bind_upload_image_to_media = function(file, image) {
  file.on('change', function (e) {
    // 通常動作を止める
    e.preventDefault();

    let data = new FormData;

    data.append( 'action', 'upload-attachment' );
    data.append( 'async-upload', file[0].files[0] );
    data.append( 'name', file[0].files[0].name );
    data.append( '_wpnonce', upload_param.nonce );

    $.ajax( {
      url         : upload_param.upload_url,
      data        : data,
      processData : false,
      contentType : false,
      dataType    : 'json',
      type        : 'POST',
    }).then(
      function ( data ) {
        image.attr('src', data.data.url);
      },
      function ( jqXHR, textStatus, errorThrown ) {
        console.log( 'error!' );
        console.log( 'jqXHR' );
        console.log( jqXHR );
        console.log( 'textStatus' );
        console.log( textStatus );
        console.log( 'errorThrown' );
        console.log( errorThrown );
      }
    );
  });
}