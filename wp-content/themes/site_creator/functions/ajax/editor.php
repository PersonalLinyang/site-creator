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
  $error_list = array();
  $except_list = ['action', 'target_id'];
  
  $block_id_list = array();
  $block_list = array();
  
  if(is_user_logged_in()) {
    $user_id = get_current_user_id();
    
    $target = get_post($_POST['target_id']);
    
    if($target) {
      foreach($_POST as $key => $value) {
        if(!in_array($key, $except_list)) {
          $key_list = explode("__", $key);
          $block_list = format_block_list($key_list, $value, $block_list);
        }
      }
      
      foreach($block_list as $block_key => $info) {
        switch($block_key) {
          case 'body':
            $block_name = 'BODY';
            $block_type = 'body';
            break;
          case 'header':
            $block_name = 'HEADER';
            $block_type = 'header';
            break;
          case 'main':
            $block_name = 'MAIN';
            $block_type = 'main';
            break;
          case 'footer':
            $block_name = 'FOOTER';
            $block_type = 'footer';
            break;
          default:
            $block_name = in_array('name', array_keys($info)) ? $info['name'] : '';
            $block_type = 'block';
            break;
        }
        
        if(in_array('block_id', array_keys($info)) && $info['block_id']) {
          // HTMLブロックとして存在する場合タイトルを更新
          $block_id = $info['block_id'];
          $html_block = array(
            'ID' => $block_id,
            'post_title' => $block_name,
          );
          wp_update_post($html_block);
        } else {
          // HTMLブロックとして存在しない場合追加する
          $block_uid = md5(uniqid(rand(), true));
          $block = array(
            'post_name'      => $block_uid,
            'post_title'     => $block_name,
            'post_status'    => 'publish',
            'post_type'      => 'html_block',
            'post_author'    => $user_id,
          );
          $block_id = wp_insert_post($block);
          
          update_field('type', $block_type, $block_id);
        }
        $block_id_list[$block_key] = $block_id;
        
        // スタイルをJSON化して保存
        if(in_array('style', array_keys($info))) {
          update_field('style', json_encode($info['style']), $block_id);
        }
        
        // HTMLの場合サイトの共通スタイルとして保存
        if($block_key == 'body') {
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
      
      $block_key_list = array_keys($block_id_list);
      
      foreach($block_list as $block_key => $info) {
        if(in_array('blocks', array_keys($info)) && in_array($block_key, $block_key_list)) {
          $blocks = array();
          foreach($info['blocks'] as $child_block_key) {
            if(in_array($child_block_key, $block_key_list)) {
              array_push($blocks, $block_id_list[$child_block_key]);
            }
          }
          update_field('blocks', $blocks, $block_id_list[$block_key]);
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
    'info' => $block_list,
    'error_list' => $error_list,
    'block_id_list' => $block_id_list,
  );
  echo json_encode($response);
  die();
}
add_action('wp_ajax_editor_save_style', 'func_editor_save_style');
add_action('wp_ajax_nopriv_editor_save_style', 'func_editor_save_style');



/*
 * メディア投稿情報取得
 */
function func_get_media_info(){
  $result = true;
  
  $media_id = $_POST['media_id'];
  
  // リポジトリ出力
  $response = array(
    'result' => $result,
    'data' => array(
      'name' => basename(get_attached_file($media_id)),
      'url' => wp_get_attachment_url($media_id),
    ),
    'errors' => $error_list,
  );
  echo json_encode($response);
  die();
}
add_action('wp_ajax_get_media_info', 'func_get_media_info');
add_action('wp_ajax_nopriv_get_media_info', 'func_get_media_info');
