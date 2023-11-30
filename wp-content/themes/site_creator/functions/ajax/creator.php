<?php

/*
 * サイト情報バリデーションAjax処理
 */
function func_validate_creator(){
  $result = true;
  $error_list = array();
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;

  // バリデーション
  foreach($_POST as $key => $value) {
    if($key == 'site_name') {
      // サイト名
      if($value == '') {
        $result = false;
        $error_list[$key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Name', $lang_domain));
      }
    } elseif($key == 'site_host') {
      // サイトキー
      if($value == '') {
        $result = false;
        $error_list[$key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Host', $lang_domain));
      } elseif(!preg_match("/^([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}(\/[a-zA-Z0-9][a-zA-Z0-9\-_]*[a-zA-Z0-9])*(\/){0,1}$/", $value)) {
        $result = false;
        $error_list[$key] = sprintf(__('%s cannot be this format', $lang_domain), __('Site Host', $lang_domain));
      }
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
add_action('wp_ajax_validate_creator', 'func_validate_creator');
add_action('wp_ajax_nopriv_validate_creator', 'func_validate_creator');


/*
 * サイト作成Ajax処理
 */
function func_creator(){
  $result = true;
  $site_uid = md5(uniqid(rand(), true));
  $error_list = array();
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  
  // サイト作成
  if(is_user_logged_in()) {
    $author_id = get_current_user_id();
    
    global $wpdb;
    
    $wpdb->query('START TRANSACTION');
    
    try {
      $wp_res = $wpdb->insert(
        'tb_site',
        array(
          'uid' => $site_uid,
          'site_name' => $_POST['site_name'],
          'author_id' => $author_id,
        ),
        array( '%s', '%s', '%d' ),
      );
      
      if(!$wp_res) {
        throw new Exception(__( 'Failed to create site', $lang_domain ));
      }
    } catch(Exception $ex) {
      $result = false;
      $error_list['system'] = $ex->getMessage();
    }
    
    if($result) {
      $wpdb->query('COMMIT');
    } else {
      $wpdb->query('ROLLBACK');
    }
  } else {
    $result = false;
    $error_list['system'] = __('Login is necessary to create site', $lang_domain);
  }
  
  // リポジトリ出力
  $response = array(
    'result' => $result,
    'url' => get_site_url() . '/site/' . $site_uid . '/',
    'errors' => $error_list,
  );
  echo json_encode($response);
  die();
}
add_action('wp_ajax_creator', 'func_creator');
add_action('wp_ajax_nopriv_creator', 'func_creator');
