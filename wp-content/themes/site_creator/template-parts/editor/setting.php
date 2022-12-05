<?php

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

// テンプレートパーツパラメータ変数化
$block = $args['block'];
$parent = $args['parent'];

// ブロック情報のスタイル部分のキーリストを取得
$style_key_list = array_keys($block['style']);

?>

<div class="form-block <?php if(!$parent) { echo 'active'; } ?>" data-target="<?php echo $block['key']; ?>">
  <div class="form-topic">
    <?php if($parent): ?>
    <p class="form-block-slide-handler form-topic-back" data-target="<?php echo $parent; ?>"></p>
    <?php endif; ?>
    <p class="form-topic-text"><?php echo $block['name']; ?></p>
  </div>
  <div class="form-content">
  
    <?php 
    // タイプが特定のタイプ以外にはブロック名の入力欄を構築
    if(!in_array($block['type'], ['body', 'header', 'main', 'footer'])): 
    ?>
    <div class="form-line">
      <p class="form-title"><?php echo __('Block Name', $lang_domain); ?></p>
      <div class="form-input form-blockname">
        <input type="text" class="form-blockname-txtname" name="<?php echo $block['key']; ?>__name" value="<?php echo $block['name']; ?>" />
      </div>
    </div>
    <?php endif; ?>
    
    
    <?php 
    // タイプが特定のタイプ以外にはPC/SPのみ表示のチェックを構築
    if($block['type'] != 'body'): 
    ?>
    <div class="form-responsive-target form-content-main">
      <div class="form-responsive form-block-responsive">
        <div class="form-responsive-controller">
          <p class="form-checkbox form-responsive-checkbox form-responsive-chkdevice center setting-pc active">
            <input type="checkbox" name="<?php echo $block['key']; ?>__pc_only" class="form-responsive-chkdevice-check chkdevice-check-pc" />
            <?php echo __('Responsive PC', $lang_domain); ?>
          </p>
          <p class="form-checkbox form-responsive-checkbox form-responsive-chkdevice center setting-sp">
            <input type="checkbox" name="<?php echo $block['key']; ?>__sp_only" class="form-responsive-chkdevice-check chkdevice-check-sp" />
            <?php echo __('Responsive SP', $lang_domain); ?>
          </p>
        </div>
        <div class="form-responsive-area">
    <?php endif; ?>
    
    
    <div class="form-line">
      <p class="form-title"><?php echo __('Layout', $lang_domain); ?></p>
      <div class="form-input form-layout">
        <?php if($block['type'] != 'body'): ?>
        <p class="form-layout-type">
          <select class="form-layout-seltype" name="<?php echo $block['key']; ?>__style__layout__type">
            <option value="l"><?php echo __('Line Layout', $lang_domain); ?></option>
            <option value="r"><?php echo __('Row Layout', $lang_domain); ?></option>
          </select>
        </p>
        <p class="form-layout-btnadd"><?php echo __('Add Block', $lang_domain); ?></p>
        <?php endif; ?>
        <div class="form-layout-sim">
          <?php foreach($block['blocks'] as $child_block): ?>
          <div class="form-layout-sim-item form-block-slide" data-target="<?php echo $child_block['key']; ?>">
            <?php if(!in_array($child_block['type'], ['body', 'header', 'main', 'footer'])): ?>
            <p class="form-layout-sim-item-btnsort"></p>
            <?php endif; ?>
            <p class="form-block-slide-handler form-layout-sim-item-btnedit" data-target="<?php echo $child_block['key']; ?>"></p>
            <?php if(!in_array($child_block['type'], ['body', 'header', 'main', 'footer'])): ?>
            <p class="form-layout-sim-item-btndelete"></p>
            <?php endif; ?>
            <p class="form-layout-sim-item-text" title="<?php echo $child_block['name']; ?>"><?php echo $child_block['name']; ?></p>
            <input class="form-layout-sim-item-index" type="hidden" name="" value="<?php echo $child_block['key']; ?>" />
          </div>
          <?php endforeach; ?>
          <p class="form-layout-sim-dummy <?php if(count($block['blocks']) == 0) { echo 'active'; } ?>">
            <?php echo __('Please Add Block', $lang_domain)?>
          </p>
        </div>
      </div>
    </div>
    
    
    <?php 
    // 背景編集エリアを構築
    $data_background = array();
    if(in_array('background', $style_key_list)) {
      $data_background = $block['style']['background'];
    }
    get_template_part('template-parts/editor/background/base', null, array('data' => $data_background, 'key' => $block['key']));
    ?>
    
    
    <?php 
    // タイプが特定のタイプ以外にはPC/SPのみ表示のチェックを構築（終了部分）
    if($block['type'] != 'body'): 
    ?>
        </div>
      </div>
    </div>
    <?php endif; ?>
    
  </div>
  <input type="hidden" name="<?php echo $block['key']; ?>__block_id" value="<?php echo $block['id']; ?>" />
</div>

<?php 
// 子ブロックの編集エリアを構築（再帰処理）
foreach($block['blocks'] as $child_block) {
  get_template_part('template-parts/editor/setting', null, array('block' => $child_block, 'parent' => $block['key'])); 
} 
?>