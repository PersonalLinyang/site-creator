<?php

// HTMLブロック情報を取得
function get_html_block_info($block_id) {
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  
  // 再帰中に実行回数を記録するインデックス
  static $block_index = 0;
  
  // ブロックタイプを取得
  $block_type = get_field('type', $block_id);
  
  // タイプによって名前とキーを取得
  switch($block_type) {
    case 'body':
      $block_name = __('Site Whole Style', $lang_domain);
      $block_key = 'body';
      break;
    case 'header':
      $block_name = __('Header', $lang_domain);
      $block_key = 'header';
      break;
    case 'main':
      $block_name = __('Main Content', $lang_domain);
      $block_key = 'main';
      break;
    case 'footer':
      $block_name = __('Footer', $lang_domain);
      $block_key = 'footer';
      break;
    default:
      $block_name = get_the_title($block_id);
      $block_key = $block_type . $block_index;
      break;
  }
  
  // スタイル情報を取得
  $block_style = get_field('style', $block_id);
  
  // ブロック情報を初期化
  $block_info = array(
    'id' => $block_id,
    'key' => $block_key,
    'name' => $block_name,
    'type' => $block_type,
    'style' => $block_style ? json_decode(get_field('style', $block_id), true) : array(),
    'blocks' => array(),
  );
  
  // インデックスをプラス（これ以前に再帰しない、これ以降にインデックスを使う場所がないように注意）
  $block_index++;
  
  // 子ブロックを取得
  $child_block_id_list = get_field('blocks', $block_id);
  if(is_array($child_block_id_list)) {
    foreach($child_block_id_list as $child_block_id) {
      // 子ブロック情報を整理（再帰処理）し、現在のブロック情報に追加
      array_push($block_info['blocks'], get_html_block_info($child_block_id));
    }
  }
  
  return $block_info;
}