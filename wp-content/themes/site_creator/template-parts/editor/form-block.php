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

<div class="form-block <?php if($block_type == 'body'){ echo 'active'; } ?>" data-target="<?php echo $block_target; ?>">
  <div class="form-topic">
    <?php if($block_type != 'body'): ?>
    <p class="form-block-slidehandler form-topic-back" data-target="<?php echo $block_parent; ?>"></p>
    <?php endif; ?>
    <p class="form-topic-text"><?php echo $topic_text; ?></p>
  </div>
  <div class="form-content">
    
    <!-- ヘッダータイプ -->
    <?php if(in_array($block_type, ['header'])) : ?>
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
    
    <!-- 全体レイアウト -->
    <?php if(in_array($block_type, ['body'])) : ?>
    <div class="form-line">
      <p class="form-title"><?php echo __('Layout', $lang_domain); ?></p>
      <div class="form-input form-layout">
        <p class="form-layout-header">
          <select class="form-layout-selheader" name="<?php echo $block_key; ?>__style__layout__header">
            <option value="all"><?php echo __('Use Common Header ALL', $lang_domain); ?></p>
            <option value="pc"><?php echo __('Use Common Header PC', $lang_domain); ?></p>
            <option value="sp"><?php echo __('Use Common Header SP', $lang_domain); ?></p>
            <option value="none"><?php echo __('Use Common Header None', $lang_domain); ?></p>
          </select>
        </p>
        <div class="form-layout-sim">
          <p class="form-block-slidehandler form-layout-sim-item" data-target="header"><?php echo __('Header', $lang_domain); ?></p>
          <p class="form-block-slidehandler form-layout-sim-item" data-target="main"><?php echo __('Main Content', $lang_domain); ?></p>
          <p class="form-block-slidehandler form-layout-sim-item" data-target="footer"><?php echo __('Footer', $lang_domain); ?></p>
        </div>
        <p class="form-layout-footer">
          <select class="form-layout-selfooter" name="<?php echo $block_key; ?>__style__layout__footer">
            <option value="all"><?php echo __('Use Common Footer ALL', $lang_domain); ?></p>
            <option value="pc"><?php echo __('Use Common Footer PC', $lang_domain); ?></p>
            <option value="sp"><?php echo __('Use Common Footer SP', $lang_domain); ?></p>
            <option value="none"><?php echo __('Use Common Footer None', $lang_domain); ?></p>
          </select>
        </p>
      </div>
    </div>
    <?php endif; ?>
    
    <!-- 背景 -->
    <div class="form-line">
      <p class="form-title"><?php echo __('Background', $lang_domain); ?></p>
      <div class="form-input form-background" data-lastid="0">
        <p class="form-background-btninsert"><?php echo __('Add Background Layer', $lang_domain); ?></p>
        <div class="form-background-layerlist"></div>
      </div>
    </div>
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