<?php

get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

require_once get_template_directory() . '/inc/custom-functions/get_acf_select_options.inc.php';

$site_http_options = get_acf_select_options('site', 'site_http');

?>

<div class="create-slider" data-index="0">
  <div class="create-slider-inner">
    
    <section class="create-section" id="create-section-0">
      <div class="create-section-inner">
        <h2><?php echo __('Create Site Title', $lang_domain); ?></h2>
        <p class="attention"><?php echo __('Create Site Attention', $lang_domain); ?></p>
        <form class="form" id="create-base-form">
          <div class="form-line">
            <p class="form-title"><?php echo __('Site Name', $lang_domain); ?><span class="required">*</span></p>
            <div class="form-input">
              <input type="text" name="site_name" placeholder="<?php echo __('Site Name', $lang_domain); ?>" />
              <p class="warning warning-site_name"></p>
            </div>
          </div>
          <div class="form-line">
            <p class="form-title"><?php echo __('Site Key', $lang_domain); ?><span class="required">*</span></p>
            <div class="form-input">
              <input type="text" name="site_key" placeholder="<?php echo __('Site Key', $lang_domain); ?>" />
              <p class="warning warning-site_key"></p>
              <p class="attention create-attention"><?php echo __('This key will be used as the name of the theme', $lang_domain); ?></p>
            </div>
          </div>
          <div class="form-line">
            <p class="form-title"><?php echo __('Site Host', $lang_domain); ?><span class="required">*</span></p>
            <div class="form-input create-host">
              <select name="site_http" id="sel-site-http">
                <?php foreach($site_http_options as $http_key => $http_value): ?>
                <option value="<?php echo $http_key; ?>"><?php echo $http_value; ?></option>
                <?php endforeach; ?>
              </select>
              <input type="text" name="site_host" id="txt-site-host" placeholder="<?php echo __('Site Host', $lang_domain); ?>" />
              <p class="warning warning-site_host"></p>
            </div>
          </div>
        </form>
        <div class="create-btnarea">
          <p class="button create-button create-next" id="create-base-submit"><?php echo __('Next Step', $lang_domain); ?></p>
        </div>
        <p class="warning warning-system_base"></p>
      </div>
    </section>
    
    <section class="create-section" id="create-section-1">
      <div class="create-section-inner">
        <h2><?php echo __( 'Create Site Page', $lang_domain ); ?></h2>
        <p class="attention"><?php echo __('What is Site Page', $lang_domain); ?></p>
        <form class="form create-form" id="create-page-form">
          <div class="create-page-line base-line header-line">
            <p class="form-input create-page-title"><?php echo __('Site Page Title', $lang_domain); ?></p>
            <p class="form-input create-page-url"><?php echo __('Site Page URL', $lang_domain); ?></p>
          </div>
          <div class="create-page-line base-line" data-index="0" data-level="0">
            <div class="form-input create-page-title"><?php echo __('Site Front Page', $lang_domain); ?></div>
            <div class="form-input create-page-url">
              <span class="auto-site_http">https://</span><span class="auto-site_host"></span>/
            </div>
            <p class="create-btnplus create-page-plus" data-counter="0">
              <?php echo __('Site Page Plus', $lang_domain); ?>
            </p>
          </div>
        </form>
        <div class="create-btnarea">
          <p class="button create-button create-prev"><?php echo __('Prev Step', $lang_domain); ?></p>
          <p class="button create-button create-next" id="create-page-submit"><?php echo __('Next Step', $lang_domain); ?></p>
        </div>
        <p class="warning warning-system_page"></p>
      </div>
    </section>
    
    <section class="create-section" id="create-section-2">
      <div class="create-section-inner">
        <h2><?php echo __( 'Create Site Type', $lang_domain ); ?></h2>
        <p class="attention"><?php echo __('What is Site Post Type', $lang_domain); ?></p>
        <form class="form create-form" id="create-type-form">
          <div class="create-type-line">
            <div class="create-type-header">
              <p class="create-type-header-title"><?php echo __('Site Type Name', $lang_domain); ?></p>
              <div class="form-input create-type-header-value"><?php echo __('Site Type Post', $lang_domain); ?></div>
              <p class="create-type-header-title"><?php echo __('Site Type Slug', $lang_domain); ?></p>
              <div class="form-input create-type-header-value">
                <input type="text" id="create-type-slug-post" name="type_slug_post" value="columns" maxlength="20" placeholder="<?php echo __('Site Type Slug', $lang_domain); ?>" />
                <p class="warning warning-type_slug_post"></p>
              </div>
            </div>
            <div class="create-type-body">
              <div class="create-type-body-header">
                <p class="form-input create-type-body-title"><?php echo __('Site Type Body Title', $lang_domain); ?></p>
                <p class="form-input create-type-body-url active"><?php echo __('Site Type Body URL', $lang_domain); ?></p>
              </div>
              <div class="create-type-body-line">
                <div class="form-input create-type-body-title">
                  <label class="checkbox-check">
                    <input type="checkbox" class="create-type-check" id="chk-type-check-post-archive" name="type_check_post_archive" />
                  </label>
                  <label class="checkbox-text" for="chk-type-check-post-archive"><?php echo __('Site Type Archive', $lang_domain); ?></label>
                  <p class="warning warning-type_check_post_archive"></p>
                </div>
                <div class="form-input create-type-body-url">
                  <span class="auto-site_http">https://</span><span class="auto-site_host"></span>/
                  <input type="text" class="create-type-body-url-input" name="type_url_post_archive" placeholder="<?php echo __('Site Type Archive Url', $lang_domain); ?>" />
                  <p class="warning warning-type_url_post_archive"></p>
                  <div class="create-type-body-controller">
                    <p class="create-type-body-button auto-type_slug_post" data-value="columns"><?php echo __('Site Type Slug', $lang_domain); ?></p>
                  </div>
                </div>
              </div>
              <div class="create-type-body-line">
                <div class="form-input create-type-body-title">
                  <label class="checkbox-check">
                    <input type="checkbox" class="create-type-check" id="chk-type-check-post-single" name="type_check_post_single" />
                  </label>
                  <label class="checkbox-text" for="chk-type-check-post-single"><?php echo __('Site Type Single', $lang_domain); ?></label>
                  <p class="warning warning-type_check_post_single"></p>
                </div>
                <div class="form-input create-type-body-url">
                  <span class="auto-site_http">https://</span><span class="auto-site_host"></span>/
                  <input type="text" class="create-type-body-url-input" name="type_url_post_single" placeholder="<?php echo __('Site Type Single Url', $lang_domain); ?>" />
                  <p class="warning warning-type_url_post_single"></p>
                  <div class="create-type-body-controller">
                    <p class="create-type-body-button auto-type_slug_post" data-value="columns"><?php echo __('Site Type Slug', $lang_domain); ?></p>
                    <p class="create-type-body-button" data-value="%Year%"><?php echo __('Site Type Year Four', $lang_domain); ?></p>
                    <p class="create-type-body-button" data-value="%year%"><?php echo __('Site Type Year Two', $lang_domain); ?></p>
                    <p class="create-type-body-button" data-value="%Month%"><?php echo __('Site Type Month Two', $lang_domain); ?></p>
                    <p class="create-type-body-button" data-value="%month%"><?php echo __('Site Type Month One', $lang_domain); ?></p>
                    <p class="create-type-body-button" data-value="%Day%"><?php echo __('Site Type Day Two', $lang_domain); ?></p>
                    <p class="create-type-body-button" data-value="%day%"><?php echo __('Site Type Day One', $lang_domain); ?></p>
                    <p class="create-type-body-button" data-value="%postid%"><?php echo __('Site Type Post Id', $lang_domain); ?></p>
                    <p class="create-type-body-button" data-value="%postname%"><?php echo __('Site Type Post Name', $lang_domain); ?></p>
                  </div>
                </div>
              </div>
              <div class="create-type-body-line">
                <div class="form-input create-type-body-title">
                  <label class="checkbox-check">
                    <input type="checkbox" class="create-type-check" id="chk-type-check-post-category" name="type_check_post_category" />
                  </label>
                  <label class="checkbox-text" for="chk-type-check-post-category"><?php echo __('Site Type Category', $lang_domain); ?></label>
                  <p class="warning warning-type_check_post_category"></p>
                </div>
                <div class="form-input create-type-body-url">
                  <span class="auto-site_http">https://</span><span class="auto-site_host"></span>/
                  <input type="text" class="create-type-body-url-input" name="type_url_post_category" placeholder="<?php echo __('Site Type Category Url', $lang_domain); ?>" />
                  <p class="warning warning-type_url_post_category"></p>
                  <div class="create-type-body-controller">
                    <p class="create-type-body-button auto-type_slug_post" data-value="columns"><?php echo __('Site Type Slug', $lang_domain); ?></p>
                    <p class="create-type-body-button" data-value="category"><?php echo __('Site Type Taxonomy Slug', $lang_domain); ?></p>
                    <p class="create-type-body-button" data-value="%slug%"><?php echo __('Site Type Term Slug', $lang_domain); ?></p>
                  </div>
                </div>
              </div>
              <div class="create-type-body-line">
                <div class="form-input create-type-body-title">
                  <label class="checkbox-check">
                    <input type="checkbox" class="create-type-check" id="chk-type-check-post-tag" name="type_check_post_tag" />
                  </label>
                  <label class="checkbox-text" for="chk-type-check-post-tag"><?php echo __('Site Type Tag', $lang_domain); ?></label>
                  <p class="warning warning-type_check_post_tag"></p>
                </div>
                <div class="form-input create-type-body-url">
                  <span class="auto-site_http">https://</span><span class="auto-site_host"></span>/
                  <input type="text" class="create-type-body-url-input" name="type_url_post_tag" placeholder="<?php echo __('Site Type Tag Url', $lang_domain); ?>" />
                  <p class="warning warning-type_url_post_tag"></p>
                  <div class="create-type-body-controller">
                    <p class="create-type-body-button auto-type_slug_post" data-value="columns"><?php echo __('Site Type Slug', $lang_domain); ?></p>
                    <p class="create-type-body-button" data-value="tag"><?php echo __('Site Type Taxonomy Slug', $lang_domain); ?></p>
                    <p class="create-type-body-button" data-value="%slug%"><?php echo __('Site Type Term Slug', $lang_domain); ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="create-btnarea">
              <p class="create-type-button create-type-taxonomy" data-target="post" data-counter="0"><?php echo __('Site Type Taxonomy Plus', $lang_domain); ?></p>
            </div>
          </div>
          <p class="create-btnplus create-type-plus" data-counter="0">
            <?php echo __('Site Type Plus', $lang_domain); ?>
          </p>
        </form>
        <div class="create-btnarea">
          <p class="button create-button create-prev"><?php echo __('Prev Step', $lang_domain); ?></p>
          <p class="button create-button create-submit final-submit" id="create-type-submit"><?php echo __('Create Site Submit', $lang_domain); ?></p>
        </div>
        <p class="warning warning-system_type"></p>
        <p class="warning warning-system_site"></p>
      </div>
    </section>
    
  </div>
</div>

<?php
get_footer();
