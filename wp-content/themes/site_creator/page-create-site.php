<?php

require_once get_template_directory() . '/inc/custom-functions/get_acf_select_options.inc.php';
require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';
require_once get_template_directory() . '/inc/custom-classes/section_counter.inc.php';

get_header();

$lang = new LanguageSupporter();

$section_counter = new SectionCounter();

$site_http_options = get_acf_select_options('site', 'site_http');

?>

<div class="create-slider" data-index="0">
  <div class="create-slider-inner">
    
    <section class="create-slider-item" id="create-section-<?php echo $section_counter->get(); ?>">
      <div class="create-section-inner">
        <h2><?php echo $lang->translate('Create Site Title'); ?></h2>
        <p class="attention"><?php echo $lang->translate('Create Site Attention'); ?></p>
        <form class="form" id="create-base-form">
          <div class="form-line">
            <p class="form-title"><?php echo $lang->translate('Site Name'); ?><span class="required">*</span></p>
            <div class="form-input">
              <input type="text" name="site_name" placeholder="<?php echo $lang->translate('Site Name'); ?>" />
              <p class="warning warning-site_name"></p>
            </div>
          </div>
          <div class="form-line">
            <p class="form-title"><?php echo $lang->translate('Site Key'); ?><span class="required">*</span></p>
            <div class="form-input">
              <input type="text" name="site_key" placeholder="<?php echo $lang->translate('Site Key'); ?>" />
              <p class="warning warning-site_key"></p>
              <p class="attention create-attention"><?php echo $lang->translate('This key will be used as the name of the theme'); ?></p>
            </div>
          </div>
          <div class="form-line">
            <p class="form-title"><?php echo $lang->translate('Site Host'); ?><span class="required">*</span></p>
            <div class="form-input create-host">
              <select name="site_http" id="sel-site-http">
                <?php foreach($site_http_options as $http_key => $http_value): ?>
                <option value="<?php echo $http_key; ?>"><?php echo $http_value; ?></option>
                <?php endforeach; ?>
              </select>
              <input type="text" name="site_host" id="txt-site-host" placeholder="<?php echo $lang->translate('Site Host'); ?>" />
              <p class="warning warning-site_host"></p>
            </div>
          </div>
        </form>
        <div class="create-btnarea">
          <p class="button create-button create-next" id="create-base-submit"><?php echo $lang->translate('Next Step'); ?></p>
        </div>
        <p class="warning warning-system_base"></p>
      </div>
    </section>
    
    <section class="create-slider-item" id="create-section-<?php echo $section_counter->get(); ?>">
      <div class="create-section-inner">
        <h2><?php echo $lang->translate( 'Create Site Page' ); ?></h2>
        <p class="attention"><?php echo $lang->translate('What is Site Page'); ?></p>
        <form class="form create-form" id="create-page-form">
          <div class="create-page-line base-line header-line">
            <p class="form-input create-page-title"><?php echo $lang->translate('Site Page Title'); ?></p>
            <p class="form-input create-page-url"><?php echo $lang->translate('Site Page URL'); ?></p>
          </div>
          <div class="create-page-line base-line" data-index="0" data-level="0">
            <div class="form-input create-page-title"><?php echo $lang->translate('Site Front Page'); ?></div>
            <div class="form-input create-page-url">
              <span class="auto-site_http">https://</span><span class="auto-site_host"></span>/
            </div>
            <p class="create-btnplus create-page-plus" data-counter="0">
              <?php echo $lang->translate('Site Page Plus'); ?>
            </p>
          </div>
        </form>
        <div class="create-btnarea">
          <p class="button create-button create-prev"><?php echo $lang->translate('Prev Step'); ?></p>
          <p class="button create-button create-next" id="create-page-submit"><?php echo $lang->translate('Next Step'); ?></p>
        </div>
        <p class="warning warning-system_page"></p>
      </div>
    </section>
    
    <section class="create-slider-item" id="create-section-<?php echo $section_counter->get(); ?>">
      <div class="create-section-inner">
        <h2><?php echo $lang->translate( 'Create Site Type' ); ?></h2>
        <p class="attention"><?php echo $lang->translate('What is Site Post Type'); ?></p>
        <form class="form create-form" id="create-type-form">
          <div class="create-type-line">
            <div class="create-type-header">
              <p class="create-type-header-title"><?php echo $lang->translate('Site Type Name'); ?></p>
              <div class="form-input create-type-header-value"><?php echo $lang->translate('Site Type Post'); ?></div>
              <p class="create-type-header-title"><?php echo $lang->translate('Site Type Slug'); ?></p>
              <div class="form-input create-type-header-value">
                <input type="text" id="create-type-slug-post" name="type_slug_post" value="columns" maxlength="20" placeholder="<?php echo $lang->translate('Site Type Slug'); ?>" />
                <p class="warning warning-type_slug_post"></p>
              </div>
            </div>
            <div class="create-type-body">
              <div class="create-type-body-header">
                <p class="form-input create-type-body-title"><?php echo $lang->translate('Site Type Body Title'); ?></p>
                <p class="form-input create-type-body-url active"><?php echo $lang->translate('Site Type Body URL'); ?></p>
              </div>
              <div class="create-type-body-line">
                <div class="form-input create-type-body-title">
                  <label class="checkbox-check">
                    <input type="checkbox" class="create-type-check" id="chk-type-check-post-archive" name="type_check_post_archive" />
                  </label>
                  <label class="checkbox-text" for="chk-type-check-post-archive"><?php echo $lang->translate('Site Type Archive'); ?></label>
                  <p class="warning warning-type_check_post_archive"></p>
                </div>
                <div class="form-input create-type-body-url">
                  <span class="auto-site_http">https://</span><span class="auto-site_host"></span>/
                  <input type="text" class="create-type-body-url-input" name="type_url_post_archive" placeholder="<?php echo $lang->translate('Site Type Archive Url'); ?>" />
                  <p class="warning warning-type_url_post_archive"></p>
                  <div class="create-type-body-controller">
                    <p class="create-type-body-button auto-type_slug_post" data-value="columns"><?php echo $lang->translate('Site Type Slug'); ?></p>
                  </div>
                </div>
              </div>
              <div class="create-type-body-line">
                <div class="form-input create-type-body-title">
                  <label class="checkbox-check">
                    <input type="checkbox" class="create-type-check" id="chk-type-check-post-single" name="type_check_post_single" />
                  </label>
                  <label class="checkbox-text" for="chk-type-check-post-single"><?php echo $lang->translate('Site Type Single'); ?></label>
                  <p class="warning warning-type_check_post_single"></p>
                </div>
                <div class="form-input create-type-body-url">
                  <span class="auto-site_http">https://</span><span class="auto-site_host"></span>/
                  <input type="text" class="create-type-body-url-input" name="type_url_post_single" placeholder="<?php echo $lang->translate('Site Type Single Url'); ?>" />
                  <p class="warning warning-type_url_post_single"></p>
                  <div class="create-type-body-controller">
                    <p class="create-type-body-button auto-type_slug_post" data-value="columns"><?php echo $lang->translate('Site Type Slug'); ?></p>
                    <p class="create-type-body-button" data-value="%Year%"><?php echo $lang->translate('Site Type Year Four'); ?></p>
                    <p class="create-type-body-button" data-value="%year%"><?php echo $lang->translate('Site Type Year Two'); ?></p>
                    <p class="create-type-body-button" data-value="%Month%"><?php echo $lang->translate('Site Type Month Two'); ?></p>
                    <p class="create-type-body-button" data-value="%month%"><?php echo $lang->translate('Site Type Month One'); ?></p>
                    <p class="create-type-body-button" data-value="%Day%"><?php echo $lang->translate('Site Type Day Two'); ?></p>
                    <p class="create-type-body-button" data-value="%day%"><?php echo $lang->translate('Site Type Day One'); ?></p>
                    <p class="create-type-body-button" data-value="%postid%"><?php echo $lang->translate('Site Type Post Id'); ?></p>
                    <p class="create-type-body-button" data-value="%postname%"><?php echo $lang->translate('Site Type Post Name'); ?></p>
                  </div>
                </div>
              </div>
              <div class="create-type-body-line">
                <div class="form-input create-type-body-title">
                  <label class="checkbox-check">
                    <input type="checkbox" class="create-type-check" id="chk-type-check-post-category" name="type_check_post_category" />
                  </label>
                  <label class="checkbox-text" for="chk-type-check-post-category"><?php echo $lang->translate('Site Type Category'); ?></label>
                  <p class="warning warning-type_check_post_category"></p>
                </div>
                <div class="form-input create-type-body-url">
                  <span class="auto-site_http">https://</span><span class="auto-site_host"></span>/
                  <input type="text" class="create-type-body-url-input" name="type_url_post_category" placeholder="<?php echo $lang->translate('Site Type Category Url'); ?>" />
                  <p class="warning warning-type_url_post_category"></p>
                  <div class="create-type-body-controller">
                    <p class="create-type-body-button auto-type_slug_post" data-value="columns"><?php echo $lang->translate('Site Type Slug'); ?></p>
                    <p class="create-type-body-button" data-value="category"><?php echo $lang->translate('Site Type Taxonomy Slug'); ?></p>
                    <p class="create-type-body-button" data-value="%slug%"><?php echo $lang->translate('Site Type Term Slug'); ?></p>
                  </div>
                </div>
              </div>
              <div class="create-type-body-line">
                <div class="form-input create-type-body-title">
                  <label class="checkbox-check">
                    <input type="checkbox" class="create-type-check" id="chk-type-check-post-tag" name="type_check_post_tag" />
                  </label>
                  <label class="checkbox-text" for="chk-type-check-post-tag"><?php echo $lang->translate('Site Type Tag'); ?></label>
                  <p class="warning warning-type_check_post_tag"></p>
                </div>
                <div class="form-input create-type-body-url">
                  <span class="auto-site_http">https://</span><span class="auto-site_host"></span>/
                  <input type="text" class="create-type-body-url-input" name="type_url_post_tag" placeholder="<?php echo $lang->translate('Site Type Tag Url'); ?>" />
                  <p class="warning warning-type_url_post_tag"></p>
                  <div class="create-type-body-controller">
                    <p class="create-type-body-button auto-type_slug_post" data-value="columns"><?php echo $lang->translate('Site Type Slug'); ?></p>
                    <p class="create-type-body-button" data-value="tag"><?php echo $lang->translate('Site Type Taxonomy Slug'); ?></p>
                    <p class="create-type-body-button" data-value="%slug%"><?php echo $lang->translate('Site Type Term Slug'); ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="create-btnarea">
              <p class="create-type-button create-type-taxonomy" data-target="post" data-counter="0"><?php echo $lang->translate('Site Type Taxonomy Plus'); ?></p>
            </div>
          </div>
          <p class="create-btnplus create-type-plus" data-counter="0">
            <?php echo $lang->translate('Site Type Plus'); ?>
          </p>
        </form>
        <div class="create-btnarea">
          <p class="button create-button create-prev"><?php echo $lang->translate('Prev Step'); ?></p>
          <p class="button create-button create-submit final-submit" id="create-type-submit"><?php echo $lang->translate('Create Site Submit'); ?></p>
        </div>
        <p class="warning warning-system_type"></p>
        <p class="warning warning-system_site"></p>
      </div>
    </section>
    
  </div>
</div>

<?php
get_footer();
