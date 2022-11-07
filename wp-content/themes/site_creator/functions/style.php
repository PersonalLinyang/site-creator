<?php

/*
 * CSS呼び出し
 */
function my_enqueue_styles() {
  $post = get_post();
  $css_common_path = 'assets/css/common/common.css';
  wp_enqueue_style('css_common', get_theme_file_uri($css_common_path), array(), filemtime(get_theme_file_path($css_common_path)), 'all');
  
  $editor_flag = False;
  if(is_page() && get_field('editor_flag', $post->ID)) {
    require_once get_template_directory() . '/inc/custom-functions/check_site_editor_permission.inc.php';
    $check_result = check_site_editor_permission();
    if($check_result['result']) {
      $editor_flag = True;
    }
  }
  
  if($editor_flag) {
    $css_colorpicker_path = 'assets/plugins/colorpicker/css/colorpicker.css';
    wp_enqueue_style('css_colorpicker', get_theme_file_uri($css_colorpicker_path), array(), filemtime(get_theme_file_path($css_colorpicker_path)), 'all');
    
    $css_editor_path = 'assets/css/common/editor.css';
    wp_enqueue_style('css_editor', get_theme_file_uri($css_editor_path), array('css_common'), filemtime(get_theme_file_path($css_editor_path)), 'all');
  } else {
    $css_normal_path = 'assets/css/common/normal.css';
    wp_enqueue_style('css_normal', get_theme_file_uri($css_normal_path), array('css_common'), filemtime(get_theme_file_path($css_normal_path)), 'all');
  }
  
  if(is_page()) {
    $css_page_path = 'assets/css/page/' . $post->post_name . '.css';
    if(file_exists(get_theme_file_path($css_page_path))) {
      wp_enqueue_style('css_page', get_theme_file_uri($css_page_path), array('css_common', 'css_normal'), filemtime(get_theme_file_path($css_page_path)), 'all');
    }
  } elseif(is_singular()) {
    $css_page_path = 'assets/css/single/' . $post->post_type . '.css';
    if(file_exists(get_theme_file_path($css_page_path))) {
      wp_enqueue_style('css_page', get_theme_file_uri($css_page_path), array('css_common', 'css_normal'), filemtime(get_theme_file_path($css_page_path)), 'all');
    }
  }
}
add_action('wp_enqueue_scripts', 'my_enqueue_styles');
