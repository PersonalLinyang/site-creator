<?php

get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

?>

<section>
  <div class="creator-inner">
    <h2><?php echo __('Create Site Title', $lang_domain); ?></h2>
    <p class="attention"><?php echo __('Create Site Attention', $lang_domain); ?></p>
    <form class="form" id="creator-form">
      <div class="form-line">
        <p class="form-title"><?php echo __('Site Name', $lang_domain); ?><span class="required">*</span></p>
        <div class="form-input">
          <input type="text" name="site_name" placeholder="<?php echo __('Site Name', $lang_domain); ?>" />
          <p class="warning warning-site_name"></p>
        </div>
      </div>
      <div class="form-line">
        <p class="form-title"><?php echo __('Site Host', $lang_domain); ?><span class="required">*</span></p>
        <div class="form-input creator-host">
          <select name="site_http" id="sel-site-http">
            <option value="1">https</option>
            <option value="0">http</option>
          </select>
          <input type="text" name="site_host" id="txt-site-host" placeholder="<?php echo __('Site Host', $lang_domain); ?>" />
          <p class="warning warning-site_host"></p>
        </div>
      </div>
    </form>
    <div class="creator-btnarea">
      <p class="button creator-submit"><?php echo __('Create Site Submit', $lang_domain); ?></p>
    </div>
    <p class="warning warning-system"></p>
  </div>
</section>

<?php
get_footer();
