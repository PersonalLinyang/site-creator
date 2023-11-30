<?php

/*
 * style.css作成
 */
function write_style_css($result, $error_list, $zip, $site, $theme_dir) {
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  $content = '';
  
  $file_name = 'style.css';
  $file_path = $theme_dir . $file_name;
  
  try {
    $file_handle = fopen( $file_path, "w");
    
    $content .= <<<EOT
@charset "UTF-8";
/*
EOT . PHP_EOL;
    $content .= 'Theme Name: ' . $site->site_name . PHP_EOL;
    $content .= 'Author: ' . __( 'This Site Name', 'site-creator-en' ) . PHP_EOL;
    $content .= <<<EOT
Version: 1.0
*/
EOT . PHP_EOL;
    
    fwrite( $file_handle, $content);
    
    fclose($file_handle);
    
    $zip->addFile($file_path, $file_name);
  } catch ( Exception $ex ) {
    $result = false;
    $error_list['system'] = sprintf(__('Failed to create file %1$s, Error Message: %2$s', $lang_domain), $file_name, $ex->getMessage());
  }
  
  return array($result, $error_list, $zip);
}


/*
 * functions.php作成
 */
function write_functions_php($result, $error_list, $zip, $site, $theme_dir) {
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  $content = '';
  
  $file_name = 'functions.php';
  $file_path = $theme_dir . $file_name;
  
  try {
    $file_handle = fopen( $file_path, "w");
    
    $content .= <<<EOT
<?php 
EOT . PHP_EOL;
    
    fwrite( $file_handle, $content);
    
    fclose($file_handle);
    
    $zip->addFile($file_path, $file_name);
  } catch ( Exception $ex ) {
    $result = false;
    $error_list['system'] = sprintf(__('Failed to create file %1$s, Error Message: %2$s', $lang_domain), $file_name, $ex->getMessage());
  }
  
  return array($result, $error_list, $zip);
}


/*
 * header.php作成
 */
function write_header_php($result, $error_list, $zip, $site, $theme_dir) {
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  $content = '';
  
  $file_name = 'header.php';
  $file_path = $theme_dir . $file_name;
  
  try {
    $file_handle = fopen( $file_path, "w");
    
    $content .= <<<EOT
<?php
/*
 * ヘッダ部分
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>

    <header>
    </header>

    <main>
EOT;
    
    fwrite( $file_handle, $content);
    
    fclose($file_handle);
    
    $zip->addFile($file_path, $file_name);
  } catch ( Exception $ex ) {
    $result = false;
    $error_list['system'] = sprintf(__('Failed to create file %1$s, Error Message: %2$s', $lang_domain), $file_name, $ex->getMessage());
  }
  
  return array($result, $error_list, $zip);
}


/*
 * footer.php作成
 */
function write_footer_php($result, $error_list, $zip, $site, $theme_dir) {
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  $content = '';
  
  $file_name = 'footer.php';
  $file_path = $theme_dir . $file_name;
  
  try {
    $file_handle = fopen( $file_path, "w");
    
    $content .= <<<EOT
<?php
?>
    </main>
    <footer>
    </footer>
    <?php wp_footer(); ?>
  </body>
</html>
EOT . PHP_EOL;
    
    fwrite( $file_handle, $content);
    
    fclose($file_handle);
    
    $zip->addFile($file_path, $file_name);
  } catch ( Exception $ex ) {
    $result = false;
    $error_list['system'] = sprintf(__('Failed to create file %1$s, Error Message: %2$s', $lang_domain), $file_name, $ex->getMessage());
  }
  
  return array($result, $error_list, $zip);
}


/*
 * index.php作成
 */
function write_index_php($result, $error_list, $zip, $site, $theme_dir) {
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  $content = '';
  
  $file_name = 'index.php';
  $file_path = $theme_dir . $file_name;
  
  try {
    $file_handle = fopen( $file_path, "w");
    
    $content .= <<<EOT
<?php
get_header();
?>
<?php
get_footer();
EOT . PHP_EOL;
    
    fwrite( $file_handle, $content);
    
    fclose($file_handle);
    
    $zip->addFile($file_path, $file_name);
  } catch ( Exception $ex ) {
    $result = false;
    $error_list['system'] = sprintf(__('Failed to create file %1$s, Error Message: %2$s', $lang_domain), $file_name, $ex->getMessage());
  }
  
  return array($result, $error_list, $zip);
}


/*
 * テーマZIP化Ajax処理
 */
function func_zip_theme(){
  $result = true;
  $error_list = array();
  $upload_dir = wp_upload_dir();
  
  $site_uid = $_POST['site_uid'];
  
  $zip_name = $site_uid . '.zip';
  $zip_relative_path = '/theme_zip/';
  $zip_dir = $upload_dir['basedir'] . $zip_relative_path;
  $theme_dir = $zip_dir . $site_uid . '/';
  $zip_path = $zip_dir . $zip_name;
  $zip_url = $upload_dir['baseurl'] . $zip_relative_path . $zip_name;
  
  if(!file_exists($zip_dir)) {
    mkdir($zip_dir, 0777);
  }
  
  if(!file_exists($theme_dir)) {
    mkdir($theme_dir, 0777);
  }
  
  $zip = new ZipArchive;
  $zip->open($zip_path, ZipArchive::CREATE|ZipArchive::OVERWRITE);
  
  if(is_writable($theme_dir)) {
    global $wpdb;
    $site_sql = 'SELECT * FROM tb_site WHERE uid="' . $site_uid . '"';
    $site_query = $wpdb->get_results($wpdb->prepare($site_sql));
    
    if(count($site_query)) {
      $site = current($site_query);
      
      // style.css作成
      if($result) { list($result, $error_list, $zip) = write_style_css($result, $error_list, $zip, $site, $theme_dir); }
      
      // functions.php作成
      if($result) { list($result, $error_list, $zip) = write_functions_php($result, $error_list, $zip, $site, $theme_dir); }
      
      // header.php作成
      if($result) { list($result, $error_list, $zip) = write_header_php($result, $error_list, $zip, $site, $theme_dir); }
      
      // footer.php作成
      if($result) { list($result, $error_list, $zip) = write_footer_php($result, $error_list, $zip, $site, $theme_dir); }
      
      // index.php作成
      if($result) { list($result, $error_list, $zip) = write_index_php($result, $error_list, $zip, $site, $theme_dir); }
      
      $result = $zip->close();
    } else {
      $result = false;
      $error_list['system'] = __( 'Failed to create theme', $lang_domain );
    }
  } else {
    $result = false;
    $error_list['system'] = __( 'Can not write on theme_zip directory', $lang_domain );
  }
  
  // リポジトリ出力
  $response = array(
    'result' => $result,
    'zip_url' => $zip_url,
    'zip_name' => $zip_name,
    'errors' => $error_list,
  );
  echo json_encode($response);
  die();
}
add_action('wp_ajax_zip_theme', 'func_zip_theme');
add_action('wp_ajax_nopriv_zip_theme', 'func_zip_theme');
