<?php

require_once get_template_directory() . '/inc/custom-functions/get_acf_select_options.inc.php';
require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';


get_header();

$lang = new LanguageSupporter();

$site_status_options = get_acf_select_options('site', 'site_status');
$site_http_options = get_acf_select_options('site', 'site_http');

$post_status = get_field('site_status', $post->ID);
$post_http = get_field('site_http', $post->ID);

$common_style_list = get_field('common_style', $post->ID);
if(!is_array($common_style_list)) {
  $common_style_list = array();
}

?>

<section class="single-site">
  <div class="single-site-header">
    <p class="single-site-header-status status-<?php echo $post_status; ?>"><?php echo $site_status_options[$post_status]; ?></p>
  </div>
  <h2><?php echo $post->post_title; ?></h2>
  <div class="single-site-info">
    <div class="single-site-info-header">
      <p class="single-site-info-header-title"><?php echo $lang->translate('Site Base Info'); ?></p>
      <div class="single-site-info-header-btnarea">
        <p class="single-site-info-header-button" id="btn-base-edit"><?php echo $lang->translate('Site Base Edit'); ?></p>
        <p class="single-site-info-header-button" id="btn-base-save"><?php echo $lang->translate('Save'); ?></p>
      </div>
    </div>
    <div class="single-site-line">
      <p class="single-site-line-title"><?php echo $lang->translate('Site Name'); ?></p>
      <p class="single-site-line-value"><?php echo $post->post_title; ?></p>
    </div>
    <div class="single-site-line">
      <p class="single-site-line-title"><?php echo $lang->translate('Site Key'); ?></p>
      <p class="single-site-line-value"><?php echo get_field('site_key', $post->ID); ?></p>
    </div>
    <div class="single-site-line">
      <p class="single-site-line-title"><?php echo $lang->translate('Site Host'); ?></p>
      <p class="single-site-line-value"><?php echo $site_http_options[$post_http]; ?><?php echo get_field('site_host', $post->ID); ?></p>
    </div>
  </div>
  <div class="single-site-info">
    <div class="single-site-info-header">
      <p class="single-site-info-header-title"><?php echo $lang->translate('Site Common Style'); ?></p>
      <div class="single-site-info-header-btnarea">
        <p class="single-site-info-header-button">
          <a class="full-link" href="<?php echo get_site_url(); ?>/common-style/<?php echo $post->post_name; ?>/">
            <?php echo $lang->translate('Site Common Style Edit'); ?>
          </a>
        </p>
      </div>
    </div>
    <?php foreach($common_style_list as $common_style): ?>
    <div class="single-site-line">
      <p class="single-site-name"><?php echo $common_style->post_title; ?></p>
      <p class="single-site-btnedit">
        <a class="full-link" href="<?php echo get_site_url(); ?>/common-style/<?php echo $post->post_name; ?>/<?php echo $common_style->post_name; ?>/">
          <?php echo $lang->translate('Edit'); ?>
        </a>
      </p>
      <p class="single-site-btndelete"><?php echo $lang->translate('Delete'); ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>






















<section>
  <input type="hidden" id="site-uid" value="<?php echo $post->post_name; ?>"  />
  <p class="button button-download-theme">Download</p>
</section>

<?php
get_footer();