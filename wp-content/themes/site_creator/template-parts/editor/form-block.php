<?php

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

$block_id = $args['block_id'];
$block_type = $args['block_type'];
$block_parent = $args['block_parent'];
$block_key = '';

$block = get_post($block_id);

if($block_id) {
  $block = get_post($block_id);
  $topic_text = $block->post_title;
} else {
  switch($block_type) {
    case 'body':
      $topic_text = __('Site Whole Style', $lang_domain);
      break;
    case 'header':
      $topic_text = __('Header', $lang_domain);
      break;
    case 'main':
      $topic_text = __('Main Content', $lang_domain);
      break;
    case 'footer':
      $topic_text = __('Footer', $lang_domain);
      break;
    default:
      $topic_text = '';
      break;
  }
}

switch($block_type) {
  case 'body':
  case 'header':
  case 'main':
  case 'footer':
    $block_target = $block_type;
    $block_key = $block_type;
    break;
  default:
    $block_target = '';
    break;
}

?>

<div class="form-block <?php if($block_type == 'header'){ echo 'active'; } ?>" data-target="<?php echo $block_target; ?>">
  <div class="form-topic">
    <?php if($block_type != 'body'): ?>
    <p class="form-block-slidehandler form-topic-back" data-target="<?php echo $block_parent; ?>"></p>
    <?php endif; ?>
    <p class="form-topic-text"><?php echo $topic_text; ?></p>
  </div>
  <div class="form-content">
    <?php if($block_type !='body'): ?>
    <div class="form-responsive-target">
      <div class="form-responsive">
        <div class="form-responsive-controller">
          <p class="form-checkbox form-responsive-checkbox form-responsive-chkdevice setting-pc active">
            <input type="checkbox" name="<?php echo $block_key; ?>__pc_only" class="form-responsive-chkdevice-check chkdevice-check-pc" />
            <?php echo __('Responsive PC', $lang_domain); ?>
          </p>
          <p class="form-checkbox form-responsive-checkbox form-responsive-chkdevice setting-sp">
            <input type="checkbox" name="<?php echo $block_key; ?>__sp_only" class="form-responsive-chkdevice-check chkdevice-check-sp" />
            <?php echo __('Responsive SP', $lang_domain); ?>
          </p>
        </div>
        <div class="form-responsive-area">
    <?php endif; ?>
    
    <?php 
    // ヘッダーレイアウト
    if(in_array($block_type, ['header'])): 
    ?>
    <div class="form-line">
      <p class="form-title"><?php echo __('Layout', $lang_domain); ?></p>
      <div class="form-input form-layout">
        <p class="form-layout-type">
          <select class="form-layout-seltype" name="<?php echo $block_key; ?>__style__layout__type">
            <option value="l"><?php echo __('Line Layout', $lang_domain); ?></option>
            <option value="r"><?php echo __('Row Layout', $lang_domain); ?></option>
          </select>
        </p>
        <p class="form-layout-btnadd"><?php echo __('Add Block', $lang_domain); ?></p>
        <div class="form-layout-sim">
          <p class="form-layout-sim-dummy"><?php echo __('Please Add Block', $lang_domain); ?></p>
        </div>
      </div>
    </div>
    <?php endif; ?>
    
    <?php if($block_type !='body'): ?>
        </div>
      </div>
    </div>
    <?php endif; ?>
    
    <?php 
    // 全体レイアウト
    if(in_array($block_type, ['body'])) : 
    ?>
    <div class="form-line">
      <p class="form-title"><?php echo __('Layout', $lang_domain); ?></p>
      <div class="form-input form-layout">
        <div class="form-layout-sim">
          <p class="form-block-slidehandler form-layout-sim-item" data-target="header"><?php echo __('Header', $lang_domain); ?></p>
          <p class="form-block-slidehandler form-layout-sim-item" data-target="main"><?php echo __('Main Content', $lang_domain); ?></p>
          <p class="form-block-slidehandler form-layout-sim-item" data-target="footer"><?php echo __('Footer', $lang_domain); ?></p>
        </div>
      </div>
    </div>
    <?php endif; ?>
    
    <?php 
    // ヘッダータイプ
    if(in_array($block_type, ['header'])) : 
    ?>
    <div class="form-line">
      <p class="form-title"><?php echo __('Header Position', $lang_domain); ?></p>
      <div class="form-input form-position setting-pc active">
        <p class="form-input-title"><?php echo __('Header Position Type', $lang_domain); ?></p>
        <p class="form-position-type-header">
          <select class="form-position-seltype-header-pc" name="<?php echo $block_key; ?>__style__position__pc__type">
            <option value="following"><?php echo __('Following Header', $lang_domain); ?></option>
            <option value="non_following"><?php echo __('Non-Following Header', $lang_domain); ?></option>
            <option value="scroll"><?php echo __('Following By Scrolling Header', $lang_domain); ?></option>
          </select>
        </p>
      </div>
      <div class="form-input form-position setting-sp">
        <p class="form-input-title"><?php echo __('Header Position Type', $lang_domain); ?></p>
        <p class="form-position-type-header">
          <select class="form-position-seltype-header-sp" name="<?php echo $block_key; ?>__style__position__sp__type">
            <option value="following"><?php echo __('Following Header', $lang_domain); ?></option>
            <option value="non_following"><?php echo __('Non-Following Header', $lang_domain); ?></option>
            <option value="scroll"><?php echo __('Following By Scrolling Header', $lang_domain); ?></option>
          </select>
        </p>
      </div>
    </div>
    <?php endif; ?>
    
    <?php 
    // 背景
    if(in_array($block_type, ['header'])) : 
    ?>
    <div class="form-line">
      <p class="form-title"><?php echo __('Background', $lang_domain); ?></p>
      <div class="form-input form-background" data-lastid="0">
        <p class="form-background-btninsert"><?php echo __('Add Background Layer', $lang_domain); ?></p>
        <div class="form-background-layerlist"></div>
      </div>
    </div>
    <?php endif; ?>

  </div>
  <input type="hidden" name="<?php echo $block_key; ?>__block_id" value="<?php echo $block_id; ?>" />
  <?php if($block_parent): ?>
  <input type="hidden" name="<?php echo $block_key; ?>__block_parent" value="<?php echo $block_parent; ?>" />
  <?php endif; ?>
</div>
<?php if(in_array($block_type, ['body'])) : ?>
<?php get_template_part('template-parts/editor/form-block', null, array('block_id' => '', 'block_type' => 'header', 'block_parent' => $block_target)); ?>
<?php get_template_part('template-parts/editor/form-block', null, array('block_id' => '', 'block_type' => 'main', 'block_parent' => $block_target)); ?>
<?php get_template_part('template-parts/editor/form-block', null, array('block_id' => '', 'block_type' => 'footer', 'block_parent' => $block_target)); ?>
<?php endif; ?>