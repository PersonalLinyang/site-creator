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
    case 'editor':
      $translations = array(
        'background'              => __('Background', $lang_domain),
        'background_bottom'             => __('Background Bottom', $lang_domain),
        'background_bottom_left'        => __('Background Bottom Left', $lang_domain),
        'background_bottom_right'       => __('Background Bottom Right', $lang_domain),
        'background_center'             => __('Background Center', $lang_domain),
        'background_custom_position'    => __('Background Custom Position', $lang_domain),
        'background_full_size'              => __('Background Full Size', $lang_domain),
        'background_gradient'           => __('Background Gradient', $lang_domain),
        'background_layer'              => __('Background Layer', $lang_domain),
        'background_layer_add'              => __('Add Background Layer', $lang_domain),
        'background_layer_name_ph'      => __('Background Layer Name Placeholder', $lang_domain),
        'background_left'               => __('Background Left', $lang_domain),
        'background_picture'            => __('Background Picture', $lang_domain),
        'background_position'    => __('Background Position', $lang_domain),
        'background_repeat'             => __('Background Repeat', $lang_domain),
        'background_size'    => __('Background Size', $lang_domain),
        'background_solid'              => __('Background Solid', $lang_domain),
        'background_right'              => __('Background Right', $lang_domain),
        'background_top'                => __('Background Top', $lang_domain),
        'background_top_left'           => __('Background Top Left', $lang_domain),
        'background_top_right'          => __('Background Top Right', $lang_domain),
        'background_type_ph'            => __('Background Type Placeholder', $lang_domain),
        'block_add'                  => __('Add Block', $lang_domain),
        'block_name'              => __('Block Name', $lang_domain),
        'block_without_name'              => __('Block Without Name', $lang_domain),
        'color_and_opacity'              => __('Color And Opacity', $lang_domain),
        'direction_bottom'              => __('Direction Bottom', $lang_domain),
        'direction_right'              => __('Direction Right', $lang_domain),
        'file_upload'                   => __('File Upload', $lang_domain),
        'from_bottom'             => __('From Bottom', $lang_domain),
        'from_left'               => __('From Left', $lang_domain),
        'from_right'              => __('From Right', $lang_domain),
        'from_top'                => __('From Top', $lang_domain),
        'gradient_add'                  => __('Add Gradient Color', $lang_domain),
        'gradient_center'               => __('Gradient Center', $lang_domain),
        'gradient_circle'               => __('Gradient Circle', $lang_domain),
        'gradient_conic'                => __('Gradient Conic', $lang_domain),
        'gradient_custom_rotate'        => __('Gradient Custom Rotate', $lang_domain),
        'gradient_ellipse'              => __('Gradient Ellipse', $lang_domain),
        'gradient_linear'               => __('Gradient Linear', $lang_domain),
        'gradient_radial'               => __('Gradient Radial', $lang_domain),
        'gradient_repeat'              => __('Gradient Repeat', $lang_domain),
        'gradient_rotate'               => __('Gradient Rotate', $lang_domain),
        'gradient_size'              => __('Gradient Size', $lang_domain),
        'gradient_to_bottom'            => __('Gradient To Bottom', $lang_domain),
        'gradient_to_right'             => __('Gradient To Right', $lang_domain),
        'gradient_to_top_right'         => __('Gradient To Top Right', $lang_domain),
        'gradient_to_bottom_right'      => __('Gradient To Bottom Right', $lang_domain),
        'has_max' => __('Has Max', $lang_domain),
        'has_min' => __('Has Min', $lang_domain),
        'height'              => __('Height', $lang_domain),
        'height_auto'              => __('Height Auto', $lang_domain),
        'height_content'              => __('Height Content', $lang_domain),
        'height_custom'              => __('Height Custom', $lang_domain),
        'height_relative'              => __('Height Relative', $lang_domain),
        'keep_proportion'    => __('Keep Proportion', $lang_domain),
        'layout'              => __('Layout', $lang_domain),
        'layout_block_list'              => __('Layout Block List', $lang_domain),
        'layout_column'              => __('Layout Column', $lang_domain),
        'layout_content'              => __('Layout Content', $lang_domain),
        'layout_dummy'              => __('Please Add Block', $lang_domain),
        'layout_padding'              => __('Layout Padding', $lang_domain),
        'layout_position'              => __('Layout Position', $lang_domain),
        'layout_position_bottom'              => __('Layout Position Bottom', $lang_domain),
        'layout_position_center'              => __('Layout Position Center', $lang_domain),
        'layout_position_left'              => __('Layout Position Left', $lang_domain),
        'layout_position_middle'              => __('Layout Position Middle', $lang_domain),
        'layout_position_right'              => __('Layout Position Right', $lang_domain),
        'layout_position_stretch_height'              => __('Layout Position Stretch Height', $lang_domain),
        'layout_position_stretch_width'              => __('Layout Position Stretch Width', $lang_domain),
        'layout_position_top'              => __('Layout Position Top', $lang_domain),
        'layout_space'              => __('Layout Space', $lang_domain),
        'layout_space_around_column'              => __('Layout Space Around Column', $lang_domain),
        'layout_space_around_row'              => __('Layout Space Around Row', $lang_domain),
        'layout_space_between_column'              => __('Layout Space Between Column', $lang_domain),
        'layout_space_between_row'              => __('Layout Space Between Row', $lang_domain),
        'layout_space_bottom'              => __('Layout Space Bottom', $lang_domain),
        'layout_space_center'              => __('Layout Space Center', $lang_domain),
        'layout_space_left'              => __('Layout Space Left', $lang_domain),
        'layout_space_middle'              => __('Layout Space Middle', $lang_domain),
        'layout_space_right'              => __('Layout Space Right', $lang_domain),
        'layout_space_top'              => __('Layout Space Top', $lang_domain),
        'layout_row'              => __('Layout Row', $lang_domain),
        'layout_type'              => __('Layout Type', $lang_domain),
        'max'              => __('Max', $lang_domain),
        'min'              => __('Min', $lang_domain),
        'original_size'              => __('Original Size', $lang_domain),
        'position'              => __('Position', $lang_domain),
        'position_absolute'              => __('Position Absolute', $lang_domain),
        'position_bottom'              => __('Position Bottom', $lang_domain),
        'position_center'              => __('Position Center', $lang_domain),
        'position_custom'              => __('Position Custom', $lang_domain),
        'position_fixed'              => __('Position Fixed', $lang_domain),
        'position_horizontal'              => __('Position Horizontal', $lang_domain),
        'position_initial'              => __('Position Initial', $lang_domain),
        'position_left'              => __('Position Left', $lang_domain),
        'position_margin_left'              => __('Position Margin Left', $lang_domain),
        'position_margin_top'              => __('Position Margin Top', $lang_domain),
        'position_relative_height'     => __('Position Relative Height', $lang_domain),
        'position_relative_width'     => __('Position Relative Width', $lang_domain),
        'position_right'              => __('Position Right', $lang_domain),
        'position_self'              => __('Position Self', $lang_domain),
        'position_top'              => __('Position Top', $lang_domain),
        'position_type'              => __('Position Type', $lang_domain),
        'position_vertical'              => __('Position Vertical', $lang_domain),
        'responsive_flag'               => __('Responsive Flag', $lang_domain),
        'responsive_pc'                 => __('Responsive PC', $lang_domain),
        'responsive_sp'                 => __('Responsive SP', $lang_domain),
        'width'              => __('Width', $lang_domain),
        'width_auto'              => __('Width Auto', $lang_domain),
        'width_content'              => __('Width Content', $lang_domain),
        'width_custom'              => __('Width Custom', $lang_domain),
        'width_relative'              => __('Width Relative', $lang_domain),
      );
      break;
    case 'page_create-site':
      $translations = array(
        'page_delete_float'             => __('Site Page Delete Float', $lang_domain),
        'page_name'                     => __('Site Page Name', $lang_domain),
        'page_subplus_float'            => __('Site Page SubPlus Float', $lang_domain),
        'page_title'                    => __('Site Page Title', $lang_domain),
        'type_archive'                  => __('Site Type Archive', $lang_domain),
        'type_archive_url'              => __('Site Type Archive Url', $lang_domain),
        'type_body_title'               => __('Site Type Body Title', $lang_domain),
        'type_body_url'                 => __('Site Type Body URL', $lang_domain),
        'type_day_one'                  => __('Site Type Day One', $lang_domain),
        'type_day_two'                  => __('Site Type Day Two', $lang_domain),
        'type_delete'                   => __('Site Type Delete', $lang_domain),
        'type_month_one'                => __('Site Type Month One', $lang_domain),
        'type_month_two'                => __('Site Type Month Two', $lang_domain),
        'type_name'                     => __('Site Type Name', $lang_domain),
        'type_post_id'                  => __('Site Type Post Id', $lang_domain),
        'type_post_name'                => __('Site Type Post Name', $lang_domain),
        'type_single'                   => __('Site Type Single', $lang_domain),
        'type_single_url'               => __('Site Type Single Url', $lang_domain),
        'type_slug'                     => __('Site Type Slug', $lang_domain),
        'type_tax_delete_float'         => __('Site Type Taxonomy Delete Float', $lang_domain),
        'type_tax_name'                 => __('Site Type Taxonomy Name', $lang_domain),
        'type_tax_plus'                 => __('Site Type Taxonomy Plus', $lang_domain),
        'type_tax_post_list'            => __('Site Type Taxonomy Post List', $lang_domain),
        'type_tax_slug'                 => __('Site Type Taxonomy Slug', $lang_domain),
        'type_tax_url'                  => __('Site Type Taxonomy Url', $lang_domain),
        'type_term_slug'                => __('Site Type Term Slug', $lang_domain),
        'type_year_four'                => __('Site Type Year Four', $lang_domain),
        'type_year_two'                 => __('Site Type Year Two', $lang_domain),
      );
      break;
  }
  
  return $translations;
}


/*
 * Jquery呼び出しと内容翻訳設定
 */
function my_enqueue_scripts() {
  $lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
  $lang_domain = 'site-creator-' . $lang_code;
  
  $post = get_post();
  $translations = array();
  
  wp_enqueue_script('js_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', array(), false);
  wp_enqueue_script('js_jquery_ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array(), false);
  
  $editor_flag = False;
  if(is_page() && get_field('editor_flag', $post->ID)) {
    // 編集権限をチェックする
    require_once get_template_directory() . '/inc/custom-functions/check_site_editor_permission.inc.php';
    $check_result = check_site_editor_permission();
    if($check_result['result']) {
      $editor_flag = True;
    }
  }
  
  if($editor_flag) {
    // 編集可能の場合編集ターゲットを取得
    $target = $check_result['target'];
    
    if($target->post_type == 'site') {
      // 編集ターゲットがサイトの場合初期ブロック情報を構築
      $base_block = array(
        'id' => '', 'key' => 'body', 'name' => __('Site Whole Style', $lang_domain), 'type' => 'body', 'style' => array(),
        'blocks' => array(
          array( 'id' => '', 'key' => 'header', 'name' => __('Header', $lang_domain), 'type' => 'header', 'style' => array(), 'blocks' => array() ),
          array( 'id' => '', 'key' => 'main', 'name' => __('Main Content', $lang_domain), 'type' => 'main', 'style' => array(), 'blocks' => array() ),
          array( 'id' => '', 'key' => 'footer', 'name' => __('Footer', $lang_domain), 'type' => 'footer', 'style' => array(), 'blocks' => array() ),
        ),
      );
    } else {
      // 編集ターゲットがHTMLブロックの場合ブロック情報を取得(再帰処理)
      require_once get_template_directory() . '/inc/custom-functions/get_html_block_info.inc.php';
      $base_block = get_html_block_info($target->ID);
    }
    
    // 基礎ブロックをJS変数化する
    wp_localize_script('js_jquery', 'base_block', $base_block);
    
    // カラーピーカーを読み込み
    $js_colorpicker_path = 'assets/plugins/colorpicker/js/colorpicker.js';
    wp_enqueue_script('js_colorpicker', get_theme_file_uri($js_colorpicker_path), array('js_jquery', 'js_jquery_ui'), filemtime(get_theme_file_path($js_colorpicker_path)));
    
    // 画像アップロードを読み込み
    $js_upload_image_path = 'assets/plugins/upload-image/upload-image.js';
    wp_enqueue_script('js_upload_image', get_theme_file_uri($js_upload_image_path), array('js_jquery', 'js_jquery_ui'), filemtime(get_theme_file_path($js_upload_image_path)));
    
    // 画像アップロード用パラメータをJS変数化
    $upload_param = array(
      'upload_url' => admin_url( 'async-upload.php' ),
      'nonce' => wp_create_nonce( 'media-form' ),
    );
    wp_localize_script( 'js_upload_image', 'upload_param', $upload_param );
    
    // エディター共通処理JSを読み込み
    $js_editor_common_path = 'assets/js/editor/common.js';
    wp_enqueue_script('js_editor_common', get_theme_file_uri($js_editor_common_path), array('js_jquery', 'js_jquery_ui'), filemtime(get_theme_file_path($js_editor_common_path)));
    
    // エディだー背景編集JSを読み込み
    $js_editor_background_path = 'assets/js/editor/background.js';
    wp_enqueue_script('js_editor_background', get_theme_file_uri($js_editor_background_path), array('js_editor_common'), filemtime(get_theme_file_path($js_editor_background_path)));
    
    // エディターレイアウト編集JSを読み込み
    $js_editor_layout_path = 'assets/js/editor/layout.js';
    wp_enqueue_script('js_editor_layout', get_theme_file_uri($js_editor_layout_path), array('js_editor_common'), filemtime(get_theme_file_path($js_editor_layout_path)));
    
    // エディター位置編集JSを読み込み
    $js_editor_position_path = 'assets/js/editor/position.js';
    wp_enqueue_script('js_editor_position', get_theme_file_uri($js_editor_position_path), array('js_editor_common'), filemtime(get_theme_file_path($js_editor_position_path)));
    
    // エディターブロック編集JSを読み込み
    $js_editor_block_path = 'assets/js/editor/block.js';
    wp_enqueue_script('js_editor_block', get_theme_file_uri($js_editor_block_path), array('js_editor_common'), filemtime(get_theme_file_path($js_editor_block_path)));
    
    // エディターレスポンシブ対応編集JSを読み込み
    $js_editor_responsive_path = 'assets/js/editor/responsive.js';
    wp_enqueue_script('js_editor_responsive', get_theme_file_uri($js_editor_responsive_path), array('js_editor_common'), filemtime(get_theme_file_path($js_editor_responsive_path)));
    
    // エディターメイン処理JSを読み込み
    $js_editor_index_path = 'assets/js/editor/index.js';
    wp_enqueue_script('js_editor_index', get_theme_file_uri($js_editor_index_path), array('js_editor_common'), filemtime(get_theme_file_path($js_editor_index_path)));
    
    // エディター用通訳配列をJS変数化
    $translations = array_merge($translations, get_js_translations('editor'));
    
    // 編集時に使える単位リストを取得してJS変数化
    $unit_options = array();
    if(is_user_logged_in()) {
      $user_id = get_current_user_id();
      $relative_unit_options = get_field('relative_unit', 'user_' . $user_id);
      $absolute_unit_options = get_field('absolute_unit', 'user_' . $user_id);
      $unit_options = array_merge($relative_unit_options, $absolute_unit_options);
    }
    wp_localize_script('js_jquery', 'unit_options', $unit_options);
  } else {
    $js_common_common_path = 'assets/js/common/common.js';
    wp_enqueue_script('js_common_common', get_theme_file_uri($js_common_common_path), array('js_jquery', 'js_jquery_ui'), filemtime(get_theme_file_path($js_common_common_path)));
    $translations = array_merge($translations, get_js_translations('common_common'));
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
