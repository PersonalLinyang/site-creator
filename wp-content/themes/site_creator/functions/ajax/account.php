<?php

/*
 * 新規登録Ajax処理
 */
function func_signup(){
  $result = true;
  $error_list = array();
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  
  if(!in_array('agreement', array_keys($_POST)) || $_POST['agreement'] != 'on') {
    $result = false;
    $error_list['agreement'] = sprintf(__('Check %s first', $lang_domain), __('terms of service', $lang_domain));
  }
  
  if(!$result) {
    $response = array(
      'result' => $result,
      'errors' => $error_list,
    );
    echo json_encode($response);

    die();
  }

  if(!in_array('user_login', array_keys($_POST)) || $_POST['user_login'] == '') {
    $result = false;
    $error_list['user_login'] = sprintf(__('%s cannot be empty', $lang_domain), __('Username', $lang_domain));
  } else if(mb_strlen($_POST['user_login']) > 60) {
    $result = false;
    $error_list['user_login'] = sprintf(__('%1$s cannot be over %2$s characters', $lang_domain), __('Username', $lang_domain), '60');
  } else if(!preg_match("/^[a-zA-Z0-9\-_@]+$/", $_POST['user_login'])) {
    $result = false;
    $error_list['user_login'] = sprintf(__('%s cannot be this format', $lang_domain), __('Username', $lang_domain));
  } else if(get_user_by('login', $_POST['user_login'])) {
    $result = false;
    $error_list['user_login'] = sprintf(__('%s had been signuped', $lang_domain), __('Username', $lang_domain));
  }
  
  if(!in_array('first_name', array_keys($_POST)) || $_POST['first_name'] == '') {
    $result = false;
    $error_list['first_name'] = sprintf(__('%s cannot be empty', $lang_domain), __('First Name', $lang_domain));
  }
  
  if(!in_array('family_name', array_keys($_POST)) || $_POST['family_name'] == '') {
    $result = false;
    $error_list['family_name'] = sprintf(__('%s cannot be empty', $lang_domain), __('Family Name', $lang_domain));
  }

  if(!in_array('email', array_keys($_POST)) || $_POST['email'] == '') {
    $result = false;
    $error_list['email'] = sprintf(__('%s cannot be empty', $lang_domain), __('Email', $lang_domain));
  } else if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])) {
    $result = false;
    $error_list['email'] = sprintf(__('%s cannot be this format', $lang_domain), __('Email', $lang_domain));
  } else if(get_user_by('login', $_POST['user_login'])) {
    $result = false;
    $error_list['email'] = sprintf(__('%s had been signuped', $lang_domain), __('Email', $lang_domain));
  }

  if(!in_array('password', array_keys($_POST)) || $_POST['password'] == '') {
    $result = false;
    $error_list['password'] = sprintf(__('%s cannot be empty', $lang_domain), __('Password', $lang_domain));
  } else if(!preg_match("/^[a-zA-Z0-9!#\$%&'()\*\+-\.\/:;<=>\?@\[\]\^_`{|}~]+$/", $_POST['password'])) {
    $result = false;
    $error_list['password'] = sprintf(__('%s cannot be this format', $lang_domain), __('Password', $lang_domain));
  }
  
  if($result) {
    $user_id = wp_insert_user(array(
      'user_login' => $_POST['user_login'],
      'user_pass' => $_POST['password'],
      'user_email' => $_POST['email'],
      'first_name' => $_POST['first_name'],
      'last_name' => $_POST['family_name'],
      'display_name' => $_POST['family_name'] . ' ' . $_POST['first_name'],
      'show_admin_bar_front' => 'false',
      'role' => 'author',
    ));
    
    add_user_meta( $user_id, 'language', $_POST['language'] );
    
    $creds = array();
    $creds['user_login'] = $_POST['user_login'];
    $creds['user_password'] = $_POST['password'];
    $creds['remember'] = true;
    
    wp_signon($creds, true);
  }
  
  $response = array(
    'result' => $result,
    'errors' => $error_list,
  );
  echo json_encode($response);

  die();
}
add_action('wp_ajax_signup', 'func_signup');
add_action('wp_ajax_nopriv_signup', 'func_signup');


/*
 * ログインAjax処理
 */
function func_login(){
  $result = true;
  $error_list = array();
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;

  // バリデーション
  if($_POST['loginid'] == '') {
    $result = false;
    $error_list['loginid'] = sprintf(__('%s cannot be empty', $lang_domain), __('Username or Email', $lang_domain));
  } else if(!get_user_by('login', $_POST['loginid']) && !get_user_by('email', $_POST['loginid'])) {
    $result = false;
    $error_list['loginid'] = sprintf(__('%s is not signuped', $lang_domain), __('Username or Email', $lang_domain));
  }
  if($_POST['password'] == '') {
    $result = false;
    $error_list['password'] = sprintf(__('%s cannot be empty', $lang_domain), __('Password', $lang_domain));
  }
  
  $remember = true;
  if(!in_array('remember', array_keys($_POST))) {
    $remember = false;
  } else if($_POST['remember'] != 'on') {
    $remember = false;
  }
  
  // ログイン
  if($result) {
    $creds = array();
    $user_login = $_POST['loginid'];
    if(!empty( $user_login ) && is_email( $user_login )) {
      if ( $user = get_user_by_email( $user_login ) ) {
        $user_login = $user->user_login;
      }
    }
    $creds['user_login'] = $user_login;
    $creds['user_password'] = $_POST['password'];
    $creds['remember'] = $remember;
    $user_signon = wp_signon($creds, true);
    if(is_wp_error($user_signon)) {
      $result = false;
      $error_list['password'] = sprintf(__('%s is wrong', $lang_domain), __('Password', $lang_domain));
    }
  }
  
  // リポジトリ出力
  $response = array(
    'result' => $result,
    'errors' => $error_list,
  );
  echo json_encode($response);
  die();
}
add_action('wp_ajax_login', 'func_login');
add_action('wp_ajax_nopriv_login', 'func_login');


/*
 * パスワードリセットAjax処理
 */
function func_pwdreset(){
  $result = true;
  $error_list = array();
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;

  // バリデーション
  if($_POST['loginid'] == '') {
    $result = false;
    $error_list['loginid'] = sprintf(__('%s cannot be empty', $lang_domain), __('Username or Email', $lang_domain));
  } else if(!get_user_by('login', $_POST['loginid']) && !get_user_by('email', $_POST['loginid'])) {
    $result = false;
    $error_list['loginid'] = sprintf(__('%s is not signuped', $lang_domain), __('Username or Email', $lang_domain));
  }
  
  // パスワードリセット
  if($result) {
    if(is_email($_POST['loginid'])) {
      $user = get_user_by('email', $_POST['loginid']);
    } else {
      $user = get_user_by('login', $_POST['loginid']);
    }
    
    $password = wp_generate_password();
    wp_set_password($password, $user->ID);
    
    try {
      $mail_body = sprintf(__('Mail To %s', $lang_domain), $user->display_name) . '<br/><br/>';
      $mail_body .= sprintf(__('Thank you for using %s', $lang_domain), __( 'This Site Name', $lang_domain )) . '<br/><br/>';
      $mail_body .= __('Your password has been reseted successfully', $lang_domain) . '<br/>';
      $mail_body .= sprintf(__('Please login with this password: %s', $lang_domain), $password) . '<br/>';
      $mail_body .= __('And set your password again in the profile page', $lang_domain) . '<br/><br/>';
      $mail_body .= sprintf(__('Please continue to use %s', $lang_domain), __('This Site Name', $lang_domain)) . '<br/><br/>';
      $mail_body .= __('This Site Name', $lang_domain) . '<br/><br/>';
      
      // 顧客へメール送信
      wp_mail($user->user_email, $subject, $mail_body, $headers);
    } catch(Exception $ex) {
      $result = false;
      $error_list['system'] = __('Failed to Send Email', $lang_domain);
    }
  }
  
  // リポジトリ出力
  $response = array(
    'result' => $result,
    'errors' => $error_list,
  );
  echo json_encode($response);
  die();
}
add_action('wp_ajax_pwdreset', 'func_pwdreset');
add_action('wp_ajax_nopriv_pwdreset', 'func_pwdreset');
