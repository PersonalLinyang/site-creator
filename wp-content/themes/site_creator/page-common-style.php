<?php

// 必要関数をロードする
require_once get_template_directory() . '/inc/custom-functions/check_site_editor_permission.inc.php';
require_once get_template_directory() . '/inc/custom-functions/get_html_block_info.inc.php';

get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

// 編集権限をチェックする
$check_result = check_site_editor_permission();

if($check_result['result']) :
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
    $base_block = get_html_block_info($target->ID);
  }
  $design_width_pc = 1200;
  $design_width_sp = 375;
  $design_fontsize_pc = 16;
  $design_fontsize_sp = 12;
  if($check_result['site_id']) {
    $site_id = $check_result['site_id'];
    $design_width_pc = get_field('design_width_pc', $site_id);
    $design_width_sp = get_field('design_width_sp', $site_id);
    $design_fontsize_pc = get_field('design_fontsize_pc', $site_id);
    $design_fontsize_sp = get_field('design_fontsize_sp', $site_id);
  }
?>

<section class="sim sim-pc">
  <div class="sim-inner sim-inner-pc">
    <div class="sim-item sim-html sim-html-pc" id="sim-html-pc" style="--design-width: <?php echo $design_width_pc; ?>; --design-fontsize: <?php echo $design_fontsize_pc; ?>;">
    </div>
  </div>
</section>

<section class="sim sim-sp">
  <div class="sim-inner sim-inner-sp">
    <div class="sim-html sim-html-sp" id="sim-html-sp" style="--design-width: <?php echo $design_width_sp; ?>; --design-fontsize: <?php echo $design_fontsize_sp; ?>;">
    </div>
  </div>
</section>

<section class="setting" data-index="">
  <h2 class="setting-title"><?php echo __('Site Common Style Edit', $lang_domain); ?></h2>
  <form class="form form-style" id="common-style-form">
    <input type="hidden" name="target_id" value="<?php echo $target->ID; ?>" />
    <div class="form-body">
    </div>
  </form>
</section>

<?php 
else: 
  // 編集権限がない場合エラーページを表示
  get_template_part('template-parts/error/' . $check_result['error']); 
endif;

get_footer();
