// フォームエラー表示
const addFormWarning = function(key, text) {
  $('.warning-' + key).html(text);
  $('.warning-' + key).show();
  $('.warning-' + key).closest('.form-input').find('[name="' + key + '"]').addClass('error');
  $('.warning-' + key).closest('.form-input').find('.checkbox-check').addClass('error');
}

// フォームエラー解消
const removeFormWarning = function(obj) {
  obj.closest('.form-input').find('.error').removeClass('error');
  obj.closest('.form-input').find('.warning').hide();
}

// チェックボックス動作を初期化
const initCheckbox = function(obj) {
  if(obj.prop('checked')) {
    obj.closest('.checkbox-check').addClass('active');
  } else {
    obj.closest('.checkbox-check').removeClass('active');
  }
}

// チェックボックス動作を初期化
const initFormCheckbox = function(obj) {
  obj.find('input[type="checkbox"]').on('change', function(){
    if($(this).prop('checked')) {
      $(this).closest('.form-checkbox-check').addClass('active');
    } else {
      $(this).closest('.form-checkbox-check').removeClass('active');
    }
  });
}

$(document).ready(function(){
  // [SP]言語選択をクリックすると選択肢を広げる、以外の部分をクリックすると選択肢を閉じる
  $(document).on('click',function(e) {
    if($(e.target).closest('.header-language-now').length) {
      $('.header-language.sp-only').find('.header-language-list').slideToggle();
    } else {
      $('.header-language.sp-only').find('.header-language-list').slideUp();
    }
  });
  
  // [SP]ヘッダーメニューハンドラーをクリック
  $('.header-menu-handler').click(function(){
    if($(this).hasClass('active')) {
      $(this).removeClass('active');
      $('.header-menu').slideUp();
    } else {
      $(this).addClass('active');
      $('.header-menu').slideDown();
    }
  });
  
  // パスワードを表示するボタンをクリック
  $('.password-show').click(function(){
    if($(this).hasClass('active')) {
      $(this).removeClass('active');
      $(this).closest('.password-group').find('input[type="text"]').attr('type', 'password');
    } else {
      $(this).addClass('active');
      $(this).closest('.password-group').find('input[type="password"]').attr('type', 'text');
    }
  });
  
  // チェックボックスクリック
  $('.checkbox-check').find('input[type="checkbox"]').on('change', function(){
    initCheckbox($(this));
  });
  
  // テキスト入力でエラー解消
  $('.form-input').find('input[type="text"],input[type="password"],input[type="number"],input[type="email"]').on('input', function(){
    removeFormWarning($(this));
  });
  
  // チェックボックスクリックでエラー解消
  $('.form-input').find('input[type="checkbox"]').on('change', function(){
    removeFormWarning($(this));
  });
  
  $('.form-checkbox').each(function(){ 
    initFormCheckbox($(this)); 
  });
});