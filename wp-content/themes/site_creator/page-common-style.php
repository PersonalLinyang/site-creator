<?php

require_once get_template_directory() . '/inc/custom-functions/check_site_editor_permission.inc.php';

get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

$check_result = check_site_editor_permission();

if($check_result['result']) :
  $site = $check_result['site'];
?>

<section class="sim sim-pc">
  <div class="sim-inner sim-inner-pc">
    <div class="sim-item sim-html sim-html-pc" id="sim-html-pc">
      <div class="sim-header" id="sim-html-pc">
      </div>
      <div class="sim-main" id="sim-main">
        <div class="sim-block" id="sim-block">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
      </div>
      <div class="sim-footer" id="sim-footer">
      </div>
    </div>
  </div>
</section>

<section class="sim sim-sp">
  <div class="sim-inner sim-inner-sp">
    <div class="sim-item sim-html sim-html-sp" id="sim-html-sp">
      <div class="test_box" id="test_box" style="width: 80px; height: 50px; background: #0a0; position: absolute;">
      </div>
      <div id="test_box2" style="width: 300px; height: 200px; background: #a00; position: absolute;"></div>
    </div>
  </div>
</section>

<section class="setting">
  <h2 class="setting-title"><?php echo __('Site Common Style Edit', $lang_domain); ?></h2>
  
  <form class="form" id="common-style-form">
    <input type="hidden" name="site_uid" value="<?php echo $site->post_name; ?>" />
    
    <div class="form-body">
      <div class="form-block" data-target="html">
        <div class="form-topic">
          <p class="form-topic-text"><?php echo __('Site Whole Style', $lang_domain); ?></p>
        </div>
        <div class="form-content">
          <div class="form-line">
            <p class="form-title"><?php echo __('Background', $lang_domain); ?></p>
            <div class="form-input form-background" data-lastid="0">
              <p class="form-background-btninsert"><?php echo __('Add Background Layer', $lang_domain); ?></p>
              <div class="form-background-layerlist"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>

<?php else: ?>
  <?php get_template_part('template-parts/error/' . $check_result['error']); ?>
<?php 
endif;
get_footer();
