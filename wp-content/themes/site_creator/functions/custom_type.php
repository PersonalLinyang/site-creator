<?php

/*
 * 「配色」投稿タイプと関連タクソノミー追加
 */
function create_color_pattern_type() {
  // 記事タイプ「配色」追加
  register_post_type('color_pattern',
    array(
      'label' => '配色',
      'public' => true,
      'has_archive' => false,
      'menu_position' => 101, 
      'supports' => [
        'title',
        'custom-fields',
      ]
    )
  );
  
  // タクソノミー「タイプ」追加
  register_taxonomy( 
    'color_type',
    array('color_pattern'),
    array(
      'labels' => array(
        'name' => 'タイプ',
        'edit_item' => '編集',
        'update_item' => '更新',
        'add_new_item' => 'タイプを追加'
      ),
      'meta_box_cb' => 'post_categories_meta_box',
    ) 
  );
  
  // タクソノミー「イメージ」追加
  register_taxonomy( 
    'color_image',
    array('color_pattern'),
    array(
      'labels' => array(
        'name' => 'イメージ',
        'edit_item' => '編集',
        'update_item' => '更新',
        'add_new_item' => 'タイプを追加'
      ),
      'meta_box_cb' => 'post_categories_meta_box',
    ) 
  );
}
add_action('init', 'create_color_pattern_type');


/*
 * 「サイト固定ページ」投稿タイプ追加
 */
function create_site_page_type() {
  // 記事タイプ「サイト固定ページ」追加
  register_post_type('site_page',
    array(
      'label' => 'サイト固定ページ',
      'public' => true,
      'has_archive' => false,
      'menu_position' => 103, 
      'hierarchical' => true,
      'supports' => [
        'title',
        'custom-fields',
        'page-attributes',
      ]
    )
  );
}
add_action('init', 'create_site_page_type');


/*
 * 「サイト投稿タイプ」投稿タイプ追加
 */
function create_site_type_type() {
  // 記事タイプ「サイト投稿タイプ」追加
  register_post_type('site_type',
    array(
      'label' => 'サイト投稿タイプ',
      'public' => true,
      'has_archive' => false,
      'menu_position' => 104,
      'supports' => [
        'title',
        'custom-fields',
      ]
    )
  );
}
add_action('init', 'create_site_type_type');


/*
 * 「HTMLブロック」投稿タイプ追加
 */
function create_html_block_type() {
  // 記事タイプ「HTMLブロック」追加
  register_post_type('html_block',
    array(
      'label' => 'HTMLブロック',
      'public' => true,
      'has_archive' => false,
      'menu_position' => 105,
      'supports' => [
        'title',
        'custom-fields',
      ]
    )
  );
}
add_action('init', 'create_html_block_type');



















/*
 * 「テスト」投稿タイプ追加
 */
function create_test_type() {
  // 記事タイプ「テスト」追加
  register_post_type('test',
    array(
      'label' => 'テスト',
      'public' => true,
      'has_archive' => false,
      'menu_position' => 110,
      'supports' => [
        'title',
        'custom-fields',
      ]
    )
  );
  
  // タクソノミー「タイプ」追加
  register_taxonomy( 
    '__',
    array('test'),
    array(
      'labels' => array(
        'name' => 'タイプ',
        'edit_item' => '編集',
        'update_item' => '更新',
        'add_new_item' => 'タイプを追加'
      ),
      'meta_box_cb' => 'post_categories_meta_box',
    ) 
  );
}
add_action('init', 'create_test_type');
