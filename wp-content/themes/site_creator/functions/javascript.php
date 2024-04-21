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
  require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

  $lang = new LanguageSupporter();
  $translations = array();
  
  switch($key) {
    case 'common_common':
      $translations = array(
        'system_error'                  => $lang->translate('System Error'),
      );
      break;
    case 'editor':
      $translations = array(
        'add'                  => $lang->translate('Add'),
        'background'              => $lang->translate('Background'),
        'background_bottom'             => $lang->translate('Background Bottom'),
        'background_bottom_left'        => $lang->translate('Background Bottom Left'),
        'background_bottom_right'       => $lang->translate('Background Bottom Right'),
        'background_center'             => $lang->translate('Background Center'),
        'background_custom_position'    => $lang->translate('Background Custom Position'),
        'background_full_size'              => $lang->translate('Background Full Size'),
        'background_gradient'           => $lang->translate('Background Gradient'),
        'background_layer'              => $lang->translate('Background Layer'),
        'background_layer_add'              => $lang->translate('Add Background Layer'),
        'background_layer_name_ph'      => $lang->translate('Background Layer Name Placeholder'),
        'background_left'               => $lang->translate('Background Left'),
        'background_picture'            => $lang->translate('Background Picture'),
        'background_position'    => $lang->translate('Background Position'),
        'background_repeat'             => $lang->translate('Background Repeat'),
        'background_size'    => $lang->translate('Background Size'),
        'background_solid'              => $lang->translate('Background Solid'),
        'background_right'              => $lang->translate('Background Right'),
        'background_top'                => $lang->translate('Background Top'),
        'background_top_left'           => $lang->translate('Background Top Left'),
        'background_top_right'          => $lang->translate('Background Top Right'),
        'background_type_ph'            => $lang->translate('Background Type Placeholder'),
        'block'                  => $lang->translate('Block'),
        'block_name'              => $lang->translate('Block Name'),
        'block_type_ph'                => $lang->translate('Block Type Placeholder'),
        'block_without_name'              => $lang->translate('Block Without Name'),
        'body'                  => $lang->translate('Body'),
        'button'                  => $lang->translate('Button'),
        'color_and_opacity'              => $lang->translate('Color And Opacity'),
        'direction_bottom'              => $lang->translate('Direction Bottom'),
        'direction_right'              => $lang->translate('Direction Right'),
        'file_upload'                   => $lang->translate('File Upload'),
        'footer'                  => $lang->translate('Footer'),
        'form'                  => $lang->translate('Form'),
        'from_bottom'             => $lang->translate('From Bottom'),
        'from_left'               => $lang->translate('From Left'),
        'from_right'              => $lang->translate('From Right'),
        'from_top'                => $lang->translate('From Top'),
        'gradient_add'                  => $lang->translate('Add Gradient Color'),
        'gradient_center'               => $lang->translate('Gradient Center'),
        'gradient_circle'               => $lang->translate('Gradient Circle'),
        'gradient_conic'                => $lang->translate('Gradient Conic'),
        'gradient_custom_rotate'        => $lang->translate('Gradient Custom Rotate'),
        'gradient_ellipse'              => $lang->translate('Gradient Ellipse'),
        'gradient_linear'               => $lang->translate('Gradient Linear'),
        'gradient_radial'               => $lang->translate('Gradient Radial'),
        'gradient_repeat'              => $lang->translate('Gradient Repeat'),
        'gradient_rotate'               => $lang->translate('Gradient Rotate'),
        'gradient_size'              => $lang->translate('Gradient Size'),
        'gradient_to_bottom'            => $lang->translate('Gradient To Bottom'),
        'gradient_to_right'             => $lang->translate('Gradient To Right'),
        'gradient_to_top_right'         => $lang->translate('Gradient To Top Right'),
        'gradient_to_bottom_right'      => $lang->translate('Gradient To Bottom Right'),
        'has_max' => $lang->translate('Has Max'),
        'has_min' => $lang->translate('Has Min'),
        'header'                  => $lang->translate('Header'),
        'headline'                  => $lang->translate('Headline'),
        'height'              => $lang->translate('Height'),
        'height_auto'              => $lang->translate('Height Auto'),
        'height_content'              => $lang->translate('Height Content'),
        'height_custom'              => $lang->translate('Height Custom'),
        'height_relative'              => $lang->translate('Height Relative'),
        'image'                  => $lang->translate('Image'),
        'keep_proportion'    => $lang->translate('Keep Proportion'),
        'layout'              => $lang->translate('Layout'),
        'layout_block_list'              => $lang->translate('Layout Block List'),
        'layout_column'              => $lang->translate('Layout Column'),
        'layout_content'              => $lang->translate('Layout Content'),
        'layout_dummy'              => $lang->translate('Please Add Block'),
        'layout_padding'              => $lang->translate('Layout Padding'),
        'layout_position'              => $lang->translate('Layout Position'),
        'layout_position_bottom'              => $lang->translate('Layout Position Bottom'),
        'layout_position_center'              => $lang->translate('Layout Position Center'),
        'layout_position_left'              => $lang->translate('Layout Position Left'),
        'layout_position_middle'              => $lang->translate('Layout Position Middle'),
        'layout_position_right'              => $lang->translate('Layout Position Right'),
        'layout_position_stretch_height'              => $lang->translate('Layout Position Stretch Height'),
        'layout_position_stretch_width'              => $lang->translate('Layout Position Stretch Width'),
        'layout_position_top'              => $lang->translate('Layout Position Top'),
        'layout_space'              => $lang->translate('Layout Space'),
        'layout_space_around_column'              => $lang->translate('Layout Space Around Column'),
        'layout_space_around_row'              => $lang->translate('Layout Space Around Row'),
        'layout_space_between_column'              => $lang->translate('Layout Space Between Column'),
        'layout_space_between_row'              => $lang->translate('Layout Space Between Row'),
        'layout_space_bottom'              => $lang->translate('Layout Space Bottom'),
        'layout_space_center'              => $lang->translate('Layout Space Center'),
        'layout_space_left'              => $lang->translate('Layout Space Left'),
        'layout_space_middle'              => $lang->translate('Layout Space Middle'),
        'layout_space_right'              => $lang->translate('Layout Space Right'),
        'layout_space_top'              => $lang->translate('Layout Space Top'),
        'layout_row'              => $lang->translate('Layout Row'),
        'layout_type'              => $lang->translate('Layout Type'),
        'link'                  => $lang->translate('Link'),
        'list'                  => $lang->translate('List'),
        'main'                  => $lang->translate('Main'),
        'max'              => $lang->translate('Max'),
        'min'              => $lang->translate('Min'),
        'original_size'              => $lang->translate('Original Size'),
        'position'              => $lang->translate('Position'),
        'position_absolute'              => $lang->translate('Position Absolute'),
        'position_bottom'              => $lang->translate('Position Bottom'),
        'position_center'              => $lang->translate('Position Center'),
        'position_custom'              => $lang->translate('Position Custom'),
        'position_fixed'              => $lang->translate('Position Fixed'),
        'position_horizontal'              => $lang->translate('Position Horizontal'),
        'position_initial'              => $lang->translate('Position Initial'),
        'position_left'              => $lang->translate('Position Left'),
        'position_margin'              => $lang->translate('Position Margin'),
        'position_relative_height'     => $lang->translate('Position Relative Height'),
        'position_relative_width'     => $lang->translate('Position Relative Width'),
        'position_right'              => $lang->translate('Position Right'),
        'position_self'              => $lang->translate('Position Self'),
        'position_top'              => $lang->translate('Position Top'),
        'position_type'              => $lang->translate('Position Type'),
        'position_vertical'              => $lang->translate('Position Vertical'),
        'responsive_flag'               => $lang->translate('Responsive Flag'),
        'responsive_pc'                 => $lang->translate('Responsive PC'),
        'responsive_sp'                 => $lang->translate('Responsive SP'),
        'table'                  => $lang->translate('Table'),
        'text'                  => $lang->translate('Text'),
        'video'                  => $lang->translate('Video'),
        'width'              => $lang->translate('Width'),
        'width_auto'              => $lang->translate('Width Auto'),
        'width_content'              => $lang->translate('Width Content'),
        'width_custom'              => $lang->translate('Width Custom'),
        'width_relative'              => $lang->translate('Width Relative'),
      );
      break;
    case 'page_create-site':
      $translations = array(
        'page_delete_float'             => $lang->translate('Site Page Delete Float'),
        'page_name'                     => $lang->translate('Site Page Name'),
        'page_subplus_float'            => $lang->translate('Site Page SubPlus Float'),
        'page_title'                    => $lang->translate('Site Page Title'),
        'type_archive'                  => $lang->translate('Site Type Archive'),
        'type_archive_url'              => $lang->translate('Site Type Archive Url'),
        'type_body_title'               => $lang->translate('Site Type Body Title'),
        'type_body_url'                 => $lang->translate('Site Type Body URL'),
        'type_day_one'                  => $lang->translate('Site Type Day One'),
        'type_day_two'                  => $lang->translate('Site Type Day Two'),
        'type_delete'                   => $lang->translate('Site Type Delete'),
        'type_month_one'                => $lang->translate('Site Type Month One'),
        'type_month_two'                => $lang->translate('Site Type Month Two'),
        'type_name'                     => $lang->translate('Site Type Name'),
        'type_post_id'                  => $lang->translate('Site Type Post Id'),
        'type_post_name'                => $lang->translate('Site Type Post Name'),
        'type_single'                   => $lang->translate('Site Type Single'),
        'type_single_url'               => $lang->translate('Site Type Single Url'),
        'type_slug'                     => $lang->translate('Site Type Slug'),
        'type_tax_delete_float'         => $lang->translate('Site Type Taxonomy Delete Float'),
        'type_tax_name'                 => $lang->translate('Site Type Taxonomy Name'),
        'type_tax_plus'                 => $lang->translate('Site Type Taxonomy Plus'),
        'type_tax_post_list'            => $lang->translate('Site Type Taxonomy Post List'),
        'type_tax_slug'                 => $lang->translate('Site Type Taxonomy Slug'),
        'type_tax_url'                  => $lang->translate('Site Type Taxonomy Url'),
        'type_term_slug'                => $lang->translate('Site Type Term Slug'),
        'type_year_four'                => $lang->translate('Site Type Year Four'),
        'type_year_two'                 => $lang->translate('Site Type Year Two'),
      );
      break;
  }
  
  return $translations;
}


/*
 * Jquery呼び出しと内容翻訳設定
 */
function my_enqueue_scripts() {
  require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

  $lang = new LanguageSupporter();
  
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
        'id' => '', 'key' => 'body', 'name' => $lang->translate('Site Whole Style'), 'type' => 'body', 'style' => array(),
        'blocks' => array(
          array( 'id' => '', 'key' => 'header', 'name' => $lang->translate('Header'), 'type' => 'header', 'style' => array(), 'blocks' => array() ),
          array( 'id' => '', 'key' => 'main', 'name' => $lang->translate('Main Content'), 'type' => 'main', 'style' => array(), 'blocks' => array() ),
          array( 'id' => '', 'key' => 'footer', 'name' => $lang->translate('Footer'), 'type' => 'footer', 'style' => array(), 'blocks' => array() ),
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
    
    // エディターブロック編集JSを読み込み
    $js_editor_simulation_path = 'assets/js/editor/simulation.js';
    wp_enqueue_script('js_editor_simulation', get_theme_file_uri($js_editor_simulation_path), array('js_editor_common'), filemtime(get_theme_file_path($js_editor_simulation_path)));
    
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
