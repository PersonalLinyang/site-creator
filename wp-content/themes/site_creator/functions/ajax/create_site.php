<?php

/*
 * 固定ページURLチェック(再帰関数)
 */
function check_page_url($key, $index, $url, $post_data, $index_list) {
  try {
    if(array_key_exists('page_name_' . $index, $post_data)) {
      $url = '/' . $post_data['page_name_' . $index] . $url;
      if(array_key_exists('page_parent_' . $index, $post_data)) {
        $index = $post_data['page_parent_' . $index];
        if($index == '0') {
          return array(true, $url, '');
        } elseif(in_array($index, $index_list)) {
          return array(false, $url, 'roop');
        } else {
          array_push($index_list, $index);
          list($result, $url, $error) = check_page_url($key, $index, $url, $post_data, $index_list);
          return array($result, $url, $error);
        }
      } else {
        return array(false, $url, 'parent');
      }
    }
    return array(false, $url, 'url');
  }catch ( Exception $ex ) {
    return array(false, $url, $ex->getMessage ());
  }
}


/*
 * サイト基本情報バリデーションAjax処理
 */
function func_validate_create_base(){
  $result = true;
  $error_list = array();
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;

  // バリデーション
  foreach($_POST as $key => $value) {
    if($key == 'site_name') {
      // サイト名
      if($value == '') {
        $result = false;
        $error_list[$key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Name', $lang_domain));
      }
    } elseif($key == 'site_key') {
      // サイトキー
      if($value == '') {
        $result = false;
        $error_list[$key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Key', $lang_domain));
      } elseif(!preg_match("/^[a-zA-Z0-9\-_\s]+$/", $value)) {
        $result = false;
        $error_list[$key] = sprintf(__('%1$s can use %2$s only', $lang_domain), __('Site Key', $lang_domain), 
                              sprintf(__('%1$s and %2$s'), sprintf('%1$s,%2$s,%3$s', __('alphabet and number', $lang_domain), '[-]', '[_]'), __('space', $lang_domain)));
      }
    } elseif($key == 'site_host') {
      // サイトキー
      if($value == '') {
        $result = false;
        $error_list[$key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Host', $lang_domain));
      } elseif(!preg_match("/^([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}(\/[a-zA-Z0-9][a-zA-Z0-9\-_]*[a-zA-Z0-9])*(\/){0,1}$/", $value)) {
        $result = false;
        $error_list[$key] = sprintf(__('%s cannot be this format', $lang_domain), __('Site Host', $lang_domain));
      }
    }
  }
  
  // リポジトリ出力
  $response = array(
    'result' => $result,
    'errors' => $error_list,
  );
  echo json_encode($response);
  die();
}
add_action('wp_ajax_validate_create_base', 'func_validate_create_base');
add_action('wp_ajax_nopriv_validate_create_base', 'func_validate_create_base');


/*
 * 固定ページ情報バリデーションAjax処理
 */
function func_validate_create_page(){
  $result = true;
  $error_list = array();
  $existed_url_list = array();
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;

  // バリデーション
  foreach($_POST as $key => $value) {
    if(preg_match('/^page_title_\d+$/', $key)) {
      // 固定ページ名
      if($value == '') {
        $result = false;
        $error_list[$key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Page Title', $lang_domain));
      } else {
        preg_match('/\d+/', $key, $numbers);
        $index = current($numbers);
        
        if(!array_key_exists('page_name_'. $index, $_POST) || !array_key_exists('page_parent_'. $index, $_POST)) {
          $error_list['system_page'] = __( 'Page is not matched', $lang_domain );
        }
      }
    } elseif(preg_match('/^page_parent_\d+$/', $key)) {
      // 固定ページ親子関係
      if(!is_numeric($value)) {
        $result = false;
        $error_list[$key] = sprintf(__('%s is wrong', $lang_domain), __('Site Page Parent', $lang_domain));
      } else {
        preg_match('/\d+/', $key, $numbers);
        $index = current($numbers);
        
        if(!array_key_exists('page_title_'. $index, $_POST) || !array_key_exists('page_name_'. $index, $_POST)) {
          $error_list['system_page'] = __( 'Page is not matched', $lang_domain );
        }
      }
    } elseif(preg_match('/^page_name_\d+$/', $key)) {
      // 固定ページURL
      if($value == '') {
        $result = false;
        $error_list[$key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Page Name', $lang_domain));
      } elseif(!preg_match("/^[a-zA-Z0-9]([\-_]*[a-zA-Z0-9])*$/", $value)) {
        $result = false;
        $error_list[$key] = sprintf(__('%1$s can use %2$s only', $lang_domain), __('Site Page Name', $lang_domain), 
                              sprintf(__('%1$s and %2$s'), sprintf('%1$s,%2$s', __('alphabet and number', $lang_domain), '[-]'), '[_]'));
      } else {
        preg_match('/\d+/', $key, $numbers);
        $index = current($numbers);
        
        if(!array_key_exists('page_title_'. $index, $_POST) || !array_key_exists('page_parent_'. $index, $_POST)) {
          $result = false;
          $error_list['system_page'] = __( 'Page is not matched', $lang_domain );
        } else {
          $url = '';
          list($result_url, $url, $error) = check_page_url($index, $index, '/', $_POST, array());
          if(!$result_url) {
            if($error == 'roop' || $error = 'parent') {
              $result = false;
              $error_list[$key] = sprintf(__('%s is wrong', $lang_domain), __('Site Page Parent', $lang_domain));
            } else {
              $result = false;
              $error_list[$key] = sprintf(__('%s cannot be getted correctly', $lang_domain), __('Site Page Url', $lang_domain));
            }
          } elseif(in_array($url, $existed_url_list)) {
            $result = false;
            $error_list[$key] = sprintf(__('%s had been existed', $lang_domain), __('Site Page Url', $lang_domain));
          } else {
            array_push($existed_url_list, $url);
          }
        }
      }
    }
  }
  
  // リポジトリ出力
  $response = array(
    'result' => $result,
    'existed_url' => $existed_url_list,
    'errors' => $error_list,
  );
  echo json_encode($response);
  die();
}
add_action('wp_ajax_validate_create_page', 'func_validate_create_page');
add_action('wp_ajax_nopriv_validate_create_page', 'func_validate_create_page');

/*
 * 投稿タイプ情報バリデーションAjax処理
 */
function func_validate_create_type(){
  $result = true;
  $error_list = array();
  $type_slug_list = array();
  $taxonomy_slug_list = array();
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;

  // バリデーション
  foreach($_POST as $key => $value) {
    if(preg_match('/^type_name_(\d+|post)$/', $key)) {
      // 投稿タイプ名
      if($value == '') {
        $result = false;
        $error_list[$key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Type Name', $lang_domain));
      }
    } elseif(preg_match('/^type_slug_(\d+|post)$/', $key)) {
      // 投稿タイプキー
      if($value == '') {
        $result = false;
        $error_list[$key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Type Slug', $lang_domain));
      } elseif(mb_strlen($str1) > 20) {
        $result = false;
        $error_list[$key] = sprintf(__('%1$s cannot be over %2$s characters', $lang_domain), __('Site Type Slug', $lang_domain), '20');
      } elseif($key != 'type_slug_post' && $value == 'post') {
        $result = false;
        $error_list[$key] = sprintf(__('%1$s cannot be same as %2$s', $lang_domain), __('Site Type Slug', $lang_domain), '[post]');
      } elseif($key != 'type_slug_post' && $value == 'page') {
        $result = false;
        $error_list[$key] = sprintf(__('%1$s cannot be same as %2$s', $lang_domain), __('Site Type Slug', $lang_domain), '[page]');
      } elseif(!preg_match("/^([a-z0-9\-_])*$/", $value)) {
        $result = false;
        $error_list[$key] = sprintf(__('%1$s can use %2$s only', $lang_domain), __('Site Type Slug', $lang_domain), 
                              sprintf(__('%1$s and %2$s'), sprintf('%1$s,%2$s,%3$s', __('small alphabet', $lang_domain), __('number', $lang_domain), '[-]'), '[_]'));
      } elseif(in_array($value, $type_slug_list)) {
        $result = false;
        $error_list[$key] = sprintf(__('%1$s had been existed', $lang_domain), __('Site Type Slug', $lang_domain));
      } else {
        array_push($type_slug_list, $value);
      }
    } elseif(preg_match('/^type_tax_name_(\d+|post)_\d+$/', $key)) {
      // タクソノミー名
      if($value == '') {
        $result = false;
        $error_list[$key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Type Taxonomy Name', $lang_domain));
      }
    } elseif(preg_match('/^type_tax_slug_(\d+|post)_\d+$/', $key)) {
      // タクソノミー名
      if($value == '') {
        $result = false;
        $error_list[$key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Type Taxonomy Slug', $lang_domain));
      } elseif(mb_strlen($str1) > 32) {
        $result = false;
        $error_list[$key] = sprintf(__('%1$s cannot be over %2$s characters', $lang_domain), __('Site Type Taxonomy Slug', $lang_domain), '32');
      } elseif($value == 'category') {
        $result = false;
        $error_list[$key] = sprintf(__('%1$s cannot be same as %2$s', $lang_domain), __('Site Type Taxonomy Slug', $lang_domain), '[category]');
      } elseif($value == 'tag') {
        $result = false;
        $error_list[$key] = sprintf(__('%1$s cannot be same as %2$s', $lang_domain), __('Site Type Taxonomy Slug', $lang_domain), '[tag]');
      } elseif(!preg_match("/^([a-z_])*$/", $value)) {
        $result = false;
        $error_list[$key] = sprintf(__('%1$s can use %2$s only', $lang_domain), __('Site Type Taxonomy Slug', $lang_domain), 
                              sprintf(__('%1$s and %2$s'), __('small alphabet', $lang_domain), '[_]'));
      } elseif(in_array($value, $taxonomy_slug_list)) {
        $result = false;
        $error_list[$key] = sprintf(__('%1$s had been existed', $lang_domain), __('Site Type Taxonomy Slug', $lang_domain));
      } else {
        array_push($taxonomy_slug_list, $value);
      }
    } elseif(preg_match('/^type_check_(\d+|post)_archive$/', $key)) {
      // 記事一覧URL
      if($value == 'on') {
        $url_key = str_replace('check_', 'url_', $key);
        if(!in_array($url_key, array_keys($_POST))) {
          $error_list[$key] = sprintf(__('%s cannot be found', $lang_domain), __('Site Type Archive Url', $lang_domain));
        } else {
          $url_value = $_POST[$url_key];
          $allow_content = '[a-zA-Z0-9]';
          if($url_value == '') {
            $result = false;
            $error_list[$url_key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Type Archive Url', $lang_domain));
          } elseif(!preg_match("/^((" . $allow_content . ")([\-_]*(" . $allow_content . "))*(\/){0,1})*$/", $url_value)) {
            $result = false;
            $error_list[$url_key] = sprintf(__('%s cannot be this format', $lang_domain), __('Site Type Archive Url', $lang_domain));
          }
        }
      }
    } elseif(preg_match('/^type_check_(\d+|post)_single$/', $key)) {
      // 記事詳細URL
      if($value == 'on') {
        $url_key = str_replace('check_', 'url_', $key);
        if(!in_array($url_key, array_keys($_POST))) {
          $error_list[$key] = sprintf(__('%s cannot be found', $lang_domain), __('Site Type Single Url', $lang_domain));
        } else {
          $url_value = $_POST[$url_key];
          $allow_content = '[a-zA-Z0-9]|%Year%|%year%|%Month%|%month%|%Day%|%day%|%postid%|%postname%';
          if($url_value == '') {
            $result = false;
            $error_list[$url_key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Type Single Url', $lang_domain));
          } elseif(!preg_match("/^((" . $allow_content . ")([\-_]*(" . $allow_content . "))*(\/){0,1})*$/", $url_value)) {
            $result = false;
            $error_list[$url_key] = sprintf(__('%s cannot be this format', $lang_domain), __('Site Type Single Url', $lang_domain));
          }
        }
      }
    } elseif(preg_match('/^type_check_(\d+|post)_(\d+|category|tag)$/', $key)) {
      // カテゴリ/タグ/カスタムタクソノミー記事一覧URL
      if($value == 'on') {
        $url_key = str_replace('check_', 'url_', $key);
        if(!in_array($url_key, array_keys($_POST))) {
          $error_list[$key] = sprintf(__('%s cannot be found', $lang_domain), __('Site Type Taxonomy Url', $lang_domain));
        } else {
          $url_value = $_POST[$url_key];
          $allow_content = '[a-zA-Z0-9]|%slug%';
          if($url_value == '') {
            $result = false;
            $error_list[$url_key] = sprintf(__('%s cannot be empty', $lang_domain), __('Site Type Taxonomy Url', $lang_domain));
          } elseif(!preg_match("/^((" . $allow_content . ")([\-_]*(" . $allow_content . "))*(\/){0,1})*$/", $url_value)) {
            $result = false;
            $error_list[$url_key] = sprintf(__('%s cannot be this format', $lang_domain), __('Site Type Taxonomy Url', $lang_domain));
          }
        }
      }
    }
  }
  
  // リポジトリ出力
  $response = array(
    'result' => $result,
    'errors' => $error_list,
  );
  echo json_encode($response);
  die();
}
add_action('wp_ajax_validate_create_type', 'func_validate_create_type');
add_action('wp_ajax_nopriv_validate_create_type', 'func_validate_create_type');

/*
 * サイト作成Ajax処理
 */
function func_create_site(){
  $result = true;
  $site_uid = md5(uniqid(rand(), true));
  $error_list = array();
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  
  // サイト作成
  if(is_user_logged_in()) {
    $user_id = get_current_user_id();
    
    global $wpdb;
    
    try {
      $wpdb->query('START TRANSACTION');
      
      // サイト作成
      $site = array(
        'post_name'      => $site_uid,
        'post_title'     => $_POST['site_name'],
        'post_status'    => 'publish',
        'post_type'      => 'site',
        'post_author'    => $user_id,
      );
      $site_id = wp_insert_post($site);
      add_post_meta($site_id, 'site_key', $_POST['site_key']);
      add_post_meta($site_id, 'site_http', $_POST['site_http']);
      add_post_meta($site_id, 'site_host', $_POST['site_host']);
      add_post_meta($site_id, 'site_status', 'new');
      
      // 固定ページ作成
      $page_id_list = array();
      $page_title_key_list = array_filter(array_keys($_POST), function($key){ return preg_match("/^page_title_\d+$/" , $key); });
      foreach($page_title_key_list as $page_title_key) {
        preg_match('/\d+/', $page_title_key, $numbers);
        $index = current($numbers);
        $page_parent_key = 'page_parent_' . $index;
        $page_name_key = 'page_name_' . $index;
        
        $site_page_uid = md5(uniqid(rand(), true));
        $site_page = array(
          'post_name'      => $site_page_uid,
          'post_title'     => $_POST[$page_title_key],
          'post_status'    => 'publish',
          'post_type'      => 'site_page',
          'post_author'    => $user_id,
        );
        $site_page_id = wp_insert_post($site_page);
        add_post_meta($site_page_id, 'site', $site_id);
        add_post_meta($site_page_id, 'post_name', $_POST[$page_name_key]);
        if(array_key_exists('p' . $_POST[$page_parent_key], $page_id_list)) {
          add_post_meta($site_page_id, 'post_parent', $page_id_list['p' . $_POST[$page_parent_key]]);
        } else {
          add_post_meta($site_page_id, 'post_parent', NULL);
        }
        
        $page_id_list['p' . $index] = $site_page_id;
      }
      
      // 「投稿」投稿タイプ情報保存
      add_post_meta($site_id, 'post_info', '');
      add_post_meta($site_id, 'post_info_type_url_key', $_POST['type_slug_post']);
      
      if(array_key_exists('type_check_post_archive', $_POST) && $_POST['type_check_post_archive'] == 'on') {
        add_post_meta($site_id, 'post_info_archive_flag', 1);
        add_post_meta($site_id, 'post_info_archive_url', $_POST['type_url_post_archive']);
      } else {
        add_post_meta($site_id, 'post_info_archive_flag', 0);
      }
      
      if(array_key_exists('type_check_post_single', $_POST) && $_POST['type_check_post_single'] == 'on') {
        add_post_meta($site_id, 'post_info_single_flag', 1);
        add_post_meta($site_id, 'post_info_single_url', $_POST['type_url_post_single']);
      } else {
        add_post_meta($site_id, 'post_info_single_flag', 0);
      }
      
      if(array_key_exists('type_check_post_category', $_POST) && $_POST['type_check_post_category'] == 'on') {
        add_post_meta($site_id, 'post_info_category_flag', 1);
        add_post_meta($site_id, 'post_info_category_url', $_POST['type_url_post_category']);
      } else {
        add_post_meta($site_id, 'post_info_category_flag', 0);
      }
      
      if(array_key_exists('type_check_post_tag', $_POST) && $_POST['type_check_post_tag'] == 'on') {
        add_post_meta($site_id, 'post_info_tag_flag', 1);
        add_post_meta($site_id, 'post_info_tag_url', $_POST['type_url_post_tag']);
      } else {
        add_post_meta($site_id, 'post_info_tag_flag', 0);
      }
      
      $tax_counter = 0;
      $tax_name_key_list = array_filter(array_keys($_POST), function($key){ return preg_match("/^type_tax_name_post_\d+$/" , $key); });
      foreach($tax_name_key_list as $tax_name_key) {
        $tax_slug_key = str_replace('name', 'slug', $tax_name_key);
        $tax_check_key = str_replace('tax_name', 'check', $tax_name_key);
        $tax_url_key = str_replace('tax_name', 'url', $tax_name_key);
        
        add_post_meta($site_id, 'post_info_taxonomy_' . $tax_counter . '_name', $_POST[$tax_name_key]);
        add_post_meta($site_id, 'post_info_taxonomy_' . $tax_counter . '_slug', $_POST[$tax_slug_key]);
        
        if(array_key_exists($tax_check_key, $_POST) && $_POST[$tax_check_key] == 'on') {
          add_post_meta($site_id, 'post_info_taxonomy_' . $tax_counter . '_archive_flag', 1);
          add_post_meta($site_id, 'post_info_taxonomy_' . $tax_counter . '_archive_url', $_POST[$tax_url_key]);
        } else {
          add_post_meta($site_id, 'post_info_taxonomy_' . $tax_counter . '_archive_flag', 0);
        }
        
        $tax_counter++;
      }
      add_post_meta($site_id, 'post_info_taxonomy', $tax_counter);
      
      // 投稿タイプ作成
      $type_name_key_list = array_filter(array_keys($_POST), function($key){ return preg_match("/^type_name_\d+$/" , $key); });
      foreach($type_name_key_list as $type_name_key) {
        preg_match('/\d+/', $type_name_key, $numbers);
        $index = current($numbers);
        $type_slug_key = 'type_slug_' . $index;
        $type_check_archive_key = 'type_check_' . $index . '_archive';
        $type_url_archive_key = 'type_url_' . $index . '_archive';
        $type_check_single_key = 'type_check_' . $index . '_single';
        $type_url_single_key = 'type_url_' . $index . '_single';
        
        $site_type_uid = md5(uniqid(rand(), true));
        $site_type = array(
          'post_name'      => $site_type_uid,
          'post_title'     => $_POST[$type_name_key],
          'post_status'    => 'publish',
          'post_type'      => 'site_type',
          'post_author'    => $user_id,
        );
        $site_type_id = wp_insert_post($site_type);
        add_post_meta($site_type_id, 'site', $site_id);
        add_post_meta($site_type_id, 'post_type', $_POST[$type_slug_key]);
        
        if(array_key_exists($type_check_archive_key, $_POST) && $_POST[$type_check_archive_key] == 'on') {
          add_post_meta($site_type_id, 'archive_flag', 1);
          add_post_meta($site_type_id, 'archive_url', $_POST[$type_url_archive_key]);
        } else {
          add_post_meta($site_type_id, 'archive_flag', 0);
        }
        
        if(array_key_exists($type_check_single_key, $_POST) && $_POST[$type_check_single_key] == 'on') {
          add_post_meta($site_type_id, 'single_flag', 1);
          add_post_meta($site_type_id, 'single_url', $_POST[$type_url_single_key]);
        } else {
          add_post_meta($site_type_id, 'single_flag', 0);
        }
        
        $tax_counter = 0;
        $tax_name_key_list = array();
        foreach(array_keys($_POST) as $temp_key) {
          if(preg_match("/^type_tax_name_" . $index . "_\d+$/", $temp_key)) {
            array_push($tax_name_key_list, $temp_key);
          }
        }
        foreach($tax_name_key_list as $tax_name_key) {
          $tax_slug_key = str_replace('name', 'slug', $tax_name_key);
          $tax_check_key = str_replace('tax_name', 'check', $tax_name_key);
          $tax_url_key = str_replace('tax_name', 'url', $tax_name_key);
          
          add_post_meta($site_type_id, 'taxonomy_' . $tax_counter . '_name', $_POST[$tax_name_key]);
          add_post_meta($site_type_id, 'taxonomy_' . $tax_counter . '_slug', $_POST[$tax_slug_key]);
          
          if(array_key_exists($tax_check_key, $_POST) && $_POST[$tax_check_key] == 'on') {
            add_post_meta($site_type_id, 'taxonomy_' . $tax_counter . '_archive_flag', 1);
            add_post_meta($site_type_id, 'taxonomy_' . $tax_counter . '_archive_url', $_POST[$tax_url_key]);
          } else {
            add_post_meta($site_type_id, 'taxonomy_' . $tax_counter . '_archive_flag', 0);
          }
          
          $tax_counter++;
        }
        add_post_meta($site_type_id, 'taxonomy', $tax_counter);
      }
      
      $wpdb->query('COMMIT');
    } catch(Exception $ex) {
      $result = false;
      $error_list['system_site'] = __( 'Failed to create site', $lang_domain );
      $wpdb->query('ROLLBACK');
    }
  } else {
    $result = false;
    $error_list['system_site'] = __('Login is necessary to create site', $lang_domain);
  }
  
  // リポジトリ出力
  $response = array(
    'result' => $result,
    'url' => get_site_url() . '/site/' . $site_uid . '/',
    'errors' => $error_list,
  );
  echo json_encode($response);
  die();
}
add_action('wp_ajax_create_site', 'func_create_site');
add_action('wp_ajax_nopriv_create_site', 'func_create_site');
