<?php

// サイト編集系画面権限チェック
function check_site_editor_permission() {
  $result = array(
    'result' => True,
    'site'   => NULL,
    'error'  => NULL,
  );
  
  if(is_user_logged_in()) {
    $site_uid = get_query_var('site_uid');
    
    if($site_uid) {
      $sites = get_posts(array(
        'name' => $site_uid,
        'post_type' => 'site',
        'status' => 'publish',
      ));
      
      if(count($sites)) {
        $site = current($sites);
        $result['site'] = $site;
        
        $user = wp_get_current_user();
        
        if(!in_array('administrator', $user->roles)) {
          if($site->post_author != $user->ID) {
            $result['result'] = False;
            $result['error'] = 'permission';
          }
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