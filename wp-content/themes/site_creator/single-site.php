<?php

require_once get_template_directory() . '/inc/custom-functions/get_acf_select_options.inc.php';

get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

$site_status_options = get_acf_select_options('site', 'site_status');
$site_http_options = get_acf_select_options('site', 'site_http');

$post_status = get_field('site_status', $post->ID);
$post_http = get_field('site_http', $post->ID);

?>

<section class="single-site">
  <div class="single-site-header">
    <p class="single-site-header-status status-<?php echo $post_status; ?>"><?php echo $site_status_options[$post_status]; ?></p>
  </div>
  <h2><?php echo $post->post_title; ?></h2>
  <div class="single-site-info">
    <div class="single-site-info-header">
      <p class="single-site-info-header-title"><?php echo __('Site Base Info', $lang_domain); ?></p>
      <div class="single-site-info-header-btnarea">
        <p class="single-site-info-header-button" id="btn-base-edit"><?php echo __('Site Base Edit', $lang_domain); ?></p>
        <p class="single-site-info-header-button" id="btn-base-save"><?php echo __('Save', $lang_domain); ?></p>
      </div>
    </div>
    <div class="single-site-line">
      <p class="single-site-line-title"><?php echo __('Site Name', $lang_domain); ?></p>
      <p class="single-site-line-value"><?php echo $post->post_title; ?></p>
    </div>
    <div class="single-site-line">
      <p class="single-site-line-title"><?php echo __('Site Key', $lang_domain); ?></p>
      <p class="single-site-line-value"><?php echo get_field('site_key', $post->ID); ?></p>
    </div>
    <div class="single-site-line">
      <p class="single-site-line-title"><?php echo __('Site Host', $lang_domain); ?></p>
      <p class="single-site-line-value"><?php echo $site_http_options[$post_http]; ?><?php echo get_field('site_host', $post->ID); ?></p>
    </div>
  </div>
  <div class="single-site-info">
    <div class="single-site-info-header">
      <p class="single-site-info-header-title"><?php echo __('Site Common Style', $lang_domain); ?></p>
      <div class="single-site-info-header-btnarea">
        <p class="single-site-info-header-button">
          <a class="full-link" href="<?php echo get_site_url(); ?>/common-style/<?php echo $post->post_name; ?>/">
            <?php echo __('Site Common Style Edit', $lang_domain); ?>
          </a>
        </p>
      </div>
    </div>
  </div>
</section>






















<section>
  <input type="hidden" id="site-uid" value="<?php echo $post->post_name; ?>"  />
  <p class="button button-download-theme">Download</p>
</section>

<?php
get_footer();