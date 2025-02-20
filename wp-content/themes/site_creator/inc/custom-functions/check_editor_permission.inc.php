<?php

// サイト編集系画面権限チェック
function check_editor_permission() {
  $result = array(
    'result' => True,
    'site_id' => NULL,
    'target' => NULL,
    'error' => NULL,
  );
  
  if(is_user_logged_in()) {
    $user = wp_get_current_user();
    
    $post_id = get_queried_object_id();
    $slug = get_post_field('post_name', $post_id);
    
    if(strpos($slug, 'create-') === 0) {
      
    } else {
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
            $result['site_id'] = $target->ID;
          } elseif($target->post_type == 'html_block') {
            //
            $site = get_page_by_path(get_query_var('site_uid'), OBJECT, array('site'));
            if($site) {
              $result['site_id'] = $site->ID;
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
    }
  } else {
    $result['result'] = False;
    $result['error'] = 'unlogin';
  }
  
  return $result;
}