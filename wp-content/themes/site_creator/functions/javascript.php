<?php

/*
 * Ajax送信先URL設定
 */
function add_my_ajaxurl() {
?>
  <script>
    var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
  </script>
<?php
}
add_action( 'wp_head', 'add_my_ajaxurl', 1 );


/*
 * Jquery翻訳リスト取得
 */
function get_js_translations($key) {
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  $translations = array();
  
  switch($key) {
    case 'common_common':
      $translations = array(
        'system_error'                  => __('System Error', $lang_domain),
      );
      break;
    case 'common_editor':
      $translations = array(
        'background_layer'              => __('Background Layer', $lang_domain),
        'background_layer_name_ph'      => __('Background Layer Name Placeholder', $lang_domain),
        'background_type_ph'            => __('Background Type Placeholder', $lang_domain),
        'background_solid'              => __('Solid', $lang_domain),
        'background_picture'            => __('Picture', $lang_domain),
        'background_gradient'           => __('Gradient', $lang_domain),
        'background_repeat'             => __('Background Repeat', $lang_domain),
        'responsive_flag'               => __('Responsive Flag', $lang_domain),
        'responsive_pc'                 => __('Responsive PC', $lang_domain),
        'responsive_sp'                 => __('Responsive SP', $lang_domain),
        'responsive_sp'                 => __('Responsive SP', $lang_domain),
        'file_upload'                   => __('File Upload', $lang_domain),
        'add_gradient'                  => __('Add Gradient Color', $lang_domain),
        'gradient_linear'               => __('Gradient Linear', $lang_domain),
        'gradient_radial'               => __('Gradient Radial', $lang_domain),
        'gradient_conic'                => __('Gradient Conic', $lang_domain),
        'gradient_to_bottom'            => __('To Bottom', $lang_domain),
        'gradient_to_right'             => __('To Right', $lang_domain),
        'gradient_to_top_right'         => __('To Top Right', $lang_domain),
        'gradient_to_bottom_right'      => __('To Bottom Right', $lang_domain),
        'gradient_custom_rotate'        => __('Gradient Custom Rotate', $lang_domain),
        'gradient_rotate'               => __('Gradient Rotate', $lang_domain),
        'gradient_ellipse'              => __('Gradient Ellipse', $lang_domain),
        'gradient_circle'               => __('Gradient Circle', $lang_domain),
        'background_center'             => __('Background Center', $lang_domain),
        'background_top'                => __('Background Top', $lang_domain),
        'background_bottom'             => __('Background Bottom', $lang_domain),
        'background_left'               => __('Background Left', $lang_domain),
        'background_right'              => __('Background Right', $lang_domain),
        'background_top_left'           => __('Background Top Left', $lang_domain),
        'background_top_right'          => __('Background Top Right', $lang_domain),
        'background_bottom_left'        => __('Background Bottom Left', $lang_domain),
        'background_bottom_right'       => __('Background Bottom Right', $lang_domain),
        'background_custom_position'    => __('Background Custom Position', $lang_domain),
        'gradient_center_position_x'    => __('Gradient Center Position X', $lang_domain),
        'gradient_center_position_y'    => __('Gradient Center Position Y', $lang_domain),
      );
      break;
    case 'page_create-site':
      $translations = array(
        'page_title'                    => __('Site Page Title', $lang_domain),
        'page_name'                     => __('Site Page Name', $lang_domain),
        'page_subplus_float'            => __('Site Page SubPlus Float', $lang_domain),
        'page_delete_float'             => __('Site Page Delete Float', $lang_domain),
        'type_name'                     => __('Site Type Name', $lang_domain),
        'type_slug'                     => __('Site Type Slug', $lang_domain),
        'type_delete'                   => __('Site Type Delete', $lang_domain),
        'type_body_title'               => __('Site Type Body Title', $lang_domain),
        'type_body_url'                 => __('Site Type Body URL', $lang_domain),
        'type_archive'                  => __('Site Type Archive', $lang_domain),
        'type_archive_url'              => __('Site Type Archive Url', $lang_domain),
        'type_single'                   => __('Site Type Single', $lang_domain),
        'type_single_url'               => __('Site Type Single Url', $lang_domain),
        'type_year_four'                => __('Site Type Year Four', $lang_domain),
        'type_year_two'                 => __('Site Type Year Two', $lang_domain),
        'type_month_two'                => __('Site Type Month Two', $lang_domain),
        'type_month_one'                => __('Site Type Month One', $lang_domain),
        'type_day_two'                  => __('Site Type Day Two', $lang_domain),
        'type_day_one'                  => __('Site Type Day One', $lang_domain),
        'type_post_id'                  => __('Site Type Post Id', $lang_domain),
        'type_post_name'                => __('Site Type Post Name', $lang_domain),
        'type_tax_post_list'            => __('Site Type Taxonomy Post List', $lang_domain),
        'type_tax_plus'                 => __('Site Type Taxonomy Plus', $lang_domain),
        'type_tax_name'                 => __('Site Type Taxonomy Name', $lang_domain),
        'type_tax_slug'                 => __('Site Type Taxonomy Slug', $lang_domain),
        'type_tax_url'                  => __('Site Type Taxonomy Url', $lang_domain),
        'type_tax_delete_float'         => __('Site Type Taxonomy Delete Float', $lang_domain),
        'type_term_slug'                => __('Site Type Term Slug', $lang_domain),
      );
      break;
  }
  
  return $translations;
}


/*
 * Jquery呼び出しと内容翻訳設定
 */
function my_enqueue_scripts() {
  $post = get_post();
  $translations = array();
  
  wp_enqueue_script('js_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', array(), false);
  wp_enqueue_script('js_jquery_ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array(), false);
  
  $js_common_common_path = 'assets/js/common/common.js';
  wp_enqueue_script('js_common_common', get_theme_file_uri($js_common_common_path), array('js_jquery', 'js_jquery_ui'), filemtime(get_theme_file_path($js_common_common_path)));
  $translations = array_merge($translations, get_js_translations('common_common'));

  if(is_page() && get_field('editor_flag', $post->ID)) {
    $js_colorpicker_path = 'assets/plugins/colorpicker/js/colorpicker.js';
    wp_enqueue_script('js_colorpicker', get_theme_file_uri($js_colorpicker_path), array('js_jquery', 'js_jquery_ui'), filemtime(get_theme_file_path($js_colorpicker_path)));
    
    $js_upload_image_path = 'assets/plugins/upload-image/upload-image.js';
    wp_enqueue_script('js_upload_image', get_theme_file_uri($js_upload_image_path), array('js_jquery', 'js_jquery_ui'), filemtime(get_theme_file_path($js_upload_image_path)));
    $upload_param = array(
      'upload_url' => admin_url( 'async-upload.php' ),
      'nonce' => wp_create_nonce( 'media-form' ),
    );
    wp_localize_script( 'js_upload_image', 'upload_param', $upload_param );
    
    $js_common_editor_common_path = 'assets/js/common/editor/common.js';
    wp_enqueue_script('js_common_editor_common', get_theme_file_uri($js_common_editor_common_path), 
        array('js_common_common'), filemtime(get_theme_file_path($js_common_editor_common_path)));
    
    $js_common_editor_background_path = 'assets/js/common/editor/background.js';
    wp_enqueue_script('js_common_editor_background', get_theme_file_uri($js_common_editor_background_path), 
        array('js_common_editor_common'), filemtime(get_theme_file_path($js_common_editor_background_path)));
    
    $js_common_editor_index_path = 'assets/js/common/editor/index.js';
    wp_enqueue_script('js_common_editor_index', get_theme_file_uri($js_common_editor_index_path), 
        array('js_common_editor_background'), filemtime(get_theme_file_path($js_common_editor_index_path)));
    
    $translations = array_merge($translations, get_js_translations('common_editor'));
  }

  if(is_page()) {
    $js_page_path = 'assets/js/page/' . $post->post_name . '.js';
    
    if(file_exists(get_theme_file_path($js_page_path))) {
      wp_enqueue_script('js_page', get_theme_file_uri($js_page_path), array('js_jquery', 'js_jquery_ui'), filemtime(get_theme_file_path($js_page_path)));
      $translations = array_merge($translations, get_js_translations('page_' . $post->post_name));
    }
  } elseif(is_singular('site')) {
    $js_page_path = 'assets/js/single/' . $post->post_type . '.js';
    
    if(file_exists(get_theme_file_path($js_page_path))) {
      wp_enqueue_script('js_page', get_theme_file_uri($js_page_path), array('js_jquery', 'js_jquery_ui'), filemtime(get_theme_file_path($js_page_path)));
      $translations = array_merge($translations, get_js_translations('single_' . $post->post_name));
    }
  }
  
  wp_localize_script('js_jquery', 'translations', $translations);
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );
