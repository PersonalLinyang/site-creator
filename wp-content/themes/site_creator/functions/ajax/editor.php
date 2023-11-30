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
  $except_list = ['action', 'target_uid'];
  
  $block_uid_list = array();
  $block_list = array();
  
  if(is_user_logged_in()) {
    $author_id = get_current_user_id();
    
    try {
      global $wpdb;
      
      $wpdb->query('START TRANSACTION');
      
      // 再帰関数でスタイルの情報を配列に整理
      foreach($_POST as $key => $value) {
        if(!in_array($key, $except_list)) {
          $key_list = explode("__", $key);
          $block_list = format_block_list($key_list, $value, $block_list);
        }
      }
      
      foreach($block_list as $block_key => $info) {
        $block_uid = in_array('block_uid', array_keys($info)) ? $info['block_uid'] : '';
        
        switch($block_key) {
          case 'base':
            $block_name = 'BASE';
            $block_type = 'base';
            break;
          default:
            $block_name = in_array('name', array_keys($info)) ? $info['name'] : '';
            $block_type = 'block';
            break;
        }
        
        // スタイルをJSON化して保存
        $block_style = '';
        if(in_array('style', array_keys($info))) {
          $block_style = json_encode($info['style']);
        }
        
        if($block_uid) {
          $wp_res = $wpdb->update(
            'tb_block',
            array(
              'block_name' => $block_name,
              'block_type' => $block_type,
              'block_style' => $block_style,
            ),
            array( 'uid' => $block_uid ),
            array( '%s', '%s', '%s' ),
            array( '%s' )
          );
          
          if($wp_res) {
            $block_uid_list[$block_key] = $block_uid;
          } else {
            throw new Exception(__( 'Failed to update block', $lang_domain ));
          }
        } else {
          $block_uid = md5(uniqid(rand(), true));
          $wp_res = $wpdb->insert(
            'tb_block',
            array(
              'uid' => $block_uid,
              'block_name' => $block_name,
              'block_type' => $block_type,
              'author_id' => $author_id,
              'block_style' => $block_style,
            ),
            array( '%s', '%s', '%s', '%d', '%s' ),
          );
          
          if($wp_res) {
            $block_uid_list[$block_key] = $block_uid;
          } else {
            throw new Exception(__( 'Failed to create new block', $lang_domain ));
          }
        }
      }
      
      $block_key_list = array_keys($block_uid_list);
      
      foreach($block_list as $block_key => $info) {
        if(in_array('blocks', array_keys($info)) && in_array($block_key, $block_key_list)) {
          $blocks = array();
          foreach($info['blocks'] as $child_block_key) {
            if(in_array($child_block_key, $block_key_list)) {
              array_push($blocks, $block_uid_list[$child_block_key]);
            }
          }
          $wp_res = $wpdb->update(
            'tb_block',
            array( 'block_children' => implode(',', $blocks) ),
            array( 'uid' => $block_uid_list[$block_key] ),
            array( '%s' ),
            array( '%s' )
          );
          
          if($wp_res) {
            $block_uid_list[$block_key] = $block_uid;
          } else {
            throw new Exception(__( 'Failed to update relationship', $lang_domain ));
          }
        }
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
    $error_list['system'] = __('Login is necessary to save', $lang_domain);
  }
  
  // リポジトリ出力
  $response = array(
    'result' => $result,
    'info' => $block_list,
    'error_list' => $error_list,
    'block_uid_list' => $block_uid_list,
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
