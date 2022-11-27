<?php

// サイト編集系画面権限チェック
function check_site_editor_permission() {
  $result = array(
    'result' => True,
    'target' => NULL,
    'error' => NULL,
  );
  
  if(is_user_logged_in()) {
    $user = wp_get_current_user();
    $target_uid = get_query_var('target_uid');
    
    if($target_uid) {
      $target = get_page_by_path($target_uid, OBJECT, array('site', 'html_block'));
      
      if($target) {
        $result['target'] = $target;
        
        // 権限判定
        if($target->post_type == 'site') {
          if(!in_array('administrator', $user->roles)) {
            if($target->post_author != $user->ID) {
              $result['result'] = False;
              $result['error'] = 'permission';
            }
          }
        } elseif($target->post_type == 'html_block') {
          //
        }
      } else {
        $result['result'] = False;
        $result['error'] = '404';
      }
    } else {
      $result['result'] = False;
      $result['error'] = '404';
    }
  } else {
    $result['result'] = False;
    $result['error'] = 'unlogin';
  }
  
  return $result;
}