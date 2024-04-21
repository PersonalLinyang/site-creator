// スライド時間
const slide_time = 1000;

// フォーム次のステップへスライド
const slideStepNext = function() {
  var index = parseInt($('.create-slider').data('index'));
  var next = index + 1;
  var height_now = $('#create-section-' + index).outerHeight();
  var height_next = $('#create-section-' + next).outerHeight();
  
  $('#create-section-' + next).show();
  $('.create-slider').css('height', height_now);
  $('.create-slider-inner').animate({marginLeft: '-100%'}, slide_time, function(){
    $('#create-section-'+ index).hide();
    $('.create-slider-inner').css('margin-left', '0');
  });
  $('.create-slider').animate({height: height_next + 'px'}, slide_time, function(){
    $('.create-slider').css('height', 'auto');
  });
  $('.create-slider').data('index', next);
}

// フォーム前のステップへスライド
const slideStepPrev = function() {
  var index = parseInt($('.create-slider').data('index'));
  var prev = index - 1;
  var height_now = $('#create-section-' + index).outerHeight();
  var height_prev = $('#create-section-' + prev).outerHeight();
  
  $('#create-section-' + prev).show();
  $('.create-slider-inner').css('margin-left', '-100%');
  $('.create-slider').css('height', height_now);
  $('.create-slider-inner').animate({marginLeft: '0'}, slide_time, function(){
    $('#create-section-'+ index).hide();
  });
  $('.create-slider').animate({height: height_prev + 'px'}, slide_time, function(){
    $('.create-slider').css('height', 'auto');
  });
  $('.create-slider').data('index', prev);
}

// 固定ページURL入力
const inputPageUrl = function(obj){
  $('.auto-' + obj[0].name).html(obj.val());
  obj.css('width', Math.max(obj.val().length + 5, 20) + 'ch');
}

// 投稿タイプ各ページURL入力
const inputTypeUrl = function(obj){
  obj.css('width', Math.max(obj.val().length + 5, 20) + 'ch');
}

// 投稿タイプ各ページチェックボックスクリック
const initTypeCheckbox = function(obj) {
  if(obj.prop('checked')) {
    obj.closest('.create-type-body-line').find('.create-type-body-url').addClass('active');
  } else {
    obj.closest('.create-type-body-line').find('.create-type-body-url').removeClass('active');
  }
}

// サイト作成時各ステップSubmitボタンをクリック
const initCreateSubmit = function(submit_key) {
  if(!$('#create-' + submit_key + '-submit').hasClass('sending')) {
    $('#create-' + submit_key + '-submit').addClass('sending');
    $('#create-' + submit_key + '-submit').closest('form').find('.warning').hide();
    $('#create-' + submit_key + '-submit').closest('form').find('.error').removeClass('error');
    
    var fd = new FormData();
    fd.append('action', 'validate_create_' + submit_key);
    $($('#create-' + submit_key + '-form').serializeArray()).each(function(i, v) {
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
          if($('#create-' + submit_key + '-submit').hasClass('final-submit')) {
            var fd_submit = new FormData();
            fd_submit.append('action', 'create_site');
            $('.create-slider').find('form').each(function() {
              $($(this).serializeArray()).each(function(i, v) {
                fd_submit.append(v.name, v.value);
              });
            });
            
            $.ajax({
              type: 'POST',
              url: ajaxurl,
              data: fd_submit,
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
                $('#create-' + submit_key + '-submit').removeClass('sending');
              },
              error: function( response ){
                addFormWarning('system_' + submit_key, translations.system_error);
                $('#create-' + submit_key + '-submit').removeClass('sending');
              }
            });
          } else {
            slideStepNext();
            $('#create-' + submit_key + '-submit').removeClass('sending');
          }
        } else {
          $.each(res['errors'], function(key, value) {
            addFormWarning(key, value);
          });
          $('#create-' + submit_key + '-submit').removeClass('sending');
        }
      },
      error: function( response ){
        addFormWarning('system_' + submit_key, translations.system_error);
        $('#create-' + submit_key + '-submit').removeClass('sending');
      }
    });
  }
}

// 固定ページと子ページ追加
const addPage = function(obj){
  // 親固定ページURLHMTL文取得(再帰関数)
  var getParentUrl = function(obj, url){
    if(obj.parent('.create-page-line').length) {
      var line = obj.parent('.create-page-line');
      var input = obj.siblings('.create-page-url').find('input');
      if(input.length > 0) {
        url = '<span class="auto-' + input[0].name + '">' + input.val() + '</span>/' + url;
      }
      // 再帰処理
      return getParentUrl(line, url);
    } else {
      return url;
    }
  }
  
  // 固定ページ行情報取得
  var counter = parseInt(obj.data('counter')) + 1;
  var index = parseInt(obj.closest('.create-page-line').data('index'));
  var level = parseInt(obj.closest('.create-page-line').data('level')) + 1;
  
  // 最初の子固定ページ判定
  var first_child_line_class = '';
  if(obj.closest('.create-page-line').find('.create-page-line').length == 0) {
    var first_child_line_class = 'first-child-line';
  }
  
  // html構築
  var html = '';
  
  html += '<div class="create-page-line ' + first_child_line_class + '" id="create-page-line-' + counter + '" data-index="' + counter + '" data-level="' + level + '">';
    html += '<div class="form-input create-page-title" style="width: ' + (250 - level * 20) + 'px">';
      html += '<input type="text" name="page_title_' + counter + '" placeholder="' + translations.page_title + '" />';
      html += '<p class="warning warning-page_title_' + counter + '"></p>';
    html += '</div>';
    html += '<div class="form-input create-page-url" style="width: calc(100% - ' + (332 - level * 20) + 'px)">';
      html += '<span class="auto-site_http">' + $('#sel-site-http option:selected').text() + '</span>';
      html += '<span class="auto-site_host">' + $('#txt-site-host').val() + '</span>/';
      html += getParentUrl(obj, '');
      html += '<input type="text" name="page_name_' + counter + '" id="create-page-name-' + counter + '" placeholder="' + translations.page_name + '" />/';
      html += '<p class="warning warning-page_name_' + counter + '"></p>';
    html += '</div>';
    html += '<div class="create-btnline create-page-plus float-description" id="create-page-plus-' + counter + '" data-counter="0">';
      html += '<p class="description">' + translations.page_subplus_float + '</p><p>＋</p>';
    html += '</div>';
    html += '<div class="create-btnline float-description" id="create-page-delete-' + counter + '">';
      html += '<p class="description">' + translations.page_delete_float + '</p><p>×</p>';
    html += '</div>';
    html += '<input type="hidden" name="page_parent_' + counter + '" value="' + index + '" />';
  html += '</div>';
  
  if(level == 1) {
    // ドメイン直下子ページ追加
    obj.before(html);
  } else {
    // 固定ページに子ページ追加
    obj.closest('.create-page-line').append(html);
  }
  
  // 固定ページURL入力で子ページURL連動
  $('#create-page-name-' + counter).on('input', function(){
    inputPageUrl($(this));
  });
  
  // 子ページ追加ボタン有効化
  $('#create-page-plus-' + counter).on('click', function(){
    addPage($(this));
  });
  
  // 固定ページと子ページ削除ボタン有効化
  $('#create-page-delete-' + counter).on('click', function(){
    $(this).closest('.create-page-line').remove();
  });
  
  // テキスト入力でエラー解消有効化
  $('#create-page-line-' + counter).find('input[type="text"]').on('input', function(){
    removeFormWarning($(this));
  });
  
  // 子ページ追加カウンター更新
  $('.create-page-plus').data('counter', counter);
}

// 投稿タイプを追加
const addType = function(obj){
  // 投稿タイプ行情報取得
  var counter = parseInt(obj.data('counter'));
  
  // html構築
  var html = '';
  
  html += '<div class="create-type-line" id="create-type-line-' + counter + '">';
    html += '<div class="create-type-header">';
      html += '<p class="create-type-header-title">' + translations.type_name + '</p>';
      html += '<div class="form-input create-type-header-value">';
        html += '<input type="text" name="type_name_' + counter + '" placeholder="' + translations.type_name + '" />';
        html += '<p class="warning warning-type_name_' + counter + '"></p>';
      html += '</div>';
      html += '<p class="create-type-header-title">' + translations.type_slug + '</p>';
      html += '<div class="form-input create-type-header-value">';
        html += '<input type="text" id="create-type-slug-' + counter + '" name="type_slug_' + counter + '" maxlength="20" '
              + 'placeholder="' + translations.type_slug + '" />';
        html += '<p class="warning warning-type_slug_' + counter + '"></p>';
      html += '</div>';
    html += '</div>';
    html += '<div class="create-type-body">';
      html += '<div class="create-type-body-header">';
        html += '<p class="form-input create-type-body-title">' + translations.type_body_title + '</p>';
        html += '<p class="form-input create-type-body-url active">' + translations.type_body_url + '</p>';
      html += '</div>';
      html += '<div class="create-type-body-line">';
        html += '<div class="form-input create-type-body-title">';
          html += '<label class="checkbox-check">';
            html += '<input type="checkbox" class="create-type-check" id="chk-type-check-' + counter + '-archive" name="type_check_' + counter + '_archive" />';
          html += '</label>';
          html += '<label class="checkbox-text" for="chk-type-check-' + counter + '-archive">' + translations.type_archive + '</label>';
          html += '<p class="warning warning-type_check_' + counter + '_archive"></p>';
        html += '</div>';
        html += '<div class="form-input create-type-body-url">';
          html += '<span class="auto-site_http">' + $('#sel-site-http option:selected').text() + '</span>';
          html += '<span class="auto-site_host">' + $('#txt-site-host').val() + '</span>/';
          html += '<input type="text" class="create-type-body-url-input" name="type_url_' + counter + '_archive" '
                + 'placeholder="' + translations.type_archive_url + '" />';
          html += '<p class="warning warning-type_url_' + counter + '_archive"></p>';
          html += '<div class="create-type-body-controller">';
            html += '<p class="create-type-body-button auto-type_slug_' + counter + '" data-value="">' + translations.type_slug + '</p>';
          html += '</div>';
        html += '</div>';
      html += '</div>';
      html += '<div class="create-type-body-line">';
        html += '<div class="form-input create-type-body-title">';
          html += '<label class="checkbox-check">';
            html += '<input type="checkbox" class="create-type-check" id="chk-type-check-' + counter + '-single" name="type_check_' + counter + '_single" />';
          html += '</label>';
          html += '<label class="checkbox-text" for="chk-type-check-' + counter + '-single">' + translations.type_single + '</label>';
          html += '<p class="warning warning-type_check_' + counter + '_single"></p>';
        html += '</div>';
        html += '<div class="form-input create-type-body-url">';
          html += '<span class="auto-site_http">' + $('#sel-site-http option:selected').text() + '</span>';
          html += '<span class="auto-site_host">' + $('#txt-site-host').val() + '</span>/';
          html += '<input type="text" class="create-type-body-url-input" name="type_url_' + counter + '_single" '
                + 'placeholder="' + translations.type_single_url + '" />';
          html += '<p class="warning warning-type_url_' + counter + '_single"></p>';
          html += '<div class="create-type-body-controller">';
            html += '<p class="create-type-body-button auto-type_slug_' + counter + '" data-value="">' + translations.type_slug + '</p>';
            html += '<p class="create-type-body-button" data-value="%Year%">' + translations.type_year_four + '</p>';
            html += '<p class="create-type-body-button" data-value="%year%">' + translations.type_year_two + '</p>';
            html += '<p class="create-type-body-button" data-value="%Month%">' + translations.type_month_two + '</p>';
            html += '<p class="create-type-body-button" data-value="%month%">' + translations.type_month_one + '</p>';
            html += '<p class="create-type-body-button" data-value="%Day%">' + translations.type_day_two + '</p>';
            html += '<p class="create-type-body-button" data-value="%day%">' + translations.type_day_one + '</p>';
            html += '<p class="create-type-body-button" data-value="%postid%">' + translations.type_post_id + '</p>';
            html += '<p class="create-type-body-button" data-value="%postname%">' + translations.type_post_name + '</p>';
          html += '</div>';
        html += '</div>';
      html += '</div>';
    html += '</div>';
    html += '<div class="create-btnarea">';
      html += '<p class="create-type-button create-type-delete" id="create-type-delete-' + counter + '">' + translations.type_delete + '</p>';
      html += '<p class="create-type-button create-type-taxonomy" id="create-type-taxonomy-' + counter + '" data-target="' + counter + '" data-counter="0">';
        html += translations.type_tax_plus;
      html += '</p>';
    html += '</div>';
  html += '</div>';
  
  // 投稿タイプを追加
  obj.before(html);
  
  // 投稿タイプキーを入力
  $('#create-type-slug-' + counter).on('input', function(){
    $('.auto-' + $(this)[0].name).data('value', $(this).val());
  });
  
  // 投稿タイプ各ページチェックボックスをクリック
  $('#create-type-line-' + counter).find('.create-type-check').on('change', function(){
    initTypeCheckbox($(this));
    initCheckbox($(this));
    removeFormWarning($(this));
  });
  
  // 投稿タイプ各ページURLに動作を追加
  $('#create-type-line-' + counter).find('.create-type-body-url-input').on('focus', function() {
    $(this).closest('.create-type-body-url').find('.create-type-body-controller').slideDown();
  }).on('blur', function() {
    $(this).closest('.create-type-body-url').find('.create-type-body-controller').slideUp();
  }).on('input', function(){
    inputTypeUrl($(this));
  });
  
  // 投稿タイプ各ページURLボタンをクリック
  $('#create-type-line-' + counter).find('.create-type-body-button').on('mousedown', function() {
    event.preventDefault();
  }).on('click', function(){
    var input = $(this).closest('.create-type-body-url').find('.create-type-body-url-input');
    var value = input.val();
    input.val(value + $(this).data('value') + '/');
    inputTypeUrl(input);
  });
  
  // 投稿タイプを削除
  $('#create-type-delete-' + counter).on('click', function(){
    $(this).closest('.create-type-line').remove();
  });
  
  // 投稿タイプタクソノミーを追加
  $('#create-type-taxonomy-' + counter).on('click', function(){
    addTaxonomy($(this));
  });
  
  // 投稿タイプ行ない任意テキスト入力
  $('#create-type-line-' + counter).find('input[type="text"]').on('input', function(){
    removeFormWarning($(this));
  })
  
  // 投稿タイプ追加カウンター更新
  obj.data('counter', counter + 1);
}

// 投稿タクソノミーを追加
const addTaxonomy = function(obj){
  // タクソノミー行情報取得
  var target = obj.data('target');
  var counter = parseInt(obj.data('counter'));
  
  // html構築
  var html = '';
  
  html += '<div class="create-type-body-line" id="create-type-body-line-' + target + '-' + counter + '">';
    html += '<div class="form-input create-type-body-title">';
      html += '<div class="form-input create-type-body-title-name">';
        html += '<input type="text" name="type_tax_name_' + target + '_' + counter + '" placeholder="' + translations.type_tax_name + '" />';
        html += '<p class="warning warning-type_tax_name_' + target + '_' + counter + '"></p>';
      html += '</div>';
      html += '<div class="form-input create-type-body-title-slug">';
        html += '(<input type="text" id="create-type-tax-slug-' + target + '-' + counter + '" name="type_tax_slug_' + target + '_' + counter + '" '
              + 'maxlength="32" placeholder="' + translations.type_tax_slug + '" />)';
        html += '<p class="warning warning-type_tax_slug_' + target + '_' + counter + '"></p>';
      html += '</div>';
      html += '<div class="form-input create-type-body-title-check">';
        html += '<label class="checkbox-check">';
          html += '<input type="checkbox" class="create-type-check" id="chk-type-check-' + target + '-' + counter + '" name="type_check_' + target + '_' + counter + '" />';
        html += '</label>';
        html += '<label class="checkbox-text" for="chk-type-check-' + target + '-' + counter + '">' + translations.type_tax_post_list + '</label>';
        html += '<p class="warning warning-type_check_' + target + '_' + counter + '"></p>';
      html += '</div>';
    html += '</div>';
    html += '<div class="form-input create-type-body-url">';
      html += '<span class="auto-site_http">' + $('#sel-site-http option:selected').text() + '</span>';
      html += '<span class="auto-site_host">' + $('#txt-site-host').val() + '</span>/';
      html += '<input type="text" class="create-type-body-url-input" id="create-type-url-' + target + '_' + counter + '" name="type_url_' + target + '_' + counter + '" '
            + 'placeholder="' + translations.type_tax_url + '" />';
      html += '<p class="warning warning-type_url_' + target + '_' + counter + '"></p>';
      html += '<div class="create-type-body-controller">';
        html += '<p class="create-type-body-button auto-type_slug_' + target + '" data-value="' + $('#create-type-slug-' + target).val() + '">';
          html += translations.type_slug;
        html += '</p>';
        html += '<p class="create-type-body-button auto-type_tax_slug_' + target + '_' + counter + '" data-value="">';
          html += translations.type_tax_slug;
        html += '</p>';
        html += '<p class="create-type-body-button" data-value="%slug%">';
          html += translations.type_term_slug;
        html += '</p>';
      html += '</div>';
    html += '</div>';
    html += '<div class="create-btnline create-type-body-line-delete float-description" id="create-type-tax-delete-' + target + '-' + counter + '">';
      html += '<p class="description">' + translations.type_tax_delete_float + '</p><p>×</p>';
    html += '</div>';
  html += '</div>';
  
  // 投稿タイプを追加
  obj.closest('.create-type-line').find('.create-type-body').append(html);
  
  // タクソノミースラッグを入力
  $('#create-type-tax-slug-' + target + '-' + counter).on('input', function(){
    $('.auto-' + $(this)[0].name).data('value', $(this).val());
  });
  
  // 投稿タイプ各ページURLに動作を追加
  $('#create-type-body-line-' + target + '-' + counter).find('.create-type-body-url-input').on('focus', function() {
    $(this).closest('.create-type-body-url').find('.create-type-body-controller').slideDown();
  }).on('blur', function() {
    $(this).closest('.create-type-body-url').find('.create-type-body-controller').slideUp();
  }).on('input', function(){
    inputTypeUrl($(this));
  });
  
  // 投稿タイプ各ページURLボタンをクリック
  $('#create-type-body-line-' + target + '-' + counter).find('.create-type-body-button').on('mousedown', function() {
    event.preventDefault();
  }).on('click', function(){
    var input = $(this).closest('.create-type-body-url').find('.create-type-body-url-input');
    var value = input.val();
    input.val(value + $(this).data('value') + '/');
    inputTypeUrl(input);
  });
  
  // 投稿タイプ各ページチェックボックスをクリック
  $('#chk-type-check-' + target + '-' + counter).on('change', function(){
    initTypeCheckbox($(this));
    initCheckbox($(this));
    removeFormWarning($(this));
  });
  
  // タクソノミーを削除
  $('#create-type-tax-delete-' + target + '-' + counter).on('click', function(){
    $('#create-type-body-line-' + target + '-' + counter).remove();
  });
  
  // 投稿タイプ行ない任意テキスト入力
  $('#create-type-body-line-' + target + '-' + counter).find('input[type="text"]').on('input', function(){
    removeFormWarning($(this));
  })
  
  // タクソノミー追加カウンター更新
  obj.data('counter', counter + 1);
}

$(document).ready(function(){
  
  // 基本情報HTTP選択を変更する
  $('#sel-site-http').on('change', function() {
    $('.auto-' + $(this)[0].name).html($(this).find('option:selected').text());
  });
  
  // 基本情報ホストを入力する
  $('#txt-site-host').on('input', function() {
    $('.auto-' + $(this)[0].name).html($(this).val());
    if($(this).val().slice(-1) == '/') {
      $('.auto-' + $(this)[0].name).html($(this).val().slice(0,-1));
    }
  });
  
  // 基本情報次へボタンをクリックする
  $('#create-base-submit').on('click', function(){
    initCreateSubmit('base');
  });
  
  // 固定ページ追加ボタンをクリックする
  $('.create-page-plus').on('click', function() {
    addPage($(this));
  });
  
  // 戻るボタンをクリックする
  $('.create-prev').on('click', function(){
    if(!$(this).hasClass('sending')) {
      $(this).addClass('sending');
      slideStepPrev();
      $(this).removeClass('sending');
    }
  });
  
  // 固定ページ情報次へボタンをクリックする
  $('#create-page-submit').on('click', function(){
    initCreateSubmit('page');
  });
  
  // 投稿タイプ各ページチェックボックスをクリック
  $('.create-type-check').on('change', function(){
    initTypeCheckbox($(this));
  });
  
  // 投稿タイプキーを入力
  $('#create-type-slug-post').on('input', function(){
    $('.auto-' + $(this)[0].name).data('value', $(this).val());
  });
  
  // 投稿タイプ各ページURLに動作を追加
  $('.create-type-body-url-input').on('focus', function() {
    $(this).closest('.create-type-body-url').find('.create-type-body-controller').slideDown();
  }).on('blur', function() {
    $(this).closest('.create-type-body-url').find('.create-type-body-controller').slideUp();
  }).on('input', function(){
    inputTypeUrl($(this));
  });
  
  // 投稿タイプ各ページURLボタンをクリック
  $('.create-type-body-button').on('mousedown', function() {
    event.preventDefault();
  }).on('click', function(){
    var input = $(this).closest('.create-type-body-url').find('.create-type-body-url-input');
    var value = input.val();
    input.val(value + $(this).data('value') + '/');
    inputTypeUrl(input);
  });
  
  // 投稿タイプタクソノミーを追加
  $('.create-type-taxonomy').on('click', function(){
    addTaxonomy($(this));
  });
  
  // 投稿タイプを追加
  $('.create-type-plus').on('click', function(){
    addType($(this));
  });
  
  // 投稿タイプ情報次へボタンをクリックする
  $('#create-type-submit').on('click', function(){
    initCreateSubmit('type');
  });
  
});
