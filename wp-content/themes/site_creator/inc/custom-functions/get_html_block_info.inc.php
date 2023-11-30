<?php

// HTMLブロック情報を取得
function get_html_block_info($block_uid) {
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  
  // 再帰中に実行回数を記録するインデックス
  static $block_index = 0;
  
  // ブロック情報を取得
  global $wpdb;
  $sql = 'SELECT * FROM tb_block WHERE uid="' . $block_uid . '"';
  $query = $wpdb->get_results($wpdb->prepare($sql));
  
  if(count($query)) {
    // ブロック基本情報取得
    $block_name = current($query)->block_name;
    $block_type = current($query)->block_type;
    if($block_type == 'base') {
      $block_key = 'base';
    } else {
      $block_key = $block_type . $block_index;
    }
    
    // ブロックのスタイルを取得しディコード
    $block_style = array();
    $block_style_json = current($query)->block_style;
    if($block_style_json) {
      try {
        $block_style = json_decode($block_style_json, true);
      } catch(Exception $e) {
        // JSONディコードできない
        return '';
      }
    }
    
    // ブロック情報を初期化
    $block_info = array(
      'uid' => $block_uid,
      'key' => $block_key,
      'name' => $block_name,
      'type' => $block_type,
      'style' => $block_style,
      'blocks' => array(),
    );
    
    // インデックスをプラス（これ以前に再帰しない、これ以降にインデックスを使う場所がないように注意）
    $block_index++;
    
    // 子ブロックを取得
    $block_children = explode(',', current($query)->block_children);
    if(is_array($block_children)) {
      foreach($block_children as $child_block_uid) {
        // 子ブロック情報を整理（再帰処理）し、現在のブロック情報に追加
        $child_block_info = get_html_block_info($child_block_uid);
        if(is_array($child_block_info)) {
          array_push($block_info['blocks'], $child_block_info);
        }
      }
    }
    
    return $block_info;
  } else {
    return '';
  }
}