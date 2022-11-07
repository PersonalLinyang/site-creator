<?php

/**
 * SMTP経由の送信設定
 */
function ag_send_mail_smtp($phpmailer)
{
  /* SMTP有効設定 */
  $phpmailer->isSMTP();
  /* SMTPホスト名 */
  $phpmailer->Host       = "smtp.gmail.com";
  /* SMTP認証の有無 */
  $phpmailer->SMTPAuth   = true;
  /* ポート番号 */
  $phpmailer->Port       = "587";
  /* ユーザー名 */
  $phpmailer->Username   = "personal.linyang@gmail.com";
  /* パスワード */
  $phpmailer->Password   = "ylin19920518";
  /* 暗号化方式 */
  $phpmailer->SMTPSecure = "tls";
  /* 送信者メールアドレス */
  $phpmailer->From       = "personal.linyang@gmail.com";
  /* 送信者名 */
  $phpmailer->FromName = "yang";
  /* デバッグ */
  $phpmailer->SMTPDebug = 0;
}
add_action("phpmailer_init", "ag_send_mail_smtp");


/* 
 * 多言語対応有効化
 */
add_action('after_setup_theme', 'multilingual_setup');
function multilingual_setup(){
  load_theme_textdomain('site-creator-ja', get_template_directory() . '/languages/ja');
  load_theme_textdomain('site-creator-zh', get_template_directory() . '/languages/zh');
  load_theme_textdomain('site-creator-en', get_template_directory() . '/languages/en');
  load_theme_textdomain('site-creator-tc', get_template_directory() . '/languages/tc');
  
  global $lang_key_list;
  global $lang_code_list;
  global $lang_name_list;
  
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  
  $lang_key_list = ['ja', 'zh', 'tc', 'en'];
  $lang_code_list = array(
    'ja' => 'JP',
    'zh' => 'SC',
    'tc' => 'TC',
    'en' => 'EN',
  );
  $lang_name_list = array(
    'ja' => __( 'Japanese', 'site-creator-' . $lang_code ),
    'zh' => __( 'Chinese CN', 'site-creator-' . $lang_code ),
    'tc' => __( 'Chinese TC', 'site-creator-' . $lang_code ),
    'en' => __( 'English', 'site-creator-' . $lang_code ),
  );
}


/*
 * Wordpressツールバー表示
 * ログイン中のユーザーによりだし分け、管理者のみツールバーを出す
 */
add_filter( 'show_admin_bar', 'customize_admin_bar' );
function customize_admin_bar(){
  if(is_user_logged_in()) {
    $role = wp_get_current_user()->roles[0];
    if($role == 'administrator') {
      return false;
    }
    return false;
  } else {
    return false;
  }
}
