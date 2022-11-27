<?php

/*
 * スタイル情報POSTを配列に整理(再帰関数)
 */
function format_block_list($key_list, $value, $block_list) {
  if(count($key_list) > 0) {
    $key = $key_list[0];
    if(!in_array($key_list[0], array_keys($block_list))) {
      $block_list[$key] = array();
    }
    if(count($key_list) == 1) {
      $block_list[$key] = $value;
    } else {
      array_shift($key_list);
      $block_list[$key] = format_block_list($key_list, $value, $block_list[$key]);
    }
  }
  return $block_list;
}


/*
 * スタイルを保存
 */
function func_editor_save_style(){
  $result = true;
  $block_id_list = array();
  $block_list = array();
  $except_list = ['action', 'target_uid'];
  
  if(is_user_logged_in()) {
    $user_id = get_current_user_id();
    
    $target = get_page_by_path($_POST['target_uid'], OBJECT, array('site', 'html_block'));
    
    if($target) {
      foreach($_POST as $key => $value) {
        if(!in_array($key, $except_list)) {
          $key_list = explode("__", $key);
          $block_list = format_block_list($key_list, $value, $block_list);
        }
      }
      
      foreach($block_list as $block_key => $info) {
        // HTMLブロックとして存在する場合IDを取得、存在しない場合追加する
        $block_id = 0;
        if(in_array('block_id', array_keys($info)) && $info['block_id']) {
          $block_id = $info['block_id'];
        } else {
          $block_uid = md5(uniqid(rand(), true));
          $block_name = '';
          if($block_key == 'html') {
            $block_name = 'HTML-' . $target->post_title;
          }
          $block = array(
            'post_name'      => $block_uid,
            'post_title'     => $block_name,
            'post_status'    => 'publish',
            'post_type'      => 'html_block',
            'post_author'    => $user_id,
          );
          $block_id = wp_insert_post($block);
        }
        $block_id_list[$block_key] = $block_id;
        
        // スタイルをJSON化して保存
        if(in_array('style', array_keys($info))) {
          update_field('style', json_encode($info['style']), $block_id);
        }
        
        // HTMLの場合サイトの共通スタイルとして保存
        if($block_key == 'html') {
          $common_style = get_field('common_style', $target->ID);
          if($common_style) {
            if(!in_array($block_id, $common_style)) {
              array_push($common_style, $block_id);
              update_field('common_style', $common_style, $target->ID);
            }
          } else {
            update_field('common_style', array($block_id), $target->ID);
          }
        }
      }
    } else {
      $result = false;
      $error_list['system'] = __('Cannot find target to save', $lang_domain);
    }
  } else {
    $result = false;
    $error_list['system'] = __('Login is necessary to save', $lang_domain);
  }
  
  // リポジトリ出力
  $response = array(
    'result' => $result,
    'block_id_list' => $block_id_list,
  );
  echo json_encode($response);
  die();
}
add_action('wp_ajax_editor_save_style', 'func_editor_save_style');
add_action('wp_ajax_nopriv_editor_save_style', 'func_editor_save_style');
