<?php

// 選択型カスタムフィールド選択肢リスト取得
function get_acf_select_options($field_group, $field_key) {
  $options = array();
  $acfg = get_page_by_title('ACFG For ' . $field_group, OBJECT, 'acf-field-group');
  if($acfg) {
    global $wpdb;
    $sql = 'SELECT post_content FROM wp_posts WHERE post_type="acf-field" AND post_parent = ' . $acfg->ID . ' AND post_excerpt ="' . $field_key . '"';
    $acf_query = $wpdb->get_results($wpdb->prepare($sql));
    if(count($acf_query)) {
      $acf_content = maybe_unserialize(current($acf_query)->post_content);
      if(array_key_exists('choices', $acf_content)) {
        $options = $acf_content['choices'];
      }
    }
  }
  return $options;
}