<?php

/*
 * 新規登録Ajax処理
 */
function func_signup(){
  require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

  $lang = new LanguageSupporter();
  $result = true;
  $error_list = array();
  
  if(!in_array('agreement', array_keys($_POST)) || $_POST['agreement'] != 'on') {
    $result = false;
    $error_list['agreement'] = sprintf($lang->translate('Check %s first'), $lang->translate('terms of service'));
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
    $error_list['user_login'] = sprintf($lang->translate('%s cannot be empty'), $lang->translate('Username'));
  } else if(mb_strlen($_POST['user_login']) > 60) {
    $result = false;
    $error_list['user_login'] = sprintf($lang->translate('%1$s cannot be over %2$s characters'), $lang->translate('Username'), '60');
  } else if(!preg_match("/^[a-zA-Z0-9\-_@]+$/", $_POST['user_login'])) {
    $result = false;
    $error_list['user_login'] = sprintf($lang->translate('%s cannot be this format'), $lang->translate('Username'));
  } else if(get_user_by('login', $_POST['user_login'])) {
    $result = false;
    $error_list['user_login'] = sprintf($lang->translate('%s had been signuped'), $lang->translate('Username'));
  }
  
  if(!in_array('first_name', array_keys($_POST)) || $_POST['first_name'] == '') {
    $result = false;
    $error_list['first_name'] = sprintf($lang->translate('%s cannot be empty'), $lang->translate('First Name'));
  }
  
  if(!in_array('family_name', array_keys($_POST)) || $_POST['family_name'] == '') {
    $result = false;
    $error_list['family_name'] = sprintf($lang->translate('%s cannot be empty'), $lang->translate('Family Name'));
  }

  if(!in_array('email', array_keys($_POST)) || $_POST['email'] == '') {
    $result = false;
    $error_list['email'] = sprintf($lang->translate('%s cannot be empty'), $lang->translate('Email'));
  } else if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])) {
    $result = false;
    $error_list['email'] = sprintf($lang->translate('%s cannot be this format'), $lang->translate('Email'));
  } else if(get_user_by('login', $_POST['user_login'])) {
    $result = false;
    $error_list['email'] = sprintf($lang->translate('%s had been signuped'), $lang->translate('Email'));
  }

  if(!in_array('password', array_keys($_POST)) || $_POST['password'] == '') {
    $result = false;
    $error_list['password'] = sprintf($lang->translate('%s cannot be empty'), $lang->translate('Password'));
  } else if(!preg_match("/^[a-zA-Z0-9!#\$%&'()\*\+-\.\/:;<=>\?@\[\]\^_`{|}~]+$/", $_POST['password'])) {
    $result = false;
    $error_list['password'] = sprintf($lang->translate('%s cannot be this format'), $lang->translate('Password'));
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
  require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

  $lang = new LanguageSupporter();
  $result = true;
  $error_list = array();

  // バリデーション
  if($_POST['loginid'] == '') {
    $result = false;
    $error_list['loginid'] = sprintf($lang->translate('%s cannot be empty'), $lang->translate('Username or Email'));
  } else if(!get_user_by('login', $_POST['loginid']) && !get_user_by('email', $_POST['loginid'])) {
    $result = false;
    $error_list['loginid'] = sprintf($lang->translate('%s is not signuped'), $lang->translate('Username or Email'));
  }
  if($_POST['password'] == '') {
    $result = false;
    $error_list['password'] = sprintf($lang->translate('%s cannot be empty'), $lang->translate('Password'));
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
      $error_list['password'] = sprintf($lang->translate('%s is wrong'), $lang->translate('Password'));
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
  require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

  $lang = new LanguageSupporter();
  $result = true;
  $error_list = array();

  // バリデーション
  if($_POST['loginid'] == '') {
    $result = false;
    $error_list['loginid'] = sprintf($lang->translate('%s cannot be empty'), $lang->translate('Username or Email'));
  } else if(!get_user_by('login', $_POST['loginid']) && !get_user_by('email', $_POST['loginid'])) {
    $result = false;
    $error_list['loginid'] = sprintf($lang->translate('%s is not signuped'), $lang->translate('Username or Email'));
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
      $mail_body = sprintf($lang->translate('Mail To %s'), $user->display_name) . '<br/><br/>';
      $mail_body .= sprintf($lang->translate('Thank you for using %s'), $lang->translate( 'This Site Name' )) . '<br/><br/>';
      $mail_body .= $lang->translate('Your password has been reseted successfully') . '<br/>';
      $mail_body .= sprintf($lang->translate('Please login with this password: %s'), $password) . '<br/>';
      $mail_body .= $lang->translate('And set your password again in the profile page') . '<br/><br/>';
      $mail_body .= sprintf($lang->translate('Please continue to use %s'), $lang->translate('This Site Name')) . '<br/><br/>';
      $mail_body .= $lang->translate('This Site Name') . '<br/><br/>';
      
      // 顧客へメール送信
      wp_mail($user->user_email, $subject, $mail_body, $headers);
    } catch(Exception $ex) {
      $result = false;
      $error_list['system'] = $lang->translate('Failed to Send Email');
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
