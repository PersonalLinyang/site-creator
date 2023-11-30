<?php

// サイト編集系画面権限チェック
function check_part_editor_permission() {
  $result = array(
    'result' => True,
    'target_uid' => NULL,
    'error' => array(
      'code' => '',
      'message' => '',
    ),
  );
  
  if(is_user_logged_in()) {
    $user = wp_get_current_user();
    $target_uid = get_query_var('target_uid');
    
    if($target_uid) {
      global $wpdb;
      $sql = 'SELECT author_id FROM tb_block WHERE uid="' . $target_uid . '"';
      $query = $wpdb->get_results($wpdb->prepare($sql));
      if(count($query)) {
        $author_id = current($query)->author_id;
        if($author_id == $user->ID) {
          $result['target_uid'] = $target_uid;
        } else {
          $result['result'] = False;
          $result['error'] = '403';
        }
      } else {
        $result['result'] = False;
        $result['error'] = '404';
      }
    } else {
      $result['target_uid'] = md5(uniqid(rand(), true));
    }
  } else {
    $result['result'] = False;
    $result['error'] = 'unlogin';
  }
  
  return $result;
}